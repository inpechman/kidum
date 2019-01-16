<?php
/**
 * This file contains all the functionality for the additional meta boxes for the pages and posts.
 * It contains functions for loading the meta data into arrays, displaying the meta boxes and
 * saving the meta data.
 *
 */

/**
 * ADD THE ACTIONS
 */
add_action('admin_menu', 'designare_load_meta_boxes');
add_action('admin_menu', 'create_meta_box');  
add_action('admin_menu', 'create_meta_post_box');  
add_action('admin_menu', 'create_meta_portfolio_box'); 
add_action('admin_menu', 'create_meta_testimonials_box');  
add_action('admin_menu', 'create_meta_partners_box');
add_action('admin_menu', 'create_meta_team_box');
add_action('save_post', 'save_postdata');  
add_action('save_post', 'save_post_postdata');  
add_action('save_post', 'save_portfolio_postdata'); 
add_action('save_post', 'save_testimonials_postdata');
add_action('save_post', 'save_partners_postdata');
add_action('save_post', 'save_team_postdata');
add_action('admin_footer','print_helper');

if (!defined('DESIGNARE_PORTFOLIO_POST_TYPE')){
	if (!defined('DESIGNARE_SHORTNAME')) define('DESIGNARE_SHORTNAME', 'yunik');
	$portfolio_permalink = get_option(DESIGNARE_SHORTNAME."_portfolio_permalink");
	if (!get_option(DESIGNARE_SHORTNAME."_portfolio_permalink")) define("DESIGNARE_PORTFOLIO_POST_TYPE", "portfolio");
	else define("DESIGNARE_PORTFOLIO_POST_TYPE", get_option(DESIGNARE_SHORTNAME."_portfolio_permalink"));
}
if (!defined('DESIGNARE_TESTIMONIALS_POST_TYPE')){
	define("DESIGNARE_TESTIMONIALS_POST_TYPE", 'testimonials');
}
if (!defined('DESIGNARE_PARTNERS_POST_TYPE')){
	define("DESIGNARE_PARTNERS_POST_TYPE", 'partners');
}
if (!defined('DESIGNARE_TEAM_POST_TYPE')){
	define("DESIGNARE_TEAM_POST_TYPE", 'team');	
}

if (isset($_REQUEST['file'])) { 
    //check_admin_referer("des_gallery_options");
    $options = get_option('des_gallery_options', TRUE);
	$options['default_image'] = absint($_REQUEST['file']) ? absint($_REQUEST['file']) : "";
    update_option('des_gallery_options', $options);
}

function get_des_templates($type){
	global $wpdb, $table_prefix;
	$q = "SELECT * from ".$wpdb->prefix."options WHERE option_name LIKE 'des_template_[$type]_%'";
	$res = $wpdb->get_results($q, ARRAY_A);
	$output = array();
	foreach($res as $r){
		$options = $r['option_value'];
		while( gettype($options) === "string" ){
			$options = unserialize(trim($options));
		}
		$options = $options['des_template_tab'];
		array_push($output, array("id"=>$options['name'], "name"=>$options['nicename']));
	}
	return $output;
}

