<?php

class Newsletter_Widget extends WP_Widget {
	function Newsletter_Widget() {
		$widget_ops = array('classname' => 'newsletter_widget', 'description' => __('Subscribe the Newsletter.', 'yunik'));
		parent::__construct(false, 'DESIGNARE _ Newsletter', $widget_ops);
	}
function form($instance) {	

	if (isset($instance['title'])){
		$title = esc_attr($instance['title']); 
	} else $title = "";
	
?>  
       <p><label for="<?php echo $this->get_field_id('title'); ?>">&#8212; <?php _e('Title', 'yunik'); ?> &#8212;<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label></p> 
       <p>This widget will display the subscription form to the newsletter with the information you inserted on the <strong>Appearance</strong> > <strong>Yunik Options</strong> > <strong>Newsletter</strong>.</p>
        
<?php
	}
function update($new_instance, $old_instance) {
	// processes widget options to be saved
	$instance = $old_instance;
    $instance['title'] = $new_instance['title'];
		return $instance;
	}
	
function widget($args, $instance) {
		
	extract($args);
    $title = $instance['title'];
    echo $before_widget;
   
    ?> 
    <div class="widget widget-newsletter">
	    <?php if (!empty($title)) { echo "<h4>$title</h4><hr>"; } ?>
	    <div class="mail-box">
			<div class="mail-news">
				<div class="news-l">
					<div class="banner">
						<h3><?php echo get_option(DESIGNARE_SHORTNAME."_newsletter_text"); ?></h3>
						<p><?php echo stripslashes(get_option(DESIGNARE_SHORTNAME."_newsletter_stext")); ?></p>
					</div>
					<div class="form">
						<?php
							$code = str_replace('&', '&amp;', get_option(DESIGNARE_SHORTNAME."_mailchimp_code"));
							echo stripslashes($code);
						?>
					</div>
				</div>
			</div>
		</div>
    </div>
    <?php
    echo $after_widget;
	}
}
register_widget('Newsletter_Widget');

?>
