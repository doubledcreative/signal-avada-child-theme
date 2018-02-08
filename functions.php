<?php

function theme_enqueue_styles() {
    wp_enqueue_style( 'avada-parent-stylesheet', get_template_directory_uri() . '/style.css' );
}
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );

function avada_lang_setup() {
	$lang = get_stylesheet_directory() . '/languages';
	load_child_theme_textdomain( 'Avada', $lang );
}
add_action( 'after_setup_theme', 'avada_lang_setup' );

    
////////////////////////////////////////////////////////////////////////////////////////////////////

/* Load LESS */

function childtheme_scripts() {

wp_enqueue_style('less', get_stylesheet_directory_uri() .'/css/style.less');
add_filter('style_loader_tag', 'my_style_loader_tag_function');

wp_enqueue_script('less', get_stylesheet_directory_uri() .'/scripts/less.min.js', array('jquery'),'2.5.0');

}
add_action('wp_enqueue_scripts','childtheme_scripts', 150);

function my_style_loader_tag_function($tag){   
  return preg_replace("/='stylesheet' id='less-css'/", "='stylesheet/less' id='less-css'", $tag);
}

////////////////////////////////////////////////////////////////////////////////////////////////////

/* Load Fonts dot com */

function extra_css () {
	wp_register_style( 'font', '//fast.fonts.net/cssapi/70eaf24b-3068-4ded-9473-ca80349f025a.css' );
	wp_enqueue_style( 'font' );
} 

add_action('wp_print_styles', 'extra_css');

////////////////////////////////////////////////////////////////////////////////////////////////////

/* Remove Date from Yoast SEO */

add_filter( 'wpseo_show_date_in_snippet_preview', false);

////////////////////////////////////////////////////////////////////////////////////////////////////

add_shortcode( 'divider', 'shortcode_insert_divider' );
function shortcode_insert_divider( ) {
return '<div class="divider"></div>';
}

////////////////////////////////////////////////////////////////////////////////////////////////////

/* Remove Dates from SEO on Pages */

function wpd_remove_modified_date(){
    if( is_page() ){
        add_filter( 'the_time', '__return_false' );
        add_filter( 'the_modified_time', '__return_false' );
        add_filter( 'get_the_modified_time', '__return_false' );
        add_filter( 'the_date', '__return_false' );
        add_filter( 'the_modified_date', '__return_false' );
        add_filter( 'get_the_modified_date', '__return_false' );
    }
}
add_action( 'template_redirect', 'wpd_remove_modified_date' );

////////////////////////////////////////////////////////////////////////////////////////////////////

/* Defer Parsing of Java 

if (!(is_admin() )) {
  function defer_parsing_of_js ( $url ) {
    if ( FALSE === strpos( $url, '.js' ) ) return $url;
    if ( strpos( $url, 'jquery.js' ) ) return $url;
    return "$url' defer ";
  }
  add_filter( 'clean_url', 'defer_parsing_of_js', 11, 1 );
}*/

////////////////////////////////////////////////////////////////////////////////////////////////////

/* Remove Query String */

function _remove_script_version( $src ){
	$parts = explode( '?', $src );
	return $parts[0];
}
add_filter( 'script_loader_src', '_remove_script_version', 15, 1 );
add_filter( 'style_loader_src', '_remove_script_version', 15, 1 );

////////////////////////////////////////////////////////////////////////////////////////////////////

/*** Add Field Visibility Section to Gravity Forms ***/		
		
add_filter( 'gform_enable_field_label_visibility_settings', '__return_true' );

add_filter("gform_init_scripts_footer", "init_scripts");
function init_scripts() {
return true;
}

////////////////////////////////////////////////////////////////////////////////////////////////////

/* Change Gravity Button Type To FontAwesome */

add_filter("gform_submit_button_2", "form_submit_button", 10, 2);
function form_submit_button($button, $form){
return "<button class='button' id='gform_submit_button_{$form["id"]}'><i class='fa fa-fw fa-envelope'></i></button>";
}

