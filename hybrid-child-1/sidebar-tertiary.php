<?php
/**
 * Tertiary Sidebar
 *
 * The Tertiary Sidebar template houses the HTML used for the 'Tertiary' widget area. 
 * It will first check if the widget area is active before displaying anything.
 *
 * @package HybridNews
 * @subpackage Template
 */

	if ( is_active_sidebar( 'tertiary' ) ) : ?>

		<div id="tertiary" class="sidebar sidebar-tertiary aside">

			<?php dynamic_sidebar( 'tertiary' ); ?>

		</div><!-- #tertiary .aside -->

	<?php endif; ?>