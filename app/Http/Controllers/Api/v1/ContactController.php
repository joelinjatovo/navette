<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Mail\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    
    /**
     * Send help message
     *
     * @param  Request  $request
     *
     * @return Response
     */
    public function contact(Request $request)
    {
		$subject = $request->input('subject');
		$message = $request->input('message');

        Mail::to(config('mail.contact_to.address'))
			->send(new Contact($subject, $message));
		
        return $this->success(200, trans('messages.message.sent'), [
			'subject' => $subject,
			'message' => $message,
		]);
    }
}
