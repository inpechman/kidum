jQuery(document).ready(function($){
	initBlogs();
});


function initBlogs(){

	if (jQuery('.posts_category_filter').length){
		jQuery('.posts_category_filter .showall .counter').text(" ("+jQuery('article').length+")");
		jQuery('.posts_category_filter li:not(.showall)').each(function(){
			jQuery(this).find('.counter').text(" ("+jQuery('article.'+jQuery(this).attr('class')).length+")");
		});
	}
				    	
	for (var i=0; i<17; i++){
		jQuery('li.depth-'+i).each(function(){
			jQuery(this).css({ 'width': jQuery(this).parent().width()-((i-1)*10)+'px' });
		});
	}
	
	if (jQuery('.post-listing .flexslider').length){
		jQuery('.post-listing .flexslider').each(function(){
			if (jQuery(this).parents('.single').length){
				jQuery(this).flexslider({
					animation: "fade",
					controlNav: true,
					directionNav: true,
					touch: true
				});					
			} else {
				jQuery(this).flexslider({
					animation: "fade",
					controlNav: true,
					directionNav: true,
					touch: true,
					start:function(slider){
						jQuery(slider).find('.flex-direction-nav li a').each(function(){
							jQuery(this).hover(function(){
								jQuery(this).css('background-color',jQuery('#styleColor').html());
							}, function(){
								jQuery(this).css('background-color','rgba(0, 0, 0, 0.5)');
							});
						});
					}
				});
			}
		});
	}
	
	
	if (jQuery('.the_movies').length){
		jQuery('.the_movies').each(function(){
			var who = jQuery(this).attr('data-movie');
			if (who){
				jQuery(this).html("<iframe src='"+jQuery(".v_links[data-movie="+who+"]").eq(0).html()+"' width='100%' height='370' frameborder='0' webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>");
			} else {
				jQuery(this).html("<iframe src='"+jQuery(".v_links").eq(0).html()+"' width='100%' height='370' frameborder='0' webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>");
			}
			if (jQuery(".the_movies").siblings(".v_links").length > 1){
	      		jQuery(this).find('.movies-nav').remove();
	        	jQuery(this).append('<ul class="flex-direction-nav movies-nav"><li><a class="prev" href="javascript:;">Previous</a></li><li><a class="next" href="javascript:;">Next</a></li></ul>');
	      		jQuery(this).siblings('.current_movie').remove();
	      		jQuery(this).after('<div style="display:none;" class="current_movie">0</div>');
	      		
	      		var elem = jQuery(this);
	      		
	      		jQuery(this).find('.movies-nav .prev').click(function(e){
	      			e.preventDefault();
	      			var index = parseInt(elem.siblings('.current_movie').html());
	      			var nextIndex = 0;
	      			if (index == 0) nextIndex = elem.siblings('.v_links').length - 1;
	      			else nextIndex = index-1;
	      			elem.find("iframe").attr('src', elem.siblings('.v_links').eq(nextIndex).html() );
	      			elem.siblings('.current_movie').html(nextIndex);
	      			
	      		});
	      		jQuery(this).find('.movies-nav .next').click(function(e){
	      			e.preventDefault();
	      			var index = parseInt(elem.siblings('.current_movie').html());
	      			var nextIndex = 0;
	      			if (index == elem.siblings('.v_links').length - 1) nextIndex = 0;
	      			else nextIndex = index+1;
	      			elem.find("iframe").attr('src', elem.siblings('.v_links').eq(nextIndex).html() );
	      			elem.siblings('.current_movie').html(nextIndex);
	      		});
	      	}
		});
	}
	
	if (jQuery('.postcontent .flexslider.slider').length){
		jQuery('.postcontent .flexslider.slider .mask .more').each(function(){
			jQuery(this).attr('onclick', 'jQuery(this).parents(\'.mask\').siblings(\'ul.slides\').find(\'li\').eq(0).find(\'a\').trigger(\'click\');');
		});
	}
			
	jQuery('a.comment-reply-link').each(function(){
		if (jQuery(this).attr('href').indexOf('#') != -1){
			jQuery(this).bind('click', function(){
				jQuery('html,body').animate({scrollTop: jQuery(this).offset().top - 80}, 222, 'jswing');
			});
		}
	});
	
	jQuery(".container .vendor").fitVids();

}

