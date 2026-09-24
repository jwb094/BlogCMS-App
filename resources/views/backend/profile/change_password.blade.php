@extends('layouts.backend-layout')
@section('title','Blog - Password Reset')
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
<section class="d-flex flex-column align-items-center justify-content-center vh-100 bg-body-tertiary">
    <div class="w-100 d-flex justify-content-center align-items-center mx-auto" style="max-width: 400px;">
    
        <section class="form-signin w-100 m-auto">
            <form action={{ route('admin.profile.password_update') }} method="POST">
                @csrf
                <h1 class="h3 mb-3 fw-normal text-center"> Change Password</h1>
                <div class="form-floating mt-2">
                    <x-form.input type="password" class="form-control" name="password" id="floatingPassword" placeholder="Password"></x-form.input>
                    <x-form.label for="floatingPassword">New Password</x-form.label>
                </div>
                <div class="form-floating mt-2">
                    <x-form.input type="password" class="form-control" name="password_confirmation" id="floatingReconfirmPassword" placeholder="Password"></x-form.input>
                    <x-form.label for="floatingReconfirmPassword">ReConfirm Password</x-form.label>
                </div>
                <x-form.button class="btn btn-primary w-100 py-2 mt-2" type="submit">Update Password</x-form.button>
    
            </form>
        </section>
    </div>
</section>
@endsection
