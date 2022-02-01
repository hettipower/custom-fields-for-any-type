<?php

//Setting Options
class CustomPostTypeSettings {
	private $custom_post_type_settings_options;

	public function __construct() {
		add_action( 'admin_menu', array( $this, 'cffapt_settings_add_plugin_page' ) );
		add_action( 'admin_init', array( $this, 'cffapt_settings_page_init' ) );
	}

	public function cffapt_settings_add_plugin_page() {
		add_menu_page(
			'Custom Post Type Settings', // page_title
			'Custom Post Type Settings', // menu_title
			'manage_options', // capability
			'cffapt-settings', // menu_slug
			array( $this, 'cffapt_settings_create_admin_page' ), // function
			'dashicons-admin-generic', // icon_url
			80 // position
		);
	}

	public function cffapt_settings_create_admin_page() {
		$this->custom_post_type_settings_options = get_option( 'cffapt_options' ); ?>

		<div class="wrap">
			<h2>Custom Post Type Settings</h2>
			<p>Please select post type(s) to add custom fields</p>
			<?php settings_errors(); ?>

			<form method="post" action="options.php">
				<?php
					settings_fields( 'cffapt_settings_option_group' );
					do_settings_sections( 'cffapt-settings-admin' );
					submit_button();
				?>
			</form>
		</div>
	<?php }

	public function cffapt_settings_page_init() {
		register_setting(
			'cffapt_settings_option_group', // option_group
			'cffapt_options', // option_name
			array( $this, 'cffapt_settings_sanitize' ) // sanitize_callback
		);

		add_settings_section(
			'cffapt_settings_setting_section', // id
			'Settings', // title
			array( $this, 'cffapt_settings_section_info' ), // callback
			'cffapt-settings-admin' // page
		);

		add_settings_field(
			'cffapt_post_types', // id
			'Post Types', // title
			array( $this, 'cffapt_post_types_callback' ), // callback
			'cffapt-settings-admin', // page
			'cffapt_settings_setting_section' // section
		);
	}

	public function cffapt_settings_sanitize($input) {
		$sanitary_values = array();
		if ( isset( $input['cffapt_post_types'] ) ) {
			$sanitary_values['cffapt_post_types'] = $input['cffapt_post_types'];
		}

		return $sanitary_values;
	}

	public function cffapt_settings_section_info() {
		
	}

	public function cffapt_post_types_callback() {

        $allPostTypes = $this->get_all_post_types();

        if( $allPostTypes ) {
            foreach( $allPostTypes as $postType ) {


                $checked = ( isset( $this->custom_post_type_settings_options['cffapt_post_types'] ) && in_array( $postType->name , $this->custom_post_type_settings_options['cffapt_post_types'] ) ) ? 'checked' : '' ;
                
                printf(
                    '<p><input type="checkbox" name="cffapt_options[cffapt_post_types][]" id="cffapt_post_types_%s" value="%s" %s><label for="cffapt_post_types_%s">%s</label></p>' , $postType->name , $postType->name , $checked , $postType->name , $postType->label
                );


            }
        }

	}

    public function get_all_post_types() {
        $args = array(
            'public'   => true,
        );
        $post_types = get_post_types( $args , 'objects' );

        return $post_types;
    }

}
if ( is_admin() )
	$cffapt_settings = new CustomPostTypeSettings();

/* 
 * Retrieve this value with:
 * $cffapt_settings_options = get_option( 'cffapt_options' ); // Array of All Options
 * $cffapt_post_types = $cffapt_settings_options['cffapt_post_types']; // Post Types
 */
