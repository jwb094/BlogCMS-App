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
        $posts = Post::with('category')
            ->latest()
            ->paginate(10);

        return view('backend.posts.index', compact('posts'));
    }

    /**
     * Display soft-deleted posts.
     */
    public function bin()
    {
        $posts = Post::onlyTrashed()
            ->with('category')
            ->latest('deleted_at')
            ->paginate(10);

        return view('backend.posts.bin', compact('posts'));
    }

    /**
     * Restore a post from the recycle bin.
     */
    public function restore(string $postId)
    {
        abort_unless(auth()->user()?->isAdmin() || auth()->user()?->isAuthor(), 403);

        $post = Post::onlyTrashed()->findOrFail($postId);
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
        $categories = Category::orderBy('name')->get();

        return view('backend.posts.edit', compact('post', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostFormRequest $request, Post $post)
    {
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
        abort_unless(auth()->user()?->isAdmin() || auth()->user()?->isAuthor(), 403);

        $post->delete();

        return redirect()->route('admin.post.index')
            ->with('success', 'Post moved to the recycle bin.');
    }

    /**
     * Permanently delete a post.
     */
    public function forceDestroy(Post $post)
    {
        abort_unless(auth()->user()?->isAdmin() || auth()->user()?->isAuthor(), 403);

        $post->forceDelete();

        return redirect()->route('admin.post.index')
            ->with('success', 'Post permanently deleted.');
    }
}
