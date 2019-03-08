<?php
/*
*  
* includes/rccwoo-functions.php
* holds all main functions of plugin. This is the brain!
*  
*/	
	if( ! function_exists('rccwoo_register_resources') ) {
		function rccwoo_register_resources(){
			rccwoo_script_file();
			rccwoo_style_file();
		}
	}
	
	if( ! function_exists('rccwoo_script_file') ) {
		function rccwoo_script_file() {
			global $rccwoo_NOME_JAVASCRIPT;
			global $rccwoo_DIR_JAVASCRIPT;
			global $rccwoo_EXT_JAVASCRIPT;
			wp_register_script( $rccwoo_NOME_JAVASCRIPT, plugins_url( $rccwoo_DIR_JAVASCRIPT.$rccwoo_NOME_JAVASCRIPT.$rccwoo_EXT_JAVASCRIPT, __FILE__ ) );
			wp_enqueue_script( $rccwoo_NOME_JAVASCRIPT );
		}
	}
	
	if( ! function_exists('rccwoo_style_file') ) {
		function rccwoo_style_file() {
			global $rccwoo_NOME_STYLESHEET;
			global $rccwoo_DIR_STYLESHEET;
			global $rccwoo_EXT_STYLESHEET;
			// Respects SSL, Style.css is relative to the current file
			wp_register_style( $rccwoo_NOME_STYLESHEET, plugins_url( $rccwoo_DIR_STYLESHEET.$rccwoo_NOME_STYLESHEET.$rccwoo_EXT_STYLESHEET, __FILE__ ) );
			wp_enqueue_style( $rccwoo_NOME_STYLESHEET );
		}
	}

	
	if( ! function_exists('rccwoo_register_admin_resources') ) {
		function rccwoo_register_admin_resources() {
			rccwoo_register_admin_script();
			rccwoo_register_admin_style();
		}
	}

	if( ! function_exists('rccwoo_register_admin_style') ) {
		function rccwoo_register_admin_style() {
			global $rccwoo_NOME_ADMIN_STYLESHEET;
			global $rccwoo_DIR_STYLESHEET;
			global $rccwoo_EXT_STYLESHEET;

			wp_register_style( $rccwoo_NOME_ADMIN_STYLESHEET, $rccwoo_DIR_STYLESHEET.$rccwoo_NOME_ADMIN_STYLESHEET.$rccwoo_EXT_STYLESHEET , array() , '0.1' );
			wp_enqueue_style( $rccwoo_NOME_ADMIN_STYLESHEET );
		}
	}
	
	if( ! function_exists('rccwoo_register_admin_script') ) {
		function rccwoo_register_admin_script() {
			global $rccwoo_NOME_ADMIN_JAVASCRIPT;
			global $rccwoo_DIR_ADMIN_JAVASCRIPT;
			global $rccwoo_EXT_ADMIN_JAVASCRIPT;
			wp_register_script( $rccwoo_NOME_ADMIN_JAVASCRIPT, plugins_url( $rccwoo_DIR_ADMIN_JAVASCRIPT.$rccwoo_NOME_ADMIN_JAVASCRIPT.$rccwoo_EXT_ADMIN_JAVASCRIPT, __FILE__ ) , array( 'jquery', 'wp-color-picker' ) , microtime() , true );
			wp_enqueue_script( $rccwoo_NOME_ADMIN_JAVASCRIPT );
		}
	}
	
	/**
	 * Load plugin textdomain.
	 *
	 * @since 1.0.0
	 */
	function rccwoo_load_textdomain() {
		global $rccwoo_basename;
		$textdomain_loaded = load_plugin_textdomain( 'rccwoo-textdomain', false, basename( dirname( __DIR__ ) ) . '/languages' ); 
	}
	
	
	
	
?>