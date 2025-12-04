<?php

namespace App\Mail;

use App\Models\Subscriber;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WelcomeEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $subscriber;
    public $unsubscribeUrl;

    /**
     * Create a new message instance.
     */
    public function __construct(Subscriber $subscriber, $unsubscribeUrl)
    {
        $this->subscriber = $subscriber;
        $this->unsubscribeUrl = $unsubscribeUrl;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('¡Bienvenido a Edward Villa Perfumería!')
                    ->view('emails.subscribers.welcome-html', [
                        'subscriber' => $this->subscriber,
                        'unsubscribeUrl' => $this->unsubscribeUrl
                    ]);
    }
}
