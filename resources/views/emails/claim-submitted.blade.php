@extends('emails.layout')

@section('content')
    <h1>{{ $isAdmin ? 'New Claim Request' : 'Claim Received' }}</h1>
    <p>Hello,</p>
    @if ($isAdmin)
        <p>A new product claim request has been submitted for <strong>{{ $claim->tool->name }}</strong>.</p>
        <p>Vendor: {{ $claim->vendor->company_name }} ({{ $claim->vendor->user->email }})</p>
        <p>Reason: {{ $claim->reason }}</p>
        <p>Status: {{ ucfirst($claim->status) }}</p>
    @else
        <p>Thank you for claiming <strong>{{ $claim->tool->name }}</strong>. Your request has been received and is currenty
            <strong>{{ $claim->status }}</strong>.</p>
        @if ($claim->status === 'approved')
            <p>Congratulations! Your claim was automatically approved as your business email matched the product domain.</p>
        @else
            <p>Our team will review your claim and get back to you shortly.</p>
        @endif
    @endif
    <p>Regards,<br>{{ config('app.name') }} Team</p>
@endsection
