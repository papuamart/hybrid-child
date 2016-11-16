<?php
function swc_shortcode_admin() {
// $page_title, $menu_title, $capability, $menu_slug, $function
add_theme_page("wP Shortcodes", "wP Shortcodes", 'administrator', 'swc-shortcode', 'swc_shortcode_page');
}
add_action('admin_menu', 'swc_shortcode_admin'); 

//  Page displayed in the admin area - menu item name "Shortcodes"
function swc_shortcode_page() {
	?>
<div class="wrap">
<div style="float:left;width:45%;margin:10px'">
<h2>Simply Works Core Shortcodes</h2>
<p>Here is list of available shortcodes</p>
<h3>Text Boxes</h3>
<p>Syntax: [text-box]  your content [/text-box] <em>(default yellow)</em> </p>
<div style="margin: 10px; padding: 10px; background: #fff; border: 1px solid #ddd; overflow:auto; color: #333333; background-color: #ffffdd; border-color: #ffd700;">Wrap the shortcode tags around your content</div>
<p>Syntax: [text-box color="green"]  your content [/text-box]</p>
<div style="margin: 10px; padding: 10px; background: #fff; border: 1px solid #ddd; overflow:auto; color: #11a322; background-color: #e8f6e9; border-color: #b2e1b7;">Wrap the shortcode tags around your content</div>
<p>Syntax: [text-box color="blue"]  your content [/text-box]</p>
<div style="margin: 10px; padding: 10px; background: #fff; border: 1px solid #ddd; overflow:auto; color: #2446ad; background-color: #eaedf7; border-color: #b8c3e4;">Wrap the shortcode tags around your content</div>
<p>Syntax: [text-box color="purple"]  your content [/text-box]</p>
<div style="margin: 10px; padding: 10px; background: #fff; border: 1px solid #ddd; overflow:auto; color: #7b11a3; background-color: #f4e8f6; border-color: #d08ee0;">Wrap the shortcode tags around your content</div>
<p>Syntax: [text-box color="red"]  your content [/text-box]</p>
<div style="margin: 10px; padding: 10px; background: #fff; border: 1px solid #ddd; overflow:auto; color: #9e1111; background-color: #f5e8e8; border-color: #dfb2b2;">Wrap the shortcode tags around your content</div>
<p>Syntax: [text-box color="orange"]  your content [/text-box] </p>
<div style="margin: 10px; padding: 10px; background: #fff; border: 1px solid #ddd; overflow:auto; color: #a35211; background-color: #f4e5d3; border-color: #de9860;">Wrap the shortcode tags around your content</div>
<p>Syntax: [text-box color="darkblue"]  your content [/text-box] </p>
<div style="margin: 10px; padding: 10px; background: #fff; border: 1px solid #ddd; overflow:auto; color: #333333; background-color: #54b1ec; border-color: #164978;">Wrap the shortcode tags around your content</div>
<p>Syntax: [text-box color="brigtherbule"]  your content [/text-box] </p>
<div style="margin: 10px; padding: 10px; background: #164978 border: 1px solid #ddd; overflow:auto; color: #2222; background-color: #85d6fd; border-color: #d08ee0;">Wrap the shortcode tags around your content</div>
<p>Syntax: [text-box color="darkerblue"]  your content [/text-box] </p>
<div style="margin: 10px; padding: 10px; background: #164978 border: 1px solid #ddd; overflow:auto; color: #ffffff; background-color: #164978; border-color: #85d6fd">Wrap the shortcode tags around your content</div>

<h4>WIDGET SHORTCODES</h4>
<div style="margin: 10px; padding: 10px; background: #fff; border: 1px solid #ddd; overflow:auto; color: #11a322; background-color: #e8f6e9; border-color: #b2e1b7;">add_shortcode('widget','widget'); // registers the shortcode<br />
//To use this add in your posts for example: [widget class="calendar"]<br />
echo do_shortcode('[widget class="calendar"]');<br />
echo do_shortcode('[slideshow_shortcode"]');<br />
echo do_shortcode('[PMNews_Recent_Tags"]');<br />
echo do_shortcode('[News_Widget_Popular_Tabs"]');<br />
( 'News_Widget_Popular_Tabs' );<br />
( 'News_Widget_Image_Stream' );<br />
( 'News_Widget_Newsletter' );<br />
( 'PMNews_Recent_Tags' );<br />
( 'PMNews_Tweets_Widget' );<br />
( 'PMThemeCatLight' );<br />
( 'PMThemeList' );<br />
( 'PMThemeComments' );<br />
( 'PMThemeLatestList' );<br />
( 'PMThemeThumbs' );<br />
( 'PMThemeVideo' );<br />
( 'Widget_PMNewsFlickr' );<br />
// Example: [query category_name="wordpress-code" count=3]<br />
// Example: [donate_shortcode]<br />
// [doc class="psd" href="http://www.wpsnipp.com/file.psd"]my PSD file name[/doc]<br />
// [doc class="ai" href="http://www.wpsnipp.com/file.ai"]my AI file name[/doc]<br />
// [doc class="svg" href="http://www.wpsnipp.com/file.svg"]my SVG file name[/doc]<br />
</div>
<div style="margin: 10px; padding: 10px; background: #fff; border: 1px solid #ddd; overflow:auto; color: #333333; background-color: #ffffdd; border-color: #ffd700;">
<h4>YUI GRIDS MENU</h4>
<p>div#doc creates a 750px page width.</p>
<p>div#doc2 creates a 950px page width.</p>
<p>div#doc3 creates a 100% page width. (Note that the 100% page width also sets 10px of left and right margin so that content had a bit of breathing room between it and the browser chrome.)</p>
<p>div#doc4 creates a 974px page width, and is a new addition to Grids in YUI version 2.3.0.</p>
	
<p>.yui-t1 – Two columns, narrow on left, 160px</p>
<p>.yui-t2 – Two columns, narrow on left, 180px</p>
<p>.yui-t3 – Two columns, narrow on left, 300px</p>
<p>.yui-t4 – Two columns, narrow on right, 180px</p>
<p>.yui-t5 – Two columns, narrow on right, 240px</p>
<p>.yui-t6 – Two columns, narrow on right, 300px</p>
<p>=================</p>
<p>.yui-gb : Takes 3 units and divides equally</p>
<p>yui-gc : Takes 2 units and divides as 2/3 and 1/3</p>
<p>yui-gd : Takes 2 units and divides as 1/3 and 2/3</p>
<p>yui-ge : Takes 2 units and divides as 3/4 and 1/4</p>
<p>yui-gf : Takes 2 units and divides as 1/4 and 3/4</p>
<p>=================</p>
<p>.yui-g – Standard grid, 1/2 – 1/2</p>
<p>.yui-gb – Special grid, 1/3 – 1/3 – 1/3</p>
<p>.yui-gc – Special grid, 2/3 – 1/3</p>
<p>.yui-gd – Special grid, 1/3 – 2/3</p>
<p>.yui-ge – Special grid, 3/4 – 1/4</p>
<p>.yui-gf – Special grid, 1/4 – 3/4</p>
===============</div>

<div style="margin: 10px; padding: 10px; background: #fff; border: 1px solid #ddd; overflow:auto; color: #333333; background-color: #54b1ec; border-color: #164978;">
<h3>Special Shortcode to use on available widgets. Just Copy and paste the following shortcodes syntax into the whatever widgets avaliable. I tested using the "<a href="http://www.erik-rasmussen.com/blog/2006/11/30/widgetize-anything/" target="_blank">Widgetize Anything</a> Plugin</h3>
<h4>Related by Tags of the post</h4>
<p>Syntax: echo do_shortcode( '[tag_related_posts limit="5"]' ); </p>
<h4>Related by Words or Terms</h4>
<p>Syntax:echo do_shortcode('[related_posts_by_content]');</p>
<p>Syntax:echo do_shortcode('[more_articles]');</p>
<p>Syntax:echo do_shortcode('[entry-published]');</p>
<p>Syntax:echo do_shortcode('[related-prev]');</p>
<p>Syntax:echo do_shortcode('[related_posts_by_content]');</p>
<p>Syntax:echo do_shortcode('[related_posts_by_content]');</p>
<p>Syntax:echo do_shortcode('[entry-tag-breadcrumb]');</p>
<p>Syntax:echo do_shortcode('[entry-tag-breadcrumb]');</p>
<h3> To utilise TEMPLATE_TAG_SHORTCODE widget</h3>
<p>The available shortcodes

If you know me, you know I can’t stop at one or two shortcodes. That’s why I made 40.

<p>Several shortcodes have additional parameters, which are listed in the plugin’s readme.html file. Here’s the list of what’s currently available in the plugin.

  <p>  * [wp_list_authors]<br />
    * [the_author]<br />
    * [the_author_description]<br />
    * [the_author_login]<br />
    * [the_author_firstname]<br />
    * [the_author_lastname]<br />
    * [the_author_nickname]<br />
    * [the_author_ID]<br />
    * [the_author_url]<br />
    * [the_author_email]<br />
    * [the_author_link]<br />
    * [the_author_aim]<br />
    * [the_author_yim]<br />
    * [the_author_posts]<br />
    * [the_author_posts_link]<br />
    * [the_modified_author]<br />
    * [wp_list_categories]<br />
    * [wp_dropdown_categories]<br />
    * [the_category]<br />
    * [get_category_link]<br />
    * [the_date]<br />
    * [the_time]<br />
    * [the_modified_date]<br />
    * [the_modified_time]<br />
    * [wp_tag_cloud]<br />
    * [the_tags]<br />
    * [get_tag_link]<br />
    * [wp_list_bookmarks]<br />
    * [the_title]<br />
    * [the_title_attribute]<br />
    * [the_ID]<br />
    * [the_permalink]<br />
    * [get_permalink]<br />
    * [wp_list_pages]<br />
    * [wp_dropdown_pages]<br />
    * [wp_get_archives]<br />
    * [bloginfo]<br />
    * [allowed_tags]<br />
    * [wp_logout_url]<br />
    * [wp_login_url]<br />
    * [comments_link]<br />
    * [category_description]<br />
    * [tag_description]<br />
    * [term_description]<br />
    * [the_terms]<br />
    * [the_author_meta]<br />
</div>
</div>
<div style="float:right;width:45%;margin:10px'">
<p>I’m sure more will be added over time. If you have a particular template tag you’d like to see as a shortcode, just let me know in the comments.
Some important notes

<p>These shortcodes don’t provide additional XHTML formatting. For example, [wp_list_pages] won’t be wrapped with the <ul> tag. This is because its equivalent template tag wp_list_pages() does not do this. So, you’ll want to add any additional formatting from within the post editor.

<p>I struggled with this decision but thought it was the best route. The goal was to adhere to the same rules as the WordPress template tags.
<h3> To utilise TEMPLATE_TAG_SHORTCODE widget</h3>
<p></p>
<div style="margin: 10px; padding: 10px; background: #fff; border: 1px solid #ddd; overflow:auto; color: #7b11a3; background-color: #f4e8f6; border-color: #d08ee0;">
<h3> STYLES TO INCLUDE IN THEMES</h3>
/*
<p>
@import url("build/assets/grids-min.css");
</p><p>
@import url("build/assets/base-min.css");
</p><p>
@import url("build/assets/skin.css");</p><p>
@import url("build/assets/yui.css");</p><p>
@import url("build/assets/accordion.css");</p><p>
@import url("build/assets/tabview.css");</p><p>
@import url("build/assets/button.css");</p><p>
@import url("build/assets/container.css");</p><p>
@import url("build/assets/carousel.css");</p><p>
@import url("build/assets/skins/sam/menu.css");</p><p>
@import url("build/assets/shortcodes.css");</p><p>
@import url("build/assets/footer-widgets.css");</p><p>
@import url("build/assets/bottombars.css");</p><p>
@import url("build/assets/multicolumns.css");</p><p>
@import url("build/assets/footer-widgets.css");</p><p>
@import url("build/assets/flickr-widgets.css");</p><p>
@import url("build/assets/tooltips.css");</p><p>
@import url("build/assets/shortcodes.css");</p><p>
@import url("build/assets/typography.css");</p><p>
@import url("build/assets/multicolumns-footer.css");</p>
*/
</p>
</div>
<div style="margin: 10px; padding: 10px; background: #164978 border: 1px solid #ddd; overflow:auto; color: #7b11a3; background-color: #85d6fd; border-color: #d08ee0;">

<h3>Added Theme Supports & Shortcodes for PMNews</h3>
/* Add support for framework extensions. */
	<p>add_theme_support( 'breadcrumb-trail' );</p><p>
	add_theme_support( 'breadcrumb-tag' );</p><p>
	add_theme_support( 'custom-field-series' );</p><p>
	add_theme_support( 'get-the-image' );</p><p>
	add_theme_support( 'post-stylesheets' );</p><p>
	/* Add support for framework extensions. */	</p><p>
	//add_theme_support( 'wp-pagenavi' );</p><p>
	add_theme_support( 'entry-views' );</p><p>
	add_theme_support( 'loop-pagination' );</p><p>
	add_theme_support( 'custom-field-series' );	</p><p>
	
	// Post Format support. You can also use the legacy "gallery" or "asides" (note the plural) categories.</p><p>
	add_theme_support( 'post-formats', array( 'aside', 'gallery' ) );</p><p>
	// This theme uses post thumbnails</p><p>
	add_theme_support( 'post-thumbnails' );</p><p>
	add_theme_support( 'site-logo' );</p><p>
	add_theme_support( 'custom-header' );</p><p>
	add_theme_support( 'custom-post-meta' );</p><p>
	add_theme_support( 'custom-post-types' );</p><p>
	add_theme_support( 'tags-breadcrumb' );</p><p>
	add_theme_support( 'content-box-shortcodes' );</p><p>
	add_theme_support( 'beep-widget' );</p><p>
	add_theme_support( 'single-bottom-widget' );</p>
</div>	
<div style="margin: 10px; padding: 10px; background: #fff; border: 1px solid #ddd; overflow:auto; color: #333333; background-color: #ffffdd; border-color: #ffd700;">
<h3>The Following is  Font stack options</h3>
/* Font stack options

	The following represents a list of font stacks, as recommended by Nathan Ford in
	http://unitinteractive.com/blog/2008/06/26/better-css-font-stacks/

	I've added inverted commas around the relevant family names to ensure compatibility.
	p = balanced for paragraphs or body copy
	t = balanced for headlines or titles

	- - - -

<p>Arial, "Helvetica Neue", Helvetica, sans-serif - p, t
</p><p>
Baskerville, "Times New Roman", Times, serif - p
Baskerville, "Times, Times New Roman", serif - t
</p><p>
Cambria, Georgia, Times, "Times New Roman", serif - p, t
"Century Gothic", "Apple Gothic", sans-serif - p, t
</p><p>
Consolas, "Lucida Console", Monaco, monospace - p, t
</p><p>
"Copperplate Light", "Copperplate Gothic Light", serif - p, t
</p><p>
"Courier New", Courier, monospace - p, t
</p><p>
"Franklin Gothic Medium", "Arial Narrow Bold", Arial, sans-serif - p, t
</p><p>
Futura, "Century Gothic", "Apple Gothic", sans-serif - p, t
</p><p>
Garamond, "Hoefler Text", "Times New Roman", Times, serif - p
Garamond, "Hoefler Text", Palatino, "Palatino Linotype", serif - t
</p><p>
Geneva, "Lucida Sans", "Lucida Grande", "Lucida Sans Unicode", Verdana, sans-serif - p
Geneva, Verdana, "Lucida Sans", "Lucida Grande", "Lucida Sans Unicode", sans-serif - t
</p><p>
Georgia, Palatino, "Palatino Linotype", Times, "Times New Roman", serif - p
Georgia, Times, "Times New Roman", serif - t
</p><p>
GillSans, Calibri, Trebuchet, sans-serif - p
GillSans, Trebuchet, Calibri, sans-serif - t
</p><p>
"Helvetica Neue", Arial, Helvetica, sans-serif - p
Helvetica, "Helvetica Neue", Arial, sans-serif - t
</p><p>
Impact, Haettenschweiler, "Arial Narrow Bold", sans-serif - p, t
</p><p>
"Lucida Sans", "Lucida Grande", "Lucida Sans Unicode", sans-serif - p, t
</p><p>
Palatino, "Palatino Linotype", Georgia, Times, "Times New Roman", serif - p
Palatino, "Palatino Linotype", "Hoefler Text", Times, "Times New Roman", serif - t
</p><p>
Tahoma, Geneva, Verdana - p
Tahoma, Verdana, Geneva - t
</p><p>
Times, "Times New Roman", Georgia, serif - p, t
</p><p>
Trebuchet, "Lucida Sans Unicode", "Lucida Grande", "Lucida Sans", Arial, sans-serif - p
Trebuchet, Tahoma, Arial, sans-serif - t
</p><p>
Verdana, Geneva, Tahoma, sans-serif - p
Verdana, Tahoma, Geneva, sans-serif - t
</p><p>
<p>These shortcodes don’t provide additional XHTML formatting. For example, [wp_list_pages] won’t be wrapped with the <ul> tag. This is because its equivalent template tag wp_list_pages() does not do this. So, you’ll want to add any additional formatting from within the post editor.

<p>I struggled with this decision but thought it was the best route. The goal was to adhere to the same rules as the WordPress template tags.
<h3> To utilise TEMPLATE_TAG_SHORTCODE widget</h3>
<p></p>
<h3> STYLES TO INCLUDE IN THEMES</h3>
/*
<p>
@import url("build/assets/grids-min.css");
</p><p>
@import url("build/assets/base-min.css");
</p><p>
@import url("build/assets/skin.css");</p><p>
@import url("build/assets/yui.css");</p><p>
@import url("build/assets/accordion.css");</p><p>
@import url("build/assets/tabview.css");</p><p>
@import url("build/assets/button.css");</p><p>
@import url("build/assets/container.css");</p><p>
@import url("build/assets/carousel.css");</p><p>
@import url("build/assets/skins/sam/menu.css");</p><p>
@import url("build/assets/shortcodes.css");</p><p>
@import url("build/assets/footer-widgets.css");</p><p>
@import url("build/assets/bottombars.css");</p><p>
@import url("build/assets/multicolumns.css");</p><p>
@import url("build/assets/footer-widgets.css");</p><p>
@import url("build/assets/flickr-widgets.css");</p><p>
@import url("build/assets/tooltips.css");</p><p>
@import url("build/assets/shortcodes.css");</p><p>
@import url("build/assets/typography.css");</p><p>
@import url("build/assets/multicolumns-footer.css");</p>
*/
</div>	
</div>	
</div>	
<?php
}


//  Text Boxes
function swc_text_box($atts, $content = null)
{	
extract(shortcode_atts(array('color'=>'yellow',), $atts));
return '<div class="message ' .$color. ' ">' . do_shortcode($content) . '</div>';
}
add_shortcode('text-box','swc_text_box');
?>