@extends('emails.diegopenavicente.layout-default')

@section('email-content')
<!-- Email Body -->
<tr>
    <td class="body" width="100%" cellpadding="0" cellspacing="0" style="border: hidden !important;">
        <table class="inner-body" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation">
            <!-- Body content -->
            <tr>
                <td class="content-cell">
                    <h1>Gracias Por Tu Mensaje!</h1><br>
                    <p>Hola {{ $name }},</p><br>
                    <p>Tu nueva contraseña es:</p><br>
                    <p>{{ $password }}</p><br>
                    <p>Puedes cambiarla en el panel de usuario.</p><br>
                    <p>Saludos Cordiales</p><br>
                    <p>DiegoPenaVicente </p><br>
                </td>
            </tr>
        </table>
    </td>
</tr>
@endsection