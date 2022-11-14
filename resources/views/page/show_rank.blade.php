@extends('layout.front_page.master')
@section('main')
    @push('css')
        <link rel="stylesheet" href="{{ asset('front_asset/css/own/index.css') }}">
    @endpush
    <div class="row">
        @foreach($data as $story)
            <x-story :story="$story"/>
        @endforeach
    </div>
@endsection
