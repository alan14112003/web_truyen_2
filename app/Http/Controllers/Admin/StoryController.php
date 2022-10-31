<?php

namespace App\Http\Controllers\Admin;

use App\Enums\StoryLevelEnum;
use App\Enums\StoryPinEnum;
use App\Enums\StoryStatusEnum;
use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Category;
use App\Models\Chapter;
use App\Models\Story;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class StoryController extends Controller
{
    private Builder $model;
    private string $table;
    private string $title;

    public function __construct()
    {
        $this->model = Story::query();
        $this->table = (new Story())->getTable();

        View::share('table', $this->table);
    }


    public function index(Request $request)
    {
        $q = $request->get('q');
        $categoriesFilter = $request->get('categories');
        $statusFilter = $request->get('status');
        $levelFilter = $request->get('level');
        $pinFilter = $request->get('pin');
        $usersFilter = $request->get('users');

        $query = $this->model
            ->with('categories')
            ->withCount('chapter')
            ->with('author')
            ->with('author_2')
            ->with('user')
            ->latest()
            ->where('name', 'like', "%$q%")
            ->whereNot('pin', StoryPinEnum::EDITING)
        ;


        if (isset($categoriesFilter) && !in_array('All', $categoriesFilter)) {
            $query = $query->whereHas('categories', function($qr) use ($categoriesFilter) {
                $qr->whereIn('categories.id', $categoriesFilter);
            });
        }

        if (isset($levelFilter) && $levelFilter !== 'All') {
            $query = $query->where('level', $levelFilter);
        }

        if (isset($statusFilter) && $statusFilter !== 'All') {
            $query = $query->where('status', $statusFilter);
        }

        if (isset($pinFilter) && $pinFilter !== 'All') {
            $query = $query->where('pin', $pinFilter);
        }

        if (isset($usersFilter) && $usersFilter !== 'All') {
            $query = $query->where('user_id', $usersFilter);
        }


        $data = $query->paginate();


        //        categories
        $categories = Category::query()->get();

        //        status
        $statusEnum = StoryStatusEnum::getValues();
        $status = [];
        foreach ($statusEnum as $item) {
            $status[$item] = StoryStatusEnum::getNameByValue($item);
        }

        //        level
        $levelEnum = StoryLevelEnum::getValues();
        $level = [];
        foreach ($levelEnum as $item) {
            $level[$item] = StoryLevelEnum::getNameByValue($item);
        }

        //        pin
        $pinEnum = StoryPinEnum::getValues();
        $pin = [];
        foreach ($pinEnum as $item) {
            if ($item === StoryPinEnum::EDITING) continue;
            $pin[$item] = StoryPinEnum::getNameByValue($item);
        }

//        user
        $users = User::query()->get(['id', 'name']);


//        dd(implode(', ', $query->categories->pluck('name')->toArray()));

        $this->title = 'Danh sách truyện';
        View::share('title', $this->title);

        return view("admin.$this->table.index", [
            'data' => $data,
            'q' => $q,

            'categories' => $categories,
            'status' => $status,
            'level' => $level,
            'pin' => $pin,
            'users' => $users,

            'categoriesFilter' => $categoriesFilter,
            'statusFilter' => $statusFilter,
            'levelFilter' => $levelFilter,
            'pinFilter' => $pinFilter,
            'usersFilter' => $usersFilter,
        ]);
    }

    public function blackList(Request $request)
    {
        $q = $request->get('q');
        $categoriesFilter = $request->get('categories');
        $statusFilter = $request->get('status');
        $levelFilter = $request->get('level');
        $authorFilter = $request->get('author');
        $author2Filter = $request->get('author_2');
        $pinFilter = $request->get('pin');


        $query = Story::onlyTrashed()
            ->with('categories')
            ->withCount('chapter')
            ->with('author')
            ->with('author_2')
            ->with('user')
            ->latest()
            ->where('name', 'like', "%$q%")
            ->whereNot('pin', StoryPinEnum::EDITING)
        ;


        if (isset($categoriesFilter)) {
            $query = $query->whereHas('categories', function($qr) use ($categoriesFilter) {
                $qr->whereIn('categories.id', $categoriesFilter);
            });
        }

        if (isset($levelFilter) && $levelFilter !== 'All') {
            $query = $query->where('level', $levelFilter);
        }

        if (isset($statusFilter) && $statusFilter !== 'All') {
            $query = $query->where('status', $statusFilter);
        }

        if (isset($authorFilter) && $authorFilter !== 'All') {
            $query = $query->where('author_id', $authorFilter);
        }

        if (isset($author2Filter) && $author2Filter !== 'All') {
            $query = $query->where('author_2_id', $author2Filter);
        }

        if (isset($pinFilter) && $pinFilter !== 'All') {
            $query = $query->where('pin', $pinFilter);
        }


        $data = $query->paginate();


        //        categories
        $categories = Category::query()->get();

        //        status
        $statusEnum = StoryStatusEnum::getValues();
        $status = [];
        foreach ($statusEnum as $item) {
            $status[$item] = StoryStatusEnum::getNameByValue($item);
        }

        //        level
        $levelEnum = StoryLevelEnum::getValues();
        $level = [];
        foreach ($levelEnum as $item) {
            $level[$item] = StoryLevelEnum::getNameByValue($item);
        }

        //        author
        $author = Author::query()->where('level', 0)
            ->get(['id', 'name']);
        //        author 2
        $author_2 = Author::query()->where('level', 1)
            ->get(['id', 'name']);


        //        pin
        $pinEnum = StoryPinEnum::getValues();
        $pin = [];
        foreach ($pinEnum as $item) {
            if ($item === StoryPinEnum::EDITING) continue;
            $pin[$item] = StoryPinEnum::getNameByValue($item);
        }

//        dd(implode(', ', $query->categories->pluck('name')->toArray()));

        $this->title = 'Danh sách truyện đã xóa';
        View::share('title', $this->title);

        return view("admin.$this->table.black_list", [
            'data' => $data,
            'q' => $q,

            'categories' => $categories,
            'status' => $status,
            'level' => $level,
            'author' => $author,
            'author_2' => $author_2,
            'pin' => $pin,

            'categoriesFilter' => $categoriesFilter,
            'statusFilter' => $statusFilter,
            'levelFilter' => $levelFilter,
            'authorFilter' => $authorFilter,
            'author_2Filter' => $author2Filter,
            'pinFilter' => $pinFilter,
        ]);
    }

    public function view($id)
    {
        $stories = $this->model
            ->where('pin', '>', StoryPinEnum::EDITING)
            ->get(['id', 'name']);

        $story = Story::query()->withCount('chapter')->with('author')
            ->find($id);

        $chapters = Chapter::query()->where('story_id', $id)->paginate(1);

        $this->title = "$story->name";
        View::share('title', $this->title);

        return view("admin.$this->table.view", [
            'story' => $story,
            'stories' => $stories,
            'chapters' => $chapters
        ]);
    }

    public function viewBlack($id)
    {
        $stories = Story::onlyTrashed()
            ->where('pin', '>', StoryPinEnum::EDITING)
            ->get(['id', 'name']);

        $story = Story::onlyTrashed()->withCount('chapter')->with('author')
            ->find($id);

        $chapters = Chapter::query()->where('story_id', $id)->paginate(1);

        $this->title = "$story->name";
        View::share('title', $this->title);

        return view("admin.$this->table.view_black", [
            'story' => $story,
            'stories' => $stories,
            'chapters' => $chapters
        ]);
    }

    public function find(Request $request)
    {
        $story_id = $request->get('story_id');
        return redirect()->route("admin.$this->table.view", $story_id);
    }

    public function findBlack(Request $request)
    {
        $story_id = $request->get('story_id');
        return redirect()->route("admin.$this->table.view_black", $story_id);
    }

    public function approve($id)
    {
        $this->model->find($id)->update([
            'pin' => StoryPinEnum::APPROVE,
        ]);
        return redirect()->back()->with('success', 'Đã duyệt truyện');
    }

    public function un_approve($id)
    {
        $this->model->find($id)->update([
            'pin' => StoryPinEnum::UPLOADING,
        ]);
        return redirect()->back()->with('success', 'Đã bỏ duyệt truyện');
    }

    public function pinned($id)
    {
        $story = $this->model->find($id);
        if ($story->pin === StoryPinEnum::PINNED) {
            $story->update([
                'pin' => StoryPinEnum::APPROVE,
            ]);
            return redirect()->back()->with('success', 'Đã bỏ ghim truyện');
        } else {
            $story->update([
                'pin' => StoryPinEnum::PINNED,
            ]);
        }
        return redirect()->back()->with('success', 'Đã ghim truyện');
    }

    public function destroy($id)
    {
        $this->model->find($id)->delete();
        return redirect()->back()->with('success', 'Đã xóa truyện');
    }

    public function restore($id)
    {
        if ($story = Story::onlyTrashed()->find($id)) {
            $story->restore();

            return redirect()->back()
                ->with('success', 'Đã khôi phục');
        }
        return redirect()->back()
            ->with('success', 'Không có truyện này');
    }

    public function kill($id)
    {
        if ($story = Story::onlyTrashed()->findOrFail($id)) {
            if (empty($story->image)) {
                $story->forceDelete();

                return redirect()->back()
                    ->with('success', 'Đã xóa vĩnh viễn truyện này');
            }
            if (file_exists("storage/$story->image")) {
                $link = "storage/$story->image";
                $path = "storage/images/$story->id";
                unlink($link);
                rmdir($path);
            }
            $story->forceDelete();

            return redirect()->back()
                ->with('success', 'Đã xóa vĩnh viễn truyện này');
        }

        return redirect()->back()
            ->with('error', "Không xóa được");
    }
}
