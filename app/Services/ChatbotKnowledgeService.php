<?php

namespace App\Services;

use App\Models\ContactDetail;
use App\Models\Job;
use App\Models\Service;
use App\Models\Setting;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class ChatbotKnowledgeService
{
    /** @var Collection<int, array<string, mixed>>|null */
    private ?Collection $services = null;

    /**
     * @return array{html: string, intent: string, service_id: ?int, service_title: ?string}
     */
    public function answer(string $message): array
    {
        $text = trim($message);
        if ($text === '') {
            return $this->wrap('general', 'Please type a question about our services or say <em>contact me</em> to reach our team.');
        }

        if ($this->wantsLocationOrHours($text)) {
            return $this->wrap('location', $this->buildContactInfoResponse());
        }

        if ($this->wantsContactFlow($text)) {
            $matched = $this->matchService($text);

            return [
                'html' => 'I can connect you with our team. Please share your email address to continue.',
                'intent' => 'contact',
                'service_id' => $matched['id'] ?? null,
                'service_title' => $matched['title'] ?? null,
            ];
        }

        if ($this->wantsAllServices($text)) {
            return $this->wrap('service', $this->buildAllServicesList());
        }

        if ($this->wantsCareers($text)) {
            return $this->wrap('careers', $this->buildCareersResponse());
        }

        if ($this->wantsPricing($text)) {
            return $this->wrap('pricing', 'Our pricing is tailored to each engagement. Say <em>contact me</em> and we will prepare a quote for your needs.');
        }

        $knowledge = $this->answerFromKnowledge($text);
        if ($knowledge !== null) {
            $matched = $this->matchService($text);

            return [
                'html' => $knowledge,
                'intent' => 'service',
                'service_id' => $matched['id'] ?? null,
                'service_title' => $matched['title'] ?? null,
            ];
        }

        if ($this->matchService($text)) {
            return $this->wrap('service', 'We offer VAT & corporate tax, payroll, audit & assurance, accounting, business setup, IT support, and more. Ask <em>what services do you offer</em> or name a service for details.');
        }

        return $this->wrap('general', 'Ask about any service (e.g. tax, audit, accounting, IT support) or say <em>list all services</em>. Say <em>contact me</em> when you are ready to talk to our team.');
    }

    /**
     * @return array{html: string, intent: string, service_id: ?int, service_title: ?string}
     */
    private function wrap(string $intent, string $html, ?int $serviceId = null, ?string $serviceTitle = null): array
    {
        return [
            'html' => $html,
            'intent' => $intent,
            'service_id' => $serviceId,
            'service_title' => $serviceTitle,
        ];
    }

    private function wantsContactFlow(string $text): bool
    {
        return (bool) preg_match('/\b(contact me|call me|callback|get a quote|request a quote|get started|speak to (someone|an advisor|a consultant|our team)|talk to (someone|our team)|email me|consultation|hire you|engage you|book (a )?appointment)\b/i', $text);
    }

    private function wantsPricing(string $text): bool
    {
        return (bool) preg_match('/\b(pricing|cost|quote|budget|price|estimate)\b/i', $text);
    }

    private function wantsCareers(string $text): bool
    {
        return (bool) preg_match('/\b(job|career|careers|position|hiring|apply|vacancy|vacancies|opening)\b/i', $text);
    }

    private function wantsAllServices(string $text): bool
    {
        return (bool) preg_match('/\b(all services|what services|list services|your services|services do you|what do you offer)\b/i', $text);
    }

    private function wantsLocationOrHours(string $text): bool
    {
        return (bool) preg_match('/\b(where are you|where.+located|location|address|office hours|office address|find you|visit us|reach you|contact (us|details|info)|your (phone|email|address|number)|our (phone|email|address)|phone number|telephone|email address|call you|mobile number)\b/i', $text);
    }

    private function loadServices(): Collection
    {
        if ($this->services !== null) {
            return $this->services;
        }

        $strip = fn ($v, int $limit = 1200) => Str::limit(strip_tags((string) ($v ?? '')), $limit);

        $this->services = Service::where('is_active', true)
            ->with(['activeSubServices' => fn ($q) => $q->orderBy('order')->orderBy('id')])
            ->orderBy('order')
            ->orderBy('id')
            ->get()
            ->map(function (Service $service) use ($strip) {
                $subServices = $service->activeSubServices->map(function ($sub) use ($strip) {
                    $sections = [];
                    for ($i = 1; $i <= 5; $i++) {
                        $h = $sub->{'heading_'.$i} ?? null;
                        $c = $sub->{'content_'.$i} ?? null;
                        if ($h || $c) {
                            $sections[] = ['heading' => $strip($h, 200), 'content' => $strip($c, 400)];
                        }
                    }

                    return [
                        'title' => $sub->title,
                        'description' => $strip($sub->description, 400),
                        'sections' => $sections,
                        'search_blob' => $this->normalizeText(implode(' ', [
                            $sub->title,
                            $sub->description,
                            ...array_column($sections, 'heading'),
                            ...array_column($sections, 'content'),
                        ])),
                    ];
                })->values()->all();

                $fields = [
                    $service->title,
                    $service->translated_title,
                    $service->description,
                    $service->intro_text,
                    $service->main_heading,
                    $service->content_paragraph_1,
                    $service->content_paragraph_2,
                    $service->services_list,
                    $service->section_title,
                    $service->section_content_1,
                    $service->section_content_2,
                    $service->section_content_3,
                    $service->additional_info_title,
                    $service->additional_info_content,
                    $service->contact_message,
                ];

                foreach ($subServices as $sub) {
                    $fields[] = $sub['title'];
                    $fields[] = $sub['description'];
                    $fields[] = $sub['search_blob'];
                }

                return [
                    'id' => $service->id,
                    'title' => $service->title,
                    'translated_title' => $service->translated_title,
                    'description' => $strip($service->description, 800),
                    'intro_text' => $strip($service->intro_text, 400),
                    'main_heading' => $strip($service->main_heading, 200),
                    'content_paragraph_1' => $strip($service->content_paragraph_1, 600),
                    'content_paragraph_2' => $strip($service->content_paragraph_2, 600),
                    'services_list' => $strip($service->services_list, 800),
                    'section_title' => $strip($service->section_title, 200),
                    'section_content_1' => $strip($service->section_content_1, 400),
                    'section_content_2' => $strip($service->section_content_2, 400),
                    'section_content_3' => $strip($service->section_content_3, 400),
                    'additional_info_title' => $strip($service->additional_info_title, 200),
                    'additional_info_content' => $strip($service->additional_info_content, 500),
                    'contact_message' => $strip($service->contact_message, 400),
                    'sub_services' => $subServices,
                    'search_blob' => $this->normalizeText(implode(' ', array_filter($fields))),
                ];
            });

        return $this->services;
    }

    /**
     * @return array{id: int, title: string}|null
     */
    private function matchService(string $text): ?array
    {
        $normalized = $this->normalizeText($text);
        if ($normalized === '') {
            return null;
        }

        $best = null;
        $bestScore = 0;

        $keywords = [
            'accounting' => ['account', 'bookkeep', 'ledger'],
            'tax' => ['tax', 'vat', 'zatca', 'corporate tax', 'taxation'],
            'audit' => ['audit', 'assurance'],
            'payroll' => ['payroll', 'salary', 'wages'],
            'business' => ['business setup', 'company formation', 'incorporat'],
            'it' => ['it support', 'it services', 'software', 'cyber', 'technology'],
            'financial' => ['financial', 'finance', 'treasury'],
            'policies' => ['polic', 'procedure', 'compliance'],
        ];

        foreach ($this->loadServices() as $service) {
            foreach (array_filter([$service['title'], $service['translated_title']]) as $title) {
                $titleNorm = $this->normalizeText($title);
                if ($titleNorm === '') {
                    continue;
                }

                $score = 0;
                if (str_contains($normalized, $titleNorm) || str_contains($titleNorm, $normalized)) {
                    $score = strlen($titleNorm) + 10;
                } else {
                    foreach (explode(' ', $titleNorm) as $word) {
                        if (strlen($word) > 3 && str_contains($normalized, $word)) {
                            $score += strlen($word);
                        }
                    }
                }

                foreach ($keywords as $key => $terms) {
                    if (str_contains($titleNorm, $key)) {
                        foreach ($terms as $kw) {
                            if (str_contains($normalized, $this->normalizeText($kw))) {
                                $score += strlen($kw);
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

        if ($bestScore < 3 || $best === null) {
            return null;
        }

        return [
            'id' => $best['id'],
            'title' => $best['translated_title'] ?: $best['title'],
        ];
    }

    private function answerFromKnowledge(string $text): ?string
    {
        $matched = $this->matchService($text);
        if ($matched !== null) {
            $service = $this->loadServices()->firstWhere('id', $matched['id']);

            return $service ? $this->buildServiceDetailResponse($service) : null;
        }

        $norm = $this->normalizeText($text);
        if ($norm === '') {
            return null;
        }

        $hits = [];
        foreach ($this->loadServices() as $service) {
            $words = array_filter(explode(' ', $norm), fn ($w) => strlen($w) > 3);
            $score = 0;
            foreach ($words as $word) {
                if (str_contains($service['search_blob'], $word)) {
                    $score++;
                }
            }
            if ($score >= 2) {
                $hits[] = ['service' => $service, 'score' => $score];
            }
        }

        usort($hits, fn ($a, $b) => $b['score'] <=> $a['score']);

        if (count($hits) === 1) {
            return $this->buildServiceDetailResponse($hits[0]['service']);
        }

        if (count($hits) > 1) {
            $html = 'I found several relevant areas:<ul class="list-disc pl-4 mt-2">';
            foreach (array_slice($hits, 0, 3) as $hit) {
                $title = $hit['service']['translated_title'] ?: $hit['service']['title'];
                $html .= '<li><strong>'.e($title).'</strong></li>';
            }
            $html .= '</ul><br>Ask about one of these for full details.';

            return $html;
        }

        return null;
    }

    private function buildAllServicesList(): string
    {
        $services = $this->loadServices();
        if ($services->isEmpty()) {
            return 'Please visit our Services page for full details.';
        }

        $html = '<strong>Our Services at 9Associates:</strong><ul class="list-disc pl-4 mt-2 space-y-2">';
        foreach ($services as $s) {
            $title = $s['translated_title'] ?: $s['title'];
            $brief = $s['intro_text'] ?: $s['description'] ?: '';
            $html .= '<li><strong>'.e($title).'</strong>';
            if ($brief !== '') {
                $short = Str::limit($brief, 180);
                $html .= '<br><span class="text-slate-600">'.e($short).'</span>';
            }
            $html .= '</li>';
        }
        $html .= '</ul><br>Ask about any service by name for full details, or say <em>contact me</em> to reach our team.';

        return $html;
    }

    /**
     * @param  array<string, mixed>  $service
     */
    private function buildServiceDetailResponse(array $service): string
    {
        $title = $service['translated_title'] ?: $service['title'];
        $html = '<strong>'.e($title).'</strong><br><br>';

        if (! empty($service['main_heading'])) {
            $html .= '<em>'.e($service['main_heading']).'</em><br><br>';
        }

        $summary = $service['intro_text'] ?: $service['description'];
        if ($summary) {
            $html .= e($summary).'<br><br>';
        }
        if (! empty($service['content_paragraph_1'])) {
            $html .= e($service['content_paragraph_1']).'<br><br>';
        }
        if (! empty($service['content_paragraph_2'])) {
            $html .= e($service['content_paragraph_2']).'<br><br>';
        }
        if (! empty($service['services_list'])) {
            $html .= '<strong>What we cover:</strong><br>'.nl2br(e($service['services_list'])).'<br><br>';
        }
        if (! empty($service['section_title'])) {
            $html .= '<strong>'.e($service['section_title']).'</strong><br>';
            foreach (['section_content_1', 'section_content_2', 'section_content_3'] as $key) {
                if (! empty($service[$key])) {
                    $html .= e($service[$key]).'<br>';
                }
            }
            $html .= '<br>';
        }
        if (! empty($service['additional_info_title']) && ! empty($service['additional_info_content'])) {
            $html .= '<strong>'.e($service['additional_info_title']).'</strong><br>'.e($service['additional_info_content']).'<br><br>';
        }
        if (! empty($service['contact_message'])) {
            $html .= e($service['contact_message']).'<br><br>';
        }

        if (! empty($service['sub_services'])) {
            $html .= '<strong>Sub-services:</strong>';
            foreach ($service['sub_services'] as $sub) {
                $html .= '<br><br>• <strong>'.e($sub['title']).'</strong>';
                if (! empty($sub['description'])) {
                    $html .= '<br>'.e($sub['description']);
                }
                foreach ($sub['sections'] ?? [] as $sec) {
                    if (! empty($sec['heading'])) {
                        $html .= '<br><strong>'.e($sec['heading']).'</strong>';
                    }
                    if (! empty($sec['content'])) {
                        $html .= ': '.e($sec['content']);
                    }
                }
            }
            $html .= '<br><br>';
        }

        $html .= '<span class="text-slate-500 text-xs">Say <em>contact me</em> or <em>get a quote</em> and I will connect you with our team.</span>';

        return $html;
    }

    private function buildContactInfoResponse(): string
    {
        $detail = ContactDetail::getContactDetails();
        $lines = ['<strong>How to reach 9Associates:</strong><br><br>'];

        $email = $detail->email ?: Setting::get('email_address_1');
        $phone = $detail->phone ?: Setting::get('phone_number_1');
        $phone2 = $detail->phone_2 ?: Setting::get('phone_number_2');
        $address = $detail->address ?: Setting::get('office_address');
        $hours = $detail->office_hours;

        if ($email) {
            $lines[] = '<strong>Email:</strong> '.e($email).'<br>';
        }
        if ($phone) {
            $lines[] = '<strong>Phone:</strong> '.e($phone).'<br>';
        }
        if ($phone2) {
            $lines[] = '<strong>Phone 2:</strong> '.e($phone2).'<br>';
        }
        if ($address) {
            $lines[] = '<strong>Address:</strong> '.e($address).'<br>';
        }
        if ($hours) {
            $lines[] = '<strong>Office hours:</strong> '.e($hours).'<br>';
        }

        if (count($lines) === 1) {
            return 'Visit our <a href="'.e(route('contact')).'" class="text-primary underline">Contact page</a> for full details, or say <em>contact me</em> and I will connect you with our team.';
        }

        $lines[] = '<br>Say <em>contact me</em> to leave your details and we will call you back.';

        return implode('', $lines);
    }

    private function buildCareersResponse(): string
    {
        $jobs = Job::where('is_active', true)->orderByDesc('created_at')->get();

        if ($jobs->isEmpty()) {
            return 'We are not listing open roles right now. Visit our <a href="'.e(route('careers')).'" class="text-primary underline">Careers page</a> or say <em>contact me</em> to reach our HR team.';
        }

        $html = '<strong>Current openings:</strong><ul class="list-disc pl-4 mt-2 space-y-2">';
        foreach ($jobs as $job) {
            $html .= '<li><strong>'.e($job->title).'</strong>';
            $meta = array_filter([$job->department, $job->location, $job->employment_type]);
            if ($meta) {
                $html .= '<br><span class="text-slate-600">'.e(implode(' · ', $meta)).'</span>';
            }
            if ($job->description) {
                $html .= '<br>'.e(Str::limit(strip_tags($job->description), 200));
            }
            $html .= '</li>';
        }
        $html .= '</ul><br>Apply on our <a href="'.e(route('careers')).'" class="text-primary underline">Careers page</a>.';

        return $html;
    }

    private function normalizeText(string $text): string
    {
        $text = strtolower($text);
        $text = preg_replace('/[^a-z0-9\s]/', ' ', $text) ?? $text;

        return trim(preg_replace('/\s+/', ' ', $text) ?? $text);
    }
}
