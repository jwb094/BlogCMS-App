<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Services\PublicBlogService;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    //
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('frontend.index');
    }

    /**
     * Display the BLog Post Article.
     */
    public function blogPost(PublicBlogService $blogService, string $id)
    {
        return view('frontend.blogPost', $blogService->article($id));
    }

    public function storeComment(Request $request, PublicBlogService $blogService, string $id)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email:rfc', 'max:255'],
            'content' => ['required', 'string', 'min:3', 'max:5000'],
        ]);

        if ($request->filled('website')) {
            return response()->json([
                'message' => 'Your comment has been submitted and is awaiting moderation.',
            ], 202);
        }

        $blogService->addComment($id, $validated, $request->user(), (string) $request->ip());

        return response()->json([
            'message' => 'Your comment has been submitted and is awaiting moderation.',
        ], 201);
    }

    /**
     * Display a listing of all blogs.
     */
    public function blog($id)
    {
        return view('frontend.blog');
    }

    /**
     * Display a listing of all blogs post with a specific category.
     */
    public function categories(PublicBlogService $blogService)
    {
        return view('frontend.category', [
            'categories' => $blogService->categoriesIndex(),
        ]);
    }

    public function category(PublicBlogService $blogService, string $slug)
    {
        return view('frontend.category-detail', $blogService->categoryArticles($slug));
    }

    /**
     * Display a listing of all blog post with a specific tag.
     */
    public function tag(PublicBlogService $blogService, string $slug)
    {
        return view('frontend.tag', $blogService->tagArticles($slug));
    }

    public function author($authorId)
    {
        return view('frontend.author');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
        //
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
    public function destroy(string $id)
    {
        //
    }
}
