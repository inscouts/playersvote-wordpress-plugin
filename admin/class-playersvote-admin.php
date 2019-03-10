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

	private $settings;

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
		$this->settings = new Playersvote_Settings($this->plugin_name);

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

		$this->settings->register_settings();

		$this->settings->add_section();

		$this->settings->add_setting('api-key', 'API Key', "API key from <a href=\"https://platform.playersvote.com\">platform.playersvote.com</a>");
		$this->settings->add_setting('token', 'Token', "Token from <a href=\"https://platform.playersvote.com\">platform.playersvote.com</a>");
	}

	public function get_api_key() {
		return $this->settings->get_setting('api-key');
	}

	public function get_token() {
		return $this->settings->get_setting('token');
	}

	private function send_request($path) {
		$client = new GuzzleHttp\Client(['base_uri' => 'https://219l7y1jf5.execute-api.eu-central-1.amazonaws.com/production/api/']);
		$response = $client->request('GET', $path, [
			'headers' => [
				'Authorization' => 'Bearer ' . $this->get_token()
			]
		]);
		return json_decode($response->getBody(), true);
	}

	public function get_sources() {
		try {
			return $this->send_request('sources');
		} catch (Exception $err) {
			var_dump($err->getMessage());
		}
	}

	public function get_games($source) {
		try {
			return $this->send_request('sources/'.$source.'/games');
		} catch (Exception $err) {
			var_dump($err->getMessage());
		}
	}

	public function format_date_string($dateStr) {
		$date = strtotime($dateStr);
		return date('d.m.Y H:i', $date);
	}

}
