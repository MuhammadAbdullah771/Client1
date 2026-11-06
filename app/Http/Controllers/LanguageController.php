<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    public function switch(Request $request, $locale)
    {
        if (!in_array($locale, ['en', 'fr', 'ar'])) {
            $locale = 'en';
        }

        Session::put('locale', $locale);
        App::setLocale($locale);

        $previousUrl = url()->previous();
        if ($previousUrl && parse_url($previousUrl, PHP_URL_PATH) === parse_url($request->url(), PHP_URL_PATH)) {
            $previousUrl = route('home');
        }
        $url = $previousUrl ?: route('home');

        // Chain cookie directly on response so it is set even on HTTPS/secure hosts
        return redirect($url)->withCookie(
            cookie('locale', $locale, 60 * 24 * 365, '/', null, $request->secure(), false, false, 'lax')
        );
    }
}

