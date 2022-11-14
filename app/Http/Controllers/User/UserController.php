<?php

namespace App\Http\Controllers\User;

use App\Enums\ChapterPinEnum;
use App\Enums\StoryPinEnum;
use App\Http\Controllers\Controller;
use App\Models\Chapter;
use App\Models\Star;
use App\Models\Story;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class UserController extends Controller
{
    public function index()
    {

        $starQr = Star::query()
            ->groupBy('story_id');

        $approvedStories = Story::query()
            ->select('*')
            ->withCount('view')
            ->selectSub("
            select count(number)
            from chapters
            where story_id = stories.id and pin = ". ChapterPinEnum::APPROVED ."
            order by number desc limit 1
            ", 'chapter_count')
                ->withAvg('star', 'total')
            ->where('pin', '>', StoryPinEnum::UPLOADING)
            ->where('user_id', Auth::id())
            ->latest()
            ->get()
        ;

        $uploadingStories = Story::query()
            ->select('*')
            ->selectSub("
            select count(number)
            from chapters
            where story_id = stories.id
            order by number desc limit 1
            ", 'chapter_count')
            ->where('pin', StoryPinEnum::UPLOADING)
            ->where('user_id', Auth::id())
            ->latest()
            ->get()
        ;

        $editingStories = Story::query()
            ->select('*')
            ->selectSub("
            select count(number)
            from chapters
            where story_id = stories.id
            order by number desc limit 1
            ", 'chapter_count')
            ->where('pin', StoryPinEnum::EDITING)
            ->where('user_id', Auth::id())
            ->latest()
            ->get()
        ;

        $notApprovedStories = Story::query()
            ->select('*')
            ->selectSub("
            select count(number)
            from chapters
            where story_id = stories.id
            order by number desc limit 1
            ", 'chapter_count')
            ->where('pin', StoryPinEnum::NOT_APPROVE)
            ->where('user_id', Auth::id())
            ->latest()
            ->get()
        ;

        $chapters = Story::query()
            ->join('chapters', 'stories.id', '=', 'chapters.story_id')
            ->where('chapters.pin', '=', ChapterPinEnum::NOT_APPROVE)
            ->where('user_id', Auth::id())
            ->oldest('chapters.updated_at')
            ->get(['stories.*', 'chapters.number'])
        ;

        View::share('title', 'Tổng hợp truyện');
        return view('user.index', [
            'approvedStories' => $approvedStories,
            'uploadingStories' => $uploadingStories,
            'notApprovedStories' => $notApprovedStories,
            'editingStories' => $editingStories,
            'chapters' => $chapters,
        ]);
    }
}
