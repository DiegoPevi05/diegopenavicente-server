<?php

namespace App\Mail\diegopenavicente;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SFMailableReply extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $email;
    public $content;
    public $language;

    public function __construct($name, $email, $content,$language)
    {
        $this->name = $name;
        $this->email = $email;
        $this->content = $content;
        $this->language = $language;
    }

    public function build()
    {
        $Subject = $this->name . ' wants contact you';

        if($this->language == "es"){

            $Subject = $this->name . ' quiere contactarte';

            return $this->view('emails.diegopenavicente.reply-template-es', [
                                'name' => $this->name,
                                'email' => $this->email,
                                'content' => $this->content,
                               ])
                        ->subject($Subject);

        }else if($this->language == "it"){

            $Subject = $this->name . ' vuole contattarti';

            return $this->view('emails.diegopenavicente.reply-template-it', [
                                'name' => $this->name,
                                'email' => $this->email,
                                'content' => $this->content,
                               ])
                        ->subject($Subject);
        }else{

            return $this->view('emails.diegopenavicente.reply-template', [
                                'name' => $this->name,
                                'email' => $this->email,
                                'content' => $this->content,
                               ])
                        ->subject($Subject);
        }

    }
}
