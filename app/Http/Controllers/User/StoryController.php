<?php

namespace App\Http\Controllers\User;

use App\Enums\AuthorLevelEnum;
use App\Enums\ChapterPinEnum;
use App\Enums\StoryLevelEnum;
use App\Enums\StoryPinEnum;
use App\Enums\StoryStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Story\StoreRequest;
use App\Http\Requests\Story\UpdateRequest;
use App\Models\Author;
use App\Models\Category;
use App\Models\Chapter;
use App\Models\Story;
use App\Models\User;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use Throwable;

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
            $pin[$item] = StoryPinEnum::getNameByValue($item);
        }

//        user
        $users = User::query()->get(['id', 'name']);


//        dd(implode(', ', $query->categories->pluck('name')->toArray()));

        $this->title = 'Danh s??ch truy???n c???a t??i';
        View::share('title', $this->title);

        return view("user.$this->table.index", [
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
        $pinFilter = $request->get('pin');


        $query = Story::onlyTrashed()
            ->with('categories')
            ->withCount('chapter')
            ->with('author')
            ->with('author_2')
            ->with('user')
            ->latest()
            ->where('name', 'like', "%$q%")
            ->where('user_id', Auth::id())
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
            $pin[$item] = StoryPinEnum::getNameByValue($item);
        }


        $this->title = 'Danh s??ch truy???n ???? x??a c???a t??i';
        View::share('title', $this->title);

        return view("user.$this->table.black_list", [
            'data' => $data,
            'q' => $q,

            'categories' => $categories,
            'status' => $status,
            'level' => $level,
            'pin' => $pin,

            'categoriesFilter' => $categoriesFilter,
            'statusFilter' => $statusFilter,
            'levelFilter' => $levelFilter,
            'pinFilter' => $pinFilter,
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

        //        author
        $author = Author::query()->where('level', AuthorLevelEnum::AUTHOR)
            ->get(['id', 'name']);

        $authorArray = array();
        foreach ($author as $item) {
            $authorArray[] = $item->name;
        }
        //        author 2
        $author_2 = Author::query()->where('level', AuthorLevelEnum::EDITOR)
            ->get(['id', 'name']);

        $author2Array = [];
        foreach ($author_2 as $item) {
            $author2Array[] = $item->name;
        }

        $this->title = 'Th??m truy???n m???i';
        View::share('title', $this->title);

        return view("user.$this->table.create", [
            'categories' => $categories,
            'status' => $status,
            'level' => $level,
            'authorArray' => $authorArray,
            'author2Array' => $author2Array,
        ]);
    }

    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        $image = $request->file('image');
        DB::beginTransaction();
        try {
//            x??? l?? t??c gi???
            $author = Author::query()
                ->firstOrCreate([
                    'name' => $data['author'],
                    'level' => AuthorLevelEnum::AUTHOR,
                ]);
            if (isset($data['author_2'])) {
                $author_2 = Author::query()
                    ->firstOrCreate([
                        'name' => $data['author_2'],
                        'level' => AuthorLevelEnum::EDITOR,
                    ]);
            }
//              X??? l?? ????ng truy???n
            $story = $this->model->create([
                'name' => Str::lower($data['name']),
                'status' => (int)$data['status'],
                'author_id' => $author->id,
                'descriptions' => $data['descriptions'],
                'level' => (int)$data['level'],
                'pin' => StoryPinEnum::EDITING,
                'user_id' => Auth::id(),
            ]);
            if (isset($data['author_2'])) {
                $story->update([
                    'author_2_id' => $author_2->id,
                ]);
            }

//            x??? l?? upload ???nh v?? l??u v??o c?? s??? d??? li???u
            $fileImageExtension = $image->extension();
            $fileImageName = "image.$fileImageExtension";
            $fileImageUrl = Storage::disk('public')
                ->putFileAs("images/$story->id", $request->file('image'), $fileImageName);

            $story->update([
                'image' => $fileImageUrl,
            ]);

//            x??? l?? li??n k???t truy???n v???i th??? lo???i
            $story->categories()->attach($data['categories']);

            DB::commit();
            return redirect()->route("user.$this->table.show", [$story->slug, $story->id])
                ->with('success', 'T???o truy???n m???i th??nh c??ng');
        } catch (Throwable $e) {
            $link = "storage/$story->image";
            $path = "storage/images/$story->id";
            unlink($link);
            rmdir($path);
            DB::rollBack();
            echo "Error: " . $e->getMessage();
            return redirect()->back()->with('error', 'T???o truy???n th???t b???i' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $story = $this->model
            ->with('categories')
            ->find($id);

        if (Auth::id() !== $story->user_id) {
            return redirect()->back()->with('error', 'B???n kh??ng c?? quy???n');
        }
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

        //        author
        $author = Author::query()->where('level', AuthorLevelEnum::AUTHOR)
            ->get(['id', 'name']);

        $authorArray = array();
        foreach ($author as $item) {
            $authorArray[] = $item->name;
        }
        //        author 2
        $author_2 = Author::query()->where('level', AuthorLevelEnum::EDITOR)
            ->get(['id', 'name']);

        $author2Array = [];
        foreach ($author_2 as $item) {
            $author2Array[] = $item->name;
        }

        $this->title = 'Thay ?????i th??ng tin truy???n: ' . $story->name;
        View::share('title', $this->title);

        return view("user.$this->table.edit", [
            'story' => $story,
            'categories' => $categories,
            'status' => $status,
            'level' => $level,
            'authorArray' => $authorArray,
            'author2Array' => $author2Array,
        ]);
    }

    public function update(UpdateRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            //            x??? l?? t??c gi???
            $author = Author::query()
                ->firstOrCreate([
                    'name' => $request->author,
                    'level' => AuthorLevelEnum::AUTHOR,
                ]);
            if (isset($request->author_2)) {
                $author_2 = Author::query()
                    ->firstOrCreate([
                        'name' => $request->author_2,
                        'level' => AuthorLevelEnum::EDITOR,
                    ]);
            }

            //              X??? l?? ????ng truy???n
            $story = $this->model->find($id);
            $slug = SlugService::createSlug(Story::class, 'slug', $request->name);
            $story->update([
                    'name' => Str::lower($request->name),
                    'status' => (int)$request->status,
                    'author_id' => $author->id,
                    'descriptions' => $request->descriptions,
                    'level' => (int)$request->level,
                    'slug' => $slug,
                ]);
            if (isset($request->author_2)) {
                $story->update([
                    'author_2_id' => $author_2->id,
                ]);
            }

//            x??? l?? upload ???nh v?? l??u v??o c?? s??? d??? li???u
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $fileImageExtension = $image->extension();
                $fileImageName = "image.$fileImageExtension";

                $link = "storage/$story->image";
                unlink($link);

                $fileImageUrl = Storage::disk('public')
                    ->putFileAs("images/$story->id", $request->file('image'), $fileImageName);

                $story->update([
                    'image' => $fileImageUrl,
                ]);
            }

//            x??? l?? li??n k???t truy???n v???i th??? lo???i
            $story->categories()->sync($request->categories);

            DB::commit();
            return redirect()->route("user.$this->table.show", [$story->slug, $story->id])
                ->with('success', 'Thay ?????i th??ng tin truy???n th??nh c??ng');
        }
        catch (Throwable $e) {
            DB::rollBack();
            echo "Error: " . $e->getMessage();
            return redirect()->back()->with('error', 'T???o truy???n th???t b???i' . $e->getMessage());
        }
    }


    public function destroy($id)
    {
        $this->model->find($id)->delete();
        return redirect()->back()->with('success', '???? x??a truy???n');
    }

    public function restore($id)
    {
        if ($story = Story::onlyTrashed()->find($id)) {
            $story->restore();

            return redirect()->back()
                ->with('success', '???? kh??i ph???c');
        }
        return redirect()->back()
            ->with('success', 'Kh??ng c?? truy???n n??y');
    }

    public function kill($id)
    {
        if ($story = Story::onlyTrashed()->findOrFail($id)) {
            Chapter::query()->where('story_id', $story->id)->delete();
            if (empty($story->image)) {
                $story->forceDelete();

                return redirect()->back()
                    ->with('success', '???? x??a v??nh vi???n truy???n n??y');
            }
            if (file_exists("storage/$story->image")) {
                $link = "storage/$story->image";
                $path = "storage/images/$story->id";
                unlink($link);
                rmdir($path);
            }
            $story->forceDelete();

            return redirect()->back()
                ->with('success', '???? x??a v??nh vi???n truy???n n??y');
        }

        return redirect()->back()
            ->with('error', "Kh??ng x??a ???????c");
    }


    public function show($slug, $id, Request $request)
    {
        $stories = $this->model
            ->where('user_id', auth()->id())
            ->get(['id', 'name']);

        $chapterPinFilter = $request->get('chapter_pin_filter');

        $chaptersQuery = Chapter::query()
            ->where('story_id', $id)
        ;

        if (isset($chapterPinFilter) && $chapterPinFilter !== 'All') {
            $chaptersQuery->where('pin', $chapterPinFilter);
        }

        $chapters = $chaptersQuery->paginate(5);

        $ChapterPinEnum = ChapterPinEnum::getValues();
        $ChapterPin = [];
        foreach ($ChapterPinEnum as $item) {
            $ChapterPin[$item] = ChapterPinEnum::getNameByValue($item);
        }

        $story = Story::query()->withCount('chapter')->where('user_id', Auth::id())
            ->with('author')
            ->where('slug', $slug)->first()
        ;

        $this->title = "$story->name";
        View::share('title', $this->title);

        return view("user.$this->table.show", [
            'story' => $story,
            'stories' => $stories,
            'chapters' => $chapters,
            'ChapterPin' => $ChapterPin,
            'chapterPinFilter' => $chapterPinFilter,
        ]);
    }

    public function find(Request $request)
    {
        $story_id = $request->get('story_id');
        $story = $this->model->find($story_id);
        return redirect()->route("user.$this->table.show", [$story->slug, $story->id]);
    }

    public function upload($id)
    {
        $story = $this->model->find($id);

        if ($story->pin > StoryPinEnum::EDITING) {
            Chapter::query()
                ->where('pin', '>', ChapterPinEnum::EDITING)
                ->where('story_id', $id)->update([
                'pin' => ChapterPinEnum::UPLOADING,
            ]);
            $story->update([
                'pin' => StoryPinEnum::EDITING,
            ]);
            return redirect()->back()->with('success', '???? g??? truy???n th??nh c??ng');
        }

        $chapter = Chapter::query()
            ->where('story_id', $story->id)
            ->where('pin','>', ChapterPinEnum::EDITING)
            ->count();

        if ($chapter === 0) {
            return redirect()->back()->with('error', 'Truy???n ph???i c?? ??t nh???t 1 ch????ng ????ng l??n');
        }
        if (Auth::user()->level_id === 1) {
            $story->update([
                'pin' => StoryPinEnum::UPLOADING,
            ]);
        } else {
            $story->update([
                'pin' => StoryPinEnum::APPROVED,
            ]);
            Chapter::query()->where('pin', ChapterPinEnum::UPLOADING)
                ->where('story_id', $id)
                ->update([
                'pin' => ChapterPinEnum::APPROVED,
            ]);
        }
        return redirect()->back()->with('success', '???? ????ng truy???n th??nh c??ng');
    }
}
