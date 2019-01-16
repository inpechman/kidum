<?php

class RecentPostsSidebar_Widget extends WP_Widget {

	function RecentPostsSidebar_Widget() {
		$widget_ops = array('classname' => 'recentPostsSidebar_widget', 'description' => __('Show your recent blog posts on your site.', 'yunik'));
		parent::__construct(false, 'DESIGNARE _ Recent Posts', $widget_ops);
	}

	function form($instance) {

		if (isset($instance['title'])){
			$title = esc_attr($instance['title']); 	
		} else $title = "";
		
		if (isset($instance['nposts'])){
			$nposts = esc_attr($instance['nposts']);	
		} else $nposts = "";
		
		if (isset($instance['categories'])){
			$categories = esc_attr($instance['categories']);  
		} else $categories = "";
		
		if (isset($instance['orderby'])){
			$orderby = esc_attr($instance['orderby']);	
		} else $orderby = "";
		
		if (isset($instance['order'])){
			$order = esc_attr($instance['order']);  	
		} else $order = "";
        
        if (isset($instance['autoplay'])){
			$autoplay = esc_attr($instance['autoplay']); 	
		} else $autoplay = "";
		
        if (isset($instance['hidearrows'])){
			$hidearrows = esc_attr($instance['hidearrows']); 	
		} else $hidearrows = "";
		
		if (isset($instance['hidenav'])){
			$hidenav = esc_attr($instance['hidenav']); 	
		} else $hidenav = "";
		
		if (isset($instance['desktops'])){
			$desktops = esc_attr($instance['desktops']); 	
		} else $desktops = "";
		
		if (isset($instance['tabs'])){
			$tabs = esc_attr($instance['tabs']); 	
		} else $tabs = "";
		
		if (isset($instance['mobiles'])){
			$mobiles = esc_attr($instance['mobiles']); 	
		} else $mobiles = "";
        
        ?>
        
        <p><label for="<?php echo $this->get_field_id('title'); ?>">&#8212; <?php _e('Title','yunik'); ?> &#8212;<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" ></label></p> 
        <p><label for="<?php echo $this->get_field_id('nposts'); ?>">&#8212; <?php _e('Number Posts to show','yunik'); ?> &#8212;<input class="widefat" id="<?php echo $this->get_field_id('nposts'); ?>" name="<?php echo $this->get_field_name('nposts'); ?>" type="text" value="<?php echo $nposts; ?>" ><br><span class="flickr-stuff">If 0 will show all posts.</span></label></p>
        <p><label for="<?php echo $this->get_field_id('categories'); ?>">&#8212; <?php _e('Categories','yunik'); ?> &#8212;<input style="display:none;" class="widefat" id="<?php echo $this->get_field_id('categories'); ?>" name="<?php echo $this->get_field_name('categories'); ?>" type="text" value="<?php echo $categories; ?>" ></label></p>
       <div class="widget-recent-posts-categories">
       <?php
	    $args = array(
			'type' => 'post',
			'orderby' => 'id',
			'order' => 'ASC',
			'taxonomy' => 'category',
			'hide_empty' => 0,
			'pad_counts' => false
		);
		
		$categories = get_categories( $args );
		if (count($categories) > 0){
			foreach($categories as $cats){
				?>
				<label></label><input type="checkbox" name="<?php echo $cats->slug; ?>" value="<?php echo $cats->slug; ?>"><?php echo $cats->cat_name; ?>
				<?php
			}
		}
		else { ?> <i style="position:relative;top:-8px;margin-left:15px;"> <?php _e("No Categories defined.", "yunik"); ?></i> <?php }
	       
       ?>
       </div>
        
	    <p><label>&#8212; <?php _e('Order by','yunik'); ?> &#8212;</label><br>
	    		<input type="radio" name="<?php echo $this->get_field_name('orderby'); ?>" value="title" <?php if($orderby == 'title') echo 'checked'; ?>> <?php _e('Title','yunik'); ?><br>
	    		<input type="radio" name="<?php echo $this->get_field_name('orderby'); ?>" value="date" <?php if($orderby == 'date') echo 'checked'; ?>> <?php _e('Date','yunik'); ?><br>
	    		<input type="radio" name="<?php echo $this->get_field_name('orderby'); ?>" value="author" <?php if($orderby == 'author') echo 'checked'; ?>> <?php _e('Author','yunik'); ?><br>
	    		<input type="radio" name="<?php echo $this->get_field_name('orderby'); ?>" value="comment_count" <?php if($orderby == 'comment_count') echo 'checked'; ?>> <?php _e('Number Comments','yunik'); ?><br>
	    </p>
	    <p><label>&#8212; <?php _e('Order','yunik'); ?> &#8212;</label><br>
	    		<input type="radio" name="<?php echo $this->get_field_name('order'); ?>" value="asc" <?php if($order == 'asc') echo 'checked'; ?>> <?php _e('Ascending','yunik'); ?><br>
	    		<input type="radio" name="<?php echo $this->get_field_name('order'); ?>" value="desc" <?php if($order == 'desc') echo 'checked'; ?>> <?php _e('Descending','yunik'); ?><br>
	    </p>
	    
		<p class="posts_autoplay_select"><label for="<?php echo $this->get_field_id('autoplay'); ?>">&#8212; <?php _e('Scroll Items Automatically','yunik'); ?> &nbsp;<input id="<?php echo $this->get_field_id('autoplay'); ?>" name="<?php echo $this->get_field_name('autoplay'); ?>" type="checkbox" value="autoplay" <?php if($autoplay == "autoplay") echo 'checked'; ?> /></label></p>
		
		<p class="posts_hidearrows_select"><label for="<?php echo $this->get_field_id('hidearrows'); ?>">&#8212; <?php _e('Hide Navigation Arrows','yunik'); ?> &nbsp;<input id="<?php echo $this->get_field_id('hidearrows'); ?>" name="<?php echo $this->get_field_name('hidearrows'); ?>" type="checkbox" value="hidearrows" <?php if($hidearrows == "hidearrows") echo 'checked'; ?> /></label></p>
		
		<p class="posts_hidenav_select"><label for="<?php echo $this->get_field_id('hidenav'); ?>">&#8212; <?php _e('Hide Navigation','yunik'); ?> &nbsp;<input id="<?php echo $this->get_field_id('hidenav'); ?>" name="<?php echo $this->get_field_name('hidenav'); ?>" type="checkbox" value="hidenav" <?php if($hidenav == "hidenav") echo 'checked'; ?> /></label></p>
		
		<h4><?php _e("Define the number of items to show in each display","yunik"); ?></h4>
		<p><label for="<?php echo $this->get_field_id('desktops'); ?>">&#8212; <?php _e('Desktops','yunik'); ?> &#8212;<input class="widefat" id="<?php echo $this->get_field_id('desktops'); ?>" name="<?php echo $this->get_field_name('desktops'); ?>" type="text" value="<?php echo $desktops; ?>" /></label></p> 
		
		<p><label for="<?php echo $this->get_field_id('tabs'); ?>">&#8212; <?php _e('Tablets','yunik'); ?> &#8212;<input class="widefat" id="<?php echo $this->get_field_id('tabs'); ?>" name="<?php echo $this->get_field_name('tabs'); ?>" type="text" value="<?php echo $tabs; ?>" /></label></p> 

		<p><label for="<?php echo $this->get_field_id('mobiles'); ?>">&#8212; <?php _e('Mobiles','yunik'); ?> &#8212;<input class="widefat" id="<?php echo $this->get_field_id('mobiles'); ?>" name="<?php echo $this->get_field_name('mobiles'); ?>" type="text" value="<?php echo $mobiles; ?>" /></label></p> 
		    
		<script type="text/javascript">
	        jQuery(document).ready(function($){
	        	$('.widget-recent-posts-categories').each(function(){
		        	var $el = $(this);
		        	var savedVal = $el.prev().find('input').val().split("|*|");
		        	for (var i=0; i<savedVal.length; i++){
			        	if (savedVal[i] != ""){
				        	$el.find('input[value='+savedVal[i]+']').attr('checked','true');
			        	}
		        	}
		        
			        $el.find('input').change(function(){
				       var newVal = "";
				       var first = true;
				       $el.find('input').each(function(){
					       if ($(this).is(':checked')){
						       if (first){
							   		newVal += $(this).val();
							   		first = false;
						       } else newVal += "|*|" + $(this).val();
					       }
				       });
				       $el.prev().find('input').val(newVal);
			        });	
	        	});
	        });
        </script>	    
	
        <?php
	}
	function update($new_instance, $old_instance) {
		// processes widget options to be saved
		$instance = $old_instance;
	    $instance['title'] = $new_instance['title'];
	    $instance['nposts'] = $new_instance['nposts'];
	    $instance['categories'] = $new_instance['categories'];
	    $instance['orderby'] = $new_instance['orderby'];
	    $instance['order'] = $new_instance['order'];
	    $instance['autoplay'] = $new_instance['autoplay'];
	    $instance['hidearrows'] = $new_instance['hidearrows'];
	    $instance['hidenav'] = $new_instance['hidenav'];
		
		$instance['desktops'] = $new_instance['desktops'];
	    $instance['tabs'] = $new_instance['tabs'];
	    $instance['mobiles'] = $new_instance['mobiles'];

		return $instance;
	}
	
