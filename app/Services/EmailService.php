<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Mail;

class EmailService
{
    /**
     * Send email with Gmail-optimized settings
     */
    public static function send($mailable)
    {
        // Ensure mail is configured before sending
        MailService::configureMailFromSettings();

        try {
            return Mail::send($mailable);
        } catch (\Exception $e) {
            \Log::error('Email send failed', [
                'error' => $e->getMessage(),
                'mailable' => get_class($mailable),
            ]);
            throw $e;
        }
    }

    /**
     * Get email headers for Gmail deliverability
     */
    public static function getGmailOptimizedHeaders()
    {
        return [
            'X-Mailer' => 'Laravel/Mailable',
            'X-Priority' => '3',
            'X-MSMail-Priority' => 'Normal',
            'Importance' => 'Normal',
            'List-Unsubscribe' => '<mailto:' . config('mail.from.address') . '?subject=unsubscribe>',
        ];
    }

    /**
     * Get service-specific email template
     */
    public static function getServiceTemplate($serviceType)
    {
        $templates = [
            'it-services' => 'emails.services.it-services',
            'consulting' => 'emails.services.consulting',
            'recruitment' => 'emails.services.recruitment',
            'contact' => 'emails.services.contact',
            'job-application' => 'emails.services.job-application',
        ];

        return $templates[$serviceType] ?? 'emails.services.contact';
    }

    /**
     * Send service-specific notification email
     */
    public static function sendServiceNotification($serviceType, $data, $recipientEmail)
    {
        MailService::configureMailFromSettings();

        $template = self::getServiceTemplate($serviceType);
        $subject = $data['subject'] ?? 'New Service Inquiry';

        try {
            Mail::send($template, $data, function ($message) use ($recipientEmail, $subject) {
                $message->to($recipientEmail)
                    ->subject($subject)
                    ->replyTo(config('mail.from.address'))
                    ->priority(1) // High priority for Gmail
                    ->getHeaders()
                    ->addTextHeader('X-Priority', '1')
                    ->addTextHeader('X-MSMail-Priority', 'High')
                    ->addTextHeader('Importance', 'high');
            });

            \Log::info('Service notification sent', [
                'service' => $serviceType,
                'recipient' => $recipientEmail,
            ]);

            return true;
        } catch (\Exception $e) {
            \Log::error('Failed to send service notification', [
                'service' => $serviceType,
                'recipient' => $recipientEmail,
                'error' => $e->getMessage(),
            ]);

            return false;
        }
    }

    /**
     * Verify SMTP connection to Gmail
     */
    public static function verifySmtpConnection()
    {
        MailService::configureMailFromSettings();

        try {
            $config = MailService::getMailConfig();

            // Create Swift connection
            $transport = new \Swift_SmtpTransport(
                $config['host'],
                $config['port'],
                $config['encryption']
            );
            $transport->setUsername($config['username']);
            $transport->setPassword($config['password']);

            $mailer = new \Swift_Mailer($transport);
            $transport->start();

            \Log::info('SMTP connection verified successfully', [
                'host' => $config['host'],
                'port' => $config['port'],
            ]);

            return true;
        } catch (\Exception $e) {
            \Log::error('SMTP connection failed', [
                'error' => $e->getMessage(),
            ]);

            return false;
        }
    }
}
