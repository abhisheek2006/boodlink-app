<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BirthdayWish extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public User $user,
    ) {}

    public function build()
    {
        return $this
            ->subject('Happy Birthday from Blood Link!')
            ->view('emails.birthday');
    }
}
