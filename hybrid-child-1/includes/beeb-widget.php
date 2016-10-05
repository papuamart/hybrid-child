<?php
// Custom Widgets for The Beeb Theme
class PMThemeList extends WP_Widget {
	function PMThemeList() {
		$widget_ops = array('classname' => 'widget_PMThemeList', 
		'description' => __('Create a list of posts from any of your categories', 'hybrid'));
		$control_ops = array('width' => 350, 'height' => 350);
		$this->WP_Widget('pmthemelist', __('PMNews - List', 'hybrid'), $widget_ops, $control_ops);
	}

function widget($args, $instance) {
	global $post;
	$post_old = $post; 	
	extract( $args );	
	if( !$instance["title"] ) {
		$category_info = get_category($instance["cat"]);
		$instance["title"] = $category_info->name;
	}	
	$cat_posts = new WP_Query("showposts=" . $instance["show"] . "&cat=" . $instance["cat"] . "&offset=" . $instance["skip"]);
	echo $before_widget;	
	
echo $before_title;		
	if( $instance["title_link"] )
		echo '<a href="' . get_category_link($instance["cat"]) . '">' . $instance["title"] . '</a>';
	else
		echo $instance["title"];
		echo $after_title;

end;
	echo "<ul class=listing>";	
	while ( $cat_posts->have_posts() )
	{
		$cat_posts->the_post();
	?>
		<li class="cat-post-item">
			<a class="post-title" href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"> <?php short_title('', '', true, '36'); ?></a>,&nbsp;<span class="postDate"><?php echo human_time_diff(get_the_time('U'), current_time('timestamp')) . ' ago'; ?>&nbsp;-&nbsp;</span>
			</li>
	<?php
	}
	
	echo '</ul>';	
	echo $after_widget;
	$post = $post_old; 
}
function update($new_instance, $old_instance) {	
	return $new_instance;
}
function form($instance) {
?>

<p>
<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/widget-list.gif" alt="widget-list" align="right" style="padding: 1px; margin: 0px 0px 10px 10px; border: 1px solid #C0CCD3; width: 200px; height: 170px;" />
<p>Use this widget to add a list of posts from any of your categories, as shown in the image.</p>
<p>Use the options below to fine-tune your list.</p>
<p>Suitable for <u>all columns</u>.</p>
<div style="clear: both; padding-bottom: 15px; margin-bottom: 20px; border-bottom: 1px solid #C0CCD3;"></div>
	</p>
		<p>
			<label for="<?php echo $this->get_field_id("title"); ?>">
		
				<?php _e( '<p><b>WIDGET TITLE:</b></p>', hybrid_get_textdomain() ); ?>
				<input class="widefat" id="<?php echo $this->get_field_id("title"); ?>" name="<?php echo $this->get_field_name("title"); ?>" type="text" value="<?php echo esc_attr($instance["title"]); ?>" />
				<br /><br /><?php _e( 'Enter a title for this widget, or leave blank to use the selected category name as the title.', hybrid_get_textdomain() ); ?><br /><br />
			</label>
		</p>
		
				<p>				
				<?php _e( '<p><b>LINKABLE TITLE?</b></p>', hybrid_get_textdomain() ); ?>
				<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id("title_link"); ?>" name="<?php echo $this->get_field_name("title_link"); ?>"<?php checked( (bool) $instance["title_link"], true ); ?> />
				<br /><br /><?php _e( 'Check the box to link the widget title to your selected category.', hybrid_get_textdomain() ); ?><br /><br />			</label>
		</p>
			<p>								
			<label for="<?php echo $this->get_field_id("show"); ?>">
					<?php _e( '<p><b>POST COUNT:</b></p>', hybrid_get_textdomain() ); ?>
				<input style="text-align: center;" id="<?php echo $this->get_field_id("show"); ?>" name="<?php echo $this->get_field_name("show"); ?>" type="text" value="<?php echo absint($instance["show"]); ?>" size='3' />
				<br /><br /><?php _e( 'Enter how many posts to show in this list.', hybrid_get_textdomain() ); ?><br /><br />
			</label>
		</p>
		
				<p>
			<label for="<?php echo $this->get_field_id("skip"); ?>">
			<?php _e( '<p><b>SKIP POSTS?</b></p>', hybrid_get_textdomain() ); ?>
			<input style="text-align: center;" id="<?php echo $this->get_field_id("skip"); ?>" name="<?php echo $this->get_field_name("skip"); ?>" type="text" value="<?php echo absint($instance["skip"]); ?>" size='3' />
							<br /><br /><?php _e( 'Enter how many posts to skip before starting this list.', hybrid_get_textdomain() ); ?><br /><br />
							</label>
		</p>
		
		<p>
			<label>
			<?php _e( '<p><b>SELECT A CATEGORY:</b></p>', hybrid_get_textdomain() ); ?>
					<?php wp_dropdown_categories( array( 'name' => $this->get_field_name("cat"), 'selected' => $instance["cat"] ) ); ?>
			<br /><br /><?php _e( 'Select one of your categories to show posts from.', hybrid_get_textdomain() ); ?><br /><br />
			</label>
		</p>
<?php
}
}
add_action( 'widgets_init', create_function('', 'return register_widget("PMThemeList");') );
?>
<?php
 
