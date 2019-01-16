<?php
/**
 * @package WordPress
 * @subpackage Yunik
 */

remove_action('load-update-core.php','wp_update_plugins');
add_filter('site_transient_update_plugins','__return_false');
add_filter('pre_site_transient_update_plugins','__return_false');

add_action( 'after_setup_theme', 'designare_yunik_setup' );

function designare_yunik_setup(){
	
	//remove notifications
	add_action( 'vc_before_init', 'des_vcSetAsTheme' );
	function des_vcSetAsTheme() {
	    vc_set_as_theme(true);
	}
	if (function_exists( 'set_revslider_as_theme' )){
		add_action( 'init', 'des_set_revslider_as_theme' );
		function des_set_revslider_as_theme() {
			set_revslider_as_theme();
		}
	}

	/* Add theme-supported features. */
	/** 
	 * Add default posts and comments RSS feed links to head
	 */
	add_theme_support( 'automatic-feed-links' );
	
	/**
	 * This theme uses post thumbnails
	 */
	add_theme_support( 'post-thumbnails' );
	
	/**
	 *	This theme supports woocommerce
	 */
	add_theme_support( 'woocommerce' );
		
	/**
	 *	This theme supports editor styles
	 */
	add_editor_style("/css/layout-style.css");
	
	/* Add custom actions. */
	/**
	 * Make theme available for translation
	 * Translations can be filed in the /languages/ directory
	 */
	load_theme_textdomain( 'yunik', get_template_directory() . '/languages' );
		
	$locale = get_locale();
	$locale_file = get_template_directory() . "/languages/$locale.php";
	if ( is_readable( $locale_file ) )
		require_once( $locale_file );
	/*

	/**
	 * Set the content width based on the theme's design and stylesheet.
	 */
	if ( ! isset( $content_width ) )
		$content_width = 900;
	
	
	
	/**
	 * Functions
	 * 
	 * This is the main functions file that can add some additional functionality to the theme.
	 * It calls an object from a manager class that inits all the needed functionality.
	 */
	
	//declare some global variables that will be used everywhere
	global $designare_new_meta_boxes,
		$designare_new_meta_post_boxes,
		$designare_new_meta_portfolio_boxes,
		$designare_buttons,
		$designare_data;
	$designare_new_meta_boxes=array();
	$designare_new_meta_post_boxes=array();
	$designare_new_meta_portfolio_boxes=array();
	$designare_buttons=array();
	$designare_data=new stdClass();
	
	/*----------------------------------------------------------------
	 *  DEFINE THE MAIN CONSTANTS
	 *---------------------------------------------------------------*/
	
	//main theme info constants
	define("DESIGNARE_THEMENAME", 'Yunik');
	if (!defined('DESIGNARE_SHORTNAME')) define("DESIGNARE_SHORTNAME", 'yunik');
	
	$my_theme = wp_get_theme();
	define("DESIGNARE_VERSION", $my_theme->Version);
	
	global $des_theme_prefix; $des_theme_prefix = "yunik_";
	
	//define the main paths and URLs
	define("DESIGNARE_LIB_PATH", get_template_directory() . '/lib/');
	define("DESIGNARE_LIB_URL", get_template_directory_uri().'/lib/');
	define("DESIGNARE_JS_PATH", get_template_directory_uri().'/js/');
	define("DESIGNARE_CSS_PATH", get_template_directory_uri().'/css/');

	define("DESIGNARE_FUNCTIONS_PATH", DESIGNARE_LIB_PATH . 'functions/');
	define("DESIGNARE_FUNCTIONS_URL", DESIGNARE_LIB_URL.'functions/');
	define("DESIGNARE_CLASSES_PATH", DESIGNARE_LIB_PATH.'classes/');
	define("DESIGNARE_OPTIONS_PATH", DESIGNARE_LIB_PATH.'options/');
	define("DESIGNARE_WIDGETS_PATH", DESIGNARE_LIB_PATH.'widgets/');
	define("DESIGNARE_SHORTCODES_PATH", DESIGNARE_LIB_PATH.'shortcodes/');
	define("DESIGNARE_PLUGINS_PATH", DESIGNARE_LIB_PATH.'plugins/');
	define("DESIGNARE_UTILS_URL", DESIGNARE_LIB_URL.'utils/');
	
	define("DESIGNARE_IMAGES_URL", DESIGNARE_LIB_URL.'images/');
	define("DESIGNARE_CSS_URL", DESIGNARE_LIB_URL.'css/');
	define("DESIGNARE_SCRIPT_URL", DESIGNARE_LIB_URL.'script/');
	define("DESIGNARE_PATTERNS_URL", get_template_directory_uri().'/images/yunik_patterns/');
	$uploadsdir=wp_upload_dir();
	define("DESIGNARE_UPLOADS_URL", $uploadsdir['url']);
	define("DESIGNARE_SEPARATOR", '|*|');
	define("DESIGNARE_OPTIONS_PAGE", 'designare_options');
	define("DESIGNARE_STYLE_OPTIONS_PAGE", 'designare_style_options');
	define("DESIGNARE_DEMOS_PAGE", 'designare_demos');

	/*----------------------------------------------------------------
	 *  INCLUDE THE FUNCTIONS FILES
	 *---------------------------------------------------------------*/
			
	require_once (DESIGNARE_FUNCTIONS_PATH.'general.php');  //some main common functions
	add_action('wp_enqueue_scripts', 'designare_yunik_style', 1);
	add_action('wp_enqueue_scripts','designare_yunik_custom_head', 2);
	add_action('wp_enqueue_scripts', 'designare_scripts', 10);
	add_action('wp_head','designare_css_options', 13);

	require_once (DESIGNARE_FUNCTIONS_PATH.'stylesheet.php');  //some main common functions
	require_once (DESIGNARE_FUNCTIONS_PATH.'sidebars.php');  //the sidebar functionality
	if ( isset($_GET['page']) && $_GET['page'] == DESIGNARE_OPTIONS_PAGE ){
		require_once (DESIGNARE_CLASSES_PATH.'designare-options-manager.php');  //the theme options manager functionality
	}
	if ( isset($_GET['page']) && $_GET['page'] == DESIGNARE_STYLE_OPTIONS_PAGE ){
		require_once (DESIGNARE_CLASSES_PATH.'designare-style-options-manager.php');  //the theme options manager functionality
	}
	if ( isset($_GET['page']) && $_GET['page'] == DESIGNARE_DEMOS_PAGE ){
		require_once (DESIGNARE_CLASSES_PATH.'designare-demos-manager.php');  //the theme options manager functionality
	}
		
	require_once (DESIGNARE_CLASSES_PATH.'designare-templater.php');  
	require_once (DESIGNARE_CLASSES_PATH.'designare-custom-data-manager.php');  
	require_once (DESIGNARE_CLASSES_PATH.'designare-custom-page.php');  
	require_once (DESIGNARE_CLASSES_PATH.'designare-custom-page-manager.php');  
	require_once (DESIGNARE_FUNCTIONS_PATH.'custom-pages.php');  //the comments functionality
	require_once (DESIGNARE_FUNCTIONS_PATH.'ajax.php');  //AJAX handler functions
	require_once (DESIGNARE_FUNCTIONS_PATH.'comments.php');  //the comments functionality
	require_once (DESIGNARE_WIDGETS_PATH.'widgets.php');  //the widgets functionality
	require_once (DESIGNARE_FUNCTIONS_PATH.'options.php');  //the theme options functionality
	require_once (DESIGNARE_LIB_PATH.'classes/Mobile_Detect.php');
	
	if (is_admin()){
		require_once (DESIGNARE_FUNCTIONS_PATH. 'meta.php');  //adds the custom meta fields to the posts and pages
		add_action('admin_enqueue_scripts','designare_yunik_admin_style');
	}
	$functions_path = get_template_directory() . '/functions/';
	
	require_once ($functions_path . 'admin-init.php' );
	
	add_filter('add_to_cart_fragments' , 'des_woocommerce_header_add_to_cart_fragment' );
	
	// Declare sidebar widget zone
	if (function_exists('register_sidebar')) {
		register_sidebar(array(
			'name' => 'Blog Sidebar',
			'id'   => 'sidebar-widgets',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h2>',
			'after_title'   => '</h2>'
		));
	}
	
	if (!function_exists('wp_pagenavi')){ 
		$including = $functions_path. 'wp-pagenavi.php';
	    require_once($including);
	}

	/* tgm plugin activator */
	
	/**
	 * This file represents an example of the code that themes would use to register
	 * the required plugins.
	 *
	 * It is expected that theme authors would copy and paste this code into their
	 * functions.php file, and amend to suit.
	 *
	 * @package	   TGM-Plugin-Activation
	 * @subpackage Example
	 * @version	   2.3.6
	 * @author	   Thomas Griffin <thomas@thomasgriffinmedia.com>
	 * @author	   Gary Jones <gamajo@gamajo.com>
	 * @copyright  Copyright (c) 2012, Thomas Griffin
	 * @license	   http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
	 * @link       https://github.com/thomasgriffin/TGM-Plugin-Activation
	 */
	
	/**
	 * Include the TGM_Plugin_Activation class.
	 */
	require_once DESIGNARE_FUNCTIONS_PATH . 'class-tgm-plugin-activation.php';
	
	add_action( 'tgmpa_register', 'des_register_required_plugins' );	
	
	if ( function_exists('vc_remove_element') ){
		// Finally initialize code
		new VCExtendAddonClass();	
	}
	
	if (get_option(DESIGNARE_SHORTNAME."_enable_smooth_scroll") == "on"){
		update_option('ultimate_smooth_scroll','enable');
	} else update_option('ultimate_smooth_scroll','disable');
	add_filter( 'woocommerce_enqueue_styles', '__return_false' );
}

function designare_yunik_admin_style(){
	wp_enqueue_style('css19', DESIGNARE_CSS_PATH .'font-awesome-painel.min.css');
	//wp_enqueue_script('admin-scripts', DESIGNARE_SCRIPT_URL .'admin-scripts.js');
}

