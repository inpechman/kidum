<?php

	$yunik_thisPostID = get_the_ID(); wp_enqueue_style( 'prettyphoto'); wp_enqueue_script( 'prettyphoto'); 

	if (get_post_meta($yunik_thisPostID, "yunik_enable_custom_pagetitle_options_value", true) == "no" || !get_post_meta($yunik_thisPostID, "yunik_enable_custom_pagetitle_options_value", true)){
		$type = get_option(DESIGNARE_SHORTNAME."_header_type");
		$thecolor = des_hex2rgb(get_option(DESIGNARE_SHORTNAME."_header_color")); 
		$opacity = intval(str_replace("%","",get_option(DESIGNARE_SHORTNAME."_header_opacity")))/100;
		$color = "rgba(".$thecolor[0].",".$thecolor[1].",".$thecolor[2].",".$opacity.")";
		$image = get_option(DESIGNARE_SHORTNAME."_header_image"); 
		$pattern = DESIGNARE_PATTERNS_URL.get_option(DESIGNARE_SHORTNAME."_header_pattern"); 
		$custompattern = get_option(DESIGNARE_SHORTNAME."_header_custom_pattern"); 
		$margintop = get_option(DESIGNARE_SHORTNAME."_header_text_margin_top");	
		$banner = get_option(DESIGNARE_SHORTNAME."_banner_slider");
		$showtitle = get_option(DESIGNARE_SHORTNAME."_hide_pagetitle") == "on" ? true : false;
		$showsectitle = get_option(DESIGNARE_SHORTNAME."_hide_sec_pagetitle") == "on" ? true : false;
		$tcolor = get_option(DESIGNARE_SHORTNAME.'_header_text_color');
		$tsize = intval(str_replace(" ", "", get_option(DESIGNARE_SHORTNAME.'_header_text_size')),10)."px";
		$tfont = get_option(DESIGNARE_SHORTNAME.'_header_text_font');
		$stcolor = get_option(DESIGNARE_SHORTNAME.'_secondary_title_text_color');
		$stsize = intval(str_replace(" ", "", get_option(DESIGNARE_SHORTNAME.'_secondary_title_text_size')),10)."px";
		$stfont = get_option(DESIGNARE_SHORTNAME.'_secondary_title_font');
		$stmargin = intval(str_replace(" ", "", get_option(DESIGNARE_SHORTNAME.'_header_sec_text_margin_top')),10)."px";
		$originalalign = get_option(DESIGNARE_SHORTNAME."_header_text_alignment");
		$pt_parallax = get_option(DESIGNARE_SHORTNAME."_pagetitle_image_parallax") == "on" ? true : false;
		$pt_overlay = get_option(DESIGNARE_SHORTNAME."_pagetitle_image_overlay") == "on" ? true : false;
		$pt_overlay_type = get_option(DESIGNARE_SHORTNAME."_pagetitle_overlay_type");
		$pt_overlay_the_color = des_hex2rgb(get_option(DESIGNARE_SHORTNAME."_pagetitle_overlay_color"));
		$pt_overlay_pattern = (is_string(get_option(DESIGNARE_SHORTNAME."_pagetitle_overlay_pattern"))) ? DESIGNARE_PATTERNS_URL.get_option(DESIGNARE_SHORTNAME."_pagetitle_overlay_pattern") : "";
		$pt_overlay_opacity = intval(str_replace("%","",get_option(DESIGNARE_SHORTNAME."_pagetitle_overlay_opacity")))/100;
		$pt_overlay_color = "rgba(".$pt_overlay_the_color[0].",".$pt_overlay_the_color[1].",".$pt_overlay_the_color[2].",".$pt_overlay_opacity.")";
		$breadcrumbs = get_option(DESIGNARE_SHORTNAME."_breadcrumbs");
		$breadcrumbs_margintop = get_option('yunik_breadcrumbs_text_margin_top');
		$pagetitlepadding = get_option('yunik_page_title_padding');
	} else {
		$type = get_post_meta($yunik_thisPostID, "yunik_header_type_value", true);
		$thecolor = des_hex2rgb(get_post_meta($yunik_thisPostID, "yunik_header_color_value", true)); 
		$opacity = intval(str_replace("%","",get_post_meta($yunik_thisPostID, "yunik_header_color_opacity_value", true)))/100;
		$color = "rgba(".$thecolor[0].",".$thecolor[1].",".$thecolor[2].",".$opacity.")";
		$image = get_post_meta($yunik_thisPostID, "yunik_header_image_value", true);
		$image = explode('|!|',$image);
		if (isset($image[1])) $image = explode('|*|',$image[1]);
		$image = $image[0];
		$pattern = DESIGNARE_PATTERNS_URL.get_post_meta($yunik_thisPostID, "yunik_header_pattern_value", true).".jpg";
		$custompattern = get_option(DESIGNARE_SHORTNAME."yunik_header_custom_pattern_value"); 
		$margintop = get_post_meta($yunik_thisPostID, "yunik_header_text_margin_top_value", true);
		$banner = get_post_meta($yunik_thisPostID, "yunik_banner_slider_value", true);
		$showtitle = get_post_meta($yunik_thisPostID, "yunik_hide_pagetitle_value", true) == "yes" ? true : false;
		$showsectitle = get_post_meta($yunik_thisPostID, "yunik_hide_sec_pagetitle_value", true) == "yes" ? true : false;
		$tcolor = get_post_meta($yunik_thisPostID, "yunik_header_text_color_value", true);
		$tsize = intval(str_replace(" ", "", get_post_meta($yunik_thisPostID, "yunik_header_text_size_value", true)),10)."px";
		$tfont = get_post_meta($yunik_thisPostID, "yunik_header_text_font_value", true);
		$stcolor = get_post_meta($yunik_thisPostID, "yunik_secondary_title_text_color_value", true);
		$stsize = intval(str_replace(" ", "", get_post_meta($yunik_thisPostID, "yunik_secondary_title_text_size_value", true)),10)."px";
		$stfont = get_post_meta($yunik_thisPostID, "yunik_secondary_title_font_value", true);
		$stmargin = intval(str_replace(" ", "", get_post_meta($yunik_thisPostID, "yunik_header_secondary_text_margin_top_value", true)),10)."px";
		$originalalign = get_post_meta($yunik_thisPostID, "yunik_header_text_alignment_value", true);
		$pt_parallax = get_post_meta($yunik_thisPostID, DESIGNARE_SHORTNAME."_pagetitle_image_parallax_value", true) == "on" ? true : false;
		$pt_overlay = get_post_meta($yunik_thisPostID, DESIGNARE_SHORTNAME."_pagetitle_image_overlay_value", true) == "on" ? true : false;
		$pt_overlay_type = get_post_meta($yunik_thisPostID, DESIGNARE_SHORTNAME."_pagetitle_overlay_type_value", true);
		$pt_overlay_the_color = des_hex2rgb(get_post_meta($yunik_thisPostID, DESIGNARE_SHORTNAME."_pagetitle_overlay_color_value", true));
		$pt_overlay_pattern = DESIGNARE_PATTERNS_URL.get_post_meta($yunik_thisPostID, DESIGNARE_SHORTNAME."_pagetitle_overlay_pattern_value", true);
		$pt_overlay_opacity = intval(str_replace("%","",get_post_meta($yunik_thisPostID, DESIGNARE_SHORTNAME."_pagetitle_overlay_opacity_value", true)))/100;
		$pt_overlay_color = "rgba(".$pt_overlay_the_color[0].",".$pt_overlay_the_color[1].",".$pt_overlay_the_color[2].",".$pt_overlay_opacity.")";
/*
		$sidebar_scheme = get_post_meta($yunik_thisPostID, "sidebar_value", true);
		$sidebar = get_post_meta($yunik_thisPostID, "sidebar_which_value", true);
*/
		$breadcrumbs = get_post_meta($yunik_thisPostID, "yunik_enable_breadcrumbs_value", true) == "yes" ? "on" : "off";
		$breadcrumbs_margintop = intval(str_replace(" ", "", get_post_meta($yunik_thisPostID, "yunik_breadcrumbs_margin_top_value", true)),10)."px";
		$pagetitlepadding = intval(str_replace(" ", "", get_post_meta($yunik_thisPostID, "yunik_page_title_padding_value", true)),10)."px";
	}
	$height = "auto";
	
	$textalign = $originalalign;
	if ($originalalign == "titlesleftcrumbsright") $textalign = "left";
	if ($originalalign == "titlesrightcrumbsleft") $textalign = "right";

	global $des_import_fonts;
	
	$des_import_fonts[] = $tfont;
	$principalfont = explode("|",$tfont);
	if ($principalfont[0] == "Helvetica" || $principalfont[0] == "Helvetica Neue") $principalfont[0] = $principalfont[0]."', 'Arial', 'sans-serif";
	if (!isset($principalfont[1])) $principalfont[1] = "";
		
	$des_import_fonts[] = $stfont;
	$secondaryfont = explode("|",$stfont);
	if ($secondaryfont[0] == "Helvetica" || $secondaryfont[0] == "Helvetica Neue") $secondaryfont[0] = $secondaryfont[0]."', 'Arial', 'sans-serif";
	if (!isset($secondaryfont[1])) $secondaryfont[1] = "";
	
	if ($type != "without"){
		?>
		<div class="fullwidth-container <?php if ($pt_parallax) echo "parallax"; ?>" <?php if ($pt_parallax) echo 'data-stellar-ratio="0.5"'; ?> style="
	    	<?php 
		 		if ($height != "") echo "height: ". $height . ";";
				if ($type == "none") echo "background: none;"; 
				if ($type == "color") echo "background: " . $color . ";";
				if ($type == "image") echo "background: url(" . $image . ") no-repeat; background-size: 100% auto;";  
	 			if ($type == "pattern") echo "background: url('" . $pattern . "') 0 0 repeat;";
	    	?>">
	    	<?php
		    	if ($type == "image" && $pt_overlay){
			    	echo '<div class="pagetitle_overlay" style="'; 
			    	if ($pt_overlay_type == "color") echo 'background-color:'.$pt_overlay_color;
			    	else echo 'background:url('.$pt_overlay_pattern.'.jpg) repeat;opacity:'.$pt_overlay_opacity.';';
			    	echo '"></div>';
		    	}
		    	if ($type === "banner"){
			    	?> <div class="revBanner"> <?php putRevSlider(substr($banner, 10)); ?> </div> <?php
		    	} else {
		    	?>
				<div class="container <?php echo $originalalign; ?>" style="padding:<?php echo $pagetitlepadding; ?> 15px;">
					<div class="pageTitle" style="text-align:<?php echo $textalign; ?>;">
					<?php
						if ($showtitle){
							?>
							<h1 class="page_title" style="<?php echo "color: #$tcolor; font-size: $tsize; font-family: '{$principalfont[0]}'; font-weight: {$principalfont[1]};";?><?php if ($margintop != "") echo "margin-top: ".intval($margintop,10)."px;"; ?>">
								<?php 
									if (get_post_meta($yunik_thisPostID, "yunik_enable_custom_pagetitle_options_value", true) == "no" || !get_post_meta($yunik_thisPostID, "yunik_enable_custom_pagetitle_options_value", true)){
										if (get_option('yunik_blog_single_primary_title') != "") echo get_option('yunik_blog_single_primary_title'); else echo get_the_title($yunik_thisPostID);
									} else {
										echo get_the_title($yunik_thisPostID);
									} 
								?>
							</h1>
							<?php
						}
		    			if ($showsectitle){
			    			if (get_post_meta($post->ID, 'secondaryTitle_value', true) != "" || get_option('yunik_blog_secondary_title') != ""){
						    	?>
							    <h2 class="secondaryTitle" style="<?php echo "color: #$stcolor; font-size: $stsize; line-height: $stsize; font-family: '{$secondaryfont[0]}'; font-weight:{$secondaryfont[1]}; margin-top:{$stmargin};";?>">
								    <?php
									    if (get_post_meta($yunik_thisPostID, "yunik_enable_custom_pagetitle_options_value", true) == "no" || !get_post_meta($yunik_thisPostID, "yunik_enable_custom_pagetitle_options_value", true)){
										    if (get_option('yunik_blog_secondary_title') != "") echo get_option('yunik_blog_secondary_title'); else echo get_post_meta($post->ID, 'secondaryTitle_value', true);
									    } else {
										    echo get_post_meta($post->ID, 'secondaryTitle_value', true);
									    }
								    ?>
							    </h2>
					    		<?php
					    	}
		    			}
		    		?>
		    		
		    		</div>
		    		<?php
			    		if ($breadcrumbs == "on"){
				    		?>
				    		<div class="des_breadcrumbs">
								<?php designare_the_breadcrumb(); ?>
				    		</div>
				    		<?php
			    		}
		    		?>
				</div>
		<?php }
		?>
		</div>	
		<?php
	}
	
	$sidebar_scheme = get_option('yunik_blog_single_sidebar');
	$sidebar = get_option('yunik_sidebars_available');
	if ($sidebar == "") $sidebar = "defaultblogsidebar";
	switch ( $sidebar_scheme ){
		case "none":
			?>
			<div class="blog-default wideblog">
				<div class="master_container container">
					<section class="page_content col-xs-12 col-md-12">
						<div class="blog-default-bg">
							<?php des_print_single_post(); ?>
						</div>
					</section>
				</div>
			</div>
			<?php
		break;
		case "left":
			?>
			<div class="blog-default">
				<div class="master_container container">
					<section class="page_content left sidebar col-xs-12 col-md-3">
						
						<div class="blog-sidebar-bg">
							<?php 
							if ($sidebar === "defaultblogsidebar"){
								get_sidebar();
							} else {
								if ( function_exists('dynamic_sidebar')) { 
									ob_start();
								    do_shortcode(dynamic_sidebar($sidebar));
								    $html = ob_get_contents();
								    ob_end_clean();
								    echo $html;  
								}	
							}
							?>
						</div>
					</section>
					<section class="page_content right col-xs-12 col-md-9">
						<div class="blog-default-bg">
							<?php des_print_single_post(); ?>
						</div>
					</section>
				</div>
			</div>
			<?php
		break;
		case "right":
			?>
			
			<div class="blog-default">
				<div class="master_container container">
					<section class="page_content left col-xs-12 col-md-9">
						<div class="blog-default-bg">
							<?php des_print_single_post(); ?>
						</div>
					</section>
					<section class="page_content right sidebar col-xs-12 col-md-3">
						<div class="blog-sidebar-bg">
							<?php 
							if ($sidebar === "defaultblogsidebar"){
								get_sidebar();
							} else {
								if ( function_exists('dynamic_sidebar')) { 
									ob_start();
								    do_shortcode(dynamic_sidebar($sidebar));
								    $html = ob_get_contents();
								    ob_end_clean();
								    echo $html;  
								}
							}
							?>
						</div>
					</section>
				</div>
			</div>
			
			<?php
		break;
		default:
			?>
			<div class="blog-default wideblog">
				<div class="master_container container">
					<section class="page_content col-xs-12 col-md-12">
						<div class="blog-default-bg">
							<?php des_print_single_post(); ?>
						</div>
					</section>
				</div>
			</div>
			<?php
		break;
	}	

	function des_print_single_post(){
		?>
		<article id="post-<?php the_ID(); ?>" class="post">
				
			   	
	    	<?php
	    	
	    	$posttype = get_post_meta(get_the_ID(), 'posttype_value', true);
	    	
	    	$postid = get_the_ID(); ?>
	    	
	    	
	    	<div class="postcontent">
				    									    	
	    	<?php
	    	
	    		switch($posttype){
		    		case "image":
		    			if (wp_get_attachment_url( get_post_thumbnail_id($postid))){
						?>
						
							<div class="featured-image-thumb">
								<?php
									if (get_option(DESIGNARE_SHORTNAME."_enlarge_images") == "on"){ ?>
										<a class="featured-image-fb des_prettyphoto" href="<?php echo wp_get_attachment_url( get_post_thumbnail_id($postid)); ?>" title="<?php  the_title(); ?>">
									<?php
						    		}
								?>
									<img src="<?php echo wp_get_attachment_url( get_post_thumbnail_id($postid)); ?>" title="<?php the_title(); ?>"/>
								<?php
									if (get_option(DESIGNARE_SHORTNAME."_enlarge_images") == "on"){ ?>
										<span class="post_overlay"><i class="fa fa-search" aria-hidden="true"></i></span>
										</a>
									<?php
									}
								?>
							</div>
							<?php 
								if (get_option(DESIGNARE_SHORTNAME."_enlarge_images") == "on"){
								?>
								<script type="text/javascript">
									jQuery(document).ready(function(){
										jQuery('.featured-image-thumb > a.des_prettyphoto').prettyPhoto({
									    	animationSpeed: 'normal', /* fast/slow/normal */
											padding: 15, /* padding for each side of the picture */
											opacity: 0.7, /* Value betwee 0 and 1 */
											showTitle: false, /* true/false */
											allowresize: true, /* true/false */
											counter_separator_label: '/', /* The separator for the gallery counter 1 "of" 2 */
											//theme: 'light_square', /* light_rounded / dark_rounded / light_square / dark_square */
											hideflash: false, /* Hides all the flash object on a page, set to TRUE if flash appears over prettyPhoto */
											deeplinking: false, /* Allow prettyPhoto to update the url to enable deeplinking. */
											modal: false, /* If set to true, only the close button will close the window */
											callback: function () {
												var url = location.href;
												var hashtag = (url.indexOf( '#!prettyPhoto' )) ? true : false;
												if ( hashtag ) {
													location.hash = "!";
												}
											} /* Called when prettyPhoto is closed */,
											social_tools: ''
								    	});
									});
								</script>
								<?php
							}
						}
		    		break;
		    		
		    		case "slider": 
		    			$randClass = rand(0,1000);
						?>
							<div class="flexslider <?php echo $posttype; ?>" id="<?php echo $randClass; ?>">
								<ul class="slides">
									<?php
										$sliderData = get_post_meta($postid, "sliderImages_value", true);
										$slide = explode("|*|",$sliderData);
									    foreach ($slide as $s){
									    	if ($s != ""){
									    		$params = explode("|!|",$s);
									    		$attachment = get_post( $params[0] );
									    		echo "<li>";
									    		if (get_option(DESIGNARE_SHORTNAME."_enlarge_images") == "on"){
										    		echo "<a href='".$params[1]."' rel='des_prettyPhoto[pp_gal]' class='slide-images des_prettyphoto'>";
									    		}
									    		echo "<img src='".$params[1]."' >";
									    		if (get_option(DESIGNARE_SHORTNAME."_enlarge_images") == "on"){
										    		echo "<span class='post_overlay'><i class='fa fa-search' aria-hidden='true'></i></span></a>";
									    		}
									    		echo "</li>";	
									    	}
									    }
									?>
								</ul>
							</div>
							<?php
								$animation = get_option(DESIGNARE_SHORTNAME. "_posts_flex_transition");
								$directionNav = get_option(DESIGNARE_SHORTNAME. "_posts_flex_navigation");
								$slideshowSpeed = get_option(DESIGNARE_SHORTNAME. "_posts_flex_slide_duration") ? get_option(DESIGNARE_SHORTNAME. "_posts_flex_slide_duration") : 3000;
								$pauseOnHover = get_option(DESIGNARE_SHORTNAME. "_posts_flex_pause_hover");
								$controlNav = get_option(DESIGNARE_SHORTNAME. "_posts_flex_controls");
								$slideshow = get_option(DESIGNARE_SHORTNAME. "_posts_flex_autoplay");
								$height = get_option(DESIGNARE_SHORTNAME. "_posts_flex_height");
								$animationDuration = get_option(DESIGNARE_SHORTNAME. "_posts_flex_transition_duration") ? get_option(DESIGNARE_SHORTNAME. "_posts_flex_transition_duration") : 1000;
								if ($directionNav == "on" || $directionNav == "true") $directionNav = true; else $directionNav = false;
								if ($pauseOnHover == "on" || $pauseOnHover == "true") $pauseOnHover = true; else $pauseOnHover = false;
								if ($controlNav == "on" || $controlNav == "true") $controlNav = true; else $controlNav = false;
								if ($slideshow == "on" || $slideshow == "true") $slideshow = true; else $slideshow = false;
							?>
							<script type="text/javascript">
								jQuery(document).ready(function(){ 
									
									<?php if (get_option(DESIGNARE_SHORTNAME."_enlarge_images") == "on"){
								    	?>
								    	jQuery('li:not(.clone) > a.des_prettyphoto, li:not(.clone) > a[rel="des_prettyPhoto[pp_gal]"], .featured-image-thumb > a.des_prettyphoto').prettyPhoto({
									    	animationSpeed: 'normal', /* fast/slow/normal */
											padding: 15, /* padding for each side of the picture */
											opacity: 0.7, /* Value betwee 0 and 1 */
											showTitle: false, /* true/false */
											allowresize: true, /* true/false */
											counter_separator_label: '/', /* The separator for the gallery counter 1 "of" 2 */
											//theme: 'light_square', /* light_rounded / dark_rounded / light_square / dark_square */
											hideflash: false, /* Hides all the flash object on a page, set to TRUE if flash appears over prettyPhoto */
											deeplinking: false, /* Allow prettyPhoto to update the url to enable deeplinking. */
											modal: false, /* If set to true, only the close button will close the window */
											callback: function () {
												var url = location.href;
												var hashtag = (url.indexOf( '#!prettyPhoto' )) ? true : false;
												if ( hashtag ) {
													location.hash = "!";
												}
											} /* Called when prettyPhoto is closed */,
											social_tools: ''
								    	});
								    	<?php
							    	} ?>
									
									
									jQuery('#<?php echo $randClass; ?>.flexslider').flexslider({
										animation: '<?php echo $animation; ?>',
										slideDirection: "horizontal", 
										directionNav: '<?php echo $directionNav; ?>',
										slideshowSpeed: <?php echo $slideshowSpeed; ?>,
										controlsContainer: "#<?php echo $randClass; ?> .flex-viewport",
										pauseOnAction: false,
										pauseOnHover: '<?php echo $pauseOnHover; ?>',
										keyboardNav: false,
										controlNav: '<?php echo $controlNav; ?>',
										slideshow: '<?php echo $slideshow; ?>',
										animationDuration: <?php echo $animationDuration; ?>,
										start: function(slider){
											jQuery('#<?php echo $randClass; ?>.flexslider').css('overflow','visible');
											jQuery(slider).find('.flex-direction-nav').css({ 'position':'absolute', 'width':'100%', 'top':'50%' });
											jQuery(slider).flexslider("next");
										}
									});
									jQuery('#<?php echo $randClass; ?> ul.slides li, #<?php echo $randClass; ?> ul.slides li a').css({'max-height':'<?php echo $height ?>','overflow':'hidden'});
								});
							</script>
							<?php 
		    		break;
		    		
		    		case "audio":
		    			$randClass = rand(0,1000);
						?>
						<div class="audioContainer">
							<?php
								if (get_post_meta($postid, 'audioSource_value', true) == 'embed') echo get_post_meta($postid, 'audioCode_value', true); 
								else {
									$audio = explode("|!|",get_post_meta($postid, 'audioMediaLibrary_value', true));
									if (isset($audio[1])) {
										$ext = explode(".",$audio[1]);
										if (isset($ext)) $ext = $ext[count($ext)-1];
										?>
										<audio controls="controls"><source type="audio/<?php echo $ext; ?>" src="<?php echo $audio[1]; ?>"></audio>
										<?php
									}
								}
							?>
						</div>
						<?php
		    		break;
		    		
		    		case "video":
						$videosType = get_post_meta($postid, "videoSource_value", true);
						if ($videosType != "embed"){
							$videos = get_post_meta($postid, "videoCode_value", true);
							$videos = preg_replace( '/\s+/', '', $videos );
							$vid = explode(",",$videos);
						}
						switch (get_post_meta($postid, "videoSource_value", true)){
							case "media":
								echo "<video id='html5video' preload='metadata' controls='controls' style='position:relative;float:left;width:100%;'>";
								$media = get_post_meta($yunik_thisPostID, 'videoMediaLibrary_value', true);
								$media = explode("|*|",$media);
								foreach ($media as $m){
									if (strlen($m) > 0){
										$videoattrs = explode("|!|",$m);
										$ext = explode('.',$videoattrs[1]);
										$ext = $ext[count($ext)-1];
										echo "<source src=".$videoattrs[1]." type='video/".$ext."'>";
									}
								}
								echo "</video>";
							break;
							case "youtube":
								echo "<div id='the_movies' class='vendor ".get_post_meta($postid, "videoSource_value", true)."'></div>";
								foreach ($vid as $v){
									echo "<div class='v_links'>http://www.youtube.com/embed/".$v."?autoplay=1&wmode=transparent&autohide=1&showinfo=0&rel=0</div>";	
								}
								break;
							case "vimeo":
								echo "<div id='the_movies' class='vendor ".get_post_meta($postid, "videoSource_value", true)."'></div>";
								foreach ($vid as $v){
									echo "<div class='v_links'>http://player.vimeo.com/video/".$v."?autoplay=1&title=0&byline=0&portrait=0</div>";	
								}
								break;
						}
						?>
						<script type="text/javascript">
							jQuery(document).ready(function(){
								<?php
								if (get_post_meta($postid, "videoSource_value", true) != "embed" && get_post_meta($postid, "videoSource_value", true) != "media"){ 
									?>
									jQuery("#the_movies").html("<iframe src='"+jQuery(".v_links").eq(0).html()+"' width='560' height='349' frameborder='0' webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>").fitVids();
									<?php
								}
								?>									          	
					          	if (jQuery("#the_movies").css({'position':'relative','float':'left','width':'100%'}).siblings(".v_links").length > 1){
					          		jQuery('#the_movies').siblings('.movies-nav').remove();
					            	jQuery('#the_movies').append('<ul class="flex-direction-nav movies-nav"><li><a class="prev" href="javascript:;">Previous</a></li><li><a class="next" href="javascript:;">Next</a></li></ul>');
					          		jQuery('#the_movies .flex-direction-nav').css({
						          		'position': 'absolute',
						          		'width':'100%',
						          		'top':'50%',
					          		}).find('li').css({'margin':0,'padding':0}).find('a').css({'display':'inline-block', 'position':'relative', 'opacity':1});
							  		jQuery('#the_movies .flex-direction-nav li').eq(0).css('float','left');
							  		jQuery('#the_movies .flex-direction-nav li').eq(1).css('float','right');
					          		
					          		jQuery('#the_movies').siblings('.current_movie').remove();
					          		jQuery('#the_movies').after('<div style="display:none;" class="current_movie">0</div>');
					          		
					          		jQuery('.movies-nav').find('.prev').click(function(e){
					          			e.preventDefault();
					          			var index = parseInt(jQuery('.current_movie').html());
					          			var nextIndex = 0;
					          			if (index == 0) nextIndex = jQuery('#the_movies').siblings('.v_links').length - 1;
					          			else nextIndex = index-1;
					          			jQuery("#the_movies iframe").attr('src', jQuery('#the_movies').siblings('.v_links').eq(nextIndex).html() );
					          			jQuery('#the_movies').siblings('.current_movie').html(nextIndex);
					          			
					          		});
					          		jQuery('.movies-nav').find('.next').click(function(e){
					          			e.preventDefault();
					          			var index = parseInt(jQuery('.current_movie').html());
					          			var nextIndex = 0;
					          			if (index == jQuery('#the_movies').siblings('.v_links').length - 1) nextIndex = 0;
					          			else nextIndex = index+1;
					          			jQuery("#the_movies iframe").attr('src', jQuery('#the_movies').siblings('.v_links').eq(nextIndex).html() );
					          			jQuery('#the_movies').siblings('.current_movie').html(nextIndex);
					
					          		});
					          		
					          	}
							});
						</script>
						<?php
					break;
		    	}
		    						    	
	    		?>
				
				<div class="the_title"><h2><?php the_title(); ?></h2></div>
		    
			    <div class="metas-container">
	    			
	    			<p class="blog-date"><i class="fa fa-calendar"></i><?php echo get_the_date("M")." ".get_the_date("d").", ".get_the_date("Y"); ?></p>
	    			<p><a class="the_author" href="?author=<?php  the_author_meta('ID'); ?>"><i class="fa fa-user"></i> <?php  the_author_meta('nickname'); ?></a></p>
					
		    		<?php
						$posttags = get_the_tags();
						if ($posttags) {
							$first = true;
							echo '<p><i class="fa fa-tags"></i> ';
							foreach($posttags as $tag) {
								if ($tag->name != "uncategorized"){
									if ($first){
										echo "<a href='".esc_url( home_url( '/' ) )."tag/".$tag->slug."'>".$tag->name."</a>"; 
										$first = false;
									} else {
										echo "<span style='float:left;width:0;'>, </span><a href='".esc_url( home_url( '/' ) )."tag/".$tag->slug."'>".$tag->name."</a>";
									}		
								}								    
						  	}
						  	echo '</p>';
						}
					?>
					<?php
						$postcats = get_the_category();
						if ($postcats) {
							$first = true;
							echo '<p><i class="fa fa-pencil-square-o"></i> ';
							foreach($postcats as $cat) {
								if ($cat->name != "uncategorized"){
									if ($first){
										echo "<a href='".esc_url( home_url( '/' ) )."category/".$cat->slug."'>".$cat->name."</a>"; 
										$first = false;
									} else {
										echo "<span style='float:left;width:0;'>, </span><a href='".esc_url( home_url( '/' ) )."category/".$cat->slug."'>".$cat->name."</a>"; 
									}	
								}									    
						  	}
						  	echo '</p>';
						}
					?>
					
					<p><a class="nav-to" href="#comments"><i class="fa fa-comments-o"></i> <?php echo get_comments_number(); ?></a></p>
	    		</div>
	    		
	    		
	    		<div class="the_content">
			    	<?php 
			    		the_content();
			    		$args = array(
							'before'           => '<div class="navigation" style="margin-top: 0px;"><div class="des-pages"><span class="pages current">' . __('Post Pages:', 'yunik') . '</span>',
							'after'            => '</div></div>',
							'link_before'      => '<div class="postpagelinks">',
							'link_after'       => '</div>',
							'next_or_number'   => 'number',
							'nextpagelink'     => __('Next page','yunik'),
							'previouspagelink' => __('Previous page','yunik'),
							'pagelink'         => '%',
							'echo'             => 1
						); 
			    		wp_link_pages($args); 
			    	?>

			    </div>
	    		
	    		<div class="about-author">
										    
				    <div class="img-container">
					    <?php echo str_replace('avatar-80', 'avatar-80', get_avatar(get_the_author_meta('email'), 80)); ?>
				    </div>
				    <h5>Post by <a href="?author=<?php  the_author_meta('ID'); ?>"><?php the_author(); ?></a></h5>
				    <p><?php the_author_meta('description'); ?></p>
				</div>
			
	    		
	    		<div class="share-buttons">
	                <h5>SHARE THIS</h5>        
					<!--  NEW STUFF -->
	                <div class="posts-shares">
	                    <div class="social-shares clearfix">
					        <ul>
								<li>
									<a href="http://www.facebook.com/sharer.php?u=<?php the_permalink();?>&t=<?php the_title(); ?>" class="share-facebook" target="_blank" title=""><i class="fa fa-facebook"></i>Facebook</a>
								</li>
								
								<li>
									<a href="http://twitter.com/home?status=<?php the_title(); ?> <?php the_permalink(); ?>" class="share-twitter" target="_blank" title=""><i class="fa fa-twitter"></i>Twitter</a>
								</li>
								
								<li>
									<a href="http://linkedin.com/shareArticle?mini=true&url=<?php the_permalink();?>&title=<?php the_title();?>" target="_blank" class="share-linkedin" title=""><i class="fa fa-linkedin"></i>Linkedin</a>
								</li>
								
								<li>
									<a href="http://google.com/bookmarks/mark?op=edit&bkmk=<?php the_permalink() ?>&title=<?php echo urlencode(esc_attr(the_title('', '', false))); ?>" target="_blank" class="share-google" title=""><i class="fa fa-google-plus"></i>Google Plus</a>
								</li>
								
								<li>
									<a href="https://www.pinterest.com/pin/create/button/?url=<?php the_permalink(); ?>&media=<?php $url = wp_get_attachment_url( get_post_thumbnail_id(get_the_ID()) ); echo esc_url($url); ?>&" target="_blank" class="share-pinterest" title=""><i class="fa fa-pinterest"></i>Pinterest</a>
								</li>
		
		
								<li>
									<a href="https://www.tumblr.com/share/?url=<?php the_permalink() ?>&title=<?php echo urlencode(esc_attr(the_title('', '', false))); ?>" class="share-tumblr" target="_blank" title=""><i class="fa fa-tumblr"></i>Tumblr</a>									
								</li>
							
								<li>
									<a href="mailto:?subject=<?php the_title();?>&body=<?php the_permalink() ?>" class="share-mail" title=""><i class="fa fa-envelope-o"></i> Email</a>
								</li>
								
								
					        </ul>
					    </div>
	                    
	                </div>
	                
	             </div>    
				 
				 
				 <nav id="nav-below" role="article" class="navigation">
					<?php 
						previous_post_link( '<div class="nav-previous"><i class="fa fa-angle-left"></i>%link</div>', __(get_option('yunik_single_previous_text'),'yunik')); 
						next_post_link( '<div class="nav-next">%link<i class="fa fa-angle-right"></i></div>', __(get_option('yunik_single_next_text'),'yunik') ); 
					?>
				</nav>
					
			    <div class="the_comments">
				    <?php comments_template( '', true ); ?>
			    </div>
		    
				
				
		    </div> <!-- end of .postcontent -->
	    	
	    </article> <!-- end of post -->
		<?php
	}
	?>
	<script type="text/javascript">
	jQuery(document).ready(function(){
		// Open social-shares links in Popup
		jQuery('.social-shares a[target=_blank]').live('click', function(){
	        newwindow=window.open($(this).attr('href'),'','height=450,width=700');
	        if (window.focus) {newwindow.focus()}
	        return false;
	    });
	});
	</script>
	
	<style>
	<?php
	if ($breadcrumbs == "on"){
		if ($originalalign == "titlesleftcrumbsright" || $originalalign == "titlesrightcrumbsleft"){
			?>
			.fullwidth-container .pageTitle, .des_breadcrumbs{max-width: 50%;}
			<?php
			if ($originalalign == "titlesleftcrumbsright"){
				?>
				.fullwidth-container .pageTitle{float:left;}
				.fullwidth-container .des_breadcrumbs{float:right;}
				<?php
			} else {
				?>
				.fullwidth-container .pageTitle{float:right;}
				.fullwidth-container .des_breadcrumbs{float:left;}
				<?php
			}
		}
		?>
		.des_breadcrumbs{
			margin-top: <?php echo intval($breadcrumbs_margintop,10)."px"; ?>;
			<?php
				switch($originalalign){
					case "left": case "titlesrightcrumbsleft":
					?>
					text-align: left;
					<?php
					break;
					case "right": case "titlesleftcrumbsright":
					?>
					text-align: right;
					<?php
					break;
					case "center": 
					?>
					text-align: center;
					<?php
					break;
				}
			?>
		}
		<?php
	}
	?>
	</style>