class PMThemeComments extends WP_Widget {
	function PMThemeComments() {
		$widget_ops = array('classname' => 'widget_pmthemecomments', 
		'description' => __('Add your 10 most-recent comments into a pre-styled widget', 'hybrid'));
		$control_ops = array('width' => 350, 'height' => 350);
		$this->WP_Widget('pmthemecomments', __('PMNews - Comments', 'hybrid'), $widget_ops, $control_ops);
	}
	function widget( $args, $instance ) {
		extract($args);
		$title = apply_filters( 'widget_title', empty($instance['title']) ? '' : $instance['title'], $instance );
		$text = apply_filters( 'widget_execphp', $instance['text'], $instance );
		echo $before_widget;
echo $before_title;
	if( $instance["title"] )
		echo $instance["title"];
	else
		echo 'Latest Comments';
echo $after_title;
?>

<?php
  $pre_HTML ="";
  $post_HTML ="";
  global $wpdb;
  $sql = "SELECT DISTINCT ID, post_title, post_password, comment_ID, comment_post_ID, comment_author, comment_date_gmt, comment_approved, comment_type,comment_author_url, SUBSTRING(comment_content,1,39) AS com_excerpt FROM $wpdb->comments LEFT OUTER JOIN $wpdb->posts ON ($wpdb->comments.comment_post_ID = $wpdb->posts.ID) WHERE comment_approved = '1' AND comment_type = '' AND post_password = '' ORDER BY comment_date_gmt DESC LIMIT 10";

  $comments = $wpdb->get_results($sql);
  $output = $pre_HTML;
  $output .= "\n<ul>";
  foreach ($comments as $comment) {
    $output .= "\n<li>" . "<a href=\"" . get_permalink($comment->ID)."#comment-" . $comment->comment_ID . "\" title=\"on ".$comment->post_title . "\">" . strip_tags($comment->com_excerpt)."</a></li>";
  }
  $output .= "\n</ul>";
  $output .= $post_HTML;
  echo $output;
?>

<?php
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		if ( current_user_can('unfiltered_html') )
			$instance['text'] =  $new_instance['text'];
		else
			$instance['text'] = stripslashes( wp_filter_post_kses( $new_instance['text'] ) );
		$instance['filter'] = isset($new_instance['filter']);
		return $instance;
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'text' => '' ) );
		$title = strip_tags($instance['title']);
		$text = format_to_edit($instance['text']);
?>

