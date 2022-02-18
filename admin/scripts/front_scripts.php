<?php
function cffapt_enqueue_front_script() {
    wp_register_style( 'cffapt_front_css', CFFAPT_URL . 'front/assets/css/cffapt-front.css', false, '1.0.0' );
    wp_enqueue_style( 'cffapt_front_css' );
    wp_register_style( 'fontawesome-css', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css', false, '1.0.0' );
    wp_enqueue_style( 'fontawesome-css' );

    wp_register_script('cffapt_front_js',CFFAPT_URL.'front/assets/js/cffapt-front.js', array('jquery'),'1.0',true);
    wp_enqueue_script('cffapt_front_js');
}
add_action('wp_print_styles', 'cffapt_enqueue_front_script');