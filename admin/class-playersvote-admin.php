<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://playersvote.com
 * @since      1.0.0
 *
 * @package    Playersvote
 * @subpackage Playersvote/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Playersvote
 * @subpackage Playersvote/admin
 * @author     Inscouts <dominic@inscouts.com>
 */
class Playersvote_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Playersvote_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Playersvote_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/playersvote-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Playersvote_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Playersvote_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/playersvote-admin.js', array( 'jquery' ), $this->version, false );

	}

	public function get_plugin() {
		return $this->plugin_name;
	}

	public function add_admin_settings_page() {
		add_options_page('Playersvote', 'Playersvote', 'manage_options', $this->plugin_name, [$this, 'display_plugin_admin_page']);
	}

	public function display_plugin_admin_page(){
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/playersvote-admin-display.php';
	}

	public function init_admin() {
		register_setting( $this->plugin_name.'_options', $this->plugin_name.'_options' );

		// add_settings_section( $id, $title, $callback, $menu_slug );
		add_settings_section(
			$this->plugin_name . '-user-display-options', // section
			apply_filters( $this->plugin_name . '-user-display-section-title', __( '', $this->plugin_name ) ),
			array( $this, 'display_options_section' ),
			$this->plugin_name
		);

		// add_settings_field( $id, $title, $callback, $menu_slug, $section, $args );
		add_settings_field(
			'api-key',
			apply_filters( $this->plugin_name . '-api-key-user-label', __( 'API key', $this->plugin_name ) ),
			array( $this, 'api_key_options_field' ),
			$this->plugin_name,
			$this->plugin_name . '-user-display-options' // section to add to
		);

	}

	public function display_options_section( $params ) {
		echo '<p>' . $params['title'] . '</p>';
	}

	public function api_key_options_field() {
		$api_key = $this->get_api_key();
		?><input type="text" id="<?php echo $this->plugin_name; ?>_options[api-key]" name="<?php echo $this->plugin_name; ?>_options[api-key]" value="<?php echo $api_key  ?>" />
		<p class="description">API key from <a href="https://platform.playersvote.com">platform.playersvote.com</a></p> <?php
	}

	public function get_api_key() {
		$options 	= get_option( $this->plugin_name . '_options' );
		$option 	= '';
		if ( ! empty( $options['api-key'] ) ) {
			$option = $options['api-key'];
		}
		return $option;
	}
}
