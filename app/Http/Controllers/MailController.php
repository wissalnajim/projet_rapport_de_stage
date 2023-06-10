<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function sendMail(Request $request)
    {
        // Validate the form data
        $request->validate([
            'greetings' => 'required',
            'body' => 'required',
            'action' => 'required',
            'name' => 'required',
        ]);

        // Prepare the mail data
        $data = [
            'greetings' => $request->greetings,
            'body' => $request->body,
            'action' => $request->action,
            'name' => $request->name,
        ];

        // Send the email
        Mail::send('emails.notification', $data, function ($message) use ($data) {
            $message->to($data['name'])->subject($data['greetings']);
            $message->setBody($data['body'], $data['action']);
        });

        // Redirect to a success page or display a success message
        return redirect()->route('some.success.route')->with('status', 'Email sent successfully');
    }
}

