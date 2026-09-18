@extends('layouts.frontend-default-layout')
@section('title','Home')
@section('content')


<div class="container">
    <!-- Content here -->

    <div class="container text-center">
                    <h1>GGG</h1>
        <div class="row align-items-start">
            <div class="col-12 col-md-12">
    

            </div>
            <div class="col-12 col-md-12">
                <x-frontend.topstorycard></x-frontend.topstorycard>
            </div>
            <div class="col-12 col-md-4">
                <x-frontend.top-block-card></x-frontend.top-block-card>
            </div>
 <div class="col-12 col-md-4">
                   <x-frontend.top-block-card></x-frontend.top-block-card>
            </div>
             <div class="col-12 col-md-4">
                            <x-frontend.top-block-card></x-frontend.top-block-card>
            </div>
        </div>
    </div>
</div>

@endsection
