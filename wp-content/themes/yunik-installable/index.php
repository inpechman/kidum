<?php
/**
 * @package WordPress
 * @subpackage Yunik
 */
	get_header();

		global $yunik_reading_option; $yunik_reading_option = get_option(DESIGNARE_SHORTNAME.'_blog_reading_type');
			
		global $yunik_more;
			$yunik_more = 0; 
	
		$menuLocations = get_nav_menu_locations();
		
		$menuID = 0;
		if (isset($menuLocations['PrimaryNavigation'])){
			$menuID = $menuLocations['PrimaryNavigation'];
		}
		$theMenus = wp_get_nav_menus($menuID);
		$theMenu = array();
		
		for ($idx = 0; $idx < count($theMenus); $idx++){
			if ($theMenus[$idx]->term_id == $menuID){
				$theMenu = $theMenus[$idx];
			}
		}
	
		global $isfirstpage;
		$isfirstpage = true;
		
		get_template_part('blog-template');
	
?>

<div class="clear"></div>
	
	
<?php get_footer(); ?>