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


add_shortcode('related-by-selected-term', 'related_by_selected_term_shortcode');
// echo do_shortcode( '[related-by-selected-term]' );

function related_by_tag_shortcode( $atts ) {
	extract(shortcode_atts(array(
	    'limit' => '10',
	), $atts));

	global $wpdb, $post, $table_prefix;
	if ($post->ID) {
		$retval = '<ul class=listing>';
 		// Get tags
		$tags = wp_get_post_tags($post->ID);
		$tagsarray = array();
		foreach ($tags as $tag) {
			$tagsarray[] = $tag->term_id;
		}
		$tagslist = implode(',', $tagsarray);
		// Do the query
		$q = "SELECT p.*, count(tr.object_id) as count
			FROM $wpdb->term_taxonomy AS tt, $wpdb->term_relationships AS tr, $wpdb->posts AS p WHERE tt.taxonomy ='post_tag' AND tt.term_taxonomy_id = tr.term_taxonomy_id AND tr.object_id  = p.ID AND tt.term_id IN ($tagslist) AND p.ID != $post->ID
				AND p.post_status = 'publish'
				AND p.post_date_gmt < NOW()
 			GROUP BY tr.object_id
			ORDER BY count DESC, p.post_date_gmt DESC
			LIMIT $limit;";

		$related = $wpdb->get_results($q);
 		if ( $related ) {
			foreach($related as $r) {			
		$retval .= '<li><a title="'.wptexturize($r->post_title).'" href="'.get_permalink($r->ID).'">'.wptexturize($r->post_title).'</a>,&nbsp;<span class=red>&#64;&nbsp;<em>'.do_shortcode ('[entry-published]').'</em></span></li>';
			}
			
		} else {
			$retval .= '
	<li>No related posts found</li>';
		}
		$retval .= '</ul>';
		return $retval;
	}
	return;
}
add_shortcode('related-by-tag', 'related_by_tag_shortcode');
// echo do_shortcode( '[related-by-tag]' );
/////////
function related_by_category_shortcode( $atts ) {
$tags = wp_get_post_tags($post->ID);
			$post_not_in = array($post->ID);
			if ($tags) {
				$tag_ids = array();
				foreach($tags as $individual_tag) $tag_ids[] = $individual_tag->term_id;
				$args=array(
					'tag__in' => $tag_ids,
					'post__not_in' => $post_not_in,
					'showposts'=>10, // Number of related posts that will be shown.
					'caller_get_posts'=>1
				);
				$my_query = new wp_query($args);
				if( $my_query->have_posts() ) {
					echo '&raquo;&nbsp;&rang;&nbsp;Related News by Category';
					while ($my_query->have_posts()) {
						$my_query->the_post();
					?>
						<ul><li><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a><span class=date>,&nbsp;<em>&#64;&nbsp;<?php echo do_shortcode( '[entry-published]' ); ?></em></span></li></ul>
					<?php
					}			
				}}
}
add_shortcode('related_by_category', 'related_by_category_shortcode');
//
// RELATED by words or terms used in the post content
function related_by_content_shortcode() {
//for in the loop, display all "content", regardless of post_type,
//that have the same custom taxonomy (e.g. words) terms as the current post
$backup = $post;  // backup the current object
$found_none = '<h2>No related posts found!</h2>';
$taxonomy = 'words,terms';//  e.g. post_tag, category, custom taxonomy
$param_type = 'words,terms'; //  e.g. tag__in, category__in, but genre__in will NOT work
$post_types = get_post_types( array('public' => true), 'names' );
$tax_args=array('orderby' => 'none');
$tags = wp_get_post_terms( $post->ID , $taxonomy, $tax_args);
if ($tags) {
  foreach ($tags as $tag) {
    $args=array(
      "$param_type" => $tag->slug,
      'post__not_in' => array($post->ID),
      'post_type' => $post_types,
      'showposts'=>5,
      'caller_get_posts'=>1    );
    $my_query = null;
    $my_query = new WP_Query($args);
    if( $my_query->have_posts() ) {
      while ($my_query->have_posts()) : $my_query->the_post(); ?>
       <ul class="listing"><li><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a><span class=red>,&nbsp;<em>&#64;&nbsp;<?php echo do_shortcode( '[entry-published]' ); ?></em></span></li></ul>
        <?php $found_none = '';
		$post_not_in[] = get_the_ID();
      endwhile;
    }
  }
}
if ($found_none) {
echo $found_none;
}
$post = $backup;  // copy it back
wp_reset_query(); // to use the original query again
}
add_shortcode('related_by_content', 'related_by_content_shortcode');

