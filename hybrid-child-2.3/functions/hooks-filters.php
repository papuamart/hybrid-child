<?php
/**
 * Functions:
 * semantic_navigation();
 * semantic_news_posted_on(); news_posted_in
 * semantic_title();
 * semantic_body();
 * semantic_entries();
 * semantic_comments();
 * semantic_last_class();
 * semantic_date_classes();
 * semantic_gallery();
 */
// disable admin bar menu on top of wordpres page
	add_filter( 'show_admin_bar', '__return_false' ); 
/**
 * REMOVE SIDEBAR AND FOOTER WIDGETS OR SECONDARY AND SUBSIDIARY
 *  disable sidebars from SINGLE PAGE AND POST
*/
add_filter( 'sidebars_widgets', 'disable_all_widgets' );
function disable_all_widgets( $sidebars_widgets ) {
 if ( is_attachment() ||
 is_page_template('page-home-trial.php') || 
 is_page_template('page-newspaper-layout.php') || 
 is_page_template('page-home-test.php') || 
 is_page_template('page-home-layout.php') || 
  is_page('category-archives') || 
 is_page('forum') || 
 is_page('facebook') || 
 is_page('google-archive') || 
 is_singular('gallery') || 
 is_singular('video') || 
 is_singular('slideshow') || 
 is_page_template('page-no-widgets.php') || 
 is_page_template('page-pmnews-home.php') ) 
 $sidebars_widgets = array( false );
 return $sidebars_widgets;
}
 
/*
add_filter( 'sidebars_widgets', 'disable_secondary_widgets' );
function disable_secondary_widgets( $sidebars_widgets ) {
	if ( is_singular() && is_page() )
		$sidebars_widgets['secondary'] = false;
	return $sidebars_widgets;
}

*/
add_filter('wp_nav_menu_items','add_date', 11, 2);
function add_date($items, $args) {
	if ( 'secondary' == $args->theme_location ) {
    $items .= '<li style="margin-top:8px;" class="vsep"><span class="cms-dynamic">' . date("l F jS, Y"). '</span></li>';
	$items = str_replace( '</ul></div>', $links . '</ul></div>', $items );	
	}
    return $items;
}

/*
*
*/
/*
add_filter('hybrid_class','browser_body_class');
function browser_body_class($classes) {
	global $is_lynx, $is_gecko, $is_IE, $is_opera, $is_NS4, $is_safari, $is_chrome, $is_iphone;

	if($is_lynx) $classes[] = 'lynx';
	elseif($is_gecko) $classes[] = 'gecko';
	elseif($is_opera) $classes[] = 'opera';
	elseif($is_NS4) $classes[] = 'ns4';
	elseif($is_safari) $classes[] = 'safari';
	elseif($is_chrome) $classes[] = 'chrome';
	elseif($is_IE) $classes[] = 'ie';
	else $classes[] = 'unknown';

	if($is_iphone) $classes[] = 'iphone';
	return $classes;
}

add_filter( 'wp_get_attachment_link', 'gallery_prettyPhoto');

add_filter('wp_nav_menu_items','add_search_box', 10, 2);
function add_search_box($items, $args) {
	if ( 'secondary' == $args->theme_location ) {
        ob_start();
        get_search_form();
        $searchform = ob_get_contents();
        ob_end_clean();
        $items .= '<div class=""><li class="search-form vsep">' . $searchform . '</li></div>';
}		
    return $items;
}*/
function pmnews_text_highlight($text){
  if(is_search()){
    global $wp_query; //we need this for the search terms
    $keys = explode(" ",$wp_query->query_vars['s']);
    $text =
      preg_replace(
        '/('.implode('|', $keys) .')/iu',
        '<span style="background-color: #fc0; font-weight:400;">\0</span>',
        $text);

  }
    return $text;
}
add_filter('the_excerpt','pmnews_text_highlight'); /*this adds a coloured text to the searched term

/* Go threw a string to see if it contains a certain character */
		function hasQuestionMark($string) {
			$length = strlen($string);
			for($i = 0; $i < $length; $i++) {
				$char = $string[$i];
				if($char == '?') { return true; }
			}
			return false;
}

