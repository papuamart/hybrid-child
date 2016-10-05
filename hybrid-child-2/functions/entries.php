<?php
/*
Plugin Name: Entry Categories with Count Plugin
Plugin URI: http://mtdewvirus.com/code/wordpress-plugins/
*/
function cats_with_count( $format = 'list', $before = '', $sep = '', $after = '' ) {
	global $post;
	$postcats = get_the_terms($post->ID, 'category');

	if ( !$postcats )
		return;

	foreach ( $postcats as $cat ) {
			$cat_link = '<a class="cats-links" href="' . get_term_link($cat, 'taxonomy') . '" rel="category">' . $cat->name . ' (' . number_format_i18n( $cat->count ) . ')</a>';	if ( $format == 'list' )
			$cat_link = '<li >' . $cat_link . '</li>';

		$cat_links[] = $cat_link;
	}

	echo $before . join( $sep, $cat_links ) . $after;
}
/*
Plugin Name: Getting Number of Posts in a Category Plugin
Plugin URI: http://mtdewvirus.com/code/wordpress-plugins/

function wt_get_category_count($input = '') {
	global $wpdb;
	if($input == '')
	{
		$category = get_the_category(', ');
		return $category[0]->category_count;
	}
	elseif(is_numeric($input))
	{
		$SQL = "SELECT $wpdb->term_taxonomy.count FROM $wpdb->terms, $wpdb->term_taxonomy WHERE $wpdb->terms.term_id=$wpdb->term_taxonomy.term_id AND $wpdb->term_taxonomy.term_id=$input";
		return $wpdb->get_var($SQL);
	}
	else
	{
		$SQL = "SELECT $wpdb->term_taxonomy.count FROM $wpdb->terms, $wpdb->term_taxonomy WHERE $wpdb->terms.term_id=$wpdb->term_taxonomy.term_id AND $wpdb->terms.slug='$input'";
		return $wpdb->get_var($SQL);
}}
*/
function wt_get_category_count($cat = 0) {
	global $wpdb;
	
	if(empty($cat)) $cat = 0;
	
	$SQL = "SELECT $wpdb->term_taxonomy.count FROM $wpdb->term_taxonomy WHERE $wpdb->term_taxonomy.term_id=$cat";
	$count = $wpdb->get_var($SQL);
	
	if($count)
		return $count;
	else
		return 0;
	
	if($input == '')
	{
		$category = get_the_category();
		return $category[0]->category_count;
	}
	elseif(is_numeric($input))
	{
		$SQL = "SELECT $wpdb->term_taxonomy.count FROM $wpdb->terms, $wpdb->term_taxonomy WHERE $wpdb->terms.term_id=$wpdb->term_taxonomy.term_id AND $wpdb->term_taxonomy.term_id=$input";
		return $wpdb->get_var($SQL);
	}
	else
	{
		$SQL = "SELECT $wpdb->term_taxonomy.count FROM $wpdb->terms, $wpdb->term_taxonomy WHERE $wpdb->terms.term_id=$wpdb->term_taxonomy.term_id AND $wpdb->terms.slug='$input'";
		return $wpdb->get_var($SQL);
	}
}
///
/*
Plugin Name: Entry Tags with Count  Plugin
Plugin URI: http://mtdewvirus.com/code/wordpress-plugins/
*/
function tags_with_count( $format = 'list', $before = '', $sep = '', $after = '' ) {
	global $post;
	$posttags = get_the_tags($post->ID, 'post_tag');
	
	if ( !$posttags )
		return;
	
	foreach ( $posttags as $tag ) {
		if ( $tag->count > 1 && !is_tag($tag->slug) ) {
			$tag_link = '<a class="tags" href="' . get_term_link($tag, 'post_tag') . '" rel="tag">' . $tag->name . ' (' . number_format_i18n( $tag->count ) . ')</a>';
		} else {
			$tag_link = $tag->name;
		}
		
		if ( $format == 'list' )
			$tag_link = '<li>' . $tag_link . '</li>';
		
		$tag_links[] = $tag_link;
	}	
	echo $before . join( $sep, $tag_links ) . $after;
}

/*
Plugin Name: Entry Word Length Count Plugin
Plugin URI: http://mtdewvirus.com/code/wordpress-plugins/
*/

//Enable easy display of your post’s word count
function word_count() {
	global $post;
	echo str_word_count($post->post_content);
}

/*
Plugin Name: Entry Comments Count Plugin
Plugin URI: http://mtdewvirus.com/code/wordpress-plugins/
*/

