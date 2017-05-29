(function($) {
    "use strict";
    $(function()
    {
        // Datepickers
        $('#start').datepicker({
            dateFormat: 'dd.mm.yy',
            prevText: '<i class="fa fa-chevron-left"></i>',
            nextText: '<i class="fa fa-chevron-right"></i>',
            onSelect: function(selectedDate)
            {
                $('#finish').datepicker('option', 'minDate', selectedDate);
            }
        });
        $('#finish').datepicker({
            dateFormat: 'dd.mm.yy',
            prevText: '<i class="fa fa-chevron-left"></i>',
            nextText: '<i class="fa fa-chevron-right"></i>',
            onSelect: function(selectedDate)
            {
                $('#start').datepicker('option', 'maxDate', selectedDate);
            }
        });

        // Validation
        $("#sky-form").validate(
                {
                    // Rules for form validation
                    rules:
                            {
                                name:
                                        {
                                            required: true
                                        },
                                email:
                                        {
                                            required: true,
                                            email: true
                                        },
                                phone:
                                        {
                                            required: true
                                        },
                                interested:
                                        {
                                            required: true
                                        },
                                budget:
                                        {
                                            required: true
                                        }
                            },
                    // Messages for form validation
                    messages:
                            {
                                name:
                                        {
                                            required: 'Please enter your name'
                                        },
                                email:
                                        {
                                            required: 'Please enter your email address',
                                            email: 'Please enter a VALID email address'
                                        },
                                phone:
                                        {
                                            required: 'Please enter your phone number'
                                        },
                                interested:
                                        {
                                            required: 'Please select interested service'
                                        },
                                budget:
                                        {
                                            required: 'Please select your budget'
                                        }
                            },
                    // Ajax form submition
                    submitHandler: function(form)
                    {
                        $(form).ajaxSubmit(
                                {
                                    beforeSend: function()
                                    {
                                        $('#sky-form button[type="submit"]').addClass('button-uploading').attr('disabled', true);
                                    },
                                    uploadProgress: function(event, position, total, percentComplete)
                                    {
                                        $("#sky-form .progress").text(percentComplete + '%');
                                    },
                                    success: function()
                                    {
                                        $("#sky-form").addClass('submited');
                                        $('#sky-form button[type="submit"]').removeClass('button-uploading').attr('disabled', false);
                                    }
                                });
                    },
                    // Do not change code below
                    errorPlacement: function(error, element)
                    {
                        error.insertAfter(element.parent());
                    }
                });
    });
})(jQuery);

(function($) {
    $('.data-hash').on('click', function(e) {
         e.preventDefault();
        var self = (jQuery)(this);
        var tmpArr = self.attr('href').split('/');
        var strSection = tmpArr[tmpArr.length - 1];
        var positionY = (jQuery)(strSection).offset().top;
        (jQuery)('html, body').animate({
            scrollTop: positionY
        }, 500);
    });
    
    $('.navbar-collapse .search-box form input[type="search"]').attr('placeholder','Search here ...!');
    $('.services-2> .col-md-6:first-of-type .fea-sce-col').addClass('active');
    
     jQuery('.navbar-brand.logo').each(function() {
            var url_img = 'url(' + jQuery(this).attr('data-bg') + ') no-repeat left 8px'; 
            jQuery(this).css("background-image", url_img);
        });
})(jQuery);

//// search box..
$(function () {
        // Remove Search if user Resets Form or hits Escape!
		$('body, .navbar-collapse .search-box button[type="reset"]').on('click keyup', function(event) {
			console.log(event.currentTarget);
			if (event.which == 27 && $('.navbar-collapse .search-box').hasClass('active') ||
				$(event.currentTarget).attr('type') == 'reset') {
				closeSearch();
			}
		});

		function closeSearch() {
            var $form = $('.navbar-collapse .search-box.active')
    		$form.find('input').val('');
			$form.removeClass('active');
		}

		// Show Search if form is not active // event.preventDefault() is important, this prevents the form from submitting
		$(document).on('click', '.navbar-collapse .search-box:not(.active) button[type="submit"]', function(event) {
			event.preventDefault();
			var $form = $(this).closest('form'),
				$input = $form.find('input');
			$form.addClass('active');
			$input.focus();

		});
		// ONLY FOR DEMO // Please use $('form').submit(function(event)) to track from submission
		// if your form is ajax remember to call `closeSearch()` to close the search container
		$(document).on('click', '.navbar-collapse .search-box.active button[type="submit"]', function(event) {
			event.preventDefault();
			var $form = $(this).closest('form'),
				$input = $form.find('input');
			$('#showSearchTerm').text($input.val());
            closeSearch()
		});
    });
//// search box end..
