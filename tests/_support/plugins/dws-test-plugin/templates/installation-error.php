<?php
/**
 * A very early error message displayed if something doesn't check out.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @package DeepWebSolutions\wp-test-plugin\templates
 */

defined( 'ABSPATH' ) || exit;

?>

<div class="error notice">
	<p>
		<?php
		echo esc_html(
			sprintf(
				/* translators: %s: DWS Test Plugin Name */
				__( 'It seems like %s is corrupted. Please reinstall!', 'dws-test-plugin' ),
				DWS_TEST_PLUGIN_NAME
			)
		);
		?>
	</p>
</div>
