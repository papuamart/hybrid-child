<?php
/**
 * Template Name: Blog
 *
 * If you want to set up an alternate blog page, just use this template for your page.
 * This template shows your latest posts.
 *
 * @package Hybrid
 * @subpackage Template
 * @link http://themehybrid.com/themes/hybrid/page-templates/blog
 * @deprecated 0.9.0 Users should no longer be using this template. 'home.php' is used to show posts.
 */

get_header(); // Loads the header.php template. ?>

	<div id="content" class="hfeed content">

		<?php do_atomic( 'before_content' ); // hybrid_before_content ?>

		<?php
			$wp_query = new WP_Query();
			$wp_query->query( array( 'posts_per_page' => get_option( 'posts_per_page' ), 'paged' => $paged ) );
			$more = 0;
		?>

		<?php if ( $wp_query->have_posts() ) : while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>

			<div id="post-<?php the_ID(); ?>" class="<?php hybrid_entry_class(); ?>">


		<?php echo apply_atomic_shortcode( 'entry_title', '[entry-title]' ); ?>
		<?php echo apply_atomic_shortcode( 'entry_subtitle', '[entry-subtitle]' ); ?>
		
		<?php echo apply_atomic_shortcode( 'byline', '<div class="byline">' . __( 'Published by [entry-author] on [entry-published] [entry-comments-link before=" | "] [entry-edit-link before=" | "]', 'my-life' ) . '</div>' ); ?>

		<div class="entry-content">
			<?php the_content(); ?>
			<?php wp_link_pages( array( 'before' => '<p class="page-links">' . __( 'Pages:', 'my-life' ), 'after' => '</p>' ) ); ?>
		</div><!-- .entry-content -->

		<?php echo apply_atomic_shortcode( 'entry_meta', '<div class="entry-meta">' . __( '[entry-cats-with-count before="Posted in "] [entry-tags-with-count before="Tagged "]', 'my-life' ) . '</div>' ); ?>

			</div><!-- .hentry -->

			<?php endwhile; ?>

			<?php do_atomic( 'after_singular' ); // hybrid_after_singular ?>

		<?php else: ?>

		<!--?php if ( current_theme_supports( 'get-the-image' ) ) get_the_image( array( 'meta_key' => 'Thumbnail', 'size' => 'thumbnail' ) ); ?-->
		<!--?php if ( current_theme_supports( 'get-the-image' ) ) get_the_image( array( 'meta_key' => 'Thumbnail', 'size' => 'thumbnail' ) ); ?-->
			<?php if ( current_theme_supports( 'get-the-image' ) ) get_the_image( array( 'custom_key' => false, 'the_post_thumbnail' => false, 'default_size' => 'thumbnail', 'image_scan' => true, 'width' => '125', 'default_image' => 'bloginfo( "stylesheet_directory")/images/default_thumb.gif' ) ); ?>

		<?php echo apply_atomic_shortcode( 'entry_title', '[entry-title]' ); ?>
		<?php echo apply_atomic_shortcode( 'entry_subtitle', '[entry-subtitle]' ); ?>
		
		<?php echo apply_atomic_shortcode( 'byline', '<div class="byline">' . __( 'Published by [entry-author] on [entry-published] [entry-comments-link before=" | "] [entry-edit-link before=" | " [entry-views before=" Views: "]]', 'my-life' ) . '</div>' ); ?>

		<div class="entry-summary">
			<?php the_excerpt(); ?>
			<?php wp_link_pages( array( 'before' => '<p class="page-links">' . __( 'Pages:', 'my-life' ), 'after' => '</p>' ) ); ?>
		</div><!-- .entry-summary -->
		<?php echo apply_atomic_shortcode( 'entry_meta', '<div class="segment">' . __( '[entry-cats-with-count] [entry-tags-with-count] [entry-words-count] [last-modified]', 'my-life' ) . '</div>' ); ?>

		<?php echo apply_atomic_shortcode( 'entry_meta', '<div class="entry-meta">' . __( '[entry-terms taxonomy="category" before="Posted in "] [entry-terms before="| Tagged "]', 'my-life' ) . '</div>' ); ?>

		<?php endif; ?>

		<?php do_atomic( 'after_content' ); // hybrid_after_content ?>

	</div><!-- .content .hfeed -->

<?php get_footer(); // Loads the footer.php template. ?>