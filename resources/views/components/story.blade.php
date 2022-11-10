<div class="col-lg-3 col-sm-4 col-6">
    <div class="item_box">
        <a href="{{ route('show_story', $slug) }}">
            <div class="box_image">
                <img
                    src="{{ $image }}" alt="">
                <div class="box_view">
                    <i class="fa-regular fa-eye mr-1"></i>{{ $viewCount }} lượt xem
                </div>
            </div>
        </a>
        <div class="text_box">
            <p class="text_box_name text-capitalize">
                <a href="{{ route('show_story', $slug) }}">
                    {{ $name }}
                </a>
            </p>
            <p class="text_box_chapter">
                <span class="text_box_chapter_number">
                    <a href="{{ route('show_chapter', [$slug, $chapterNumber]) }}">
                        Chương {{ $chapterNumber }}
                    </a>
                </span>
                <span class="text_box_chapter_time">
                    {{ $chapterTime }}
                </span>
            </p>
        </div>
    </div>
</div>
