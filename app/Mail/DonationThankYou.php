<?php

namespace App\Mail;

use App\Models\DonationSession;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DonationThankYou extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public User $user,
        public DonationSession $session,
    ) {}

    public function build()
    {
        return $this
            ->subject('Thank You for Your Life-Saving Donation!')
            ->view('emails.donation-thank-you');
    }
}
