<div class="row">
    <h4>Blogs</h4>
    @foreach($data as $blog)
        <div class="col-xs-12 col-sm-6 col-md-4">
            <div class="image-div">
                {!! Html::image($blog['image'],'',["class"=>"img img-responsive"]) !!}
            </div>
            <div class="detail-div">
                <h4 class="name" style="text-transform: capitalize">{{$blog['title']}}</h4>
                <div class="description-thin">
                    {!! $blog['content'] !!}
                </div>
            </div>
        </div>
    @endforeach
</div>
