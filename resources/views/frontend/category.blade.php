@extends('layouts.frontend-default-layout')
@section('title', 'Categories')

@section('content')
    <div class="container py-5">
        <header class="mb-4">
            <p class="text-primary fw-semibold text-uppercase small mb-2">Explore</p>
            <h1 class="display-5 fw-bold">Categories</h1>
            <p class="lead text-body-secondary">Browse articles by topic.</p>
        </header>

        @if ($categories->isNotEmpty())
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                @foreach ($categories as $category)
                    <div class="col">
                        <a href="{{ route('blog.category', $category->slug) }}" class="text-decoration-none text-reset">
                            <article class="card h-100 border-0 shadow-sm">
                                <div class="card-body p-4">
                                    <h2 class="h4 fw-bold">{{ $category->name }}</h2>
                                    <p class="text-body-secondary mb-0">{{ $category->description ?: 'Explore the latest articles in this category.' }}</p>
                                </div>
                            </article>
                        </a>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-body-secondary">There are no categories to show yet.</p>
        @endif
    </div>
@endsection