function designare_load_meta_boxes(){
	//load the porftfolio categeories
	$sidebar_taxonomies=designare_get_custom_sidebars();
	$sidebar_categories=array(array('id'=>'none', 'name'=>'No Sidebar'), array('id'=>'sidebar-widgets', 'name'=>'Default Sidebar'));

	$sides = get_option('des_sidebar_name_names');
	if (is_string($sides)) $sides = explode(DESIGNARE_SEPARATOR, $sides);
	$outputsidebars = array(array("id"=>"defaultblogsidebar", "name" => "Blog Sidebar"));
	if (!empty($sides)){
		foreach ($sides as $s){
			if ($s != ""){
				array_push($outputsidebars, array("id"=>$s, "name"=>$s));
			}
		}	
	}
	if (!count($outputsidebars)) array_push($outputsidebars, array("id"=>"", "name"=>"No Sidebars Found."));
	
	foreach($sidebar_taxonomies as $taxonomy){
		$sidebar_categories[]=array("name"=>$taxonomy, "id"=>convert_to_class($taxonomy));
	}
	
	//load the porftfolio categeories
	$portf_categories=array(array('id'=>'all', 'name'=>'All Portfolios'));
	if (function_exists('designare_get_taxonomies')){
		$portf_taxonomies=designare_get_taxonomies('portfolio_type');
		foreach($portf_taxonomies as $taxonomy){
			$portf_categories[]=array("name"=>$taxonomy->name, "id"=>$taxonomy->slug);
		}		
	}
	
	//patterns
	$patterns=array();
	$patterns[0]=array('id'=>'none','name'=>'none');
	for($i=1; $i<=54; $i++){
		$patterns[]=array('id'=>'pattern'.$i, 'name'=>'pattern'.$i.'.jpg');
	}
	
	//post filtration
	global $wpdb;
	//post categories
	$post_categories_query = "SELECT term_taxonomy_id from {$wpdb->prefix}term_taxonomy WHERE taxonomy LIKE 'category'";
	$post_categories = $wpdb->get_results($post_categories_query, ARRAY_A);
	$post_categories_output = array();
	if (count($post_categories) > 0){	
		foreach ($post_categories as $pcat){
			$post_taxonomy_name_query = "SELECT name from {$wpdb->prefix}terms WHERE term_id = ".$pcat['term_taxonomy_id'];
			$post_taxonomy_name = $wpdb->get_results($post_taxonomy_name_query, ARRAY_A);
			if (!empty($post_taxonomy_name)){
				$aux = array("id" => (string)$pcat['term_taxonomy_id'], "name" => (string)$post_taxonomy_name[0]['name']);
				array_push($post_categories_output, $aux);
			}
		}
	}
	//post tags
	$post_tags_query = "SELECT term_taxonomy_id from {$wpdb->prefix}term_taxonomy WHERE taxonomy LIKE 'post_tag'";
	$post_tags = $wpdb->get_results($post_tags_query, ARRAY_A);
	$post_tags_output = array();
	if (count($post_tags) > 0){	
		foreach ($post_tags as $ptag){
			$post_taxonomy_name_query = "SELECT name from {$wpdb->prefix}terms WHERE term_id = ".$ptag['term_taxonomy_id'];
			$post_taxonomy_name = $wpdb->get_results($post_taxonomy_name_query, ARRAY_A);
			if (!empty($post_taxonomy_name)){
				$aux = array("id" => (string)$ptag['term_taxonomy_id'], "name" => (string)$post_taxonomy_name[0]['name']);
				array_push($post_tags_output, $aux);
			}
		}
	}
	//authors
	$post_authors = get_users('orderby=post_count&order=DESC');
	$usrs = array();
	foreach ($post_authors as $pauth){
		if (!in_array('subscriber', $pauth->roles)){
			$usrs[] = array("id" => $pauth->data->ID, "name" => $pauth->data->user_nicename);
		}
	}
	$post_authors = $usrs;

	global $designare_data, $designare_new_meta_boxes, $designare_new_meta_portfolio_boxes, $new_meta_testimonials_boxes, $designare_new_meta_post_boxes, $new_meta_partners_boxes, $new_meta_team_boxes;
	
		/* ------------------------------------------------------------------------*
		 * META BOXES FOR THE PAGES
		 * ------------------------------------------------------------------------*/
	
	
		 if (get_option(DESIGNARE_SHORTNAME."_body_type") == "pattern") $varType = DESIGNARE_PATTERNS_URL.get_option(DESIGNARE_SHORTNAME."_body_pattern");
		 else $varType =  get_option(DESIGNARE_SHORTNAME."_header_body_pattern");
	
		//the meta data for pages
		$designare_new_meta_boxes =
		array(
		
		
		array(
			"title" => '<div class="ui-icon ui-icon-image no_show_hide_opts"></div>Blog Filter Options',
			"type" => "heading",
			"name" => "blogoptions"
		),
		
		array(
			"title" => '<p>Here you can narrow the Posts listing by choosing specific categories, tags or authors. If you want to select all of your posts as per usual deselect all the checkboxes. Either way, the ordering options will be applied.</p>',
			"type" => "heading_unformatted",
		),
		
		array(
			"title" => '<h4>Categories</h4>',
			"type" => "heading",
			"name" => "",
			"std" => "",
			"description" => ""
		),
		
		array(
			"title" => "",
			"type" => "multicheck",
			"name" => "posts_filter_categories",
			"options" => $post_categories_output
		),
		
		array(
			"title" => "Add Category Filter (Only for Masonry Template)",
			"type" => "select",
			"name" => "posts_add_category_filter",
			"options" => array(array("id"=>"yes","name"=>"Yes, please."), array("id"=>"no", "name"=>"No, thanks.")),
			"std" => "no"
		),
		
		array(
			"title" => "Add Counter on Filters (Only for Masonry Template)",
			"type" => "select",
			"name" => "posts_add_category_filter_counter",
			"options" => array(array("id"=>"yes","name"=>"Yes, please."), array("id"=>"no", "name"=>"No, thanks.")),
			"std" => "yes"
		),

		array(
			"title" => '<h4>Tags</h4>',
			"type" => "heading",
			"name" => "",
			"std" => "",
			"description" => ""
		),

		array(
			"title" => "",
			"type" => "multicheck",
			"name" => "posts_filter_tags",
			"options" => $post_tags_output
		),

		array(
			"title" => '<h4>Author</h4>',
			"type" => "heading",
			"name" => "",
			"std" => "",
			"description" => ""
		),

		array(
			"title" => "",
			"type" => "multicheck",
			"name" => "posts_filter_authors",
			"options" => $post_authors
		),

		array(
			"title" => '<h4>Order by</h4>',
			"type" => "heading",
			"name" => "",
			"std" => "",
			"description" => ""
		),
		
		array(
			"title" => 'Order by',
			"type" => "select",
			"name" => "posts_filter_orderby",
			"options" => array( array("id"=>"ID", "name"=>"ID"), array("id"=>"author", "name"=>"Author"), array("id"=>"title", "name"=>"Title"), array("id"=>"date","name"=>"Date"), array("id"=>"modified","name"=>"Modified"), array("id"=>"parent", "name"=>"Parent"), array("id"=>"rand","name"=>"Random"), array("id"=>"comment_count", "name"=>"Number of comments") ),
			"std" => "date"
		),

		array(
			"title" => '<h4>Order</h4>',
			"type" => "heading",
			"name" => "",
			"std" => "",
			"description" => ""
		),

		array(
			"title" => "Order",
			"name" => "posts_filter_order",
			"type" => "select",
			"options" => array(array("id"=>"desc","name"=>"Descendent"), array("id"=>"asc","name"=>"Ascendent")),
			"std" => "desc"
		),
		
		
		array(
			"title" => '<div class="ui-icon ui-icon-image no_show_hide_opts"></div>Page Title Options',
			"type" => "heading",
			"name" => "pagetitleoptions",
			"std" => "",
			"description" => ""
		),
		
		array(
			"title" => "Secondary Title",
			"name" => "secondaryTitle",
			"type" => "text",
			"description" => "If set, will display a second title below the main one. If you need to use classes use <strong style=\"font-style:normal;\">'</strong> instead of <strong style=\"font-style:normal;\">\"</strong>. You can also use <strong style=\"font-style:normal;\">br</strong> tags."
		),
		
		array(
			"title" => "Enable Custom Page Options ?",
			"name" => DESIGNARE_SHORTNAME."_enable_custom_pagetitle_options",
			"type" => "select",
			"options" => array(array("id"=>"yes","name"=>"Yes, please."), array("id"=>"no", "name"=>"No, thanks.")),
			"std" => "no"
		),
			
		array(
			"title" => "Background Type",
			"name" => DESIGNARE_SHORTNAME."_header_type",
			"type" => "select",
			"options" => array(array('id'=>'without', 'name'=>'Without Page Title'), array('id'=>'color','name'=>'Color'), array('id'=>'image','name'=>'Image'), array('id'=>'pattern','name'=>'Pattern'), array('id' => 'banner', 'name' => 'Banner Slider')),
			"std" => get_option('yunik_header_type')
		),
		
		array(
			"title" => "Image",
			"name" => DESIGNARE_SHORTNAME."_header_image",
			"type" => "mediaupload",
			"description" => 'Here you can choose the image for your header.'
		),
		
		// levar aqui as opções novas do pagetitle do painel para o caso das custom options numa page specific.
		array(
			"title" => "Parallax ?",
			"name" => DESIGNARE_SHORTNAME."_pagetitle_image_parallax",
			"type" => "select",
			"options" => array(array("id"=>"on","name"=>"Yes, please."),array("id"=>"off","name"=>"No, thanks.")),
			"std" => "off",
		),
		
		array(
			"title" => "Overlay ?",
			"name" => DESIGNARE_SHORTNAME."_pagetitle_image_overlay",
			"type" => "select",
			"options" => array(array("id"=>"on","name"=>"Yes, please."),array("id"=>"off","name"=>"No, thanks.")),
			"std" => "off"
		),
		
		array(
			"title" => "Overlay Type",
			"name" => DESIGNARE_SHORTNAME."_pagetitle_overlay_type",
			"type" => "select",
			"options" => array(array('id'=>'color', 'name'=>'Color'), array('id'=>'pattern','name'=>'Pattern')),
			"std" => 'color',
		),
		
		array(
			"title" => "Overlay Color",
			"name" => DESIGNARE_SHORTNAME."_pagetitle_overlay_color",
			"type" => "color",
			"std" => "333333"
		),
		
		array(
			"title" => "Overlay Pattern",
			"name" => DESIGNARE_SHORTNAME."_pagetitle_overlay_pattern",
			"type" => "pattern",
			"options" => $patterns,
		),
		
		array(
			"title" => "Overlay Opacity",
			"name" => DESIGNARE_SHORTNAME."_pagetitle_overlay_opacity",
			"type" => "slider",
			"std" => "100%"
		),
		// end of new options
		
		array(
			"title" => "Color",
			"name" => DESIGNARE_SHORTNAME."_header_color",
			"type" => "color"
		),
		
		array(
			"title" => "Color Opacity",
			"name" => DESIGNARE_SHORTNAME."_header_color_opacity",
			"type" => "slider",
			"std" => "100"
		),
		
		array(
			"title" => "Pattern",
			"name" => DESIGNARE_SHORTNAME."_header_pattern",
			"type" => "pattern",
			"options" => $patterns,
			"description" => 'Here you can choose the pattern for your header.'
		),
		
		array(
			"title" => "Custom Pattern",
			"name" => DESIGNARE_SHORTNAME."_header_custom_pattern",
			"type" => "mediaupload",
			"description" => 'Here you can choose the custom pattern for your header. It will replace the pattern you choose above.'
		),
		
		array(
			"title" => "Banner Slider",
			"name" => DESIGNARE_SHORTNAME."_banner_slider",
			"type" => "select",
			"options" => designare_get_created_camera_sliders()
		),

		array(
			"title" => "Page Title Padding",
			"name"=> DESIGNARE_SHORTNAME."_page_title_padding",
			"type" => "text",
			"std" => "50px"
		),
		
		array(
			"title"=>"Text Alignment",
			"name" => DESIGNARE_SHORTNAME."_header_text_alignment",
			"type" => "select",
			"std" => "left",
			"options" => array(array("id"=>"left", "name"=>"Left"), array("id"=>"center", "name"=>"Center"), array("id"=>"right", "name"=>"Right"), array("id"=>"titlesleftcrumbsright", "name"=>"Left: Titles, Right: Breadcrumbs"), array("id"=>"titlesrightcrumbsleft", "name"=>"Left: Breadcrumbs, Right: Titles"))
		),
		
		array(
			"title" => '<h4>Primary Title Options</h4>',
			"type" => "heading",
			"name" => "primarytitleoptions",
			"std" => "",
			"description" => ""
		),


		array(
			"title" => "Display Title ?",
			"name" => DESIGNARE_SHORTNAME."_hide_pagetitle",
			"type" => "select",
			"options" => array(array("id"=>"yes","name"=>"Yes, please."), array("id"=>"no", "name"=>"No, thanks.")),
			"std" => "yes"
		),
		
		array(
			"title" => "Primary Title Font",
			"name" => DESIGNARE_SHORTNAME."_header_text_font",
			"type" => "select",
			"options" => designare_fonts_array_builder(),
			"description" => 'You can select one of the fonts that the theme goes with or you can add google fonts (Style Options > Fonts).',
			"std" => 'Helvetica Neue'
		),
		
		array(
			"title" => "Primary Title Color",
			"name" => DESIGNARE_SHORTNAME."_header_text_color",
			"type" => "color",
			"std" => "26aee4"
		),
		
		array(
			"title" => "Primary Title Size",
			"name" => DESIGNARE_SHORTNAME."_header_text_size",
			"type" => "text",
			"std" => "16px"
		),
		
		array(
			"title" => "Primary Title Margin",
			"name" => DESIGNARE_SHORTNAME."_header_text_margin_top",
			"type" => "text",
			"std" => "20px"
		),
		
		array(
			"title" => '<h4>Secondary Title Options</h4>',
			"type" => "heading",
			"name" => "secondarytitleoptions",
			"std" => "",
			"description" => ""
		),
		
		array(
			"title" => "Display Secondary Title ?",
			"name" => DESIGNARE_SHORTNAME."_hide_sec_pagetitle",
			"type" => "select",
			"options" => array(array("id"=>"yes","name"=>"Yes, please."), array("id"=>"no", "name"=>"No, thanks.")),
			"std" => "yes"
		),
		
		array(
			"title" => "Secondary Title Font",
			"name" => DESIGNARE_SHORTNAME."_secondary_title_font",
			"type" => "select",
			"options" => designare_fonts_array_builder(),
			"description" => 'You can select one of the fonts that the theme goes with or you can add google fonts (Style Options > Fonts).',
			"std" => 'Helvetica Neue'
		),
		
		array(
			"title" => "Secondary Title Color",
			"name" => DESIGNARE_SHORTNAME."_secondary_title_text_color",
			"type" => "color",
			"std" => "828282"
		),
		
		array(
			"title" => "Secondary Title Size",
			"name" => DESIGNARE_SHORTNAME."_secondary_title_text_size",
			"type" => "text",
			"std" => "12px"
		),

		array(
			"title" => "Secondary Title Margin",
			"name" => DESIGNARE_SHORTNAME."_header_secondary_text_margin_top",
			"type" => "text",
			"std" => "10px"
		),
		
		array(
			"title" => '<h4>Breadcrumbs Options</h4>',
			"type" => "heading",
			"name" => "breadcrumboptions",
			"std" => "",
			"description" => ""
		),
		
		array(
			"title" => "Display Breadcrumbs ?",
			"name" => DESIGNARE_SHORTNAME."_enable_breadcrumbs",
			"type" => "select",
			"options" => array(array("id"=>"yes","name"=>"Yes, please."), array("id"=>"no", "name"=>"No, thanks.")),
			"std" => "yes"
		),
		
		array(
			"title" => "Breadcrumbs Margin Top",
			"name" => DESIGNARE_SHORTNAME."_breadcrumbs_margin_top",
			"type" => "text",
			"std" => "10px"
		),

			/* FLASH NEW STUFF */
			array(
				"title" => '<div class="ui-icon ui-icon-image no_show_hide_opts"></div>Under Construction Template Options',
				"type" => "heading",
				"name" => "underconstructionoptions",
				"std" => "",
				"description" => ""
			),
		
			array(
				"title" => "Choose the Revolution Slider",
				"name" => "underconstruction_rev",
				"type" => "select",
				"options" => designare_get_created_camera_sliders()
			),
			
			array(
				"title" => '<div class="ui-icon ui-icon-image no_show_hide_opts"></div>Homepage Style',
				"type" => "heading",
				"name" => "homepageoptions",
				"std" => "",
				"description" => ""
			),
		
			array(
				"title" => "Choose the Home Template Style.",
				"name" => "homeStyle",
				"type" => "selectHomeStyle",
				"options" => array(array("id"=>"slider","name"=>"Slider"), array("id"=>"image", "name"=>"Image"), array("id"=>"video", "name"=>"Video")),
			),
		
			array(
				"title" => "Homepage Slider",
				"name" => "homepageDefaultSlider",
				"type" => "select",
				"options" => designare_get_created_camera_sliders(),
				"description" => 'Choose one of your previously created sliders.'
			),
			
			array(
				"title" => "Parallax Effect ?",
				"name" => "parallaxEffect",
				"type" => "select",
				"options" => array(array("id"=>"yes","name"=>"YES"), array("id"=>"no","name"=>"NO")),
				"std" => "yes"
			),
			
			array(
				"title"=> "Select Background Media",
				"name"=> "homeParallaxMedia",
				"type"=> "mediauploadHome"
			),
			
			array(
				"title" => "Select the source of the video.",
				"name" => "homeVideoSource",
				"type" => "select",
				"options" => array(array("id"=>"youtube","name"=>"Youtube Video"), array("id"=>"media","name"=>"Media Library"))
			),
			
			array(
				"title"=> "Select Background Media",
				"name"=> "homeParallaxMedia_video",
				"type"=> "mediauploadHome_video"
			),
			
			array(
				"title" => "Youtube Video Link",
				"name" => "homeYoutubeLink",
				"type" => "text",
				"description"=> "Paste <strong> just the ID of the video</strong> (E.g. http://www.youtube.com/watch?v=<strong>8O72jXoMIkg</strong>) you want to show."
			),
			
			array(
				"title" => "Show Controls",
				"name" => "homeVideoControls",
				"type" => "select",
				"options" => array(array("id"=>"no","name"=>"NO"), array("id"=>"yes","name"=>"YES")),
				"std" => "no"
			),
			
			array(
				"title" => "Mute Video",
				"name" => "homeVideoMuted",
				"type" => "select",
				"options" => array(array("id"=>"no","name"=>"NO"), array("id"=>"yes","name"=>"YES")),
				"std" => "yes"
			),
			
			array(
				"title" => "Intro Logotype",
				"name" => "introLogo",
				"type" => "select",
				"options" => array(array("id"=>"image", "name"=>"Image"), array("id"=>"text","name"=>"Text"), array("id"=>"none","name"=>"None")),
				"std" => "text"
			),
			
			array(
				"title" => "Intro Logo Text",
				"name" => "introLogoText",
				"type" => "text",
				"std" => "YUNIK"
			),
			
			array(
				"title" => "Intro Logo Font",
				"name" => "introLogoFont",
				"type" => "select",
				"options" => designare_fonts_array_builder(),
				"std" => "Open Sans Semibold"
			),
			
			array(
				"title" => "Intro Logo Font Size",
				"name" => "introLogoFontSize",
				"type" => "text",
				"std" => "80px"
			),
				
			array(
				"title" => "Intro Logo Text Style",
				"name" => "introLogoTextStyle",
				"type" => "select",
				"options" => array(array("id"=>"dark","name"=>"Dark"),array("id"=>"light","name"=>"Light")),
				"std" => "dark"
			),
			
			array(
				"title" => "Intro Logo Border",
				"name" => "introLogoBorder",
				"type" => "select",
				"options" => array(array("id"=>"yes","name"=>"Yes"),array("id"=>"no","name"=>"No")),
				"std" => "no"
			),
			
			array(
				"title" => "Intro Logo Image URL",
				"name" => "introLogoImageURL",
				"type" => "introLogoUpload"
			),
			
			array(
				"title" => "Intro Logo Image Height",
				"name" => "introLogoImageHeight",
				"type" => "text",
				"std" => "130px"
			),
			
			array(
				"title" => "Intro Logo Link",
				"name" => "introLogoLink",
				"type" => "text",
				"desc" => "If empty the link will scroll to the content, skipping the intro screen."
			),
			
			array(
				"title" => "Show Captions?",
				"name" => "introCaptionsEnable",
				"type" => "select",
				"options" => array(array("id"=>"yes","name"=>"Yes"),array("id"=>"no","name"=>"No")),
				"std" => "yes"
			),
			
			array(
				"title" => "Captions List",
				"name" => "introCaptionsList",
				"type" => "textarea"
			),
			
			array(
				"title" => "Intro Captions Font",
				"name" => "introCaptionsFont",
				"type" => "select",
				"options" => designare_fonts_array_builder(),
				"std" => "Open Sans Semibold"
			),
			
			array(
				"title" => "Intro Captions Text Color",
				"name" => "introCaptionsTextStyle",
				"type" => "color",
				"std" => "FFFFFF"
			),
		
			array(
				"title" => "Intro Social Icons",
				"name" => "introSocailIconsEnable",
				"type" => "select",
				"options" => array(array("id"=>"yes", "name"=>"Yes"),array("id"=>"no","name"=>"No")),
				"std" => "no",
				"description" => "If set to YES will display the Social Icons defined on the <strong>Yunik Options > Social</strong> panel."
			),
			
			array(
				"title" => "Intro \"Continue\" Button",
				"name" => "introContinueEnable",
				"type" => "select",
				"options" => array(array("id"=>"yes","name"=>"Yes"),array("id"=>"no","name"=>"No")),
				"description" => "If set to <strong>Yes</strong> it will display a button at the bottom of the intro to continue to the site's content."
			),
			
			array(
				"title" => "Intro \"Continue\" Button Type",
				"name" => "introContinueType",
				"type" => "select",
				"options" => array(array("id"=>"text","name"=>"Text"),array("id"=>"arrow","name"=>"Arrow"))
			),
			
			array(
				"title" => "Intro \"Continue\" Button Text",
				"name" => "introContinueText",
				"type" => "text",
				"std" => "Continue"
			),
			
			array(
				"title" => "Intro \"Continue\" Text Font",
				"name" => "introContinueFont",
				"type" => "select",
				"options" => designare_fonts_array_builder(),
				"std" => "Open Sans Semibold"
			),
			
			array(
				"title" => "Intro \"Continue\" Text Font Size",
				"name" => "introContinueSize",
				"type" => "text",
				"std" => "14px"
			),
			
			array(
				"title" => "Intro \"Continue\" Text Color",
				"name" => "introContinueColor",
				"type" => "color",
				"std" => "fafafa"
			),
			
			array(
				"title" => "Intro \"Continue\" Text Background Color",
				"name" => "introContinueBgColor",
				"type" => "color",
				"std" => "666666"
			),
		
			/* ENDOF FLASH NEW STUFF */
			
			array(
				"title" => "",
				"name" => "sidebar_for_default",
				"type" => "select",
				"options" => array(array("id"=>"none", "name" => "none"), array("id"=>"left", "name" => "left"), array("id"=>"right", "name" => "right")),
				"std" => "none"
			),
			
			array(
				"title" => "Choose your Sidebar",
				"name" => "sidebars_available",
				"type" => "select",
				"options" => $outputsidebars
			),
						
		);


		/* ------------------------------------------------------------------------*
		 * META BOXES FOR THE POSTS - POST_TYPES
		 * ------------------------------------------------------------------------*/

		$designare_new_meta_post_boxes =
		array(
		
			array(
				"title" => "Secondary Title",
				"name" => "secondaryTitle",
				"type" => "text",
				"std" => "",
				"description" => "If set, will display a second title below the main one."
			),
				
			array(
				"title" => "Post Type",
				"name" => "posttype",
				"std" => "text",
				"type" => "select",
				"options" => array(array('id'=> 'image', 'name'=> 'Featured Image'), array('id'=>'slider', 'name'=>'Images Slider'), array('id'=>'video', 'name'=>'Video'), array('id'=>'audio', 'name'=>'Audio'), array('id'=>'text', 'name'=>'Text'), array('id'=>'quote', 'name'=>'Quote'), array('id'=>'link','name'=>'Link'), array('id'=>'none', 'name'=>'None')),
				"description" => 'You can choose from the following five post types: Featured Image, Slider, Video, Audio, Text or None.'
			),
			
			array(
				"title" => "<div class='ui-icon ui-icon-image show_hide_opts'></div>Quote",
				"type" => "heading",
				"name" => "",
				"std" => "",
				"description" => "",
			),
			
			array(
				'title' => 'Quote text',
				'name' => 'quote_text',
				'type' => 'textarea'
			),
			
			array(
				'title' => 'Quote Author',
				'name' => 'quote_author',
				'type' => 'text'
			),
			
			array(
				"title" => "<div class='ui-icon ui-icon-image show_hide_opts'></div>Link",
				"type" => "heading",
				"name" => "",
				"std" => "",
				"description" => "",
			),
			
			array(
				'title' => 'Link Text',
				'name' => 'link_text',
				'type' => 'text'
			),
			
			array(
				'title' => 'Link URL',
				'name' => 'link_url',
				'type' => 'text'
			),
			
			array(
				"title" => "<div class='ui-icon ui-icon-image show_hide_opts'></div>Images Slider",
				"type" => "heading",
				"name" => "",
				"std" => "",
				"description" => "",
			),
			
			array(
				"title"=> "Add Images",
				"name"=> "sliderImages",
				"type"=> "mediaupload"
			),
			
			array(
				"title" => "<div class='ui-icon ui-icon-image show_hide_opts'></div>Video",
				"type" => "heading",
				"name" => "",
				"std" => "",
				"description" => "",
			),
			
			array(
				"title"=> "Video Source",
				"name"=> "videoSource",
				"type"=> "select",
				"options" => array(array("id"=>"youtube", "name"=>"Youtube"), array("id"=>"vimeo","name"=>"Vimeo"), array("id"=>"media","name"=>"Media Library"))
			),
			
			array(
				"title"=>"Video Code",
				"name"=>"videoCode",
				"type"=>"textarea",
				"description"=> "Paste <strong> just the ID of the video</strong> (E.g. http://www.youtube.com/watch?v=<strong>I83Xp7itj8c</strong> or http://vimeo.com/<strong>127909728</strong>) you want to show, or insert own Embed Code."
			),
			
			array(
				"title"=> "Select Video",
				"name"=> "videoMediaLibrary",
				"type"=> "mediauploadHome_video"
			),
			
			array(
				"title" => "<div class='ui-icon ui-icon-image show_hide_opts'></div>Audio",
				"type" => "heading",
				"name" => "",
				"std" => "",
				"description" => "",
			),
			
			array(
				"title" => "Audio Source",
				"name" => "audioSource",
				"type" => "select",
				"options" => array( array("id"=>"embed","name"=>"Embed Code"), array("id"=>"media","name"=>"Media Library") )
			),
			
			array(
				"title"=> "Select Audio",
				"name"=> "audioMediaLibrary",
				"type"=> "mediaupload_audio"
			),
			
			array(
				"title"=>"Audio Code",
				"name"=>"audioCode",
				"type"=>"textarea",
				"description"=> "Paste the Embed Code. <br>"
			),
			
						
		array(
			"title" => "Enable Custom Page Options ?",
			"name" => DESIGNARE_SHORTNAME."_enable_custom_pagetitle_options",
			"type" => "select",
			"options" => array(array("id"=>"yes","name"=>"Yes, please."), array("id"=>"no", "name"=>"No, thanks.")),
			"std" => "no"
		),
			
		array(
			"title" => "Background Type",
			"name" => DESIGNARE_SHORTNAME."_header_type",
			"type" => "select",
			"options" => array(array('id'=>'without', 'name'=>'Without Page Title'), array('id'=>'color','name'=>'Color'), array('id'=>'image','name'=>'Image'), array('id'=>'pattern','name'=>'Pattern'), array('id' => 'banner', 'name' => 'Banner Slider')),
			"std" => get_option('yunik_header_type')
		),
		
		array(
			"title" => "Image",
			"name" => DESIGNARE_SHORTNAME."_header_image",
			"type" => "mediaupload",
			"description" => 'Here you can choose the image for your header.'
		),
		
		// levar aqui as opções novas do pagetitle do painel para o caso das custom options numa page specific.
		array(
			"title" => "Parallax ?",
			"name" => DESIGNARE_SHORTNAME."_pagetitle_image_parallax",
			"type" => "select",
			"options" => array(array("id"=>"on","name"=>"Yes, please."),array("id"=>"off","name"=>"No, thanks.")),
			"std" => "off",
		),
		
		array(
			"title" => "Overlay ?",
			"name" => DESIGNARE_SHORTNAME."_pagetitle_image_overlay",
			"type" => "select",
			"options" => array(array("id"=>"on","name"=>"Yes, please."),array("id"=>"off","name"=>"No, thanks.")),
			"std" => "off"
		),
		
		array(
			"title" => "Overlay Type",
			"name" => DESIGNARE_SHORTNAME."_pagetitle_overlay_type",
			"type" => "select",
			"options" => array(array('id'=>'color', 'name'=>'Color'), array('id'=>'pattern','name'=>'Pattern')),
			"std" => 'color',
		),
		
		array(
			"title" => "Overlay Color",
			"name" => DESIGNARE_SHORTNAME."_pagetitle_overlay_color",
			"type" => "color",
			"std" => "333333"
		),
		
		array(
			"title" => "Overlay Pattern",
			"name" => DESIGNARE_SHORTNAME."_pagetitle_overlay_pattern",
			"type" => "pattern",
			"options" => $patterns,
		),
		
		array(
			"title" => "Overlay Opacity",
			"name" => DESIGNARE_SHORTNAME."_pagetitle_overlay_opacity",
			"type" => "slider",
			"std" => "100%"
		),
		// end of new options
		
		array(
			"title" => "Color",
			"name" => DESIGNARE_SHORTNAME."_header_color",
			"type" => "color"
		),
		
		array(
			"title" => "Color Opacity",
			"name" => DESIGNARE_SHORTNAME."_header_color_opacity",
			"type" => "slider",
			"std" => "100"
		),
		
		array(
			"title" => "Pattern",
			"name" => DESIGNARE_SHORTNAME."_header_pattern",
			"type" => "pattern",
			"options" => $patterns,
			"description" => 'Here you can choose the pattern for your header.'
		),
		
		array(
			"title" => "Custom Pattern",
			"name" => DESIGNARE_SHORTNAME."_header_custom_pattern",
			"type" => "mediaupload",
			"description" => 'Here you can choose the custom pattern for your header. It will replace the pattern you choose above.'
		),
		
		array(
			"title" => "Banner Slider",
			"name" => DESIGNARE_SHORTNAME."_banner_slider",
			"type" => "select",
			"options" => designare_get_created_camera_sliders()
		),

		array(
			"title" => "Page Title Padding",
			"name"=> DESIGNARE_SHORTNAME."_page_title_padding",
			"type" => "text",
			"std" => "50px"
		),
		
		array(
			"title"=>"Text Alignment",
			"name" => DESIGNARE_SHORTNAME."_header_text_alignment",
			"type" => "select",
			"std" => "left",
			"options" => array(array("id"=>"left", "name"=>"Left"), array("id"=>"center", "name"=>"Center"), array("id"=>"right", "name"=>"Right"), array("id"=>"titlesleftcrumbsright", "name"=>"Left: Titles, Right: Breadcrumbs"), array("id"=>"titlesrightcrumbsleft", "name"=>"Left: Breadcrumbs, Right: Titles"))
		),
		
		array(
			"title" => '<h4>Primary Title Options</h4>',
			"type" => "heading",
			"name" => "primarytitleoptions",
			"std" => "",
			"description" => ""
		),


		array(
			"title" => "Display Title ?",
			"name" => DESIGNARE_SHORTNAME."_hide_pagetitle",
			"type" => "select",
			"options" => array(array("id"=>"yes","name"=>"Yes, please."), array("id"=>"no", "name"=>"No, thanks.")),
			"std" => "yes"
		),
		
		array(
			"title" => "Primary Title Font",
			"name" => DESIGNARE_SHORTNAME."_header_text_font",
			"type" => "select",
			"options" => designare_fonts_array_builder(),
			"description" => 'You can select one of the fonts that the theme goes with or you can add google fonts (Style Options > Fonts).',
			"std" => 'Helvetica Neue'
		),
		
		array(
			"title" => "Primary Title Color",
			"name" => DESIGNARE_SHORTNAME."_header_text_color",
			"type" => "color",
			"std" => "26aee4"
		),
		
		array(
			"title" => "Primary Title Size",
			"name" => DESIGNARE_SHORTNAME."_header_text_size",
			"type" => "text",
			"std" => "16px"
		),
		
		array(
			"title" => "Primary Title Margin",
			"name" => DESIGNARE_SHORTNAME."_header_text_margin_top",
			"type" => "text",
			"std" => "20px"
		),
		
		array(
			"title" => '<h4>Secondary Title Options</h4>',
			"type" => "heading",
			"name" => "secondarytitleoptions",
			"std" => "",
			"description" => ""
		),
		
		array(
			"title" => "Display Secondary Title ?",
			"name" => DESIGNARE_SHORTNAME."_hide_sec_pagetitle",
			"type" => "select",
			"options" => array(array("id"=>"yes","name"=>"Yes, please."), array("id"=>"no", "name"=>"No, thanks.")),
			"std" => "yes"
		),
		
		array(
			"title" => "Secondary Title Font",
			"name" => DESIGNARE_SHORTNAME."_secondary_title_font",
			"type" => "select",
			"options" => designare_fonts_array_builder(),
			"description" => 'You can select one of the fonts that the theme goes with or you can add google fonts (Style Options > Fonts).',
			"std" => 'Helvetica Neue'
		),
		
		array(
			"title" => "Secondary Title Color",
			"name" => DESIGNARE_SHORTNAME."_secondary_title_text_color",
			"type" => "color",
			"std" => "828282"
		),
		
		array(
			"title" => "Secondary Title Size",
			"name" => DESIGNARE_SHORTNAME."_secondary_title_text_size",
			"type" => "text",
			"std" => "12px"
		),

		array(
			"title" => "Secondary Title Margin",
			"name" => DESIGNARE_SHORTNAME."_header_secondary_text_margin_top",
			"type" => "text",
			"std" => "10px"
		),
		
		array(
			"title" => '<h4>Breadcrumbs Options</h4>',
			"type" => "heading",
			"name" => "breadcrumboptions",
			"std" => "",
			"description" => ""
		),
		
		array(
			"title" => "Display Breadcrumbs ?",
			"name" => DESIGNARE_SHORTNAME."_enable_breadcrumbs",
			"type" => "select",
			"options" => array(array("id"=>"yes","name"=>"Yes, please."), array("id"=>"no", "name"=>"No, thanks.")),
			"std" => "yes"
		),
		
		array(
			"title" => "Breadcrumbs Margin Top",
			"name" => DESIGNARE_SHORTNAME."_breadcrumbs_margin_top",
			"type" => "text",
			"std" => "10px"
		),

			
		);


		/* ------------------------------------------------------------------------*
		 * META BOXES FOR THE PORTFOLIO POSTS
		 * ------------------------------------------------------------------------*/

		$designare_new_meta_portfolio_boxes =
		array(
		
			array(
				"title" => "Secondary Title",
				"name" => "secondaryTitle",
				"type" => "text",
				"std" => "",
				"description" => "If set, will display a second title below the main one."
			),
						
			array(
				"title" => "Project - Page Layout",
				"name" => "singleLayout",
				"type" => "select",
				"options" => array(array('id'=>'default','name'=>'Default'), array('id'=>'left_media', 'name'=>'Media on the Left'),array('id'=>'full_media', 'name'=>'Media occupies the container\'s full length'), array('id'=>'fullwidth_media', 'name'=>'Media occupies the window\'s length')),
				"std" => "default",
				"description"=>"If set to <strong>Default</strong> the Project will be displayed as defined on the <strong>Panel Options </strong>><strong> General </strong>><strong> Projects </strong>><strong> Project Single Layout Option</strong>."
			),
			
			array(
				"title" => "Portfolio Type",
				"name" => "portfolioType",
				"type" => "select",
				"options" => array(array("id"=>"image", "name"=>"Slider Images"),array("id"=>"video", "name"=>"Video"), array("id"=>"other", "name"=>"Other"))
			),

			array(
				"title" => "<div class='ui-icon ui-icon-image show_hide_opts'></div>Slider Images",
				"type" => "heading",
				"name" => "",
				"std" => "",
				"description" => "",
			),
		
			array(
				"title"=> "Add Slider Image",
				"name"=> "sliderImages",
				"type"=> "mediaupload"
			),
			
			array(
				"title" => "Custom Flex Slider Options",
				"name" => "custom_slider_opts",
				"type" => "select",
				"options" => array(array("id"=>"on", "name"=>"ON"),array("id"=>"off","name"=>"OFF")),
				"description"=>"If set to <strong>ON</strong> this options will override the ones on the Panel Options > Slider Settings > Flex Slider > General > Projects.",
				"std" => "off"
			),
			
			array(
				"title" => "Show Direction Controls",
				"name" => "projs_flex_navigation",
				"type" => "select",
				"options" => array(array("name"=>"Yes", "id"=>"true"), array("name"=>"No", "id"=>"false")),
				"std" => get_option(DESIGNARE_SHORTNAME."_projs_flex_navigation"),
				"description" => ""
			),
		
			array(
				"title" => "Show Controls",
				"name" => "projs_flex_controls",
				"type" => "select",
				"options" => array(array("name"=>"Yes", "id"=>"true"), array("name"=>"No", "id"=>"false")),
				"std" => get_option(DESIGNARE_SHORTNAME."_projs_flex_controls"),
				"description" => ""
			),
			
			array(
				"title" => "Transition Effect",
				"name" => "projs_flex_transition",
				"type" => "select",
				"options" => array(array("name"=>"Slide", "id"=>"slide"), array("name"=>"Fade", "id"=>"fade")),
				"std" => get_option(DESIGNARE_SHORTNAME."_projs_flex_transition"),
				"description" => ""
			),
			
			array(
				"title" => "Transition Duration",
				"name" => "projs_flex_transition_duration",
				"type" => "text",
				"std" => get_option(DESIGNARE_SHORTNAME."_projs_flex_transition_duration"),
				"description" => "The duration of the transition between slides."
			),
			
			array(
				"title" => "Slide Duration",
				"name" => "projs_flex_slide_duration",
				"type" => "text",
				"std" => get_option(DESIGNARE_SHORTNAME."_projs_flex_slide_duration"),
				"description" => "The duration of each slide"
			),
			
			array(
				"title" => "Autoplay",
				"name" => "projs_flex_autoplay",
				"type" => "select",
				"options" => array(array("name"=>"Yes", "id"=>"true"), array("name"=>"No", "id"=>"false")),
				"std" => get_option(DESIGNARE_SHORTNAME."_projs_flex_autoplay"),
				"description" => ""
			),
			
			array(
				"title" => "Pause on Hover",
				"name" => "projs_flex_pause_hover",
				"type" => "select",
				"options" => array(array("name"=>"Yes", "id"=>"true"), array("name"=>"No", "id"=>"false")),
				"std" => get_option(DESIGNARE_SHORTNAME."_projs_flex_pause_hover"),
				"description" => "Play/Pause on mouse out/over"
			),
			
			array(
				"title" => "Slider Height",
				"name" => "projs_flex_height",
				"type" => "text",
				"std" => get_option(DESIGNARE_SHORTNAME."_projs_flex_height"),
				"description" => "The height of the slider."
			),
			
			array(
				"title" => "<div class='ui-icon ui-icon-image show_hide_opts'></div>Video",
				"type" => "heading",
				"name" => "",
				"std" => "",
				"description" => "",
			),
			
			array(
				"title"=> "Video Source",
				"name"=> "videoSource",
				"type"=> "select",
				"options" => array(array("id"=>"youtube", "name"=>"Youtube"), array("id"=>"vimeo", "name"=>"Vimeo"), array("id"=>"media","name"=>"Media Library"))
			),
			
			array(
				"title"=>"Video Code",
				"name"=>"videoCode",
				"type"=>"textarea",
				"description"=> "Paste <strong> just the ID of the video</strong> (E.g. http://www.youtube.com/watch?v=<strong>I83Xp7itj8c</strong> or http://vimeo.com/<strong>127909728</strong>) you want to show, or insert own Embed Code. <br>If you need to show more than one video just paste de IDs separated by comas [ <strong>,</strong> ].<br>"
			),
			
			array(
				"title"=> "Select Video",
				"name"=> "videoMediaLibrary",
				"type"=> "mediauploadHome_video"
			),
	
			array(
				"title" => "Enable Custom Page Options ?",
				"name" => DESIGNARE_SHORTNAME."_enable_custom_pagetitle_options",
				"type" => "select",
				"options" => array(array("id"=>"yes","name"=>"Yes, please."), array("id"=>"no", "name"=>"No, thanks.")),
				"std" => "no"
			),
				
			array(
				"title" => "Background Type",
				"name" => DESIGNARE_SHORTNAME."_header_type",
				"type" => "select",
				"options" => array(array('id'=>'without', 'name'=>'Without Page Title'), array('id'=>'color','name'=>'Color'), array('id'=>'image','name'=>'Image'), array('id'=>'pattern','name'=>'Pattern'), array('id' => 'banner', 'name' => 'Banner Slider')),
				"std" => get_option('yunik_header_type')
			),
			
			array(
				"title" => "Image",
				"name" => DESIGNARE_SHORTNAME."_header_image",
				"type" => "mediaupload",
				"description" => 'Here you can choose the image for your header.'
			),
			
			// levar aqui as opções novas do pagetitle do painel para o caso das custom options numa page specific.
			array(
				"title" => "Parallax ?",
				"name" => DESIGNARE_SHORTNAME."_pagetitle_image_parallax",
				"type" => "select",
				"options" => array(array("id"=>"on","name"=>"Yes, please."),array("id"=>"off","name"=>"No, thanks.")),
				"std" => "off",
			),
			
			array(
				"title" => "Overlay ?",
				"name" => DESIGNARE_SHORTNAME."_pagetitle_image_overlay",
				"type" => "select",
				"options" => array(array("id"=>"on","name"=>"Yes, please."),array("id"=>"off","name"=>"No, thanks.")),
				"std" => "off"
			),
			
			array(
				"title" => "Overlay Type",
				"name" => DESIGNARE_SHORTNAME."_pagetitle_overlay_type",
				"type" => "select",
				"options" => array(array('id'=>'color', 'name'=>'Color'), array('id'=>'pattern','name'=>'Pattern')),
				"std" => 'color',
			),
			
			array(
				"title" => "Overlay Color",
				"name" => DESIGNARE_SHORTNAME."_pagetitle_overlay_color",
				"type" => "color",
				"std" => "333333"
			),
			
			array(
				"title" => "Overlay Pattern",
				"name" => DESIGNARE_SHORTNAME."_pagetitle_overlay_pattern",
				"type" => "pattern",
				"options" => $patterns,
			),
			
			array(
				"title" => "Overlay Opacity",
				"name" => DESIGNARE_SHORTNAME."_pagetitle_overlay_opacity",
				"type" => "slider",
				"std" => "100%"
			),
			// end of new options
			
			array(
				"title" => "Color",
				"name" => DESIGNARE_SHORTNAME."_header_color",
				"type" => "color"
			),
			
			array(
				"title" => "Color Opacity",
				"name" => DESIGNARE_SHORTNAME."_header_color_opacity",
				"type" => "slider",
				"std" => "100"
			),
			
			array(
				"title" => "Pattern",
				"name" => DESIGNARE_SHORTNAME."_header_pattern",
				"type" => "pattern",
				"options" => $patterns,
				"description" => 'Here you can choose the pattern for your header.'
			),
			
			array(
				"title" => "Custom Pattern",
				"name" => DESIGNARE_SHORTNAME."_header_custom_pattern",
				"type" => "mediaupload",
				"description" => 'Here you can choose the custom pattern for your header. It will replace the pattern you choose above.'
			),
			
			array(
				"title" => "Banner Slider",
				"name" => DESIGNARE_SHORTNAME."_banner_slider",
				"type" => "select",
				"options" => designare_get_created_camera_sliders()
			),
			
			array(
				"title" => "Page Title Padding",
				"name"=> DESIGNARE_SHORTNAME."_page_title_padding",
				"type" => "text",
				"std" => "50px"
			),
			
			array(
				"title"=>"Text Alignment",
				"name" => DESIGNARE_SHORTNAME."_header_text_alignment",
				"type" => "select",
				"std" => "left",
				"options" => array(array("id"=>"left", "name"=>"Left"), array("id"=>"center", "name"=>"Center"), array("id"=>"right", "name"=>"Right"), array("id"=>"titlesleftcrumbsright", "name"=>"Left: Titles, Right: Breadcrumbs"), array("id"=>"titlesrightcrumbsleft", "name"=>"Left: Breadcrumbs, Right: Titles"))
			),
			
			array(
				"title" => '<h4>Primary Title Options</h4>',
				"type" => "heading",
				"name" => "primarytitleoptions",
				"std" => "",
				"description" => ""
			),
	
	
			array(
				"title" => "Display Title ?",
				"name" => DESIGNARE_SHORTNAME."_hide_pagetitle",
				"type" => "select",
				"options" => array(array("id"=>"yes","name"=>"Yes, please."), array("id"=>"no", "name"=>"No, thanks.")),
				"std" => "yes"
			),
			
			array(
				"title" => "Primary Title Font",
				"name" => DESIGNARE_SHORTNAME."_header_text_font",
				"type" => "select",
				"options" => designare_fonts_array_builder(),
				"description" => 'You can select one of the fonts that the theme goes with or you can add google fonts (Style Options > Fonts).',
				"std" => 'Helvetica Neue'
			),
			
			array(
				"title" => "Primary Title Color",
				"name" => DESIGNARE_SHORTNAME."_header_text_color",
				"type" => "color",
				"std" => "26aee4"
			),
			
			array(
				"title" => "Primary Title Size",
				"name" => DESIGNARE_SHORTNAME."_header_text_size",
				"type" => "text",
				"std" => "16px"
			),
			
			array(
				"title" => "Primary Title Margin",
				"name" => DESIGNARE_SHORTNAME."_header_text_margin_top",
				"type" => "text",
				"std" => "20px"
			),
			
			array(
				"title" => '<h4>Secondary Title Options</h4>',
				"type" => "heading",
				"name" => "secondarytitleoptions",
				"std" => "",
				"description" => ""
			),
			
			array(
				"title" => "Display Secondary Title ?",
				"name" => DESIGNARE_SHORTNAME."_hide_sec_pagetitle",
				"type" => "select",
				"options" => array(array("id"=>"yes","name"=>"Yes, please."), array("id"=>"no", "name"=>"No, thanks.")),
				"std" => "yes"
			),
			
			array(
				"title" => "Secondary Title Font",
				"name" => DESIGNARE_SHORTNAME."_secondary_title_font",
				"type" => "select",
				"options" => designare_fonts_array_builder(),
				"description" => 'You can select one of the fonts that the theme goes with or you can add google fonts (Style Options > Fonts).',
				"std" => 'Helvetica Neue'
			),
			
			array(
				"title" => "Secondary Title Color",
				"name" => DESIGNARE_SHORTNAME."_secondary_title_text_color",
				"type" => "color",
				"std" => "828282"
			),
			
			array(
				"title" => "Secondary Title Size",
				"name" => DESIGNARE_SHORTNAME."_secondary_title_text_size",
				"type" => "text",
				"std" => "12px"
			),
	
			array(
				"title" => "Secondary Title Margin",
				"name" => DESIGNARE_SHORTNAME."_header_secondary_text_margin_top",
				"type" => "text",
				"std" => "10px"
			),
			
			array(
				"title" => '<h4>Breadcrumbs Options</h4>',
				"type" => "heading",
				"name" => "breadcrumboptions",
				"std" => "",
				"description" => ""
			),
			
			array(
				"title" => "Display Breadcrumbs ?",
				"name" => DESIGNARE_SHORTNAME."_enable_breadcrumbs",
				"type" => "select",
				"options" => array(array("id"=>"yes","name"=>"Yes, please."), array("id"=>"no", "name"=>"No, thanks.")),
				"std" => "yes"
			),
			
			array(
				"title" => "Breadcrumbs Margin Top",
				"name" => DESIGNARE_SHORTNAME."_breadcrumbs_margin_top",
				"type" => "text",
				"std" => "10px"
			),
		
		);
		
		/* ------------------------------------------------------------------------*
		 * META BOXES FOR THE TESTIMONIALS POSTS
		 * ------------------------------------------------------------------------*/

		$new_meta_testimonials_boxes =
		array(

			array(
				"title" => "Testimonial Author",
				"name" => "author",
				"std" => "",
				"type" => "text",
				"description" => 'Enter the name of the testimonial author.'
			),
			
			array(
				"title" => "Author HyperLink",
				"name" => "author_link",
				"std" => "",
				"type" => "text",
				"description" => 'Optional author hyperlink.'
			),


			array(
				"title" => "Testimonial Author Company",
				"name" => "company",
				"std" => "",
				"type" => "text",
				"description" => 'Enter the company\'s name of the testimonial author.'
			),

			array(
				"title" => "Compny HyperLink",
				"name" => "company_link",
				"std" => "",
				"type" => "text",
				"description" => 'Optional company hyperlink.'
			),
		
		);
		
		/* ------------------------------------------------------------------------*
		 * META BOXES FOR THE PARTNERS POSTS
		 * ------------------------------------------------------------------------*/

		$new_meta_partners_boxes =
		array(

			array(
				"title" => "Partners Hyperlink",
				"name" => "link",
				"std" => "",
				"type" => "text",
				"description" => 'Enter the Hyperlink to your Partner\'s website. Paste the entire URL \'http://\' included.'
			)
		
		);


		/* ------------------------------------------------------------------------*
		 * META BOXES FOR THE TEAM POSTS
		 * ------------------------------------------------------------------------*/

		$new_meta_team_boxes = array();
}

