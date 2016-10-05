<?php
if ( ! function_exists( 'hybrid_news_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post—date/time and author.
 * @since Twenty Ten 1.0
 */
function hybrid_news_posted_on() {
echo '<p id=ft class=byline box style="font-size:11px;">';
echo '<span class="meta-sep" style="font-size:10px;">&#64;</span>&nbsp;'; 
echo do_shortcode( '[entry-published]');
if(!is_singular() && !is_page()) {
echo do_shortcode( '[entry-post-count] [entry-words-count] <span class="meta-sep">&#177;</span>[entry-views before=" Views "]' );
}
echo '<span class="meta-sep">&nbsp;&#167;&nbsp;</span>';
comments_popup_link( __( 'Leave a comment', 'your-theme' ), __( '1 Comment', 'hybrid-news' ), __( '% Comments', 'hybrid-news' ) );
echo ('</p>'); 
}
endif;

if ( ! function_exists( 'hybrid_news_posted_in' ) ) :
/**
 * Prints HTML with meta information for the current post (category, tags and permalink).
 * @since Twenty Ten 1.0
 */
function hybrid_news_posted_in() {
echo '<p style="border:1px; color:#111;">';
// Retrieves tag list of current post, separated by commas.
echo '<div class="entry-meta">';
echo do_shortcode('[entry-cats-with-count] [entry-tags-with-count] [last-modified]'); 
echo '</div>';	
echo '</p>';	
}
endif;

//Enable easy display of your post’s word count
function word_count() {
	global $post;
	echo str_word_count($post->post_content);
}


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

/**
* Text highlight for searched-terms i search.php
*******************************/
function hybrid_child_text_highlight($text){
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
add_filter('the_excerpt','hybrid_child_text_highlight');
?>