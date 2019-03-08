<?php 
/*
*
* class Options Page
* class_Admin_Options.php
*
*/
/**
 * Prevent direct access to the script.
 */
if( ! defined( 'ABSPATH' ) ) {
	exit;
}

if( ! class_exists( 'rccwoo_Admin_Options' ) ) {	
	class rccwoo_Admin_Options {
		/**
		 * Holds the values to be used in the fields callbacks
		 */
		private $options;

		private $page_title = 'RaCar rccwoo Options Page';
		private	$menu_title = 'RaCar Plugins';
		private	$capability = 'manage_options';
		private	$menu_slug = 'racar-admin-page.php';
		private	$function_main_menu = 'racar_admin_page'; // if altering this, alter throughout this file.
		private	$icon_url = 'dashicons-lightbulb'; //dashicons
		private	$position = 99; 
		
		private $sub_page_title = 'Racar Clear Cart for WooCommerce';
		private $sub_menu_title = 'Clear Cart WC';
		private $capability_sub = 'manage_options';
		private $page_url = 'rccwoo-config';
		private $function_sub_page = 'rccwoo_options_page'; // if altering this, alter throughout this file.

		/**
		 * Start up
		 */
		public function __construct() {
			add_action( 'admin_menu', array( $this, 'racar_main_admin_menu' ) );
			add_action( 'admin_menu', array( $this, 'rccwoo_admin_menu' ) );
			add_action( 'admin_init', array( $this, 'remove_admin_submenu' ) );
			add_action( 'admin_init', array( $this, 'register_plugin_settings' ) );
		}

		/**
		 * Add options page
		 */
		/*public function add_plugin_page() {
			// This page will be under "Settings"
			add_options_page(
				'Settings Admin', 
				'My Settings', 
				'manage_options', 
				'my-setting-admin', 
				array( $this, 'create_admin_page' )
			);
		}*/
		public function racar_main_admin_menu() {
			global $menu;
			global $submenu;
			if( empty( $GLOBALS['admin_page_hooks']['racar-admin-page.php'] ) ) {
				add_menu_page( 
					$this->page_title, 
//					var_dump($menu) ,
//					var_dump($submenu), 
//					var_dump($GLOBALS['admin_page_hooks']['racar-admin-page.php']), 
					$this->menu_title, 
					$this->capability, 
					'racar-admin-page.php', 
					array( $this , $this->function_main_menu ),
					$this->icon_url, 
					$this->position
				);
//				remove_submenu_page( 'racar-admin-page.php' , 'racar-admin-page.php' );
			}	
		}
		
		public function remove_admin_submenu() {
			remove_submenu_page( 'racar-admin-page.php' , 'racar-admin-page.php' );
		}

		
		public function racar_admin_page(){
			?>
			<div class="wrap">
				<h1>Plugins RaCar</h1>
				
			</div>
			<?php
		}
		public function rccwoo_admin_menu() { 
			add_submenu_page( 
				'racar-admin-page.php',
				$this->sub_page_title,
				$this->sub_menu_title,
				$this->capability_sub,
				$this->page_url,
				array( $this , $this->function_sub_page )
			);
		}
		
		public function rccwoo_options_page() { 
			// Set class property
			$this->options = get_option( 'rccwoo_settings' );
			?>
				<form action='options.php' method='post'>
					<?php
						if( function_exists( 'wp_nonce_field' ) ) 
							wp_nonce_field( 'rccwoo_update_options' , 'nonce_rccwoo_settings' ); 
					?>
					<h2>RaCar Clear Cart for WooCommerce</h2>
					
					<?php 
					settings_fields( 'rccwoo_option_group_1' );
					do_settings_sections( 'rccwoo-options-page' );
					submit_button();
					?>

				</form>
			<?php
		}

		
		
		
		public function register_plugin_settings() { 
			register_setting(
				'rccwoo_option_group_1',  // Option group
				'rccwoo_settings' , // Options name
				array( $this, 'sanitize' ) // Sanitize 
			);
			
			add_settings_section(
				'rccwoo_section_1', // ID
				__( 'Preferences', 'rccwoo-textdomain' ), // title
				array( $this, 'plugin_settings_section_callback' ), // callback
				'rccwoo-options-page' // Page
			);
			
			add_settings_field( 
				'rccwoo_enabled', // ID
				__( 'Enable Plugin', 'rccwoo-textdomain' ), // Title 
				array( $this , 'rccwoo_enabled_render' ), // Callback
				'rccwoo-options-page',  // Page
				'rccwoo_section_1'  // Section   
			);
		
			add_settings_field( 
				'rccwoo_button_text', 
				__( 'Button Text', 'rccwoo-textdomain' ), 
				array( $this , 'rccwoo_button_text_render' ), 
				'rccwoo-options-page', 
				'rccwoo_section_1' 
			);
			
			add_settings_field( 
				'rccwoo_confirm_text', 
				__( 'Confirmation Text', 'rccwoo-textdomain' ), 
				array( $this , 'rccwoo_confirm_text_render' ), 
				'rccwoo-options-page', 
				'rccwoo_section_1' 
			);
			
			
			
			add_settings_field( 
				'rccwoo_radiobox_1', 
				__( 'Side', 'rccwoo-textdomain' ), 
				array( $this , 'rccwoo_radiobox_1_render' ), 
				'rccwoo-options-page', 
				'rccwoo_section_1' 
			);
			
			add_settings_field( 
				'rccwoo_background',
				__( 'Background Color', 'rccwoo-textdomain' ),
				array( $this, 'rccwoo_background_render' ),
				'rccwoo-options-page',
				'rccwoo_section_1' 
			); // id, title, display cb, page, section
			
			add_settings_field( 
				'rccwoo_text_color',
				__( 'Button Text Color', 'rccwoo-textdomain' ),
				array( $this, 'rccwoo_text_color_render' ),
				'rccwoo-options-page',
				'rccwoo_section_1' 
			); 
			
		}
		
		
		
		
		

		/**
		 * Sanitize each setting field as needed
		 *
		 * @param array $input Contains all settings fields as array keys
		 */
		public function sanitize( $input ) {
			
			// if this fails, check_admin_referer() will automatically print a "failed" page and die.
			
			$new_input = array();
			// only sanitize and save if wp_nonce_field is right
			if ( ! empty( $_POST ) && check_admin_referer( 'rccwoo_update_options', 'nonce_rccwoo_settings' ) ) {
				if( isset( $input['rccwoo_button_text'] ) )
				$new_input['rccwoo_button_text'] = sanitize_text_field( $input['rccwoo_button_text'] );
				
				if( isset( $input['rccwoo_confirm_text'] ) )
				$new_input['rccwoo_confirm_text'] = sanitize_text_field( $input['rccwoo_confirm_text'] );
				
				if( isset( $input['rccwoo_enabled'] ) )
				$new_input['rccwoo_enabled'] = absint( $input['rccwoo_enabled'] );
			
				if( isset( $input['rccwoo_radiobox_1'] ) )
				$new_input['rccwoo_radiobox_1'] = $input['rccwoo_radiobox_1'];
			
				if( isset( $input['rccwoo_background'] ) ) {
					$background = trim( $input['rccwoo_background'] );
					$background = strip_tags( stripslashes( $background ) );
					if( FALSE === $this->check_color( $background ) ) {
						// Set the error message
						add_settings_error( 'rccwoo_settings', 'rccwoo_bg_error', __('Insert a valid color for Background' , 'rccwoo-textdomain' ) , 'error' ); // $setting, $code, $message, $type
						// Get the previous valid value
						$new_input['rccwoo_background'] = $this->options['rccwoo_background'];
					} else {
						$new_input['rccwoo_background'] = $input['rccwoo_background'];
					}
				}
				if( isset( $input['rccwoo_background'] ) ) {
					$background = trim( $input['rccwoo_background'] );
					$background = strip_tags( stripslashes( $background ) );
					$bg_color = '';
					if( '#' != $background[0]) {
						$background = '#' . $background;
					}
					$new_input['rccwoo_background'] = sanitize_hex_color( $background );
				}
				
				if( isset( $input['rccwoo_text_color'] ) ) {
					$textcolor = trim( $input['rccwoo_text_color'] );
					$textcolor = strip_tags( stripslashes( $textcolor ) );
					$txt_color = '';
					if( '#' != $textcolor[0]) {
						$textcolor = '#' . $textcolor;
					}
					$new_input['rccwoo_text_color'] = sanitize_hex_color( $textcolor );
				}
			}

			return $new_input;
		}
		
		public function check_color( $value ) { 
			if ( preg_match( '/^#[a-f0-9]{6}$/i', $value ) ) { // if user insert a HEX color with #     
				return true;
			}
			return false;
		}

		/** 
		 * Print the Section text
		 */
		public function plugin_settings_section_callback() { 
			echo __( 'Enter your preferences below:', 'rccwoo-textdomain' );
		}

		
		
		public function rccwoo_button_text_render() { 
			printf(
				'<input type="text" id="button-text" name="rccwoo_settings[rccwoo_button_text]" value="%s" />',
				isset( $this->options['rccwoo_button_text'] ) ? esc_attr( $this->options['rccwoo_button_text']) : ''
			);
		}
		
		public function rccwoo_confirm_text_render() { 
			printf(
				'<input type="text" id="confirm-text" name="rccwoo_settings[rccwoo_confirm_text]" value="%s" />',
				isset( $this->options['rccwoo_confirm_text'] ) ? esc_attr( $this->options['rccwoo_confirm_text']) : ''
			);
		}
		
		public function rccwoo_enabled_render() { 
			$checked = ( isset( $this->options['rccwoo_enabled'] ) && $this->options['rccwoo_enabled'] == 1 ) ? 1 : 0;
			$html = '<input type="checkbox" id="rccwoo_enabled" name="rccwoo_settings[rccwoo_enabled]" value="1"' . checked( 1, $checked, false ) . '/>';
			echo $html;
		}
		
		public function rccwoo_radiobox_1_render() {
			$html = '';
			if( isset( $this->options["rccwoo_radiobox_1"] ) ){
//				trace( $this->options["rccwoo_radiobox_1"] );
				$html = __( 'Inherit' , 'rccwoo-textdomain' ) . ' <input type="radio" class="rccwoo_radiobox_1" name="rccwoo_settings[rccwoo_radiobox_1]" value="inherit"';
				if( 'inherit' == $this->options['rccwoo_radiobox_1'] ) $html .= 'checked';
				$html .= '/>';
				$html .= __( 'Left' , 'rccwoo-textdomain' ) . ' <input type="radio" class="rccwoo_radiobox_1" name="rccwoo_settings[rccwoo_radiobox_1]" value="left"';
				if( 'left' == $this->options['rccwoo_radiobox_1'] ) $html .= 'checked';
				$html .= '/>';
				$html .= __( 'Right' , 'rccwoo-textdomain' ) . ' <input type="radio" class="rccwoo_radiobox_1" name="rccwoo_settings[rccwoo_radiobox_1]" value="right"';
				if( 'right' == $this->options['rccwoo_radiobox_1'] ) $html .= 'checked';
				$html .= '/>';
			} else {
				$html = __( 'Inherit' , 'rccwoo-textdomain' ) . ' <input type="radio" class="rccwoo_radiobox_1" name="rccwoo_settings[rccwoo_radiobox_1]" value="inherit"';
				$html .= '/>';
				$html .= __( 'Left' , 'rccwoo-textdomain' ) . ' <input type="radio" class="rccwoo_radiobox_1" name="rccwoo_settings[rccwoo_radiobox_1]" value="left"/>';
				$html .= __( 'Right' , 'rccwoo-textdomain' ) . ' <input type="radio" class="rccwoo_radiobox_1" name="rccwoo_settings[rccwoo_radiobox_1]" value="right"/>';
			}
//			trace( $html );
			echo $html;
		}
		
		public function rccwoo_background_render() {
			$val = '';
			if( isset( $this->options["rccwoo_background"] ) ){
				$val = $this->options['rccwoo_background'];
			}
			$html = '<input type="text" id="rccwoo_background" class="rccwoo-colorpicker" name="rccwoo_settings[rccwoo_background]" value="' . $val . '"';
			echo $html;
		}
		
		public function rccwoo_text_color_render() {
			$val = '';
			if( isset( $this->options["rccwoo_text_color"] ) ){
				$val = $this->options['rccwoo_text_color'];
			}
			$html = '<input type="text" id="rccwoo_text_color" class="rccwoo-colorpicker" name="rccwoo_settings[rccwoo_text_color]" value="' . $val . '"';
			echo $html;
		}
		
	}
}
    $my_settings_page = new rccwoo_Admin_Options();
