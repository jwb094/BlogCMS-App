<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Media;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class AdminService
{
    /**
     * Gather dashboard statistics for the signed-in user.
     *
     * @return array{
     *     globalStats: array{users: int, posts: int, categories: int, comments: int, tags: int}|null,
     *     monthlyPosts: array<int, array{label: string, count: int}>,
     *     authorMonthlyPosts: array<int, array{label: string, count: int}>,
     *     personalStats: array{posts: int, comments: int, pendingComments: int, media: int},
     *     popularCategories: EloquentCollection<int, Category>
     * }
     */
    public function dashboardData(User $user): array
    {
        $userPosts = Post::where('user_id', $user->id);
        $userComments = Comment::whereHas('post', function ($query) use ($user): void {
            $query->where('user_id', $user->id);
        });

        $personalStats = [
            'posts' => (clone $userPosts)->count(),
            'comments' => (clone $userComments)->count(),
            'pendingComments' => (clone $userComments)->where('status', 'pending')->count(),
            'media' => Media::where('user_id', $user->id)->count(),
        ];

        $globalStats = null;
        $monthlyPosts = [];
        $authorMonthlyPosts = [];
        $popularCategories = new EloquentCollection;

        if ($user->isAuthor() || $user->isAdmin()) {
            $months = $this->lastThreeMonths();
            $quarterStart = $months->first();
            $quarterEnd = $months->last()->copy()->endOfMonth();

            if ($user->isAuthor()) {
                $authorMonthlyPosts = $this->postsByMonth($months, $quarterStart, $quarterEnd, $user->id);
            }

            if ($user->isAdmin()) {
                $globalStats = [
                    'users' => User::count(),
                    'posts' => Post::count(),
                    'categories' => Category::count(),
                    'comments' => Comment::count(),
                    'tags' => Tag::count(),
                ];
                $monthlyPosts = $this->postsByMonth($months, $quarterStart, $quarterEnd);

                $postsInQuarter = function ($query) use ($quarterStart, $quarterEnd): void {
                    $query->whereBetween('posts.created_at', [$quarterStart, $quarterEnd]);
                };

                $popularCategories = Category::query()
                    ->whereHas('posts', $postsInQuarter)
                    ->withCount(['posts' => $postsInQuarter])
                    ->orderByDesc('posts_count')
                    ->orderBy('name')
                    ->limit(3)
                    ->get();
            }
        }

        return compact('globalStats', 'monthlyPosts', 'authorMonthlyPosts', 'personalStats', 'popularCategories');
    }

    // Comments

    public function commentsIndex(User $user): LengthAwarePaginator
    {
        $commentsQuery = Comment::with(['post.user']);

        if (! $user->isAdmin()) {
            $commentsQuery->whereHas('post', function ($query) use ($user): void {
                $query->where('user_id', $user->id);
            });
        }

        return $commentsQuery
            ->latest('created_at')
            ->paginate(9);
    }

    /**
     * Update a comment's moderation status.
     *
     * @param  array<string, mixed>  $updatedCommentData
     */
    public function updateCommentStatus(Comment $comment, array $updatedCommentData): Comment
    {
        $comment->update($updatedCommentData);

        return $comment->refresh();
    }

    public function deleteComment(Comment $comment): void
    {
        $comment->delete();
    }

    // Media

    public function mediaIndex(User $user, ?string $filename = null): LengthAwarePaginator
    {
        $mediaQuery = Media::query();

        if (! $user->isAdmin()) {
            $mediaQuery->where('user_id', $user->id);
        }

        if ($filename !== null && $filename !== '') {
            $mediaQuery->where('filename', 'LIKE', '%'.$filename.'%');
        }

        return $mediaQuery
            ->latest('created_at')
            ->paginate(9)
            ->withQueryString();
    }

    public function mediaDetails(Media $medium, User $user): Media
    {
        abort_unless($user->isAdmin() || (int) $medium->user_id === (int) $user->id, 403);

        return $medium->loadMissing('user');
    }

    // Posts

    public function postsIndex(User $user): LengthAwarePaginator
    {
        $postsQuery = Post::with(['category', 'user']);

        if ($user->isAuthor()) {
            $postsQuery->where('user_id', $user->id);
        }

        return $postsQuery->latest()->paginate(10);
    }

    public function postsBin(User $user): LengthAwarePaginator
    {
        $postsQuery = Post::onlyTrashed()->with('category');

        if ($user->isAuthor()) {
            $postsQuery->where('user_id', $user->id);
        }

        return $postsQuery->latest('deleted_at')->paginate(10);
    }

    /** @return array{categories: EloquentCollection<int, Category>, featuredImages: array<int, string>} */
    public function postFormData(User $user): array
    {
        return [
            'categories' => Category::orderBy('name')->get(),
            'featuredImages' => $this->featuredImagesForUser($user),
        ];
    }

    /** @param array<string, mixed> $postData */
    public function createPost(User $user, array $postData, ?UploadedFile $featuredImageUpload = null): Post
    {
        $postData['user_id'] = $user->id;
        $postData['published_at'] = $postData['published_at'] ?: null;
        $postData['featured_image'] = $featuredImageUpload !== null
            ? $this->storeFeaturedImage($featuredImageUpload, $user->id)
            : $postData['featured_image'];
        unset($postData['featured_image_upload']);

        return Post::create($postData);
    }

    public function postForEditing(Post $post, User $user): Post
    {
        $this->authorizePostManagement($post, $user);

        return $post;
    }

    /** @param array<string, mixed> $postData */
    public function updatePost(Post $post, User $user, array $postData, ?UploadedFile $featuredImageUpload = null): Post
    {
        $this->authorizePostManagement($post, $user);

        $postData['published_at'] = $postData['published_at'] ?: null;

        if ($featuredImageUpload !== null) {
            $postData['featured_image'] = $this->storeFeaturedImage($featuredImageUpload, $user->id);
        }
        unset($postData['featured_image_upload']);

        $post->update($postData);

        return $post->refresh();
    }

    public function restorePost(string $postId, User $user): void
    {
        $postQuery = Post::onlyTrashed();

        if ($user->isAuthor()) {
            $postQuery->where('user_id', $user->id);
        } else {
            abort_unless($user->isAdmin(), 403);
        }

        $postQuery->findOrFail($postId)->restore();
    }

    public function deletePost(Post $post, User $user): void
    {
        $this->authorizePostManagement($post, $user);
        $post->delete();
    }

    public function forceDeletePost(Post $post, User $user): void
    {
        $this->authorizePostManagement($post, $user);
        $post->forceDelete();
    }

    private function authorizePostManagement(Post $post, User $user): void
    {
        abort_unless(
            $user->isAdmin() || ($user->isAuthor() && (int) $post->user_id === (int) $user->id),
            403
        );
    }

    /**
     * Get image paths owned by the signed-in user that still exist on disk.
     *
     * @return array<int, string>
     */
    private function featuredImagesForUser(User $user): array
    {
        $imagePaths = Media::query()
            ->where('user_id', $user->id)
            ->where('path', 'like', 'post-featured-images/%')
            ->pluck('path')
            ->merge(
                Post::withTrashed()
                    ->where('user_id', $user->id)
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

    /**
     * Get the current month and two preceding months.
     *
     * @return Collection<int, Carbon>
     */
    private function lastThreeMonths(): Collection
    {
        return collect(range(0, 2))->map(function (int $monthsAgo): Carbon {
            return Carbon::now()->startOfMonth()->subMonths(2 - $monthsAgo);
        });
    }

    /**
     * Count posts per month for the selected period.
     *
     * @param  Collection<int, Carbon>  $months
     * @return array<int, array{label: string, count: int}>
     */
    private function postsByMonth(Collection $months, Carbon $quarterStart, Carbon $quarterEnd, ?int $userId = null): array
    {
        $postsQuery = Post::query()->whereBetween('created_at', [$quarterStart, $quarterEnd]);

        if ($userId !== null) {
            $postsQuery->where('user_id', $userId);
        }

        $postsByMonth = $postsQuery
            ->get(['created_at'])
            ->countBy(fn (Post $post): string => $post->created_at->format('Y-m'));

        return $months->map(fn (Carbon $month): array => [
            'label' => $month->format('M Y'),
            'count' => $postsByMonth->get($month->format('Y-m'), 0),
        ])->all();
    }
}
