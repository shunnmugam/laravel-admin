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
        <a class="btn btn-default btn-sm hor-align pull-right btn-right-spacing" href="{{route('state.create')}}" ><i class='glyphicon glyphicon-plus-sign'></i>&nbsp;&nbsp;New</a>
        <table id="datatable-buttons1" class="table table-striped table-responsive table-bordered data-Table" cellspacing="0">
            <thead>
            <tr>
                <th class="noExport">{!! Form::checkbox('select_all', 'checked_all', false, array('id'=>'select-all-item')) !!}{!! Html::decode(Form::label('select-all-item','<span></span>')) !!}</th>
                <th>No</th>
                <th>Name</th>
                <th>Country Name</th>
                <th>Status</th>
                <th class="noExport">Action</th>
            </tr>
            </thead>
            <tbody>

            </tbody>
            <tfoot>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
    </div>

@endsection
@section('script')
    <script>

        $('document').ready(function(){
            var countries = {!! (json_encode($countries)) !!};
            //console.log(countries);
            var element = $("#datatable-buttons1");
            var url =  '{{route('get_state_data_from_admin')}}';
            var column = [
                { data: 'check', name: 'check', searchable: false, sortable: false , width: '9%' , render : function(data, type, row, meta)
                    {
                        return '<input id="'+data+'" class="check_class" type="checkbox" value='+row["id"]+' name="selected_state[]"><label for="'+data+'"><span></span></label>';
                    }
                },
                { data: 'rownum',defaultContent : '', name: 'rownum' , searchable: false, sortable: false , className: 'textcenter' },
                { data: 'name', name: 'name', width: '15%' },
                { data: 'country_name', name: 'country_id' , className: 'textcenter' },
                { data: 'status', name: 'states.status', sortable: false , className: 'textcenter' },
                { data: 'action', name: 'users.id', searchable: false, sortable: false, className: 'textcenter'}
            ];
            var csrf = '{{ csrf_token() }}';

            var options  = {
                //order : [ [ 6, "desc" ] ],
                lengthMenu: [[15,25,50, 100 ,250, 500, -1], [15,25,50, 100 ,250, 500,"ALL"]],
                button : [
                    {
                        name : "Publish" ,
                        url : "{{route('country_action_from_admin',1)}}"
                    },
                    {
                        name : "Un Publish",
                        url : "{{route('country_action_from_admin',0)}}"
                    },
                    {
                        name : "Trash",
                        url : "{{route('country_action_from_admin',-1)}}"
                    },
                    {
                        name : "Delete",
                        url : "{{route('country.destroy',1)}}",
                        method : "DELETE"
                    },{
                        name : "Import",
                        url : "{{route('state_import_from_admin')}}",
                        method : "GET"
                    }
                ],
                initComplete: function () {
                    this.api().columns([3]).every( function () {
                        var column = this;
                        var select = $('<select><option value=""></option></select>')
                            .appendTo( $(column.footer()).empty() )
                            .on( 'change', function () {
                                var val = $.fn.dataTable.util.escapeRegex(
                                    $(this).val()
                                );

                                column
                                    .search( val ? '^'+val+'$' : '', true, false )
                                    .draw();
                            } );

                        $.each( countries,function ( k, v ) {
                            select.append( '<option value="'+k+'">'+v+'</option>' )
                        } );
                    });
                }

            }


            dataTable(element,url,column,csrf,options);

        });
    </script>

@endsection