/**
 * Creates a page meta box.
 */
function create_meta_box() {
	if ( function_exists('add_meta_box') ) {
		add_meta_box( 'new-meta-boxes', '<div class="icon-small"></div> '.DESIGNARE_THEMENAME.' PAGE SETTINGS', 'designare_new_meta_boxes', 'page', 'normal', 'high' );
	}
}

/**
 * Creates a post meta box.
 */
function create_meta_post_box() {
	if ( function_exists('add_meta_box') ) {
		add_meta_box( 'new-meta-post-boxes', '<div class="icon-small"></div> '.DESIGNARE_THEMENAME.' POST TYPE SETTINGS - W`P`L`O`C`K`E`R`.`C`O`M`', 'designare_new_meta_post_boxes', 'post', 'normal', 'high' );
	}
}


/**
 * Creates a post meta box.
 */
function create_meta_portfolio_box() {
	if ( function_exists('add_meta_box') && defined('DESIGNARE_PORTFOLIO_POST_TYPE')) {
		add_meta_box( 'new-meta-portfolio-boxes', '<div class="icon-small"></div> '.DESIGNARE_THEMENAME.' PORTFOLIO ITEM SETTINGS', 'designare_new_meta_portfolio_boxes', DESIGNARE_PORTFOLIO_POST_TYPE, 'normal', 'high' );
	}
}

