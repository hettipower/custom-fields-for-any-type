<?php
/**
 *
 * @param int $hook Hook suffix for the current admin page.
 */
function cffapt_enqueue_admin_script( $hook ) {

    $cffapt_settings_options = get_option( 'cffapt_options' );
    $cffapt_post_types = $cffapt_settings_options['cffapt_post_types'];
    $screen = get_current_screen();

    if( in_array( $screen->id , $cffapt_post_types ) ) {
        wp_enqueue_script( 'repeater', CFFAPT_URL . 'admin/assets/js/jquery.repeater.min.js', array(), '1.0' );
        wp_enqueue_script( 'cffapt-admin', CFFAPT_URL . 'admin/assets/js/cffapt-admin-post.js', array(), '1.0' );

        wp_register_style( 'cffapt_admin_css', CFFAPT_URL . 'admin/assets/css/cffapt-admin-post.css', false, '1.0.0' );
        wp_enqueue_style( 'cffapt_admin_css' );
    }

}
add_action( 'admin_enqueue_scripts', 'cffapt_enqueue_admin_script' );