<p>
<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/widget-comments.gif" alt="widget-comments" align="right" style="padding: 1px; margin: 0px 0px 10px 10px; border: 1px solid #C0CCD3; width: 200px; height: 144px;" />
<p>Add your 10 most-recent comments into a pre-styled widget, as shown in the image.</p>
<p>Suitable for <u>all columns</u>.</p>
<div style="clear: both; padding-bottom: 15px; margin-bottom: 20px; border-bottom: 1px solid #C0CCD3;"></div>
</p>
		<p>
			<label for="<?php echo $this->get_field_id("title"); ?>">			
							<?php _e( '<p><b>WIDGET TITLE:</b></p>', hybrid_get_textdomain() ); ?>
				<input class="widefat" id="<?php echo $this->get_field_id("title"); ?>" name="<?php echo $this->get_field_name("title"); ?>" type="text" value="<?php echo esc_attr($instance["title"]); ?>" />
			<br /><br /><?php _e( 'Enter a title for this widget, or leave blank to use default text.', hybrid_get_textdomain() ); ?><br /><br />
			</label>
		</p>
<?php
	}
}
add_action('widgets_init', create_function('', 'return register_widget("PMThemeComments");'));
 ?>
<?php
class PMThemeLatestList extends WP_Widget {
	function PMThemeLatestList() {
		$widget_ops = array('classname' => 'widget_PMThemeLatestList', 'description' => __('Create a list of posts from ALL of your categories', 'hybrid'));
		$control_ops = array('width' => 350, 'height' => 350);
		$this->WP_Widget('pmthemelatestlist', __('PMNews - Latest List', 'hybrid'), $widget_ops, $control_ops);
	}
function widget($args, $instance) {
	global $post;
	$post_old = $post; 	
	extract( $args );	
	if( !$instance["title"] ) {
		$category_info = get_category($instance["cat"]);
		$instance["title"] = $category_info->name;
	}	
	$cat_posts = new WP_Query("showposts=" . $instance["show"] . "&offset=" . $instance["skip"]);
	echo $before_widget;	
	echo $before_title;
	if( $instance["title"] )
		echo $instance["title"];
	else
		echo 'Latest News';
		echo $after_title;
end;
	echo "<ul>";
	
	while ( $cat_posts->have_posts() )
	{
		$cat_posts->the_post();
	?>
	<li>
	<a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php short_title('', '', true, '36'); ?></a>,&nbsp;<span class="postDate"><?php echo human_time_diff(get_the_time('U'), current_time('timestamp')) . ' ago'; ?>&nbsp;</span>
	</li>
	<?php
	}	
	echo '</ul>';
	echo $after_widget;
	$post = $post_old; 
}
function update($new_instance, $old_instance) {	
	return $new_instance;
}
function form($instance) {
?>
<p>
<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/widget-latestlist.gif" alt="widget-latestlist" align="right" style="padding: 1px; margin: 0px 0px 10px 10px; border: 1px solid #C0CCD3; width: 200px; height: 172px;" />
<p>Use this widget to add a list of posts from ALL of your categories, as shown in the image.</p>
<p>Use the options below to fine-tune your list.</p>
<p>Suitable for <u>all columns</u>.</p>
<div style="clear: both; padding-bottom: 15px; margin-bottom: 20px; border-bottom: 1px solid #C0CCD3;"></div>
</p>	
		<p>
			<label for="<?php echo $this->get_field_id("title"); ?>">		
				<?php _e( '<p><b>WIDGET TITLE:</b></p>', hybrid_get_textdomain() ); ?>
				<input class="widefat" id="<?php echo $this->get_field_id("title"); ?>" name="<?php echo $this->get_field_name("title"); ?>" type="text" value="<?php echo esc_attr($instance["title"]); ?>" />
				<br /><br /><?php _e( 'Enter a title for this widget, or leave blank to use the default text.', hybrid_get_textdomain() ); ?><br /><br />
			</label>
		</p>		
		
		<p>				
				<?php _e( '<p><b>INVERTED TITLE?</b></p>', hybrid_get_textdomain() ); ?>
				<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id("title_invert"); ?>" name="<?php echo $this->get_field_name("title_invert"); ?>"<?php checked( (bool) $instance["title_invert"], true ); ?> />
				<br /><br /><?php _e( 'Check the box to invert the widget title.', hybrid_get_textdomain() ); ?><br /><br />
				</label>
		</p>		
		
		<p>								
			<label for="<?php echo $this->get_field_id("show"); ?>">
					<?php _e( '<p><b>POST COUNT:</b></p>', hybrid_get_textdomain() ); ?>
				<input style="text-align: center;" id="<?php echo $this->get_field_id("show"); ?>" name="<?php echo $this->get_field_name("show"); ?>" type="text" value="<?php echo absint($instance["show"]); ?>" size='3' />
				<br /><br /><?php _e( 'Enter how many posts to show in this list.', hybrid_get_textdomain() ); ?><br /><br />
			</label>
		</p>
		
	<p>
		<label for="<?php echo $this->get_field_id("skip"); ?>">
		<?php _e( '<p><b>SKIP POSTS?</b></p>', hybrid_get_textdomain() ); ?>
		<input style="text-align: center;" id="<?php echo $this->get_field_id("skip"); ?>" name="<?php echo $this->get_field_name("skip"); ?>" type="text" value="<?php echo absint($instance["skip"]); ?>" size='3' />
							<br /><br /><?php _e( 'Enter how many posts to skip before starting this list.', hybrid_get_textdomain() ); ?><br /><br />
	</label>
		</p>	
<?php
}
}
add_action( 'widgets_init', create_function('', 'return register_widget("PMThemeLatestList");') );

