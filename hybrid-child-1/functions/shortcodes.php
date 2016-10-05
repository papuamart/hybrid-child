<?php
/**
 * Additional shortcodes for use within the theme.
 *
 * @package News
 * @subpackage Includes
 * @since 0.1.0
 */

/**
 * Registers new shortcodes.
 *
 * @since 0.1.0
 */
function news_register_shortcodes() {
	add_shortcode( 'slideshow', 'news_slideshow_shortcode' );
	add_shortcode( 'entry-popup-shortlink', 'news_entry_shortlink_popup_shortcode' );
	add_shortcode( 'entry-print-link', 'news_entry_print_link_shortcode' );
	add_shortcode( 'entry-email-link', 'news_entry_email_link_shortcode' );
	add_shortcode( 'entry-mixx-link', 'news_entry_mixx_link_shortcode' );
	add_shortcode( 'entry-delicious-link', 'news_entry_delicious_link_shortcode' );
	add_shortcode( 'entry-digg-link', 'news_entry_digg_link_shortcode' );
	add_shortcode( 'entry-facebook-link', 'news_entry_facebook_link_shortcode' );
	add_shortcode( 'entry-twitter-link', 'news_entry_twitter_link_shortcode' );
	add_shortcode( 'entry-date-published', 'news_entry_published_link_shortcode' );

	add_shortcode( 'entry-tags-with-count', 'news_entry_tag_with_count_shortcode' );
	add_shortcode( 'entry-category-with-count', 'news_entry_category_with_count_shortcode' );
	add_shortcode( 'entry-cats-with-count', 'news_entry_cats_with_count_shortcode' );
	add_shortcode( 'entry-words-count', 'news_entry_word_count_shortcode' );
	add_shortcode( 'entry-post-count', 'news_entry_post_count_shortcode' );	
	add_shortcode('last-modified', 'last_modified_posts_shortcode');	

}

/**
 * Shortlink popup shortcode.
 *
 * @since 0.1.0
 */
function news_entry_shortlink_popup_shortcode() {
	$shortlink = wp_get_shortlink( get_the_ID() );

	if ( empty( $shortlink ) )
		return '';

	$id = sanitize_html_class( 'shortlink-' . get_the_ID() );
	$title = sprintf( __( "Shortlink for '%s'", 'news' ), get_the_title() );
	$out = '<a class="tips shortlink hide-if-no-js" rel="#' . $id . '" title="' . esc_attr( $title ) . '">' . __( 'Shortlink', 'news' ) . '</a>';
	$out .= ' <div id="' . $id . '" class="tip hide">';
	$out .= '<input type="text" value="' . esc_url( $shortlink ) . '" onclick="this.focus(); this.select();" />';
	$out .= '</div>';

	return $out;
}

/**
 * Print link shortcode.
 *
 * @since 0.1.0
 */
function news_entry_print_link_shortcode() {
	return '<a class="print-link hide-if-no-js" href="#">' . __( 'Print', 'news' ) . '</a>';
}

/**
 * Email link shortcode.
 *
 * @since 0.1.0
 */
function news_entry_email_link_shortcode() {
	$subject = urlencode( esc_attr( '[' . get_bloginfo( 'name' ) . ']' . the_title_attribute( 'echo=0' ) ) );
	$body = urlencode( esc_attr( sprintf( __( 'Check out this post: %1$s', 'news' ), get_permalink( get_the_ID() ) ) ) );
	return '<a class="email-link" href="mailto:?subject=' . $subject . '&amp;body=' . $body . '">' . __( 'Email', 'news' ) . '</a>';
}

/**
 * Mixx link shortcode.
 *
 * @since 0.1.0
 */
function news_entry_mixx_link_shortcode() {
	return '<a href="http://www.mixx.com" onclick="window.location=\'http://www.mixx.com/submit?page_url=\'+window.location; return false;">' . __( 'Mixx', 'news' ) . '</a>';
}

/**
 * Delicious link shortcode.
 *
 * @since 0.1.0
 */