// Replace keywords or cursing in the comments
function wps_filter_comment($comment) {
	$replace = array(
		// 'WORD TO REPLACE' => 'REPLACE WORD WITH THIS'
		'foobar' => '*****',
		'hate' => 'love',
		'cuki' => 'sayang',
		'puki' => 'sobat',
		'bodoh' => 'pintar',
		'anjing' => 'sobat',
		'babi' => 'sobat',
		'zoom' => '<a href="http://zoom.com">zoom</a>'
	);
	$comment = str_replace(array_keys($replace), $replace, $comment);
	return $comment;
}
// Get limit excerpt
function the_content_limit($max_char, $more_link_text = '(Read full story...)', $stripteaser = 0, $more_file = '') {
    $content = get_the_content($more_link_text, $stripteaser, $more_file);
    $content = apply_filters('the_content', $content);
    $content = str_replace(']]>', ']]&gt;', $content);
    $content = strip_tags($content);

   if (strlen($_GET['p']) > 0) {
      echo "<p>";
      echo $content;
      echo "&nbsp;<a href='";
      the_permalink();
      echo "'>"."Read More &rarr;</a>";
      echo "</p>";
   }
   else if ((strlen($content)>$max_char) && ($espacio = strpos($content, " ", $max_char ))) {
        $content = substr($content, 0, $espacio);
        $content = $content;
        echo "<p>";
        echo $content;
        echo "...";
        echo "&nbsp;<a href='";

        the_permalink();
        echo "'>".$more_link_text."</a>";
        echo "</p>";
   }
   else {
      echo "<p>";

      echo $content;
      echo "&nbsp;<a href='";
      the_permalink();
      echo "'>"."Read More &rarr;</a>";
      echo "</p>";
   }
}
#Theme Functions
function string_limit_words($string, $word_limit)
{
	$words = explode(' ', $string, ($word_limit + 1));
	if(count($words) > $word_limit)
	array_pop($words);
	return implode(' ', $words);
}
/**
 * Default entry utility for posts.
 *
 * @since 0.9
 */
function pmnews_content_utility( $cutility = '' ) {

	if ( $cutility )
		$cutility = '<p class="content-utility">' . $cutility . '</p>';
	else
		$cutility = '';

	echo apply_atomic_shortcode( 'content_utility', $cutility );
}
//
// COMMENTS AJAXED
add_action('init', 'wdp_ajaxcomments_load_js', 10);
	function wdp_ajaxcomments_load_js(){
			wp_enqueue_script('ajaxcomments', get_stylesheet_directory_uri().'/wdp-ajaxed-comments/js/jquery.validate.min.js',	array('jquery', 'ajaxValidate'), '1.5.1');
			wp_enqueue_script('ajaxcomments', get_stylesheet_directory_uri().'/wdp-ajaxed-comments/js/ajax-comments.js',	array('jquery', 'ajaxcomments'), '1.3');
	}
	add_action('comment_post', 'wdp_ajaxcomments_stop_for_ajax',20, 2);
	function wdp_ajaxcomments_stop_for_ajax($comment_ID, $comment_status){
		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
		//If AJAX Request Then
			switch($comment_status){
				case '0':
					//notify moderator of unapproved comment
					wp_notify_moderator($comment_ID);
				case '1': //Approved comment
					echo "success";
					$commentdata=&get_comment($comment_ID, ARRAY_A);
					$post=&get_post($commentdata['comment_post_ID']); //Notify post author of comment
					if ( get_option('comments_notify') && $commentdata['comment_approved'] && $post->post_author != $commentdata['user_ID'] )
						wp_notify_postauthor($comment_ID, $commentdata['comment_type']);
					break;
				default:
					echo "error";
			}
			exit;
		}
}

