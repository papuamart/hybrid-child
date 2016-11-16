<?php
/**
 * Sidebar Loop Navigation Template
 *
 * Displays information at the top of the page about archive and search results when viewing those pages.  
 * This is not shown on the home page and singular views.
 *
 * @package News
 * @hybrid_sidebar_loop_nav Template
 * PMNews added tagBreadcrumb for is_singular ('post')) meta
 */
?>

<p><?php echo news_navigation(); /* refer to "context.php" */ ?> </p>
	<?php echo do_shortcode('[child-site-description]'); ?>			

<?php if ( is_home() || is_front_page() || is_page_template('page-home.php') || is_page_template('page-front-page.php')) : ?>
<div class='breadcrumbs'>
	<?php echo do_shortcode('[entry-google-breadcrumb]'); ?>			
</div>

<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar('sidebar-home') ) : else : ?>
	<div class="widget-top"><?php _e('Home Sidebar', 'hybrid-news'); ?></div>
	<div class="nowidget"><a href="<?php echo get_settings('home'); ?>/wp-admin/widgets.php/" target="_self" title="Click to add widgets">Add "Home Sidebar" Widgets</a></div>
	<div class="widget-bottom"></div>
	<?php endif; ?> 

	<?php elseif ( is_page( 'watch-papua' ) ) : ?>
	<div class="breadcrumbs"> 
<p style="text-align:center;margin:3px;padding:3px;"><?php echo news_navigation(); ?></p>
	<?php echo do_shortcode('[entry-google-breadcrumb]'); ?>			
	<?php echo do_shortcode('[entry-sidebar-pagination]'); ?>		 
		</div><!-- .yui-cms-item yui-panel -->		
		
<?php elseif ( is_singular('post') ) : ?>
<div class="breadcrumbs">
<?php echo apply_atomic_shortcode( 'entry_utility', '<div class="entry-utility">' . __( '[entry-print-link]<span class=vsep></span>[entry-email-link before=" /"]<span class=vsep></span>[entry-facebook-link]<span class=vsep></span> [entry-twitter-link] <span class=vsep></span> [entry-googleplus-link] <span class=vsep></span> [entry-cakifo-twitter] <span class=vsep></span>[entry-fblike-live-link]', hybrid_get_textdomain() ) . '</div>' ); ?>
</div><!-- .yui-cms-item yui-panel -->
	 
<div  id="widget">
 	<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar('sidebar-singular') ) : else : ?>
	<div class="widget-top"><?php _e('Singular Sidebar', 'hybrid-news'); ?></div>
	<div class="nowidget"><a href="<?php echo home_url(); ?>/wp-admin/widgets.php/" target="_self" title="Click to add widgets">Add Singular Sidebar Widgets</a></div>
	<div class="widget-bottom"></div>
	<?php endif; ?>	
	</div><!--#widget -->
 
<?php elseif ( is_page() ) : ?>
<?php global $notfound; ?>
 <?php /* Creates a menu for pages beneath the level of the current page */
  if (is_page() and ($notfound != '1')) {
   $current_page = $post->ID;
   while($current_page) {
    $page_query = $wpdb->get_row("SELECT ID, post_title, post_status, post_parent FROM $wpdb->posts WHERE ID = '$current_page'");
    $current_page = $page_query->post_parent;
   }
   $parent_id = $page_query->ID;
   $parent_title = $page_query->post_title;
if ($wpdb->get_results("SELECT * FROM $wpdb->posts WHERE post_parent = '$parent_id' AND post_status != 'attachment'")) { ?>
<!--div class="hd"><span class="gr" style="font-size:120%;"><!--?php echo $parent_title; ?></span><br-->
<em><?php _e('has the following Subpages', 'hybrid'); ?></em><!--/div-->

	<ul class="listing"><span style="font-size:12px;color:#E76300;"><?php wp_list_pages('sort_column=menu_order&title_li=&child_of='. $parent_id); ?><span></ul>
    <?php if ($parent_id != $post->ID) { ?> 
	<br />
 <li class="sidebarheader"><a href="<?php echo get_permalink($parent_id); ?>"><?php printf(__('Back to %s', 'hybrid'), $parent_title ) ?></a></li>
  <?php } ?> 
 <?php } } ?>
 <div class="yui-cms-item yui-panel selected">
  <div class="hd"><?php echo apply_atomic_shortcode( 'entry_utility', '<div class="entry-utility">' . __( '[entry-print-link] [entry-email-link] [entry-popup-shortlink]', hybrid_get_textdomain() ) . '</div>' ); ?>
