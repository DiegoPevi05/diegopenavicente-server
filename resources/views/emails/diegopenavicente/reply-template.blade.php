@extends('emails.diegopenavicente.layout-default')

@section('email-content')

<!-- Email Body -->
<tr>
    <td class="body" width="100%" cellpadding="0" cellspacing="0" style="border: hidden !important;">
        <table class="inner-body" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation">
            <!-- Body content -->
            <tr>
                <td class="content-cell">
                    <h1>New Form of Contact!</h1><br>
                    <p>Name: {{ $name }}</p><br>
                    <p>Email: {{ $email }}</p><br>
                    <p>Message: {{ $content }}</p><br>
                </td>
            </tr>
        </table>
    </td>
</tr>

@endsection