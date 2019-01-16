<?php

$google_fonts = des_get_all_google_fonts();
global $wpdb;

$table_name = $wpdb->prefix."revslider_sliders";
if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
    //table is not created. plugin is yet to install.
    //$revs = array();
    $revsliders = array();
} else {
	$revsliders = array();
	$q = "SELECT * from ".$wpdb->prefix."revslider_sliders";
	$revs = $wpdb->get_results($q, ARRAY_A);
	
	if ( $revs ) {
		foreach($revs as $r) {
			array_push($revsliders, array('id'=>"revSlider_".$r['alias'], 'name'=>$r['title']));	
		}
	}
	if (!count($revsliders)) $revsliders = array(array("id"=>"", "name"=>"You have no sliders created."));
}
/**
 * Load the patterns into arrays.
 */
$patterns=array();
$patterns[0]='none';
for($i=1; $i<=54; $i++){
	$patterns[]='pattern'.$i.'.jpg';
}

$colors = array('26ade4', '7AB317', 'F15A23', 'd63b33', 'EDB44D', 'FF005A', '9e4d9e', '5a7c96', '10b9b9', '709c3e', '91683d', '3691ad');

$designare_fonts_array = designare_fonts_array_builder();

$designare_styles_options=array( array(
"name" => "Style Editor",
"type" => "title",
"img" => DESIGNARE_IMAGES_URL.'icon_style.png'
),

array(
"type" => "open",
"subtitles"=>array(array("id"=>"general", "name"=>"General"), array("id"=>"website_loading","name"=>"Website Loading"), array("id"=>"header","name"=>"Header & Top Bar"), array("id"=>"logotype", "name"=>"Logotype"), array("id"=>"menu", "name" => "Menu"), array("id"=>"search", "name"=>"Search"), array("id"=>"pagetitle", "name"=>"Page Title"), array("id"=>"footer", "name"=>"Footer"), array("id"=>"text", "name"=>"Typography"), array("id"=>"impexp", "name" => "Import / Export Options"))
),

/* ------------------------------------------------------------------------*
 * GENERAL
 * ------------------------------------------------------------------------*/

array(
	"type" => "subtitle",
	"id" => 'general'
),

array(
	"type" => "documentation",
	"text" => '<h3>Global Style Color</h3>'
),

array(
	"name" => "Suggested Color",
	"id" => DESIGNARE_SHORTNAME."_style_defcolor",
	"type" => "stylecolor",
	"options" => $colors
),

array(
	"name" => "Custom Style Color",
	"id" => DESIGNARE_SHORTNAME."_style_color",
	"type" => "color",
	"std" => "EDB44D"
),

array(
	"type" => "documentation",
	"text" => "<h3>Layout Options</h3>"
),

array(
	"name" => "Layout Style",
	"id" => DESIGNARE_SHORTNAME."_body_type",
	"type" => "select",
	"options" => array(array('id'=>'body_wide','name'=>'Wide Layout'), array('id'=>'body_boxed','name'=>'Boxed Layout')),
	"std" => 'body_wide'
),

array(
	"name" => "Body Background Style",
	"id" => DESIGNARE_SHORTNAME."_bodybg_type",
	"type" => "select",
	"options" => array(array('id'=>'color','name'=>'Color'), array('id'=>'image','name'=>'Image')),
	"std" => 'color'
),

array(
	"name" => "Image",
	"id" => DESIGNARE_SHORTNAME."_bodybg_type_image",
	"type" => "upload_from_media",
),

array(
	"name" => "Color",
	"id" => DESIGNARE_SHORTNAME."_bodybg_type_color",
	"type" => "color",
	"std" => 'ffffff'
),


array(
	"type" => "close"
),


/* ------------------------------------------------------------------------*
 * WEBSITE LOADING
 * ------------------------------------------------------------------------*/
array(
	"type" => "subtitle",
	"id" => 'website_loading'
),

array(
	"type" => "documentation",
	"text" => '<h3>Website Loading</h3>'
),

array(
	"name" => "Background Color",
	"id" => DESIGNARE_SHORTNAME."_loader_background",
	"type" => "color",
	"std" => "ffffff"
),

array(
	"name" => "Loader Color",
	"id" => DESIGNARE_SHORTNAME."_loader_color",
	"type" => "color",
	"std" => "212121"
),

array(
	"name" => "Percentage Font",
	"id" => DESIGNARE_SHORTNAME."_loader_percentage_font",
	"type" => "select",
	"options" => $designare_fonts_array,
	"desc" => 'You can select one of the fonts that the theme goes with or you can add google fonts (Style Options > Fonts).',
	"std" => "Helvetica Neue"
),

array(
	"name" => "Percentage Font Size",
	"id" => DESIGNARE_SHORTNAME."_loader_percentage_font_size",
	"type" => "slider",
	"std" => "16px",
),

array(
	"name" => "Percentage Font Color",
	"id" => DESIGNARE_SHORTNAME."_loader_percentage_font_color",
	"type" => "color",
	"std" => "999999"
),

array(
	"type" => "close"
),


/* ------------------------------------------------------------------------*
 * HEADER
 * ------------------------------------------------------------------------*/
array(
	"type" => "subtitle",
	"id" => "header"
),

array(
	"type" => "documentation",
	"text" => "<h3>Top Bar</h3>"
),

array(
	"name" => "Background Color",
	"id" => DESIGNARE_SHORTNAME."_topbar_bg_color",
	"type" => "color",
	"std" => "f2f2f2"
),

array(
	"name" => "Background Opacity",
	"id" => DESIGNARE_SHORTNAME."_topbar_bg_opacity",
	"type" => "opacity_slider",
	"std" => "100"
),

array(
	"name" => "Text Color",
	"id" => DESIGNARE_SHORTNAME."_topbar_text_color",
	"type" => "color",
	"std" => "444444"
),

array(
	"name" => "Links Color",
	"id" => DESIGNARE_SHORTNAME."_topbar_links_color",
	"type" => "color",
	"std" => "444444"
),

array(
	"name" => "Links Hover Color",
	"id" => DESIGNARE_SHORTNAME."_topbar_links_hover_color",
	"type" => "color",
	"std" => "EDB44D"
),

array(
	"name" => "Social Icons Color",
	"id" => DESIGNARE_SHORTNAME."_topbar_social_color",
	"type" => "color",
	"std" => "444444"
),

array(
	"name" => "Social Icons Hover Color",
	"id" => DESIGNARE_SHORTNAME."_topbar_social_hover_color",
	"type" => "color",
	"std" => "EDB44D"
),

array(
	"name" => "Borders Color",
	"id" => DESIGNARE_SHORTNAME."_topbar_borders_color",
	"type" => "color",
	"std" => "f2f2f2"
),

array(
	"type" => "documentation",
	"text" => "<h3>Top Bar Submenu Items</h3>"
),

array(
	"name" => "Background Color",
	"id" => DESIGNARE_SHORTNAME."_topbar_submenu_bg_color",
	"type" => "color",
	"std" => "1E1E1E"
),

array(
	"name" => "Background Hover Color",
	"id" => DESIGNARE_SHORTNAME."_topbar_submenu_bg_hover_color",
	"type" => "color",
	"std" => "1E1E1E"
),

array(
	"name" => "Text Color",
	"id" => DESIGNARE_SHORTNAME."_topbar_submenu_text_color",
	"type" => "color",
	"std" => "8C8C8C"
),

array(
	"name" => "Text Hover Color",
	"id" => DESIGNARE_SHORTNAME."_topbar_submenu_text_hover_color",
	"type" => "color",
	"std" => "f2f2f2"
),

array(
	"type" => "documentation",
	"text" => "<h3>Header</h3>"
),

array(
	"name" => "Background Type",
	"id" => DESIGNARE_SHORTNAME."_headerbg_type",
	"type" => "select",
	"options" => array(array('id'=>'color','name'=>'Color'), array('id'=>'image','name'=>'Image'), array('id'=>'pattern','name'=>'Pattern'), array('id'=>'custom_pattern','name'=>'Custom Pattern')),
	"std" => 'color'
),

array(
	"name" => "Image",
	"id" => DESIGNARE_SHORTNAME."_headerbg_image",
	"type" => "upload_from_media",
),

array(
	"name" => "Color",
	"id" => DESIGNARE_SHORTNAME."_headerbg_color",
	"type" => "color",
	"std" => 'ffffff'
),

array(
	"name" => "Background Opacity",
	"id" => DESIGNARE_SHORTNAME."_headerbg_opacity",
	"type" => "opacity_slider",
	"std" => "100"
),

array(
	"name" => "Pattern",
	"id" => DESIGNARE_SHORTNAME."_headerbg_pattern",
	"type" => "pattern",
	"options" => $patterns,
),

array(
	"name" => "Custom Pattern",
	"id" => DESIGNARE_SHORTNAME."_headerbg_custom_pattern",
	"type" => "upload_from_media"
),

array(
	"name" => "Icons Color",
	"id" => DESIGNARE_SHORTNAME."_header_icons_color",
	"type" => "color",
	"desc" => "This color applies to the social icons, search icons and WooCommerce icon.",
	"std" => "C3C5C5"
),

array(
	"name" => "Icons Hover Color",
	"id" => DESIGNARE_SHORTNAME."_header_icons_hover_color",
	"type" => "color",
	"std" => "EDB44D"
),

array(
	"type" => "documentation",
	"text" => "<h3>Header After Scroll & Shrinked</h3>"
),

array(
	"name" => "Background Type",
	"id" => DESIGNARE_SHORTNAME."_headerbg_after_scroll_type",
	"type" => "select",
	"options" => array(array('id'=>'color','name'=>'Color'), array('id'=>'image','name'=>'Image'), array('id'=>'pattern','name'=>'Pattern')),
	"std" => 'color'
),

array(
	"name" => "Image",
	"id" => DESIGNARE_SHORTNAME."_headerbg_after_scroll_image",
	"type" => "upload_from_media",
),

array(
	"name" => "Color",
	"id" => DESIGNARE_SHORTNAME."_headerbg_after_scroll_color",
	"type" => "color",
	"std" => 'ffffff'
),

array(
	"name" => "Background Opacity",
	"id" => DESIGNARE_SHORTNAME."_headerbg_after_scroll_opacity",
	"type" => "opacity_slider",
	"std" => "100"
),

array(
	"name" => "Pattern",
	"id" => DESIGNARE_SHORTNAME."_headerbg_after_scroll_pattern",
	"type" => "pattern",
	"options" => $patterns,
),

array(
	"name" => "Custom Pattern",
	"id" => DESIGNARE_SHORTNAME."_headerbg_after_scroll_custom_pattern",
	"type" => "upload_from_media",
),

array(
	"name" => "Icons Color",
	"id" => DESIGNARE_SHORTNAME."_header_after_scroll_icons_color",
	"type" => "color",
	"desc" => "This applies to the social icons, search icons and WooCommerce icon.",
	"std" => "C3C5C5"
),

array(
	"name" => "Icons Hover Color",
	"id" => DESIGNARE_SHORTNAME."_header_after_scroll_icons_hover_color",
	"type" => "color",
	"std" => "EDB44D"
),

array(
	"type" => "close"
),


/* ------------------------------------------------------------------------*
 * LOGO OPTIONS
 * ------------------------------------------------------------------------*/


array(
	"type" => "subtitle",
	"id" => 'logotype'
),

array(
	"type" => "documentation",
	"text" => "<h3>Logo on Primary Header</h3>"
),

array(
	"name" => "Font Normal",
	"id" => DESIGNARE_SHORTNAME."_logo_font",
	"type" => "select",
	"options" => $designare_fonts_array,
	"desc" => 'You can select one of the fonts that the theme goes with or you can add google fonts (Style Options > Fonts).'
),

array(
	"name" => "Font Normal style",
	"id" => DESIGNARE_SHORTNAME."_logo_font_style",
	"type" => "multicheck",
	"options" => array(array("id"=>"bold", "name"=>"Bold"), array("id"=>"italic", "name"=>"Italic"), array("id"=>"underline", "name"=>"Underline")),
	"class"=>"include"
),

array(
	"name" => "Text Normal Size",
	"id" => DESIGNARE_SHORTNAME."_logo_size",
	"type" => "slider",
	"std" => "36 px",
	"desc" => "Choose the size of your logo."
),

array(
	"name" => "Text Normal Color",
	"id" => DESIGNARE_SHORTNAME."_logo_color",
	"type" => "color",
	"std" => "424242",
	"desc" => 'Select a custom color for your logo.'
),


array(
	"name" => "Margin Top",
	"id" => DESIGNARE_SHORTNAME."_logo_margin_top",
	"type" => "slider",
	"std" => "20px",
	"desc" => "Choose a top margin for your logo."
),

array(
	"name" => "Margin Left",
	"id" => DESIGNARE_SHORTNAME."_logo_margin_left",
	"type" => "slider",
	"std" => "0px",
	"desc" => "Choose a left margin for your logo."
),

array(
	"name" => "Height",
	"id" => DESIGNARE_SHORTNAME."_logo_height",
	"type" => "text",
	"desc" => "Insert the height of your logo (pixels).",
	"std"=>"58px"
),

array(
	"type" => "documentation",
	"text" => "<h3>Logo on Header After Scroll & Shrinked</h3>"
),

array(
	"name" => "Text Size After Scroll",
	"id" => DESIGNARE_SHORTNAME."_logo_after_scroll_size",
	"type" => "slider",
	"std" => "20 px",
	"desc" => "Choose the size of your logo."
),

array(
	"name" => "Text Color After Scroll",
	"id" => DESIGNARE_SHORTNAME."_logo_after_scroll_color",
	"type" => "color",
	"desc" => 'Select a custom color for your logo.'
),

array(
	"name" => "Margin Top After Scroll",
	"id" => DESIGNARE_SHORTNAME."_logo_after_scroll_margin_top",
	"type" => "slider",
	"std" => "10px",
	"desc" => "Choose a top margin for your logo."
),

array(
	"name" => "Margin Left After Scroll",
	"id" => DESIGNARE_SHORTNAME."_logo_after_scroll_margin_left",
	"type" => "slider",
	"std" => "0px",
	"desc" => "Choose a left margin for your logo."
),

array(
	"name" => "Height",
	"id" => DESIGNARE_SHORTNAME."_logo_reduced_height",
	"type" => "text",
	"desc" => "Insert the height of the header (pixels) after scroll.",
	"std" => "40px"
),

array(
	"type" => "close"
),


/* ------------------------------------------------------------------------*
 * MENU OPTIONS
 * ------------------------------------------------------------------------*/

array(
	"type" => "subtitle",
	"id"=>'menu'
),

array(
	"type" => "documentation",
	"text" => '<h3>Menu Style on Primary Header</h3>'
),

array(
	"type" => "documentation",
	"text" => '<h2>Top Menu Items</h2>'
),

array(
	"name" => "Font",
	"id" => DESIGNARE_SHORTNAME."_menu_font",
	"type" => "select",
	"options" => $designare_fonts_array,
	"desc" => 'You can select one of the fonts that the theme goes with or you can add google fonts (Style Options > Fonts).',
	"std" => "Helvetica Neue"
),

array(
	"name" => "Font Color",
	"id" => DESIGNARE_SHORTNAME."_menu_color",
	"type" => "color",
	"std" => "555555"
),

array(
	"name" => "Font Color Hover",
	"id" => DESIGNARE_SHORTNAME."_menu_color_hover",
	"type" => "color",
	"std" => "EDB44D"
),

array(
	"name" => "Font Size",
	"id" => DESIGNARE_SHORTNAME."_menu_font_size",
	"type" => "slider",
	"std" => "12px",
	"desc" => "Change the size of your menu font."
),

array(
	"name" => "Text Uppercase",
	"id" => DESIGNARE_SHORTNAME."_menu_uppercase",
	"type" => "checkbox",
	"std" => "on"
),

array(
	"name" => "Letter Spacing",
	"id" => DESIGNARE_SHORTNAME."_menu_letter_spacing",
	"type" => "text",
	"std" => "1px"
),

array(
	"name" => "Add Border ?",
	"id" => DESIGNARE_SHORTNAME."_menu_add_border",
	"type" =>"checkbox",
	"std" => "off"
),

array(
	"name"=>"Border Color",
	"id" => DESIGNARE_SHORTNAME."_menu_border_color",
	"type" => "color",
	"std" => "000000"
),

array(
	"name" => "Menu Side Margin",
	"id" => DESIGNARE_SHORTNAME."_menu_side_margin",
	"type" => "slider",
	"std" => "20px"
),

array(
	"name" => "Menu Margin Top",
	"id" => DESIGNARE_SHORTNAME."_menu_margin_top",
	"type" => "text",
	"std" => "45px"
),


array(
	"name" => "Menu Padding Bottom",
	"id" => DESIGNARE_SHORTNAME."_menu_padding_bottom",
	"type" => "text",
	"std" => "41px"
),


array(
	"type" => "documentation",
	"text" => '<h2>Sub Menu Items</h2>'
),

array(
	"name" => "Font",
	"id" => DESIGNARE_SHORTNAME."_sub_menu_font",
	"type" => "select",
	"options" => $designare_fonts_array,
	"desc" => 'You can select one of the fonts that the theme goes with or you can add google fonts (Style Options > Fonts).',
	"std" => "Helvetica Neue"
),

array(
	"name" => "Font Color",
	"id" => DESIGNARE_SHORTNAME."_sub_menu_color",
	"type" => "color",
	"std" => "8C8C8C"
),

array(
	"name" => "Font Color Hover",
	"id" => DESIGNARE_SHORTNAME."_sub_menu_color_hover",
	"type" => "color",
	"std" => "f2f2f2"
),

array(
	"name" => "Font Size",
	"id" => DESIGNARE_SHORTNAME."_sub_menu_font_size",
	"type" => "slider",
	"std" => "13px",
	"desc" => "Change the size of your menu font."
),

array(
	"name" => "Text Uppercase",
	"id" => DESIGNARE_SHORTNAME."_sub_menu_uppercase",
	"type" => "checkbox",
	"std" => "off"
),

array(
	"name" => "Letter Spacing",
	"id" => DESIGNARE_SHORTNAME."_sub_menu_letter_spacing",
	"type" => "text",
	"std" => "0px"
),


array(
	"name" => "Background Color",
	"id" => DESIGNARE_SHORTNAME."_sub_menu_bg_color",
	"type" => "color",
	"std" => "1E1E1E"
),

array(
	"name" => "Background Opacity",
	"id" => DESIGNARE_SHORTNAME."_sub_menu_bg_opacity",
	"type" => "opacity_slider",
	"std" => "100"
),

array(
	"name" => "Background Color Hover",
	"id" => DESIGNARE_SHORTNAME."_sub_menu_bg_color_hover",
	"type" => "color",
	"std" => "1E1E1E"
),

array(
	"name"=>"Border Color",
	"id" => DESIGNARE_SHORTNAME."_sub_menu_border_color",
	"type" => "color",
	"std" => "242424"
),


array(
	"type" => "documentation",
	"text" => '<h2>Just Label (Without Link)</h2>'
),

array(
	"name" => "Font",
	"id" => DESIGNARE_SHORTNAME."_label_menu_font",
	"type" => "select",
	"options" => $designare_fonts_array,
	"desc" => 'You can select one of the fonts that the theme goes with or you can add google fonts (Style Options > Fonts).',
	"std" => "Helvetica Neue"
),

array(
	"name" => "Font Color",
	"id" => DESIGNARE_SHORTNAME."_label_menu_color",
	"type" => "color",
	"std" => "f2f2f2"
),

array(
	"name" => "Font Size",
	"id" => DESIGNARE_SHORTNAME."_label_menu_font_size",
	"type" => "slider",
	"std" => "12px",
	"desc" => "Change the size of your menu font."
),

array(
	"name" => "Text Uppercase",
	"id" => DESIGNARE_SHORTNAME."_label_menu_uppercase",
	"type" => "checkbox",
	"std" => "off"
),

array(
	"name" => "Letter Spacing",
	"id" => DESIGNARE_SHORTNAME."_label_menu_letter_spacing",
	"type" => "text",
	"std" => "0px"
),


array(
	"type" => "documentation",
	"text" => '<h3>Menu Style on Header After Scroll & Shrinked</h3>'
),


array(
	"type" => "documentation",
	"text" => '<h2>Top Menu Items</h2>'
),

array(
	"name" => "Font Color",
	"id" => DESIGNARE_SHORTNAME."_menu_after_scroll_color",
	"type" => "color",
	"std" => "555555"
),

array(
	"name" => "Font Color Hover",
	"id" => DESIGNARE_SHORTNAME."_menu_after_scroll_color_hover",
	"type" => "color",
	"std" => "EDB44D"
),

array(
	"name"=>"Border Color",
	"id" => DESIGNARE_SHORTNAME."_menu_after_scroll_border_color",
	"type" => "color",
	"std" => "000000"
),

array(
	"name" => "Menu Side Margin",
	"id" => DESIGNARE_SHORTNAME."_menu_after_scroll_side_margin",
	"type" => "slider",
	"std" => "20px"
),

array(
	"name" => "Menu Margin Top",
	"id" => DESIGNARE_SHORTNAME."_menu_after_scroll_margin_top",
	"type" => "text",
	"std" => "20px"
),


array(
	"name" => "Menu Padding Bottom",
	"id" => DESIGNARE_SHORTNAME."_menu_after_scroll_padding_bottom",
	"type" => "text",
	"std" => "20px"
),


array(
	"type" => "documentation",
	"text" => '<h2>Sub Menu Items</h2>'
),

array(
	"name" => "Font Color",
	"id" => DESIGNARE_SHORTNAME."_sub_menu_after_scroll_color",
	"type" => "color",
	"std" => "8C8C8C"
),

array(
	"name" => "Font Color Hover",
	"id" => DESIGNARE_SHORTNAME."_sub_menu_after_scroll_color_hover",
	"type" => "color",
	"std" => "f2f2f2"
),

array(
	"name" => "Background Color",
	"id" => DESIGNARE_SHORTNAME."_sub_menu_after_scroll_bg_color",
	"type" => "color",
	"std" => "1E1E1E"
),

array(
	"name" => "Background Opacity",
	"id" => DESIGNARE_SHORTNAME."_sub_menu_after_scroll_bg_opacity",
	"type" => "opacity_slider",
	"std" => "100"
),

array(
	"name" => "Background Color Hover",
	"id" => DESIGNARE_SHORTNAME."_sub_menu_after_scroll_bg_color_hover",
	"type" => "color",
	"std" => "1E1E1E"
),

array(
	"name"=>"Border Color",
	"id" => DESIGNARE_SHORTNAME."_sub_menu_after_scroll_border_color",
	"type" => "color",
	"std" => "242424"
),


array(
	"type" => "documentation",
	"text" => '<h2>Just Label (Without Link)</h2>'
),

array(
	"name" => "Font Color",
	"id" => DESIGNARE_SHORTNAME."_label_menu_after_scroll_color",
	"type" => "color",
	"std" => "f2f2f2"
),

array(
	"type" => "close"
),


/* ------------------------------------------------------------------------*
 * Search
 * ------------------------------------------------------------------------*/

array(
	"type" => "subtitle",
	"id"=>"search"
),

array(
	"type" => "documentation",
	"text" => '<h3>Search Input</h3>'
),

array(
	"name" => "Opening Effect",
	"id" => DESIGNARE_SHORTNAME."_search_open_effect",
	"type" => "select",
	"options" => array(array("id"=>"slide_left", "name"=>"Slide from Left"), array("id"=>"slide_right", "name"=>"Slide from Right"), array("id"=>"slide_top", "name"=>"Slide from Top"), array("id"=>"slide_bottom", "name"=>"Slide from Bottom"), array("id"=>"unfold_horizontal", "name"=>"Unfold Horizontally"), array("id"=>"unfold_vertical", "name"=>"Unfold Vertically"), array("id"=>"unfold_center", "name" => "Unfold from Center"), array("id"=>"unfold_top_left", "name" => "Unfold from Top Left"), array("id"=>"unfold_top_right", "name"=>"Unfold from Top Right"), array("id"=>"unfold_bottom_left", "name"=>"Unfold from Bottom Left"), array("id"=>"unfold_bottom_right", "name"=>"Unfold from Bottom Right"), array("id"=>"fade", "name"=>"Fade"), array("id"=>"none", "name"=>"None")),
	"std" => "fade"
),

array(
	"name" => "Background Color",
	"id" => DESIGNARE_SHORTNAME."_search_input_background_color",
	"type" => "color",
	"std" => "ffffff"
),

array(
	"name" => "Background Opacity",
	"id" => DESIGNARE_SHORTNAME."_search_input_background_opacity",
	"type" => "opacity_slider",
	"std" => "95"
),

array(
	"name" => "Font",
	"id" => DESIGNARE_SHORTNAME."_search_input_font",
	"type" => "select",
	"options" => $designare_fonts_array,
	"std" => "Helvetica Neue"
),

array(
	"name" => "Font Size",
	"id" => DESIGNARE_SHORTNAME."_search_input_font_size",
	"type" => "slider",
	"std" => "30px"
),

array(
	"name" => "Font Color",
	"id" => DESIGNARE_SHORTNAME."_search_input_font_color",
	"type" => "color",
	"std" => "696969"
),

array(
	"type" => "documentation",
	"text" => '<h3>Search Results</h3>'
),

array(
	"name" => "Background Color",
	"id" => DESIGNARE_SHORTNAME."_search_result_background_color",
	"type" => "color",
	"std" => "ffffff"
),

array(
	"name" => "Selected Result Background Color",
	"id" => DESIGNARE_SHORTNAME."_search_selected_result_background_color",
	"type" => "color",
	"std" => "f2f2f2"
),

array(
	"name" => "Background Opacity",
	"id" => DESIGNARE_SHORTNAME."_search_result_background_opacity",
	"type" => "opacity_slider",
	"std" => "98"
),

array(
	"name" => "Borders",
	"id" => DESIGNARE_SHORTNAME."_search_result_borders",
	"type" => "color",
	"std" => "dedede"
),

array(
	"name" => "Font",
	"id" => DESIGNARE_SHORTNAME."_search_result_font",
	"type" => "select",
	"options" => $designare_fonts_array,
	"std" => "Helvetica Neue"
),

array(
	"name" => "Font Size",
	"id" => DESIGNARE_SHORTNAME."_search_result_font_size",
	"type" => "slider",
	"std" => "14px"
),

array(
	"name" => "Font Color",
	"id" => DESIGNARE_SHORTNAME."_search_result_font_color",
	"type" => "color",
	"std" => "696969"
),

array(
	"name" => "Selected Result Font Color",
	"id" => DESIGNARE_SHORTNAME."_search_selected_result_font_color",
	"type" => "color",
	"std" => "3d3d3d"
),

array(
	"type" => "documentation",
	"text" => '<h5>Search Results Details</h5>'
),

array(
	"name" => "Font",
	"id" => DESIGNARE_SHORTNAME."_search_result_details_font",
	"type" => "select",
	"options" => $designare_fonts_array,
	"std" => "Helvetica Neue"
),

array(
	"name" => "Font Size",
	"id" => DESIGNARE_SHORTNAME."_search_result_details_font_size",
	"type" => "slider",
	"std" => "12px"
),

array(
	"name" => "Font Color",
	"id" => DESIGNARE_SHORTNAME."_search_result_details_font_color",
	"type" => "color",
	"std" => "c2c2c2"
),

array(
	"name" => "Select Result Font Color",
	"id" => DESIGNARE_SHORTNAME."_search_selected_result_details_font_color",
	"type" => "color",
	"std" => "c2c2c2"
),

array(
	"type" => "close"
),


/* ------------------------------------------------------------------------*
 * Page Title
 * ------------------------------------------------------------------------*/

array(
	"type" => "subtitle",
	"id" => 'pagetitle'
),

array(
	"type" => "documentation",
	"text" => '<h3>Page Title Background - W-P-L-O-C-K-E-R-.-C-O-M</h3>'
),

array(
	"name" => "Background Type",
	"id" => DESIGNARE_SHORTNAME."_header_type",
	"type" => "select",
	"options" => array(array('id'=>'without', 'name'=>'Without Page Title'), array('id'=>'color','name'=>'Color'), array('id'=>'image','name'=>'Image'), array('id'=>'pattern','name'=>'Pattern'), array('id'=>'custom_pattern','name'=>'Custom Pattern'), array('id' => 'banner', 'name' => 'Banner Slider')),
	"std" => 'color'
),

array(
	"name" => "Image",
	"id" => DESIGNARE_SHORTNAME."_header_image",
	"type" => "upload_from_media",
	"desc" => 'Here you can choose the image for your header.'
),

array(
	"name" => "Parallax ?",
	"id" => DESIGNARE_SHORTNAME."_pagetitle_image_parallax",
	"type" => "checkbox",
	"std" => "off",
),

array(
	"name" => "Overlay ?",
	"id" => DESIGNARE_SHORTNAME."_pagetitle_image_overlay",
	"type" => "checkbox",
	"std" => "off"
),

array(
	"name" => "Overlay Type",
	"id" => DESIGNARE_SHORTNAME."_pagetitle_overlay_type",
	"type" => "select",
	"options" => array(array('id'=>'color', 'name'=>'Color'), array('id'=>'pattern','name'=>'Pattern')),
	"std" => 'color',
),

array(
	"name" => "Overlay Color",
	"id" => DESIGNARE_SHORTNAME."_pagetitle_overlay_color",
	"type" => "color",
	"std" => "#333"
),

array(
	"name" => "Overlay Pattern",
	"id" => DESIGNARE_SHORTNAME."_pagetitle_overlay_pattern",
	"type" => "pattern",
	"options" => $patterns,
),

array(
	"name" => "Overlay Opacity",
	"id" => DESIGNARE_SHORTNAME."_pagetitle_overlay_opacity",
	"type" => "opacity_slider",
	"std" => "100"
),

array(
	"name" => "Color",
	"id" => DESIGNARE_SHORTNAME."_header_color",
	"type" => "color",
	"std" => "EDEDED"
),

array(
	"name" => "Background Opacity",
	"id" => DESIGNARE_SHORTNAME."_header_opacity",
	"type" => "opacity_slider",
	"std" => "100"
),

array(
	"name" => "Pattern",
	"id" => DESIGNARE_SHORTNAME."_header_pattern",
	"type" => "pattern",
	"options" => $patterns,
	"desc" => 'Here you can choose the pattern for your header.'
),

array(
	"name" => "Custom Pattern",
	"id" => DESIGNARE_SHORTNAME."_header_custom_pattern",
	"type" => "upload_from_media",
	"desc" => 'Here you can choose the custom pattern for your header. It will replace the pattern you choose above.'
),

array(
	"name" => "Banner Slider",
	"id" => DESIGNARE_SHORTNAME."_banner_slider",
	"type" => "select",
	"options" => $revsliders
),

array(
	"name" => "Page Title Padding",
	"id"=> DESIGNARE_SHORTNAME."_page_title_padding",
	"type" => "text",
	"std" => "50px",
	"desc" => 'Value for the padding must be set in pixels'
),

array(
	"name" => "Elements Alignment",
	"id"=> DESIGNARE_SHORTNAME."_header_text_alignment",
	"type" => "select",
	"std" => "titlesleftcrumbsright",
	"options" => array(array("id"=>"left", "name"=>"Left"), array("id"=>"center", "name"=>"Center"), array("id"=>"right", "name"=>"Right"), array("id"=>"titlesleftcrumbsright", "name"=>"Left: Titles, Right: Breadcrumbs"), array("id"=>"titlesrightcrumbsleft", "name"=>"Left: Breadcrumbs, Right: Titles"))
),

array(
	"type" => "documentation",
	"text" => '<h3>Primary Title</h3>'
),

array(
	"name" => "Display Title",
	"id" => DESIGNARE_SHORTNAME."_hide_pagetitle",
	"type" => "checkbox",
	"std" => "on"
),

array(
	"name" => "Primary Title Font",
	"id" => DESIGNARE_SHORTNAME."_header_text_font",
	"type" => "select",
	"options" => $designare_fonts_array,
	"desc" => 'You can select one of the fonts that the theme goes with or you can add google fonts (Style Options > Fonts).',
	"std" => 'Helvetica Neue'
),

array(
	"name" => "Primary Title Color",
	"id" => DESIGNARE_SHORTNAME."_header_text_color",
	"type" => "color",
	"std" => "3c3c3c"
),

array(
	"name" => "Primary Title Size",
	"id" => DESIGNARE_SHORTNAME."_header_text_size",
	"type" => "slider",
	"std" => "24px"
),

array(
	"name" => "Primary Title Margin",
	"id" => DESIGNARE_SHORTNAME."_header_text_margin_top",
	"type" => "text",
	"std" => "0px"
),

array(
	"type" => "documentation",
	"text" => '<h3>Secondary Title</h3>'
),

array(
	"name" => "Display Title",
	"id" => DESIGNARE_SHORTNAME."_hide_sec_pagetitle",
	"type" => "checkbox",
	"std" => "on"
),

array(
	"name" => "Secondary Title Font",
	"id" => DESIGNARE_SHORTNAME."_secondary_title_font",
	"type" => "select",
	"options" => $designare_fonts_array,
	"desc" => 'You can select one of the fonts that the theme goes with or you can add google fonts (Style Options > Fonts).',
	"std" => 'Helvetica Neue'
),

array(
	"name" => "Secondary Title Text Color",
	"id" => DESIGNARE_SHORTNAME."_secondary_title_text_color",
	"type" => "color",
	"std" => "C7C7C7"
),

array(
	"name" => "Secondary Title Text Size",
	"id" => DESIGNARE_SHORTNAME."_secondary_title_text_size",
	"type" => "slider",
	"std" => "12px"
),

array(
	"name" => "Secondary Title Margin",
	"id" => DESIGNARE_SHORTNAME."_header_sec_text_margin_top",
	"type" => "text",
	"std" => "10px"
),

array(
	"type" => "documentation",
	"text" => '<h3>Breadcrumbs</h3>'
),

array(
	"name" => "Breadcrumbs",
	"id" => DESIGNARE_SHORTNAME."_breadcrumbs",
	"type" => "checkbox",
	"std" => "on"
),

array(
	"name" => "Breadcrumbs Font",
	"id" => DESIGNARE_SHORTNAME."_breadcrumbs_font",
	"type" => "select",
	"options" => $designare_fonts_array,
	"desc" => 'You can select one of the fonts that the theme goes with or you can add google fonts (Style Options > Fonts).',
	"std" => 'Helvetica Neue'
),

array(
	"name" => "Breadcrumbs Text Color",
	"id" => DESIGNARE_SHORTNAME."_breadcrumbs_color",
	"type" => "color",
	"std" => "828282"
),

array(
	"name" => "Breadcrumbs Text Size",
	"id" => DESIGNARE_SHORTNAME."_breadcrumbs_size",
	"type" => "slider",
	"std" => "12px"
),

array(
	"name" => "Breadcrumbs Margin Top",
	"id" => DESIGNARE_SHORTNAME."_breadcrumbs_text_margin_top",
	"type" => "text",
	"std" => "5px"
),

array(
	"type" => "close"
),


/* ------------------------------------------------------------------------*
 * FOOTER
 * ------------------------------------------------------------------------*/

array(
	"type" => "subtitle",
	"id" => 'footer'
),

array(
	"type" => "documentation",
	"text" => '<h3>Primary Footer</h3>'
),

array(
	"name" => "Show Primary Footer?",
	"id" => DESIGNARE_SHORTNAME."_show_primary_footer",
	"type" => "checkbox",
	"std" => 'on'
),

array(
	"name" => "Background Type",
	"id" => DESIGNARE_SHORTNAME."_footerbg_type",
	"type" => "select",
	"options" => array(array('id'=>'color','name'=>'Color'), array('id'=>'image','name'=>'Image'), array('id'=>'pattern','name'=>'Pattern'), array('id'=>'custom_pattern','name'=>'Custom Pattern')),
	"std" => 'color'
),

array(
	"name" => "Image",
	"id" => DESIGNARE_SHORTNAME."_footerbg_image",
	"type" => "upload_from_media",
	"desc" => 'Here you can choose the image for your footer.'
),

array(
	"name" => "Color",
	"id" => DESIGNARE_SHORTNAME."_footerbg_color",
	"type" => "color",
	"std" => '3D3D3D'
),

array(
	"name" => "Background Opacity",
	"id" => DESIGNARE_SHORTNAME."_footerbg_color_opacity",
	"type" => "opacity_slider",
	"std" => "100"
),

array(
	"name" => "Pattern",
	"id" => DESIGNARE_SHORTNAME."_footerbg_pattern",
	"type" => "pattern",
	"options" => $patterns,
	"desc" => 'Here you can choose the pattern for your footer.'
),

array(
	"name" => "Custom Pattern",
	"id" => DESIGNARE_SHORTNAME."_footerbg_custom_pattern",
	"type" => "upload_from_media",
	"desc" => 'Here you can choose the custom pattern for your footer. It will replace the pattern you choose above.'
),

array(
	"name" => "Borders Color",
	"id" => DESIGNARE_SHORTNAME."_footerbg_borderscolor",
	"type" => "color",
	"std" => '3D3D3D'
),

array(
	"name" => "Padding Top",
	"id" => DESIGNARE_SHORTNAME."_primary_footer_padding_top",
	"type" => "text",
	"std" => "80px"
),

array(
	"name" => "Padding Bottom",
	"id" => DESIGNARE_SHORTNAME."_primary_footer_padding_bottom",
	"type" => "text",
	"std" => "80px"
),

array(
	"type" => "documentation",
	"text" => '<h3>Primary Footer - Text Colors</h3>'
),

array(
	"name" => "Links Color",
	"id" => DESIGNARE_SHORTNAME."_footerbg_linkscolor",
	"type" => "color",
	"std" => 'A6A6A6'
),

array(
	"name" => "Paragraphs Color",
	"id" => DESIGNARE_SHORTNAME."_footerbg_paragraphscolor",
	"type" => "color",
	"std" => 'A6A6A6'
),

array(
	"name" => "Headings Color",
	"id" => DESIGNARE_SHORTNAME."_footerbg_headingscolor",
	"type" => "color",
	"std" => 'ffffff'
),

array(
	"type" => "documentation",
	"text" => '<h3>Secondary Footer</h3>'
),

array(
	"name" => "Show Secondary Footer?",
	"id" => DESIGNARE_SHORTNAME."_show_sec_footer",
	"type" => "checkbox",
	"std" => 'on'
),

array(
	"name" => "Background Type",
	"id" => DESIGNARE_SHORTNAME."_sec_footerbg_type",
	"type" => "select",
	"options" => array(array('id'=>'color','name'=>'Color'), array('id'=>'image','name'=>'Image'), array('id'=>'pattern','name'=>'Pattern'), array('id'=>'custom_pattern','name'=>'Custom Pattern')),
	"std" => 'color'
),

array(
	"name" => "Image",
	"id" => DESIGNARE_SHORTNAME."_sec_footerbg_image",
	"type" => "upload_from_media",
	"desc" => 'Here you can choose the image for your footer.'
),

array(
	"name" => "Color",
	"id" => DESIGNARE_SHORTNAME."_sec_footerbg_color",
	"type" => "color",
	"std" => 'ffffff'
),

array(
	"name" => "Background Opacity",
	"id" => DESIGNARE_SHORTNAME."_sec_footerbg_color_opacity",
	"type" => "opacity_slider",
	"std" => "100"
),

array(
	"name" => "Pattern",
	"id" => DESIGNARE_SHORTNAME."_sec_footerbg_pattern",
	"type" => "pattern",
	"options" => $patterns,
	"desc" => 'Here you can choose the pattern for your footer.'
),

array(
	"name" => "Custom Pattern",
	"id" => DESIGNARE_SHORTNAME."_sec_footerbg_custom_pattern",
	"type" => "upload_from_media",
	"desc" => 'Here you can choose the custom pattern for your footer. It will replace the pattern you choose above.'
),

array(
	"name" => "Padding Top",
	"id" => DESIGNARE_SHORTNAME."_secondary_footer_padding_top",
	"type" => "text",
	"std" => "40px"
),

array(
	"name" => "Padding Bottom",
	"id" => DESIGNARE_SHORTNAME."_secondary_footer_padding_bottom",
	"type" => "text",
	"std" => "40px"
),

array(
	"name" => "Logo Font",
	"id" => DESIGNARE_SHORTNAME."_sec_footer_logo_font",
	"type" => "select",
	"options" => $designare_fonts_array,
	"std" => 'Helvetica'
),

array(
	"name" => "Logo Font Size",
	"id" => DESIGNARE_SHORTNAME."_sec_footer_logo_font_size",
	"type" => "text",
	"std" => "20px"
),

array(
	"name" => "Logo Font Color",
	"id" => DESIGNARE_SHORTNAME."_sec_footer_logo_font_color",
	"type" => "color",
	"std" => "a19ea1"
),

array(
	"name" => "Logo Font Hover Color",
	"id" => DESIGNARE_SHORTNAME."_sec_footer_logo_font_hover_color",
	"type" => "color",
	"std" => "FFFFFF"
),

array(
	"name" => "Social Icons Size",
	"id" => DESIGNARE_SHORTNAME."_sec_footer_social_icons_size",
	"type" => "text",
	"std" => "40px"
),

array(
	"name" => "Social Icons Color",
	"id" => DESIGNARE_SHORTNAME."_sec_footer_social_icons_color",
	"type" => "color",
	"std" => "a19ea1"
),

array(
	"name" => "Social Icons Hover Color",
	"id" => DESIGNARE_SHORTNAME."_sec_footer_social_icons_hover_color",
	"type" => "color",
	"std" => "FFFFFF"
),

array(
	"type" => "close"
),


/* ------------------------------------------------------------------------*
 * TYPOGRAPHY
 * ------------------------------------------------------------------------*/

array(
	"type" => "subtitle",
	"id"=>'text'
),

array(
	"type" => "documentation",
	"text" => "<h3>Links</h3>"
),

array(
	"name" => "Font",
	"id" => DESIGNARE_SHORTNAME."_links_font",
	"type" => "select",
	"options" => $designare_fonts_array,
	"desc" => 'You can select one of the fonts that the theme goes with or you can add google fonts (Style Options > Fonts).',
	"std" => 'Helvetica'
),

array(
	"name" => "Size",
	"id" => DESIGNARE_SHORTNAME."_links_size",
	"type" => "slider",
	"std" => "15px",
	"desc" => "Choose the size of your &lt;a&gt; tag."
),

array(
	"name" => "Color",
	"id" => DESIGNARE_SHORTNAME."_links_color",
	"type" => "color",
	"desc" => 'Select a custom color for your &lt;a&gt; tag.',
	"std" => "EDB44D"
),

array(
	"name" => "Color (hover)",
	"id" => DESIGNARE_SHORTNAME."_links_color_hover",
	"type" => "color",
	"desc" => 'Select a custom color for your &lt;a&gt; tag hover state.',
	"std" => "808080"
),

array(
	"name" => "Background Color (hover)",
	"id" => DESIGNARE_SHORTNAME."_links_bg_color_hover",
	"type" => "color",
	"desc" => 'Select a custom color for the background of your &lt;a&gt; tag hover state.'
),

array(
	"type" => "documentation",
	"text" => "<h3>Paragraphs</h3>"
),

array(
	"name" => "Font",
	"id" => DESIGNARE_SHORTNAME."_p_font",
	"type" => "select",
	"options" => $designare_fonts_array,
	"desc" => 'You can select one of the fonts that the theme goes with or you can add google fonts (Style Options > Fonts).',
	"std" => 'Helvetica'
),

array(
	"name" => "Size",
	"id" => DESIGNARE_SHORTNAME."_p_size",
	"type" => "slider",
	"std" => "15 px",
	"desc" => "Choose the size of your &lt;p&gt; tag."
),

array(
	"name" => "Color",
	"id" => DESIGNARE_SHORTNAME."_p_color",
	"type" => "color",
	"desc" => 'Select a custom color for your &lt;p&gt; tag.',
	"std" => "8C8C8C"
),

array(
	"type" => "documentation",
	"text" => "<h3>H1 Tag</h3>"
),


array(
	"name" => "Font",
	"id" => DESIGNARE_SHORTNAME."_h1_font",
	"type" => "select",
	"options" => $designare_fonts_array,
	"desc" => 'You can select one of the fonts that the theme goes with or you can add google fonts (Style Options > Fonts).',
	"std" => 'Helvetica Neue'
),

array(
	"name" => "Size",
	"id" => DESIGNARE_SHORTNAME."_h1_size",
	"type" => "slider",
	"std" => "36px",
	"desc" => "Choose the size of your H1 tag (pixels)."
),

array(
	"name" => "Color",
	"id" => DESIGNARE_SHORTNAME."_h1_color",
	"type" => "color",
	"desc" => 'Select a custom color for your H1 tag.',
	"std"=> "3C3C3C"
),

array(
	"type" => "documentation",
	"text" => "<h3>H2 Tag</h3>"
),

array(
	"name" => "Font",
	"id" => DESIGNARE_SHORTNAME."_h2_font",
	"type" => "select",
	"options" => $designare_fonts_array,
	"desc" => 'You can select one of the fonts that the theme goes with or you can add google fonts (Style Options > Fonts).',
	"std" => 'Helvetica Neue'
),

array(
	"name" => "Size",
	"id" => DESIGNARE_SHORTNAME."_h2_size",
	"type" => "slider",
	"std" => "32px",
	"desc" => "Choose the size of your H2 tag (pixels)."
),

array(
	"name" => "Color",
	"id" => DESIGNARE_SHORTNAME."_h2_color",
	"type" => "color",
	"desc" => 'Select a custom color for your H2 tag.',
	"std" => "3C3C3C"
),

array(
	"type" => "documentation",
	"text" => "<h3>H3 Tag</h3>"
),

array(
	"name" => "Font",
	"id" => DESIGNARE_SHORTNAME."_h3_font",
	"type" => "select",
	"options" => $designare_fonts_array,
	"desc" => 'You can select one of the fonts that the theme goes with or you can add google fonts (Style Options > Fonts).',
	"std" => 'Helvetica Neue'
),

array(
	"name" => "Size",
	"id" => DESIGNARE_SHORTNAME."_h3_size",
	"type" => "slider",
	"std" => "25px",
	"desc" => "Choose the size of your H3 tag (pixels)."
),

array(
	"name" => "Color",
	"id" => DESIGNARE_SHORTNAME."_h3_color",
	"type" => "color",
	"desc" => 'Select a custom color for your H3 tag.',
	"std" => "3C3C3C"
),

array(
	"type" => "documentation",
	"text" => "<h3>H4 Tag</h3>"
),

array(
	"name" => "Font",
	"id" => DESIGNARE_SHORTNAME."_h4_font",
	"type" => "select",
	"options" => $designare_fonts_array,
	"desc" => 'You can select one of the fonts that the theme goes with or you can add google fonts (Style Options > Fonts).',
	"std" => 'Helvetica Neue'
),

array(
	"name" => "Size",
	"id" => DESIGNARE_SHORTNAME."_h4_size",
	"type" => "slider",
	"std" => "22px",
	"desc" => "Choose the size of your H4 tag (pixels)."
),

array(
	"name" => "Color",
	"id" => DESIGNARE_SHORTNAME."_h4_color",
	"type" => "color",
	"desc" => 'Select a custom color for your H4 tag.',
	"std"=> "3C3C3C"
),

array(
	"type" => "documentation",
	"text" => "<h3>H5 Tag</h3>"
),

array(
	"name" => "Font",
	"id" => DESIGNARE_SHORTNAME."_h5_font",
	"type" => "select",
	"options" => $designare_fonts_array,
	"desc" => 'You can select one of the fonts that the theme goes with or you can add google fonts (Style Options > Fonts).',
	"std" => 'Helvetica Neue'
),

array(
	"name" => "Size",
	"id" => DESIGNARE_SHORTNAME."_h5_size",
	"type" => "slider",
	"std" => "18px",
	"desc" => "Choose the size of your H5 tag (pixels)."
),

array(
	"name" => "Color",
	"id" => DESIGNARE_SHORTNAME."_h5_color",
	"type" => "color",
	"desc" => 'Select a custom color for your H5 tag.',
	"std" => "3C3C3C"
),

array(
	"type" => "documentation",
	"text" => "<h3>H6 Tag</h3>"
),

array(
	"name" => "Font",
	"id" => DESIGNARE_SHORTNAME."_h6_font",
	"type" => "select",
	"options" => $designare_fonts_array,
	"desc" => 'You can select one of the fonts that the theme goes with or you can add google fonts (Style Options > Fonts).',
	"std" => 'Helvetica Neue'
),

array(
	"name" => "Size",
	"id" => DESIGNARE_SHORTNAME."_h6_size",
	"type" => "slider",
	"std" => "16px",
	"desc" => "Choose the size of your H6 tag (pixels)."
),

array(
	"name" => "Color",
	"id" => DESIGNARE_SHORTNAME."_h6_color",
	"type" => "color",
	"desc" => 'Select a custom color for your H6 tag.',
	"std" => "3C3C3C"
),

array(
	"type" => "close"
),

/* IMPORT EXPORT OPTIONS NEW STUFF */

array(
	"type" => "subtitle",
	"id" => "impexp"
),

array(
	"type" => "documentation",
	"text" => "<h3>Export Options</h3>"
),

array(
	"name" => "Export Options",
	"id" => DESIGNARE_SHORTNAME."_export_style_options",
	"type" => "custom",
	"button_text" => 'Save Options as...',
	"desc" => "Creates a File containing all your current Panel Options. W;P;L;O;C;K;E;R;.;C;O;M",
    "fields" => array()
),

array(
	"type" => "documentation",
	"text" => "<h3>Import Options</h3>"
),

array(
	"name" => "Import Options",
	"id" => DESIGNARE_SHORTNAME."_import_style_options",
	"type" => "upload",
	"desc" => "Load Panel Options from a previously created file."
),

array(
	"type" => "documentation",
	"text" => "<h3>Reset Options</h3>"
),

array(
	"name" => "Restore Options",
	"id" => DESIGNARE_SHORTNAME."_reset_style_options",
	"type" => "custom",
	"button_text" => 'Reset Panel Options',
	"desc" => "Restore all the Panel Options to their original value.",
    "fields" => array()
),


array(
	"type" => "close"
),

array(
	"type" => "close"
)

);

designare_add_style_options($designare_styles_options);
