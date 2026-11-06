<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class SupabaseAuthService
{
    public function isEnabled(): bool
    {
        return (bool) config('supabase.auth_enabled')
            && config('supabase.url')
            && config('supabase.anon_key');
    }

    public function isAllowedAdmin(string $email): bool
    {
        $allowed = config('supabase.admin_emails', []);

        if ($allowed !== []) {
            return in_array(Str::lower($email), array_map('strtolower', $allowed), true);
        }

        return \App\Models\Admin::where('email', $email)->exists();
    }

    /**
     * @return array{user: array<string, mixed>}|null
     */
    public function signIn(string $email, string $password): ?array
    {
        $response = Http::withHeaders($this->authHeaders(config('supabase.anon_key')))
            ->post($this->authUrl('/token?grant_type=password'), [
                'email' => $email,
                'password' => $password,
            ]);

        if (! $response->successful()) {
            return null;
        }

        $data = $response->json();

        if (! is_array($data) || empty($data['user'])) {
            return null;
        }

        return $data;
    }

    public function updatePassword(string $supabaseUserId, string $newPassword): bool
    {
        $serviceKey = config('supabase.service_role_key');

        if (! $serviceKey) {
            return false;
        }

        $response = Http::withHeaders($this->authHeaders($serviceKey))
            ->put($this->authUrl('/admin/users/'.$supabaseUserId), [
                'password' => $newPassword,
            ]);

        return $response->successful();
    }

    /**
     * @param  array<string, mixed>  $supabaseUser
     */
    public function syncAdminFromSupabase(array $supabaseUser): \App\Models\Admin
    {
        $email = (string) ($supabaseUser['email'] ?? '');
        $name = (string) ($supabaseUser['user_metadata']['name'] ?? $supabaseUser['email'] ?? 'Admin');
        $supabaseId = (string) ($supabaseUser['id'] ?? '');

        $admin = \App\Models\Admin::firstOrNew(['email' => $email]);
        $admin->name = $name;
        $admin->supabase_id = $supabaseId;

        if (! $admin->exists) {
            $admin->password = bcrypt(Str::random(32));
        }

        $admin->save();

        return $admin;
    }

    /**
     * @return array<string, string>
     */
    private function authHeaders(string $key): array
    {
        return [
            'apikey' => $key,
            'Authorization' => 'Bearer '.$key,
            'Content-Type' => 'application/json',
        ];
    }

    private function authUrl(string $path): string
    {
        return rtrim((string) config('supabase.url'), '/').'/auth/v1'.$path;
    }
}
