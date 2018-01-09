<?php
	// This theme uses post thumbnails
	// Add default posts and comments RSS feed links to head
	// Make theme available for translation
	// This theme uses wp_nav_menu() in one location.
}
endif;
if ( ! function_exists( 'promocode_admin_header_style' ) ) :
function promocode_admin_header_style() {
?>
#headimg {
<?php
add_filter( 'wp_page_menu_args', 'promocode_page_menu_args' );
function promocode_auto_excerpt_more( $more ) {
	return '' . promocode_continue_reading_link();
}
add_filter( 'excerpt_more', 'promocode_auto_excerpt_more' );
function promocode_custom_excerpt_more( $output ) {
	if ( has_excerpt() && ! is_attachment() ) {}
	return $output;
}
add_filter( 'get_the_excerpt', 'promocode_custom_excerpt_more' );
function promocode_remove_gallery_css( $css ) {
	return preg_replace( "#<style type='text/css'>(.*?)</style>#s", '', $css );
}
function promocode_widgets_init() {
	// Area 1, located at the top of the sidebar.
	register_sidebar( array(
add_action( 'widgets_init', 'promocode_widgets_init' );