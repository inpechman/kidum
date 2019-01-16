<?php

class Projects_Widget extends WP_Widget {
	function Projects_Widget() {
		$widget_ops = array('classname' => 'projects_widget', 'description' => __('Show your Projects on your site.','yunik'));
		parent::__construct(false, 'DESIGNARE _ Projects', $widget_ops);
	}
	function form($instance) {

		if (isset($instance['title'])){
			$title = esc_attr($instance['title']); 	
		} else $title = "";
		
		if (isset($instance['cubeid'])){
			$cubeid = esc_attr($instance['cubeid']); 	
		} else $cubeid = "";		
		
		if (isset($instance['autoplay'])){
			$autoplay = esc_attr($instance['autoplay']); 	
		} else $autoplay = "";

		if (isset($instance['desktops'])){
			$desktops = esc_attr($instance['desktops']); 	
		} else $desktops = "";
		
		if (isset($instance['tabs'])){
			$tabs = esc_attr($instance['tabs']); 	
		} else $tabs = "";
		
		if (isset($instance['mobiles'])){
			$mobiles = esc_attr($instance['mobiles']); 	
		} else $mobiles = "";
		
		if (isset($instance['hidearrows'])){
			$hidearrows = esc_attr($instance['hidearrows']); 	
		} else $hidearrows = "";
		
		if (isset($instance['hidenav'])){
			$hidenav = esc_attr($instance['hidenav']); 	
		} else $hidenav = "";
		
		?>  
                
       <p><label for="<?php echo $this->get_field_id('title'); ?>">&#8212; <?php _e('Title','yunik'); ?> &#8212;<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label></p> 
       
       <!-- NEW -->
       <p>
	        <label>&#8212; <?php _e('Cube Portfolio','yunik'); ?> &#8212;<br>
	        <?php
				global $wpdb, $table_prefix;
		        $sql = "SELECT id, name FROM ".$table_prefix."cubeportfolio WHERE active=1";
		        $cbps = $wpdb->get_results($sql);
				
				if (!empty($cbps)){
					?>
					<select id="<?php echo $this->get_field_id('cubeid'); ?>" name="<?php echo $this->get_field_name('cubeid'); ?>" style="margin-left:15px;">
					<?php
					foreach($cbps as $cbp){
						?>
						<option value="<?php echo $cbp->id; ?>" <?php if ($cubeid == $cbp->id) echo "selected"; ?>><?php echo $cbp->name; ?></option>
						<?php
			        }
			        ?>
					</select>
			        <?php
				} else {
					?>
					<p><?php _e("There are no cubeportolio instances.", "yunik"); ?></p>
					<?php
				}
	        ?>
	        </label>
	    </p>
       <!-- NEW -->

	   <p class="projects_autoplay_select"><label for="<?php echo $this->get_field_id('autoplay'); ?>">&#8212; <?php _e('Scroll Items Automatically','yunik'); ?> &nbsp;<input id="<?php echo $this->get_field_id('autoplay'); ?>" name="<?php echo $this->get_field_name('autoplay'); ?>" type="checkbox" value="autoplay" <?php if($autoplay == "autoplay") echo 'checked'; ?>/></label></p>
	   
	   <p class="projects_hidearrows_select"><label for="<?php echo $this->get_field_id('hidearrows'); ?>">&#8212; <?php _e('Hide Navigation Arrows','yunik'); ?> &nbsp;<input id="<?php echo $this->get_field_id('hidearrows'); ?>" name="<?php echo $this->get_field_name('hidearrows'); ?>" type="checkbox" value="hidearrows" <?php if($hidearrows == "hidearrows") echo 'checked'; ?> /></label></p>
		
		<p class="projects_hidenav_select"><label for="<?php echo $this->get_field_id('hidenav'); ?>">&#8212; <?php _e('Hide Navigation','yunik'); ?> &nbsp;<input id="<?php echo $this->get_field_id('hidenav'); ?>" name="<?php echo $this->get_field_name('hidenav'); ?>" type="checkbox" value="hidenav" <?php if($hidenav == "hidenav") echo 'checked'; ?> /></label></p>
	   
		<h4><?php _e("Define the number of items to show in each display","yunik"); ?></h4>
		<p><label for="<?php echo $this->get_field_id('desktops'); ?>">&#8212; <?php _e('Desktops','yunik'); ?> &#8212;<input class="widefat" id="<?php echo $this->get_field_id('desktops'); ?>" name="<?php echo $this->get_field_name('desktops'); ?>" type="text" value="<?php echo $desktops; ?>" /></label></p> 
		
		<p><label for="<?php echo $this->get_field_id('tabs'); ?>">&#8212; <?php _e('Tablets','yunik'); ?> &#8212;<input class="widefat" id="<?php echo $this->get_field_id('tabs'); ?>" name="<?php echo $this->get_field_name('tabs'); ?>" type="text" value="<?php echo $tabs; ?>" /></label></p> 

		<p><label for="<?php echo $this->get_field_id('mobiles'); ?>">&#8212; <?php _e('Mobiles','yunik'); ?> &#8212;<input class="widefat" id="<?php echo $this->get_field_id('mobiles'); ?>" name="<?php echo $this->get_field_name('mobiles'); ?>" type="text" value="<?php echo $mobiles; ?>" /></label></p> 
       		    
		<script type="text/javascript">
	        jQuery(document).ready(function($){$('#<?php echo $this->get_field_id('cubeid'); ?>').change(function(){$(this).find('option[selected]').removeAttr('selected');});});
        </script>
	<?php
	}
	
