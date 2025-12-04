<?php

namespace App\Mail;

use App\Models\Subscriber;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerificationEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $subscriber;
    public $verificationUrl;
    public $unsubscribeUrl;

    /**
     * Create a new message instance.
     */
    public function __construct(Subscriber $subscriber, $verificationUrl, $unsubscribeUrl)
    {
        $this->subscriber = $subscriber;
        $this->verificationUrl = $verificationUrl;
        $this->unsubscribeUrl = $unsubscribeUrl;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Verifica tu suscripción - Edward Villa Perfumería')
                    ->markdown('emails.subscribers.verify');
    }
}