////////////
function more_articles_shortcode() {
if ( is_page('home') || is_archive() || is_single()) :
			global $post;
			$categories = get_the_category();
			foreach ($categories as $category) :?>
			<ul class="listing"><?php
			$posts = get_posts('numberposts=5&offset=1&category='. $category->term_id);
			foreach($posts as $post) : ?>
			<li class="on"><a target="_self" href="<?php the_permalink(); ?>"><?php the_title(); ?></a><span class=red>,&nbsp;<em>&#64;&nbsp;<?php echo do_shortcode( '[entry-published]' ); ?></em></span></li><?php endforeach; ?><p></p>
			<li><h4>[+]<a href="<?php echo get_category_link($category->term_id);?>" title="<?php _e('Go to '); ?>
			<?php echo $category->name; ?>"> <?php _e('Go to '); ?> <strong>'<?php echo $category->name; ?>'</strong> 
			<?php _e('Archive'); ?> &raquo;</a></h4></li>
			<?php endforeach; endif ;
	echo '</ul>';
}
add_shortcode('more-articles', 'more_articles_shortcode');

// 4. Adding Previous Entries From The Same Category
function prev_related($atts, $content = null) {
		extract(shortcode_atts(array(
				"num" => '5',
				"cat" => ''
		), $atts));
		global $post;
		$myposts = get_posts('numberposts='.$num.'&order=DESC&orderby=random&category='.$cat);
		$retour='<ul class=listing>';
		foreach($myposts as $post) :
				setup_postdata($post);
			 $retour.='<li><a href="'.get_permalink().'">'.the_title("","",false).'</a>,&nbsp;<span class=red>&#64;&nbsp;'.do_shortcode ('[entry-published]').'</span></li>';
		endforeach;
		$retour.='</ul> ';
		return $retour;
}
//add_shortcode('related-prev', 'prev_related');
// In this example the shortcode [related] will randomly display 5 entries from the same category.
// WordPress Custom Fields: Listing A Series Of Posts
function article_series() {
	global $post;
	$series = get_post_meta($post->ID, 'Series', true);
	if($series) :
		$args = array(
			'numberposts' => -1,
			'meta_key' => 'Series',
			'meta_value' => $series,
		);
		$series_posts = get_posts($args);
		if($series_posts) :
			$class = preg_replace("/[^a-z0-9\\040\\.\\-\\_\\\\]/i", "", $series);
			$class = strtolower(str_replace(array(' ', '&nbsp;'), '-', $class));
			echo '<div class="series series-' . $class . '"><h4 class="series-title">' . __('Articles in this series') . '</h4><ul>';
			foreach($series_posts as $serial) :
				if($serial->ID == $post->ID)
					echo '<li class="current-post">' . $serial->post_title . '</li>';
				else
					echo '<li><a href="' . get_permalink($serial->ID) . '" title="' . str_replace('"', '"', $serial->post_title) . '">' . str_replace('"', '"', $serial->post_title) . '</a></li>';
			endforeach;
			echo '</ul></div>';
		endif;
	endif;
}
function related_from_google() {?>
<div id="gajax" style="width:600px;">
<script src="http://www.google.com/jsapi?partner-pub-1092473475447397:9613820256"></script>
    <script language="Javascript" type="text/javascript">
      google.load('search', '1.0');
      function OnLoad() {
        // create a tabbed mode search control
        var tabbed = new google.search.SearchControl();

			tabbed.addSearcher(new google.search.BlogSearch());
			tabbed.addSearcher(new google.search.VideoSearch());
			tabbed.addSearcher(new google.search.NewsSearch());
 			tabbed.addSearcher(new google.search.WebSearch());
			tabbed.addSearcher(new google.search.ImageSearch());
			tabbed.addSearcher(new google.search.BookSearch());
			tabbed.addSearcher(new google.search.LocalSearch());
        // draw in tabbed layout mode
        var drawOptions = new google.search.DrawOptions();
        drawOptions.setDrawMode(google.search.SearchControl.DRAW_MODE_TABBED);
        tabbed.draw(document.getElementById("search_control_tabbed"), drawOptions);
        tabbed.execute("<?php the_title(); ?>");
      }
      google.setOnLoadCallback(OnLoad, true);

    </script>
    <div style="float: left;width:600px;" class="search-control" id="search_control_tabbed">Loading</div>
</div>
<?php
}
//add_shortcode('related-from-google', 'related_from_google');
?>