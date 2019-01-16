<?php
	
$underconstructionpages = array();
$getunderconstructionpages = get_pages(array(
	'post_type' => 'page',
	'meta_key' => '_wp_page_template',
	'meta_value' => 'template-under-construction.php',
	'post_status' => 'publish'
));
if (!empty($getunderconstructionpages)){
	foreach ($getunderconstructionpages as $page){
		array_push($underconstructionpages, array("id"=>$page->ID, "name"=>$page->post_title));
	}
} else {
	$underconstructionpages = array(array("id"=>"0", "name"=>"You have no published Under Construction pages."));
}

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

$ultimate_gf = array();
$querygf = get_option('ultimate_selected_google_fonts');
if (isset($querygf) && is_array($querygf)){
	foreach (get_option('ultimate_selected_google_fonts') as $font){
		array_push($font, $ultimate_gf);
	}	
}

$page_on_front = 0;
if (get_option('show_on_front') == "page") $page_on_front = get_option('page_on_front');

$google_fonts = des_get_all_google_fonts();

$designare_fonts_array = designare_fonts_array_builder();
$designare_portfolio_types = designare_portfolio_types();
$designare_projects = designare_get_proj();

$designare_general_options= array( array(
	"name" => "General",
	"type" => "title",
	"img" => DESIGNARE_IMAGES_URL."icon_general.png"
),

array(
	"type" => "open",
	"subtitles"=>array(array("id"=>"main", "name"=>"Main Settings"), array("id"=>"seo", "name"=>"SEO"), array("id"=>"projects", "name"=>"Projects"), array("id"=>"blog", "name"=>"Blog"), array("id"=>"archives", "name"=>"Archives"), array("id"=>"shop", "name"=>"Shop"), array("id"=>"underconstruction", "name"=>"Under Construction Mode"))
),

/* ------------------------------------------------------------------------*
 * MAIN SETTINGS
 * ------------------------------------------------------------------------*/

array(
	"type" => "subtitle",
	"id"=>'main'
),

array(
	"type" => "documentation",
	"text" => "<h3>Website Loading</h3>"
),

array(
	"name" => "Enable Website Loading",
	"id" => DESIGNARE_SHORTNAME."_enable_website_loader",
	"type" => "checkbox",
	"std" => 'on'
),

array(
	"id" => DESIGNARE_SHORTNAME."_website_loader",
	"name" => "Loader Type",
	"type" => "website_loaders",
	"options" => array(array("id"=>"ball-pulse", "name"=>"Ball Pulse"),array("id"=>"ball-grid-pulse", "name"=>"Ball Grid Pulse"),array("id"=>"ball-clip-rotate", "name"=>"Ball Clip Rotate"),array("id"=>"ball-clip-rotate-pulse", "name"=>"Ball Clip Rotate Pulse"),array("id"=>"square-spin", "name"=>"Square Spin"),array("id"=>"ball-clip-rotate-multiple", "name"=>"Ball Clip Rotate Multiple"),array("id"=>"ball-pulse-rise", "name"=>"Ball Pulse Rise"),array("id"=>"ball-rotate", "name"=>"Ball Rotate"),array("id"=>"cube-transition", "name"=>"Cube Transition"),array("id"=>"ball-zig-zag", "name"=>"Ball Zig Zag"),array("id"=>"ball-triangle-path", "name"=>"Ball Triangle Path"),array("id"=>"ball-scale", "name"=>"Ball Scale"),array("id"=>"line-scale", "name"=>"Line Scale"),array("id"=>"line-scale-party", "name"=>"Line Scale Party"),array("id"=>"ball-scale-multiple", "name"=>"Ball Scale Multiple"),array("id"=>"ball-pulse-sync", "name"=>"Ball Pulse Sync"),array("id"=>"ball-beat", "name"=>"Ball Beat"),array("id"=>"line-scale-pulse-out", "name"=>"Line Scale Pulse Out"),array("id"=>"line-scale-pulse-out-rapid", "name"=>"Line Scale Pulse Out Rapid"),array("id"=>"ball-scale-ripple", "name"=>"Ball Scale Ripple"),array("id"=>"ball-scale-ripple-multiple", "name"=>"Ball Scale Ripple Multiple"),array("id"=>"ball-spin-fade-loader", "name"=>"Ball Spin Fade Loader"),array("id"=>"line-spin-fade-loader", "name"=>"Line Spin Fade Loader"),array("id"=>"pacman","name"=>"Pacman"),array("id"=>"load2","name"=>"Load 2"),array("id"=>"load3","name"=>"Load 3"),array("id"=>"load6","name"=>"Load 6")),
	"std" => "ball-pulse"
),

array(
	"name" => "Show Loading Percentage ?",
	"id" => DESIGNARE_SHORTNAME."_enable_website_loader_percentage",
	"type" => "checkbox",
	"std" => 'on'
),

array(
	"type" => "documentation",
	"text" => "<h3>Smooth Scroll</h3>"
),

array(
	"name" => "Enable Smooth Scroll",
	"id" => DESIGNARE_SHORTNAME."_enable_smooth_scroll",
	"type" => "checkbox",
	"std" => 'on'
),

array(
	"type" => "documentation",
	"text" => "<h3>Update Address on Scroll</h3>"
),

array(
	'name' => 'Update Address ?',
	'type' => 'checkbox',
	'id' => DESIGNARE_SHORTNAME."_update_section_titles",
	'std' => 'off',
	'desc' => 'Updates the Address with the Sections Title (on One Pages). Ex.: httpx://xxxxx.xxx/<strong>#About</strong>'
),


array(
	"type" => "documentation",
	"text" => "<h3>Go To Top</h3>"
),

array(
	"name" => "Enable Go To Top button",
	"id" => DESIGNARE_SHORTNAME."_enable_gotop",
	"type" => "checkbox",
	"std" => 'on'
),

array(
	"type" => "documentation",
	"text" => "<h3>Images with Grayscale Effect</h3>"
),

array(
	"name" => "Enable Grayscale Effect on Images",
	"id" => DESIGNARE_SHORTNAME."_enable_grayscale",
	"type" => "checkbox",
	"std" => 'off'
),

array(
	"type" => "documentation",
	"text" => "<h3>Favicon</h3>"
),


array(
	"name" => "Image URL",
	"id" => DESIGNARE_SHORTNAME."_favicon",
	"type" => "upload_from_media",
	"desc" => "Upload a favicon image - with .ico extension.",
	"std" => "http://placehold.it/4x4"
),

array(
"type" => "close"),


/* ------------------------------------------------------------------------*
 * SEO
 * ------------------------------------------------------------------------*/

array(
	"type" => "subtitle",
	"id"=>'seo'
),

array(
	"type" => "documentation",
	"text" => "<h3>SEO Options</h3>"
),

array(
	"name" => "Use theme's SEO options ?",
	"id" => DESIGNARE_SHORTNAME."_enable_theme_seo",
	"type" => "checkbox",
	"std" => 'on',
	"desc" => 'You can turn off this option if you intend to use a SEO plugin.'
),

array(
	"type" => "documentation",
	"text" => "<h3>Google Analytics</h3>"
),

array(
	"name" => "Google Analytics Code",
	"id" => DESIGNARE_SHORTNAME."_seo_analytics",
	"type" => "textarea",
	"desc" => "You can paste your generated Google Analytics here and it will be automatically set to the theme."
),

array(
	"type" => "documentation",
	"text" => "<h3>Website Info</h3>"
),

array(
	"name" => "Site Title",
	"id" => DESIGNARE_SHORTNAME."_seo_sitetitle",
	"type" => "text",
	"desc" => 'Insert a title for your site. If empty, it will use the wordpress default title/tagline.'
),

array(
	"name" => "Site Author",
	"id" => DESIGNARE_SHORTNAME."_seo_author",
	"type" => "text",
	"desc" => 'Insert the site\'s author.'
),

array(
	"name" => "Site keywords",
	"id" => DESIGNARE_SHORTNAME."_seo_keywords",
	"type" => "text",
	"desc" => 'The main keywords that describe your site, separated by commas. Example:<br />
	<i>portfolio,design,web</i>'
),

array(
	"name" => "Site Description",
	"id" => DESIGNARE_SHORTNAME."_seo_description",
	"type" => "textarea",
	"desc" => "Here you can set a description that will be displayed on your site."
),

array(
"type" => "close"),

/* ------------------------------------------------------------------------*
 * Projects
 * ------------------------------------------------------------------------*/

array(
	"type" => "subtitle",
	"id"=>'archives'
),


array(
	"type" => "documentation",
	"text" => "<h3>HomePage with Posts Listing</h3>"
),

array(
	"name" => "Primary Title",
	"id" => DESIGNARE_SHORTNAME."_index_primary_title",
	"type" => "text"
),

array(
	"name" => "Secondary Title",
	"id" => DESIGNARE_SHORTNAME."_index_secondary_title",
	"type" => "text",
	"desc" => "If set, will display this as a secondary title."
),

array(
	"type" => "documentation",
	"text" => "<h3>Blog Archive</h3>"
),

array(
	"name" => "Secondary Title",
	"id" => DESIGNARE_SHORTNAME."_archive_secondary_title",
	"type" => "text",
	"desc" => "If set, will display this as a secondary title."
),

array(
	"name" => "Sidebar ?",
	"id" => DESIGNARE_SHORTNAME."_blog_archive_sidebar",
	"type" => "select",
	"options" => array(array("id"=>"none", "name"=>"None"), array("id"=>"left", "name"=>"Left"), array("id"=>"right", "name"=>"Right")),
	"std"=>"right"
),

array(
	"name" => "Choose your Sidebar",
	"id" => DESIGNARE_SHORTNAME."_blog_archive_sidebars_available",
	"type" => "select",
	"options" => $outputsidebars
),

array(
	"name" => "Blog Style",
	"id" => DESIGNARE_SHORTNAME."_blog_archive_style",
	"type" => "select",
	"options" => array(array("id"=>"normal","name"=>"Normal style"), array("id"=>"masonry","name"=>"Masonry style")),
	"std" => "normal"
),

array(
	"type" => "documentation",
	"text" => "<h3>Projects Archive</h3>"
),

array(
	"name" => "Primary Title",
	"id" => DESIGNARE_SHORTNAME."_projects_primary_title",
	"type" => "text"
),

array(
	"name" => "Secondary Title",
	"id" => DESIGNARE_SHORTNAME."_projects_secondary_title",
	"type" => "text",
	"desc" => "If set, will display this as a secondary title."
),

array(
	"name" => "Predefined Style",
	"id" => DESIGNARE_SHORTNAME."_projects_archive_style",
	"type" => "select",
	"options" => array(array("id"=>"style1", "name"=>"Style 1"), array("id"=>"style2", "name"=>"Style 2")),
	"std"=>"no"
),

array(
	"name" => "Number of columns",
	"id" => DESIGNARE_SHORTNAME."_projects_archive_ncolumns",
	"type" => "select",
	"options" => array(array("id"=>"2col", "name"=>"2"), array("id"=>"3col", "name"=>"3"), array("id"=>"4col", "name"=>"4")),
	"std"=>"4col"
),

array(
	"name" => "Effect",
	"id" => DESIGNARE_SHORTNAME."_projects_archive_effect",
	"type" => "select",
	"options" => array(array("id"=>"move", "name"=>"Move"), array("id"=>"opacity", "name"=>"Opacity")),
	"std"=>"Move"
),

array(
"type" => "close"),

/* ------------------------------------------------------------------------*
 * Blog
 * ------------------------------------------------------------------------*/

array(
	"type" => "subtitle",
	"id"=>'blog'
),

array(
	"type" => "documentation",
	"text" => "<h3>Blog Reading Option</h3>"
),

array(
	"name" => "Reading Type",
	"id" => DESIGNARE_SHORTNAME."_blog_reading_type",
	"type" => "select",
	"options" => array(array('id'=>'default','name'=>'Default'), array('id'=>'paged','name'=>'Pagination'), array('id'=>'dropdown', 'name'=>'Pagination Dropdown List'), array('id'=>'scroll','name'=>'Load More'), array('id'=>'scrollauto','name'=>'Auto Load More')),
	"std" => 'default'
),

array(
	"type" => "documentation",
	"text" => "<h3>Blog - Single Post Options</h3>"
),

array(
	"name" => "Primary Title",
	"id" => DESIGNARE_SHORTNAME."_blog_single_primary_title",
	"type" => "text",
	"std" => ""
),

array(
	"name" => "Secondary Title",
	"id" => DESIGNARE_SHORTNAME."_blog_secondary_title",
	"type" => "text",
	"desc" => "If set, will display this as a secondary title."
),


array(
	"name" => "Sidebar ?",
	"id" => DESIGNARE_SHORTNAME."_blog_single_sidebar",
	"type" => "select",
	"options" => array(array("id"=>"none", "name"=>"None"), array("id"=>"left", "name"=>"Left"), array("id"=>"right", "name"=>"Right")),
	"std"=>"right"
),

array(
	"name" => "Choose your Sidebar",
	"id" => "yunik_sidebars_available",
	"type" => "select",
	"options" => $outputsidebars
),

array(
	"name" => "Enlarge Images on Single Post",
	"id" => DESIGNARE_SHORTNAME."_enlarge_images",
	"type" => "checkbox",
	"std" => 'off',
	"desc" => 'If "ON" PrettyPhoto effect will be available.'
),

array(
"type" => "close"),


/* ------------------------------------------------------------------------*
 * Projects
 * ------------------------------------------------------------------------*/

array(
	"type" => "subtitle",
	"id"=>'projects'
),

array(
	"type" => "documentation",
	"text" => "<h3>Projects Display</h3>"
),


array(
	"name" => "Portfolio Permalink",
	"id" => DESIGNARE_SHORTNAME."_portfolio_permalink",
	"type" => "text",
	"std" => "portfolio",
	"desc" => "Change the \"/portfolio/\" bit of the projects' permalink. <br/><strong>Max. 20 characters, can not contain capital letters or spaces.</strong>"
),

array(
	"name" => "Project Single Layout Option",
	"id" => DESIGNARE_SHORTNAME."_single_layout",
	"type" => "select",
	"options" => array(array('id'=>'left_media', 'name'=>'Media on the Left'),array('id'=>'full_media', 'name'=>'Media occupies the container\'s full length'), array('id'=>'fullwidth_media', 'name'=>'Media occupies the window\'s length')),
	"std" => 'full_media'
),

array(
	"type" => "close"
),

/* shop */
array(
	"type" => "subtitle",
	"id" => "shop"
),

array(
	"type" => "documentation",
	"text" => "<h3>WooCommerce Shop</h3><br/><p>These titles will appear on Product Pages (either single products and categories/tags)</p>"
),

array(
	"name" => "Shop Primary Title",
	"id" => DESIGNARE_SHORTNAME."_shop_primary_title",
	"type" => "text",
	"std" => "Shop"
),

array(
	"name" => "Shop Secondary Title",
	"id" => DESIGNARE_SHORTNAME."_shop_secondary_title",
	"type" => "text",
	"desc" => "If set, will display this as a secondary title."
),

array(
	"name" => "Sidebar ?",
	"id" => DESIGNARE_SHORTNAME."_woo_sidebar_scheme",
	"type" => "select",
	"options" => array(array("id"=>"none", "name"=>"None"), array("id"=>"left", "name"=>"Left"), array("id"=>"right", "name"=>"Right")),
	"std"=>"right"
),

array(
	"name" => "Choose your Sidebar",
	"id" => DESIGNARE_SHORTNAME."_woo_sidebar",
	"type" => "select",
	"options" => $outputsidebars
),

array(
	"type" => "close"
),

/* under construction mode */
array(
	"type" => "subtitle",
	"id" => "underconstruction"
),

array(
	"type" => "documentation",
	"text" => "<h3>Under Construction Mode</h3>"
),

array(
	"name" => "Under Construction Mode",
	"id" => DESIGNARE_SHORTNAME."_enable_under_construction",
	"type" => "checkbox",
	"std" => "off",
	"desc" => "If set to ON, non-logged-in users will be redirected to an Under Construction Page of your choosing."
),

array(
	"name" => "Under Construction Page",
	"id" => DESIGNARE_SHORTNAME."_under_construction_page",
	"type" => "select",
	"options" => $underconstructionpages
),

array(
	"name" => "xxxxxxxx",
	"id" => 'ultimate_selected_google_fonts',
	"type" => "fakeinput",
	"std" => $ultimate_gf
),

array(
	"name" => "xxxxxxxxy",
	"id" => 'page_on_front',
	"type" => "fakeinput",
	"std" => $page_on_front,
	"el_class" => "show_on_front"
),

array(
	"type" => "close"
),

array(
"type" => "close"));

designare_add_options($designare_general_options);