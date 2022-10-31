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
        <div class="col-md-12">
            {{ Breadcrumbs::render('admin.levels.index') }}
        </div>
    </div>
    <div class="row">
        <a href="{{ route("admin.$table.create") }}" class="pe-7s-plus" style="font-size: 40px; margin: 24px;">
        </a>
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
                                    <th>Tên</th>
                                    <th>Mô tả</th>
                                    <th>Số lượng</th>
                                    <th>Hành động</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($data as $level)
                                    <tr>
                                        <td>{{ $level->id }}</td>
                                        <td>{{ $level->name }}</td>
                                        <td>{{ $level->descriptions }}</td>
                                        <td>{{ $level->user_count }}</td>
                                        <td>
                                        <div style="display: flex;">
                                            <a href="{{ route("admin.$table.edit", $level->id) }}" class="pe-7s-note">
                                            </a>
                                            @if($level->id > 3)
                                            <form action="{{ route("admin.$table.destroy", $level->id) }}" method="post">
                                                @csrf
                                                @method('delete')
                                                <button class="pe-7s-trash text-danger" style="border: none; background: transparent"></button>
                                            </form>
                                            @else
                                                <button class="pe-7s-trash text-danger" disabled
                                                        style="border: none; background: transparent; cursor: no-drop">
                                                </button>
                                            @endif
                                        </div>
                                        </td>
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
