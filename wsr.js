jQuery(function(){

	/********************
	*  Check if mobile device
	*/
	// var isMobile = window.matchMedia("only screen and (max-width: 760px)");
	//if (isMobile.matches) {}

	/********************
	*  Scroll reveal 
	*/
	//window.sr = ScrollReveal();
	//sr.reveal('.page-header');



	/********************
	*  Ajax 
	*/
	// jQuery.ajax({
	// 	url: wsr_ajax.ajaxurl,
	// 	type: 'POST',
	// 	dataType: 'json',
	// 	data: {
	//     	action: 'wsr_action',
	//     	security: wsr_ajax.ajax_nonce,
	//     	mydata: 'sending this to ajax'
	//     }
	// })
	// .done(function(res, txtStatus, request) {
		//request.getResponseHeader('X-WP-TotalPages'),
	// 	if (res.success){
 //        	alert(res.data);
 //    	}else{
 //    		console.log(res);
 //    	}
	// })
	// .fail(function(err, textStatus) {
	// 	console.log(textStatus);
	// })
	// .always(function(err) {
	// 	console.log("complete");
	// });



	/********************
	*  Wordpress Ajax - Load content from menu dynamically
	*/
	// var $mainContent = $("#main-content"),
	// 	siteUrl = "http://" + top.location.host.toString(),
	// 	url = ''; 

	// $("#ajaxload a").click( function() {
	// 	location.hash = this.pathname;
	// 	return false;
	// }); 

	// $(window).bind('hashchange', function(){
	// 	url = window.location.hash.substring(1); 
	// 	if (!url) {
	// 		return;
	// 	} 
	// 	url = url + " #content-inside"; 
		
	// 	$mainContent.animate({opacity: "0.1"}, 250).html('').load(url, function(response, status, xhr) {
	// 		$mainContent.animate({opacity: "1"}, 250);
	// 	});
	// });

	// $(window).trigger('hashchange');



	/********************
	*  Menu scroll to anchor  
	*/
	// jQuery('#main-menu a').click(function(e){
	// 	e.preventDefault();
	// 	jQuery('html, body').animate({
	//        'scrollTop':   jQuery(this.attributes.href.value).offset().top
	//      }, 800);

	// 	return false;
	// });



	/********************
	*  Masonry
	*  Add css to set width: .masonry-entry{ width:33%}
	*/
 //    var masonryContainer = jQuery('.products');
 //    if (masonryContainer.length){
	//     imagesLoaded( masonryContainer, function() {
	//     	masonryContainer.masonry({
	//     		 itemSelector: 'li.product'
	//     	});
	//     });
	// }



	/********************
	*  lazyload by bill erickson
	*/
	// if (masonryContainer.length){
	// 	jQuery('.products').append( '<li class="load-more"></li>' );
	// 	var button = jQuery('.products .load-more');
	// 	var page = 2;
	// 	var cat_id = 0;
	// 	var orderby = 'date';
	// 	var order = 'DESC';
	// 	var loading = false;
	// 	var scrollHandling = {
	// 	    allow: true,
	// 	    reallow: function() {
	// 	        scrollHandling.allow = true;
	// 	    },
	// 	    delay: 400 //(milliseconds) adjust to the highest acceptable value
	// 	};

	// 	jQuery(window).scroll(function(){
	// 		lazyLoad();
	// 	});

	// 	function lazyLoad(){
	// 		if( ! loading && scrollHandling.allow ) {
	// 			scrollHandling.allow = false;
	// 			setTimeout(scrollHandling.reallow, scrollHandling.delay);
	// 			var offset = jQuery(button).offset().top - jQuery(window).scrollTop();
	// 			if( 2000 > offset ) {
	// 				loading = true;
	// 				var data = {
	// 					action: 'wsr_ajax_load_more',
	// 					security: wsr_ajax.ajax_nonce,
	// 					page: page,
	// 					query: wsr_ajax.query,
	// 					catid: cat_id,
	// 					orderby: orderby,
	// 					order: order
	// 				};
	// 				jQuery.post(wsr_ajax.ajaxurl, data, function(res) {
	// 					if( res.success) {
	// 						var $items = jQuery(res.data);
	// 						
	// 						$items.imagesLoaded().done(function(instance){
	//							masonryContainer.append($items);
	//							masonryContainer.masonry( 'appended', $items);
	//							masonryContainer.masonry('reloadItems');
	//							masonryContainer.masonry('layout');
	// 						
	// 							jQuery('.products').append( button );
	// 							page = page + 1;
	// 							loading = false;
	// 						});
	// 					} else {
	// 						console.log(res);
	// 					}
	// 				}).fail(function(xhr, textStatus, e) {
	// 					console.log(xhr.responseText);
	// 				});

	// 			}
	// 		}
	// 	}

	// 	//dropdown categories lazy load
	// 	jQuery('#category-list a').on('click', function(e){
	// 		e.preventDefault();
	// 		var elcat = jQuery(this).parent();
	// 		var elcat = elcat.attr('class');
	// 		cat_id = elcat.match(/\d+/);
	// 		page = 1;
	// 		masonryContainer.empty();
	// 		lazyLoad();
	// 	});

	// 	//sortby lazyload
	// 	jQuery('#sort-menu a').on('click', function(e){
	// 		e.preventDefault();
	// 		var elsort = jQuery(this).parent();
	// 		var elsort = elsort.attr('class');
	// 		var sortArray = elsort.split('-');
	// 		orderby = sortArray[0];
	// 		order = sortArray[1];
	// 		page = 1;
	// 		masonryContainer.empty();
	// 		lazyLoad();
	// 	});
	// }




	/****************
	* Show sticky header when scrolldown
	*/
	// var didScroll;
	// var lastScrollTop = 0;
	// var delta = 5;
	// var navbarHeight = jQuery('#navbar').outerHeight();
	// var isMobile = window.matchMedia("only screen and (max-width: 760px)");

	// jQuery(window).scroll(function(event){
	// 		if (!isMobile.matches) {
    //     		didScroll = true;
    // 	   	}
	// });

	// setInterval(function() {
	//     if (didScroll) {
	//         hasScrolled();
	//         didScroll = false;
	//     }
	// }, 250);

	// function hasScrolled() {
	//     var st = jQuery(this).scrollTop();
	    
	//     // Make sure they scroll more than delta
	//     if(Math.abs(lastScrollTop - st) <= delta)
	//         return;
	    
	//     // If they scrolled down and are past the navbar, add class .nav-up.
	//     // This is necessary so you never see what is "behind" the navbar.
	//     if (st > lastScrollTop && st > navbarHeight){
	//         // Scroll Down
	//         jQuery('.navbar-brand').show();
	//         jQuery('#main-nav').addClass('navbar-fixed-top');
	//         jQuery('#wedge').show();
	//         if (jQuery('#wpadminbar').length){
	//         	jQuery('.navbar-fixed-top').css('margin-top', '32px');
	//         }
	//     } else {
	//         // Scroll Up
	//         if(st + jQuery(window).height() < jQuery(document).height()) {
	//         	if (jQuery('#wpadminbar').length){
	//     	    	jQuery('.navbar-fixed-top').css('margin-top', '0px');
	// 		    }
	//             jQuery('#main-nav').removeClass('navbar-fixed-top');
	//             jQuery('#wedge').hide();
	//             jQuery('.navbar-brand').hide();
	//         }
	//     }
	//     lastScrollTop = st;
	// }


	/***********************
	* Hover menu item effect
	* css to use: #magic-line { position: absolute; width: 0; bottom: 29px; height: 2px; background: #736d73;z-index: 0; }
	*/
	// var $el, leftPos, newWidth,
 //    $mainNav = jQuery("#menu-main");
    
 //    $mainNav.append("<div id='magic-line'></div>");
 //    var $magicLine = jQuery("#magic-line");
    
 //    jQuery("#menu-main > li").mouseenter(function() {
 //        $el = jQuery(this);
 //        var alink = jQuery('> a', this);
 //        $magicLine
 //          .width(0)
 //          .css("left", $el.position().left +15)
 //          .data("origLeft", $magicLine.position().left)
 //          .data("origWidth", $magicLine.width());

 //        leftPos = $el.position().left + 15;
 //        newWidth = $el.width() - 30;
 //        $magicLine.stop().animate({
 //            left: leftPos,
 //            width: newWidth
 //        });
 //    });

 //    jQuery("#menu-main > li").mouseleave(function() {
 //        $magicLine.stop(true).animate({
 //          width: 0
 //        });
 //    });

});

 

