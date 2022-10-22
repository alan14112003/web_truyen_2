<?php

namespace App\Http\Controllers\Admin;

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
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;

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
        $query = $this->model->with('level')
            ->where('name', 'like', "%$q%")
        ->whereNot('id', Auth::user()->id);
        $data = $query->paginate();


        $this->title = 'Quản lý người dùng';
        View::share('title', $this->title);
        return view("admin.$this->table.index", [
            'data' => $data,
            'q' => $q,
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

        $this->title = 'Thêm Người dùng';
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
            $fileAvatarName = "$request->name.$fileAvatarExtension";
            $fileAvatarUrl = Storage::disk('public')->putFileAs("avatars/$newUser->id", $request->file('avatar'), $fileAvatarName);

            $newUser->update([
                'avatar' => $fileAvatarUrl,
            ]);
        }

        return redirect()->route("admin.$this->table.index")
            ->with('success', 'Đã thêm thành công');
    }

    public function destroy($id)
    {
        $this->model->find($id)->delete();

        return redirect()->route("admin.$this->table.index")
            ->with('success', 'Đã xóa thành công');
    }

}
