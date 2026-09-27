<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use App\Services\BlogService;
use Illuminate\Http\Request;

class MediaController extends Controller
{

    public function __construct(
        protected BlogService $blogService
    ) {}
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //$media = Media::all();
        $data = $this->blogService->mediaIndex($request);
        return view('backend.media.index', compact('data'));
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
    public function show(Media $medium)
    {
        //dd($medium);
        return view('backend.media.show',['media' => $medium]);
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
