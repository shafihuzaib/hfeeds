$(document).ready(function() {

	//=================================== Tooltips =====================================//

	if ($.fn.tooltip()) {
		$('.list-brands [class="tooltip_hover"]').tooltip({
			placement : "top"
		});
		$('.footer [class="tooltip_hover"]').tooltip({
			placement : "bottom"
		});
	}

	//=================================== video responsivo  =================================//

	$("#video").fitVids();

	//=================================== slider  =================================//

	$("#slider").responsiveSlides({
		auto : false, // Boolean: Animate automatically, true or false
		speed : 500, // Integer: Speed of the transition, in milliseconds
		timeout : 4000, // Integer: Time between slide transitions, in milliseconds
		pager : false, // Boolean: Show pager, true or false
		nav : true, // Boolean: Show navigation, true or false
		random : false, // Boolean: Randomize the order of the slides, true or false
		pause : false, // Boolean: Pause on hover, true or false
		pauseControls : false, // Boolean: Pause when hovering controls, true or false
		prevText : "Previous", // String: Text for the "previous" button
		nextText : "Next", // String: Text for the "next" button
		maxwidth : "", // Integer: Max-width of the slideshow, in pixels
		navContainer : "", // Selector: Where controls should be appended to, default is after the 'ul'
		manualControls : "", // Selector: Declare custom pager navigation
		namespace : "rslides", // String: Change the default namespace used
		before : function() {
		}, // Function: Before callback
		after : function() {
		} // Function: After callback
	});



	//=================================== formulario newssleter =================================//

	$("#newsletter").submit(function() {
		$.ajax({
			type : "POST",
			url : "newsletter.php",
			dataType : "html",
			data : $(this).serialize(),
			beforeSend : function() {
				$("#loadingNews").show();
			},
			success : function(response) {
				$("#responseNews").html(response);
				$("#loadingNews").hide();
				$("#h_form").hide();

			}
		})
		return false;
	});

	//=================================== form Course =================================//
	$("#curse-form").submit(function() {
		$.ajax({
			type : "POST",
			url : "formsubmit.php",
			dataType : "html",
			data : $(this).serialize(),
			beforeSend : function() {
				$("#loading").show();
			},
			success : function(response) {
				$("#response").html(response);
				$("#loading").hide();
				$("#h_form").hide();

			}
		})
		return false;
	});

	//=================================== Hover steps =================================//
	$('.steps .item').hover(function() {
		$(this).children(".ico").toggleClass('animated tada');
	});
	
	//=================================== Hover pricing =================================//
	$('.pricing .item').hover(function() {
		$(this).toggleClass('animated pulse');
	});
	
	//=================================== placeholder for ie =================================//
	$('input, textarea').placeholder();
	
	//=================================== scroll top =================================//
	$('#top, #goTop').click(function() {
		$('body,html').animate({
			scrollTop : 0
		}, 800);
		return false
	});


	$(window).scroll(function() {


        var ScrollTop = $(window).scrollTop();
        if (ScrollTop > 350) {
            $("#goTop").addClass("show");
        }
        if (ScrollTop < 350) {
            $("#goTop").removeClass("show");
        }
    });
	
	

});

