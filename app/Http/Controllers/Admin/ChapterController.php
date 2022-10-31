<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Chapter;
use App\Models\Story;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class ChapterController extends Controller
{

    private Builder $model;
    private string $table;
    private string $title;

    public function __construct()
    {
        $this->table = (new Chapter())->getTable();
        View::share('table', $this->table);
    }

    public function index($id, $number)
    {
        $story = Story::query()->find($id);

        $chapterList = Chapter::query()->where('story_id', $story->id)->pluck('number')->toArray();

        $chapter = Chapter::query()->where('story_id', $story->id)
            ->where('number', $number)->first();
        $this->title = "Chương truyện";
        View::share('title', $this->title);

        return view("user.$this->table.index", [
            'story' => $story,
            'chapterList' => $chapterList,
            'chapter' => $chapter,
        ]);
    }

}
