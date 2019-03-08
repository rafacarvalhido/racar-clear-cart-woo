<?php
/*
*  
* includes/class-rccwoo-dependencies.php
*  
*/	
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! defined( 'WPINC' ) ) die; // If this file is called directly, abort.
	


if( ! class_exists( 'rccwoo_Dependencies' ) ) {	
	class rccwoo_Dependencies {
		
		public static function on_activate_function() {
			// Check if Woo is active
			if( ! in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
				wp_die( __( 'Please activate WooCommerce first in order to run', 'rccwoo-textdomain' ) . ' RaCar Clear Cart for WooCommerce' , 'Plugin dependency check' , array( 'back_link' => true ) );
			}
        }
	}
}
	
