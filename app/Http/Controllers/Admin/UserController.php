<?php

namespace App\Http\Controllers\Admin;

use App\Enums\StoryPinEnum;
use App\Enums\UserGenderEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreRequest;
use App\Models\Level;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View as ViewAlias;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Throwable;
use function PHPUnit\Framework\directoryExists;

class UserController extends Controller
{
    private Builder $model;
    private string $table;
    private string $title;

    public function __construct()
    {
        $this->model = User::query();
        $this->table = (new User())->getTable();

        View::share('table', $this->table);
    }

    /**
     * @param Request $request
     * @return Application|Factory|ViewAlias
     */
    //    : ViewAlias|Factory|Application
    public function index(Request $request)
    {
        $q = $request->get('q');
        $genderFilter = $request->get('gender');
        $levelFilter = $request->get('level_id');

        $query = $this->model
            ->select('*')
            ->selectSub('Select count(*) from stories where user_id = users.id and pin > '. StoryPinEnum::UPLOADING , 'story_count')
            ->with('level')
            ->where('name', 'like', "%$q%")
            ->whereNot('id', Auth::user()->id)
            ->latest();

        if (isset($genderFilter) && $genderFilter !== 'All') {
            $query = $query->where('gender', $genderFilter);
        }
        if (isset($levelFilter) && $levelFilter !== 'All') {
            $query = $query->where('level_id', $levelFilter);
        }

        $data = $query->paginate();

        //        genders
        $gendersEnum = UserGenderEnum::getValues();
        $genders = [];
        foreach ($gendersEnum as $gender) {
            $genders[$gender] = UserGenderEnum::getNameByValue($gender);
        }

        //       level
        $levels = Level::query()->get([
            'id',
            'name',
        ]);


        $this->title = 'Qu???n l?? ng?????i d??ng';
        View::share('title', $this->title);

        return view("admin.$this->table.index", [
            'data' => $data,
            'q' => $q,
            'genders' => $genders,
            'levels' => $levels,
            'genderFilter' => $genderFilter,
            'levelFilter' => $levelFilter,
        ]);
    }

    public function blackList(Request $request)
    {
        $q = $request->get('q');
        $genderFilter = $request->get('gender');
        $levelFilter = $request->get('level_id');

        $query = User::onlyTrashed()->with('level')
            ->where('name', 'like', "%$q%")->latest();

        if (isset($genderFilter) && $genderFilter !== 'All') {
            $query = $query->where('gender', $genderFilter);
        }
        if (isset($levelFilter) && $levelFilter !== 'All') {
            $query = $query->where('level_id', $levelFilter);
        }

        $data = $query->paginate();

        //        genders
        $gendersEnum = UserGenderEnum::getValues();
        $genders = [];
        foreach ($gendersEnum as $gender) {
            $genders[$gender] = UserGenderEnum::getNameByValue($gender);
        }

        //       level
        $levels = Level::query()->get([
            'id',
            'name',
        ]);

        $this->title = 'S??? ??en';
        View::share('title', $this->title);

        return view("admin.$this->table.black_list", [
            'data' => $data,
            'q' => $q,
            'genders' => $genders,
            'levels' => $levels,
            'levelFilter' => $levelFilter,
            'genderFilter' => $genderFilter,
        ]);
    }

    public function create()
    {
        //        genders
        $gendersEnum = UserGenderEnum::getValues();
        $genders = [];
        foreach ($gendersEnum as $gender) {
            $genders[$gender] = UserGenderEnum::getNameByValue($gender);
        }

        //       level
        $levels = Level::query()->get([
            'id',
            'name',
        ]);

        $this->title = 'Th??m Ng?????i d??ng';
        View::share('title', $this->title);
        return view("admin.$this->table.create", [
            'genders' => $genders,
            'levels' => $levels,
        ]);
    }

    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        $avatar = $request->file('avatar');
        $data['avatar'] = null;
        $data['password'] = Hash::make($data['password']);
        $newUser = $this->model->create($data);

        if (isset($avatar)) {
            $fileAvatarExtension = $request->file('avatar')->extension();
            $fileAvatarName = "avatar.$fileAvatarExtension";
            $fileAvatarUrl = Storage::disk('public')->putFileAs("avatars/$newUser->id", $request->file('avatar'), $fileAvatarName);

            $newUser->update([
                'avatar' => $fileAvatarUrl,
            ]);
        }

        return redirect()->route("admin.$this->table.index")
            ->with('success', '???? th??m th??nh c??ng');
    }

    public function destroy($id)
    {
        $this->model->find($id)->delete();

        return redirect()->route("admin.$this->table.index")
            ->with('success', '???? ????a v??o s??? ??en');
    }

    public function restore($id)
    {
        if ($user = User::onlyTrashed()->find($id)) {
            $user->restore();

            return redirect()->route("admin.$this->table.black_list")
                ->with('success', '???? kh??i ph???c th??nh c??ng');
        }
        return redirect()->route("admin.$this->table.black_list")
            ->with('success', 'Kh??ng c?? ng?????i n??y');
    }

    public function kill($id)
    {
            if ($user = User::onlyTrashed()->find($id)) {
                if (File::isFile("storage/$user->avatar")) {
                    $link = "storage/$user->avatar";
                    $path = "storage/avatars/$user->id";
                    unlink($link);
                    rmdir($path);
                }
                $user->forceDelete();

                return redirect()->route("admin.$this->table.black_list")
                    ->with('success', '???? x??a v??nh vi???n ng?????i n??y');
            }

        return redirect()->route("admin.$this->table.black_list")
            ->with('success', "Kh??ng th??nh c??ng");
    }
}
