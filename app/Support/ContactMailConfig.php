<?php

namespace App\Support;

use App\Models\Service;
use App\Models\Setting;

class ContactMailConfig
{
    public static function firstValidEmail(array $candidates): ?string
    {
        foreach ($candidates as $email) {
            $email = trim((string) $email);
            if ($email !== '' && filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return $email;
            }
        }

        return null;
    }

    public static function settingEmail(string $key): ?string
    {
        $value = Setting::get($key);

        return self::firstValidEmail([$value]);
    }

    public static function defaultRecipientCandidates(): array
    {
        return [
            Setting::get('contact_form_email'),
            Setting::get('it_support_email'),
            Setting::get('email_address_1'),
            Setting::get('email_address_2'),
            Setting::get('job_notification_email'),
            config('mail.from.address'),
            env('MAIL_FROM_ADDRESS'),
        ];
    }

    public static function resolveRecipient(string $helpWith, string $serviceLabel): string
    {
        // Career/job submissions (e.g. from the AI assistant) go to the same
        // inbox as job application forms.
        if (self::isCareerSubmission($helpWith, $serviceLabel)) {
            $jobEmail = self::firstValidEmail([
                Setting::get('job_notification_email'),
                ...self::defaultRecipientCandidates(),
            ]);

            if ($jobEmail) {
                return $jobEmail;
            }
        }

        $service = self::findServiceForSubmission($helpWith, $serviceLabel);

        if ($service && ($email = self::firstValidEmail([$service->contact_email]))) {
            return $email;
        }

        $labelForRouting = $service?->title ?: $serviceLabel;

        if (self::isItService($service, $labelForRouting, $helpWith)) {
            $itEmail = self::firstValidEmail([
                Setting::get('it_support_email'),
                ...self::defaultRecipientCandidates(),
            ]);

            if ($itEmail) {
                return $itEmail;
            }
        }

        $general = self::firstValidEmail(self::defaultRecipientCandidates());

        if ($general) {
            return $general;
        }

        return 'contact@9associates.com';
    }

    public static function isCareerSubmission(string $helpWith, string $serviceLabel): bool
    {
        $helpWith = strtolower(trim($helpWith));
        $label = strtolower(trim($serviceLabel));

        return $helpWith === 'careers'
            || str_starts_with($helpWith, 'job_')
            || str_contains($label, 'career interest')
            || str_contains($label, 'job application');
    }

    public static function isItService(?Service $service, string $serviceLabel, string $helpWith): bool
    {
        if ($service) {
            $title = strtolower($service->title ?? '');
            if (str_contains($title, 'it support') || str_contains($title, 'it services')) {
                return true;
            }
        }

        $label = strtolower(trim($serviceLabel));
        if (str_contains($label, 'it support') || str_contains($label, 'it services')) {
            return true;
        }

        if (preg_match('/^service_\d+$/', $helpWith) && $service) {
            $title = strtolower($service->title ?? '');
            return str_contains($title, 'it');
        }

        return false;
    }

    public static function findServiceForSubmission(string $helpWith, string $serviceLabel): ?Service
    {
        if (preg_match('/^service_(\d+)$/', $helpWith, $matches)) {
            $byId = Service::where('is_active', true)->find((int) $matches[1]);
            if ($byId) {
                return $byId;
            }
        }

        $candidates = array_filter([
            $serviceLabel,
            $helpWith,
        ], fn ($value) => is_string($value) && trim($value) !== '' && ! in_array(trim($value), ['N/A', 'General Chatbot Inquiry', 'Service Inquiry', 'General Inquiry'], true));

        $services = Service::where('is_active', true)->orderBy('order')->get();

        foreach ($candidates as $candidate) {
            $needle = strtolower(trim($candidate));

            foreach ($services as $service) {
                $titles = array_filter([
                    strtolower($service->title),
                    strtolower($service->translated_title ?? ''),
                ]);

                foreach ($titles as $title) {
                    if ($title === '' || $title === 'n/a') {
                        continue;
                    }

                    if (str_contains($needle, $title) || str_contains($title, $needle)) {
                        return $service;
                    }
                }
            }
        }

        return null;
    }

    /**
     * Ensure admin email settings exist (from .env when DB is empty).
     */
    public static function ensureDefaultSettings(): void
    {
        $defaults = [
            'contact_form_email' => env('CONTACT_FORM_EMAIL', config('mail.from.address', 'contact@9associates.com')),
            'it_support_email' => env('IT_SUPPORT_EMAIL', env('CONTACT_FORM_EMAIL', config('mail.from.address', 'contact@9associates.com'))),
            'job_notification_email' => env('JOB_NOTIFICATION_EMAIL', config('mail.from.address', 'contact@9associates.com')),
        ];

        foreach ($defaults as $key => $value) {
            $existing = trim((string) Setting::get($key, ''));
            if ($existing === '' && ($email = self::firstValidEmail([$value]))) {
                Setting::set($key, $email);
            }
        }
    }
}