/**
 * Creates a testimonials meta box.
 */
function create_meta_testimonials_box() {
	if ( function_exists('add_meta_box') && defined('DESIGNARE_TESTIMONIALS_POST_TYPE')) {
		add_meta_box( 'new-meta-testimonials-boxes', '<div class="icon-small"></div> '.DESIGNARE_THEMENAME.' TESTIMONIALS ITEM SETTINGS', 'new_meta_testimonials_boxes', DESIGNARE_TESTIMONIALS_POST_TYPE, 'normal', 'high' );
	}
}

/**
 * Creates a partners meta box.
 */
function create_meta_partners_box() {
	if ( function_exists('add_meta_box') && defined('DESIGNARE_PARTNERS_POST_TYPE')) {
		add_meta_box( 'new-meta-partners-boxes', '<div class="icon-small"></div> '.DESIGNARE_THEMENAME.' PARTNERS ITEM SETTINGS', 'new_meta_partners_boxes', DESIGNARE_PARTNERS_POST_TYPE, 'normal', 'high' );
	}
}

function create_meta_team_box() {
	if ( function_exists('add_meta_box') ) {
		//add_meta_box( 'new-meta-team-boxes', '<div class="icon-small"></div> '.DESIGNARE_THEMENAME.' TEAM ITEM SETTINGS', 'new_meta_team_boxes', DESIGNARE_TEAM_POST_TYPE, 'normal', 'high' );
	}
}


