<?php
 
	$yunik_thisPostID = get_the_ID(); 

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
							<h1 class="page_title" style="<?php echo "color: #$tcolor; font-size: $tsize; font-family: '{$principalfont[0]}';font-weight:{$principalfont[1]}; ";?><?php if ($margintop != "") echo "margin-top: ".intval($margintop,10)."px;"; ?>">
								<?php echo get_the_title($yunik_thisPostID); ?>
							</h1>
							<?php
						}
		    			if ($showsectitle){
			    			if (get_post_meta($post->ID, 'secondaryTitle_value', true) != ""){
						    	?>
							    <h2 class="secondaryTitle" style="<?php echo "color: #$stcolor; font-size: $stsize; line-height: $stsize; font-family: '{$secondaryfont[1]}'; font-weight:{$secondaryfont[1]}; margin-top:{$stmargin};";?>">
							    	<?php echo get_post_meta($post->ID, 'secondaryTitle_value', true); ?>
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
		    		<div class="projects_nav1">
						<?php previous_post_link( '<div class="nav-previous-nav1">%link</div>', __(get_option(DESIGNARE_SHORTNAME."_prev_single_proj"),"yunik") ); ?>
						<?php next_post_link( '<div class="nav-next-nav1">%link</div>', __(get_option(DESIGNARE_SHORTNAME."_next_single_proj"), "yunik") ); ?>
					</div>
				</div>
		<?php }
		?>
		</div>
		<?php
	}
	
	$yunik_custom = get_post_meta($yunik_thisPostID, 'des_custom_page_style_value', true);
	$singleLayout = get_post_meta($yunik_thisPostID, 'singleLayout_value', true);
	if ($singleLayout == "default"){
		$singleLayout = get_option(DESIGNARE_SHORTNAME."_single_layout");
	}

	if (get_post_meta($yunik_thisPostID, "portfolioType_value", true) != "other") {
		$pj_cols = " col-md-7";
		$ct_cols = " col-md-5";
		if ($singleLayout != "left_media"){
			$pj_cols = " col-md-12";
			$ct_cols = " col-md-12";
		}
		?>
		<article id="post-<?php the_ID(); ?>" <?php post_class('container'); ?> role="article">
			<div class="proj-content">
				<div class="projects_description">
					<div class="projects_media <?php echo $singleLayout . $pj_cols; ?>">
						<?php
							$output = "";
							
							if ($singleLayout == 'fullwidth_media'){
								$output .= "[vc_row full_width='stretch_row_content_no_spaces' video_opts='' multi_color_overlay=''][vc_column width='1/1'][vc_column_text]";
							}
						
							if (get_post_meta($yunik_thisPostID, "portfolioType_value", true) == "image"){
								$output .= "<div id='p-slider-".get_the_ID()."' class='flexslider clearfix'><ul class='slides da-thumbs-plus'>";
								
								$sliderData = get_post_meta($yunik_thisPostID, "sliderImages_value", true);
								$slide = explode("|*|",$sliderData);
								foreach ($slide as $s){
							    	if ($s != ""){
							    		$url = explode("|!|",$s);
							    		$output .= "<li><img src='".$url[1]."' alt='' width='100%' class='rp_style1_img'></li>";	
							    	}
							    }
							    $output .= "</ul></div>";
							} 
							if (get_post_meta($yunik_thisPostID, "portfolioType_value", true) == "video") {
								$videosType = get_post_meta($yunik_thisPostID, "videoSource_value", true);
								if ($videosType != "embed"){
									$videos = get_post_meta($yunik_thisPostID, "videoCode_value", true);
									$videos = preg_replace( '/\s+/', '', $videos );
									$vid = explode(",",$videos);
								}
								switch (get_post_meta($yunik_thisPostID, "videoSource_value", true)){
									case "media":
										$output .= "<video id='html5video' preload='metadata' controls='controls' style='position:relative;float:left;width:100%;'>";
										$media = get_post_meta($yunik_thisPostID, 'videoMediaLibrary_value', true);
										$media = explode("|*|",$media);
										foreach ($media as $m){
											if (strlen($m) > 0){
												$videoattrs = explode("|!|",$m);
												$ext = explode('.',$videoattrs[1]);
												$ext = $ext[count($ext)-1];
												$output .= "<source src=".$videoattrs[1]." type='video/".$ext."'>";
											}
										}
										$output .= "</video>";
									break;
									case "youtube":
										$output .= "<div id='the_movies' class='vendor'></div>";
										foreach ($vid as $v){
											$output .= "<div class='v_links'>http://www.youtube.com/embed/".$v."?autoplay=1&amp;wmode=transparent&amp;autohide=1&amp;showinfo=0&amp;rel=0</div>";	
										}
										break;
									case "vimeo":
										$output .= "<div id='the_movies' class='vendor'></div>";
										foreach ($vid as $v){
											$output .= "<div class='v_links'>http://player.vimeo.com/video/".$v."?autoplay=1&amp;title=0&amp;byline=0&amp;portrait=0</div>";	
										}
										break;
									case "embed":
										$output .= "<div class='embedded'>".get_post_meta($yunik_thisPostID, "videoCode_value", true)."</div>";
										break;
								}
							}
							
						if ($singleLayout == "fullwidth_media"){
							$output .= "[/vc_column_text][/vc_column][/vc_row]";
							echo do_shortcode($output);
						} else {
							echo $output;
						}
						?>
					</div>
					<div class="content_container <?php echo $ct_cols; ?>">
						<?php 
							wp_reset_query();
							$content = get_the_content(get_the_ID());
							$content = apply_filters('the_content', $content); 
							des_content_shortcoder($content);
							echo $content;
							$shortcodes_custom_css = get_post_meta( get_the_ID(), '_wpb_shortcodes_custom_css', true );
							if ( isset($shortcodes_custom_css) && ! empty( $shortcodes_custom_css ) ) {
								echo '<style type="text/css" data-type="vc_shortcodes-custom-css">';
								echo $shortcodes_custom_css;
								echo '</style>';
							}						
						?>
					</div>
				</div>
			</div>
			
			<div class="share-buttons">
                <h5>SHARE THIS PROJECT</h5>        
				<!--  NEW STUFF -->
                <div class="posts-shares">
                    <div class="social-shares clearfix">
				        <ul>
							<li>
								<a href="http://www.facebook.com/sharer.php?u=<?php the_permalink();?>&amp;t=<?php the_title(); ?>" class="share-facebook" target="_blank" title=""><i class="fa fa-facebook"></i>Facebook</a>
							</li>
							
							<li>
								<a href="http://twitter.com/home?status=<?php the_title(); ?> <?php the_permalink(); ?>" class="share-twitter" target="_blank" title=""><i class="fa fa-twitter"></i>Twitter</a>
							</li>
							
							<li>
								<a href="http://linkedin.com/shareArticle?mini=true&amp;url=<?php the_permalink();?>&amp;title=<?php the_title();?>" target="_blank" class="share-linkedin" title=""><i class="fa fa-linkedin"></i>Linkedin</a>
							</li>
							
							<li>
								<a href="http://google.com/bookmarks/mark?op=edit&amp;bkmk=<?php the_permalink() ?>&amp;title=<?php echo urlencode(esc_attr(the_title('', '', false))); ?>" target="_blank" class="share-google" title=""><i class="fa fa-google-plus"></i>Google Plus</a>
							</li>
							
							<li>
								<a href="https://www.pinterest.com/pin/create/button/?url=<?php the_permalink(); ?>&amp;media=<?php $url = wp_get_attachment_url( get_post_thumbnail_id(get_the_ID()) ); echo esc_url($url); ?>&amp;" target="_blank" class="share-pinterest" title=""><i class="fa fa-pinterest"></i>Pinterest</a>
							</li>
	
							<li>
								<a href="https://www.tumblr.com/share/?url=<?php the_permalink() ?>&amp;title=<?php echo urlencode(esc_attr(the_title('', '', false))); ?>" class="share-tumblr" target="_blank" title=""><i class="fa fa-tumblr"></i>Tumblr</a>									
							</li>
						
							<li>
								<a href="mailto:?subject=<?php the_title();?>&amp;body=<?php the_permalink() ?>" class="share-mail" title=""><i class="fa fa-envelope-o"></i> Email</a>
							</li>
							
							
				        </ul>
				    </div>
                    
                </div>
                
             </div> 
	             
	             
			<div class="the_comments">
			    <?php if (comments_open()) {
				  	remove_action('comment_form','wp_comment_form_unfiltered_html_nonce');
				  	comments_template( '', true ); 
			    }
			    ?>
		    </div>
		</article>
		
		<script type="text/javascript">
			jQuery(document).ready(function(){
				
			<?php
				if(get_post_meta($yunik_thisPostID, "portfolioType_value", true) == "image"){ 
				
					if (get_post_meta($yunik_thisPostID, "custom_slider_opts_value", true) == "on"){
						$animation = get_post_meta($yunik_thisPostID, "projs_flex_transition_value", true);
						$directionNav = get_post_meta($yunik_thisPostID, "projs_flex_navigation_value", true);
						$slideshowSpeed = get_post_meta($yunik_thisPostID, "projs_flex_slide_duration_value", true) != "" ? get_post_meta($yunik_thisPostID, "projs_flex_slide_duration_value", true) : 3000;
						$pauseOnHover = get_post_meta($yunik_thisPostID, "projs_flex_pause_hover_value", true);
						$controlNav = get_post_meta($yunik_thisPostID, "projs_flex_controls_value", true);
						$slideshow = get_post_meta($yunik_thisPostID, "projs_flex_autoplay_value", true);
						$height = get_post_meta($yunik_thisPostID, "projs_flex_height_value", true);
						$animationDuration = get_post_meta($yunik_thisPostID, "projs_flex_transition_duration_value", true) != "" ? get_post_meta($yunik_thisPostID, "projs_flex_transition_duration_value", true) : 1000;
					} else {
						$animation = get_option(DESIGNARE_SHORTNAME. "_projs_flex_transition");
						$directionNav = get_option(DESIGNARE_SHORTNAME. "_projs_flex_navigation");
						$slideshowSpeed = get_option(DESIGNARE_SHORTNAME. "_projs_flex_slide_duration") ? get_option(DESIGNARE_SHORTNAME. "_projs_flex_slide_duration") : 3000;
						$pauseOnHover = get_option(DESIGNARE_SHORTNAME. "_projs_flex_pause_hover");
						$controlNav = get_option(DESIGNARE_SHORTNAME. "_projs_flex_controls");
						$slideshow = get_option(DESIGNARE_SHORTNAME. "_projs_flex_autoplay");
						$height = get_option(DESIGNARE_SHORTNAME. "_projs_flex_height");
						$animationDuration = get_option(DESIGNARE_SHORTNAME. "_projs_flex_transition_duration") ? get_option(DESIGNARE_SHORTNAME. "_projs_flex_transition_duration") : 1000;
					}
				
					if ($directionNav == "on" || $directionNav == "true") $directionNav = true; else $directionNav = false;
					if ($pauseOnHover == "on" || $pauseOnHover == "true") $pauseOnHover = true; else $pauseOnHover = false;
					if ($controlNav == "on" || $controlNav == "true") $controlNav = true; else $controlNav = false;
					if ($slideshow == "on" || $slideshow == "true") $slideshow = true; else $slideshow = false;
				?>
				
					

				if (jQuery("#p-slider-<?php echo $yunik_thisPostID; ?>").find('li').length > 1){
					jQuery("#p-slider-<?php echo $yunik_thisPostID; ?>").flexslider({
						animation: '<?php echo $animation; ?>',
						slideDirection: "horizontal", 
						directionNav: '<?php echo $directionNav; ?>',
						slideshowSpeed: <?php echo $slideshowSpeed; ?>,
						controlsContainer: "#p-slider-<?php echo $yunik_thisPostID; ?> .flex-viewport",
						pauseOnAction: false,
						pauseOnHover: '<?php echo $pauseOnHover; ?>',
						keyboardNav: false,
						controlNav: '<?php echo $controlNav; ?>',
						slideshow: '<?php echo $slideshow; ?>',
						animationDuration: <?php echo $animationDuration; ?>,
						start: function(slider){
							jQuery(slider).find('.flex-direction-nav').css({ 'position':'absolute', 'width':'100%', 'top':'50%' });
							//jQuery(slider).flexslider("next");
						}
					});
					jQuery("#p-slider-<?php echo $yunik_thisPostID; ?> ul.slides").css({'max-height':'<?php echo $height ?>', 'overflow':'hidden'});

				} else {
						jQuery("#p-slider-<?php echo $yunik_thisPostID; ?>").find('ul li').css('display','block');
						jQuery("#p-slider-<?php echo $yunik_thisPostID; ?>").find('li a img').css('opacity',1);
						jQuery("#p-slider-<?php echo $yunik_thisPostID; ?>").find('.magnifier').bind('click', function(){
						jQuery("#p-slider-<?php echo $yunik_thisPostID; ?>").find('li a').trigger('click');
					});
				}

			<?php } if (get_post_meta($yunik_thisPostID, "portfolioType_value", true) == "video") {
				
				if (get_post_meta($yunik_thisPostID, "videoSource_value", true) != "embed" && get_post_meta($yunik_thisPostID, "videoSource_value", true) != "media"){ 
					?>
					jQuery("#the_movies").html("<iframe src='"+jQuery(".v_links").eq(0).html()+"' width='560' height='349' frameborder='0' webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>").fitVids();
					<?php
				}
				?>									          	
	          	if (jQuery("#the_movies").css({'position':'relative','float':'left','width':'100%'}).siblings(".v_links").length > 1){
	          		jQuery('.projects_media #the_movies').siblings('.movies-nav').remove();
	            	jQuery('.projects_media #the_movies').append('<ul class="flex-direction-nav movies-nav"><li><a class="prev" href="javascript:;">Previous</a></li><li><a class="next" href="javascript:;">Next</a></li></ul>');
	          		jQuery('.projects_media #the_movies .flex-direction-nav').css({
		          		'position': 'absolute',
		          		'width':'100%',
		          		'top':'50%',
	          		}).find('li').css({'margin':0,'padding':0}).find('a').css({'display':'inline-block', 'position':'relative', 'opacity':1});
			  		jQuery('.projects_media #the_movies .flex-direction-nav li').eq(0).css('float','left');
			  		jQuery('.projects_media #the_movies .flex-direction-nav li').eq(1).css('float','right');
	          		
	          		jQuery('.projects_media #the_movies').siblings('.current_movie').remove();
	          		jQuery('.projects_media #the_movies').after('<div style="display:none;" class="current_movie">0</div>');
	          		
	          		jQuery('.movies-nav').find('.prev').click(function(e){
	          			e.preventDefault();
	          			var index = parseInt(jQuery('.current_movie').html());
	          			var nextIndex = 0;
	          			if (index == 0) nextIndex = jQuery('.projects_media #the_movies').siblings('.v_links').length - 1;
	          			else nextIndex = index-1;
	          			jQuery("#the_movies iframe").attr('src', jQuery('.projects_media #the_movies').siblings('.v_links').eq(nextIndex).html() );
	          			jQuery('.projects_media #the_movies').siblings('.current_movie').html(nextIndex);
	          			
	          		});
	          		jQuery('.movies-nav').find('.next').click(function(e){
	          			e.preventDefault();
	          			var index = parseInt(jQuery('.current_movie').html());
	          			var nextIndex = 0;
	          			if (index == jQuery('.projects_media #the_movies').siblings('.v_links').length - 1) nextIndex = 0;
	          			else nextIndex = index+1;
	          			jQuery("#the_movies iframe").attr('src', jQuery('.projects_media #the_movies').siblings('.v_links').eq(nextIndex).html() );
	          			jQuery('.projects_media #the_movies').siblings('.current_movie').html(nextIndex);
	
	          		});
	          		
	          	}
	          	<?php
			} ?>
				
				if (!jQuery('.nav-previous-nav1').length){
					jQuery('.nav-previous-nav1').html('<a href="javascript:;" rel="prev" style="color: rgb(102, 102, 102); opacity: 0.3; filter: alpha(opacity=30);">l</a>');
				}
				if (!jQuery('.nav-next-nav1').length){
					jQuery('.nav-next-nav1').html('<a href="javascript:;" rel="next" style="color: rgb(102, 102, 102); opacity: 0.3; filter: alpha(opacity=30);">r</a>');
				}
									
			});

		</script>
	<?php
	} else {
		?>
		<article id="post-<?php the_ID(); ?>" <?php post_class('container'); ?> role="article">
			<div class="content_container col-md-12">
				<?php 
					wp_reset_query();
					$content = get_the_content(get_the_ID());
					$content = apply_filters('the_content', $content); 
					des_content_shortcoder($content);
					echo $content;
					$shortcodes_custom_css = get_post_meta( get_the_ID(), '_wpb_shortcodes_custom_css', true );
					if ( isset($shortcodes_custom_css) && ! empty( $shortcodes_custom_css ) ) {
						echo '<style type="text/css" data-type="vc_shortcodes-custom-css">';
						echo $shortcodes_custom_css;
						echo '</style>';
					}
				?>
			</div>
		</article>
		<div class="the_comments">
	    <?php if (comments_open()) {
			  	remove_action('comment_form','wp_comment_form_unfiltered_html_nonce');
			  	comments_template( '', true ); 
		    }
		    ?>
	    </div>
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