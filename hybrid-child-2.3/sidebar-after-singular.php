<?php
/**
 * After Singular Sidebar Template
 *
 * The After Singular sidebar template houses the HTML used for the 'Utility: After Singular' 
 * sidebar.  If widgets are present, they will be displayed.  If no widgets are present and the reader
 * is viewing a singular post, a tabbed list of related posts will be displayed by recent/popular.
 *
 * @package News
 * @subpackage Template
 */

if ( is_active_sidebar( 'after-singular' ) ) : ?>

	<div id="sidebar-after-singular" class="sidebar utility">

		<?php dynamic_sidebar( 'after-singular' ); ?>

	</div><!-- #sidebar-after-singular .utility -->

<?php elseif ( is_singular( 'post' ) ) : ?>

	<?php
		/* Put the categories in an array for related posts. */
		$terms = get_the_terms( get_the_ID(), 'category' );
		$cat__in = array();
		foreach ( $terms as $term )
			$cat__in[] = $term->term_id;
	?>

	<div id="sidebar-after-singular" class="sidebar utility">

		<div class="ui-tabs">

			<div class="ui-tabs-wrap">

				<ul class="ui-tabs-nav">
					<li><a href="#singular-post-tabs-1"><?php _e( 'More Previous', hybrid_get_textdomain() ); ?></a></li>
					<li><a href="#singular-post-tabs-2"><?php _e( 'Popular', hybrid_get_textdomain() ); ?></a></li>
					<li><a href="#singular-post-tabs-3"><?php _e( 'More Next', hybrid_get_textdomain() ); ?></a></li>
					<li><a href="#singular-post-tabs-4"><?php _e( 'Related Tags', hybrid_get_textdomain() ); ?></a></li>
					<li><a href="#singular-post-tabs-6"><?php _e( 'by Category', hybrid_get_textdomain() ); ?></a></li>
				</ul><!-- .ui-tabs-nav -->

				<div id="singular-post-tabs-1" class="ui-tabs-panel">

					<?php $loop = new WP_Query( array( 'cat__in' => $cat__in, 'posts_per_page' => 6, 'ignore_sticky_posts' => true ) ); ?>

					<?php $i = 0; ?>
		
			<div class="yui-g">
		
					<?php if ( $loop->have_posts() ) : ?>
		
				<h4><?php printf( __( '&raquo;&nbsp;&rang;&nbsp;Previous 5 in: %s', 'hybrid-news' ), get_the_category_list(', ') ) ?></h4>										
						<div class="yui-u first">
						
						<ul class="listing">

						<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>

							<?php if ( ++$i == 4 ) { ?>
								</ul></div>
								
								<div class="yui-u">
								
								<ul class="listing">
							<?php } ?>

							<?php the_title( '<li><a href="' . get_permalink() . '" title="' . the_title_attribute( 'echo=0' ) . '">', '</a></li>' ); ?> - <?php echo do_shortcode( '[posted-time-ago]' ); ?>

						<?php endwhile; ?>

						</ul></div>

					<?php endif; ?>
				</div>
				
				</div><!-- #singular-post-tabs-1 .ui-tabs-panel -->

				<div id="singular-post-tabs-2" class="ui-tabs-panel">

					<?php $loop = new WP_Query( array( 'cat__in' => $cat__in, 'orderby' => 'comment_count', 'posts_per_page' => 6, 'ignore_sticky_posts' => true ) ); ?>

					<?php $i = 0; ?>

					<?php if ( $loop->have_posts() ) : ?>

						<div class="yui-g">
						<div class="yui-u first">
						<ul class="listing">

						<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>

							<?php if ( ++$i == 4 ) { ?>
							</ul></div>
								<div class="yui-u">
								<ul class="listing">
							<?php } ?>

							<?php the_title( '<li><a href="' . get_permalink() . '" title="' . the_title_attribute( 'echo=0' ) . '">', '</a></li>' ); ?> - <?php echo do_shortcode( '[posted-time-ago]' ); ?>

						<?php endwhile; wp_reset_query(); ?>

						</ul></div>
				</div><!-- #singular-post-tabs-2 .ui-tabs-panel -->

					<?php endif; ?>

				</div><!-- #singular-post-tabs-2 .ui-tabs-panel -->
				
				<div id="singular-post-tabs-3" class="ui-tabs-panel">
				<h4><?php printf( __( '&raquo;&nbsp;&rang;&nbsp;Next 5 in: %s', 'hybrid-news' ), get_the_category_list(', ') ) ?></h4>
					<?php echo do_shortcode( '[more-articles limit="5"]' );?>
				</div><!-- #singular-post-tabs-3 .ui-tabs-panel -->
				
				
				<div id="singular-post-tabs-4" class="ui-tabs-panel">
				<h4><?php printf( __( '&raquo;&nbsp;&rang;&nbsp;Related Tags: %s', 'hybrid-news' ), get_the_tag_list('&nbsp;&nbsp;') ) ?></h4>
				<?php echo do_shortcode( '[related-by-tag limit="5"]' );?>
				</div><!-- #singular-post-tabs-4 .ui-tabs-panel -->
				
				
			<div id="singular-post-tabs-6">
			<h4 class="archiveheader"><?php _e('&raquo;&nbsp;&rang;&nbsp;Related News by Category&nbsp;', 'hybrid-news'); ?></h4>
	<?php $related = get_posts( array( 'category__in' => wp_get_post_categories($post->ID), 'numberposts' => 5, 'post__not_in' => array($post->ID) ) );
	if( $related ) foreach( $related as $post ) {
	setup_postdata($post); ?>
	<ul class="listing"> 
        <li>
		<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>">,&nbsp;<?php the_title(); ?></a> <?php echo do_shortcode ('<span class=red>&#64;&nbsp;<em>[entry-published]</em></span>'); ?>
            <!--?php the_content('Read the rest of this entry &raquo;'); ?-->
        </li>
    </ul>   
	<?php }
	wp_reset_postdata();?>
		</div><!-- #singular-post-tabs-6 .series -->

			</div><!-- .ui-tabs-wrap -->

		</div><!-- .ui-tabs -->

	</div><!-- #sidebar-singular -->

	<?php elseif ( is_attachment() ) : ?>

