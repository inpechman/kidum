<?php
/*
Plugin Name: Designare Custom Post Types
Plugin URI: http://designarethemes.net
Description: Testimonials, Partners, Team and Projects Posts. We do not intended this plugin for distribution. We are only responsible for its usage with DesignareThemes' themes.
Version: 1.0
Author: DesignareThemes
Author URI: http://designarethemes.net
*/


// don't load directly
if ( ! defined( 'ABSPATH' )) {
	die( '-1' );
}

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

/*******+++++**/
/*	projects
/********+++++*/
/**
 * ADD THE ACTIONS
 */
add_action('init', 'designare_register_portfolio_category');  //functions/portfolio.php
add_action('init', 'designare_register_portfolio_post_type');  //functions/portfolio.php
add_action('manage_posts_custom_column',  'portfolio_show_columns'); //functions/portfolio.php
add_filter('manage_edit-portfolio_columns', 'portfolio_columns');

/**
 * Registers the portfolio category taxonomy.
 */
if (!function_exists('designare_register_portfolio_category')){
    function designare_register_portfolio_category(){

        register_taxonomy("portfolio_category",
            array(DESIGNARE_PORTFOLIO_POST_TYPE),
            array(	"hierarchical" => true,
                "label" => "Categories",
                "singular_label" => "Categories",
                "rewrite" => true,
                "query_var" => true
            ));

        register_taxonomy("portfolio_type",
            array(DESIGNARE_PORTFOLIO_POST_TYPE),
            array(	"hierarchical" => true,
                "label" => "Portfolios",
                "singular_label" => "Portfolios",
                "rewrite" => true,
                "query_var" => true
            ));
    }
}


/**
 * Registers the portfolio custom type.
 */
if (!function_exists('designare_register_portfolio_post_type')){
    function designare_register_portfolio_post_type() {
        $portfolio_permalink = get_option(DESIGNARE_SHORTNAME."_portfolio_permalink");
        //the labels that will be used for the portfolio items
        $labels = array(
            'name' => _x('Projects', 'portfolio name','yunik'),
            'singular_name' => _x('Project Item', 'portfolio type singular name','yunik'),
            'add_new' => __('Add New','yunik'),
            'add_new_item' => __('Add New Item','yunik'),
            'edit_item' => __('Edit Item','yunik'),
            'new_item' => __('New Project Item','yunik'),
            'view_item' => __('View Item','yunik'),
            'search_items' => __('Search Project Items','yunik'),
            'not_found' =>  __('No project items found','yunik'),
            'not_found_in_trash' => __('No project items found in Trash','yunik'),
            'parent_item_colon' => ''
        );

        //register the custom post type
        register_post_type( DESIGNARE_PORTFOLIO_POST_TYPE,
            array( 'labels' => $labels,
                'public' => true,
                'show_ui' => true,
                'capability_type' => 'post',
                'menu_icon' => get_template_directory_uri() . '/img/designare_icons/projectsicon.png',
                'hierarchical' => false,
                'rewrite' => array( 'with_front' => 'false', 'slug' => $portfolio_permalink ),
                'taxonomies' => array('portfolio_category'),
                'supports' => array('title', 'editor', 'thumbnail', 'comments', 'page-attributes', 'excerpt') ) );


    }
}



/* ------------------------------------------------------------------------*
 * SET THE DEFAULT IMAGE SIZES FOR THE PORTFOLIO ITEMS REGARDING THE
 * NUMBER OF COLUMNS
 * ------------------------------------------------------------------------*/

if (!function_exists('portfolio_columns')){
    function portfolio_columns($columns) {
        $columns['category'] = 'Category';
        $columns['type'] = 'Portfolio';
        return $columns;
    }
}

/**
 * Add category column to the portfolio items page
 * @param $name
 */
if (!function_exists('portfolio_show_columns')){
    function portfolio_show_columns($name) {
        global $post;
        switch ($name) {
            case 'category':
                $cats = get_the_term_list( $post->ID, 'portfolio_category', '', ', ', '' );
                echo $cats;
                break;
            case 'type':
                $cats = get_the_term_list( $post->ID, 'portfolio_type', '', ', ', '' );
                echo $cats;
                break;
        }
    }
}


/**
 * Gets a list of custom taxomomies by type
 * @param $type the type of the taxonomy
 */
