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
	<h2>PlayersVote Settings</h2>
	<form action="options.php" method="post">
		<?php
			settings_fields( $this->get_plugin() . '_options' );
			do_settings_sections( $this->get_plugin() );
			submit_button( 'Save Settings' );
		?>
	</form>

	<div>
		<?php
		$api_key = $this->get_api_key();
		$selected_source = $_GET['source'];
		if (isset($api_key) && $api_key) {
			$sources = $this->get_sources();
			?>

			<form action="" method="get">
				<input type="hidden" name="page" value="<?php echo $this->get_plugin(); ?>">
				<select name="source" onchange="this.form.submit()">
					<option value="">Please select</option>
				<?php foreach($sources as $value): ?>
					<option
							value="<?php echo $value['key'] ?>"
							<?php if(isset($selected_source) && $selected_source == $value['key']) { echo 'selected'; } ?>
					><?php echo $value['name'] ?></option>
				<?php endforeach; ?>
				</select>
			</form>
			<?php
		}

		// List games
		if (isset($selected_source) && $selected_source) {
			$games = $this->get_games($selected_source); ?>

			<table class="pv-table">
				<thead>
				<tr>
					<th>Date</th>
					<th>Team 1</th>
					<th>Team 2</th>
					<th>Location</th>
					<th>Week</th>
					<th>Shortcode</th>
				</tr>
				</thead>
				<tbody>
				<?php foreach($games as $game): ?>
					<tr>
						<td><?php echo $this->format_date_string($game['start']) ?></td>
						<td><?php echo $game['team_1']['name'] ?></td>
						<td><?php echo $game['team_2']['name'] ?></td>
						<td><?php echo $game['location'] ?></td>
						<td><?php echo $game['week'] ?></td>
						<td><pre>[playersvote-widget source="<?php echo $selected_source ?>" id="<?php echo $game['id']?>"]</pre></td>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
		<?php } ?>
	</div>

</div>
