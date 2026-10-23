<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Media;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
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
        $popularCategories = collect();

        if ($user->isAuthor()) {
            $months = collect(range(0, 2))->map(function (int $monthsAgo): Carbon {
                return Carbon::now()->startOfMonth()->subMonths(2 - $monthsAgo);
            });
            $postsByMonth = Post::query()
                ->where('user_id', $user->id)
                ->whereBetween('created_at', [$months->first(), $months->last()->copy()->endOfMonth()])
                ->get(['created_at'])
                ->countBy(fn (Post $post): string => $post->created_at->format('Y-m'));

            $authorMonthlyPosts = $months->map(fn (Carbon $month): array => [
                'label' => $month->format('M Y'),
                'count' => $postsByMonth->get($month->format('Y-m'), 0),
            ])->all();
        }

        if ($user->isAdmin()) {
            $globalStats = [
                'users' => User::count(),
                'posts' => Post::count(),
                'categories' => Category::count(),
                'comments' => Comment::count(),
                'tags' => Tag::count(),
            ];

            $months = collect(range(0, 2))->map(function (int $monthsAgo): Carbon {
                return Carbon::now()->startOfMonth()->subMonths(2 - $monthsAgo);
            });
            $quarterStart = $months->first();
            $quarterEnd = $months->last()->copy()->endOfMonth();

            $postsByMonth = Post::query()
                ->whereBetween('created_at', [$quarterStart, $quarterEnd])
                ->get(['created_at'])
                ->countBy(fn (Post $post): string => $post->created_at->format('Y-m'));

            $monthlyPosts = $months->map(fn (Carbon $month): array => [
                'label' => $month->format('M Y'),
                'count' => $postsByMonth->get($month->format('Y-m'), 0),
            ])->all();

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

        return view('backend.dashboard.index', compact('globalStats', 'monthlyPosts', 'authorMonthlyPosts', 'personalStats', 'popularCategories'));
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