/**
 * Calls the print method for page meta boxes.
 */
function designare_new_meta_boxes() {
	global $post, $designare_new_meta_boxes;

	foreach($designare_new_meta_boxes as $meta_box) {
		print_meta_box($meta_box, $post);
	}
}

/**
 * Calls the print method for post meta boxes.
 */
function designare_new_meta_post_boxes() {
	global $post, $designare_new_meta_post_boxes;

	foreach($designare_new_meta_post_boxes as $meta_box) {
		print_meta_box($meta_box, $post);
	}
}

/**
 * Calls the print method for portfolio meta boxes.
 */
function designare_new_meta_portfolio_boxes() {
	global $post, $designare_new_meta_portfolio_boxes;

	foreach($designare_new_meta_portfolio_boxes as $meta_box) {
		print_meta_box($meta_box, $post);
	}
}

/**
 * Calls the print method for portfolio meta boxes.
 */
function new_meta_testimonials_boxes() {
	global $post, $new_meta_testimonials_boxes;

	foreach($new_meta_testimonials_boxes as $meta_box) {
		print_meta_box($meta_box, $post);
	}
}

/**
 * Calls the print method for partners meta boxes.
 */
function new_meta_partners_boxes() {
	global $post, $new_meta_partners_boxes;

	foreach($new_meta_partners_boxes as $meta_box) {
		print_meta_box($meta_box, $post);
	}
}

/**
 * Calls the print method for partners meta boxes.
 */
function new_meta_team_boxes() {
	global $post, $new_meta_team_boxes;

	foreach($new_meta_team_boxes as $meta_box) {
		print_meta_box($meta_box, $post);
	}
}

/**
 * Prints the meta box
 * @param $meta_box the meta box to be printed
 * @param $post the post to contain the meta box
 */
function print_meta_box($meta_box, $post){
	
	if (!isset($meta_box['name'])) $meta_box['name'] = "";
	$meta_box_value = get_post_meta($post->ID, $meta_box['name'].'_value', true);

	if($meta_box_value == ""){
		if (isset($meta_box['std']))
			$meta_box_value = $meta_box['std'];
		else $meta_box_value = "";
	}


	switch($meta_box['type']){
		
		case 'slider':
			echo '<div class="option-container">';
			
			echo'<input type="hidden" name="'.$meta_box['name'].'_noncename" id="'.$meta_box['name'].'_noncename" value="'.wp_create_nonce( plugin_basename(__FILE__) ).'" />';

			echo'<h4 class="page-option-title">'.$meta_box['title'].'</h4>';
			
			echo '<div class="slider_container" style="position:relative;float:left;width:40%;top:13px;"><div class="slider opacity-slider" id="'.$meta_box['name'].'_slider" title="'.$meta_box['name'].'_helper_input"></div><input class="option-input slider-input" name="'.$meta_box['name'].'_helper_input" id="'.$meta_box['name'].'_helper_input" type="text" value="'.$meta_box_value.'" style="border: 0; background: none; color: #314572; padding: 0; margin: 0; font-style: italic; box-shadow: none; -webkit-box-shadow: none;width:100%;text-align:center;margin-top:10px;" /></div>';

			if (isset($meta_box['description']) && $meta_box['description'] != "") echo'<span class="option-description">'.$meta_box['description'].'</span>';
			
			echo'<input type="text" id="'.$meta_box['name'].'_value" name="'.$meta_box['name'].'_value" value="'.$meta_box_value.'" class="option-input hidden" />';

			echo '</div>';
			
			echo '<script>jQuery(document).ready(function() {
				
				jQuery("#'.$meta_box['name'].'_slider").each(function(){
					
					var value = parseInt(jQuery("#'.$meta_box['name'].'_value").val(), 10);
					jQuery(this).slider({
						range: "min",
						value: value,
						min: 0,
						max: 100,
						slide: function( event, ui ) {
							jQuery("#'.$meta_box['name'].'_helper_input").val(ui.value+"%");
							jQuery("#'.$meta_box['name'].'_value").val( ui.value + " %" );
						}
					});
				
				}); });
				</script>';
		break;
		
		case 'multicheck':
			if (sizeof($meta_box['options'])>1){
				
			}
			static $mcindex = 1;
			echo '<div class="option-container multicheck '.$meta_box['name'].'" id="multicheck-'.$mcindex.'">';			
			echo'<input type="hidden" name="'.$meta_box['name'].'_noncename" id="'.$meta_box['name'].'_noncename" value="'.wp_create_nonce( plugin_basename(__FILE__) ).'" />';
			echo'<h4 class="page-option-title '.$meta_box['name'].'">'.$meta_box['title'].'</h4>';
			$metavalues = explode(",", $meta_box_value);
			if (!is_array($metavalues) || empty($metavalues)) $metavalues = array();
			if(sizeof($meta_box['options'])>0){
				if(sizeof($meta_box['options'])>1) echo '<label for="'.$meta_box['name'].'_all" class="button">Select All</label>';
				foreach ($meta_box['options'] as $option) { ?>
					<label for="<?php echo $meta_box['name']; ?>_<?php echo $option['id']; ?>"><input type="checkbox"
					<?php if ( in_array($option['id'], $metavalues) ){
						echo ' checked="checked"';
					}
					?> value="<?php echo($option['id']);?>"> <?php echo $option['name']; ?></label><?php
				}
				?>
				<script type="text/javascript">
					var allselected = true;
					for (var i = 0; i < jQuery('#multicheck-<?php echo $mcindex; ?> label').not('.button').length; i++){
						if (jQuery('#multicheck-<?php echo $mcindex; ?> > label').not('.button').eq(i).children('input').attr('checked') == undefined) allselected = false;
					}
					if (allselected) jQuery('label[for=<?php echo $meta_box['name']; ?>_all]').text('Deselect All');
					function update_multicheck_<?php echo $mcindex; ?>(){
						var multicheck_value = "";
						jQuery('#multicheck-<?php echo $mcindex; ?>.multicheck > label').not('.button').each(function(){
							if (jQuery(this).find('input').is(':checked')) multicheck_value += jQuery(this).find('input').val()+",";
						});
						if (multicheck_value.substr(multicheck_value.length-1) === ',') 
							multicheck_value = multicheck_value.substr(0, multicheck_value.length-1);
						jQuery('#designare-multicheck-<?php echo $mcindex; ?>').attr('value',multicheck_value);
						var allselected = true;
						for (var i = 0; i < jQuery('#multicheck-<?php echo $mcindex; ?> > label').not('.button').length; i++){
							if (jQuery('#multicheck-<?php echo $mcindex; ?> label').not('.button').eq(i).children('input').attr('checked') == undefined) allselected = false;
						}
						if (allselected) jQuery('label[for=<?php echo $meta_box['name']; ?>_all]').text('Deselect All');
						else jQuery('label[for=<?php echo $meta_box['name']; ?>_all]').text('Select All');
					}
					jQuery('#multicheck-<?php echo $mcindex; ?> label[for=<?php echo $meta_box['name']; ?>_all]').click(function(){
						if (jQuery(this).text() === 'Select All'){
							jQuery(this).siblings('label').find('input').attr('checked','checked');
							jQuery(this).text('Deselect All'); 
						} else {
							jQuery(this).siblings('label').find('input').attr('checked',false)
							jQuery(this).text('Select All');
						}
					});
					jQuery('#multicheck-<?php echo $mcindex; ?> > label').click(function(){
						setTimeout(function(){
							update_multicheck_<?php echo $mcindex; ?>();
						}, 100);
					});
				</script>
				<?php
			} else {
				echo "<br/><h4>You have no Post Categories defined.</h4><br/>";
			}
			echo'<input type="text" name="'.$meta_box['name'].'_value" value="'.$meta_box_value.'" id="designare-multicheck-'.$mcindex.'" class="option-input hidden" />';
			echo '</div>';
			$mcindex++;
		break;
		case 'heading':
			echo'<div class="ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix '.$meta_box['name'].'">
