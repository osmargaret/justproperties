<?php

namespace App\Notifications;

use App\Models\Property;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PropertyAlertNotification extends Notification
{
    use Queueable;

    public function __construct(public Property $property) {}

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject(__('A property matching your alert is available'))
            ->greeting(__('Hello :name,', ['name' => $notifiable->name]))
            ->line(__('A new property matching your alert has been listed: :property', ['property' => $this->property->name]))
            ->action(__('View property'), route('property.show', $this->property));
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'kind' => 'property_alert',
            'title' => __('New property matching your alert'),
            'message' => $this->property->name,
            'url' => route('property.show', $this->property, absolute: false),
            'property_id' => $this->property->id,
        ];
    }
}
