<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Story;
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
        DB::enableQueryLog();
        $query = $this->model->with('categories')
            ->find(2);
//            ->where('name', 'like', "%$q%");
//        $data = $query->paginate();

        dd(DB::getQueryLog());

        $this->title = 'Danh sách truyện';
        View::share('title', $this->title);

        return view("user.$this->table.index", [
            'data' => $data,
            'q' => $q,
        ]);
    }
}
