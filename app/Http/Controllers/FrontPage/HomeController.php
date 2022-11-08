<?php

namespace App\Http\Controllers\FrontPage;

use App\Enums\ChapterPinEnum;
use App\Enums\StoryPinEnum;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Chapter;
use App\Models\History;
use App\Models\Star;
use App\Models\Story;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index(Request $request): Factory|View|Application
    {
        $q = $request->get('q');

//      Lịch sử đọc truyện
        $histories = History::showHistoriesByGuest();
        if (Auth::check()) {
            $histories = History::showHistoriesByUser();
        }

//      Top đánh giá

//
        return view('page.index', [
            'q' => $q,
            'histories' => $histories,
//            danh sách tìm kiếm
        ]);
    }

    public function showCategories($slug)
    {
        $data = Story::query()->select([
            'stories.*'
        ])
            ->with('chapter')
            ->join('category_story as cs', 'cs.story_id', '=', 'stories.id')
            ->join('categories as c', 'c.id', '=', 'cs.category_id')
            ->where('c.slug', $slug)
            ->where('stories.pin', '>', StoryPinEnum::UPLOADING)
            ->inRandomOrder()
            ->get()
        ;
        return view('page.category', [
            '$data' => $data,
        ]);
    }

    public function showStory(Request $request,$slug)
    {
        $sort = $request->get('sort');

//        story
        $story = Story::query()
            ->with('categories')
            ->with('author')
            ->with('chapter', function ($qr) {
                $qr->where('pin', ChapterPinEnum::APPROVED);
            })
            ->where('slug', $slug)
            ->where('pin', '>', StoryPinEnum::UPLOADING)
            ->first()
        ;
//        số sao
        $stars = Star::query()->where('story_id', $story->id)->get();
        $starTotal = 0;
        $starPerson = count($stars);
        $starAvg = 0;
        if ($starPerson !== 0) {
            foreach ($stars as $star) {
                $starTotal += $star->total;
            }
            $starAvg = round( ( ($starTotal / ($starPerson * 5) ) * 5), 1);
        }

//        chapters
        $query = Chapter::query()
            ->where('pin', ChapterPinEnum::APPROVED)
            ->where('story_id', $story->id);

        if (isset($sort)) {
            $query->orderBy('number', $sort);
        }
        $chapters = $query->get();

        return view('page.story', [
            'story' => $story,
            'chapters' => $chapters,
            'sort' => $sort,
            'starAvg' => $starAvg,
            'starPerson' => $starPerson,
        ]);
    }

    public function showChapter($slug, $number)
    {
        $story = Story::query()->where('slug', $slug)->first();

//        thêm vào lich sử
        History::createHistory($story->id, $number);

        $chapter = Chapter::query()
            ->where('story_id', $story->id)
            ->where('pin', ChapterPinEnum::APPROVED)
            ->where('number', $number)->first();

        $chapterList = Chapter::query()
            ->where('pin', ChapterPinEnum::APPROVED)
            ->where('story_id', $story->id)
            ->pluck('number')
            ->toArray()
        ;

        $curent = array_search($chapter->number, $chapterList, true);
        $pre = $chapterList[$curent - 1] ?? '';
        $next = $chapterList[$curent + 1] ?? '';
        $first = reset($chapterList);
        $last = end($chapterList);

        return view('page.chapter', [
            'story' => $story,
            'chapter' => $chapter,
            'chapterList' => $chapterList,
            'pre' => $pre,
            'next' => $next,
            'first' => $first,
            'last' => $last,
        ]);
    }
}
