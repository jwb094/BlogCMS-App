<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Validation\ValidationException;

class PublicBlogService
{
    /** @param array{name: string, email: string, content: string} $commentData */
    public function addComment(string $postId, array $commentData, ?User $user, string $ipAddress): Comment
    {
        $post = Post::query()
            ->where('status', 'live')
            ->where(function ($query): void {
                $query->whereNull('published_at')
                    ->orWhere('published_at', '<=', now());
            })
            ->findOrFail($postId);

        abort_unless($post->allow_comments === 'allow', 403);

        $content = trim(strip_tags($commentData['content']));

        if (mb_strlen($content) < 3) {
            throw ValidationException::withMessages([
                'content' => 'Please enter a comment with at least three characters.',
            ]);
        }

        if (preg_match('~(?:https?://|www\\.|<\\s*a\\b|href\\s*=|(?:[a-z0-9-]+\\.)+[a-z]{2,}(?:/|\\b))~i', $content)) {
            throw ValidationException::withMessages([
                'content' => 'Comments cannot contain links or advertising.',
            ]);
        }

        if (preg_match('/(.)\\1{9,}/us', $content)) {
            throw ValidationException::withMessages([
                'content' => 'Please remove repeated characters from your comment.',
            ]);
        }

        $duplicateCommentExists = Comment::query()
            ->where('ip_address', $ipAddress)
            ->where('content', $content)
            ->where('created_at', '>=', now()->subDay())
            ->exists();

        if ($duplicateCommentExists) {
            throw ValidationException::withMessages([
                'content' => 'This comment has already been submitted.',
            ]);
        }

        return Comment::create([
            'name' => $commentData['name'],
            'email' => $commentData['email'],
            'content' => $content,
            'status' => 'pending',
            'ip_address' => $ipAddress,
            'user_id' => $user?->id,
            'post_id' => $post->id,
        ]);
    }

    /**
     * Get a public article with its approved comments and related stories.
     *
     * @return array{post: Post, relatedPosts: EloquentCollection<int, Post>, safeContent: string}
     */
    public function article(string $id): array
    {
        $post = Post::query()
            ->with([
                'category',
                'user',
                'tags',
                'comments' => fn ($query) => $query->where('status', 'approved')->latest('created_at'),
            ])
            ->where('status', 'live')
            ->where(function ($query): void {
                $query->whereNull('published_at')
                    ->orWhere('published_at', '<=', now());
            })
            ->findOrFail($id);

        $publishedPosts = Post::query()
            ->with(['category', 'user'])
            ->where('status', 'live')
            ->where(function ($query): void {
                $query->whereNull('published_at')
                    ->orWhere('published_at', '<=', now());
            })
            ->whereKeyNot($post->getKey());

        $relatedPosts = (clone $publishedPosts)
            ->where('category_id', $post->category_id)
            ->latest('created_at')
            ->limit(3)
            ->get();

        if ($relatedPosts->count() < 3) {
            $additionalPosts = (clone $publishedPosts)
                ->when($relatedPosts->isNotEmpty(), fn ($query) => $query->whereNotIn('id', $relatedPosts->modelKeys()))
                ->latest('created_at')
                ->limit(3 - $relatedPosts->count())
                ->get();

            $relatedPosts = $relatedPosts->concat($additionalPosts);
        }

        return [
            'post' => $post,
            'relatedPosts' => $relatedPosts,
            'safeContent' => $this->sanitizeArticleContent((string) $post->content),
        ];
    }

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

    private function sanitizeArticleContent(string $content): string
    {
        $document = new \DOMDocument('1.0', 'UTF-8');
        $previousErrorMode = libxml_use_internal_errors(true);
        $document->loadHTML(
            '<!DOCTYPE html><html><head><meta charset="UTF-8"></head><body><div id="article-content">'.$content.'</div></body></html>',
            LIBXML_NONET
        );
        libxml_clear_errors();
        libxml_use_internal_errors($previousErrorMode);

        $container = $document->getElementById('article-content');

        if ($container === null) {
            return e($content)->toHtml();
        }

        $this->sanitizeArticleNodes($container);

        $safeContent = '';
        foreach ($container->childNodes as $child) {
            $safeContent .= $document->saveHTML($child);
        }

        return $safeContent;
    }

    private function sanitizeArticleNodes(\DOMNode $parent): void
    {
        $allowedTags = ['a', 'blockquote', 'br', 'code', 'em', 'h2', 'h3', 'h4', 'hr', 'i', 'img', 'li', 'ol', 'p', 'pre', 'strong', 'ul'];
        $removeTags = ['embed', 'form', 'iframe', 'object', 'script', 'style', 'svg', 'video', 'audio'];

        foreach (iterator_to_array($parent->childNodes) as $child) {
            if (! $child instanceof \DOMElement) {
                if ($child instanceof \DOMComment) {
                    $parent->removeChild($child);
                }

                continue;
            }

            $tag = strtolower($child->tagName);

            if (in_array($tag, $removeTags, true)) {
                $parent->removeChild($child);

                continue;
            }

            if (! in_array($tag, $allowedTags, true)) {
                $this->sanitizeArticleNodes($child);

                while ($child->firstChild !== null) {
                    $parent->insertBefore($child->firstChild, $child);
                }
                $parent->removeChild($child);

                continue;
            }

            $this->sanitizeArticleAttributes($child, $tag);
            $this->sanitizeArticleNodes($child);
        }
    }

    private function sanitizeArticleAttributes(\DOMElement $element, string $tag): void
    {
        $allowedAttributes = match ($tag) {
            'a' => ['href', 'title'],
            'img' => ['src', 'alt', 'title', 'width', 'height'],
            default => [],
        };

        foreach (iterator_to_array($element->attributes) as $attribute) {
            $name = strtolower($attribute->name);

            if (! in_array($name, $allowedAttributes, true)) {
                $element->removeAttribute($attribute->name);

                continue;
            }

            if (in_array($name, ['href', 'src'], true) && ! $this->isSafeArticleUrl($attribute->value, $tag === 'a')) {
                $element->removeAttribute($attribute->name);
            }
        }

        if ($tag === 'a' && $element->hasAttribute('href')) {
            $element->setAttribute('rel', 'nofollow noopener noreferrer');
        }
    }

    private function isSafeArticleUrl(string $url, bool $allowMailto): bool
    {
        $url = trim($url);

        if ($url === '' || str_starts_with($url, '//')) {
            return false;
        }

        if (str_starts_with($url, '/') || str_starts_with($url, '#')) {
            return true;
        }

        $allowedSchemes = $allowMailto ? ['http', 'https', 'mailto'] : ['http', 'https'];

        return in_array(strtolower(parse_url($url, PHP_URL_SCHEME) ?? ''), $allowedSchemes, true);
    }
}
