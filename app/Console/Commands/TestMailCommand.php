<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Exception;

class TestMailCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:test {email? : The email address to send the test email to}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test the SMTP mail configuration';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Testing Mail Configuration...');
        $this->table(
            ['Configuration', 'Value'],
            [
                ['MAIL_MAILER', config('mail.default')],
                ['MAIL_HOST', config('mail.mailers.smtp.host')],
                ['MAIL_PORT', config('mail.mailers.smtp.port')],
                ['MAIL_ENCRYPTION', config('mail.mailers.smtp.encryption') ?: 'none'],
                ['MAIL_USERNAME', config('mail.mailers.smtp.username')],
                ['MAIL_PASSWORD', config('mail.mailers.smtp.password') ? '********' : 'Not Set'],
                ['MAIL_FROM_ADDRESS', config('mail.from.address')],
            ]
        );

        $email = $this->argument('email') ?: config('mail.from.address');

        if (!$email) {
            $this->error('No email address provided to send the test message. Please provide an email as an argument or set MAIL_FROM_ADDRESS.');
            return 1;
        }

        $this->info("Attempting to send a test email to: {$email}");

        try {
            Mail::raw('This is a test email from Laravel to verify SMTP configuration.', function ($message) use ($email) {
                $message->to($email)
                        ->subject('Test Email - SMTP Configuration Verification');
            });
            $this->info('Test email sent successfully! Check your inbox.');
        } catch (Exception $e) {
            $this->error('Failed to send test email.');
            $this->error('Exception: ' . get_class($e));
            $this->error('Message: ' . $e->getMessage());
            $this->error('Trace: ' . $e->getTraceAsString());
            return 1;
        }

        return 0;
    }
}
