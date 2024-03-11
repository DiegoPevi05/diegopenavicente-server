<?php

namespace App\Mail\olimed;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SFMailable extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $language;

    public function __construct($name, $language)
    {
        $this->name = $name;
        $this->language = $language;
    }

    public function build()
    {
        if($this->language == "es"){

            return $this->view('emails.olimed.template', [
                                'name' => $this->name,
                                ])
                        ->subject('Gracias por contactarnos');

        }else if($this->language == "en"){

            return $this->view('emails.olimed.template-en', [
                                'name' => $this->name,
                                ])
                        ->subject('Thanks for Contact Us');

        }
    }
}