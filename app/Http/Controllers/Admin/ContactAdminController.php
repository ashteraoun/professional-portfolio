<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactAdminController extends Controller
{
    public function index(): View
    {
        return view('admin.messages.index', [
            'messages' => Contact::latest()->paginate(20),
        ]);
    }

    public function show(Contact $contact): View
    {
        if ($contact->status === 'unread') {
            $contact->update(['status' => 'read']);
        }

        return view('admin.messages.show', ['message' => $contact]);
    }

    public function update(Request $request, Contact $contact): RedirectResponse
    {
        $request->validate(['status' => 'required|in:unread,read,archived']);
        $contact->update(['status' => $request->status]);

        return back()->with('success', 'Message updated.');
    }

    public function destroy(Contact $contact): RedirectResponse
    {
        $contact->delete();

        return redirect()->route('admin.messages.index')->with('success', 'Message deleted.');
    }
}
