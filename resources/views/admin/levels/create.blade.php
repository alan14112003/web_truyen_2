@extends('layout.master')
@section('main')
    @push('css')
    <style>
        .card {
            max-width: 400px;
            margin: auto;
        }
    </style>
    @endpush
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                </div>
                <div class="content">
                    <form action="{{ route("admin.$table.store") }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="name" class="control-label">Tên</label>
                            <input type="text" class="form-control" name="name" id="name">
                        </div>
                        <div class="form-group">
                            <label for="describe" class="control-label">Mô tả</label>
                            <textarea class="form-control" rows="4" name="describe" id="describe">
                            </textarea>
                        </div>
                        <div class="footer text-center">
                            <button class="btn btn-primary">Thêm</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
