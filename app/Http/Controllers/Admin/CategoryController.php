<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryFormRequest;
use App\Models\Category;
use App\Services\BlogService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct(
        protected BlogService $blogService
    ) {}
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = $this->blogService->categoryIndex($request);
        return view('backend.category.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryFormRequest $request)
    {
        $newCategory = $this->blogService->newCategory($request->validated());


        if (!$newCategory->id) {
            return  redirect(route('admin.category.create'))
                ->withInput()
                ->with('status', false)->with('message', "New Tag didn't save, try again please");;
        }
        return redirect()->route('admin.category.index')
            ->with('success', "Tag was updated");
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
    public function edit(Category $category)
    {
        return view('backend.category.edit', [
            "category" => $category
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryFormRequest $request, Category $category)
    {
        $this->blogService->updateCategory($request->validated(), $category->id);

        return redirect()->route('admin.category.index')
            ->with('success', "Tag was updated");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect(route('admin.category.index'))
            ->with('Status', "Tag Record was delete");
    }
}
