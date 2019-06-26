<?php
/**
 * Plugin Name: WooCommerce Conversion Codes
 * Plugin URI: https://omni.agency
 * Description: Super-light and simple way to add conversion code to your WooCommerce 'Order Complete' page.
 * Version: 1.0.1
 * Author: Jimmy Hughes
 * Author URI: https://omni.agency
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

// Register settings

function wc_cc_register_settings() {

	add_option( 'wc_cc_head', '');
	register_setting( 'wc_cc_default', 'wc_cc_head', 'wc_cc_head_callback' );

	add_option( 'wc_cc_codes', '');
	register_setting( 'wc_cc_default', 'wc_cc_codes', 'wc_cc_codes_callback' );

}
add_action( 'admin_init', 'wc_cc_register_settings' );

// Create options page

function wc_cc_create_settings() {

  add_options_page('WooCommerce Conversion Codes', 'WC Conversion Codes', 'manage_options', 'wc_cc', 'wc_cc_options_page');

}
add_action('admin_menu', 'wc_cc_create_settings');

function wc_cc_options_page() { ?>
	<div>
	  	<?php screen_icon(); ?>
	  	<h1>WooCommerce Conversion Codes</h1>
	  	<p>Simply paste your Google <strong>Global Site Tag</strong> and <strong>Conversion Code(s)</strong> into the boxes, below. Don't forget to include the <strong>&lt;script&gt;</strong> and <strong>&lt;/script&gt;</strong> tags.</p>
	  	<form method="post" action="options.php">
	  		<?php settings_fields( 'wc_cc_default' ); ?>
			<table class="wc-cc-options-table">
	  			<tr valign="top">
	  				<td class="wc-cc-row">
	  					<h4 class="wc-cc-field-heading">Global Site Tag</h4>
	  					<p class="wc-cc-field-description">This inserts the global site tag into the &lt;head&gt; setion of your website.</p>
	  					<textarea id="wc_cc_head_field" name="wc_cc_head" rows="4" class="wc-cc-head-field"><?php echo wp_unslash( get_option('wc_cc_head') ); ?></textarea>
	  				</td>
	  			</tr>
	  			<tr valign="top">
	  				<td class="wc-cc-row">
	  					<h4 class="wc-cc-field-heading">Conversion Code(s)</h4>
	  					<p class="wc-cc-field-description">This inserts your conversion code(s) into the default WooCommerce 'Order Complete' page.</p>
	  					<textarea id="wc_cc_codes_field" name="wc_cc_codes" rows="4" class="wc-cc-codes-field"><?php echo wp_unslash( get_option('wc_cc_codes') ); ?></textarea>
	  				</td>
	  			</tr>
	  		</table>
	  		<?php submit_button(); ?>
		</form>
	</div>
<?php

}

// Adds the global site tag to <head>

add_action( 'wp_head', 'wc_cc_do_head' );
 
function wc_cc_do_head() { 

	echo get_option('wc_cc_head');

}

// Adds the conversion code to the 'Thank You' page

add_action( 'woocommerce_thankyou', 'wc_cc_do_codes' );
 
function wc_cc_do_codes() { 

	echo get_option('wc_cc_codes');

}

// Register and enqueue styles & scripts

function wc_cc_styles() {

	// Options page styles
	wp_register_style( 'wc_cc_css', plugin_dir_url( __FILE__ ) . 'css/wc_cc.css', false, '1.0.1' );
	wp_enqueue_style( 'wc_cc_css' );

	// Code editor scripts
	wp_enqueue_code_editor( array( 'type' => 'text/html' ) );
    wp_enqueue_script( 'js-code-editor', plugin_dir_url( __FILE__ ) . 'editor/editor.js', array( 'jquery' ), '', true );

}
add_action( 'admin_enqueue_scripts', 'wc_cc_styles' );