<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class InviteUser extends Mailable {
    use Queueable, SerializesModels;

    public  $user;
    public  $company;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $company) {
        //
         $this->user = $user;
        $this->company = $company;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() {
        //->view('emails.invite_user')
        return $this
                ->subject("You have been invited on Horizony")
            ->text('emails.invite_user_plain');
    }
}
