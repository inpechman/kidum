<?php
	
	$designare_general_options= array( array(
		"name" => "Widgets Area",
		"type" => "title",
		"img" => DESIGNARE_IMAGES_URL."icon_general.png"
	),
	
	array(
		"type" => "open",
		"subtitles"=>array(array("id"=>"footer", "name"=>"Footer"), array("id"=>"sidebars", "name"=>"Sidebars"))
	),
	
	
	/* ------------------------------------------------------------------------*
	 * Footer
	 * ------------------------------------------------------------------------*/
	
	array(
		"type" => "subtitle",
		"id"=>'footer'
	),
	
	array(
		"type" => "documentation",
		"text" => "<h3>Footer Settings</h3>"
	),
	
	array(
		"name" => "Number Columns",
		"id" => DESIGNARE_SHORTNAME."_footer_number_cols",
		"type" => "select",
		"options" => array(array("name"=>"One", "id"=>"one"), array("name"=>"Two", "id"=>"two"), array("name"=>"Three", "id"=>"three"), array("name"=>"Four", "id"=>"four")),
		"std" => 'one'
	),
	
	array(
		"name" => "Columns Order",
		"id" => DESIGNARE_SHORTNAME."_footer_columns_order",
		"type" => "select",
		"options" => array(array("name"=>"x | x | x", "id"=>"one_three"), array("name"=>"x | xx", "id"=>"one_two_three"), array("name"=>"xx | x", "id"=>"two_one_three")),
		"std" => "one_three"
	),
	
	array(
		"name" => "Columns Order",
		"id" => DESIGNARE_SHORTNAME."_footer_columns_order_four",
		"type" => "select",
		"options" => array(array("name"=>"x | x | x | x", "id"=>"one_four"), array("name"=>"x | xx | x", "id"=>"two_one_two_four"), array("name"=>"xxx | x", "id"=>"three_one_four"), array("name"=>"x | xxx", "id"=>"one_three_four")),
		"std" => "one_four"
	),
	
	
	array(
		"type" => "documentation",
		"text" => "<h3>Secondary Footer</h3>"
	),
	
	array(
		"name" => "<strong>Display Logo?</strong>",
		"id" => DESIGNARE_SHORTNAME."_footer_display_logo",
		"type" => "checkbox",
		"std" => "off"
	),
	
	array(
		"name" => "Logo type",
		"id" => DESIGNARE_SHORTNAME."_footer_logo_type",
		"type" => "checkbox-text-image",
		"std" => "image"
	),
	
	array(
		"name" => "Logo Normal URL",
		"id" => DESIGNARE_SHORTNAME."_footer_logo_image_url",
		"type" => "upload_from_media",
		"desc" => "Upload your logo image - with png/jpg/gif extension.",
		"std" => "http://placehold.it/188x50"
	),
	
	array(
		"name" => "Logo Normal Retina URL",
		"id" => DESIGNARE_SHORTNAME."_footer_logo_retina_image_url",
		"type" => "upload_from_media",
		"desc" => "Upload your logo image - with png/jpg/gif extension.",
		"std" => "http://placehold.it/300x80"
	),
	
	array(
		"name" => "Text",
		"id" => DESIGNARE_SHORTNAME."_footer_logo_text",
		"type" => "text",
		"std" => "Yunik"
	),

	array(
		"name" => "Logotype Alignment",
		"id" => DESIGNARE_SHORTNAME."_footer_logo_alignment",
		"type" => "select",
		"options" => array(array("id"=>"left","name"=>"Left"), array("id"=>"center","name"=>"Center"), array("id"=>"right","name"=>"Right")),
		"std" => "center"
	),

	array(
		"name" => "<strong>Display Social Icons?</strong>",
		"id" => DESIGNARE_SHORTNAME."_footer_display_social_icons",
		"type" => "checkbox",
		"std" => "off"
	),
	
	array(
		"name" => "Social Icons Alignment",
		"id" => DESIGNARE_SHORTNAME."_footer_social_icons_alignment",
		"type" => "select",
		"options" => array(array("id"=>"left","name"=>"Left"), array("id"=>"center","name"=>"Center"), array("id"=>"right","name"=>"Right")),
		"std" => "center"
	),
	
	array(
		"name" => "<strong>Display Custom Text?</strong>",
		"id" => DESIGNARE_SHORTNAME."_footer_display_custom_text",
		"type" => "checkbox",
		"std" => "off"
	),
	
	array(
		"name" => "Custom Text",
		"id" => DESIGNARE_SHORTNAME."_footer_custom_text",
		"type" => "textarea_wysiwyg",
		"std" => "<p>Your text here. You can also use shortcodes.</p>"
	),
	
	array(
		"name" => "Custom Text Alignment",
		"id" => DESIGNARE_SHORTNAME."_footer_custom_text_alignment",
		"type" => "select",
		"options" => array(array("id"=>"left","name"=>"Left"), array("id"=>"center","name"=>"Center"), array("id"=>"right","name"=>"Right")),
		"std" => "center"
	),
		
	array(
		"type" => "close"
	),
	
	/* ------------------------------------------------------------------------*
	 * Sidebars
	 * ------------------------------------------------------------------------*/
	
	array(
		"type" => "subtitle",
		"id"=>'sidebars'
	),
	
	array(
		"type" => "documentation",
		"text" => "<h3>Create New Sidebar</h3>"
	),
	
	array(
		"name"=>"Custom Sidebars",
		"id"=>'sidebar_name',
		"type"=>"custom",
		"button_text"=>'Add Sidebar',
		"fields"=>array(
			array('id'=>'des_sidebar_name_name', 'type'=>'text', 'name'=>'Name')
		),
		"desc"=>"Here you can create unlimited sidebars. After creating one you can customize its content in Appearance > Widgets and then use it wherever you want via shortcode (Shortcodes > Features > Custom Sidebar)."
	),
	
	
	array(
		"type" => "close"
	),
	
	/*close array*/
	
	array(
		"type" => "close"
	));
	
	designare_add_options($designare_general_options);
	
?>