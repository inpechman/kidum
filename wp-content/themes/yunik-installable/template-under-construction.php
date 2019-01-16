<?php
/*
Template Name: Under Construction Template
*/
get_header(); //the_post();
$theid = (isset($des_uc_id)) ? $des_uc_id : get_the_ID();
global $the_query, $post;
$post = get_post($theid);
if (class_exists('Ultimate_VC_Addons')) {
	wp_enqueue_script('ultimate', plugins_url().'/Ultimate_VC_Addons/assets/min-js/ultimate.min.js', array('jquery'),'1');
	wp_enqueue_style('ultimate', plugins_url().'/Ultimate_VC_Addons/assets/min-css/ultimate.min.css');
	wp_enqueue_script('ultimate-script');
	wp_enqueue_script('ultimate-vc-params');
	
	if(stripos($post->post_content, 'font_call:')){
		preg_match_all('/font_call:(.*?)"/',$post->post_content, $display);
		enquque_ultimate_google_fonts_optimzed($display[1]);
	}
}
?>
<body class="page-template page-template-template-under-construction page-template-template-under-construction-php <?php echo "the-id-is-$theid"; ?>">
	<div class="fullwindow_rev">
		<?php
		$daslider = get_post_meta($theid, 'underconstruction_rev_value', true);
		if ($daslider){
			if (substr($daslider, 0, 10) === "revSlider_"){
				if (!function_exists('putRevSlider')){
					echo 'Please install the missing plugin - Revolution Slider.';
				} else {
					putRevSlider(substr($daslider, 10));
				}
			}
		} else {
			echo "You need to create and a Revolution Slider instance and then choose it in this Page Options.";
		}
		?>
	</div>
	<div class="fullwindow_content container">
		<div class="tb-row">
			<div class="tb-cell">
				<?php 
					echo do_shortcode($post->post_content);
					/* custom element css */
					$shortcodes_custom_css = get_post_meta( $theid, '_wpb_shortcodes_custom_css', true );
					if ( ! empty( $shortcodes_custom_css ) ) {
						echo '<style type="text/css" data-type="vc_shortcodes-custom-css">';
						echo $shortcodes_custom_css;
						echo '</style>';
					}
				?>
			</div>
		</div>
	</div>
	<?php wp_footer(); ?>
<div id="templatepath" class="yunik_helper_div"><?php  echo get_template_directory_uri()."/"; ?></div>
<div id="homeURL" class="yunik_helper_div"><?php echo home_url(); ?>/</div>
<div id="styleColor" class="yunik_helper_div"><?php global $yunik_styleColor; echo $yunik_styleColor;?></div>	
<div id="headerStyleType" class="yunik_helper_div"><?php global $headerStyleType; echo $headerStyleType; ?></div>
<div class="yunik_helper_div" id="reading_option"><?php 
	global $yunik_reading_option;
	if ($yunik_reading_option == "scrollauto"){
		$detect = new Mobile_Detect();
		if ($detect->isMobile())
			$yunik_reading_option = "scroll";
	}
	echo $yunik_reading_option; 
?></div>
<div class="yunik_helper_div" id="yunik_no_more_posts_text"><?php echo __(get_option('yunik_no_more_posts_text'), "yunik"); ?></div>
<div class="yunik_helper_div" id="yunik_load_more_posts_text"><?php echo __(get_option('yunik_load_more_posts_text'), "yunik");  ?></div>
<div class="yunik_helper_div" id="yunik_loading_posts_text"><?php echo __(get_option('yunik_loading_posts_text'), "yunik");  ?></div>
<div class="yunik_helper_div" id="yunik_links_color_hover"><?php echo get_option('yunik_links_color_hover'); ?></div>
<div class="yunik_helper_div" id="yunik_enable_images_magnifier"><?php echo get_option('yunik_enable_images_magnifier'); ?></div>
<div class="yunik_helper_div" id="yunik_thumbnails_hover_option"><?php echo get_option('yunik_thumbnails_hover_option'); ?></div>
<div class="yunik_helper_div" id="yunik_menu_color">#<?php echo get_option(DESIGNARE_SHORTNAME."_menu_color"); ?></div>
<div class="yunik_helper_div" id="yunik_fixed_menu"><?php echo get_option(DESIGNARE_SHORTNAME."_fixed_menu"); ?></div>
<div class="yunik_helper_div" id="yunik_thumbnails_effect"><?php if (get_option(DESIGNARE_SHORTNAME."_animate_thumbnails") == "on") echo get_option(DESIGNARE_SHORTNAME."_thumbnails_effect"); else echo "none"; ?></div>
<div class="yunik_helper_div loadinger">
	<img alt="loading" src="<?php echo get_template_directory_uri(). '/img/ajx_loading.gif' ?>">
</div>
<div class="yunik_helper_div" id="permalink_structure"><?php echo get_option('permalink_structure'); ?></div>
<div class="yunik_helper_div" id="headerstyle3_menucolor">#<?php echo get_option(DESIGNARE_SHORTNAME."_menu_color"); ?></div>
<div class="yunik_helper_div" id="disable_responsive_layout"><?php echo get_option('yunik_disable_responsive'); ?></div>
<div class="yunik_helper_div" id="filters-dropdown-sort"><?php _e('Sort Gallery','yunik'); ?></div>
<div class="yunik_helper_div" id="templatepath"><?php echo get_template_directory_uri(); ?></div>
<div class="yunik_helper_div" id="searcheverything"><?php echo get_option(DESIGNARE_SHORTNAME."_enable_search_everything"); ?></div>
<div class="yunik_helper_div" id="yunik_header_shrink"><?php if (get_option('yunik_fixed_menu') == 'on'){if (get_option('yunik_header_after_scroll') == 'on'){if (get_option('yunik_header_shrink_effect') == 'on'){echo "yes";} else echo "no";}} ?></div>
<div class="yunik_helper_div" id="yunik_header_after_scroll"><?php if (get_option('yunik_fixed_menu') == 'on'){if (get_option('yunik_header_after_scroll') == 'on'){echo "yes";} else echo "no";} ?></div>
<div class="yunik_helper_div" id="yunik_grayscale_effect"><?php echo get_option(DESIGNARE_SHORTNAME."_enable_grayscale"); ?></div>
<div class="yunik_helper_div" id="yunik_enable_ajax_search"><?php echo get_option(DESIGNARE_SHORTNAME."_enable_ajax_search"); ?></div>
<div class="yunik_helper_div" id="yunik_menu_add_border"><?php echo get_option(DESIGNARE_SHORTNAME."_menu_add_border"); ?></div>
<div class="yunik_helper_div" id="yunik_newsletter_input_text"><?php echo get_option('yunik_newsletter_input_text'); ?></div>
</body>