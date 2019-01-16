<?php

class VCElement_Widget extends WP_Widget {
	function VCElement_Widget() {
		$widget_ops = array('classname' => 'vcelement_widget', 'description' => __('Paste code generated with Visual Composer.', 'yunik'));
		parent::__construct(false, 'DESIGNARE _ Visual Composer', $widget_ops);
	}
	
	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'text' => '' ) );
		$title = strip_tags($instance['title']);
		$text = format_to_edit($instance['text']);
	?>
		<p><?php _e("You can use this widget to paste code that has been generated with Visual Composer. ","yunik"); ?></p>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'yunik'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>
	
		<textarea class="widefat" rows="16" cols="20" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>"><?php echo $text; ?></textarea>
	
		<p><input id="<?php echo $this->get_field_id('filter'); ?>" name="<?php echo $this->get_field_name('filter'); ?>" type="checkbox" <?php checked(isset($instance['filter']) ? $instance['filter'] : 0); ?> />&nbsp;<label for="<?php echo $this->get_field_id('filter'); ?>"><?php _e('Automatically add paragraphs.', 'yunik'); ?></label></p>  
		<?php
	}
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		if ( current_user_can('unfiltered_html') )
			$instance['text'] =  $new_instance['text'];
		else
			$instance['text'] = stripslashes( wp_filter_post_kses( $new_instance['text'] ) );
		$instance['filter'] = isset($new_instance['filter']);
		return $instance;
	}
		
	function widget($args, $instance) {
		extract($args);
		$title = apply_filters( 'widget_title', empty($instance['title']) ? '' : $instance['title'], $instance );
		if (isset($before_widget) && !empty($before_widget)) { echo $before_title;}
		if (!empty($title)) { echo "<h4>$title</h4><hr>"; }
		des_content_shortcoder($instance['text']);
		?>
		<div class="des_widget_vc_element"><?php echo $instance['filter'] ? do_shortcode(wpautop($instance['text'])) : do_shortcode($instance['text']); ?></div>
		<?php
		echo $after_widget;
	}
}
register_widget('VCElement_Widget');

?>
