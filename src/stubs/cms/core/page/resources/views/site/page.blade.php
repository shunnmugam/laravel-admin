@extends('layout::site.master')

@section('sIte_tItle','Page')
@section('addlinks')

@endsection

@section('body')
    <div class="container">
        @if(count($data)==0)
            <h1>Page Not Found</h1>
        @else
            <h2>{!! $data->title !!}</h2>
            {!! $data->page_content !!}
        @endif
    </div>
@endsection