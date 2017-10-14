<div class="row">
    <h4>Pages</h4>
    @foreach($data as $page)
        <div class="col-xs-12 col-sm-6 col-md-4">
            <div class="detail-div">
                <h4 class="name" style="text-transform: capitalize">{{$page['title']}}</h4>
                <div class="description-thin">
                    {!! $page['page_content'] !!}
                    <a href="{{url('page/'.$page['url'])}}">view more</a>
                </div>
            </div>
        </div>
    @endforeach
</div>
