<?php
/**
 * @package WordPress
 * @subpackage Yunik
 */
?>
	
	<div id="big_footer">
	<?php
		
		if (get_option(DESIGNARE_SHORTNAME."_newsletter_enabled") == "on"){
			$code = str_replace('&', '&amp;', get_option(DESIGNARE_SHORTNAME."_mailchimp_code"));
			if (!empty($code)){
			    $output = '<div class="newsletter_shortcode footer_newsletter"><div class="mail-box"><div class="mail-news"><div class="news-l"><div class="banner"><h3>'.get_option(DESIGNARE_SHORTNAME."_newsletter_text").'</h3><p>'.get_option(DESIGNARE_SHORTNAME."_newsletter_stext").'</p></div><div class="form">';
				$output .= stripslashes($code);
				$output .= '</div></div></div></div></div>';			
			} else {
				$output = '<div class="newsletter_shortcode">'.__('You need to fill the inputs on the <strong>Appearance > Yunik Options > Newsletter</strong> panel in order to work.','yunik').'</div>';
			}
		    echo $output;
		}
		
		if (get_option(DESIGNARE_SHORTNAME."_show_primary_footer") == "on"){
			?>
			<div id="primary_footer">
		    	<div class="container">
	    		<?php
	    		
					if(get_option(DESIGNARE_SHORTNAME . "_footer_number_cols") == "one"){ ?>
						<div class="footer_sidebar col-xs-12 col-md-12"><?php print_sidebar('footer-one-column'); ?></div>
					<?php }
					if(get_option(DESIGNARE_SHORTNAME . "_footer_number_cols") == "two"){ ?>
						<div class="footer_sidebar col-xs-12 col-md-6"><?php print_sidebar('footer-two-column-left'); ?></div>
						<div class="footer_sidebar col-xs-12 col-md-6"><?php print_sidebar('footer-two-column-right'); ?></div>
					<?php }
					if(get_option(DESIGNARE_SHORTNAME . "_footer_number_cols") == "three"){
						if(get_option(DESIGNARE_SHORTNAME . "_footer_columns_order") == "one_three"){ ?>
							<div class="footer_sidebar col-xs-12 col-md-4"><?php print_sidebar('footer-three-column-left'); ?></div>
							<div class="footer_sidebar col-xs-12 col-md-4"><?php print_sidebar('footer-three-column-center'); ?></div>
							<div class="footer_sidebar col-xs-12 col-md-4"><?php print_sidebar('footer-three-column-right'); ?></div>
						<?php }
						if(get_option(DESIGNARE_SHORTNAME . "_footer_columns_order") == "one_two_three"){ ?>
							<div class="footer_sidebar col-xs-12 col-md-4"><?php print_sidebar('footer-three-column-left-1_3'); ?></div>
							<div class="footer_sidebar col-xs-12 col-md-8"><?php print_sidebar('footer-three-column-right-2_3'); ?></div>
						<?php }
						if(get_option(DESIGNARE_SHORTNAME . "_footer_columns_order") == "two_one_three"){ ?>
							<div class="footer_sidebar col-xs-12 col-md-8"><?php print_sidebar('footer-three-column-left-2_3'); ?></div>
							<div class="footer_sidebar col-xs-12 col-md-4"><?php print_sidebar('footer-three-column-right-1_3'); ?></div>
						<?php }
					}
					if(get_option(DESIGNARE_SHORTNAME . "_footer_number_cols") == "four"){
						if(get_option(DESIGNARE_SHORTNAME . "_footer_columns_order_four") == "one_four"){ ?>
							<div class="footer_sidebar col-xs-12 col-md-3"><?php print_sidebar('footer-four-column-left'); ?></div>
							<div class="footer_sidebar col-xs-12 col-md-3"><?php print_sidebar('footer-four-column-center-left'); ?></div>
							<div class="footer_sidebar col-xs-12 col-md-3"><?php print_sidebar('footer-four-column-center-right'); ?></div>
							<div class="footer_sidebar col-xs-12 col-md-3"><?php print_sidebar('footer-four-column-right'); ?></div>
						<?php }
						if(get_option(DESIGNARE_SHORTNAME . "_footer_columns_order_four") == "two_one_two_four"){ ?>
							<div class="footer_sidebar col-xs-12 col-md-3"><?php print_sidebar('footer-four-column-left-1_2_4'); ?></div>
							<div class="footer_sidebar col-xs-12 col-md-6"><?php print_sidebar('footer-four-column-center-2_2_4'); ?></div>
							<div class="footer_sidebar col-xs-12 col-md-3"><?php print_sidebar('footer-four-column-right-1_2_4'); ?></div>
						<?php }
						if(get_option(DESIGNARE_SHORTNAME . "_footer_columns_order_four") == "three_one_four"){ ?>
							<div class="footer_sidebar col-xs-12 col-md-8"><?php print_sidebar('footer-four-column-left-3_4'); ?></div>
							<div class="footer_sidebar col-xs-12 col-md-4"><?php print_sidebar('footer-four-column-right-1_4'); ?></div>
						<?php }
						if(get_option(DESIGNARE_SHORTNAME . "_footer_columns_order_four") == "one_three_four"){ ?>
							<div class="footer_sidebar col-xs-12 col-md-4"><?php print_sidebar('footer-four-column-left-1_4'); ?></div>
							<div class="footer_sidebar col-xs-12 col-md-8"><?php print_sidebar('footer-four-column-right-3_4'); ?></div>
						<?php }
					}
				?>
				</div>
		    </div>
			<?php
		}
	?>
    
    <?php
	    if (get_option(DESIGNARE_SHORTNAME."_show_sec_footer") == "on"){
		    ?>
		    <div id="secondary_footer">
				<div class="container">
					
					<?php
						/* FOOTER LOGOTYPE */
						if (get_option(DESIGNARE_SHORTNAME."_footer_display_logo") == 'on'){
						?>
						<a class="footer_logo align-<?php echo get_option(DESIGNARE_SHORTNAME."_footer_logo_alignment"); ?>" href="<?php echo home_url(); ?>" tabindex="-1">
				        	<?php 
			    			if (get_option(DESIGNARE_SHORTNAME."_footer_logo_type") == "text"){
			    			?>
		    					<h1 class="logo">
									<?php echo get_option(DESIGNARE_SHORTNAME."_footer_logo_text"); ?>
								</h1>
			    			<?php
			    			} else {		    			
				    			$alone = true;
			    				if (get_option(DESIGNARE_SHORTNAME."_footer_logo_retina_image_url") != ""){
				    				$alone = false;
			    				}
		    					?>
		    					<img class="footer_logo_normal <?php if (!$alone) echo "notalone"; ?>" style="position: relative;" src="<?php echo get_option(DESIGNARE_SHORTNAME."_footer_logo_image_url"); ?>" alt="<?php _e("", "yunik"); ?>" title="<?php _e("", "yunik"); ?>">
			    					
			    				<?php 
			    				if (get_option(DESIGNARE_SHORTNAME."_footer_logo_retina_image_url") != ""){
			    				?>
				    				<img class="footer_logo_retina" style="display:none; position: relative;" src="<?php echo get_option(DESIGNARE_SHORTNAME."_footer_logo_retina_image_url"); ?>" alt="<?php _e("", "yunik"); ?>" title="<?php _e("", "yunik"); ?>">
			    				<?php
		    					}
			    			}
			    		?>
				        </a>
						<?php
						}
						
						/* FOOTER SOCIAL ICONS */
						if (get_option(DESIGNARE_SHORTNAME."_footer_display_social_icons") == "on"){
						?>
						<div class="social-icons-fa align-<?php echo get_option(DESIGNARE_SHORTNAME."_footer_social_icons_alignment"); ?>">
					        <ul>
							<?php
								$icons = array(array("facebook","Facebook"),array("twitter","Twitter"),array("tumblr","Tumblr"),array("stumbleupon","Stumble Upon"),array("flickr","Flickr"),array("linkedin","LinkedIn"),array("delicious","Delicious"),array("skype","Skype"),array("digg","Digg"),array("google-plus","Google+"),array("vimeo-square","Vimeo"),array("deviantart","DeviantArt"),array("behance","Behance"),array("instagram","Instagram"),array("wordpress","Wordpress"),array("youtube","Youtube"),array("reddit","Reddit"),array("rss","RSS"),array("soundcloud","SoundCloud"),array("pinterest","Pinterest"),array("dribbble","Dribbble"));
								foreach ($icons as $i){
									if (is_string(get_option(DESIGNARE_SHORTNAME."_icon-".$i[0])) && get_option(DESIGNARE_SHORTNAME."_icon-".$i[0]) != ""){
									?>
									<li>
										<a href="<?php echo get_option(DESIGNARE_SHORTNAME."_icon-".$i[0]); ?>" target="_blank" class="<?php echo strtolower($i[0]); ?>" title="<?php echo $i[1]; ?>"><i class="fa fa-<?php echo strtolower($i[0]); ?>"></i></a>
									</li>
									<?php
									}
								}
							?>
						    </ul>
						</div>
						<?php
						}
						
						/* FOOTER CUSTOM TEXT */
						if (get_option(DESIGNARE_SHORTNAME."_footer_display_custom_text") == "on"){
						?>
						<div class="footer_custom_text <?php echo get_option(DESIGNARE_SHORTNAME."_footer_custom_text_alignment"); ?>"><?php echo do_shortcode(stripslashes(get_option(DESIGNARE_SHORTNAME."_footer_custom_text"))); ?></div>
						<?php
						}
					?>
				</div>
			</div>
		    <?php
	    }
    ?>

