<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Contact extends Mailable
{
    use Queueable, SerializesModels;
	
	private $object;
	
	private $content;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($object, $content)
    {
        $this->object = $object;
        $this->content = $content;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->object)
				->markdown('emails.contact.html')
                ->text('emails.contact.plain')
				->with([
					'object' => $this->object,
					'content' => $this->content,
				]);
    }
}
