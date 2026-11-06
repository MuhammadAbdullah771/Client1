<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Service;
use App\Models\Setting;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        // Get all active services including IT Services
        $services = Service::where('is_active', true)
            ->orderBy('order')
            ->orderBy('id')
            ->get();
        return view('services', compact('services'));
    }

    public function show($id)
    {
        $service = Service::with(['portfolioItems', 'activeSubServices'])->findOrFail($id);
        $contactEmail = $service->contact_email;

        return view('service-detail', compact('service', 'contactEmail'));
    }

    public function contact(Request $request, $id)
    {
        $service = Service::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'nullable|string',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string',
        ], [
            'name.required' => 'Please enter your full name.',
            'email.required' => 'Please enter your email address.',
            'email.email' => 'Please enter a valid email address.',
            'message.required' => 'Please enter your message.',
        ]);

        // Add service information to the contact data
        $validated['subject'] = $validated['subject'] ?? 'Service Inquiry: ' . $service->title;
        
        // Save to database
        Contact::create($validated);

        // Get service-specific email or fallback to default
        $serviceEmail = $service->contact_email;
        $adminEmail = Setting::get('job_notification_email', '');
        $emailToUse = !empty($serviceEmail) ? $serviceEmail : $adminEmail;
        
        if (empty($emailToUse) || !filter_var($emailToUse, FILTER_VALIDATE_EMAIL)) {
            \Log::error('Service contact email not configured or invalid for service ID: ' . $id);
            
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Email address not configured. Please contact administrator.'
                ], 500);
            }
            
            return back()->with('error', 'Email address not configured. Please contact administrator.');
        }

        // Return JSON response for AJAX requests
        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Message submitted successfully!',
                'service_email' => $serviceEmail,
                'admin_email' => $adminEmail
            ]);
        }

        // Fallback for non-AJAX requests
        return back()->with('success', 'Thank you for contacting us! We will get back to you soon.');
    }

    public function getSubServices($id)
    {
        $service = Service::with(['activeSubServices' => function($query) {
            $query->orderBy('order')->orderBy('id');
        }])->findOrFail($id);

        return response()->json([
            'success' => true,
            'sub_services' => $service->activeSubServices->map(function($subService) {
                return [
                    'id' => $subService->id,
                    'title' => $subService->title,
                ];
            })
        ]);
    }
}

