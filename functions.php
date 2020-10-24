<?php
function my_theme_enqueue_styles() {

	wp_enqueue_style( 'wowmall-child-style',
		get_stylesheet_directory_uri() . '/style.css',
		array( 'wowmall-style' ),
		wp_get_theme()->get('Version')
	);
}
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles', 11 );

add_action( 'widgets_init', function () {
	register_sidebar( array(
			'id' => 'size-sidebar',
			'name' => __( 'Sidebar Size', 'jp-basic' ),
			'description' => __( '', 'jp-basic' ),
			'before_widget' => '',
			'after_widget' => '',
			'class' => 'size-filter',
	) );
} );

add_filter( 'woocommerce_output_related_products_args', function( $args ) 
{ 
    $args = wp_parse_args( array( 'posts_per_page' => 3 ), $args );
    return $args;
});

remove_action('woocommerce_single_product_summary', 'wowmall_wc_template_single_excerpt',20);


defined('THEME_URI') || define('THEME_URI', get_template_directory_uri());
defined('THEME_PATH') || define('THEME_PATH', realpath(__DIR__));


function function_script_header() {
	echo '<script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>';
}
add_action( 'wp_header', 'function_script_header' );


function function_script_footer() {
	include_once THEME_PATH . '/inc/functions.php';
}
add_action( 'wp_footer', 'function_script_footer' );

//Permitir subir archivos que no sean imagenes
add_filter( 'wp_check_filetype_and_ext', 'ecomerciar_disable_real_mime_check', 10, 4 );
function ecomerciar_disable_real_mime_check( $data, $file, $filename, $mimes ) {
	$wp_filetype = wp_check_filetype( $filename, $mimes );
	return array( 'ext' => $wp_filetype['ext'], 'type' => $wp_filetype['type'], 'proper_filename' => $wp_filetype['proper_filename'] );
}


add_filter('woocommerce_template_single_add_to_cart','__return_true');

add_action( 'woocommerce_single_product_summary', 'wowmall_wc_template_single_excerpt', 20 );


// Remove the additional information tab
function woo_remove_product_tabs( $tabs ) {
    unset( $tabs['additional_information'] );
    return $tabs;
}
add_filter( 'woocommerce_product_tabs', 'woo_remove_product_tabs', 98 );


