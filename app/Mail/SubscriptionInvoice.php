<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Subscription;
use Barryvdh\DomPDF\Facade\Pdf;

class SubscriptionInvoice extends Mailable
{
    use Queueable, SerializesModels;

    public $subscription;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Subscription $subscription)
    {
        $this->subscription = $subscription;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $pdf = PDF::loadView('emails.invoice', ['subscription' => $this->subscription]);
        $pdfContent = $pdf->output();

        return $this->view('emails.invoice')
                    ->subject('Invoice')
                    ->attachData($pdfContent, $this->subscription->name . '.pdf', [
                        'mime' => 'application/pdf',
                    ]);
    }
}
