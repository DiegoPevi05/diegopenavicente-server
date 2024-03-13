<?php

namespace App\Mail\diegopenavicente;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaymentNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $language;
    public $payment;

    public function __construct($name,$language, $payment)
    {
        $this->name = $name;
        $this->language = $language;
        $this->payment = $payment;
    }

    public function build()
    {
        if($this->language == "es"){

            return $this->view('emails.diegopenavicente.payment-template', [
                                'GreetingHeader' => 'Hola',
                                'GreetingFooter' => 'Saludos Cordiales',
                                'name' => $this->name,
                                'body' => 'Tu pago esta pendiente, tienes un pago pendiente de '. $this->payment .' por favor realiza el pago lo antes posible. Gracias.'
                               ])
                        ->subject('Recodatorio de pago');

        }else if($this->language == "en"){

            return $this->view('emails.diegopenavicente.payment-template', [
                                'GreetingHeader' => 'Hello',
                                'GreetingFooter' => 'Best Regards',
                                'name' => $this->name,
                                'body' => 'You have a pending payment, you have a pending payment of ' . $this->payment . ' please make the payment as soon as possible. Thanks.'
                               ])
                        ->subject('Payment reminder');

        }else if($this->language == "it"){

            return $this->view('emails.diegopenavicente.payment-template', [
                                'GreetingHeader' => 'Ciao',
                                'GreetingFooter' => 'Cordiali Saluti',
                                'name' => $this->name,
                                'body' => 'Hai un pagamento in sospeso, hai un pagamento in sospeso di ' . $this->payment . ' per favore effettua il pagamento il prima possibile. Grazie.'
                               ])
                        ->subject('Promemoria di pagamento');

        }

    }
}
