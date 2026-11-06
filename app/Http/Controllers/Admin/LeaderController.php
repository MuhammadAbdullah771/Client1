<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Leader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class LeaderController extends Controller
{
    private function getActiveDepartments(): array
    {
        return config('departments.departments', []);
    }

    private function normalizeLinkedin(?string $value): ?string
    {
        $value = trim((string) $value);
        if ($value === '') {
            return null;
        }
        $value = preg_replace('~^https?://~i', '', $value);
        $value = preg_replace('~^www\.~i', '', $value);
        if (stripos($value, 'linkedin.com/in/') !== false) {
            $value = substr($value, stripos($value, 'linkedin.com/in/') + strlen('linkedin.com/in/'));
        } elseif (stripos($value, '/in/') !== false) {
            $value = substr($value, stripos($value, '/in/') + strlen('/in/'));
        }
        $value = preg_replace('~[?#].*$~', '', $value);
        $value = trim($value, "/ \t\n\r\0\x0B");
        if ($value === '') {
            return null;
        }
        return 'https://linkedin.com/in/' . $value;
    }

    /**
     * Convert Google Drive share link to direct image link
     * Handles various Google Drive URL formats
     */
    private function convertGoogleDriveLink(?string $url): ?string
    {
        if (empty($url)) {
            return null;
        }
        
        $url = trim($url);
        
        // If already a direct link, return as is
        if (str_contains($url, '/uc?export=view&id=') || str_contains($url, '/uc?export=download&id=')) {
            return $url;
        }
        
        // Extract file ID from Google Drive share link
        $fileId = null;
        
        // Pattern 1: /file/d/FILE_ID/
        if (preg_match('/\/file\/d\/([a-zA-Z0-9_-]+)/', $url, $matches)) {
            $fileId = $matches[1];
        }
        // Pattern 2: ?id=FILE_ID
        elseif (preg_match('/[?&]id=([a-zA-Z0-9_-]+)/', $url, $matches)) {
            $fileId = $matches[1];
        }
        
        // If we found a file ID, convert to direct image link
        if ($fileId) {
            return "https://drive.google.com/uc?export=view&id={$fileId}";
        }
        
        // If it's already a direct image URL, return as is
        return $url;
    }

    public function index()
    {
        $q = trim((string) request('q', ''));
        $leadersQuery = Leader::query()
            ->where(function ($qry) {
                $qry->where('department', '!=', 'IT')->orWhereNull('department');
            })
            ->orderBy('order')
            ->orderBy('name');

        if ($q !== '') {
            $leadersQuery->where(function ($query) use ($q) {
                $query
                    ->where('name', 'like', "%{$q}%")
                    ->orWhere('role', 'like', "%{$q}%")
                    ->orWhere('department', 'like', "%{$q}%");
            });
        }

        $leaders = $leadersQuery->paginate(12)->appends(request()->query());

        return view('admin.leaders.index', compact('leaders'));
    }

    public function create()
    {
        return view('admin.leaders.create');
    }

    public function store(Request $request)
    {
        // Log the incoming request for debugging
        \Illuminate\Support\Facades\Log::info('Store leader request received', [
            'request_all' => $request->all(),
            'has_image_url' => $request->filled('image_url'),
        ]);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'department' => [
                'required',
                'string',
                'max:255',
                function ($attribute, $value, $fail) {
                    $validDepartments = $this->getActiveDepartments();
                    if (!empty($value) && !in_array($value, $validDepartments)) {
                        $fail('The selected department is invalid. Please choose from the available options.');
                    }
                },
            ],
            'bio' => 'required|string|max:1000',
            'image_url' => 'required|url|max:500',
            'email' => 'nullable|email|max:255',
            'linkedin' => 'nullable|string|max:255',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ], [
            'name.required' => 'The name field is required.',
            'role.required' => 'The role field is required.',
            'department.required' => 'Please select a department.',
            'bio.required' => 'The biography field is required.',
            'bio.max' => 'The biography must not exceed 1000 characters.',
            'image_url.required' => 'Please provide a profile picture URL.',
            'image_url.url' => 'Please enter a valid URL for the profile picture.',
            'image_url.max' => 'The image URL must not exceed 500 characters.',
            'email.email' => 'Please enter a valid email address.',
        ]);

        // Trim string fields
        $validated['name'] = trim($validated['name']);
        $validated['role'] = trim($validated['role']);
        $validated['department'] = trim($validated['department']);
        $validated['bio'] = trim($validated['bio']);
        
        $validated['order'] = $validated['order'] ?? 0;
        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['linkedin'] = $this->normalizeLinkedin($validated['linkedin'] ?? null);
        
        // Store image URL directly (convert Google Drive links automatically)
        $imageUrl = trim($validated['image_url']);
        $validated['image'] = $this->convertGoogleDriveLink($imageUrl);
        unset($validated['image_url']);
        
        // Convert empty strings to null for nullable fields
        if (isset($validated['email'])) {
            $validated['email'] = !empty(trim($validated['email'])) ? trim($validated['email']) : null;
        }

        try {
            DB::beginTransaction();
            
            // Prepare create data - only include fillable fields
            $createData = [];
            $fillable = (new Leader())->getFillable();
            
            // Add all validated fields that are fillable
            foreach ($validated as $key => $value) {
                if (in_array($key, $fillable)) {
                    $createData[$key] = $value;
                }
            }
            
            // Ensure order is set
            if (!isset($createData['order'])) {
                $createData['order'] = 0;
            }
            
            // Log what we're creating for debugging
            \Illuminate\Support\Facades\Log::info('Creating leader', [
                'request_all' => $request->all(),
                'validated' => $validated,
                'create_data' => $createData,
                'fillable' => $fillable,
            ]);
            
            // Create the leader
            $leader = Leader::create($createData);
            
            if (!$leader || !$leader->id) {
                DB::rollBack();
                throw new \Exception('Leader creation returned null or no ID');
            }
            
            DB::commit();
            
            // Refresh the model to ensure we have the latest data
            $leader->refresh();
            
            \Illuminate\Support\Facades\Log::info('Leader created successfully', [
                'leader_id' => $leader->id,
                'created_fields' => array_keys($createData),
                'current_data' => $leader->toArray(),
            ]);
            
            return redirect()->route('admin.leaders.index')->with('success', 'Leader created successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            throw $e;
        } catch (\Exception $e) {
            DB::rollBack();
            \Illuminate\Support\Facades\Log::error('Leader creation failed: ' . $e->getMessage(), [
                'request_all' => $request->all(),
                'validated' => $validated ?? [],
                'trace' => $e->getTraceAsString(),
            ]);
            
            return back()->withInput()->withErrors([
                'error' => 'Failed to create leader: ' . $e->getMessage() . '. Please check the logs for more details.'
            ]);
        }
    }

    public function edit(Leader $leader)
    {
        if ($leader->department === 'IT') {
            abort(404, 'IT team members are managed from IT Services → IT Services Team.');
        }
        return view('admin.leaders.edit', compact('leader'));
    }

    public function update(Request $request, Leader $leader)
    {
        if ($leader->department === 'IT') {
            abort(404, 'IT team members are managed from IT Services → IT Services Team.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'department' => [
                'required',
                'string',
                'max:255',
                function ($attribute, $value, $fail) {
                    $validDepartments = $this->getActiveDepartments();
                    if (!empty($value) && !in_array($value, $validDepartments)) {
                        $fail('The selected department is invalid. Please choose from the available options.');
                    }
                },
            ],
            'bio' => 'required|string|max:1000',
            'image_url' => 'nullable|url|max:500',
            'email' => 'nullable|email|max:255',
            'linkedin' => 'nullable|string|max:255',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ], [
            'name.required' => 'The name field is required.',
            'role.required' => 'The role field is required.',
            'department.required' => 'Please select a department.',
            'bio.required' => 'The biography field is required.',
            'bio.max' => 'The biography must not exceed 1000 characters.',
            'image_url.url' => 'Please enter a valid URL for the profile picture.',
            'image_url.max' => 'The image URL must not exceed 500 characters.',
            'email.email' => 'Please enter a valid email address.',
        ]);

        // Trim string fields
        $validated['name'] = trim($validated['name']);
        $validated['role'] = trim($validated['role']);
        $validated['department'] = trim($validated['department']);
        $validated['bio'] = trim($validated['bio']);
        
        // Handle is_active checkbox (defaults to false if not checked)
        $validated['is_active'] = $request->boolean('is_active', false);
        
        // Handle order field - keep existing value if not provided
        if (!isset($validated['order']) || $validated['order'] === null) {
            $validated['order'] = $leader->order ?? 0;
        }
        
        // Normalize LinkedIn URL
        $validated['linkedin'] = $this->normalizeLinkedin($validated['linkedin'] ?? null);
        
        // Convert empty strings to null for nullable fields
        if (isset($validated['email'])) {
            $validated['email'] = !empty(trim($validated['email'])) ? trim($validated['email']) : null;
        } else {
            $validated['email'] = $leader->email;
        }

        // Update image URL if provided (convert Google Drive links automatically)
        if ($request->filled('image_url')) {
            $imageUrl = trim($validated['image_url']);
            $validated['image'] = $this->convertGoogleDriveLink($imageUrl);
        }
        unset($validated['image_url']);

        try {
            DB::beginTransaction();
            
            // Prepare update data - include all validated fields that are fillable
            $updateData = [];
            $fillable = $leader->getFillable();
            
            // Add all validated fields that are fillable
            foreach ($validated as $key => $value) {
                if (in_array($key, $fillable)) {
                    $updateData[$key] = $value;
                }
            }
            
            // Ensure order is set (use existing if not provided)
            if (!isset($updateData['order'])) {
                $updateData['order'] = $leader->order ?? 0;
            }
            
            // Log what we're updating for debugging
            \Illuminate\Support\Facades\Log::info('Updating leader', [
                'leader_id' => $leader->id,
                'request_all' => $request->all(),
                'validated' => $validated,
                'update_data' => $updateData,
                'fillable' => $fillable,
            ]);
            
            // Use update method with only fillable fields
            $updated = $leader->update($updateData);
            
            if (!$updated) {
                // If update returns false, try save method
                foreach ($updateData as $key => $value) {
                    $leader->$key = $value;
                }
                $saved = $leader->save();
                if (!$saved) {
                    DB::rollBack();
                    throw new \Exception('Both update() and save() methods returned false');
                }
            }
            
            DB::commit();
            
            // Refresh the model to ensure we have the latest data
            $leader->refresh();
            
            \Illuminate\Support\Facades\Log::info('Leader updated successfully', [
                'leader_id' => $leader->id,
                'updated_fields' => array_keys($updateData),
                'current_data' => $leader->toArray(),
            ]);
            
            return redirect()->route('admin.leaders.index')->with('success', 'Leader updated successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            throw $e;
        } catch (\Exception $e) {
            DB::rollBack();
            \Illuminate\Support\Facades\Log::error('Leader update failed: ' . $e->getMessage(), [
                'leader_id' => $leader->id,
                'request_all' => $request->all(),
                'validated' => $validated ?? [],
                'trace' => $e->getTraceAsString(),
            ]);
            
            return back()->withInput()->withErrors([
                'error' => 'Failed to update leader: ' . $e->getMessage() . '. Please check the logs for more details.'
            ]);
        }
    }

    public function toggle(Leader $leader)
    {
        if ($leader->department === 'IT') {
            abort(404, 'IT team members are managed from IT Services → IT Services Team.');
        }
        $leader->is_active = !$leader->is_active;
        $leader->save();
        $status = $leader->is_active ? 'activated' : 'deactivated';
        return redirect()->route('admin.leaders.index')->with('success', "Leader {$status} successfully.");
    }

    public function destroy(Leader $leader)
    {
        if ($leader->department === 'IT') {
            abort(404, 'IT team members are managed from IT Services → IT Services Team.');
        }
        
        $leader->delete();

        return redirect()->route('admin.leaders.index')->with('success', 'Leader deleted successfully.');
    }
}