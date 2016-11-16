<!--Popular posts by Paul Stamatiou: http://paulstamatiou.com/2007/06/03/how-to-twitter-bar-popular-posts-random-stats-->
<div class="pop-inthiscat-tag">
<?php 
$now = gmdate("Y-m-d H:i:s",time());
$tagid = get_query_var('post_tag');
$lastmonth = gmdate("Y-m-d H:i:s",gmmktime(date("H"), date("i"), date("s"), date("m")-12,date("d"),date("Y")));
$popularposts = "SELECT ID, post_title, post_date, comment_count, COUNT($wpdb->comments.comment_post_ID) AS 'stammy', $wpdb->term_relationships.object_ID AS 'tagy' FROM $wpdb->posts, $wpdb->term_relationships, $wpdb->comments WHERE comment_approved = '1' AND term_taxonomy_id = '$tagid' AND $wpdb->posts.ID=$wpdb->comments.comment_post_ID AND $wpdb->posts.ID=$wpdb->term_relationships.object_ID AND post_status = 'publish' AND post_date < '$now' AND post_date > '$lastmonth' AND comment_status = 'open' GROUP BY $wpdb->comments.comment_post_ID ORDER BY stammy DESC LIMIT 3";
$posts = $wpdb->get_results($popularposts);
$popular = '';
if($posts){ ?>
<!---->
 <!---->
    <div class="widget-title">&nbsp;<?php _e('Popular posts under', 'hybrid') ?> &nbsp;"<?php echo single_tag_title(); ?>&laquo;
	</div> 
<?php			
 foreach($posts as $post){
	    $post_title = stripslashes($post->post_title);
		$guid = get_permalink($post->ID);
		$post_date = stripslashes($post->post_date);
		$comment_count = stripslashes($post->comment_count);?>
	<ul>
		<li><?php echo do_shortcode( '[entry-published]' ); ?>&nbsp;-&nbsp;<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>&nbsp;
	<?php the_content_limit('166'); ?></li></ul>

<?php 
}
}
?></div>