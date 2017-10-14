@extends('layout::site.master')

@section('sIte_tItle','Search')

@section('body')
    @php
        $datas = array();
        foreach ($result as $data)
        {
            $datas[$data['name']][] = $data;
        }
    @endphp
    <div class="container">
    <div class="row">
        @if(count($datas)==0)
            No data
        @endif
        @foreach($datas as $key =>$data)
            @includeIf($data[0]['view'],['data'=>$data])
        @endforeach
    </div>
    {!! $result->appends(request()->all())->links() !!}
    </div>
@endsection