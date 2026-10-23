@extends('layouts.frontend-default-layout')
@section('title', 'Contact Us')

@section('content')
    <div class="container py-5">
        <div class="row g-5">
            <div class="col-lg-7">
                <p class="text-primary fw-semibold text-uppercase small mb-2">Contact</p>
                <h1 class="display-5 fw-bold">We’d like to hear from you</h1>
                <p class="lead text-body-secondary">
                    Have a question about an article, need help with your account, or want to share feedback?
                    Get in touch with the {{ config('app.name') }} team.
                </p>
                <div class="p-4 bg-white rounded-3 shadow-sm">
                    <h2 class="h4 fw-bold">Email us</h2>
                    <p class="text-body-secondary">Send a message to our site team. Including the relevant article link or account email will help us respond.</p>
                    <a class="btn btn-primary" href="mailto:{{ config('mail.from.address') }}?subject={{ rawurlencode('Contact '.config('app.name')) }}">
                        {{ config('mail.from.address') }}
                    </a>
                </div>
            </div>
            <aside class="col-lg-5">
                <div class="h-100 p-4 bg-body-secondary rounded-3">
                    <h2 class="h4 fw-bold">What are you contacting us about?</h2>
                    <ul class="mb-0 ps-3">
                        <li class="mb-2"><strong>Account help:</strong> include the email address on your account. Never send us your password.</li>
                        <li class="mb-2"><strong>Article feedback:</strong> include the article title or link and describe the correction or concern.</li>
                        <li><strong>General questions:</strong> tell us what you need and we’ll direct your message to the right person.</li>
                    </ul>
                </div>
            </aside>
        </div>
    </div>
@endsection
