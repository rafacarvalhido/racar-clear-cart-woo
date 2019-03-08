<?php 
/*
Plugin Name: RaCar Clear Cart for WooCommerce
Plugin URI:  https://programawordpress.pro.br/
Description: This plugin adds a convenient button to empty the shopping cart. Clear the entire cart with one click.
Version:     0.1 20190306
Author:      Rafa Carvalhido
Author URI:  https://programawordpress.pro.br/blog/contato/rafa-carvalhido/
Text Domain: rccwoo-textdomain
Domain Path: /languages
License:     GPL2

RaCar Clear Cart WooCommerce is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.
 
RaCar Clear Cart WooCommerce is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
 
You should have received a copy of the GNU General Public License
along with RaCar Clear Cart WooCommerce.
*/

	/*=========================================================================*/ 
	/* SECURITY CHECKS */
	if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

	if ( ! defined( 'WPINC' ) ) die; // If this file is called directly, abort.
	
	//if ( is_admin() && ! defined( 'DOING_AJAX' ) ) {
	if( wp_doing_ajax() ) {
		return;
	}
	

	
	
	
	/*=========================================================================*/
	// PLUGIN INCLUDES
	
	include 'includes/rccwoo-functions.php';
	include 'includes/class-rccwoo_plugin.php';
	
	
	/*=========================================================================*/ 
	// PLUGIN DEPENDENCIES
	$woo_path = ABSPATH . 'wp-content/plugins/woocommerce/woocommerce.php';
	include_once dirname( __FILE__ ) . '/includes/class-rccwoo_dependencies.php';
	register_activation_hook( __FILE__, array( 'rccwoo_Dependencies', 'on_activate_function' ) );
	add_action( 'deactivated_plugin' , 'rccwoo_detect_plugin_deactivation', 10, 2 );
	register_deactivation_hook( $woo_path , 'when_wc_deactivate');

	function when_wc_deactivate() {
		//add_action( 'admin_notices', 'so_32551934_woocommerce_warning' );
		update_option('plugin_status', 'inactive');
	}

	
	function rccwoo_detect_plugin_deactivation( $plugin, $network_activation ) {
		global $rccwoo_basename;
		if( $plugin == "woocommerce/woocommerce.php" ) {
			deactivate_plugins( $rccwoo_basename );
			$url = admin_url( 'plugins.php?deactivate=true' );
			header( "Location: $url" );
			//add_action( 'admin_notices', 'so_32551934_woocommerce_warning' );
			die();
		}
		
	}

	/*=========================================================================*/
	// ADMIN PANEL
	if( true === is_admin() ){ // admin actions
		include 'admin/class-rccwoo_Action_List.php';
		$starta_plugin_action_list = new rccwoo_Action_List();
		add_action( 'admin_enqueue_scripts' , 'rccwoo_register_admin_resources' );
		include 'admin/class-rccwoo_Admin_Options.php';
	}
	
	
	
	/*=========================================================================*/
	// SYSTEM VARIABLES
	global $rccwoo_basename;
	$rccwoo_basename = plugin_basename(__FILE__);
	
	$rccwoo_NOME_STYLESHEET = 'rccwoo-stylesheet';
	$rccwoo_DIR_STYLESHEET = '../css/';
	$rccwoo_EXT_STYLESHEET = '.css';
	
	$rccwoo_NOME_JAVASCRIPT = 'rccwoo-javascript';
	$rccwoo_DIR_JAVASCRIPT = '../js/';
	$rccwoo_EXT_JAVASCRIPT = '.js';
	
	$rccwoo_OPTIONSON = TRUE;
	//$rccwoo_OPTIONSON = FALSE;
	
	// unused for now
	/*$rccwoo_NOME_ADMIN_STYLESHEET;
	$rccwoo_DIR_STYLESHEET;
	$rccwoo_EXT_STYLESHEET;*/
	
	$rccwoo_NOME_ADMIN_JAVASCRIPT = 'rccwoo-admin-javascript';
	$rccwoo_DIR_ADMIN_JAVASCRIPT = '../admin/js/';
	$rccwoo_EXT_ADMIN_JAVASCRIPT = '.js';
	
	
	/*=========================================================================*/
	// PLUGIN RESOURCES TO BE ENQUEUED
	add_action( 'wp_enqueue_scripts', 'rccwoo_register_resources' );
	
	
	/*=========================================================================*/
	// LOAD PLUGIN TEXTDOMAIN
	add_action( 'init', 'rccwoo_load_textdomain' );
	
	
	/*=========================================================================*/
	// START PLUGIN
	
	function start_rccwoo_plugin() {
		$plugin_is_on = new rccwoo_Plugin;
	}
	start_rccwoo_plugin();
	
	
	/*=========================================================================*/
	
	
?>