if (!function_exists('designare_get_taxonomies')){
    function designare_get_taxonomies($type){
        $args = array(
            'type' => 'post',
            'orderby' => 'id',
            'order' => 'ASC',
            'taxonomy' => $type,
            'hide_empty' => 1,
            'pad_counts' => false );

        $categories = get_categories( $args );

        return $categories;
    }
}


/**
 * Gets a list of custom taxomomies by slug
 * @param $term_id the slug
 */
if (!function_exists('designare_get_taxonomy_slug')){
    function designare_get_taxonomy_slug($term_id){
        global $wpdb;

        $res = $wpdb->get_results($wpdb->prepare("SELECT slug FROM $wpdb->terms WHERE term_id=%s LIMIT 1;", $term_id));
        $res=$res[0];
        return $res->slug;
    }
}

/**
 * Gets a list of custom taxomomy's children
 * @param $type the type of the taxonomy
 * @param $parent_id the slug of the parent taxonomy
 */
if (!function_exists('designare_get_taxonomy_children')){
    function designare_get_taxonomy_children($type, $parent_id){
        global $wpdb;

        if($parent_id!='-1'){
            $res = $wpdb->get_results($wpdb->prepare("SELECT t.term_id, t.name, t.slug FROM $wpdb->terms as t LEFT JOIN $wpdb->term_taxonomy tt ON t.term_id=tt.term_id WHERE tt.taxonomy=%s AND tt.parent=%s;", $type, $parent_id));
        }else{
            $res = $wpdb->get_results($wpdb->prepare("SELECT t.term_id, t.name, t.slug FROM $wpdb->terms as t LEFT JOIN $wpdb->term_taxonomy tt ON t.term_id=tt.term_id WHERE tt.taxonomy=%s;", $type));
        }
        return $res;
    }
}

if (!function_exists('designare_get_projects')){
    function designare_get_projects(){
        $proj = array();
        $args= array(
            'posts_per_page' =>-1,
            'post_type' => DESIGNARE_PORTFOLIO_POST_TYPE
        );
        query_posts($args);

        if(have_posts()) {
            while (have_posts()) {
                the_post();
                $proj[] = array("p_title"=>get_the_title(), "p_id"=>get_the_ID());
                //$ret .= get_the_title() . "|*|";
            }
        }

        return $proj;
    }
}


/*******+++++**/
/*	partners
/********+++++*/
/**
 * ADD THE ACTIONS
 */
add_action('init', 'designare_register_partners_post_type');  //functions/partners.php


/**
 * Registers the portfolio custom type.
 */
if (!function_exists('designare_register_partners_post_type')){
    function designare_register_partners_post_type() {

        register_taxonomy("partners_category",
            array(DESIGNARE_PARTNERS_POST_TYPE),
            array(	"hierarchical" => true,
                "label" => "Categories",
                "singular_label" => "Categories",
                "rewrite" => true,
                "query_var" => true,
                "show_admin_column" => true
            ));

        //the labels that will be used for the portfolio items
        $labels = array(
            'name' => _x('Partners', 'partners name','yunik'),
            'singular_name' => _x('Partners Item', 'partners type singular name','yunik'),
            'add_new' => __('Add New','yunik'),
            'add_new_item' => __('Add New Item','yunik'),
            'edit_item' => __('Edit Item','yunik'),
            'new_item' => __('New Partners Item','yunik'),
            'view_item' => __('View Item','yunik'),
            'search_items' => __('Search Partners Items','yunik'),
            'not_found' =>  __('No Partners items found','yunik'),
            'not_found_in_trash' => __('No partners items found in Trash','yunik'),
            'parent_item_colon' => ''
        );

        //register the custom post type
        register_post_type( DESIGNARE_PARTNERS_POST_TYPE,
            array( 'labels' => $labels,
                'public' => true,
                'show_ui' => true,
                'exclude_from_search' => true,
                'show_in_nav_menus' => false,
                'menu_icon' => get_template_directory_uri() . '/img/designare_icons/partnersicon.png',
                'capability_type' => 'post',
                'hierarchical' => false,
                'rewrite' => array('slug'=>'partners'),
                'taxonomies' => array('partners_category'),
                'supports' => array('title', 'thumbnail') ) );


    }
}


