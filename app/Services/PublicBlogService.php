<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

class PublicBlogService
{
    public function searchArticles(?string $term): LengthAwarePaginator
    {
        $postsQuery = Post::query()
            ->with(['category', 'user'])
            ->where('status', 'live')
            ->where(function ($query): void {
                $query->whereNull('published_at')
                    ->orWhere('published_at', '<=', now());
            });

        if ($term === null || $term === '') {
            $postsQuery->whereRaw('1 = 0');
        } else {
            $postsQuery->where(function ($query) use ($term): void {
                $query->where('title', 'LIKE', '%'.$term.'%')
                    ->orWhere('excerpt', 'LIKE', '%'.$term.'%')
                    ->orWhere('content', 'LIKE', '%'.$term.'%');
            });
        }

        return $postsQuery
            ->latest('created_at')
            ->paginate(10)
            ->withQueryString();
    }

    /** @return EloquentCollection<int, Category> */
    public function categoriesIndex(): EloquentCollection
    {
        return Category::query()->orderBy('name')->get();
    }

    /**
     * Get the selected category and its latest published posts.
     *
     * @return array{category: Category, posts: LengthAwarePaginator}
     */
    public function categoryArticles(string $slug): array
    {
        $category = Category::query()->where('slug', $slug)->firstOrFail();

        $posts = $category->posts()
            ->with('user')
            ->where('status', 'live')
            ->where(function ($query): void {
                $query->whereNull('published_at')
                    ->orWhere('published_at', '<=', now());
            })
            ->latest('created_at')
            ->paginate(10)
            ->withQueryString();

        return compact('category', 'posts');
    }

    /**
     * Get the selected tag and its latest published posts.
     *
     * @return array{tag: Tag, posts: LengthAwarePaginator}
     */
    public function tagArticles(string $slug): array
    {
        $tag = Tag::query()->where('slug', $slug)->firstOrFail();

        $posts = $tag->posts()
            ->with('user')
            ->where('status', 'live')
            ->where(function ($query): void {
                $query->whereNull('published_at')
                    ->orWhere('published_at', '<=', now());
            })
            ->latest('created_at')
            ->paginate(10)
            ->withQueryString();

        return compact('tag', 'posts');
    }

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
