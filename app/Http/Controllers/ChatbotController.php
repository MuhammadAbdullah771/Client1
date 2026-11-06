<?php

namespace App\Http\Controllers;

use App\Models\ContactDetail;
use App\Models\Job;
use App\Models\Service;
use App\Services\GeminiService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ChatbotController extends Controller
{
    public function answer(Request $request): JsonResponse
    {
        $message = trim((string) $request->input('message', ''));
        if ($message === '') {
            return response()->json([
                'intent' => 'general',
                'html' => 'Please type a question — for example, <em>What services do you offer?</em> or <em>Tell me about VAT compliance</em>.',
            ]);
        }

        $normalized = $this->normalize($message);
        $services = Service::where('is_active', true)
            ->orderBy('order')
            ->orderBy('id')
            ->get();

        if ($this->matchesAny($normalized, ['hello', 'hi', 'hey', 'good morning', 'good afternoon', 'salam', 'assalam'])) {
            return response()->json([
                'intent' => 'greeting',
                'html' => 'Hello! I\'m <strong>9A Assistant</strong>. I can explain our services, VAT &amp; tax support, business setup, audit, payroll, and how to reach our advisors.',
            ]);
        }

        if ($this->matchesAny($normalized, ['thank', 'thanks', 'appreciate'])) {
            return response()->json([
                'intent' => 'general',
                'html' => 'You\'re welcome. If you need anything else, ask here or say <em>contact me</em> to speak with our team.',
            ]);
        }

        if ($this->matchesAny($normalized, ['contact form', 'contact page form', 'how do i contact', 'how to contact', 'fill the form', 'form fields', 'submit a form', 'send a message'])) {
            return response()->json([
                'intent' => 'contact',
                'html' => $this->buildContactFormHtml(),
            ]);
        }

        if ($this->matchesAny($normalized, ['contact', 'call me', 'email me', 'phone', 'reach you', 'get in touch', 'speak to', 'talk to', 'appointment', 'consultation', 'quote', 'get a quote', 'pricing', 'cost', 'price'])) {
            return response()->json([
                'intent' => 'contact',
                'html' => $this->buildContactHtml(),
            ]);
        }

        if ($this->matchesAny($normalized, ['about you', 'about 9associates', 'about the company', 'who are you', 'who is 9associates', 'your company', 'tell me about yourself'])) {
            return response()->json([
                'intent' => 'general',
                'html' => '<strong>About 9Associates</strong><br>We are a professional advisory firm serving Saudi Arabia (KSA), the UAE and the wider GCC. Our specialists cover <strong>VAT &amp; corporate tax (ZATCA compliance)</strong>, <strong>accounting &amp; bookkeeping</strong>, <strong>audit &amp; assurance</strong>, <strong>payroll</strong>, <strong>business setup &amp; company formation</strong> and <strong>IT support</strong>.<br><br>Learn more on our About page, or ask me about any service by name.',
            ]);
        }

        if ($this->matchesAny($normalized, ['all services', 'what services', 'list services', 'your services', 'what do you offer', 'services do you'])) {
            return response()->json([
                'intent' => 'service',
                'html' => $this->buildServicesListHtml($services),
            ]);
        }

        if ($this->matchesAny($normalized, ['where are you', 'location', 'address', 'office', 'based'])) {
            $contact = ContactDetail::getContactDetails();
            $address = $contact->address ?: 'Visit our Contact page for office locations across KSA &amp; GCC.';
            return response()->json([
                'intent' => 'general',
                'html' => '<strong>Our offices</strong><br>' . e($address),
            ]);
        }

        if ($this->matchesAny($normalized, ['job', 'career', 'careers', 'hiring', 'vacancy', 'vacancies', 'open position', 'open role', 'work with you', 'join your team', 'recruitment'])
            && ! $this->matchesAny($normalized, ['how to apply', 'how do i apply', 'application form', 'apply for'])) {
            return response()->json([
                'intent' => 'careers',
                'html' => $this->buildJobsListHtml(),
            ]);
        }

        if ($this->matchesAny($normalized, ['office hours', 'opening hours', 'working hours', 'are you open', 'when are you open', 'availability', '24 7', 'when are you'])) {
            $contact = ContactDetail::getContactDetails();
            $hours = $contact->office_hours ?: 'Our advisors are available during business hours and for urgent client matters.';
            return response()->json([
                'intent' => 'general',
                'html' => '<strong>Availability</strong><br>' . e($hours),
            ]);
        }

        if ($this->matchesAny($normalized, ['how to apply', 'how do i apply', 'application form', 'apply for a job', 'submit my cv', 'submit resume', 'upload resume', 'upload cv', 'send my cv', 'job form'])) {
            return response()->json([
                'intent' => 'careers',
                'html' => $this->buildJobApplicationHtml(),
            ]);
        }

        $matched = $this->matchService($normalized, $services);
        if ($matched) {
            return response()->json([
                'intent' => 'service',
                'service_id' => $matched->id,
                'service_title' => $matched->translated_title ?? $matched->title,
                'html' => $this->buildServiceHtml($matched),
            ]);
        }

        $hits = $this->searchServices($normalized, $services);
        if (count($hits) === 1) {
            $service = $hits[0];
            return response()->json([
                'intent' => 'service',
                'service_id' => $service->id,
                'service_title' => $service->translated_title ?? $service->title,
                'html' => $this->buildServiceHtml($service),
            ]);
        }

        if (count($hits) > 1) {
            $html = 'I found a few areas that may help:<ul class="list-disc pl-4 mt-2 space-y-1">';
            foreach (array_slice($hits, 0, 4) as $service) {
                $html .= '<li><strong>' . e($service->translated_title ?? $service->title) . '</strong></li>';
            }
            $html .= '</ul><br>Ask about one of these by name for full details.';
            return response()->json(['intent' => 'service', 'html' => $html]);
        }

        // Optional Gemini fallback when local knowledge has no match.
        if (GeminiService::enabled()) {
            $gemini = GeminiService::ask($message, $this->buildGeminiContext($services));
            if ($gemini) {
                return response()->json([
                    'intent' => 'general',
                    'html' => nl2br(e($gemini)).'<br><br><span class="text-slate-500 text-xs">Need a human? Say <em>contact me</em>. For roles, ask <em>what jobs are open</em>.</span>',
                    'source' => 'gemini',
                ]);
            }
        }

        return response()->json([
            'intent' => 'general',
            'html' => 'I\'m not sure I caught that. Try asking about <em>VAT &amp; corporate tax</em>, <em>audit</em>, <em>accounting</em>, <em>business setup</em>, or say <em>list all services</em>. Say <em>contact me</em> to reach an advisor, or <em>what jobs are open</em> for careers.',
        ]);
    }

    private function buildGeminiContext($services): string
    {
        $lines = ['Company: 9Associates — tax, accounting, audit, payroll, business setup, IT support (KSA / UAE / GCC).'];

        $contact = ContactDetail::getContactDetails();
        foreach (['email', 'phone', 'mobile', 'address', 'office_hours'] as $field) {
            if (! empty($contact->{$field})) {
                $lines[] = ucfirst($field).': '.$contact->{$field};
            }
        }

        $lines[] = 'Services:';
        foreach ($services as $service) {
            $title = $service->translated_title ?? $service->title;
            $brief = Str::limit(strip_tags((string) ($service->intro_text ?: $service->description)), 120);
            $lines[] = '- '.$title.($brief ? ': '.$brief : '');
        }

        $jobs = Job::where('is_active', true)->orderByDesc('id')->limit(12)->get();
        $lines[] = 'Open jobs:';
        if ($jobs->isEmpty()) {
            $lines[] = '- None advertised right now (speculative applications welcome via contact).';
        } else {
            foreach ($jobs as $job) {
                $lines[] = '- '.$job->title.' | '.($job->department ?: 'General').' | '.($job->location ?: 'Remote').' | '.($job->employment_type ?: '');
            }
        }

        $lines[] = 'Contact form fields: reason/service, first name, last name, email, phone, message, privacy consent.';
        $lines[] = 'Job application fields: job, first name, last name, email, phone, cover letter, CV (PDF/Word), privacy consent.';

        return implode("\n", $lines);
    }

    private function normalize(string $text): string
    {
        // Lowercase FIRST, otherwise uppercase input (e.g. "VAT") is stripped by the character filter.
        return trim(preg_replace('/\s+/', ' ', preg_replace('/[^a-z0-9\s]/', ' ', strtolower($text))) ?? '');
    }

    private function matchesAny(string $normalized, array $phrases): bool
    {
        foreach ($phrases as $phrase) {
            if (str_contains($normalized, $this->normalize($phrase))) {
                return true;
            }
        }
        return false;
    }

    private function matchService(string $normalized, $services)
    {
        $best = null;
        $bestScore = 0;

        foreach ($services as $service) {
            foreach ([$service->title, $service->translated_title ?? ''] as $title) {
                if (!$title) {
                    continue;
                }
                $titleNorm = $this->normalize($title);
                if ($titleNorm === '') {
                    continue;
                }

                $score = 0;
                if (str_contains($normalized, $titleNorm) || str_contains($titleNorm, $normalized)) {
                    $score = strlen($titleNorm) + 12;
                } else {
                    foreach (explode(' ', $titleNorm) as $word) {
                        if (strlen($word) > 3 && str_contains($normalized, $word)) {
                            $score += strlen($word);
                        }
                    }
                }

                $aliases = [
                    'vat' => ['vat', 'zatca', 'value added tax', 'corporate tax', 'tax return'],
                    'tax' => ['tax', 'taxation', 'zatca', 'filing', 'vat', 'value added tax', 'corporate tax'],
                    'audit' => ['audit', 'assurance', 'review engagement'],
                    'accounting' => ['accounting', 'bookkeeping', 'book keep', 'ledger'],
                    'payroll' => ['payroll', 'salary', 'wages', 'wps'],
                    'business' => ['business setup', 'company formation', 'incorporation', 'license'],
                    'it' => ['it support', 'technology', 'software', 'cyber', 'digital'],
                ];

                foreach ($aliases as $key => $words) {
                    if (str_contains($titleNorm, $key)) {
                        foreach ($words as $word) {
                            if (str_contains($normalized, $this->normalize($word))) {
                                $score += strlen($word);
                            }
                        }
                    }
                }

                if ($score > $bestScore) {
                    $bestScore = $score;
                    $best = $service;
                }
            }
        }

        return $bestScore >= 4 ? $best : null;
    }

    private function searchServices(string $normalized, $services): array
    {
        $hits = [];
        foreach ($services as $service) {
            $blob = $this->normalize(implode(' ', array_filter([
                $service->title,
                $service->translated_title,
                $service->description,
                $service->intro_text,
                $service->services_list,
                $service->main_heading,
            ])));

            $score = 0;
            foreach (explode(' ', $normalized) as $word) {
                if (strlen($word) > 3 && str_contains($blob, $word)) {
                    $score++;
                }
            }
            if ($score >= 2) {
                $hits[] = $service;
            }
        }

        return $hits;
    }

    private function buildContactHtml(): string
    {
        $contact = ContactDetail::getContactDetails();

        $html = 'I can connect you with our team right here — just share your <strong>email</strong> in chat and an advisor will follow up promptly.';

        $lines = [];
        if ($contact->phone) {
            $lines[] = 'Phone: ' . e($contact->phone);
        }
        if ($contact->phone_2) {
            $lines[] = 'Phone 2: ' . e($contact->phone_2);
        }
        if ($contact->mobile) {
            $lines[] = 'Mobile / WhatsApp: ' . e($contact->mobile);
        }
        if ($contact->email) {
            $lines[] = 'Email: ' . e($contact->email);
        }
        if ($contact->address) {
            $lines[] = 'Address: ' . e($contact->address);
        }
        if ($contact->office_hours) {
            $lines[] = 'Hours: ' . e($contact->office_hours);
        }
        if ($contact->website) {
            $lines[] = 'Website: ' . e($contact->website);
        }

        if ($lines) {
            $html .= '<br><br><strong>Contact details:</strong><ul class="list-disc pl-4 mt-2 space-y-1">';
            foreach ($lines as $line) {
                $html .= '<li>' . $line . '</li>';
            }
            $html .= '</ul>';
        }

        $html .= '<br>You can also use the <strong>contact form</strong> on our Contact page — ask me <em>how the contact form works</em> for a walkthrough.';

        return $html;
    }

    private function buildContactFormHtml(): string
    {
        return '<strong>Contacting 9Associates — 3 easy ways:</strong>'
            . '<ul class="list-disc pl-4 mt-2 space-y-2">'
            . '<li><strong>Right here in chat</strong> — say <em>contact me</em>, then share your email and phone. Your request goes straight to our advisors.</li>'
            . '<li><strong>Contact form</strong> — on the Contact page (or the &quot;Get Started&quot; button). It asks for: reason for contact (choose a service), first &amp; last name, email, phone, an optional message, and privacy consent. We respond within one business day.</li>'
            . '<li><strong>Direct</strong> — phone or email from our contact details. Ask me for <em>contact details</em> to see them.</li>'
            . '</ul>';
    }

    private function buildJobsListHtml(): string
    {
        $jobs = Job::where('is_active', true)->orderBy('id', 'desc')->get();

        if ($jobs->isEmpty()) {
            return '<strong>Careers at 9Associates</strong><br>We have no advertised openings right now, but we\'re always interested in strong talent in tax, audit, accounting and IT. Say <em>contact me</em> to send a speculative application to our HR team, or check the Careers page later.';
        }

        $html = '<strong>Current openings at 9Associates:</strong><ul class="list-disc pl-4 mt-2 space-y-2">';
        foreach ($jobs as $job) {
            $html .= '<li><strong>' . e($job->title) . '</strong>';
            $meta = array_filter([
                $job->department,
                $job->location,
                $job->employment_type,
            ]);
            if ($meta) {
                $html .= '<br><span class="text-slate-600">' . e(implode(' · ', $meta)) . '</span>';
            }
            if ($job->description) {
                $html .= '<br><span class="text-slate-600">' . e(Str::limit(strip_tags((string) $job->description), 140)) . '</span>';
            }
            $html .= '</li>';
        }
        $html .= '</ul><br>Ask me <em>how to apply</em> for a step-by-step guide, or visit the Careers page to apply directly.';

        return $html;
    }

    private function buildJobApplicationHtml(): string
    {
        return '<strong>How to apply for a job at 9Associates:</strong>'
            . '<ol class="list-decimal pl-4 mt-2 space-y-1">'
            . '<li>Open the <strong>Careers</strong> page and pick a role (ask me <em>what jobs are open</em> to see the list).</li>'
            . '<li>Click <strong>Apply</strong> — the application form opens.</li>'
            . '<li>Fill in: the position, your <strong>first &amp; last name</strong>, <strong>email</strong>, <strong>phone</strong>, and an optional <strong>cover letter</strong>.</li>'
            . '<li>Upload your <strong>CV / resume</strong> (PDF or Word document).</li>'
            . '<li>Accept the privacy consent and submit — our HR team reviews every application.</li>'
            . '</ol>'
            . '<br>Prefer to talk first? Say <em>contact me</em> and HR will reach out to you.';
    }

    private function buildServicesListHtml($services): string
    {
        if ($services->isEmpty()) {
            return 'Please visit our Services page for the full list.';
        }

        $html = '<strong>9Associates services:</strong><ul class="list-disc pl-4 mt-2 space-y-2">';
        foreach ($services as $service) {
            $title = $service->translated_title ?? $service->title;
            $brief = Str::limit(strip_tags((string) ($service->intro_text ?: $service->description)), 160);
            $html .= '<li><strong>' . e($title) . '</strong>';
            if ($brief) {
                $html .= '<br><span class="text-slate-600">' . e($brief) . '</span>';
            }
            $html .= '</li>';
        }
        $html .= '</ul><br>Ask about any service by name, or say <em>contact me</em> for a tailored consultation.';

        return $html;
    }

    private function buildServiceHtml(Service $service): string
    {
        $title = $service->translated_title ?? $service->title;
        $html = '<strong>' . e($title) . '</strong><br><br>';

        foreach (['main_heading', 'intro_text', 'description', 'content_paragraph_1', 'content_paragraph_2'] as $field) {
            $value = $service->{$field} ?? null;
            if ($value) {
                $html .= e(Str::limit(strip_tags((string) $value), 600)) . '<br><br>';
            }
        }

        if ($service->services_list) {
            $html .= '<strong>Includes:</strong><br>' . nl2br(e(Str::limit(strip_tags((string) $service->services_list), 500))) . '<br><br>';
        }

        if ($service->contact_message) {
            $html .= e(Str::limit(strip_tags((string) $service->contact_message), 300)) . '<br><br>';
        }

        $html .= '<span class="text-slate-500 text-xs">Need a quote? Say <em>contact me</em> and we\'ll connect you with a specialist.</span>';

        return $html;
    }
}
