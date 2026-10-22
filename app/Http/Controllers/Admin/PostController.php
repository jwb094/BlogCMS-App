<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

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
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //

        return view('backend.posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    public function edit(string $id)
    {
        return view('backend.posts.edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
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
