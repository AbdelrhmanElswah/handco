<?php

namespace App\Http\Controllers;

use App\Http\Requests\Contact\StoreContactRequest;
use App\Models\Contact;
use App\Traits\HandleResponse;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::all();

        return view('dashboard.contacts.index',compact('contacts'));
    }
    public function store(StoreContactRequest $request)
    {
        // Save the validated data
        Contact::create($request->validated());

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Your message has been sent successfully!');
    }


}
