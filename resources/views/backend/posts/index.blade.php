<div>
    <!-- The whole future lies in uncertainty: live immediately. - Seneca -->
</div>
@extends('layouts.backend-layout')
@section('title','Post - Dashboard')
@section('content')
<div class="container-fluid mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Posts</h1>
        @if (auth()->user()->isAuthor())
            <a href="{{ route('admin.post.create') }}" class="btn btn-primary">New Post</a>
        @endif
    </div>

    @if (session('success'))
        <div class="alert alert-success" role="status">{{ session('success') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table table-striped align-middle">
            <thead class="table-dark">
                <tr>
                    <th scope="col">Title</th>
                    <th scope="col">Category</th>
                    @if (auth()->user()->isAdmin())
                        <th scope="col">Author</th>
                    @endif
                    <th scope="col">Date</th>
                    <th scope="col">Comments</th>
                    @if (auth()->user()->isAdmin() || auth()->user()->isAuthor())
                        <th scope="col">Actions</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse ($posts as $post)
                    <tr>
                        <td>{{ $post->title }}</td>
                        <td>{{ $post->category?->name ?? 'Uncategorized' }}</td>
                        @if (auth()->user()->isAdmin())
                            <td>{{ $post->user?->name ?? 'Unknown' }}</td>
                        @endif
                        <td>{{ $post->created_at?->format('d M Y') ?? '—' }}</td>
                        <td>{{ $post->allow_comments === 'allow' ? 'Enabled' : 'Disabled' }}</td>
                        @if (auth()->user()->isAdmin() || auth()->user()->isAuthor())
                            <td>
                                <div class="d-flex flex-nowrap align-items-center gap-2">
                                    @if (auth()->user()->isAuthor())
                                        <a href="{{ route('admin.post.edit', $post) }}" class="btn btn-primary btn-sm text-nowrap">Edit</a>
                                        <a href="{{ route('blog.post', $post->id) }}" class="btn btn-secondary btn-sm text-nowrap" target="_blank" rel="noopener">Preview</a>
                                    @endif
                                    <form action="{{ route('admin.post.destroy', $post) }}" method="POST" class="mb-0 flex-shrink-0">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-warning btn-sm" onclick="return confirm('Move this post to the recycle bin?')">
                                            Recycle bin
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.post.force-destroy', $post) }}" method="POST" class="mb-0 flex-shrink-0">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Permanently delete this post? This cannot be undone.')">
                                            Delete permanently
                                        </button>
                                    </form>
                                </div>
                            </td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ (auth()->user()->isAdmin() ? 5 : 4) + (auth()->user()->isAdmin() || auth()->user()->isAuthor() ? 1 : 0) }}" class="text-center py-4">No posts found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $posts->links() }}
    </div>
</div>
@endsection
