<?php
/*
 * ABOUT WIDGET
 */
class about_widget extends WP_Widget {
	function about_widget() {
		$widget_ops = array( 'classname' => 'about_widget', 'description' => 'Display an "about" widget' );
		$control_ops = array( 'width' => 400, 'height' => 350, 'id_base' => 'about_widget' );
		$this->WP_Widget( 'about_widget', 'Gabfire Widget : About', $widget_ops, $control_ops);	
	}
	
	function widget($args, $instance) {
		extract( $args );
		$title	= $instance['title'];
		$avatar	= $instance['a_avatar'] ? '1' : '0';
		$text	= $instance['a_text'];
		$link 	= $instance['a_link'];
		$anchor	= $instance['a_anchor'];

		echo $before_widget;

			if ( $title ) {
				echo $before_title . $title . $after_title;
			}
			
			if($avatar) {
				echo '<div class="widget_avatar">' . get_avatar(get_bloginfo('admin_email'),'50') . '</div>';
			}	
			
			echo '<p>' . nl2br($text) . '</p><div class="clear"></div>';
				
			if($link) {
				echo '<span class="about_more"><a href="' . get_permalink($link) . '">'. $anchor . '</a></span>';
			}
			
		echo $after_widget; 
	}
	
	function update($new_instance, $old_instance) {  
		$instance['title']		= strip_tags($new_instance['title']);
		$instance['a_avatar']	= $new_instance['a_avatar'] ? '1' : '0';
		$instance['a_text'] 	= strip_tags($new_instance['a_text']);
		$instance['a_link'] 	= strip_tags($new_instance['a_link']);
		$instance['a_anchor'] 	= strip_tags($new_instance['a_anchor']); 
		return $new_instance;
	}
 
	function form($instance) {
		$defaults	= array( 'title' => 'About', 'a_avatar' => '1', 'a_text' => '', 'a_link' => '', 'a_anchor' => '');
		$instance = wp_parse_args( (array) $instance, $defaults ); 
	?>

	<p>
		<label for="<?php echo $this->get_field_id('title'); ?>">Title</label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($instance['title']); ?>" />
	</p>
		
	<p>
		<label for="<?php echo $this->get_field_id( 'a_avatar' ); ?>">Site Admin's Avatar</label> 
		<select id="<?php echo $this->get_field_id( 'a_avatar' ); ?>" name="<?php echo $this->get_field_name( 'a_avatar' ); ?>">
			<option value="1" <?php if ( '1' == $instance['a_avatar'] ) echo 'selected="selected"'; ?>>Enable</option>
			<option value="0" <?php if ( '0' == $instance['a_avatar'] ) echo 'selected="selected"'; ?>>Disable</option>	
		</select>
	</p>	
		
	<p>
		<label for="<?php echo $this->get_field_id('a_text'); ?>">About Text</label>
		<textarea class="widefat" rows="5" cols="20" id="<?php echo $this->get_field_id('a_text'); ?>" name="<?php echo $this->get_field_name('a_text'); ?>"><?php echo esc_attr($instance['a_text']); ?></textarea>
	</p>

	<p>
		<label for="<?php echo $this->get_field_id('a_link'); ?>">Post or Page ID for link</label>
		<input id="<?php echo $this->get_field_id('a_link'); ?>" name="<?php echo $this->get_field_name('a_link'); ?>" type="text" value="<?php echo esc_attr( $instance['a_link'] ); ?>" />
	</p>
		
	<p>
		<label for="<?php echo $this->get_field_id('a_anchor'); ?>">Link label</label>
		<input class="widefat" id="<?php echo $this->get_field_id('a_anchor'); ?>" name="<?php echo $this->get_field_name('a_anchor'); ?>" type="text" value="<?php echo esc_attr($instance['a_anchor']); ?>" />
	</p>
<?php
	}
}
register_widget('about_widget');
//
?>