
{{ Cms::style('theme/vendors/slider/sliderResponsive.css') }}
{{ Cms::script('theme/vendors/slider/sliderResponsive.js') }}


<div class="slider" id="slider1">
    <!-- Slides -->


@if(isset($parm->box_count))
    @for($i=0;$i<$parm->box_count;$i++)
    <?php $ttt = "image".$i; ?>
    <div style="background-image:url({{url(@$parm->$ttt)}})">
        <span>
        <?php $title = "title1_".$i; ?>
          <h2>{{@$parm->$title}}</h2>
      </span>
    </div>
    @endfor
@else


    <div style="background-image:url(https://unsplash.it/1920/1200?image=839)"></div>

    <div style="background-image:url(https://unsplash.it/1920/1200?image=838)"></div>
    <div style="background-image:url(https://unsplash.it/1920/1200?image=836)"></div>
    <div style="background-image:url(https://unsplash.it/1920/1200?image=826)"></div>
    <div style="background-image:url(https://unsplash.it/1920/1200?image=822)"></div>
    @endif
    <!-- The Arrows -->
    <i class="left" class="arrows" style="z-index:2; position:absolute;"><svg viewBox="0 0 100 100"><path d="M 10,50 L 60,100 L 70,90 L 30,50  L 70,10 L 60,0 Z"></path></svg></i>
    <i class="right" class="arrows" style="z-index:2; position:absolute;"><svg viewBox="0 0 100 100"><path d="M 10,50 L 60,100 L 70,90 L 30,50  L 70,10 L 60,0 Z" transform="translate(100, 100) rotate(180) "></path></svg></i>
    <!-- Title Bar -->
   
</div>



<script>
$(document).ready(function() {
  
  $("#slider1").sliderResponsive({
  // Using default everything
     slidePause: "{{ isset($parm->slidePause) ?  $parm->slidePause : '5000'}}",
     fadeSpeed: "{{ @$parm->fadeSpeed }}",
     autoPlay:  "{{ (@$parm->autoPlay==1) ? 'on' : 'off' }}",
     showArrows: "{{ (@$parm->showArrows==1) ? 'on' : 'off' }}",
     hideDots: "{{ (@$parm->hideDots==1) ? 'off' : 'on' }}",
     hoverZoom: "{{ (@$parm->hoverZoom==1) ? 'on' : 'off' }}",
     titleBarTop: "{{ (@$parm->titleBarTop==1) ? 'on' : 'off' }}",

  }); 
}); 
</script>





@section('script')
   
@endsection