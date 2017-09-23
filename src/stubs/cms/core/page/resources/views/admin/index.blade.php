@extends('layout::admin.master')

@section('title','users')
@section('style')
    <!-- Datatables -->
    @include('layout::admin.head.list_head')
    <style>
        .table-div table {
            width: 100% !important;
        }
    </style>
@endsection
@section('body')
    <div class="table-div">
        <a class="btn btn-default btn-sm hor-align pull-right btn-right-spacing" href="{{route('page.create')}}" ><i class='glyphicon glyphicon-plus-sign'></i>&nbsp;&nbsp;New</a>
    <table id="datatable-buttons1" class="table table-striped table-responsive table-bordered data-Table" cellspacing="0">
        <thead>
        <tr>
            <th class="noExport">{!! Form::checkbox('select_all', 'checked_all', false, array('id'=>'select-all-item')) !!}{!! Html::decode(Form::label('select-all-item','<span></span>')) !!}</th>
            <th>No</th>
            <th>Id</th>
            <th>Page Title</th>
            <th>Page Url</th>
            <th>Status</th>
            <th class="noExport">Action</th>
        </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
    </div>
    
@endsection
@section('script')
<script>
    $('document').ready(function(){

        var element = $("#datatable-buttons1");
        var url =  '{{route('get_page_data_from_admin')}}';
        var column = [
            { data: 'check', name: 'check', searchable: false, sortable: false , width: '9%' , render : function(data, type, row, meta)
            {
                return '<input id="'+data+'" class="check_class" type="checkbox" value='+row["id"]+' name="selected_pages[]"><label for="'+data+'"><span></span></label>';
            }
            },
            { data: 'rownum',defaultContent : '', name: 'rownum' , searchable: false, sortable: false , className: 'textcenter' },
            { data: 'id', name: 'id', width: '15%' },
            { data: 'title', name: 'title', width: '20%' },
            { data: 'url', name: 'url', width: '10%', className: 'textcenter' },
            { data: 'status', name: 'users.status', sortable: false , className: 'textcenter' },
            { data: 'action', name: 'users.id', searchable: false, sortable: false, className: 'textcenter'}
        ];
        var csrf = '{{ csrf_token() }}';

        var options  = {
            //order : [ [ 6, "desc" ] ],
            //lengthMenu: [[100, 250, 500], [100, 250, 500]]
            button : [
                {
                    name : "Publish" ,
                    url : "{{route('page_action_from_admin',1)}}"
                },
                {
                    name : "Un Publish",
                    url : "{{route('page_action_from_admin',0)}}"
                },
                {
                    name : "Trash",
                    url : "{{route('page_action_from_admin',-1)}}"
                },
                {
                    name : "Delete",
                    url : "{{route('page.destroy',1)}}",
                    method : "DELETE"
                }
            ],

        }


        dataTable(element,url,column,csrf,options);

    });
    </script>

@endsection