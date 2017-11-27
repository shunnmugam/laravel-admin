jQuery.fn.foxholder = function(number) {
  this.addClass("form-container").attr("id", "example-"+number.demo);

  //adding labels with placeholders content. Removing placeholders
  this.find('form').find('input:not(:checkbox):not(:button):not(:submit),textarea').each(function() {

    var placeholderText, formItemId, inputType; 

    //wrapping form elements in their oun <div> tags
    jQuery(this).wrap('<div class="form-item-block"></div>'); 

    //creating labels
    inputType = jQuery(this).attr('type');

    if (inputType == 'hidden') {

    } else {
      placeholderText = jQuery(this).attr('placeholder');
      formItemId = jQuery(this).attr('id')
      jQuery(this).after('<label for="'+ formItemId +'"><span>'+ placeholderText +'</span></label>');
      jQuery(this).removeAttr('placeholder');
    }
  });

  //adding class on blur
  jQuery('.form-container form').find('input:not(:checkbox):not(:button):not(:submit),textarea').blur(function(){
    if (jQuery.trim(jQuery(this).val())!="") {
      jQuery(this).addClass("active");
    } else {
      jQuery(this).removeClass("active");
    }
  });

  //adding line-height for block with textarea 
  jQuery('.form-item-block').each(function() {
    if (jQuery(this).has('textarea').length > 0) {
      jQuery(this).css({'line-height': '0px'});
    }
  });


  //examples scripts

  if (number.demo == 15) {

    //example-15 adding triangle icons
    $('#example-15 input:not(:checkbox):not(:button):not(:submit), #example-15 textarea').each(function() {
      $(this).next('label').append('<div class="top-triangle"></div>').append('<div class="bottom-triangle"></div>');
    });

    //example-15 elements padding
    $('#example-15 input:not(:checkbox):not(:button):not(:submit), #example-15 textarea').focus(function() {
      var labelWidth;
      labelWidth = $(this).siblings('label').width() + 86;
      $(this).css({'padding-left': labelWidth});
    });

    $('#example-15 input:not(:checkbox):not(:button):not(:submit), #example-15 textarea').blur(function() {
      if ($(this).hasClass('active')) {
      } else {
        $(this).css({'padding-left': 20});
      }
    });
    
  }

}