<!-- Don't forget analytics -->
<?php if( get_option(DESIGNARE_SHORTNAME."_enable_theme_seo") == "on" && get_option(DESIGNARE_SHORTNAME."_seo_analytics")) echo stripslashes(get_option(DESIGNARE_SHORTNAME."_seo_analytics")); ?>

<?php

/* sets the type of pagination [scroll, autoscroll, paged, default] */
wp_reset_query();
global $yunik_reading_option; $yunik_reading_option = get_option('yunik_blog_reading_type');
if (is_archive() || is_single() || is_search() || is_page_template('blog-template.php') || is_page_template('blog-masonry-template.php')) {
	
	$nposts = get_option('posts_per_page');
	
	
	global $yunik_more;
	global $yunik_pag;
		$yunik_more = 0;
		$yunik_pag = 0;

	$orderby="";
	$category="";
	$nposts = "";
	
	if (isset($_GET['paged'])) $yunik_pag = $_GET['paged'];
	else {
		$pageURL = 'http';
		if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
		$pageURL .= "://";
		if ($_SERVER["SERVER_PORT"] != "80") {
			$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
		} else {
			$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		}
		$yunik_pagina = explode('/page/', $pageURL);
		if(isset($yunik_pagina[1])) $yunik_pagina = explode ('/', $yunik_pagina[1]);
		if ($yunik_pagina[0]) $yunik_pag = $yunik_pagina[0];	
	}
	if (!is_numeric($yunik_pag)) $yunik_pag = 1;
	$max = 0;
	
	switch ($yunik_reading_option){
		case "scrollauto": 
				
				global $wp_query;
				
				// Add code to index pages.
				if( !is_singular() ) {	
					
					if (is_search()){
					
						wp_reset_query();
						
						$yunik_reading_option = get_option('yunik_blog_reading_type');
						$se = get_option(DESIGNARE_SHORTNAME."_enable_search_everything");
	
						$nposts = get_option('posts_per_page');
						
						if (isset($_GET['paged'])) $yunik_pag = $_GET['paged'];
						else {
							$pageURL = 'http';
							if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
							$pageURL .= "://";
							if ($_SERVER["SERVER_PORT"] != "80") {
								$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
							} else {
								$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
							}
							$yunik_pagina = explode('/page/', $pageURL);
							if(isset($yunik_pagina[1])) $yunik_pagina = explode ('/', $yunik_pagina[1]);
							if ($yunik_pagina[0]) $yunik_pag = $yunik_pagina[0];	
						}
						if (!is_numeric($yunik_pag)) $yunik_pag = 1;
									
						if ($se == "on"){
							$args = array(
								'showposts' => get_option('posts_per_page'),
								'post_status' => 'publish',
								'paged' => $yunik_pag,
								's' => esc_html($_GET['s'])
							);
						    
						    $the_query = new WP_Query( $args );
						    
						    $args2 = array(
								'showposts' => -1,
								'post_status' => 'publish',
								'paged' => $yunik_pag,
								's' => esc_html($_GET['s'])
							);
							
							$counter = new WP_Query($args2);
							
						} else {
							$args = array(
								'showposts' => get_option('posts_per_page'),
								'post_status' => 'publish',
								'paged' => $yunik_pag,
								'post_type' => 'post',
								's' => esc_html($_GET['s'])
							);
						    
						    $the_query = new WP_Query( $args );
						    
						    $args2 = array(
								'showposts' => -1,
								'post_status' => 'publish',
								'paged' => $yunik_pag,
								'post_type' => 'post',
								's' => esc_html($_GET['s'])
							);
							
							$counter = new WP_Query($args2);
						}

						$max = ceil($counter->post_count / $nposts);
						$yunik_paged = ( get_query_var('paged') > 1 ) ? get_query_var('paged') : 1;
											
					} else {
	
						// What page are we on? And what is the pages limit?
						$max = $wp_query->max_num_pages;
						$yunik_paged = ( get_query_var('paged') > 1 ) ? get_query_var('paged') : 1;
						
					}
					
					?> 
							
					<script type="text/javascript">
					
						jQuery(document).ready(function($){
					
							if ($('#reading_option').html() === "scrollauto" && !jQuery('body').hasClass('single')){ 
								window.loadingPoint = 0;
								//monitor page scroll to fire up more posts loader
								window.clearInterval(window.interval);
								window.interval = setInterval('monitorScrollTop()', 1000 );
							}	
						
						});
					
					</script>
					
					<?php
					
					
				} else {
					
				    $args = array(
	    				'showposts' => $nposts,
	    				'orderby' => $orderby,
	    				'order' => $order,
	    				'cat' => $category,
	    				'paged' => $yunik_pag,
	    				'post_status' => 'publish'
	    			);
	    				
	    			//global $post, $wp_query;
	    		    
	    		    $the_query = new WP_Query( $args );
	
		    		$max = $the_query->max_num_pages;
		    		$yunik_paged = ( get_query_var('paged') > 1 ) ? get_query_var('paged') : 1;
		    		
		    		?> 
		    		
		    			<script type="text/javascript">
					
							jQuery(document).ready(function($){
						
								if ($('#reading_option').html() === "scrollauto" && !jQuery('body').hasClass('single')){ 
									window.loadingPoint = 0;
									//monitor page scroll to fire up more posts loader
									window.clearInterval(window.interval);
									window.interval = setInterval('monitorScrollTop()', 1000 );
								}	
							
							});
						
						</script>
		    		<?php
	    				
	    		}
			break;
		case "scroll": 

				global $wp_query;
				
				// Add code to index pages.
				if( !is_singular() ) {	
				
					if (is_search()){
						wp_reset_query();
						
						$nposts = get_option('posts_per_page');
					
						$se = get_option(DESIGNARE_SHORTNAME."_enable_search_everything");

						if ($se == "on"){
							$args = array(
								'showposts' => get_option('posts_per_page'),
								'post_status' => 'publish',
								'paged' => $yunik_pag,
								's' => esc_html($_GET['s'])
							);
						    
						    $the_query = new WP_Query( $args );
						    
						    $args2 = array(
								'showposts' => -1,
								'post_status' => 'publish',
								'paged' => $yunik_pag,
								's' => esc_html($_GET['s'])
							);
							
							$counter = new WP_Query($args2);
							
						} else {
							$args = array(
								'showposts' => get_option('posts_per_page'),
								'post_status' => 'publish',
								'paged' => $yunik_pag,
								'post_type' => 'post',
								's' => esc_html($_GET['s'])
							);
						    
						    $the_query = new WP_Query( $args );
						    
						    $args2 = array(
								'showposts' => -1,
								'post_status' => 'publish',
								'paged' => $yunik_pag,
								'post_type' => 'post',
								's' => esc_html($_GET['s'])
							);
							
							$counter = new WP_Query($args2);
						}
					    
						$max = ceil($counter->post_count / $nposts);
						$yunik_pag = 1;

						if (isset($_GET['paged'])) $yunik_pag = $_GET['paged'];
						else {
							$pageURL = 'http';
							if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
							$pageURL .= "://";
							if ($_SERVER["SERVER_PORT"] != "80") {
								$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
							} else {
								$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
							}
							$yunik_pagina = explode('/page/', $pageURL);
							if(isset($yunik_pagina[1])) $yunik_pagina = explode ('/', $yunik_pagina[1]);
							if ($yunik_pagina[0]) $yunik_pag = $yunik_pagina[0];	
						}
						if (!is_numeric($yunik_pag)) $yunik_pag = 1;
					
					} else {
						// What page are we on? And what is the pages limit?
						$max = $wp_query->max_num_pages;
						$yunik_paged = $yunik_pag;
											
					}
					
					
				} else {
				 			
					$orderby = "";
					$category = "";

				    $args = array(
	    				'showposts' => $nposts,
	    				'orderby' => $orderby,
	    				'order' => $order,
	    				'cat' => $category,
	    				'post_status' => 'publish'
	    			);
	    		    
	    		    $the_query = new WP_Query( $args );
	    		    	    		
	
		    		$max = $the_query->max_num_pages;
		    		$yunik_pag = 1;

					if (isset($_GET['paged'])) $yunik_pag = $_GET['paged'];
					else {
						$pageURL = 'http';
						if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
						$pageURL .= "://";
						if ($_SERVER["SERVER_PORT"] != "80") {
							$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
						} else {
							$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
						}
						$yunik_pagina = explode('/page/', $pageURL);
						if(isset($yunik_pagina[1])) $yunik_pagina = explode ('/', $yunik_pagina[1]);
						if ($yunik_pagina[0]) $yunik_pag = $yunik_pagina[0];	
					}
					if (!is_numeric($yunik_pag)) $yunik_pag = 1;		    			    				
	    		}
										
			break;
	}
	?>
	<div class="yunik_helper_div" id="loader-startPage"><?php echo $yunik_pag; ?></div>
	<div class="yunik_helper_div" id="loader-maxPages"><?php echo $max; ?></div>
	<div class="yunik_helper_div" id="loader-nextLink"><?php echo next_posts($max, false); ?></div>
	<?php
}
?>

