<?php
/**
 * Custom pages - this file contains ana manages the main functionality that is related
 * with custom pages. Custom pages are pages that allow adding items from selected post types.
 * The items data(fields) that should be added is set within an array and the custom pages
 * structure is built depending on the data set in that array.
 */

add_action('admin_menu', 'designare_add_custom_pages');
add_action('wp_ajax_designare_insert_post', 'designare_insert_post');
add_action('wp_ajax_designare_add_instance', 'designare_add_instance');
add_action('wp_ajax_designare_save_order', 'designare_save_order');
add_action('wp_ajax_designare_detele_item', 'designare_detele_item');
add_action('wp_ajax_designare_edit_item', 'designare_edit_item');
add_action('wp_ajax_designare_detele_instance', 'designare_detele_instance');



//define the main constants that will be used
define("DESIGNARE_CUSTOM_PREFIX", 'custom_');
define("DESIGNARE_DEFAULT_TERM", 'default');
define("DESIGNARE_TERM_SUFFIX", '_category');
define("DESIGNARE_NONCE", 'designare-custom-page');

$designare_data->custom_pages=array();
/**
 * Adds all the custom pages to the menu.
 */
function designare_add_custom_pages(){
	global $designare_data;

	foreach($designare_data->custom_pages as $page){
		$portfolio_permalink = get_option(DESIGNARE_SHORTNAME."_portfolio_permalink");
		add_theme_page( 'edit.php?post_type='.$portfolio_permalink, $page->page_name, 'delete_pages', $page->post_type, 'designare_build_custom_page' );		
	}
}

/**
 * Returns all the main sliders data that are registered for the theme.
 */
function designare_get_custom_sliders(){
	global $designare_data;
	$sliders=array();
	
	foreach($designare_data->custom_pages as $id=>$page){
		
		if($page->type==DESIGNARE_SLIDER_TYPE){
			$sliders[]=array('id'=>$id, 'name'=>$page->page_name, 'class'=>$id, 'type'=>'image');
		}
		
		else if($page->type==DESIGNARE_VIDEO_TYPE){
			$sliders[]=array('id'=>$id, 'name'=>$page->page_name, 'class'=>$id, 'type'=>'video');
		}
		
		else if($page->type==DESIGNARE_FLEXSLIDER_TYPE){
			$sliders[]=array('id'=>$id, 'name'=>$page->page_name, 'class'=>$id, 'type'=>'slider');
		}
		
		else if($page->type==DESIGNARE_CAMERASLIDER_TYPE){
			$sliders[]=array('id'=>$id, 'name'=>$page->page_name, 'class'=>$id, 'type'=>'camera');
		}
		
	}
	return $sliders;
}

/**
 * Generates arrays containing all the sliders names, so that this data would be used in an drop down select.
 */
function designare_get_created_sliders(){
	$designare_slider_data=array();
	$designare_sliders=designare_get_custom_sliders();
	
	foreach($designare_sliders as $slider){
		$slider_id=$slider['id'];
		
		//the slider caption that will be shown in a select box as disabled
		if($slider['type'] == 'image')
			$designare_slider_data[]=array('id'=>'disabled', 'name'=>'--- Photo Collection ---', 'class'=>'caption');
		else if($slider['type'] == 'video')
			$designare_slider_data[]=array('id'=>'disabled', 'name'=>'--- Video Collection ---', 'class'=>'caption');
		
		$terms=get_terms($slider_id.DESIGNARE_TERM_SUFFIX, array('hide_empty'=>false, 'orderby'=>'id', 'order'=>'desc'));
		//display all the instances of the page
		foreach($terms as $term){
			if($slider_id != 'slider_collection'){
				$name=$term->name==DESIGNARE_DEFAULT_TERM?$term->name.' '.$slider['name']:$term->name;
				$designare_slider_data[]=array('id'=>designare_generate_slider_id($slider_id, $term->term_id), 'name'=>ucfirst($name));
			}
		}

	}
	return $designare_slider_data;
}

function designare_get_created_sliders2(){
	$designare_slider_data=array();
	$designare_sliders=designare_get_custom_sliders();

	foreach($designare_sliders as $slider){
		$slider_id=$slider['id'];
		
		$terms=get_terms($slider_id.DESIGNARE_TERM_SUFFIX, array('hide_empty'=>false, 'orderby'=>'id', 'order'=>'desc'));
		//display all the instances of the page
		foreach($terms as $term){
			if($slider_id == 'slider_collection'){
				$name=$term->name==DESIGNARE_DEFAULT_TERM?$term->name.' '.$slider['name']:$term->name;
				$designare_slider_data[]=array('id'=>designare_generate_slider_id($slider_id, $term->term_id), 'name'=>ucfirst($name));
			}
		}
		
	}

	return $designare_slider_data;
}