?>
<?php
class PMThemeCatLight extends WP_Widget {
	function PMThemeCatLight() {
		$widget_ops = array('classname' => 'widget_PMThemeCatLight', 
		'description' => __('Highlight an entire category with the catlight widget', 'hybrid'));
		$control_ops = array('width' => 350, 'height' => 350);
		$this->WP_Widget('pmthemecatlight', __('PMNews - CatLight', 'hybrid'), $widget_ops, $control_ops);
	}

function widget($args, $instance) {
	global $post;
	$post_old = $post; 	
	extract( $args );	
	if( !$instance["title"] ) {
		$category_info = get_category($instance["cat"]);
		$instance["title"] = $category_info->name;
	}

	echo $before_widget;
		$cat_posts = new WP_Query("showposts=" . $instance["show"] . "&cat=" . $instance["cat"] . "&offset=" . $instance["skip"]);
echo $before_title;	
	if( $instance["title_link"] )
		echo '<a  class="single-cat-feedlink cat-feedlink" href="' . get_category_link($instance["cat"]) . '">' . $instance["title"] . '</a>';
	else
		echo $instance["title"];
		
echo $after_title;	
	while ( $cat_posts->have_posts() )
	{
		$cat_posts->the_post();
	?>		
<?php $count++; ?>

<?php if ($count == 1) : ?>		
 <?php if ( current_theme_supports( 'get-the-image' ) ) get_the_image( array( 'custom_key' => false, 'Thumbnail' => false, 'default_size' => 'img-catlight-right', 'image_scan' => true, 'default_image' => './wp-content/uploads/images/default_thumb.gif' ) ); ?>

 	<h2 class="widget-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2><span class=""><?php echo do_shortcode('[entry-published]'); ?></span>
	
<div class="entry-summary">
<?php print string_limit_words(get_the_excerpt(), 38); ?>&hellip;
</div>

<div style="clear: both; margin: 0px 0px 15px 0px;"></div>	
<ul class="listing">
		<?php else : ?>
		<?php if ($count == 1) : ?>
		<?php else : ?>

<li><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php short_title('', '', true, '36'); ?></a>,&nbsp;<span class="postDate"><?php echo human_time_diff(get_the_time('U'), current_time('timestamp')) . ' ago'; ?></span></li>
<?php endif; ?>
<?php endif; ?>
<?php
	}	
	echo '</ul>';
	echo $after_widget;
	$post = $post_old; 
}
function update($new_instance, $old_instance) {
	
	return $new_instance;
}
function form($instance) {
?>
<p>
<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/widget-catlight.gif" alt="widget-catlight" align="right" style="padding: 1px; margin: 0px 0px 10px 10px; border: 1px solid #C0CCD3; width: 200px; height: 192px;" />
<p>Use this widget to highlight an entire category, with leading story and a list of more category-specific posts, as shown in the image.</p>
<p>Suitable for <u>all columns</u>.</p>
<div style="clear: both; padding-bottom: 15px; margin-bottom: 20px; border-bottom: 1px solid #C0CCD3;"></div>
	</p>
	
		<p>
			<label for="<?php echo $this->get_field_id("title"); ?>">
							<?php _e( '<p><b>WIDGET TITLE:</b></p>', hybrid_get_textdomain() ); ?>
							<input class="widefat" id="<?php echo $this->get_field_id("title"); ?>" name="<?php echo $this->get_field_name("title"); ?>" type="text" value="<?php echo esc_attr($instance["title"]); ?>" />
			<br /><br /><?php _e( 'Enter a title for this widget, or leave blank to use the default text.', hybrid_get_textdomain() ); ?><br /><br />
			</label>
		</p>		

			<p>
				
				<?php _e( '<p><b>LINKABLE TITLE?</b></p>', hybrid_get_textdomain() ); ?>
				<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id("title_link"); ?>" name="<?php echo $this->get_field_name("title_link"); ?>"<?php checked( (bool) $instance["title_link"], true ); ?> />
				<br /><br /><?php _e( 'Check the box to link the widget title to your selected category.', hybrid_get_textdomain() ); ?><br /><br />
			</label>
		</p>		


				<p>				
				<?php _e( '<p><b>SWITCH IMAGES?</b></p>', hybrid_get_textdomain() ); ?>
				<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id("switch_images"); ?>" name="<?php echo $this->get_field_name("switch_images"); ?>"<?php checked( (bool) $instance["switch_images"], true ); ?> />
				<br /><br /><?php _e( 'Check the box to switch the thumbnail images to be right-aligned.', hybrid_get_textdomain() ); ?><br /><br />


			</label>
		</p>	
	
								<p>
								
			<label for="<?php echo $this->get_field_id("show"); ?>">
					<?php _e( '<p><b>POST COUNT:</b></p>', hybrid_get_textdomain() ); ?>
				<input style="text-align: center;" id="<?php echo $this->get_field_id("show"); ?>" name="<?php echo $this->get_field_name("show"); ?>" type="text" value="<?php echo absint($instance["show"]); ?>" size='3' />
				<br /><br /><?php _e( 'Enter how many posts to show in this list.', hybrid_get_textdomain() ); ?><br /><br />
			</label>
		</p>
		
				<p>
			<label for="<?php echo $this->get_field_id("skip"); ?>">
			<?php _e( '<p><b>SKIP POSTS?</b></p>', hybrid_get_textdomain() ); ?>
			<input style="text-align: center;" id="<?php echo $this->get_field_id("skip"); ?>" name="<?php echo $this->get_field_name("skip"); ?>" type="text" value="<?php echo absint($instance["skip"]); ?>" size='3' />
			<br /><br /><?php _e( 'Enter how many posts to skip before starting this list.', hybrid_get_textdomain() ); ?><br /><br />
			</label>
		</p>
		
		<p>
			<label>
			<?php _e( '<p><b>SELECT A CATEGORY:</b></p>', hybrid_get_textdomain() ); ?>
					<?php wp_dropdown_categories( array( 'name' => $this->get_field_name("cat"), 'selected' => $instance["cat"] ) ); ?>
			<br /><br /><?php _e( 'Select one of your categories to show posts from.', hybrid_get_textdomain() ); ?><br /><br />
			</label>
		</p>
		
<?php
}
}
add_action( 'widgets_init', create_function('', 'return register_widget("PMThemeCatLight");') );

