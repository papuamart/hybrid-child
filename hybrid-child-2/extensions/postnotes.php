<?php
/*
Plugin Name: Post Notes
Plugin URI: http://papuapost.com
Description: Adds Space for Notes to your Wordpress posts. Called using the template tag the_postnotes.
Version: 1.0
Author: Joshua Unseth
Author URI: http://papuapost.com
*/

function add_postnote_text_input(){
	global $post;
	$post_id = $post;
	if (is_object($post_id)) {
		$post_id = $post_id->ID;
	}
	$postnote = htmlspecialchars(stripcslashes(get_post_meta($post_id, 'postnote', true)));

	echo"
		<div style='background-color:#F7F7F7;position:absolute; width:666px; top:500px; left:55px;'>
		<input value='postnote_edit' type='hidden' name='postnote_edit' />
		<div style='float:left'><h3>Write Admin Post Note</h3></div><div style='float:left'><input value='$postnote' type='text' tabindex='1' name='postnoter_postnote' size='66'/></div>
		</div>";
}

function the_postnote(){
	$values = get_post_custom_values("postnote");
	if (isset($values[0])) {
		$values = get_post_custom_values("postnote");
		echo $values[0];
	}
}


function get_postnote($id) {
	$postnoter_edit = $_POST["postnote_edit"];
	if (isset($postnoter_edit) && !empty($postnoter_edit)) {
		$postnote = $_POST["postnoter_postnote"];
		delete_post_meta($id, 'postnote');
		if (isset($postnote) && !empty($postnote)) {
			add_post_meta($id, 'postnote', $postnote);
		}
	}
}

function postnoter_css(){
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

function h3_hack(){
?>
	<div id="h3-hack">
<?php
}

function h3_hack_cont(){
?>
<?php
}
add_action('edit_post', 'get_postnote');
add_action('publish_post', 'get_postnote');
add_action('save_post', 'get_postnote');
add_action('edit_page_form', 'get_postnote');
add_action('in_admin_footer', 'h3_hack_cont');

add_action('edit_form_advanced', 'add_postnote_text_input', 1);
add_action('edit_page_form', 'add_postnote_text_input', 1);
add_action('edit_form_advanced', 'h3_hack',100);
add_action('admin_head', 'postnoter_css');
?>