<?php
/*
  Plugin Name: LTR <=> RTL Admin content
  Plugin URI: http://WPwith.us/plugins/ltr-admin
  Description: Enable LTR in admin content area. Click the admin bar button to switch between RTL & LTR.
  This plugin adds a button to  the admin bar.
  Clicking the button switches between RTL & LTR text direction of current page content only.
  The LTR/RTL state is saved in current browser only.
  Author: Ronny Sherer
  Author URI: http://WPwith.us
  Text Domain: ltr-admin
  Version: 0.4

  Copyright 2014 - 2015 WPwith.us
*/

defined('ABSPATH') || die('This file cannot be ');

function admin_body_ltr_scripts()
{
	wp_enqueue_style( 'admin-body-ltr', plugins_url( 'ltr-admin.css' , __FILE__ ) );
	wp_enqueue_script( 'admin-body-ltr', plugins_url( 'ltr-admin.js' , __FILE__ ), array( 'jquery' ), '0.1', true );
}

add_action( 'admin_enqueue_scripts', 'admin_body_ltr_scripts' );

function admin_body_ltr_adminbar($wp_admin_bar)
{
	if (!is_admin())
		return;

	$args = array(
			'id' => 'custom-button',
			'title' => '<span id="dir-rtl">RTL</span><i></i><span id="dir-ltr">LTR</span>',
			'href' => '#',
			'meta' => array(
				'class' => 'admin-body-ltr-adminbar',
				'title' => __('Switch admin content direction between RTL and LTR', 'ltr-admin')));

	$wp_admin_bar->add_node($args);
}

add_action('admin_bar_menu', 'admin_body_ltr_adminbar', 100);


function plugins_loaded_ltr_admin()
{
	load_plugin_textdomain( 'ltr-admin', false, dirname(plugin_basename(__FILE__)).'/languages' );
}
add_action( 'plugins_loaded', 'plugins_loaded_ltr_admin', 999999);
