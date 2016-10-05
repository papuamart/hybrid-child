<?php
/**
 * Post Types Menu Template
 *
 * Displays the Post Types Menu if it has active menu items.
 *
 * @package News
 * @subpackage Template
 */

if ( has_nav_menu( 'posttypes' ) ) : ?>

	<div id="menu-posttypes" class="menu-container">		

			<?php do_atomic( 'before_posttypes_menu' ); // Before posttypes menu hook ?>

			<?php wp_nav_menu( array( 'theme_location' => 'posttypes', 'container_class' => 'menu', 'menu_class' => '', 'menu_id' => 'menu-posttypes-items', 'depth' => 2, 'fallback_cb' => '' ) ); ?>

			<?php do_atomic( 'after_posttypes_menu' ); // After posttypes menu hook ?>

	

	</div><!-- #posttypes-menu  .menu-container -->

<?php endif; ?>