</div> <!-- end of everything -->


<?php 
	global $yunik_pag;
	if ($yunik_pag > 1) {
	?>
	<div class="yunik_helper_div" id="loader-prevLink"><?php
		if (isset($_GET['paged'])) {
			$pageURL = 'http';
			if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
			$pageURL .= "://";
			if ($_SERVER["SERVER_PORT"] != "80") {
				$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
			} else {
				$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
			}
			$aux = explode("paged=",$pageURL);
			$output = $aux[0]."paged=";
			$output .= (int)$yunik_pag-1;
			echo $output;
		}
		else {
			$pageURL = 'http';
			if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
			$pageURL .= "://";
			if ($_SERVER["SERVER_PORT"] != "80") {
				$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
			} else {
				$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
			}
			$aux = explode('/page/', $pageURL);
			$output = $aux[0]."/page/";
			$output .= (int)$yunik_pag-1;
			$output .= "/";
			echo $output;	
		}
	?></div>
	<?php
}
global $yunik_custom;
global $yunik_styleColor;
$yunik_custom = get_post_meta(get_the_ID(), 'des_custom_page_style_value', true);

if ($yunik_custom == "on"){
	$bodyLayoutType = get_post_meta($post->ID, 'bodyLayoutType_value', true);
	$headerType = get_post_meta($post->ID, 'headerType_value', true);
} else {
	$bodyLayoutType = get_option(DESIGNARE_SHORTNAME."_body_layout_type");
	$headerType = get_option(DESIGNARE_SHORTNAME."_header_type");
} ?>
<div id="bodyLayoutType" class="yunik_helper_div"><?php echo $bodyLayoutType; ?></div>
<div id="headerType" class="yunik_helper_div"><?php echo $headerType; ?></div>
<?php 
	if ($yunik_custom == "on"){
		if (get_post_meta($post->ID, 'bodyShadow_value', true) == "on"){
			?>
				<div id="bodyShadowColor" class="yunik_helper_div"><?php echo "#".get_post_meta($post->ID, 'bodyShadowColor_value', true); ?></div>
			<?php
		}
		$headerStyleType = get_post_meta($post->ID, 'headerStyleType_value', true);
	} else {
		if (get_option(DESIGNARE_SHORTNAME."_body_shadow") == "on"){
			?>
				<div id="bodyShadowColor" class="yunik_helper_div"><?php echo "#".get_option(DESIGNARE_SHORTNAME."_body_shadow_color"); ?></div>
			<?php
		}
		$headerStyleType = get_option(DESIGNARE_SHORTNAME."_header_style_type");
	}
	
