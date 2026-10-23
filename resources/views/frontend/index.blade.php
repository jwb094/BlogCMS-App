@extends('layouts.frontend-default-layout')
@section('title', 'Home')

@push('styles')
    @vite('resources/css/frontend/index.css')
@endpush

@section('content')
    <div class="container py-4 py-lg-5">
        @if ($topPosts->isNotEmpty())
            <section aria-label="Top articles" class="mb-5">
                <div class="row g-3">
                    @php($topStory = $topPosts->first())
                    <div class="col-12 col-lg-9">
                        <a href="{{ route('blog.post', $topStory->id) }}" class="home-top-story d-block w-100 h-100 position-relative overflow-hidden rounded-3 text-white text-decoration-none bg-dark">
                            @if ($topStory->featured_image)
                                <img src="{{ asset('storage/'.$topStory->featured_image) }}" alt="{{ $topStory->featured_image_caption ?: $topStory->title }}" class="position-absolute top-0 start-0 w-100 h-100 object-fit-cover">
                            @endif
                            <div class="home-top-story-gradient position-absolute top-0 start-0 w-100 h-100"></div>
                            <div class="position-absolute bottom-0 start-0 p-4 p-lg-5">
                                <span class="badge bg-light text-dark mb-3">{{ $topStory->category?->name ?? 'Uncategorized' }}</span>
                                <h1 class="display-5 fw-bold">{{ $topStory->title }}</h1>
                                @if ($topStory->excerpt)
                                    <p class="lead mb-0">{{ $topStory->excerpt }}</p>
                                @endif
                            </div>
                        </a>
                    </div>

                    <div class="col-12 col-lg-3">
                        <div class="top-stories-side">
                            @foreach ($topPosts->skip(1) as $post)
                                <a href="{{ route('blog.post', $post->id) }}" class="d-block position-relative overflow-hidden rounded-3 text-white text-decoration-none bg-dark h-100">
                                    @if ($post->featured_image)
                                        <img src="{{ asset('storage/'.$post->featured_image) }}" alt="{{ $post->featured_image_caption ?: $post->title }}" class="position-absolute top-0 start-0 w-100 h-100 object-fit-cover">
                                    @endif
                                    <div class="home-side-story-gradient position-absolute top-0 start-0 w-100 h-100"></div>
                                    <div class="position-absolute bottom-0 start-0 p-3">
                                        <span class="small fw-semibold">{{ $post->category?->name ?? 'Uncategorized' }}</span>
                                        <h2 class="h5 fw-bold mb-0 mt-1">{{ $post->title }}</h2>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>
        @endif

        @foreach ($categorySections as $category)
            <section aria-labelledby="category-{{ $category->id }}-heading" class="mb-5">
                <div class="d-flex align-items-center justify-content-between border-bottom mb-4 pb-2">
                    <h2 id="category-{{ $category->id }}-heading" class="h3 fw-bold mb-0">{{ $category->name }}</h2>
                    <a href="{{ route('blog.category', $category->slug) }}" class="text-decoration-none">More {{ $category->name }} articles</a>
                </div>
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                    @foreach ($category->posts as $post)
                        <div class="col">
                            <article class="card h-100 border-0 shadow-sm overflow-hidden">
                                <a href="{{ route('blog.post', $post->id) }}" class="text-decoration-none text-dark">
                                    @if ($post->featured_image)
                                        <img src="{{ asset('storage/'.$post->featured_image) }}" alt="{{ $post->featured_image_caption ?: $post->title }}" class="home-article-image card-img-top object-fit-cover">
                                    @else
                                        <div class="home-article-image-placeholder bg-secondary-subtle"></div>
                                    @endif
                                    <div class="card-body">
                                        <h3 class="h5 fw-bold">{{ $post->title }}</h3>
                                        @if ($post->excerpt)
                                            <p class="text-body-secondary mb-0">{{ $post->excerpt }}</p>
                                        @endif
                                    </div>
                                </a>
                            </article>
                        </div>
                    @endforeach
                </div>
            </section>
        @endforeach
    </div>
@endsection
