<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Priority: session > cookie > browser Accept-Language header > default
        $locale = Session::get('locale');

        if (!$locale) {
            $locale = $request->cookie('locale');
        }

        if (!$locale) {
            // Try Accept-Language header as fallback
            $browserLang = substr($request->header('Accept-Language', 'en'), 0, 2);
            $locale = in_array($browserLang, ['en', 'fr', 'ar']) ? $browserLang : config('app.locale', 'en');
        }

        if (!in_array($locale, ['en', 'fr', 'ar'])) {
            $locale = 'en';
        }

        App::setLocale($locale);
        Session::put('locale', $locale);
        config(['app.locale' => $locale]);
        view()->share('currentLocale', $locale);

        return $next($request);
    }
}