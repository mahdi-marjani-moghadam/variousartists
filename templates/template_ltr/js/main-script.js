/*var tpj = jQuery;
var revapi68;
tpj(document).ready(function () {
	if (tpj("#rev_slider_70_1").revolution == undefined) {
		revslider_showDoubleJqueryError("#rev_slider_70_1");
	} else {
		revapi68 = tpj("#rev_slider_70_1").show().revolution({
			sliderType: "standard",
			jsFileLocation: "include/rs-plugin/js/",
			sliderLayout: "auto",
			dottedOverlay: "none",
			delay: 8000,
			navigation: {
				/!*arrows:{enable:true}*!/
			},
			responsiveLevels: [1240, 1024, 778, 480],
			gridwidth: [1400, 1240, 778, 480],
			gridheight: [500, 500, 500, 500],
			lazyType: "none",
			shadow: 0,
			spinner: "off",
			autoHeight: "off",
			disableProgressBar: "on",
			hideThumbsOnMobile: "off",
			hideSliderAtLimit: 0,
			hideCaptionAtLimit: 0,
			hideAllCaptionAtLilmit: 0,
			debugMode: false,
			fallbacks: {
				simplifyAll: "off",
				disableFocusListener: false,
			}
		});
	}*/






	/*var owl_single = $(".single-owl");

	owl_single.owlCarousel({

		items: 1, //10 items above 1000px browser width
		itemsDesktop: [1000, 1], //5 items between 1000px and 901px
		itemsDesktopSmall: [900, 1], // 3 items betweem 900px and 601px
		itemsTablet: [600, 1], //2 items between 600 and 0;
		itemsMobile: false // itemsMobile disabled - inherit from itemsTablet option

	});

	$(".side-left .next").click(function () {
		owl_single.trigger('owl.next');
	});
	$(".side-left .prev").click(function () {
		owl_single.trigger('owl.prev');
	});*/






	// chart
	/*var barChartData = {
		labels : ["فروردین","اردیبهشت","خرداد","تیر","مرداد","شهریور","مهر","آبان","آذر","دی","بهمن","اسفند"],
		datasets : [
			{
				fillColor : "rgba(220,220,220,0.5)",
				strokeColor : "rgba(220,220,220,1)",
				pointColor : "rgba(220,220,220,1)",
				pointStrokeColor : "#fff",
				data : [65,44,33,44,67,54,33,11,23,67,90,87]
			}
		]

	};

	var globalGraphSettings = {animation : Modernizr.canvas};

	function showBarChart(){
		var ctx = document.getElementById("barChartCanvas").getContext("2d");
		new Chart(ctx).Bar(barChartData,globalGraphSettings);
	}

	$('#barChart').appear( function(){ $(this).css({ opacity: 1 }); setTimeout(showBarChart,300); },{accX: 0, accY: -155},'easeInCubic');

	var barChartData2 = {
		labels : ["فروردین","اردیبهشت","خرداد","تیر","مرداد","شهریور","مهر","آبان","آذر","دی","بهمن","اسفند"],
		datasets : [
			{
				fillColor : "rgba(160,160,160,1)",
				data : [65,59,90,81,56,55,50,44,12,33,44,55]
			}
		]

	};

	var globalGraphSettings = {animation : Modernizr.canvas};
	function showBarChart2(){
		var ctx = document.getElementById("barChartCanvas2").getContext("2d");
		new Chart(ctx).Bar(barChartData2,globalGraphSettings);
	}

	$('#barChart2').appear( function(){ $(this).css({ opacity: 1 }); setTimeout(showBarChart2,300); },{accX: 0, accY: -155},'easeInCubic');

	var nice = $(".videos-list").niceScroll({cursorcolor: "#ff5a00",cursorborder:"none",cursorborderradius: "0",cursorwidth: "4px",railalign: 'left'  });  // The document page (body)


    // setTimeout(function(){
    $('body').on('mouseenter','.movie_list a',function(){
        $(this).parents('.video-box').addClass('movie-hover');
    });
    $('body').on('mouseleave','.movie_list a',function(){
        $(this).parents('.video-box').removeClass('movie-hover');
    });
    // }, 5000);


    $('.movie_thumb_wrapper').hover(function () {
       $('.book-row-mask').toggleClass('book-row-mask-active');
        $(this).toggleClass('movie_thumb_wrapper_active');
    });*/





$(document).ready(function () {

	// rate
	$('.push-rate').change(function(){
		var artists_id = $(this).data('artists');
		var product_id = $(this).data('product');
		var val = $(this).val();
		$.ajax({
			url: 'product',
			type: "post",
			data: {
				artists_id: artists_id,
				product_id: product_id,
				val: val,
				action: 'push_rate'
			},
			success: function (data, status, xhr) {

				var result = $.parseJSON(data);
				$('.star-rating').html('Your Rate is '+result.rate);
				if (result['result'] == -1) {
					var msg = result['msg'];
					$('#alertMessage').remove();
					$('#showError ').html("<div id='alertMessage'><div class='alert alert-danger'>Error: " + msg + "</div></div>");
					return false;
				}

			}
		});
		return false;

	});




	// nav
	$('.p-nav-handle , .p-shortcuts-handle').click(function () {
		$(this).next('ul').toggle();
	});

	/*if($('body').width() > 767 ){
		$('.p-right').height($('.p-left').height());
	}
	if($('.inbox').height() > $('.information').height()){ $('.information').height($('.inbox').height()) }
	else { $('.inbox').height($('.information').height()) }*/



});
