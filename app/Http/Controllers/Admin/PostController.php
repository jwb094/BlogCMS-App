<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostFormRequest;
use App\Models\Post;
use App\Services\AdminService;

class PostController extends Controller
{
    /** Display a listing of the resource. */
    public function index(AdminService $adminService)
    {
        $posts = $adminService->postsIndex(auth()->user());

        return view('backend.posts.index', compact('posts'));
    }

    /** Display soft-deleted posts. */
    public function bin(AdminService $adminService)
    {
        $posts = $adminService->postsBin(auth()->user());

        return view('backend.posts.bin', compact('posts'));
    }

    /** Restore a post from the recycle bin. */
    public function restore(AdminService $adminService, string $postId)
    {
        $adminService->restorePost($postId, auth()->user());

        return redirect()->route('admin.post.bin')
            ->with('success', 'Post restored successfully.');
    }

    /** Show the form for creating a new resource. */
    public function create(AdminService $adminService)
    {
        $formData = $adminService->postFormData(auth()->user());

        return view('backend.posts.create', $formData);
    }

    /** Store a newly created resource in storage. */
    public function store(AdminService $adminService, PostFormRequest $request)
    {
        $adminService->createPost(
            $request->user(),
            $request->validated(),
            $request->file('featured_image_upload')
        );

        return redirect()->route('admin.post.index')
            ->with('success', 'Post created successfully.');
    }

    /** Display the specified resource. */
    public function show(string $id)
    {
        //
    }

    /** Show the form for editing the specified resource. */
    public function edit(AdminService $adminService, Post $post)
    {
        $post = $adminService->postForEditing($post, auth()->user());
        $formData = $adminService->postFormData(auth()->user());

        return view('backend.posts.edit', compact('post') + $formData);
    }

    /** Update the specified resource in storage. */
    public function update(AdminService $adminService, PostFormRequest $request, Post $post)
    {
        $adminService->updatePost(
            $post,
            $request->user(),
            $request->validated(),
            $request->file('featured_image_upload')
        );

        return redirect()->route('admin.post.index')
            ->with('success', 'Post updated successfully.');
    }

    /** Move the specified resource to the recycle bin. */
    public function destroy(AdminService $adminService, Post $post)
    {
        $adminService->deletePost($post, auth()->user());

        return redirect()->route('admin.post.index')
            ->with('success', 'Post moved to the recycle bin.');
    }

    /** Permanently delete a post. */
    public function forceDestroy(AdminService $adminService, Post $post)
    {
        $adminService->forceDeletePost($post, auth()->user());

        return redirect()->route('admin.post.index')
            ->with('success', 'Post permanently deleted.');
    }
}
