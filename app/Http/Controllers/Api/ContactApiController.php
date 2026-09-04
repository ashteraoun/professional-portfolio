<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactRequest;
use App\Models\Contact;
use App\Models\User;
use App\Notifications\ContactReceivedNotification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ContactApiController extends Controller
{
    public function store(ContactRequest $request): JsonResponse
    {
        $contact = Contact::create([
            ...$request->validated(),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        User::where('is_admin', true)->each(
            fn (User $admin) => $admin->notify(new ContactReceivedNotification($contact))
        );

        return response()->json([
            'message' => 'Thank you for reaching out.',
            'data' => ['id' => $contact->id],
        ], 201);
    }
}
