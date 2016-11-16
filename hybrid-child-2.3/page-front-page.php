<?php
/**
 * Template Name: Front Page
 *
 * Useful for sites that need a news-type front page.
 *
 * @package HybridNews
 * @subpackage Template
 */

get_header(); ?>

	<div class="hfeed content">

		<?php do_atomic( 'before_content' ); // Before content hook ?>

			<div class="ui-tabs">

			<div class="ui-tabs-wrap">

				<ul class="ui-tabs-nav">
					<li><a href="#panel1"><?php _e('Headlines', hybrid_get_textdomain() ); ?></a></li>
					<li><a href="#panel2"><?php _e('Hot Topics', hybrid_get_textdomain() ); ?></a></li>
					<li><a href="#panel3"><?php _e('In Focus', hybrid_get_textdomain() ); ?></a></li>
					<li><a href="#panel4"><?php _e('The Specials', hybrid_get_textdomain() ); ?></a></li>
					<li><a href="#panel5"><?php _e('About Us', hybrid_get_textdomain() ); ?></a></li>
				</ul><!-- .ui-tabs-nav -->
				
				<div id="panel1" class="ui-tabs-panel">
				
					<!-- Begin feature slider. -->
		<div id="slider-container">

			<div id="slider">

			<?php
				if ( hybrid_get_setting( 'feature_category' ) )
					$feature_query = array( 'cat' => hybrid_get_setting( 'feature_category' ), 'showposts' => hybrid_get_setting( 'feature_num_posts' ), 'ignore_sticky_posts' => true );
				else
					$feature_query = array( 'post__in' => get_option( 'sticky_posts' ), 'showposts' => hybrid_get_setting( 'feature_num_posts' ) );
			?>

				<?php $loop = new WP_Query( $feature_query ); ?>

				<?php while ( $loop->have_posts() ) : $loop->the_post(); $do_not_duplicate[] = $post->ID; ?>

					<div class="<?php hybrid_entry_class( 'feature' ); ?>">

 <?php if ( current_theme_supports( 'get-the-image' ) ) get_the_image( array( 'custom_key' => false, 'Medium', 'Feature Image' => false, 'default_size' => 'medium', 'image_scan' => true,  'width' => 130, 'height' => 100, 'default_image' => './wp-content/uploads/images/default_thumb.gif' ) ); ?>

						<?php do_atomic( 'before_entry' ); ?>

						<div class="entry-summary">
							<?php the_excerpt(); ?>
							<a class="more-link" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php _e( 'Full Story &raquo;', 'hybrid-news' ); ?></a>
						</div>

						<?php do_atomic( 'after_entry' ); ?>

					</div>

				<?php endwhile; ?>

			</div>

			<div class="slider-controls">
				<a class="slider-prev" title="<?php esc_attr_e( 'Previous Post', 'hybrid-news' ); ?>"><?php _e( 'Previous', 'hybrid-news' ); ?></a>
				<a class="slider-pause" title="<?php esc_attr_e( 'Pause', 'hybrid-news' ); ?>"><?php _e( 'Pause', 'hybrid-news' ); ?></a>
				<a class="slider-next" title="<?php esc_attr_e( 'Next Post', 'hybrid-news' ); ?>"><?php _e( 'Next', 'hybrid-news' ); ?></a>
			</div>

		</div>
		<!-- End feature slider. -->

		<!-- Begin excerpts section. -->
		<div id="excerpts">

			<?php $loop = new WP_Query( array( 'cat' => hybrid_get_setting( 'excerpt_category' ), 'showposts' => hybrid_get_setting( 'excerpt_num_posts' ), 'ignore_sticky_posts' => true, 'post__not_in' => $do_not_duplicate ) ); ?>

			<?php while ( $loop->have_posts() ) : $loop->the_post(); $do_not_duplicate[] = $post->ID; ?>

				<div class="<?php hybrid_entry_class(); ?>">