// WordPress: Output Clean and Valid HTML Content
include_once ( get_stylesheet_directory() . '/admin/htmLawed/htmLawed.php' ); // THIS FILE SHOULD RESIDE IN THE THEME FOLDER.
function clean_the_content( $content )
{
	$szPostContent = $content;
	$szRemoveFilter = array( "~<p[^>]*>\s?</p>~", "~<a[^>]*>\s?</a>~", "~<font[^>]*>~", "~<\/font>~", "~<span[^>]*>\s?</span>~" );
	$szPostContent = preg_replace( $szRemoveFilter, '' , $szPostContent);
	$szPostContent = htmLawed($szPostContent);
	return $szPostContent;
}
// Enable delete and spam links for all versions of wordpress
function delete_comment_link($id) {
	if (current_user_can('edit_post')) {
		echo '| <a href="'.get_bloginfo('wpurl').'/wp-admin/comment.php?action=cdc&c='.$id.'">del</a> ';
		echo '| <a href="'.get_bloginfo('wpurl').'/wp-admin/comment.php?action=cdc&dt=spam&c='.$id.'">spam</a>';
	}
}
add_filter('the_content', 'clean_the_content');
// Automatically refuse spam comments on your WordPress blog
function in_comment_post_like($string, $array) {
foreach($array as $ref) { if(strstr($string, $ref)) { return true; } }
return false;
}
function drop_bad_comments() {
if (!empty($_POST['comment'])) {
$post_comment_content = $_POST['comment'];
$lower_case_comment = strtolower($_POST['comment']);
$bad_comment_content = array(
'viagra',
'hydrocodone',
'hair loss',
'[url=http',
'[link=http',
'xanax',
'tramadol',
'russian girls',
'russian brides',
'lorazepam',
'adderall',
'dexadrine',
'no prescription',
'oxycontin',
'without a prescription',
'sex pics',
'family incest',
'online casinos',
'online dating',
'cialis',
'best forex',
'babi',
'anjing',
'tolol',
'cuki',
'kolot',
'pepe',
'kontol',
'seks',
'monyet',
'sex',
'kondom',
'ayam kampung',
'ayam kampus',
'<?',
'?>',
'forex',
'original watch',
'hair loss',
'nude pics',
'amoxicillin',
'puki'
);
if (in_comment_post_like($lower_case_comment, $bad_comment_content)) {
$comment_box_text = wordwrap(trim($post_comment_content), 80, "\n ", true);
$txtdrop = fopen('/../../../../wp_post-logger/nullamatix.com-text-area_dropped.txt', 'a');
fwrite($txtdrop, " --------------\n [COMMENT] = " . $post_comment_content . "\n --------------\n");
fwrite($txtdrop, " [SOURCE_IP] = " . $_SERVER['REMOTE_ADDR'] . " @ " . date("F j, Y, g:i a") . "\n");
fwrite($txtdrop, " [USERAGENT] = " . $_SERVER['HTTP_USER_AGENT'] . "\n");
fwrite($txtdrop, " [REFERER ] = " . $_SERVER['HTTP_REFERER'] . "\n");
fwrite($txtdrop, " [FILE_NAME] = " . $_SERVER['SCRIPT_NAME'] . " - [REQ_URI] = " . $_SERVER['REQUEST_URI'] . "\n");
fwrite($txtdrop, '--------------**********------------------'."\n");
header("HTTP/1.1 406 Not Acceptable");
header("Status: 406 Not Acceptable");
header("Connection: Close");
wp_die( __('bang bang.') );
}
}
}
add_action('init', 'drop_bad_comments');
// remove actions & filters (Related Posts Plugin & WP-PageNavi)
remove_filter( 'the_content', 'inlinePostTags');
remove_filter( 'the_content', 'inlineRelatedPosts');
remove_action( 'wp_print_styles', 'pagenavi_stylesheets');
// remove junk from head
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'feed_links', 2);
remove_action('wp_head', 'index_rel_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'feed_links_extra', 3);
remove_action('wp_head', 'start_post_rel_link', 10, 0);
remove_action('wp_head', 'parent_post_rel_link', 10, 0);
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);
// remove nofollow from comments
function xwp_dofollow($str) {
	$str = preg_replace(
		'~<a ([^>]*)\s*(["|\']{1}\w*)\s*nofollow([^>]*)>~U',
		'<a ${1}${2}${3}>', $str);
	return str_replace(array(' rel=""', " rel=''"), '', $str);
}
remove_filter('pre_comment_content',     'wp_rel_nofollow');
add_filter   ('get_comment_author_link', 'xwp_dofollow');
add_filter   ('post_comments_link',      'xwp_dofollow');
add_filter   ('comment_reply_link',      'xwp_dofollow');
add_filter   ('comment_text',            'xwp_dofollow');
// Removing the_content filters by tag
function my_template_redirect() {
	global $wp_query;
 
	if (!is_singular() || !$wp_query->post) {
		remove_plugin_filters();
		return;
	}
	$post = $wp_query->post;
	$wp_syntax = FALSE;
 
	if ($post->post_type == 'post') :
		$tags = wp_get_object_terms($post->ID, 'post_tag');
		foreach ($tags as $tag) {
			if ($tag->name == "wp-syntax") {
				$wp_syntax = TRUE;
                                break;
			}
		}	
	endif;
 
	if (!$wp_syntax) {
		remove_plugin_filters();	
         }
}


