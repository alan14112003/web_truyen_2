@extends('layout.master')
@section('main')
    @push('css')
        <style>
            [class^="pe-"] {
                font-size: 30px;
            }
        </style>
    @endpush
    <div class="row">
        @auth
            @if(auth()->user()->level_id === 2 || auth()->user()->level_id === 3)
                <a href="{{ route("admin.$table.create") }}" class="pe-7s-plus" style="font-size: 40px; margin: 24px;"></a>
            @endif
        @endauth
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    
                </div>
                <div class="card-body">
                    <div class="bootstrap-table">
                        <div class="content table-responsive table-full-width">
                            <table class="table table-hover table-striped">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Tên truyện</th>
                                    <th>Thể loại</th>
                                    <th>Mô tả</th>
                                    <th>Tình trạng</th>
                                    <th>Phân loại</th>
                                    <th>Tác giả</th>
                                    <th>Tác giả 2</th>
                                    <th>Người đăng</th>
                                    <th>Ảnh đại diện</th>
                                    <th>Trạng thái</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($data as $category)
                                    <tr>
                                        <td>{{ $category->id }}</td>
                                        <td>{{ $category->name }}</td>
                                        <td>{{ implode(', ', $category->categories->pluck('name')->toArray()) }}</td>
                                        <td>{{ $category->descriptions }}</td>
                                        <td>{{ \App\Enums\StoryStatusEnum::getNameByValue($category->status) }}</td>
                                        <td>{{ \App\Enums\StoryLevelEnum::getNameByValue($category->level) }}</td>
                                        <td>{{ $category->author->name }}</td>
                                        <td>{{ optional($category->author_2)->name }}</td>
                                        <td>{{ optional($category->user)->name }}</td>
                                        <td><img src="{{ $category->image }}"></td>
                                        <td>{{ \App\Enums\StoryPinEnum::getNameByValue($category->pin) }}</td>
                                        @auth
                                            @if(auth()->user()->level_id === 2 || auth()->user()->level_id === 3)
                                                <td class="td-actions text-right">
                                                    <div style="display: flex;">
                                                        <a rel="tooltip" data-original-title="Xem"
                                                           href="{{ route("admin.$table.edit", $category->id) }}"
                                                           class="btn btn-simple btn-info btn-icon table-action">
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                        @if($category->pin
                                                                === 1)
                                                        <a rel="tooltip" data-original-title="duyệt"
                                                           href="{{ route("admin.$table.edit", $category->id) }}"
                                                           class="btn btn-simple btn-success btn-icon table-action">
                                                            <i class="fa fa-check"></i>
                                                        </a>
                                                        @endif

                                                        <div
                                                             class="checkbox" style="margin-top: 8px;">
                                                            <input type="checkbox" id="pin-{{ $category->id }}"
                                                            {{ $category->pin === 3 ? 'checked' : '' }} >
                                                            <label data-original-title="ghim" rel="tooltip" for="pin-{{ $category->id }}"></label>
                                                        </div>

                                                        <form action="{{ route("admin.$table.destroy", $category->id) }}" method="post">
                                                            @csrf
                                                            @method('delete')
                                                            <button rel="tooltip" data-original-title="Xóa"
                                                                    class="btn btn-simple btn-danger btn-icon table-action">
                                                                    <i class="fa fa-remove"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            @endif
                                        @endauth
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="fixed-table-pagination">
                            <div class="pull-right pagination">
                                {{ $data->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
