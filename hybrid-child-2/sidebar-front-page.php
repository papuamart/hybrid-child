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

<div>	
<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar('home-top') ) : else : ?>
	<div class="widget-top"><?php _e('Home Top', 'hybrid-news'); ?></div>
	<div class="nowidget"><a href="<?php echo get_settings('home'); ?>/wp-admin/widgets.php/" target="_self" title="Click to add widgets">Add "Home Top" Widgets</a></div>
	<div class="widget-bottom"></div>
	<?php endif; ?>
<div style="float:left;width:48%;margin-right:10px;">
<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar('home-middle-left') ) : else : ?>
	<div class="widget-top"><?php _e('Home Middle Left', 'hybrid-news'); ?></div>
	<div class="nowidget"><a href="<?php echo get_settings('home'); ?>/wp-admin/widgets.php/" target="_self" title="Click to add widgets">Add "Home Middle Left" Widgets</a></div>
	<div class="widget-bottom"></div>
<?php endif; ?>
</div>
<div  style="float:left;width:48%;margin-left:10px;">
<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar('home-middle-right') ) : else : ?>
	<div class="widget-top"><?php _e('Home Middle Right', 'hybrid-news'); ?></div>
	<div class="nowidget"><a href="<?php echo get_settings('home'); ?>/wp-admin/widgets.php/" target="_self" title="Click to add widgets">Add "Home Middle Right" Widgets</a></div>
	<div class="widget-bottom"></div>
<?php endif; ?>
</div>

<div style="float:left;">
<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar('home-bottom') ) : else : ?>
	<div class="widget-top"><?php _e('Home Bottom', 'hybrid-news'); ?></div>
	<div class="nowidget"><a href="<?php echo get_settings('home'); ?>/wp-admin/widgets.php/" target="_self" title="Click to add widgets">Add "Home Bottom" Widgets</a></div>
	<div class="widget-bottom"></div>
<?php endif; ?>
</div>


</div>