<?php
/**
 * Complementary Sidebar
 *
 * The Complementary Sidebar template houses the HTML used for the 'Complementary' widget area. 
 * It will first check if the widget area is active before displaying anything.
 *
 * @package HybridNews
 * @subpackage Template
 */

	if ( is_active_sidebar( 'complementary' ) ) : ?>

		<div id="complementary" class="sidebar sidebar-complementary aside">

			<?php dynamic_sidebar( 'complementary' ); ?>

		</div><!-- #complementary .aside -->

	<?php endif; ?>