/*
	Copyright (c) 2013 
	Willmer, Jens (http://jwillmer.de)	
	
	Permission is hereby granted, free of charge, to any person obtaining
	a copy of this software and associated documentation files (the
	"Software"), to deal in the Software without restriction, including
	without limitation the rights to use, copy, modify, merge, publish,
	distribute, sublicense, and/or sell copies of the Software, and to
	permit persons to whom the Software is furnished to do so, subject to
	the following conditions:
	
	The above copyright notice and this permission notice shall be
	included in all copies or substantial portions of the Software.
	
	THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
	EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
	MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
	NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
	LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION
	OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION
	WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
	
	
	feedBackBox: A small feedback box realized as jQuery Plugin.
	@author: Willmer, Jens
	@url: https://github.com/jwillmer/feedBackBox
	@documentation: https://github.com/jwillmer/feedBackBox/wiki
	@version: 0.0.1
*/
; (function ($) {
    $.fn.extend({
        feedBackBox: function (options) {

            // default options
            this.defaultOptions = {
                title: 'Feedback',
                titleMessage: 'Please feel free to leave us feedback.',
                userName: '',
                isUsernameEnabled: true,
                message: '',
                token : '',
                ajaxUrl: 'http://..',
                successMessage: 'Thank your for your feedback.',
                errorMessage: 'Something wen\'t wrong!'
            };

            var settings = $.extend(true, {}, this.defaultOptions, options);

            return this.each(function () {
                var $this = $(this);
                var thisSettings = $.extend({}, settings);

                var diableUsername;
                if (!thisSettings.isUsernameEnabled) {
                    diableUsername = 'disabled="disabled"';
                }

                // add feedback box
                $this.html('<div id="fpi_feedback"><div id="fpi_title" class="rotate"><h2>'
                    + thisSettings.title
                    + '</h2></div><div id="fpi_content"><div id="fpi_header_message">'
                    + thisSettings.titleMessage
                    + '</div><form><div id="fpi_submit_username"><label for="username">Name</label><input type="text" name="username" '
                    + diableUsername
                    + ' value="'
                    + thisSettings.userName
                    + '"><input type="hidden" name="_token"'
                    + ' value="'
                    + thisSettings.token
                    + '"><div id="fpi_submit_email"><label for="email">Email</label><input type="email" name="email"></div>'
                    + '</div><div id="fpi_submit_message"><label for="message">Message</label><textarea name="message"></textarea></div>'
                    + '<input type="file" name="image"'
                    + ' "><div id="fpi_submit_loading"></div><div id="fpi_submit_submit"><input type="submit" value="Submit">'
					+ '</div></form><div id="fpi_ajax_message"><h2></h2></div></div></div>');

                // remove error indication on text change
                $('#fpi_submit_username input').change(function () {
                    if ($(this).val() != '') {
                        $(this).removeClass('error');
                    }
                });
                $('#fpi_submit_message textarea').change(function () {
                    if ($(this).val() != '') {
                        $(this).removeClass('error');
                    }
                });

                // submit action
                $this.find('form').submit(function () {

                    // validate input fields
                    var haveErrors = false;
                    if ($('#fpi_submit_username input').val() == '' && typeof diableUsername == 'undefined') {
                        haveErrors = true;
                        $('#fpi_submit_username input').addClass('error');
                    }
                    if ($('#fpi_submit_message textarea').val() == '') {
                        haveErrors = true;
                        $('#fpi_submit_message textarea').addClass('error');
                    } 

                    // send ajax call
                    if (!haveErrors) {
                        // serialize all input fields
                        var disabled = $(this).find(':input:disabled').removeAttr('disabled');
                        var serialized = $(this).serialize();

                        var formData = new FormData(this);

                        disabled.attr('disabled', 'disabled');

                        // disable submit button
                        $('#fpi_submit_submit input').attr('disabled', 'disabled');

                        $.ajax({
                            type: 'POST',
                            dataType: 'json',
                            url: thisSettings.ajaxUrl,
                            data: formData,
                            cache:false,
                            contentType: false,
                            processData: false,
                            beforeSend: function () {
                                $('#fpi_submit_loading').show();
                            },
                            error: function (data) {
                                $('#fpi_content form').hide();
                                $('#fpi_content #fpi_ajax_message h2').html(thisSettings.errorMessage);
                            },
                            success: function () {
                                $('#fpi_content form').hide();
                                $('#fpi_content #fpi_ajax_message h2').html(thisSettings.successMessage);
                            }
                        });
                    }

                    return false;
                });

                // open and close animation
                var isOpen = false;
                $('#fpi_title').click(function () {
                    if (isOpen) {
                        $('#fpi_feedback').animate({ "width": "+=5px" }, "fast")
                        .animate({ "width": "55px" }, "slow")
                        .animate({ "width": "60px" }, "fast");
                        isOpen = !isOpen;
                    } else {
                        $('#fpi_feedback').animate({ "width": "-=5px" }, "fast")
                        .animate({ "width": "365px" }, "slow")
                        .animate({ "width": "360px" }, "fast");

                        // reset properties
                        $('#fpi_submit_loading').hide();
                        $('#fpi_content form').show()
                        $('#fpi_content form .error').removeClass("error");
                        $('#fpi_submit_submit input').removeAttr('disabled');
                        isOpen = !isOpen;
                    }
                });

            });
        }
    });
})(jQuery);
