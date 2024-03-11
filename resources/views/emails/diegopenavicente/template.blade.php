@extends('emails.diegopenavicente.layout-default')

@section('email-content')
<!-- Email Body -->
<tr>
    <td class="body" width="100%" cellpadding="0" cellspacing="0" style="border: hidden !important;">
        <table class="inner-body" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation">
            <!-- Body content -->
            <tr>
                <td class="content-cell">
                    <h1>Thanks for your message!</h1><br>
                    <p>Hi {{ $name }},</p><br>
                    <p>Thanks for contact us. we have received your message we will be in touch as soon as posible.</p><br>
                    <p>Best Regards</p><br>
                    <p>Diego Pena Vicente</p><br>
                </td>
            </tr>
        </table>
    </td>
</tr>
@endsection
