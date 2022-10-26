<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "descriptions",
    ];

    public function stories()
    {
        return $this->belongsToMany(Story::class, 'category_story',
            'category_id', 'story_id');
    }
}
