<?php
/*
Plugin Name: CPT Products Display
Plugin URI: https://github.com/hettipower
Description: Add Custom Fields for any selected post type. Post Type can be selected manualy 
Version: 1.2
Author: TharinduH
Author URI: https://github.com/hettipower
Text Domain: cffapt
*/

defined( 'ABSPATH' ) or exit;
define( 'CFFAPT_PATH', plugin_dir_path( __FILE__ ) );
define( 'CFFAPT_URL', plugin_dir_url( __FILE__ ) );

//Settings Options
require_once CFFAPT_PATH.'/admin/options/admin_options.php';
//Custom Meta Fields
require_once CFFAPT_PATH.'/admin/meta-fields/custom_meta_links_list.php';
require_once CFFAPT_PATH.'/admin/meta-fields/custom_meta_fields.php';
require_once CFFAPT_PATH.'/admin/meta-fields/cpt_display_shortcode_meta.php';
require_once CFFAPT_PATH.'/admin/meta-fields/cpt_comparison_boxes.php';
require_once CFFAPT_PATH.'/admin/meta-fields/faqs_meta_fields.php';
//require_once CFFAPT_PATH.'/admin/meta-fields/simple_menus_meta_fields.php';
//require_once CFFAPT_PATH.'/admin/meta-fields/simple_latest_post_meta_fields.php';

//Admin Scripts
require_once CFFAPT_PATH.'/admin/scripts/admin_scripts.php';
//Front Scripts
require_once CFFAPT_PATH.'/admin/scripts/front_scripts.php';

//require_once CFFAPT_PATH.'/admin/class-template-loader.php';

//ShortCode Function
require_once CFFAPT_PATH.'/front/cpt_shortcode.php';
require_once CFFAPT_PATH.'/front/cpt_comparison_shortcode.php';
require_once CFFAPT_PATH.'/front/cpt_faqs_shortcode.php';