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
                                    <th>Info</th>
                                    <th>Cấp bậc</th>
                                    <th>Ảnh đại diện</th>
                                    <th>Xóa</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($data as $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td>
                                            <div style="display: flex">
                                                <span style="margin-right: 8px">{{ $user->name }}</span> -
                                                <span style="margin-left: 8px">{{ $user->gender_name }}</span>
                                            </div>
                                            <div>
                                                <a href="mailto:{{ $user->email }}" style="margin: 0 10px">{{ $user->email }}</a>
                                            </div>
                                        </td>
                                        <td>
                                            {{ $user->level->name}}
                                        </td>
                                        <td>
                                            <style>
                                                img:hover {
                                                    transform: scale(1.2);
                                                    transition: all 0.3s ease;
                                                }
                                            </style>
                                            @if(isset($user->avatar))
                                            <a href="{{ $user->avatar }}" target="_blank">

                                                <img style="width: 50px; height: 50px; object-fit: cover;"
                                                     src="{{ file_exists("storage/$user->avatar") ?
                                                     asset("storage/$user->avatar") : $user->avatar }}">
                                            </a>
                                            @else
                                                <img style="width: 50px; object-fit: cover;"
                                                     src="{{ asset('img/no_face.png') }}">
                                            @endif
                                        </td>
                                        <td>
                                            <form action="{{ route("admin.$table.destroy", $user->id) }}" method="post">
                                                @csrf
                                                @method('delete')
                                                <button class="pe-7s-trash text-danger" style="border: none; background: transparent"></button>
                                            </form>
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
