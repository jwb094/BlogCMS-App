@extends('layouts.backend-layout')
@section('title','Profile Details')
@section('content')

<div class="container-fluid">
    <div class="row">
        @if (session('status'))
        <x-form.alert class="alert alert-success mt-5">
            {{ session('message') }}
        </x-form.alert>
        @endif
        @if ($errors->any())
        <x-form.alert class="alert alert-danger mt-5">
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
            <form action={{ route('admin.profile.update',$user->id) }} method="POST" enctype="multipart/form-data" class="profile_information" id="profile_information">
                @csrf
                @method('PUT')
                @if($user->profile_photo)
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-check mt-3">
                            <x-form.label for="profile_photo" class="form-label"> Profile Photo </x-form.label>
                            <x-form.input type="file" id="profile_photo" class="form-control" name="profile_photo"></x-form.input>

                        </div>
                    </div>
                    <div class="col-md-6">
                        @if ($user->profile_photo)
                        <img src="{{ Storage::url($user->profile_photo) }}" alt="{{ $user->name }}" class="img-thumbnail w-25 rounded-circle">
                        @endif
                    </div>
                </div>
                @endif
                @if(!$user->profile_photo)
                <div class="form-check mt-3">
                    <x-form.label for="profile_photo" class="form-label"> Profile Photo </x-form.label>
                    <x-form.input type="file" id="profile_photo" class="form-control" name="profile_photo"></x-form.input>
                </div>
                @endif
                <div class="form-check mt-3">
                    <x-form.label for="first_name" class="form-label"> First Name </x-form.label>
                    <x-form.input type="text" id="first_name" class="form-control" name="first_name" value="{{ old('first_name',$user->first_name) }}"></x-form.input>
                </div>
                <div class="form-check mt-3">
                    <x-form.label for="user_last_name" class="form-label"> Last Name </x-form.label>
                    <x-form.input type="text" id="last_name" class="form-control" name="last_name" value="{{ old('last_name',$user->last_name) }}"></x-form.input>
                </div>
                <div class="form-check mt-3">
                    <x-form.label for="user_email" class="form-label"> Email </x-form.label>
                    <x-form.input type="text" id="email" class="form-control" name="email" value="{{ old('user_email',$user->email) }}"></x-form.input>
                </div>
                <div class="form-check my-3">
                    <x-form.label for="bio" class="form-label"> Bio </x-form.label>
                    <x-form.textarea type="text" id="bio" class="form-control" name="bio" rows="3">{{ old('notes',$user->bio) }}</x-form.textarea>
                </div>
                <div class="form-check mt-3">
                    <x-form.label for="facebook" class="form-label"> Facebook </x-form.label>
                    <x-form.input type="text" id="facebook" class="form-control" name="facebook" value="{{ old('first_name',$user->facebook) }}"></x-form.input>
                </div>
                <div class="form-check mt-3">
                    <x-form.label for="instagram" class="form-label"> Instagram </x-form.label>
                    <x-form.input type="text" id="instagram" class="form-control" name="instagram" value="{{ old('last_name',$user->instagram) }}"></x-form.input>
                </div>
                <div class="form-check mt-3">
                    <x-form.label for="linkedin" class="form-label"> Linkedin </x-form.label>
                    <x-form.input type="text" id="linkedin" class="form-control" name="linkedin" value="{{ old('user_email',$user->linkedin) }}"></x-form.input>
                </div>
                <div class="form-check mt-3">
                    <x-form.label for="twitter" class="form-label"> Twitter </x-form.label>
                    <x-form.input type="text" id="twitter" class="form-control" name="twitter" value="{{ old('user_email',$user->twitter) }}"></x-form.input>
                </div>
                <div class="buttons mt-5">
                    <button class="btn btn-dark" type="submit" id="submitBtn">Submit</button>
                </div>
            </form>
        </section>
    </div>

    @endsection
