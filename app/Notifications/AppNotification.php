<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AppNotification extends Notification
{
  use Queueable;

  // public $connection = 'sync';

  /**
   * Create a new notification instance.
   */
  public function __construct(
    public string $message,
  ) {
    //
  }

  public function toBroadcast(object $notifiable): BroadcastMessage
  {
    return (new BroadcastMessage([
      'message' => $this->message,
    ]))->onConnection('sync');
  }

  /**
   * Get the notification's delivery channels.
   *
   * @return array<int, string>
   */
  public function via(object $notifiable): array
  {
    return ['broadcast'];
  }

  /**
   * Get the mail representation of the notification.
   */

  // public function toMail(object $notifiable): MailMessage
  // {
  //   return (new MailMessage)
  //     ->line('The introduction to the notification.')
  //     ->action('Notification Action', url('/'))
  //     ->line('Thank you for using our application!');
  // }

  /**
   * Get the array representation of the notification.
   *
   * @return array<string, mixed>
   */
  public function toArray(object $notifiable): array
  {
    return [
      'test'
    ];
  }
}
