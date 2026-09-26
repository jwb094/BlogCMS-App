<?php

namespace App\Services;

use App\Models\Tag;
use Illuminate\Support\Str;

class   BlogService
{



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