// Stop more link from jumping to middle of page
function remove_more_jump_link($link) { 
	$offset = strpos($link, '#more-');
	if ($offset) {
		$end = strpos($link, '"',$offset);
	}
	if ($end) {
		$link = substr_replace($link, '', $offset, $end-$offset);
	}
	return $link;
}
add_filter('the_content_more_link', 'remove_more_jump_link');

add_filter('comments_array', 'filterTrackbacks', 0);
add_filter('the_posts', 'filterPostComments', 0);
//Updates the comment number for posts with trackbacks
function filterPostComments($posts) {
	foreach ($posts as $key => $p) {
		if ($p->comment_count <= 0) { return $posts; }
		$comments = get_approved_comments((int)$p->ID);
		$comments = array_filter($comments, "stripTrackback");
		$posts[$key]->comment_count = sizeof($comments);
	}
	return $posts;
}
//Updates the count for comments and trackbacks
function filterTrackbacks($comms) {
global $comments, $trackbacks;
	$comments = array_filter($comms,"stripTrackback");
	return $comments;
}
//Strips out trackbacks/pingbacks
function stripTrackback($var) {
	if ($var->comment_type == 'trackback' || $var->comment_type == 'pingback') { return false; }
	return true;
}

function my_remove_all_shortcodes() {
  global $shortcode_tags;
  global $temp_shortcode_tags;
  $temp_shortcode_tags = $shortcode_tags;
  remove_all_shortcodes();
}
 
function my_restore_all_shortcodes() {
  global $shortcode_tags;
  global $temp_shortcode_tags;
  if(!empty($temp_shortcode_tags)) {
    $shortcode_tags = $temp_shortcode_tags;
  }
}

remove_action('wp_head', 'wp_generator');
add_filter('login_errors', create_function('$a', "return null;"));
remove_filter('the_content', 'wptexturize');
// This will occur when the comment is posted
function plc_comment_post( $incoming_comment ) {

	// convert everything in a comment to display literally
	$incoming_comment['comment_content'] = htmlspecialchars($incoming_comment['comment_content']);

	// the one exception is single quotes, which cannot be #039; because WordPress marks it as spam
	$incoming_comment['comment_content'] = str_replace( "'", '&apos;', $incoming_comment['comment_content'] );

	return( $incoming_comment );
}

// This will occur before a comment is displayed
function plc_comment_display( $comment_to_display ) {

	// Put the single quotes back in
	$comment_to_display = str_replace( '&apos;', "'", $comment_to_display );

	return $comment_to_display;
}

add_filter( 'preprocess_comment', 'plc_comment_post', '', 1);
add_filter( 'comment_text', 'plc_comment_display', '', 1);
add_filter( 'comment_text_rss', 'plc_comment_display', '', 1);
add_filter( 'comment_excerpt', 'plc_comment_display', '', 1);
?>