<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostFormRequest;
use App\Models\Category;
use App\Models\Media;
use App\Models\Post;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $postsQuery = Post::with(['category', 'user']);

        if (auth()->user()->isAuthor()) {
            $postsQuery->where('user_id', auth()->id());
        }

        $posts = $postsQuery
            ->latest()
            ->paginate(10);

        return view('backend.posts.index', compact('posts'));
    }

    /**
     * Display soft-deleted posts.
     */
    public function bin()
    {
        $postsQuery = Post::onlyTrashed()->with('category');

        if (auth()->user()->isAuthor()) {
            $postsQuery->where('user_id', auth()->id());
        }

        $posts = $postsQuery
            ->latest('deleted_at')
            ->paginate(10);

        return view('backend.posts.bin', compact('posts'));
    }

    /**
     * Restore a post from the recycle bin.
     */
    public function restore(string $postId)
    {
        $postQuery = Post::onlyTrashed();

        if (auth()->user()->isAuthor()) {
            $postQuery->where('user_id', auth()->id());
        } else {
            abort_unless(auth()->user()->isAdmin(), 403);
        }

        $post = $postQuery->findOrFail($postId);
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
        $featuredImages = $this->featuredImagesForCurrentUser();

        return view('backend.posts.create', compact('categories', 'featuredImages'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostFormRequest $request)
    {
        $postData = $request->validated();
        $postData['user_id'] = $request->user()->id;
        $postData['published_at'] = $postData['published_at'] ?: null;
        $postData['featured_image'] = $request->hasFile('featured_image_upload')
            ? $this->storeFeaturedImage($request->file('featured_image_upload'), $request->user()->id)
            : $postData['featured_image'];
        unset($postData['featured_image_upload']);

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
        $this->authorizePostManagement($post);

        $categories = Category::orderBy('name')->get();
        $featuredImages = $this->featuredImagesForCurrentUser();

        return view('backend.posts.edit', compact('post', 'categories', 'featuredImages'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostFormRequest $request, Post $post)
    {
        $this->authorizePostManagement($post);

        $postData = $request->validated();
        $postData['published_at'] = $postData['published_at'] ?: null;

        if ($request->hasFile('featured_image_upload')) {
            $postData['featured_image'] = $this->storeFeaturedImage($request->file('featured_image_upload'), $request->user()->id);
        }
        unset($postData['featured_image_upload']);

        $post->update($postData);

        return redirect()->route('admin.post.index')
            ->with('success', 'Post updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $this->authorizePostManagement($post);

        $post->delete();

        return redirect()->route('admin.post.index')
            ->with('success', 'Post moved to the recycle bin.');
    }

    /**
     * Permanently delete a post.
     */
    public function forceDestroy(Post $post)
    {
        $this->authorizePostManagement($post);

        $post->forceDelete();

        return redirect()->route('admin.post.index')
            ->with('success', 'Post permanently deleted.');
    }

    private function authorizePostManagement(Post $post): void
    {
        $user = auth()->user();

        abort_unless(
            $user?->isAdmin() || ($user?->isAuthor() && (int) $post->user_id === (int) $user->id),
            403
        );
    }

    /**
     * Get image paths owned by the signed-in user that still exist on disk.
     *
     * @return array<int, string>
     */
    private function featuredImagesForCurrentUser(): array
    {
        $userId = auth()->id();
        $imagePaths = Media::query()
            ->where('user_id', $userId)
            ->where('path', 'like', 'post-featured-images/%')
            ->pluck('path')
            ->merge(
                Post::withTrashed()
                    ->where('user_id', $userId)
                    ->where('featured_image', 'like', 'post-featured-images/%')
                    ->pluck('featured_image')
            );

        return $imagePaths
            ->unique()
            ->filter(fn (string $path): bool => Storage::disk('public')->exists($path))
            ->values()
            ->all();
    }

    private function storeFeaturedImage(UploadedFile $image, int $userId): string
    {
        $path = $image->store('post-featured-images', 'public');

        if ($path === false) {
            abort(500, 'The featured image could not be saved.');
        }

        $dimensions = $image->dimensions() ?: [0, 0];

        Media::create([
            'filename' => mb_substr($image->getClientOriginalName(), 0, 255),
            'path' => $path,
            'mime_type' => $image->getMimeType() ?? 'application/octet-stream',
            'file_size' => (string) $image->getSize(),
            'width' => (string) $dimensions[0],
            'height' => (string) $dimensions[1],
            'user_id' => $userId,
        ]);

        return $path;
    }
}
