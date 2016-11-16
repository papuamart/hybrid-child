<?php
if (class_exists('WP_Widget')) {
    class PMNews_Widget_Post_Navigation extends WP_Widget {

        function PMNews_Widget_Post_Navigation() {
            $widget_ops = array('classname' => 'pmnews_widget_post_navi', 'description' => __( "Some posts before and after the current post", 'hybrid') );
            $this->WP_Widget('pmnews-post-navi', __('PMNews Single Post Navigation', 'hybrid'), $widget_ops);
        }

        function widget($args, $instance) {
            if(is_single()) {
                global $post, $wpdb;
                extract($args);

                if ( !$number = (int) $instance['number'] )
                    $number = 5;
                elseif( $number < 1 )
                    $number = 1;
                elseif( $number > 10 )
                    $number = 10;

                $title_before 		= apply_filters('widget_title', empty($instance['title_before']) ? '5 Posts before' : $instance['title_before']);
                $title_after	 	= apply_filters('widget_title', empty($instance['title_after']) ? '5 Posts after' : $instance['title_after']);
                $before_widget_2	= preg_replace("/(pmnews\-post\-navi-\d+)/", "$1-1", $before_widget);

                $querystr = "
                    SELECT *
                    FROM $wpdb->posts wposts
                    WHERE wposts.ID != $post->ID
                    AND wposts.post_type = 'post'
                    AND wposts.post_status = 'publish'
                    AND wposts.post_date %s '$post->post_date'
                    ORDER BY wposts.post_date %s
                    LIMIT $number
                 ";

                $leading_posts = $wpdb->get_results(sprintf($querystr, '<', 'DESC'), OBJECT);
                $trailing_posts = $wpdb->get_results(sprintf($querystr, '>', 'ASC'), OBJECT);

                if ($trailing_posts && count($trailing_posts)) {
                    echo $before_widget_2 . $before_title . $title_before . $after_title . "<div class=sidebarheader><ul class=listing>";
                    $trailing_posts = array_reverse($trailing_posts);
                    foreach ($trailing_posts as $post) {
                        setup_postdata($post);
                        ?> <li><a href="<?php the_permalink() ?>" title="<?php echo esc_attr(get_the_title() ? get_the_title() : get_the_ID()); ?>"><?php if ( get_the_title() ) the_title(); else the_ID(); ?> </a>,<span class="red"><?php echo do_shortcode('[entry-published]'); ?></span></li><?php
                    }
                    echo "</ul></div>" . $after_widget;
                }

                if ($leading_posts && count($leading_posts)) {
                    echo $before_widget . $before_title . $title_after . $after_title . "<div class=sidebarheader><ul class=listing>";
                    foreach ($leading_posts as $post) {
                        setup_postdata($post);
                        ?> <li><a href="<?php the_permalink() ?>" title="<?php echo esc_attr(get_the_title() ? get_the_title() : get_the_ID()); ?>"><?php if ( get_the_title() ) the_title(); else the_ID(); ?> </a>,<span class="red"><?php echo do_shortcode('[entry-published]'); ?></span></li><?php
                    }
                    echo "</ul></div>" . $after_widget;
                }
                wp_reset_query();
            }
        }

        function update( $new_instance, $old_instance ) {
            $instance = $old_instance;
            $instance['title_before'] = strip_tags($new_instance['title_before']);
            $instance['number'] = (int) $new_instance['number'];
            $instance['title_after'] = strip_tags($new_instance['title_after']);

            return $instance;
        }
        function form( $instance ) {
            $title_before = ($instance['title_before'] == '') ? '5 Posts before' : esc_attr($instance['title_before']);
            $title_after = ($instance['title_after'] == '') ? '5 Posts after' : esc_attr($instance['title_after']);
            if ( !$number = (int) $instance['number'] )
                $number = 5;
            elseif ( $number < 1 )
                $number = 1;
            elseif ( $number > 10 )
                $number = 10;
    ?>
            <p><label for="<?php echo $this->get_field_id('title_before'); ?>">Title before:</label>
            <input class="widefat" id="<?php echo $this->get_field_id('title_before'); ?>" name="<?php echo $this->get_field_name('title_before'); ?>" type="text" value="<?php echo $title_before; ?>" /></p>
            <p><label for="<?php echo $this->get_field_id('title_after'); ?>">Title after:</label>
            <input class="widefat" id="<?php echo $this->get_field_id('title_after'); ?>" name="<?php echo $this->get_field_name('title_after'); ?>" type="text" value="<?php echo $title_after; ?>" /></p>
            <p><label for="<?php echo $this->get_field_id('number'); ?>">Number of posts to show before and after current post:</label>
            <input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" size="3" /><br />
            <small>(at most 10)</small></p>
    <?php
        }
    }
    register_widget('PMNews_Widget_Post_Navigation');
}?>