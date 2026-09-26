<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TagFormRequest;
use App\Models\Tag;
use App\Services\BlogService;
use Illuminate\Http\Request;

class TagController extends Controller
{
    //protected BlogService $blogService;
    public function __construct(
        protected BlogService $blogService
    ) {}


    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = $this->blogService->Index($request);
        return view('backend.tags.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.tags.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TagFormRequest $request)
    {
        //
        $newTag = $this->blogService->newTag($request->validated());

        if (!$newTag->id) {
            return  redirect(route('admin.tags.create'))
                ->withInput()
                ->with('status', false)->with('message', "New Tag didn't save, try again please");;
        }
        return  redirect(route('admin.tags.index'))
            ->with('status', true)
            ->with('message', "New Tag added ");
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
    public function edit(Tag $tag)
    {

        return view('backend.tags.edit', [
            "tag" => $tag
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TagFormRequest $request, Tag $tag)
    {
        //
        $this->blogService->updateTag($request->validated(), $tag->id);

        return redirect()->route('admin.tags.index')
            ->with('success', "Tag was updated");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tag $tag)
    {
        //
        $tag->delete();
        return redirect(route('admin.tags.index'))
        ->with('Status', "Tag Record was delete");
    }
}
