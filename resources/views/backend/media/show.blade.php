<div>
    <!-- Nothing worth having comes easy. - Theodore Roosevelt -->
</div>
@extends('layouts.backend-layout')
@section('title','Media - Show')
@section('content')
<div class="container text-center">
    <div class="row text-center my-5">
        <h1>Details</h1>
    </div>
    <div class="row">
        <div class="col-12 col-md-6">
            <figure class="figure">
                <img src="https://placehold.co/300x300" class=" figure-img img-fluid rounded" alt="A generic square placeholder image with rounded corners in a figure.">
                <figcaption class="figure-caption">{{ $media->filename }}</figcaption>
            </figure>
        </div>
        <div class="col-12 col-md-6">
 
            <ul class="list-group text-start ">
                <li class="list-group-item">Filename :{{ $media->filename }}</li>
                <li class="list-group-item">Size : {{ $media->file_size }}</li>
                <li class="list-group-item">Width : {{ $media->width }}</li>
                <li class="list-group-item">Height : {{ $media->height }}</li>
                <li class="list-group-item">Date Uploaded : {{ $media->created_at->format('d.m.Y') }}</li>
            </ul>
        </div>
    </div>

</div>
@endsection
