<?php
/**
 * Header Sidebar
 *
 * The Heder Sidebar template houses the HTML used for the 'Utility: Header' 
 * widget area. It will first check if the widget area is active before displaying anything.
 *
 * @package HybridChild
 * @subpackage Template
 */

	if ( is_active_sidebar( 'utilityheader' ) ) : ?>

		<div id="utility-header" class="sidebar sidebar-header">

			<?php dynamic_sidebar( 'utilityheader' ); ?>
			
				</div><!-- #utility-header .utility -->				
<?php elseif (is_singular() ) :?>
<div id="utility-header" class="sidebar-header">
<?php echo apply_atomic_shortcode( 'entry_meta', '<div class="">' . __( '[entry-tags-breadcrumb]', 'hybrid-child' ) . '</div>' );  ?>
	</div><!-- #utility-header .utility -->
<?php else : ?>
<div id="utility-header" class="sidebar-header">
<?php echo apply_atomic_shortcode( 'entry_meta', '<div class="">' . __( '[entry-tags-breadcrumb]', 'hybrid-child' ) . '</div>' );  ?>
	</div><!-- #utility-header .utility -->
	<?php endif; ?>