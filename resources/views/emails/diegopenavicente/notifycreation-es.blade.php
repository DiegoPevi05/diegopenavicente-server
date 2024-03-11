@extends('emails.diegopenavicente.layout-default')

@section('email-content')

<!-- Email Body -->
<tr>
    <td class="body" width="100%" cellpadding="0" cellspacing="0" style="border: hidden !important;">
        <table class="inner-body" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation">
            <!-- Body content -->
            <tr>
                <td class="content-cell">
                    <h1>Gracias por Confiar en mi experiencia!</h1><br>
                    <p>Hola {{ $name }},</p><br>
                    <p>Con este correo se confirma el inicio de tu servicio web/digital.</p><br>
                    <p>Saludos Cordiales</p><br>
                    <p>Diego Pena Vicente </p><br>
                </td>
            </tr>
        </table>
    </td>
</tr>

@endsection
