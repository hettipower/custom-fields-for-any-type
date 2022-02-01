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
        wp_enqueue_script( 'cffapt-admin', CFFAPT_PATH . '/admin/assets/js/cffapt-admin-post.js', array(), '1.0' );
    }

}
add_action( 'admin_enqueue_scripts', 'cffapt_enqueue_admin_script' );