@extends('layouts.frontend-default-layout')
@section('title','Blog - Register')
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
        <form action={{ route('profile.store') }} method="POST">
            @csrf
            <h1 class="h3 mb-3 fw-normal text-center"> Register</h1>
            <div class="form-floating">
                <x-form.input type="text" class="form-control | mb-2" name="first_name" id="floatingInput-FirstName" placeholder="Luthor"></x-form.input>
                <x-form.label for="floatingInput-FirstName">First Name</x-form.label>
            </div>
            <div class="form-floating">
                {{-- <input type="text" class="form-control | mb-2" name="last_name" id="floatingPassword" placeholder="Luthor"> --}}
                <x-form.input type="text" class="form-control | mb-2" name="last_name" id="floatingInput-Email" placeholder="Luthor"></x-form.input>
                <x-form.label for="floatingInput-LastName">Last Name</x-form-label>
            </div>
            <div class="form-floating">
                <x-form.input type="email" class="form-control | mb-2" name="email" id="floatingInput-Email" placeholder="name@example.com"></x-form.input>
                <x-form.label for="floatingInput-Email">Email address</x-form.label>
            </div>
            <div class="form-floating">

                <x-form.input type="password" class="form-control" name="password" id="floatingPassword" placeholder="Password">
                    </x-form-input>
                    <x-form.label for="floatingPassword">Password</x-form.label>
            </div>
            <x-form.button class="btn btn-primary w-100 py-2 mt-2" type="submit">Register</x-form.button>

        </form>
    </section>
</div>


@endsection
