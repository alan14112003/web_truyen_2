@extends('layout.master')
@section('main')
    <div class="row">
        <div class="col-md-12">
            {{ Breadcrumbs::render('user.chapter.create', $story) }}
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 style="padding: 24px 24px 0;">{{ $title ?? '' }}</h3>
                    <hr>
                </div>
                <div class="content">
                    <form action="{{ route("user.stories.chapters.store", $story->slug) }}" method="post">
                        @csrf
                        <input type="hidden" name="story_id" value="{{ $story->id }}">
                        <div class="form-group">
                            <label for="name" class="control-label">Tên</label>
                            <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}">
                            @if ($errors->any())
                                <span class="text-danger">{{ $errors->first('name') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="content" class="control-label">Nội dung</label>
                            <textarea class="form-control" rows="4" name="content" id="content">
                            {{ old('content') }}
                            </textarea>
                            @if ($errors->any())
                                <span class="text-danger">{{ $errors->first('content') }}</span>
                            @endif
                        </div>
                        <div class="footer text-center">
                            <button class="btn btn-primary">Thêm</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @push('js')
    <script src="https://cdn.ckeditor.com/ckeditor5/35.2.0/classic/ckeditor.js"></script>
    <script>
        ClassicEditor.create(document.querySelector('#content'))
            .then(editor => {
                console.log(editor);
            })
            .catch(error => {
                console.error(error);
            });
    </script>
    @endpush
@endsection