</div>
 <div class="bd">
		<div class="fixed">		
<?php
{ $postnote = get_post_meta
($post->ID, 'postnote', $single = true); ?>
<div class="alert" style="font-size:11px;">
<?php if($postnote !== '') echo $postnote; 
else; } ?>
</div>	
	<!--?php echo do_shortcode( '[entry-cakifo-twitter]' );?-->
  	</div><!-- .fixed -->
	</div><!-- .bd -->
	<div class="actions">
	<a href="#" class="accordionToggleItem">&nbsp;</a> 
	</div>
	</div><!-- .yui-cms-item yui-panel -->
<div  id="widget">
 	<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar('sidebar-singular') ) : else : ?>
	<div class="widget-top"><?php _e('Singular Sidebar', 'hybrid-news'); ?></div>
	<div class="nowidget"><a href="<?php echo home_url(); ?>/wp-admin/widgets.php/" target="_self" title="Click to add widgets">Add Singular Sidebar Widgets</a></div>
	<div class="widget-bottom"></div>
	<?php endif; ?>	
	</div><!--#widget -->
	
 <?php elseif ( is_category() ) : ?>


<div class="yui-cms-item yui-panel breadcrumbs">
<?php
		$this_category = get_category($cat);
		if (get_category_children($this_category->cat_ID) != "") {		
		echo '<div class="widget-title">';
		echo '"';
		echo single_cat_title();
	echo '"&raquo;&nbsp;';
		echo 'has <em>Sub-Category(ies)</em>:</div>'; 
			wp_list_categories('optioncount=1&orderby=id&title_li=
		&use_desc_for_title=1&child_of='.$this_category->cat_ID); 
}
?>
<div class="widget-title">
<div class="hd"><span class="gr" style="font-size:120%;">&nbsp;&raquo;&nbsp;&rang;&nbsp;<?php echo single_cat_title(); ?></span>&nbsp;&laquo;&nbsp;&rang;&nbsp;<span class="single-cat-feedlink cat-feedlink"><a href="<?php echo get_category_feed_link($cat, ''); ?>" title="<?php printf(__('Subscribe to %s', 'hybrid'),get_cat_name($cat)); ?>"><?php printf(__('Subscribe to %s', 'hybrid'), get_cat_name($cat)); ?></a></span></div>
<!--div class="thumbnail"><!--?php echo do_action( 'taxonomy_image_plugin_print_image_html', 'detail' );?-->
</div-->
<?php $description = category_description( '', get_query_var( 'taxonomy' ) ); ?>
<?php if ( !empty( $description ) ) echo '<span class="headlines">' . $description . '</span>'; ?>
</div>	
</div><!-- .yui-cms-item yui-panel -->
<?php  
if ( current_theme_supports( 'popular-inthis' ) ) {
	echo '<div class=breadcrumbs>';
include( trailingslashit( CHILD_THEME_DIR ) . 'extensions/popinthiscat.php' );
echo '</div>';
} ?>
	
<div  id="widget">
 	<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar('sidebar-archive') ) : else : ?>
	<div class="widget-top"><?php _e('Archive Sidebar', 'hybrid-news'); ?></div>
	<div class="nowidget"><a href="<?php echo home_url(); ?>/wp-admin/widgets.php/" target="_self" title="Click to add widgets">Add Archive Sidebar Widgets</a></div>
	<div class="widget-bottom"></div>
	<?php endif; ?>	
	</div><!--#widget -->	
	
		<?php elseif ( is_tag() ) : ?>
			<div class="breadcrumbs">
			<div class="hd"><span class="gr">&nbsp;&raquo;&nbsp;&rang;&nbsp;<?php echo single_tag_title(); ?></span>
			<span class="rss"><a class="icon-rss" href="<?php echo get_tag_feed_link( $tag->term_id ); ?>">RSS</a>&nbsp;<a href="<?php echo $tag_link; ?>"><?php echo esc_html( $tag->name ); ?></a></span>
			</div>
		
