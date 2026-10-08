<?php

namespace App\Services;

use App\Models\Contact;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class WhatsAppContactNotifier
{
    public function send(Contact $contact): void
    {
        $config = [
            'access_token' => config('services.whatsapp.access_token'),
            'phone_number_id' => config('services.whatsapp.phone_number_id'),
            'to' => config('services.whatsapp.to'),
            'template_name' => config('services.whatsapp.template_name'),
            'template_language' => config('services.whatsapp.template_language'),
            'api_version' => config('services.whatsapp.api_version'),
        ];
        $missing = array_keys(array_filter(
            $config,
            fn ($value) => ! is_string($value) || trim($value) === ''
        ));

        if ($missing !== []) {
            Log::warning('WhatsApp contact notification is not configured.', [
                'contact_id' => $contact->id,
                'missing_settings' => $missing,
            ]);

            return;
        }

        try {
            $response = Http::withToken($config['access_token'])
                ->timeout(10)
                ->post(
                    "https://graph.facebook.com/{$config['api_version']}/{$config['phone_number_id']}/messages",
                    [
                        'messaging_product' => 'whatsapp',
                        'to' => preg_replace('/\D+/', '', $config['to']),
                        'type' => 'template',
                        'template' => [
                            'name' => $config['template_name'],
                            'language' => ['code' => $config['template_language']],
                            'components' => [[
                                'type' => 'body',
                                'parameters' => [[
                                    'type' => 'text',
                                    'text' => $this->messageText($contact),
                                ]],
                            ]],
                        ],
                    ]
                );
        } catch (ConnectionException $exception) {
            Log::error('WhatsApp contact notification could not reach the Cloud API.', [
                'contact_id' => $contact->id,
                'exception' => $exception::class,
            ]);

            return;
        }

        if (! $response->successful()) {
            Log::error('WhatsApp Cloud API rejected a contact notification.', [
                'contact_id' => $contact->id,
                'status' => $response->status(),
            ]);
        }
    }

    private function messageText(Contact $contact): string
    {
        $details = array_filter([
            "Name: {$contact->name}",
            "Email: {$contact->email}",
            $contact->company ? "Company: {$contact->company}" : null,
            $contact->project_type ? "Project type: {$contact->project_type}" : null,
            $contact->budget_range ? "Budget: {$contact->budget_range}" : null,
            $contact->timeline ? "Timeline: {$contact->timeline}" : null,
            'Message: '.$contact->message,
            $contact->attachments->isNotEmpty()
                ? 'Attachment: '.$contact->attachments->pluck('original_name')->implode(', ')
                : null,
            'View in admin: '.url('/admin/messages/'.$contact->id),
        ]);

        return Str::limit(implode("\n", $details), 900, '...');
    }
}
