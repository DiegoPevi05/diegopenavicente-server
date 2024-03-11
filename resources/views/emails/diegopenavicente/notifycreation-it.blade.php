@extends('emails.diegopenavicente.layout-default')

@section('email-content')

<!-- Email Body -->
<tr>
    <td class="body" width="100%" cellpadding="0" cellspacing="0" style="border: hidden !important;">
        <table class="inner-body" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation">
            <!-- Body content -->
            <tr>
                <td class="content-cell">
                    <h1>Grazie per la tua fiducia!</h1><br>
                    <p>Ciao {{ $name }},</p><br>
                    <p>Con questa email confermiamo l'inizio del tuo servizio web/digitale.</p><br>
                    <p>Cordiali Saluti</p><br>
                    <p>Diego Pena Vicente </p><br>
                </td>
            </tr>
        </table>
    </td>
</tr>

@endsection
