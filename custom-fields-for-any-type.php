<?php
/*
Plugin Name: Custom Fields for any Post Type
Plugin URI: https://github.com/hettipower
Description: Add Custom Fields for any selected post type. Post Type can be selected manualy 
Version: 1.0
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
//Admin Scripts
require_once CFFAPT_PATH.'/admin/scripts/admin_scripts.php';