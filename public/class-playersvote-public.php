<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://playersvote.com
 * @since      1.0.0
 *
 * @package    Playersvote
 * @subpackage Playersvote/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Playersvote
 * @subpackage Playersvote/public
 * @author     Inscouts <dominic@inscouts.com>
 */
class Playersvote_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->settings = new Playersvote_Settings($this->plugin_name);

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/playersvote-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/playersvote-public.js', array( 'jquery' ), $this->version, false );

	}

	public function generate_widget_code($atts) {
		$atts = array_change_key_case( (array)$atts, CASE_LOWER );
		$api_key = $this->settings->get_setting('api-key');
		$source = $atts['source'];
		$id = $atts['id'];
		return "<div id=\"playersvote-widget\"></div><script type=\"text/javascript\" src=\"https://matchday.playersvote.com/widget.bundle.js\"></script><script>window.initWidget({ apiKey: '$api_key', url: 'https://matchday.playersvote.com', source:'$source', gameId: $id }); </script>";
	}

}