function commenstCount($type = 'comments'){
	if($type == 'comments'):
		$typeSql = 'comment_type = ""';
		$oneText = 'One comment';
		$moreText = '% comments';
		$noneText = 'No Comments';
	elseif($type == 'pings'):
		$typeSql = 'comment_type != ""';
		$oneText = 'One pingback/trackback';
		$moreText = '% pingbacks/trackbacks';
		$noneText = 'No pinbacks/trackbacks';
	elseif($type == 'trackbacks'):
		$typeSql = 'comment_type = "trackback"';
		$oneText = 'One trackback';
		$moreText = '% trackbacks';
		$noneText = 'No trackbacks';
	elseif($type == 'pingbacks'):
		$typeSql = 'comment_type = "pingback"';
		$oneText = 'One pingback';
		$moreText = '% pingbacks';
		$noneText = 'No pingbacks';
	endif;
	global $wpdb;
    $result = $wpdb->get_var('
        SELECT
            COUNT(comment_ID)
        FROM
            '.$wpdb->comments.'
        WHERE
            '.$typeSql.' AND
            comment_approved="1" AND
            comment_post_ID= '.get_the_ID()
    );
	if($result == 0):
		echo str_replace('%', $result, $noneText);
	elseif($result == 1):
		echo str_replace('%', $result, $oneText);
	elseif($result > 1):
		echo str_replace('%', $result, $moreText);
	endif;
}

/*
Plugin Name: Entry User comment Count Next to Username Plugin
Plugin URI: http://mtdewvirus.com/code/wordpress-plugins/
*/

function commentCount() {
    global $wpdb;
    $count = $wpdb->get_var('SELECT COUNT(comment_ID) FROM ' . $wpdb->comments. ' WHERE comment_author_email = "' . get_comment_author_email() . '"');
    echo $count . ' comments';
}

/*
Plugin Name: Entries Counts Plugin
Plugin URI: http://mtdewvirus.com/code/wordpress-plugins/
*/

function total_posts() {
    global $wpdb;
    echo $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->posts WHERE post_status = 'publish' AND post_type='post'");
}
function total_pages() {
    global $wpdb;
    echo $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->posts WHERE post_status = 'publish' AND post_type='page'");
}
function total_categories() {
    global $wpdb;
    echo$wpdb->get_var("SELECT COUNT(*) FROM $wpdb->term_taxonomy WHERE taxonomy = 'category'");
}
function total_tags() {
	global $wpdb;
	echo $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->term_taxonomy WHERE taxonomy = 'post_tag'");
}
function total_link_categories() {
	global $wpdb;
	echo $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->term_taxonomy WHERE taxonomy = 'link_category'");
}
function total_links() {
	global $wpdb;
	echo $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->term_taxonomy WHERE taxonomy = 'wp_links'");
}
function total_comments() {
	global $wpdb;
	echo $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->comments WHERE comment_approved = 1");
}
function total_users() {
	global $wpdb;
	echo $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->users;");
}
function total_pingbacks() {
global $wpdb;
$count="SELECT COUNT(*) FROM $wpdb->comments WHERE comment_type = 'pingback'";
echo $wpdb->get_var($count);
}
function tb_count() {
global $wpdb;
$count="SELECT COUNT(*) FROM $wpdb->comments WHERE comment_type = 'pingback'";
echo $wpdb->get_var($count);
}

/*
Plugin Name: Alexa SiteMeter Webstats Count Plugin
Plugin URI: http://mtdewvirus.com/code/wordpress-plugins/
*/

function alexa_sitemeter() {
	if ( is_home() || is_front_page())
		echo '<A href="http://www.alexa.com/siteinfo/www.papuapost.com"><SCRIPT type="text/javascript" language="JavaScript" src="http://xslt.alexa.com/site_stats/js/s/a?url=www.papuapost.com"></SCRIPT></A>';
}
add_action( 'news_website-webstats', 'alexa_sitemeter', 11 );
/*
Plugin Name: Mitogo Webstats Count Plugin
Plugin URI: http://mtdewvirus.com/code/wordpress-plugins/
*/
function motigo_webstats() {
	if ( is_home() || is_front_page())
		echo '<!-- Begin Motigo Webstats counter code -->
<a id="mws3945574" href="http://webstats.motigo.com/">
<img width="80" height="15" border="0" alt="Free counter and web stats" src="http://m1.webstats.motigo.com/n80x15.gif?id=ADw0Zg8GL3CBwhHCW0t_B9BeTVJA" /></a>
<script src="http://m1.webstats.motigo.com/c.js?id=3945574&amp;lang=EN&amp;i=25" type="text/javascript"></script>
<!-- End Motigo Webstats counter code -->';
}
add_action( 'news_website-webstats', 'motigo_webstats', 11 );

/*
Plugin Name: Facebook Fans Count Plugin
Plugin URI: http://mtdewvirus.com/code/wordpress-plugins/
*/
function facebook_fans() {
$page_id = "PAGE-ID";
	$xml = @simplexml_load_file("http://api.facebook.com/restserver.php?method=facebook.fql.query&query=SELECT%20fan_count%20FROM%20page%20WHERE%20page_id=".$page_id."") or die ("a lot");
	$fans = $xml->page->fan_count;
	echo $fans;
}	
add_action( 'news_website-webstats', 'facebook_fans', 11 );
?>