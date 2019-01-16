<?php
/*
Template Name: Blog Template
*/
get_header(); des_yunik_print_menu();

	$yunik_thisPostID = get_the_ID(); 	
	global $isfirstpage;

	if (get_post_meta($yunik_thisPostID, "yunik_enable_custom_pagetitle_options_value", true) == "no" || !get_post_meta($yunik_thisPostID, "yunik_enable_custom_pagetitle_options_value", true)){
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
		//$height = get_post_meta($yunik_thisPostID, "yunik_header_height_value", true);
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
		 			
		 		//if ($isfirstpage) echo "margin-top:60px;";
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
								<?php if (get_option('yunik_blog_single_primary_title') != "" && !is_array(get_option('yunik_blog_single_primary_title'))) echo get_option('yunik_blog_single_primary_title'); else echo get_the_title($yunik_thisPostID); ?>
							</h1>
							<?php
						}
		    			if ($showsectitle){
			    			if (get_post_meta($post->ID, 'secondaryTitle_value', true) != ""){
						    	?>
							    <h2 class="secondaryTitle" style="<?php echo "color: #$stcolor; font-size: $stsize; line-height: $stsize; font-family: '{$secondaryfont[0]}'; font-weight: {$secondaryfont[1]}; margin-top:{$stmargin};";?>">
							    	<?php echo stripslashes(get_post_meta($post->ID, 'secondaryTitle_value', true)); ?>
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

	$sidebar_scheme = get_post_meta($yunik_thisPostID, 'sidebar_for_default_value', true);
	$sidebar = get_post_meta($yunik_thisPostID, 'sidebars_available_value', true);
	if (!$sidebar) $sidebar = "defaultblogsidebar";
	switch ($sidebar_scheme){
		case "none":
			if (!$isfirstpage){
				?>
				<div class="content-before-blog">
					<?php echo do_shortcode($post->post_content); ?>
				</div>
				<?php
			}
			?>
			<div class="blog-default wideblog">
				<div class="master_container">
					<section class="page_content col-xs-12 col-md-12">
						<div class="blog-default-bg">
							<div class="container">
							<?php des_yunik_print_blog(); ?>
							</div>
						</div>
					</section>
				</div>
			</div>
			<?php
		break;
		case "left":
			if (!$isfirstpage){
				?>
				<div class="content-before-blog">
					<?php echo do_shortcode($post->post_content); ?>
				</div>
				<?php
			}
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
							<?php des_yunik_print_blog(); ?>
						</div>
					</section>
				</div>
			</div>
			<?php
		break;
		case "right":
			if (!$isfirstpage){
				?>
				<div class="content-before-blog">
					<?php echo do_shortcode($post->post_content); ?>
				</div>
				<?php
			}
			?>
			<div class="blog-default">
				<div class="master_container container">
					<section class="page_content left col-xs-12 col-md-9">
						<div class="blog-default-bg">
							<?php des_yunik_print_blog(); ?>
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
			if (!$isfirstpage){
				?>
				<div class="content-before-blog">
					<?php echo do_shortcode($post->post_content); ?>
				</div>
				<?php
			}
			?>
			<div class="blog-default wideblog">
				<div class="master_container">
					<section class="page_content col-xs-12 col-md-12">
						<div class="blog-default-bg">
							<div class="container">
							<?php des_yunik_print_blog(); ?>
							</div>
						</div>
					</section>
				</div>
			</div>
			<?php
		break;
	}

	function des_yunik_print_blog(){
		
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
		
		$cattype = "category__in";
		if (strpos(get_post_meta(get_the_ID(), 'posts_filter_categories_value', true), ',') !== false){
			$categories = explode(',',get_post_meta(get_the_ID(), 'posts_filter_categories_value', true));	
		} else {
			$cattype = "cat";
			$categories = get_post_meta(get_the_ID(), 'posts_filter_categories_value', true);
		}
		$tagtype = "tag__in";
		if (strpos(get_post_meta(get_the_ID(), 'posts_filter_tags_value', true), ',') !== false){
			$tags = explode(",",get_post_meta(get_the_ID(), 'posts_filter_tags_value', true));	
		} else {
			$tagtype = "tag_id";
			$tags = get_post_meta(get_the_ID(), 'posts_filter_tags_value', true);
		}
		$authortype = "author__in";
		if (strpos(get_post_meta(get_the_ID(), 'posts_filter_authors_value', true), ',') !== false){
			$authors = explode(",",get_post_meta(get_the_ID(), 'posts_filter_authors_value', true));
		} else {
			$authortype = "author";
			$authors = get_post_meta(get_the_ID(), 'posts_filter_authors_value', true);
		}
		$orderby = get_post_meta(get_the_ID(), 'posts_filter_orderby_value', true);
		$order = get_post_meta(get_the_ID(), 'posts_filter_order_value', true);
		
		if (!isset($nposts)) $nposts = get_option('posts_per_page');
		$args = array(
			'showposts' => $nposts,
	    	'orderby' => $orderby,
	    	'order' => $order,
	    	$cattype => $categories,
	    	$tagtype => $tags,
	    	$authortype => $authors,
	    	'post_status' => 'publish',
	    	'paged' => $pag
	    );
	    	
	    global $post, $wp_query;
	    
	    $the_query = new WP_Query( $args );
	    				    
	    if ($the_query->have_posts()){ 
	    ?> 
	    	<div class="post-listing">
		    	
	    	<?php
		    
			    while ($the_query->have_posts()){
				    $the_query->the_post();
				    $postid = get_the_ID();
				    ?>
				    
				    <article id="post-<?php the_ID(); ?>" <?php if (is_sticky()) post_class('sticky'); else post_class(); ?>>
					    
					    <?php
						    $posttype = get_post_meta(get_the_ID(), 'posttype_value', true);
						    switch($posttype){
					    		case "image":
					    		
					    			if (wp_get_attachment_url( get_post_thumbnail_id($postid))){
									?>
										<div class="featured-image">
											<a href="<?php the_permalink(); ?>" title="">
											<img alt="" src="<?php echo wp_get_attachment_url( get_post_thumbnail_id($postid)); ?>" title="<?php the_title(); ?>"/>
											<span class="post_overlay">
													<i class="fa fa-plus" aria-hidden="true"></i>
												</span>
											</a>
										</div>
										<?php 
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
												    		echo "<img src='".$params[1]."' alt='' title='".$attachment->post_excerpt."'>";
												    		echo "</li>";	
												    	}
												    }
												?>
											</ul>
										</div>
									<?php
					    		break;

					    		case "audio":
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
					    			?>
					    			<div class="post-video <?php echo get_post_meta($postid, "videoSource_value", true); ?>">
										<div class="video-thumb">
											<div class="video-wrapper vendor">
										<?php
											$videosType = get_post_meta($postid, "videoSource_value", true);
											if ($videosType != "embed"){
												$videos = get_post_meta($postid, "videoCode_value", true);
												$videos = preg_replace( '/\s+/', '', $videos );
												$vid = explode(",",$videos);
											}
											switch (get_post_meta($postid, "videoSource_value", true)){
												case "media":
													$video = explode("|!|",get_post_meta($postid, 'videoMediaLibrary_value', true));
													if (isset($video[1])) {
														$ext = explode(".",$video[1]);
														if (isset($ext)) $ext = $ext[count($ext)-1];
														?>
														<video controls="controls" style="width: 100%;"><source type="video/<?php echo $ext; ?>" src="<?php echo $video[1]; ?>"></video>
														<?php
													}
												break;
												case "youtube":
													if (isset($vid[0])) echo "<iframe src='//www.youtube.com/embed/".$vid[0]."' frameborder='0' allowfullscreen></iframe>";
													break;
												case "vimeo":
													if (isset($vid[0])) echo '<iframe src="https://player.vimeo.com/video/'.$vid[0].'" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
													break;
											}						
										?>
											</div>
										</div>
									</div>
									<?php
					    		break;
					    		case "quote":
					    			?>
					    			<a href="<?php the_permalink(); ?>">
						    			<div class="post-quote">
				                        	<blockquote><i class="fa fa-quote-left"></i> <?php echo get_post_meta($postid, 'quote_text_value', true); ?> <i class="fa fa-quote-right"></i></blockquote>
				                        	<span class="author-quote">-- <?php echo get_post_meta($postid, 'quote_author_value', true); ?> --</span>
				                        </div>
			                        </a>
					    			<?php
					    		break;

								case "link":
									?>
									<h2 class="post-title post-link">
										<?php
											$linkurl = get_post_meta($postid, 'link_url_value', true) != '' ? get_post_meta($postid, 'link_url_value', true) : get_permalink();
											$linktext = get_post_meta($postid, 'link_text_value', true) != '' ? get_post_meta($postid, 'link_text_value', true) : $linkurl;
										?>
										<a href="<?php echo $linkurl; ?>" target="_blank"><?php echo $linktext; ?></a>
			                        </h2>
									<?php
								break;
					    		
					    		case "text": default:

					    		break;
				    		}
					    ?>		
				    		
				    		<?php
					    		if ($posttype != "quote" && $posttype != "link"){
						    		?>
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
						    		
						    		<div class="blog_excerpt">
								    	<?php the_excerpt(); ?>
								    </div>
						    		<?php
					    		}
				    		?>
					    <div class="divider-posts"></div>
				    </article>
				    <?php
			    }
			    
			    ?>
	    	</div>
	    	<div class="navigation">
			<?php
				$yunik_reading_option = get_option('yunik_blog_reading_type');
				wp_reset_postdata();
				if ($yunik_reading_option != "paged" && $yunik_reading_option != "dropdown"){ 
					next_posts_link( '<div class="next-posts"><i class="fa fa-angle-left"></i>'.__(get_option(DESIGNARE_SHORTNAME."_previous_text"), "yunik").'</div>', $the_query->max_num_pages);  
					previous_posts_link('<div class="prev-posts">'.__(get_option(DESIGNARE_SHORTNAME."_next_text"), "yunik").'<i class="fa fa-angle-right"></i></div>', $the_query->max_num_pages);  
				} else {
					wp_pagenavi();
				}
			?>	
			</div>
	    <?php
		}
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