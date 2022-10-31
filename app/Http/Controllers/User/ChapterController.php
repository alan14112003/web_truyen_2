<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Chapter\StoreRequest;
use App\Http\Requests\Chapter\UpdateRequest;
use App\Models\Chapter;
use App\Models\Story;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class ChapterController extends Controller
{

    private Builder $model;
    private string $table;
    private string $title;

    public function __construct()
    {
        $this->model = Chapter::query();
        $this->table = (new Chapter())->getTable();
        View::share('table', $this->table);
    }

    public function index($slug, $number)
    {
        $story = Story::query()->where('slug', $slug)->first();

        $chapterList = $this->model->where('story_id', $story->id)->pluck('number')->toArray();

        $chapter = $this->model->where('story_id', $story->id)
        ->where('number', $number)->first();
        $this->title = "Chương truyện";
        View::share('title', $this->title);

        return view("user.$this->table.index", [
            'story' => $story,
            'chapterList' => $chapterList,
            'chapter' => $chapter,
        ]);
    }

    public function create($slug)
    {
        $story = Story::query()->where('slug', $slug)->first();

        $this->title = "Thêm 1 chương cho truyện: $story->name";
        View::share('title', $this->title);

        return view("user.$this->table.create", [
            'story' => $story,
        ]);
    }

    public function store(StoreRequest $request)
    {
        $number = ($this->model
            ->where('story_id', $request->get('story_id'))
            ->max('number')) ?? 0;
        ;
        $data = $request->validated();
        $data['number'] = $number + 1;
        $this->model->create($data);
        $story = Story::query()->find($request->get('story_id'));
        return redirect()->route("user.stories.show", [$story->slug, $story->id])
            ->with('success', 'Đã thêm 1 chương mới');
    }

    public function edit($slug,Chapter $id)
    {

        $story = Story::query()->where('slug', $slug)->first();

        $this->title = "Sửa chương truyện: $id->name";
        View::share('title', $this->title);

        return view("user.$this->table.edit", [
            'story' => $story,
            'chapter' => $id,
        ]);
    }

    public function update(UpdateRequest $request, $slug, $id)
    {
        $chapter = $this->model->find($id);

        $chapter->update($request->validated());
        return redirect()->route("user.stories.$this->table.index", ['slug' => $slug, 'number' => $chapter->number])
                ->with('success', 'Đã sửa thành công');
    }

    public function destroy($slug, $number)
    {
        $story = Story::query()->where('slug', $slug)->first();

        $this->model->where('story_id', $story->id)
            ->where('number', $number)->delete();

        DB::statement("UPDATE chapters SET NUMBER = NUMBER - 1 WHERE story_id = $story->id AND NUMBER > $number");

        return redirect()->route("user.stories.show", [$story->slug, $story->id])
            ->with('success', 'Đã xóa chương');
    }
}
