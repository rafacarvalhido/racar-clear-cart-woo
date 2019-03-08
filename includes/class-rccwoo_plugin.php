<?php
/*
*  
* includes/class-rccwoo-plugin.php
* holds all main functions of plugin. This is the brain!
*  
*/	
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! defined( 'WPINC' ) ) die; // If this file is called directly, abort.
	


if( ! class_exists( 'rccwoo_Plugin' ) ) {	
	class rccwoo_Plugin {
		
		
		public function __construct() {
            add_action( 'woocommerce_cart_actions' , array( $this , 'rccwoo_empty_cart_button' ) );
            //add_action( 'woocommerce_after_cart_contents' , array( $this , 'rccwoo_botao_esvaziar' ) );
            
			add_action( 'init', array( $this , 'woocommerce_clear_cart_url') );
        }
		
		private $options;
		
		
	
		public function rccwoo_empty_cart_button(){
			$this->options = get_option( 'rccwoo_settings' );

			if( ! isset( $this->options["rccwoo_enabled"] ) || $this->options['rccwoo_enabled'] != 1 ) {
				return;
			}
			$button_text = __('Empty Cart','rccwoo-textdomain');
			$confirm_text = __('Are you sure you wish to clear your shopping cart?','rccwoo-textdomain');
			$float_option = '';
			$button_bg_color = '';
			$button_text_color = 'inherit';
			
			if( isset( $this->options["rccwoo_radiobox_1"] ) ){
				$float_option = $this->options["rccwoo_radiobox_1"];
			}
			if( isset( $this->options["rccwoo_button_text"] ) && $this->options["rccwoo_button_text"] != '' ){
				$button_text = $this->options["rccwoo_button_text"];
			}
			if( isset( $this->options["rccwoo_confirm_text"] ) && $this->options["rccwoo_confirm_text"] != '' ){
				$confirm_text = $this->options["rccwoo_confirm_text"];
			}
			if( isset( $this->options["rccwoo_background"] ) && $this->options["rccwoo_background"] != '' ){
				$button_bg_color = $this->options["rccwoo_background"];
			}
			if( isset( $this->options["rccwoo_text_color"] ) && $this->options["rccwoo_text_color"] != '' ){
				$button_text_color = $this->options["rccwoo_text_color"];
			}
/*trace($button_text);
trace($confirm_text);
trace(esc_html($confirm_text));*/
			?>
				<input type="submit" style="float:<?php echo esc_html($float_option);?>;background-color:<?php echo esc_html($button_bg_color);?>;color:<?php echo esc_html($button_text_color);?>;" onclick='return confirm("<?php echo esc_html($confirm_text);?>");' class="button" id="empty-cart" name="clear-cart" value="<?php echo esc_html($button_text);?>" />
			<?php 
			
		}
		
		public function woocommerce_clear_cart_url() {
			global $woocommerce;
			if( isset( $_REQUEST['clear-cart'] ) ) {
				$woocommerce->cart->empty_cart();
			}
		}
 
		
		
		
		
	}
}
	