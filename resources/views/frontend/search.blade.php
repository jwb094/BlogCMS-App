@extends('layouts.frontend-default-layout')
@section('title', 'Search Articles')

@section('content')
    <div class="container py-5">
        <header class="mb-4">
            <p class="text-primary fw-semibold text-uppercase small mb-2">Discover</p>
            <h1 class="display-5 fw-bold">Search articles</h1>
            <p class="lead text-body-secondary">Find articles by title, summary, or article content.</p>
        </header>

        <form action="{{ route('blog.search') }}" method="GET" role="search" class="mb-5">
            <label for="search-query" class="form-label fw-semibold">What are you looking for?</label>
            <div class="input-group input-group-lg">
                <input
                    id="search-query"
                    type="search"
                    name="q"
                    value="{{ $searchTerm }}"
                    class="form-control"
                    placeholder="Search articles"
                    maxlength="255"
                    aria-describedby="search-button"
                >
                <button id="search-button" class="btn btn-primary" type="submit">Search</button>
            </div>
        </form>

        @if ($searchTerm === '')
            <p class="text-body-secondary">Enter a search term to find published articles.</p>
        @elseif ($posts->total() > 0)
            <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-4">
                <h2 class="h4 fw-bold mb-0">Search results</h2>
                <span class="text-body-secondary">{{ $posts->total() }} {{ \Illuminate\Support\Str::plural('article', $posts->total()) }}</span>
            </div>

            @foreach ($posts as $post)
                <article class="card border-0 shadow-sm mb-4 overflow-hidden">
                    <div class="row g-0">
                        <div class="col-md-4">
                            @if ($post->featured_image)
                                @php($thumbnailUrl = filter_var($post->featured_image, FILTER_VALIDATE_URL) ? $post->featured_image : asset('storage/'.$post->featured_image))
                                <img src="{{ $thumbnailUrl }}" alt="{{ $post->featured_image_caption ?: $post->title }}" class="w-100 h-100 object-fit-cover" style="min-height: 13rem;">
                            @else
                                <div class="w-100 h-100 bg-secondary-subtle" style="min-height: 13rem;"></div>
                            @endif
                        </div>
                        <div class="col-md-8">
                            <div class="card-body p-4">
                                <p class="small text-primary fw-semibold text-uppercase mb-2">{{ $post->category?->name ?? 'Uncategorized' }}</p>
                                <h3 class="h4 fw-bold"><a href="{{ route('blog.post', $post->id) }}" class="text-decoration-none text-dark">{{ $post->title }}</a></h3>
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
            @endforeach

            <div class="mt-4">{{ $posts->links() }}</div>
        @else
            <div class="p-4 bg-white rounded-3 shadow-sm">
                <h2 class="h4 fw-bold">No articles found</h2>
                <p class="text-body-secondary mb-0">Try a different title, topic, or keyword.</p>
            </div>
        @endif
    </div>
@endsection
