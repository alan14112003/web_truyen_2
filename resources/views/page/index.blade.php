@extends('layout.front_page.master')
@section('main')
    @push('css')
        <link rel="stylesheet" href="{{ asset('front_asset/css/style.css') }}">
        <link rel="stylesheet" href="{{ asset('front_asset/css/own/index.css') }}">
        <link rel="stylesheet" href="{{ asset('front_asset/css/own/owl.carousel.min.css') }}">
        <link rel="stylesheet" href="{{ asset('front_asset/css/own/owl.theme.default.min.css') }}">
    @endpush
    <section class="banner">
        <div class="banner__item banner__left__top">
            <img src="https://i.truyenvua.xyz/slider/290x191/slider_1559213484.jpg?gf=hdfgdfg&mobile=2" alt="">
        </div>
        <div class="banner__item banner__left__bottom">
            <img src="https://i.truyenvua.xyz/slider/290x191/slider_1560493497.jpg?gf=hdfgdfg&mobile=2" alt="">
        </div>
        <div class="banner__item banner__right__top">
            <img src="https://i.truyenvua.xyz/slider/290x191/slider_1567830171.jpg?gf=hdfgdfg&mobile=2" alt="">
        </div>
        <div class="banner__item banner__right__bottom">
            <img src="https://i.truyenvua.xyz/slider/290x191/slider_1561609693.jpg?gf=hdfgdfg&mobile=2" alt="">
        </div>
        <div class="banner__item banner__center">
            <img src="https://i.truyenvua.xyz/slider/583x386/slider_1560573084.jpg?gf=hdfgdfg&mobile=2" alt="">
        </div>
    </section>

    <div class="row">
        <div class="mb-3 col-12 col-md-8">
            <div class="mt-4 mb-1 d-flex justify-content-between">
                <h3 class="fit-width" style="color: #2980b9;"> Truyện mới</h3>
                <a href="{{ route('advanced_search') }}" class="btn btn-outline-warning">
                    <i class="fa-solid fa-filter text-success"></i>
                </a>
            </div>
            <div class="row">
                @foreach($stories as $story)
                    <x-story :story="$story"/>
                @endforeach
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="row mt-4">
                <!-- -----------history---------- -->

                <div class="col-12 mb-3">
                    <div class="history">
                        <div class="history_title">
                            Lịch sử đọc truyện
                        </div>

                        @auth
                            @if (isset($histories))
                                <div class="history_list">
                                @foreach ($histories as $history)
                                        <div class="list_li history_item" id="history_item-{{ $history->story->id }}">
                                            <div class="history_img">
                                                <a href="{{ route('show_story', $history->story->slug) }}">
                                                    <img src="{{ $history->story->image_url }}" alt="{{ $history->story->name }}">
                                                </a>
                                            </div>
                                            <div class="history_info">
                                                <p class="history_info_name">
                                                    <a href="{{ route('show_story', $history->story->slug) }}">
                                                        {{ $history->story->name }}
                                                    </a>
                                                </p>
                                                <div class="history_info_chapter d-flex justify-content-between">
                                            <span class="history_info_chapter_number">
                                                <a href="{{ route('show_chapter', [$history->story->slug, $history->chapter_number]) }}">
                                                    Đọc tiếp chương {{ $history->chapter_number }}
                                                </a>
                                            </span>
                                                    <a class="history_info_chapter_delete histories_close"
                                                       data-story_id="{{ $history->story_id }}"
                                                       data-history_item="history_item-{{ $history->story->id }}">
                                                        <i class="fa-solid fa-xmark"></i> Xóa
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                @endforeach
                                </div>
                            @endif
                        @endauth
                        @guest
                            @if (isset($histories))
                                <div class="history_list">
                                @foreach ($histories as $history)
                                        <div class="list_li history_item" id="history_item-{{ $history->story_id }}">
                                            <div class="history_img">
                                                <a href="{{ route('show_story', $history->story_slug) }}">
                                                    <img src="{{ $history->story_image }}" alt="{{ $history->story_name }}">
                                                </a>
                                            </div>
                                            <div class="history_info">
                                                <p class="history_info_name">
                                                    <a href="{{ route('show_story', $history->story_slug) }}">
                                                        {{ $history->story_name }}
                                                    </a>
                                                </p>
                                                <div class="history_info_chapter d-flex justify-content-between">
                                            <span class="history_info_chapter_number">
                                                <a href="{{ route('show_chapter', [$history->story_slug, $history->chapter_number]) }}">
                                                    Đọc tiếp Chương {{ $history->chapter_number }}
                                                </a>
                                            </span>
                                                    <a class="history_info_chapter_delete histories_close"
                                                       data-history_item="history_item-{{ $history->story_id }}"
                                                       data-story_id="{{ $history->story_id }}"
                                                    >
                                                        <i class="fa-solid fa-xmark"></i> Xóa
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                @endforeach
                                </div>
                            @endif
                        @endguest
                    </div>
                </div>

                <!-- --------top truyen---------- -->
                <div class="col-12 mb-3">
                    <div class="rank_top">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active"
                                   id="top-star-tab"
                                   data-toggle="tab"
                                   href="#top-star"
                                   role="tab"
                                   aria-controls="top-star"
                                   aria-selected="true">Top đánh giá</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link"
                                   id="top-month-tab"
                                   data-toggle="tab"
                                   href="#top-month"
                                   role="tab"
                                   aria-controls="top-month"
                                   aria-selected="false">Top tháng</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link"
                                   id="top-week-tab"
                                   data-toggle="tab"
                                   href="#top-week"
                                   role="tab"
                                   aria-controls="top-week"
                                   aria-selected="false">Top tuần</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link"
                                   id="top-day-tab"
                                   data-toggle="tab"
                                   href="#top-day"
                                   role="tab"
                                   aria-controls="top-day"
                                   aria-selected="false">Top ngày</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active"
                                 id="top-star"
                                 role="tabpanel"
                                 aria-labelledby="top-star-tab">
                                @foreach($topFiveStars as $key => $topStarItem)
                                    <div class="list_li">
                                        <div class="rank_top_number">
                                            <span class="pos{{ ++$key }}">0{{ $key }}</span>
                                        </div>
                                        <div class="rank_top_img">
                                            <a href="{{ route('show_story', $topStarItem->name) }}">
                                                <img src="{{ $topStarItem->image_url }}" alt="{{ $topStarItem->name }}">
                                            </a>
                                        </div>
                                        <div class="rank_top_info">
                                            <p class="rank_top_info_name">
                                                <a href="{{ route('show_story', $topStarItem->name) }}">
                                                    {{ $topStarItem->name }}
                                                </a>
                                            </p>
                                            <div class="rank_top_info_chapter">
                                                    <span class="rank_top_info_chapter_number">
                                                        <a href="#">
                                                            Chương {{ $topStarItem->chapter_new_number }}
                                                        </a>
                                                    </span>
                                                <div class="rank_top_info_chapter_views">
                                                    <i class="fa-regular fa-star"></i> {{ $topStarItem->totalStar }}/{{ $topStarItem->number_user }} người
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="tab-pane fade" id="top-month" role="tabpanel" aria-labelledby="top-month-tab">
                                @foreach($topFiveViewMonth as $key => $topViewMonthItem)
                                    <div class="list_li">
                                        <div class="rank_top_number">
                                            <span class="pos{{ ++$key }}">0{{ $key }}</span>
                                        </div>
                                        <div class="rank_top_img">
                                            <a href="{{ route('show_story', $topViewMonthItem->slug) }}">
                                                <img src="{{ $topViewMonthItem->image_url }}" alt="{{ $topViewMonthItem->name }}">
                                            </a>
                                        </div>
                                        <div class="rank_top_info">
                                            <p class="rank_top_info_name">
                                                <a href="{{ route('show_story', $topViewMonthItem->slug) }}">
                                                    {{ $topViewMonthItem->name }}
                                                </a>
                                            </p>
                                            <div class="rank_top_info_chapter">
                                                    <span class="rank_top_info_chapter_number">
                                                        <a href="{{ route('show_chapter', [$topViewMonthItem->slug, $topViewMonthItem->chapter_new_number]) }}">
                                                            Chương {{ $topViewMonthItem->chapter_new_number }}
                                                        </a>
                                                    </span>
                                                <div class="rank_top_info_chapter_views">
                                                    <i class="fa-regular fa-eye"></i> {{ $topViewMonthItem->chapter_new_number }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="tab-pane fade" id="top-week" role="tabpanel" aria-labelledby="top-week-tab">
                                @foreach($topFiveViewWeek as $key => $topViewWeekItem)
                                    <div class="list_li">
                                        <div class="rank_top_number">
                                            <span class="pos{{ ++$key }}">0{{ $key }}</span>
                                        </div>
                                        <div class="rank_top_img">
                                            <a href="{{ route('show_story', $topViewWeekItem->slug) }}">
                                                <img src="{{ $topViewWeekItem->image_url }}" alt="{{ $topViewWeekItem->name }}">
                                            </a>
                                        </div>
                                        <div class="rank_top_info">
                                            <p class="rank_top_info_name">
                                                <a href="{{ route('show_story', $topViewWeekItem->slug) }}">
                                                    {{ $topViewWeekItem->name }}
                                                </a>
                                            </p>
                                            <div class="rank_top_info_chapter">
                                                    <span class="rank_top_info_chapter_number">
                                                        <a href="{{ route('show_chapter', [$topViewWeekItem->slug, $topViewWeekItem->chapter_new_number]) }}">
                                                            Chương {{ $topViewWeekItem->chapter_new_number }}
                                                        </a>
                                                    </span>
                                                <div class="rank_top_info_chapter_views">
                                                    <i class="fa-regular fa-eye"></i> {{ $topViewWeekItem->chapter_new_number }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="tab-pane fade" id="top-day" role="tabpanel" aria-labelledby="top-day-tab">
                                <div class="list_li">
                                    <div class="rank_top_number">
                                        <span class="pos1">01</span>
                                    </div>
                                    <div class="rank_top_img">
                                        <a href="">
                                            <img src="https://img.8cache.com/hot-9.jpg" alt="">
                                        </a>
                                    </div>
                                    <div class="rank_top_info">
                                        <p class="rank_top_info_name">
                                            <a href="/HTML/Truyen/idol.html">
                                                [Vong Tiện] Idol Tiện Kỳ Ảo Chi Lữ sy gdfgdfhssgfbgfjhf sêgsdhfg
                                            </a>
                                        </p>
                                        <div class="rank_top_info_chapter">
                                                <span class="rank_top_info_chapter_number">
                                                    <a href="#">
                                                        Chương 1
                                                    </a>
                                                </span>
                                            <div class="rank_top_info_chapter_views">
                                                <i class="fa-regular fa-eye"></i>1000
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="list_li">
                                    <div class="rank_top_number">
                                        <span class="pos2">02</span>
                                    </div>
                                    <div class="rank_top_img">
                                        <a href="">
                                            <img src="https://img.8cache.com/hot-9.jpg" alt="">
                                        </a>
                                    </div>
                                    <div class="rank_top_info">
                                        <p class="rank_top_info_name">
                                            <a href="/HTML/Truyen/idol.html">
                                                [Vong Tiện] Idol Tiện Kỳ Ảo Chi Lữ sy gdfgdfhssgfbgfjhf sêgsdhfg
                                            </a>
                                        </p>
                                        <div class="rank_top_info_chapter">
                                                <span class="rank_top_info_chapter_number">
                                                    <a href="#">
                                                        Chương 1
                                                    </a>
                                                </span>
                                            <div class="rank_top_info_chapter_views">
                                                <i class="fa-regular fa-eye"></i>1000
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="list_li">
                                    <div class="rank_top_number">
                                        <span class="pos3">03</span>
                                    </div>
                                    <div class="rank_top_img">
                                        <a href="">
                                            <img src="https://img.8cache.com/hot-9.jpg" alt="">
                                        </a>
                                    </div>
                                    <div class="rank_top_info">
                                        <p class="rank_top_info_name">
                                            <a href="/HTML/Truyen/idol.html">
                                                [Vong Tiện] Idol Tiện Kỳ Ảo Chi Lữ sy gdfgdfhssgfbgfjhf sêgsdhfg
                                            </a>
                                        </p>
                                        <div class="rank_top_info_chapter">
                                                <span class="rank_top_info_chapter_number">
                                                    <a href="#">
                                                        Chương 1
                                                    </a>
                                                </span>
                                            <div class="rank_top_info_chapter_views">
                                                <i class="fa-regular fa-eye"></i>1000
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="list_li">
                                    <div class="rank_top_number">
                                        <span>04</span>
                                    </div>
                                    <div class="rank_top_img">
                                        <a href="">
                                            <img src="https://img.8cache.com/hot-9.jpg" alt="">
                                        </a>
                                    </div>
                                    <div class="rank_top_info">
                                        <p class="rank_top_info_name">
                                            <a href="/HTML/Truyen/idol.html">
                                                [Vong Tiện] Idol Tiện Kỳ Ảo Chi Lữ sy gdfgdfhssgfbgfjhf sêgsdhfg
                                            </a>
                                        </p>
                                        <div class="rank_top_info_chapter">
                                                <span class="rank_top_info_chapter_number">
                                                    <a href="#">
                                                        Chương 1
                                                    </a>
                                                </span>
                                            <div class="rank_top_info_chapter_views">
                                                <i class="fa-regular fa-eye"></i>1000
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('js')
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function()
            {
                const historiesClose = $('.histories_close')
                historiesClose.each(function(index, historyClose) {
                    historyClose.onclick = (e) => {
                        let idHistoryElement = e.target.dataset.history_item
                        const historyElement = $('#' + idHistoryElement)
                        const story_id = e.target.dataset.story_id
                        submitDestroyHistory(story_id)
                        historyElement.remove()
                    }
                })

                // khi thực hiện kích vào nút Sign in
                function submitDestroyHistory(story_id)
                {
                    let data = {
                        "_token": "{{ csrf_token() }}",
                        'story_id' : story_id,
                    }
                    //Sử dụng hàm $.ajax()
                    $.ajax({
                        type : 'POST', //kiểu post
                        url  : '{{ route('history.destroy') }}', //gửi dữ liệu sang trang submit.php
                        data : data,
                        success :  function(data)
                        {
                            if($.isEmptyObject(data.error)){
                                console.log(data.success);
                            }else{
                                console.log(data.error);
                            }
                        }
                    });
                    return false;
                }
            });
        </script>
    @endpush
@endsection
