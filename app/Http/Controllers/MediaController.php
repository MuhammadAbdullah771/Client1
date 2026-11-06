<?php

namespace App\Http\Controllers;

use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MediaController extends Controller
{
    /**
     * Display a listing of media.
     */
    public function index()
    {
        $media = Media::active()
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('admin.media.index', compact('media'));
    }

    /**
     * Show the form for creating a new media.
     */
    public function create()
    {
        $categories = [
            'hero' => 'Hero Section',
            'service' => 'Services',
            'portfolio' => 'Portfolio',
            'blog' => 'Blog',
            'team' => 'Team',
            'case-study' => 'Case Studies',
            'other' => 'Other',
        ];

        return view('admin.media.create', compact('categories'));
    }

    /**
     * Store a newly created media in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'file' => 'required|file|mimes:jpeg,png,gif,webp,svg,jpg,pdf,mp4,webm|max:51200', // 50MB
            'category' => 'required|string|in:hero,service,portfolio,blog,team,case-study,other',
            'description' => 'nullable|string|max:500',
            'alt_text' => 'nullable|string|max:255',
        ]);

        $file = $request->file('file');
        $extension = $file->getClientOriginalExtension();
        $mimeType = $file->getMimeType();

        // Determine file type
        $fileType = 'document';
        if (str_starts_with($mimeType, 'image/')) {
            $fileType = 'image';
        } elseif (str_starts_with($mimeType, 'video/')) {
            $fileType = 'video';
        }

        // Generate unique filename
        $filename = Str::slug($validated['title']) . '-' . time() . '.' . $extension;
        $category = $validated['category'];

        // Store file in public storage
        $path = $file->storeAs("media/{$category}", $filename, 'public');
        $url = asset('storage/' . $path);

        // Save media record to database
        $media = Media::create([
            'title' => $validated['title'],
            'file_path' => $path,
            'file_url' => $url,
            'file_type' => $fileType,
            'mime_type' => $mimeType,
            'file_size' => $file->getSize(),
            'description' => $validated['description'] ?? null,
            'alt_text' => $validated['alt_text'] ?? null,
            'category' => $category,
            'is_active' => true,
        ]);

        return redirect()
            ->route('admin.media.index')
            ->with('success', "Media '{$media->title}' uploaded successfully!");
    }

    /**
     * Show the form for editing the specified media.
     */
    public function edit(Media $media)
    {
        $categories = [
            'hero' => 'Hero Section',
            'service' => 'Services',
            'portfolio' => 'Portfolio',
            'blog' => 'Blog',
            'team' => 'Team',
            'case-study' => 'Case Studies',
            'other' => 'Other',
        ];

        return view('admin.media.edit', compact('media', 'categories'));
    }

    /**
     * Update the specified media in storage.
     */
    public function update(Request $request, Media $media)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'file' => 'nullable|file|mimes:jpeg,png,gif,webp,svg,jpg,pdf,mp4,webm|max:51200',
            'category' => 'required|string|in:hero,service,portfolio,blog,team,case-study,other',
            'description' => 'nullable|string|max:500',
            'alt_text' => 'nullable|string|max:255',
        ]);

        // Handle new file upload if provided
        if ($request->hasFile('file')) {
            // Delete old file if exists
            if ($media->file_path && Storage::disk('public')->exists($media->file_path)) {
                Storage::disk('public')->delete($media->file_path);
            }

            $file = $request->file('file');
            $extension = $file->getClientOriginalExtension();
            $mimeType = $file->getMimeType();

            // Determine file type
            $fileType = 'document';
            if (str_starts_with($mimeType, 'image/')) {
                $fileType = 'image';
            } elseif (str_starts_with($mimeType, 'video/')) {
                $fileType = 'video';
            }

            // Generate unique filename
            $filename = Str::slug($validated['title']) . '-' . time() . '.' . $extension;
            $category = $validated['category'];

            // Store file
            $path = $file->storeAs("media/{$category}", $filename, 'public');
            $url = asset('storage/' . $path);

            $media->update([
                'file_path' => $path,
                'file_url' => $url,
                'file_type' => $fileType,
                'mime_type' => $mimeType,
                'file_size' => $file->getSize(),
            ]);
        }

        // Update metadata
        $media->update([
            'title' => $validated['title'],
            'category' => $validated['category'],
            'description' => $validated['description'] ?? null,
            'alt_text' => $validated['alt_text'] ?? null,
        ]);

        return redirect()
            ->route('admin.media.index')
            ->with('success', "Media '{$media->title}' updated successfully!");
    }

    /**
     * Delete the specified media (soft delete via is_active).
     */
    public function destroy(Media $media)
    {
        $title = $media->title;
        $media->update(['is_active' => false]);

        return redirect()
            ->route('admin.media.index')
            ->with('success', "Media '{$title}' deleted successfully!");
    }

    /**
     * Get media by category (API endpoint)
     */
    public function getByCategory($category)
    {
        $media = Media::active()
            ->byCategory($category)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($media);
    }

    /**
     * Get all media links (for easy copying)
     */
    public function links()
    {
        $media = Media::active()
            ->orderBy('category')
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('category');

        return view('admin.media.links', compact('media'));
    }
}