function designare_get_revsliders(){
	global $wpdb;
	$designare_slider_data = array();
	$table_name = $wpdb->prefix."revslider_sliders";
	if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
	    //table is not created. plugin is yet to install.
	} else {
		$q = "SELECT * from ".$wpdb->prefix."revslider_sliders";
		$revs = $wpdb->get_results($q, ARRAY_A);
		
		if ( $revs ) {
			foreach($revs as $r) {
				array_push($designare_slider_data, array('id'=>"revSlider_".$r['alias'], 'name'=>$r['title']));	
			}
		}	
	}

	return $designare_slider_data;	
}

function designare_get_created_camera_sliders(){
	$designare_slider_data=array();
	global $wpdb;
	
	/* rev sliders */
	$table_name = $wpdb->prefix."revslider_sliders";
	if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
	    //table is not created. plugin is yet to install.
		$designare_slider_data = array(array('id'=>'no_slider','name'=>'No Sliders Found.'));
	} else {
		$q = "SELECT * from ".$wpdb->prefix."revslider_sliders";
		$revs = $wpdb->get_results($q, ARRAY_A);
		
		$revsliders = array();
		if ( $revs ) {
			foreach($revs as $r) {
				array_push($revsliders, array('id'=>"revSlider_".$r['alias'], 'name'=>$r['title']));	
			}
		}
		
		if (count($revsliders)>0){
			$designare_slider_data = array_merge($designare_slider_data,$revsliders);
		} else {
			$designare_slider_data = array(array('id'=>'no_slider','name'=>'No Sliders Found.'));
		}
	}
	return $designare_slider_data;
}

function designare_generate_slider_id($name, $term_id){
	return $name.':'.$term_id;
}

function designare_get_slider_data($id){
	global $designare_data;
	
	$parts=explode(':', $id);
	$post_type=$parts[0];
	$category=$parts[1];
	$taxonomy=$post_type.DESIGNARE_TERM_SUFFIX;
	
	$daslug = "";
	if (isset(get_term($category, $taxonomy)->slug)) $daslug = get_term($category, $taxonomy)->slug;

	$args=array('numberposts' => -1, 
				'post_type' => $post_type, 
				$taxonomy=>$daslug);
				
	$posts = get_posts( $args );
	$ordered_posts=designare_get_ordered_post_list($posts, $category,$post_type);
	
	$post_data=array();
	//get the file name that will display the data
	$post_data['filename']=$designare_data->custom_pages[$post_type]->file_name;
	$post_data['posts']=$ordered_posts;
	return $post_data;
}

/**
 * Builds a custom page - when the page is opened, an object from a manager class builds the page structure.
 */
function designare_build_custom_page(){
	if(isset($_GET['page'])){
		global $designare_data;

		$pageid=$_GET['page'];
		$custom_page=$designare_data->custom_pages[$pageid];
		$custom_page_manager=new DesignareCustomPageManager($custom_page, DESIGNARE_CUSTOM_PREFIX, DESIGNARE_TERM_SUFFIX, DESIGNARE_DEFAULT_TERM, DESIGNARE_NONCE);
		$custom_page_manager->build_page();
	}

}

function designare_print_sliders_page(){
	//TODO Customize sliders page
	echo 'Sliders';
}

/**
 * Inserts a post - this is the function that is called via AJAX request, when
 * a new custom post should be inserted.
 */
function designare_insert_post(){
	//check the nonce field for security
	check_ajax_referer(DESIGNARE_NONCE, 'nonce');

	global $designare_data, $current_user;

	$post_type=$_POST['post_type'];
	$custom_page=$designare_data->custom_pages[$post_type];

	//insert the post
	$dataManager=new DesignareCustomDataManager();
	$post=$dataManager->insert_post($_POST, $custom_page, DESIGNARE_CUSTOM_PREFIX, DESIGNARE_TERM_SUFFIX);

	//get the display template for the inserted post
	$templater=new DesignareTemplater();
	echo $templater->get_custom_page_list_template($post, $custom_page, DESIGNARE_CUSTOM_PREFIX);
	die();

}

