<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use stdClass;

class History extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'story_id',
        'chapter_number',
    ];

    public function story()
    {
        return $this->belongsTo(Story::class);
    }

    public static function createHistory($story_id, $chapter_number)
    {
        if (Auth::check()) {
            $history = History::query()
                ->firstOrCreate([
                    'user_id' => Auth::id(),
                    'story_id' => $story_id,
                ]);
            ;
            $history->chapter_number = $chapter_number;
            $history->save();
        } else {
            $name = 'history_Stories';
            $time = time() + (86400 * 30);
            $data = new stdClass;
            $history = new stdClass;
            $story = Story::query()->find($story_id, [
                'id',
                'name',
                'image',
                'slug',
            ]);
            $history->story_id = $story->id;
            $history->story_name = $story->name;
            $history->story_image = $story->image_url;
            $history->story_slug = $story->slug;
            $history->chapter_number = $chapter_number;
            if (isset($_COOKIE[$name])) {
                $data = json_decode($_COOKIE[$name]);
            }
            $data->$story_id = $history;
            setcookie($name, json_encode($data), $time, '/');
        }
    }

    public static function showHistoriesByUser(): Collection|array
    {
        return History::query()
            ->with('story')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();
    }


    public static function showHistoriesByGuest(): ?array
    {
        $name = 'history_Stories';
        if (!isset($_COOKIE[$name])) {
            return null;
        }
        $data = (array)json_decode($_COOKIE[$name]);
        return array_reverse($data);
    }

    public static function getHistoriesByGuest()
    {
        $name = 'history_Stories';
        if (!isset($_COOKIE[$name])) {
            return null;
        }
        return json_decode($_COOKIE[$name]);
    }

}
