<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Tag;
use Illuminate\Support\Str;

class   BlogService
{
        //Category
    /**
     * Summary of Tag Index
     * @param object $inputData
     * @return array{tags: \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Pagination\LengthAwarePaginator<int, Tag>}
     */
    public function categoryIndex(object $inputData): array
    {


        $query =  Category::query();

        if (!empty($inputData['name'])) {
            $query->where(
                'name',
                'LIKE',
                '%' . $inputData['name'] . '%'
            );
        }



        $category = $query
            ->orderBy('name', 'ASC')
            ->latest()
            ->paginate(10)
            ->withQueryString();



        return [
            "category" => $category
        ];
    }

    /**
     * Summary of newTag
     * @param array $data
     * @return Category
     */
    public  function newCategory(array $data): Category
    {



        $data["slug"] = Str::slug($data['name']);
        //dd($data);
        $newTag = Category::create($data);

        return $newTag;
    }

    /**
     * Summary of updateTag
     * @param array $updatedCategoryData
     * @param int $updatedCategoryDataId
     * @return Category
     */
    public function updateCategory(array $updatedCategoryData, int $updatedCategoryDataId)
    {
        $category = Category::findOrFail($updatedCategoryDataId);


        $updatedCategoryData["slug"] = Str::slug($updatedCategoryData['name']);


        $category->update($updatedCategoryData);

        return $category->refresh();
    }


    //Tag
    /**
     * Summary of Tag Index
     * @param object $inputData
     * @return array{tags: \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Pagination\LengthAwarePaginator<int, Tag>}
     */
    public function Index(object $inputData): array
    {


        $query =  Tag::query();

        if (!empty($inputData['name'])) {
            $query->where(
                'name',
                'LIKE',
                '%' . $inputData['name'] . '%'
            );
        }



        $tags = $query
            ->orderBy('name', 'ASC')
            ->latest()
            ->paginate(10)
            ->withQueryString();



        return [
            "tags" => $tags
        ];
    }

    /**
     * Summary of newTag
     * @param array $data
     * @return Tag
     */
    public  function newTag(array $data): Tag
    {



        $data["slug"] = Str::slug($data['name']);
        //dd($data);
        $newTag = Tag::create($data);

        return $newTag;
    }

    /**
     * Summary of updateTag
     * @param array $updatedTagData
     * @param int $updatedTagDataId
     * @return Tag
     */
    public function updateTag(array $updatedTagData, int $updatedTagDataId)
    {
        $tag = Tag::findOrFail($updatedTagDataId);


        $updatedTagData["slug"] = Str::slug($updatedTagData['name']);


        $tag->update($updatedTagData);

        return $tag->refresh();
    }
}
