<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CustomOrderLink extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The order data.
     *
     * @var order
     */
    public $order;

    /**
     * Create a new message instance.
     * 
     * @param $order
     */
    public function __construct($order)
    {
        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Su orden ha sido procesada')
                    ->view('email.orderLink')
                    ->with('order',$this->order);
    }
}
