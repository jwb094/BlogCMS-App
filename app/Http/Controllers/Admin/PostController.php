<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostFormRequest;
use App\Models\Category;
use App\Models\Post;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $postsQuery = Post::with('category');

        if (auth()->user()->isAuthor()) {
            $postsQuery->where('user_id', auth()->id());
        }

        $posts = $postsQuery
            ->latest()
            ->paginate(10);

        return view('backend.posts.index', compact('posts'));
    }

    /**
     * Display soft-deleted posts.
     */
    public function bin()
    {
        $postsQuery = Post::onlyTrashed()->with('category');

        if (auth()->user()->isAuthor()) {
            $postsQuery->where('user_id', auth()->id());
        }

        $posts = $postsQuery
            ->latest('deleted_at')
            ->paginate(10);

        return view('backend.posts.bin', compact('posts'));
    }

    /**
     * Restore a post from the recycle bin.
     */
    public function restore(string $postId)
    {
        $postQuery = Post::onlyTrashed();

        if (auth()->user()->isAuthor()) {
            $postQuery->where('user_id', auth()->id());
        } else {
            abort_unless(auth()->user()->isAdmin(), 403);
        }

        $post = $postQuery->findOrFail($postId);
        $post->restore();

        return redirect()->route('admin.post.bin')
            ->with('success', 'Post restored successfully.');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get();

        return view('backend.posts.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostFormRequest $request)
    {
        $postData = $request->validated();
        $postData['user_id'] = $request->user()->id;
        $postData['published_at'] = $postData['published_at'] ?: null;
        $postData['featured_image'] = $request->file('featured_image')->store('post-featured-images', 'public');

        Post::create($postData);

        return redirect()->route('admin.post.index')
            ->with('success', 'Post created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        $this->authorizePostManagement($post);

        $categories = Category::orderBy('name')->get();

        return view('backend.posts.edit', compact('post', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostFormRequest $request, Post $post)
    {
        $this->authorizePostManagement($post);

        $postData = $request->validated();
        $postData['published_at'] = $postData['published_at'] ?: null;

        if ($request->hasFile('featured_image')) {
            $postData['featured_image'] = $request->file('featured_image')->store('post-featured-images', 'public');
        } else {
            unset($postData['featured_image']);
        }

        $post->update($postData);

        return redirect()->route('admin.post.index')
            ->with('success', 'Post updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $this->authorizePostManagement($post);

        $post->delete();

        return redirect()->route('admin.post.index')
            ->with('success', 'Post moved to the recycle bin.');
    }

    /**
     * Permanently delete a post.
     */
    public function forceDestroy(Post $post)
    {
        $this->authorizePostManagement($post);

        $post->forceDelete();

        return redirect()->route('admin.post.index')
            ->with('success', 'Post permanently deleted.');
    }

    private function authorizePostManagement(Post $post): void
    {
        $user = auth()->user();

        abort_unless(
            $user?->isAdmin() || ($user?->isAuthor() && (int) $post->user_id === (int) $user->id),
            403
        );
    }
}