/****************
* Add to cart ajax popup 
*/
// $('body').on('added_to_cart',function(e,data) {
//     //alert('Added ' + data['div.widget_shopping_cart_content']);
//     if ($('#hidden_cart').length == 0) { //add cart contents only once
//         $(this).append('<a href="#TB_inline?width=495&height=352&inlineId=hidden_cart" id="show_hidden_cart" title="" class="thickbox" style="display:none"></a>');
//         $(this).append('<div id="hidden_cart" style="display:none">'+data['div.widget_shopping_cart_content']+'</div>');
//     }
//     $('#show_hidden_cart').click();
// });


/****************
* Fixes gittery mouse scroll on IE
*/
// if(navigator.userAgent.match(/Trident\/7\./)) { // if IE
// 	jQuery('body').on("mousewheel", function () {
// 	  event.preventDefault();

// 	  var wheelDelta = event.wheelDelta;

// 	  var currentScrollPosition = window.pageYOffset;
// 	  window.scrollTo(0, currentScrollPosition - wheelDelta);
// 	});
// }

/****************
* Ability to click parent menu item on mobile. 
* Need to change $atts['href'] = '#' in navwalker to have href
*/
// jQuery('.dropdown a.dropdown-toggle').on('click', function() {
// 	    if(jQuery(this).parent().hasClass('open'))
// 	        location.assign(jQuery(this).attr('href'));
// 	});
