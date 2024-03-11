@extends('emails.diegopenavicente.layout-default')

@section('email-content')

<!-- Email Body -->
<tr>
    <td class="body" width="100%" cellpadding="0" cellspacing="0" style="border: hidden !important;">
        <table class="inner-body" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation">
            <!-- Body content -->
            <tr>
                <td class="content-cell">
                    <h1>Thanks for your trust!</h1><br>
                    <p>Hello {{ $name }},</p><br>
                    <p>With this email we confirm the beginning of your web/digital service.</p><br>
                    <p>Best Regards</p><br>
                    <p>Diego Pena Vicente </p><br>
                </td>
            </tr>
        </table>
    </td>
</tr>

@endsection
