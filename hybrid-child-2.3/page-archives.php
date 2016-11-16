<?php
/**
 * Template Name: Archives
 *
 * This will list your categories and monthly archives by default.  Alternatively, you can activate 
 * an archives plugin.
 *
 * @package Hybrid
 * @subpackage Template
 * @deprecated 0.9.0 Template will be renamed page-template-archives.php to comply with theme repo guidelines.
 */

get_header(); // Loads the header.php template. ?>

	<div id="content" class="hfeed content">

		<?php do_atomic( 'before_content' ); // hybrid_before_content ?>

		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

			<div id="post-<?php the_ID(); ?>" class="<?php hybrid_entry_class(); ?>">

				<?php do_atomic( 'before_entry' ); // hybrid_before_entry ?>

				<div class="entry-content">

					<?php the_content(); ?>

					<?php if ( function_exists( 'smartArchives' ) ) : smartArchives( 'both', '' ); ?>

					<?php elseif ( function_exists( 'wp_smart_archives' ) ) : wp_smart_archives(); ?>

					<?php elseif ( function_exists( 'srg_clean_archives' ) ) : srg_clean_archives(); ?>

					<?php else : ?>
		
		<div class="ui-tabs">

			<div class="ui-tabs-wrap">

				<ul class="ui-tabs-nav">
					<li><a href="#archive-post-tabs-1"><?php _e( 'Recent', hybrid_get_textdomain() ); ?></a></li>
					<li><a href="#archive-post-tabs-2"><?php _e( 'Timed', hybrid_get_textdomain() ); ?></a></li>
					<li><a href="#archive-post-tabs-3"><?php _e( 'Clouds', hybrid_get_textdomain() ); ?></a></li>
					<li><a href="#archive-post-tabs-4"><?php _e( 'Latest/ Category', hybrid_get_textdomain() ); ?></a></li>
					<li><a href="#archive-post-tabs-5"><?php _e( 'Archive & RSS', hybrid_get_textdomain() ); ?></a></li>
					<li><a href="#archive-post-tabs-6"><?php _e( 'Top 10 Tags', hybrid_get_textdomain() ); ?></a></li>
					<li><a href="#archive-post-tabs-7"><?php _e( 'Top 10 Categories', hybrid_get_textdomain() ); ?></a></li>
				</ul><!-- .ui-tabs-nav -->

				<div id="archive-post-tabs-1" class="ui-tabs-panel yui-gb">
	
						<div class="yui-u first">	
			<div class="hd"><h3><?php _e( '&raquo;&nbsp;&rang;&nbsp;Recently Updated & Edited Entries', 'sandbox' ) ?></h3></div>
				<div class="box">
				<?php echo do_shortcode( '[recent-updated]' ); ?>
				</div>
						 <div class="hd"><h3><?php _e( '&raquo;&nbsp;&rang;&nbsp;Pages', 'sandbox' ) ?></h3></div>
			<div class="box">
			<ul class="listing">
			<?php global $cache_pages; $cache_pages = false ?>
			<?php wp_list_pages('sort_column=post_name&show_date=xxx&date_format=(n.j.Y)&title_li=&') ?>
			</ul>
				</div>
			</div>
			
			<div class="yui-u">
			<div class="hd"><h3><?php _e( '&raquo;&nbsp;&rang;&nbsp;Recently Posted Entries', 'sandbox' ) ?></h3></div>
			<div id="latest" class="box">
					<?php echo do_shortcode( '[recent-posts]' ); ?>
			</div>
				<div class="hd"><h3><?php _e('&raquo;&nbsp;&rang;&nbsp;Breaking News','sandbox'); ?></h3></div>
<div id="latest" class="box">
	
		<?php 
			if(get_theme_mod('home_latest_from') == 'All Categories')
				query_posts('showposts='.get_theme_mod('home_latest_num').'&caller_get_posts=1');
			else 
				query_posts('cat='.get_theme_mod('home_latest_cat').'&showposts='.get_theme_mod('home_latest_num').'&caller_get_posts=1');
				while(have_posts()) : the_post();
		?>
		<ul class="listing"><li>
			<span class="postdate"><?php echo human_time_diff(get_the_time('U'), current_time('timestamp')) . ' ago'; ?>&nbsp;-&nbsp;</span>
			<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" rel="bookmark"><?php the_title(); ?></a>
		</li></ul>	
			<?php endwhile; wp_reset_query(); ?>
		
	<?php 
		$permalink_structure = get_option('permalink_structure'); 
		echo '<p class="more"><a href="'.get_bloginfo('url');
		if($permalink_structure == '') 
			echo  '/blog/page/2/';
		else 
			echo '/blog/page/1/';
		echo '" title="">';
		_e('More latest news &raquo;','sandbox');
		echo '</a></p>';	?>
