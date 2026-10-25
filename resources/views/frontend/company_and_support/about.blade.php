@extends('layouts.frontend-default-layout')
@section('title', 'About Us')

@section('content')
    <div class="container py-5 my-auto">
        <header class="mb-5 text-center">
            <p class="text-primary fw-semibold text-uppercase small mb-2">About {{ config('app.name') }}</p>
            <h1 class="display-5 fw-bold">Stories, ideas, and useful perspectives</h1>
            <p class="lead text-body-secondary col-lg-9 mx-auto mb-0">
                {{ config('app.name') }} is a place to publish and discover articles across a range of topics.
                We bring readers and writers together through thoughtful stories and clear, useful information.
            </p>
        </header>

        <div class="row g-4 justify-content-center">
            <section class="col-md-4">
                <div class="h-100 p-4 bg-white rounded-3 shadow-sm text-center">
                    <h2 class="h4 fw-bold">For readers</h2>
                    <p class="text-body-secondary mb-0">Browse the latest articles, explore topics by category, and follow the ideas that matter to you.</p>
                </div>
            </section>
            <section class="col-md-4">
                <div class="h-100 p-4 bg-white rounded-3 shadow-sm text-center">
                    <h2 class="h4 fw-bold">For writers</h2>
                    <p class="text-body-secondary mb-0">Authors can create and manage posts, add images, and share their work with the community.</p>
                </div>
            </section>
            <section class="col-md-4">
                <div class="h-100 p-4 bg-white rounded-3 shadow-sm text-center">
                    <h2 class="h4 fw-bold">Our approach</h2>
                    <p class="text-body-secondary mb-0">We aim to make publishing straightforward and keep the reading experience focused on the articles.</p>
                </div>
            </section>
        </div>

        <div class="mt-5 d-flex justify-content-center">
            <a href="{{ route('blog.archive') }}" class="btn btn-primary">Browse articles</a>
            <a href="{{ route('pages.contact') }}" class="btn btn-outline-secondary ms-2">Get in touch</a>
        </div>
    </div>
@endsection
