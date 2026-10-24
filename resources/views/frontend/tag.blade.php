@extends('layouts.frontend-default-layout')
@section('title', 'Articles tagged '.$tag->name)

@section('content')
    <div class="container py-5">
        <header class="mb-4">
            <p class="text-primary fw-semibold text-uppercase small mb-2">Tag</p>
            <h1 class="display-5 fw-bold">{{ $tag->name }}</h1>
            @if ($tag->description)
                <p class="lead text-body-secondary">{{ $tag->description }}</p>
            @endif
        </header>

        @forelse ($posts as $post)
            <article class="card border-0 shadow-sm mb-4 overflow-hidden">
                <div class="row g-0">
                    <div class="col-md-4">
                        @if ($post->featured_image)
                            <img src="{{ asset('storage/'.$post->featured_image) }}" alt="{{ $post->featured_image_caption ?: $post->title }}" class="w-100 h-100 object-fit-cover" style="min-height: 13rem;">
                        @else
                            <div class="w-100 h-100 bg-secondary-subtle" style="min-height: 13rem;"></div>
                        @endif
                    </div>
                    <div class="col-md-8">
                        <div class="card-body p-4">
                            <h2 class="h3 fw-bold"><a href="{{ route('blog.post', $post->id) }}" class="text-decoration-none text-dark">{{ $post->title }}</a></h2>
                            <p class="text-body-secondary">{{ $post->excerpt }}</p>
                            <p class="small text-body-secondary mb-0">
                                By {{ $post->user?->name ?? 'Unknown author' }}
                                <span class="mx-2">·</span>
                                {{ \Illuminate\Support\Carbon::parse($post->published_at ?? $post->created_at)->format('F j, Y') }}
                            </p>
                        </div>
                    </div>
                </div>
            </article>
        @empty
            <p class="text-body-secondary">There are no published articles with this tag yet.</p>
        @endforelse

        <div class="mt-4">{{ $posts->links() }}</div>
    </div>
@endsection
