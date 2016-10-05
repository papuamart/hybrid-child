<?php
/**
 * Post Formats Menu Template
 *
 * Displays the Post Formats if it has active menu items.
 *
 * @package News
 * @subpackage Template
 */

if ( has_nav_menu( 'postformats' ) ) : ?>

	<div id="postformats-menu" class="menu-container">		

			<?php do_atomic( 'before_postformats_menu' ); // Before subsidiary menu hook ?>

		<?php wp_nav_menu( array( 'theme_location' => 'postformats', 'container_class' => 'menu', 'menu_class' => '', 'fallback_cb' => '' ) ); ?>

			<?php do_atomic( 'after_postformats_menu' ); // After subsidiary menu hook ?>

	</div><!-- #postformats-menu  .menu-container -->
	
<?php else : ?>

<div id="postformats-menu" class="postformats-menu menu-container">		

<?php do_atomic( 'before_postformats_menu' ); // Before subsidiary menu hook ?>

<?php
/* Post Format Navigation. */
$formats = get_terms( 'post_format' );
if ( ! is_wp_error( $formats ) ) {
   //print '<ul class="blue meta-sep vsep">' . "\n"; 
    foreach ( $formats as $format ) {
        $href = get_term_link( $format, 'post_format' );
        $text = get_post_format_string( str_replace( 'post-format-', '', $format->slug ) );
        print '<a class="" href="' . $href . '">' . $text . '</a>' . "\n";
    }
  //  print '</ul>' . "\n";
}
?>
<?php do_atomic( 'after_postformats_menu' ); // After subsidiary menu hook ?>
	
	</div><!-- #footer-menu  .menu-container -->
<?php endif; ?>