?>
<?php
class PMThemeThumbs extends WP_Widget {
	function PMThemeThumbs() {
		$widget_ops = array('classname' => 'widget_PMThemeThumbs', 
		'description' => __('Highlight posts from any category with thumbnail images', 'hybrid'));
		$control_ops = array('width' => 350, 'height' => 350);
		$this->WP_Widget('pmthemethumbs', __('PMNews - Thumbs', 'hybrid'), $widget_ops, $control_ops);
	}
function widget($args, $instance) {
	global $post;
	$post_old = $post; 
	
	extract( $args );
	
	if( !$instance["title"] ) {
		$category_info = get_category($instance["cat"]);
		$instance["title"] = $category_info->name;
	}
	$cat_posts = new WP_Query("showposts=" . $instance["show"] . "&cat=" . $instance["cat"] . "&offset=" . $instance["skip"]);

	echo $before_widget;
echo $before_title;		
	if( $instance["title_link"] )
		echo '<a href="' . get_category_link($instance["cat"]) . '">' . $instance["title"] . '</a>';
	else
		echo $instance["title"];
		
echo $after_title;
	while ( $cat_posts->have_posts() )
	{
		$cat_posts->the_post();
	?>		
<div style="border-bottom:1px solid #ccc;margin-bttom:10px;">
	<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3><span class=""><?php echo do_shortcode('[entry-published]'); ?></span>
<?php if ( current_theme_supports( 'get-the-image' ) ) get_the_image( array( 'custom_key' => false, 'Thumbnail' => false, 'default_size' => 'img-thumb', 'image_scan' => true, 'default_image' => './wp-content/uploads/images/default_thumb.gif' ) ); ?>


<p class="bd">
<?php print string_limit_words(get_the_excerpt(), 28); ?>&hellip;
</p></div>
<div style="clear: both;"></div>	
<?php
	}
	echo $after_widget;
	$post = $post_old; 
}
function update($new_instance, $old_instance) {
	return $new_instance;
}
function form($instance) {
?>

<p>
<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/widget-thumbs.gif" alt="widget-thumbs" align="right" style="padding: 1px; margin: 0px 0px 10px 10px; border: 1px solid #C0CCD3; width: 200px; height: 191px;" />
<p>Use this widget to add a list of posts, with thumbnail images and an excerpt of text, as shown in the image.</p>
<p>Suitable for <u>all columns</u>.</p>
<div style="clear: both; padding-bottom: 15px; margin-bottom: 20px; border-bottom: 1px solid #C0CCD3;"></div>
	</p>	
		<p>
			<label for="<?php echo $this->get_field_id("title"); ?>">			
				<?php _e( '<p><b>WIDGET TITLE:</b></p>', hybrid_get_textdomain() ); ?>
				<input class="widefat" id="<?php echo $this->get_field_id("title"); ?>" name="<?php echo $this->get_field_name("title"); ?>" type="text" value="<?php echo esc_attr($instance["title"]); ?>" />
			<br /><br /><?php _e( 'Enter a title for this widget, or leave blank to use the default text.', hybrid_get_textdomain() ); ?><br /><br />
			</label>
		</p>		

			<p>				
				<?php _e( '<p><b>LINKABLE TITLE?</b></p>', hybrid_get_textdomain() ); ?>
				<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id("title_link"); ?>" name="<?php echo $this->get_field_name("title_link"); ?>"<?php checked( (bool) $instance["title_link"], true ); ?> />
				<br /><br /><?php _e( 'Check the box to link the widget title to your selected category.', hybrid_get_textdomain() ); ?><br /><br />			</label>
		</p>		
		<p>				
				<?php _e( '<p><b>SWITCH IMAGES?</b></p>', hybrid_get_textdomain() ); ?>
				<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id("switch_images"); ?>" name="<?php echo $this->get_field_name("switch_images"); ?>"<?php checked( (bool) $instance["switch_images"], true ); ?> />
				<br /><br /><?php _e( 'Check the box to switch the thumbnail images to be right-aligned.', hybrid_get_textdomain() ); ?><br /><br />


			</label>
		</p>	
		<p>
								
			<label for="<?php echo $this->get_field_id("show"); ?>">
					<?php _e( '<p><b>POST COUNT:</b></p>', hybrid_get_textdomain() ); ?>
				<input style="text-align: center;" id="<?php echo $this->get_field_id("show"); ?>" name="<?php echo $this->get_field_name("show"); ?>" type="text" value="<?php echo absint($instance["show"]); ?>" size='3' />
				<br /><br /><?php _e( 'Enter how many posts to show in this list.', hybrid_get_textdomain() ); ?><br /><br />
			</label>
		</p>
		
				<p>
			<label for="<?php echo $this->get_field_id("skip"); ?>">
			<?php _e( '<p><b>SKIP POSTS?</b></p>', hybrid_get_textdomain() ); ?>
			<input style="text-align: center;" id="<?php echo $this->get_field_id("skip"); ?>" name="<?php echo $this->get_field_name("skip"); ?>" type="text" value="<?php echo absint($instance["skip"]); ?>" size='3' />
							<br /><br /><?php _e( 'Enter how many posts to skip before starting this list.', hybrid_get_textdomain() ); ?><br /><br />
							
							</label>
		</p>
		
		<p>
			<label>
			<?php _e( '<p><b>SELECT A CATEGORY:</b></p>', hybrid_get_textdomain() ); ?>
					<?php wp_dropdown_categories( array( 'name' => $this->get_field_name("cat"), 'selected' => $instance["cat"] ) ); ?>
			<br /><br /><?php _e( 'Select one of your categories to show posts from.', hybrid_get_textdomain() ); ?><br /><br />
			</label>
		</p>
		
<?php
}
}
add_action( 'widgets_init', create_function('', 'return register_widget("PMThemeThumbs");') );
?>
<?php
class PMThemeVideo extends WP_Widget {

