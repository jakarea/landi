<?php

namespace App\Mail;
use App\Models\SubscriptionPackage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PackageSubscribeCancle extends Mailable
{
    use Queueable, SerializesModels;

    public $package;

    public function __construct(SubscriptionPackage $package)
    {
        $this->package = $package;
    }

    public function build()
    {
        return $this->markdown('emails.package.cancle')
            ->subject('Subscription Canceled'); 
    }
}