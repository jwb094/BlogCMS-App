<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Media;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

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