<h4>'.$meta_box['title'].'</h4></div>';
			break;
			
		case 'heading_unformatted':
			if (!isset($meta_box['name'])) $meta_box['name'] = "";
			echo'<div class="'.$meta_box['name'].'">'.$meta_box['title'].'</div>';
			break;
			
		case 'text':
			echo '<div class="option-container">';
			echo'<input type="hidden" name="'.$meta_box['name'].'_noncename" id="'.$meta_box['name'].'_noncename" value="'.wp_create_nonce( plugin_basename(__FILE__) ).'" />';

			echo'<h4 class="page-option-title">'.$meta_box['title'].'</h4>';

			echo'<input type="text" name="'.$meta_box['name'].'_value" value="'.$meta_box_value.'" class="option-input"/><br />';
			
			if (!isset($meta_box['description'])) $meta_box['description'] = "";
			echo'<span class="option-description">'.$meta_box['description'].'</span>';
			echo '</div>';
			break;
			
		case 'color':
			echo '<div class="option-container">';
			echo'<input type="hidden" name="'.$meta_box['name'].'_noncename" id="'.$meta_box['name'].'_noncename" value="'.wp_create_nonce( plugin_basename(__FILE__) ).'" />';

			echo'<h4 class="page-option-title">'.$meta_box['title'].'</h4>';

			echo'<label>#</label><input type="text" style="width: 100px; background: #'.$meta_box_value.'" id="'.$meta_box['name'].'" name="'.$meta_box['name'].'_value" value="'.$meta_box_value.'" class="option-input"/><br />';

			if (!isset($meta_box['description'])) $meta_box['description'] = "";
			echo'<span class="option-description">'.$meta_box['description'].'</span>';
			echo '</div>';
			
			echo '<script type="text/javascript">jQuery(document).ready(function($){
				$("#'.$meta_box['name'].'").ColorPicker({
					onSubmit: function(hsb, hex, rgb, el) {
						$(el).val(hex);
						$(el).css("background", "#"+hex);
						$(el).ColorPickerHide();
					},
					onBeforeShow: function () {
						$(this).ColorPickerSetColor(this.value);
					},
					onHide: function (colpkr) {
					$(colpkr).fadeOut(500);
					return false;
					}
				})
				.bind("keyup", function(){
					$(this).ColorPickerSetColor(this.value);
				});
			});</script>'; 
			break;
		case 'upload':
			echo '<div class="option-container">';
			echo'<input type="hidden" name="'.$meta_box['name'].'_noncename" id="'.$meta_box['name'].'_noncename" value="'.wp_create_nonce( plugin_basename(__FILE__) ).'" />';

			echo'<h4 class="page-option-title">'.$meta_box['title'].'</h4>';

			echo'<input type="text" name="'.$meta_box['name'].'_value" value="'.$meta_box_value.'" id="designare-'.$meta_box['name'].'" class="option-input upload"/>';

			echo '<div id="designare-'.$meta_box['name'].'_button" class="upload-button upload-logo" ><a class="button button-upload"><span>Upload</span></a></div><br/>';

			//call the script for this upload button particularly
			echo '<script type="text/javascript">jQuery(document).ready(function($){
				designareOptions.loadUploader(jQuery("div#designare-'.$meta_box['name'].'_button"), "'.DESIGNARE_UTILS_URL.'upload-handler.php", "'.DESIGNARE_UPLOADS_URL.'");
			});</script>'; 
			
			echo '<ul><li><img src="' . $meta_box_value . '" width="200px"></li></ul>';
				
			echo'<span class="option-description">'.$meta_box['description'].'</span>';
			echo '</div>';
			break;
			
		case 'textarea':
			echo '<div class="option-container">';
			echo'<input type="hidden" name="'.$meta_box['name'].'_noncename" id="'.$meta_box['name'].'_noncename" value="'.wp_create_nonce( plugin_basename(__FILE__) ).'" />';

			echo'<h4 class="page-option-title">'.$meta_box['title'].'</h4>';

			echo'<textarea name="'.$meta_box['name'].'_value" class="option-textarea" />'.$meta_box_value.'</textarea><br />';

			if (!isset($meta_box['description'])) $meta_box['description'] = "";
			echo'<span class="option-description">'.$meta_box['description'].'</span>';
			echo '</div>';
		break;
		case 'select':
			echo '<div class="option-container">';
			echo'<input type="hidden" name="'.$meta_box['name'].'_noncename" id="'.$meta_box['name'].'_noncename" value="'.wp_create_nonce( plugin_basename(__FILE__) ).'" />';

			echo'<h4 class="page-option-title">'.$meta_box['title'].'</h4>';
			echo '<select name="'.$meta_box['name'].'_value" id="'.$meta_box['name'].'_value">';

				
			if(sizeof($meta_box['options'])>0){
				foreach ($meta_box['options'] as $option) { 
					if (isset($option['id'])){
				?>
					<option
					<?php if ( $meta_box_value == $option['id']) {
						echo ' selected="selected"';
					}
					if ($option['id']=='disabled') {
						echo ' disabled="disabled"';
					}
					
					if (isset($option['class'])){
						if ($option['class']!=null) {
							echo ' class="'.$option['class'].'"';
						}
					}
					?>
						value="<?php echo($option['id']);?>"><?php echo $option['name']; ?></option>
					<?php
					}

				}
			}
			echo '</select>';
			if (isset($meta_box['description']))
				echo'<span class="option-description">'.$meta_box['description'].'</span>';
			echo '</div>';
		break;
			
		case 'selectHomeStyle':
			echo '<div class="option-container">';
			echo'<input type="hidden" name="'.$meta_box['name'].'_noncename" id="'.$meta_box['name'].'_noncename" value="'.wp_create_nonce( plugin_basename(__FILE__) ).'" />';

			echo'<h4 class="page-option-title">'.$meta_box['title'].'</h4>';
			echo '<div class="temppath" style="display:none;">'.get_template_directory_uri().'</div>';
			echo '<select name="'.$meta_box['name'].'_value" id="'.$meta_box['name'].'_value">';


			if(sizeof($meta_box['options'])>0){
				foreach ($meta_box['options'] as $option) { 
				?> 
				<option
					<?php if ( $meta_box_value == $option['id']) {
						echo ' selected="selected"';
					}
					if ($option['id']=='disabled') {
						echo ' disabled="disabled"';
					}

					if (isset($option['class'])){
						if ($option['class']!=null) {
							echo ' class="'.$option['class'].'"';
						}
					}
					?>
						value="<?php echo($option['id']);?>"><?php echo $option['name']; ?></option>
					<?php

				}
			}
			echo '</select>';
			if (isset($meta_box['description']))
				echo'<span class="option-description">'.$meta_box['description'].'</span>';
			echo '</div>';
		break;
			
		case 'textarea':
			echo '<div class="option-container">';
			echo'<input type="hidden" name="'.$meta_box['name'].'_noncename" id="'.$meta_box['name'].'_noncename" value="'.wp_create_nonce( plugin_basename(__FILE__) ).'" />';

			echo'<h4 class="page-option-title">'.$meta_box['title'].'</h4>';

			echo'<textarea name="'.$meta_box['name'].'_value" class="option-textarea" />'.$meta_box_value.'</textarea><br />';

			echo'<span class="option-description">'.$meta_box['description'].'</span>';
			echo '</div>';
		break;	
		
		
		
		
		
		case 'pattern':
			echo '<div class="option-container patterns">';
			echo'<input type="hidden" name="'.$meta_box['name'].'_noncename" id="'.$meta_box['name'].'_noncename" value="'.wp_create_nonce( plugin_basename(__FILE__) ).'" />';

			echo'<h4 class="page-option-title">'.$meta_box['title'].'</h4>';
			
			echo '<select style="display:none;" name="'.$meta_box['name'].'_value" id="'.$meta_box['name'].'_value">';
			if(sizeof($meta_box['options'])>0){
				foreach ($meta_box['options'] as $option) { 
				?> <option
					<?php if ( $meta_box_value == $option['id']) {
						echo ' selected="selected"';
					}
					if ($option['id']=='disabled') {
						echo ' disabled="disabled"';
					}
					
					if (isset($option['class'])){
						if ($option['class']!=null) {
							echo ' class="'.$option['class'].'"';
						}
					}
					?>
						value="<?php echo($option['id']);?>"><?php echo $option['name']; ?></option>
					<?php

				}
			} 
			echo '</select>';
			
			echo '<div class="patterns_list" name="'.$meta_box['name'].'_value" id="'.$meta_box['name'].'_value">';
			if(sizeof($meta_box['options'])>0){
				foreach ($meta_box['options'] as $option) { 
					if ($option['name'] != "none"){
						?> <div onclick="jQuery(this).addClass('selected').siblings().removeClass('selected');jQuery(this).parent().siblings('select').val('<?php echo $option['id']; ?>');" style="background-image:url(<?php echo get_template_directory_uri().'/images/yunik_patterns/'.$option['name'] ?>);" class="pattern_item
						<?php if ( $meta_box_value == $option['id']) {
							echo ' selected';
						}
						echo '"';
						?>
							value="<?php echo($option['id']);?>"></div>
						<?php	
					}
				}
			} 
			echo '</div>';
			
			if (isset($meta_box['description']))
				echo'<span class="option-description">'.$meta_box['description'].'</span>';
			echo '</div>';
		break;
			
			
			
			
			
		
		case 'mediaupload':
		
			static $muindex = 1;
		
			echo '<div class="option-container mediauploader-'.$muindex.'">';
			?>
			<h4 class="page-option-title"><?php echo $meta_box['title']; ?></h4>
			<div class="description <?php echo $meta_box['name']; ?>" style="margin-bottom:10px;">
				<strong>Notice:</strong> The Preview Image will be the Image set as Featured Image.
			</div>
			<?php echo '<input type="hidden" name="'.$meta_box['name'].'_noncename" id="'.$meta_box['name'].'_noncename" value="'.wp_create_nonce( plugin_basename(__FILE__) ).'" />'; ?>
			<div class="thumb_slides_container" style="position:relative;float:left;width:100%;clear:both;padding-bottom:40px;"></div>
			<div class="uploader">
			  <textarea type="textarea" name="<?php echo $meta_box['name']."_value" ?>" id="_slider_images-<?php echo $muindex; ?>" style="display:none;"><?php echo $meta_box_value; ?></textarea>
			  <input class="button buttonUploader" name="_slider_images-<?php echo $muindex; ?>_button" id="_slider_images-<?php echo $muindex; ?>_button" value="Insert Images" style="width:auto;text-align:center;"/>
			</div>
			
			<script type="text/javascript">
				jQuery(document).ready(function($){
								
				  var _custom_media = true,
				      _orig_send_attachment = wp.media.editor.send.attachment;
				  
				  var thumbs = jQuery('.mediauploader-<?php echo $muindex; ?> #_slider_images-<?php echo $muindex; ?>').val().split('|*|');
				  for (var i = 0; i < thumbs.length; i++){
					  if (thumbs[i] != ""){
						  var url = thumbs[i].split("|!|")[1];
						  var id = thumbs[i].split("|!|")[0];
						  jQuery('.mediauploader-<?php echo $muindex; ?> .thumb_slides_container').append('<div class="thumb_cont elem-'+id+'" style="border: 4px solid #ededed;position:relative;display:inline-block;float:left;width:160px;height:145px;margin:5px;cursor: move;"><img src='+url+' style="width:100%;height:100%;" /><a href="post.php?post='+id+'&action=edit" style="position:absolute;top:5px;right:35px;width:30px;height:30px;background:url(<?php echo get_template_directory_uri(); ?>/img/admin-edit-icon.png) no-repeat;cursor:pointer;" title="Edit Image" class="editImage" target="_blank"></a><a title="Delete Image" class="removeImage" style="position:absolute;top:5px;right:5px;width:30px;height:30px;background:url(<?php echo get_template_directory_uri(); ?>/img/admin-delete-icon.png) no-repeat;cursor:pointer;" onclick="jQuery(this).parent(\'.thumb_cont\').remove(); var newVal = jQuery(\'#_slider_images-<?php echo $muindex; ?>\').val(); newVal = newVal.replace(\''+id+'|!|'+url+'|*|\', \'\'); jQuery(\'#_slider_images-<?php echo $muindex; ?>\').val(newVal);" ></a></div>');
					  }
				  }
				  
				  jQuery('.mediauploader-<?php echo $muindex; ?> .thumb_slides_container').sortable({
				  	placeholder: '.mediauploader-<?php echo $muindex; ?> .thumb_slides_container',
				  	dropOnEmpty: true,
				  	forceHelperSize: true,
				  	appendTo: "parent",
				  	start: function(event,ui){
					  	ui.item.css({
						  	'transition': 'none',
							'-webkit-transition': 'none',
							'-moz-transition': 'none',
							'-ms-transition': 'none',
							'-o-transition': 'none'
					  	});
				  	},
					stop: function(event,ui){
						var newVal = "";
						jQuery('.mediauploader-<?php echo $muindex; ?> .thumb_slides_container .thumb_cont').each(function(){
							newVal += jQuery(this).attr('class').split('thumb_cont elem-')[1] + '|!|' + jQuery(this).find('img').attr('src') + '|*|';
						});
						jQuery('.mediauploader-<?php echo $muindex; ?> #_slider_images-<?php echo $muindex; ?>').val(newVal);
					}
				  });
				  
				  
				  $('.mediauploader-<?php echo $muindex; ?> .buttonUploader').click(function(e) {
				  	e.stopPropagation();
				  	e.preventDefault();
				    var send_attachment_bkp = wp.media.editor.send.attachment;
				    var button = $(this);
				    var id = button.attr('id').replace('_button', '');
				    _custom_media = true;
				    wp.media.editor.send.attachment = function(props, attachment){
				    	jQuery('.mediauploader-<?php echo $muindex; ?> .thumb_slides_container').append('<div class="thumb_cont elem-'+attachment.id+'" style="border: 4px solid #ededed;position:relative;display:inline-block;float:left;width:160px;height:145px;margin:5px;cursor: move;"><img src='+attachment.url+' style="width:100%;height:100%;" /><a href="post.php?post='+attachment.id+'&action=edit" style="position:absolute;top:5px;right:35px;width:30px;height:30px;background:url(<?php echo get_template_directory_uri(); ?>/img/admin-edit-icon.png) no-repeat;cursor:pointer;" title="Edit Image" class="editImage" target="_blank"></a><a title="Delete Image" class="removeImage" style="position:absolute;top:5px;right:5px;width:30px;height:30px;background:url(<?php echo get_template_directory_uri(); ?>/img/admin-delete-icon.png) no-repeat;cursor:pointer;" onclick="jQuery(this).parent(\'.thumb_cont\').remove(); var newVal = jQuery(\'#_slider_images\').val(); newVal = newVal.replace(\''+attachment.id+'|!|'+attachment.url+'|*|\', \'\'); jQuery(\'#_slider_images\').val(newVal);" ></a></div>');
				      if ( _custom_media ) {
				        jQuery(".mediauploader-<?php echo $muindex; ?> #"+id).val(jQuery(".mediauploader-<?php echo $muindex; ?> #"+id).val() + attachment.id + "|!|" + attachment.url + "|*|");
				      } else {
				        return _orig_send_attachment.apply( this, [props, attachment] );
				      };
				    }
				
				    wp.media.editor.open(button);
				    return false;
				  });
				
				  $('.mediauploader-<?php echo $muindex; ?> .add_media').on('click', function(){
				    _custom_media = false;
				  });
				});
				
				
			</script>
			
			<?php $muindex++;
			echo "</div>";
			break;
		
		case 'mediauploadHome':

			echo '<div class="option-container mediauploadHome">';
			?>
			<h4 class="page-option-title"><?php echo $meta_box['title']; ?></h4>

			<?php echo '<input type="hidden" name="'.$meta_box['name'].'_noncename" id="'.$meta_box['name'].'_noncename" value="'.wp_create_nonce( plugin_basename(__FILE__) ).'" />'; ?>
			<div class="thumb_slides_container" style="position:relative;float:left;clear:both;padding-bottom:40px;"></div>
			
			<div class="uploader" style="position:relative;float:left;width:100%;">
			  <textarea type="textarea" name="<?php echo $meta_box['name']."_value" ?>" id="_slider_images" style="display:none;"><?php echo $meta_box_value; ?></textarea>
			  <input class="button buttonUploader" name="_slider_images_button" id="_slider_images_button" value="Select Media" style="width:auto;text-align:center;"/>
			</div>

			<script type="text/javascript">
				jQuery(document).ready(function($){

				  var _custom_media = true,
				      _orig_send_attachment = wp.media.editor.send.attachment;

				  var thumbs = jQuery('#_slider_images').val().split('|*|');
				  for (var i = 0; i < thumbs.length; i++){
					  if (thumbs[i] != ""){
						  var id = thumbs[i].split("|!|")[0];
						  var url = thumbs[i].split("|!|")[1];
						  var type = thumbs[i].split("|!|")[2];
						  if (type === "video"){
							  	jQuery('.thumb_slides_container').append('<div class="thumb_cont elem-'+id+'" style="position:relative;display:inline-block;float:left;width:500px;height:auto;margin:0px auto;cursor: move;"><video style="border: 4px solid #ededed;width:100%;height:100%;" controls><source src="'+url+'" ></video><a href="post.php?post='+id+'&action=edit" style="position:absolute;top:10px;right:35px;width:26px;height:23px;background:url(<?php echo get_template_directory_uri(); ?>/img/admin-edit-icon.png) no-repeat;cursor:pointer;" title="Edit Image" class="editImage" target="_blank"></a><a title="Delete Image" class="removeImage" style="position:absolute;top:10px;right:5px;width:26px;height:23px;background:url(<?php echo get_template_directory_uri(); ?>/img/admin-delete-icon.png) no-repeat;cursor:pointer;" onclick="jQuery(this).parent(\'.thumb_cont\').remove(); var newVal = jQuery(\'#_slider_images\').val(); newVal = newVal.replace(\''+id+'|!|'+url+'|*|\', \'\'); jQuery(\'#_slider_images\').val(newVal);" ></a></div>');
						  } else {
								jQuery('.thumb_slides_container').append('<div class="thumb_cont elem-'+id+'" style="border: 4px solid #ededed;position:relative;display:inline-block;float:left;max-width:500px;height:auto;margin:5px;cursor: move;"><img src='+url+' style="width:100%;height:100%;" /><a href="post.php?post='+id+'&action=edit" style="position:absolute;top:5px;right:35px;width:26px;height:23px;background:url(<?php echo get_template_directory_uri(); ?>/img/admin-edit-icon.png) no-repeat;cursor:pointer;" title="Edit Image" class="editImage" target="_blank"></a><a title="Delete Image" class="removeImage" style="position:absolute;top:5px;right:5px;width:26px;height:23px;background:url(<?php echo get_template_directory_uri(); ?>/img/admin-delete-icon.png) no-repeat;cursor:pointer;" onclick="jQuery(this).parent(\'.thumb_cont\').remove(); var newVal = jQuery(\'#_slider_images\').val(); newVal = newVal.replace(\''+id+'|!|'+url+'|*|\', \'\'); jQuery(\'#_slider_images\').val(newVal);" ></a></div>');  
						  }
					  }
				  }

				  jQuery('.mediauploadHome .buttonUploader').click(function(e) {
				  		var button = $(this);
				  		var id = button.attr('id').replace('_button', '');
					  	var custom_uploader = wp.media({
						    title: 'Select Media',
						    button: {
						        text: 'Select Media'
						    },
						    multiple: (jQuery('#homeStyle_value').val() === "video") ? true : false
						})
						.on('select', function() {
						    var attachment = custom_uploader.state().get('selection').first().toJSON();
							var totalAttach = custom_uploader.state().get('selection').toJSON();							
						    if (attachment){
						    	jQuery('.thumb_slides_container').html('');
							 	if (attachment.type === "video"){
									var output = '<div class="thumb_cont elem-'+attachment.id+'" style="position:relative;display:inline-block;float:left;width:500px;height:auto;margin:0px auto;cursor: move;"><video style="border: 4px solid #ededed;width:100%;height:100%;" controls>'; 
									for (var i=0; i < totalAttach.length; i++){
										output += '<source src="'+totalAttach[i].url+'" type="video/'+totalAttach[i].url.split('.').pop()+'">';
									}
									output += '</video><a href="post.php?post='+attachment.id+'&action=edit" style="position:absolute;top:10px;right:35px;width:26px;height:23px;background:url(<?php echo get_template_directory_uri(); ?>/img/admin-edit-icon.png) no-repeat;cursor:pointer;" title="Edit Image" class="editImage" target="_blank"></a><a title="Delete Image" class="removeImage" style="position:absolute;top:10px;right:5px;width:26px;height:23px;background:url(<?php echo get_template_directory_uri(); ?>/img/admin-delete-icon.png) no-repeat;cursor:pointer;" onclick="jQuery(this).parent(\'.thumb_cont\').remove(); var newVal = jQuery(\'#_slider_images\').val(); newVal = newVal.replace(\''+attachment.id+'|!|'+attachment.url+'|*|\', \'\'); jQuery(\'#_slider_images\').val(newVal);" ></a></div>';
								    jQuery('.thumb_slides_container').append(output);
							    } else {
								    jQuery('.thumb_slides_container').append('<div class="thumb_cont elem-'+attachment.id+'" style="position:relative;display:inline-block;float:left;max-width:500px;height:auto;margin:5px;cursor: move;"><img src='+attachment.url+' style="border: 4px solid #ededed;width:100%;height:100%;" /><a href="post.php?post='+attachment.id+'&action=edit" style="position:absolute;top:10px;right:35px;width:26px;height:23px;background:url(<?php echo get_template_directory_uri(); ?>/img/admin-edit-icon.png) no-repeat;cursor:pointer;" title="Edit Image" class="editImage" target="_blank"></a><a title="Delete Image" class="removeImage" style="position:absolute;top:10px;right:5px;width:26px;height:23px;background:url(<?php echo get_template_directory_uri(); ?>/img/admin-delete-icon.png) no-repeat;cursor:pointer;" onclick="jQuery(this).parent(\'.thumb_cont\').remove(); var newVal = jQuery(\'#_slider_images\').val(); newVal = newVal.replace(\''+attachment.id+'|!|'+attachment.url+'|*|\', \'\'); jQuery(\'#_slider_images\').val(newVal);" ></a></div>');
							    }
						    }
							if (totalAttach.length > 1){
								var newVal = "";
								for (var i=0; i < totalAttach.length; i++){
									newVal += totalAttach[i].id + "|!|" + totalAttach[i].url + "|!|" + totalAttach[i].type + "|*|";
								}
								jQuery('#'+id).val(newVal);
							} else jQuery("#"+id).val(attachment.id + "|!|" + attachment.url + "|!|" + attachment.type);
						})
						.open(button);
						return false;
				});

			});
			</script>
			</div>
			<?php
			break;
			
			case 'mediauploadHome_video':

				echo '<div class="option-container">';
				?>
				<h4 class="page-option-title"><?php echo $meta_box['title']; ?></h4>

				<?php echo '<input type="hidden" name="'.$meta_box['name'].'_noncename" id="'.$meta_box['name'].'_noncename" value="'.wp_create_nonce( plugin_basename(__FILE__) ).'" />'; ?>
				<div class="thumb_slides_container_video" style="position:relative;float:left;clear:both;padding-bottom:40px;"></div>

				<div class="uploader" style="position:relative;float:left;width:100%;">
				  <textarea type="textarea" name="<?php echo $meta_box['name']."_value" ?>" id="_slider_video" style="display:none;"><?php echo $meta_box_value; ?></textarea>
					<span class="option-description videoHelper" style="width:100%;">In case you choose video from the Media Library, you can select them in multiple formats so it will be available cross browser.</span>
				  <input class="button buttonUploader_video" name="_slider_video_button" id="_slider_video_button" value="Select Media" style="width:auto;text-align:center;"/>
				</div>

				<script type="text/javascript">
					jQuery(document).ready(function($){

					  var _custom_media = true,
					      _orig_send_attachment = wp.media.editor.send.attachment;

					  var thumbs = jQuery('#_slider_video').val().split('|*|');
					  for (var i = 0; i < thumbs.length; i++){
						  if (thumbs[i] != ""){
							  var id = thumbs[i].split("|!|")[0];
							  var url = thumbs[i].split("|!|")[1];
							  var type = thumbs[i].split("|!|")[2];
							  var output = '<div class="thumb_cont elem-'+id+'" style="position:relative;display:inline-block;float:left;width:100%;height:auto;margin:0px auto;cursor: move;"><video style="border: 4px solid #ededed;width:100%;height:100%;" controls>';
							  if (type === "video"){
									output += '<source src="'+url+'"';
							  }
							output += '</video><a href="post.php?post='+id+'&action=edit" style="position:absolute;top:10px;right:35px;width:26px;height:23px;background:url(<?php echo get_template_directory_uri(); ?>/img/admin-edit-icon.png) no-repeat;cursor:pointer;" title="Edit Image" class="editImage" target="_blank"></a><a title="Delete Image" class="removeImage" style="position:absolute;top:10px;right:5px;width:26px;height:23px;background:url(<?php echo get_template_directory_uri(); ?>/img/admin-delete-icon.png) no-repeat;cursor:pointer;" onclick="jQuery(this).parent(\'.thumb_cont\').remove(); var newVal = jQuery(\'#_slider_video\').val(); newVal = newVal.replace(\''+id+'|!|'+url+'|*|\', \'\'); jQuery(\'#_slider_video\').val(newVal);" ></a></div>';
						  }
					  }
					  jQuery('.thumb_slides_container_video').append(output);
					
					  jQuery('.buttonUploader_video').click(function(e) {
					  		var button = $(this);
					  		var id = button.attr('id').replace('_button', '');
						  	var custom_uploader = wp.media({
							    title: 'Select Media',
							    button: {
							        text: 'Select Media'
							    },
							    multiple: true,
							    library: { type: 'video' }
							})
							.on('select', function() {
							    var attachment = custom_uploader.state().get('selection').first().toJSON();
								var totalAttach = custom_uploader.state().get('selection').toJSON();							
							    if (attachment){
							    	jQuery('.thumb_slides_container_video').html('');
								 	if (attachment.type === "video"){
										var output = '<div class="thumb_cont elem-'+attachment.id+'" style="position:relative;display:inline-block;float:left;width:100%;height:auto;margin:0px auto;cursor: move;"><video style="border: 4px solid #ededed;width:100%;height:100%;" controls>'; 
										for (var i=0; i < totalAttach.length; i++){
											output += '<source src="'+totalAttach[i].url+'" type="video/'+totalAttach[i].url.split('.').pop()+'">';
										}
										output += '</video><a href="post.php?post='+attachment.id+'&action=edit" style="position:absolute;top:10px;right:35px;width:26px;height:23px;background:url(<?php echo get_template_directory_uri(); ?>/img/admin-edit-icon.png) no-repeat;cursor:pointer;" title="Edit Image" class="editImage" target="_blank"></a><a title="Delete Image" class="removeImage" style="position:absolute;top:10px;right:5px;width:26px;height:23px;background:url(<?php echo get_template_directory_uri(); ?>/img/admin-delete-icon.png) no-repeat;cursor:pointer;" onclick="jQuery(this).parent(\'.thumb_cont\').remove(); var newVal = jQuery(\'#_slider_video\').val(); newVal = newVal.replace(\''+attachment.id+'|!|'+attachment.url+'|*|\', \'\'); jQuery(\'#_slider_video\').val(newVal);" ></a></div>';
									    jQuery('.thumb_slides_container_video').append(output);
								    }
							    }
								if (totalAttach.length > 1){
									var newVal = "";
									for (var i=0; i < totalAttach.length; i++){
										newVal += totalAttach[i].id + "|!|" + totalAttach[i].url + "|!|" + totalAttach[i].type + "|*|";
									}
									jQuery('#'+id).val(newVal);
								} else jQuery("#"+id).val(attachment.id + "|!|" + attachment.url + "|!|" + attachment.type);
							})
							.open(button);
							return false;
					});

				});
				</script>
				</div>
				<?php
				break;
				
		case 'mediaupload_audio':

			echo '<div class="option-container">';
			?>
			<h4 class="page-option-title"><?php echo $meta_box['title']; ?></h4>

			<?php echo '<input type="hidden" name="'.$meta_box['name'].'_noncename" id="'.$meta_box['name'].'_noncename" value="'.wp_create_nonce( plugin_basename(__FILE__) ).'" />'; ?>
			<div class="thumb_slides_container_audio" style="position:relative;float:left;clear:both;padding-bottom:40px;"></div>

			<div class="uploader" style="position:relative;float:left;width:100%;">
			  <textarea type="textarea" name="<?php echo $meta_box['name']."_value" ?>" id="_slider_audio" style="display:none;"><?php echo $meta_box_value; ?></textarea>
			  <input class="button buttonUploader_audio" name="_slider_audio_button" id="_slider_audio_button" value="Select Media" style="width:auto;text-align:center;"/>
			</div>

			<script type="text/javascript">
				jQuery(document).ready(function($){

				  var _custom_media = true,
				      _orig_send_attachment = wp.media.editor.send.attachment;
				  
				  var thumbs = jQuery('#_slider_audio').val().split('|*|');
				  for (var i = 0; i < thumbs.length; i++){
					  if (thumbs[i] != ""){
						  var id = thumbs[i].split("|!|")[0];
						  var url = thumbs[i].split("|!|")[1];
						  var type = thumbs[i].split("|!|")[2];
						  var output = '<div class="thumb_cont elem-'+id+'" style="position:relative;display:inline-block;float:left;width:400px;height:auto;margin:0px auto;cursor: move;left:-3px;top:20px;"><audio style="border: 4px solid #ededed;width:100%;height:100%;" controls>';
						  if (type === "audio"){
								output += '<source src="'+url+'"';
						  }
						output += '</audio><a href="post.php?post='+id+'&action=edit" style="position:absolute;top:10px;right:35px;width:26px;height:23px;background:url(<?php echo get_template_directory_uri(); ?>/img/admin-edit-icon.png) no-repeat;cursor:pointer;" title="Edit Image" class="editImage" target="_blank"></a><a title="Delete Image" class="removeImage" style="position:absolute;top:10px;right:5px;width:26px;height:23px;background:url(<?php echo get_template_directory_uri(); ?>/img/admin-delete-icon.png) no-repeat;cursor:pointer;" onclick="jQuery(this).parent(\'.thumb_cont\').remove(); var newVal = jQuery(\'#_slider_audio\').val(); newVal = newVal.replace(\''+id+'|!|'+url+'|*|\', \'\'); jQuery(\'#_slider_audio\').val(newVal);" ></a></div>';
					  }
				  }
				  jQuery('.thumb_slides_container_audio').append(output);
				
				  jQuery('.buttonUploader_audio').click(function(e) {
				  		var button = $(this);
				  		var id = button.attr('id').replace('_button', '');
					  	var custom_uploader = wp.media({
						    title: 'Select Media',
						    button: {
						        text: 'Select Audio File'
						    },
						    multiple: true,
						    library : { type : 'audio'}
						})
						.on('select', function() {
						    var attachment = custom_uploader.state().get('selection').first().toJSON();
							var totalAttach = custom_uploader.state().get('selection').toJSON();							
						    if (attachment){
						    	jQuery('.thumb_slides_container_audio').html('');
							 	if (attachment.type === "audio"){
									var output = '<div class="thumb_cont elem-'+attachment.id+'" style="position:relative;display:inline-block;float:left;width:500px;height:auto;margin:0px auto;cursor: move;"><audio style="border: 4px solid #ededed;width:100%;height:100%;" controls>'; 
									for (var i=0; i < totalAttach.length; i++){
										output += '<source src="'+totalAttach[i].url+'" type="audio/'+totalAttach[i].url.split('.').pop()+'">';
									}
									output += '</audio><a href="post.php?post='+attachment.id+'&action=edit" style="position:absolute;top:10px;right:35px;width:26px;height:23px;background:url(<?php echo get_template_directory_uri(); ?>/img/admin-edit-icon.png) no-repeat;cursor:pointer;" title="Edit Image" class="editImage" target="_blank"></a><a title="Delete Image" class="removeImage" style="position:absolute;top:10px;right:5px;width:26px;height:23px;background:url(<?php echo get_template_directory_uri(); ?>/img/admin-delete-icon.png) no-repeat;cursor:pointer;" onclick="jQuery(this).parent(\'.thumb_cont\').remove(); var newVal = jQuery(\'#_slider_audio\').val(); newVal = newVal.replace(\''+attachment.id+'|!|'+attachment.url+'|*|\', \'\'); jQuery(\'#_slider_audio\').val(newVal);" ></a></div>';
								    jQuery('.thumb_slides_container_audio').append(output);
							    }
						    }
							if (totalAttach.length > 1){
								var newVal = "";
								for (var i=0; i < totalAttach.length; i++){
									newVal += totalAttach[i].id + "|!|" + totalAttach[i].url + "|!|" + totalAttach[i].type + "|*|";
								}
								jQuery('#'+id).val(newVal);
							} else jQuery("#"+id).val(attachment.id + "|!|" + attachment.url + "|!|" + attachment.type);
						})
						.open(button);
						return false;
				});

			});
			</script>
			</div>
			<?php
		break;
				

		case "introLogoUpload":
			echo '<div class="option-container">';
			?>
			<h4 class="page-option-title"><?php echo $meta_box['title']; ?></h4>

			<?php echo '<input type="hidden" name="'.$meta_box['name'].'_noncename" id="'.$meta_box['name'].'_noncename" value="'.wp_create_nonce( plugin_basename(__FILE__) ).'" />'; ?>
			<div class="logo_intro_container" style="position:relative;float:left;width:100%;clear:both;padding-bottom:40px;"></div>
			<div class="uploader">
			  <textarea type="textarea" name="<?php echo $meta_box['name']."_value" ?>" id="_logo_intro_images" style="display:none;"><?php echo $meta_box_value; ?></textarea>
				
			  <input class="button logoUploader" name="_logo_intro_images_button" id="_logo_intro_images_button" value="Select Media" style="width:auto;text-align:center;"/>
			</div>

			<script type="text/javascript">
				jQuery(document).ready(function($){

				  var _custom_media = true,
				      _orig_send_attachment = wp.media.editor.send.attachment;

				  var thumbs = jQuery('#_logo_intro_images').val().split('|*|');
				  for (var i = 0; i < thumbs.length; i++){
					  if (thumbs[i] != ""){
						  var id = thumbs[i].split("|!|")[0];
						  var url = thumbs[i].split("|!|")[1];
						  var type = thumbs[i].split("|!|")[2];
						  jQuery('.logo_intro_container').append('<div class="thumb_cont elem-'+id+'" style="min-width: 200px;border: 4px solid #ededed;position:relative;display:inline-block;float:left;max-width:500px;height:auto;margin:5px;cursor: move;line-height:0px;"><img src='+url+' style="width:100%;height:100%;" /><a href="post.php?post='+id+'&action=edit" style="position:absolute;top:5px;right:35px;width:26px;height:23px;background:url(<?php echo get_template_directory_uri(); ?>/img/admin-edit-icon.png) no-repeat;cursor:pointer;" title="Edit Image" class="editImage" target="_blank"></a><a title="Delete Image" class="removeImage" style="position:absolute;top:5px;right:5px;width:26px;height:23px;background:url(<?php echo get_template_directory_uri(); ?>/img/admin-delete-icon.png) no-repeat;cursor:pointer;" onclick="jQuery(this).parent(\'.thumb_cont\').remove(); var newVal = jQuery(\'#_logo_intro_images\').val(); newVal = newVal.replace(\''+id+'|!|'+url+'|*|\', \'\'); jQuery(\'#_logo_intro_images\').val(newVal);" ></a></div>');  
					  }
				  }

				  jQuery('.logoUploader').click(function(e) {
				  		var button = $(this);
				  		var id = button.attr('id').replace('_button', '');
					  	var custom_uploader = wp.media({
						    title: 'Select Media',
						    button: {
						        text: 'Select Media'
						    },
						    multiple: false
						})
						.on('select', function() {
						    var attachment = custom_uploader.state().get('selection').first().toJSON();
						    if (attachment){
						    	jQuery('.logo_intro_container').html('');
							    jQuery('.logo_intro_container').append('<div class="thumb_cont elem-'+attachment.id+'" style="min-width: 200px;position:relative;display:inline-block;float:left;max-width:500px;height:auto;margin:5px;cursor: move;line-height:0px;"><img src='+attachment.url+' style="border: 4px solid #ededed;width:100%;height:100%;" /><a href="post.php?post='+attachment.id+'&action=edit" style="position:absolute;top:10px;right:35px;width:26px;height:23px;background:url(<?php echo get_template_directory_uri(); ?>/img/admin-edit-icon.png) no-repeat;cursor:pointer;" title="Edit Image" class="editImage" target="_blank"></a><a title="Delete Image" class="removeImage" style="position:absolute;top:10px;right:5px;width:26px;height:23px;background:url(<?php echo get_template_directory_uri(); ?>/img/admin-delete-icon.png) no-repeat;cursor:pointer;" onclick="jQuery(this).parent(\'.thumb_cont\').remove(); var newVal = jQuery(\'#_logo_intro_images\').val(); newVal = newVal.replace(\''+attachment.id+'|!|'+attachment.url+'|*|\', \'\'); jQuery(\'#_logo_intro_images\').val(newVal);" ></a></div>');
						    }
						    jQuery("#"+id).val(attachment.id + "|!|" + attachment.url + "|!|" + attachment.type);
						})
						.open(button);
						return false;
				});

			});
			</script>
			</div>
			<?php
		break;
		
		case "opacity_slider":
			echo '<div class="option-container">';
			
			echo'<input type="hidden" name="'.$meta_box['name'].'_noncename" id="'.$meta_box['name'].'_noncename" value="'.wp_create_nonce( plugin_basename(__FILE__) ).'" />';

