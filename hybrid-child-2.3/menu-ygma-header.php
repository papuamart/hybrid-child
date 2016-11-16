<?php
/**
 * After Footer Utility Template
 *
 * Displays information at the top of the page about archive and search results when viewing those pages.  
 * This is not shown on the home page and singular views.
 *
 * @package News
 * @subpackage Template
 * PMNews added tagBreadcrumb for is_singular ('post')) meta
 */
?>
<div id="ygma" class="menu-container">	
<div id="ygmacx">
<div id="ygmatop" style="padding-top:10px;padding-left:10px;">
		<div class='vsep cms-dynamic' style="float:right;padding-right:25px;margin-top:-5px;"><?php get_search_form(); ?></div>
<a href="mailto:info@papua.pw"><?php _e( 'EMail Us!', hybrid_get_textdomain() ); ?></a>
		<!-- USER AND WEB ADMIN -->
   <?php global $user_ID; if( $user_ID ) : ?>
	<?php if(current_user_can('level_10')) : ?>
	<?php _e('Hello!, Wa, Wa!, Salam!', hybrid_get_textdomain() ); ?>&nbsp;"<strong><?php user_info('user_email'); ?></strong>"
	<?php wp_register("","<span class='vsep cms-dynamic'></span>"); ?><?php wp_loginout(); ?>
	<?php endif; ?>
	<?php else : ?>
	<span class='vsep cms-dynamic'></span><?php _e( 'Hello Guest!', hybrid_get_textdomain() ); ?> <strong><?php _e( 'Not Registered or logged in?', hybrid_get_textdomain() ); ?></strong>&nbsp;&nbsp;<?php wp_loginout(); ?>
	<span class='vsep cms-dynamic'></span><?php _e( 'or', hybrid_get_textdomain() ); ?>&nbsp;&nbsp;&nbsp;<a href="<?php echo home_url() ?>/wp-login.php?action=register"><strong><?php _e( 'Register', hybrid_get_textdomain() ); ?></strong></a>
	<?php endif; ?><!-- USER AND WEB ADMIN -->
</div>
		</div><!-- .yui-cms-item yui-panel -->		
	</div><!-- .bd -->
