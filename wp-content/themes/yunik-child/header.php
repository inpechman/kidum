<?php
/**
 * @package WordPress
 * @subpackage Yunik
 */
?><!DOCTYPE html>
<!--[if lt IE 7 ]> <html <?php language_attributes(); ?> class="ie6"> <![endif]-->
<!--[if IE 7 ]>    <html <?php language_attributes(); ?> class="ie7"> <![endif]-->
<!--[if IE 8 ]>    <html <?php language_attributes(); ?> class="ie8"> <![endif]-->
<!--[if IE 9 ]>    <html <?php language_attributes(); ?> class="ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html <?php language_attributes(); ?>> <!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<?php
		if (get_option(DESIGNARE_SHORTNAME."_disable_responsive") !== "on"){
			?>
			<meta content="width=device-width, initial-scale=1.0, maximum-scale=1" name="viewport">
			<?php		
		}
	?>
	<?php
		if (get_option('yunik_enable_theme_seo') === 'on'){
			if (get_option(DESIGNARE_SHORTNAME."_seo_author")){
				?>
				<title><?php echo get_option(DESIGNARE_SHORTNAME."_seo_sitetitle"); ?></title>
				<?php
			} else {
				?>
				<title><?php
				global $page, $paged, $woocommerce;
				wp_title( '|', true, 'right' );
				bloginfo( 'name' );
				$site_description = get_bloginfo( 'description', 'display' );
				if ( $site_description && ( is_home() || is_front_page() ) )
					echo " | $site_description";
				if ( $paged >= 2 || $page >= 2 )
					echo ' | ' . sprintf( __( 'Page %s', 'yunik' ), max( $paged, $page ) );
				?></title>
				<?php
			}
			?>
			<meta name="keywords" content="<?php if(get_option(DESIGNARE_SHORTNAME."_seo_author")) echo get_option(DESIGNARE_SHORTNAME."_seo_author"); ?>">
			
			<meta name="author" content="<?php if(get_option(DESIGNARE_SHORTNAME."_seo_keywords")) echo get_option(DESIGNARE_SHORTNAME."_seo_keywords"); ?>">
			<?php
		} else {
			?>
			<title><?php
			global $page, $paged, $woocommerce;
			wp_title( '|', true, 'right' );
			bloginfo( 'name' );
			$site_description = get_bloginfo( 'description', 'display' );
			if ( $site_description && ( is_home() || is_front_page() ) )
				echo " | $site_description";
			if ( $paged >= 2 || $page >= 2 )
				echo ' | ' . sprintf( __( 'Page %s', 'yunik' ), max( $paged, $page ) );
			?></title>
			<?php
		}
	?>    
	<!-- Place favicon.ico and apple-touch-icons in the images folder -->
	
	<!-- favicon -->
	<link rel="shortcut icon" href="<?php if (get_option(DESIGNARE_SHORTNAME."_favicon")) echo get_option(DESIGNARE_SHORTNAME."_favicon"); else echo '#'; ?>">
	<link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/images/apple-touch-icon.png"><!--60X60-->
	<link rel="apple-touch-icon" sizes="72x72" href="<?php echo get_template_directory_uri(); ?>/images/apple-touch-icon-ipad.png"><!--72X72-->
	<link rel="apple-touch-icon" sizes="114x114" href="<?php echo get_template_directory_uri(); ?>/images/apple-touch-icon-iphone4.png"><!--114X114-->
	<link rel="apple-touch-icon" sizes="144x144" href="<?php echo get_template_directory_uri(); ?>/images/apple-touch-icon-ipad3.png">	<!--144X144-->	
	
	<link rel="profile" href="http://gmpg.org/xfn/11" >

	
	<?php if ( is_singular() && get_option( 'thread_comments' ) ) wp_enqueue_script( 'comment-reply' ); ?>
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" >
	<link href='https://fonts.googleapis.com/css?family=Arimo:400,700&subset=hebrew,latin' rel='stylesheet' type='text/css'>
	<?php wp_head(); ?>
<link href="<?php bloginfo('url'); ?>/wp-content/themes/yunik-child/external.css" rel="stylesheet" type="text/css">
</head>

<?php
	//under construction feature.
	function des_under_construction(){
		$des_uc_id = get_option('yunik_under_construction_page');
		require_once('template-under-construction.php');
		exit;
	}
	if (get_option('yunik_enable_under_construction') === "on" && get_option('yunik_under_construction_page') != "0" && !is_user_logged_in()){
		add_action('template_redirect', des_under_construction());
	}
?>

<body <?php body_class(); if (get_option(DESIGNARE_SHORTNAME."_body_type") == "body_boxed") echo 'id="boxed_layout"'?>>
	
	<?php
		if (get_option(DESIGNARE_SHORTNAME."_enable_website_loader") == "on"){
			?>
			<div id="des_website_load">
			  	<div class="spinner">
				  	<?php
					  	$spinner = get_option(DESIGNARE_SHORTNAME."_website_loader");
					  	switch($spinner){
							case "ball-clip-rotate": case "square-spin": case "ball-rotate": case "ball-scale": case "ball-scale-ripple":
								//1
								$divs = "<div></div>";
							break;
							case "ball-clip-rotate-pulse": case "ball-clip-rotate-multiple": case "cube-transition": case "ball-zig-zag":
								//2
								$divs = "<div></div><div></div>";
							break;
							case "ball-pulse": case "ball-triangle-path": case "ball-scale-multiple": case "ball-pulse-sync": case "ball-beat": case "ball-scale-ripple-multiple":
								//3
								$divs = "<div></div><div></div><div></div>";
							break;
							case "line-scale-party":
								//4
								$divs = "<div></div><div></div><div></div><div></div>";
							break;
							case "ball-pulse-rise": case "line-scale": case "line-scale-pulse-out": case "line-scale-pulse-out-rapid": case "pacman":
								//5
								$divs = "<div></div><div></div><div></div><div></div><div></div>";
							break;
							case "ball-spin-fade-loader": case "line-spin-fade-loader":
								//8
								$divs = "<div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div>";
							break;
							case "ball-grid-pulse":
								//9
								$divs = "<div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div>";
							break;
						}
						
						if ($spinner == "load2" || $spinner == "load3" || $spinner == "load6"){
							echo '<div class="loaders-style-box '.$spinner.'"><div class="loader"></div></div>';
						} else {
							echo '<div class="loaders-style-box loader-inner '.$spinner.'">'.$divs.'</div>';
						}
				  	?>
				</div>
				<?php
					if (get_option(DESIGNARE_SHORTNAME."_enable_website_loader_percentage") == "on"){
						?>
						<div class="percentage">0%</div>
						<?php
					}
				?>
		  	</div>
			<?php
		}
	?>
	
	<?php
		if (get_option(DESIGNARE_SHORTNAME."_body_type") == "body_boxed"){
			?>
			<div class="boxed_layout">
			<?php
		}
	?>