function designare_css_options(){
	global $yunik_custom, $yunik_styleColor, $post, $des_import_fonts;;
	$theid = get_the_ID();
	$yunik_styleColor = "#".get_option(DESIGNARE_SHORTNAME."_style_color");
	if ("#".get_option(DESIGNARE_SHORTNAME."_style_color") != $yunik_styleColor) $yunik_styleColor = "#".get_option(DESIGNARE_SHORTNAME."_style_color");
	$yunik_styleColor_rgb = des_hex2rgb($yunik_styleColor);
	$bodyLayoutType = get_option(DESIGNARE_SHORTNAME."_body_layout_type");
	$headerType = get_option(DESIGNARE_SHORTNAME."_header_type");
	?>
	<!-- Style Options -->
	<style class="from_style_panel_options" type="text/css">
	
	<?php global $des_import_fonts; ?>
	
	.widget li a:after, .widget_nav_menu li a:after, .custom-widget.widget_recent_entries li a:after{
		color: #<?php echo get_option('yunik_p_color'); ?>;
	}
	body, p, .lovepost a, .widget ul li a, .widget p, .widget span, .widget ul li, .the_content ul li, .the_content ol li, #recentcomments li, .custom-widget h4, .widget.widget-newsletter h3, .widget.des_cubeportfolio_widget h4, .widget.des_recent_posts_widget h4, .custom-widget ul li a, .des_partners_widget h4, .aio-icon-description{
		<?php $font = get_option('yunik_p_font'); $des_import_fonts[] = $font; $font = explode("|",$font); if ($font[0] == "Helvetica" || $font[0] == "Helvetica Neue") $font[0] = $font[0]."', 'Arial', 'sans-serif"; if (!isset($font[1])) $font[1] = ""; ?>
		font-family: '<?php echo $font[0]; ?>';
		font-weight: <?php echo $font[1] ?>;
		font-size: <?php echo intval(get_option('yunik_p_size'), 10)."px"; ?>;
		color: #<?php echo get_option('yunik_p_color'); ?>;
	}
	
	.map_info_text{
		<?php $font = get_option('yunik_p_font'); $des_import_fonts[] = $font; $font = explode("|",$font); if ($font[0] == "Helvetica" || $font[0] == "Helvetica Neue") $font[0] = $font[0]."', 'Arial', 'sans-serif"; if (!isset($font[1])) $font[1] = ""; ?>
		font-family: '<?php echo $font[0]; ?>';
		font-weight: <?php echo $font[1] ?>;
		font-size: <?php echo intval(get_option('yunik_p_size'), 10)."px"; ?>;
		color: #<?php echo get_option('yunik_p_color'); ?> !important;
	}
	
	a, .pageXofY .pageX, .pricing .bestprice .name, .filter li a:hover, .widget_links ul li a:hover, #contacts a:hover, .title-color, .ms-staff-carousel .ms-staff-info h4, .filter li a:hover, .navbar-default .navbar-nav > .open > a, .navbar-default .navbar-nav > .open > a:hover, .navbar-default .navbar-nav > .open > a:focus, a.go-about:hover, .text_color, .navbar-nav .dropdown-menu a:hover, .profile .profile-name, #elements h4, #contact li a:hover, #agency-slider h5, .ms-showcase1 .product-tt h3, .filter li a.active, .contacts li i, .big-icon i, .navbar-default.dark .navbar-brand:hover,.navbar-default.dark .navbar-brand:focus, a.p-button.border:hover, .navbar-default.light-menu .navbar-nav > li > a.selected, .navbar-default.light-menu .navbar-nav > li > a.selected:hover, .navbar-default.light-menu .navbar-nav > li > a.selected, .navbar-default.light-menu .navbar-nav > .open > a,.navbar-default.light-menu .navbar-nav > .open > a:hover, .navbar-default.light-menu .navbar-nav > .open > a:focus, .light-menu .dropdown-menu > li > a:focus, a.social:hover:before, .symbol.colored i, .icon-nofill, .slidecontent-bi .project-title-bi p a:hover, .grid .figcaption a.thumb-link:hover, .tp-caption a:hover, .btn-1d:hover, .btn-1d:active, #contacts .tweet_text a, #contacts .tweet_time a, .social-font-awesome li a:hover, h2.post-title a:hover, .tags a:hover, .des-button-color span, #contacts .form-success p, .nav-container .social-icons-fa a i:hover, .the_title h2 a:hover, .widget ul li a:hover, .nav-previous-nav1:hover a, .nav-next-nav1:hover a, .des_breadcrumbs a:hover, .special_tabs.icontext .label.current a, .special_tabs.text .label.current a, #big_footer .widget-newsletter .banner .text_color, .custom-widget .widget-newsletter .banner .text_color, .des-pages .postpagelinks, .widget_nav_menu .current-menu-item a{
	  color: <?php echo $yunik_styleColor; ?>;
	}
	
	.aio-icon-read, .tp-caption a.text_color{color: <?php echo $yunik_styleColor ?> !important;}
	
	.homepage_parallax .home-logo-text a.light:hover, .homepage_parallax .home-logo-text a.dark:hover{
		color: <?php echo $yunik_styleColor; ?> !important;
	}
	
	a.sf-button.hide-icon, .tabs li.current, .readmore:hover, .navbar-default .navbar-nav > .open > a,.navbar-default .navbar-nav > .open > a:hover, .navbar-default .navbar-nav > .open > a:focus, a.p-button:hover, a.p-button.colored, .light #contacts a.p-button, .tagcloud a:hover, .rounded.fill, .colored-section, .pricing .bestprice .price, .pricing .bestprice .signup, .signup:hover, .divider.colored, .services-graph li span, .no-touch .hi-icon-effect-1a .hi-icon:hover, .hi-icon-effect-1b .hi-icon:hover, .no-touch .hi-icon-effect-1b .hi-icon:hover, .symbol.colored .line-left, .symbol.colored .line-right, .projects-overlay #projects-loader, .panel-group .panel.active .panel-heading, .double-bounce1, .double-bounce2, .des-button-color-1d:after, .container1 > div, .container2 > div, .container3 > div, .cbp-l-caption-buttonLeft:hover, .cbp-l-caption-buttonRight:hover, .flex-control-paging li a.flex-active, .post-content a:hover .post-quote, .post-listing .post a:hover .post-quote, h2.post-title.post-link:hover, header:not(.header_after_scroll) .dl-menuwrapper button.dl-trigger, .dl-menuwrapper button, .des-button-color-1d:after, .woocommerce .widget_price_filter .ui-slider-horizontal .ui-slider-range, .woocommerce-page .widget_price_filter .ui-slider-horizontal .ui-slider-range,.yunik_little_shopping_bag .overview span.minicart_items, .nav-previous, .nav-next, .next-posts, .prev-posts, .btn-contact-left input, .single #commentform .form-submit #submit, .page-template-blog-masonry-template .posts_category_filter li:hover{
		background-color:<?php echo $yunik_styleColor; ?>;
	}
	
	 .info-cirlce-active{
		background-color:<?php echo $yunik_styleColor; ?> !important;color: #fff !important;
	}
	
	.widget .slick-dots li.slick-active i, .style-light .slick-dots li.slick-active i, .style-dark .slick-dots li.slick-active i{color: <?php echo $yunik_styleColor; ?> !important;opacity: 1;}
	
	
	.woocommerce #content input.button, .woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button, .woocommerce-page #content input.button, .woocommerce-page #respond input#submit, .woocommerce-page a.button, .woocommerce-page button.button, .woocommerce-page input.button, .woocommerce #content div.product form.cart .button, .woocommerce div.product form.cart .button, .woocommerce-page #content div.product form.cart .button, .woocommerce-page div.product form.cart .button, .woocommerce ul.products li.product .onsale, .woocommerce-page ul.products li.product .onsale{
		background-color:<?php echo $yunik_styleColor; ?>;
		color: #fff !important;
	}
	.nav-container a.button.yunik_minicart_checkout_but:hover, .nav-container a.button.yunik_minicart_cart_but:hover{
		background-color: <?php echo $yunik_styleColor; ?> !important;
		color: #fff !important;
		border: 2px solid <?php echo $yunik_styleColor; ?> !important;
		opacity: 1;
	}
	.des-button-color-1d:hover, .des-button-color-1d:active, .page-template-blog-masonry-template .posts_category_filter li:hover{
		border: 1px double <?php echo $yunik_styleColor; ?>;
	}
	.des-button-color{
		background-color:<?php echo $yunik_styleColor; ?>;
		color: <?php echo $yunik_styleColor; ?>;
	}
	.vc_tta-color-grey.vc_tta-style-classic .vc_tta-panel.vc_active .vc_tta-panel-heading {
    	border-color: <?php echo $yunik_styleColor; ?> !important;
    	background-color: <?php echo $yunik_styleColor; ?> !important;
	}
	.widget_posts .tabs li.current{border: 1px solid <?php echo $yunik_styleColor; ?>;}
	.hi-icon-effect-1 .hi-icon:after{box-shadow: 0 0 0 3px <?php echo $yunik_styleColor; ?>;}
	.colored-section:after {border: 20px solid <?php echo $yunik_styleColor; ?>;}
	.filter li a.active, .filter li a:hover, .panel-group .panel.active .panel-heading{border:1px solid <?php echo $yunik_styleColor; ?>}
	.navbar-default.light-menu.border .navbar-nav > li > a.selected:before, .navbar-default.light-menu.border .navbar-nav > li > a.selected:hover, .navbar-default.light-menu.border .navbar-nav > li > a.selected{
		border-bottom: 1px solid <?php echo $yunik_styleColor; ?>;
	}
	
	.cbp-l-caption-alignCenter .cbp-l-caption-buttonLeft:hover, .cbp-l-caption-alignCenter .cbp-l-caption-buttonRight:hover {
    background-color: <?php echo $yunik_styleColor; ?> !important;
    border: 2px solid <?php echo $yunik_styleColor; ?> !important;
    color: #fff !important;
}
	.doubleborder{
		border: 6px double <?php echo $yunik_styleColor; ?>;
	}
	.special_tabs .current .designare_icon_special_tabs{
		background: <?php echo $yunik_styleColor; ?>;
		border: 1px solid transparent;
	}
	.des-button-color, .des-pages .postpagelinks, .tagcloud a:hover{
		border: 1px solid <?php echo $yunik_styleColor; ?>;
	}
	
	.featured-image a .post_overlay, body.single-post a.des_prettyphoto .post_overlay{
		<?php
			$color = des_hex2rgb($yunik_styleColor);
		?>
		background-color: rgba(<?php echo $color[0].",".$color[1].",".$color[2].",.97"; ?>) !important;
	}
	
	.navbar-collapse ul.menu-depth-1 li:not(.des_mega_hide_link) a, .dl-menuwrapper li:not(.des_mega_hide_link) a, .gosubmenu, .nav-container .yunik_minicart ul li {
		<?php $font = get_option('yunik_sub_menu_font'); $des_import_fonts[] = $font; $font = explode("|",$font); if ($font[0] == "Helvetica" || $font[0] == "Helvetica Neue") $font[0] = $font[0]."', 'Arial', 'sans-serif"; if (!isset($font[1])) $font[1] = ""; ?>
		font-family: '<?php echo $font[0]; ?>';
		font-weight: <?php echo $font[1] ?>;
		font-size: <?php echo intval(get_option('yunik_sub_menu_font_size'),10)."px"; ?>;
		color: #<?php echo get_option('yunik_sub_menu_color'); ?>;
		<?php if (get_option('yunik_sub_menu_uppercase') === 'on') echo "text-transform: uppercase;\n"; ?>
		letter-spacing: <?php echo intval(get_option('yunik_sub_menu_letter_spacing'),10)."px"; ?>;
	}
	.dl-back{color: #<?php echo get_option('yunik_sub_menu_color'); ?>;}
	
	.navbar-collapse ul.menu-depth-1 li:not(.des_mega_hide_link):hover > a, .dl-menuwrapper li:not(.des_mega_hide_link):hover > a, .dl-menuwrapper li:not(.des_mega_hide_link):hover > a, .dl-menuwrapper li:not(.des_mega_hide_link):hover > .gosubmenu, .dl-menuwrapper li.dl-back:hover{
		color: #<?php echo get_option('yunik_sub_menu_color_hover'); ?>;
	}
	
	ul.menu-depth-1, ul.menu-depth-1 ul, .dl-menu{
		<?php
			$color = des_hex2rgb(get_option("yunik_sub_menu_bg_color"));
		?>
		background-color: rgba(<?php echo $color[0].",".$color[1].",".$color[2].",".intval(str_replace("%","",get_option("yunik_sub_menu_bg_opacity")))/100; ?>) !important;
	}
	
	.navbar-collapse .des_mega_menu ul.menu-depth-2, .navbar-collapse .des_mega_menu ul.menu-depth-2 ul {background-color: transparent !important;} 
	
	li:not(.des_mega_menu) ul.menu-depth-1 li:hover, li.des_mega_menu li.menu-item-depth-1 li:hover, .dl-menu li:hover{
		<?php
			$color = des_hex2rgb(get_option("yunik_sub_menu_bg_color_hover"));
		?>
		background-color: rgba(<?php echo $color[0].",".$color[1].",".$color[2].",".intval(str_replace("%","",get_option("yunik_sub_menu_bg_opacity")))/100; ?>) !important;
	}
	
	.navbar-collapse li:not(.des_mega_menu) ul.menu-depth-1 li:not(:first-child){
		border-top: 1px solid #<?php echo get_option('yunik_sub_menu_border_color'); ?>;
	}
	
	
	
	.navbar-collapse li.des_mega_menu ul.menu-depth-2{
		border-right: 1px solid #<?php echo get_option('yunik_sub_menu_border_color'); ?>;
	}
	.dl-menu li:not(:last-child), .dl-menu ul li:not(:last-child), .yunik_sub_menu_border_color{
		border-bottom: 1px solid #<?php echo get_option('yunik_sub_menu_border_color'); ?>;
	}
	
	
	.navbar-collapse > ul > li > a{
		<?php $font = get_option('yunik_menu_font'); $des_import_fonts[] = $font; $font = explode("|",$font); if ($font[0] == "Helvetica" || $font[0] == "Helvetica Neue") $font[0] = $font[0]."', 'Arial', 'sans-serif"; if (!isset($font[1])) $font[1] = ""; ?>
		font-family: '<?php echo $font[0]; ?>';
		font-weight: <?php echo $font[1] ?>;
		font-size: <?php echo intval(get_option('yunik_menu_font_size'),10)."px"; ?>;
		color: #<?php echo get_option('yunik_menu_color'); ?>;
		<?php if (get_option('yunik_menu_uppercase') === 'on') echo "text-transform: uppercase;\n"; ?>
		letter-spacing: <?php echo intval(get_option('yunik_menu_letter_spacing'),10)."px"; ?>;
	}
	
	.navbar-collapse > ul > li > a:hover, .navbar-collapse > ul > li.current-menu-ancestor > a:not(.mainhomepage), .navbar-collapse > ul > li.current-menu-item > a:not(.mainhomepage), .navbar-collapse > ul > li > a.selected{
		color: #<?php echo get_option('yunik_menu_color_hover'); ?>;
	}
	
	.current-menu-item a{
		color: #<?php echo get_option('yunik_menu_color_hover'); ?> !important;
	}
	
	<?php
		if (get_option('yunik_menu_add_border') == "on"){
			?>
			.navbar-collapse ul.menu-depth-1, .nav-container .yunik_minicart{border-top:3px solid #<?php echo get_option('yunik_menu_border_color'); ?> !important;}
			<?php
		}
	?>
	
	li.des_mega_hide_link > a, li.des_mega_hide_link > a:hover{
		<?php $font = get_option('yunik_label_menu_font'); $des_import_fonts[] = $font; $font = explode("|",$font); if ($font[0] == "Helvetica" || $font[0] == "Helvetica Neue") $font[0] = $font[0]."', 'Arial', 'sans-serif"; if (!isset($font[1])) $font[1] = ""; ?>
		font-family: '<?php echo $font[0]; ?>' !important;
		font-weight: <?php echo $font[1] ?>;
		font-size: <?php echo intval(get_option('yunik_label_menu_font_size'),10)."px"; ?> !important;
		color: #<?php echo get_option('yunik_label_menu_color'); ?> !important;
		<?php if (get_option('yunik_label_menu_uppercase') === 'on') echo "text-transform: uppercase !important;\n"; ?>
		letter-spacing: <?php echo intval(get_option('yunik_label_menu_letter_spacing'),10)."px !important"; ?>;
	}
	
	.nav-container .yunik_minicart li a:hover {
		<?php $font = get_option('yunik_label_menu_font'); $des_import_fonts[] = $font; $font = explode("|",$font); if ($font[0] == "Helvetica" || $font[0] == "Helvetica Neue") $font[0] = $font[0]."', 'Arial', 'sans-serif"; if (!isset($font[1])) $font[1] = ""; ?>
/*
		font-family: '<?php echo $font[0]; ?>' !important;
		font-weight: <?php echo $font[1] ?>;
		font-size: <?php echo intval(get_option('yunik_label_menu_font_size'),10)."px"; ?> !important;
*/
		color: #<?php echo get_option('yunik_label_menu_color'); ?> !important;
/* 		letter-spacing: <?php echo intval(get_option('yunik_label_menu_letter_spacing'),10)."px !important"; ?>; */
		text-decoration: none;
	}
	.nav-container .yunik_minicart li a{
		<?php $font = get_option('yunik_sub_menu_font'); $des_import_fonts[] = $font; $font = explode("|",$font); if ($font[0] == "Helvetica" || $font[0] == "Helvetica Neue") $font[0] = $font[0]."', 'Arial', 'sans-serif"; if (!isset($font[1])) $font[1] = ""; ?>
		font-family: '<?php echo $font[0]; ?>';
		font-weight: <?php echo $font[1] ?>;
		font-size: <?php echo intval(get_option('yunik_sub_menu_font_size'),10)."px"; ?>;
		color: #<?php echo get_option('yunik_sub_menu_color'); ?>;
		<?php if (get_option('yunik_sub_menu_uppercase') === 'on') echo "text-transform: uppercase;\n"; ?>
		letter-spacing: <?php echo intval(get_option('yunik_sub_menu_letter_spacing'),10)."px"; ?>;
	}
	
	.dl-trigger{
		<?php $font = get_option('yunik_menu_font'); $des_import_fonts[] = $font; $font = explode("|",$font); if ($font[0] == "Helvetica" || $font[0] == "Helvetica Neue") $font[0] = $font[0]."', 'Arial', 'sans-serif"; if (!isset($font[1])) $font[1] = ""; ?>
		font-family: '<?php echo $font[0]; ?>' !important;
		font-weight: <?php echo $font[1] ?> !important;
		font-size: <?php echo intval(get_option('yunik_menu_font_size'),10)."px"; ?>;
		<?php if (get_option('yunik_menu_uppercase') === 'on') echo "text-transform: uppercase;\n"; ?>
		letter-spacing: <?php echo intval(get_option('yunik_menu_letter_spacing'),10)."px"; ?>;
	}
	
	.navbar-default .navbar-nav > li > a {
		padding-right:<?php echo intval(get_option('yunik_menu_side_margin'),10)."px"; ?>;
		padding-left:<?php echo intval(get_option('yunik_menu_side_margin'),10)."px"; ?>;
		padding-top:<?php echo intval(get_option('yunik_menu_margin_top'),10)."px"; ?>;
		padding-bottom:<?php echo intval(get_option('yunik_menu_padding_bottom'),10)."px"; ?>;
	}
	
	header.style1 .header_social_icons, header.style2 .header_social_icons, header.style1 .search_trigger, header.style2 .search_trigger, header.style1 .yunik_dynamic_shopping_bag, header.style2 .yunik_dynamic_shopping_bag{
		padding-top:<?php echo intval(get_option('yunik_menu_margin_top'),10)."px"; ?>;
		padding-bottom:<?php echo intval(get_option('yunik_menu_padding_bottom'),10)."px"; ?>;
	}
	
	header:not(.header_after_scroll) .navbar-nav > li > ul{
		margin-top:<?php echo intval(get_option('yunik_menu_padding_bottom'),10)."px"; ?>;
	}

	.yunik_minicart_wrapper{
		padding-top: <?php echo intval(get_option('yunik_menu_padding_bottom'),11)."px"; ?>;
	}
	
	.yunik_minicart{
		<?php
			$color = des_hex2rgb(get_option("yunik_sub_menu_bg_color"));
		?>
		background-color: rgba(<?php echo $color[0].",".$color[1].",".$color[2].",".intval(str_replace("%","",get_option("yunik_sub_menu_bg_opacity")))/100; ?>) !important;
	}
	
	/* typography */
	.page_content a, header a, #big_footer a{
		<?php $font = get_option('yunik_links_font'); $des_import_fonts[] = $font; $font = explode("|",$font); if ($font[0] == "Helvetica" || $font[0] == "Helvetica Neue") $font[0] = $font[0]."', 'Arial', 'sans-serif"; if (!isset($font[1])) $font[1] = ""; ?>
		font-family: '<?php echo $font[0]; ?>';
		font-weight: <?php echo $font[1] ?>;
		font-size: <?php echo intval(get_option('yunik_links_size'), 10)."px"; ?>;
		color: #<?php echo get_option('yunik_links_color'); ?>
	}
	.page_content a:hover, header a:hover, #big_footer a:hover{
		color: #<?php echo get_option('yunik_links_color_hover'); ?>;
		background-color: #<?php echo get_option('yunik_links_bg_color_hover'); ?>;
	}
	
	
	h1{
		<?php $font = get_option('yunik_h1_font'); $des_import_fonts[] = $font; $font = explode("|",$font); if ($font[0] == "Helvetica" || $font[0] == "Helvetica Neue") $font[0] = $font[0]."', 'Arial', 'sans-serif"; if (!isset($font[1])) $font[1] = ""; ?>
		font-family: '<?php echo $font[0]; ?>';
		font-weight: <?php echo $font[1] ?>;
		font-size: <?php echo intval(get_option('yunik_h1_size'), 10)."px"; ?>;
		color: #<?php echo get_option('yunik_h1_color'); ?>;
	}
	
	h2{
		<?php $font = get_option('yunik_h2_font'); $des_import_fonts[] = $font; $font = explode("|",$font); if ($font[0] == "Helvetica" || $font[0] == "Helvetica Neue") $font[0] = $font[0]."', 'Arial', 'sans-serif"; if (!isset($font[1])) $font[1] = ""; ?>
		font-family: '<?php echo $font[0]; ?>';
		font-weight: <?php echo $font[1] ?>;
		font-size: <?php echo intval(get_option('yunik_h2_size'), 10)."px"; ?>;
		color: #<?php echo get_option('yunik_h2_color'); ?>;
	}
	
	h3{
		<?php $font = get_option('yunik_h3_font'); $des_import_fonts[] = $font; $font = explode("|",$font); if ($font[0] == "Helvetica" || $font[0] == "Helvetica Neue") $font[0] = $font[0]."', 'Arial', 'sans-serif"; if (!isset($font[1])) $font[1] = ""; ?>
		font-family: '<?php echo $font[0]; ?>';
		font-weight: <?php echo $font[1] ?>;
		font-size: <?php echo intval(get_option('yunik_h3_size'), 10)."px"; ?>;
		color: #<?php echo get_option('yunik_h3_color'); ?>;
	}
	
	h4{
		<?php $font = get_option('yunik_h4_font'); $des_import_fonts[] = $font; $font = explode("|",$font); if ($font[0] == "Helvetica" || $font[0] == "Helvetica Neue") $font[0] = $font[0]."', 'Arial', 'sans-serif"; if (!isset($font[1])) $font[1] = ""; ?>
		font-family: '<?php echo $font[0]; ?>';
		font-weight: <?php echo $font[1] ?>;
		font-size: <?php echo intval(get_option('yunik_h4_size'), 10)."px"; ?>;
		color: #<?php echo get_option('yunik_h4_color'); ?>;
	}
	.widget h2 > .widget_title_span, .wpb_content_element .wpb_accordion_header a, .custom-widget h4, .widget.widget-newsletter h3, .widget.des_cubeportfolio_widget h4, .widget.des_recent_posts_widget h4, .des_partners_widget h4{
		color: #<?php echo get_option('yunik_h4_color'); ?>;
		font-size: 14px !important;
	}
	.ult-item-wrap .title h4{font-size: 16px !important;}
	.wpb_content_element .wpb_accordion_header.ui-accordion-header-active a{color: <?php echo $yunik_styleColor; ?>;}
	h5{
		<?php $font = get_option('yunik_h5_font'); $des_import_fonts[] = $font; $font = explode("|",$font); if ($font[0] == "Helvetica" || $font[0] == "Helvetica Neue") $font[0] = $font[0]."', 'Arial', 'sans-serif"; if (!isset($font[1])) $font[1] = ""; ?>
		font-family: '<?php echo $font[0]; ?>';
		font-weight: <?php echo $font[1] ?>;
		font-size: <?php echo intval(get_option('yunik_h5_size'), 10)."px"; ?>;
		color: #<?php echo get_option('yunik_h5_color'); ?>;
	}
	
	h6{
		<?php $font = get_option('yunik_h6_font'); $des_import_fonts[] = $font; $font = explode("|",$font); if ($font[0] == "Helvetica" || $font[0] == "Helvetica Neue") $font[0] = $font[0]."', 'Arial', 'sans-serif"; if (!isset($font[1])) $font[1] = ""; ?>
		font-family: '<?php echo $font[0]; ?>';
		font-weight: <?php echo $font[1] ?>;
		font-size: <?php echo intval(get_option('yunik_h6_size'), 10)."px"; ?>;
		color: #<?php echo get_option('yunik_h6_color'); ?>;
	}
		
	header.navbar{
		<?php
		switch (get_option('yunik_headerbg_type')){
			case "color":
				$color = des_hex2rgb(get_option(DESIGNARE_SHORTNAME."_headerbg_color"));
				?>
				background-color: rgba(<?php echo $color[0].",".$color[1].",".$color[2].",".intval(str_replace("%","",get_option(DESIGNARE_SHORTNAME."_headerbg_opacity")))/100; ?>);
				<?php
			break;
			case "image":
				echo "background-repeat:no-repeat; background-position:center center; -o-background-size: cover !important; -moz-background-size: cover !important; -webkit-background-size: cover !important; background-size: cover !important;";
				echo "background: url(" . get_option("yunik_headerbg_image") . ") no-repeat fixed !important; background-size: cover !important;";  
			break;
			case "pattern":
				echo "background: url('" . get_template_directory_uri() . "/images/yunik_patterns/" . get_option("yunik_headerbg_pattern") . "') 0 0 repeat !important;";
			break;
			case "custom_pattern":
				echo "background: url('" . get_option("yunik_headerbg_custom_pattern") . "') 0 0 repeat !important;";
			break;
		}
		?>
	}
	
	
	body#boxed_layout{
		<?php 
		switch (get_option(DESIGNARE_SHORTNAME."_bodybg_type")){
			case "image":
				echo "background-repeat:no-repeat; background-position:center center; -o-background-size: cover !important; -moz-background-size: cover !important; -webkit-background-size: cover !important; background-size: cover !important;width: 100%;height: 100%;
	background-attachment: fixed !important;";
				echo "background: url(" . get_option(DESIGNARE_SHORTNAME."_bodybg_type_image") . ") no-repeat;";  
			break;
			case "color":
	 				echo "background-color: #" . get_option(DESIGNARE_SHORTNAME."_bodybg_type_color") . ";";
			break;
			
		}
		?>	
	}
	
		
	header a.navbar-brand{
		<?php if(get_option(DESIGNARE_SHORTNAME."_logo_margin_top")) echo "margin-top: " . str_replace(" ", "", get_option(DESIGNARE_SHORTNAME."_logo_margin_top")) . ";margin-bottom: " . str_replace(" ", "", get_option(DESIGNARE_SHORTNAME."_logo_margin_top")) . ";"; ?> <?php if(get_option(DESIGNARE_SHORTNAME."_logo_margin_left")) echo "margin-left: " . str_replace(" ", "", get_option(DESIGNARE_SHORTNAME."_logo_margin_left")) . ";"; if(get_option(DESIGNARE_SHORTNAME."_logo_height")) echo "height:" . get_option(DESIGNARE_SHORTNAME."_logo_height") . ";"; ?>
	}
	header a.navbar-brand img{max-height: <?php echo intval(get_option('yunik_logo_height'),10)."px"; ?>;}
	<?php
		
		$header_after_scroll = false;
		if (get_option('yunik_fixed_menu') == 'on'){
			if (get_option('yunik_header_after_scroll') == 'on'){
				$header_after_scroll = true;
				?>
				
				header.navbar.header_after_scroll, header.header_after_scroll .navbar-nav > li.des_mega_menu > .dropdown-menu, header.header_after_scroll .navbar-nav > li:not(.des_mega_menu) .dropdown-menu{
					<?php
					switch (get_option('yunik_headerbg_after_scroll_type')){
						case "color":
							$color = des_hex2rgb(get_option(DESIGNARE_SHORTNAME."_headerbg_after_scroll_color"));
							?>
							background-color: rgba(<?php echo $color[0].",".$color[1].",".$color[2].",".intval(str_replace("%","",get_option(DESIGNARE_SHORTNAME."_headerbg_after_scroll_opacity")))/100; ?>);
							<?php
						break;
						case "image":
							echo "background-repeat:no-repeat; background-position:center center; -o-background-size: cover !important; -moz-background-size: cover !important; -webkit-background-size: cover !important; background-size: cover !important;";
							echo "background: url(" . get_option("yunik_headerbg_after_scroll_image") . ") no-repeat fixed !important; background-size: cover !important;";  
						break;
						case "pattern":
							echo "background: url('" . get_template_directory_uri() . "/images/yunik_patterns/" . get_option("yunik_headerbg_after_scroll_pattern") . "') 0 0 repeat !important;";
						break;
						case "custom_pattern":
							echo "background: url('" . get_option("yunik_headerbg_after_scroll_custom_pattern") . "') 0 0 repeat !important;";
						break;
					}	
					?>
				}
				
				header.header_after_scroll a.navbar-brand h1{
					<?php 
						echo "color: #" . get_option(DESIGNARE_SHORTNAME."_logo_after_scroll_color") . " !important;";
					?>
				}
				
				<?php
					$header_shrink = false;
					if (get_option('yunik_fixed_menu') == 'on'){
						if (get_option('yunik_header_after_scroll') == 'on'){
							if (get_option('yunik_header_shrink_effect') == 'on'){
								$header_shrink = true;
								?>
				header.header_after_scroll a.navbar-brand img.logo_after_scroll{max-height: <?php echo intval(get_option('yunik_logo_reduced_height'),10)."px"; ?>;}
								<?php
							}
						}
					}
				?>
				
				header.header_after_scroll .navbar-collapse ul.menu-depth-1 li:not(.des_mega_hide_link) a, header.header_after_scroll .dl-menuwrapper li:not(.des_mega_hide_link) a, header.header_after_scroll .gosubmenu {
					color: #<?php echo get_option('yunik_sub_menu_after_scroll_color'); ?>;
				}
				header.header_after_scroll .dl-back{color: #<?php echo get_option('yunik_sub_menu_after_scroll_color'); ?>;}
				
				header.header_after_scroll .navbar-collapse ul.menu-depth-1 li:not(.des_mega_hide_link):hover > a, header.header_after_scroll .dl-menuwrapper li:not(.des_mega_hide_link):hover > a, header.header_after_scroll .dl-menuwrapper li:not(.des_mega_hide_link):hover > a, header.header_after_scroll .dl-menuwrapper li:not(.des_mega_hide_link):hover > header.header_after_scroll .gosubmenu, header.header_after_scroll .dl-menuwrapper li.dl-back:hover{
					color: #<?php echo get_option('yunik_sub_menu_after_scroll_color_hover'); ?>;
				}
				
				header.header_after_scroll ul.menu-depth-1, header.header_after_scroll ul.menu-depth-1 ul, header.header_after_scroll .dl-menu{
					<?php
						$color = des_hex2rgb(get_option("yunik_sub_menu_after_scroll_bg_color"));
					?>
					background-color: rgba(<?php echo $color[0].",".$color[1].",".$color[2].",".intval(str_replace("%","",get_option("yunik_sub_menu_after_scroll_bg_opacity")))/100; ?>) !important;
				}
				
				header.header_after_scroll .navbar-collapse .des_mega_menu ul.menu-depth-2, header.header_after_scroll .navbar-collapse .des_mega_menu ul.menu-depth-2 ul {background-color: transparent !important;} 
				
				header.header_after_scroll li:not(.des_mega_menu) ul.menu-depth-1 li:hover, header.header_after_scroll li.des_mega_menu li.menu-item-depth-1 li:hover, header.header_after_scroll .dl-menu li:hover{
					<?php
						$color = des_hex2rgb(get_option("yunik_sub_menu_after_scroll_bg_color_hover"));
					?>
					background-color: rgba(<?php echo $color[0].",".$color[1].",".$color[2].",".intval(str_replace("%","",get_option("yunik_sub_menu_after_scroll_bg_opacity")))/100; ?>) !important;
				}
				
				header.header_after_scroll .navbar-collapse li:not(.des_mega_menu) ul.menu-depth-1 li:not(:first-child){
					border-top: 1px solid #<?php echo get_option('yunik_sub_menu_after_scroll_border_color'); ?>;
				}
				header.header_after_scroll .navbar-collapse li.des_mega_menu ul.menu-depth-2{
					border-right: 1px solid #<?php echo get_option('yunik_sub_menu_after_scroll_border_color'); ?>;
				}
				header.header_after_scroll .dl-menu li:not(:last-child), header.header_after_scroll .dl-menu ul li:not(:last-child){
					border-bottom: 1px solid #<?php echo get_option('yunik_sub_menu_after_scroll_border_color'); ?>;
				}
				
				header.header_after_scroll .navbar-collapse > ul > li > a{
					color: #<?php echo get_option('yunik_menu_after_scroll_color'); ?>;
				}
				
				header.header_after_scroll .navbar-collapse > ul > li > a:hover, header.header_after_scroll .navbar-collapse > ul > li.current-menu-ancestor > a:not(.mainhomepage), header.header_after_scroll .navbar-collapse > ul > li.current-menu-item > a:not(.mainhomepage), header.header_after_scroll .navbar-collapse > ul > li > a.selected{
					color: #<?php echo get_option('yunik_menu_after_scroll_color_hover'); ?>;
				}
				
				<?php
					if (get_option('yunik_menu_add_border') == "on"){
						?>
						header.header_after_scroll .navbar-collapse ul.menu-depth-1{border-top:3px solid #<?php echo get_option('yunik_menu_after_scroll_border_color'); ?> !important;}
						<?php
					}
				?>
				
				header.header_after_scroll li.des_mega_hide_link > a, header.header_after_scroll li.des_mega_hide_link > a:hover{
					color: #<?php echo get_option('yunik_label_menu_after_scroll_color'); ?> !important;
				}
				
				<?php
					$header_shrink = false;
					if (get_option('yunik_fixed_menu') == 'on'){
						if (get_option('yunik_header_after_scroll') == 'on'){
							if (get_option('yunik_header_shrink_effect') == 'on'){
								$header_shrink = true;
								?>
								.header_after_scroll.navbar-default .navbar-nav > li > a{
									padding-right:<?php echo intval(get_option('yunik_menu_after_scroll_side_margin'),10)."px"; ?>;
									padding-left:<?php echo intval(get_option('yunik_menu_after_scroll_side_margin'),10)."px"; ?>;
									padding-top:<?php echo intval(get_option('yunik_menu_after_scroll_margin_top'),10)."px"; ?>;
									padding-bottom:<?php echo intval(get_option('yunik_menu_after_scroll_padding_bottom'),10)."px"; ?>;
								}
								
								.header_after_scroll.style1 .header_social_icons, .header_after_scroll.style2 .header_social_icons, .header_after_scroll.style1 .search_trigger, .header_after_scroll.style2 .search_trigger, .header_after_scroll.style1 .yunik_dynamic_shopping_bag, .header_after_scroll.style2 .yunik_dynamic_shopping_bag{
									padding-top:<?php echo intval(get_option('yunik_menu_after_scroll_margin_top'),10)."px"; ?>;
									padding-bottom:<?php echo intval(get_option('yunik_menu_after_scroll_padding_bottom'),10)."px"; ?>;
								} 
								
								header.header_after_scroll .navbar-nav > li > ul{
									margin-top:<?php echo intval(get_option('yunik_menu_after_scroll_padding_bottom'),10)."px"; ?>;
								}
								
								.header_after_scroll .yunik_minicart_wrapper{
									padding-top:<?php echo intval(get_option('yunik_menu_after_scroll_padding_bottom'),10)."px"; ?>;
				
								}
								<?php
							}
						}
					}
			}
		}
		
		$header_shrink = false;
		if (get_option('yunik_fixed_menu') == 'on'){
			if (get_option('yunik_header_after_scroll') == 'on'){
				if (get_option('yunik_header_shrink_effect') == 'on'){
					$header_shrink = true;
					?>
					header.header_after_scroll a.navbar-brand{
						<?php if(get_option(DESIGNARE_SHORTNAME."_logo_after_scroll_margin_top")) echo "margin-top: " . str_replace(" ", "", get_option(DESIGNARE_SHORTNAME."_logo_after_scroll_margin_top")) . ";margin-bottom: " . str_replace(" ", "", get_option(DESIGNARE_SHORTNAME."_logo_after_scroll_margin_top")) . ";"; if (get_option(DESIGNARE_SHORTNAME."_logo_after_scroll_margin_left")) echo "margin-left: " . str_replace(" ", "", get_option(DESIGNARE_SHORTNAME."_logo_after_scroll_margin_left")) . ";"; if(get_option(DESIGNARE_SHORTNAME."_logo_reduced_height")) echo "height:" . get_option(DESIGNARE_SHORTNAME."_logo_reduced_height") . ";"; else {if(get_option(DESIGNARE_SHORTNAME."_logo_height")) echo "height:" . get_option(DESIGNARE_SHORTNAME."_logo_height") . ";";} ?>" src="<?php echo get_option(DESIGNARE_SHORTNAME."_logo_after_scroll_image_url"); ?>
					}
					header.header_after_scroll a.navbar-brand h1{
						<?php
							echo "font-size: " . str_replace(" ", "", get_option(DESIGNARE_SHORTNAME."_logo_after_scroll_size")) . " !important;";
						?>
					}
					<?php
				}
			}
		}
		
		if (get_option(DESIGNARE_SHORTNAME."_info_above_menu") == "on"){
			$color = des_hex2rgb(get_option(DESIGNARE_SHORTNAME."_topbar_bg_color"));
			?>
			header .top-bar .top-bar-bg, header .top-bar #lang_sel a.lang_sel_sel, header .top-bar #lang_sel > ul > li > ul > li > a{
				background-color: rgba(<?php echo $color[0].",".$color[1].",".$color[2].",".intval(str_replace("%","",get_option(DESIGNARE_SHORTNAME."_topbar_bg_opacity")))/100; ?>);
			}
			header .top-bar ul.phone-mail li, header .top-bar ul.phone-mail li i{
				color: #<?php echo get_option(DESIGNARE_SHORTNAME."_topbar_text_color"); ?>;
			}
			header .top-bar a, header .top-bar ul.phone-mail li a{
				color: #<?php echo get_option(DESIGNARE_SHORTNAME."_topbar_links_color"); ?> !important;
			}
			header .top-bar a:hover, header .top-bar ul.phone-mail li a:hover{
				color: #<?php echo get_option(DESIGNARE_SHORTNAME."_topbar_links_hover_color"); ?> !important;
			}
			header .top-bar .social-icons-fa li a{
				color: #<?php echo get_option(DESIGNARE_SHORTNAME."_topbar_social_color"); ?> !important;
			}
			header .top-bar .social-icons-fa li a:hover{
				color: #<?php echo get_option(DESIGNARE_SHORTNAME."_topbar_social_hover_color"); ?> !important;
			}
			header .top-bar *{
				border-color: #<?php echo get_option(DESIGNARE_SHORTNAME."_topbar_borders_color"); ?> !important;
			}
			header .top-bar .down-button{
				border-color: transparent rgba(<?php echo $color[0].",".$color[1].",".$color[2].",".intval(str_replace("%","",get_option(DESIGNARE_SHORTNAME."_topbar_bg_opacity")))/100; ?>) transparent transparent !important;
			}
			header .top-bar.opened .down-button{
				border-color: transparent #fff transparent transparent !important;
			}
			<?php
		}
	?>	
	
	#primary_footer > .container{
		padding-top:<?php echo intval(get_option('yunik_primary_footer_padding_top'),10)."px"; ?>;
		padding-bottom:<?php echo intval(get_option('yunik_primary_footer_padding_bottom'),10)."px"; ?>;
	}
	#primary_footer{
		<?php 
		switch (get_option(DESIGNARE_SHORTNAME."_footerbg_type")){
			case "image":
				echo "background-repeat:no-repeat; background-position:center center; -o-background-size: cover !important; -moz-background-size: cover !important; -webkit-background-size: cover !important; background-size: cover !important;";
				echo "background: url(" . get_option(DESIGNARE_SHORTNAME."_footerbg_image") . ") no-repeat /* fixed !important */; background-size: cover !important;";  
			break;
			case "color":
				$color = des_hex2rgb(get_option(DESIGNARE_SHORTNAME."_footerbg_color")); ?>
				background-color: rgba(<?php echo $color[0].",".$color[1].",".$color[2].",".intval(str_replace("%","",get_option(DESIGNARE_SHORTNAME."_footerbg_color_opacity")))/100; ?>);
				<?php
			break;
			case "pattern":
				echo "background: url('" . get_template_directory_uri() . "/images/yunik_patterns/" . get_option(DESIGNARE_SHORTNAME."_footerbg_pattern") . "') 0 0 repeat !important;";
			break;
			case "custom_pattern":
				echo "background: url('" . get_option(DESIGNARE_SHORTNAME."_footerbg_custom_pattern") . "') 0 0 repeat !important;";
			break;
		}
		?>	
	}
	#primary_footer input, #primary_footer textarea{
		<?php 
		switch (get_option(DESIGNARE_SHORTNAME."_footerbg_type")){
			case "image": case "pattern": case "custom_pattern":
				echo "background: transparent;";  
			break;
			case "color":
				$color = des_hex2rgb(get_option(DESIGNARE_SHORTNAME."_footerbg_color")); ?>
				background-color: rgba(<?php echo $color[0].",".$color[1].",".$color[2].",".intval(str_replace("%","",get_option(DESIGNARE_SHORTNAME."_footerbg_color_opacity")))/100; ?>);
				<?php
			break;
		}
		?>	
	}
	#primary_footer input, #primary_footer textarea{
		border: 1px solid #<?php echo get_option(DESIGNARE_SHORTNAME."_footerbg_borderscolor") ?>;
	}
	#primary_footer hr, .footer_sidebar ul li a{
		border-top: 1px solid #<?php echo get_option(DESIGNARE_SHORTNAME."_footerbg_borderscolor") ?>;
	}
	.footer_sidebar ul li:last-child{
		border-bottom: 1px solid #<?php echo get_option(DESIGNARE_SHORTNAME."_footerbg_borderscolor") ?>;
	}
	#primary_footer a{
		color: #<?php echo get_option(DESIGNARE_SHORTNAME."_footerbg_linkscolor"); ?>;
	}
	
	#primary_footer, #primary_footer p, #big_footer input, #big_footer textarea{
		color: #<?php echo get_option(DESIGNARE_SHORTNAME."_footerbg_paragraphscolor"); ?>;
	}
	
	#primary_footer .footer_sidebar > h4, #primary_footer .footer_sidebar > .widget > h4 {
		color: #<?php echo get_option(DESIGNARE_SHORTNAME."_footerbg_headingscolor"); ?>;
	}
	
	#secondary_footer{
		<?php 
		switch (get_option(DESIGNARE_SHORTNAME."_sec_footerbg_type")){
			case "image":
				echo "background-repeat:no-repeat; background-position:center center; -o-background-size: cover !important; -moz-background-size: cover !important; -webkit-background-size: cover !important; background-size: cover !important;";
				echo "background: url(" . get_option(DESIGNARE_SHORTNAME."_sec_footerbg_image") . ") no-repeat fixed !important; background-size: cover !important;";  
			break;
			case "color":
				$color = des_hex2rgb(get_option(DESIGNARE_SHORTNAME."_sec_footerbg_color")); ?>
				background-color: rgba(<?php echo $color[0].",".$color[1].",".$color[2].",".intval(str_replace("%","",get_option(DESIGNARE_SHORTNAME."_sec_footerbg_color_opacity")))/100; ?>);
				<?php
			break;
			case "pattern":
				echo "background: url('" . get_template_directory_uri() . "/images/yunik_patterns/" . get_option(DESIGNARE_SHORTNAME."_sec_footerbg_pattern") . "') 0 0 repeat !important;";
			break;
			case "custom_pattern":
				echo "background: url('" . get_option(DESIGNARE_SHORTNAME."_sec_footerbg_custom_pattern") . "') 0 0 repeat !important;";
			break;
		}
		?>
		padding-top:<?php echo intval(get_option('yunik_secondary_footer_padding_top'),10)."px"; ?>;
		padding-bottom:<?php echo intval(get_option('yunik_secondary_footer_padding_bottom'),10)."px"; ?>;
	}
	
	<?php
	if (get_option(DESIGNARE_SHORTNAME."_show_sec_footer") == "on"){
		if (get_option(DESIGNARE_SHORTNAME."_footer_display_logo") == "on"){
			if (get_option('yunik_footer_logo_type') == "text"){
				?>
				
				#secondary_footer .footer_logo .logo{
					<?php $font = get_option('yunik_sec_footer_logo_font'); $des_import_fonts[] = $font; $font = explode("|",$font); if ($font[0] == "Helvetica" || $font[0] == "Helvetica Neue") $font[0] = $font[0]."', 'Arial', 'sans-serif"; if (!isset($font[1])) $font[1] = ""; ?>
					font-family: '<?php echo $font[0]; ?>';
					font-weight: <?php echo $font[1] ?>;
					font-size: <?php echo intval(get_option('yunik_sec_footer_logo_font_size'),10); ?>px;
					color: #<?php echo get_option('yunik_sec_footer_logo_font_color'); ?>;
				}
				#secondary_footer .footer_logo .logo:hover{
					color: #<?php echo get_option('yunik_sec_footer_logo_font_hover_color'); ?>;
				}
				
				#secondary_footer .social-icons-fa a{
					font-size: <?php echo intval(get_option('yunik_sec_footer_social_icons_size'),10); ?>px;
					line-height: <?php echo intval(get_option('yunik_sec_footer_social_icons_size'),10); ?>px;
					color: #<?php echo get_option('yunik_sec_footer_social_icons_color'); ?>;
				}
				#secondary_footer .social-icons-fa a:hover{
					color: #<?php echo get_option('yunik_sec_footer_social_icons_hover_color'); ?>;
				}
				
				<?php
			}
		}
	}
	
	//search
	?>
	header .search_input{
		<?php
			$color = des_hex2rgb(get_option(DESIGNARE_SHORTNAME."_search_input_background_color"));
		?>
		background-color: rgba(<?php echo $color[0].",".$color[1].",".$color[2].",".intval(str_replace("%","",get_option(DESIGNARE_SHORTNAME."_search_input_background_opacity")))/100; ?>);
	}
	header .search_input input.search_input_value{
		<?php $font = get_option(DESIGNARE_SHORTNAME."_search_input_font"); $des_import_fonts[] = $font; $font = explode("|",$font); if ($font[0] == "Helvetica" || $font[0] == "Helvetica Neue") $font[0] = $font[0]."', 'Arial', 'sans-serif"; if (!isset($font[1])) $font[1] = ""; ?>
		font-family: '<?php echo $font[0]; ?>';
		font-weight: <?php echo $font[1] ?>;
	}
	header .search_input input.search_input_value, header .search_close{
		font-size: <?php echo intval(get_option(DESIGNARE_SHORTNAME."_search_input_font_size"),10)."px"; ?>;
		color: #<?php echo get_option(DESIGNARE_SHORTNAME."_search_input_font_color"); ?>
	}
	header .search_input .ajax_search_results ul{
		<?php
			$color = des_hex2rgb(get_option(DESIGNARE_SHORTNAME."_search_result_background_color"));
		?>
		background-color: rgba(<?php echo $color[0].",".$color[1].",".$color[2].",".intval(str_replace("%","",get_option(DESIGNARE_SHORTNAME."_search_result_background_opacity")))/100; ?>);
	}
	header .search_input .ajax_search_results ul li.selected{
		<?php
			$color = des_hex2rgb(get_option(DESIGNARE_SHORTNAME."_search_selected_result_background_color"));
		?>
		background-color: rgba(<?php echo $color[0].",".$color[1].",".$color[2].",".intval(str_replace("%","",get_option(DESIGNARE_SHORTNAME."_search_result_background_opacity")))/100; ?>);
	}
	header .search_input .ajax_search_results ul li{
		border-bottom: 1px solid #<?php echo get_option(DESIGNARE_SHORTNAME."_search_result_borders"); ?>;
	}
	header .search_input .ajax_search_results ul li a{
		<?php $font = get_option(DESIGNARE_SHORTNAME."_search_input_font"); $des_import_fonts[] = $font; $font = explode("|",$font); if ($font[0] == "Helvetica" || $font[0] == "Helvetica Neue") $font[0] = $font[0]."', 'Arial', 'sans-serif"; if (!isset($font[1])) $font[1] = ""; ?>
		font-family: '<?php echo $font[0]; ?>';
		font-weight: <?php echo $font[1] ?>;
		font-size: <?php echo intval(get_option(DESIGNARE_SHORTNAME."_search_result_font_size"),10)."px"; ?>;
		color: #<?php echo get_option(DESIGNARE_SHORTNAME."_search_result_font_color"); ?>
	}
	header .search_input .ajax_search_results ul li.selected a{
		color: #<?php echo get_option(DESIGNARE_SHORTNAME."_search_selected_result_font_color"); ?>
	}
	header .search_input .ajax_search_results ul li a span, header .search_input .ajax_search_results ul li a span i{
		<?php $font = get_option(DESIGNARE_SHORTNAME."_search_result_details_font"); $des_import_fonts[] = $font; $font = explode("|",$font); if ($font[0] == "Helvetica" || $font[0] == "Helvetica Neue") $font[0] = $font[0]."', 'Arial', 'sans-serif"; if (!isset($font[1])) $font[1] = ""; ?>
		font-family: '<?php echo $font[0]; ?>';
		font-weight: <?php echo $font[1] ?>;
		font-size: <?php echo intval(get_option(DESIGNARE_SHORTNAME."_search_result_details_font_size"),10)."px"; ?>;
		color: #<?php echo get_option(DESIGNARE_SHORTNAME."_search_result_details_font_color"); ?>
	}
	header .search_input .ajax_search_results ul li.selected a span{
		color: #<?php echo get_option(DESIGNARE_SHORTNAME."_search_selected_result_details_font_color"); ?>
	}
	
	<?php
	if (is_user_logged_in() && get_option(DESIGNARE_SHORTNAME.'_fixed_menu') == "on"){
		global $wpdb;
		$q = "SELECT meta_value from ".$wpdb->base_prefix."usermeta WHERE user_id=".get_current_user_id()." AND meta_key='show_admin_bar_front'";
		$res = $wpdb->get_results($q, OBJECT);
		if ($res && $res[0]->meta_value == "true"){
			?>
			body:not(.vc_editor) header { top:32px !important; }
			@media screen and (max-width:782px) {
				body:not(.vc_editor) header, body:not(.vc_editor) header .down-button {
					top:45px !important;
				}
				body:not(.vc_editor) header .top-bar-bg{
					margin-top: 44px !important;
				}
				#wpadminbar{position: fixed;}
			}
			<?php			
		}
	}
	
	if (get_option(DESIGNARE_SHORTNAME."_enable_website_loader") == "on"){
		?>
		body #des_website_load, #des_website_load .load2 .loader:before, #des_website_load .load2 .loader:after, #des_website_load .load3 .loader:after{background: #<?php echo get_option(DESIGNARE_SHORTNAME."_loader_background"); ?>;}
		
		.ball-pulse>div, .ball-pulse-sync>div, .ball-scale>div, .ball-rotate>div, .ball-rotate>div:before, .ball-clip-rotate>div, .ball-clip-rotate-pulse>div:first-child, .ball-beat>div, .ball-scale-multiple>div, .ball-triangle-path>div, .ball-pulse-rise>div, .ball-grid-beat>div, .ball-grid-pulse>div, .ball-spin-fade-loader>div, .ball-zig-zag>div, .ball-zig-zag-deflect>div, .line-scale>div, .line-scale-party>div, .line-scale-pulse-out>div, .line-scale-pulse-out-rapid>div, .line-spin-fade-loader>div, .square-spin>div, .pacman>div:nth-child(3),.pacman>div:nth-child(4),.pacman>div:nth-child(5),.pacman>div:nth-child(6), .cube-transition>div, .ball-rotate>div:after, .ball-rotate>div:before, #des_website_load .load3 .loader:before, #des_website_load .load3 .loader:before{background-color: #<?php echo get_option(DESIGNARE_SHORTNAME."_loader_color"); ?>;}

		.ball-clip-rotate>div{border-top-color: #<?php echo get_option(DESIGNARE_SHORTNAME."_loader_color"); ?>;border-left-color: #<?php echo get_option(DESIGNARE_SHORTNAME."_loader_color"); ?>;border-right-color: #<?php echo get_option(DESIGNARE_SHORTNAME."_loader_color"); ?>;}

		.ball-clip-rotate-pulse>div:last-child, .ball-clip-rotate-multiple>div:last-child{border-top-color: #<?php echo get_option(DESIGNARE_SHORTNAME."_loader_color"); ?>;border-bottom-color: #<?php echo get_option(DESIGNARE_SHORTNAME."_loader_color"); ?>;}
		
		.ball-clip-rotate-multiple>div{border-right-color: #<?php echo get_option(DESIGNARE_SHORTNAME."_loader_color"); ?>;border-left-color:#<?php echo get_option(DESIGNARE_SHORTNAME."_loader_color"); ?>;}

		.ball-triangle-path>div, .ball-scale-ripple>div, .ball-scale-ripple-multiple>div{border-color:#<?php echo get_option(DESIGNARE_SHORTNAME."_loader_color"); ?>;}
		
		.pacman>div:first-of-type, .pacman>div:nth-child(2){border-top-color: #<?php echo get_option(DESIGNARE_SHORTNAME."_loader_color"); ?>;border-left-color: #<?php echo get_option(DESIGNARE_SHORTNAME."_loader_color"); ?>;border-bottom-color: #<?php echo get_option(DESIGNARE_SHORTNAME."_loader_color"); ?>;}
		
		.load2 .loader{box-shadow:inset 0 0 0 1em #<?php echo get_option(DESIGNARE_SHORTNAME."_loader_color"); ?>;}
		<?php
			$color = des_hex2rgb(get_option(DESIGNARE_SHORTNAME."_loader_color"));
		?>

		.load3 .loader{background:#<?php echo get_option(DESIGNARE_SHORTNAME."_loader_color"); ?>;background:-moz-linear-gradient(left, #<?php echo get_option(DESIGNARE_SHORTNAME."_loader_color"); ?> 10%, rgba(<?php echo $color[0].",".$color[1].",".$color[2]; ?>, 0) 42%);background:-webkit-linear-gradient(left, #<?php echo get_option(DESIGNARE_SHORTNAME."_loader_color"); ?> 10%, rgba(<?php echo $color[0].",".$color[1].",".$color[2]; ?>, 0) 42%);background:-o-linear-gradient(left, #<?php echo get_option(DESIGNARE_SHORTNAME."_loader_color"); ?> 10%, rgba(<?php echo $color[0].",".$color[1].",".$color[2]; ?>, 0) 42%);background:-ms-linear-gradient(left, #<?php echo get_option(DESIGNARE_SHORTNAME."_loader_color"); ?> 10%, rgba(<?php echo $color[0].",".$color[1].",".$color[2]; ?>, 0) 42%);background:linear-gradient(to right, #<?php echo get_option(DESIGNARE_SHORTNAME."_loader_color"); ?> 10%, rgba(<?php echo $color[0].",".$color[1].",".$color[2]; ?>, 0) 42%);}
		
		.load6 .loader{font-size:50px;text-indent:-9999em;overflow:hidden;width:1em;height:1em;border-radius:50%;position:relative;-webkit-transform:translateZ(0);-ms-transform:translateZ(0);transform:translateZ(0);-webkit-animation:load6 1.7s infinite ease;animation:load6 1.7s infinite ease}@-webkit-keyframes "load6"{0%{-webkit-transform:rotate(0deg);transform:rotate(0deg);box-shadow:0 -0.83em 0 -0.4em #<?php echo get_option(DESIGNARE_SHORTNAME."_loader_color"); ?>, 0 -0.83em 0 -0.42em #<?php echo get_option(DESIGNARE_SHORTNAME."_loader_color"); ?>, 0 -0.83em 0 -0.44em #<?php echo get_option(DESIGNARE_SHORTNAME."_loader_color"); ?>, 0 -0.83em 0 -0.46em #<?php echo get_option(DESIGNARE_SHORTNAME."_loader_color"); ?>, 0 -0.83em 0 -0.477em #<?php echo get_option(DESIGNARE_SHORTNAME."_loader_color"); ?>;}5%,95%{box-shadow:0 -0.83em 0 -0.4em #<?php echo get_option(DESIGNARE_SHORTNAME."_loader_color"); ?>, 0 -0.83em 0 -0.42em #<?php echo get_option(DESIGNARE_SHORTNAME."_loader_color"); ?>, 0 -0.83em 0 -0.44em #<?php echo get_option(DESIGNARE_SHORTNAME."_loader_color"); ?>, 0 -0.83em 0 -0.46em #<?php echo get_option(DESIGNARE_SHORTNAME."_loader_color"); ?>, 0 -0.83em 0 -0.477em #<?php echo get_option(DESIGNARE_SHORTNAME."_loader_color"); ?>;}10%,59%{box-shadow:0 -0.83em 0 -0.4em #<?php echo get_option(DESIGNARE_SHORTNAME."_loader_color"); ?>, -0.087em -0.825em 0 -0.42em #<?php echo get_option(DESIGNARE_SHORTNAME."_loader_color"); ?>, -0.173em -0.812em 0 -0.44em #<?php echo get_option(DESIGNARE_SHORTNAME."_loader_color"); ?>, -0.256em -0.789em 0 -0.46em #<?php echo get_option(DESIGNARE_SHORTNAME."_loader_color"); ?>, -0.297em -0.775em 0 -0.477em #<?php echo get_option(DESIGNARE_SHORTNAME."_loader_color"); ?>;}20%{box-shadow:0 -0.83em 0 -0.4em #<?php echo get_option(DESIGNARE_SHORTNAME."_loader_color"); ?>, -0.338em -0.758em 0 -0.42em #<?php echo get_option(DESIGNARE_SHORTNAME."_loader_color"); ?>, -0.555em -0.617em 0 -0.44em #<?php echo get_option(DESIGNARE_SHORTNAME."_loader_color"); ?>, -0.671em -0.488em 0 -0.46em #<?php echo get_option(DESIGNARE_SHORTNAME."_loader_color"); ?>, -0.749em -0.34em 0 -0.477em #<?php echo get_option(DESIGNARE_SHORTNAME."_loader_color"); ?>;}38%{box-shadow:0 -0.83em 0 -0.4em #<?php echo get_option(DESIGNARE_SHORTNAME."_loader_color"); ?>, -0.377em -0.74em 0 -0.42em #<?php echo get_option(DESIGNARE_SHORTNAME."_loader_color"); ?>, -0.645em -0.522em 0 -0.44em #<?php echo get_option(DESIGNARE_SHORTNAME."_loader_color"); ?>, -0.775em -0.297em 0 -0.46em #<?php echo get_option(DESIGNARE_SHORTNAME."_loader_color"); ?>, -0.82em -0.09em 0 -0.477em #<?php echo get_option(DESIGNARE_SHORTNAME."_loader_color"); ?>;}100%{-webkit-transform:rotate(360deg);transform:rotate(360deg);box-shadow:0 -0.83em 0 -0.4em #<?php echo get_option(DESIGNARE_SHORTNAME."_loader_color"); ?>, 0 -0.83em 0 -0.42em #<?php echo get_option(DESIGNARE_SHORTNAME."_loader_color"); ?>, 0 -0.83em 0 -0.44em #<?php echo get_option(DESIGNARE_SHORTNAME."_loader_color"); ?>, 0 -0.83em 0 -0.46em #<?php echo get_option(DESIGNARE_SHORTNAME."_loader_color"); ?>, 0 -0.83em 0 -0.477em #<?php echo get_option(DESIGNARE_SHORTNAME."_loader_color"); ?>;}}@keyframes "load6"{0%{-webkit-transform:rotate(0deg);transform:rotate(0deg);box-shadow:0 -0.83em 0 -0.4em #<?php echo get_option(DESIGNARE_SHORTNAME."_loader_color"); ?>, 0 -0.83em 0 -0.42em #<?php echo get_option(DESIGNARE_SHORTNAME."_loader_color"); ?>, 0 -0.83em 0 -0.44em #<?php echo get_option(DESIGNARE_SHORTNAME."_loader_color"); ?>, 0 -0.83em 0 -0.46em #<?php echo get_option(DESIGNARE_SHORTNAME."_loader_color"); ?>, 0 -0.83em 0 -0.477em #<?php echo get_option(DESIGNARE_SHORTNAME."_loader_color"); ?>;}5%,95%{box-shadow:0 -0.83em 0 -0.4em #<?php echo get_option(DESIGNARE_SHORTNAME."_loader_color"); ?>, 0 -0.83em 0 -0.42em #<?php echo get_option(DESIGNARE_SHORTNAME."_loader_color"); ?>, 0 -0.83em 0 -0.44em #<?php echo get_option(DESIGNARE_SHORTNAME."_loader_color"); ?>, 0 -0.83em 0 -0.46em #<?php echo get_option(DESIGNARE_SHORTNAME."_loader_color"); ?>, 0 -0.83em 0 -0.477em #<?php echo get_option(DESIGNARE_SHORTNAME."_loader_color"); ?>;}10%,59%{box-shadow:0 -0.83em 0 -0.4em #<?php echo get_option(DESIGNARE_SHORTNAME."_loader_color"); ?>, -0.087em -0.825em 0 -0.42em #<?php echo get_option(DESIGNARE_SHORTNAME."_loader_color"); ?>, -0.173em -0.812em 0 -0.44em #<?php echo get_option(DESIGNARE_SHORTNAME."_loader_color"); ?>, -0.256em -0.789em 0 -0.46em #<?php echo get_option(DESIGNARE_SHORTNAME."_loader_color"); ?>, -0.297em -0.775em 0 -0.477em #<?php echo get_option(DESIGNARE_SHORTNAME."_loader_color"); ?>;}20%{box-shadow:0 -0.83em 0 -0.4em #<?php echo get_option(DESIGNARE_SHORTNAME."_loader_color"); ?>, -0.338em -0.758em 0 -0.42em #<?php echo get_option(DESIGNARE_SHORTNAME."_loader_color"); ?>, -0.555em -0.617em 0 -0.44em #<?php echo get_option(DESIGNARE_SHORTNAME."_loader_color"); ?>, -0.671em -0.488em 0 -0.46em #<?php echo get_option(DESIGNARE_SHORTNAME."_loader_color"); ?>, -0.749em -0.34em 0 -0.477em #<?php echo get_option(DESIGNARE_SHORTNAME."_loader_color"); ?>;}38%{box-shadow:0 -0.83em 0 -0.4em #<?php echo get_option(DESIGNARE_SHORTNAME."_loader_color"); ?>, -0.377em -0.74em 0 -0.42em #<?php echo get_option(DESIGNARE_SHORTNAME."_loader_color"); ?>, -0.645em -0.522em 0 -0.44em #<?php echo get_option(DESIGNARE_SHORTNAME."_loader_color"); ?>, -0.775em -0.297em 0 -0.46em #<?php echo get_option(DESIGNARE_SHORTNAME."_loader_color"); ?>, -0.82em -0.09em 0 -0.477em #<?php echo get_option(DESIGNARE_SHORTNAME."_loader_color"); ?>;}100%{-webkit-transform:rotate(360deg);transform:rotate(360deg);box-shadow:0 -0.83em 0 -0.4em #<?php echo get_option(DESIGNARE_SHORTNAME."_loader_color"); ?>, 0 -0.83em 0 -0.42em #<?php echo get_option(DESIGNARE_SHORTNAME."_loader_color"); ?>, 0 -0.83em 0 -0.44em #<?php echo get_option(DESIGNARE_SHORTNAME."_loader_color"); ?>, 0 -0.83em 0 -0.46em #<?php echo get_option(DESIGNARE_SHORTNAME."_loader_color"); ?>, 0 -0.83em 0 -0.477em #<?php echo get_option(DESIGNARE_SHORTNAME."_loader_color"); ?>;}}
		
		<?php
		if (get_option(DESIGNARE_SHORTNAME."_enable_website_loader_percentage") == "on"){
			?>
			body #des_website_load .percentage{
				<?php $font = get_option(DESIGNARE_SHORTNAME."_loader_percentage_font"); $des_import_fonts[] = $font; $font = explode("|",$font); if ($font[0] == "Helvetica" || $font[0] == "Helvetica Neue") $font[0] = $font[0]."', 'Arial', 'sans-serif"; if (!isset($font[1])) $font[1] = ""; ?>
				font-family: '<?php echo $font[0]; ?>';
				font-weight: <?php echo $font[1] ?>;
				font-size: <?php echo intval(get_option(DESIGNARE_SHORTNAME."_loader_percentage_font_size"),10)."px"; ?>;
				color: #<?php echo get_option(DESIGNARE_SHORTNAME."_loader_percentage_font_color"); ?>;
			}
			<?php
		}
		
	}
	?>
	.des_breadcrumbs, .des_breadcrumbs a, .des_breadcrumbs span{
		<?php $font = get_option(DESIGNARE_SHORTNAME."_breadcrumbs_font"); $des_import_fonts[] = $font; $font = explode("|",$font); if ($font[0] == "Helvetica" || $font[0] == "Helvetica Neue") $font[0] = $font[0]."', 'Arial', 'sans-serif"; if (!isset($font[1])) $font[1] = ""; ?>
		font-family: '<?php echo $font[0]; ?>';
		font-weight: <?php echo $font[1] ?>;
		color: #<?php echo get_option(DESIGNARE_SHORTNAME."_breadcrumbs_color"); ?>;
		font-size: <?php echo intval(get_option(DESIGNARE_SHORTNAME."_breadcrumbs_size"),10)."px"; ?>;
	}
	<?php
		
	/* new top bar menu options */
	?>
	#menu_top_bar > li ul{background: #<?php echo get_option(DESIGNARE_SHORTNAME."_topbar_submenu_bg_color"); ?>;}
	#menu_top_bar > li ul li:hover{background: #<?php echo get_option(DESIGNARE_SHORTNAME."_topbar_submenu_bg_hover_color"); ?>;}
	#menu_top_bar > li ul a{color: #<?php echo get_option(DESIGNARE_SHORTNAME."_topbar_submenu_text_color"); ?> !important;}
	#menu_top_bar > li ul a:hover, #menu_top_bar > li ul li:hover > a{color: #<?php echo get_option(DESIGNARE_SHORTNAME."_topbar_submenu_text_hover_color"); ?> !important;}
	<?php
		
	/* new header icons options */
	?>
	header.navbar .nav-container i{color: #<?php echo get_option(DESIGNARE_SHORTNAME."_header_icons_color"); ?>;}
	header.navbar .nav-container i:hover{color: #<?php echo get_option(DESIGNARE_SHORTNAME."_header_icons_hover_color"); ?>;}
	header.header_after_scroll.navbar .nav-container i{color: #<?php echo get_option(DESIGNARE_SHORTNAME."_header_after_scroll_icons_color"); ?>;}
	header.header_after_scroll.navbar .nav-container i:hover{color: #<?php echo get_option(DESIGNARE_SHORTNAME."_header_after_scroll_icons_hover_color"); ?>;}
	<?php

	/* panel's custom css */	
	if (get_option("enable_custom_css") == "on"){
		$yunik_customcss = get_option(DESIGNARE_SHORTNAME."_custom_css");
		if (gettype($yunik_customcss) === "string" && $yunik_customcss != "") {
			echo strip_tags($yunik_customcss);
		}
	}
	?>
	/* ENDOF new header options and behaviors */
	</style>
	<?php
}

function designare_yunik_custom_head(){
	if(preg_match('/(?i)msie [2-9]/',$_SERVER['HTTP_USER_AGENT'])){
		wp_enqueue_script( 'html5trunk', 'http://html5shiv.googlecode.com/svn/trunk/html5.js', array('jquery'), '1');
	}
}

function designare_yunik_style() {
	if(preg_match('/(?i)msie [2-9]/',$_SERVER['HTTP_USER_AGENT'])){
  	    wp_enqueue_style('js_composer_front');
	}
	wp_enqueue_style( 'designare-yunik-style', get_bloginfo( 'stylesheet_url' ), array(), '1' );
}

function designare_scripts(){

	if (!is_admin()){
		global $vc_addons_url;
	    wp_enqueue_script( 'jquery' );
   	    wp_enqueue_script( 'des_utils', DESIGNARE_JS_PATH .'utils.js', array(),'1.0',$in_footer = true);
  	    wp_enqueue_script( 'yunik', DESIGNARE_JS_PATH .'yunik.js', array(), '1',$in_footer = true);
  	    wp_enqueue_script( 'jquery.twitter', DESIGNARE_JS_PATH .'twitter/jquery.tweet.js', array(),'1.0',$in_footer = true);
  	    
  		wp_enqueue_script('cubeportfolio-jquery-js',$in_footer = false);
		wp_enqueue_style('cubeportfolio-jquery-css',$in_footer = false);
  	   
   	    global $post;
   	    
   	    if (is_archive() || is_search() || is_home() || is_front_page()){
	   	    wp_enqueue_script('blog', get_template_directory_uri().'/js/blog.js', array(), '1');
	   	    wp_enqueue_style('blog', DESIGNARE_CSS_PATH.'blog.css');
	   	    wp_enqueue_style('load-posts', DESIGNARE_CSS_PATH.'load-posts.css');
   	    } else {
	   	    if (is_404()){
		   	    wp_enqueue_style('blog', DESIGNARE_CSS_PATH.'blog.css');
	   	    }
	   	    if (isset($post->ID)) $template = get_post_meta( $post->ID, '_wp_page_template' ,true );
	   	    if (isset($template)){
			    switch($template){
				    case 'blog-template.php': case 'blog-masonry-template.php': case 'blog-template-leftsidebar.php': case 'index.php': case 'post-archive.php': case 'post-single.php': case 'search.php':
						wp_enqueue_script('blog', get_template_directory_uri().'/js/blog.js', array(), '1',$in_footer = true);
						wp_enqueue_style('blog', DESIGNARE_CSS_PATH.'blog.css');
				   	    if (get_option('yunik_blog_reading_type') === "scroll" || get_option('yunik_blog_reading_type') == "scrollauto"){
					   	 	wp_enqueue_style('load-posts', DESIGNARE_CSS_PATH.'load-posts.css');   
				   	    }
					    break;
					default:
						if (is_single())
							wp_enqueue_script('blog', get_template_directory_uri().'/js/blog.js', array(), '1',$in_footer = true);
							wp_enqueue_style('blog', DESIGNARE_CSS_PATH.'blog.css');
						break;
			    }
	   	    }
   	    }
	    if (strpos($_SERVER["HTTP_USER_AGENT"], 'MSIE')){
		    wp_enqueue_script('IE', DESIGNARE_JS_PATH.'IE.js', array(), '1',$in_footer = true);
	    }
	}
}

function designare_the_breadcrumb(){
    $delimiter = '<span class="delimiter"></span>'; 
    $delimiter1 = '<span class="delimiter1"></span>';
    $main = __(get_option('yunik_breadcrumbs_home_text'), 'yunik');
    $maxLength= 30;
    $arc_year = get_the_time('Y');
    $arc_month = get_the_time('F');
    $arc_day = get_the_time('d');
    $arc_day_full = get_the_time('l');
    $url_year = get_year_link($arc_year);
    $url_month = get_month_link($arc_year,$arc_month);
 
    if (!is_front_page()) {         
        global $post, $cat;         
        $homeLink = home_url();
        echo '<a href="' . $homeLink . '">' . $main . '</a>' . $delimiter;    
        if (is_single()) { 
    		$terms2 = get_the_terms($post->ID, 'portfolio_type');
			$first = true;
			if(!empty($cat_type)) echo $cat_type . " &raquo; ";
            if (is_single()) {
                the_title();
            }
        } 
        elseif (is_category()) { 
            echo get_category_parents($cat, true,' ' . $delimiter . ' ') . '"' ;
        }       
        elseif ( is_tag() ) { 
            echo single_tag_title("", false) ;
        }        
        elseif ( is_day()) { 
            echo '<a href="' . $url_year . '">' . $arc_year . '</a> ' . $delimiter . ' ';
            echo '<a href="' . $url_month . '">' . $arc_month . '</a> ' . $delimiter . $arc_day . ' (' . $arc_day_full . ')';
        } 
        elseif ( is_month() ) {  
            echo '<a href="' . $url_year . '">' . $arc_year . '</a> ' . $delimiter . $arc_month;
        } 
        elseif ( is_year() ) {  
            echo $arc_year;
        }       
        elseif ( is_search() ) {  
            echo __('Search Results for "', 'yunik') . get_search_query() . '"';
        }       
        elseif ( is_page() && !$post->post_parent ) { 
            echo get_the_title(); 
        }           
        elseif ( is_page() && $post->post_parent ) { 
            $post_array = get_post_ancestors($post);
             
            krsort($post_array); 
            foreach($post_array as $key=>$postid){
                $post_ids = get_post($postid);
                $title = $post_ids->post_title; 
                echo $title . $delimiter;
            }
            the_title(); 
        }           
        elseif ( is_author() ) {
            global $author;
            $user_info = get_userdata($author);
            echo  __('Author&#39;s Article(s) &raquo; ', 'yunik') . $user_info->display_name ;
        }       
        elseif ( is_404() ) {
            //echo  'Error 404 - Not Found.';
        }       
        else {
           	global $wpdb;
           	$bc = get_body_class();
           	if (isset($bc[3]) && is_integer($bc[3])){
	           	$aidee = substr($bc[3], 5);
	            $q = "SELECT name FROM ".$wpdb->prefix."terms WHERE term_id=".$aidee;
	            $res = $wpdb->get_results($q, OBJECT);
	            if (isset($res[0]))
	            echo $res[0]->name;
           	} else {
	           	if (isset($bc[0])) echo $bc[0];
           	}
        }
    } else {
	    $homeLink = home_url();
        echo '<a href="' . $homeLink . '">' . $main . '</a>';
    }
}

function des_yunik_print_intro($id, $video = false){
	?>
	<div class="home-text-wrapper<?php echo $video ? "-video" : ""; ?>">
		
		<?php if ($video) { ?><div class="home-text-wrapper-video-contents"><?php } ?>
						
		<?php
			$type = get_post_meta($id, 'introLogo_value', true);
			if ($type !== "none"){
				?>
				<div class="home-logo-<?php echo $type; ?> home-logo">
					<?php
						switch($type){
							case "text":
								$font = get_post_meta($id,'introLogoFont_value',true); $des_import_fonts[] = $font; $font = explode("|",$font); if ($font[0] == "Helvetica" || $font[0] == "Helvetica Neue") $font[0] = $font[0]."', 'Arial', 'sans-serif"; if (!isset($font[1])) $font[1] = "";
								$fontsize = get_post_meta($id,'introLogoFontSize_value',true);
								$variation = get_post_meta($id,'introLogoTextStyle_value',true);
								$border = get_post_meta($id,'introLogoBorder_value',true);
								$link = get_post_meta($id,'introLogoLink_value',true);
								?>
								<a href="<?php if ($link === "") $link = "#"; echo $link; ?>" class="nav-to <?php echo $variation; ?>" style="font-family:'<?php echo $font[0]; ?>';font-weight:<?php echo $font[1]; ?>;font-size:<?php echo (int) preg_replace('/\D/', '', $fontsize)."px"; ?>;<?php if ($border === "yes") echo 'padding: 5px 25px 5px;border: 3px solid;letter-spacing: 3px;'; ?>"><?php echo get_post_meta($id,'introLogoText_value',true); ?>
								<?php
							break;
							
							case "image":
								$imageurl = get_post_meta($id,'introLogoImageURL_value',true);
								$imageurl = explode("|!|", $imageurl);
								$height = get_post_meta($id,'introLogoImageHeight_value',true);
								$link = get_post_meta($id,'introLogoLink_value',true);
								?>
								<a href="<?php if ($link === "") $link = "#"; echo $link; ?>" class="nav-to">
									<img src="<?php echo $imageurl[1]; ?>" alt="" style="height:<?php echo (int) preg_replace('/\D/', '', $height)."px"; ?>;"/>
								</a>
								<?php
							break;
						}
					?>
					</a>
				</div>  		
				<?php
			}
			
			if (get_post_meta($id, 'introCaptionsEnable_value', true) === "yes" && get_post_meta($id,'introCaptionsList_value', true) !== ""){
				?>
				<div id="home-slider" class="flexslider">			
					<ul class="slides styled-list">
						<?php
							$slides = get_post_meta($id,'introCaptionsList_value', true);
							$slides = explode("|!|", $slides);
							foreach($slides as $s){
								if ($s != ""){
									$font = get_post_meta($id,'introCaptionsFont_value',true); $des_import_fonts[] = $font; $font = explode("|",$font); if ($font[0] == "Helvetica" || $font[0] == "Helvetica Neue") $font[0] = $font[0]."', 'Arial', 'sans-serif"; if (!isset($font[1])) $font[1] = "";
									?>
									<li class="home-slide">
										<p class="home-slide-content" style="font-family:'<?php echo $font[0]; ?>';font-weight:<?php echo $font[1]; ?>;color:#<?php echo get_post_meta($id,'introCaptionsTextStyle_value',true); ?>;">
											<?php echo "$s"; ?>
										</p>
									</li>
									<?php
								}
							}
						?>
					</ul>
				</div>
				<?php
			}
						
			if (get_post_meta($id, 'introContinueEnable_value', true) === "yes"){
				$link = get_post_meta($id,'introLogoLink_value',true);
				?>
				<div class="intro_continue intro_continue_<?php echo get_post_meta($id, 'introContinueType_value', true); ?>">
					<a href="<?php if ($link === "") $link = "#"; echo $link; ?>" class="nav-to">
					<?php
						if (get_post_meta($id, 'introContinueType_value', true) === "text"){
							$font = get_post_meta($id,'introContinueFont_value',true); $des_import_fonts[] = $font; $font = explode("|",$font); if ($font[0] == "Helvetica" || $font[0] == "Helvetica Neue") $font[0] = $font[0]."', 'Arial', 'sans-serif"; if (!isset($font[1])) $font[1] = "";
							$fontsize = (int) preg_replace('/\D/', '', get_post_meta($id, 'introContinueSize_value', true));
							$fontcolor = get_post_meta($id, 'introContinueColor_value', true);
							$fontbgcolor = get_post_meta($id, 'introContinueBgColor_value', true);
							echo "<p style='font-family:{$font[0]}';font-weight:{$font[1]};font-size:".$fontsize."px;color:#$fontcolor;background:#$fontbgcolor;'>".get_post_meta($id, 'introContinueText_value', true).'</p>';
						} else {
							?>
							<img src="<?php echo get_template_directory_uri(); ?>/images/next-section.png" alt="">
							<?php
						}
					?>
					</a>
				</div>
				<?php
			}
		?>
		
		<?php if ($video) { ?></div><?php } ?>
		
	</div>
	<script type="text/javascript">
		jQuery(document).on('click', '.home-text-wrapper .home-logo a, .home-text-wrapper .intro_continue a', function(e){
			if (jQuery(this).attr('href') === "#"){
				e.preventDefault();
				jQuery('html, body').animate({ scrollTop: jQuery('header').offset().top }, 1300, "easeInOutCirc");
			}
		});
	</script>
	<?php
}

function des_yunik_print_menu($ispagephp = true, $isfirstpage = false){
	$header_shrink = "";
	if (get_option('yunik_fixed_menu') == 'on'){
		if (get_option('yunik_header_after_scroll') == 'on'){
			if (get_option('yunik_header_shrink_effect') == 'on'){
				$header_shrink = " header_shrink";
			}
		}
	}
	$header_after_scroll = false;
	if (get_option('yunik_fixed_menu') == 'on'){
		if (get_option('yunik_header_after_scroll') == 'on'){
			$header_after_scroll = true;
		}
	}
	$typeofheader = get_option(DESIGNARE_SHORTNAME."_header_style_type");
	
	?>
	<header class="navbar navbar-default navbar-fixed-top <?php echo $typeofheader; ?> <?php if (get_option('yunik_fixed_menu') == 'off') echo " header_not_fixed"; else if (get_option('yunik_header_hide_on_start') == "on" && !$ispagephp) echo " hide-on-start"; ?>">
		
		<?php
		if (get_option(DESIGNARE_SHORTNAME."_info_above_menu") == "on"){
			?>
			<div class="top-bar">
				<div class="top-bar-bg">
					<div class="container clearfix">
						<div class="slidedown">
						    <div class="col-xs-12 col-sm-12">
							<?php
								/* social icons */
								if (get_option(DESIGNARE_SHORTNAME."_enable_socials") == "on"){
									?>
										<div class="social-icons-fa">
									        <ul>
											<?php
												$icons = array(array("facebook","Facebook"),array("twitter","Twitter"),array("tumblr","Tumblr"),array("stumbleupon","Stumble Upon"),array("flickr","Flickr"),array("linkedin","LinkedIn"),array("delicious","Delicious"),array("skype","Skype"),array("digg","Digg"),array("google-plus","Google+"),array("vimeo-square","Vimeo"),array("deviantart","DeviantArt"),array("behance","Behance"),array("instagram","Instagram"),array("wordpress","Wordpress"),array("youtube","Youtube"),array("reddit","Reddit"),array("rss","RSS"),array("soundcloud","SoundCloud"),array("pinterest","Pinterest"),array("dribbble","Dribbble"));
												foreach ($icons as $i){
													if (is_string(get_option(DESIGNARE_SHORTNAME."_icon-".$i[0])) && get_option(DESIGNARE_SHORTNAME."_icon-".$i[0]) != ""){
													?>
													<li>
														<a href="<?php echo get_option(DESIGNARE_SHORTNAME."_icon-".$i[0]); ?>" target="_blank" class="<?php echo strtolower($i[0]); ?>" title="<?php echo $i[1]; ?>"><i class="fa fa-<?php echo strtolower($i[0]); ?>"></i></a>
													</li>
													<?php
													}
												}
											?>
										    </ul>
										</div>
									<?php	
								}
								/* company infos */
								if ( get_option(DESIGNARE_SHORTNAME."_telephone_menu") != "" || get_option(DESIGNARE_SHORTNAME."_email_menu") != "" || get_option(DESIGNARE_SHORTNAME."_address_menu") != "" || get_option(DESIGNARE_SHORTNAME."_text_field_menu") != "" ){
									?>
									<ul class="phone-mail">
										<?php if ( is_string(get_option(DESIGNARE_SHORTNAME."_telephone_menu")) && get_option(DESIGNARE_SHORTNAME."_telephone_menu") != "" ){ ?>
											<li><i class="fa fa-phone"></i><?php _e(get_option(DESIGNARE_SHORTNAME."_telephone_menu"), "yunik"); ?></li>
										<?php } ?>
										<?php if ( is_string(get_option(DESIGNARE_SHORTNAME."_email_menu")) && get_option(DESIGNARE_SHORTNAME."_email_menu") != "" ){ ?>
											<li><i class="fa fa-envelope"></i><a href="mailto:<?php echo get_option(DESIGNARE_SHORTNAME."_email_menu"); ?>"><?php echo get_option(DESIGNARE_SHORTNAME."_email_menu"); ?></a></li>
										<?php } ?>
										<?php if ( is_string(get_option(DESIGNARE_SHORTNAME."_address_menu")) && get_option(DESIGNARE_SHORTNAME."_address_menu") != "" ){ ?>
											<li><i class="fa fa-map-marker"></i><?php echo get_option(DESIGNARE_SHORTNAME."_address_menu"); ?></li>
										<?php } ?>
										<?php if ( is_string(get_option(DESIGNARE_SHORTNAME."_text_field_menu")) && get_option(DESIGNARE_SHORTNAME."_text_field_menu") != "" ){ ?>
											<li><i class="fa fa-info-circle"></i><?php echo get_option(DESIGNARE_SHORTNAME."_text_field_menu"); ?></li>
										<?php } ?>
									</ul>
									<?php
								}
								
								/* wpml menu */
								if (get_option(DESIGNARE_SHORTNAME."_wpml_menu_widget") == "on") { 								
									if (function_exists('icl_object_id')) { ?>
										<div class="menu_wpml_widget">	
											<?php do_action('icl_language_selector'); ?>
										</div>
									<?php 
									}
								}
								/* topbar menu */
								if (get_option(DESIGNARE_SHORTNAME."_top_bar_menu") == "on"){
									?>
									<div class="top-bar-menu">
										<?php wp_nav_menu( array( 'theme_location' => 'topbarnav', 'container' => false, 'menu_class' => 'sf-menu', 'menu_id' => 'menu_top_bar' )); ?>
									</div>
									<?php
								}
							?>
							</div>
						</div>
					</div>
				</div>
				<a href="#" class="down-button"><i class="fa fa-plus"></i></a><!-- this appear on small devices -->
			</div>
			<script type="text/javascript">
				jQuery(document).ready(function(){		
					"use strict";
					if (jQuery(this).width() > 768) {
						jQuery('a.down-button').removeClass('current');
						jQuery('.slidedown').removeAttr('style');
					}
					jQuery('a.down-button').bind('click', function () {
					  if (jQuery(this).hasClass('current')) {
						  jQuery(this).removeClass('current');
						  jQuery(this).parent().parent().find('.slidedown').slideUp('slow', function(){ jQuery(this).closest('.top-bar').removeClass('opened'); });
						  
						  return false;
					  } else {
						  jQuery(this).addClass('current').closest('.top-bar').addClass('opened');
						  jQuery(this).parent().parent().find('.slidedown').slideDown('slow');
						  
						  return false;
					  }
					});
				});
				jQuery(window).bind('resize', function () { 
					if (jQuery(this).width() > 768) {
						jQuery('a.down-button').removeClass('current');
						jQuery('.slidedown').removeAttr('style');
					}
				});
			</script>
			<?php
		}
		
		if ($typeofheader == "style4" && (get_option(DESIGNARE_SHORTNAME."_social_icons_menu") == "on" || get_option(DESIGNARE_SHORTNAME."_enable_search") || get_option(DESIGNARE_SHORTNAME."_woocommerce_cart") == "on")){
			?>
			<div class="style4_social_search container">
				<?php
					if (get_option(DESIGNARE_SHORTNAME."_social_icons_menu") == "on"){
						?>
						<div class="header_social_icons <?php if (get_option(DESIGNARE_SHORTNAME."_social_icons_menu") == "on") echo "with-social-icons"; ?>">
							<div class="header_social_icons_wrapper">
							<?php
								global $howmany_header_social_icons; $howmany_header_social_icons = 0;
								$icons = array_reverse(array(array("facebook","Facebook"),array("twitter","Twitter"),array("tumblr","Tumblr"),array("stumbleupon","Stumble Upon"),array("flickr","Flickr"),array("linkedin","LinkedIn"),array("delicious","Delicious"),array("skype","Skype"),array("digg","Digg"),array("google-plus","Google+"),array("vimeo-square","Vimeo"),array("deviantart","DeviantArt"),array("behance","Behance"),array("instagram","Instagram"),array("wordpress","Wordpress"),array("youtube","Youtube"),array("reddit","Reddit"),array("rss","RSS"),array("soundcloud","SoundCloud"),array("pinterest","Pinterest"),array("dribbble","Dribbble")));
								foreach ($icons as $i){
									if (is_string(get_option(DESIGNARE_SHORTNAME."_icon-".$i[0])) && get_option(DESIGNARE_SHORTNAME."_icon-".$i[0]) != ""){
										$howmany_header_social_icons++;
									?>
									<div class="social_container <?php echo strtolower($i[0]); ?>_container" onclick="window.open('<?php echo get_option(DESIGNARE_SHORTNAME."_icon-".$i[0]); ?>', '_blank');">
										<i class="fa fa-<?php echo strtolower($i[0]); ?>"></i>
				                    </div>
									<?php
									}
								}
							?>	
							</div>
						</div>
						<?php
					}
					if (get_option(DESIGNARE_SHORTNAME."_enable_search") == "on"){
						?>
						<div class="search_trigger"><i class="fa fa-search"></i></div>
						<?php
					}
					des_print_woocommerce_button();
				?>
			</div>
			<?php
		}
		
		
		?>
		
		<div class="nav-container container">
	    	<div class="navbar-header">
		    	<?php if ($typeofheader == "style4"){ ?>
		    	<div class="new-menu-wrapper">
			    	<div class="new-menu-left"><div class="new-menu-bearer"><ul class="navbar-nav nav"></ul></div></div>
			    	<div class="new-menu-right"><div class="new-menu-bearer"><ul class="navbar-nav nav"></ul></div></div>
			    </div>
		    	<?php } ?>
				<a class="navbar-brand nav-to" href="<?php echo home_url(); ?>" tabindex="-1">
		        	<?php 
	    			if (get_option(DESIGNARE_SHORTNAME."_logo_type") == "text"){
	    			?>
	    					<h1 class="logo" style="
    						<?php
								if (get_option(DESIGNARE_SHORTNAME."_logo_font")){
									$font = get_option(DESIGNARE_SHORTNAME."_logo_font");
									$des_import_fonts[] = $font;
									$font = explode("|",$font);
									if ($font[0] == "Helvetica" || $font[0] == "Helvetica Neue") $font[0] = $font[0]."', 'Arial', 'sans-serif";
									if (!isset($font[1])) $font[1] = "";									
							 		echo "font-family:'{$font[0]}';font-weigth:{$font[1]};";
						 		}
							?>
    						<?php 
    						if (get_option(DESIGNARE_SHORTNAME."_logo_font_style") != ""){
    							$styles = explode(',', get_option(DESIGNARE_SHORTNAME."_logo_font_style"));
									foreach ($styles as $style){
										switch($style){
											case "italic": 
												echo "font-style: italic; ";
												break;
											case "bold": 
												echo "font-weight: bold; ";
												break;
											case "underline": 
												echo "text-decoration: underline; ";
												break;
										}
									}  
							} ?>
								<?php echo "font-size: " . str_replace(" ", "", get_option(DESIGNARE_SHORTNAME."_logo_size")) . ";";  ?>
								<?php echo "color: #" . get_option(DESIGNARE_SHORTNAME."_logo_color") . ";";  ?>">
								<?php echo get_option(DESIGNARE_SHORTNAME."_logo_text"); ?></h1>
								<?php if (isset($variant) && $variant) echo "<div style='display:none;'>".do_shortcode($shtcd)."</div>"; ?>
	    				<?php
	    			} else {		    			
		    			$alone = true;
	    				if (get_option(DESIGNARE_SHORTNAME."_logo_retina_image_url") != ""){
		    				$alone = false;
	    				}
    					?>
    					<img class="logo_normal <?php if (!$alone) echo "notalone"; ?>" style="position: relative;" src="<?php echo get_option(DESIGNARE_SHORTNAME."_logo_image_url"); ?>" alt="<?php _e("", "yunik"); ?>" title="<?php _e("", "yunik"); ?>">
	    					
	    				<?php 
	    				if (get_option(DESIGNARE_SHORTNAME."_logo_retina_image_url") != ""){
	    				?>
		    				<img class="logo_retina" style="display:none; position: relative;" src="<?php echo get_option(DESIGNARE_SHORTNAME."_logo_retina_image_url"); ?>" alt="<?php _e("", "yunik"); ?>" title="<?php _e("", "yunik"); ?>">
	    				<?php
    					}
						/* yunik_header_after_scroll option */
		    			if ($header_after_scroll || get_option('yunik_header_hide_on_start') == 'on'){
			    			$alone = true;
		    				if (get_option(DESIGNARE_SHORTNAME."_logo_after_scroll_retina_image_url") != ""){
			    				$alone = false;
		    				}
	    					?>
	    					<img class="logo_normal logo_after_scroll <?php if (!$alone) echo "notalone"; ?>" style="position: relative;" alt="<?php _e("", "yunik"); ?>" title="<?php _e("", "yunik"); ?>" src="<?php echo get_option(DESIGNARE_SHORTNAME."_logo_after_scroll_image_url"); ?>">
		    					
		    				<?php 
		    				if (get_option(DESIGNARE_SHORTNAME."_logo_after_scroll_retina_image_url") != ""){
		    				?>
			    				<img class="logo_retina logo_after_scroll" style="display:none; position: relative;" src="<?php echo get_option(DESIGNARE_SHORTNAME."_logo_after_scroll_retina_image_url"); ?>" alt="<?php _e("", "yunik"); ?>" title="<?php _e("", "yunik"); ?>">
		    				<?php
	    					}
		    			}
	    			}
	    		?>
		        </a>
			</div>
			
			<?php
				if ($typeofheader == "style4" && (get_option(DESIGNARE_SHORTNAME."_social_icons_menu") == "on" || get_option(DESIGNARE_SHORTNAME."_enable_search") || get_option(DESIGNARE_SHORTNAME."yunik_woocommerce_cart") == "on")){
					?>
					<div class="style4_social_search_mobile container">
						<?php
							if (get_option(DESIGNARE_SHORTNAME."_social_icons_menu") == "on"){
								?>
								<div class="header_social_icons <?php if (get_option(DESIGNARE_SHORTNAME."_social_icons_menu") == "on") echo "with-social-icons"; ?>">
									<div class="header_social_icons_wrapper">
									<?php
										des_print_woocommerce_button();
										if (get_option(DESIGNARE_SHORTNAME."_enable_search") == "on"){
											?>
											<div class="search_trigger"><i class="fa fa-search"></i></div>
											<?php
										}
										global $howmany_header_social_icons; $howmany_header_social_icons = 0;
										$icons = array_reverse(array(array("facebook","Facebook"),array("twitter","Twitter"),array("tumblr","Tumblr"),array("stumbleupon","Stumble Upon"),array("flickr","Flickr"),array("linkedin","LinkedIn"),array("delicious","Delicious"),array("skype","Skype"),array("digg","Digg"),array("google-plus","Google+"),array("vimeo-square","Vimeo"),array("deviantart","DeviantArt"),array("behance","Behance"),array("instagram","Instagram"),array("wordpress","Wordpress"),array("youtube","Youtube"),array("reddit","Reddit"),array("rss","RSS"),array("soundcloud","SoundCloud"),array("pinterest","Pinterest"),array("dribbble","Dribbble")));
										foreach ($icons as $i){
											if (is_string(get_option(DESIGNARE_SHORTNAME."_icon-".$i[0])) && get_option(DESIGNARE_SHORTNAME."_icon-".$i[0]) != ""){
												$howmany_header_social_icons++;
											?>
											<div class="social_container <?php echo strtolower($i[0]); ?>_container" onclick="window.open('<?php echo get_option(DESIGNARE_SHORTNAME."_icon-".$i[0]); ?>', '_blank');">
												<i class="fa fa-<?php echo strtolower($i[0]); ?>"></i>
						                    </div>
											<?php
											}
										}
									?>
									</div>
								</div>
								<?php
							}
						?>
					</div>
					<?php
				}
				
				if (get_option(DESIGNARE_SHORTNAME."_header_style_type") == "style3"){
					?>
					<div class="header_social_icons <?php if (get_option(DESIGNARE_SHORTNAME."_social_icons_menu") == "on") echo "with-social-icons"; ?>">
						<?php 
							if (get_option(DESIGNARE_SHORTNAME."_social_icons_menu") == "on"){
								?>
								<div class="header_social_icons_wrapper">
								<?php
									global $howmany_header_social_icons; $howmany_header_social_icons = 0;
									$icons = array_reverse(array(array("facebook","Facebook"),array("twitter","Twitter"),array("tumblr","Tumblr"),array("stumbleupon","Stumble Upon"),array("flickr","Flickr"),array("linkedin","LinkedIn"),array("delicious","Delicious"),array("skype","Skype"),array("digg","Digg"),array("google-plus","Google+"),array("vimeo-square","Vimeo"),array("deviantart","DeviantArt"),array("behance","Behance"),array("instagram","Instagram"),array("wordpress","Wordpress"),array("youtube","Youtube"),array("reddit","Reddit"),array("rss","RSS"),array("soundcloud","SoundCloud"),array("pinterest","Pinterest"),array("dribbble","Dribbble")));
									foreach ($icons as $i){
										if (is_string(get_option(DESIGNARE_SHORTNAME."_icon-".$i[0])) && get_option(DESIGNARE_SHORTNAME."_icon-".$i[0]) != ""){
											$howmany_header_social_icons++;
										?>
										<div class="social_container <?php echo strtolower($i[0]); ?>_container" onclick="window.open('<?php echo get_option(DESIGNARE_SHORTNAME."_icon-".$i[0]); ?>', '_blank');">
											<i class="fa fa-<?php echo strtolower($i[0]); ?>"></i>
					                    </div>
										<?php
										}
									}
								?>	
								</div>
								<?php
							}
							//search trigger
							if (get_option(DESIGNARE_SHORTNAME."_enable_search") == "on"){
								?>
								<div class="search_trigger_mobile"><i class="fa fa-search"></i></div>
								<?php
							}
						?>
					</div>
					<?php
				}
			?>
			
			<div class="navbar-collapse collapse">
				<?php 
					if (!$isfirstpage){
						if ($ispagephp){
							wp_nav_menu( array( 'theme_location' => 'PrimaryNavigation', 'container' => false, 'menu_class' => 'nav navbar-nav navbar-right', 'walker' => new des_walker_nav_menu_outsider, 'fallback_cb' => __('You need to assign a Menu to the Main Navigation Location.','yunik') ) );
						} 
						else {
							global $homes;
							$homes = 0;
							wp_nav_menu( array( 'theme_location' => 'PrimaryNavigation', 'container' => false, 'menu_class' => 'nav navbar-nav navbar-right', 'walker' => new des_walker_nav_menu, 'fallback_cb' => __('You need to assign a Menu to the Main Navigation Location.','yunik') ) );
						} 	
					}
				?>
			</div>
			<?php
				if (!$isfirstpage){
					?>
					<div id="dl-menu" class="dl-menuwrapper">
						<div class="dl-trigger-wrapper">
							<button class="dl-trigger"><?php _e(get_option(DESIGNARE_SHORTNAME."_open_menu"),"yunik"); ?></button>
						</div>
						<?php 
							if ($ispagephp){
								wp_nav_menu( array( 'theme_location' => 'PrimaryNavigation', 'container' => false, 'menu_class' => 'dl-menu', 'walker' => new des_walker_nav_menu_outsider, 'fallback_cb' => __('You need to assign a Menu to the Main Navigation Location.','yunik') ) );
							} 
							else {
								global $homes;
								$homes = 0;
								wp_nav_menu( array( 'theme_location' => 'PrimaryNavigation', 'container' => false, 'menu_class' => 'dl-menu', 'walker' => new des_walker_nav_menu, 'fallback_cb' => __('You need to assign a Menu to the Main Navigation Location.','yunik') ) );
							} 
						?>
					</div>
					<?php
				}
			?>
			
			
			<?php
				if ($typeofheader != "style3" && $typeofheader != "style4"){
					?>
					<div class="header_social_icons <?php if (get_option(DESIGNARE_SHORTNAME."_social_icons_menu") == "on") echo "with-social-icons"; ?>">
						<?php
							if (get_option(DESIGNARE_SHORTNAME."_social_icons_menu") == "on" ){
								?>
								<div class="header_social_icons_wrapper">
								<?php
									global $howmany_header_social_icons; $howmany_header_social_icons = 0;
									$icons = array_reverse(array(array("facebook","Facebook"),array("twitter","Twitter"),array("tumblr","Tumblr"),array("stumbleupon","Stumble Upon"),array("flickr","Flickr"),array("linkedin","LinkedIn"),array("delicious","Delicious"),array("skype","Skype"),array("digg","Digg"),array("google-plus","Google+"),array("vimeo-square","Vimeo"),array("deviantart","DeviantArt"),array("behance","Behance"),array("instagram","Instagram"),array("wordpress","Wordpress"),array("youtube","Youtube"),array("reddit","Reddit"),array("rss","RSS"),array("soundcloud","SoundCloud"),array("pinterest","Pinterest"),array("dribbble","Dribbble")));
									foreach ($icons as $i){
										if (is_string(get_option(DESIGNARE_SHORTNAME."_icon-".$i[0])) && get_option(DESIGNARE_SHORTNAME."_icon-".$i[0]) != ""){
											$howmany_header_social_icons++;
										?>
										<div class="social_container <?php echo strtolower($i[0]); ?>_container" onclick="window.open('<?php echo get_option(DESIGNARE_SHORTNAME."_icon-".$i[0]); ?>', '_blank');">
											<i class="fa fa-<?php echo strtolower($i[0]); ?>"></i>
					                    </div>
										<?php
										}
									}
								?>	
								</div>
								<?php
							}
							//search trigger
							if (get_option(DESIGNARE_SHORTNAME."_enable_search") == "on"){
								?>
								<div class="search_trigger_mobile"><i class="fa fa-search"></i></div>
								<?php
							}
						?>
					</div>
					<?php
					des_print_woocommerce_button();
				}
			?>
			
			<?php
				//search trigger
				if (get_option(DESIGNARE_SHORTNAME."_enable_search") == "on" && $typeofheader != "style4"){
					?>
					<div class="search_trigger"><i class="fa fa-search"></i></div>
					<?php
				}
			?>
			 
		</div>
		
		<?php
		//the search input
		if (get_option(DESIGNARE_SHORTNAME."_enable_search") == "on"){
			?>
			<form autocomplete="off" role="search" method="get" class="search_input <?php echo get_option(DESIGNARE_SHORTNAME."_search_open_effect"); ?>" action="<?php echo home_url( '/' ); ?>">
				<div class="container">
					<input value="" name="s" class="search_input_value" type="text" placeholder="<?php _e(get_option(DESIGNARE_SHORTNAME."_search_box_text"),"yunik"); ?>" />
					<input class="hidden" type="submit" id="searchsubmit" value="Search" />
					<div class="search_close">
						<i class="fa fa-times"></i>
					</div>
					<div class="ajax_search_results"><ul></ul></div>
				</div>
			</form>	
			<?php
		}
		?>
		
	</header>
	<?php
}

class des_walker_nav_menu extends Walker_Nav_Menu {
	function start_lvl( &$output, $depth = 0, $args = array() ) {
	    $indent = ( $depth > 0  ? str_repeat( "\t", $depth ) : '' );
	    $display_depth = ( $depth + 1);
	    $classes = array(
	        'sub-menu',
	        ( $display_depth % 2  ? 'menu-odd' : 'menu-even' ),
	        ( $display_depth >=2 ? 'sub-sub-menu' : '' ),
	        'menu-depth-' . $display_depth
	        );
	    $class_names = implode( ' ', $classes );
	    $output .= "\n" . $indent . '<ul class="dropdown-menu ' . $class_names . '">' . "\n";
	}
  	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
	    global $wp_query, $homes;
	    $indent = ( $depth > 0 ? str_repeat( "\t", $depth ) : '' );
	    $depth_classes = array(
	        ( $depth == 0 ? 'main-menu-item' : 'sub-menu-item' ),
	        ( $depth >=2 ? 'sub-sub-menu-item' : '' ),
	        ( $depth % 2 ? 'menu-item-odd' : 'menu-item-even' ),
	        'menu-item-depth-' . $depth
	    );
	    $depth_class_names = esc_attr( implode( ' ', $depth_classes ) );
	    $classes = empty( $item->classes ) ? array() : (array) $item->classes;
	    $iconsclass = "";
	    if (!empty($classes)){
	    	for ($i=0; $i<count($classes); $i++){
		    	if (isset($classes[$i]) && substr($classes[$i], 0, 2) === "fa"){
			    	$iconsclass .= " ".$classes[$i];
			    	unset($classes[$i]);
		    	}
	    	}
	    }
	    if ($iconsclass != "") $iconsclass = "<i class='main-menu-icon ".$iconsclass."'></i>";
	    $class_names = esc_attr( implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) ) );
		$pid = explode(" ",$class_names);
		$thyid = 0;
		foreach ($pid as $p){
			if (substr( $p, 0, 5 ) === "page-"){
				$thyid = substr($p,5);
			}
		}
		$template = get_post_meta($thyid, '_wp_page_template', true);
		$outsider = ($template === "page.php" || $template === "blog-template.php" || $template === "blog-masonry-template.php" || $template === "template-home.php" || $template === "woocommerce.php") ? " outsider" : "";
		
		if ($template === "template-home.php") $homes++;
		if ($template === "template-home.php" && $homes == 1) $outsider .= " mainhomepage";
	    $output .= $indent . '<li id="nav-menu-item-'. $item->ID . '" class="' . $depth_class_names . ' ' . $class_names . '">';
  
	    // link attributes
	    $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
	    $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
	    $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';

		if (!empty($item->url)){
			if ($outsider != ""){
				if ($template === "one-page-template.php"){
					$attributes .= ' href="./#section_page-'.$thyid.'"';
				} else {
					if ($template === 'template-home.php' && $homes == 1){
						$attributes .= ' href="#home"';
					} else {
						$attributes .= ' href="' . esc_attr( $item->url ) . '"';
					}	
				}
			} else {
				$custom = false;
				foreach ($pid as $p){
					if ($p === "menu-item-object-custom"){
						$custom = true;
					}
				}
				if ($custom) $attributes .= ' href="' . esc_attr( $item->url ) . '"';
				else $attributes .= ' href="#section_page-'.$thyid.'"';
			}
		}
	    $attributes .= ' class="menu-link ' . ( $depth > 0 ? 'sub-menu-link' . $outsider : 'main-menu-link' ) . $outsider . '"';
  
	    $item_output = sprintf( '%1$s<a%2$s>%7$s%3$s%4$s%5$s</a>%6$s',
	        $args->before,
	        $attributes,
	        $args->link_before,
	        apply_filters( 'the_title', $item->title, $item->ID ),
	        $args->link_after,
	        $args->after,
	        $iconsclass
	    );
  
	    $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}
}

class des_walker_nav_menu_outsider extends Walker_Nav_Menu {
  
	function start_lvl( &$output, $depth = 0, $args = array() ) {
	    $indent = ( $depth > 0  ? str_repeat( "\t", $depth ) : '' );
	    $display_depth = ( $depth + 1);
	    $classes = array(
	        'sub-menu',
	        ( $display_depth % 2  ? 'menu-odd' : 'menu-even' ),
	        ( $display_depth >=2 ? 'sub-sub-menu' : '' ),
	        'menu-depth-' . $display_depth
	        );
	    $class_names = implode( ' ', $classes );
	    $output .= "\n" . $indent . '<ul class="dropdown-menu ' . $class_names . '">' . "\n";
	}
  
	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
	    global $wp_query;
	    $indent = ( $depth > 0 ? str_repeat( "\t", $depth ) : '' );
	    $depth_classes = array(
	        ( $depth == 0 ? 'main-menu-item' : 'sub-menu-item' ),
	        ( $depth >=2 ? 'sub-sub-menu-item' : '' ),
	        ( $depth % 2 ? 'menu-item-odd' : 'menu-item-even' ),
	        'menu-item-depth-' . $depth
	    );
	    $depth_class_names = esc_attr( implode( ' ', $depth_classes ) );
  
	    $classes = empty( $item->classes ) ? array() : (array) $item->classes;
	    
	    $iconsclass = "";
	    if (!empty($classes)){
	    	for ($i=0; $i<count($classes); $i++){
		    	if (isset($classes[$i]) && substr($classes[$i], 0, 2) === "fa"){
			    	$iconsclass .= " ".$classes[$i];
			    	unset($classes[$i]);
		    	}
	    	}
	    }
	    if ($iconsclass != "") $iconsclass = "<i class='main-menu-icon ".$iconsclass."'></i>";
	    $class_names = esc_attr( implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) ) );
	    
	    $pid = explode(" ",$class_names);
		$thyid = 0;
		foreach ($pid as $p){
			if (substr( $p, 0, 5 ) == "page-" && substr( $p, 0, 10 ) != "page-item-"){
				$thyid = substr($p,5);
			}
		}
	    $template = get_post_meta($thyid, '_wp_page_template', true);
	    $output .= $indent . '<li id="nav-menu-item-'. $item->ID . '" class="' . $depth_class_names . ' ' . $class_names . '">';
  
	    // link attributes
	    $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
	    $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
	    $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
		if (!empty($item->url)){
			if ($template === "one-page-template.php"){
				$attributes .= ' href="' . esc_url( home_url( '/' ) ) . "#section_page-" . $thyid . '"';
			} else {
				$attributes .= ' href="' . esc_attr( $item->url ) . '"';	
			}
		}
	    $attributes .= ' class="menu-link ' . ( $depth > 0 ? 'sub-menu-link' : 'main-menu-link' ) . '"';
  
	    $item_output = sprintf( '%1$s<a%2$s>%7$s%3$s%4$s%5$s</a>%6$s',
	        $args->before,
	        $attributes,
	        $args->link_before,
	        apply_filters( 'the_title', $item->title, $item->ID ),
	        $args->link_after,
	        $args->after,
	        $iconsclass
	    );
	    $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}
}

function des_yunik_print_slider($id, $prlx = null){
	$daslider = get_post_meta($id, 'homepageDefaultSlider_value', true);
	if (substr($daslider, 0, 10) === "revSlider_"){
		if (!function_exists('putRevSlider')){
			echo 'Please install the missing plugin - Revolution Slider.';
		} else {
			if ($prlx){ ?>
			<section id="home" class="homepage_parallax parallax">
				<div id="parallax-home" class="parallax" data-stellar-ratio="0.5">
			<?php 
			} ?>
			<section id="home" class="revslider">
				<?php putRevSlider(substr($daslider, 10)); ?>
			</section>
			<?php 
			if ($prlx){ ?>
				</div>
			</section>
			<?php 
			}
		}
	}
}

function des_register_required_plugins() {

	$plugins = array(

		// This is an example of how to include a plugin pre-packaged with a theme
		
		array(
			'name'     				=> 'Designare Custom Post Types', // The plugin name
			'slug'     				=> 'designare_custom_post_types', // The plugin slug (typically the folder name)
			'source'   				=> get_template_directory_uri() . '/lib/plugins/designare_custom_post_types.zip', // The plugin source
			'required' 				=> true, // If false, the plugin is only 'recommended' instead of required
			'version' 				=> '', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			'force_activation' 		=> true, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' 	=> true, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
		),
		
		array(
			'name'     				=> 'Contact Form 7', // The plugin name
			'slug'     				=> 'contact-form-7', // The plugin slug (typically the folder name)
			'source'   				=> get_template_directory_uri() . '/lib/plugins/contact-form-7.zip', // The plugin source
			'required' 				=> true, // If false, the plugin is only 'recommended' instead of required
			'version' 				=> '', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			'force_activation' 		=> true, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
		),
		
		array(
			'name'     				=> 'Really Simple CAPTCHA', // The plugin name
			'slug'     				=> 'really-simple-captcha', // The plugin slug (typically the folder name)
			'source'   				=> get_template_directory_uri() . '/lib/plugins/really-simple-captcha.zip', // The plugin source
			'required' 				=> true, // If false, the plugin is only 'recommended' instead of required
			'version' 				=> '', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			'force_activation' 		=> true, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
		),
				
		array(
			'name'     				=> 'Revolution Slider', // The plugin name
			'slug'     				=> 'revslider', // The plugin slug (typically the folder name)
			'source'   				=> get_template_directory_uri() . '/lib/plugins/revslider.zip', // The plugin source
			'required' 				=> true, // If false, the plugin is only 'recommended' instead of required
			'version' 				=> '', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			'force_activation' 		=> true, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
		),
		
		array(
			'name'     				=> 'WPBakery Visual Composer', // The plugin name
			'slug'     				=> 'js_composer', // The plugin slug (typically the folder name)
			'source'   				=> get_template_directory_uri() . '/lib/plugins/js_composer.zip', // The plugin source
			'required' 				=> true, // If false, the plugin is only 'recommended' instead of required
			'version' 				=> '', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			'force_activation' 		=> true, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
		),
		
		array(
			'name'     				=> 'Ultimate Addons for Visual Composer', // The plugin name
			'slug'     				=> 'Ultimate_VC_Addons', // The plugin slug (typically the folder name)
			'source'   				=> get_template_directory_uri() . '/lib/plugins/Ultimate_VC_Addons.zip', // The plugin source
			'required' 				=> true, // If false, the plugin is only 'recommended' instead of required
			'version' 				=> '', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			'force_activation' 		=> true, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
		),
		
		array(
			'name'     				=> 'Cube Portfolio', // The plugin name
			'slug'     				=> 'cubeportfolio', // The plugin slug (typically the folder name)
			'source'   				=> get_template_directory_uri() . '/lib/plugins/cubeportfolio.zip', // The plugin source
			'required' 				=> true, // If false, the plugin is only 'recommended' instead of required
			'version' 				=> '', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			'force_activation' 		=> true, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
		)
		// This is an example of how to include a plugin from the WordPress Plugin Repository
	);

	// Change this to your theme text domain, used for internationalising strings
	$theme_text_domain = 'yunik';
	$config = array(
		'domain'       		=> $theme_text_domain,         	// Text domain - likely want to be the same as your theme.
		'default_path' 		=> get_template_directory_uri() . '/lib/plugins/',                         	// Default absolute path to pre-packaged plugins
		'parent_menu_slug' 	=> 'themes.php', 				// Default parent menu slug
		'parent_url_slug' 	=> 'themes.php', 				// Default parent URL slug
		'menu'         		=> 'install-required-plugins', 	// Menu slug
		'has_notices'      	=> true,                       	// Show admin notices or not
		'is_automatic'    	=> true,					   	// Automatically activate plugins after installation or not
		'message' 			=> '',							// Message to output right before the plugins table
		'strings'      		=> array(
			'page_title'                       			=> __( 'Install Required Plugins', $theme_text_domain ),
			'menu_title'                       			=> __( 'Install Plugins', $theme_text_domain ),
			'installing'                       			=> __( 'Installing Plugin: %s', $theme_text_domain ), // %1$s = plugin name
			'oops'                             			=> __( 'Something went wrong with the plugin API.', $theme_text_domain ),
			'notice_can_install_required'     			=> _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.' ), // %1$s = plugin name(s)
			'notice_can_install_recommended'			=> _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.' ), // %1$s = plugin name(s)
			'notice_cannot_install'  					=> _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.' ), // %1$s = plugin name(s)
			'notice_can_activate_required'    			=> _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s)
			'notice_can_activate_recommended'			=> _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s)
			'notice_cannot_activate' 					=> _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.' ), // %1$s = plugin name(s)
			'notice_ask_to_update' 						=> _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.' ), // %1$s = plugin name(s)
			'notice_cannot_update' 						=> _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.' ), // %1$s = plugin name(s)
			'install_link' 					  			=> _n_noop( 'Begin installing plugin', 'Begin installing plugins' ),
			'activate_link' 				  			=> _n_noop( 'Activate installed plugin', 'Activate installed plugins' ),
			'return'                           			=> __( 'Return to Required Plugins Installer', $theme_text_domain ),
			'plugin_activated'                 			=> __( 'Plugin activated successfully.', $theme_text_domain ),
			'complete' 									=> __( 'All plugins installed and activated successfully. %s', $theme_text_domain ), // %1$s = dashboard link
			'nag_type'									=> 'updated' // Determines admin notice type - can only be 'updated' or 'error'
		)
	);

	tgmpa( $plugins, $config );

}


function des_autoimport($url, $demo) {
	
    // get the file
    require_once DESIGNARE_CLASSES_PATH . 'designare-content-import.php';

    if ( ! class_exists( 'Auto_Importer' ) )
        die( 'Auto_Importer not found' );

    // call the function
	$upload_dir = wp_upload_dir();
	$demo_file = $url.$demo."/contents.xml";
	$tempfile = $upload_dir['basedir'] . '/temp.xml' ;

    if (function_exists('curl_exec')){
        $conn = curl_init($demo_file);
        curl_setopt($conn, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($conn, CURLOPT_FRESH_CONNECT,  true);
        curl_setopt($conn, CURLOPT_RETURNTRANSFER, 1);
        $xml = (curl_exec($conn));
        curl_close($conn);
    } else if (function_exists('file_get_contents')){
        $xml = file_get_contents($demo_file);
    } else if (function_exists('fopen') && function_exists('stream_get_contents')){
        $handle = fopen ($demo_file, "r");
        $xml = stream_get_contents($handle);
    } else {
        $xml = false;
    }

	if (function_exists('file_put_contents')){
		$xml = file_put_contents($tempfile, $xml);
	} else {
		$xml = copy($xml, $tempfile);
	}
	//$xml = file_get_contents($demo_file);
	
//	if (!file_put_contents($tempfile, $xml)){
//		echo "not enough permissions" . $tempfile;
//	} else {
		$args = array(
            'file'        => $tempfile,
            'map_user_id' => 0
        );
    
        auto_import( $args );
//	}

}

function des_get_excerpt($text, $excerpt){
    if ($excerpt) return $excerpt;

    $text = strip_shortcodes( $text );

    $text = apply_filters('the_content', $text);
    $text = str_replace(']]>', ']]&gt;', $text);
    $text = strip_tags($text);
    $excerpt_length = apply_filters('excerpt_length', 55);
    $excerpt_more = apply_filters('excerpt_more', ' ' . '[...]');
    $words = preg_split("/[\n\r\t ]+/", $text, $excerpt_length + 1, PREG_SPLIT_NO_EMPTY);
    if ( count($words) > $excerpt_length ) {
            array_pop($words);
            $text = implode(' ', $words);
            $text = $text . $excerpt_more;
    } else {
            $text = implode(' ', $words);
    }

    return apply_filters('wp_trim_excerpt', $text, $raw_excerpt);
}

/*  EXTEND VC SHORTCODES  */
function des_team_categories_settings_field($settings, $value){
	$dependency = vc_generate_dependencies_attributes($settings);
	$taxonomy = 'team_category';
	$tax_terms = get_terms($taxonomy);
	$output = "";
	if (!count($tax_terms)){
		$output .= "No categories defined.";
		$output .= '<input name="'.$settings['param_name'].'" class="hidden wpb_vc_param_value wpb-textinput '.$settings['param_name'].' '.$settings['type'].'_field" type="text" value="0" />';
	} else {
		if (count($tax_terms) > 1) $output .= "<label class='team_categories'><input class='selectall' type='checkbox' name='categories[]' value='0' onchange=\"if(jQuery(this).is(':checked')){ jQuery(this).parent().siblings().children('input').attr('checked',true);jQuery(this).parent().siblings('input.".$settings['param_name']."').val('-1');} else { jQuery(this).parent().siblings().children('input').attr('checked',false);jQuery(this).parent().siblings('input.".$settings['param_name']."').val('0');}\" />".__('All','js_composer')."</label>";
		$value = explode(",",$value);
		foreach ($tax_terms as $tax_term) {
			$output .= "<label class='team_categories'><input ";
			if (in_array($tax_term->term_id, $value)) $output .= " checked='checked' ";
			$output .= "class='categories_checks' type='checkbox' name='categories[]' value='".$tax_term->term_id."' onchange=\"var output = '';jQuery('.edit_form_line input:checked').not('.selectall').each(function(e){ if(e!=0){output += ',';} output += jQuery(this).val(); }); jQuery(this).parent().siblings('.team_cats_field').val(output); if (jQuery('.edit_form_line input').not('.selectall').not(':checked').length) jQuery('.edit_form_line input.selectall').attr('checked',false); if (jQuery('.edit_form_line input.categories_checks:checked').not('.selectall').length == jQuery('.edit_form_line input.categories_checks').not('.selectall').length) jQuery('.edit_form_line input.selectall').attr('checked',true); \" />".$tax_term->name."</label>";
		}
		$output .= '<input name="'.$settings['param_name'].'" class="hidden wpb_vc_param_value wpb-textinput '.$settings['param_name'].' '.$settings['type'].'_field" type="text" value="'.implode(",",$value).'" />';
	}
	return $output;
}

function des_partners_categories_settings_field($settings, $value){
	$dependency = vc_generate_dependencies_attributes($settings);
	$taxonomy = 'partners_category';
	$tax_terms = get_terms($taxonomy);
	$output = "";
	if (!count($tax_terms)){
		$output .= "No categories defined.";
		$output .= '<input name="'.$settings['param_name'].'" class="hidden wpb_vc_param_value wpb-textinput '.$settings['param_name'].' '.$settings['type'].'_field" type="text" value="0" />';
	} else {
		if (count($tax_terms) > 1) $output .= "<label class='partners_categories'><input class='selectall' type='checkbox' name='categories[]' value='0' onchange=\"if(jQuery(this).is(':checked')){ jQuery(this).parent().siblings().children('input').attr('checked',true);jQuery(this).parent().siblings('input.".$settings['param_name']."').val('-1');} else { jQuery(this).parent().siblings().children('input').attr('checked',false);jQuery(this).parent().siblings('input.".$settings['param_name']."').val('0');}\" />".__('All','js_composer')."</label>";
		$value = explode(",",$value);
		foreach ($tax_terms as $tax_term) {
			$output .= "<label class='partners_categories'><input "; 
			if (in_array($tax_term->term_id, $value)) $output .= " checked='checked' ";
			$output .= "class='categories_checks' type='checkbox' name='categories[]' value='".$tax_term->term_id."' onchange=\"var output = '';jQuery('.edit_form_line input:checked').not('.selectall').each(function(e){ if(e!=0){output += ',';} output += jQuery(this).val(); }); jQuery(this).parent().siblings('.partners_cats_field').val(output); if (jQuery('.edit_form_line input').not('.selectall').not(':checked').length) jQuery('.edit_form_line input.selectall').attr('checked',false); if (jQuery('.edit_form_line input.categories_checks:checked').not('.selectall').length == jQuery('.edit_form_line input.categories_checks').not('.selectall').length) jQuery('.edit_form_line input.selectall').attr('checked',true); \" />".$tax_term->name."</label>";
		}
		$output .= '<input name="'.$settings['param_name'].'" class="hidden wpb_vc_param_value wpb-textinput '.$settings['param_name'].' '.$settings['type'].'_field" type="text" value="'.implode(",",$value).'" />';
	}
	return $output;
}

function des_testimonials_categories_settings_field($settings, $value){
	$dependency = vc_generate_dependencies_attributes($settings);
	$taxonomy = 'testimonials_category';
	$tax_terms = get_terms($taxonomy);
	$output = "";
	if (!count($tax_terms)){
		$output .= "No categories defined.";
		$output .= '<input name="'.$settings['param_name'].'" class="hidden wpb_vc_param_value wpb-textinput '.$settings['param_name'].' '.$settings['type'].'_field" type="text" value="0" />';
	} else {
		if (count($tax_terms) > 1) $output .= "<label class='testimonial_categories'><input class='selectall' type='checkbox' name='categories[]' value='0' onchange=\"if(jQuery(this).is(':checked')){ jQuery(this).parent().siblings().children('input').attr('checked',true);jQuery(this).parent().siblings('input.".$settings['param_name']."').val('-1');} else { jQuery(this).parent().siblings().children('input').attr('checked',false);jQuery(this).parent().siblings('input.".$settings['param_name']."').val('0');}\" />".__('All','js_composer')."</label>";
		$value = explode(",",$value);
		foreach ($tax_terms as $tax_term) {
			$output .= "<label class='testimonial_categories'><input ";
			if (in_array($tax_term->term_id, $value)) $output .= " checked='checked' ";
			$output .= "class='categories_checks' type='checkbox' name='categories[]' value='".$tax_term->term_id."' onchange=\"var output = '';jQuery('.edit_form_line input:checked').not('.selectall').each(function(e){ if(e!=0){output += ',';} output += jQuery(this).val(); }); jQuery(this).parent().siblings('.testimonials_cats_field').val(output); if (jQuery('.edit_form_line input').not('.selectall').not(':checked').length) jQuery('.edit_form_line input.selectall').attr('checked',false); if (jQuery('.edit_form_line input.categories_checks:checked').not('.selectall').length == jQuery('.edit_form_line input.categories_checks').not('.selectall').length) jQuery('.edit_form_line input.selectall').attr('checked',true); \" />".$tax_term->name."</label>";
		}
		$output .= '<input name="'.$settings['param_name'].'" class="hidden wpb_vc_param_value wpb-textinput '.$settings['param_name'].' '.$settings['type'].'_field" type="text" value="'.implode(",",$value).'" />';
	}
	return $output;
}


function des_fa_settings_field($settings, $value) {
   $dependency = vc_generate_dependencies_attributes($settings);
	$icons = array('fa-adjust','fa-adn','fa-align-center','fa-align-justify','fa-align-left','fa-align-right','fa-ambulance','fa-anchor','fa-android','fa-angle-double-down','fa-angle-double-left','fa-angle-double-right','fa-angle-double-up','fa-angle-down','fa-angle-left','fa-angle-right','fa-angle-up','fa-apple','fa-archive','fa-arrow-circle-down','fa-arrow-circle-left','fa-arrow-circle-o-down','fa-arrow-circle-o-left','fa-arrow-circle-o-right','fa-arrow-circle-o-up','fa-arrow-circle-right','fa-arrow-circle-up','fa-arrow-down','fa-arrow-left','fa-arrow-right','fa-arrow-up','fa-arrows','fa-arrows-alt','fa-arrows-h','fa-arrows-v','fa-asterisk','fa-automobile','fa-backward','fa-ban','fa-bank','fa-bar-chart-o','fa-barcode','fa-bars','fa-beer','fa-behance','fa-behance-square','fa-bell','fa-bell-o','fa-bitbucket','fa-bitbucket-square','fa-bitcoin','fa-bold','fa-bolt','fa-bomb','fa-book','fa-bookmark','fa-bookmark-o','fa-briefcase','fa-btc','fa-bug','fa-building','fa-building-o','fa-bullhorn','fa-bullseye','fa-cab','fa-calendar','fa-calendar-o','fa-camera','fa-camera-retro','fa-car','fa-caret-down','fa-caret-left','fa-caret-right','fa-caret-square-o-down','fa-caret-square-o-left','fa-caret-square-o-right','fa-caret-square-o-up','fa-caret-up','fa-certificate','fa-chain','fa-chain-broken','fa-check','fa-check-circle','fa-check-circle-o','fa-check-square','fa-check-square-o','fa-chevron-circle-down','fa-chevron-circle-left','fa-chevron-circle-right','fa-chevron-circle-up','fa-chevron-down','fa-chevron-left','fa-chevron-right','fa-chevron-up','fa-child','fa-circle','fa-circle-o','fa-circle-o-notch','fa-circle-thin','fa-clipboard','fa-clock-o','fa-cloud','fa-cloud-download','fa-cloud-upload','fa-cny','fa-code','fa-code-fork','fa-codepen','fa-coffee','fa-cog','fa-cogs','fa-columns','fa-comment','fa-comment-o','fa-comments','fa-comments-o','fa-compass','fa-compress','fa-copy','fa-credit-card','fa-crop','fa-crosshairs','fa-css3','fa-cube','fa-cubes','fa-cut','fa-cutlery','fa-dashboard','fa-database','fa-dedent','fa-delicious','fa-desktop','fa-deviantart','fa-digg','fa-dollar','fa-dot-circle-o','fa-download','fa-dribbble','fa-dropbox','fa-drupal','fa-edit','fa-eject','fa-ellipsis-h','fa-ellipsis-v','fa-empire','fa-envelope','fa-envelope-o','fa-envelope-square','fa-eraser','fa-eur','fa-euro','fa-exchange','fa-exclamation','fa-exclamation-circle','fa-exclamation-triangle','fa-expand','fa-external-link','fa-external-link-square','fa-eye','fa-eye-slash','fa-facebook','fa-facebook-square','fa-fast-backward','fa-fast-forward','fa-fax','fa-female','fa-fighter-jet','fa-file','fa-file-archive-o','fa-file-audio-o','fa-file-code-o','fa-file-excel-o','fa-file-image-o','fa-file-movie-o','fa-file-o','fa-file-pdf-o','fa-file-photo-o','fa-file-picture-o','fa-file-powerpoint-o','fa-file-sound-o','fa-file-text','fa-file-text-o','fa-file-video-o','fa-file-word-o','fa-file-zip-o','fa-files-o','fa-film','fa-filter','fa-fire','fa-fire-extinguisher','fa-flag','fa-flag-checkered','fa-flag-o','fa-flash','fa-flask','fa-flickr','fa-floppy-o','fa-folder','fa-folder-o','fa-folder-open','fa-folder-open-o','fa-font','fa-forward','fa-foursquare','fa-frown-o','fa-gamepad','fa-gavel','fa-gbp','fa-ge','fa-gear','fa-gears','fa-gift','fa-git','fa-git-square','fa-github','fa-github-alt','fa-github-square','fa-gittip','fa-glass','fa-globe','fa-google','fa-google-plus','fa-google-plus-square','fa-graduation-cap','fa-group','fa-h-square','fa-hacker-news','fa-hand-o-down','fa-hand-o-left','fa-hand-o-right','fa-hand-o-up','fa-hdd-o','fa-header','fa-headphones','fa-heart','fa-heart-o','fa-history','fa-home','fa-hospital-o','fa-html5','fa-image','fa-inbox','fa-indent','fa-info','fa-info-circle','fa-inr','fa-instagram','fa-institution','fa-italic','fa-joomla','fa-jpy','fa-jsfiddle','fa-key','fa-keyboard-o','fa-krw','fa-language','fa-laptop','fa-leaf','fa-legal','fa-lemon-o','fa-level-down','fa-level-up','fa-life-bouy','fa-life-ring','fa-life-saver','fa-lightbulb-o','fa-link','fa-linkedin','fa-linkedin-square','fa-linux','fa-list','fa-list-alt','fa-list-ol','fa-list-ul','fa-location-arrow','fa-lock','fa-long-arrow-down','fa-long-arrow-left','fa-long-arrow-right','fa-long-arrow-up','fa-magic','fa-magnet','fa-mail-forward','fa-mail-reply','fa-mail-reply-all','fa-male','fa-map-marker','fa-maxcdn','fa-medkit','fa-meh-o','fa-microphone','fa-microphone-slash','fa-minus','fa-minus-circle','fa-minus-square','fa-minus-square-o','fa-mobile','fa-mobile-phone','fa-money','fa-moon-o','fa-mortar-board','fa-music','fa-navicon','fa-openid','fa-outdent','fa-pagelines','fa-paper-plane','fa-paper-plane-o','fa-paperclip','fa-paragraph','fa-paste','fa-pause','fa-paw','fa-pencil','fa-pencil-square','fa-pencil-square-o','fa-phone','fa-phone-square','fa-photo','fa-picture-o','fa-pied-piper','fa-pied-piper-alt','fa-pinterest','fa-pinterest-square','fa-plane','fa-play','fa-play-circle','fa-play-circle-o','fa-plus','fa-plus-circle','fa-plus-square','fa-plus-square-o','fa-power-off','fa-print','fa-puzzle-piece','fa-qq','fa-qrcode','fa-question','fa-question-circle','fa-quote-left','fa-quote-right','fa-ra','fa-random','fa-rebel','fa-recycle','fa-reddit','fa-reddit-square','fa-refresh','fa-renren','fa-reorder','fa-repeat','fa-reply','fa-reply-all','fa-retweet','fa-rmb','fa-road','fa-rocket','fa-rotate-left','fa-rotate-right','fa-rouble','fa-rss','fa-rss-square','fa-rub','fa-ruble','fa-rupee','fa-save','fa-scissors','fa-search','fa-search-minus','fa-search-plus','fa-send','fa-send-o','fa-share','fa-share-alt','fa-share-alt-square','fa-share-square','fa-share-square-o','fa-shield','fa-shopping-cart','fa-sign-in','fa-sign-out','fa-signal','fa-sitemap','fa-skype','fa-slack','fa-sliders','fa-smile-o','fa-sort','fa-sort-alpha-asc','fa-sort-alpha-desc','fa-sort-amount-asc','fa-sort-amount-desc','fa-sort-asc','fa-sort-desc','fa-sort-down','fa-sort-numeric-asc','fa-sort-numeric-desc','fa-sort-up','fa-soundcloud','fa-space-shuttle','fa-spinner','fa-spoon','fa-spotify','fa-square','fa-square-o','fa-stack-exchange','fa-stack-overflow','fa-star','fa-star-half','fa-star-half-empty','fa-star-half-full','fa-star-half-o','fa-star-o','fa-steam','fa-steam-square','fa-step-backward','fa-step-forward','fa-stethoscope','fa-stop','fa-strikethrough','fa-stumbleupon','fa-stumbleupon-circle','fa-subscript','fa-suitcase','fa-sun-o','fa-superscript','fa-support','fa-table','fa-tablet','fa-tachometer','fa-tag','fa-tags','fa-tasks','fa-taxi','fa-tencent-weibo','fa-terminal','fa-text-height','fa-text-width','fa-th','fa-th-large','fa-th-list','fa-thumb-tack','fa-thumbs-down','fa-thumbs-o-down','fa-thumbs-o-up','fa-thumbs-up','fa-ticket','fa-times','fa-times-circle','fa-times-circle-o','fa-tint','fa-toggle-down','fa-toggle-left','fa-toggle-right','fa-toggle-up','fa-trash-o','fa-tree','fa-trello','fa-trophy','fa-truck','fa-try','fa-tumblr','fa-tumblr-square','fa-turkish-lira','fa-twitter','fa-twitter-square','fa-umbrella','fa-underline','fa-undo','fa-university','fa-unlink','fa-unlock','fa-unlock-alt','fa-unsorted','fa-upload','fa-usd','fa-user','fa-user-md','fa-users','fa-video-camera','fa-vimeo-square','fa-vine','fa-vk','fa-volume-down','fa-volume-off','fa-volume-up','fa-warning','fa-wechat','fa-weibo','fa-weixin','fa-wheelchair','fa-windows','fa-won','fa-wordpress','fa-wrench','fa-xing','fa-xing-square','fa-yahoo','fa-yen','fa-youtube','fa-youtube-play','fa-youtube-square');
	$output = '<div class="des_fa_block">'
	             .'<input name="'.$settings['param_name']
	             .'" class="wpb_vc_param_value wpb-textinput '
	             .$settings['param_name'].' '.$settings['type'].'_field" type="text" value="'
	             .$value.'" ' . $dependency . '/>'
	         .'</div><div class="icons-container">';
	foreach($icons as $i){
		$output .= '<i class="fa '.$i;
		if ($i == $value) $output .= ' selected';
		$output .= '" onclick="jQuery(this).closest(\'.edit_form_line\').find(\'input.des_fa_field\').val(\''.$i.'\');jQuery(this).addClass(\'selected\').siblings().removeClass(\'selected\');"/>';
	}
	$output .= '</div>';
   return $output;
}
if (function_exists('add_shortcode_param')){
	add_shortcode_param('team_cats', 'des_team_categories_settings_field');
	add_shortcode_param('partners_cats', 'des_partners_categories_settings_field');
	add_shortcode_param('testimonials_cats', 'des_testimonials_categories_settings_field');
	add_shortcode_param('des_fa', 'des_fa_settings_field');	
}
if (function_exists('vc_remove_element')){
	vc_remove_element('vc_carousel');
	vc_remove_element('vc_posts_slider');
	vc_remove_element('vc_gallery');
	vc_remove_element('vc_images_carousel');
	vc_remove_element('vc_button');
	vc_remove_element('vc_cta_button');
	vc_remove_element('vc_custom_heading');
}

class VCExtendAddonClass {
	
    function __construct() {
        // We safely integrate with VC with this hook
        add_action( 'vc_before_init', array( $this, 'des_integrateWithVC' ) );
 
        // Use this when creating a shortcode addon
        if (function_exists('add_shortcode')){
			add_shortcode( 'verticaltabs', array( $this, 'des_renderVerticalTabs' ) );
			add_shortcode( 'verticaltab', array( $this, 'des_renderVerticalTab' ) );
			add_shortcode( 'testimonials', array( $this, 'des_renderTestimonials' ) );
			add_shortcode( 'twitter_scroller', array( $this, 'des_renderTwitterScroller' ) );
			add_shortcode( 'partners', array( $this, 'des_renderPartners' ) );
			add_shortcode( 'team', array( $this, 'des_renderTeam' ) );
			add_shortcode( 'newsletter', array($this, 'des_renderNewsletter') );
			
	        // Register CSS and JS
	        //add_action( 'wp_enqueue_scripts', array( $this, 'des_loadCssAndJs' ) );   
        }
    }
 
    public function des_integrateWithVC() {
        $vs_posttypes = get_option('wpb_js_content_types');
        if (!isset($vs_posttypes)) update_option('wpb_js_content_types', array('post','page','portfolio','team'), true );
        else {
	        if (!isset($vs_posttypes) || !$vs_posttypes) {
		        $vs_posttypes = array('post','page','portfolio','team');
	        }
		    if (is_array($vs_posttypes) && !in_array('team',$vs_posttypes)){ 
				array_push($vs_posttypes, 'team');
			}
			if (is_array($vs_posttypes) && !in_array('page',$vs_posttypes)){ 
				array_push($vs_posttypes, 'page');
			}
			if (is_array($vs_posttypes) && !in_array('portfolio',$vs_posttypes)){ 
				array_push($vs_posttypes, 'portfolio');
			} 
			update_option('wpb_js_content_types', $vs_posttypes, true);
        }
        
        vc_map( array(
            "name" => __("[DESIGNARE] Newsletter", 'vc_extend'),
			"category" => 'DESIGNARE Shortcodes',
            "description" => __("Newsletter", 'vc_extend'),
            "base" => "newsletter",
            "icon" => "vc_extend_newsletter_icon", // or css class name which you can reffer in your css file later. Example: "vc_extend_my_class"
            "category" => __('DESIGNARE', 'js_composer'),
			'show_settings_on_create' => false,
			'category' => array('DESIGNARE Shortcodes',__('Content','js_composer')),
			'params' => array()
	        )
		);
        
        $tab_id_1 = time() . '-1-' . rand( 0, 100 );
        vc_map( array(
            "name" => __("[DESIGNARE] Vertical Tabs", 'vc_extend'),
            "description" => __("Awesome Vertical Tabs", 'vc_extend'),
            "base" => "verticaltabs",
            "icon" => "vc_extend_vertical_tabs_icon", // or css class name which you can reffer in your css file later. Example: "vc_extend_my_class"
            "category" => 'DESIGNARE Shortcodes',
			'show_settings_on_create' => false,
			"as_parent" => array('only' => 'verticaltab'),
            'admin_enqueue_js' => get_template_directory_uri().'/lib/des_vc_shortcodes/vertical_tabs.js', // This will load js file in the VC backend editor
            'admin_enqueue_css' => get_template_directory_uri().'/lib/des_vc_shortcodes/vertical_tabs.css', // This will load css file in the VC backend editor
			//'front_enqueue_js' => array(get_template_directory_uri().'/lib/des_vc_shortcodes/vertical_tabs.js',get_template_directory_uri().'/lib/des_vc_shortcodes/simulate.js'), // This will load js file in the VC backend editor
			//'front_enqueue_css' => get_template_directory_uri().'/lib/des_vc_shortcodes/vertical_tabs.css', // This will load css file in the VC backend editor
            'params' => array(
				array(
					'type' => 'textfield',
					'heading' => __( 'Widget title', 'js_composer' ),
					'param_name' => 'tab_title',
					'description' => __( 'Enter text which will be used as widget title. Leave blank if no title is needed.', 'js_composer' )
				),
				array(
					'type' => 'dropdown',
					'heading' => __( 'Style', 'js_composer' ),
					'param_name' => 'style',
					'value' => array( 'Icon' => 'icon', 'Text' => 'text', 'Icon + Text' => 'icontext' ),
					'std' => 'icon',
					'description' => __( 'Choose between just display an icon or icon and text.', 'js_composer' )
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Orientation', 'js_composer' ),
					'param_name' => 'orientation',
					'value' => array( 'Vertical' => 'vertical', 'Horizontal' => 'horizontal' ),
					'std' => 'vertical',
					'description' => esc_html__( 'Choose between Vertical and Horizontal orientation (it also affects the effect).', 'js_composer' )
				),
				array(
					'type' => 'textfield',
					'heading' => __( 'Extra class name', 'js_composer' ),
					'param_name' => 'el_class',
					'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' )
				)
			),
			'custom_markup' => '<div class="wpb_tabs_holder wpb_holder vc_container_for_children"><ul class="tabs_controls"></ul>%content%</div>',
			//'default_content' => '[verticaltab title="' . __( 'Tab 1', 'js_composer' ) . '" tab_id="' . $tab_id_1 . '" icon="fa-adjust"][vc_row_inner][vc_column_inner width="1/1"][/vc_column_inner][/vc_row_inner][/verticaltab][verticaltab title="' . __( 'Tab 2', 'js_composer' ) . '" tab_id="' . $tab_id_2 . '" icon="fa-adjust"][vc_row_inner][vc_column_inner width="1/1"][/vc_column_inner][/vc_row_inner][/verticaltab]',
			'default_content' => '[verticaltab title="' . __( 'Tab 1', 'js_composer' ) . '" tab_id="' . $tab_id_1 . '" icon="fa-adjust"][/verticaltab]',
			'js_view' => 'VcVerticalTabsView',
			'category' => array('DESIGNARE Shortcodes',__('Content','js_composer'))
	        )
		);
		
		vc_map( array(
			'name' => __( 'Vertical Tab', 'js_composer' ),
			"category" => 'DESIGNARE Shortcodes',
			'base' => 'verticaltab',
			"as_child" => array('only' => 'verticaltabs'),
			"as_parent" => array('only' => 'vc_row'),
			"allowed_container_element" => true,
			"is_container" => true,
			'params' => array(
				array(
					'type' => 'textfield',
					'heading' => __( 'Title', 'js_composer' ),
					'param_name' => 'title',
					'description' => __( 'Tab title.', 'js_composer' )
				),
				array(
					'type' => 'des_fa',
					'heading' => __( 'Icon', 'js_composer' ),
					'param_name' => 'icon',
					'description' => __( 'Choose an Icon', 'js_composer' )
				),
				array(
					'type' => 'textarea_html',
					'heading' => 'This tab\'s content.',
					'param_name' => 'content'
				),
				array(
					'type' => 'tab_id',
					'heading' => __( 'Tab ID', 'js_composer' ),
					'param_name' => "tab_id"
				)
			),
			'js_view' => 'VcVerticalTabView',
		) );
		
		vc_map( array(
			'name' => __( '[DESIGNARE] Testimonials', 'js_composer' ),
			"category" => 'DESIGNARE Shortcodes',
			'base' => 'testimonials',
			'is_container' => false,
			"icon" => "vc_extend_testimonials_icon", // or css class name which you can reffer in your css file later. Example: "vc_extend_my_class"
			'admin_enqueue_js' => get_template_directory_uri().'/lib/des_vc_shortcodes/testimonials.js',
			'params' => array(
				array(
					'type' => 'dropdown',
					'heading' => __('Style', 'js_composer'),
					'param_name' => 'style',
					'description' => __('Choose between Style 1 & Style 2.','js_composer'),
					'value' => array(
						__( 'Style 1', 'js_composer' ) => 'style1',
						__( 'Style 2 (with scroller)', 'js_composer' ) => 'style2'
					),
				),
				
				/*flexoptions*/
				array(
					'type' => 'dropdown',
					'heading' => __('Animation Type','js_composer'),
					'param_name' => 'des_testimonials_flex_animation',
					'description' => __('Choose between Slide and Fade effects.','js_composer'),
					'value' => array(
						__( 'Slide', 'js_composer' ) => 'slide',
						__( 'Fade', 'js_composer' ) => 'fade'
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => __( 'Slideshow?', 'js_composer' ),
					'param_name' => 'des_testimonials_flex_slideshow',
					'description' => __( 'Animate slider automatically.', 'js_composer' ),
					'value' => array( __( 'Yes, please', 'js_composer' ) => 'yes', __( 'No, thanks', 'js_composer' ) => 'no' )
				),
				array(
					'type' => 'textfield',
					'heading' => __( 'Slideshow Speed', 'js_composer' ),
					'param_name' => 'des_testimonials_flex_slideshow_speed',
					'description' => __( 'Set the speed of the slideshow cycling, in milliseconds.', 'js_composer' ),
					'value' => '3500'
				),
				array(
					'type' => 'textfield',
					'heading' => __( 'Animation Duration', 'js_composer' ),
					'param_name' => 'des_testimonials_flex_animation_duration',
					'description' => __( 'Set the speed of animations, in milliseconds.', 'js_composer' ),
					'value' => '1000'
				),
				array(
					'type' => 'dropdown',
					'heading' => __( 'Direction Navigation', 'js_composer' ),
					'param_name' => 'des_testimonials_flex_direction_nav',
					'description' => __( 'Create navigation for previous/next navigation.', 'js_composer' ),
					'value' => array( __( 'Yes, please', 'js_composer' ) => 'yes', __( 'No, thanks', 'js_composer' ) => 'no' )
				),
				array(
					'type' => 'dropdown',
					'heading' => __( 'Navigation Style', 'js_composer' ),
					'param_name' => 'des_testimonials_flex_nav_style',
					'description' => __( 'Choose between Dark and Light style.', 'js_composer' ),
					'value' => array( __( 'Dark', 'js_composer' ) => 'dark', __( 'Light', 'js_composer' ) => 'light' )
				),
				array(
					'type' => 'dropdown',
					'heading' => __( 'Control Navigation', 'js_composer' ),
					'param_name' => 'des_testimonials_flex_control_nav',
					'description' => __( 'Create navigation for paging control of each slide.', 'js_composer' ),
					'value' => array( __( 'Yes, please', 'js_composer' ) => 'yes', __( 'No, thanks', 'js_composer' ) => 'no' )
				),
				array(
					'type' => 'dropdown',
					'heading' => __( 'Pause on Hover', 'js_composer' ),
					'param_name' => 'des_testimonials_flex_pause_on_hover',
					'description' => __( 'Pause the slideshow when hovering over slider, then resume when no longer hovering.', 'js_composer' ),
					'value' => array( __( 'Yes, please', 'js_composer' ) => 'yes', __( 'No, thanks', 'js_composer' ) => 'no' )
				),
				/*endofflexoptions*/
				
				array(
					'type' => 'testimonials_cats',
					'heading' => __( 'Categories', 'js_composer' ),
					'param_name' => 'testimonials_cats',
					'description' => __( 'Choose one or more Categories', 'js_composer' )
				),
				array(
					'type' => 'textfield',
					'heading' => __( 'Number of Testimonials', 'js_composer' ),
					'param_name' => 'number',
					'description' => __( 'The number of testimonials. If set to <i><strong>0</strong></i> it will display all.', 'js_composer' )
				),
				array(
					'type' => 'checkbox',
					'heading' => __( 'Hide author?', 'js_composer' ),
					'param_name' => 'hide_author',
					'description' => __( 'If selected, the author will not be displayed.', 'js_composer' ),
					'value' => array( __( 'Yes, please', 'js_composer' ) => 'yes' )
				),
				array(
					'type' => 'checkbox',
					'heading' => __( 'Hide company?', 'js_composer' ),
					'param_name' => 'hide_company',
					'description' => __( 'If selected, the company will not be displayed.', 'js_composer' ),
					'value' => array( __( 'Yes, please', 'js_composer' ) => 'yes' )
				)
			),
			'js_view' => 'VcTestimonialsView'
		) );
		
		vc_map( array(
			'name' => __('[DESIGNARE] Twitter Scroller', 'js_composer'),
			"category" => 'DESIGNARE Shortcodes',
			'base' => 'twitter_scroller',
			'is_container' => false,
			'icon' => 'vc_extend_twitter_scroller_icon',
			'admin_enqueue_js' => get_template_directory_uri().'/lib/des_vc_shortcodes/twitter_scroller.js',
			'params' => array(
				/*flexoptions*/
				array(
					'type' => 'dropdown',
					'heading' => __('Animation Type','js_composer'),
					'param_name' => 'des_twitter_animation',
					'description' => __('Choose between Slide and Fade effects.','js_composer'),
					'value' => array(
						__( 'Slide', 'js_composer' ) => 'slide',
						__( 'Fade', 'js_composer' ) => 'fade'
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => __( 'Slideshow?', 'js_composer' ),
					'param_name' => 'des_twitter_slideshow',
					'description' => __( 'Animate slider automatically.', 'js_composer' ),
					'value' => array( __( 'Yes, please', 'js_composer' ) => 'yes', __( 'No, thanks', 'js_composer' ) => 'no' )
				),
				array(
					'type' => 'textfield',
					'heading' => __( 'Slideshow Speed', 'js_composer' ),
					'param_name' => 'des_twitter_slideshow_speed',
					'description' => __( 'Set the speed of the slideshow cycling, in milliseconds.', 'js_composer' ),
					'value' => '3500'
				),
				array(
					'type' => 'textfield',
					'heading' => __( 'Animation Duration', 'js_composer' ),
					'param_name' => 'des_twitter_animation_duration',
					'description' => __( 'Set the speed of animations, in milliseconds.', 'js_composer' ),
					'value' => '1000'
				),
				array(
					'type' => 'dropdown',
					'heading' => __( 'Direction Navigation', 'js_composer' ),
					'param_name' => 'des_twitter_direction_nav',
					'description' => __( 'Create navigation for previous/next navigation.', 'js_composer' ),
					'value' => array( __( 'Yes, please', 'js_composer' ) => 'yes', __( 'No, thanks', 'js_composer' ) => 'no' )
				),
				array(
					'type' => 'dropdown',
					'heading' => __( 'Navigation Style', 'js_composer' ),
					'param_name' => 'des_twitter_direction_nav_style',
					'description' => __( 'Choose between Dark and Light style.', 'js_composer' ),
					'value' => array( __( 'Dark', 'js_composer' ) => 'dark', __( 'Light', 'js_composer' ) => 'light' )
				),
				array(
					'type' => 'dropdown',
					'heading' => __( 'Control Navigation', 'js_composer' ),
					'param_name' => 'des_twitter_control_nav',
					'description' => __( 'Create navigation for paging control of each slide.', 'js_composer' ),
					'value' => array( __( 'Yes, please', 'js_composer' ) => 'yes', __( 'No, thanks', 'js_composer' ) => 'no' )
				),
				array(
					'type' => 'dropdown',
					'heading' => __( 'Pause on Hover', 'js_composer' ),
					'param_name' => 'des_twitter_pause_on_hover',
					'description' => __( 'Pause the slideshow when hovering over slider, then resume when no longer hovering.', 'js_composer' ),
					'value' => array( __( 'Yes, please', 'js_composer' ) => 'yes', __( 'No, thanks', 'js_composer' ) => 'no' )
				),
				/*endofflexoptions*/
			),
			'js_view' => 'VcTwitterScrollerView'
		) );
		
		vc_map( array(
			'name' => __( '[DESIGNARE] Partners', 'js_composer' ),
			'category' => 'DESIGNARE Shortcodes',
			'base' => 'partners',
			'is_container' => false,
			'icon' => 'vc_extend_partners_icon', // or css class name which you can reffer in your css file later. Example: "vc_extend_my_class"
			'admin_enqueue_js' => get_template_directory_uri().'/lib/des_vc_shortcodes/partners.js',
			'params' => array(
				array(
					'type' => 'partners_cats',
					'heading' => __( 'Categories', 'js_composer' ),
					'param_name' => 'partners_cats',
					'description' => __( 'Choose one or more Categories', 'js_composer' )
				),
				array(
					'type' => 'textfield',
					'heading' => __( 'Number of Partners', 'js_composer' ),
					'param_name' => 'number',
					'description' => __( 'The number of Partners. If set to <i><strong>0</strong></i> it will display all.', 'js_composer' )
				),
				array(
					'type' => 'dropdown',
					'heading' => __( 'Display tooltip?', 'js_composer' ),
					'param_name' => 'tooltip',
					'description' => __( 'If selected, a tooltip with the Partner\'s name will be displayed on hover.', 'js_composer' ),
					'value' => array( __( 'Yes, please', 'js_composer' ) => 'yes', __( 'No, thanks', 'js_composer' ) => 'no' )
				),
				array(
					'type' => 'dropdown',
					'heading' => __( 'Display scroller?', 'js_composer' ),
					'param_name' => 'scroller',
					'description' => __( 'If selected, the Partner\'s will be displayed with a scroller.', 'js_composer' ),
					'value' => array( __( 'Yes, please', 'js_composer' ) => 'yes', __( 'No, thanks', 'js_composer' ) => 'no' )
				),
				
				/*owlcarousel*/
				array(
					'type' => 'dropdown',
					'heading' => __( 'Auto Play?', 'js_composer' ),
					'param_name' => 'des_partners_owl_autoplay',
					'description' => __( 'Animate slider automatically.', 'js_composer' ),
					'value' => array( __( 'Yes, please', 'js_composer' ) => 'yes', __( 'No, thanks', 'js_composer' ) => 'no' )
				),
				array(
					'type' => 'textfield',
					'heading' => __( 'Animation Speed', 'js_composer' ),
					'param_name' => 'des_partners_owl_animation_speed',
					'description' => __( 'Set the speed of the slideshow cycling, in milliseconds.', 'js_composer' ),
					'value' => '3000'
				),
				array(
					'type' => 'textfield',
					'heading' => __( 'Number of Items in Desktop', 'js_composer' ),
					'param_name' => 'des_partners_owl_items_desktop',
					'description' => __( 'The number of visible items per slide in a desktop.', 'js_composer' ),
					'value' => '6'
				),
				array(
					'type' => 'textfield',
					'heading' => __( 'Number of Items in a Small Desktop', 'js_composer' ),
					'param_name' => 'des_partners_owl_items_small_desktop',
					'description' => __( 'The number of visible items per slide in a small desktop.', 'js_composer' ),
					'value' => '4'
				),
				array(
					'type' => 'textfield',
					'heading' => __( 'Number of Items in a Tablet', 'js_composer' ),
					'param_name' => 'des_partners_owl_items_tablet',
					'description' => __( 'The number of visible items per slide in a tablet.', 'js_composer' ),
					'value' => '2'
				),
				array(
					'type' => 'textfield',
					'heading' => __( 'Number of Items in Mobile', 'js_composer' ),
					'param_name' => 'des_partners_owl_items_mobile',
					'description' => __( 'The number of visible items per slide in a mobile.', 'js_composer' ),
					'value' => '1'
				),
				array(
					'type' => 'dropdown',
					'heading' => __( 'Navigation?', 'js_composer' ),
					'param_name' => 'des_partners_owl_navigation',
					'description' => __( 'Display "next" and "prev" buttons.', 'js_composer' ),
					'value' => array( __( 'Yes, please', 'js_composer' ) => 'yes', __( 'No, thanks', 'js_composer' ) => 'no' )
				),
				array(
					'type' => 'dropdown',
					'heading' => __( 'Navigation Style', 'js_composer' ),
					'param_name' => 'des_partners_owl_nav_style',
					'description' => __( 'Choose between Dark and Light style.', 'js_composer' ),
					'value' => array( __( 'Dark', 'js_composer' ) => 'dark', __( 'Light', 'js_composer' ) => 'light' )
				),
				array(
					'type' => 'dropdown',
					'heading' => __( 'Pagination?', 'js_composer' ),
					'param_name' => 'des_partners_owl_pagination',
					'description' => __( 'Show pagination.', 'js_composer' ),
					'value' => array( __( 'Yes, please', 'js_composer' ) => 'yes', __( 'No, thanks', 'js_composer' ) => 'no' )
				),
				array(
					'type' => 'dropdown',
					'heading' => __( 'Pagination Style', 'js_composer' ),
					'param_name' => 'des_partners_owl_pag_style',
					'description' => __( 'Choose between Dark and Light style.', 'js_composer' ),
					'value' => array( __( 'Dark', 'js_composer' ) => 'dark', __( 'Light', 'js_composer' ) => 'light' )
				),
				array(
					'type' => 'dropdown',
					'heading' => __( 'Pause on Hover', 'js_composer' ),
					'param_name' => 'des_partners_owl_pause_on_hover',
					'description' => __( 'Pause the slideshow when hovering over slider, then resume when no longer hovering.', 'js_composer' ),
					'value' => array( __( 'Yes, please', 'js_composer' ) => 'yes', __( 'No, thanks', 'js_composer' ) => 'no' )
				),
				array(
					'type' => 'textfield',
					'heading' => __( 'Slider Height', 'js_composer' ),
					'param_name' => 'des_partners_owl_height',
					'description' => __( 'The height of the slider in pixels.', 'js_composer' ),
					'value' => '130'
				),
				/*endofowlcarousel*/
				
				array(
					'type' => 'dropdown',
					'heading' => __( 'Number of Partners per row', 'js_composer' ),
					'param_name' => 'number_per_row',
					'description' => __( 'The number of Partners per row.', 'js_composer' ),
					'value' => array_reverse(array( '6' => '6', '4' => '4', '3' => '3', '2' => '2', '1' => '1' ))
				),
				array(
					'type' => 'textfield',
					'heading' => __( 'Row Height', 'js_composer' ),
					'param_name' => 'row_height',
					'description' => __( 'The height of each row of partners in pixels.', 'js_composer' ),
					'value' => '130'
				),
				array(
					'type' => 'dropdown',
					'heading' => __( 'Display Inner Border?', 'js_composer' ),
					'param_name' => 'innerborder',
					'value' => array( __( 'Yes, please', 'js_composer' ) => 'yes', __( 'No, thanks', 'js_composer' ) => 'no' ),
					'description' => __( 'Displays a border between the partners.', 'js_composer' ),
				),
				array(
					'type' => 'colorpicker',
					'heading' => __( 'Inner Border Color', 'js_composer' ),
					'param_name' => 'inner_border_color',
					'description' => __( 'Select a color for the border.', 'js_composer' )
				)

			),
			'js_view' => 'VcPartnersView'
		) );
		
		vc_map( array(
			'name' => __( '[DESIGNARE] Team', 'js_composer' ),
			"category" => 'DESIGNARE Shortcodes',
			'base' => 'team',
			'is_container' => false,
			"icon" => "vc_extend_team_icon", // or css class name which you can reffer in your css file later. Example: "vc_extend_my_class"
			'admin_enqueue_js' => get_template_directory_uri().'/lib/des_vc_shortcodes/team.js',
			'params' => array(
				array(
					'type' => 'team_cats',
					'heading' => __( 'Categories', 'js_composer' ),
					'param_name' => 'team_cats',
					'description' => __( 'Choose one or more Categories', 'js_composer' )
				),
				array(
					'type' => 'textfield',
					'heading' => __( 'Number of Team Members', 'js_composer' ),
					'param_name' => 'number',
					'description' => __( 'The number of Team Members. If set to <i><strong>0</strong></i> it will display all.', 'js_composer' )
				),
				array(
					'type' => 'dropdown',
					'heading' => __( 'Display tooltip?', 'js_composer' ),
					'param_name' => 'tooltip',
					'description' => __( 'If selected, a tooltip with the Team Member\'s name will be displayed on hover.', 'js_composer' ),
					'value' => array( __( 'Yes, please', 'js_composer' ) => 'yes', __( 'No, thanks', 'js_composer' ) => 'no' )
				),
				array(
					'type' => 'dropdown',
					'heading' => __( 'Display scroller?', 'js_composer' ),
					'param_name' => 'scroller',
					'description' => __( 'If selected, the Team Member\'s will be displayed with a scroller.', 'js_composer' ),
					'value' => array( __( 'Yes, please', 'js_composer' ) => 'yes', __( 'No, thanks', 'js_composer' ) => 'no' )
				),
				
				/*owlcarousel*/
				array(
					'type' => 'dropdown',
					'heading' => __( 'Auto Play?', 'js_composer' ),
					'param_name' => 'des_team_owl_autoplay',
					'description' => __( 'Animate slider automatically.', 'js_composer' ),
					'value' => array( __( 'Yes, please', 'js_composer' ) => 'yes', __( 'No, thanks', 'js_composer' ) => 'no' )
				),
				array(
					'type' => 'textfield',
					'heading' => __( 'Animation Speed', 'js_composer' ),
					'param_name' => 'des_team_owl_animation_speed',
					'description' => __( 'Set the speed of the slideshow cycling, in milliseconds.', 'js_composer' ),
					'value' => '3000'
				),
				array(
					'type' => 'textfield',
					'heading' => __( 'Number of Items in Desktop', 'js_composer' ),
					'param_name' => 'des_team_owl_items_desktop',
					'description' => __( 'The number of visible items per slide in a desktop.', 'js_composer' ),
					'value' => '6'
				),
				array(
					'type' => 'textfield',
					'heading' => __( 'Number of Items in a Small Desktop', 'js_composer' ),
					'param_name' => 'des_team_owl_items_small_desktop',
					'description' => __( 'The number of visible items per slide in a small desktop.', 'js_composer' ),
					'value' => '4'
				),
				array(
					'type' => 'textfield',
					'heading' => __( 'Number of Items in a Tablet', 'js_composer' ),
					'param_name' => 'des_team_owl_items_tablet',
					'description' => __( 'The number of visible items per slide in a tablet.', 'js_composer' ),
					'value' => '2'
				),
				array(
					'type' => 'textfield',
					'heading' => __( 'Number of Items in Mobile', 'js_composer' ),
					'param_name' => 'des_team_owl_items_mobile',
					'description' => __( 'The number of visible items per slide in a mobile.', 'js_composer' ),
					'value' => '1'
				),
				array(
					'type' => 'dropdown',
					'heading' => __( 'Navigation?', 'js_composer' ),
					'param_name' => 'des_team_owl_navigation',
					'description' => __( 'Display "next" and "prev" buttons.', 'js_composer' ),
					'value' => array( __( 'Yes, please', 'js_composer' ) => 'yes', __( 'No, thanks', 'js_composer' ) => 'no' )
				),
				array(
					'type' => 'dropdown',
					'heading' => __( 'Navigation Style', 'js_composer' ),
					'param_name' => 'des_team_owl_nav_style',
					'description' => __( 'Choose between Dark and Light style.', 'js_composer' ),
					'value' => array( __( 'Dark', 'js_composer' ) => 'dark', __( 'Light', 'js_composer' ) => 'light' )
				),
				array(
					'type' => 'dropdown',
					'heading' => __( 'Pagination?', 'js_composer' ),
					'param_name' => 'des_team_owl_pagination',
					'description' => __( 'Show pagination.', 'js_composer' ),
					'value' => array( __( 'Yes, please', 'js_composer' ) => 'yes', __( 'No, thanks', 'js_composer' ) => 'no' )
				),
				array(
					'type' => 'dropdown',
					'heading' => __( 'Pagination Style', 'js_composer' ),
					'param_name' => 'des_team_owl_pag_style',
					'description' => __( 'Choose between Dark and Light style.', 'js_composer' ),
					'value' => array( __( 'Dark', 'js_composer' ) => 'dark', __( 'Light', 'js_composer' ) => 'light' )
				),
				array(
					'type' => 'dropdown',
					'heading' => __( 'Pause on Hover', 'js_composer' ),
					'param_name' => 'des_team_owl_pause_on_hover',
					'description' => __( 'Pause the slideshow when hovering over slider, then resume when no longer hovering.', 'js_composer' ),
					'value' => array( __( 'Yes, please', 'js_composer' ) => 'yes', __( 'No, thanks', 'js_composer' ) => 'no' )
				),
				array(
					'type' => 'textfield',
					'heading' => __( 'Slider Height', 'js_composer' ),
					'param_name' => 'des_team_owl_height',
					'description' => __( 'The height of the slider in pixels.', 'js_composer' ),
					'value' => '350'
				),
				/*endofowlcarousel*/
				
				array(
					'type' => 'dropdown',
					'heading' => __( 'Number of Team Members per row', 'js_composer' ),
					'param_name' => 'number_per_row',
					'description' => __( 'The number of Partners per row.', 'js_composer' ),
					'value' => array( '6' => '6', '4' => '4', '3' => '3', '2' => '2', '1' => '1' )
				),
				array(
					'type' => 'textfield',
					'heading' => __( 'Row Height on Desktops', 'js_composer' ),
					'param_name' => 'row_height',
					'description' => __( 'The height of each row of partners in pixels.', 'js_composer' ),
					'value' => '350'
				),
				array(
					'type' => 'textfield',
					'heading' => __( 'Row Height on Tablets', 'js_composer' ),
					'param_name' => 'row_height_tablets',
					'description' => __( 'The height of each row of partners in pixels.', 'js_composer' ),
					'value' => '230'
				),
				array(
					'type' => 'textfield',
					'heading' => __( 'Row Height on Mobiles', 'js_composer' ),
					'param_name' => 'row_height_mobiles',
					'description' => __( 'The height of each row of partners in pixels.', 'js_composer' ),
					'value' => '170'
				)
			),
			'js_view' => 'VcTeamView'
		) );
    }
    
    /*
    Shortcode logic how it should be rendered
    */
    
    public function des_renderNewsletter( $atts, $content = null ){
		$code = str_replace('&', '&amp;', get_option(DESIGNARE_SHORTNAME."_mailchimp_code"));
		if (!empty($code)){
		    $output = '<div class="newsletter_shortcode"><div class="mail-box"><div class="mail-news"><div class="news-l"><div class="banner"><h3>'.get_option(DESIGNARE_SHORTNAME."_newsletter_text").'</h3><p>'.get_option(DESIGNARE_SHORTNAME."_newsletter_stext").'</p></div><div class="form">';
			$output .= stripslashes($code);
			$output .= '</div></div></div></div></div>';			
		} else {
			$output = '<div class="newsletter_shortcode">'.__('You need to fill the inputs on the <strong>Appearance > Yunik Options > Newsletter</strong> panel in order to work.','yunik').'</div>';
		}
	    return $output;
    }
    
	public function des_renderTeam( $atts, $content = null ) {	
	  extract( shortcode_atts( array(
		 'team_cats' => -1,
	  	 'number' => -1,
		 'tooltip' => 'yes',
		 'scroller' => 'yes',
		 'des_team_owl_autoplay' => 'yes',
		 'des_team_owl_animation_speed' => 3000,
		 'des_team_owl_items_desktop' => 6,
		 'des_team_owl_items_small_desktop' => 4,
		 'des_team_owl_items_tablet' => 2,
		 'des_team_owl_items_mobile' => 1,
		 'des_team_owl_navigation' => 'yes',
		 'des_team_owl_pagination' => 'yes',
		 'des_team_owl_pause_on_hover' => 'yes',
		 'number_per_row' => 6,
		 'row_height' => 350,
		 'row_height_tablets' => 230,
		 'row_height_mobiles' => 170,
		 'des_team_owl_height' => 350,
		 'des_team_owl_nav_style' => 'dark',
		 'des_team_owl_pag_style' => 'dark'
	  ), $atts ) );
	
      $content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content

	  static $des_team_index = 1;
	  $des_team_index_aux = 1;

	  $output = "";
	  if ($team_cats == "0" || $team_cats == -1 || $team_cats == "") {
		  $args = array(
			'posts_per_page' => $number,
		  	'post_type' => 'team'
		  );
		  $team = get_posts($args);
	  } else {
		  $team_cats = explode(",",$team_cats);
		  $args = array(
			'posts_per_page' => $number,
		  	'post_type' => 'team',
		  	'tax_query' => array(
		        array(
		            'taxonomy' => 'team_category',
		            'field'    => 'term_id',
		            'terms'    => $team_cats
		        ),
		    )
	   	  );
	   	  $team = get_posts($args);
	  }
	
	  if ($scroller == "no"){
			$output .= '<div id="des-team-'.$des_team_index.'" class="row team text-center noscroller '; 
			if ($tooltip == 'yes') $output .= "withtooltip";
			$output .= '">';
			foreach ($team as $t){
				$output .= '<div class="col-xs-'.(12/intval($number_per_row,10)).' col-sm-'.(12/intval($number_per_row,10)).'" style="height: '.intval($row_height,10).'px;"><a style="display:inline-block;overflow:hidden;max-height:100%;" data-toggle="modal" href="#member'.$des_team_index.'-'.$des_team_index_aux.'" class="modal-popup-link team-profile profile-id-'.$t->ID.'"><img src="'; 
				$image = wp_get_attachment_image_src( get_post_thumbnail_id( $t->ID ), 'single-post-thumbnail' );
				$output .= $image[0];
				$output .= '" alt="'.$t->post_title.'" class="animated fadeInUp" style="opacity: 1;" /><div class="tooltip-desc"><div class="tooltip-content"><p><b>'.$t->post_title.'</b></p></div></div></a></div>';
				$des_team_index_aux++;
			}
			$output .= '</div>';
			$des_team_index_aux = 1;
			foreach ($team as $t){
				$output .= '<div id="member'.$des_team_index.'-'.$des_team_index_aux.'" class="modal team_member_profile_content"><div class="container">'.do_shortcode($t->post_content).'<a href="#" class="close" data-dismiss="modal">x</a></div></div>';
				$des_team_index_aux++;
			}
			$output .= '<style>@media only screen and (min-width: 768px) and (max-width: 959px) {#des-team-'.$des_team_index.' > div{height:'.intval($row_height_tablets,10).'px !important;}}@media only screen and (max-width: 767px) {#des-team-'.$des_team_index.' > div{height:'.intval($row_height_mobiles,10).'px !important;}}</style>';
	  } else {
			$output .= '<div id="des-team-'.$des_team_index.'" class="row team text-center withscroller'; 
			if ($tooltip == 'yes') $output .= " withtooltip";
			$output .= '" rel="'.$des_team_owl_autoplay.'|'.$des_team_owl_animation_speed.'|'.$des_team_owl_items_desktop.'|'.$des_team_owl_items_small_desktop.'|'.$des_team_owl_items_tablet.'|'.$des_team_owl_items_mobile.'|'.$des_team_owl_navigation.'|'.$des_team_owl_pagination.'|'.$des_team_owl_pause_on_hover.'|'.$des_team_owl_nav_style.'|'.$des_team_owl_pag_style.'">';
			foreach ($team as $t){
				$output .= '<a data-toggle="modal" href="#member'.$des_team_index.'-'.$des_team_index_aux.'" class="modal-popup-link team-profile profile-id-'.$t->ID.'"><img src="'; 
				$image = wp_get_attachment_image_src( get_post_thumbnail_id( $t->ID ), 'single-post-thumbnail' );
				$output .= $image[0];
				$output .= '" alt="'.$t->post_title.'" class="animated fadeInUp" style="opacity: 1;" /><div class="tooltip-desc"><div class="tooltip-content"><p><b>'.$t->post_title.'</b></p></div></div></a>';
				$des_team_index_aux++;
			}
			$output .= '</div>';
			
			$output .= "<script type=\"text/javascript\">
			jQuery(window).load(function(){
			    var who = jQuery('#des-team-".$des_team_index."');
			   
			    var owlopts = who.attr('rel').split('|');
				if (owlopts[0] == 'yes') owlopts[0] = parseInt(owlopts[1],10); else owlopts[0] = false;
				if (owlopts[6] == 'yes') {
					owlopts[6] = true;
					who.addClass('nav-'+owlopts[9]);
				} else owlopts[6] = false;
				if (owlopts[7] == 'yes') {
					owlopts[7] = true; 
					who.addClass('controlnav-'+owlopts[10]);
				} else owlopts[7] = false;
				if (owlopts[8] == 'yes') owlopts[8] = true; else owlopts[8] = false;
				who.slick({
					dots: owlopts[7], 
					autoplay: owlopts[0], 
					autoplaySpeed:5000, speed:600, infinite: true,
					arrows: owlopts[6],
					adaptiveHeight:true,
					nextArrow:'<button type=\"button\" style=\"color:#333333; font-size:24px;\" class=\"slick-next default\"><i class=\"ultsl-arrow-right6\"></i></button>',
					prevArrow:'<button type=\"button\" style=\"color:#333333; font-size:24px;\" class=\"slick-prev default\"><i class=\"ultsl-arrow-left6\"></i></button>',
					swipe:true,
					draggable:true,
					touchMove:true,
					slidesToScroll: parseInt(owlopts[2],10),
					slidesToShow: parseInt(owlopts[2],10),
					responsive:[{
						breakpoint: 1024,
						settings:{
							slidesToShow: parseInt(owlopts[3],10),
							slidesToScroll: parseInt(owlopts[3],10)
						}
					},{
						breakpoint: 768,
						settings:{
							slidesToShow: parseInt(owlopts[4],10),
							slidesToScroll: parseInt(owlopts[4],10)
						}
					},{
						breakpoint: 480,
						settings:{
							slidesToShow: parseInt(owlopts[5],10),
							slidesToScroll: parseInt(owlopts[5],10)
						}
					}],
					pauseOnHover:true,
					pauseOnDotsHover:true,
					customPaging:function(slider,i){
						return'<i type=\"button\" style=\"color:#333333;\" class=\"ultsl-record\" data-role=\"none\"></i>';
					}
				});
				   
			});
			</script>";
						
			$des_team_index_aux = 1;
			foreach ($team as $t){
				$output .= '<div id="member'.$des_team_index.'-'.$des_team_index_aux.'" class="modal team_member_profile_content"><div class="container">'.do_shortcode($t->post_content).'<a href="#" class="close" data-dismiss="modal">x</a></div></div>';
				$des_team_index_aux++;
			}
	  }
	    	
      wp_reset_query();

	  $des_team_index++;
      return $output;
	}

	public function des_renderPartners( $atts, $content = null ) {
		
	  extract( shortcode_atts( array(
		 'partners_cats' => -1,
	  	 'number' => -1,
		 'tooltip' => 'yes',
		 'scroller' => 'yes',
		 'des_partners_owl_autoplay' => 'yes',
		 'des_partners_owl_animation_speed' => 3000,
		 'des_partners_owl_items_desktop' => 6,
		 'des_partners_owl_items_small_desktop' => 4,
		 'des_partners_owl_items_tablet' => 2,
		 'des_partners_owl_items_mobile' => 1,
		 'des_partners_owl_navigation' => 'yes',
		 'des_partners_owl_nav_style' => 'dark',
		 'des_partners_owl_pagination' => 'yes',
		 'des_partners_owl_pag_style' => 'dark',
		 'des_partners_owl_pause_on_hover' => 'yes',
		 'number_per_row' => 6,
		 'row_height' => 130,
		 'des_partners_owl_height' => 130,
		 'innerborder' => 'yes',
		 'inner_border_color' => '#EDEDED'
	  ), $atts ) );
	
      $content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content

	  static $des_partners_index = 1;

	  $output = "";  
	  
	  if ($partners_cats == "0" || $partners_cats == -1 || $partners_cats == "") {
		  $args = array(
			'posts_per_page' => $number,
		  	'post_type' => 'partners'
		  );
		  $partners = get_posts($args);
	  } else {
		  $partners_cats = explode(",",$partners_cats);
		  $args = array(
			'posts_per_page' => $number,
		  	'post_type' => 'partners',
		  	'tax_query' => array(
		        array(
		            'taxonomy' => 'partners_category',
		            'field'    => 'term_id',
		            'terms'    => $partners_cats
		        ),
		    )
	   	  );
	   	  $partners = get_posts($args);
	  }

	  if ($scroller == "no"){
			$output .= '<div id="partners-'.$des_partners_index.'" class="partners-container noscroller'; 
			if ($tooltip == 'yes') $output .= " withtooltip";
			if ($innerborder == 'yes') $output .= " innerborder innerbordercolor-{$inner_border_color}";
			$output .= '">';
			foreach ($partners as $p){
				$output .= '<div class="partner-item col-md-'.(12/intval($number_per_row,10)).'" style="height: '.intval($row_height,10).'px;line-height: '.intval($row_height,10).'px;"><a target="_blank" href="'.get_post_meta($p->ID,'link_value', true).'" ';
				if ($tooltip == "yes") $output .= ' data-toggle="tooltip" data-placement="top" title="'.$p->post_title.'"';
				$output .= '><img title="'.$p->post_title.'" src="';
				$image = wp_get_attachment_image_src( get_post_thumbnail_id( $p->ID ), 'single-post-thumbnail' );
				$output .= $image[0].'" />';
				$output .= '</a></div>';
			}
			$output .= '</div>';
			$output .= "<script type=\"text/javascript\">
					jQuery(document).ready(function(){ jQuery('#partners-".$des_partners_index.".withtooltip .partner-item a, #partners-".$des_partners_index.".withtooltip .carousel-item a').tooltip(); });
					</script>";
	  } else {
			$output .= '<div id="logos-carousel-'.$des_partners_index.'" class="partners-container owl-carousel light-text'; 
			if ($tooltip == 'yes') $output .= ' withtooltip"'; else $output .= '"';
			$output .= 'rel="'.$des_partners_owl_autoplay.'|'.$des_partners_owl_animation_speed.'|'.$des_partners_owl_items_desktop.'|'.$des_partners_owl_items_small_desktop.'|'.$des_partners_owl_items_tablet.'|'.$des_partners_owl_items_mobile.'|'.$des_partners_owl_navigation.'|'.$des_partners_owl_pagination.'|'.$des_partners_owl_pause_on_hover.'|'.$des_partners_owl_nav_style.'|'.$des_partners_owl_pag_style.'">';
			foreach ($partners as $p){
				$output .= '<div class="carousel-item" style="height:'.intval($des_partners_owl_height,10).'px;line-height:'.intval($des_partners_owl_height,10).'px;"><a target="_blank" href="'.get_post_meta($p->ID, 'link_value', true).'" class="c-adj"'; 
				if ($tooltip == "yes") $output .= ' data-toggle="tooltip" data-placement="top" title="'.$p->post_title.'"';
				$output .= '><img alt="'.$p->post_title.'" src="';
				$image = wp_get_attachment_image_src( get_post_thumbnail_id( $p->ID ), 'single-post-thumbnail' );
				$output .= $image[0];
				$output .= '"></a></div>';
			}
			$output .= '</div>';
			
			$output .= "
			<script type=\"text/javascript\">
			jQuery(window).load(function(){ 
				var who = jQuery('#logos-carousel-".$des_partners_index."');
				var owlopts = who.attr('rel').split('|');
				if (owlopts[0] == 'yes') owlopts[0] = parseInt(owlopts[1],10); else owlopts[0] = false;
				if (owlopts[6] == 'yes') {
					owlopts[6] = true; 
					who.addClass('nav-'+owlopts[9]);
				} else owlopts[6] = false;
				if (owlopts[7] == 'yes') {
					owlopts[7] = true;
					who.addClass('controlnav-'+owlopts[10]);
				} else owlopts[7] = false;
				if (owlopts[8] == 'yes') owlopts[8] = true; else owlopts[8] = false;
				who.slick({
					dots: owlopts[7], 
					autoplay: owlopts[0], 
					autoplaySpeed:5000, speed:600, infinite: true,
					arrows: owlopts[6],
					adaptiveHeight:true,
					nextArrow:'<button type=\"button\" style=\"color:#333333; font-size:24px;\" class=\"slick-next default\"><i class=\"ultsl-arrow-right6\"></i></button>',
					prevArrow:'<button type=\"button\" style=\"color:#333333; font-size:24px;\" class=\"slick-prev default\"><i class=\"ultsl-arrow-left6\"></i></button>',
					swipe:true,
					draggable:true,
					touchMove:true,
					slidesToScroll: parseInt(owlopts[2],10),
					slidesToShow: parseInt(owlopts[2],10),
					responsive:[{
						breakpoint: 1024,
						settings:{
							slidesToShow: parseInt(owlopts[3],10),
							slidesToScroll: parseInt(owlopts[3],10)
						}
					},{
						breakpoint: 768,
						settings:{
							slidesToShow: parseInt(owlopts[4],10),
							slidesToScroll: parseInt(owlopts[4],10)
						}
					},{
						breakpoint: 480,
						settings:{
							slidesToShow: parseInt(owlopts[5],10),
							slidesToScroll: parseInt(owlopts[5],10)
						}
					}],
					pauseOnHover:true,
					pauseOnDotsHover:true,
					customPaging:function(slider,i){
						return'<i type=\"button\" style=\"color:#333333;\" class=\"ultsl-record\" data-role=\"none\"></i>';
					}
				});
				
				";
			if ($tooltip == "yes") $output .= "who.find('.partner-item, .carousel-item').css('margin-top','10px').find('a').tooltip(); ";
			$output .= "
			});
			</script>";
			
	  }
	  
      wp_reset_query();

	  $des_partners_index++;
      return $output;
	}

	public function des_renderTwitterScroller ( $atts, $content = null ){
		extract( shortcode_atts( array(
			 'des_twitter_animation' => 'slide',
			 'des_twitter_direction' => 'horizontal',
			 'des_twitter_slideshow' => 'yes',
			 'des_twitter_slideshow_speed' => '3500',
			 'des_twitter_animation_duration' => '1000',
			 'des_twitter_direction_nav' => 'yes',
			 'des_twitter_control_nav' => 'yes',
			 'des_twitter_pause_on_hover' => 'yes',
			 'des_twitter_direction_nav_style' => 'dark',
		), $atts ) );
	    $content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content

		static $des_twitter_index = 1;
		$output = "";
		
		$errors = false;
		$username = get_option(DESIGNARE_SHORTNAME.'_twitter_username');
		if (empty($username)) $errors .= 'Twitter Username';
		$consumerkey = trim(get_option('twitter_consumer_key'));
		if (empty($consumerkey)){
			if ($errors) $errors .= ', ';
			$errors .= 'Twitter App Consumer Key';
		}
		$consumersecret = trim(get_option('twitter_consumer_secret'));
		if (empty($consumersecret)){
			if ($errors) $errors .= ', ';
			$errors .= 'Twitter App Consumer Secret';
		}
		$usertoken = trim(get_option('twitter_user_token'));
		if (empty($usertoken)){
			if ($errors) $errors .= ', ';
			$errors .= 'Twitter App User Token';
		}
		$usersecret = trim(get_option('twitter_user_secret'));
		if (empty($usersecret)){
			if ($errors) $errors .= ', ';
			$errors .= 'Twitter App Access Token Secret';
		}
		$tweetcount = get_option('yunik_twitter_number_tweets');
		if (empty($tweetcount)) $tweetcount = 0;
		
		if ($errors){
			$output = '<div class="twitter_warning">'.__('You need to fill the following Twitter related fields in the Admin Panel > Yunik Options > Twitter and Social Icons > Twitter. ','yunik').'<br/>'.$errors.'</div>';
		} else {
			$output = '<div id="des-twitter-'.$des_twitter_index.'" class="twitter-container style-'.$des_twitter_direction_nav_style.'" rel="'.$username.'|'.$tweetcount.'"><div class="icon-author animated flipInX"><div class="bird"><i class="fa fa-twitter"></i></div><p class="twitter-author"><a href="http://twitter.com/'.$username.'" target="_blank"><b>'.__(get_option(DESIGNARE_SHORTNAME."_twitter_follow_us"),'yunik').'</b></a></p></div><div class="twitter-slider"><div id="twitter-feed"></div></div></div>';
		}
		
		$output .= "<script type=\"text/javascript\">
		jQuery(document).ready(function(){
			var who = jQuery('#des-twitter-".$des_twitter_index."');
			if (typeof vc !== 'undefined') who = jQuery(vc.".'$frame_body'.").find('#des-twitter-".$des_twitter_index."');

			who.find('#twitter-feed').destweet({
				username: \"".$username."\",
				join_text: '".__(get_option(DESIGNARE_SHORTNAME."_twitter_pre_tweet"), "yunik")."',
				avatar_size: 0,
				count: ".$tweetcount."
			});
			
			who.find('#twitter-feed').find('ul').addClass('slides');
			who.find('#twitter-feed').find('ul li').addClass('slide');
			//who.find('#twitter-feed').contents().wrapAll('<div class=\"tweets-feed\">');
			
			var flexopts = [\"".$des_twitter_animation."\",\"".$des_twitter_direction."\",\"".$des_twitter_slideshow."\",\"".$des_twitter_slideshow_speed."\",\"".$des_twitter_animation_duration."\",\"".$des_twitter_direction_nav."\",\"".$des_twitter_control_nav."\",\"".$des_twitter_pause_on_hover."\",\"".$des_twitter_direction_nav_style."\"];

			if (flexopts[2] == 'yes') flexopts[2] = true; else flexopts[2] = false;
			if (flexopts[5] == 'yes'){ 
				flexopts[5] = true; 
			} else flexopts[5] = false;
			if (flexopts[6] == 'yes') {
				flexopts[6] = true;
			} else flexopts[6] = false;
			if (flexopts[7] == 'yes') flexopts[7] = true; else flexopts[7] = false;
			if (flexopts[0] == 'fade') flexopts[0] = true; else flexopts[0] = false;

			who.find('.tweet_list').slick({
				fade: flexopts[0],
				dots: flexopts[6], 
				autoplay: flexopts[2], 
				autoplaySpeed:flexopts[3], speed:flexopts[4], infinite: true,
				arrows: flexopts[5],
				adaptiveHeight:true,
				nextArrow:'<button type=\"button\" style=\"color:#333333; font-size:24px;\" class=\"slick-next default\"><i class=\"ultsl-arrow-right6\"></i></button>',
				prevArrow:'<button type=\"button\" style=\"color:#333333; font-size:24px;\" class=\"slick-prev default\"><i class=\"ultsl-arrow-left6\"></i></button>',
				swipe:true,
				draggable:true,
				touchMove:true,
				slidesToScroll: 1,
				slidesToShow: 1,
				pauseOnHover:flexopts[7],
				pauseOnDotsHover:flexopts[7],
				customPaging:function(slider,i){
					return'<i type=\"button\" style=\"color:#333333;\" class=\"ultsl-record\" data-role=\"none\"></i>';
				}
			});

		});
		</script>";
		
		$des_twitter_index++;
		return $output;
	}

    public function des_renderTestimonials( $atts, $content = null ) {	
	    
	  extract( shortcode_atts( array(
		 'style' => 'style1',
		 'testimonials_cats' => -1,
	  	 'number' => -1,
		 'hide_author' => 'no',
		 'hide_company' => 'no',
		 'des_testimonials_flex_animation' => 'slide',
		 'des_testimonials_flex_direction' => 'horizontal',
		 'des_testimonials_flex_slideshow' => 'yes',
		 'des_testimonials_flex_slideshow_speed' => '3500',
		 'des_testimonials_flex_animation_duration' => '1000',
		 'des_testimonials_flex_direction_nav' => 'yes',
		 'des_testimonials_flex_control_nav' => 'yes',
		 'des_testimonials_flex_pause_on_hover' => 'yes',
		 'des_testimonials_flex_nav_style' => 'dark'
	  ), $atts ) );
      $content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content

	  static $des_testimonials_index = 1;
	  $des_single_testimonial_index = 1;
	  $output = "";
	  
	  if ($testimonials_cats == "0" || $testimonials_cats == -1 || $testimonials_cats == "") {
		  $args = array(
			'posts_per_page' => $number,
		  	'post_type' => 'testimonials'
		  );
		  $testimonials = get_posts($args);
	  } else {
		  $testimonials_cats = explode(",",$testimonials_cats);
		  $args = array(
			'posts_per_page' => $number,
		  	'post_type' => 'testimonials',
		  	'tax_query' => array(
		        array(
		            'taxonomy' => 'testimonials_category',
		            'field'    => 'term_id',
		            'terms'    => $testimonials_cats
		        ),
		    )
	   	  );
	   	  $testimonials = get_posts($args);
	  }
	  
	  if ($style === "style1"){
		  $output .= '<div id="testimonials-container-'.$des_testimonials_index.'" class="container testimonials '.$style.'"><div class="testimonial-box"><ul class="testimonial-nav">'; 

	      foreach ($testimonials as $t){
			$output .= '<li><a href="#testimonial-'.$des_single_testimonial_index.'"><img alt="'.get_the_title( $t->ID ).'" src="'; 
			$image = wp_get_attachment_image_src( get_post_thumbnail_id( $t->ID ), 'single-post-thumbnail' );
			$output .= $image[0];
			$output .= '" /></a></li>';
			$des_single_testimonial_index++;
		  }

		  $output .= '</ul></div>';
		  $des_single_testimonial_index = 1;

		  $output .= '<div class="testimonials-content">';
		  foreach ($testimonials as $t){
			  	$active = ($des_single_testimonial_index == 1) ? " active" : "";
				$output .= '<div class="testimonial'.$active.'" id="testimonial-'.$des_single_testimonial_index.'">'.$t->post_content;
				if ($hide_author === "no" && $hide_company === "no" || get_post_meta($t->ID,'author_value', true) != '' && get_post_meta($t->ID,'company_value', true) != '') { $output .= '<span>'; }
					if (get_post_meta($t->ID,'author_value', true) != ''){
						if (get_post_meta($t->ID,'author_link_value', true) != ''){ $output .= '<a href="'.get_post_meta($t->ID,'author_link_value', true).'">'; }
						$output .= get_post_meta($t->ID,'author_value', true);
						if (get_post_meta($t->ID,'author_link_value', true) != ''){ $output .= '</a>'; }
					}
					if (get_post_meta($t->ID,'author_value', true) != '' && get_post_meta($t->ID,'company_value', true) != '') $output .= ' / ';
					if (get_post_meta($t->ID,'company_value', true) != ''){
						if (get_post_meta($t->ID,'company_link_value', true) != ''){ $output .= '<a href="'.get_post_meta($t->ID,'company_link_value', true).'">'; }
						$output .= get_post_meta($t->ID,'company_value', true);
						if (get_post_meta($t->ID,'company_link_value', true) != ''){ $output .= '</a>'; }
					}
				if ($hide_author === "no" && $hide_company === "no" || get_post_meta($t->ID,'author_value', true) != '' && get_post_meta($t->ID,'company_value', true) != '') { $output .= '</span>'; }
				$output .= '</div>';
			    $des_single_testimonial_index++;
		  }
		  $output .= '</div>'; // end of testimonials-content

		  $output .= '</div>'; //end of #testimonials
		  
		  $output .= "
		  <script type=\"text/javascript\">
		  jQuery(document).ready(function(){
				var who = jQuery('#testimonials-container-".$des_testimonials_index."');
				who.find('.testimonials-content').height( who.find('.testimonials-content .testimonial.active > p').height() + who.find('.testimonials-content .testimonial.active > span').height() +40 );
				who.find('.testimonial-nav a').on('click', function(e){
					e.preventDefault();
				});
				who.find('.testimonial-nav a').on('hover', function(){
					who.find('.testimonial-nav a').removeClass('active');
					who.find('.testimonial.active').removeClass('active');
					who.find(jQuery(this).attr('href')).addClass('active');
					who.find('.testimonials-content').height( who.find('.testimonials-content .testimonial.active > p').height() + who.find('.testimonials-content .testimonial.active > span').height() +40 );
				});
		  });
		  </script>";		  
	  } else {
	
		$output .= '<div id="testimonials-slider-'.$des_testimonials_index.'" class="testimonials-style2 style-'.$des_testimonials_flex_nav_style.'"><ul class="slides styled-list">';
		
		foreach ($testimonials as $t){
			$output .= '<li class="testimonials-slide"><div class="testimonials-slide-content container">';
			
			$image = wp_get_attachment_image_src( get_post_thumbnail_id( $t->ID ), 'single-post-thumbnail' );
			if ($image[0] != ""){
				$output .= '<div class="img-container"><img title="'.get_post_meta($t->ID,'author_value', true).'" src="'.$image[0].'" alt="'.get_post_meta($t->ID,'author_value', true).'"></div>';
			}
			$output .= '<div class="text-container">';
			if ($hide_author === "no" && $hide_company === "no" || get_post_meta($t->ID,'author_value', true) != '' && get_post_meta($t->ID,'company_value', true) != '') { $output .= '<span class="t-author">'; }
				if (get_post_meta($t->ID,'author_value', true) != ''){
					if (get_post_meta($t->ID,'author_link_value', true) != ''){ $output .= '<a href="'.get_post_meta($t->ID,'author_link_value', true).'">'; }
					$output .= get_post_meta($t->ID,'author_value', true);
					if (get_post_meta($t->ID,'author_link_value', true) != ''){ $output .= '</a>'; }
				}
				if (get_post_meta($t->ID,'author_value', true) != '' && get_post_meta($t->ID,'company_value', true) != '') $output .= ', ';
				if (get_post_meta($t->ID,'company_value', true) != ''){
					if (get_post_meta($t->ID,'company_link_value', true) != ''){ $output .= '<a href="'.get_post_meta($t->ID,'company_link_value', true).'">'; }
					$output .= get_post_meta($t->ID,'company_value', true);
					if (get_post_meta($t->ID,'company_link_value', true) != ''){ $output .= '</a>'; }
				}
			if ($hide_author === "no" && $hide_company === "no" || get_post_meta($t->ID,'author_value', true) != '' && get_post_meta($t->ID,'company_value', true) != '') { $output .= '</span>'; }
			$output .= '<span class="testimonials_text_content">';
			$output .= $t->post_content;
			$output .= '</span>';
			$output .= '</div></div></li>';
		}
		$output .= '</ul></div>'; // end of #testimonials
		
		$output .= "
		<script type=\"text/javascript\">
		  jQuery(document).ready(function(){
				var who = jQuery('#testimonials-slider-".$des_testimonials_index." ul.slides');
				
				var opts = ['".$des_testimonials_flex_animation."','".$des_testimonials_flex_direction."','".$des_testimonials_flex_slideshow."','".$des_testimonials_flex_slideshow_speed."','".$des_testimonials_flex_animation_duration."','".$des_testimonials_flex_direction_nav."','".$des_testimonials_flex_control_nav."','".$des_testimonials_flex_pause_on_hover."','".$des_testimonials_flex_nav_style."'];
				
				if (opts[2] == 'yes') opts[2] = true; else opts[2] = false;
				if (opts[5] == 'yes') {
					opts[5] = true;
				} else opts[5] = false;
				if (opts[6] == 'yes') {
					opts[6] = true;
				} else opts[6] = false;
				if (opts[7] == 'yes') opts[7] = true; else opts[7] = false;				
				if (opts[0] == 'fade') opts[0] = true; else opts[0] = false;
				
				who.slick({
					fade: opts[0],
					dots: opts[6], 
					autoplay: opts[2], 
					autoplaySpeed:opts[3], speed:opts[4], infinite: true,
					arrows: opts[5],
					adaptiveHeight:true,
					nextArrow:'<button type=\"button\" style=\"color:#333333; font-size:24px;\" class=\"slick-next default\"><i class=\"ultsl-arrow-right6\"></i></button>',
					prevArrow:'<button type=\"button\" style=\"color:#333333; font-size:24px;\" class=\"slick-prev default\"><i class=\"ultsl-arrow-left6\"></i></button>',
					swipe:true,
					draggable:true,
					touchMove:true,
					slidesToScroll: 1,
					slidesToShow: 1,
					pauseOnHover:opts[7],
					pauseOnDotsHover:opts[7],
					customPaging:function(slider,i){
						return'<i type=\"button\" style=\"color:#333333;\" class=\"ultsl-record\" data-role=\"none\"></i>';
					}
				});
				
		  });
		  </script>";
	  }
	
      wp_reset_query();

	  $des_testimonials_index++;
      return $output;
	}

    public function des_renderVerticalTabs( $atts, $content = null ) {
      extract( shortcode_atts( array(
        'title' => '',
        'style' => 'icon',
        'orientation' => 'vertical'
      ), $atts ) );
      $content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content
     
     static $des_vertical_tabs = 1;
     
     if (vc_is_inline()){
	     $output = '<h2 class="front_end_editor_vertical_tabs">'.__('the vertical tabs shortcode can only be edited in the backend editor.<br/>we\'re working on it, sorry for the inconvenience.','yunik').'</h2>';
	     $output .= '<style>body.vc_editor .vc_verticaltabs .vc_controls, body.vc_editor .vc_verticaltabs *::after{display: none !important;}body.vc_editor .vc_verticaltabs *{pointer-events:none;}</style>';
     } else {
	      $content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content
     
		  if ($orientation === 'horizontal'){
				$tabslayout = 'col-xs-12 col-sm-12';
		  } else {
				$tabslayout = ($style === 'icon') ? 'col-xs-12 col-sm-1' : 'col-xs-12 col-sm-3';  
		  }
		  
		  if ($orientation === 'horizontal'){
				$contentlayout = 'col-xs-12 col-sm-12';
		  } else {
				$contentlayout = ($style === 'icon') ? 'col-xs-12 col-sm-11' : 'col-xs-12 col-sm-9';
		  }
			
	      $output = "<section class='special_tabs {$style} {$orientation}'>";
		  if ($title) $output .= "<h2>".esc_html($title)."</h2>";
		  $output .= "<div class='tab-selector {$tabslayout}'></div><div class='tab-container {$contentlayout}' style='margin-left:0px;'></div>";
		  $output .= "{$content}</section>";
     
/*
		  $tabslayout = ($style === 'icon') ? 'col-xs-12 col-sm-1' : 'col-xs-12 col-sm-3';
		  $contentlayout = ($style === 'icon') ? 'col-xs-12 col-sm-11' : 'col-xs-12 col-sm-9';
		
	      $output = "<section class='special_tabs {$style}'>";
		  if ($title) $output .= "<h2>{$title}</h2>";
		  $output .= "<div class='tab-selector {$tabslayout}'></div><div class='tab-container {$contentlayout}' style='margin-left:0px;'></div>";
		  $output .= "{$content}</section>";
*/     
	 }	  
	  
	  $des_vertical_tabs++;
      return $output;
    }

	public function des_renderVerticalTab( $atts, $content = null ) {
      extract( shortcode_atts( array(
        'title' => 'Tab',
		'icon' => 'fa-adjust',
        'tab_id' => ''
      ), $atts ) );
      $content = wpb_js_remove_wpautop($content, true); // fix unclosed/unwanted paragraph tags in $content
      
	  static $des_vt_index = 1;
	  $uniq = rand();
	        
	  if (vc_is_inline()){
		$output = "";
	  } else {
		  $output = "<div class='label {$des_vt_index}'><div class='designare_icon_special_tabs'><i class='fa {$icon}'></i></div><div class='title'><a>{$title}</a></div><div class='divider-vertical-tabs'></div></div><div class='content {$des_vt_index}'>{$content}</div>";
	  }	

	  $des_vt_index++;
      return $output;
    }

    /*
    Load plugin css and javascript files which you may need on front end of your site
    */
    //public function des_loadCssAndJs() { }

}


if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
	class WPBakeryShortCode_des_info_list extends WPBakeryShortCodesContainer {}
    class WPBakeryShortCode_Verticaltabs extends WPBakeryShortCodesContainer {
		static $filter_added = false;
		public function __construct( $settings ) {
			parent::__construct( $settings );
			if ( ! self::$filter_added ) {
				$this->addFilter( 'vc_inline_template_content', 'setCustomTabId' );
				self::$filter_added = true;
			}
		}
		public function contentAdmin( $atts, $content = null ) {
			if (!isset($output)) $output = "";
			$width = $custom_markup = '';
			$shortcode_attributes = array( 'width' => '1/1' );
			foreach ( $this->settings['params'] as $param ) {
				if ( $param['param_name'] != 'content' ) {
					if ( isset( $param['value'] ) && is_string( $param['value'] ) ) {
						$shortcode_attributes[$param['param_name']] = __( $param['value'], "js_composer" );
					} elseif ( isset( $param['value'] ) ) {
						$shortcode_attributes[$param['param_name']] = $param['value'];
					}
				} else if ( $param['param_name'] == 'content' && $content == NULL ) {
					$content = __( $param['value'], "js_composer" );
				}
			}
			extract( shortcode_atts(
				$shortcode_attributes
				, $atts ) );
			preg_match_all( '/verticaltab title="([^\"]+)"(\stab_id\=\"([^\"]+)\"){0,1}/i', $content, $matches, PREG_OFFSET_CAPTURE );			
			$tab_titles = array();
			if ( isset( $matches[0] ) ) {
				$tab_titles = $matches[0];
			}
			$tmp = '';
			if ( count( $tab_titles ) ) {
				$tmp .= '<ul class="clearfix tabs_controls">';
				foreach ( $tab_titles as $tab ) {
					preg_match( '/title="([^\"]+)"(\stab_id\=\"([^\"]+)\"){0,1}/i', $tab[0], $tab_matches, PREG_OFFSET_CAPTURE );
					if ( isset( $tab_matches[1][0] ) ) {
						$tmp .= '<li><a href="#tab-' . ( isset( $tab_matches[3][0] ) ? $tab_matches[3][0] : sanitize_title( $tab_matches[1][0] ) ) . '">' . $tab_matches[1][0] . '</a></li>';

					}
				}
				$tmp .= '</ul>' . "\n";
			} else {
				$output .= do_shortcode( $content );
			}
			$elem = $this->getElementHolder( $width );
			$iner = '';
			foreach ( $this->settings['params'] as $param ) {
				$custom_markup = '';
				$param_value = isset( $$param['param_name'] ) ? $$param['param_name'] : '';
				if ( is_array( $param_value ) ) {
					reset( $param_value );
					$first_key = key( $param_value );
					$param_value = $param_value[$first_key];
				}
				$iner .= $this->singleParamHtmlHolder( $param, $param_value );
			}
			if ( isset( $this->settings["custom_markup"] ) && $this->settings["custom_markup"] != '' ) {
				if ( $content != '' ) {
					$custom_markup = str_ireplace( "%content%", $tmp . $content, $this->settings["custom_markup"] );
				} else if ( $content == '' && isset( $this->settings["default_content_in_template"] ) && $this->settings["default_content_in_template"] != '' ) {
					$custom_markup = str_ireplace( "%content%", $this->settings["default_content_in_template"], $this->settings["custom_markup"] );
				} else {
					$custom_markup = str_ireplace( "%content%", '', $this->settings["custom_markup"] );
				}
				$iner .= do_shortcode( $custom_markup );
			}
			$elem = str_ireplace( '%wpb_element_content%', $iner, $elem );
			$output = $elem;
			return $output;
		}
		public function getTabTemplate() {
			return '<div class="wpb_template">' . do_shortcode( '[verticaltab title="" tab_id="" icon=""][/verticaltab]' ) . '</div>';
		}
		public function setCustomTabId( $content ) {
			return preg_replace( '/tab\_id\=\"([^\"]+)\"/', 'tab_id="$1-' . time() . '"', $content );
		}
	
    }
}

if ( class_exists('WPBakeryShortCodesContainer')){
	class WPBakeryShortCode_Verticaltab extends WPBakeryShortCodesContainer {
		protected $predefined_atts = array(
			'tab_id' => '',
			'icon' => 'fa-adjust',
			'title' => ''
		);

		public function __construct( $settings ) {
			parent::__construct( $settings );
		}

		public function customAdminBlockParams() {
			return ' id="tab-' . $this->atts['tab_id'] . '"';
		}

		public function mainHtmlBlockParams( $width, $i ) {
			return 'data-element_type="' . $this->settings["base"] . '" class="wpb_' . $this->settings['base'] . ' wpb_sortable wpb_content_holder"' . $this->customAdminBlockParams();
		}

		public function containerHtmlBlockParams( $width, $i ) {
			return 'class="wpb_column_container vc_container_for_children"';
		}
	}
} 


function des_hex2rgb($hex = "000000") {
	if (is_array($hex)) $hex = "000000";
	$hex = str_replace("#", "", $hex);
	
	if(strlen($hex) == 3) {
		$r = hexdec(substr($hex,0,1).substr($hex,0,1));
		$g = hexdec(substr($hex,1,1).substr($hex,1,1));
		$b = hexdec(substr($hex,2,1).substr($hex,2,1));
	} else {
		$r = hexdec(substr($hex,0,2));
		$g = hexdec(substr($hex,2,2));
		$b = hexdec(substr($hex,4,2));
	}
	$rgb = array($r, $g, $b);
	//return implode(",", $rgb); // returns the rgb values separated by commas
	return $rgb; // returns an array with the rgb values
}


function des_menu_item_class_select(){
    global $pagenow;
    if ($pagenow == "nav-menus.php"){
	    wp_enqueue_script('jquery-ui-dialog');
	    wp_enqueue_style('designare-admin-style',DESIGNARE_CSS_URL.'custom_page.css');
	    $des_icons = array('fa-adjust','fa-adn','fa-align-center','fa-align-justify','fa-align-left','fa-align-right','fa-ambulance','fa-anchor','fa-android','fa-angle-double-down','fa-angle-double-left','fa-angle-double-right','fa-angle-double-up','fa-angle-down','fa-angle-left','fa-angle-right','fa-angle-up','fa-apple','fa-archive','fa-arrow-circle-down','fa-arrow-circle-left','fa-arrow-circle-o-down','fa-arrow-circle-o-left','fa-arrow-circle-o-right','fa-arrow-circle-o-up','fa-arrow-circle-right','fa-arrow-circle-up','fa-arrow-down','fa-arrow-left','fa-arrow-right','fa-arrow-up','fa-arrows','fa-arrows-alt','fa-arrows-h','fa-arrows-v','fa-asterisk','fa-automobile','fa-backward','fa-ban','fa-bank','fa-bar-chart-o','fa-barcode','fa-bars','fa-beer','fa-behance','fa-behance-square','fa-bell','fa-bell-o','fa-bitbucket','fa-bitbucket-square','fa-bitcoin','fa-bold','fa-bolt','fa-bomb','fa-book','fa-bookmark','fa-bookmark-o','fa-briefcase','fa-btc','fa-bug','fa-building','fa-building-o','fa-bullhorn','fa-bullseye','fa-cab','fa-calendar','fa-calendar-o','fa-camera','fa-camera-retro','fa-car','fa-caret-down','fa-caret-left','fa-caret-right','fa-caret-square-o-down','fa-caret-square-o-left','fa-caret-square-o-right','fa-caret-square-o-up','fa-caret-up','fa-certificate','fa-chain','fa-chain-broken','fa-check','fa-check-circle','fa-check-circle-o','fa-check-square','fa-check-square-o','fa-chevron-circle-down','fa-chevron-circle-left','fa-chevron-circle-right','fa-chevron-circle-up','fa-chevron-down','fa-chevron-left','fa-chevron-right','fa-chevron-up','fa-child','fa-circle','fa-circle-o','fa-circle-o-notch','fa-circle-thin','fa-clipboard','fa-clock-o','fa-cloud','fa-cloud-download','fa-cloud-upload','fa-cny','fa-code','fa-code-fork','fa-codepen','fa-coffee','fa-cog','fa-cogs','fa-columns','fa-comment','fa-comment-o','fa-comments','fa-comments-o','fa-compass','fa-compress','fa-copy','fa-credit-card','fa-crop','fa-crosshairs','fa-css3','fa-cube','fa-cubes','fa-cut','fa-cutlery','fa-dashboard','fa-database','fa-dedent','fa-delicious','fa-desktop','fa-deviantart','fa-digg','fa-dollar','fa-dot-circle-o','fa-download','fa-dribbble','fa-dropbox','fa-drupal','fa-edit','fa-eject','fa-ellipsis-h','fa-ellipsis-v','fa-empire','fa-envelope','fa-envelope-o','fa-envelope-square','fa-eraser','fa-eur','fa-euro','fa-exchange','fa-exclamation','fa-exclamation-circle','fa-exclamation-triangle','fa-expand','fa-external-link','fa-external-link-square','fa-eye','fa-eye-slash','fa-facebook','fa-facebook-square','fa-fast-backward','fa-fast-forward','fa-fax','fa-female','fa-fighter-jet','fa-file','fa-file-archive-o','fa-file-audio-o','fa-file-code-o','fa-file-excel-o','fa-file-image-o','fa-file-movie-o','fa-file-o','fa-file-pdf-o','fa-file-photo-o','fa-file-picture-o','fa-file-powerpoint-o','fa-file-sound-o','fa-file-text','fa-file-text-o','fa-file-video-o','fa-file-word-o','fa-file-zip-o','fa-files-o','fa-film','fa-filter','fa-fire','fa-fire-extinguisher','fa-flag','fa-flag-checkered','fa-flag-o','fa-flash','fa-flask','fa-flickr','fa-floppy-o','fa-folder','fa-folder-o','fa-folder-open','fa-folder-open-o','fa-font','fa-forward','fa-foursquare','fa-frown-o','fa-gamepad','fa-gavel','fa-gbp','fa-ge','fa-gear','fa-gears','fa-gift','fa-git','fa-git-square','fa-github','fa-github-alt','fa-github-square','fa-gittip','fa-glass','fa-globe','fa-google','fa-google-plus','fa-google-plus-square','fa-graduation-cap','fa-group','fa-h-square','fa-hacker-news','fa-hand-o-down','fa-hand-o-left','fa-hand-o-right','fa-hand-o-up','fa-hdd-o','fa-header','fa-headphones','fa-heart','fa-heart-o','fa-history','fa-home','fa-hospital-o','fa-html5','fa-image','fa-inbox','fa-indent','fa-info','fa-info-circle','fa-inr','fa-instagram','fa-institution','fa-italic','fa-joomla','fa-jpy','fa-jsfiddle','fa-key','fa-keyboard-o','fa-krw','fa-language','fa-laptop','fa-leaf','fa-legal','fa-lemon-o','fa-level-down','fa-level-up','fa-life-bouy','fa-life-ring','fa-life-saver','fa-lightbulb-o','fa-link','fa-linkedin','fa-linkedin-square','fa-linux','fa-list','fa-list-alt','fa-list-ol','fa-list-ul','fa-location-arrow','fa-lock','fa-long-arrow-down','fa-long-arrow-left','fa-long-arrow-right','fa-long-arrow-up','fa-magic','fa-magnet','fa-mail-forward','fa-mail-reply','fa-mail-reply-all','fa-male','fa-map-marker','fa-maxcdn','fa-medkit','fa-meh-o','fa-microphone','fa-microphone-slash','fa-minus','fa-minus-circle','fa-minus-square','fa-minus-square-o','fa-mobile','fa-mobile-phone','fa-money','fa-moon-o','fa-mortar-board','fa-music','fa-navicon','fa-openid','fa-outdent','fa-pagelines','fa-paper-plane','fa-paper-plane-o','fa-paperclip','fa-paragraph','fa-paste','fa-pause','fa-paw','fa-pencil','fa-pencil-square','fa-pencil-square-o','fa-phone','fa-phone-square','fa-photo','fa-picture-o','fa-pied-piper','fa-pied-piper-alt','fa-pinterest','fa-pinterest-square','fa-plane','fa-play','fa-play-circle','fa-play-circle-o','fa-plus','fa-plus-circle','fa-plus-square','fa-plus-square-o','fa-power-off','fa-print','fa-puzzle-piece','fa-qq','fa-qrcode','fa-question','fa-question-circle','fa-quote-left','fa-quote-right','fa-ra','fa-random','fa-rebel','fa-recycle','fa-reddit','fa-reddit-square','fa-refresh','fa-renren','fa-reorder','fa-repeat','fa-reply','fa-reply-all','fa-retweet','fa-rmb','fa-road','fa-rocket','fa-rotate-left','fa-rotate-right','fa-rouble','fa-rss','fa-rss-square','fa-rub','fa-ruble','fa-rupee','fa-save','fa-scissors','fa-search','fa-search-minus','fa-search-plus','fa-send','fa-send-o','fa-share','fa-share-alt','fa-share-alt-square','fa-share-square','fa-share-square-o','fa-shield','fa-shopping-cart','fa-sign-in','fa-sign-out','fa-signal','fa-sitemap','fa-skype','fa-slack','fa-sliders','fa-smile-o','fa-sort','fa-sort-alpha-asc','fa-sort-alpha-desc','fa-sort-amount-asc','fa-sort-amount-desc','fa-sort-asc','fa-sort-desc','fa-sort-down','fa-sort-numeric-asc','fa-sort-numeric-desc','fa-sort-up','fa-soundcloud','fa-space-shuttle','fa-spinner','fa-spoon','fa-spotify','fa-square','fa-square-o','fa-stack-exchange','fa-stack-overflow','fa-star','fa-star-half','fa-star-half-empty','fa-star-half-full','fa-star-half-o','fa-star-o','fa-steam','fa-steam-square','fa-step-backward','fa-step-forward','fa-stethoscope','fa-stop','fa-strikethrough','fa-stumbleupon','fa-stumbleupon-circle','fa-subscript','fa-suitcase','fa-sun-o','fa-superscript','fa-support','fa-table','fa-tablet','fa-tachometer','fa-tag','fa-tags','fa-tasks','fa-taxi','fa-tencent-weibo','fa-terminal','fa-text-height','fa-text-width','fa-th','fa-th-large','fa-th-list','fa-thumb-tack','fa-thumbs-down','fa-thumbs-o-down','fa-thumbs-o-up','fa-thumbs-up','fa-ticket','fa-times','fa-times-circle','fa-times-circle-o','fa-tint','fa-toggle-down','fa-toggle-left','fa-toggle-right','fa-toggle-up','fa-trash-o','fa-tree','fa-trello','fa-trophy','fa-truck','fa-try','fa-tumblr','fa-tumblr-square','fa-turkish-lira','fa-twitter','fa-twitter-square','fa-umbrella','fa-underline','fa-undo','fa-university','fa-unlink','fa-unlock','fa-unlock-alt','fa-unsorted','fa-upload','fa-usd','fa-user','fa-user-md','fa-users','fa-video-camera','fa-vimeo-square','fa-vine','fa-vk','fa-volume-down','fa-volume-off','fa-volume-up','fa-warning','fa-wechat','fa-weibo','fa-weixin','fa-wheelchair','fa-windows','fa-won','fa-wordpress','fa-wrench','fa-xing','fa-xing-square','fa-yahoo','fa-yen','fa-youtube','fa-youtube-play','fa-youtube-square');
	    ?>
	<script type="text/javascript">
	
		function des_removeIcon(el){
		    el.siblings('.edit-menu-item-classes').val( " "+el.siblings('.edit-menu-item-classes').val().replace(el.siblings('i').attr('class'), ""));
		    el.siblings('i').remove();
		    el.remove();
	    }
	    
	    function des_override_class_options(){
		    var holders = jQuery('.menu-item-settings p.field-css-classes > label').not('.des');
		    holders.each(function(){
			    var theid = jQuery(this).closest('.menu-item-settings').attr('id');
			    jQuery(this).addClass('des');
			    jQuery(this).removeClass('hidden-field').css('display','block');
 			    jQuery(this).contents().filter(function () { return this.nodeType === 3; }).remove();
			    jQuery(this).prepend('<label class="des_input" for="des_mega_menu">Mega Menu?  </label><input type="checkbox" name="des_mega_menu"><label class="des_input" for="des_mega_hide_title">Hide Title?  </label><input type="checkbox" name="des_mega_hide_title"><br/><label class="des_input" for="des_mega_hide_link">Just Label (Without Link) ?  </label><input type="checkbox" name="des_mega_hide_link"><br/><a href="#" class="des_select_icon button" >Select Icon</a><br/><br/>');
			    
			    
			    /* check if menu item has already an icon and present it. also check the boxes if the class exists. */
			    if (jQuery(this).find('input.edit-menu-item-classes').val()){
				    var itemClasses = jQuery(this).find('input.edit-menu-item-classes').val().split(" ");
				    var found = "false";
				    for (var i=0; i<itemClasses.length; i++){
					    if (itemClasses[i].indexOf("fa-") > -1) {
						    found = itemClasses[i];
					    }
					    if (itemClasses[i].indexOf("des_mega_hide_link") > -1) jQuery(this).find('input[name=des_mega_hide_link]').attr('checked','checked');
					    if (itemClasses[i].indexOf("des_mega_hide_title") > -1) jQuery(this).find('input[name=des_mega_hide_title]').attr('checked','checked');
					    if (itemClasses[i].indexOf("des_mega_menu") > -1) jQuery(this).find('input[name=des_mega_menu]').attr('checked','checked');
				    }
				    if (found != "false"){
					    jQuery(this).find('.des_select_icon.button').after( '<i class="fa '+found+'" style="position:relative;top:2px;margin-left:10px;margin-right:10px;width: 30px;height: 30px;font-size: 25px;border: 1px solid;text-align: center;line-height: 30px;"></i><a class="des_remove_icon" href="javascript:;" onclick="des_removeIcon(jQuery(this));">Remove Icon</a>' );
				    }
			    }
			    
			    
				jQuery(this).find('input').each(function(){
					jQuery(this).bind('change', function(){
						if (jQuery(this).is(':checked')) jQuery(this).siblings('.edit-menu-item-classes').val( jQuery(this).siblings('.edit-menu-item-classes').val() + " " + jQuery(this).attr('name') );
						else jQuery(this).siblings('.edit-menu-item-classes').val( jQuery(this).siblings('.edit-menu-item-classes').val().replace(" " + jQuery(this).attr('name'),"") );
					});
				});
				jQuery(this).find('.des_select_icon').click(function(){
					jQuery('.des_icon_container').dialog({modal:true, height: parseInt(jQuery(window).height()*.8, 10), width: parseInt(jQuery(window).width()*.8, 10), autoOpen: false});
					jQuery('.des_icon_container').parent().attr('data-rel',theid).css({position : "fixed"}).end().dialog('open');
				});
		    });			
		}
	
	    jQuery(document).ready(function(){
		    
		    des_override_class_options();

			jQuery('.submit-add-to-menu').click(function(){ 
				var new_item = false;
				if (jQuery(this).attr('id') === 'submit-posttype-page' && jQuery('#posttype-page input:checked').length > 0) new_item = true;
				if (jQuery(this).attr('id') === 'submit-customlinkdiv' && jQuery('#custom-menu-item-name').val() != "" && !jQuery('#custom-menu-item-name').hasClass('input-with-default-title') && jQuery('#custom-menu-item-url').val() != "" && jQuery('#custom-menu-item-url').val() != "http://") nav_item = true;
				if (jQuery(this).attr('id') === 'submit-taxonomy-category' && jQuery('#add-category input:checked').length > 0) new_item = true;
				if (new_item){
					var check_for_new_item = setInterval(function(){
						if (jQuery('.menu-item-settings p.field-css-classes label').not('.des').not('.des_input').length){
							clearInterval(check_for_new_item);
							des_override_class_options();
						}
					}, 100);
				}
			});	
	    });
    </script>
	<div class="des_icon_container" style="display:none;">
		<?php
			$first = true;
			foreach ($des_icons as $i){
				if ($first) {
					$first = false;
					echo "<i class='fa $i selected' data-rel='fa $i' onclick='jQuery(this).addClass(\"selected\").siblings().removeClass(\"selected\");'></i>";
				} else echo "<i class='fa $i' data-rel='fa $i' onclick='jQuery(this).addClass(\"selected\").siblings().removeClass(\"selected\");'></i>";
			}
		?>
		<div class="clear" style="height:10px;"></div>
		<a href="javascript:;" onclick=" if (jQuery('#'+jQuery(this).closest('.ui-dialog').attr('data-rel')+ ' .des_remove_icon').length) jQuery('#'+jQuery(this).closest('.ui-dialog').attr('data-rel')+ ' .des_remove_icon').click(); jQuery('#'+jQuery(this).closest('.ui-dialog').attr('data-rel')+ ' .edit-menu-item-classes').val( jQuery('#'+jQuery(this).closest('.ui-dialog').attr('data-rel')+ ' .edit-menu-item-classes').val() + ' ' + jQuery(this).siblings('i.selected').attr('data-rel')); jQuery('#'+jQuery(this).closest('.ui-dialog').attr('data-rel')+ ' .des_select_icon.button').after('<a class=\'des_remove_icon\' href=\'javascript:;\' onclick=\'des_removeIcon(jQuery(this));\'>Remove Icon</a>').after( '<i class=\''+jQuery(this).siblings('i.selected').attr('data-rel')+'\' style=\'position:relative;top:2px;margin-left:10px;margin-right:10px;width: 30px;height: 30px;font-size: 25px;border: 1px solid;text-align: center;line-height: 30px;\'></i>' );   jQuery('.des_icon_container').dialog('close');" class="button button_ok">OK</a>
		<a href="javascript:;" onclick="jQuery('.des_icon_container').dialog('close');" class="button button_cancel">Cancel</a>
	</div>
    <?php
    }
}
add_action('admin_footer','des_menu_item_class_select');

function des_get_string_between($string, $start, $end){
    $string = " ".$string;
    $ini = strpos($string,$start);
    if ($ini == 0) return "";
    $ini += strlen($start);
    $len = strpos($string,$end,$ini) - $ini;
    return substr($string,$ini,$len);
}

function des_content_shortcoder($post_content){
	
	$dependancy = array('jquery');
	global $vc_addons_url;
	// register css
	wp_register_style('ultimate-animate',$vc_addons_url.'assets/min-css/animate.min.css',array());
	wp_register_style('ultimate-style',$vc_addons_url.'assets/min-css/style.min.css',array());
	wp_register_style('ultimate-style-min',$vc_addons_url.'assets/min-css/ultimate.min.css',array());

	wp_enqueue_script('ultimate-script');
	wp_enqueue_script('ultimate-vc-params');
			
	if( 
		stripos( $post_content, '[ultimate_spacer') 
		|| stripos( $post_content, '[ult_buttons') 
		|| stripos( $post_content, '[ultimate_icon_list') 
	) {
		wp_enqueue_script('ultimate-custom');
	}
	if( 
		stripos( $post_content, '[just_icon') 
		|| stripos( $post_content, '[ult_animation_block')
		|| stripos( $post_content, '[icon_counter')
		|| stripos( $post_content, '[ultimate_google_map')
		|| stripos( $post_content, '[icon_timeline')
		|| stripos( $post_content, '[bsf-info-box')
		|| stripos( $post_content, '[info_list')
		|| stripos( $post_content, '[ultimate_info_table')
		|| stripos( $post_content, '[interactive_banner_2')
		|| stripos( $post_content, '[interactive_banner')
		|| stripos( $post_content, '[ultimate_pricing')
		|| stripos( $post_content, '[ultimate_icons')
	) {
		wp_enqueue_script('ultimate-appear');
		wp_enqueue_script('ultimate-custom');
	}
	if( stripos( $post_content, '[ultimate_heading') ) {
		wp_enqueue_script("ultimate-headings-script");
	}
	if( stripos( $post_content, '[ultimate_carousel') ) {
		wp_enqueue_script('ult-slick');
		wp_enqueue_script('ultimate-appear');
		wp_enqueue_script('ult-slick-custom');		
	}
	if( stripos( $post_content, '[ult_countdown') ) {
		wp_enqueue_script('jquery.timecircle');
		wp_enqueue_script('jquery.countdown');
	}
	if( stripos( $post_content, '[icon_timeline') ) {
		wp_enqueue_script('masonry');
	}
	if( stripos( $post_content, '[ultimate_info_banner') ) {
		wp_enqueue_script('ultimate-appear');
		wp_enqueue_script('utl-info-banner-script');
	}
	if( stripos( $post_content, '[ultimate_google_map') ) {
		wp_enqueue_script('googleapis');
	}
	if( stripos( $post_content, '[swatch_container') ) {
		wp_enqueue_script('modernizr-79639-js');
		wp_enqueue_script('swatchbook-js');
	}
	if( stripos( $post_content, '[ult_ihover') ) {
		wp_enqueue_script('ult_ihover_js');
	}
	if( stripos( $post_content, '[ult_hotspot') ) {
		wp_enqueue_script('ult_hotspot_js');
		wp_enqueue_script('ult_hotspot_tooltipster_js');
	}
	if( stripos( $post_content, '[ult_content_box') ) {
		wp_enqueue_script('ult_content_box_js');
	}
	if( stripos( $post_content, '[bsf-info-box') ) {
		wp_enqueue_script('info_box_js');
	}
	if( stripos( $post_content, '[icon_counter') ) {
		wp_enqueue_script('flip_box_js');
	}
	if( stripos( $post_content, '[ultimate_ctation') ) {
		wp_enqueue_script('utl-ctaction-script');
	}
	if( stripos( $post_content, '[stat_counter') ) {
		wp_enqueue_script('ultimate-appear');
		wp_enqueue_script('front-js');
		wp_enqueue_script('ult-slick-custom');
		array_push($dependancy,'front-js');
	}
	if( stripos( $post_content, '[ultimate_video_banner') ) {
		wp_enqueue_script('ultimate-video-banner-script');
	}
	if( stripos( $post_content, '[ult_dualbutton') ) {
		wp_enqueue_script('jquery.dualbtn');
		
	}
	if( stripos( $post_content, '[ult_createlink') ) {
		wp_enqueue_script('jquery.ult_cllink');
	}
	if( stripos( $post_content, '[ultimate_img_separator') ) {
		wp_enqueue_script('ultimate-appear');
		wp_enqueue_script('ult-easy-separator-script');
		wp_enqueue_script('ultimate-custom');
	}

	if( stripos( $post_content, '[ult_tab_element') ) {
		wp_enqueue_script('imd_ui_tabs_rotate');
		wp_enqueue_script('imd_ui_acordian_js');
	}
	if( stripos( $post_content, '[ultimate_exp_section') ) {
		wp_enqueue_script('jquery_ui');
		wp_enqueue_script('jquery_ultimate_expsection');
	}

	wp_enqueue_style('ultimate-style-min');
}

function des_print_woocommerce_button(){
	global $woocommerce;
	if (isset($woocommerce) && get_option(DESIGNARE_SHORTNAME."_woocommerce_cart") == "on"){ ?>
		<div class="yunik_dynamic_shopping_bag">
    
            <div class="yunik_little_shopping_bag_wrapper">
                <div class="yunik_little_shopping_bag">
                    <div class="title">
	                	<i class="fa fa-shopping-cart"></i>
	                </div>
	                
	                <div class="overview"><span class="minicart_items"><?php echo sprintf(_n('%d', '%d', $woocommerce->cart->cart_contents_count, 'yunik'), $woocommerce->cart->cart_contents_count); ?></span></div>
                </div>
                <div class="yunik_minicart_wrapper">
                    <div class="yunik_minicart">
                    <?php                                    
                    echo '<ul class="cart_list">';                                        
                        if (sizeof($woocommerce->cart->cart_contents)>0) : foreach ($woocommerce->cart->cart_contents as $cart_item_key => $cart_item) :
                        
                            $_product = $cart_item['data'];                                            
                            if ($_product->exists() && $cart_item['quantity']>0) :                                            
                                echo '<li class="cart_list_product">';                                                
                                    echo '<a class="cart_list_product_img" href="'.get_permalink($cart_item['product_id']).'">' . $_product->get_image().'</a>';                                                    
                                    echo '<div class="cart_list_product_title">';
                                        $yunik_product_title = $_product->get_title();
                                        $yunik_short_product_title = (strlen($yunik_product_title) > 28) ? substr($yunik_product_title, 0, 25) . '...' : $yunik_product_title;
                                        echo '<a href="'.get_permalink($cart_item['product_id']).'">' . apply_filters('woocommerce_cart_widget_product_title', $yunik_short_product_title, $_product) . '</a>';
                                        echo '<div class="cart_list_product_quantity">'.$cart_item['quantity'].'x</div>';
                                    echo '</div>';
                                    echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf('<a href="%s" class="remove" title="%s">&times;</a>', esc_url( $woocommerce->cart->get_remove_url( $cart_item_key ) ), __('Remove this item', 'yunik') ), $cart_item_key );
                                    echo '<div class="cart_list_product_price">'.woocommerce_price($_product->get_price()).'</div>';
                                    echo '<div class="clr"></div>';                                                
                                echo '</li>';                                         
                            endif;                                        
                        endforeach;
                        ?>
                                
                        <div class="minicart_total_checkout">                                        
                            <?php _e('Cart subtotal', 'yunik'); ?><span><?php echo $woocommerce->cart->get_cart_total(); ?></span>                                   
                        </div>
                        
                         <a href="<?php echo esc_url( $woocommerce->cart->get_cart_url() ); ?>" class="button yunik_minicart_cart_but"><?php _e('View Bag', 'yunik'); ?></a>
                    <a href="<?php echo esc_url( $woocommerce->cart->get_checkout_url() ); ?>" class="button yunik_minicart_checkout_but"><?php _e('Checkout', 'yunik'); ?></a>
                        
                        <?php                                        
                        else: echo '<li class="empty">'.__('No products in the cart.','woothemes').'</li>'; endif;                                    
                    echo '</ul>';                                    
                    ?>                                                                        
    
                    </div>
                </div>
                
            </div>
            
            <a href="<?php echo esc_url( $woocommerce->cart->get_cart_url() ); ?>" class="yunik_little_shopping_bag_wrapper_mobiles"><span><?php echo $woocommerce->cart->cart_contents_count; ?></span></a>
        
        </div>
    <?php
	}
}

function des_woocommerce_header_add_to_cart_fragment( $fragments ) {
	global $woocommerce;
	ob_start();
	?>
	<div class="yunik_dynamic_shopping_bag">
        <div class="yunik_little_shopping_bag_wrapper">
            <div class="yunik_little_shopping_bag" style="background: transparent !important;">
                <div class="title">
                	<i class="fa fa-shopping-cart"></i>
                </div>
                <div class="overview"><span class="minicart_items"><?php echo sprintf(_n('%d', '%d', $woocommerce->cart->cart_contents_count, 'yunik'), $woocommerce->cart->cart_contents_count); ?></span></div>
            </div>
            <div class="yunik_minicart_wrapper">
                <div class="yunik_minicart">
                <?php
                echo '<ul class="cart_list">';
                    if (sizeof($woocommerce->cart->cart_contents)>0) : foreach ($woocommerce->cart->cart_contents as $cart_item_key => $cart_item) :
                        $_product = $cart_item['data'];
                        if ($_product->exists() && $cart_item['quantity']>0) :                                            
                            echo '<li class="cart_list_product">';
                                echo '<a class="cart_list_product_img" href="'.get_permalink($cart_item['product_id']).'">' . $_product->get_image().'</a>';
                                echo '<div class="cart_list_product_title">';
                                    $yunik_product_title = $_product->get_title();
                                    $yunik_short_product_title = (strlen($yunik_product_title) > 28) ? substr($yunik_product_title, 0, 25) . '...' : $yunik_product_title;
                                    echo '<a href="'.get_permalink($cart_item['product_id']).'">' . apply_filters('woocommerce_cart_widget_product_title', $yunik_short_product_title, $_product) . '</a>';
                                    echo '<div class="cart_list_product_quantity">'.$cart_item['quantity'].'x</div>';
                                echo '</div>';
                                echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf('<a href="%s" class="remove" title="%s">&times;</a>', esc_url( $woocommerce->cart->get_remove_url( $cart_item_key ) ), __('Remove this item', 'yunik') ), $cart_item_key );
                                echo '<div class="cart_list_product_price">'.woocommerce_price($_product->get_price()).'</div>';
                                echo '<div class="clr"></div>';
                            echo '</li>';
                        endif;
                    endforeach;
                    ?>
                    <div class="minicart_total_checkout">
                        <?php _e('Cart subtotal', 'yunik'); ?><span><?php echo $woocommerce->cart->get_cart_total(); ?></span>
                    </div>
                    <a href="<?php echo esc_url( $woocommerce->cart->get_cart_url() ); ?>" class="button yunik_minicart_cart_but"><?php _e('View Bag', 'yunik'); ?></a>
                    <a href="<?php echo esc_url( $woocommerce->cart->get_checkout_url() ); ?>" class="button yunik_minicart_checkout_but"><?php _e('Checkout', 'yunik'); ?></a>
                    <?php                                    
                    else: echo '<li class="empty">'.__('No products in the cart.','woothemes').'</li>'; endif;
                echo '</ul>';
                ?>
                </div>
            </div>
        </div>
        <a href="<?php echo esc_url( $woocommerce->cart->get_cart_url() ); ?>" class="yunik_little_shopping_bag_wrapper_mobiles"><span><?php echo $woocommerce->cart->cart_contents_count; ?></span></a>
        <script type="text/javascript">
	        jQuery("header:not(.headerclone) .yunik_little_shopping_bag_wrapper").on("mouseenter mouseover", function() {
				if(!jQuery(this).data('init')){
		            jQuery(this).data('init', true);
		            jQuery(this).hover(
		                function(){
							jQuery('header:not(.headerclone) .yunik_minicart_wrapper').fadeIn(200);
		                },
		                function(){
		                    jQuery('header:not(.headerclone) .yunik_minicart_wrapper').fadeOut(200);
		                    
		                }
		            );
		            jQuery(this).trigger('mouseenter');
		        }
			});
			jQuery("header:not(.headerclone) ul.cart_list li").mouseenter(function(){
				jQuery(this).children('.remove').fadeIn(0);
			}).mouseleave(function(){
				jQuery(this).children('.remove').fadeOut(0);
			});	
        </script>
    </div>
	<?php
	$fragments['div.yunik_dynamic_shopping_bag' ] = ob_get_clean();
	return $fragments;
}