<?php
/**
 * @package WordPress
 * @subpackage Yunik
 */

get_header(); des_yunik_print_menu();

	global $yunik_reading_option; $yunik_reading_option = get_option(DESIGNARE_SHORTNAME.'_blog_reading_type');
	global $yunik_more;	$yunik_more = 0;

	$type = get_option(DESIGNARE_SHORTNAME."_header_type");
	$thecolor = des_hex2rgb(get_option(DESIGNARE_SHORTNAME."_header_color")); 
	$opacity = intval(str_replace("%","",get_option(DESIGNARE_SHORTNAME."_header_opacity")))/100;
	$color = "rgba(".$thecolor[0].",".$thecolor[1].",".$thecolor[2].",".$opacity.")";
	$image = get_option(DESIGNARE_SHORTNAME."_header_image"); 
	$pattern = DESIGNARE_PATTERNS_URL.get_option(DESIGNARE_SHORTNAME."_header_pattern"); 
	$custompattern = get_option(DESIGNARE_SHORTNAME."_header_custom_pattern"); 
	$height = get_option(DESIGNARE_SHORTNAME."_header_height"); 
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
							<h1 class="page_title" style="<?php echo "color: #$tcolor; font-size: $tsize; font-family: '{$principalfont[0]}';font-weight: {$principalfont[1]}; ";?><?php if ($margintop != "") echo "margin-top: ".intval($margintop,10)."px;"; ?>">
								<?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
	
								<?php /* If this is a category archive */ if (is_category()) { ?>
									Archive for the &#8216;<?php single_cat_title(); ?>&#8217; Category
									
								<?php /* If this is a tag archive */ } elseif( is_tag() ) { ?>
									Posts Tagged &#8216;<?php single_tag_title(); ?>&#8216;
										
								<?php /* If this is a daily archive */ } elseif (is_day()) { ?>
									Archive for <?php the_time('F jS, Y'); ?>
					
								<?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
									Archive for <?php the_time('F, Y'); ?>
					
								<?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
									Archive for <?php the_time('Y'); ?>
					
								<?php /* If this is an author archive */ } elseif (is_author()) { ?>
									Author Archive
									
								<?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
									Blog Archives
								
								<?php } ?>
							</h1>
							<?php
						}
		    			if ($showsectitle){
			    			if (get_option('yunik_archive_secondary_title') != ""){
						    	?>
							    <h2 class="secondaryTitle" style="<?php echo "color: #$stcolor; font-size: $stsize; line-height: $stsize; font-family: '{$secondaryfont[0]}'; font-weight: {$secondaryfont[1]}; margin-top:{$stmargin};";?>">
							    	<?php echo stripslashes(get_option(DESIGNARE_SHORTNAME."_archive_secondary_title")); ?>
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
		</div> <!-- end of fullwidth section -->
		<?php	
	}
	
	$sidebar = get_option(DESIGNARE_SHORTNAME.'_blog_archive_sidebars_available');
	switch (get_option(DESIGNARE_SHORTNAME."_blog_archive_sidebar")){
		case "none":
			?>
			<div class="blog-default wideblog">
				<div class="master_container container">
					
					<section class="page_content col-xs-12 col-md-12">
						<div class="blog-default-bg">
							<?php des_yunik_print_blog_archive(); ?>
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
							<?php des_yunik_print_blog_archive(); ?>
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
							<?php des_yunik_print_blog_archive(); ?>
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
			<section class="page_content">
				<div class="container">
				<?php
					$thepost = get_post($i->object_id);
					echo apply_filters( 'the_content', $thepost->post_content );
				?>
				</div>
			</section>
			<?php
		break;
	}
	
		
	function des_yunik_print_blog_archive(){
		
		if (have_posts()){
		
			if (get_option(DESIGNARE_SHORTNAME."_blog_archive_style") === "normal"){
			?> 			
			<div class="post-listing">
	    	
	    	<?php
		    
			    while (have_posts()){
				the_post();
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
		    		
				    <div class="divider-posts"></div>
			    </article>
	    	<?php }
		    ?>
		    </div>
		    <?php
		    } else {
			    ?>
			    <div class="post-listing journal isotope" data-columns="3" data-gutter-space="0.25">
	    	
		    	<?php
			    
				    while (have_posts()){
					    the_post();
					    $postid = get_the_ID();
					    ?>
					    <article id="post-<?php the_ID(); ?>" class="post journal-post isotope-item <?php echo get_post_meta(get_the_ID(), 'posttype_value', true); ?>">
						
						<div class="blog-default-bg-masonry">
							
								<div class="post-content fadeInUpBig">
							    <?php
								    $posttype = get_post_meta(get_the_ID(), 'posttype_value', true);
								    switch($posttype){
							    		case "image":
							    		
							    			if (wp_get_attachment_url( get_post_thumbnail_id($postid))){
											?>
												<div class="featured-image">
													<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
														<img alt="" src="<?php echo wp_get_attachment_url( get_post_thumbnail_id($postid)); ?>" title="<?php the_title(); ?>"/>
													</a>
												</div>
												<div class="padding-box-masonry">
													<div class="the_title"><h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2></div>
													
													<div class="post-summary"><?php the_excerpt(); ?></div>
													<div class="metas">
														<div class="date">
															<p><?php echo get_the_date("M")." ".get_the_date("d").", ".get_the_date("Y"); ?></p>
														</div>
														
														 <div class="comments-lovepost">
								                            <div class="comments-count">
								                            	<p><i class="fa fa-comments-o"></i> <?php echo get_comments_number(); ?></p>
								                            </div>
								                            
								                            <?php if( function_exists('zilla_likes') ){ ?>
									                        <div class="lovepost"><?php zilla_likes(); ?></div>
									                        <?php } ?>
							                            </div>
													</div>
												</div>
												<?php 
											}
							    			
							    		break;
		
							    		case "slider": 
											$randClass = rand(0,1000);
											?>
												<div class="light">
													<div class="flexslider <?php echo $posttype; ?>">
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
																    		echo "<a href='".$params[1]."' rel='gallery[".$randClass."]' class='slide-images' title='".$attachment->post_excerpt."'>";
															    		}
															    		echo "<img src='".$params[1]."' alt='' title='".$attachment->post_excerpt."'>";
															    		if (get_option(DESIGNARE_SHORTNAME."_enlarge_images") == "on"){
																    		echo "</a>";
															    		}
															    		echo "</li>";	
															    	}
															    }
															?>
														</ul>
													</div>
												</div>
												
												<div class="padding-box-masonry">
													<div class="the_title"><h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2></div>
													<div class="post-summary"><?php the_excerpt(); ?></div>													
													<div class="metas">
														<div class="date">
															<p><?php echo get_the_date("M")." ".get_the_date("d").", ".get_the_date("Y"); ?></p>
														</div>
														
														 <div class="comments-lovepost">
								                            <div class="comments-count">
								                            	<p><i class="fa fa-comments-o"></i> <?php echo get_comments_number(); ?></p>
								                            </div>
								                            
								                            <?php if( function_exists('zilla_likes') ){ ?>
									                        <div class="lovepost"><?php zilla_likes(); ?></div>
									                        <?php } ?>
							                            </div>
													</div>
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
												
											<div class="padding-box-masonry">
													
												<div class="the_title"><h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2></div>
												<div class="post-summary"><?php the_excerpt(); ?></div>
												<div class="metas">
													<div class="date">
														<p><?php echo get_the_date("M")." ".get_the_date("d").", ".get_the_date("Y"); ?></p>
													</div>
													
													 <div class="comments-lovepost">
							                            <div class="comments-count">
							                            	<p><i class="fa fa-comments-o"></i> <?php echo get_comments_number(); ?></p>
							                            </div>
							                            
							                            <?php if( function_exists('zilla_likes') ){ ?>
								                        <div class="lovepost"><?php zilla_likes(); ?></div>
								                        <?php } ?>
						                            </div>
												</div>
											</div>
											<?php
							    		break;
							    		
							    		case "video":
							    			?>
							    			
							    			
								    			<div class="post-video">
	                        	<div class="video-thumb">
									<div class="video-wrapper">
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
								    			</div></div></div>
											
											
											<div class="padding-box-masonry">
											
												<div class="the_title"><h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2></div>	
												<div class="post-summary"><?php the_excerpt(); ?></div>
												<div class="metas">
													<div class="date">
														<p><?php echo get_the_date("M")." ".get_the_date("d").", ".get_the_date("Y"); ?></p>
													</div>
													
													 <div class="comments-lovepost">
							                            <div class="comments-count">
							                            	<p><i class="fa fa-comments-o"></i> <?php echo get_comments_number(); ?></p>
							                            </div>
							                            
							                            <?php if( function_exists('zilla_likes') ){ ?>
								                        <div class="lovepost"><?php zilla_likes(); ?></div>
								                        <?php } ?>
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
											<div class="padding-box-masonry">
												<h2 class="post-title post-link">
													<?php
														$linkurl = get_post_meta($postid, 'link_url_value', true) != '' ? get_post_meta($postid, 'link_url_value', true) : get_permalink();
														$linktext = get_post_meta($postid, 'link_text_value', true) != '' ? get_post_meta($postid, 'link_text_value', true) : $linkurl;
													?>
													<a href="<?php echo $linkurl; ?>" target="_blank"><?php echo $linktext; ?></a>
						                        </h2>
						                        
											</div>
											<?php
										break;
							    		
							    		case "text": default:
							    			?>
							    			
							    			<div class="padding-box-masonry">
							    				<div class="the_title no-feature"><h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2></div>
												<div class="post-summary"><?php the_excerpt(); ?></div>
												<div class="metas">
													<div class="date">
														<p><?php echo get_the_date("M")." ".get_the_date("d").", ".get_the_date("Y"); ?></p>
													</div>
													
													 <div class="comments-lovepost">
							                            <div class="comments-count">
							                            	<p><i class="fa fa-comments-o"></i> <?php echo get_comments_number(); ?></p>
							                            </div>
							                            
							                            <?php if( function_exists('zilla_likes') ){ ?>
								                        <div class="lovepost"><?php zilla_likes(); ?></div>
								                        <?php } ?>
						                            </div>
												</div>
							    			</div>
							    			
							    			<?php
							    		break;
						    		}
								    ?>
							    
							    
							</div>
						</div>
				    </article>
					    <?php
				    }
				    
				    ?>
		    	</div>
		    	<script type="text/javascript">
				jQuery(document).ready(function(){
					var forceGutter = 50; // change to false to return to the normal behavior.
					(function(e){"use strict";e.Isotope.prototype._getMasonryGutterColumns=function(){var e=this.options.masonry&&this.options.masonry.gutterWidth||0;var t=this.element.width();this.masonry.columnWidth=this.options.masonry&&this.options.masonry.columnWidth||this.$filteredAtoms.outerWidth(true)||t;this.masonry.columnWidth+=e;this.masonry.cols=Math.floor((t+e)/this.masonry.columnWidth);this.masonry.cols=Math.max(this.masonry.cols,1)};e.Isotope.prototype._masonryReset=function(){this.masonry={};this._getMasonryGutterColumns();var e=this.masonry.cols;this.masonry.colYs=[];while(e--){this.masonry.colYs.push(0)}};e.Isotope.prototype._masonryResizeChanged=function(){var e=this.masonry.cols;this._getMasonryGutterColumns();return this.masonry.cols!==e};e(document).ready(function(){var t=e(".journal");var n=0;var r=0;var i=function(){var e=parseInt(t.data("columns"));var i=t.data("gutterSpace");var s=t.width();var o=0;if(isNaN(i)){i=.02}else if(i>.05||i<0){i=.02}if(s<568){e=1}else if(s<768){e-=2}else if(s<991){e-=1;if(e<2){e=2}}if(e<1){e=1}r=forceGutter!=false ? forceGutter : Math.floor(s*i);var u=r*(e-1);var a=s-u;n=Math.floor(a/e);o=r;if(1==e){o=20}t.children(".journal-post").css({width:n+"px",marginBottom:o+"px"})};i();window.iso = t.isotope({itemSelector:".journal-post",resizable:false,masonry:{columnWidth:n,gutterWidth:r}});t.imagesLoaded(function(){i();t.isotope({itemSelector:".journal-post",resizable:true,masonry:{columnWidth:n,gutterWidth:r}})});e(window).smartresize(function(){i();t.isotope({masonry:{columnWidth:n,gutterWidth:r}})});var s=e(".wc-shortcodes-filtering .wc-shortcodes-term");s.click(function(i){i.preventDefault();s.removeClass("wc-shortcodes-term-active");e(this).addClass("wc-shortcodes-term-active");var o=e(this).attr("data-filter");t.isotope({filter:o,masonry:{columnWidth:n,gutterWidth:r}});return false})})})(jQuery);
					
					jQuery('.flexslider').flexslider({						
						animation: "fade",
						slideshow: true,
						slideshowSpeed: 3500,
						animationDuration: 1000,
						directionNav: true,
						controlNav: true,
						smootheHeight:false,
						start: function(slider) {
						  slider.removeClass('loading').css('overflow','');
						}
						
					});
				});
			</script>
			    <?php
		    	}
	    	?> 
					
			<div class="navigation">
				<?php
					global $yunik_reading_option;
					if ($yunik_reading_option != "paged" && $yunik_reading_option != "dropdown"){ 
						$the_query = new WP_Query();
					?>
						<?php  next_posts_link('&laquo; <div class="next-posts">' . __(get_option(DESIGNARE_SHORTNAME."_previous_text").'</div>', "yunik"), $the_query->max_num_pages);  ?>
						<?php  previous_posts_link('<div class="prev-posts">'.__(get_option(DESIGNARE_SHORTNAME."_next_text"), "yunik") . ' &raquo;</div>', $the_query->max_num_pages); ?>
					<?php
					} else { 
						wp_pagenavi();
					}
				?>
			</div>

									
		<?php  }
		else echo "<br/><br/><h2>There are no posts in this archive.</h2><br/><br/>";
	}
		
	?>

	<div class="clear"></div>
	
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