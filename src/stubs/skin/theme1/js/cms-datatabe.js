/**
 * Created by Ramesh on 9/5/2017.
 */

//default variables

    var order = [[2,"asc"]];
    var lengthMenu = [[50, 100 ,250, 500, -1], [50, 100 ,250, 500,"ALL"]];
    //var csrf = "";

    var dataTable = function(element,ajax_url,columns_array,csrf,options)
    {
        //csrf = csrf;
        $(element).DataTable({
            order : ((options.order) ? options.order : order),
            lengthMenu: ((options.lengthMenu) ? options.lengthMenu : lengthMenu),
            serverSide: true,
            dom: '<"toolbar"<"col-xs-12 col-sm-2"l><"col-xs-12 col-sm-2"B>>frtip',
            buttons: [
                {
                    extend: "copy",
                    className: "btn-sm",
                    exportOptions: {
                        columns: "thead th:not(.noExport)"
                    }
                },
                {
                    extend: "csv",
                    className: "btn-sm",
                    exportOptions: {
                        columns: "thead th:not(.noExport)"
                    }
                },
                {
                    extend: "pdfHtml5",
                    className: "btn-sm",
                    exportOptions: {
                        columns: "thead th:not(.noExport)"
                    }
                },
                {
                    extend: "print",
                    className: "btn-sm",
                    exportOptions: {
                        columns: "thead th:not(.noExport)"
                    }
                },{
                    extend: "excelHtml5",
                    className: "btn-sm",
                    exportOptions: {
                        columns: "thead th:not(.noExport)"
                    }
                },
            ],
            responsive: true,
            keys: true,
            ajax :{
                url: ajax_url,
                type : 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrf
                },
                dataType: 'JSON'
            },
            columns : columns_array
        });

        // add bulk action button
        if(options.button) {
            var action = "";
            for(i=0;i<options.button.length;i++){
                var obj = options.button[i];
                action += '<li><a href="' + obj.url + '" method="'+((obj.method) ? obj.method : "POST")+'">' + obj.name + '</a></li>';
            }

            $("div.toolbar")
                .append('<form id="bulk-action"><div class="btn-group"><button type="button" class="btn btn-danger">Action</button><button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><span class="caret"></span> <span class="sr-only">Toggle Dropdown</span> </button> <ul class="dropdown-menu bulk-action" role="menu">'+action+'</ul> </div></form>');
        }




        //do bulk action
        $('.bulk-action a').click(function(event) {
            event.preventDefault();
            //console.log(checkbox);
            var selected = new Array();
            $('input.check_class:checked').each(function () {
                selected.push(parseInt($(this).val()));
            })
            var form = $('#bulk-action');
            form.attr('action', $(this).attr('href'));

            if ($(this).attr('method') == "DELETE")
                form.attr('method', "POST");
            else
                form.attr('method', $(this).attr('method'));

            form.append(jQuery('<input>', {
                'name': '_token',
                'value': csrf,
                'type': 'hidden'
            }))
            if ($(this).attr('method') == "DELETE")
            {
                form.append(jQuery('<input>', {
                    'name': '_method',
                    'value': 'DELETE',
                    'type': 'hidden'
                }))
            }
            form.append($('.check_class'));
            form.submit().remove();
        });
    }

//(function () {

//select all option
    $("table").on('click','#select-all-item', function () {
        $("table .check_class").prop('checked',($(this).is(":checked") == true) ? true : false);
    });
//});