	function PMThemeVideo() {
		$widget_ops = array('classname' => 'widget_pmthemevideo', 'description' => __('Embed a video into a widget', 'hybrid'));
		$control_ops = array('width' => 280, 'height' => 280);
		$this->WP_Widget('pmthemevideo', __('PMNews - Video', 'hybrid'), $widget_ops, $control_ops);
	}

	function widget( $args, $instance ) {
		extract($args);
		$title = apply_filters( 'widget_title', empty($instance['title']) ? '' : $instance['title'], $instance );
		$text = apply_filters( 'widget_execphp', $instance['text'], $instance );
		echo $before_widget;

echo $before_title;		
	if( $instance["title"] )
		echo $instance["title"];
	else
		echo 'Featured Video';
		
echo $after_title;
	?>			
			<center><?php echo $instance['filter'] ? wpautop($text) : $text; ?></center>
		<?php
		echo $after_widget;
	}
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		if ( current_user_can('unfiltered_html') )
			$instance['text'] =  $new_instance['text'];
		else
			$instance['text'] = stripslashes( wp_filter_post_kses( $new_instance['text'] ) );
		$instance['filter'] = isset($new_instance['filter']);
		return $instance;
	}
	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'text' => '' ) );
		$title = strip_tags($instance['title']);
		$text = format_to_edit($instance['text']);
