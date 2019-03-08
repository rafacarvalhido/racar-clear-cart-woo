<?php
/*
*
* classe PLUGIN´S ACTION LIST
* class-Plugin_Action_List.php
*
*/
/**
 * Prevent direct access to the script.
 */
if( ! defined( 'ABSPATH' ) ) {
	exit;
}

if( ! class_exists( 'rccwoo_Action_List' ) ) {	
	class rccwoo_Action_List {

		function __construct() {
			add_filter( 'plugin_action_links' , array( $this , 'add_plugin_action_links' ) , 10 , 2 );
		}
		
		
		public function add_plugin_action_links( $links , $file ) {
			global $rccwoo_basename;
			static $this_plugin;
			global $rccwoo_OPTIONSON;

			if( ! $this_plugin ) {
				$this_plugin = $rccwoo_basename;
			}

			// check to make sure we are on the correct plugin
			if( $file == $this_plugin ) {	
				$plugin_links = array();
				// check if plugin has options page and add address
				if( TRUE === $rccwoo_OPTIONSON ) {
					// link to what ever you want
					//$plugin_links[] = '<a href="' . get_bloginfo('wpurl') . '/wp-admin/widgets.php">Widgets</a>';
					$plugin_links[] = '<a href="' . get_bloginfo('wpurl') . '/wp-admin/admin.php?page=rccwoo-config">' . __( 'Settings' , 'rccwoo-textdomain') . '</a>';
					// add the links to the list of links already there
					
				}
				foreach( $plugin_links as $link ) {
					array_unshift( $links , $link );
				}
				
			}
			return $links;
		}
	}
}