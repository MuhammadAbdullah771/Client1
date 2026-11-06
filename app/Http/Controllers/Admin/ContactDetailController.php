<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactDetail;
use Illuminate\Http\Request;

class ContactDetailController extends Controller
{
    public function edit()
    {
        $contactDetail = ContactDetail::getContactDetails();
        return view('admin.contact-details.edit', compact('contactDetail'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string|max:1000',
            'phone' => 'nullable|string|max:50',
            'phone_2' => 'nullable|string|max:50',
            'mobile' => 'nullable|string|max:50',
            'fax' => 'nullable|string|max:50',
            'office_hours' => 'nullable|string|max:500',
            'website' => 'nullable|url|max:255',
            'additional_info' => 'nullable|string|max:2000',
        ]);

        try {
            $contactDetail = ContactDetail::getContactDetails();
            
            // Convert empty strings to null for all fields
            $updateData = [];
            foreach ($validated as $key => $value) {
                $updateData[$key] = !empty($value) ? trim($value) : null;
            }
            
            // Update the contact detail
            $contactDetail->fill($updateData);
            $saved = $contactDetail->save();
            
            if (!$saved) {
                throw new \Exception('Failed to save contact details to database');
            }
            
            // Refresh the model to ensure we have the latest data
            $contactDetail->refresh();

            return redirect()->route('admin.contact-details.edit')
                ->with('success', 'Contact details updated successfully.');
        } catch (\Exception $e) {
            \Log::error('Error updating contact details: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            return back()->withInput()->withErrors(['error' => 'Failed to update contact details. Please try again.']);
        }
    }
}
