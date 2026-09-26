@extends('layouts.backend-layout')
@section('title','Tags - Edit Tag')
@section('content')
<div class="container-fluid">
    <div class="row">
        @if ($errors->any())
        <div class="w-100 d-flex justify-content-center align-items-center mx-auto" >
            <x-form.alert class="alert alert-danger">
                <ul class="mb-0 p-0">
                    @foreach ($errors->all() as $error)
                    <li class="mb-1">{{ $error }}</li>
                    @endforeach
                </ul>
            </x-form.alert>
        </div>
        @endif

        <!-- Main content -->
        <div class="col-md-12 ms-sm-auto col-lg-12 px-md-4 my-auto">

            <section class=" my-5 mx-auto">
                <form action={{ route('admin.tags.update',$tag) }} method="POST">
                    @csrf
                    @method('PUT')
                    <h1 class="h3 mb-3 fw-normal text-center"> New Tag</h1>
                    <div class="form-check mt-3">
                        <x-form.label for="tagname" class="form-label"> Name</x-form.label>
                        <x-form.input type="text" id="tagname" class="form-control" name="name" value="{{ old('name',$tag->name) }}"></x-form.input>
                    </div>
                    <div class="form-check mt-3">
                        <x-form.label for="description" class="form-label">Description</x-form.label>
                        <x-form.textarea type="text" id="description" class="form-control" name="description" rows="3">{{ old('description',$tag->description) }}</x-form.textarea>
                    </div>
                    <div class="form-check mt-3">
                        <x-form.label for="meta_title" class="form-label"> Meta title</x-form.label>
                        <x-form.input type="text" id="meta_title" class="form-control" name="meta_title" value="{{ old('meta_title',$tag->meta_title) }}"></x-form.input>
                    </div>
                    <div class="form-check mt-3">
                        <x-form.label for="meta_description" class="form-label"> Meta Description</x-form.label>
                        <x-form.textarea type="text" id="meta_description" class="form-control" name="meta_description" rows="3">{{ old('meta_description',$tag->meta_description) }}</x-form.textarea>
                    </div>

                    <x-form.button class="btn btn-primary w-100 py-2 mt-2" type="submit">Save</x-form.button>

                </form>
            </section>
        </div>

    </div>
</div>
@endsection
