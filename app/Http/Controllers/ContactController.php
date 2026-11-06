<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Setting;
use App\Services\MailService;
use App\Support\ContactMailConfig;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function index()
    {
        return view('contact', [
            'officeAddress' => Setting::get('office_address'),
            'phoneNumber1' => Setting::get('phone_number_1'),
            'phoneNumber2' => Setting::get('phone_number_2'),
            'emailAddress1' => Setting::get('email_address_1'),
            'emailAddress2' => Setting::get('email_address_2'),
        ]);
    }

    public function submitForm(Request $request)
    {
        ContactMailConfig::ensureDefaultSettings();

        $validated = $request->validate([
            'help_with' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:50',
            'additional_info' => 'nullable|string|max:2000',
            'file' => 'nullable|file|max:5120|mimes:pdf,doc,docx,txt,jpg,jpeg,png',
            'privacy_consent' => 'required|accepted',
            'service_type' => 'nullable|string|max:255',
            'sub_service' => 'nullable|string|max:255',
        ]);

        $helpWith = $validated['help_with'];
        $serviceLabel = $request->input('service_type') ?: 'N/A';
        $subService = $request->input('sub_service') ?: 'N/A';

        $emailToUse = ContactMailConfig::resolveRecipient($helpWith, $serviceLabel);

        Log::info('Contact form: resolved recipient', [
            'email_to_use' => $emailToUse,
            'help_with' => $helpWith,
            'service_label' => $serviceLabel,
            'sub_service' => $subService,
        ]);

        Contact::create([
            'name' => $validated['first_name'].' '.$validated['last_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'subject' => 'Website Contact Form',
            'message' => $validated['additional_info'] ?? '',
        ]);

        $messageBody =
            "New Contact Form Submission\n\n".
            "Name: {$validated['first_name']} {$validated['last_name']}\n".
            "Email: {$validated['email']}\n".
            "Phone: {$validated['phone']}\n".
            "Help With (raw value): {$helpWith}\n".
            "Selected Service (label): {$serviceLabel}\n".
            "Selected Sub-service (raw): {$subService}\n\n".
            "Additional Information:\n".
            ($validated['additional_info'] ?? 'N/A')."\n\n".
            'IP Address: '.$request->ip()."\n".
            'Submitted At: '.now()->toDateTimeString();

        try {
            MailService::configureMailFromSettings();

            $fromAddress = ContactMailConfig::firstValidEmail([
                config('mail.from.address'),
                env('MAIL_FROM_ADDRESS'),
            ]) ?? $emailToUse;

            $fromName = config('mail.from.name', '9Associates');

            Mail::mailer('smtp')->raw($messageBody, function ($message) use ($emailToUse, $validated, $request, $fromAddress, $fromName) {
                $message
                    ->from($fromAddress, $fromName)
                    ->to($emailToUse)
                    ->replyTo($validated['email'], $validated['first_name'].' '.$validated['last_name'])
                    ->subject('New Contact Form Message - 9Associates');

                if ($request->hasFile('file') && $request->file('file')->isValid()) {
                    $file = $request->file('file');
                    $message->attach(
                        $file->getRealPath(),
                        [
                            'as' => $file->getClientOriginalName(),
                            'mime' => $file->getMimeType() ?: $file->getClientMimeType(),
                        ]
                    );
                }
            });

            Log::info('Contact form: Mail sent', ['to' => $emailToUse]);
        } catch (\Exception $e) {
            Log::error('Mail Sending Failed: '.$e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Your message was saved, but the email notification could not be delivered. Please try again later.',
            ], 502);
        }

        return response()->json([
            'success' => true,
            'message' => 'Message sent successfully!',
            'sent_to' => $emailToUse,
        ]);
    }
}
