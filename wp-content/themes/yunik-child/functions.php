<?php

	

	if (!defined('DESIGNARE_SHORTNAME')) define('DESIGNARE_SHORTNAME', 'yunik');

// show admin bar only for admins and editors

if (!current_user_can('edit_posts')) {

        add_filter('show_admin_bar', '__return_false');

}

	



/** changing default wordpres email settings */

add_filter('wp_mail_from', 'new_mail_from');

add_filter('wp_mail_from_name', 'new_mail_from_name');

 

function new_mail_from($old) {

 return 'info@kidum10.co.il';

}

function new_mail_from_name($old) {

 return 'קידום';

} 

 /*

function my_password_form() {

    global $post;

    $label = 'pwbox-'.( empty( $post->ID ) ? rand() : $post->ID );

    $o = '<form class="pas-block-form" action="' . esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ) . '" method="post">

    <p>' . __( " התחדשות עירונית – ירושלים. כדי לצפות בתוכן זה יש להזין סיסמא:" ) . '</p>

    <label for="' . $label . '">' . __( "Password:" ) . ' </label><input name="post_password" id="' . $label . '" type="password" size="20" maxlength="20" /><input type="submit" name="Submit" value="' . esc_attr__( "כניסה" ) . '" />

    <p>' . __( "* במידה ולא קיבלת סיסמא, ניתן לפנות למשרדנו" ) . '</p>

    </form>

    ';

    return $o;

}

add_filter( 'the_password_form', 'my_password_form' );*/

/*function to add async to all scripts*/



/* Remove the "Dashboard" from the admin menu for non-admin users */

function wpse52752_remove_dashboard () {

    global $current_user, $menu, $submenu;

    get_currentuserinfo();



    if( ! in_array( 'administrator', $current_user->roles ) ) {

        reset( $menu );

        $page = key( $menu );

        while( ( __( 'Dashboard' ) != $menu[$page][0] ) && next( $menu ) ) {

            $page = key( $menu );

        }

        if( __( 'Dashboard' ) == $menu[$page][0] ) {

            unset( $menu[$page] );

        }

        reset($menu);

        $page = key($menu);

        while ( ! $current_user->has_cap( $menu[$page][1] ) && next( $menu ) ) {

            $page = key( $menu );

        }

        if ( preg_match( '#wp-admin/?(index.php)?$#', $_SERVER['REQUEST_URI'] ) &&

            ( 'index.php' != $menu[$page][2] ) ) {

                wp_redirect( get_option( 'siteurl' ) . '/wp-admin/edit.php');

        }

    }

}

add_action('admin_menu', 'wpse52752_remove_dashboard');



?>