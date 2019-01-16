<?php

$designare_info_options= array( array(
"name" => "Header Layout",
"type" => "title",
"img" => DESIGNARE_IMAGES_URL."icon_home.png"
),

array(
"type" => "open",
"subtitles"=>array(array("id"=>"header_layout", "name"=>"Header"), array("id"=>"logotype", "name" =>"Logotype"), array("id"=>"top_panel", "name"=>"Top Bar"), array("id"=>"search", "name"=>"Search"))
),

array(
"type" => "subtitle",
"id"=>'header_layout'
),

array(
	'type' => 'goto',
	'name' => 'header',
	'desc' => 'Style this Element'
),

array(
"type" => "documentation",
"text" => '<h3>Fixed Header</h3>'
),

array(
"name" => "Fixed Header?",
"id" => DESIGNARE_SHORTNAME."_fixed_menu",
"type" => "checkbox",
"std" => "on",
"desc" => "If set to <strong>ON</strong> the header will be always visible, not only at the top of the page."
),

array(
"name" => "Hide on Start?",
"id" => DESIGNARE_SHORTNAME."_header_hide_on_start",
"type" => "checkbox",
"std" => "off",
"desc" => "If set to <strong>ON</strong> the header will appear from the top of the page after scrolling."
),

array(
	"name" => "Page Content (on multipage templates)",
	"id" => DESIGNARE_SHORTNAME."_content_to_the_top",
	"type" => "select",
	"options" => array(array("id"=>"off","name"=>"Content starts after the header"), array("id"=>"on","name"=>"Content behind the header")),
	"std" => "off"
),

array(
"type" => "documentation",
"text" => '<h3>Header After Scroll</h3>'
),

array(
"name" => "Header After Scroll?",
"id" => DESIGNARE_SHORTNAME."_header_after_scroll",
"type" => "checkbox",
"std" => "on",
"desc" => "If set to <strong>ON</strong> you will have options to style a second header to display different from the one appearing in the top of the page."
),


array(
"type" => "documentation",
"text" => '<h3>Header Shrink Effect</h3>'
),

array(
"name" => "Header Shrink Effect?",
"id" => DESIGNARE_SHORTNAME."_header_shrink_effect",
"type" => "checkbox",
"std" => "on",
"desc" => "If set to <strong>ON</strong> you will be able to change the sizes of the contents (header included)."
),

array(
	"type" => "documentation",
	"text" => "<h3>Enable / Disable Woocommerce Cart</h3>"
),

array(
	"name" => "Woocommerce Cart",
	"id" => DESIGNARE_SHORTNAME."_woocommerce_cart",
	"type" => "checkbox",
	"std" => 'off',
	"desc" => "Displays the Woocommerce Cart."
),

array(
	"type" => "documentation",
	"text" => "<h3>Enable / Disable Social Icons</h3>"
),

array(
	"name" => "Social Icons",
	"id" => DESIGNARE_SHORTNAME."_social_icons_menu",
	"type" => "checkbox",
	"std" => 'on',
	"desc" => "Displays the social icons."
),

array(
"type" => "documentation",
"text" => '<h3>Header Layout</h3>'
),

array(
	"type" => "documentation",
	"text" => '<p><b>Note:</b> After choose the header style, go to the next tab <b>Top Bar</b> and add your contents.</p>'
),

array(
	"name" => "Header Style Type",
	"id" => DESIGNARE_SHORTNAME."_header_style_type",
	"type" => "select",
	"options" => array(array('id'=>'style1', 'name'=>'Style 1'), array('id'=>'style2','name'=>'Style 2'), array('id'=>'style3','name'=>'Style 3'), array('id'=>'style4','name'=>'Style 4')),
	"std" => 'style1'
),

array(
	"type" => "close"
),

/* logotype new place */
array(
"type" => "subtitle",
"id"=>'logotype'
),

array(
	'type' => 'goto',
	'name' => 'logotype',
	'desc' => 'Style this Element'
),

array(
	"type" => "documentation",
	"text" => "<h3>Logo</h3>"
),

array(
	"name" => "Logo type",
	"id" => DESIGNARE_SHORTNAME."_logo_type",
	"type" => "checkbox-text-image",
	"std" => "text"
),

array(
	"name" => "Logo Normal URL",
	"id" => DESIGNARE_SHORTNAME."_logo_image_url",
	"type" => "upload_from_media",
	"desc" => "Upload your logo image - with png/jpg/gif extension.",
	"std" => "http://placehold.it/188x50"
),

array(
	"name" => "Logo Normal Retina URL",
	"id" => DESIGNARE_SHORTNAME."_logo_retina_image_url",
	"type" => "upload_from_media",
	"desc" => "Upload your logo image - with png/jpg/gif extension.",
	"std" => "http://placehold.it/300x80"
),

array(
	"name" => "Logo After Scroll URL",
	"id" => DESIGNARE_SHORTNAME."_logo_after_scroll_image_url",
	"type" => "upload_from_media",
	"desc" => "Upload your logo image - with png/jpg/gif extension.",
	"std" => "http://placehold.it/188x50"
),

array(
	"name" => "Logo After Scroll Retina URL",
	"id" => DESIGNARE_SHORTNAME."_logo_after_scroll_retina_image_url",
	"type" => "upload_from_media",
	"desc" => "Upload your logo image - with png/jpg/gif extension.",
	"std" => "http://placehold.it/300x80"
),

array(
	"name" => "Text",
	"id" => DESIGNARE_SHORTNAME."_logo_text",
	"type" => "text",
	"desc" => "Insert the text of your logo.",
	"std" => "YUNIK"
),


array(
	"type" => "close"
),


/* ------------------------------------------------------------------------*
 * Top Contents
 * ------------------------------------------------------------------------*/

array(
"type" => "subtitle",
"id"=>'top_panel'
),

	array(
		"type" => "documentation",
		"text" => "<h3>Top Bar Contents</h3>"
	),
	
	array(
		"name" => "Enable Top Info Bar",
		"id" => DESIGNARE_SHORTNAME."_info_above_menu",
		"type" => "checkbox",
		"std" => 'on',
		"desc" => "Displays an above menu information container."
	),
	
	array(
		"name" => "WPML Widget",
		"id" => DESIGNARE_SHORTNAME."_wpml_menu_widget",
		"type" => "checkbox",
		"std" => 'off',
		"desc" => "Displays the WPML widget if available."
	),
	
	array(
		"name" => "Display Top Bar Menu",
		"id" => DESIGNARE_SHORTNAME."_top_bar_menu",
		"type" => "checkbox",
		"std" => 'off',
		"desc" => "Displays the Top Bar Menu. You need to assign a Menu to the Top Bar Location in <strong>Appearance > Menus</strong>."
	),
	
	array(
		"name" => "Telephone",
		"id" => DESIGNARE_SHORTNAME."_telephone_menu",
		"type" => "text",
		"desc" => "Insert number to display above the menu. <br/>NOTE: If you add links, span or class <b>do not use quotes or double quotes</b>.<br/> ex: < span class=text_color >",
		"std" => ""
	),
	
	array(
		"name" => "Email",
		"id" => DESIGNARE_SHORTNAME."_email_menu",
		"type" => "text",
		"desc" => "Insert email to display above the menu.<br/>NOTE: If you add links, span or class <b>do not use quotes or double quotes</b>.<br/> ex: < span class=text_color >",
		"std" => ""
	),
	
	array(
		"name" => "Address",
		"id" => DESIGNARE_SHORTNAME."_address_menu",
		"type" => "text",
		"desc" => "Insert address to display above the menu.<br/>NOTE: If you add links, span or class <b>do not use quotes or double quotes</b>.<br/> ex: < span class=text_color >",
		"std" => ""
	),
	
	array(
		"name" => "Text Field",
		"id" => DESIGNARE_SHORTNAME."_text_field_menu",
		"type" => "text",
		"desc" => "Insert a custom text line.<br/>NOTE: If you add links, span or class <b>do not use quotes or double quotes</b>.<br/> ex: < span class=text_color >",
		"std" => ""
	),
	
	array(
		"name" => "Enable Social Icons",
		"id" => DESIGNARE_SHORTNAME."_enable_socials",
		"type" => "checkbox",
		"std" => 'on'
	),
	
	array(
		"type" => "close"
	),
	
	array(
		"type" => "subtitle",
		"id"=>'search'
	),
	
	array(
		"type" => "documentation",
		"text" => "<h3>Search Options</h3>"
	),
	
	array(
		"name" => "Enable Search",
		"id" => DESIGNARE_SHORTNAME."_enable_search",
		"type" => "checkbox",
		"std" => 'on'
	),
	
	array(
		"name" => "Enable Ajax Search",
		"id" => DESIGNARE_SHORTNAME."_enable_ajax_search",
		"type" => "checkbox",
		"std" => 'off',
		"desc" => "If enabled, displays search results on typing."
	),
	
	array(
		"name" => "Search all contents ?",
		"id" => DESIGNARE_SHORTNAME."_enable_search_everything",
		"type" => "checkbox",
		"std" => 'on',
		"desc" => "If enabled the search will go through not only posts and pages, but all of the website's content."
	),
	
	array(
		"type" => "documentation",
		"text" => "<h3>Search Page Results</h3>"
	),
	
	array(
		"name" => "Secondary Title",
		"id" => DESIGNARE_SHORTNAME."_search_secondary_title",
		"type" => "text",
		"desc" => "If set, will display this as a secondary title."
	),
	
	array(
		"name" => "Sidebar ?",
		"id" => DESIGNARE_SHORTNAME."_search_archive_sidebar",
		"type" => "select",
		"options" => array(array("id"=>"none", "name"=>"None"), array("id"=>"left", "name"=>"Left"), array("id"=>"right", "name"=>"Right")),
		"std"=>"right"
	),
	
	array(
		"name" => "Choose your Sidebar",
		"id" => DESIGNARE_SHORTNAME."_search_sidebars_available",
		"type" => "select",
		"options" => $outputsidebars
	),
	
	array(
		"type" => "documentation",
		"text" => "<h3>Search Results Ajax Details</h3>"
	),
	
	array(
		"name" => "Show Author ?",
		"id" => DESIGNARE_SHORTNAME."_search_show_author",
		"type" => "checkbox",
		"std" => 'on'
	),
	
	array(
		"name" => "Show Date ?",
		"id" => DESIGNARE_SHORTNAME."_search_show_date",
		"type" => "checkbox",
		"std" => 'on'
	),
	
	array(
		"name" => "Show Tags ?",
		"id" => DESIGNARE_SHORTNAME."_search_show_tags",
		"type" => "checkbox",
		"std" => 'off'
	),
	
	array(
		"name" => "Show Categories ?",
		"id" => DESIGNARE_SHORTNAME."_search_show_categories",
		"type" => "checkbox",
		"std" => 'off'
	),

	array(
		"type" => "close"
	),	
	
	
	array(
	"type" => "close"));

designare_add_options($designare_info_options);