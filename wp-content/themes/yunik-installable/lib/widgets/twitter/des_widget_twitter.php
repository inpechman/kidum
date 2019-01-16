<?php

class Twitter_Widget extends WP_Widget {
	function Twitter_Widget() {
		$widget_ops = array('classname' => 'twitter_widget', 'description' => __('Show your tweets on your site.', 'yunik'));
		parent::__construct(false, 'DESIGNARE _ Twitter', $widget_ops);
	}
function form($instance) {

		if (isset($instance['title'])){
			$title = esc_attr($instance['title']); 	
		} else $title = "";
		
		if (isset($instance['twitteruser'])){
			$twitteruser = esc_attr($instance['twitteruser']);  	
		} else $twitteruser = "";
		
		if (isset($instance['ntweets'])){
			$ntweets = esc_attr($instance['ntweets']); 	
		} else $ntweets = "";
		
?>  
        
       <p><label for="<?php echo $this->get_field_id('title'); ?>">&#8212; <?php _e('Title','yunik'); ?> &#8212;<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label></p> 
       <p><label for="<?php echo $this->get_field_id('ntweets'); ?>">&#8212; <?php _e('Number Tweets to show','yunik'); ?> &#8212;<input class="widefat" id="<?php echo $this->get_field_id('ntweets'); ?>" name="<?php echo $this->get_field_name('ntweets'); ?>" type="text" value="<?php echo $ntweets; ?>" /><br><span class="flickr-stuff">If 0 will show the last tweet.</span></label></p>
        
<?php
	}
	
function update($new_instance, $old_instance) {
	// processes widget options to be saved
	$instance = $old_instance;
    $instance['title'] = $new_instance['title'];
    $instance['ntweets'] = $new_instance['ntweets'];
	return $instance;
}
	
function widget($args, $instance) {
		
	extract($args);
    $title = apply_filters('widget_title', $instance['title'], $instance);
    $ntweets = $instance['ntweets'];
    if ($ntweets == "") $ntweets = 1;
    $twitter_data_is_filled = true;
	if ( (get_option(DESIGNARE_SHORTNAME."_twitter_username") == "") || (get_option("twitter_consumer_key") == "") || (get_option("twitter_consumer_secret") == "") || (get_option("twitter_user_token") == "") || (get_option("twitter_user_secret") == "") || (get_option(DESIGNARE_SHORTNAME."_twitter_number_tweets") == "") ){
		$twitter_data_is_filled = false;
	}
    if ($twitter_data_is_filled) wp_enqueue_script( 'tweet', DESIGNARE_JS_PATH .'twitter/jquery.tweet.js', array(),'1.0',$in_footer = true);
    ?>
    
    <div class="twitter_container widget">
	    
	    <?php if ( !empty( $title ) ) { echo $before_title . $title . $after_title; } ?>
	    
			<div id="twitter_update_list">
			 <?php
				 if ($twitter_data_is_filled){
					 ?>
					 <script type="text/javascript">
						jQuery(document).ready(function(){
							jQuery('#twitter_update_list').destweet({
								modpath: jQuery('#templatepath').html()+'/js/twitter/index.php',
						        username: "<?php echo get_option(DESIGNARE_SHORTNAME . "_twitter_username"); ?>",
						        page: 1,
						        avatar_size: 0,
					            count: <?php echo $ntweets; ?>
						    });
						});
					</script>
					 <?php
				 } else {
					 ?>
					 <p>Please fill the fields on the <strong>Appearance > Yunik Options > Twitter and Social Icons > Twitter</strong> panel with your credentials.</p>
					 <?php
				 }
			 ?>
			</div>
		</div>
    
    <?php
  
    echo $after_widget;
	}
}
register_widget('Twitter_Widget');

?>
