<?php

namespace App\Http\Requests;

use App\Models\Media;
use App\Models\Post;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class PostFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'slug' => Str::slug($this->input('slug', '')),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $post = $this->route('post');
        $uniqueSlugRule = Rule::unique('posts', 'slug');

        if ($post !== null) {
            $uniqueSlugRule->ignore($post);
        }

        return [
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', $uniqueSlugRule],
            'subheading' => ['required', 'string'],
            'excerpt' => ['required', 'string'],
            'status' => ['required', 'in:live,draft,scheduled'],
            'allow_comments' => ['required', 'in:allow,forbidden'],
            'featured_image' => [
                'required_without:featured_image_upload',
                'nullable',
                'string',
                'max:255',
                function (string $attribute, mixed $value, \Closure $fail): void {
                    if ($value === null || $value === '') {
                        return;
                    }

                    $userId = $this->user()->id;
                    $isOwnedGalleryImage = Media::query()
                        ->where('user_id', $userId)
                        ->where('path', $value)
                        ->where('path', 'like', 'post-featured-images/%')
                        ->exists()
                        || Post::withTrashed()
                            ->where('user_id', $userId)
                            ->where('featured_image', $value)
                            ->where('featured_image', 'like', 'post-featured-images/%')
                            ->exists();
                    $post = $this->route('post');
                    $isCurrentPostImage = $post instanceof Post
                        && $post->featured_image === $value;

                    if (! $isOwnedGalleryImage && ! $isCurrentPostImage) {
                        $fail('Select an image from your own featured image gallery.');
                    }
                },
            ],
            'featured_image_upload' => [
                'required_without:featured_image',
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,gif,webp',
                'max:5120',
            ],
            'featured_image_caption' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'meta_title' => ['required', 'string', 'max:255'],
            'meta_description' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'published_at' => ['nullable', 'date'],
        ];
    }
}
