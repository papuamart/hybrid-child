<?php
/**
 * Front Page Sidebar Widgets Template
 *
 * The After Content sidebar template houses the HTML used for the 'Utility: After Content' 
 * sidebar. It will first check if the sidebar is active before displaying anything.
 *
 * @package Hybrid
 * @subpackage Template
 * @link http://themehybrid.com/themes/hybrid/widget-areas
 */
?>

 
<div style="float:left;width:48%;">
<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar('home-3') ) : else : ?>
	<div class="widget-top"><?php _e('Home 3', 'hybrid-news'); ?></div>
	<div class="nowidget"><a href="<?php echo get_settings('home'); ?>/wp-admin/widgets.php/" target="_self" title="Click to add widgets">Add "Home 3" Widgets</a></div>
	<div class="widget-bottom"></div>
<?php endif; ?>
</div>

<div style="float:right;width:48%;margin-left:10px;">
<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar('home-4') ) : else : ?>
	<div class="widget-top"><?php _e('Home 4', 'hybrid-news'); ?></div>
	<div class="nowidget"><a href="<?php echo get_settings('home'); ?>/wp-admin/widgets.php/" target="_self" title="Click to add widgets">Add "Home 4" Widgets</a></div>
	<div class="widget-bottom"></div>
<?php endif; ?>
</div> 