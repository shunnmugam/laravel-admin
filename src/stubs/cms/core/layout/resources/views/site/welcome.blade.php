@extends('layout::site.master')

@section('sIte_tItle','Home Page')

@section('body')
    <div class="container">

        <div class="container-fluid slider_fami">
            <div class="wrapper">
                @includeIf(Plugins::get('slider')[0],['data'=>Plugins::get('slider')[1],'parm'=>Plugins::get('slider')[2]])

            </div><!-- wrapper -->
        </div>

    This is Home page
    </div>
@endsection