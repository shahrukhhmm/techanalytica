@extends('emails.layout')

@section('content')
    <h1>{{ $isAdmin ? 'New Submission' : 'Submission Received' }}</h1>
    <p>Hello,</p>
    @if ($isAdmin)
        <p>A new product submission request from <strong>{{ $submission->vendor->company_name }}</strong> has been received
            for the product <strong>{{ $submission->tool_name }}</strong>.</p>
        <p>Details:</p>
        <ul>
            <li>Category: {{ $submission->fields['category_id'] }} (See Admin Panel for details)</li>
            <li>B2B/B2C: {{ $submission->fields['is_ai_focused'] ? 'AI Focused' : 'N/A' }}</li>
        </ul>
    @else
        <p>Your product submission for <strong>{{ $submission->tool_name }}</strong> has been successfully received.</p>
        <p>Our team will review your submission and notify you once it goes live. This typically takes 24-48 hours.</p>
    @endif
    <p>Regards,<br>{{ config('app.name') }} Team</p>
@endsection