/**
 * Creates a new instance of a custom page item - it is related with inserting a new
 * category from the selected custom post type.
 */
function designare_add_instance(){

	//check the nonce field for security
	check_ajax_referer(DESIGNARE_NONCE, 'nonce');

	global $designare_data;

	//insert a new category(term) for the custom post type
	$res=wp_insert_term( $_POST['name'], $_POST['taxonomy']);
	$custom_page=$designare_data->custom_pages[$_POST['post_type']];

	if($res instanceof WP_Error){
		$html='-1';
	}else{
		$templater=new DesignareTemplater();
		$html=$templater->get_before_custom_section($_POST['name']);
		$html.=$templater->get_custom_page_form_template($_POST['name'], $res['term_id'], $custom_page, DESIGNARE_CUSTOM_PREFIX);
		$html.='<ul class="sortable"></ul>'.$templater->get_after_custom_section();
	}

	echo $html;
	die();

}

/**
 * Saves the new order of the items - should be called via AJAX post request, 
 * the following parameters should be set in the request:
 * - order - the new order to be saved (as a string, separated by commas)
 * - category - the category the items to be ordered belong to
 */
function designare_save_order(){
	//check the nonce field for security
	check_ajax_referer(DESIGNARE_NONCE, 'nonce');

	if(isset($_POST['order'])&& $_POST['order'] && isset($_POST['category']) && $_POST['category'] && isset($_POST['posttype'])){
			update_option('designare_order'.$_POST['category'].$_POST['posttype'], $_POST['order']);
	}
}

/**
 * Creates an ordered post list - gets the unordered posts and the order string
 * saved as option that corresponds to those post group.
 * @param $posts the posts to be ordered
 * @param $category the category the posts belong to
 * @return an array of the posts that ordered according to the saved order
 */
function designare_get_ordered_post_list($posts, $category, $posttype){
	$new_post_array=array();

	$order=explode(',',get_option('designare_order'.$category.$posttype));
	if(sizeof($order)!=sizeof($posts)){
		return $posts;
	}else{
		//make the post array key the ID of the post so that it can be accessed by ID
		foreach($posts as $post){
			$new_post_array[$post->ID]=$post;
		}
			
		foreach($order as $index){
			$ordered_post_array[]=$new_post_array[$index];
		}
	}

	return $ordered_post_array;
}

/**
 * Deletes an item and changes the saved item order not to contain this item. Should be called via AJAX post request, 
 * the following parameters should be set in the request:
 * - itemid - the ID of the item to be deleted
 * - category - the category the item belongs to
 */
function designare_detele_item(){
	//check the nonce field for security
	check_ajax_referer(DESIGNARE_NONCE, 'nonce');

	if(isset($_POST['itemid']) && isset($_POST['category']) && isset($_POST['posttype'])){
		$res=wp_delete_post($_POST['itemid']);
		if($res){
			//the item has been deleted successfully, update the new order value
			$order_option='designare_order'.$_POST['category'].$_POST['posttype'];
			$order_arr=explode(',',get_option($order_option));
			$new_order=designare_remove_item_by_value($order_arr,$_POST['itemid']);
			update_option($order_option, implode(',',$new_order));
		}else{
			echo '-1';
			die();
		}
	}
}

/**
 * Edits an item - Should be called via AJAX post request, 
 * the following parameters should be set in the request:
 * - itemid - the ID of the item to be edited
 */
function designare_edit_item(){
	//check the nonce field for security
	check_ajax_referer(DESIGNARE_NONCE, 'nonce');

	if(isset($_POST['itemid'])&& $_POST['itemid']){
		$dataManager=new DesignareCustomDataManager();
		$post=$dataManager->edit_post($_POST, DESIGNARE_CUSTOM_PREFIX);
	}
}

/**
 * Deletes a group of items with their parent instance. Should be called via AJAX request, 
 * the following parameters should be set in the request:
 * - category - the category (term name) the slider represents
 * - taxonomy - the taxonomy name
 * - post_type - the type of the posts the slider contains
 */
function designare_detele_instance(){
	//check the nonce field for security
	check_ajax_referer(DESIGNARE_NONCE, 'nonce');

	if(isset($_POST['category'])&& isset($_POST['taxonomy'])){
		$dataManager=new DesignareCustomDataManager();
		$dataManager->delete_term($_POST['category'],$_POST['taxonomy'],$_POST['post_type']);
	}
}
