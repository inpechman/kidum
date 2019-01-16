<?php
/**
 * Template Name: Multi Page Template
 * @package WordPress
 * @subpackage Yunik
**/
get_header(); des_yunik_print_menu();


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
							<h1 class="page_title" style="<?php echo "color: #$tcolor; font-size: $tsize; font-family: '{$principalfont[0]}';font-weight: {$principalfont[1]};";?><?php if ($margintop != "") echo "margin-top: ".intval($margintop,10)."px;"; ?>">
								<?php echo get_the_title($yunik_thisPostID); ?>
							</h1>
							<?php
						}
		    			if ($showsectitle){
			    			if (get_post_meta($post->ID, 'secondaryTitle_value', true) != ""){
						    	?>
							    <h2 class="secondaryTitle" style="<?php echo "color: #$stcolor; font-size: $stsize; line-height: $stsize; font-family: '{$secondaryfont[0]}';font-weight:{$secondaryfont[1]}; margin-top:{$stmargin};";?>">
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
				</div>
		<?php }
		?>
		</div>	
		<?php
	}
	
	$sidebar = get_post_meta($post->ID, 'sidebars_available_value', true);
	switch (get_post_meta($post->ID, 'sidebar_for_default_value', true)){
		case "none":
			?>
			<div class="master_container" style="width: 100%;float: left;background-color: white;">
				<section class="page_content" id="section-<?php echo get_the_ID(); ?>">
					<div class="container">
					<?php 
						wp_reset_query();
						$content = get_the_content($post->ID);
						des_content_shortcoder($content);
						$content = apply_filters('the_content', $content); 
						echo $content;
						
						$shortcodes_custom_css = get_post_meta( $post->ID, '_wpb_shortcodes_custom_css', true );
						if ( isset($shortcodes_custom_css) && ! empty( $shortcodes_custom_css ) ) {
							echo '<style type="text/css" data-type="vc_shortcodes-custom-css">';
							echo $shortcodes_custom_css;
							echo '</style>';
						}
					?>
					<?php
						if (comments_open()){
							?>
							<div class="the_comments">
							    <?php comments_template( '', true ); ?>
						    </div>
							<?php
						}
					?>
					</div>
				</section>
			</div>
			<?php
		break;
		case "left":
			?>
			<div class="master_container" style="width: 100%;float: left;background-color: white;">
				<div class="container">
					<section class="page_content left sidebar col-xs-12 col-md-3">
						<?php 
						if ( function_exists('dynamic_sidebar')) { 
							if ($sidebar == 'defaultblogsidebar'){
								get_sidebar();
							} else {
								ob_start();
							    do_shortcode(dynamic_sidebar($sidebar));
							    $html = ob_get_contents();
							    ob_end_clean();
							    echo $html;								
							}
						} else {
							get_sidebar();
						}
						?>
					</section>
					<section class="page_content right col-xs-12 col-md-9" id="section-<?php echo get_the_ID(); ?>">
						<?php 
							wp_reset_query();
							$content = get_the_content($post->ID);
							des_content_shortcoder($content);
							$content = apply_filters('the_content', $content); 
							echo $content;
							
							$shortcodes_custom_css = get_post_meta( $post->ID, '_wpb_shortcodes_custom_css', true );
							if ( isset($shortcodes_custom_css) && ! empty( $shortcodes_custom_css ) ) {
								echo '<style type="text/css" data-type="vc_shortcodes-custom-css">';
								echo $shortcodes_custom_css;
								echo '</style>';
							}
						?>
						<?php
							if (comments_open()){
								?>
								<div class="the_comments">
								    <?php comments_template( '', true ); ?>
							    </div>
								<?php
							}
						?>
					</section>
				</div>
			</div>
			<?php
		break;
		case "right":
			?>
			<div class="master_container" style="width: 100%;float: left;background-color: white;">
				<div class="container">
					<section class="page_content left col-xs-12 col-md-9" id="section-<?php echo get_the_ID(); ?>">
						<?php 
							wp_reset_query();
							$content = get_the_content($post->ID);
							des_content_shortcoder($content);
							$content = apply_filters('the_content', $content); 
							echo $content;
							
							$shortcodes_custom_css = get_post_meta( $post->ID, '_wpb_shortcodes_custom_css', true );
							if ( isset($shortcodes_custom_css) && ! empty( $shortcodes_custom_css ) ) {
								echo '<style type="text/css" data-type="vc_shortcodes-custom-css">';
								echo $shortcodes_custom_css;
								echo '</style>';
							}
						?>
						<?php
							if (comments_open()){
								?>
								<div class="the_comments">
								    <?php comments_template( '', true ); ?>
							    </div>
								<?php
							}
						?>
					</section>
					<section class="page_content right sidebar col-xs-12 col-md-3">
						<?php 
						if ( function_exists('dynamic_sidebar')) { 
							if ($sidebar == 'defaultblogsidebar'){
								get_sidebar();
							} else {
								ob_start();
							    do_shortcode(dynamic_sidebar($sidebar));
							    $html = ob_get_contents();
							    ob_end_clean();
							    echo $html;								
							}
						} else {
							get_sidebar();
						}
						?>
					</section>
				</div>
			</div>
			<?php
		break;
		default:
			?>
			<div class="master_container" style="width: 100%;float: left;background-color: white;">
				<section class="page_content" id="section-<?php echo get_the_ID(); ?>" style="margin: 50px 0px;">
					<div class="container">
					<?php 
						wp_reset_query();
						$content = get_the_content($post->ID);
						des_content_shortcoder($content);
						$content = apply_filters('the_content', $content); 
						echo $content;
						
						$shortcodes_custom_css = get_post_meta( $post->ID, '_wpb_shortcodes_custom_css', true );
						if ( isset($shortcodes_custom_css) && ! empty( $shortcodes_custom_css ) ) {
							echo '<style type="text/css" data-type="vc_shortcodes-custom-css">';
							echo $shortcodes_custom_css;
							echo '</style>';
						}
					?>
					<?php
						if (comments_open()){
							?>
							<div class="the_comments">
							    <?php comments_template( '', true ); ?>
						    </div>
							<?php
						}
					?>
					</div>
				</section>
			</div>
			<?php
		break;
	}
	?>
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
		} else {
			?>
			.fullwidth-container .pageTitle, .des_breadcrumbs{max-width: 100%;width:100%;}
			<?php
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

<?php get_footer(); ?>