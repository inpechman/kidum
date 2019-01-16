<?php
/*
Template Name: One Page Template
*/

/**
 * @package WordPress
 * @subpackage Yunik
 */
	get_header();
	
		global $yunik_reading_option; $yunik_reading_option = get_option(DESIGNARE_SHORTNAME.'_blog_reading_type');
			
		global $yunik_more;
			$yunik_more = 0; 
	
		$menuLocations = get_nav_menu_locations();
		$this_page_id = get_the_ID();
		$menuID = 0;
		if (isset($menuLocations['PrimaryNavigation'])){
			$menuID = $menuLocations['PrimaryNavigation'];
		}
		$theMenus = wp_get_nav_menus($menuID);
		$theMenu = array();
		
		for ($idx = 0; $idx < count($theMenus); $idx++){
			if ($theMenus[$idx]->term_id == $menuID){
				$theMenu = $theMenus[$idx];
			}
		}		
		
		if (is_front_page() && !vc_is_inline()){
			wp_enqueue_style('js_composer_front');
			$fonts = get_option('smile_fonts');
			if(is_array($fonts)){
				foreach($fonts as $font => $info){
					if(strpos($info['style'], 'http://' ) !== false) {
						wp_enqueue_style('bsf-'.$font,$info['style']);
					} else {
						$uploadsdir = wp_upload_dir();
						wp_enqueue_style('bsf-'.$font,trailingslashit(set_url_scheme(trailingslashit($uploadsdir['baseurl'])."smile_fonts")).$info['style']);
					}
				}
			}
			
			if (!empty($theMenu)){
				$args = array(
			        'order'                  => 'ASC',
			        'orderby'                => 'menu_order',
			        'post_type'              => 'nav_menu_item',
			        'post_status'            => 'publish',
			        'output'                 => ARRAY_A,
			        'output_key'             => 'menu_order',
			        'nopaging'               => true,
			        'update_post_term_cache' => false 
			    );
				$items = wp_get_nav_menu_items( $theMenu->slug, $args );
				des_yunik_print_menu(false);
				
				$outsiders = array();
				$firstHome = true;
				ob_start();
				foreach ($items as $i){
					$thisID = $i->object_id;
					$template = get_post_meta($thisID, '_wp_page_template', true);
					
					if ($template === "template-home.php" && $firstHome){
						$firstHome = false;
						$homeType = get_post_meta($thisID, 'homeStyle_value', true);
						switch($homeType){
							case "slider":
								$prlx = (get_post_meta($thisID, 'parallaxEffect_value', true) == 'yes') ? true : false ;
								des_yunik_print_slider($thisID, $prlx);
							break;
							case "image": case "video":
								?>
								<section id="home" class="homepage_parallax <?php echo $homeType; if (get_post_meta($thisID, 'parallaxEffect_value', true) == 'yes') echo " parallax"; ?>">
									<?php
										if ($homeType == "image"){
											$media = get_post_meta($thisID, 'homeParallaxMedia_value', true);
											$media = explode("|!|",$media);
											?>
											<div id="parallax-home" <?php if (get_post_meta($thisID, 'parallaxEffect_value', true) == 'yes') echo 'class="parallax" data-stellar-ratio="0.5" '; ?> style="background-image: url(<?php echo $media[1]; ?>);background-size:cover;text-align:center;">
												<?php des_yunik_print_intro($thisID); ?>
											</div>
											<?php
										} else {
											?>
											<div id="parallax-home" <?php if (get_post_meta($thisID, 'parallaxEffect_value', true) == 'yes') echo 'class="parallax" data-stellar-ratio="0.5"'; ?>>
												<?php des_yunik_print_intro($thisID, true); ?>
												
												<?php
													if (get_post_meta($thisID, 'homeVideoSource_value', true) != 'youtube'){
														?>
														<div class="video-container <?php if (get_post_meta($thisID, 'parallaxEffect_value', true) == 'yes') echo 'parallax'; ?>">
														<?php
														$media = get_post_meta($thisID, 'homeParallaxMedia_video_value', true);
														$media = explode("|!|",$media);
														$controls = (get_post_meta($thisID, 'homeVideoControls_value', true) == 'yes') ? "true" : "false";
														echo do_shortcode("[video src='".$media[1]."' preload='true' autoplay='true' loop='true' controls='".$controls."']");
														?>
														</div>
														<?php
													}
												?>
											</div>
											<?php
											if (get_post_meta($thisID, 'homeVideoSource_value', true) == 'youtube'){
												$controls = (get_post_meta($thisID, 'homeVideoControls_value', true) == 'yes') ? "true" : "false";
												?>
												<div class="player" style="display:block; margin: auto; background: rgba(0,0,0,0.5)" data-property="{videoURL:'<?php echo get_post_meta($thisID, 'homeYoutubeLink_value', true); ?>',  optimizeDisplay:true, showControls:<?php echo $controls; ?>,containment:'#parallax-home',startAt:0,mute:<?php echo (get_post_meta($thisID,'homeVideoMuted_value', true) == 'yes') ? "true" : "false"; ?>,autoPlay:true,player:true,loop:true,opacity:1,stopMovieOnBlur:true}"></div>
												<?php
											}
										}
									?>
									
									<script type="text/javascript">
										jQuery(document).ready(function($){
										
											if (jQuery('.homepage_parallax #home-slider').length){
												jQuery('.home-slide').each(function(){
												    contentSize = jQuery(this).find('.home-slide-content');  
											        contentSize.fitText(1);			
												});
												jQuery('#home-slider.flexslider').flexslider({						
													animation: "swing",
													direction: "vertical",
													slideshow: true,
													slideshowSpeed: 3500,
													animationDuration: 1000,
													directionNav: false,
													controlNav: true,
													smootheHeight: true
												});
											}
										});	
									</script>
								</section>
								<div class="clear"></div>
								<?php
							break;
						}
						?>
						<section class="page_content" id="section_page-<?php echo $thisID; ?>">
							<div class="container">
							<?php echo apply_filters('the_content', get_post_field('post_content', $thisID)); 
								$shortcodes_custom_css = get_post_meta( $thisID, '_wpb_shortcodes_custom_css', true );
								if ( ! empty( $shortcodes_custom_css ) ) {
									echo '<style type="text/css" data-type="vc_shortcodes-custom-css">';
									echo $shortcodes_custom_css;
									echo '</style>';
								}
							?>
							</div>
						</section>
						<?php
						
					} else {
						if ($template === "one-page-template.php"){
							$thepost = get_post($thisID);
							?>
							<section class="page_content section_page-<?php echo $thisID; ?>" id="section_page-<?php echo $thisID; ?>" data-section-title="<?php echo $thepost->post_title; ?>">
								<div class="container">
								<?php
									$content = wpb_js_remove_wpautop($thepost->post_content, true);
									if(stripos($thepost->post_content, 'font_call:')){
										preg_match_all('/font_call:(.*?)"/',$thepost->post_content, $display);
										enquque_ultimate_google_fonts_optimzed($display[1]);
									}
									echo do_shortcode($thepost->post_content);
									/* check the content for ultimate addons shortcodes */
									des_content_shortcoder($thepost->post_content);
									/* custom element css */
									$shortcodes_custom_css = get_post_meta( $thisID, '_wpb_shortcodes_custom_css', true );
									if ( ! empty( $shortcodes_custom_css ) ) {
										echo '<style type="text/css" data-type="vc_shortcodes-custom-css">';
										echo $shortcodes_custom_css;
										echo '</style>';
									}
								?>
								</div>
							</section>
							<?php
						} else {
							array_push($outsiders, $thisID);
						}
					}
				}
			} else {
				echo "You need to assign one Menu to the Main Navigation.";
			}
		} else {
			
			des_yunik_print_menu(true);
			
			if (get_post_meta($this_page_id, "yunik_enable_custom_pagetitle_options_value", true) == "no" || !get_post_meta($this_page_id, "yunik_enable_custom_pagetitle_options_value", true)){
				$type = get_option(DESIGNARE_SHORTNAME."_header_type");
				$thecolor = des_hex2rgb(get_option(DESIGNARE_SHORTNAME."_header_color")); 
				$opacity = intval(str_replace("%","",get_option(DESIGNARE_SHORTNAME."_header_opacity")))/100;
				$color = "rgba(".$thecolor[0].",".$thecolor[1].",".$thecolor[2].",".$opacity.")";
				$image = get_option(DESIGNARE_SHORTNAME."_header_image"); 
				$pattern = DESIGNARE_PATTERNS_URL.get_option(DESIGNARE_SHORTNAME."_header_pattern"); 
				$custompattern = get_option(DESIGNARE_SHORTNAME."_header_custom_pattern"); 
				//$height = get_option(DESIGNARE_SHORTNAME."_header_height"); 
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
				$pt_overlay_pattern = DESIGNARE_PATTERNS_URL.get_option(DESIGNARE_SHORTNAME."_pagetitle_overlay_pattern");
				$pt_overlay_opacity = intval(str_replace("%","",get_option(DESIGNARE_SHORTNAME."_pagetitle_overlay_opacity")))/100;
				$pt_overlay_color = "rgba(".$pt_overlay_the_color[0].",".$pt_overlay_the_color[1].",".$pt_overlay_the_color[2].",".$pt_overlay_opacity.")";
				$breadcrumbs = get_option(DESIGNARE_SHORTNAME."_breadcrumbs");
				$breadcrumbs_margintop = get_option('yunik_breadcrumbs_text_margin_top');
				$pagetitlepadding = get_option('yunik_page_title_padding');
			} else {
				$type = get_post_meta($this_page_id, "yunik_header_type_value", true);
				$thecolor = des_hex2rgb(get_post_meta($this_page_id, "yunik_header_color_value", true)); 
				$opacity = intval(str_replace("%","",get_post_meta($this_page_id, "yunik_header_color_opacity_value", true)))/100;
				$color = "rgba(".$thecolor[0].",".$thecolor[1].",".$thecolor[2].",".$opacity.")";
				$image = get_post_meta($this_page_id, "yunik_header_image_value", true);
				$image = explode('|!|',$image);
				if (isset($image[1])) $image = explode('|*|',$image[1]);
				$image = $image[0];
				$pattern = DESIGNARE_PATTERNS_URL.get_post_meta($this_page_id, "yunik_header_pattern_value", true).".jpg";
				$custompattern = get_option(DESIGNARE_SHORTNAME."yunik_header_custom_pattern_value"); 
				//$height = get_post_meta($this_page_id, "yunik_header_height_value", true);
				$margintop = get_post_meta($this_page_id, "yunik_header_text_margin_top_value", true);
				$banner = get_post_meta($this_page_id, "yunik_banner_slider_value", true);
				$showtitle = get_post_meta($this_page_id, "yunik_hide_pagetitle_value", true) == "yes" ? true : false;
				$showsectitle = get_post_meta($this_page_id, "yunik_hide_sec_pagetitle_value", true) == "yes" ? true : false;
				$tcolor = get_post_meta($this_page_id, "yunik_header_text_color_value", true);
				$tsize = intval(str_replace(" ", "", get_post_meta($this_page_id, "yunik_header_text_size_value", true)),10)."px";
				$tfont = get_post_meta($this_page_id, "yunik_header_text_font_value", true);
				$stcolor = get_post_meta($this_page_id, "yunik_secondary_title_text_color_value", true);
				$stsize = intval(str_replace(" ", "", get_post_meta($this_page_id, "yunik_secondary_title_text_size_value", true)),10)."px";
				$stfont = get_post_meta($this_page_id, "yunik_secondary_title_font_value", true);
				$stmargin = intval(str_replace(" ", "", get_post_meta($this_page_id, "yunik_header_secondary_text_margin_top_value", true)),10)."px";
				$originalalign = get_post_meta($this_page_id, "yunik_header_text_alignment_value", true);
				$pt_parallax = get_post_meta($this_page_id, DESIGNARE_SHORTNAME."_pagetitle_image_parallax_value", true) == "on" ? true : false;
				$pt_overlay = get_post_meta($this_page_id, DESIGNARE_SHORTNAME."_pagetitle_image_overlay_value", true) == "on" ? true : false;
				$pt_overlay_type = get_post_meta($this_page_id, DESIGNARE_SHORTNAME."_pagetitle_overlay_type_value", true);
				$pt_overlay_the_color = des_hex2rgb(get_post_meta($this_page_id, DESIGNARE_SHORTNAME."_pagetitle_overlay_color_value", true));
				$pt_overlay_pattern = DESIGNARE_PATTERNS_URL.get_post_meta($this_page_id, DESIGNARE_SHORTNAME."_pagetitle_overlay_pattern_value", true);
				$pt_overlay_opacity = intval(str_replace("%","",get_post_meta($this_page_id, DESIGNARE_SHORTNAME."_pagetitle_overlay_opacity_value", true)))/100;
				$pt_overlay_color = "rgba(".$pt_overlay_the_color[0].",".$pt_overlay_the_color[1].",".$pt_overlay_the_color[2].",".$pt_overlay_opacity.")";
				$breadcrumbs = get_post_meta($this_page_id, "yunik_enable_breadcrumbs_value", true) == "yes" ? "on" : "off";
				$breadcrumbs_margintop = intval(str_replace(" ", "", get_post_meta($this_page_id, "yunik_breadcrumbs_margin_top_value", true)),10)."px";
				$pagetitlepadding = intval(str_replace(" ", "", get_post_meta($this_page_id, "yunik_page_title_padding_value", true)),10)."px";
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
									<h1 class="page_title" style="<?php echo "color: #$tcolor; font-size: $tsize; font-family: '{$principalfont[0]}';font-weight: {$principalfont[1]};";?><?php if ($margintop != "") echo "margin-top: ".intval($margintop,10)."px;"; ?>">
										<?php echo get_the_title($this_page_id); ?>
									</h1>
									<?php
								}
				    			if ($showsectitle){
					    			if (get_post_meta($this_page_id, 'secondaryTitle_value', true) != ""){
								    	?>
									    <h2 class="secondaryTitle" style="<?php echo "color: #$stcolor; font-size: $stsize; line-height: $stsize; font-family: '{$secondaryfont[0]}';font-weight:{$secondaryfont[1]}; margin-top:{$stmargin};";?>">
									    	<?php echo get_post_meta($this_page_id, 'secondaryTitle_value', true); ?>
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
			
			
			?>
			<div class="master_container" style="width: 100%;float: left;background-color: white;">
				<section class="page_content" id="section-<?php echo $this_page_id; ?>">
					<div class="container">
					<?php
						if (vc_is_inline()){
							wp_reset_query();
							global $thequery, $post;
							the_content();
						} else {
							$thepost = get_post($this_page_id);
							$content = wpb_js_remove_wpautop($thepost->post_content, true);
							if(stripos($thepost->post_content, 'font_call:')){
								preg_match_all('/font_call:(.*?)"/',$thepost->post_content, $display);
								enquque_ultimate_google_fonts_optimzed($display[1]);
							}
							echo do_shortcode($thepost->post_content);
							/* check the content for ultimate addons shortcodes */
							des_content_shortcoder($thepost->post_content);
							/* custom element css */
							$shortcodes_custom_css = get_post_meta( $this_page_id, '_wpb_shortcodes_custom_css', true );
							if ( ! empty( $shortcodes_custom_css ) ) {
								echo '<style type="text/css" data-type="vc_shortcodes-custom-css">';
								echo $shortcodes_custom_css;
								echo '</style>';
							}
						}
					?>
					</div>
				</section>
			</div>
			<?php

		}	
?>

<div class="clear"></div>
	
	
<?php get_footer();