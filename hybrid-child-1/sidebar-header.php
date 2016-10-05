<?php
/**
 * Header Sidebar
 *
 * The Heder Sidebar template houses the HTML used for the 'Utility: Header' 
 * widget area. It will first check if the widget area is active before displaying anything.
 *
 * @package HybridNews
 * @subpackage Template
 */

	if ( is_active_sidebar( 'utilityheader' ) ) : ?>

		<div id="utility-header" class="sidebar sidebar-header utility">

			<?php dynamic_sidebar( 'utilityheader' ); ?>

		</div><!-- #utility-header .utility -->
<?php else : ?>
<div class="entry-meta">
<?php echo apply_atomic_shortcode( 'entry_meta', '<div class="">' . __( '[entry-words-count] [last-modified]', 'hybrid-news' ) . '</div>' );  ?>
</div><!-- #utility-header .utility -->
	<?php endif; ?>