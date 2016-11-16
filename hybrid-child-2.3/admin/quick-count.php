<?php
/**
 * Quick Couint on Sidebar Template
 *
 * The Tertiary Sidebar template houses the HTML used for the 'Tertiary' widget area. 
 * It will first check if the widget area is active before displaying anything.
 *
 * @package HybridNews
 * @subpackage Template
 */
?>
 <style type="text/css">
.quickstats {color: #795331;width: 96%; margin:auto auto 10px 15px;
border:1px solid #ddd}
.quickstats h3 {color: #795331;}
.quickstats span {color: #795331;font-weight: bold;}
.quickstats p {padding: 2px 2px 2px 6px;
border-left: 1px solid #c6bb8d;border-right: 1px solid #c6bb8d;}
.light {background-color: #faf6dd;}
.dark {background-color: #f7eab0;}
li.first {border-top:  1px solid #c6bb8d;}
li.last {border-bottom: 1px solid #c6bb8d;}
.bb-list{}
</style>
 <div id="quickstats">
 <div class="widget-title"><?php _e('Site Stats:', 'hybrid-news'); ?></div>
 <ol class="bb-list">
<li class="first"><?php _e('Number of Posts:', 'hybrid-news'); ?><?php echo total_posts();?> </li>
<li class="light"><?php _e('Number of Comments:', 'hybrid-news'); ?><?php echo total_comments(); ?></li>
<li class="dark"><?php _e('Number of Categories:', 'hybrid-news'); ?><?php echo total_categories(); ?></li>
<li class="light"><?php _e('Number of Tags:', 'hybrid-news'); ?><?php echo total_tags(); ?></li>
<li class="dark"><?php _e('Number of Pages:', 'hybrid-news'); ?><?php echo total_pages(); ?></li>
<li class="light"><?php _e('Number of Links:', 'hybrid-news'); ?><?php echo total_links(); ?></li>
<li class="dark"><?php _e('Number of Registered Users:', 'hybrid-news'); ?><?php echo total_users(); ?></li>
<li class="light"><?php _e('Number of Links Categories:', 'hybrid-news'); ?><?php echo total_link_categories(); ?></li>
<li class="dark"><?php _e('Number of Trackback:', 'hybrid-news'); ?><?php tb_count(); ?></li>
<li class="last"><?php _e('Number of Pingbacks:', 'hybrid-news'); ?><?php total_pingbacks(); ?></li>
</ol>
</div>