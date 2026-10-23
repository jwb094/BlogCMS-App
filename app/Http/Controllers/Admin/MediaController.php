<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $mediaQuery = Media::query();

        if (! auth()->user()->isAdmin()) {
            $mediaQuery->where('user_id', auth()->id());
        }

        if ($request->filled('name')) {
            $mediaQuery->where('filename', 'LIKE', '%'.$request->input('name').'%');
        }

        $data = [
            'media' => $mediaQuery
                ->orderBy('filename', 'ASC')
                ->latest()
                ->paginate(9)
                ->withQueryString(),
        ];

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
        abort_unless(
            auth()->user()?->isAdmin() || (int) $medium->user_id === (int) auth()->id(),
            403
        );

        $medium->loadMissing('user');

        // dd($medium);
        return view('backend.media.show', ['media' => $medium]);
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
