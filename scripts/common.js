$.noConflict();
+function(excute) {
	excute(window, document, jQuery);
}(function(window, document, $){
	
	$.extend({
		loading: function(color){
			color = color ? color : "#fff";
			$("div.loading-a1").css("color", color);
			$("div.loading>div:first-child").css("border-color", color);
			$("div.loading-a1").animate({right:"0"});
		},
		loaded: function(){
			$("div.loading-a1").animate({right:"-200px"});
		},
		cookie:  function(name, value, options) {
			if (typeof value != 'undefined') {
				options = options || {};
				if (value === null) {
					value = '';
					options = $.extend({}, options);
					options.expires = -1;
				}
				var expires = '';
				if (options.expires && (typeof options.expires == 'number' || options.expires.toUTCString)) {
					var date;
					if (typeof options.expires == 'number') {
						date = new Date();
						date.setTime(date.getTime() + (options.expires * 24 * 60 * 60 * 1000));
			    	} else {
						date = options.expires;
					}
					expires = '; expires=' + date.toUTCString();
				}
				var path = options.path ? '; path=' + (options.path) : '';
				var domain = options.domain ? '; domain=' + (options.domain) : '';
				var secure = options.secure ? '; secure' : '';
				document.cookie = [name, '=', encodeURIComponent(value), expires, path, domain, secure].join('');
			} else {
				var cookieValue = null;
				if (document.cookie && document.cookie != '') {
					var cookies = document.cookie.split(';');
					for (var i = 0; i < cookies.length; i++) {
						var cookie = jQuery.trim(cookies[i]);
						if (cookie.substring(0, name.length + 1) == (name + '=')) {
							cookieValue = decodeURIComponent(cookie.substring(name.length + 1));
							break;
						}
					}
				}
				return cookieValue;
			}
		}
		
		
	});
	
	//slider
	function sliderTimer(){
		$(".slider-container>.main-slider>.slide-item:first-child").css("display","block");
	    $('.slider-container>.thumbs li:first-child').addClass('curr');
	    // Main Slider 
	    startTimer();
	    var timer;
	    var slideCount = $('.slider-container>.thumbs li').length;
	    var currSlide = $('.slider-container>.thumbs li').filter('.curr').index();
	    var nextSlide = currSlide + 1;
	    var fadeSpeed = 400;
		
	    //Start slides timer functions
	    function startTimer() {
	        timer = setInterval(function () {
	            $('.slider-container>.main-slider>.slide-item').eq(nextSlide).fadeIn(fadeSpeed);
	            $('.slider-container>.main-slider>.slide-item').eq(currSlide).fadeOut(fadeSpeed);
	            $('.slider-container>.main-slider>.slide-item, .slider-container>.thumbs li').removeClass('curr');
	            $('.slider-container>.thumbs li').eq(nextSlide).addClass('curr');
	
	            currSlide = nextSlide;
	            nextSlide = currSlide + 1 < slideCount ? currSlide + 1 : 0;
	
	        }, 5000);
	    }
	    $('.slider-container>.thumbs li').click(function () {
	        clearInterval(timer);
	        currSlide = $(this).index();
	        nextSlide = currSlide + 1 < slideCount ? currSlide + 1 : 0;;
	        $('.slider-container>.main-slider>.slide-item').fadeOut(fadeSpeed);
	        $('.slider-container>.main-slider>.slide-item, .slider-container>.thumbs li').removeClass('curr');
	        $('.slider-container>.main-slider>.slide-item').eq($(this).index()).fadeIn(fadeSpeed);
	        $(this).addClass('curr');
	        startTimer();
	    });
	}
	
	//preload background image
	$.imageloader({
      urls: new Array($("#MainBackground label").attr("value")),
      smoothing: true,
      onComplete: function(){},
      onUpdate: function(ratio, image){
        $("#MainBackground").html('<img src="' + image + '" />');
        $("#MainBackground img").animate({opacity:1}, 500, function(){
        	$.loaded();
        	$(".onlyhome").fadeIn("normal");
        });
      },
      onError: function(err){
          console.log(err);
      }
	});	
	

	
	$(function(){
		
		sliderTimer();
		
		//load the scrollbar
		$("#DetailPage").slimScroll({height:"100%"});
	  
		//index infomation tooltips
		$("a[data-original-title], abbr[data-original-title]").on("mouseover", function(event){
			$(this).tooltip('show');
		});
		
		//fade in details
		$(".moredetail").on("click", function(){
			$.loading();
			$(".onlyhome").animate({top:"-100%"}, function(){
				$(".onlydetail").fadeIn();
			});
			var clicksrc = $(this);
			
			//detail page show
			var cateid = clicksrc.attr("go").replace(/#/,"");
			if (cateid=="0"){
				$.post("./wp-admin/admin-ajax.php", {meta:"index", orderby:"meta_value", pagesize:"5", action:"getposts"}, 
					function(sliderData){
						//$("#SliderBlock").applySliderTemplate(sliderData);
						$.loaded();
					}, "json");
			}
			else {
				$.post("./wp-admin/admin-ajax.php", {id:cateid, action:"getposts"}, function(postlist){
						//$("#DetailPage").append(postlist);
						$.loaded();
					}, "json");
			}
			return false;
		});
		
		//fade to index
		$(".backhome").on("click", function(){
			$.loaded();
			$(".onlydetail").fadeOut("fast");
			$(".onlyhome").animate({top:"0"});
		});
		
		//feel so good
		$(".sogood").on("click", function(){
			$(".bs-example-modal-sm").modal("show");
			$.get("./getip", function(clientdata,ipstatus){
				var clientJson = JSON.parse(clientdata);
				$.post(
					"./wp-comments-post.php", 
					{
						comment_post_ID:"2",
						comment_parent:"0",
						comment:'"host":"'+clientJson.host+
										'",<br />"ip":"'+clientJson.ip+
										'",<br />"time":"'+clientJson.time+
										'",<br />"language":"'+clientJson.language+
										'",<br />"browser":"'+clientJson.browser+'"',
						url:clientJson.reffer,
						email:"aa@aa.aa",
						author:"点赞一族"
					},
					function(postbackdata, pbstatus){
						//alert("data:"+postbackdata+",status:"+pbstatus);
					}
				).error(function(req, status, thr) { 
					//alert("你太好了，一直赞我，教我如何消受！"+thr); 
				});
			});
			var current_comment = $(".sogood .fgclass");
			if (!current_comment.hasClass("feelgood")) {
				var now_count = parseInt(current_comment.text()) + 1;
				current_comment.text(now_count);
				current_comment.addClass("feelgood");
			}
			else{
				$("#mySmallModalLabel label").addClass("alert-warning");
				$("#mySmallModalLabel label").text("你太好了，一直赞我，教我如何消受！");
			}
		});
		
		//dropdown menu
		$("div.dropdown-hover").on("mouseenter", function(){
			$(this).find("ul.dropdown-menu").addClass("active");
		});
		$("div.dropdown-hover").on("mouseleave", function(){
			$(this).find("ul.dropdown-menu").removeClass("active");
		});
		
		//checkbutton derectin
		$(".checkbutton").on("click", function(){
			
			if ($(this).attr("check") && $(this).attr("check") == "check"){
				$(this).attr("check", "uncheck");
				$(this).find("i").attr("class", "icon-cancel");
				$(this).trigger("checkbutton.changed", "uncheck");
			}
			else{
				$(this).attr("check", "check");
				$(this).find("i").attr("class", "icon-ok");
				$(this).trigger("checkbutton.changed", "check");
			}
		});
		$(".checkbutton").find("i").attr("class", 
			$.cookie("imqx_directin") == "yes" ? "icon-ok" : "icon-cancel");
		$(".checkbutton").attr("check", 
			$.cookie("imqx_directin") == "yes" ? "check" : "uncheck");
		$(".checkbutton").on("checkbutton.changed", function(e, state){
			if (state == "check") {
				$.cookie("imqx_directin", "yes", {expires: 30});
			}
			else {
				$.cookie("imqx_directin", null)
			}
		});
		if ($.cookie("imqx_directin") == "yes") {
			$(".moredetail").click();
		}
		

		//top menu wheeling opacity
		var iswheel = false;
		$(document).on("mousewheel", function(){
			$("#TopMenu").stop();
			$("#TopMenu").animate({opacity:".7"},function(){
				$("#TopMenu").animate({opacity:"1"})});
		});
		
		
	});//jquery ready function end	
	
	
});



