<!-- Datatables -->
{!!Cms::style("theme/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" ) !!}
{!!Cms::style("theme/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" ) !!}
{!!Cms::style("theme/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" ) !!}
{!!Cms::style("theme/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" ) !!}
{!!Cms::style("theme/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" ) !!}


@section('script_link')

    {!! Cms::script("theme/vendors/datatables.net/js/jquery.dataTables.min.js") !!}
    {!! Cms::script("theme/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js") !!}
    {!! Cms::script("theme/vendors/datatables.net-buttons/js/dataTables.buttons.min.js") !!}
    {!! Cms::script("theme/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js") !!}
    {!! Cms::script("theme/vendors/datatables.net-buttons/js/buttons.flash.min.js") !!}
    {!! Cms::script("theme/vendors/datatables.net-buttons/js/buttons.html5.min.js") !!}
    {!! Cms::script("theme/vendors/datatables.net-buttons/js/buttons.print.min.js") !!}
    {!! Cms::script("theme/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js") !!}
    {!! Cms::script("theme/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js") !!}
    {!! Cms::script("theme/vendors/datatables.net-responsive/js/dataTables.responsive.min.js") !!}
    {!! Cms::script("theme/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js") !!}
    {!! Cms::script("theme/vendors/datatables.net-scroller/js/dataTables.scroller.min.js") !!}

    <!--cms-dataTable-->
    {!! Cms::script("js/cms-datatabe.js") !!}
@endsection