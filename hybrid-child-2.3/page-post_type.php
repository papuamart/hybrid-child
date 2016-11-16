<?php
/**
 * Template Name: Custom Posts
 *
 * Displays information at the top of the page about archive and search results when viewing those pages.  
 * This is not shown on the home page and singular views.
 *
 * @package News
 * @subpackage Template
 */
 
get_header(); // Loads the header.php template.
 $do_not_duplicate = array();
?>

<?php do_atomic( 'before_content' ); // hybrid_before_content ?>			

<div id="content" class="hfeed content">
		<div class="ui-tabs">

			<div class="ui-tabs-wrap">

				<ul class="ui-tabs-nav">
					<li><a href="#panel1"><?php _e('Custom Posts', hybrid_get_textdomain() ); ?></a></li>
					<li><a href="#panel2"><?php _e('Topics', hybrid_get_textdomain() ); ?></a></li>
					<li><a href="#panel3"><?php _e('Writers', hybrid_get_textdomain() ); ?></a></li>
					<li><a href="#panel4"><?php _e('Publishers', hybrid_get_textdomain() ); ?></a></li>
					<li><a href="#panel5"><?php _e('Diary Clouds', hybrid_get_textdomain() ); ?></a></li>
				</ul><!-- .ui-tabs-nav -->
				
				<div id="panel1" class="ui-tabs-panel">

				<?php
// set the $paged variable

$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
// query the posts of your custom post types
query_posts( array(
		'post_type' => array(
	         'campaign',
                'document',
                'report',
                'column',
                'editorial',
                'slideshow',
                'video',
                'gallery',
                'faq',
                'events',
                'portfolio',
                'site',
                'podcast'
				),
				'posts_per_page' => 6,
				'paged' => $paged ) // for paging links to work
			);

// have some posts?
if (have_posts()) : ?>

	<?php while ( have_posts() ) : the_post(); ?>

			<div id="post-<?php the_ID(); ?>"  <?php post_class('rounded') ?> class="<?php hybrid_entry_class(); ?>">
	
	<?php do_atomic( 'open_entry' ); // live-wire_open_entry ?>

		<?php if ( current_theme_supports( 'get-the-image' ) ) get_the_image( array( 'custom_key' => false, 'Thumbnail' => false, 'default_size' => 'thumbnail', 'image_scan' => true, 'width' => '125', 'default_image' => './wp-content/uploads/images/default_thumb.gif' ) ); ?>
	
	<?php echo apply_atomic_shortcode( 'entry_title', '[entry-title]' ); ?>
		
		<?php echo apply_atomic_shortcode( 'entry_subtitle', '[entry-subtitle]' ); ?>

			<?php news_posted_on(); ?>
	
				<div class="entry-summary">
					<?php the_excerpt(); ?>
				</div><!-- .entry-summary -->
<?php if( is_tax() ) {
    global $wp_query;
    $term = $wp_query->get_queried_object();
    $title= $term->name;
}; ?>
	</div><!-- .hentry -->

		<?php endwhile; ?>

		<?php else: ?>

			<?php get_template_part( 'loop-error' ); // Loads the loop-error.php template. ?>

		<?php endif; ?>

			<?php do_atomic( 'close_entry' ); // live-wire_open_entry ?>
			<?php get_template_part( 'loop-nav' ); // Loads the loop-error.php template. ?>

	
				</div><!-- .ui-tabs-panel -->
				
				<div id="panel2" class="ui-tabs-panel">

	<?php echo posts_by_taxonomy_topic(); ?>

				</div><!-- .ui-tabs-panel -->
				
				
				<div id="panel3" class="ui-tabs-panel">

	<?php echo posts_by_taxonomy_writer(); ?>

				</div><!-- .ui-tabs-panel -->
				
				
				<div id="panel4" class="ui-tabs-panel">
<?php echo posts_by_taxonomy_publisher(); ?>

	
				</div><!-- .ui-tabs-panel -->
				
				
				<div id="panel5" class="ui-tabs-panel">

	<h3><?php _e( 'Diaries Cloud', hybrid_get_textdomain() ); ?></h3>
	<div class="yui-g">
	<div class="yui-u first">
<h4>&raquo;&nbsp;&nbsp;<?php _e( 'By Topics', hybrid_get_textdomain() ); ?></h4>
<?php wp_tag_cloud( array( 'taxonomy' => 'topic','writer', format => 'list' ) ); ?>
<h4>&raquo;&nbsp;&nbsp;<?php _e( 'By Writers', hybrid_get_textdomain() ); ?></h4>
<?php wp_tag_cloud( array( 'taxonomy' => 'writer', format => 'list' ) ); ?>
	</div><!-- .yui-u first -->

<div class="yui-u">
<h4>&raquo;&nbsp;&nbsp;<?php _e( 'By Actors', hybrid_get_textdomain() ); ?></h4>
<?php wp_tag_cloud( array( 'taxonomy' => 'actor', format => 'list' ) ); ?>
<h4>&raquo;&nbsp;&nbsp;<?php _e( 'By Publishers', hybrid_get_textdomain() ); ?></h4>
<?php wp_tag_cloud( array( 'taxonomy' => 'publisher', format => 'list' ) ); ?>	
</div><!-- .yui-u -->
</div><!-- .yui-gc -->
	
				</div><!-- .ui-tabs-panel -->
 

			</div><!-- .ui-tabs-wrap -->

		</div><!-- .ui-tabs -->
		
	</div><!-- .content .hfeed -->

		<?php do_atomic( 'after_content' ); // hybrid_after_content ?>

<?php get_footer(); // Loads the footer.php template. ?>