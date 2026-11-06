<?php

namespace App\Http\Controllers;

use App\Models\ContactDetail;
use Illuminate\Http\Request;

class ContactDetailController extends Controller
{
    public function show()
    {
        $contactDetail = ContactDetail::getContactDetails();
        return view('contact-details', compact('contactDetail'));
    }
}
