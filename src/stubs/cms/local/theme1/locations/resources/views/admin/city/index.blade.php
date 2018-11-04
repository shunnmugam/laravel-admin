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
        <a class="btn btn-default btn-sm hor-align pull-right btn-right-spacing" href="{{route('city.create')}}" ><i class='glyphicon glyphicon-plus-sign'></i>&nbsp;&nbsp;New</a>
        <table id="datatable-buttons1" class="table table-striped table-responsive table-bordered data-Table" cellspacing="0">
            <thead>
            <tr>
                <th class="noExport">{!! Form::checkbox('select_all', 'checked_all', false, array('id'=>'select-all-item')) !!}{!! Html::decode(Form::label('select-all-item','<span></span>')) !!}</th>
                <th>No</th>
                <th>Name</th>
                <th>State Name</th>
                <th>Country Name</th>
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
            var url =  '{{route('get_city_data_from_admin')}}';
            var column = [
                { data: 'check', name: 'check', searchable: false, sortable: false , width: '9%' , render : function(data, type, row, meta)
                    {
                        return '<input id="'+data+'" class="check_class" type="checkbox" value='+row["id"]+' name="selected_city[]"><label for="'+data+'"><span></span></label>';
                    }
                },
                { data: 'rownum',defaultContent : '', name: 'rownum' , searchable: false, sortable: false , className: 'textcenter' },
                { data: 'name', name: 'name', width: '15%' },
                { data: 'state_name', name: 'state_name' , className: 'textcenter' },
                { data: 'country_name', name: 'country_name' , className: 'textcenter' },
                { data: 'status', name: 'status', sortable: false , className: 'textcenter' },
                { data: 'action', name: 'id', searchable: false, sortable: false, className: 'textcenter'}
            ];
            var csrf = '{{ csrf_token() }}';

            var options  = {
                //order : [ [ 6, "desc" ] ],
                lengthMenu: [[15,25,50, 100 ,250, 500, -1], [15,25,50, 100 ,250, 500,"ALL"]],
                button : [
                    {
                        name : "Publish" ,
                        url : "{{route('city_action_from_admin',1)}}"
                    },
                    {
                        name : "Un Publish",
                        url : "{{route('city_action_from_admin',0)}}"
                    },
                    {
                        name : "Trash",
                        url : "{{route('city_action_from_admin',-1)}}"
                    },
                    {
                        name : "Delete",
                        url : "{{route('city.destroy',1)}}",
                        method : "DELETE"
                    }
                ],

            }


            dataTable(element,url,column,csrf,options);

        });
    </script>

@endsection
