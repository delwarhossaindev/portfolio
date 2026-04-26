<?php

namespace App\Http\Controllers;

use App\Models\Contact;

class ContactController extends Controller
{
    public function index()
    {
        return view('admin.contacts.index', [
            'items' => Contact::orderByDesc('id')->paginate(20),
            'unreadCount' => Contact::unread()->count(),
        ]);
    }

    public function show(Contact $contact)
    {
        $contact->markRead();

        return view('admin.contacts.show', ['item' => $contact]);
    }

    public function destroy(Contact $contact)
    {
        $contact->delete();

        return redirect()->route('admin.contacts.index')->with('admin_success', 'Message deleted.');
    }

    public function markAllRead()
    {
        Contact::unread()->update([
            'is_read' => true,
            'read_at' => now(),
        ]);

        return redirect()->route('admin.contacts.index')->with('admin_success', 'All messages marked as read.');
    }
}
