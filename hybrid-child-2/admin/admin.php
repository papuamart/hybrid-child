<?php
/**
 * Admin functions.
 *
 * @package News
 * @subpackage Includes
 * @since 0.1.0
 */

/**
 * Saves the theme settings for Hybrid News if the user has added any.
 *
 * @since 0.3.0
 */
function hybrid_news_save_meta_box( $settings ) {

	$settings['feature_category'] = empty( $settings['feature_category'] ) ? '' : absint( $settings['feature_category'] );
	$settings['excerpt_category'] = empty( $settings['excerpt_category'] ) ? '' : absint( $settings['excerpt_category'] );
	$settings['feature_num_posts'] = empty( $settings['feature_num_posts'] ) ? 3 : absint( $settings['feature_num_posts'] );
	$settings['excerpt_num_posts'] = empty( $settings['excerpt_num_posts'] ) ? 3 : absint( $settings['excerpt_num_posts'] );
	$settings['headlines_num_posts'] = empty( $settings['headlines_num_posts'] ) ? 5 : absint( $settings['headlines_num_posts'] );
	$settings['headlines_category'] = empty( $settings['headlines_category'] ) || !is_array( $settings['headlines_category'] ) ? '' : $settings['headlines_category'];

	return $settings;
}

/**
 * Adds a meta box to the theme settings page in the admin.
 *
 * @since 0.3.0
 */
function hybrid_news_create_meta_box() {
	add_meta_box( 'hybrid-news-front-page-box', __( 'Front Page template settings', 'hybrid-news' ), 'hybrid_news_front_page_meta_box', 'appearance_page_theme-settings', 'normal', 'low' );
}

/**
 * Outputs the meta box and its form for the theme settings page.
 *
 * @since 0.3.0
 */
function hybrid_news_front_page_meta_box() {
	$categories = get_categories(); ?>

	<table class="form-table">

		<tr>
			<th><label for="<?php echo hybrid_settings_field_id( 'feature_category' ); ?>"><?php _e( 'Feature Category:', 'hybrid-news' ); ?></label></th>
			<td>
				<select id="<?php echo hybrid_settings_field_id( 'feature_category' ); ?>" name="<?php echo hybrid_settings_field_name( 'feature_category' ); ?>">
					<option value="" <?php selected( hybrid_get_setting( 'feature_category' ), '' ); ?>></option>
				<?php foreach ( $categories as $cat ) { ?>
					<option value="<?php echo $cat->term_id; ?>" <?php selected( hybrid_get_setting( 'feature_category' ), $cat->term_id ); ?>><?php echo esc_html( $cat->name ); ?></option>
				<?php } ?>
				</select> 
				<?php _e( 'Leave blank to use sticky posts.', 'hybrid-news' ); ?>
			</td>
		</tr>
		<tr>
			<th><label for="<?php echo hybrid_settings_field_id( 'feature_num_posts' ); ?>"><?php _e( 'Featured Posts:', 'hybrid-news' ); ?></label></th>
			<td>
				<input type="text" id="<?php echo hybrid_settings_field_id( 'feature_num_posts' ); ?>" name="<?php echo hybrid_settings_field_name( 'feature_num_posts' ); ?>" value="<?php echo esc_attr( hybrid_get_setting( 'feature_num_posts' ) ); ?>" size="2" maxlength="2" />
				<label for="<?php echo hybrid_settings_field_id( 'feature_num_posts' ); ?>"><?php _e( 'How many feature posts should be shown?', 'hybrid-news' ); ?></label>
			</td>
		</tr>
		<tr>
			<th><label for="<?php echo hybrid_settings_field_id( 'excerpt_category' ); ?>"><?php _e( 'Excerpts Category:', 'hybrid-news' ); ?></label></th>
			<td>
				<select id="<?php echo hybrid_settings_field_id( 'excerpt_category' ); ?>" name="<?php echo hybrid_settings_field_name( 'excerpt_category' ); ?>">
					<option value="" <?php selected( hybrid_get_setting( 'excerpt_category' ), '' ); ?>></option>
					<?php foreach( $categories as $cat ) { ?>
						<option value="<?php echo $cat->term_id; ?>" <?php selected( hybrid_get_setting( 'excerpt_category' ), $cat->term_id ); ?>><?php echo esc_html( $cat->name ); ?></option>
					<?php } ?>
				</select>
			</td>
		</tr>
		<tr>
			<th><label for="<?php echo hybrid_settings_field_id( 'excerpt_num_posts' ); ?>"><?php _e( 'Excerpts Posts:', 'hybrid-news' ); ?></label></th>
			<td>
				<input type="text" id="<?php echo hybrid_settings_field_id( 'excerpt_num_posts' ); ?>" name="<?php echo hybrid_settings_field_name( 'excerpt_num_posts' ); ?>" value="<?php echo esc_attr( hybrid_get_setting( 'excerpt_num_posts' ) ); ?>" size="2" maxlength="2" />
				<label for="<?php echo hybrid_settings_field_id( 'excerpt_num_posts' ); ?>"><?php _e('How many excerpts should be shown?', 'hybrid-news' ); ?></label>
			</td>
		</tr>
		<tr>
			<th><label for="<?php echo hybrid_settings_field_id( 'headlines_category' ); ?>"><?php _e( 'Headline Categories:', 'hybrid-news' ); ?></label></th>
			<td>
				<label for="<?php echo hybrid_settings_field_id( 'headlines_category' ); ?>"><?php _e( 'Multiple categories may be chosen by holding the <code>Ctrl</code> key and selecting.', 'hybrid-news' ); ?></label>
				<br />
				<select id="<?php echo hybrid_settings_field_id( 'headlines_category' ); ?>" name="<?php echo hybrid_settings_field_name( 'headlines_category' ); ?>[]" multiple="multiple" style="height:150px;">
				<?php foreach( $categories as $cat ) { ?>
					<option value="<?php echo $cat->term_id; ?>" <?php if ( is_array( hybrid_get_setting( 'headlines_category' ) ) && in_array( $cat->term_id, hybrid_get_setting( 'headlines_category' ) ) ) echo ' selected="selected"'; ?>><?php echo esc_html( $cat->name ); ?></option>
				<?php } ?>
				</select>
			</td>
		</tr>
		<tr>
			<th><label for="<?php echo hybrid_settings_field_id( 'headlines_num_posts' ); ?>"><?php _e('Headlines Posts:', 'hybrid-news' ); ?></label></th>
			<td>
				<input type="text" id="<?php echo hybrid_settings_field_id( 'headlines_num_posts' ); ?>" name="<?php echo hybrid_settings_field_name( 'headlines_num_posts' ); ?>" value="<?php echo esc_attr( hybrid_get_setting( 'headlines_num_posts' ) ); ?>" size="2" maxlength="2" />
				<label for="<?php echo hybrid_settings_field_id( 'headlines_num_posts' ); ?>"><?php _e( 'How many posts should be shown per headline category?', 'hybrid-news' ); ?></label>
			</td>
		</tr>

	</table><!-- .form-table --><?php
}

?>