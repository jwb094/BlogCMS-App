@extends('layouts.backend-layout')
@section('title','Media - Index')
@section('content')
<div class="container-fluid | mt-5">
    {{-- <div class="row | mt-5">
        <form action={{ route('admin.media.index') }} method="GET">

    <div class="row my-5">
        <div class="col-xs-12 col-md-2 mb-3">
            <x-form.input type="text" id="name" class="form-control" name="name"></x-form.input>
        </div>
        <div class="col-12 col-md-3 mb-3 | form-check">
            <button type="submit" class="btn btn-primary mt-6 | text-white bg-blue-500 hover:bg-blue-800 focus:ring-4 focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5">
                Search
            </button>

        </div>
        <div class="col-12 col-md-3 mb-3 | form-check">
            <a class="btn btn-secondary" href={{ route('admin.media.index') }}> Reset</a>
        </div>
    </div>

    </form>
</div> --}}
<div class="row | mt-5 | align-items-center">
    @foreach($data['media'] as $key => $value)
    <div class="col-12 col-md-4">
        <a href={{ route('admin.media.show', ['medium' => $value->id]) }}>
            <figure class="figure">
                <img src="{{ asset('storage/' . $value->path) }}" 
                alt="{{ $value->filename }}" 
                class="img-thumbnail figure-img img-fluid rounded" 
                alt="A generic square placeholder image with rounded corners in a figure.">
                <figcaption class="figure-caption">{{ $value->filename }}</figcaption>
            </figure>
        </a>
    </div>
    @endforeach
</div>

<div class="d-flex justify-content-center mt-4">
    {{ $data['media']->links() }}
</div>
</div>
@endsection
