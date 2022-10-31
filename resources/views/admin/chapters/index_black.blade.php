@extends('layout.master')
@section('main')
    @push('css')
        <style>
            .story_name h2 {
                font-size: 2.4rem;
                margin: 0 0 5px;
                line-height: 35px;
                text-transform: uppercase;
                font-family: "Roboto Condensed", Tahoma, sans-serif;
                text-align: center;
            }

            .chapter_name {
                font-size: 1.6rem;
                margin: 0 0 5px;
                line-height: 35px;
                text-align: center;
            }

            hr.chapter-start {
                background: url(//static.8cache.com/img/spriteimg_new_white_op.png) -200px -27px no-repeat;
                width: 59px;
                height: 20px;
            }

            hr.chapter-end {
                background: url(//static.8cache.com/img/spriteimg_new_white_op.png) 0 -51px no-repeat;
                width: 277px;
                height: 35px;
            }

            .button_box {
                margin: 24px auto;
                width: fit-content;
                display: flex;
                flex-wrap: wrap;
            }

            .dropdown,
            .dropup {
                margin: 0 8px;
            }

            .content {
                max-width: 1000px;
                margin: auto;
            }

            .content p {
                text-align: justify;
                font-size: 2.2rem;
            }
            @media screen and (max-width: 63.9375em){
                .button_box .btn-wd {
                    min-width: fit-content;
                    padding: 8px 8px;
                }
            }
        </style>
    @endpush
    <div class="row">
        <div class="col-md-12">
            {{ Breadcrumbs::render('admin.chapters.index_black', $story, $chapter) }}
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="story_name">
                <h2 class="text-info">{{ $story->name }}</h2>
            </div>
            <div class="chapter_name">
                <span>Chương </span> {{ $chapter->number }}: {{ $chapter->name }}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <hr class="chapter-start">
            <div class="button_box">
                <a href="{{ route("admin.stories.$table.index_black", ['id' => $story->id, 'number' => $chapter->number - 1]) }}"
                    class="btn btn-info btn-fill btn-wd @if ($chapter->number === 1) disabled @endif">
                    Chương trước</a>
                <div class="dropdown">
                    <button class="btn btn-info btn-fill dropdown-toggle" type="button" data-toggle="dropdown">Chọn
                        chương
                        <span class="caret"></span></button>
                    <ul class="dropdown-menu">
                        @foreach ($chapterList as $chapterItem)
                            <li @if ($chapterItem === $chapter->number) class="active disabled" @endif><a
                                    href="{{ route("admin.stories.$table.index_black", ['id' => $story->id, 'number' => $chapterItem]) }}">Chương
                                    {{ $chapterItem }}</a></li>
                        @endforeach
                    </ul>
                </div>
                <a href="{{ route("admin.stories.$table.index_black", ['id' => $story->id, 'number' => $chapter->number + 1]) }}"
                    class="btn btn-info btn-fill btn-wd @if ($chapter->number === count($chapterList)) disabled @endif">Chương sau
                </a>
            </div>
            <hr class="chapter-end">
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="content">
                {!! $chapter->content !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <hr class="chapter-end">
            <div class="button_box">
                <a href="{{ route("admin.stories.$table.index_black", ['id' => $story->id, 'number' => $chapter->number - 1]) }}"
                   class="btn btn-info btn-fill btn-wd @if ($chapter->number === 1) disabled @endif">
                    Chương trước</a>
                <div class="dropup">
                    <button class="btn btn-info btn-fill dropdown-toggle" type="button" data-toggle="dropdown">Chọn
                        chương
                        <span class="caret"></span></button>
                    <ul class="dropdown-menu">
                        @foreach ($chapterList as $chapterItem)
                            <li @if ($chapterItem === $chapter->number) class="active disabled" @endif><a
                                    href="{{ route("admin.stories.$table.index_black", ['id' => $story->id, 'number' => $chapterItem]) }}">Chương
                                    {{ $chapterItem }}</a></li>
                        @endforeach
                    </ul>
                </div>
                <a href="{{ route("admin.stories.$table.index_black", ['id' => $story->id, 'number' => $chapter->number + 1]) }}"
                   class="btn btn-info btn-fill btn-wd @if ($chapter->number === count($chapterList)) disabled @endif">Chương sau
                </a>
            </div>
        </div>
    </div>
@endsection
