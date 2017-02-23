<?php

namespace WPDC\PluginsTab;

class Admin {
	protected $options_page;

	public function __construct( $options_page ) {
		$this->options_page = $options_page;

		add_action( 'admin_menu', array( $this, 'add_plugins_submenu_page' ) );
		add_action( 'discourse/admin/options-page/append-settings-tabs', array(
			$this,
			'top_level_settings_tab'
		) );
		add_action( 'discourse/admin/options-page/after-settings-tabs', array(
			$this,
			'display_available_plugins'
		) );
	}

	public function add_plugins_submenu_page() {
		$plugin_settings = add_submenu_page(
			'wp_discourse_options',
			__( 'Available Plugins', 'wpdc' ),
			__( 'Available Plugins', 'wpdc' ),
			'manage_options',
			'wpdc_plugin_options',
			array( $this, 'plugin_options_tab' )
		);
		add_action( 'load-' . $plugin_settings, array( $this->options_page, 'connection_status_notice' ) );
	}

	public function plugin_options_tab() {
		if ( current_user_can( 'manage_options' ) ) {
			$this->options_page->options_pages_display( 'wpdc_plugin_options', null, 'no-fields' );
		}
	}

	public function top_level_settings_tab( $tab ) {
		$active = 'wpdc_plugin_options' === $tab;
		?>
        <a href="?page=wp_discourse_options&tab=wpdc_plugin_options"
           class="nav-tab <?php echo $active ? 'nav-tab-active' : ''; ?>"><?php esc_html_e( 'Plugins', 'wpdc' ); ?>
        </a>
		<?php
	}

	// Todo: create a wpdc_plugin post-type.
	public function display_available_plugins( $tab ) {
		if ( 'wpdc_plugin_options' === $tab ) {
			?>
            <h2>Available Plugins</h2>
            <ul class="wpdc-available-plugins">
                <li>
                    <div class="wpdc-plugin-image">
                        <img src="<?php echo esc_url( WPDC_PLUGINS_URL . '/admin/images/discourse-logo.png' ); ?>"
                             alt="Discourse logo">
                    </div>
                </li>
            </ul>
			<?php
		}
	}
}