<!--div class="img-catlight"><!--?php echo do_action( 'taxonomy_image_plugin_print_image_html', 'detail' );?-->
</div-->
<?php $description = tag_description( '', get_query_var( 'post_tag' ) ); ?>
			<?php if ( !empty( $description ) ) echo '<span class="headlines">' . $description . '</span>'; ?>
		
		</div><!-- .yui-cms-item yui-panel -->	

 		
<?php  
if ( current_theme_supports( 'popular-inthis' ) ) {
include( trailingslashit( CHILD_THEME_DIR ) . 'extensions/popinthistag.php' );
} ?>		

<div  id="widget">
 	<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar('sidebar-archive') ) : else : ?>
	<div class="widget-top"><?php _e('Archive Sidebar', 'hybrid-news'); ?></div>
	<div class="nowidget"><a href="<?php echo home_url(); ?>/wp-admin/widgets.php/" target="_self" title="Click to add widgets">Add Archive Sidebar Widgets</a></div>
	<div class="widget-bottom"></div>
	<?php endif; ?>	
	</div><!--#widget -->	
	
	<?php elseif ( is_tax() ) : ?>
			<div class="breadcrumbs">
			<div class="hd"><span class="gr" style="font-size:120%;"><?php $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) ); echo $term->name; ?></span>
			</div>
<div class="box" style="float:right;margin:3px;width:70px;"><?php echo do_action( 'taxonomy_image_plugin_print_image_html', 'detail' );?>
</div>
			<?php $description = term_description( '', get_query_var( 'taxonomy' ) ); ?>
			<?php if ( !empty( $description ) ) echo '<div class="bd">
		<div class="fixed">' . $description . '</div><!-- .fixed -->
	</div><!-- .bd -->'; ?>

	<div class="actions">
	<a href="#" class="accordionToggleItem">&nbsp;</a> 
	</div>
		</div><!-- .yui-cms-item yui-panel -->
