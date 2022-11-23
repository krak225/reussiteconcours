<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\NotificationMail;


class ContactGroupe extends Mailable
{
    use Queueable, SerializesModels;

	public $NotificationData;
	public $mail_objet;
	
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($NotificationData, $mail_objet)
    {
        $this->NotificationData = $NotificationData;
        $this->mail_objet 		= $mail_objet;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
		
		$this->withSwiftMessage(function ($swiftmessage) {
			
		   $swiftmessage_id = $swiftmessage->getId();
		   
		   $notifmail_id = $this->NotificationData['notifmail_id'];
		   $notifmail = NotificationMail::find($notifmail_id);
		   
		   $notifmail->mail_message_id = $swiftmessage_id;
		   $notifmail->exists = true;
		   $notifmail->save();
		   
		   
		   
		});
		
        return $this->from('info@krolproductions.com','K.ROL PRODUCTIONS')
					->view('mail_',$this->NotificationData)
					->subject($this->mail_objet);
					
					
    }
	
}
