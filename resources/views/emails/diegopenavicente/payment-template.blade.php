@extends('emails.diegopenavicente.layout-default')

@section('email-content')
<!-- Email Body -->
<tr>
    <td class="body" width="100%" cellpadding="0" cellspacing="0" style="border: hidden !important;">
        <table class="inner-body" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation">
            <!-- Body content -->
            <tr>
                <td class="content-cell">
                    <p>{{ $GreetingHeader }} {{ $name }},</p><br>
                    <p>{{ $body }}</p><br>
                    <p>{{ $GreetingFooter }}</p><br>
                    <p>Diego Pena Vicente</p><br>
                </td>
            </tr>
        </table>
    </td>
</tr>
@endsection
