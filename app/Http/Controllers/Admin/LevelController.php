<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Level;
use Illuminate\Http\Request;

class LevelController extends Controller
{
    private $model;
    private $table;

    public function __construct()
    {
        $this->model = Level::query();
        $this->table = (new Level())->getTable();
    }

    public function index()
    {

    }
}
