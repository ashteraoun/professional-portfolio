<?php

namespace App\Notifications;

use App\Models\Contact;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ContactReceivedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Contact $contact) {}

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New Contact Inquiry')
            ->line("Name: {$this->contact->name}")
            ->line("Email: {$this->contact->email}")
            ->line("Project Type: {$this->contact->project_type}")
            ->line($this->contact->message)
            ->action('View in Admin', url('/admin/messages/'.$this->contact->id));
    }

    public function toArray(object $notifiable): array
    {
        return [
            'contact_id' => $this->contact->id,
            'name' => $this->contact->name,
            'email' => $this->contact->email,
            'message' => \Str::limit($this->contact->message, 100),
        ];
    }
}
