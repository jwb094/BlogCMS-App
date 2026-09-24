@extends('layouts.frontend-auth-layout')
@section('title','Blog - Login')
@section('content')

@if ($errors->any())
<div class="w-100 d-flex justify-content-center align-items-center mx-auto" style="max-width: 400px;">
    <x-form.alert class="alert alert-danger">
        <ul class="mb-0 p-0">
            @foreach ($errors->all() as $error)
            <li class="mb-1">{{ $error }}</li>
            @endforeach
        </ul>
    </x-form.alert>
</div>
@endif

<div class="w-100 d-flex justify-content-center align-items-center mx-auto" style="max-width: 400px;">

    <section class="form-signin w-100 m-auto">
        <form action={{ route('profile.signin') }} method="POST">
            @csrf
            <h1 class="h3 mb-3 fw-normal text-center"> Sign in</h1>
            <div class="form-floating">
                <x-form.input type="email" class="form-control" name="email" id="floatingInput" placeholder="name@example.com"></x-form.input>
                <x-form.label for="floatingInput">Email address</x-form.label>
            </div>
            <div class="form-floating mt-2">
                <x-form.input type="password" class="form-control" name="password" id="floatingPassword" placeholder="Password"></x-form.input>
                <x-form.label for="floatingPassword">Password</x-form.label>
            </div>
            <x-form.button class="btn btn-primary w-100 py-2 mt-2" type="submit">Sign in</x-form.button>
            <a class="btn btn-primary w-100 py-2 mt-2" href={{ route('profile.reset_password') }}>Reset Password</a>

        </form>
    </section>
</div>
@endsection