	function widget($args, $instance) {
		extract($instance);
	    $nposts = $instance['nposts'];
	    $categories = $instance['categories'];
	    $orderby = $instance['orderby'];
	    $order = $instance['order'];
	    $autoplay = (isset($instance['autoplay'])) ? "yes" : "no";
		$hidearrows = (isset($instance['hidearrows'])) ? "yes" : false;
		$hidenav = (isset($instance['hidenav'])) ? "yes" : false;

		$desktops = $instance['desktops'] ? $instance['desktops'] : 1;
		$tabs = $instance['tabs'] ? $instance['tabs'] : 1;
		$mobiles = $instance['mobiles'] ? $instance['mobiles'] : 1;

		
	    //$posts_per_row = $instance['posts_per_row'];
	   	$thecats = array();
	    if (strlen($categories) > 0){
	    	$cats = explode("|*|",$categories);
	    	foreach($cats as $c){
	    		if ($c != ""){
	    			array_push($thecats, $c);
	    		}
	    	}
	    }
	    
	   	global $post, $wp_query;
	    
	    $args = array(
			'showposts' => $nposts,
			'orderby' => $orderby,
			'order' => $order,
			'post_status' => 'publish'
		);
		$losposts = get_posts($args);
		$filteredposts = array();
		foreach ($losposts as $p){
			$postscats = get_the_terms($p->ID, 'category');
			$found = false;
			if (is_array($postscats)){
				foreach ($postscats as $pcats){
					foreach ($thecats as $tc){ 
						if ($pcats->slug == $tc) $found = true;	
					}
				}
				if ($found) {
					array_push($filteredposts, $p);
					$losposts = $filteredposts;
				}	
			}
		}
		
		global $vc_addons_url;
		wp_enqueue_script('ult-slick');
		wp_enqueue_script('ultimate-appear');
		wp_enqueue_script('ult-slick-custom');
		wp_enqueue_style("ult-slick", $vc_addons_url."assets/min-css/slick.min.css");
		wp_enqueue_style("ult-icons", $vc_addons_url."assets/min-css/icons.min.css");
		wp_enqueue_style("ult-slick-animate", $vc_addons_url."assets/min-css/animate.min.css");		
		
		echo '<div class="widget des_recent_posts_widget">';
		$title = apply_filters( 'widget_title', empty($instance['title']) ? '' : $instance['title'], $instance );
		if (isset($before_widget) && !empty($before_widget)) { echo $before_title;}
		if (!empty($title)) { echo "<h4>$title</h4><hr>"; }
		
		ob_start();
		$uid = uniqid(rand());
		$uniqid = uniqid(rand());
		echo '<div id="ult-carousel-'.$uniqid.'" class="ult-carousel-wrapper ult_horizontal" data-gutter="10">';
			echo '<div class="ult-carousel-'.$uid.'">';
			if (function_exists('ultimate_override_shortcodes')) ultimate_override_shortcodes(10, 'no-animation');
			foreach ($losposts as $post){
				$posttype = (get_post_meta($post->ID, 'posttype_value', true) == "") ? "text" : get_post_meta($post->ID, 'posttype_value', true);
				echo '<div class="ult-item-wrap" data-animation="animated no-animation">';
				
				switch ($posttype){
					case "image":
						if (wp_get_attachment_url( get_post_thumbnail_id($post->ID))){
							?>
							<div class="featured-image">
								<a href="<?php echo get_permalink($post->ID); ?>" title="<?php echo $post->post_title; ?>">
									<img alt="<?php echo $post->post_title; ?>" src="<?php echo wp_get_attachment_url( get_post_thumbnail_id($post->ID)); ?>" title="<?php echo get_the_title($post->ID); ?>"/>
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
										$sliderData = get_post_meta($post->ID, "sliderImages_value", true);
										$slide = explode("|*|",$sliderData);
									    foreach ($slide as $s){
									    	if ($s != ""){
									    		$params = explode("|!|",$s);
									    		$attachment = get_post( $params[0] );
									    		echo "<li><img src='".$params[1]."' alt='' title='".$attachment->post_excerpt."'></li>";	
									    	}
									    }
									?>
								</ul>
							</div>
							<script type="text/javascript">
								jQuery(document).ready(function(){
									jQuery('#<?php echo $randClass; ?>').flexslider({						
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
					break;
					case "audio":
		    			?>
						<div class="audioContainer">
							<?php
								if (get_post_meta($post->ID, 'audioSource_value', true) == 'embed') echo get_post_meta($post->ID, 'audioCode_value', true); 
								else {
									$audio = explode("|!|",get_post_meta($post->ID, 'audioMediaLibrary_value', true));
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
		    			<div class="post-video">
							<div class="video-thumb">
								<div class="video-wrapper vendor">
								<?php
									$videosType = get_post_meta($post->ID, "videoSource_value", true);
									if ($videosType != "embed"){
										$videos = get_post_meta($post->ID, "videoCode_value", true);
										$videos = preg_replace( '/\s+/', '', $videos );
										$vid = explode(",",$videos);
									}
									switch (get_post_meta($post->ID, "videoSource_value", true)){
										case "media":
											$video = explode("|!|",get_post_meta($post->ID, 'videoMediaLibrary_value', true));
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
				}
				?>
				<div class="title"><a href="<?php echo get_permalink($post->ID); ?>"><h4><?php echo $post->post_title; ?></h4></a></div>
				
				<?php
					if ($posttype != "quote" && $posttype != "link"){
						?>
						<div class="excerpt"><?php
							$content = $post->post_content;
							$pos=strpos($content, '<!--more-->');
							$more_tag = '';
							if ($pos){
								$text = explode('<!--more-->', $content);
								$text = $text[0];
								echo $text." ".$more_tag;
							} else {
								$text = strip_shortcodes( $post->post_content );				
						        $text = apply_filters('the_content', $text);
						        $text = str_replace(']]>', ']]&gt;', $text);
						        $excerpt_length = apply_filters('excerpt_length', 55);
						        $excerpt_more = apply_filters('excerpt_more', ' ' . $more_tag);
						        $text = wp_trim_words( $text, $excerpt_length, $excerpt_more );
								echo apply_filters('wp_trim_excerpt', $text);
							}
						?></div>
					<?php
					}
				?>
				<div class="metas">
					<div class="date">
						<p><?php echo get_the_date("M")." ".get_the_date("d").", ".get_the_date("Y"); ?></p>
					</div>
					
					 <div class="comments-lovepost">
                        <div class="comments-count">
                        	<p><i class="fa fa-comments-o"></i> <?php echo get_comments_number(); ?></p>
                        </div>
                       
                    </div>
				</div>
				<?php
					if ($posttype == "quote" || $posttype == "link"){
						if ($posttype == "quote"){
							?>
							<div class="post-quote">
	                        	<blockquote><i class="fa fa-quote-left"></i> <?php echo get_post_meta($post->ID, 'quote_text_value', true); ?> <i class="fa fa-quote-right"></i></blockquote>
	                        	<span class="author-quote">-- <?php echo get_post_meta($post->ID, 'quote_author_value', true); ?> --</span>
	                        </div>
							<?php
						} else {
							?>
							<h2 class="post-title post-link">
								<?php
									$linkurl = get_post_meta($post->ID, 'link_url_value', true) != '' ? get_post_meta($post->ID, 'link_url_value', true) : get_permalink($post->ID);
									$linktext = get_post_meta($post->ID, 'link_text_value', true) != '' ? get_post_meta($post->ID, 'link_text_value', true) : $linkurl;
								?>
								<a href="<?php echo $linkurl; ?>" target="_blank"><?php echo $linktext; ?></a>
	                        </h2>
							<?php
						}
					}
				echo '</div>';
			}
			ultimate_restore_shortcodes();
			echo '</div>';
		echo '</div>';
		?>
        <script type="text/javascript">
	        jQuery(document).ready(function(){
				jQuery('.ult-carousel-<?php echo $uid; ?>').slick({<?php if (!$hidenav) echo "dots:true,"; ?><?php if($autoplay=='yes')echo'autoplay:true,autoplaySpeed:5000,';?>speed:300,infinite:true,<?php if (!$hidearrows) echo "arrows:true," ?>adaptiveHeight:true,<?php if (!$hidearrows){ ?>prevArrow:'<button type="button" style="color: rgb(51, 51, 51); font-size: 24px; display: block;" class="slick-prev default"><i class="ultsl-arrow-left6"></i></button>',nextArrow:'<button type="button" style="color: rgb(51, 51, 51); font-size: 24px; display: block;" class="slick-next default"><i class="ultsl-arrow-right6"></i></button>',<?php } ?>slidesToScroll:<?php echo $desktops; ?>,slidesToShow:<?php echo $desktops; ?>,swipe:true,draggable:true,touchMove:true,responsive:[{breakpoint:1024,settings:{slidesToShow:<?php echo $desktops; ?>,slidesToScroll:<?php echo $desktops; ?>}},{breakpoint:767,settings:{slidesToShow:<?php echo $tabs; ?>,slidesToScroll:<?php echo $tabs; ?>}},{breakpoint:480,settings:{slidesToShow:<?php echo $mobiles; ?>,slidesToScroll:<?php echo $mobiles; ?>}},{breakpoint:0,settings:{slidesToShow:<?php echo $mobiles; ?>,slidesToScroll:<?php echo $mobiles; ?>}}],pauseOnHover:true,pauseOnDotsHover:true,mobileFirst:true,customPaging:function(slider,i){return'<i type="button" style="color:#333333;" class="ultsl-record" data-role="none"></i>';},});		        
	        });
		</script>
        <?php
		
		echo ob_get_clean();
		
		if (isset($after_widget) && !empty($after_widget)) echo $after_widget;
		
		echo '</div>';
		?>
		<style type="text/css">
			.ult-carousel-<?php echo $uid; ?> button{opacity:0;transition:all .2s linear .5s;}
			.ult-carousel-<?php echo $uid; ?>:hover button{opacity:1;transition:all 0s linear 0s;}
		</style>
		<?php
		
	}
}
register_widget('RecentPostsSidebar_Widget');

?>
