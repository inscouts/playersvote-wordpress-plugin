<?php
/**
 * Created by PhpStorm.
 * User: dominic
 * Date: 10.03.19
 * Time: 14:55
 */

class Playersvote_Settings
{

	private $plugin_name;

	public function __construct( $plugin_name ) {

		$this->plugin_name = $plugin_name;

	}

	public function register_settings() {
		register_setting( $this->plugin_name.'_options', $this->plugin_name.'_options' );
	}

	public function add_section() {
		add_settings_section(
			$this->plugin_name . '-user-display-options', // section
			apply_filters( $this->plugin_name . '-user-display-section-title', __( '', $this->plugin_name ) ),
			function ( $params ) {
				echo '<p>' . $params['title'] . '</p>';
			},
			$this->plugin_name
		);
	}

	public function add_setting($setting_name, $label, $description) {
		add_settings_field(
			$setting_name,
			apply_filters( $this->plugin_name . '-'.$setting_name.'-user-label', __( $label, $this->plugin_name ) ),
			function () use ($setting_name, $description) {
				$value = $this->get_setting($setting_name);
				?><input type="text" id="<?php echo $this->plugin_name; ?>_options[<?php echo $setting_name ?>]" name="<?php echo $this->plugin_name; ?>_options[<?php echo $setting_name ?>]" value="<?php echo $value  ?>" />
				<p class="description"><?php echo $description ?></p> <?php
			},
			$this->plugin_name,
			$this->plugin_name . '-user-display-options' // section to add to
		);
	}

	public function get_setting($setting_name) {
		$options 	= get_option( $this->plugin_name . '_options' );
		$option 	= '';
		if ( ! empty( $options[$setting_name] ) ) {
			$option = $options[$setting_name];
		}
		return $option;
	}

}