<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class AdminController extends Controller
{
    public function index()
    {
        $allUsers = User::query()->count();
        $userCount = User::query()->where('level_id', '=', 1)->count();
        $censorCount = User::query()->where('level_id', '=', 2)->count();
        $adminCount = User::query()->where('level_id', '=', 3)->count();

        $userPercentage = round($userCount/$allUsers * 100);
        $censorPercentage = round($censorCount/$allUsers * 100);
        $adminPercentage = round($adminCount/$allUsers * 100);

        View::share('title', 'Quản lý');
        return view('admin.index', [
            'allUsers' => $allUsers,
            'userCount' => $userCount,
            'censorCount' => $censorCount,
            'adminCount' => $adminCount,

            'userPercentage' => $userPercentage,
            'censorPercentage' => $censorPercentage,
            'adminPercentage' => $adminPercentage,
        ]);
    }
}
