<?php
/**
 * @package WordPress
 * @subpackage Yunik
**/

get_header(); des_yunik_print_menu(); 

	/* pagetitle options related. */
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
	$height = "auto";
	$sidebar_scheme = get_option('yunik_search_archive_sidebar');
	$sidebar = get_option('yunik_search_sidebars_available');
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

	/* endof pagetitle options stuff. */
	
	/* search code related. counters and stuff. */
	global $yunik_reading_option, $yunik_more, $the_query; 
	$yunik_reading_option = get_option('yunik_blog_reading_type');
	$yunik_more = 0;

	$orderby="";
	$category="";
	$nposts = "";

	$pag = 1;
	
	if (isset($_GET['paged'])) $pag = $_GET['paged'];
	else {
		$pageURL = 'http';
		if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
		$pageURL .= "://";
		if ($_SERVER["SERVER_PORT"] != "80") {
			$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
		} else {
			$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		}
		$pagina = explode('/page/', $pageURL);
		if(isset($pagina[1])) $pagina = explode ('/', $pagina[1]);
		if ($pagina[0]) $pag = $pagina[0];	
	}
	if (!is_numeric($pag)) $pag = 1;
 
	
	$se = get_option(DESIGNARE_SHORTNAME."_enable_search_everything");

	if ($se == "on"){
		$args = array(
			'showposts' => get_option('posts_per_page'),
			'post_status' => 'publish',
			'paged' => $pag,
			's' => esc_html($_GET['s'])
		);
	    
	    $the_query = new WP_Query( $args );
	    
	    $args2 = array(
			'showposts' => -1,
			'post_status' => 'publish',
			'paged' => $pag,
			's' => esc_html($_GET['s'])
		);
		
		$counter = new WP_Query($args2);
		
	} else {
		$args = array(
			'showposts' => get_option('posts_per_page'),
			'post_status' => 'publish',
			'paged' => $pag,
			'post_type' => 'post',
			's' => esc_html($_GET['s'])
		);
			
	    $the_query = new WP_Query( $args );
	    
	    $args2 = array(
			'showposts' => -1,
			'post_status' => 'publish',
			'paged' => $pag,
			'post_type' => 'post',
			's' => esc_html($_GET['s'])
		);
		
		$counter = new WP_Query($args2);
	}
	/* endof search stuff. */
	
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
							<h1 class="page_title" style="<?php echo "color: #$tcolor; font-size: $tsize; font-family: '{$principalfont[0]}'; font-weight:{$principalfont[1]};";?><?php if ($margintop != "") echo "margin-top: ".intval($margintop,10)."px;"; ?>">
								<?php echo $counter->post_count . " " . __(get_option(DESIGNARE_SHORTNAME.'_search_results_text'), "yunik") . " &#8216; " . $_GET['s'] ." &#8217;"; ?>
							</h1>
							<?php
						}
		    			if ($showsectitle){
			    			if (get_option(DESIGNARE_SHORTNAME.'_search_secondary_title') != ""){
						    	?>
							    <h2 class="secondaryTitle" style="<?php echo "color: #$stcolor; font-size: $stsize; line-height: $stsize; font-family: '{$secondaryfont[0]}'; font-weight:{$secondaryfont[1]}; margin-top:{$stmargin};";?>">
							    	<?php echo stripslashes(get_option(DESIGNARE_SHORTNAME."_search_secondary_title")); ?>
							    </h2>
					    		<?php
					    	}
		    			}
		    		?>
		    		</div>
		    		
				</div>
		<?php }
		?>
		</div> <!-- end of fullwidth section -->
		<?php 
	}
	
	if (!$sidebar) $sidebar = "defaultblogsidebar";
	switch ($sidebar_scheme){
		case "none":
			?>
			<div class="master_container" style="width: 100%;float: left;background-color: white;">
				<div class="container">
					<section class="page_content">
						<?php des_yunik_print_search_results(); ?>
					</section>
				</div>
			</div>
			<?php
		break;
		case "left":
			?>
			<div class="master_container" style="width: 100%;float: left;background-color: white;">
				<div class="container">
					<section class="page_content left sidebar col-xs-12 col-md-3">
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
					</section>
					<section class="page_content right col-xs-12 col-md-9">
						<?php des_yunik_print_search_results(); ?>
					</section>
				</div>
			</div>
			<?php
		break;
		case "right":
			?>
			<div class="master_container" style="width: 100%;float: left;background-color: white;">
				<div class="container">
					<section class="page_content left col-xs-12 col-md-9">
						<?php des_yunik_print_search_results(); ?>
					</section>
					<section class="page_content right sidebar col-xs-12 col-md-3">
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
					</section>
				</div>
			</div>
			<?php
		break;
		default:
			?>
			<div class="master_container" style="width: 100%;float: left;background-color: white;">
				<div class="container">
					<section class="page_content">
						<?php des_yunik_print_search_results(); ?>
					</section>
				</div>
			</div>
			<?php
		break;
	}
	
	function des_yunik_print_search_results(){
		global $the_query;
		if ($the_query->have_posts()){
		?> 
		
		<div class="post-listing">
			<?php			    
			    while ( $the_query->have_posts() ) : 
						
			    	$the_query->the_post();
		    		global $yunik_more;
			    		$yunik_more = 0;
					
					?>
			    	
			    	<article id="post-<?php the_ID(); ?>" <?php if (is_sticky()) post_class('sticky'); else post_class(); ?>>
				    	
				    	
				    	<div class="the_title"><h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2></div>
    		
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
							
							<p><a href="#comments"><i class="fa fa-comments-o"></i> <?php echo get_comments_number(); ?></a></p>
			    		</div>
			    							    
					    <div class="des-sc-dots-divider"></div>
						
				    </article> <!-- end of post -->
				    	
			    <?php endwhile; ?>
			    		
	    	</div> <!-- end of post-listing -->
					
			<div class="navigation">
				<?php
					global $yunik_reading_option;
					if ($yunik_reading_option != "paged" && $yunik_reading_option != "dropdown"){ 
						$the_query = new WP_Query();
					?>
						<?php  next_posts_link('<div class="next-posts">&laquo; ' . __(get_option(DESIGNARE_SHORTNAME."_previous_results").'</div>', "yunik"), $the_query->max_num_pages);  ?>
						<?php  previous_posts_link('<div class="prev-posts">'.__(get_option(DESIGNARE_SHORTNAME."_next_results"), "yunik") . ' &raquo;</div>', $the_query->max_num_pages); ?>
					<?php
					} else { 
						wp_pagenavi();
					}
				?>
			</div>

									
		<?php  }  else { ?>
	
		<div class="post-listing">
			<div class="pageTitle">
				<h2 class="hsearchtitle"><?php echo __(get_option(DESIGNARE_SHORTNAME.'_no_results_text'), "yunik");  ?></h2>
				<p class="titleSep"></p>
			</div>
		</div>
		
		
	<?php }
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