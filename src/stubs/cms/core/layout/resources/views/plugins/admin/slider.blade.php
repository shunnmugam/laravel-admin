<style type="text/css">
	input.image_up {
    width: 32% !important;
    margin-right: 20px;
}
.txt_tit {
    margin-top: 7px;
    height: 35px;
}

.image1 {
    border: 1px solid brown;
    border-radius: 7px;
}
.col-xs-12.txt_1 {
    margin-bottom: 14px;
}
#addslide {
    margin-top: 15px;
    padding: 7px 23px;
    font-size: 13px;
    color: white;
    background-color: black;
    border-radius: 7px;
}
.slide_del {
    float: right;
}
</style>
<div id="image-container">
@php
	$parm = json_decode($data->parms);
	if(isset($parm->box_count))
	$box_cnt = $parm->box_count;
	else
		$box_cnt =1 ;
@endphp
@for($i=0;$i<$box_cnt;$i++)

	<div class="col-xs-12 image1" style="margin-top: 25px;">
	@if($i!=0)
<button  onclick="deleteNew(this);" id="btnAddAddress" class="slide_del btn btn-warning btn-md" type="button">delete</button>
@endif
		<h2 class="image_tit">Image</h2>
			<div class="slide_feilds">
				<?php $ttt = "image".$i; ?>
				@include('layout::widget.image',['id'=>'image'.$i,'required'=>'true','name'=>$ttt,'class_name'=>'image_up','value'=>@$parm->$ttt])

				<div class="col-xs-12 txt_1">
					<h4 class="col-xs-4 tx_1">Slider Title</h4>
					<div class="col-xs-4 ">
					<?php $ttt = "title1_".$i; ?>
						<input class="txt_tit tle1 form-control" type="text" name="{{$ttt}}" placeholder="Title" value="{{@$parm->$ttt}}">
					</div>
				</div>

			</div>

	</div>
	@endfor
</div>

<input type="hidden" name="box_count" value="{{@$parm->box_count}}" id="box_cntt">
<button  onclick="createNew(this);" id="btnAddAddress" class="slide btn btn-warning btn-md" type="button">Add New Slide</button>



<div class="row">
	<h4>Slider Options</h4>
	<div class="item form-group">
		<label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Auto Play
		</label>
		<div class="col-md-6 col-sm-6 col-xs-12">
			{{Form::hidden('autoPlay',0)}}
			{{ Form::checkbox('autoPlay',1,(@$parm->autoPlay==1) ? true : false, array('class' => 'js-switch', )) }}
		</div>
	</div>
	<div class="item form-group">
		<label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Arrows
		</label>
		<div class="col-md-6 col-sm-6 col-xs-12">
			{{Form::hidden('showArrows',0)}}
			{{ Form::checkbox('showArrows',1,(@$parm->showArrows==1) ? true : false, array('class' => 'js-switch', )) }}
		</div>
	</div>
	<div class="item form-group">
		<label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Dots
		</label>
		<div class="col-md-6 col-sm-6 col-xs-12">
			{{Form::hidden('hideDots',0)}}
			{{ Form::checkbox('hideDots',1,(@$parm->hideDots==1) ? true : false, array('class' => 'js-switch', )) }}
		</div>
	</div>
	<div class="item form-group">
		<label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Hover Zoom
		</label>
		<div class="col-md-6 col-sm-6 col-xs-12">
			{{Form::hidden('hoverZoom',0)}}
			{{ Form::checkbox('hoverZoom',1,(@$parm->hoverZoom==1) ? true : false, array('class' => 'js-switch', )) }}
		</div>
	</div>
	<div class="item form-group">
		<label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Top Title Bar
		</label>
		<div class="col-md-6 col-sm-6 col-xs-12">
			{{Form::hidden('titleBarTop',0)}}
			{{ Form::checkbox('titleBarTop',1,(@$parm->titleBarTop==1) ? true : false, array('class' => 'js-switch', )) }}
		</div>
	</div>
	<div class="item form-group">
		<label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">slide Pause
		</label>
		<div class="col-md-6 col-sm-6 col-xs-12">
			{{Form::number('slidePause',@$parm->slidePause,['class'=>'form-control'])}}(ms)
		</div>
	</div>
	<div class="item form-group">
		<label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Fade Speed
		</label>
		<div class="col-md-6 col-sm-6 col-xs-12">
			{{Form::number('fadeSpeed',@$parm->fadeSpeed,['class'=>'form-control'])}}(ms)
		</div>
	</div>
</div>

<script type="text/javascript">



function createNew(evt){

	var cur=$("input:text").length+1;

var aa=  '<input required id="thumbnail'+cur+'" class="form-control image_up" type="text" name="image1" style="width: 75%;float: left" value=""><a data-input="thumbnail'+cur+'" data-preview="holder'+cur+'" class="btn btn-primary lfm image_up" style="width: 25%"> <i class="fa fa-picture-o"></i> Choose</a><img id="holder'+cur+'" style="margin-top:15px;max-height:100px;">';



	 $("#image-container").append('<div class="col-xs-12 image1" style="margin-top: 25px;">	<button  onclick="deleteNew(this);" id="btnAddAddress" class="slide_del btn btn-warning btn-md" type="button">delete</button><h2 class="image_tit">Image1</h2>	'+aa+'	<div class="slide_feilds">				<div class="col-xs-12 txt_1">				<h4 class="col-xs-4 tx_1">Slider Title</h4>	<div class="col-xs-4 ">					<input class="txt_tit tle1 form-control" type="text" name="imagetitle1'+cur+'" placeholder="Title1" >				</div>			</div>					</div></div>');
 $('.lfm').filemanager('image');
	 //$(evt).css('display', 'none');
	 $(evt).siblings("button.btn-danger").css('display', 'block');
	 namechange();
var box_cnt=$('.image1').length;
$('#box_cntt').val(box_cnt);


/*function deleteNew(evnt){
	$(evnt).closest(".image1").remove();
var i=0;
$('input[type="text"]').each(function(){
      $(this).attr('name', 'tirle1_' + i);
     i++;
  });
}*/
}
function deleteNew(evnt){

     $(evnt).closest(".image1").remove();

     namechange();
     var box_cnt=$('.image1').length;
$('#box_cntt').val(box_cnt);
}

function namechange(){
	var i=0;
	 $('input[type="text"].tle1').each(function(){
      $(this).attr('name', 'title1_' + i);
     i++;
  });

 var i=0;
		 $('input[type="text"].image_up').each(function(){
	      $(this).attr('name', 'image' + i);
	     i++;
	  });
	}

</script>



