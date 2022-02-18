<?php
/**
 * Retrieving the values:
 * Shortcode = get_post_meta( get_the_ID(), 'cffapt_shortcode', true )
 */
class CPT_Display_Shortcode {
	private $config = '{"title":"CPT Display Shortcode","prefix":"cffapt_","domain":"cffapt","class_name":"CPT_Display_Shortcode","post-type":["post"],"context":"side","priority":"default","fields":[{"type":"text","label":"Shortcode","id":"cffapt_shortcode"}]}';

	public function __construct() {
		$this->config = json_decode( $this->config, true );
		add_action( 'add_meta_boxes', [ $this, 'add_meta_boxes' ] );
		add_action( 'save_post', [ $this, 'save_post' ] );
	}

	public function add_meta_boxes() {
		$cffapt_settings_options = get_option( 'cffapt_options' );
        $cffapt_post_types = $cffapt_settings_options['cffapt_post_types'];

        if( $cffapt_post_types ) {
            foreach( $cffapt_post_types as $post_type ) {
                add_meta_box(
                    sanitize_title( $this->config['title'] ),
                    $this->config['title'],
                    [ $this, 'add_meta_box_callback' ],
                    $post_type,
                    $this->config['context'],
                    $this->config['priority']
                );
            }
        }
	}

	public function save_post( $post_id ) {
        $shortcode = '[cpt-product-display id="'.$post_id.'"]';
        update_post_meta( $post_id, 'cffapt_shortcode', $shortcode );
	}

	public function add_meta_box_callback() {
		$this->fields_div();
	}

	private function fields_div() {
        global $post;
		foreach ( $this->config['fields'] as $field ) {
			?><div class="components-base-control">
				<div class="components-base-control__field">
                    <code style="width: 100%;display: inline-block;box-sizing: border-box;padding: 14px 0;text-align: center;font-weight: 600;font-size: 15px;"><?php echo $this->value( $field ); ?></code>
                </div>
			</div><?php
		}
	}

	private function label( $field ) {
		switch ( $field['type'] ) {
			default:
				printf(
					'<label class="components-base-control__label" for="%s">%s</label>',
					$field['id'], $field['label']
				);
		}
	}

	private function field( $field ) {
		switch ( $field['type'] ) {
			default:
				$this->input( $field );
		}
	}

	private function input( $field ) {
		printf(
			'<input class="components-text-control__input %s" id="%s" name="%s" %s type="%s" value="%s" readonly>',
			isset( $field['class'] ) ? $field['class'] : '',
			$field['id'], $field['id'],
			isset( $field['pattern'] ) ? "pattern='{$field['pattern']}'" : '',
			$field['type'],
			$this->value( $field )
		);
	}

	private function value( $field ) {
		global $post;
		if ( metadata_exists( 'post', $post->ID, $field['id'] ) ) {
			$value = get_post_meta( $post->ID, $field['id'], true );
		} else if ( isset( $field['default'] ) ) {
			$value = '';
		} else {
			return '';
		}
		return str_replace( '\u0027', "'", $value );
	}

}
new CPT_Display_Shortcode;


/**
 * Retrieving the values:
 * Comparison Boxes Shortcode = get_post_meta( get_the_ID(), 'cffapt_comparison_shortcode', true )
 */
class Comparison_Boxes_Shortcode {
	private $config = '{"title":"Comparison Boxes Shortcode","prefix":"cffapt_","domain":"cffapt","class_name":"Comparison_Boxes_Shortcode","post-type":["post"],"context":"side","priority":"default","fields":[{"type":"text","label":"Shortcode","id":"cffapt_comparison_shortcode"}]}';

	public function __construct() {
		$this->config = json_decode( $this->config, true );
		add_action( 'add_meta_boxes', [ $this, 'add_meta_boxes' ] );
		add_action( 'save_post', [ $this, 'save_post' ] );
	}

	public function add_meta_boxes() {
		$cffapt_settings_options = get_option( 'cffapt_options' );
        $cffapt_post_types = $cffapt_settings_options['cffapt_post_types'];

        if( $cffapt_post_types ) {
            foreach( $cffapt_post_types as $post_type ) {
                add_meta_box(
                    sanitize_title( $this->config['title'] ),
                    $this->config['title'],
                    [ $this, 'add_meta_box_callback' ],
                    $post_type,
                    $this->config['context'],
                    $this->config['priority']
                );
            }
        }
	}

	public function save_post( $post_id ) {
        $shortcode = '[cpt-comparison-boxes id="'.$post_id.'"]';
        update_post_meta( $post_id, 'cffapt_comparison_shortcode', $shortcode );
	}

