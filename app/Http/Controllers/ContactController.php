<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactRequest;
use App\Models\Contact;
use App\Traits\HandleResponse;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    use HandleResponse;
    public function index()
    {
        $contacts = Contact::all();

        return view('dashboard.contacts.index',compact('contacts'));
    }
}
