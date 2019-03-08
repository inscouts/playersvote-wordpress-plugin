<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://playersvote.com
 * @since      1.0.0
 *
 * @package    Playersvote
 * @subpackage Playersvote/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<div>
	<h2>Playersvote Settings</h2>
	<form action="options.php" method="post">
		<?php
			settings_fields( $this->get_plugin() . '_options' );
			do_settings_sections( $this->get_plugin() );
			submit_button( 'Save Settings' );

			$api_key = $this->get_api_key();
			if (isset($api_key) && $api_key) {
				echo "yes";
			}

		?>
	</form>

</div>