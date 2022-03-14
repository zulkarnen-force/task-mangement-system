<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Carbon\Carbon;

class sendingEmailTicket extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $ticket_email;

    public function __construct($ticket_email)
    {
        $this->emails_ticket = $ticket_email;
    }

    /**
     * Build the message.s
     *
     * @return $this
     */
    public function build()
    {

        $email_time = Carbon::now();

        return $this->subject('Ticket Create'.$email_time)
            ->from('gaptekxgaptekxgame@gmail.com', 'Ricky Fernando')
            ->view('template_emails.email_ticket')
            ->with('emails', $this->emails_ticket);
    }
}
