<?php
/**
 * Plugin Name: WP Discourse Plugins Tab
 * Version: 0.1
 * Author: scossar
 */

namespace WPDC\PluginsTab;

use \WPDiscourse\Admin\OptionsPage as OptionsPage;

define( 'WPDC_PLUGINS_URL', plugins_url( '/wp-discourse-plugins-tab' ) );

add_action( 'plugins_loaded', __NAMESPACE__ . '\\init' );
function init() {
	write_log( 'in the init function' );
	if ( class_exists( '\WPDiscourse\Discourse\Discourse' ) ) {
		if ( is_admin() ) {
			require_once( __DIR__ . '/admin/admin.php' );

			$options_page = OptionsPage::get_instance();

			new Admin( $options_page );

			add_action( 'admin_enqueue_scripts', __NAMESPACE__ . '\\admin_scripts' );
		}
	}
}

function admin_scripts() {
	wp_register_style( 'wpdc_plugins_tab_admin', WPDC_PLUGINS_URL . '/admin/css/admin.css' );
	wp_enqueue_style( 'wpdc_plugins_tab_admin' );
}