//			echo'<input type="hidden" name="'.$meta_box['name'].'_noncename" id="'.$meta_box['name'].'_noncename" value="'.$meta_box_value.'" />';

			echo'<h4 class="page-option-title">'.$meta_box['title'].'</h4>';
			
			echo '<div class="slider_container" style="position:relative;float:left;width:40%;top:13px;"><div class="slider opacity-slider" id="'.$meta_box['name'].'_slider" title="'.$meta_box['name'].'_helper_input"></div><input class="option-input slider-input" name="'.$meta_box['name'].'_helper_input" id="'.$meta_box['name'].'_helper_input" type="text" value="'.$meta_box_value.'" style="border: 0; background: none; color: #314572; padding: 0; margin: 0; font-style: italic; box-shadow: none; -webkit-box-shadow: none;width:100%;text-align:center;margin-top:10px;" /></div>';

			if (isset($meta_box['description']) && $meta_box['description'] != "") echo'<span class="option-description">'.$meta_box['description'].'</span>';
			
			echo'<input type="text" id="'.$meta_box['name'].'_value" name="'.$meta_box['name'].'_value" value="'.$meta_box_value.'" class="option-input hidden" />';

			echo '</div>';
			
			echo '<script>jQuery(document).ready(function() {
				
				jQuery("#'.$meta_box['name'].'_slider").each(function(){
					
					var value = parseInt(jQuery("#'.$meta_box['name'].'_value").val(), 10);
					jQuery(this).slider({
						range: "min",
						value: value,
						min: 0,
						max: 100,
						slide: function( event, ui ) {
							jQuery("#'.$meta_box['name'].'_helper_input").val(ui.value+"%");
							jQuery("#'.$meta_box['name'].'_value").val( ui.value + " %" );
						}
					});
				
				}); });
				</script>';
		break;
	}
}


