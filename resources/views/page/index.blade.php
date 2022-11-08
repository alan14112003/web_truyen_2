@extends('layout.front_page.master')
@section('main')
    <section class="Breadcrumbs">
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Photos</a></li>
            <li class="breadcrumb-item"><a href="#">Summer 2017</a></li>
            <li class="breadcrumb-item"><a href="#">Italy</a></li>
            <li class="breadcrumb-item active">Rome</li>
          </ul>
    </section>
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
    <h2> Lịch sử đọc truyện</h2>
    @auth
        @if (isset($histories))
            @foreach ($histories as $history)
                <div class="history_item" id="history_item-{{ $history->story->id }}">
                    <a href='{{ route('show_story', $history->story->slug) }}'>
                        <img src='{{ $history->story->image_url }}' style='width: 100px; height: 120px;' alt='{{ $history->story->name }}'>
                        <span>{{ $history->story->name }}</span>
                    </a>
                    <a href='{{ route('show_chapter', [$history->story->slug, $history->chapter_number]) }}'>
                        đọc tiếp chương {{ $history->chapter_number }}
                    </a>
                    <a class="histories_close"
                       data-story_id="{{ $history->story_id }}"
                       data-history_item="history_item-{{ $history->story->id }}">Xóa</a>
                </div>
            @endforeach
        @endif
    @endauth
    @guest
        @if (isset($histories))
            @foreach ($histories as $history)
                <div class="history_item" id="history_item-{{ $history->story_id }}">
                    <a href='{{ route('show_story', $history->story_slug) }}'>
                    <img src='{{ $history->story_image }}' style='width: 100px; height: 120px;' alt='{{ $history->story_name }}'>
                    <span>{{ $history->story_name }}</span>
                    </a>
                    <a href='{{ route('show_chapter', [$history->story_slug, $history->chapter_number]) }}'>
                    đọc tiếp chương {{ $history->chapter_number }}
                    </a>
                    <a class="histories_close"
                       data-history_item="history_item-{{ $history->story_id }}"
                       data-story_id="{{ $history->story_id }}"
                    >Xóa</a>
                </div>
            @endforeach;
        @endif
    @endguest

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
