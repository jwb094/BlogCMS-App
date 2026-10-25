@extends('layouts.frontend-default-layout')
@section('title', $post->meta_title ?: $post->title)

@push('meta')
    @if ($post->meta_description)
        <meta name="description" content="{{ $post->meta_description }}">
    @endif
    <meta property="og:title" content="{{ $post->meta_title ?: $post->title }}">
    <meta property="og:description" content="{{ $post->meta_description ?: $post->excerpt }}">
    @if ($post->featured_image)
        @php($featuredImageUrl = filter_var($post->featured_image, FILTER_VALIDATE_URL) ? $post->featured_image : asset('storage/'.$post->featured_image))
        <meta property="og:image" content="{{ $featuredImageUrl }}">
    @endif
@endpush

@push('styles')
    @vite('resources/css/frontend/article.css')
@endpush

@section('content')
    <div class="container py-5">
        <nav aria-label="Breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                @if ($post->category)
                    <li class="breadcrumb-item"><a href="{{ route('blog.category', $post->category->slug) }}">{{ $post->category->name }}</a></li>
                @endif
                <li class="breadcrumb-item active" aria-current="page">{{ $post->title }}</li>
            </ol>
        </nav>

        <article>
            <header class="mx-auto mb-4 text-center article-header">
                @if ($post->category)
                    <a href="{{ route('blog.category', $post->category->slug) }}" class="badge text-bg-primary text-decoration-none mb-3">{{ $post->category->name }}</a>
                @endif
                <h1 class="display-4 fw-bold">{{ $post->title }}</h1>
                @if ($post->subheading)
                    <p class="lead text-body-secondary">{{ $post->subheading }}</p>
                @endif
                <p class="small text-body-secondary mb-0">
                    By {{ $post->user?->name ?? 'Unknown author' }}
                    <span class="mx-2">·</span>
                    <time datetime="{{ \Illuminate\Support\Carbon::parse($post->published_at ?? $post->created_at)->toIso8601String() }}">
                        {{ \Illuminate\Support\Carbon::parse($post->published_at ?? $post->created_at)->format('F j, Y') }}
                    </time>
                </p>
            </header>

            @if ($post->featured_image)
                @php($featuredImageUrl = filter_var($post->featured_image, FILTER_VALIDATE_URL) ? $post->featured_image : asset('storage/'.$post->featured_image))
                <figure class="mb-5">
                    <img src="{{ $featuredImageUrl }}" alt="{{ $post->featured_image_caption ?: $post->title }}" class="article-hero-image rounded-3">
                    @if ($post->featured_image_caption)
                        <figcaption class="small text-body-secondary text-center mt-2">{{ $post->featured_image_caption }}</figcaption>
                    @endif
                </figure>
            @endif

            <div class="row justify-content-center">
                <div class="col-lg-9 col-xl-8">
                    @if ($post->excerpt)
                        <p class="fs-5 fw-medium mb-4">{{ $post->excerpt }}</p>
                    @endif

                    <div class="article-body fs-5 lh-lg">{!! $safeContent !!}</div>

                    @if ($post->tags->isNotEmpty())
                        <div class="border-top mt-5 pt-4">
                            <span class="fw-semibold me-2">Tags:</span>
                            @foreach ($post->tags as $tag)
                                <a href="{{ route('blog.tag', $tag->slug) }}" class="badge rounded-pill text-bg-light text-decoration-none me-1 mb-1">{{ $tag->name }}</a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </article>

        <section class="row justify-content-center mt-5" aria-labelledby="comments-heading">
            <div class="col-lg-9 col-xl-8">
                @if ($post->allow_comments === 'allow')
                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 border-top pt-4">
                        <h2 id="comments-heading" class="h3 fw-bold mb-0">Comments ({{ $post->comments->count() }})</h2>
                        <button
                            class="btn btn-outline-primary comments-toggle"
                            type="button"
                            data-bs-toggle="collapse"
                            data-bs-target="#article-comments"
                            aria-expanded="false"
                            aria-controls="article-comments"
                        >
                            <span class="show-comments-label">Show comments</span>
                            <span class="hide-comments-label">Hide comments</span>
                        </button>
                    </div>
                    <div class="collapse" id="article-comments" aria-labelledby="comments-heading">
                        @forelse ($post->comments as $comment)
                            <article class="border-bottom py-3">
                                <div class="d-flex justify-content-between gap-3">
                                    <h3 class="h6 fw-bold mb-1">{{ $comment->name ?: 'Reader' }}</h3>
                                    <time class="small text-body-secondary" datetime="{{ $comment->created_at->toIso8601String() }}">{{ $comment->created_at->format('F j, Y') }}</time>
                                </div>
                                <p class="mb-0">{{ $comment->content }}</p>
                            </article>
                        @empty
                            <p class="text-body-secondary py-3">There are no comments on this article yet.</p>
                        @endforelse
                    </div>
                @else
                    <p class="text-body-secondary border-top pt-4">Comments are disabled for this article.</p>
                @endif
            </div>
        </section>

        @if ($relatedPosts->isNotEmpty())
            <section class="mt-5" aria-labelledby="related-heading">
                <h2 id="related-heading" class="h3 fw-bold border-bottom pb-2 mb-4">More in {{ $post->category?->name ?? 'the blog' }}</h2>
                <div class="row row-cols-1 row-cols-md-3 g-4">
                    @foreach ($relatedPosts as $relatedPost)
                        <div class="col">
                            <article class="card h-100 border-0 shadow-sm overflow-hidden">
                                <a href="{{ route('blog.post', $relatedPost->id) }}" class="text-decoration-none text-dark">
                                    @if ($relatedPost->featured_image)
                                        @php($relatedImageUrl = filter_var($relatedPost->featured_image, FILTER_VALIDATE_URL) ? $relatedPost->featured_image : asset('storage/'.$relatedPost->featured_image))
                                        <img src="{{ $relatedImageUrl }}" alt="{{ $relatedPost->featured_image_caption ?: $relatedPost->title }}" class="card-img-top article-related-image object-fit-cover">
                                    @else
                                        <div class="card-img-top article-related-image bg-secondary-subtle"></div>
                                    @endif
                                    <div class="card-body">
                                        <h3 class="h5 fw-bold">{{ $relatedPost->title }}</h3>
                                        <p class="text-body-secondary mb-0">{{ $relatedPost->excerpt }}</p>
                                    </div>
                                </a>
                            </article>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif
    </div>
@endsection
