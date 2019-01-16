<?php

class Partners_Widget extends WP_Widget {
	function Partners_Widget() {
		$widget_ops = array('classname' => 'partners_widget', 'description' => __('Show your partners on your site.','yunik'));
		parent::__construct(false, 'DESIGNARE _ Partners', $widget_ops);
	}
function form($instance) {

		if (isset($instance['title'])){
			$title = esc_attr($instance['title']); 	
		} else $title = "";

		if (isset($instance['effect'])){
			$effect = esc_attr($instance['effect']); 	
		} else $effect = "";		
		
		if (isset($instance['categories'])){
			$categories = esc_attr($instance['categories']); 	
		} else $categories = "";
		
		if (isset($instance['nshow'])){
			$nshow = esc_attr($instance['nshow']);  	
		} else $nshow = "";
		
		if (isset($instance['autoplay'])){
			$autoplay = esc_attr($instance['autoplay']); 	
		} else $autoplay = "";
		
		if (isset($instance['hidearrows'])){
			$hidearrows = esc_attr($instance['hidearrows']); 	
		} else $hidearrows = "";
		
		if (isset($instance['hidenav'])){
			$hidenav = esc_attr($instance['hidenav']); 	
		} else $hidenav = "";
		
		if (isset($instance['tooltip'])){
			$tooltip = esc_attr($instance['tooltip']); 	
		} else $tooltip = "";
		
?>  
        
       <p><label for="<?php echo $this->get_field_id('title'); ?>">&#8212; <?php _e('Title','yunik'); ?> &#8212;<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label></p> 
       
       <p>
	        <label>&#8212; <?php _e('Partners Effect','yunik'); ?> &#8212;<br>
	        <select id="<?php echo $this->get_field_id('effect'); ?>" name="<?php echo $this->get_field_name('effect'); ?>" style="margin-left:15px;">
		        <option value='opacity' <?php if ($effect == "opacity") echo "selected"; ?>>Opacity</option>
		        <option value='greyscale' <?php if ($effect == "greyscale") echo "selected"; ?>>Greyscale</option>
	        </select>
	        </label>
	    </p>
       
        <p><label for="<?php echo $this->get_field_id('tooltip'); ?>">&#8212; <?php _e('Display Tooltip','yunik'); ?> &nbsp;<input id="<?php echo $this->get_field_id('tooltip'); ?>" name="<?php echo $this->get_field_name('tooltip'); ?>" type="checkbox" value="tooltip" <?php if($tooltip == "tooltip") echo 'checked'; ?> /></label></p>
       
       <p><label for="<?php echo $this->get_field_id('nshow'); ?>">&#8212; <?php _e('Number Partners to show','yunik'); ?> &#8212;<input class="widefat" id="<?php echo $this->get_field_id('nshow'); ?>" name="<?php echo $this->get_field_name('nshow'); ?>" type="text" value="<?php echo $nshow; ?>" /><br><span class="flickr-stuff">If 0 will show all partners.</span></label></p>
       
       <p><label for="<?php echo $this->get_field_id('categories'); ?>">&#8212; <?php _e('Categories','yunik'); ?> &#8212;<input style="display:none;" class="widefat" id="<?php echo $this->get_field_id('categories'); ?>" name="<?php echo $this->get_field_name('categories'); ?>" type="text" value="<?php echo $categories; ?>" /></label></p>
       <div class="widget-partners-categories">
       <?php
	    $args = array(
			'type' => 'post',
			'orderby' => 'id',
			'order' => 'ASC',
			'taxonomy' => 'partners_category',
			'hide_empty' => 0,
			'pad_counts' => false
		);
		
		$categories = get_categories($args);
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
       
       <p class="partners_autoplay_select"><label for="<?php echo $this->get_field_id('autoplay'); ?>">&#8212; <?php _e('Scroll Items Automatically','yunik'); ?> &nbsp;<input id="<?php echo $this->get_field_id('autoplay'); ?>" name="<?php echo $this->get_field_name('autoplay'); ?>" type="checkbox" value="autoplay" <?php if($autoplay == "autoplay") echo 'checked'; ?> /></label></p>
        
        <p class="partners_hidearrows_select"><label for="<?php echo $this->get_field_id('hidearrows'); ?>">&#8212; <?php _e('Hide Navigation Arrows','yunik'); ?> &nbsp;<input id="<?php echo $this->get_field_id('hidearrows'); ?>" name="<?php echo $this->get_field_name('hidearrows'); ?>" type="checkbox" value="hidearrows" <?php if($hidearrows == "hidearrows") echo 'checked'; ?> /></label></p>
		
		<p class="partners_hidenav_select"><label for="<?php echo $this->get_field_id('hidenav'); ?>">&#8212; <?php _e('Hide Navigation','yunik'); ?> &nbsp;<input id="<?php echo $this->get_field_id('hidenav'); ?>" name="<?php echo $this->get_field_name('hidenav'); ?>" type="checkbox" value="hidenav" <?php if($hidenav == "hidenav") echo 'checked'; ?> /></label></p>
        
       <script type="text/javascript">
	        jQuery(document).ready(function($){
	        	$('.widget-partners-categories').each(function(){
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
	    $instance['effect'] = $new_instance['effect'];
	    $instance['nshow'] = $new_instance['nshow'];
	    $instance['autoplay'] = $new_instance['autoplay'];
	    $instance['categories'] = $new_instance['categories'];
	    $instance['hidearrows'] = $new_instance['hidearrows'];
	    $instance['hidenav'] = $new_instance['hidenav'];
	    $instance['tooltip'] = $new_instance['tooltip'];
		return $instance;
	}
	
	function widget($args, $instance) {
		
		global $vc_addons_url;		
		wp_enqueue_script('ult-slick');
		wp_enqueue_script('ultimate-appear');
		wp_enqueue_script('ult-slick-custom');
		wp_enqueue_style("ult-slick", $vc_addons_url."assets/min-css/slick.min.css");
		wp_enqueue_style("ult-icons", $vc_addons_url."assets/min-css/icons.min.css");
		wp_enqueue_style("ult-slick-animate", $vc_addons_url."assets/min-css/animate.min.css");
		
		extract($instance);	
		$title = apply_filters('widget_title', $instance['title'], $instance);
	    $autoplay = (isset($instance['autoplay'])) ? "yes" : "no";
	    $hidearrows = (isset($instance['hidearrows'])) ? "yes" : false;
		$hidenav = (isset($instance['hidenav'])) ? "yes" : false;
		if (empty($nshow) || $nshow == 0 ) $nshow = -1;
	    
	    
	    $thecats = array();
		if ($categories != "all"){
	    	$cats = explode("|*|",$categories);
	    	foreach($cats as $c){
	    		if ($c != ""){
	    			array_push($thecats, $c);
	    		}
	    	}
	    }
		$args = array(
			'numberposts' => $nshow,
			'orderby' => 'post_date',
			'order' => 'DESC',
			'post_type' => 'partners',
			'post_status' => 'publish' 
		);
		$partners = get_posts( $args );	
		$filteredpartners = array();
		if ($categories != "all"){
			foreach ($partners as $p){
				$partnerscats = get_the_terms($p->ID, 'partners_category');
				$found = false;
				if (!empty($partnerscats)){
					foreach ($partnerscats as $pcats){
						foreach ($thecats as $pc){
							if ($pcats->slug == $pc) $found = true;	
						}
					}
					if ($found) {
						array_push($filteredpartners, $p);
						$partners = $filteredpartners;
					}
				}
			}			
		}
		
		$tooltip = ($tooltip == "tooltip") ? "withtooltip" : "";
	    
	    global $vc_addons_url;
	    wp_enqueue_script('ult-slick');
		wp_enqueue_script('ultimate-appear');
		wp_enqueue_script('ult-slick-custom');
		wp_enqueue_style("ult-slick", $vc_addons_url."assets/min-css/slick.min.css");
		wp_enqueue_style("ult-icons", $vc_addons_url."assets/min-css/icons.min.css");
		wp_enqueue_style("ult-slick-animate", $vc_addons_url."assets/min-css/animate.min.css");
	    
	    echo '<div class="widget des_partners_widget '.$tooltip.'">';
		$title = apply_filters( 'widget_title', empty($instance['title']) ? '' : $instance['title'], $instance );
		if (isset($before_widget) && !empty($before_widget)) { echo $before_title;}
		if (!empty($title)) { echo "<h4>$title</h4><hr>"; }
		
		ob_start();
		$uid = uniqid(rand());
		$uniqid = uniqid(rand());
		echo '<div id="ult-carousel-'.$uniqid.'" class="ult-carousel-wrapper ult_horizontal" data-gutter="10">';
			echo '<div class="ult-carousel-'.$uid.'">';
			ultimate_override_shortcodes(10, 'no-animation');
			foreach ($partners as $post){
				echo '<div class="ult-item-wrap" data-animation="animated no-animation">';
				$output = "";
				$output .= "<a target='_blank' href='";
				if (get_post_meta($post->ID, 'link_value', true) != ""){
					$output .= get_post_meta($post->ID, 'link_value', true);
				} else $output .= "javascript:;";
				$output .= "' title='".$post->post_title."'><img class='logopartner' src='".wp_get_attachment_url( get_post_thumbnail_id($post->ID))."' alt='".$post->post_title."' title='".$post->post_title."'/></a>";
				echo $output;				
				echo '</div>';
			}
			ultimate_restore_shortcodes();
			echo '</div>';
		echo '</div>';
		?>
		<script type="text/javascript">
			jQuery(document).ready(function(){
				jQuery('.ult-carousel-<?php echo $uid; ?>').slick({<?php if (!$hidenav) echo "dots:true,"; ?><?php if($autoplay=='yes')echo'autoplay:true,autoplaySpeed:5000,';?>speed:300,infinite:true,<?php if (!$hidearrows) echo "arrows:true," ?>adaptiveHeight:true,<?php if (!$hidearrows){ ?>nextArrow:'<button type="button" style="color:#333333; font-size:24px;" class="slick-next default"><i class="ultsl-arrow-right6"></i></button>',prevArrow:'<button type="button" style="color:#333333; font-size:24px;" class="slick-prev default"><i class="ultsl-arrow-left6"></i></button>',<?php } ?>slidesToScroll:1,slidesToShow:1,swipe:true,draggable:true,touchMove:true,responsive:[{breakpoint:1024,settings:{slidesToShow:1,slidesToScroll:1,}},{breakpoint:768,settings:{slidesToShow:1,slidesToScroll:1}},{breakpoint:480,settings:{slidesToShow:1,slidesToScroll:1}}],pauseOnHover:true,pauseOnDotsHover:true,customPaging:function(slider,i){return'<i type="button" style="color:#333333;" class="ultsl-record" data-role="none"></i>';},});				
			});
			<?php
				if ($effect == 'greyscale'){
					?>
jQuery(window).load(function(){jQuery('#ult-carousel-<?php echo $uniqid; ?>').find('.logopartner').each(function(){jQuery(this).greyScale({fadeTime:500,reverse:false});});});
					<?php
				}
			
				if ($tooltip == 'withtooltip'){
					?>
					jQuery(document).ready(function(){ jQuery('.ult-carousel-<?php echo $uid; ?> .ult-item-wrap > a').tooltip(); });
					<?php
				}
			?>
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
register_widget('Partners_Widget');

?>
