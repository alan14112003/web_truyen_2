<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class View extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'story_id',
        'chapter_id'
    ];


    public static function createView($user_id, $story_id, $chapter_id)
    {
        View::query()->where('user_id', $user_id)
            ->where('story_id', $story_id)
            ->where('chapter_id', $chapter_id)
            ->firstOrCreate();
    }
}
