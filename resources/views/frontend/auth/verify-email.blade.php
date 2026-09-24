@extends('layouts.frontend-default-layout')
<h1>Verify your email address</h1>

<p>
    Thanks for registering. Before continuing, please verify your email
    address by clicking the link we sent to your email.
</p>

@if (session('message'))
    <div class="alert alert-success">
        {{ session('message') }}
    </div>
@endif

<form method="POST" action="{{ route('verification.send') }}">
    @csrf

    <button type="submit">
        Resend Verification Email
    </button>
</form>