function news_entry_delicious_link_shortcode() {
	return '<a href="http://delicious.com/save" onclick="window.open(\'http://delicious.com/save?v=5&amp;noui&amp;jump=close&amp;url=\'+encodeURIComponent(\'' . get_permalink() . '\')+\'&amp;title=\'+encodeURIComponent(\'' . the_title_attribute( 'echo=0' ) . '\'),\'delicious\', \'toolbar=no,width=550,height=550\'); return false;">' . __( 'Delicious', 'news' ) . '</a>';
}

/**
 * Digg link shortcode.
 * @note This won't work from your computer (http://localhost). Must be a live site.
 *
 * @since 0.1.0
 */
function news_entry_digg_link_shortcode() {
	$url =  esc_url( 'http://digg.com/submit?phase=2&amp;url=' . urlencode( get_permalink( get_the_ID() ) ) . '&amp;title="' . urlencode( the_title_attribute( 'echo=0' ) ) );

	return '<a href="' . $url . '" title="' . __( 'Digg this entry', 'news' ) . '">Digg</a>';
}

/**
 * Facebook share link shortcode.
 *
 * @todo Figure out why this doesn't work.
 *
 * @since 0.1.0
 */
function news_entry_facebook_link_shortcode() {
	$url = esc_url( 'http://facebook.com/sharer.php?u=' . urlencode( get_permalink( get_the_ID() ) ) . '&amp;t=' . urlencode( the_title_attribute( 'echo=0' ) ) );

	return '<a href="' . $url . '" title="' . __( 'Share this entry on Facebook', 'news' ) . '">' . __( 'Facebook', 'news' ) . '</a>';
}

/**
 * Twitter link shortcode.
 *
 * @since 0.1.0
 */
function news_entry_twitter_link_shortcode() {

	$post_id = get_the_ID();

	$post_type = get_post_type( $post_id );

	if ( 'post' == $post_type || 'page' == $post_type || 'attachment' == $post_type )
		$shortlink = wp_get_shortlink( $post_id );
	else
		$shortlink = get_permalink( $post_id );

	$url = esc_url( 'http://twitter.com/home?status=' . urlencode( sprintf( __( 'Currently reading %1$s', 'news' ), $shortlink ) ) );
	return '<a href="' . $url . '" title="' . __( 'Share this entry on Twitter', 'news' ) . '">' . __( 'Twitter', 'news' ) . '</a>';
}

/**
 * Slideshow shortcode.
 *
 * @since 0.1.0
 */
