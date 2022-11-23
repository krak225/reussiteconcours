<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class MailResetLink extends Mailable
{
    use Queueable, SerializesModels;

	public $email;
	public $token;
	
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email,$token)
    {
        $this->email   				= $email;
        $this->token 					= $token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
		
        return $this->from('robot@krolproductions.com')
					->view('mail_reinitialisation')
					->subject('Demande de réinitialisation de mot de passe');
					
					
    }
	
}