/**
 * Saves the meta box content of a page
 * @param $post_id the ID of the page that contains the meta box
 */
function save_postdata( $post_id ) {
	global $post, $designare_new_meta_boxes;

	if(get_post($post_id)->post_type=='page'){
		$designare_new_meta_boxes=$GLOBALS['designare_new_meta_boxes'];
		designare_save_meta_data($designare_new_meta_boxes, $post_id);
	}
}

/**
 * Saves the meta box content of a post
 * @param $post_id the ID of the post that contains the meta box
 */
function save_portfolio_postdata( $post_id ) {
	global $post, $designare_new_meta_portfolio_boxes;
	
	if(get_post($post_id)->post_type==DESIGNARE_PORTFOLIO_POST_TYPE){
		designare_save_meta_data($designare_new_meta_portfolio_boxes, $post_id);
	}
}

/**
 * Saves the meta box content of a post
 * @param $post_id the ID of the post that contains the meta box
 */
function save_testimonials_postdata( $post_id ) {
	global $post, $new_meta_testimonials_boxes;
	
	if(get_post($post_id)->post_type==DESIGNARE_TESTIMONIALS_POST_TYPE){
		designare_save_meta_data($new_meta_testimonials_boxes, $post_id);
	}
}

/**
 * Saves the meta box content of a post
 * @param $post_id the ID of the post that contains the meta box
 */
function save_partners_postdata( $post_id ) {
	global $post, $new_meta_partners_boxes;
	
	if(get_post($post_id)->post_type==DESIGNARE_PARTNERS_POST_TYPE){
		designare_save_meta_data($new_meta_partners_boxes, $post_id);
	}
}

/**
 * Saves the meta box content of a post
 * @param $post_id the ID of the post that contains the meta box
 */
function save_team_postdata( $post_id ) {
	global $post, $new_meta_team_boxes;
	
	if(get_post($post_id)->post_type==DESIGNARE_TEAM_POST_TYPE){
		designare_save_meta_data($new_meta_team_boxes, $post_id);
	}
}

/**
 * Saves the meta box content of a post
 * @param $post_id the ID of the post that contains the meta box
 */
function save_post_postdata( $post_id ) {
	global $post, $designare_new_meta_post_boxes;

	if(get_post($post_id)->post_type=='post'){
		designare_save_meta_data($designare_new_meta_post_boxes, $post_id);
	}
}

/**
 * Saves the post meta for all types of posts.
 * @param $designare_new_meta_boxes the meta data array
 * @param $post_id the ID of the post
 */
function designare_save_meta_data($designare_new_meta_boxes, $post_id){

	if (isset($designare_new_meta_boxes) && !empty($designare_new_meta_boxes)){
			foreach($designare_new_meta_boxes as $meta_box) {

			if( $meta_box['type']!='heading'){
				// Verify
				if (isset($meta_box['name']) && isset($_POST[$meta_box['name'].'_noncename'])){
					if ( !wp_verify_nonce( $_POST[$meta_box['name'].'_noncename'], plugin_basename(__FILE__) )) {
						return $post_id;
					}	
				}
				
				if (isset($_POST['post_type'])){
					if ( 'page' == $_POST['post_type'] ) {
						if ( !current_user_can( 'edit_page', $post_id ))
						return $post_id;
					} else {
						if ( !current_user_can( 'edit_post', $post_id ))
						return $post_id;
					}
	
				}
				
				if (isset($meta_box['name']) && isset($_POST[$meta_box['name'].'_value'])) $data = $_POST[$meta_box['name'].'_value'];
	
				if (isset($data)){
					if(get_post_meta($post_id, $meta_box['name'].'_value') == "")
					add_post_meta($post_id, $meta_box['name'].'_value', $data, true);
					elseif($data != get_post_meta($post_id, $meta_box['name'].'_value', true))
					update_post_meta($post_id, $meta_box['name'].'_value', $data);
					elseif($data == "")
					delete_post_meta($post_id, $meta_box['name'].'_value', get_post_meta($post_id, $meta_box['name'].'_value', true));		
				}
			
	
			}
		}	
	}
}

function print_helper(){
	echo '<div class="temppath" style="display:none;">'.get_template_directory_uri().'</div>';
	echo '<style>.mce-i-des-shortcode-icon{background: url('.get_template_directory_uri().'/images/shortcode-icon.png) no-repeat 3px 0px}</style>';
}