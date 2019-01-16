<?php

class Team_Widget extends WP_Widget {
	function Team_Widget() {
		$widget_ops = array('classname' => 'team_widget', 'description' => __('Show your team on your site.','yunik'));
		parent::__construct(false, 'DESIGNARE _ Team', $widget_ops);
	}
function form($instance) {

		if (isset($instance['title'])){
			$title = esc_attr($instance['title']); 	
		} else $title = "";		

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
?>  
        
       <p><label for="<?php echo $this->get_field_id('title'); ?>">&#8212; <?php _e('Title','yunik'); ?> &#8212;<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label></p> 
       
       <p><label for="<?php echo $this->get_field_id('nshow'); ?>">&#8212; <?php _e('Number Team to show','yunik'); ?> &#8212;<input class="widefat" id="<?php echo $this->get_field_id('nshow'); ?>" name="<?php echo $this->get_field_name('nshow'); ?>" type="text" value="<?php echo $nshow; ?>" /><br><span class="flickr-stuff">If 0 will show all your team members.</span></label></p>
        <p><label for="<?php echo $this->get_field_id('categories'); ?>">&#8212; <?php _e('Categories','yunik'); ?> &#8212;<input style="display:none;" class="widefat" id="<?php echo $this->get_field_id('categories'); ?>" name="<?php echo $this->get_field_name('categories'); ?>" type="text" value="<?php echo $categories; ?>" /></label></p>
       <div class="widget-team-categories">
       <?php
	    $args = array(
			'type' => 'post',
			'orderby' => 'id',
			'order' => 'ASC',
			'taxonomy' => 'team_category',
			'hide_empty' => 0,
			'pad_counts' => false
		);
		
		$categories = get_categories($args);
		if (count($categories) > 0){
			foreach($categories as $cats){
				?>
				<label><input type="checkbox" name="<?php echo $cats->slug; ?>" value="<?php echo $cats->slug; ?>"><?php echo $cats->cat_name; ?></label>
				<?php
			}
		}
		else { ?> <i style="position:relative;top:-8px;margin-left:15px;"> <?php _e("No Categories defined.", "yunik"); ?></i> <?php }
       ?>
       </div>
	   
	   <p class="team_autoplay_select"><label for="<?php echo $this->get_field_id('autoplay'); ?>">&#8212; <?php _e('Scroll Items Automatically','yunik'); ?> &nbsp;<input id="<?php echo $this->get_field_id('autoplay'); ?>" name="<?php echo $this->get_field_name('autoplay'); ?>" type="checkbox" value="autoplay" <?php if($autoplay == "autoplay") echo 'checked'; ?>/></label></p>
	   
	   <p class="team_hidearrows_select"><label for="<?php echo $this->get_field_id('hidearrows'); ?>">&#8212; <?php _e('Hide Navigation Arrows','yunik'); ?> &nbsp;<input id="<?php echo $this->get_field_id('hidearrows'); ?>" name="<?php echo $this->get_field_name('hidearrows'); ?>" type="checkbox" value="hidearrows" <?php if($hidearrows == "hidearrows") echo 'checked'; ?> /></label></p>
		
		<p class="team_hidenav_select"><label for="<?php echo $this->get_field_id('hidenav'); ?>">&#8212; <?php _e('Hide Navigation','yunik'); ?> &nbsp;<input id="<?php echo $this->get_field_id('hidenav'); ?>" name="<?php echo $this->get_field_name('hidenav'); ?>" type="checkbox" value="hidenav" <?php if($hidenav == "hidenav") echo 'checked'; ?> /></label></p>
        
       <script type="text/javascript">
	        jQuery(document).ready(function($){
	        	$('.widget-team-categories').each(function(){
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
	    $instance['nshow'] = $new_instance['nshow'];
	    $instance['autoplay'] = $new_instance['autoplay'];
	    $instance['categories'] = $new_instance['categories'];
   	    $instance['hidearrows'] = $new_instance['hidearrows'];
	    $instance['hidenav'] = $new_instance['hidenav'];
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

		if(empty($nshow) || $nshow == 0 ) $nshow = -1;

		if (!function_exists('icl_object_id')){
		
			if ($categories != "all"){
		    	$cats = explode("|*|",$categories);
		    	$thecats = array();
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
				'post_type' => 'team',
				'post_status' => 'publish' 
			);
				
			$team = get_posts( $args );
			$filteredteam = array();
			
			if ($categories != "all"){
				foreach ($team as $t){
					$teamcats = get_the_terms($t->ID, 'team_category');
					$found = false;
					if (is_array($teamcats) && !empty($teamcats)){
						foreach ($teamcats as $ttcats){
							foreach ($thecats as $tc){
								if ($ttcats->slug == $tc) $found = true;	
							}
						}
						if ($found) {
							array_push($filteredteam, $t);
							$team = $filteredteam;
						}	
					}
				}			
			}
	
		} else {
			if ($categories != "all"){
		    	$cats = explode("|*|",$categories);
		    	$thecats = array();
		    	foreach($cats as $c){
		    		if ($c != ""){
		    			array_push($thecats, $c);
		    		}
		    	}
		    }
			global $wpdb, $table_prefix;
			if ($nshow != -1)
				$query = "SELECT element_id FROM ".$table_prefix."icl_translations WHERE language_code = '".ICL_LANGUAGE_CODE."' AND element_type='post_team' LIMIT 0,".$nshow;
			else
				$query = "SELECT element_id FROM ".$table_prefix."icl_translations WHERE language_code = '".ICL_LANGUAGE_CODE."' AND element_type='post_team'"; 
			$results = $wpdb->get_results($query, ARRAY_A);
			$team = array();
			foreach($results as $res){
				array_push($team, get_post( $res['element_id'] ));
			}
			$filteredteam = array();
			if ($categories != "all"){
				foreach ($team as $t){
					$teamcats = get_the_terms($t->ID, 'team_category');
					$found = false;
					if (!empty($teamcats)){
						foreach ($teamcats as $ttcats){
							foreach ($thecats as $tc){
								if ($ttcats->slug == $tc) $found = true;	
							}
						}
						if ($found) {
							array_push($filteredteam, $t);
							$team = $filteredteam;
						}	
					}
				}	
			}
		}

		echo '<div class="widget des_team_widget">';
		$title = apply_filters( 'widget_title', empty($instance['title']) ? '' : $instance['title'], $instance );
		if (isset($before_widget) && !empty($before_widget)) { echo $before_title;}
		if (!empty($title)) { echo "<h4>$title</h4><hr>"; }
		
		ob_start();
		$uid = uniqid(rand());
		$uniqid = uniqid(rand());
		echo '<div id="ult-carousel-'.$uniqid.'" class="ult-carousel-wrapper ult_horizontal" data-gutter="10">';
			echo '<div class="ult-carousel-'.$uid.'">';
			ultimate_override_shortcodes(10, 'no-animation');
			
			static $des_team_index = 1;
			$des_team_index_aux = 1;

			foreach ($team as $t){
				
				echo '<div class="ult-item-wrap" data-animation="animated no-animation">';
				
				$output = "";
				$output .= '<a data-toggle="modal" href="#member'.$des_team_index.'-'.$des_team_index_aux.'" class="modal-popup-link team-profile profile-id-'.$t->ID.'"><img src="'; 
				$image = wp_get_attachment_image_src( get_post_thumbnail_id( $t->ID ), 'single-post-thumbnail' );
				$output .= $image[0];
				$output .= '" alt="'.$t->post_title.'" class="animated fadeInUp" style="opacity: 1;" /><div class="tooltip-desc"><div class="tooltip-content"><p><strong>'.$t->post_title.'</strong></p></div></div></a>';
				$des_team_index_aux++;
				echo $output;
				
				echo '</div>';
			}
			//$output .= '</div>';
			ultimate_restore_shortcodes();
			echo '</div>';
		echo '</div>';
		
		echo '</div>';
		
		$des_team_index_aux = 1;
			
		?>
		<script type="text/javascript">
			jQuery('.ult-carousel-<?php echo $uid; ?>').slick({<?php if (!$hidenav) echo "dots:true,"; ?><?php if($autoplay=='yes')echo'autoplay:true,autoplaySpeed:5000,';?>speed:300,infinite:true,<?php if (!$hidearrows) echo "arrows:true," ?>adaptiveHeight:true,<?php if (!$hidearrows){ ?>nextArrow:'<button type="button" style="color:#333333; font-size:24px;" class="slick-next default"><i class="ultsl-arrow-right6"></i></button>',prevArrow:'<button type="button" style="color:#333333; font-size:24px;" class="slick-prev default"><i class="ultsl-arrow-left6"></i></button>',<?php } ?>slidesToScroll:1,slidesToShow:1,swipe:true,draggable:true,touchMove:true,responsive:[{breakpoint:1024,settings:{slidesToShow:1,slidesToScroll:1,}},{breakpoint:768,settings:{slidesToShow:1,slidesToScroll:1}},{breakpoint:480,settings:{slidesToShow:1,slidesToScroll:1}}],pauseOnHover:true,pauseOnDotsHover:true,customPaging:function(slider,i){return'<i type="button" style="color:#333333;" class="ultsl-record" data-role="none"></i>';},});
		</script>
		
		<style type="text/css">
			.ult-carousel-<?php echo $uid; ?> button{opacity:0;transition:all .2s linear .5s;}
			.ult-carousel-<?php echo $uid; ?>:hover button{opacity:1;transition:all 0s linear 0s;}
		</style>
		
		<?php
			
		foreach ($team as $t){
			echo '<div id="member'.$des_team_index.'-'.$des_team_index_aux.'" class="modal team_member_profile_content"><div class="container">'.do_shortcode($t->post_content).'</div></div>';
			$des_team_index_aux++;
		}
		echo ob_get_clean();
		if (isset($after_widget) && !empty($after_widget)) echo $after_widget;
		$des_team_index++;
		
	}
}
register_widget('Team_Widget');

?>