?>
<div id="templatepath" class="yunik_helper_div"><?php  echo get_template_directory_uri()."/"; ?></div>
<div id="homeURL" class="yunik_helper_div"><?php echo home_url(); ?>/</div>
<div id="styleColor" class="yunik_helper_div"><?php global $yunik_styleColor; echo $yunik_styleColor;?></div>	
<div id="headerStyleType" class="yunik_helper_div"><?php echo $headerStyleType; ?></div>
<div class="yunik_helper_div" id="reading_option"><?php 
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
<div class="yunik_helper_div" id="yunik_content_to_the_top"><?php echo get_option('yunik_content_to_the_top'); ?></div>
<div class="yunik_helper_div" id="yunik_update_section_titles"><?php echo get_option('yunik_update_section_titles'); ?></div>
<?php 
	global $des_import_fonts; 

	$standardfonts = array('Arial','Arial Black','Helvetica','Helvetica Neue','Courier New','Georgia','Impact','Lucida Sans Unicode','Times New Roman', 'Trebuchet MS','Verdana','');
	$importfonts = "";
	foreach ($des_import_fonts as $font){
		if (!in_array($font,$standardfonts)){
			$font = str_replace(" ","+",str_replace("|",":",$font));
			if ($importfonts=="") $importfonts .= $font;
			else {
				if (strpos($importfonts, $font) === false)
					$importfonts .= "|{$font}";
			}
		}
	}
	if ($importfonts!=""){
		?>
		<link id="des-google-fonts-css" rel="stylesheet" type="text/css" media="all" href="//fonts.googleapis.com/css?family=<?php echo $importfonts; ?>">
		<?php
	}
?>
<style>
	/* neat trick. each social icon in the header is 20px wide, so just do the maths. */
	header .header_social_icons, header .header_social_icons_wrapper{min-width:<?php global $howmany_header_social_icons; echo $howmany_header_social_icons*25; ?>px;}
</style>

<?php
	if (get_option(DESIGNARE_SHORTNAME."_enable_gotop") == "on"){
		?>
		<p id="back-top" style="display: none;"><a href="#home"><i class="fa fa-angle-up"></i></a></p>
		<?php
	}

?>


<?php wp_footer(); ?>

<?php
	if (get_option(DESIGNARE_SHORTNAME."_body_type") == "body_boxed"){
		?>
		</div>
		<?php
	}
?>
</body>
</html>