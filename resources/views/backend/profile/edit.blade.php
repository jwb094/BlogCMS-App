@extends('layouts.backend-layout')
@section('title','Profile Details')
@section('content')

<div class="container-fluid">
    <div class="row">
        @if (session('status'))
        <x-form.alert class="alert alert-success">
            {{ session('message') }}
        </x-form.alert>
        @endif
        @if ($errors->any())
        <x-form.alert class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </x-form.alert>
        @endif
        <div class="row | mt-5">
            <h1>Update </h1>
        </div>
        <section class="form-signin col-md-12 m-auto">
            <h1 class="h2 mb-3 fw-normal text-center my-4"> Profile Information </h1>
            <form action={{ route('admin.profile.update',$user->id) }} method="POST" class="profile_information" id="profile_information">
                @csrf
                @method('PUT')
                <div class="form-check mt-3">
                    <x-form.label for="profile_photo" class="form-label"> Profile Photo </x-form.label>
                    <x-form.input type="file" id="profile_photo" class="form-control" name="profile_photo"></x-form.input>
                </div>
                <div class="form-check mt-3">
                    <x-form.label for="first_name" class="form-label"> First Name </x-form.label>
                    <x-form.input type="text" id="first_name" class="form-control" name="first_name" value="{{ old('first_name',$user->first_name) }}"></x-form.input>
                </div>
                <div class="form-check mt-3">
                    <x-form.label for="user_last_name" class="form-label"> Last Name </x-form.label>
                    <x-form.input type="text" id="user_last_name" class="form-control" name="last_name" value="{{ old('last_name',$user->last_name) }}"></x-form.input>
                </div>
                <div class="form-check mt-3">
                    <x-form.label for="user_email" class="form-label"> Email </x-form.label>
                    <x-form.input type="text" id="user_email" class="form-control" name="email" value="{{ old('user_email',$user->email) }}"></x-form.input>
                </div>
                <div class="form-check my-3">
                    <x-form.label for="bio" class="form-label"> Bio </x-form.label>
                    <x-form.textarea type="text" id="bio" class="form-control" name="bio" rows="3">{{ old('notes',$user->bio) }}</x-form.textarea>
                </div>
                <div class="form-check mt-3">
                    <x-form.label for="first_name" class="form-label"> Facebook </x-form.label>
                    <x-form.input type="text" id="first_name" class="form-control" name="first_name" value="{{ old('first_name',$user->facebook) }}"></x-form.input>
                </div>
                <div class="form-check mt-3">
                    <x-form.label for="user_last_name" class="form-label"> Instagram </x-form.label>
                    <x-form.input type="text" id="user_last_name" class="form-control" name="last_name" value="{{ old('last_name',$user->instagram) }}"></x-form.input>
                </div>
                <div class="form-check mt-3">
                    <x-form.label for="user_email" class="form-label"> Linkedin </x-form.label>
                    <x-form.input type="text" id="user_email" class="form-control" name="email" value="{{ old('user_email',$user->linkedin) }}"></x-form.input>
                </div>
                <div class="form-check mt-3">
                    <x-form.label for="user_email" class="form-label"> Twitter </x-form.label>
                    <x-form.input type="text" id="user_email" class="form-control" name="email" value="{{ old('user_email',$user->twitter) }}"></x-form.input>
                </div>
                <div class="buttons mt-5">
                    <button class="btn btn-dark" type="submit" id="submitBtn">Submit</button>
                </div>
            </form>
        </section>
    </div>

    @endsection
