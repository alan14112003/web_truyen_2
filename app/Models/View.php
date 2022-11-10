<?php

namespace App\Models;

use App\Enums\ChapterPinEnum;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
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
        View::query()
            ->firstOrCreate(
                [
                    'user_id' => $user_id,
                    'story_id' => $story_id,
                    'chapter_id' => $chapter_id
                ],
                [
                    'user_id' => $user_id,
                    'story_id' => $story_id,
                    'chapter_id' => $chapter_id
                ]
            );
    }

    public static function showTopViewMonth(): Collection|array
    {
        $expDate = Carbon::now()->subDays(30);

        $topViewMonthQuery = View::query()->selectRaw('COUNT(*) as view_number, story_id')
            ->whereDate('created_at', '>',$expDate)
            ->groupBy('story_id')
        ;

        return Story::query()
            ->select('*')
            ->selectSub("
            select number
            from chapters
            where story_id = stories.id and pin = ". ChapterPinEnum::APPROVED ."
            order by number desc limit 1
            ", 'chapter_new_number')
            ->joinSub($topViewMonthQuery, 'rank_view', 'id', '=', 'rank_view.story_id')
            ->orderBy('view_number', 'desc')
            ->limit(5)
            ->get();
    }

    public static function showTopViewWeek(): Collection|array
    {
        $expDate = Carbon::now()->subDays(7);

        $topViewMonthQuery = View::query()->selectRaw('COUNT(*) as view_number, story_id')
            ->whereDate('created_at', '>',$expDate)
            ->groupBy('story_id')
        ;

        return Story::query()
            ->select('*')
            ->selectSub("
            select number
            from chapters
            where story_id = stories.id and pin = ". ChapterPinEnum::APPROVED ."
            order by number desc limit 1
            ", 'chapter_new_number')
            ->joinSub($topViewMonthQuery, 'rank_view', 'id', '=', 'rank_view.story_id')
            ->orderBy('view_number', 'desc')
            ->limit(5)
            ->get();
    }

    public static function showTopViewDay(): Collection|array
    {
        $expDate = Carbon::now()->subDays();

        $topViewMonthQuery = View::query()->selectRaw('COUNT(*) as view_number, story_id')
            ->whereDate('created_at', '>',$expDate)
            ->groupBy('story_id')
        ;

        return Story::query()
            ->select('*')
            ->selectSub("
            select number
            from chapters
            where story_id = stories.id and pin = ". ChapterPinEnum::APPROVED ."
            order by number desc limit 1
            ", 'chapter_new_number')
            ->joinSub($topViewMonthQuery, 'rank_view', 'id', '=', 'rank_view.story_id')
            ->orderBy('view_number', 'desc')
            ->limit(5)
            ->get();
    }
}
