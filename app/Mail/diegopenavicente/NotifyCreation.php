<?php

namespace App\Mail\diegopenavicente;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotifyCreation extends Mailable
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

            return $this->view('emails.diegopenavicente.notifycreation-es', [
                                'name' => $this->name,
                               ])
                        ->subject('Gracias por tu confianza');

        }else if($this->language == "en"){

            return $this->view('emails.diegopenavicente.notifycreation', [
                                'name' => $this->name,
                               ])
                        ->subject('Thanks for your trust');

        }else if($this->language == "it"){

            return $this->view('emails.diegopenavicente.notifycreation-it', [
                                'name' => $this->name,
                               ])
                        ->subject('Grazie per la tua fiducia');

        }

    }
}
