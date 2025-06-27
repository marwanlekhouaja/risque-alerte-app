<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReclamationValidee extends Notification
{
    use Queueable;

    /**
     * The incident instance.
     *
     * @var object
     */
    protected $incident;

    /**
     * Create a new notification instance.
     *
     * @param object $incident
     */
    public function __construct($incident)
    {
        $this->incident = $incident;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via($notifiable)
    {
        return ['database']; // 👈 notification enregistrée dans la base de données
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

    public function toDatabase($notifiable)
    {
        return [
            'incident_id' => $this->incident->id,
            'incident_name' => $this->incident->incident_name,
            'date_retour' => now()->addDays(3)->format('d/m/Y'),
            'message' => "Votre incident #{$this->incident->sheet_id} a été validé. 
              Notre équipe de maintenance interviendra dès que possible.",
            'url' => route('incidents.index'), // ou une URL spécifique
        ];
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
