@extends('emails.diegopenavicente.layout-default')

@section('email-content')

<!-- Email Body -->
<tr>
    <td class="body" width="100%" cellpadding="0" cellspacing="0" style="border: hidden !important;">
        <table class="inner-body" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation">
        <!-- Body content -->
            <tr>
                <td class="content-cell">
                    <h1>Grazie per il tuo messagio!</h1><br>
                    <p>Ciao {{ $name }},</p><br>
                    <p>Grazie per averci contattato. Abbiamo ricevuto il tuo messaggio e ti contatteremo il prima possibile.</p><br>
                    <p>Cordiali saluti</p><br>
                    <p>Diego Pena Vicente </p><br>
                </td>
            </tr>
        </table>
    </td>
</tr>
@endsection
