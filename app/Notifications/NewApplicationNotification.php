<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewApplicationNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public $application;
    public function __construct($application)
    {
        $this->application = $application;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $cvUrl = route('cv.show', $this->application->id);

        return (new MailMessage)
            ->subject('Lamaran Baru Diterima')
            ->line('Ada lamaran baru untuk pekerjaan: ' . $this->application->job->title)
            ->line('Pelamar: ' . $this->application->user->name)
            ->action('Download CV', $cvUrl)
            ->line('Atau lihat detail lamaran di dashboard admin.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
