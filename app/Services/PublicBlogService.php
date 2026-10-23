<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

class PublicBlogService
{
    /**
     * Get the featured stories and the latest articles grouped by category.
     *
     * @return array{
     *     topPosts: EloquentCollection<int, Post>,
     *     categorySections: EloquentCollection<int, Category>
     * }
     */
    public function homePageData(): array
    {
        $publishedPostConstraint = function ($query): void {
            $query->where('status', 'live')
                ->where(function ($query): void {
                    $query->whereNull('published_at')
                        ->orWhere('published_at', '<=', now());
                });
        };

        $topPosts = Post::query()
            ->with(['category', 'user'])
            ->where($publishedPostConstraint)
            ->latest('created_at')
            ->limit(4)
            ->get();

        $topPostIds = $topPosts->modelKeys();
        $categoryPostConstraint = function ($query) use ($publishedPostConstraint, $topPostIds): void {
            $publishedPostConstraint($query);

            if ($topPostIds !== []) {
                $query->whereNotIn('id', $topPostIds);
            }
        };

        $categorySections = Category::query()
            ->whereHas('posts', $categoryPostConstraint)
            ->with(['posts' => function ($query) use ($categoryPostConstraint): void {
                $categoryPostConstraint($query);
                $query->latest('created_at')->limit(3);
            }])
            ->orderBy('name')
            ->get()
            ->filter(fn (Category $category): bool => $category->posts->isNotEmpty());

        return compact('topPosts', 'categorySections');
    }
}
