<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\NotificationMail;


class MailDemandeATraiter extends Mailable
{
    use Queueable, SerializesModels;

	public $MailData;
	
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($MailData)
    {
        $this->MailData = $MailData;
		
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
		
		$this->withSwiftMessage(function ($swiftmessage) {
			
		   // $swiftmessage_id = $swiftmessage->getId();
		   
		   // $notifmail_id = $this->MailData['notifmail_id'];
		   // $notifmail = NotificationMail::find($notifmail_id);
		   
		   // $notifmail->mail_message_id = $swiftmessage_id;
		   // $notifmail->exists = true;
		   // $notifmail->save();
		   
		   
		   
		});
		
		// menuesdepenses
        return $this->from($this->MailData['demande']->from_email, $this->MailData['demande']->from_name)
					->view('mail.mail_premiere_connexion', $this->MailData)
					->subject('MOT DE PASSE - KROL PRODUCTIONS');
					
					
    }
	
}
