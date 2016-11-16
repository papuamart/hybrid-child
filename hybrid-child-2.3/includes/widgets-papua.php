<?php 
 
//////////////////////
if ( current_theme_supports( 'devnews-home-template' )  ) {
if ( function_exists('register_sidebar') ) {
    $allWidgetizedAreas = array("home-widget-1", "home-widget-2", "home-widget-3", "home-widget-4");    
    foreach ($allWidgetizedAreas as $WidgetAreaName) {    
    register_sidebar(array(
        'name'=> $WidgetAreaName,
		'description' => 'This is to be placed on External RSS", "WPNews RSS", "Papindo RSS", "Single Bottom widgets.',			
			'before_widget' => '<div id="%1$s" class="widget %2$s widget-%2$s"><div class="widget-inside">',
			'after_widget' => '</div></div>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>'
        ));    
    }
}
} // if current_theme_supports

if ( current_theme_supports( 'front-page-template' )  ) {	
if ( function_exists('register_sidebar') ) {
    $allWidgetizedAreas = array("home-1", "home-2", "home-3", "home-4");    
    foreach ($allWidgetizedAreas as $WidgetAreaName) {    
    register_sidebar(array(
        'name'=> $WidgetAreaName,
		'description' => 'This is to be placed on External RSS", "WPNews RSS", "Papindo RSS", "Single Bottom widgets.',			
			'before_widget' => '<div id="%1$s" class="widget %2$s widget-%2$s"><div class="widget-inside">',
			'after_widget' => '</div></div>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>'
        ));    
    }
}
} // if current_theme_supports


if ( current_theme_supports( 'papua-sidebar-widgets' )  ) {
/**
 * Register additional widget areas
 *
 * @since 0.3.0
 */
 function papua_register_sidebars() {
	    $allWidgetizedAreas = array("sidebar-home", "sidebar-archive", "sidebar-singular");    
    foreach ($allWidgetizedAreas as $WidgetAreaName) {    
    register_sidebar(array(
        'name'=> $WidgetAreaName,
		'description' => 'This is to be placed on External RSS", "WPNews RSS", "Papindo RSS", "Single Bottom widgets.',			
			'before_widget' => '<div id="%1$s" class="widget %2$s widget-%2$s"><div class="widget-inside">',
			'after_widget' => '</div></div>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>'
        ));    
    }
}
add_action( 'init', 'papua_register_sidebars', 11 );
} // if current_theme_supports

if ( current_theme_supports( 'papua-core-sidebars' )  ) {
/**
 * Register additional widget areas
 *
 * @since 0.3.0
 */
 function papua_core_register_sidebars() {
	    $allWidgetizedAreas = array("tertiary", "complementary", "quartiary");    
    foreach ($allWidgetizedAreas as $WidgetAreaName) {    
    register_sidebar(array(
        'name'=> $WidgetAreaName,
		'description' => 'This is to be placed on External RSS", "WPNews RSS", "Papindo RSS", "Single Bottom widgets.',			
			'before_widget' => '<div id="%1$s" class="widget %2$s widget-%2$s"><div class="widget-inside">',
			'after_widget' => '</div></div>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>'
        ));    
    }
}
add_action( 'init', 'papua_core_register_sidebars', 11 );
} // if current_theme_supports
 
?>