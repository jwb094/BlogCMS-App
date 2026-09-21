<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    //
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('frontend.blog.index');
    }

     /**
     * Display the BLog Post Article.
     */
    public function blogPost($id)
    {
        return view('frontend.blog.blogPost');
    }

     /**
     * Display a listing of all blogs.
     */
    public function blog($id)
    {
        return view('frontend.blog.blog');
    }

    /**
     * Display a listing of all blogs post with a specific category.
     */
    public function category($categoryId)
    {
        return view('frontend.blog.category');
    }

     /**
     * Display a listing of all blog post with a specific tag.
     */
    public function tags()
    {
        return view('frontend.blog.tag');
    }

     public function author($authorId)
    {
        return view('frontend.blog.author');
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
