@extends('layouts.backend-layout')
@section('title', 'Post - Edit Post')
@section('content')
<div class="container-fluid mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Edit Blog Post</h1>
        <a href="{{ route('admin.post.index') }}" class="btn btn-secondary">Back to Posts</a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger" role="alert">Please correct the highlighted fields and try again.</div>
    @endif

    <form action="{{ route('admin.post.update', $post) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <ul class="nav nav-tabs mb-4" id="postFormTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="content-tab" data-bs-toggle="tab" data-bs-target="#content-panel" type="button" role="tab" aria-controls="content-panel" aria-selected="true">Content</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="settings-tab" data-bs-toggle="tab" data-bs-target="#settings-panel" type="button" role="tab" aria-controls="settings-panel" aria-selected="false">Publishing &amp; SEO</button>
            </li>
        </ul>

        <div class="tab-content" id="postFormTabContent">
            <section class="tab-pane fade show active" id="content-panel" role="tabpanel" aria-labelledby="content-tab" tabindex="0">
                <div class="row">
                    <div class="col-md-8 mb-3">
                        <x-form.label for="title" class="form-label">Title</x-form.label>
                        <x-form.input id="title" name="title" type="text" class="form-control" value="{{ old('title', $post->title) }}" required />
                        @error('title') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <x-form.label for="slug" class="form-label">Slug</x-form.label>
                        <x-form.input id="slug" name="slug" type="text" class="form-control" value="{{ old('slug', $post->slug) }}" required />
                        @error('slug') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-12 mb-3">
                        <x-form.label for="subheading" class="form-label">Subheading</x-form.label>
                        <x-form.textarea id="subheading" name="subheading" class="form-control" rows="2" required>{{ old('subheading', $post->subheading) }}</x-form.textarea>
                        @error('subheading') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-8 mb-3">
                        <x-form.label for="excerpt" class="form-label">Excerpt</x-form.label>
                        <x-form.textarea id="excerpt" name="excerpt" class="form-control" rows="3" required>{{ old('excerpt', $post->excerpt) }}</x-form.textarea>
                        @error('excerpt') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <x-form.label for="category_id" class="form-label">Category</x-form.label>
                        <select id="category_id" name="category_id" class="form-select" required>
                            <option value="">Select a category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @selected(old('category_id', $post->category_id) == $category->id)>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-8 mb-3">
                        @include('backend.posts.partials.featured-image-gallery', ['selectedImage' => old('featured_image', $post->featured_image)])
                    </div>
                    <div class="col-md-4 mb-3">
                        <x-form.label for="featured_image_caption" class="form-label">Image Caption</x-form.label>
                        <x-form.input id="featured_image_caption" name="featured_image_caption" type="text" class="form-control" value="{{ old('featured_image_caption', $post->featured_image_caption) }}" required />
                        @error('featured_image_caption') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-12 mb-3">
                        <x-form.label for="content" class="form-label">Post Content</x-form.label>
                        <x-form.textarea id="content" name="content" class="form-control" rows="12" required>{{ old('content', $post->content) }}</x-form.textarea>
                        @error('content') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>
                </div>
            </section>

            <section class="tab-pane fade" id="settings-panel" role="tabpanel" aria-labelledby="settings-tab" tabindex="0">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <x-form.label for="status" class="form-label">Status</x-form.label>
                        <select id="status" name="status" class="form-select" required>
                            <option value="draft" @selected(old('status', $post->status) === 'draft')>Draft</option>
                            <option value="live" @selected(old('status', $post->status) === 'live')>Live</option>
                            <option value="scheduled" @selected(old('status', $post->status) === 'scheduled')>Scheduled</option>
                        </select>
                        @error('status') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <x-form.label for="allow_comments" class="form-label">Comments</x-form.label>
                        <select id="allow_comments" name="allow_comments" class="form-select" required>
                            <option value="allow" @selected(old('allow_comments', $post->allow_comments) === 'allow')>Enabled</option>
                            <option value="forbidden" @selected(old('allow_comments', $post->allow_comments) === 'forbidden')>Disabled</option>
                        </select>
                        @error('allow_comments') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <x-form.label for="published_at" class="form-label">Publish Date</x-form.label>
                        <x-form.input id="published_at" name="published_at" type="datetime-local" class="form-control" value="{{ old('published_at', $post->published_at ? \Illuminate\Support\Carbon::parse($post->published_at)->format('Y-m-d\TH:i') : '') }}" />
                        @error('published_at') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-12"><hr><h2 class="h5">Search Engine Details</h2></div>
                    <div class="col-md-6 mb-3">
                        <x-form.label for="meta_title" class="form-label">Meta Title</x-form.label>
                        <x-form.input id="meta_title" name="meta_title" type="text" class="form-control" value="{{ old('meta_title', $post->meta_title) }}" required />
                        @error('meta_title') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <x-form.label for="meta_description" class="form-label">Meta Description</x-form.label>
                        <x-form.input id="meta_description" name="meta_description" type="text" class="form-control" value="{{ old('meta_description', $post->meta_description) }}" required />
                        @error('meta_description') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>
                </div>
            </section>
        </div>

        <div class="mt-4">
            <x-form.button type="submit" class="btn btn-primary">Save Changes</x-form.button>
            <a href="{{ route('admin.post.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </div>
    </form>
</div>
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const titleInput = document.getElementById('title');
        const slugInput = document.getElementById('slug');
        let slugWasEdited = false;

        slugInput.addEventListener('input', () => {
            slugWasEdited = true;
        });

        titleInput.addEventListener('input', () => {
            if (slugWasEdited) {
                return;
            }

            slugInput.value = titleInput.value
                .toLowerCase()
                .trim()
                .replace(/[^a-z0-9]+/g, '-')
                .replace(/^-|-$/g, '');
        });
    });
</script>
@endpush
@endsection