<?php if ( current_theme_supports( 'get-the-image' ) ) get_the_image( array( 'custom_key' => false, 'Thumbnail' => false, 'default_size' => 'news-thumbnail', 'image_scan' => true,  'width' => 130, 'height' => 100, 'default_image' => './wp-content/uploads/images/default_thumb.gif' ) ); ?>

					<?php do_atomic( 'before_entry' ); ?>

					<div class="entry-summary">
						<?php the_excerpt(); ?>
					</div>

					<?php do_atomic( 'after_entry' ); ?>

				</div>

			<?php endwhile; ?>

		</div>
		<!-- End excerpts section. -->

		<?php $categories = hybrid_get_setting( 'headlines_category' ); ?>

		<?php if ( !empty( $categories ) ) : $i = 0; $alt = 'odd'; ?>

			<!-- Begin category headlines section. -->
			<div id="headlines">

			<?php foreach ( $categories as $category ) : ?>

				<?php $headlines = get_posts( array(
					'numberposts' => hybrid_get_setting( 'headlines_num_posts' ), 
					'category' => $category, 
					'post__not_in' => $do_not_duplicate
				) ); ?>

				<?php if ( !empty( $headlines ) ) : ?>

					<div class="section <?php echo $alt; ?>">

						<?php $cat = get_category( $category ); ?>

						<h3 class="section-title"><a href="<?php echo get_category_link( $category ); ?>" title="<?php echo esc_attr( $cat->name ); ?>"><?php echo $cat->name; ?></a></h3>

						<ul class="listing">
						<?php foreach ( $headlines as $post ) : $do_not_duplicate[] = $post->ID; ?>
							<li><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></li>
						<?php endforeach; ?>
						</ul>

					</div>

					<?php $alt = ( ( $i++ % 2 == 0 ) ? 'even' : 'odd' ); ?>

				<?php endif; ?>

			<?php endforeach; ?>

			</div>
			<!-- End category headlines section. -->

		<?php endif; // End check if headline categories were selected. ?>

		
				</div><!-- .ui-tabs-panel -->
				
				<div id="panel2" class="ui-tabs-panel">

<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar('home-1') ) : else : ?>
	<div class="widget-top"><?php _e('Home 1', 'hybrid-news'); ?></div>
	<div class="nowidget"><a href="<?php echo get_settings('home'); ?>/wp-admin/widgets.php/" target="_self" title="Click to add widgets">Add "Home 1" Widgets</a></div>
	<div class="widget-bottom"></div>
	<?php endif; ?> 
				</div><!-- .ui-tabs-panel -->
				
				
				<div id="panel3" class="ui-tabs-panel">

 <?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar('home-2') ) : else : ?>
	<div class="widget-top"><?php _e('Home 2', 'hybrid-news'); ?></div>
	<div class="nowidget"><a href="<?php echo get_settings('home'); ?>/wp-admin/widgets.php/" target="_self" title="Click to add widgets">Add "Home 2" Widgets</a></div>
	<div class="widget-bottom"></div>
<?php endif; ?>
				</div><!-- .ui-tabs-panel -->
				
				
				<div id="panel4" class="ui-tabs-panel">
				
	<!--?php echo posts_by_taxonomy_writer(); ?-->
<?php echo posts_by_taxonomy_topic(); ?>

				</div><!-- .ui-tabs-panel -->				
				<div id="panel5" class="ui-tabs-panel">
				<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar('about-us-widget') ) : else : ?>
	<div class="widget-top"><?php _e('Home About Us', 'hybrid-news'); ?></div>
	<div class="nowidget"><a href="<?php echo get_settings('home'); ?>/wp-admin/widgets.php/" target="_self" title="Click to add widgets">Add "Home About Us" Widgets</a></div>
	<div class="widget-bottom"></div>
<?php endif; ?><div class="clear"></div>
				<?php echo J_ShowAbout();?>

				</div><!-- .ui-tabs-panel -->
				
				
			</div><!-- .ui-tabs-wrap -->

		</div><!-- .ui-tabs -->
				
		<?php get_sidebar( 'front-page' ); // sidebar-front-page.php only for page-front-page.php ?>

		<?php do_atomic( 'after_content' ); // After content hook ?>

	</div><!-- .content .hfeed -->

<?php get_footer(); ?>