<div id="sidebar-after-singular footer-widgeted" class="sidebar utility">
				<div id="navigation" class="hd" style="text-align:center;">
						<span class="previous-image"><?php previous_image_link( false, __( '&larr; Previous' , 'sandbox' ) ); ?></span>
						<span class="next-image"><?php next_image_link( false, __( 'Next &rarr;' , 'sandbox' ) ); ?></span>
					</div><!-- #image-navigation -->

	<div class="yui-cms-accordion multiple fast fixIE" rel="bounceOut" id="mylist-second-accordion">
<h4>
	<a onclick="wp_showhide('showgallery'); changeText(this,'<?php _e('[x]&nbsp;Close Gallery', 'yikwanak') ?>');" href="javascript:void(0);"><?php _e('[+]&nbsp;More Images in this Entry', 'yikwanak') ?></a>
</h4>
	<div id="showgallery" style="display:none;">
		<div class="commentsmyAccordion" style="width: 100%;"> 
	<?php if ( wp_attachment_is_image( get_the_ID() ) ) { // Only show attachment meta for images for now. ?>
 		<div class="yui-cms-item">
	<!--h3><a href="#" class="accordionToggleItem" title="click to expand"><!--?php _e( 'Current Gallery', hybrid_get_textdomain() ); ?></a></h3-->
			<?php $gallery = do_shortcode( sprintf( '[gallery id="%1$s" exclude="%2$s" columns="8" numberposts="24" orderby="meta_value_num"]', $post->post_parent, get_the_ID() ) ); ?>
				<?php if ( !empty( $gallery ) ) { ?>
				<div class="bd">
						<div class="fixed">
						<?php echo $gallery; ?>
						</div><!-- .attachment-meta -->
				</div>
				<?php } ?>

	</div><?php } ?>
	</div>
	</div>
<h4>
	<a onclick="wp_showhide('showimageinfo'); changeText(this,'<?php _e('[x]&nbsp;Close Image Info', 'yikwanak') ?>');" href="javascript:void(0);"><?php _e('[+]&nbsp;Show Image Info', 'yikwanak') ?></a>
</h4>
	<div id="showimageinfo" style="display:none;">
					<div class="yui-cms-item"> 
					<!--<h3><a href="#" class="accordionToggleItem" title="click to expand"><!--?php _e('&raquo;&nbsp;&rang;&nbsp;Image Meta&nbsp;', 'hybrid-news'); ?></a></h3>-->
				<div class="bd"> 
				<div class="fixed"> 
				<?php news_fitted_image_info(); ?>				
				</div>
				</div>
				</div>		
		</div>	

<h4>
	<a onclick="wp_showhide('showlatesgallery'); changeText(this,'<?php _e('[x]&nbsp;Close Gallery', 'yikwanak') ?>');" href="javascript:void(0);"><?php _e('[+]&nbsp;Latest Gallery', 'yikwanak') ?></a>
</h4>
	<div id="showlatesgallery" style="display:none;">
					<div class="yui-cms-item"> 
					<!--h3><a href="#" class="accordionToggleItem" title="click to expand"><!--?php _e('&raquo;&nbsp;&rang;&nbsp;Latest Gallerys&nbsp;', 'hybrid-news'); ?--></a></h3-->
				<div class="bd"> 
				<div class="fixed"> 
				 <?php the_widget( 'News_Widget_Image_Stream', ); ?> 
				</div>
				</div>
				</div>		
		</div>				
		</div>
		</div>		
<?php endif; ?>