</div> <!--end #latest-->
</div>	
			<div class="yui-u">
			<div class="hd"><h3><?php _e( '&raquo;&nbsp;&rang;&nbsp;Recent Comments/ Opinions', 'sandbox' ) ?></h3></div>
			<div class="box">

			<?php the_widget( 'PMThemeComments' ); ?>  
		 
 			</div>				
			</div>				
		</div><!--<div #catstagsrss class="yui-gb"> 1-->   

<div id="archive-post-tabs-2" class="ui-tabs-panel yui-gb">
	<div class="yui-u first">
		 <div class="hd"><h3><?php _e( 'Archives by Last Two Weeks', hybrid_get_textdomain() ); ?></h3></div>
		<div class="box">
		<ul class="xoxo category-archives">
<?php wp_get_archives( array( 'show_post_count' => true, 'type' => 'weekly', 'limit' => '14' ) ); ?>		
<!--?php wp_get_archives( array( 'type' => 'weekly', 'show_post_count' => true ) ); ?-->
			</ul><!-- .xoxo .category-archives -->
	</div>
	</div>
		<div class="yui-u">
			 <div class="hd"><h3><?php _e( 'Archives fort Last 12 Months', hybrid_get_textdomain() ); ?></h3></div>
			<div class="box">
				<ul class="xoxo monthly-archives">
				<?php wp_get_archives( array( 'show_post_count' => true, 'type' => 'monthly', 'limit' => '12' ) ); ?>
				</ul><!-- .xoxo .monthly-archives -->
			</div>
		</div>
			<div class="yui-u">
			 <div class="hd"><h3><?php _e( 'Archives by Year', hybrid_get_textdomain() ); ?></h3></div>
			<div class="box">
				<ul class="xoxo monthly-archives">
				<?php wp_get_archives( array( 'show_post_count' => true, 'type' => 'yearly' ) ); ?>
				</ul><!-- .xoxo .monthly-archives -->
			</div>
			</div>
		</div><!--<div #catstagsrss class="yui-gb"> 2-->   
		
<div id="archive-post-tabs-3" class="ui-tabs-panel yui-gb">
		<div class="yui-u first">
			<div class="hd"><h3><?php _e( '&raquo;&nbsp;&rang;&nbsp;Category Cloud', 'sandbox' ) ?></h3></div>
			<div class="box">
				<ul class="listing">
				<?php wp_tag_cloud( array( 'taxonomy' => 'category' ) ); ?>
				</ul>			
		 </div>
	 </div>
	  
		  <div class="yui-u">
			 <div class="hd"><h3><?php _e( '&raquo;&nbsp;&rang;&nbsp;Tags Cloud', 'sandbox' ) ?></h3></div>
				<div class="box"><ul class="listing">
				  <?php wp_tag_cloud('smallest=10&largest=30&number=50&orderby=count&title_li='); ?>
				  </ul>
			</div>
		  </div>
	  
			  <div class="yui-u">
			 <div class="hd"><h3><?php _e( '&raquo;&nbsp;&rang;&nbsp;Pages', 'sandbox' ) ?></h3></div>
			<div class="box">
		<dl><ul class="listing">
<?php global $cache_pages; $cache_pages = false ?>
			<?php wp_list_pages('sort_column=post_name&show_date=xxx&date_format=(n.j.Y)&title_li=&') ?>
			</ul>
					</dl>
				</div>
			   </div>
		</div><!--<div class="yui-gb"> 3-->   


<div id="archive-post-tabs-4" class="ui-tabs-panel yui-gb">
	<!-- 4 DATA GOES HERE -->
		<div class="hd"><h3><?php _e( '&raquo;&nbsp;&rang;&nbsp;Latest 4/ Category', 'sandbox' ) ?></h3></div>
			<?php posts_by_category(); ?>
				</ul><!-- 7 DATA GOES HERE --><br clear="all">
    </div><!--<div class="yui-gb"> 4-->  

	<div id="archive-post-tabs-5" class="ui-tabs-panel yui-gb">
	<!-- 5 DATA GOES HERE -->
		<div class="yui-u first">	
 <div class="hd"><h3><?php _e( '&raquo;&nbsp;&rang;&nbsp;RSS Feeds by Category', 'sandbox' ) ?></h3></div>
		<div class="box">
				<?php wp_list_categories( array( 'feed' => __( 'RSS', hybrid_get_textdomain() ), 'show_count' => true, 'use_desc_for_title' => false, 'title_li' => false ) ); ?>
		</div>
		</div>

		<div class="yui-u">
 			 <div class="hd"><h3><?php _e( '&raquo;&nbsp;&rang;&nbsp;RSS Feeds by Topics', 'sandbox' ) ?></h3></div>
			<div class="box">
				<ul class="listing">
			 		<?php// echo prologue_recent_projects(); ?>              
			</ul>
		</div>
		</div>
				<div class="yui-u">
	<div class="hd"><h3><strong><?php _e('[+]&nbsp;Top 10 Categories', 'papuamerdeka') ?></strong></h3></div>
	 <div class="box">
			<ul class="listing"><?php wp_list_categories('number=10&show_count=1&orderby=count&feed=RSS&&order=DESC&title_li=') ?>
			</ul>
			</div>
	 </div>
	 </div><!--<div class="yui-gb"> 5-->  
	
	<!-- 6 DATA GOES HERE -->
