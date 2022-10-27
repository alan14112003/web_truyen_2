<?php

namespace App\Http\Controllers\User;

use App\Enums\StoryLevelEnum;
use App\Enums\StoryPinEnum;
use App\Enums\StoryStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Story\StoreRequest;
use App\Models\Author;
use App\Models\Category;
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
        $authorFilter = $request->get('author');
        $author2Filter = $request->get('author_2');
        $usersFilter = $request->get('users');

        $query = $this->model
            ->with('categories')
            ->withCount('chapter')
            ->with('author')
            ->with('author_2')
            ->with('user')
            ->latest()
            ->where('name', 'like', "%$q%")
            ->where('user_id', auth()->id())
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

        if (isset($pinFilter) && $pinFilter !== 'All') {
            $query = $query->where('pin', $pinFilter);
        }

        if (isset($authorFilter) && $authorFilter !== 'All') {
            $query = $query->where('author_id', $authorFilter);
        }

        if (isset($author2Filter) && $author2Filter !== 'All') {
            $query = $query->where('author_2_id', $author2Filter);
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

        //        author
        $author = Author::query()->where('level', 0)
            ->get(['id', 'name']);

        //        author 2
        $author_2 = Author::query()->where('level', 1)
            ->get(['id', 'name']);

//        user
        $users = User::query()->get(['id', 'name']);


//        dd(implode(', ', $query->categories->pluck('name')->toArray()));

        $this->title = 'Danh sách truyện của tôi';
        View::share('title', $this->title);

        return view("user.$this->table.index", [
            'data' => $data,
            'q' => $q,

            'categories' => $categories,
            'status' => $status,
            'level' => $level,
            'pin' => $pin,
            'author' => $author,
            'author_2' => $author_2,
            'users' => $users,

            'categoriesFilter' => $categoriesFilter,
            'statusFilter' => $statusFilter,
            'levelFilter' => $levelFilter,
            'pinFilter' => $pinFilter,
            'authorFilter' => $authorFilter,
            'author_2Filter' => $author2Filter,
            'usersFilter' => $usersFilter,
        ]);
    }

    public function create()
    {
        //        categories
        $categories = Category::query()->get(['id', 'name']);

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

        //        author
        $author = Author::query()->where('level', 0)
            ->get(['id', 'name']);

        $authorArray = array();
        foreach ($author as $item) {
            $authorArray[] = $item->name;
        }
        //        author 2
        $author_2 = Author::query()->where('level', 1)
            ->get(['id', 'name']);

        $author2Array = [];
        foreach ($author_2 as $item) {
            $author2Array[] = $item->name;
        }
//        user
        $users = User::query()->get(['id', 'name']);

        $this->title = 'Thêm truyện mới';
        View::share('title', $this->title);


        return view("user.$this->table.create", [
            'categories' => $categories,
            'status' => $status,
            'level' => $level,
            'pin' => $pin,
            'authorArray' => $authorArray,
            'author2Array' => $author2Array,
            'users' => $users,
        ]);
    }

    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        dd($data['categories']);
        DB::beginTransaction();
        try {
            
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
        }
    }
}