/*******+++++**/
/*	team
/********+++++*/
/**
 * ADD THE ACTIONS
 */
add_action('init', 'designare_register_team_post_type');  //functions/team.php


/**
 * Registers the portfolio custom type.
 */
if (!function_exists('designare_register_team_post_type')){
    function designare_register_team_post_type() {

        register_taxonomy("team_category",
            array(DESIGNARE_TEAM_POST_TYPE),
            array(	"hierarchical" => true,
                "label" => "Categories",
                "singular_label" => "Categories",
                "rewrite" => true,
                "query_var" => true,
                "show_admin_column" => true
            ));

        //the labels that will be used for the portfolio items
        $labels = array(
            'name' => _x('Team', 'team name','yunik'),
            'singular_name' => _x('Team Item', 'team type singular name','yunik'),
            'add_new' => __('Add New','yunik'),
            'add_new_item' => __('Add New Item','yunik'),
            'edit_item' => __('Edit Item','yunik'),
            'new_item' => __('New Team Item','yunik'),
            'view_item' => __('View Item','yunik'),
            'search_items' => __('Search Team Items','yunik'),
            'not_found' =>  __('No Team items found','yunik'),
            'not_found_in_trash' => __('No team items found in Trash','yunik'),
            'parent_item_colon' => ''
        );

        //register the custom post type
        register_post_type( DESIGNARE_TEAM_POST_TYPE,
            array( 'labels' => $labels,
                'public' => true,
                'show_ui' => true,
                'exclude_from_search' => true,
                'show_in_nav_menus' => false,
                'menu_icon' => get_template_directory_uri() . '/img/designare_icons/icon71.png',
                'capability_type' => 'post',
                'hierarchical' => false,
                'rewrite' => array('slug'=>'team'),
                'taxonomies' => array('team_category'),
                'supports' => array('title', 'editor', 'thumbnail') ) );


    }
}



/*******+++++**/
/*	testimonials
/********+++++*/
/**
 * ADD THE ACTIONS
 */
add_action('init', 'designare_register_testimonials_post_type');  //functions/testimonials.php


/**
 * Registers the portfolio custom type.
 */
if (!function_exists('designare_register_testimonials_post_type')){
    function designare_register_testimonials_post_type() {

        register_taxonomy("testimonials_category",
            array(DESIGNARE_TESTIMONIALS_POST_TYPE),
            array(	"hierarchical" => true,
                "label" => "Categories",
                "singular_label" => "Categories",
                "rewrite" => true,
                "query_var" => true,
                "show_admin_column" => true,
            ));

        //the labels that will be used for the portfolio items
        $labels = array(
            'name' => _x('Testimonials', 'testimonials name','yunik'),
            'singular_name' => _x('Testimonials Item', 'testimonials type singular name','yunik'),
            'add_new' => __('Add New','yunik'),
            'add_new_item' => __('Add New Item','yunik'),
            'edit_item' => __('Edit Item','yunik'),
            'new_item' => __('New Testimonials Item','yunik'),
            'view_item' => __('View Item','yunik'),
            'search_items' => __('Search Testimonials Items','yunik'),
            'not_found' =>  __('No testimonials items found','yunik'),
            'not_found_in_trash' => __('No testimonials items found in Trash','yunik'),
            'parent_item_colon' => ''
        );

        //register the custom post type
        register_post_type( DESIGNARE_TESTIMONIALS_POST_TYPE,
            array( 'labels' => $labels,
                'public' => true,
                'show_ui' => true,
                'exclude_from_search' => true,
                'show_in_nav_menus' => false,
                'menu_icon' => get_template_directory_uri() . '/img/designare_icons/testicon.png',
                'capability_type' => 'post',
                'hierarchical' => false,
                'rewrite' => array('slug'=>'testimonials'),
                'taxonomies' => array('testimonials_category'),
                'supports' => array('title', 'editor', 'thumbnail', 'comments', 'page-attributes') ) );


    }
}

if (!function_exists('des_init_cpt_plugin')){
    function des_init_cpt_plugin(){
        designare_register_portfolio_category();
        designare_register_portfolio_post_type();
        designare_register_partners_post_type();
        designare_register_team_post_type();
        designare_register_testimonials_post_type();
    }
}

?>