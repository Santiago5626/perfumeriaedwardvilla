<?php

namespace App\Mail;

use App\Models\Offer;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewOfferNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $offer;

    /**
     * Create a new message instance.
     */
    public function __construct(Offer $offer)
    {
        $this->offer = $offer;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('¡Nueva Oferta Especial en Edward Villa Perfumería!')
                    ->view('emails.offers.new', [
                        'offer' => $this->offer,
                        'unsubscribeUrl' => route('newsletter.unsubscribe', ['email' => $this->to[0]['address']])
                    ]);
    }
}
