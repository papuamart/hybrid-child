<?php
/*
* This is the major hack by the Kotek@Webmaster since started
* These hacks have been developed in order to complement the Rock-Solid 
* Hybrid Core WordPress Theme Framework at www.themehybrid.com by Justin T.
*/

if ( ! function_exists( 'news_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post—date/time and author.
 * @since Twenty Ten 1.0
 */
function news_posted_on() {
echo '<p class="byline path bb">'; 
echo apply_atomic_shortcode( 'news_byline', '[entry-author before=" Posted by " after="/ on"] [entry-published]');
if (!is_singular()){
echo apply_atomic_shortcode( 'news_byline', '&nbsp;<span class="vsep"></span>[entry-views before=" Views: "]'); 
}
echo do_shortcode( '[entry-edit-link before=" <span class=vsep>&equiv;</span>&nbsp; "]');
echo '</p>';
}
endif;

if ( ! function_exists( 'news_posted_in' ) ) :
/**
 * Prints HTML with meta information for the current post (category, tags and permalink).
 * @since Twenty Ten 1.0
 */
function news_posted_in() {
echo '<p class=entry-meta>';
// Retrieves tag list of current post, separated by commas.
if (!is_home() || !is_front_page() || !is_page_template('page-front-page.php') || !is_page_template('page-home.php') )
echo apply_atomic_shortcode( 'entry_meta', '[entry-cats-with-count]' ); 
echo apply_atomic_shortcode( 'entry_meta', '[entry-tags-with-count]' ); 
if (!is_singular('post') && !is_page())
echo do_shortcode('[cakifo-entry-type] [cakifo-entry-format before=" | "]');
echo apply_atomic_shortcode( 'entry_meta', '<span class="meta-sep"></span>[last-modified] [entry-words-count]'); 
echo '</p>';	
}
endif;

if ( ! function_exists( 'short_title' ) ) :
// to control the post title length
function short_title() {
 $title = get_the_title();
 $count = strlen($title);
 if ($count >= 65) {
 $title = substr($title, 0, 55);
 $title .= '...';
 }
 echo $title;
}
add_shortcode( 'entry-short-title', 'short_title' );
endif;

if ( ! function_exists( 'pmnews_entry_title' ) ) :
/**
 * Displays the published date of an individual post.
 *
 * @since 0.7
 * @param array $attr
 */
// Link Post Title to External URL
function pmnews_entry_title() {
	global $post;
    $thePostID = $post->ID;
    $post_id = get_post($thePostID);
    $title = $post_id->post_title;
    $perm = get_permalink($post_id);
    $post_keys = array(); $post_val = array();
    $post_keys = get_post_custom_keys($thePostID);

    if (!empty($post_keys)) {
		foreach ($post_keys as $pkey) {
			if ($pkey=='title_url') {
				$post_val = get_post_custom_values($pkey);
			}
		}
		if (empty($post_val)) {
			$link = $perm;
		} else {
			$link = $post_val[0];
		}
    } else {
		$link = $perm;
    }
    echo '<h3 class="widget-title" style=text-align:left;><a href="'.$link.'" rel="bookmark" title="'.$title.'">'.$title.'</a></h3>';
	echo '<h4 class="entry-subtitle">'; echo apply_atomic_shortcode( 'entry_subtitle', '[entry-subtitle]' );  echo '</h4>';	
}
add_shortcode( 'pmnews-entry-title', 'pmnews_entry_title' );
endif;


if ( ! function_exists( 'news_sidebar_pagination' ) ) :
function news_sidebar_pagination() {
 global $page, $paged;
 echo '<span class="newspaper2">';
	// Add a page number if necessary: 
	if ( $paged >= 2 || $page >= 2 ) echo '&nbsp;|&nbsp;' . sprintf( __( 'Page %s', 'hybrid' ), max( $paged, $page ) );
echo '</span>'; 
}
endif;
  
//
// Add filter to plugin init function
add_filter('post_type_link', 'gallery_permalink', 10, 3);	
// Adapted from get_permalink function in wp-includes/link-template.php
function gallery_permalink($permalink, $post_id, $leavename) {
	$post = get_post($post_id);
	$rewritecode = array(
		'%year%',
		'%monthnum%',
		'%day%',
		'%hour%',
		'%minute%',
		'%second%',
		$leavename? '' : '%postname%',
		'%post_id%',
		'%category%',
		'%author%',
		$leavename? '' : '%pagename%',
	);
 
	if ( '' != $permalink && !in_array($post->post_status, array('draft', 'pending', 'auto-draft')) ) {
		$unixtime = strtotime($post->post_date);
 
		$category = '';
		if ( strpos($permalink, '%category%') !== false ) {
			$cats = get_the_category($post->ID);
			if ( $cats ) {
				usort($cats, '_usort_terms_by_ID'); // order by ID
				$category = $cats[0]->slug;
				if ( $parent = $cats[0]->parent )
					$category = get_category_parents($parent, false, '/', true) . $category;
			}
			// show default category in permalinks, without
			// having to assign it explicitly
			if ( empty($category) ) {
				$default_category = get_category( get_option( 'default_category' ) );
				$category = is_wp_error( $default_category ) ? '' : $default_category->slug;
			}
		}
 
		$author = '';
		if ( strpos($permalink, '%author%') !== false ) {
			$authordata = get_userdata($post->post_author);
			$author = $authordata->user_nicename;
		}
 
		$date = explode(" ",date('Y m d H i s', $unixtime));
		$rewritereplace =
		array(
			$date[0],
			$date[1],
			$date[2],
			$date[3],
			$date[4],
			$date[5],
			$post->post_name,
			$post->ID,
			$category,
			$author,
			$post->post_name,
		);
		$permalink = str_replace($rewritecode, $rewritereplace, $permalink);
	} else { // if they're not using the fancy permalink option
	}
	return $permalink;
}
/////////////
function gallery_prettyPhoto ($content) {
 
    // add checks if you want to add prettyPhoto on certain places (archives etc).
 
    return str_replace("<a", "<a rel='prettyPhoto'", $content);
}

if ( ! function_exists( 'news_navigation' ) ) :
// Content Navigation Function in WordPress Footer
function news_navigation() { ?>
	<?php if ( is_attachment() && is_page_template('page-front-page.php')) : ?>
	<div class="breadcrumbs">
			<?php previous_post_link( '%link', '<span class="previous">' . __( '&laquo; Return to entry', hybrid_get_textdomain() ) . '</span>' ); ?>
		</div>

	<?php elseif ( is_singular( 'post' ) ) : ?>
		<div class="breadcrumbs">
&laquo;<?php previous_post_link( '%link', ' %title' ) ?>&nbsp;&laquo;&nbsp;&nbsp;<a class="breadcrumbs" href="<?php bloginfo('home'); ?>/"><span style="color:#a6dc00;">Start</span></a>&nbsp;&nbsp;&raquo;&nbsp;<?php next_post_link( '%link', '%title <span class="nav-next">&raquo;</span>' ) ?>
		</div><!-- .navigation-links -->
	<?php elseif ( !is_singular() && function_exists( 'wp_pagenavi' ) ) : wp_pagenavi(); ?>
	<?php elseif ( !is_singular() && current_theme_supports( 'loop-pagination' ) ) : loop_pagination(); ?>
	<?php elseif ( !is_singular() && $nav = get_posts_nav_link( array( 'sep' => '', 'prelabel' => '<span class="previous">' . __( '&laquo; Previous', hybrid_get_textdomain() ) . '</span>', 'nxtlabel' => '<span class="next">' . __( 'Next &raquo;', hybrid_get_textdomain() ) . '</span>' ) ) ) : ?>
		<div class="breadcrumbs">
			<?php echo $nav; ?>
		</div><!-- .navigation-links -->
	<?php endif; ?>				
<?php }
endif;

/*
Plugin Name: Comment Hack
Plugin URI: http://mtdewvirus.com/code/wordpress-plugins/
*/
/**
 Email Me With The Reply 1.0 By IT???
 Usage:Simple copy this code to your functions.php file, and it works. :)
 This is based on comment_mail_notify v1.0 by willin kan.
 */
//-- Here begins --------------------------------------
function comment_mail_notify($comment_id) {
  $admin_notify = '1'; // are you willing to receive the mail? 1 is yes.
  $admin_email = get_bloginfo ('admin_email'); // you can change $admin_email to your e-mail optionaly.
  $comment = get_comment($comment_id);
  $comment_author_email = trim($comment->comment_author_email);
  $parent_id = $comment->comment_parent ? $comment->comment_parent : '';
  global $wpdb;
  if ($wpdb->query("Describe {$wpdb->comments} comment_mail_notify") == '')
    $wpdb->query("ALTER TABLE {$wpdb->comments} ADD COLUMN comment_mail_notify TINYINT NOT NULL DEFAULT 0;");
  if (($comment_author_email != $admin_email && isset($_POST['comment_mail_notify'])) || ($comment_author_email == $admin_email && $admin_notify == '1'))
    $wpdb->query("UPDATE {$wpdb->comments} SET comment_mail_notify='1' WHERE comment_ID='$comment_id'");
  $notify = $parent_id ? get_comment($parent_id)->comment_mail_notify : '0';
  $spam_confirmed = $comment->comment_approved;
  if ($parent_id != '' && $spam_confirmed != 'spam' && $notify == '1') {
    $wp_email = 'no-reply@' . preg_replace('#^www\.#', '', strtolower($_SERVER['SERVER_NAME'])); // e-mail
    $to = trim(get_comment($parent_id)->comment_author_email);
    $subject = __('You got a reply from ', 'hybrid') . ' [' . get_option("blogname") . ']';
    $message = '
    <div style="background-color:#eef2fa; border:1px solid #d8e3e8; color:#111; padding:0 15px; -moz-border-radius:5px; -webkit-border-radius:5px; -khtml-border-radius:5px; border-radius:5px;">
      <p>' . __('Hello:', 'hybrid') . '</p>
      <p>' . trim(get_comment($parent_id)->comment_author) .__('. Your wrote a comment on ', 'hybrid') . get_the_title($comment->comment_post_ID) . ':<br />'
       . trim(get_comment($parent_id)->comment_content) . '</p>
      <p>' . trim($comment->comment_author) . __('replied you', 'hybrid') . ':<br />'
       . trim($comment->comment_content) . '<br /></p>
      <p>' . __('You can ', 'hybrid') . '<a href="' . htmlspecialchars(get_comment_link($parent_id)) . '">' . __('Click here to see the whole comments.', 'hybrid') . '</a></p>
      <p> <a href="' . home_url() . '">' . get_option('blogname') . '</a></p>
      <p>(System mail, Do Not Reply.)</p>
    </div>';
    $from = "From: \"" . get_option('blogname') . "\" <$wp_email>";
    $headers = "$from\nContent-Type: text/html; charset=" . get_option('blog_charset') . "\n";
    wp_mail( $to, $subject, $message, $headers );
    //echo 'mail to ', $to, '<br/> ' , $subject, $message; // for testing
  }
}
add_action('comment_post', 'comment_mail_notify');

/* Auto checked */
function add_checkbox() {
  echo '<input type="checkbox" name="comment_mail_notify" id="comment_mail_notify" value="comment_mail_notify" checked="checked" /><label for="comment_mail_notify">Email Me with The Reply</label>';
}
add_action('comment_form', 'add_checkbox');

class wpe_comment_widget extends WP_Widget {
    function wpe_comment_widget() {
        $widget_ops = array('classname' => 'wpe_widget_comments', 'description' => __( 'Your comments and commentform', 'your_textdomain') );
        $this->WP_Widget('wpe-comment-widget', __('WPE Comments', 'your_textdomain'), $widget_ops);
    }
    function widget($args, $instance) {
        if(is_single()) {
            extract($args);
            global $post;
            echo $before_widget;
            comments_template();
            echo $after_widget;
        }
    }
    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        return $instance;
    }
    function form($instance) {
        ?>
        <p><?php _e('This widget will only be displayed in single view.', 'your_textdomain'); ?></p>
       <?php
    }
}
register_widget('wpe_comment_widget');


/*
Plugin Name: Make Custom Post Types Taggable
Plugin URI: http://mtdewvirus.com/code/wordpress-plugins/
*/
if ( ! function_exists( 'post_type_tags_fix' ) ) :
// tags doesn't list other post types?	
// this is the hack for post-types to list tags	
function post_type_tags_fix($request) {
	if ( isset($request['tag']) && !isset($request['post_type']) )
	$request['post_type'] = 'any';
	return $request;
} 
add_filter('before_entry', 'post_type_tags_fix');
endif;

/*
Plugin Name: Admin Login Hack
Plugin URI: http://mtdewvirus.com/code/wordpress-plugins/
*/

// custom admin login logo
function news_login_logo() {
	echo '<style type="text/css">
	h1 a { background-image: url('.get_bloginfo('stylesheet_directory').'/images/default_thumb.gif) !important; }
	</style>';
}
add_action('login_head', 'news_login_logo');

/*
Plugin Name: Admin Contact Method Hack
Plugin URI: http://mtdewvirus.com/code/wordpress-plugins/
*/
// Add contact methods to profile, Twitter, Facebook, Flickr
function add_remove_contactmethods( $contactmethods ) {
	$contactmethods['twitter'] = 'Twitter';
	$contactmethods['facebook'] = 'Facebook';
	$contactmethods['linkedin'] = 'Linked In';
	$contactmethods['flickr'] = 'Flickr';
        // this will remove existing contact fields
	unset($contactmethods['aim']);
	unset($contactmethods['yim']);
	unset($contactmethods['jabber']);
	return $contactmethods;
}

/**
 * Extend the user contact methods to include Twitter, Facebook and Google+
 *
 * @since Quark 1.0
 *
 * @param array List of user contact methods
 * @return array The filtered list of updated user contact methods
 */
function pmnews_new_contactmethods( $contactmethods ) {
	// Add Twitter
	$contactmethods['twitter'] = 'Twitter';

	//add Facebook
	$contactmethods['facebook'] = 'Facebook';

	//add Google Plus
	$contactmethods['googleplus'] = 'Google+';

	return $contactmethods;
}
add_filter( 'user_contactmethods', 'quark_new_contactmethods', 10, 1 );

/*
Plugin Name: Admin Dashboard Hack
Plugin URI: http://mtdewvirus.com/code/wordpress-plugins/
*/
// Change the Default Gravatar in WordPress
add_action('wp_dashboard_setup', 'pmnews_custom_dashboard_widgets');
function pmnews_custom_dashboard_widgets() {
global $wp_meta_boxes;
wp_add_dashboard_widget('custom_help_widget', 'Theme Support', 'custom_dashboard_help');
}
function custom_dashboard_help() {?>
Thank you for using&nbsp;<strong><?php echo do_shortcode('[theme-link]'); ?>&nbsp;
WP Theme</strong> Framework developed based on the <a href="ttp://themehybrid.com/themes/hybrid" target="_blank">Hybrid</a> Theme Framework<br>
Need help? Contact the developer <a href="mailto:spmnews@gmail.com">here</a>. For WordPress Tutorials visit: <a href="http://www.papuawp.wordpress.com" target="_blank">West Papua WordPress Blog</a></p> 
<?php
}

/*
Plugin Name: Admin User Information
Plugin URI: http://mtdewvirus.com/code/wordpress-plugins/
*/
/***********************************
Getting User Information
*************************************/
function user_info($what) {
	global $current_user;
    get_currentuserinfo();
	print $current_user->$what;
}
function J_ShowAbout() { ?>
<h2 class="widget-title"><?php _e('About Us', hybrid_get_textdomain() ); ?></h2>
<div class="sidebarheader">
<div class="home">
<a href="<?php home_url('home'); ?>"><img  width="100" height="100" border="0" alt="Google" align="center" src="<?php bloginfo('stylesheet_directory'); ?>/images/default_thumb.gif">
</a><br clear="all">
<p style="font-size:18px;text-align:center'"><strong><?php _e('Welcome! to', hybrid_get_textdomain() ); ?></strong></p> 
<p class="middle-headline" style="font-size:16px;text-align:center'"><?php echo hybrid_site_title(); ?></p> 
<p class="small-headline" style="font-size:16px;text-align:center'"><?php echo hybrid_site_description(); ?></p>
</div>		
<?php include( trailingslashit( CHILD_THEME_DIR ) . 'admin/quick-count.php' ); ?>
</div>
<?php }
/*
Plugin Name: Post Blog Using Email
Plugin URI: http://mtdewvirus.com/code/wordpress-plugins/
*/
// Post to your blog using email
add_action('shutdown', 'retrieve_post_via_mail');
function retrieve_post_via_mail() {
	flush();
	if(get_transient('retrieve_post_via_mail')) {
		return;
	} else {
		$mail = wp_remote_get(get_bloginfo('wpurl').'/wp-mail.php');
		if(!is_wp_error($mail)) {
			set_transient('retrieve_post_via_mail', 1, 60 * 15);
		} else {
			set_transient('retrieve_post_via_mail', 1, 60 * 5);
		}
	}
}
add_filter('user_contactmethods','add_remove_contactmethods',10,1);
/*
Plugin Name: “Next-page" button in WYSIWYG-editor
Plugin URI: http://mtdewvirus.com/code/wordpress-plugins/
*/
add_filter('mce_buttons','wysiwyg_editor');
function wysiwyg_editor($mce_buttons) {
    $pos = array_search('wp_more',$mce_buttons,true);
    if ($pos !== false) {
        $tmp_buttons = array_slice($mce_buttons, 0, $pos+1);
        $tmp_buttons[] = 'wp_page';
        $mce_buttons = array_merge($tmp_buttons, array_slice($mce_buttons, $pos+1));
    }
    return $mce_buttons;
}

/**
*	Plugin Name: Google Translation
*	Plugin URI: http://papuawp.wordpress.com/google-tools/
 *
*************************/ 
function google_translation_links() { ?>
<div id="google_translate_element"></div>
<script type="text/javascript">
function googleTranslateElementInit() {
  new google.translate.TranslateElement({pageLanguage: 'id', layout: google.translate.TranslateElement.InlineLayout.SIMPLE, gaTrack: true, gaId: 'UA-36284727-1'}, 'google_translate_element');
}
</script>
<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
<?php
} 
function google_translation_utility() { ?>
<P align=center>
<h3>Google Translate to Your Language</h3>
<script src="http://www.gmodules.com/ig/ifr?url=http://cowburn.info/wp-content/themes/cowburn/translate.xml&amp;synd=open&amp;w=192&amp;h=40&amp;title=We+speak+your+language!&amp;border=%23ffffff%7C0px%2C1px+solid+%23993333%7C0px%2C1px+solid+%23bb5555%7C0px%2C1px+solid+%23DD7777%7C0px%2C2px+solid+%23EE8888&amp;output=js"></script>
</p>
<?php
} 
function google_currency_converter() { ?>
<h3>Google Currency Converter</h3>
<script src="http://www.gmodules.com/ig/ifr?url=http://www.donalobrien.net/apps/google/currency.xml&amp;up_def_from=USD&amp;up_def_to=EUR&amp;synd=open&amp;w=320&amp;h=170&amp;title=Currency+Converter&amp;border=%23ffffff%7C3px%2C1px+solid+%23999999&amp;output=js"></script>
<?php
} 
function google_multisearch_utility() { ?>
<h3>Multi Search Light</h3>
<script src="http://www.gmodules.com/ig/ifr?url=http://blogoscoped.com/homepage/multi-search-light.xml&amp;synd=open&amp;w=320&amp;h=200&amp;title=Multi+Search+Light&amp;border=%23ffffff%7C3px%2C1px+solid+%23999999&amp;output=js"></script>
<?php
} 
function google_translate_utility() { ?>
<h3>_MSG_gadgettitle</h3>
<script src="http://www.gmodules.com/ig/ifr?url=http://gd.gadgetwe.com/ig/translate/translate.xml&amp;up_src_lang=en&amp;up_dst_lang=fr&amp;synd=open&amp;w=320&amp;h=142&amp;title=__MSG_gadgettitle__&amp;lang=all&amp;country=ALL&amp;border=%23ffffff%7C3px%2C1px+solid+%23999999&amp;output=js"></script>
<?php
}

/*
Plugin Name: Post Types Query
Plugin URI: http://mtdewvirus.com/code/wordpress-plugins/
*/
/*
 * the following is from posttypes.php
 * they are post-types query
***/

/* Query the post types 
***************************************
*/
/**
 * Add additional post meta boxes.
 * - Feature image input box.
 *
 * @since 0.1
 */
 
function news_post_meta_boxes( $meta_boxes ) {
	$meta_boxes['medium'] = array( 'name' => 'Medium', 'default' => '', 'title' => __('Medium/Feature:', 'news'), 'type' => 'text', 'show_description' => false, 'description' => false );
	return $meta_boxes;
}
/**
 * Adds "class='video-wrap'" to the opening <p> element around video embeds.
 *
 * @since 0.1.0
 */
function news_video_embed_wrapper( $content ) {

	if ( is_singular( 'video' ) && in_the_loop() )
		$content = preg_replace( array( "/<p>(.*?)<object/", "/<p>(.*?)<iframe/" ), array( "<p class='video-wrap'>$1<object", "<p class='video-wrap'>$1<iframe" ), $content );

	return $content;
}
/**
 * Overwrites the default widths for embeds.  This is especially useful for making sure videos properly
 * expand the full width on video pages.  This function overwrites what the $content_width variable handles
 * with context-based widths.
 *
 * @since 0.1.0
 */
function news_embed_defaults( $args ) {
	if ( is_singular( 'video' ) || is_singular( 'slideshow' ) )
		$args['width'] = 640;
	else
		$args['width'] = 560;

	return $args;
}
/**
 * Function for grabbing a post ID by meta key and meta value.  We're using this in the sidebar-feature.php 
 * file to check if a page has been given the 'page-template-popular.php' page template.
 *
 * @since 0.1.0
 */
function news_get_post_by_meta( $meta_key = '', $meta_value = '' ) {
	global $wpdb;

	$post_id = $wpdb->get_var( $wpdb->prepare( "SELECT post_id FROM $wpdb->postmeta WHERE meta_key = %s AND meta_value = %s LIMIT 1", $meta_key, $meta_value ) );

	if ( !empty( $post_id ) )
		return $post_id;

	return false;
}

function get_custom_field($key, $echo = FALSE) {
    global $post;
    $custom_field = get_post_meta($post->ID, $key, true);
    if ($echo == FALSE) return $custom_field;
    echo $custom_field;
}

//
function ilc_cpt_custom_column($column_name, $post_id) {
    $taxonomy = $column_name;
    $post_type = get_post_type($post_id);
    $terms = get_the_terms($post_id, $taxonomy);

    if ( !empty($terms) ) {
        foreach ( $terms as $term )
            $post_terms[] = "<a href='edit.php?post_type={$post_type}&{$taxonomy}={$term->slug}'> " . esc_html(sanitize_term_field('name', $term->name, $term->term_id, $taxonomy, 'edit')) . "</a>";
        echo join( ', ', $post_terms );
	}
    else echo '<i>No terms.</i>';
}

// Define what post types to search
function searchAll( $query ) {
	if ( $query->is_search ) {
		$query->set( 'post_type', array( 'post', 'page', 'feed', 'campaign', 'document', 'report', 'video', 'slideshow', 'podcast' ));
	}
	return $query;
}

// The hook needed to search ALL content
add_filter( 'the_search_query', 'searchAll' );
/*
	 * labels
	 *      (array) (optional) labels - An array of labels for this taxonomy. By default tag labels are used for non-hierarchical types and category labels for hierarchical ones.
	        * Default: if empty, name is set to label value, and singular_name is set to name value 
	        * 'name' - general name for the taxonomy, usually plural. The same as and overridden by $tax->label. Default is _x( 'Post Tags', 'taxonomy general name' ) or _x( 'Categories', 'taxonomy general name' ). When internationalizing this string, please use a gettext context matching your post type. Example: _x('Writers', 'taxonomy general name', hybrid_get_textdomain() ); 
	        * 'singular_name' - name for one object of this taxonomy. Default is _x( 'Post Tag', 'taxonomy singular name' ) or _x( 'Category', 'taxonomy singular name' ). When internationalizing this string, please use a gettext context matching your post type. Example: _x('Writer', 'taxonomy singular name', hybrid_get_textdomain() ); 
	        * 'search_items' - the search items text. Default is __( 'Search Tags' ) or __( 'Search Categories' )
	        * 'popular_items' - the popular items text. Default is __( 'Popular Tags' ) or __( 'Popular Category' )
	        * 'all_items' - the all items text. Default is __( 'All Tags' ) or __( 'All Categories' )
	        * 'parent_item' - the parent item text. This string is not used on non-hierarchical taxonomies such as post tags. Default is null or __( 'Parent Category' )
	        * 'parent_item_colon' - The same as parent_item, but with colon : in the end null, __( 'Parent Category:' )
	        * 'edit_item' - the edit item text. Default is __( 'Edit Tag' ) or __( 'Edit Category' )
	        * 'update_item' - the update item text. Default is __( 'Update Tag' ) or __( 'Update Category' )
	        * 'add_new_item' - the add new item text. Default is __( 'Add New Tag' ) or __( 'Add New Category' )
	        * 'new_item_name' - the new item name text. Default is __( 'New Tag Name' ) or __( 'New Category Name' )
	 *
	 */
// Improving WP_Query performance for multiple taxonomies
add_filter( 'posts_join', 'tax_posts_join', 10, 2 );
add_filter( 'posts_where', 'tax_posts_where', 10, 2 );
add_filter( 'posts_request', 'tax_posts_request' );

function tax_posts_join( $sql, $wp_query ){
    if( $tax_ids = $wp_query->get('term_taxonomy_ids_in') )
        $sql .= " INNER JOIN wp_term_relationships ON ( wp_posts.ID = wp_term_relationships.object_id )";

    return $sql;
}

function tax_posts_where( $sql, $wp_query ){
    if( $tax_ids = $wp_query->get('term_taxonomy_ids_in') ){
        $tax_ids = implode( ', ', $tax_ids );
        $sql .= " AND ( wp_term_relationships.term_taxonomy_id IN (".$tax_ids.") ) ";
    }   

    return $sql;
}

function tax_posts_request( $sql ){
    //var_dump( $sql );
    return $sql;
}


$args = array(
    'term_taxonomy_ids_in' => array(23, 5, 11, 10)
);

$tax_posts = new WP_Query( $args );
////////


/*
Plugin Name: Build Own Custom Taxonomy
*/
// Custom Taxonomy Code
/**
* This special hack adds more taxonomies under
* "post_tag" and "category" on the main admin menu
**/
add_action( 'init', 'build_taxonomies', 0 );

function build_taxonomies() {
register_taxonomy( 'entry_author', 
'post', 
array( 'hierarchical' => false, 
'label' => 'Writer', 
'query_var' => true, 
'rewrite' => true ) );

register_taxonomy( 
'news_source', 
'post',
array( 'hierarchical' => false, 
'label' => 'News Source', 'query_var' => true, 
'rewrite' => true ) );
}
 
/*
Plugin Name: Make Title Shorter
Plugin URI: http://papuawp.wordpress.com/
*/

if ( ! function_exists( 'short_title' ) ) :
// to control the post title length
function short_title() {
 $title = get_the_title();
 $count = strlen($title);
 if ($count >= 65) {
 $title = substr($title, 0, 55);
 $title .= '...';
 }
 echo $title;
}
add_shortcode( 'short-title', 'short_title' );
endif;

/*
Plugin Name: Make Pages Taggable
Plugin URI: http://mtdewvirus.com/code/wordpress-plugins/
*/
// Make the metabox appear on the page editing screen
if ( ! function_exists( 'tags_for_pages' ) ) :
function tags_for_pages() {
	register_taxonomy_for_object_type('post_tag', 'page', 'post_type');	
}
add_action('init', 'tags_for_pages');
endif;

/* 
* This google.com like breadcrumb is important for headings for various purposes
*/
function googleBreadcrumbs($display = TRUE, $separator = '<b>&rsaquo;</b>', $before = '<span style="text-transform:capitalize;">', $after = '</span>') {
	global $wp_query, $post, $googleBreadcrumbs;
	$request = $wp_query->request;
	$posts_per_page = intval(get_query_var('posts_per_page'));
	$paged = intval(get_query_var('paged'));
	$numposts = $wp_query->found_posts;
	$max_page = $wp_query->max_num_pages;
	if(empty($paged) || $paged == 0) {
		$paged = 1;
	}
	?>
     <?php if (!is_page() && !is_single()) { ?>
		<span>&nbsp;Results <b><?php if (!is_404()) echo (($paged-1)*$posts_per_page)+1; else echo '0'; ?></b> - <b><?php if ($paged*$posts_per_page < $numposts) echo $paged*$posts_per_page; else echo $numposts; ?></b> of about <b><?php echo $numposts ?></b> for <b>
        <?php
		if (is_home()) echo '*';
		if (is_category()) single_cat_title();
		if (is_tag()) single_tag_title();
		if (is_day()) the_time('F jS, Y');
		if (is_month()) the_time('F, Y');
		if (is_year()) the_time('Y');
		if (is_search()) the_search_query();
		?>
        </b>. (<b><?php timer_stop(1); ?></b> seconds)&nbsp;</span>
	<?php } else { ?>
		<span>&nbsp;Results <b>1</b> - <b>1</b> of about <b>1</b> for <b><?php the_title(); ?></b>. (<b><?php timer_stop(1); ?></b> seconds)&nbsp;</span>
<?php } } 

/*
* Categories and first few tags as bread crumb
*/
	function tagAndCatBreadCrumb() {
		$posttags = get_the_tags();
		$count=0;
		if ($posttags) {
			 foreach($posttags as $tag) {
				 $count++;
				 // no. of tags to show
				 if ($count <= 3) {
				 	$ptags[] = '<a class="tag-links" href="'. get_tag_link($tag->term_id) . '" rel="tag">'. ucwords($tag->name) . '</a>';
				 }
			 }

			 $tagCatBreadCrumb = the_category(', ') . ' &gt; ' . implode(', ', $ptags);
			 return $tagCatBreadCrumb;
		}
		else { 
$tagCatBreadCrumb = the_category(', ');
return $tagCatBreadCrumb;
}	
}

//
function query_all_post_types() {
	global $post;
	rewind_posts();

	// Create a new WP_Query() object
	$wpcust = new WP_Query(
		array(
            'post_type' => array(
                'campaign',
                'document',
                'report',
                 'faq',				
                'column',				
				'slideshow',
                'gallery',		
				'image',					
                'video',	
                'audio',					
                'podcast',			
                'event',				
                'site',				
            ),
            'showposts' => '5' ) // or 10 etc. however many you want
        );

		// the $wpcust-> variable is used to call the Loop methods. not sure if required
        if ( $wpcust->have_posts() ): while( $wpcust->have_posts() ) : $wpcust->the_post();
        ?>
			<ul id="post-<?php the_ID(); ?>" class="home <?php hybrid_entry_class(); ?>">

				<?php do_atomic( 'news_before_entry' ); // hybrid_before_entry ?>
		<?php
			// get the post type for each post
        	$posttype = get_post_type( $post->ID );
            if ( $posttype) {
            	echo '(<strong>' . $posttype . '</strong>)'; // display what each post is in parenthesis
			} ?>			
		<li class="entry-summary"><?php the_excerpt(); ?></li>
				<?php do_atomic( 'after_entry' ); // hybrid_before_entry ?>
			</ul><!-- .hfeed -->
		<?php endwhile;  // close the Loop
		endif;
        wp_reset_query(); // reset the Loop


} // end of list_all_posttypes() function
// end of list_all_posttypes() function	
// to display
// <?php if(function_exists('query_all_posttypes') { query_all_posttypes(); } 	
add_shortcode( 'query-all-post-types', 'query_all_posttypes' );

/*
Plugin Name: for a given post type, return all
Plugin URI: http://mtdewvirus.com/code/wordpress-plugins/
*/
function posts_by_taxonomy() { 
$post_type = array('campaign', 'document', 'report', 'slideshow', 'video', 'gallery', 'faq', 'event', 'site', 'portfolio', 'podcast');
$tax = array('topic', 'writer', 'actor');
$tax_terms = get_terms($tax);
if ($tax_terms) {
  foreach ($tax_terms  as $tax_term) {
    $args=array(
      'post_type' => $post_type,
      "$tax" => $tax_term->slug,
      'post_status' => 'publish',
      'posts_per_page' => 3,
      'caller_get_posts'=> 1
    );
    $my_query = null;
    $my_query = new WP_Query($args);
    if( $my_query->have_posts() ) {	
      echo '<div class="googlebreadcrumbs">List of '.$post_type . ' where the taxonomy '. $tax . '  is <u> '. $tax_term->name; echo '</u></div>';

      while ($my_query->have_posts()) : $my_query->the_post(); ?>
       <ul><li><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a>,&nbsp;<span class=""><?php echo do_shortcode('[entry-published]'); ?></span></li></ul>
        </ul><?php
	      endwhile;

	}
    wp_reset_query();
  }
}
}

/*
Plugin Name: Latest by Taxonomy Name - Topic
Plugin URI: http://mtdewvirus.com/code/wordpress-plugins/
*/
function posts_by_taxonomy_topic() {  
$post_type = 
	array(
                'campaign',
                'report',
                'document',
                 'faq',				
                'column',				
				'slideshow',
                'gallery',		
				'image',					
                'video',	
                'audio',					
                'podcast',			
                'event',				
                'site',				
        );
$tax = 'topic';
$tax_terms = get_terms($tax,'hide_empty=0');

//list the taxonomy
$i=0; // counter for printing separator bars
foreach ($tax_terms as $tax_term) {
$wpq = array ('taxonomy'=>$tax,'term'=>$tax_term->slug);
$query = new WP_Query ($wpq);
$article_count = $query->post_count;
echo "<a href=\"#".$tax_term->slug."\">".$tax_term->name."</a>";
// output separator bar if not last item in list
if ( $i < count($tax_terms)-1 ) {
echo " | " ;
}
$i++;
}

//list everything
if ($tax_terms) {
  foreach ($tax_terms  as $tax_term) {
    $args=array(
      'post_type' => $post_type,
      "$tax" => $tax_term->slug,
      'post_status' => 'publish',
      'posts_per_page' => -1,
      'caller_get_posts'=> 1
    );

    $my_query = null;
    $my_query = new WP_Query($args);
    if( $my_query->have_posts() ) {
      echo "<h3 class=\"hd\" id=\"".$tax_term->slug."\"> $tax_term->name </h3>";
      while ($my_query->have_posts()) : $my_query->the_post(); ?>
       <ul><li><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a>,&nbsp;<span class=""><?php echo do_shortcode('[entry-published]'); ?></span></li></ul>
        <?php
      endwhile;
      echo "<p><a href=\"#top\">Back to top</a></p>";
    }
    wp_reset_query();
  }
}
}

/*
Plugin Name: Latest by Taxonomy Name - Writer
Plugin URI: http://mtdewvirus.com/code/wordpress-plugins/
*/
function posts_by_taxonomy_writer() {  
	array(
                'campaign',
                'document',
                'report',
                 'faq',				
                'column',				
				'slideshow',
                'gallery',		
				'image',					
                'video',	
                'audio',					
                'podcast',			
                'event',				
                'site',				
        );
$tax = 'writer';
$tax_terms = get_terms($tax,'hide_empty=0');

//list the taxonomy
$i=0; // counter for printing separator bars
foreach ($tax_terms as $tax_term) {
$wpq = array ('taxonomy'=>$tax,'term'=>$tax_term->slug);
$query = new WP_Query ($wpq);
$article_count = $query->post_count;
echo "<a href=\"#".$tax_term->slug."\">".$tax_term->name."</a>";
// output separator bar if not last item in list
if ( $i < count($tax_terms)-1 ) {
echo " | " ;
}
$i++;
}

//list everything
if ($tax_terms) {
  foreach ($tax_terms  as $tax_term) {
    $args=array(
      'post_type' => $post_type,
      "$tax" => $tax_term->slug,
      'post_status' => 'publish',
      'posts_per_page' => -1,
      'caller_get_posts'=> 1
    );

    $my_query = null;
    $my_query = new WP_Query($args);
    if( $my_query->have_posts() ) {
      echo "<h3 class=\"hd\" id=\"".$tax_term->slug."\"> $tax_term->name </h3>";
      while ($my_query->have_posts()) : $my_query->the_post(); ?>
       <ul><li><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a>,&nbsp;<span class=""><?php echo do_shortcode('[entry-published]'); ?></span></li></ul>
        <?php
      endwhile;
      echo "<p><a href=\"#top\">Back to top</a></p>";
    }
    wp_reset_query();
  }
}
}
/*
Plugin Name: Latest by Taxonomy Name - Writer
Plugin URI: http://mtdewvirus.com/code/wordpress-plugins/
*/
function posts_by_taxonomy_publisher() {  
	array(
                'campaign',
                'document',
                'report',
                 'faq',				
                'column',				
				'slideshow',
                'gallery',		
				'image',					
                'video',	
                'audio',					
                'podcast',			
                'event',				
                'site',				
        );
$tax = 'publisher';
$tax_terms = get_terms($tax,'hide_empty=0');

//list the taxonomy
$i=0; // counter for printing separator bars
foreach ($tax_terms as $tax_term) {
$wpq = array ('taxonomy'=>$tax,'term'=>$tax_term->slug);
$query = new WP_Query ($wpq);
$article_count = $query->post_count;
echo "<a href=\"#".$tax_term->slug."\">".$tax_term->name."</a>";
// output separator bar if not last item in list
if ( $i < count($tax_terms)-1 ) {
echo " | " ;
}
$i++;
}

//list everything
if ($tax_terms) {
  foreach ($tax_terms  as $tax_term) {
    $args=array(
      'post_type' => $post_type,
      "$tax" => $tax_term->slug,
      'post_status' => 'publish',
      'posts_per_page' => -1,
      'caller_get_posts'=> 1
    );

    $my_query = null;
    $my_query = new WP_Query($args);
    if( $my_query->have_posts() ) {
      echo "<h3 class=\"hd\" id=\"".$tax_term->slug."\"> $tax_term->name </h3>";
      while ($my_query->have_posts()) : $my_query->the_post(); ?>
       <ul><li><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a>,&nbsp;<span class=""><?php echo do_shortcode('[entry-published]'); ?></span></li></ul>
        <?php
      endwhile;
      echo "<p><a href=\"#top\">Back to top</a></p>";
    }
    wp_reset_query();
  }
}
}

//
function query_all_special_post_types() {
	global $post;
	rewind_posts();

	// Create a new WP_Query() object
	$wpcust = new WP_Query(
		array(
            'post_type' => array(
                'entry_author',
                'news_source',
            ),
            'showposts' => '5' ) // or 10 etc. however many you want
        );

		// the $wpcust-> variable is used to call the Loop methods. not sure if required
        if ( $wpcust->have_posts() ): while( $wpcust->have_posts() ) : $wpcust->the_post();
        ?>
			<ul id="post-<?php the_ID(); ?>" class="home <?php hybrid_entry_class(); ?>">

				<?php do_atomic( 'before_entry' ); // hybrid_before_entry ?>
		<?php
			// get the post type for each post
        	$posttype = get_post_type( $post->ID );
            if ( $posttype) {
            	echo '(<strong>' . $posttype . '</strong>)'; // display what each post is in parenthesis
			} ?>			
		<li class="entry-summary"><?php the_excerpt(); ?></li>
				<?php do_atomic( 'after_entry' ); // hybrid_before_entry ?>
			</ul><!-- .hfeed -->
		<?php endwhile;  // close the Loop
		endif;
        wp_reset_query(); // reset the Loop


} // end of list_all_posttypes() function
// end of list_all_posttypes() function	
// to display
// <?php if(function_exists('query_all_posttypes') { query_all_posttypes(); } 	
add_shortcode( 'query-special-post-types', 'query_all_special_post_types' );	

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