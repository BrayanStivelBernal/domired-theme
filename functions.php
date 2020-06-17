<?php


/** tema padre*/
add_action( 'wp_enqueue_scripts', 'enqueue_parent_theme_style' );
function enqueue_parent_theme_style() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );
	if (is_rtl()) {
		 wp_enqueue_style( 'parent-rtl', get_template_directory_uri().'/rtl.css', array(), RH_MAIN_THEME_VERSION);
	}     
}



/**hooks*/

// scripts extras
function ajax_ser_enqueue_scripts() {
    
    $uri  =  get_stylesheet_directory_uri();
    $vers =  time();
    
    if ( bp_displayed_user_id() !== 0 ){
         wp_enqueue_script( 'scripts_ser',  $uri.'/includes_cp/scripts.js', array('jquery'), 1.4, true );
    }
    
    if ( is_super_admin( get_current_user_id() )) {
        
        wp_enqueue_style( 'angular_style', $uri.'/includes_cp/angular-class.min_.css', [], $vers);
        wp_enqueue_style( 'fonts_material', 'https://fonts.googleapis.com/icon?family=Material+Icons', [], $vers);
        wp_enqueue_style( 'table_style_ser', $uri.'/includes_cp/style.css', [], $vers);
        wp_enqueue_script( 'angularjs', $uri.'/includes_cp/angular-class.js', [], $vers, true);
        wp_enqueue_script( 'angular_ser',  $uri.'/includes_cp/app.js', array('angularjs'), 1.1, true );
    }
}
add_action( 'wp_enqueue_scripts', 'ajax_ser_enqueue_scripts' );

// cambios al menu de usuario
function remove_subnav_user() {   
  	
	if ( !is_super_admin(get_current_user_id()) ) {
        bp_core_remove_nav_item( 'enviar-contactos' ); 
    } 
	
}
add_action( 'bp_init', 'remove_subnav_user' );



?>