	function update($new_instance, $old_instance) {
	// processes widget options to be saved
		$instance = $old_instance;
	    $instance['title'] = $new_instance['title'];
	    $instance['cubeid'] = $new_instance['cubeid'];
	    $instance['autoplay'] = $new_instance['autoplay'];
	    $instance['desktops'] = $new_instance['desktops'];
	    $instance['tabs'] = $new_instance['tabs'];
	    $instance['mobiles'] = $new_instance['mobiles'];
   	    $instance['hidearrows'] = $new_instance['hidearrows'];
	    $instance['hidenav'] = $new_instance['hidenav'];

		return $instance;
	}
	
	function widget($args, $instance) {
		
		global $vc_addons_url;		
		wp_enqueue_style('cubeportfolio-jquery-css');
        wp_enqueue_script('cubeportfolio-jquery-js');
        wp_enqueue_media();
		
		extract($instance);
		$title = apply_filters('widget_title', $instance['title'], $instance);
		$cubeid = $instance['cubeid'] ? $instance['cubeid'] : -1;
		$autoplay = (isset($instance['autoplay'])) ? "yes" : "no";
		$desktops = $instance['desktops'] ? $instance['desktops'] : 1;
		$tabs = $instance['tabs'] ? $instance['tabs'] : 1;
		$mobiles = $instance['mobiles'] ? $instance['mobiles'] : 1;
   	    $hidearrows = (isset($instance['hidearrows'])) ? "yes" : false;
		$hidenav = (isset($instance['hidenav'])) ? "yes" : false;
		
		$getCube = do_shortcode('[cubeportfolio id="'.$cubeid.'"]');
		global $getCubeCSS;
		global $vc_addons_url;
		wp_enqueue_script('ult-slick');
		wp_enqueue_script('ultimate-appear');
		wp_enqueue_script('ult-slick-custom');
		wp_enqueue_style("ult-slick", $vc_addons_url."assets/min-css/slick.min.css");
		wp_enqueue_style("ult-icons", $vc_addons_url."assets/min-css/icons.min.css");
		wp_enqueue_style("ult-slick-animate", $vc_addons_url."assets/min-css/animate.min.css");
		
		?>
		<div class="des_cubeportfolio_widget_helper yunik_helper_div cubeid-<?php echo $cubeid; ?>"><?php echo $getCube; ?></div>
		<?php


		ob_start();
		echo '<div class="widget des_cubeportfolio_widget">';
			
			$title = apply_filters( 'widget_title', empty($instance['title']) ? '' : $instance['title'], $instance );
			if (isset($before_widget) && !empty($before_widget)) { echo $before_title;}
			if (!empty($title)) { echo "<h4>$title</h4><hr>"; }
			
			$uid = uniqid(rand());
			$uniqid = uniqid(rand());
			
			$getCubeCSS = des_get_string_between($getCube, '<style ', '</style>' );
			$getCubeCSS = str_replace("#cbpw-wrap".$cubeid, "#ult-carousel-".$uniqid, $getCubeCSS);
			$getCubeCSS = str_replace("#cbpw-grid".$cubeid, ".ult-carousel-".$uid, $getCubeCSS);

			echo '<div id="ult-carousel-'.$uniqid.'" class="ult-carousel-wrapper ult_horizontal" data-gutter="10"><div class="ult-carousel-'.$uid.'"></div></div>';
		echo '</div>';
		?>
		<script class="cubescroller" type="text/javascript">
			
			jQuery(document).ready(function(){
				jQuery('.des_cubeportfolio_widget_helper.cubeid-<?php echo $cubeid; ?> .cbp-item').each(function(e){
					var elem = jQuery(this);
					jQuery('.ult-carousel-<?php echo $uid; ?>').append('<div class="ult-item-wrap cbp" data-animation="animated no-animation"></div>');
					jQuery(this).clone(true,true).appendTo( jQuery('.ult-carousel-<?php echo $uid; ?> .ult-item-wrap').eq(e) );
				});
				
				var theid = jQuery('.ult-carousel-<?php echo $uid; ?>').closest('.des_cubeportfolio_widget').siblings('.des_cubeportfolio_widget_helper').children('div').attr('id');
		
/*
				var theclasses = jQuery('#cbpw-grid<?php echo $cubeid; ?>').attr('class').split(" ");
				var thecaptionclass = "";
				
				console.log(jQuery('#cbpw-grid<?php echo $cubeid; ?>'));
				console.log(theclasses);
				
				for (var i=0; i<theclasses.length; i++){
					if (theclasses[i].indexOf('cbp-caption') > -1) thecaptionclass = theclasses[i];
				}
				
				jQuery('#ult-carousel-<?php echo $uniqid; ?>').addClass(thecaptionclass);
*/
				
				if (jQuery('.ult-carousel-<?php echo $uid; ?>').closest('#big_footer').length){
					jQuery('.ult-carousel-<?php echo $uid; ?>').slick({<?php if (!$hidenav) echo "dots:true,"; ?><?php if($autoplay=='yes')echo'autoplay:true,autoplaySpeed:5000,';?>speed:300,infinite:true,<?php if (!$hidearrows) echo "arrows:true," ?>adaptiveHeight:true,<?php if (!$hidearrows){ ?>nextArrow:'<button type="button" style="color:#333333; font-size:24px;" class="slick-next default"><i class="ultsl-arrow-right6"></i></button>',prevArrow:'<button type="button" style="color:#333333; font-size:24px;" class="slick-prev default"><i class="ultsl-arrow-left6"></i></button>',<?php } ?>swipe:true,draggable:true,touchMove:true,slidesToScroll:<?php echo $desktops; ?>,slidesToShow:<?php echo $desktops; ?>,swipe:true,draggable:true,touchMove:true,responsive:[{breakpoint:1024,settings:{slidesToShow:<?php echo $desktops; ?>,slidesToScroll:<?php echo $desktops; ?>}},{breakpoint:767,settings:{slidesToShow:<?php echo $tabs; ?>,slidesToScroll:<?php echo $tabs; ?>}},{breakpoint:480,settings:{slidesToShow:<?php echo $mobiles; ?>,slidesToScroll:<?php echo $mobiles; ?>}},{breakpoint:0,settings:{slidesToShow:<?php echo $mobiles; ?>,slidesToScroll:<?php echo $mobiles; ?>}}],pauseOnHover:true,pauseOnDotsHover:true,mobileFirst:true,customPaging:function(slider,i){return'<i type="button" style="color:#333333;" class="ultsl-record" data-role="none"></i>';},}).on('beforeChange', function(event, slick, currentSlide, nextSlide){ jQuery(slick.$slides[nextSlide]).add(jQuery(slick.$slides[currentSlide]).next()).add(jQuery(slick.$slides[currentSlide]).prev()).css('height', jQuery(slick.$slides[nextSlide]).find('.cbp-caption-defaultWrap img').height()+"px"); });
					
					var rtime = new Date(1, 1, 2000, 12,00,00);
					var timeout = false;
					var delta = 200;
					jQuery(window).on('resize', function() {
					    rtime = new Date();
					    if (timeout === false) {
					        timeout = true;
					        setTimeout(function(){
						        jQuery('.ult-carousel-<?php echo $uid; ?>').slick('slickGoTo',0, false);
								jQuery('.ult-carousel-<?php echo $uid; ?> .cbp-item').each(function(){ 
									jQuery(this).height(jQuery(this).find('.cbp-caption-defaultWrap img').height()+"px"); 
									jQuery(this).find('a.cbp-singlePage').click(function(){
								        jQuery('.des_cubeportfolio_widget_helper.cubeid-<?php echo $cubeid; ?> .cbp-item').eq(jQuery(this).closest('.ult-item-wrap').data('slick-index')).find('a.cbp-singlePage').click(); 
							        });
							        jQuery(this).find('a.cbp-singlePageInline').click(function(){
								        jQuery('.des_cubeportfolio_widget_helper.cubeid-<?php echo $cubeid; ?> .cbp-item').eq(jQuery(this).closest('.ult-item-wrap').data('slick-index')).find('.cbp-singlePageInline').click(); 
							        });
								});
					        }, delta);
					    }
					});
					
					jQuery(window).on('load', function(){
						jQuery('.ult-carousel-<?php echo $uid; ?>').slick('slickGoTo',0, false);
						jQuery('.ult-carousel-<?php echo $uid; ?> .cbp-item').each(function(){  jQuery(this).height(jQuery(this).find('.cbp-caption-defaultWrap img').height()+"px"); });
					});
					
				} else {
					jQuery('.ult-carousel-<?php echo $uid; ?>').slick({<?php if (!$hidenav) echo "dots:true,"; ?><?php if($autoplay=='yes')echo'autoplay:true,autoplaySpeed:5000,';?>speed:300,infinite:true,<?php if (!$hidearrows) echo "arrows:true," ?>adaptiveHeight:true,<?php if (!$hidearrows){ ?>nextArrow:'<button type="button" style="color:#333333; font-size:24px;" class="slick-next default"><i class="ultsl-arrow-right6"></i></button>',prevArrow:'<button type="button" style="color:#333333; font-size:24px;" class="slick-prev default"><i class="ultsl-arrow-left6"></i></button>',<?php } ?>slidesToScroll:<?php echo $desktops; ?>,slidesToShow:<?php echo $desktops; ?>,swipe:true,draggable:true,touchMove:true,responsive:[{breakpoint:1024,settings:{slidesToShow:<?php echo $desktops; ?>,slidesToScroll:<?php echo $desktops; ?>}},{breakpoint:767,settings:{slidesToShow:<?php echo $tabs; ?>,slidesToScroll:<?php echo $tabs; ?>}},{breakpoint:480,settings:{slidesToShow:<?php echo $mobiles; ?>,slidesToScroll:<?php echo $mobiles; ?>}},{breakpoint:0,settings:{slidesToShow:<?php echo $mobiles; ?>,slidesToScroll:<?php echo $mobiles; ?>}}],pauseOnHover:true,pauseOnDotsHover:true,mobileFirst:true,customPaging:function(slider,i){return'<i type="button" style="color:#333333;" class="ultsl-record" data-role="none"></i>';},});
					
					jQuery('.ult-carousel-<?php echo $uid; ?> .cbp-item').each(function(){  jQuery(this).height(jQuery(this).find('.cbp-caption-defaultWrap img').height()+"px"); });
					
					var rtime = new Date(1, 1, 2000, 12,00,00);
					var timeout = false;
					var delta = 200;
					jQuery(window).on('resize', function() {
					    rtime = new Date();
					    if (timeout === false) {
					        timeout = true;
					        setTimeout(function(){
						        jQuery('.ult-carousel-<?php echo $uid; ?> .cbp-item').each(function(){ 
							        jQuery(this).height(jQuery(this).find('.cbp-caption-defaultWrap img').height()+"px"); 
							        jQuery(this).find('a.cbp-singlePage').click(function(){
								        jQuery('.des_cubeportfolio_widget_helper.cubeid-<?php echo $cubeid; ?> .cbp-item').eq(jQuery(this).closest('.ult-item-wrap').data('slick-index')).find('a.cbp-singlePage').click(); 
							        });
							        jQuery(this).find('a.cbp-singlePageInline').click(function(){
								        jQuery('.des_cubeportfolio_widget_helper.cubeid-<?php echo $cubeid; ?> .cbp-item').eq(jQuery(this).closest('.ult-item-wrap').data('slick-index')).find('.cbp-singlePageInline').click(); 
							        });
							    });
					        }, delta);
					    }
					});
					jQuery(window).on('load', function(){
						jQuery('.ult-carousel-<?php echo $uid; ?> .cbp-item').each(function(){  jQuery(this).height(jQuery(this).find('.cbp-caption-defaultWrap img').height()+"px"); });
					});
					
				}				
			});
			
			jQuery(window).load(function(){
				jQuery('#ult-carousel-<?php echo $uniqid; ?>').addClass(jQuery('#cbpw-wrap<?php echo $cubeid; ?> > .cbp').attr('class')).removeClass('cbp cbp-ratio-even').find('.cbp-item').css({'visibility':'visible','z-index':5});
			})

		</script>

		<style class="cubescroller" <?php echo $getCubeCSS; ?>
			.ult-carousel-<?php echo $uid; ?> .cbp-item{position:relative;float:left;width:100% !important;max-height:100%;top: 0px !important;}
			.ult-carousel-<?php echo $uid; ?> .cbp-caption-defaultWrap img, .ult-carousel-<?php echo $uid; ?> .cbp-item{opacity:1 !important;}
			#ult-carousel-<?php echo $uniqid; ?>.cbp-l-grid-fullScreen {visibility:visible;overflow:visible;}
			.ult-carousel-<?php echo $uid; ?> .slick-dots {top: 100%; bottom: 0 !important; margin-top: 10px !important;}
			.ult-carousel-<?php echo $uid; ?> button{opacity:0;transition:all .2s linear .5s;}
			.ult-carousel-<?php echo $uid; ?>:hover button{opacity:1;transition:all 0s linear 0s;}
			#ult-carousel-<?php echo $uniqid; ?> .slick-slide{margin:0px !important;}
		</style>
		<?php
		
		echo ob_get_clean();
		if (isset($after_widget) && !empty($after_widget)) echo $after_widget;
		
	}
}
register_widget('Projects_Widget');

?>
