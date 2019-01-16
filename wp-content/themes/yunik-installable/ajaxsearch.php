<?php
	
	$path = dirname(__FILE__);
	$os = ((strpos(strtolower(PHP_OS), 'win') === 0) || (strpos(strtolower(PHP_OS), 'cygwin') !== false)) ? 'win' : 'other';
	$abspath = ($os === "win") ? substr($path, 0, strpos($path, "\wp-content"))."\wp-load.php" : substr($path, 0, strpos($path, "/wp-content"))."/wp-load.php";
	require_once($abspath);
	
	$results = "";
	
	if ($_POST['se'] == "on"){
		$args = array(
			'showposts' => -1,
			'post_status' => 'publish',
			's' => $_POST['query']
		);
	} else {
		$args = array(
			'showposts' => -1,
			'post_status' => 'publish',
			'post_type' => 'post',
			's' => $_POST['query']
		);
	}
    
    $the_query = new WP_Query( $args );
    
	if ( $the_query->have_posts() ) {
		$first = true;
		$selected = "";
		while ( $the_query->have_posts() ) {
			$the_query->the_post();

			if ($first)	{
				$first = false;
				$selected = "selected";
			} else {
				$selected = "";
			}
			$results .= "<li class='".$selected."'><a href='".get_permalink()."'><strong>".get_the_title()."</strong><span>";
			if (get_option(DESIGNARE_SHORTNAME."_search_show_author") == "on") $results .= ", ".__(get_option(DESIGNARE_SHORTNAME."_by_text"),"yunik")." ".get_the_author();
			if (get_option(DESIGNARE_SHORTNAME."_search_show_date") == "on")
			$results .= ", ".get_the_date("M")." ".get_the_date("d").", ".get_the_date("Y");
			if (get_option(DESIGNARE_SHORTNAME."_search_show_categories") == "on"){
				$categories = get_the_category();
				$firstcat = true;
				if ($categories){
					foreach($categories as $category) {
						if ($category->term_id != 1){
							if ($firstcat){
								$results .= ", ".__(get_option(DESIGNARE_SHORTNAME."_in_text"),"yunik")." <i>";
								$firstcat = false;
								$results .= $category->cat_name;
							} else {
								$results .= ", ".$category->cat_name;
							}	
						}
					}
				}
				if (!$firstcat) $results .= "</i>";
			}
			if (get_option(DESIGNARE_SHORTNAME."_search_show_tags") == "on"){
				$tags = get_the_tags();
				$firsttag = true;
				if ($tags){
					foreach($tags as $tag) {
						if ($firsttag){
							$results .= ", ".__(get_option(DESIGNARE_SHORTNAME."_in_text"),"yunik")." <i>";
							$firsttag = false;
							$results .= $tag->name;
						} else {
							$results .= ", ".$tag->name;
						}
					}
				}
				if (!$firsttag) $results .= "</i>";
			}
			$results .= "</span></a></li>";
		}
	} else {
		$results .= "<li><a>".__(get_option(DESIGNARE_SHORTNAME."_no_results_text"),"yunik")."</a></li>";
	}
	
	echo $results;

?>