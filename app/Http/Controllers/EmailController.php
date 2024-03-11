<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\diegopenavicente\SFMailable;
use App\Mail\diegopenavicente\SFMailableReply;
use App\Mail\olimed\SFMailable as SFMailableOlimed;
use App\Mail\olimed\SFMailableReply as SFMailableReplyOlimed;
use App\Mail\lanonnarose\SFMailable as SFMailableLaNonnaRose;
use App\Mail\lanonnarose\SFMailableReply as SFMailableReplyLaNonnaRose;


class EmailController extends Controller
{
    public function sendEmailDiegoPenaVicente(Request $request)
    {
        $name = $request->input('name');
        $email = $request->input('email');
        $content = $request->input('message');
        
        // Get the "Accept-Language" header and extract the preferred language
        $language = $request->header('Accept-Language');

        // If the header is not set or doesn't contain a valid language code, default to 'en'
        $languages = ['es', 'it', 'en'];
        $language = in_array($language, $languages) ? $language : 'en';

        $mailable = new SFMailable($name, $language);
        Mail::mailer('default')->to($email)->send($mailable);

        $mailableReply = new SFMailableReply($name, $email, $content, $language);
        Mail::mailer('default')->to('consulting.services@diegopenavicente.com')->send($mailableReply);
    }

    public function sendEmailOlimed(Request $request)
    {

        $name = $request->input('name');
        $email = $request->input('email');
        $content = $request->input('message');

        // Get the "Accept-Language" header and extract the preferred language
        $language = $request->header('Accept-Language');

        // Check for the "language" parameter
        $languages = ['es', 'en'];
        $language = in_array($language, $languages) ? $language : 'en';

        $mailable = new SFMailableOlimed($name,$language);
        Mail::mailer('olimed')->to($email)->send($mailable);

        $mailableReply = new SFMailableReplyOlimed($name, $email, $content);
        $recipients = ['info@olimed.com.pe', 'tadeo.m@olimed.com.pe'];
        Mail::mailer('olimed')->to($recipients)->send($mailableReply);

    }

    public function sendEmailLaNonnaRose(Request $request)
    {
        $name = $request->input('name');
        $email = $request->input('email');
        $content = $request->input('message');

        // Get the "Accept-Language" header and extract the preferred language
        $language = $request->header('Accept-Language');

        // Check for the "language" parameter
        $languages = ['es', 'en'];
        $language = in_array($language, $languages) ? $language : 'en';

        $mailable = new SFMailableLaNonnaRose($name,$language);
        Mail::mailer('lanonnarose')->to($email)->send($mailable);

        $mailableReply = new SFMailableReplyLaNonnaRose($name, $email, $content, $language);
        Mail::mailer('lanonnarose')->to('info@lanonnarose.com')->send($mailableReply);
    }
    
}
