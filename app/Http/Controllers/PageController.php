<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function show(Request $request, $slug = null)
    {
        // Get slug from route parameter or request defaults
        $slug = $slug ?? $request->route('slug') ?? $request->get('slug');
        
        if (!$slug) {
            abort(404, 'Page not found');
        }

        $page = Page::getBySlug($slug);
        
        if (!$page) {
            abort(404, 'Page not found');
        }

        return view('page', compact('page'));
    }
}
