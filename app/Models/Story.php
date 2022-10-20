<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Story extends Model
{
    use HasFactory;
    protected $fillable = [
        "name",
        "status",
        "author",
        "author_2",
        "descriptions",
        "level",
        "pin",
        "user_id",
        "image",
        "slug",
    ];
}