<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentFormRequest;
use App\Models\Comment;
use App\Services\BlogService;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $comments = Comment::query()
            ->orderBy('created_by', 'ASC')
            ->latest()
            ->paginate(9);
        return view('backend.comments.index', compact('comments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {}

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
    public function edit(Comment $comment)
    {
        return view('backend.comments.edit', compact('comment'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BlogService $blogService, CommentFormRequest $request, Comment $comment)
    {
        //
        $blogService->updateCommentStatus($request->validated(), $comment->id);

        return redirect()->route('admin.comments.index')
            ->with('success', "Comment Status was updated");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();
        return redirect(route('admin.comments.index'))
            ->with('Status', "Tag Record was delete");
    }
}
