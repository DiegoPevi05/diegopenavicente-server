<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SFMailable extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $language;

    public function __construct($name,$language)
    {
        $this->name = $name;
        $this->language = $language;
    }

    public function build()
    {
        if($this->language == "es"){

            return $this->view('emails.template-es', [
                                'name' => $this->name,
                               ])
                        ->subject('Gracias por contactarnos');

        }else if($this->language == "en"){

            return $this->view('emails.template', [
                                'name' => $this->name,
                               ])
                        ->subject('Thanks for Contact Us');

        }else if($this->language == "it"){

            return $this->view('emails.template-it', [
                                'name' => $this->name,
                               ])
                        ->subject('Grazie per averci contattato');

        }

    }
}