?>

<p>
<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/widget-video.gif" alt="widget-video" align="right" style="padding: 1px; margin: 0px 0px 10px 10px; border: 1px solid #C0CCD3; width: 200px; height: 175px;" />
<p>Use this widget to embed a video into any of your columns from sites such as YouTube and Google Video.</p>
<p>Suitable for <u>all columns</u>.</p>
<div style="clear: both; padding-bottom: 15px; margin-bottom: 20px; border-bottom: 1px solid #C0CCD3;"></div>
	</p>	
	
		<p>
			<label for="<?php echo $this->get_field_id("title"); ?>">			
							<?php _e( '<p><b>WIDGET TITLE:</b></p>', hybrid_get_textdomain() ); ?>

				<input class="widefat" id="<?php echo $this->get_field_id("title"); ?>" name="<?php echo $this->get_field_name("title"); ?>" type="text" value="<?php echo esc_attr($instance["title"]); ?>" />
			<br /><br /><?php _e( 'Enter a title for this widget, or leave blank to use the default text.', hybrid_get_textdomain() ); ?><br /><br />
			</label>
		</p>
				<p>
			<label for="<?php echo $this->get_field_id('text'); ?>">
			
							<?php _e( '<p><b>VIDEO EMBED CODE:</b></p>', hybrid_get_textdomain() ); ?>

		<textarea class="widefat" rows="16" cols="20" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>"><?php echo $text; ?></textarea></p>
			<br /><br /><?php _e( 'Enter the 280*220px video embed code in the field above.', hybrid_get_textdomain() ); ?><br /><br />
				</label>
		</p>
		
<?php } }
add_action('widgets_init', create_function('', 'return register_widget("PMThemeVideo");'));?>