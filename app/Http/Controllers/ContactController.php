<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Models\Contact;
use App\Models\User;
use App\Notifications\ContactReceivedNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function index(): View
    {
        return view('pages.contact');
    }

    public function store(ContactRequest $request): RedirectResponse
    {
        $contact = Contact::create([
            ...$request->validated(),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $path = $file->store('contact-attachments', 'local');

            $contact->attachments()->create([
                'path' => $path,
                'original_name' => $file->getClientOriginalName(),
                'mime_type' => $file->getMimeType(),
                'size' => $file->getSize(),
            ]);
        }

        User::where('is_admin', true)->each(
            fn (User $admin) => $admin->notify(new ContactReceivedNotification($contact))
        );

        return back()->with('success', 'Thank you for reaching out. I will get back to you soon.');
    }
}
