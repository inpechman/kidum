<?php
function designare_styles(){

	 if (!is_admin()){
		 
	 	wp_enqueue_style('css1', DESIGNARE_CSS_PATH .'bootstrap.css');
		wp_enqueue_style('css16', DESIGNARE_CSS_PATH .'icons-font.css');
		wp_enqueue_style('css21', DESIGNARE_CSS_PATH .'component.css');
		
		if (strpos($_SERVER["HTTP_USER_AGENT"], 'MSIE')){
			wp_enqueue_style('IE', DESIGNARE_CSS_PATH .'IE.css');	
		}
		wp_enqueue_style('css12', get_template_directory_uri().'/editor-style.css');
		wp_enqueue_style('css24', DESIGNARE_CSS_PATH .'designare-woo-layout.css');
		wp_enqueue_style('css25', DESIGNARE_CSS_PATH .'designare-woocommerce.css');
		wp_enqueue_style('css15', DESIGNARE_CSS_PATH .'resize.css');
		wp_enqueue_style('css17', DESIGNARE_CSS_PATH .'mb.YTPlayer.css');
		wp_enqueue_style('css28', DESIGNARE_CSS_PATH .'retina.css');
	}
}
add_action('wp_enqueue_scripts', 'designare_styles', 11);
?>