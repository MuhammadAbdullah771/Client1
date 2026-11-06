<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class GeminiService
{
    public static function enabled(): bool
    {
        return filled(config('services.gemini.api_key'));
    }

    /**
     * Ask Gemini with site context. Returns plain text or null on failure.
     */
    public static function ask(string $userMessage, string $context = ''): ?string
    {
        if (! self::enabled()) {
            return null;
        }

        $apiKey = config('services.gemini.api_key');
        $model = config('services.gemini.model', 'gemini-2.0-flash');
        $url = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent";

        $system = "You are 9A Assistant for 9Associates, a professional advisory firm for KSA, UAE and GCC "
            ."covering VAT/corporate tax (ZATCA), accounting, audit, payroll, business setup and IT support. "
            ."Answer clearly and helpfully in plain text (no markdown fences). Keep answers under 180 words. "
            ."If the user wants to contact the firm, tell them to say 'contact me' in chat. "
            ."If they ask about jobs, tell them to visit Careers or ask 'what jobs are open'. "
            ."Use only the provided company context when relevant; do not invent contact emails or prices.";

        if ($context !== '') {
            $system .= "\n\nCompany context:\n".Str::limit($context, 6000);
        }

        try {
            $response = Http::timeout(20)
                ->withHeaders(['Content-Type' => 'application/json'])
                ->post($url.'?key='.$apiKey, [
                    'system_instruction' => [
                        'parts' => [['text' => $system]],
                    ],
                    'contents' => [
                        [
                            'role' => 'user',
                            'parts' => [['text' => $userMessage]],
                        ],
                    ],
                    'generationConfig' => [
                        'temperature' => 0.4,
                        'maxOutputTokens' => 500,
                    ],
                ]);

            if (! $response->successful()) {
                Log::warning('Gemini API error', [
                    'status' => $response->status(),
                    'body' => Str::limit($response->body(), 500),
                ]);

                return null;
            }

            $text = data_get($response->json(), 'candidates.0.content.parts.0.text');

            return is_string($text) && trim($text) !== '' ? trim($text) : null;
        } catch (\Throwable $e) {
            Log::error('Gemini request failed: '.$e->getMessage());

            return null;
        }
    }
}