<div class="clear"></div>
<div  id="widget">
 	<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar('sidebar-archive') ) : else : ?>
	<div class="widget-top"><?php _e('Archive Sidebar', 'hybrid-news'); ?></div>
	<div class="nowidget"><a href="<?php echo home_url(); ?>/wp-admin/widgets.php/" target="_self" title="Click to add widgets">Add Archive Sidebar Widgets</a></div>
	<div class="widget-bottom"></div>
	<?php endif; ?>	
	</div><!--#widget -->	
	
	<?php elseif ( is_author() ) : ?>
		<div class="breadcrumbs">
			<?php echo do_shortcode('[entry-post-count]'); ?>
			<?php $id = get_query_var( 'author' ); ?>
		<div id="hcard-<?php the_author_meta( 'user_nicename', $id ); ?>" class="hd vcard">
		<span class="gr fn n"><?php _e('by: ', 'hybrid-news'); ?><?php the_author_meta( 'display_name', $id ); ?></span>
			 </div>			
 
			<?php $description = get_the_author_meta( 'description', $id ); ?>
			<?php if ( !empty( $description ) ) {
				$avatar = get_avatar( get_the_author_meta( 'user_email', $id ), '100', '', get_the_author_meta( 'display_name', $id ) );
				echo '<div class="loop-description">' . $avatar . $description . '</div>';
			} ?>
 
		</div><!-- .yui-cms-item yui-panel -->		
		
		<div  id="widget">
 	<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar('sidebar-archive') ) : else : ?>
	<div class="widget-top"><?php _e('Archive Sidebar', 'hybrid-news'); ?></div>
	<div class="nowidget"><a href="<?php echo home_url(); ?>/wp-admin/widgets.php/" target="_self" title="Click to add widgets">Add Archive Sidebar Widgets</a></div>
	<div class="widget-bottom"></div>
	<?php endif; ?>	
	</div><!--#widget -->	

	<?php elseif ( is_search() ) : ?>
			<div class="breadcrumbs">
		<div class="hd"><strong><?php /* Search Count */ $allsearch = &new WP_Query("s=$s&showposts=-1"); $key = esc_html($s, 1); $count = $allsearch->post_count; _e(''); _e('Searched term: "<span class="gr" style="font-size:120%;">'); echo $key; _e('</span>"'); _e(' &mdash; '); echo $count . ' '; _e('articles'); wp_reset_query(); ?></strong>
		</div> 
			<p><?php _e('Thanks for searching the', 'hybrid-news'); ?>
		<?php bloginfo('name'); ?> <?php _e('site.', 'hybrid-news'); ?> <?php _e('The main content area lists some results that we hope are the sorts of things you were looking for.', 'hybrid-news'); ?></p>
 
		</div><!-- .yui-cms-item yui-panel -->
		
	<?php elseif ( is_post_type_archive() ) : ?>
			
		<?php $post_type = get_post_type_object( get_query_var( 'post_type' ) ); ?>
			<div class="yui-cms-item yui-panel">

		<div class="hd gr" style="font-size:120%;"><?php post_type_archive_title(); ?></div>
					<div class="bd">
		<div class="fixed box">
				<?php if ( !empty( $post_type->description ) ) echo "<p>{$post_type->description}</p>"; ?>
		</div><!-- .fixed -->
	</div><!-- .bd -->
	<div class="actions">
	<a href="#" class="accordionToggleItem">&nbsp;</a> 
	</div>
		</div><!-- .yui-cms-item yui-panel --> 
 
	<?php elseif ( is_page( 'popular-posts' ) ) : ?>
			<div class="yui-cms-item yui-panel">
			<div class="hd gr" style="font-size:120%;">&nbsp;&raquo;&nbsp;&rang;&nbsp;<?php _e( 'Most Popular', hybrid_get_textdomain() ); echo '&nbsp;&raquo;&nbsp;&rang;&nbsp;'; echo tagAndCatBreadCrumb(); ?></div>
		<div class="bd">
		<div class="fixed box">
				<?php echo apply_atomic_shortcode( 'entry_meta', '<span class="">' . __( '&nbsp; [fblikes-counts] [tweets-counts] [tweets-small-counts] [entry-gbuzz-counts-link] [entry-digg-counts-link]', hybrid_get_textdomain() ) . '</span>' ); ?>
	</div><!-- .fixed -->
	</div><!-- .bd -->
	<div class="actions">
	<a href="#" class="accordionToggleItem">&nbsp;</a> 
	</div>		
		</div><!-- .yui-cms-item yui-panel -->
		
		
	<?php elseif ( is_page( 'custom-posts' ) ) : ?>
			<div class="yui-cms-item yui-panel">
			<div class="hd gr" style="font-size:120%;">&nbsp;&raquo;&nbsp;&rang;&nbsp;<?php _e( 'Most Popular', hybrid_get_textdomain() ); echo '&nbsp;&raquo;&nbsp;&rang;&nbsp;'; echo tagAndCatBreadCrumb(); ?></div>
		<div class="bd">
		<div class="fixed box">
				<?php _e( 'You are browsing the site archives by popularity.', hybrid_get_textdomain() ); ?>
				<?php echo apply_atomic_shortcode( 'entry_meta', '<span class="">' . __( '&nbsp; [fblikes-counts] [tweets-counts] [tweets-small-counts] [entry-gbuzz-counts-link] [entry-digg-counts-link]', hybrid_get_textdomain() ) . '</span>' ); ?>
	</div><!-- .fixed -->
	</div><!-- .bd -->
	<div class="actions">
	<a href="#" class="accordionToggleItem">&nbsp;</a> 
	</div>		
		</div><!-- .yui-cms-item yui-panel -->		 

		<?php elseif ( is_date() ) : ?>

<div  id="widget">
 	<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar('sidebar-archive') ) : else : ?>
	<div class="widget-top"><?php _e('Archive Sidebar', 'hybrid-news'); ?></div>
	<div class="nowidget"><a href="<?php echo home_url(); ?>/wp-admin/widgets.php/" target="_self" title="Click to add widgets">Add Archive Sidebar Widgets</a></div>
	<div class="widget-bottom"></div>
	<?php endif; ?>	
	</div><!--#widget -->	
	
<?php elseif ( is_archive() ) : ?>
<div class='breadcrumbs'>
<?php the_widget( 'PMThemeComments' ); ?>  
</div>
 
 <?php endif; ?> 
 
