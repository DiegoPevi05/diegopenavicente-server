<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SFMailable;
use App\Mail\SFMailableReply;

class EmailController extends Controller
{
    public function sendEmail(Request $request)
    {
        // Check the Authorization header
        $authHeader = $request->header('Authorization');
        if ($authHeader !== 'diegopenavicente2023') {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $name = $request->input('name');
        $email = $request->input('email');
        $content = $request->input('message');
        // Check for the "language" parameter
        $languages = ['es', 'it', 'en'];
        $language = $request->has('language') && in_array($request->input('language'), $languages) ? $request->input('language') : 'en';

        $mailable = new SFMailable($name,$language);
        Mail::to($email)->send($mailable);

        $mailableReply = new SFMailableReply($name, $email, $content,$language);
        Mail::to('consulting.services@diegopenavicente.com')->send($mailableReply);

    }
}
