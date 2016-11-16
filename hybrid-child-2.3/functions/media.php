<?php
/**
 * Functions file for loading scripts and stylesheets.  This file also handles the output of attachment files 
 * by displaying appropriate HTML elements for the attachments.
 *
 * @package HybridCore
 * @subpackage Functions
 */
add_action( 'after_setup_theme', 'pmnews_scripts_setup', 12 );

if ( ! function_exists( 'pmnews_scripts_setup' ) ):
/**
*/
function pmnews_scripts_setup() {
 
define( 'PAPUA_JS', trailingslashit ( STYLESHEETPATH ) . 'library/js');
define( 'PAPUA_YUI_JS', trailingslashit ( STYLESHEETPATH ) . 'library/js/2.7.0/build');
define( 'PAPUA_CSS', trailingslashit ( STYLESHEETPATH ) . 'library/css');

// Register and deregister Stylesheet and Scripts files	
if(!is_admin()) {
	add_action( 'wp_print_styles', 'my_deregister_styles', 100 );
	add_action( 'wp_print_scripts', 'my_deregister_scripts', 100 );
	add_action( 'template_redirect', 'hybrid_pmnews_front_page_template' );

		add_theme_support( 'pmnews-core-scripts' );
	add_theme_support( 'pmnews-bubbling-scripts' );
	add_theme_support( 'pmnews-multicolour' );
	add_theme_support( 'pmnews-yui-grids' );
	add_theme_support( 'yui-core-bubbling-scripts' ); // this will load 2.9.0/build/assets/comarq.caa
	
	}
add_action('wp_footer', 'print_my_script');
 
function print_my_script() {
	global $add_my_script; 
	if ( ! $add_my_script )
		return;}
function my_deregister_scripts() {
	wp_deregister_script( 'jquery-1.3.2' );	
	wp_deregister_script( 'jquery-1.2.6' );	
	wp_deregister_script( 'yui-utilities' );	
	wp_deregister_script( 'yui-tabview' );	
	wp_deregister_script( 'yui-container' );	
	wp_deregister_script( 'yui-loading' );	
	wp_deregister_script( 'yui-bubbling-core' );	
	wp_deregister_script( 'yui-bubbling' );	
	wp_deregister_script( 'bubbling-dispatcher' );	
	wp_deregister_script( 'bubbling-lighter' );	
	wp_deregister_script( 'bubbling-tooltips' );	
	wp_deregister_script( 'bubbling-init' );	
	wp_deregister_script( 'jquery-lazyload' );		
		
	wp_register_script( 'jquery-1.3.2', esc_url( apply_atomic( 'jquery_132_scripts', get_stylesheet_directory_uri() .'/library/js/jquery-1.3.2.min.js' ) ), array( 'jquery' ), '1.3.2', true );
	wp_register_script( 'jquery-1.2.6', esc_url( apply_atomic( 'jquery_126_scripts', get_stylesheet_directory_uri() .'/library/js/jquery-1.2.6.min.js' ) ), array( 'jquery' ), '1.2.6', true );
	wp_register_script( 'jquery-base', esc_url( apply_atomic( 'jquery_base_scripts', get_stylesheet_directory_uri() .'/library/js/base.js' ) ), array( 'jquery' ), '20090624', true );
	wp_register_script( 'comment-ajax-scripts', esc_url( apply_atomic( 'pmnews_comment_ajax_scripts', get_stylesheet_directory_uri() .'/library/js/comments-ajax.js' ) ), array( 'jquery' ), '1.3', true );
	wp_register_script('jquery', '/wp-includes/js/jquery/jquery.js', true, '1.4.2', true);

		//wp_register_script( 'yui-utilities', esc_url( apply_atomic( 'yui_utilities_js', get_stylesheet_directory_uri() .'/library/js/2.7.0/build/utilities/utilities.js' ) ), array( 'jquery' ),  false, '2.7.0', true);
		wp_register_script( 'yui-tabview', esc_url( apply_atomic( 'yui_tabview_js', get_stylesheet_directory_uri() .'/library/js/2.7.0/build/tabview/tabview-min.js' ) ), array( 'jquery' ),  false, '2.7.0', true);
		wp_register_script( 'yui-container', esc_url( apply_atomic( 'yui_container_js', get_stylesheet_directory_uri() .'/library/js/2.7.0/build/container/container-min.js' ) ), array( 'jquery' ),  false, '2.7.0', true);
		wp_register_script( 'yui-bubbling-core', esc_url( apply_atomic( 'yui_core_js', get_stylesheet_directory_uri() .'/library/js/2.0/build/package/core.js' ) ), array( 'jquery' ),  false, '2.0', true);
		wp_register_script( 'yui-bubbling', esc_url( apply_atomic( 'yui_bubbling_js', get_stylesheet_directory_uri() .'/library/js/2.0/build/bubbling/bubbling-min.js' ) ), array( 'jquery' ),  false, '2.0', true);
		wp_register_script( 'yui-loading', esc_url( apply_atomic( 'yui_loading_js', get_stylesheet_directory_uri() .'/library/js/2.0/build/loading/loading-min.js' ) ), array( 'jquery' ),  false, '2.0', true);
		wp_register_script( 'yui-accordion', esc_url( apply_atomic( 'yui_accordion_js', get_stylesheet_directory_uri() .'/library/js/2.0/build/accordion/accordion-min.js' ) ), array( 'jquery' ),  false, '2.0', true);
		wp_register_script( 'yui-dispatcher', esc_url( apply_atomic( 'yui_dispatcher_js', get_stylesheet_directory_uri() .'/library/js/2.0/build/dispatcher/dispatcher-min.js' ) ), array( 'jquery' ),  false, '2.0', true);
		wp_register_script( 'yui-lighter', esc_url( apply_atomic( 'yui_lighter_js', get_stylesheet_directory_uri() .'/library/js/2.0/build/lighter/lighter-min.js' ) ), array( 'jquery' ),  false, '2.0', true);
		wp_register_script( 'yui-tooltips', esc_url( apply_atomic( 'yui_tooltips_js', get_stylesheet_directory_uri() .'/library/js/2.0/build/tooltips/tooltips-min.js' ) ), array( 'jquery' ),  false, '2.0', true);
		wp_register_script( 'bubbling-init', esc_url( apply_atomic( 'yui_init_js', get_stylesheet_directory_uri() .'/library/js/0.1.1/build/init.js' ) ), array( 'jquery' ),  false, '0.1.1', true);

		wp_enqueue_script( 'jquery' );							
		wp_enqueue_script( 'jquery-1.3.2' );				
		wp_enqueue_script( 'jquery-1.2.6' );				
		wp_enqueue_script( 'jquery-base' );				
		
		//wp_enqueue_script( 'yui-utilities' );				
		wp_enqueue_script( 'yui-tabview' );				
		wp_enqueue_script( 'yui-container' );				
		wp_enqueue_script( 'yui-bubbling-core' );				
		wp_enqueue_script( 'yui-bubbling' );				
		wp_enqueue_script( 'yui-loading' );				
		wp_enqueue_script( 'bubbling-accordion' );				
		wp_enqueue_script( 'bubbling-dispatcher' );				
		wp_enqueue_script( 'bubbling-lighter' );				
		wp_enqueue_script( 'bubbling-tooltips' );				
		wp_enqueue_script( 'bubbling-init' );				

if (is_attachment()) {
		/* this is particularly important for imagepanner.js to function */
		wp_deregister_script('imagepanner');
		wp_deregister_script('imageresizer');
		wp_deregister_style('imagepanner');
		wp_deregister_style('imageresizer');
		wp_register_style( 'pmnews-shortcodes', esc_url( apply_atomic( 'content_box_css', trailingslashit( MYPAPUA_URL ) . 'library/plugins/tinymce-kit/editor-style.css')), 'media', true );
		
		wp_register_script( 'imagepanner', esc_url( apply_atomic( 'imagepanner_js', get_stylesheet_directory_uri() .'/library/js/imagepanner.js' ) ), array( 'jquery' ), '1.1', true );
		wp_register_script( 'imageresizer', esc_url( apply_atomic( 'imageresizer_js', get_stylesheet_directory_uri() .'/library/js/imageresizer.js' ) ), array( 'jquery' ), '1.1', true );
		wp_register_style( 'imagepanner', esc_url( apply_atomic( 'imagepanner_css', get_stylesheet_directory_uri() .'/library/css/imagepanner.css' )), true, '1.1' );
		wp_register_style( 'imageresizer', esc_url( apply_atomic( 'imageresizer_css', get_stylesheet_directory_uri() .'/library/css/imageresizer.css' )), true, '1.1' );
 
		wp_enqueue_script('imagepanner');
		wp_enqueue_script('imageresizer');
		wp_enqueue_style( 'imagepanner');	
		wp_enqueue_style( 'imageresizer');	
	}
	
if ( current_theme_supports( 'pmnews-core-scripts' ) ){
		//wp_enqueue_script( 'jquery' );
		wp_enqueue_script('jquery-1.2.6');
		wp_enqueue_script( 'base-scroll-page' );
	}
 
if ( is_singular() && get_option( 'thread_comments' ) && comments_open() ){
	/* this is particularly important for comment-ajax.js to function */		
		wp_enqueue_script( 'comment-ajax-scripts' );
}
if (is_page_template('page-front-page.php')){
	wp_deregister_script( 'slider' );
	wp_deregister_script( 'jquery.functions' );
	wp_deregister_style( 'news-front-page' );
	wp_enqueue_style('front-page-css', esc_url( apply_atomic( 'gallery_slideshow_video_css', get_stylesheet_directory_uri() .'/library/css/home/front-page.css' )), true, '1.1' );
	wp_register_script( 'slider', get_stylesheet_directory_uri() .'/library/js/jquery.cycle.js', array( 'jquery' ), 0.1 );
	wp_register_script( 'jquery.functions', get_stylesheet_directory_uri() .'/library/js/jquery.functions.js', array( 'jquery' ) );
	wp_enqueue_script( 'slider' );
	wp_enqueue_script( 'jquery.functions' );
	wp_enqueue_style( 'front-page-css' );
}

if (is_page_template('page-pmnews-front-page.php')){
	wp_deregister_script( 'slider' );
	wp_deregister_script( 'jquery.functions' );
	wp_deregister_style( 'news-front-page' );
	wp_enqueue_style('news-front-page', esc_url( apply_atomic( 'gallery_slideshow_video_css', get_stylesheet_directory_uri() .'/library/css/home/front-page.css' )), true, '1.1' );
	wp_register_script( 'slider', get_stylesheet_directory_uri() .'/library/js/jquery.cycle.js', array( 'jquery' ), 0.1 );
	wp_register_script( 'jquery.functions', get_stylesheet_directory_uri() .'/library/js/jquery.functions.js', array( 'jquery' ) );
	wp_enqueue_script( 'slider' );
	wp_enqueue_script( 'jquery.functions' );
	wp_enqueue_style( 'news-front-page' );
}
 	
if (is_page_template('content-page-pmnews-home.php') ){
	remove_theme_support( 'hybrid-core-drop-downs' );
	wp_deregister_style( 'home-page-css' );
	wp_register_style( 'feature-slideshow-video-css', esc_url( apply_atomic( 'gallery_slideshow_video_css', get_stylesheet_directory_uri() .'/library/css/home/slideshow-video.css' )), true, '1.1' );
	wp_register_script( 'news-theme',  esc_url( apply_atomic( 'news_theme_js_script', get_stylesheet_directory_uri() .'/library/js/news-theme.js')), array( 'jquery' ), 1.4 );
	wp_enqueue_script( 'news-theme' );
	wp_enqueue_style( 'feature-slideshow-video-css' );
	/* Remove the breadcrumb trail. */
	add_filter( 'breadcrumb_trail', '__return_false' );
}

if (is_page_template('content-page-news-home.php') ){
	remove_theme_support( 'hybrid-core-drop-downs' );
	wp_deregister_style( 'home-page-css' );
	wp_register_style( 'home-page-css', get_stylesheet_directory_uri() .'/library/css/home/page-template-home.css', false, '0.1', 'screen' );
	wp_register_script( 'news-theme', get_stylesheet_directory_uri() .'/library/js/news-theme.js', array( 'jquery' ), 1.4 );
	wp_enqueue_script( 'news-theme' );
	wp_enqueue_style( 'home-page-css' );
	/* Remove the breadcrumb trail. */
	add_filter( 'breadcrumb_trail', '__return_false' );
}
 
if (is_page_template('page-home.php') ){
	//wp_deregister_script( 'news-theme' );
	wp_deregister_style( 'news-home-page' );
	wp_enqueue_style('news-home-page', esc_url( apply_atomic( 'news_home_css', get_stylesheet_directory_uri() .'/library/css/home/home.css') ), false);	
	//wp_register_script( 'news-theme', esc_url( apply_atomic( 'hybrid_news_theme_js', get_stylesheet_directory_uri() .'/library/js/news-theme.js' ) ), array( 'jquery' ), '1.4.8', true );
	//wp_enqueue_script( 'news-theme' );
	wp_enqueue_style( 'news-home-page' );
}

if (is_singular('slideshow') && !is_singular('video') ){
	wp_deregister_script( 'news-theme' );
	wp_deregister_style( 'feature-slideshow-video-css' );
	wp_register_script( 'news-theme', esc_url( apply_atomic( 'hybrid_news_theme_js', get_stylesheet_directory_uri() .'/library/js/news-theme.js' ) ), array( 'jquery' ), '1.4.8', true );
	wp_register_style( 'feature-slideshow-video-css', esc_url( apply_atomic( 'gallery_slideshow_video_css', get_stylesheet_directory_uri() .'/library/css/slideshow-video.css' )), true, '1.1' );
	wp_enqueue_style( 'feature-slideshow-video-css' );
	remove_theme_support( 'hybrid-core-drop-downs' );		
	wp_enqueue_script( 'news-theme' );

	/* Remove the breadcrumb trail. */
	add_filter( 'breadcrumb_trail', '__return_false' );		
	}
		
}
function my_deregister_styles() {
	wp_deregister_style( 'yui-skin' );
	wp_deregister_style( 'yui-container' );
	wp_deregister_style( 'bubbling-loading' );	
 	wp_deregister_style( 'yui-bubbling-accordion' );		
	wp_deregister_style( 'yui-bubbling-myAccordion' );		
	wp_deregister_style( 'yui-bubbling-multicolumns' );		

  	wp_register_style( 'yui-skin', esc_url( apply_atomic( 'yui_skin_css', get_stylesheet_directory_uri() .'/library/js/2.7.0/build/assets/skins/sam/skin.css' )), true, '2.7.0' );
  	wp_register_style( 'yui-container', esc_url( apply_atomic( 'yui_container_css', get_stylesheet_directory_uri() .'/library/js/2.7.0/build/assets/skins/sam/container.css' )), true, '2.7.0' );
  	wp_register_style( 'yui-bubbling-accordion', esc_url( apply_atomic( 'yui_bubbling_accordion_css', get_stylesheet_directory_uri() .'/library/js/2.0/build/accordion/assets/accordion.css' )), true, '1.3.3' );
  	wp_register_style( 'yui-bubbling-myAccordion', esc_url( apply_atomic( 'yui_bubbling_myAccordion_css', get_stylesheet_directory_uri() .'/library/css/myAccordion.css' )), true, '1.3.3' );
  	wp_register_style( 'yui-bubbling-multicolumns', esc_url( apply_atomic( 'yui_bubbling_multicolumns_css', get_stylesheet_directory_uri() .'/library/css/multicolumns.css' )), true, '1.3.3' );
 
	wp_enqueue_style( 'yui-skin');
	wp_enqueue_style( 'yui-container');
	wp_enqueue_style( 'yui-bubbling-accordion' );
	wp_enqueue_style( 'yui-bubbling-myAccordion' );
	wp_enqueue_style( 'yui-bubbling-multicolumns' ); 
}
function hybrid_pmnews_front_page_template() {
	if (!is_page_template( 'page-front-page.php'))
	return;
		wp_register_script( 'slider', esc_url( apply_atomic( 'slider_js', trailingslashit( get_stylesheet_directory_uri()) . 'library/js/jquery.cycle.js' ) ), array( 'jquery' ), 0.1 );
		wp_register_script( 'slider-functions', esc_url( apply_atomic( 'slider_functions_js', trailingslashit( get_stylesheet_directory_uri()) . 'library/js/jquery.functions.js' ) ), array( 'jquery' ), 0.1 );
		wp_register_style( 'front-page', esc_url( apply_atomic( 'front-page_css', trailingslashit( get_stylesheet_directory_uri()) . 'library/css/front-page.css' )), false, '0.1', 'screen' );
	
 	wp_enqueue_script( 'slider');	
 	wp_enqueue_script( 'slider-functions');	
	wp_enqueue_style( 'front-page');
	
		/* Remove the breadcrumb trail. */
	add_filter( 'breadcrumb_trail', '__return_false' );	
}	
}
endif;
?>