<div id="archive-post-tabs-6" class="ui-tabs-panel yui-gb">		
			<div class="hd"><h3><?php _e( '&raquo;&nbsp;&rang;&nbsp;Popular Topics', 'sandbox' ) ?></h3></div>
				<?php $noOfTags = 9; $noOfPosts = 4;      
      $cloudRight = get_tags("orderby=count&order=DESC&number=$noOfTags");
      foreach((array)$cloudRight as $tagRight) : ?>   
  <div role="complementary" class="yui-u first">   	  
          <?php $postsRight = new WP_Query();
          $postsRight->query("tag={$tagRight->slug}&showposts=$noOfPosts");  ?>            
		 	
          <?php if ( $postsRight->have_posts() ) :?>
		   <div class="bb box">
            <h4 class="headline2" style="text-transform:capitalize;">&raquo;&nbsp;<?php echo $tagRight->name ?>&nbsp;&nbsp;</h4>
         <?php while ( $postsRight->have_posts() ) : $postsRight->the_post(); ?>
         <ul class="listing"><li><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php short_title(); ?></a>,&nbsp;<span class="postdate">&lrm;<?php echo do_shortcode('[entry-published]') ?>&lrm;</span>
		 </li>
              </ul><?php endwhile;?></div>
          <?php endif; ?>
      <?php  unset($postsRight); echo '</div>'; endforeach; ?>	 
		</div><!--<div class="yui-gb"> 6-->   
		
			<!-- 7 DATA GOES HERE -->
<div id="archive-post-tabs-7" class="ui-tabs-panel yui-gb">		
			<div class="hd"><h3><?php _e( '&raquo;&nbsp;&rang;&nbsp;Popular Topics', 'sandbox' ) ?></h3></div>
					    <?php $noOfCats = 10; $noOfPosts = 5;      
      $cloudRight = get_categories("orderby=count&order=DESC&number=$noOfCats");
      foreach((array)$cloudRight as $catRight) : ?>          
  <div role="complementary" class="yui-u first">	
          <?php $postsRight = new WP_Query();
          $postsRight->query("taxonomy={$catRight->slug}&showposts=$noOfPosts");  ?>            
          <?php if ( $postsRight->have_posts() ) :?>
            <div class="yui-cms-item" id="mylist-first-element"><h3><a href="#" class="accordionRemoveItem action" title="click to remove">&nbsp;</a><a href="#" class="accordionToggleItem">&raquo;&nbsp;<?php echo $catRight->name ?>&nbsp;&nbsp;</a></h3>
             <div class="bd">
              <div class="fixed">
			<?php while ( $postsRight->have_posts() ) : $postsRight->the_post(); ?>
             <ul class='listing'><li><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></li>
              </ul>	
			  <?php endwhile;?></div></div> 
          <?php endif; ?></div>
      <?php unset($postsRight); echo '</div>'; endforeach; ?>	 
		</div><!--<div class="yui-gb"> 7-->  
		
		</div><!--<div class="ui-tabs-wrap">-->   
	</div><!--<div class="ui-tabs">-->   	

					<?php endif; ?>

					<?php wp_link_pages( array( 'before' => '<p class="page-links pages">' . __( 'Pages:', hybrid_get_textdomain() ), 'after' => '</p>' ) ); ?>

				</div><!-- .entry-content -->

				<?php do_atomic( 'after_entry' ); // hybrid_after_entry ?>

			</div><!-- .hentry -->

			<?php do_atomic( 'after_singular' ); // hybrid_after_singular ?>

			<?php comments_template( '/comments.php', true ); // Loads the comments.php template ?>

			<?php endwhile; ?>

		<?php else: ?>

			<?php get_template_part( 'loop-error' ); // Loads the loop-error.php template. ?>

		<?php endif; ?>

		<?php do_atomic( 'after_content' ); // hybrid_after_content ?>

	</div><!-- .content .hfeed -->

<?php get_footer(); // Loads the footer.php template. ?>