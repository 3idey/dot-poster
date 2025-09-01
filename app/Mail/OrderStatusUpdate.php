<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderStatusUpdate extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Order $order, public string $oldStatus)
    {
        //
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Order #'.$this->order->id.' Status Update',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.order-status-update',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
