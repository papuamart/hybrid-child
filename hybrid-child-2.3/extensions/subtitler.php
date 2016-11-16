<?php
/*
Plugin Name: Subtitler
Plugin URI: http://spidermarket.com
Description: Adds Subtitles to your Wordpress posts. Called using the template tag the_subtitle.
Version: 1.0
Author: Joshua Unseth
Author URI: http://spidermarket.com
*/

function add_subtitle_text_input(){
	global $post;
	$post_id = $post;
	if (is_object($post_id)) {
		$post_id = $post_id->ID;
	}
	$subtitle = htmlspecialchars(stripcslashes(get_post_meta($post_id, 'subtitle', true)));

	echo"
		<div style='background-color:#CCC0;position:absolute; width:700px; top:100px; left:115px;'>
		<input value='subtitle_edit' type='hidden' name='subtitle_edit' />
		<div style='float:left'><h3>Subtitle</h3></div><div style='float:left'><input value='$subtitle' type='text' tabindex='1' name='subtitler_subtitle' size='66'/></div>
		</div>";
}


function the_subtitle(){
	$values = get_post_custom_values("subtitle");
	if (isset($values[0])) {
		$values = get_post_custom_values("subtitle");
		echo $values[0];
	}
}

function get_subtitle($id) {
	$subtitler_edit = $_POST["subtitle_edit"];
	if (isset($subtitler_edit) && !empty($subtitler_edit)) {
		$subtitle = $_POST["subtitler_subtitle"];
		delete_post_meta($id, 'subtitle');
		if (isset($subtitle) && !empty($subtitle)) {
			add_post_meta($id, 'subtitle', $subtitle);
		}
	}
}

function subtitler_css(){
?>
	<style type="text/css">
		<!--
			.postbox, #postdiv, #h2-hack h2 {
				position:relative;
				top:50px;
			}
		-->
	</style>
<?php
}

function h2_hack(){
?>
	<div id="h2-hack">
<?php
}

function h2_hack_cont(){
?>
<?php
}
add_action('edit_post', 'get_subtitle');
add_action('publish_post', 'get_subtitle');
add_action('save_post', 'get_subtitle');
add_action('edit_page_form', 'get_subtitle');
add_action('in_admin_footer', 'h2_hack_cont');

add_action('edit_form_advanced', 'add_subtitle_text_input', 1);
add_action('edit_page_form', 'add_subtitle_text_input', 1);
add_action('edit_form_advanced', 'h2_hack',100);
add_action('admin_head', 'subtitler_css');
?>