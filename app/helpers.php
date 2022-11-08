<?php


use App\Enums\StoryPinEnum;
use App\Models\Category;
use App\Models\Story;
use Illuminate\Database\Eloquent\Collection;

if (!function_exists('chapterList')) {
    function categoryList(): Collection|array
    {
        return Category::query()->get();
    }
}

if (!function_exists('listStoriesSearch')) {
    function listStoriesSearch(): Collection|array
    {

        $stories = Story::query()
            ->with('chapter')
            ->with('categories')
            ->with('author')
            ->where('stories.pin', '>', StoryPinEnum::UPLOADING)
            ->inRandomOrder()
            ->get();
        $listStories = [];
        foreach ($stories as $item) {
            $story = [];
            $story['id'] = $item->id;
            $story['name'] = $item->name;
            $story['chapter_new'] = $item->chapterNew->number;
            $story['category_name'] = $item->categoriesName;
            $story['author'] = $item->author->name;
            $story['image'] = $item->image_url;
            $story['slug'] = $item->slug;
            $listStories[] = $story;
        }
        return $listStories;
    }
}