function monitorScrollTop(){
	
	if (jQuery('#pbd-alp-load-posts').length){
		var scrollTop = getScrollTop();
	
		window.loadingPoint = parseInt((jQuery('#pbd-alp-load-posts').offset().top - jQuery(window).height() + 50),10);
		
		if (scrollTop >= window.loadingPoint){
			clearInterval(window.interval);
			jQuery('#pbd-alp-load-posts a').click();
		}	
	} else {
		clearInterval(window.interval);
	}

}

function getScrollTop(){
    if(typeof pageYOffset!= 'undefined'){
        //most browsers
        return pageYOffset;
    }
    else{
        var B= document.body; //IE 'quirks'
        var D= document.documentElement; //IE with doctype
        D= (D.clientHeight)? D: B;
        return D.scrollTop;
    }
}


/* load more posts */
jQuery(document).ready(function($) {

	// The number of the next page to load (/page/x/).
	window.pageNum = parseInt($('#loader-startPage').html(),10);
	window.totalForward = 1;
	window.totalBackward = -1;
	
	// The maximum number of pages the current query can return.
	var max = parseInt($('#loader-maxPages').html());
	
	// The link of the next page of posts.
	var nextLink = "empty";
	if ($('.navigation .next-posts').parent().attr('href')) nextLink = $('.navigation .next-posts').parent().attr('href');
	var prevLink = "empty";
	if ($('.navigation .prev-posts').parent().attr('href')) prevLink = $('.navigation .prev-posts').parent().attr('href');
	
	/**
	 * Replace the traditional navigation with our own,
	 * but only if there is at least one page of new posts to load.
	**/
	
	if (nextLink != "empty" || prevLink != "empty"){
		if ($('#reading_option').html() === "scroll" || $('#reading_option').html() === "scrollauto"){
			if((parseInt(window.pageNum, 10)+1) <= max) {
				// Insert the "More Posts" link.
				
				$('.post-listing').each(function(){
		
					if ($(this).parents('.recentPosts_widget').length == 0){
						
						if ($(this).parents('.single').length == 0){
							var appendix = '<p id="pbd-alp-load-posts"><a href="javascript:;">'+ $('#yunik_load_more_posts_text').html() +'</a></p>';
							$(this).parent()
								.append('<div style="position:relative;float:left;display:inline-block;width:100%;" class="pbd-alp-placeholder-'+ (parseInt(window.pageNum, 10)+1) +'"></div>')
								.append(appendix);			
						}
					
					}
					// Remove the traditional navigation.
					if ($(this).parents('.single').length == 0){ $('.navigation').css('display','none'); }
				});
				
			}
			if (parseInt(window.pageNum, 10) > 1){
				$('.post-listing').each(function(){
		
					if ($(this).parents('.recentPosts_widget').length == 0){
						
						if ($(this).parents('.single').length == 0){
							var prependix = '<p id="pbd-alp-load-newer-posts" style="position: relative; height:50px;width:100%;text-align:center;"><a style=" position: relative; display:inline-block;" href="javascript:;">'+ $('#yunik_load_more_posts_text').html() +'</a></p>';
							$(this).parent()
								.prepend('<div class="pbd-alp-placeholder-newer-'+ (parseInt(window.pageNum, 10)-1) +'"></div>')
								.prepend(prependix);			
						}
					
					}
					// Remove the traditional navigation.
					if ($(this).parents('.single').length == 0){ $('.navigation').css('display','none'); }
				});	
			}
			
			
			/**
			 * Load new posts when the link is clicked.
			 */	
			if (jQuery('#pbd-alp-load-posts a').length){
				$('#pbd-alp-load-posts a').click(function(e) {
				
					// Are there more posts to load?
					if((window.pageNum + window.totalForward) <= max) {
					
						// Show that we're working.
						$(this).html(''+$('#yunik_loading_posts_text').html()+'<img style="width:16px; height: 16px; margin-left: 5px; position: relative;" src="'+$('#templatepath').html()+'/img/ajx_loading.gif">');
						
						window.first = true;
						
						$('.pbd-alp-placeholder-'+ parseInt(window.pageNum + window.totalForward,10)).load( nextLink + ' article.post',
							function() {
								
								var whereTo = $('.pbd-alp-placeholder-'+ parseInt(window.pageNum + window.totalForward,10)).offset().top-100;
								
								$('.pbd-alp-placeholder-'+ parseInt(window.pageNum + window.totalForward,10)+' article.post').each(function(){
									/* masonry specifics */
									if ($('.post-listing').hasClass('journal')){
										window.iso.isotope('insert', $(this));
										$(window).trigger('resize');	
									} else {
										$(this).appendTo(jQuery('.post-listing'));
									}
									if ($(this).hasClass('recent')){
										$(this).remove();
									}
								});
								
								if (window.first){
									window.first = false;
									if ($('#reading_option').html() != "scrollauto"){
										$('html,body').stop().animate({
									      "scrollTop": whereTo
									    }, 1200, "easeInOutExpo", function () {
									      //window.location.hash = target;
									   	});	
									}
								}
			
								window.totalForward = parseInt(window.totalForward+1);
			
								if ($('#permalink_structure').html() == "%postname%")
									nextLink = nextLink.replace(/\/page\/[0-9]?/, '/page/'+ parseInt(window.pageNum + window.totalForward,10)); /* links /page/x/ */
								else nextLink = nextLink.replace(/paged=[0-9]?/, "paged="+parseInt(window.pageNum + window.totalForward, 10)); /* links /?paged=x */
							
								// Add a new placeholder, for when user clicks again.
								$('#pbd-alp-load-posts')
									.before('<div style="position:relative;float:left;width:100%;display:inline-block;" class="pbd-alp-placeholder-'+ parseInt(window.pageNum + window.totalForward, 10) +'"></div>')
								
								// Update the button message.
								if((window.pageNum + window.totalForward ) <= max) {
									$('#pbd-alp-load-posts a').text($('#yunik_load_more_posts_text').html());
									if ($('#reading_option').html() === "scrollauto" && !$('body').hasClass('single')) {
										window.clearInterval(window.interval);
										window.interval = setInterval('monitorScrollTop()', 1000 );
									}
								} else {
									$('#pbd-alp-load-posts a').text($('#yunik_no_more_posts_text').html());
									var t=setTimeout(function(){
										$('#pbd-alp-load-posts').slideUp(500).fadeOut(500);
									},5000);
									window.clearInterval(window.interval);
								}
								
								initBlogs();
							}
						).fadeIn(5000);	
					} else {
						window.clearInterval(window.interval);
					}
					return false;
				});
			}
			
			
			if (jQuery('#pbd-alp-load-newer-posts a').length){
				$('#pbd-alp-load-newer-posts a').click(function(e) {
			
					//window.totalBackward = window.totalBackward-1;
					if((window.pageNum + window.totalBackward) > 0) {
					
						// Show that we're working.
						$(this).html(''+$('#yunik_loading_posts_text').html()+'<img style="width:16px; height: 16px; margin-left: 5px; position: relative;" src="'+$('#templatepath').html()+'/img/ajx_loading.gif">');
						$('.pbd-alp-placeholder-newer-'+ (window.pageNum + window.totalBackward)).load( prevLink + ' article.post',
							function() {
		
								$('.pbd-alp-placeholder-newer-'+ (window.pageNum + window.totalBackward)+' article.post').each(function(){
									if ($(this).hasClass('recent')) $(this).remove();
									/* masonry specifics */
									if ($('.post-listing').hasClass('journal')){
										$(this).prependTo($('.journal'));
										window.iso.isotope('reloadItems').isotope({ sortBy: 'original-order' });
										$(window).trigger('resize');									
									} else {
										$(this).prependTo(jQuery('.post-listing'));
									}
								});
														
								window.totalBackward = window.totalBackward-1;
			
								if ($('#permalink_structure').html() == "%postname%")
									prevLink = prevLink.replace(/\/page\/[0-9]?/, '/page/'+ (window.pageNum + window.totalBackward)); /* links /page/x/ */
								else prevLink = prevLink.replace(/paged=[0-9]?/, "paged="+(window.pageNum + window.totalBackward)); /* links /?paged=x */		
								// Add a new placeholder, for when user clicks again.
								$('#pbd-alp-load-newer-posts')
									.after('<div class="pbd-alp-placeholder-newer-'+ parseInt((window.pageNum + window.totalBackward)) +'"></div>')
								
								// Update the button message.
								if((window.pageNum + window.totalBackward+1) > 1) {
									$('#pbd-alp-load-newer-posts a').text($('#yunik_load_more_posts_text').html());
								} else {
									$('#pbd-alp-load-newer-posts a').text($('#yunik_no_more_posts_text').html());
									var t=setTimeout(function(){
										$('#pbd-alp-load-newer-posts').slideUp(500).fadeOut(500);
									},5000);
								}
								
								initBlogs();
							}
						).fadeIn(5000);	
					} else { 
						window.clearInterval(window.interval);
					}	
					return false;
				});
			}
				
		}	
	}
	
});