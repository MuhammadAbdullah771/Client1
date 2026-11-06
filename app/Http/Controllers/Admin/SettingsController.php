<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Services\MailService;
use App\Services\SupabaseAuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class SettingsController extends Controller
{
    public function __construct(
        private SupabaseAuthService $supabaseAuth
    ) {}

    public function index()
    {
        $jobNotificationEmail = Setting::get('job_notification_email', '');
        $contactFormEmail = Setting::get('contact_form_email', '');
        $itSupportEmail = Setting::get('it_support_email', '');
        $linkedinUrl = Setting::get('social_linkedin', '');
        $twitterUrl = Setting::get('social_twitter', '');
        $facebookUrl = Setting::get('social_facebook', '');
        $mailHost = Setting::get('mail_host', config('mail.mailers.smtp.host', 'smtp.gmail.com'));
        $mailPort = Setting::get('mail_port', config('mail.mailers.smtp.port', 587));
        $mailUsername = Setting::get('mail_username', config('mail.mailers.smtp.username', ''));
        $mailEncryption = Setting::get('mail_encryption', config('mail.mailers.smtp.encryption', 'tls'));
        $mailFromAddress = Setting::get('mail_from_address', config('mail.from.address', ''));
        $mailFromName = Setting::get('mail_from_name', config('mail.from.name', config('app.name')));

        return view('admin.settings.index', compact(
            'jobNotificationEmail',
            'contactFormEmail',
            'itSupportEmail',
            'linkedinUrl',
            'twitterUrl',
            'facebookUrl',
            'mailHost',
            'mailPort',
            'mailUsername',
            'mailEncryption',
            'mailFromAddress',
            'mailFromName'
        ));
    }

    public function update(Request $request)
    {
        $request->validate([
            'job_notification_email' => 'required|email',
            'contact_form_email' => 'required|email',
            'it_support_email' => 'required|email',
            'social_linkedin' => 'nullable|url|max:255',
            'social_twitter' => 'nullable|url|max:255',
            'social_facebook' => 'nullable|url|max:255',
            'mail_host' => 'required|string|max:255',
            'mail_port' => 'required|integer|min:1|max:65535',
            'mail_username' => 'required|string|max:255',
            'mail_password' => 'nullable|string|max:255',
            'mail_encryption' => 'required|in:tls,ssl',
            'mail_from_address' => 'required|email|max:255',
            'mail_from_name' => 'required|string|max:255',
            'admin_email' => 'required|email|unique:admins,email,'.Auth::guard('admin')->id(),
            'current_password' => 'nullable|string|required_with:new_password',
            'new_password' => 'nullable|string|min:8|confirmed|different:current_password',
            'new_password_confirmation' => 'nullable|string|required_with:new_password',
        ]);

        // Update general settings
        Setting::set('job_notification_email', $request->job_notification_email);
        Setting::set('contact_form_email', $request->contact_form_email);
        Setting::set('it_support_email', $request->it_support_email);
        Setting::set('social_linkedin', $request->social_linkedin ?? '');
        Setting::set('social_twitter', $request->social_twitter ?? '');
        Setting::set('social_facebook', $request->social_facebook ?? '');
        Setting::set('mail_host', $request->mail_host);
        Setting::set('mail_port', $request->mail_port);
        Setting::set('mail_username', $request->mail_username);
        Setting::set('mail_encryption', $request->mail_encryption);
        Setting::set('mail_from_address', $request->mail_from_address);
        Setting::set('mail_from_name', $request->mail_from_name);

        if ($request->filled('mail_password')) {
            Setting::set('mail_password', $request->mail_password);
        }

        $admin = Auth::guard('admin')->user();

        if ($request->admin_email && $request->admin_email !== $admin->email) {
            $admin->email = $request->admin_email;
            $admin->save();
        }

        if ($request->filled('current_password') && $request->filled('new_password')) {
            if ($this->supabaseAuth->isEnabled()) {
                if (! $admin->supabase_id || ! $this->supabaseAuth->updatePassword($admin->supabase_id, $request->new_password)) {
                    return redirect()->route('admin.settings.index')
                        ->withInput()
                        ->with('error', 'Could not update password in Supabase. Change it in Supabase Dashboard → Authentication.');
                }

                return redirect()->route('admin.settings.index')->with('success', 'Settings updated. Password changed in Supabase.');
            }

            if (! Hash::check($request->current_password, $admin->password)) {
                return redirect()->route('admin.settings.index')
                    ->withInput()
                    ->with('error', 'Current password is incorrect. Password was not changed.');
            }

            $admin->password = Hash::make($request->new_password);
            $admin->save();

            Auth::guard('admin')->logoutOtherDevices($request->new_password);

            return redirect()->route('admin.settings.index')->with('success', 'Settings and password updated successfully. You have been logged out of other devices.');
        }

        return redirect()->route('admin.settings.index')->with('success', 'Settings updated successfully.');
    }

    public function testEmail()
    {
        $recipient = Setting::get('contact_form_email');

        try {
            MailService::configureMailFromSettings();
            Mail::mailer('smtp')->raw('Your 9Associates SMTP settings are working.', function ($message) use ($recipient) {
                $message->to($recipient)->subject('9Associates SMTP Test');
            });

            return redirect()->route('admin.settings.index')
                ->with('success', "Test email sent to {$recipient}.");
        } catch (\Throwable $exception) {
            report($exception);

            return redirect()->route('admin.settings.index')
                ->with('error', 'SMTP test failed: '.$exception->getMessage());
        }
    }

    public function exportDatabase()
    {
        try {
            $databaseName = config('database.connections.mysql.database');
            $filename = 'backup_'.$databaseName.'_'.date('Y-m-d_His').'.sql';
            $backupsDir = storage_path('app/backups');
            $filepath = $backupsDir.'/'.$filename;

            // Create backups directory if it doesn't exist
            if (! file_exists($backupsDir)) {
                if (! mkdir($backupsDir, 0755, true)) {
                    throw new \Exception('Failed to create backups directory');
                }
            }

            // Get database connection details
            $host = config('database.connections.mysql.host', '127.0.0.1');
            $port = config('database.connections.mysql.port', 3306);
            $username = config('database.connections.mysql.username', 'root');
            $password = config('database.connections.mysql.password', '');
            $database = config('database.connections.mysql.database');

            if (empty($database)) {
                throw new \Exception('Database name is not configured');
            }

            // Try mysqldump first (if available)
            $mysqldumpPath = $this->findMysqldump();
            if ($mysqldumpPath) {
                $command = sprintf(
                    '"%s" -h %s -P %s -u %s %s %s > %s 2>&1',
                    $mysqldumpPath,
                    escapeshellarg($host),
                    escapeshellarg($port),
                    escapeshellarg($username),
                    $password ? '-p'.escapeshellarg($password) : '',
                    escapeshellarg($database),
                    escapeshellarg($filepath)
                );

                exec($command, $output, $returnVar);

                if ($returnVar === 0 && file_exists($filepath) && filesize($filepath) > 0) {
                    return response()->download($filepath, $filename)->deleteFileAfterSend(true);
                }
            }

            // Fallback: Manual export using DB queries
            $tables = DB::select('SHOW TABLES');
            $tableKey = 'Tables_in_'.$database;

            $sql = "-- Database Backup\n";
            $sql .= '-- Generated: '.date('Y-m-d H:i:s')."\n";
            $sql .= "-- Database: {$database}\n\n";
            $sql .= "SET FOREIGN_KEY_CHECKS=0;\n";
            $sql .= "SET SQL_MODE = \"NO_AUTO_VALUE_ON_ZERO\";\n";
            $sql .= "SET time_zone = \"+00:00\";\n\n";

            foreach ($tables as $table) {
                $tableName = $table->$tableKey;

                try {
                    // Get table structure
                    $createTable = DB::select("SHOW CREATE TABLE `{$tableName}`");
                    if (! empty($createTable)) {
                        $sql .= "\n-- Table structure for `{$tableName}`\n";
                        $sql .= "DROP TABLE IF EXISTS `{$tableName}`;\n";
                        $sql .= $createTable[0]->{'Create Table'}.";\n\n";

                        // Get table data
                        $rows = DB::table($tableName)->get();
                        if ($rows->count() > 0) {
                            $sql .= "-- Data for table `{$tableName}`\n";
                            $columns = array_keys((array) $rows->first());
                            $columnList = '`'.implode('`, `', $columns).'`';

                            foreach ($rows as $row) {
                                $values = [];
                                foreach ($columns as $column) {
                                    $value = $row->$column;
                                    if ($value === null) {
                                        $values[] = 'NULL';
                                    } else {
                                        $values[] = DB::getPdo()->quote($value);
                                    }
                                }
                                $sql .= "INSERT INTO `{$tableName}` ({$columnList}) VALUES (".implode(',', $values).");\n";
                            }
                            $sql .= "\n";
                        }
                    }
                } catch (\Exception $e) {
                    // Skip problematic tables but continue
                    continue;
                }
            }

            $sql .= "SET FOREIGN_KEY_CHECKS=1;\n";

            if (file_put_contents($filepath, $sql) === false) {
                throw new \Exception('Failed to write backup file');
            }

            if (! file_exists($filepath) || filesize($filepath) === 0) {
                throw new \Exception('Backup file was not created or is empty');
            }

            return response()->download($filepath, $filename)->deleteFileAfterSend(true);

        } catch (\Exception $e) {
            return redirect()->route('admin.settings.index')
                ->with('error', 'Database backup failed: '.$e->getMessage());
        }
    }

    private function findMysqldump()
    {
        $paths = [
            'mysqldump',
            '/usr/bin/mysqldump',
            '/usr/local/bin/mysqldump',
            'C:\\xampp\\mysql\\bin\\mysqldump.exe',
            'C:\\wamp\\bin\\mysql\\mysql'.substr(phpversion(), 0, 3).'\\bin\\mysqldump.exe',
        ];

        foreach ($paths as $path) {
            $output = [];
            $returnVar = 0;
            exec($path.' --version 2>&1', $output, $returnVar);
            if ($returnVar === 0) {
                return $path;
            }
        }

        return null;
    }
}
