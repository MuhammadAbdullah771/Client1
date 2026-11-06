<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;

class MailService
{
    /**
     * Configure mail settings from database and reset mail manager
     */
    public static function configureMailFromSettings(): void
    {
        // .env values are always the authoritative source — DB settings only override if explicitly set
        $mailHost     = self::firstNonEmpty(Setting::get('mail_host'), env('MAIL_HOST'), config('mail.mailers.smtp.host'));
        $mailPort     = (int) self::firstNonEmpty(Setting::get('mail_port'), env('MAIL_PORT'), config('mail.mailers.smtp.port'), 587);
        $mailUsername = self::firstNonEmpty(Setting::get('mail_username'), env('MAIL_USERNAME'), config('mail.mailers.smtp.username'));
        $mailPassword = self::firstNonEmpty(Setting::get('mail_password'), env('MAIL_PASSWORD'), config('mail.mailers.smtp.password'));
        $mailFromAddress = self::firstNonEmpty(Setting::get('mail_from_address'), env('MAIL_FROM_ADDRESS'), config('mail.from.address'));
        $mailFromName    = self::firstNonEmpty(Setting::get('mail_from_name'), env('MAIL_FROM_NAME'), config('mail.from.name'), config('app.name', '9Associates'));

        if (empty($mailHost) || empty($mailUsername) || empty($mailPassword) || empty($mailFromAddress)) {
            \Log::warning('Mail configuration incomplete', [
                'host_set' => !empty($mailHost),
                'user_set' => !empty($mailUsername),
                'pass_set' => !empty($mailPassword),
                'from_set' => !empty($mailFromAddress),
            ]);
            throw new \Exception('Mail configuration is incomplete. Please verify MAIL_* in .env or Admin > Settings.');
        }

        // Gmail/Google always uses port 587 + TLS
        if (stripos((string) $mailHost, 'gmail') !== false || stripos((string) $mailHost, 'google') !== false) {
            $mailPort = 587;
        }

        // Determine scheme: port 465 always = smtps; any other port = smtp
        $scheme = ($mailPort === 465) ? 'smtps' : 'smtp';

        // Derive a clean EHLO domain from APP_URL (strip port numbers)
        $appUrl     = config('app.url', 'http://localhost');
        $localDomain = preg_replace('/:\d+$/', '', parse_url($appUrl, PHP_URL_HOST) ?? 'localhost');

        Config::set('mail.mailers.smtp', [
            'transport'    => 'smtp',
            'scheme'       => $scheme,
            'host'         => $mailHost,
            'port'         => $mailPort,
            'username'     => $mailUsername,
            'password'     => $mailPassword,
            'timeout'      => 60,
            'local_domain' => $localDomain,
        ]);

        Config::set('mail.from', ['address' => $mailFromAddress, 'name' => $mailFromName]);
        Config::set('mail.default', 'smtp');

        // Laravel 11+ uses forgetMailers(); earlier used purge()
        if (method_exists(Mail::getFacadeRoot(), 'forgetMailers')) {
            Mail::forgetMailers();
        } elseif (method_exists(Mail::getFacadeRoot(), 'purge')) {
            Mail::purge('smtp'); // @phpstan-ignore-line
        }

        \Log::info('Mail configured', [
            'host'   => $mailHost,
            'port'   => $mailPort,
            'scheme' => $scheme,
            'from'   => $mailFromAddress,
            'ehlo'   => $localDomain,
        ]);
    }

    private static function firstNonEmpty(mixed ...$candidates): mixed
    {
        foreach ($candidates as $value) {
            $value = is_string($value) ? trim($value) : $value;
            if ($value !== null && $value !== '' && $value !== false) {
                return $value;
            }
        }
        return null;
    }

    /**
     * Get mail configuration from settings
     */
    public static function getMailConfig(): array
    {
        $config = [
            'host' => Setting::get('mail_host') ?: env('MAIL_HOST', config('mail.mailers.smtp.host', 'smtp.gmail.com')),
            'port' => (int) (Setting::get('mail_port') ?: env('MAIL_PORT', config('mail.mailers.smtp.port', 587))),
            'username' => Setting::get('mail_username') ?: env('MAIL_USERNAME', ''),
            'password' => Setting::get('mail_password') ?: env('MAIL_PASSWORD', ''),
            'encryption' => Setting::get('mail_encryption') ?: env('MAIL_ENCRYPTION', 'tls'),
            'from_address' => Setting::get('mail_from_address') ?: env('MAIL_FROM_ADDRESS', config('mail.from.address', '')),
            'from_name' => Setting::get('mail_from_name') ?: env('MAIL_FROM_NAME', config('mail.from.name', config('app.name'))),
        ];

        if (stripos((string) $config['host'], 'gmail') !== false || stripos((string) $config['host'], 'google') !== false) {
            $config['port'] = 587;
            $config['encryption'] = 'tls';
        }

        return $config;
    }

    /**
     * Send email with proper Gmail headers
     */
    public static function sendMail(string $to, string $subject, string $view, array $data = []): bool
    {
        self::configureMailFromSettings();

        try {
            Mail::mailer('smtp')->send($view, $data, function ($message) use ($to, $subject) {
                $message->to($to)
                    ->subject($subject)
                    ->replyTo(config('mail.from.address'), config('mail.from.name'));
            });

            \Log::info('Email sent successfully', ['to' => $to, 'subject' => $subject]);
            return true;
        } catch (\Exception $e) {
            \Log::error('Email sending failed', [
                'to'    => $to,
                'error' => $e->getMessage(),
            ]);
            throw $e;
        }
    }

    /**
     * Test SMTP connection
     */
    public static function testConnection(): array
    {
        try {
            self::configureMailFromSettings();

            Mail::mailer('smtp')->raw('This is an SMTP test from 9Associates.', function ($message) {
                $message->to(config('mail.from.address'))
                    ->subject('SMTP Test — 9Associates');
            });

            \Log::info('SMTP connection test successful');
            return ['success' => true, 'message' => 'SMTP connection successful!'];
        } catch (\Exception $e) {
            \Log::error('SMTP connection test failed', ['error' => $e->getMessage()]);
            return ['success' => false, 'message' => 'Connection failed: '.$e->getMessage()];
        }
    }
}
