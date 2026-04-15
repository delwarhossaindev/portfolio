<?php

namespace App\Http\Controllers;

use App\Models\Contact;

class ContactController extends Controller
{
    public function index()
    {
        return view('admin.contacts.index', [
            'items' => Contact::orderByDesc('id')->paginate(20),
        ]);
    }

    public function show(Contact $contact)
    {
        return view('admin.contacts.show', ['item' => $contact]);
    }

    public function destroy(Contact $contact)
    {
        $contact->delete();

        return redirect()->route('admin.contacts.index')->with('admin_success', 'Message deleted.');
    }
}