function news_slideshow_shortcode( $attr ) {
	global $post;

	/* Set up the defaults for the slideshow shortcode. */
	$defaults = array(
		'order' => 'ASC',
		'orderby' => 'menu_order ID',
		'id' => $post->ID,
		'size' => 'news-slideshow',
		'include' => '',
		'exclude' => '',
		'numberposts' => -1,
	);
	$attr = shortcode_atts( $defaults, $attr );

	/* Allow users to overwrite the default args. */
	extract( apply_atomic( 'slideshow_shortcode_args', $attr ) );

	/* Arguments for get_children(). */
	$children = array(
		'post_parent' => intval( $id ),
		'post_status' => 'inherit',
		'post_type' => 'attachment',
		'post_mime_type' => 'image',
		'order' => $order,
		'orderby' => $orderby,
		'exclude' => absint( $exclude ),
		'include' => absint( $include ),
		'numberposts' => intval( $numberposts ),
	);

	/* Get image attachments. If none, return. */
	$attachments = get_children( $children );

	if ( empty( $attachments ) )
		return '';

	/* If is feed, leave the default WP settings. We're only worried about on-site presentation. */
	if ( is_feed() ) {
		$output = "\n";
		foreach ( $attachments as $id => $attachment )
			$output .= wp_get_attachment_link( $id, $size, true ) . "\n";
		return $output;
	}

	$slideshow = '<div class="slideshow-set"><div class="slideshow-items">';

	$i = 0;

	foreach ( $attachments as $attachment ) {

		/* Open item. */
		$slideshow .= '<div class="slideshow-item item item-' . ++$i . '">';

		/* Get image. */
		$slideshow .= wp_get_attachment_link( $attachment->ID, $size, true, false );

		/* Check for caption. */
		if ( !empty( $attachment->post_excerpt ) )
			$caption = $attachment->post_excerpt;
		elseif ( !empty( $attachment->post_content ) )
			$caption = $attachment->post_content;
		else
			$caption = '';

		if ( !empty( $caption ) ) {
			$slideshow .= '<div class="slideshow-caption">';
			$slideshow .= '<a class="slideshow-caption-control">' . __( 'Caption', 'news' ) . '</a>';
			$slideshow .= '<div class="slideshow-caption-text">' . $caption . '</div>';
			$slideshow .= '</div>';
		}

		$slideshow .= '</div>';
	}

	$slideshow .= '</div><div class="slideshow-controls">';

		$slideshow .= '<div class="slideshow-pager"></div>';
		$slideshow .= '<div class="slideshow-nav">';
			$slideshow .= '<a class="slider-prev">' . __( 'Previous', 'news' ) . '</a>';
			$slideshow .= '<a class="slider-next">' . __( 'Next', 'news' ) . '</a>';
		$slideshow .= '</div>';

	$slideshow .= '</div>';

	$slideshow .= '</div><!-- End slideshow. -->';

	return apply_atomic( 'slideshow_shortcode', $slideshow );
}
//add_shortcode('entry-category-with-count', 'news_entry_published_link_shortcode');
function news_entry_published_link_shortcode() {
	/* Get the year, month, and day of the current post. */
	$year = get_the_time( 'Y' );
	$month = get_the_time( 'm' );
	$day = get_the_time( 'd' );
	$out = '';
	/* Add a link to the monthly archive. */
	$out .= '<a href="' . get_month_link( $year, $month ) . '" title="Archive for ' . esc_attr( get_the_time( 'F Y' ) ) . '">' . get_the_time( 'F' ) . '</a>';
	/* Add a link to the daily archive. */
	$out .= ' <a href="' . get_day_link( $year, $month, $day ) . '" title="Archive for ' . esc_attr( get_the_time( 'F d, Y' ) ) . '">' . $day . '</a>';
	/* Add a link to the yearly archive. */
	$out .= ', <a href="' . get_year_link( $year ) . '" title="Archive for ' . esc_attr( $year ) . '">' . $year . '</a>';
	return $out;
}

// SHORTCODES FOR HYBRID NEWS SHORTCODE HACK
function news_entry_post_count_shortcode() {
echo '&nbsp;['; the_author_posts();
echo '&nbsp;&nbsp;entries]&nbsp;'; 
}

// news_entry_category_with_count_shortcode()
function news_entry_category_with_count_shortcode() {
echo '<span class="cat-links"></span>'; the_category(', ');
echo '&#91;'; 
echo wt_get_category_count(); 
echo '&#93;';
}

//add_shortcode('entry-category-with-count', 'news_entry_category_with_count_shortcode');
// news_entry_tag_with_count_shortcode()
function news_entry_tag_with_count_shortcode() {
	echo tags_with_count( '', __( '&nbsp;&nbsp;<span class="meta-sep">&Dagger;</span>' , 'hybrid-news' ) .' ', ', ', '' );
}

function news_entry_word_count_shortcode() {
echo '&nbsp;Length:&nbsp;['; 
echo word_count(); 
echo ']&nbsp;words.';
}
function news_entry_cats_with_count_shortcode() {
	echo cats_with_count( '', __( '<span class="meta-sep">&para;</span>' , 'hybrid-news' ) .' ', ', ', '' );
}

// Post last modified
function last_modified_posts_shortcode($atts){
$u_time = get_the_time('U');
          $u_modified_time = get_the_modified_time('U');
      if ($u_modified_time != $u_time) {
                echo ",&nbsp;and modified on ";
                the_modified_time('F jS, Y');
                echo ".";
          }
}
?>