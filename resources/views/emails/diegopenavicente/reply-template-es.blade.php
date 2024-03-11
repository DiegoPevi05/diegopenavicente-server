@extends('emails.diegopenavicente.layout-default')

@section('email-content')

<!-- Email Body -->
<tr>
    <td class="body" width="100%" cellpadding="0" cellspacing="0" style="border: hidden !important;">
        <table class="inner-body" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation">
            <!-- Body content -->
            <tr>
                <td class="content-cell">
                    <h1>Nuevo Formulario de Contacto!</h1><br>
                    <p>Nombre: {{ $name }}</p><br>
                    <p>Correo Electronico: {{ $email }}</p><br>
                    <p>Mensaje: {{ $content }}</p><br>
                </td>
            </tr>
        </table>
    </td>
</tr>

@endsection