	public function add_meta_box_callback() {
		$this->fields_div();
	}

	private function fields_div() {
        global $post;
		foreach ( $this->config['fields'] as $field ) {
			?><div class="components-base-control">
				<div class="components-base-control__field">
                    <code style="width: 100%;display: inline-block;box-sizing: border-box;padding: 14px 0;text-align: center;font-weight: 600;font-size: 15px;"><?php echo $this->value( $field ); ?></code>
                </div>
			</div><?php
		}
	}

	private function label( $field ) {
		switch ( $field['type'] ) {
			default:
				printf(
					'<label class="components-base-control__label" for="%s">%s</label>',
					$field['id'], $field['label']
				);
		}
	}

	private function field( $field ) {
		switch ( $field['type'] ) {
			default:
				$this->input( $field );
		}
	}

	private function input( $field ) {
		printf(
			'<input class="components-text-control__input %s" id="%s" name="%s" %s type="%s" value="%s" readonly>',
			isset( $field['class'] ) ? $field['class'] : '',
			$field['id'], $field['id'],
			isset( $field['pattern'] ) ? "pattern='{$field['pattern']}'" : '',
			$field['type'],
			$this->value( $field )
		);
	}

	private function value( $field ) {
		global $post;
		if ( metadata_exists( 'post', $post->ID, $field['id'] ) ) {
			$value = get_post_meta( $post->ID, $field['id'], true );
		} else if ( isset( $field['default'] ) ) {
			$value = '';
		} else {
			return '';
		}
		return str_replace( '\u0027', "'", $value );
	}

}
new Comparison_Boxes_Shortcode;

/**
 * Retrieving the values:
 * FAQs Shortcode = get_post_meta( get_the_ID(), 'cffapt_faqs_shortcode', true )
 */
class FAQs_Shortcode {
	private $config = '{"title":"FAQs Shortcode","prefix":"cffapt_","domain":"cffapt","class_name":"FAQs_Shortcode","post-type":["post"],"context":"side","priority":"default","fields":[{"type":"text","label":"Shortcode","id":"cffapt_faqs_shortcode"}]}';

	public function __construct() {
		$this->config = json_decode( $this->config, true );
		add_action( 'add_meta_boxes', [ $this, 'add_meta_boxes' ] );
		add_action( 'save_post', [ $this, 'save_post' ] );
	}

	public function add_meta_boxes() {
		$cffapt_settings_options = get_option( 'cffapt_options' );
        $cffapt_post_types = $cffapt_settings_options['cffapt_post_types'];

        if( $cffapt_post_types ) {
            foreach( $cffapt_post_types as $post_type ) {
                add_meta_box(
                    sanitize_title( $this->config['title'] ),
                    $this->config['title'],
                    [ $this, 'add_meta_box_callback' ],
                    $post_type,
                    $this->config['context'],
                    $this->config['priority']
                );
            }
        }
	}

	public function save_post( $post_id ) {
        $shortcode = '[cpt-faqs id="'.$post_id.'"]';
        update_post_meta( $post_id, 'cffapt_faqs_shortcode', $shortcode );
	}

	public function add_meta_box_callback() {
		$this->fields_div();
	}

	private function fields_div() {
        global $post;
		foreach ( $this->config['fields'] as $field ) {
			?><div class="components-base-control">
				<div class="components-base-control__field">
                    <code style="width: 100%;display: inline-block;box-sizing: border-box;padding: 14px 0;text-align: center;font-weight: 600;font-size: 15px;"><?php echo $this->value( $field ); ?></code>
                </div>
			</div><?php
		}
	}

	private function label( $field ) {
		switch ( $field['type'] ) {
			default:
				printf(
					'<label class="components-base-control__label" for="%s">%s</label>',
					$field['id'], $field['label']
				);
		}
	}

	private function field( $field ) {
		switch ( $field['type'] ) {
			default:
				$this->input( $field );
		}
	}

	private function input( $field ) {
		printf(
			'<input class="components-text-control__input %s" id="%s" name="%s" %s type="%s" value="%s" readonly>',
			isset( $field['class'] ) ? $field['class'] : '',
			$field['id'], $field['id'],
			isset( $field['pattern'] ) ? "pattern='{$field['pattern']}'" : '',
			$field['type'],
			$this->value( $field )
		);
	}

	private function value( $field ) {
		global $post;
		if ( metadata_exists( 'post', $post->ID, $field['id'] ) ) {
			$value = get_post_meta( $post->ID, $field['id'], true );
		} else if ( isset( $field['default'] ) ) {
			$value = '';
		} else {
			return '';
		}
		return str_replace( '\u0027', "'", $value );
	}

}
new FAQs_Shortcode;