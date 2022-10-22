<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View as ViewAlias;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
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
    public function index(Request $request): ViewAlias|Factory|Application
    {
        $q = $request->get('q');
        $query = $this->model->where('name', 'like', "%$q%");
        $data = $query->paginate();


        $this->title = 'Quản lý người dùng';
        View::share('title', $this->title);

        return view("admin.$this->table.index", [
            'data' => $data,
            'q' => $q,
        ]);
    }

}
