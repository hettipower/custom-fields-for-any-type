<?php
/**
 * Retrieving the values:
 * Box Title = get_post_meta( get_the_ID(), 'cffapt_box_title', true )
 * Box Sub Title = get_post_meta( get_the_ID(), 'cffapt_box_sub_title', true )
 * Title 1 = get_post_meta( get_the_ID(), 'cffapt_title_1', true )
 * Image 1 = get_post_meta( get_the_ID(), 'cffapt_image_1', true )
 * Rating 1 = get_post_meta( get_the_ID(), 'cffapt_rating_1', true )
 * Details 1 = get_post_meta( get_the_ID(), 'cffapt_details_1', true )
 * Link 1 = get_post_meta( get_the_ID(), 'cffapt_link_1', true )
 * Title 2 = get_post_meta( get_the_ID(), 'cffapt_title_2', true )
 * Image 2 = get_post_meta( get_the_ID(), 'cffapt_image_2', true )
 * Rating 2 = get_post_meta( get_the_ID(), 'cffapt_rating_2', true )
 * Details 2 = get_post_meta( get_the_ID(), 'cffapt_details_2', true )
 * Link 2 = get_post_meta( get_the_ID(), 'cffapt_link_2', true )
 * Title 3 = get_post_meta( get_the_ID(), 'cffapt_title_3', true )
 * Image 3 = get_post_meta( get_the_ID(), 'cffapt_image_3', true )
 * Rating 3 = get_post_meta( get_the_ID(), 'cffapt_rating_3', true )
 * Details 3 = get_post_meta( get_the_ID(), 'cffapt_details_3', true )
 * Link 3 = get_post_meta( get_the_ID(), 'cffapt_link_3', true )
 */
class Comparison_Boxes {
	private $config = '{"title":"Comparison Boxes","description":"","prefix":"cffapt_","domain":"cffapt","class_name":"Comparison_Boxes","post-type":["post"],"context":"normal","priority":"default","fields":[{"type":"text","label":"Box Title","id":"cffapt_box_title"},{"type":"text","label":"Box Sub Title","id":"cffapt_box_sub_title"},{"type":"checkbox","label":"Activate Box 1","checked":"1","id":"cffapt_activate_box_1"},{"type":"text","label":"Title 1","id":"cffapt_title_1"},{"type":"media","label":"Image 1","return":"url","id":"cffapt_image_1"},{"type":"number","label":"Rating 1","max":"5","min":"1","id":"cffapt_rating_1"},{"type":"editor","label":"Details 1","id":"cffapt_details_1"},{"type":"url","label":"Link 1","id":"cffapt_link_1"},{"type":"checkbox","label":"Activate Box 2","checked":"1","id":"cffapt_activate_box_2"},{"type":"text","label":"Title 2","id":"cffapt_title_2"},{"type":"media","label":"Image 2","return":"url","id":"cffapt_image_2"},{"type":"number","label":"Rating 2","max":"5","min":"1","id":"cffapt_rating_2"},{"type":"editor","label":"Details 2","id":"cffapt_details_2"},{"type":"url","label":"Link 2","id":"cffapt_link_2"},{"type":"checkbox","label":"Activate Box 3","checked":"1","id":"cffapt_activate_box_3"},{"type":"text","label":"Title 3","id":"cffapt_title_3"},{"type":"media","label":"Image 3","return":"url","id":"cffapt_image_3"},{"type":"number","label":"Rating 3","max":"5","min":"1","id":"cffapt_rating_3"},{"type":"editor","label":"Details 3","id":"cffapt_details_3"},{"type":"url","label":"Link 3","id":"cffapt_link_3"}]}';

	public function __construct() {
		$this->config = json_decode( $this->config, true );
		add_action( 'add_meta_boxes', [ $this, 'add_meta_boxes' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'admin_enqueue_scripts' ] );
		add_action( 'admin_head', [ $this, 'admin_head' ] );
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

	public function admin_enqueue_scripts() {
		global $typenow;
		if ( in_array( $typenow, $this->config['post-type'] ) ) {
			wp_enqueue_media();
		}
	}

	public function admin_head() {
		global $typenow;
		if ( in_array( $typenow, $this->config['post-type'] ) ) {
			?><script>
				jQuery.noConflict();
				(function($) {
					$(function() {
						$('body').on('click', '.rwp-media-toggle', function(e) {
							e.preventDefault();
							let button = $(this);
							let rwpMediaUploader = null;
							rwpMediaUploader = wp.media({
								title: button.data('modal-title'),
								button: {
									text: button.data('modal-button')
								},
								multiple: true
							}).on('select', function() {
								let attachment = rwpMediaUploader.state().get('selection').first().toJSON();
								button.prev().val(attachment[button.data('return')]);
							}).open();
						});
					});
				})(jQuery);
			</script><?php
			?><?php
		}
	}

	public function save_post( $post_id ) {
		foreach ( $this->config['fields'] as $field ) {
			switch ( $field['type'] ) {
                case 'checkbox':
					update_post_meta( $post_id, $field['id'], isset( $_POST[ $field['id'] ] ) ? $_POST[ $field['id'] ] : '' );
					break;
				case 'editor':
					if ( isset( $_POST[ $field['id'] ] ) ) {
						$sanitized = wp_filter_post_kses( $_POST[ $field['id'] ] );
						update_post_meta( $post_id, $field['id'], $sanitized );
					}
					break;
				case 'url':
					if ( isset( $_POST[ $field['id'] ] ) ) {
						$sanitized = esc_url_raw( $_POST[ $field['id'] ] );
						update_post_meta( $post_id, $field['id'], $sanitized );
					}
					break;
				default:
					if ( isset( $_POST[ $field['id'] ] ) ) {
						$sanitized = sanitize_text_field( $_POST[ $field['id'] ] );
						update_post_meta( $post_id, $field['id'], $sanitized );
					}
			}
		}
	}

	public function add_meta_box_callback() {
		echo '<div class="rwp-description">' . $this->config['description'] . '</div>';
		$this->fields_table();
	}

	private function fields_table() {
		?><table class="form-table" role="presentation">
			<tbody><?php
				foreach ( $this->config['fields'] as $field ) {
					?><tr>
						<th scope="row"><?php $this->label( $field ); ?></th>
						<td><?php $this->field( $field ); ?></td>
					</tr><?php
				}
			?></tbody>
		</table><?php
	}

	private function label( $field ) {
		switch ( $field['type'] ) {
			case 'editor':
				echo '<div class="">' . $field['label'] . '</div>';
				break;
			case 'media':
				printf(
					'<label class="" for="%s_button">%s</label>',
					$field['id'], $field['label']
				);
				break;
			default:
				printf(
					'<label class="" for="%s">%s</label>',
					$field['id'], $field['label']
				);
		}
	}

	private function field( $field ) {
		switch ( $field['type'] ) {
            case 'checkbox':
				$this->checkbox( $field );
				break;
			case 'number':
				$this->input_minmax( $field );
				break;
			case 'editor':
				$this->editor( $field );
				break;
			case 'media':
				$this->input( $field );
				$this->media_button( $field );
				break;
			default:
				$this->input( $field );
		}
	}

    private function checkbox( $field ) {
		printf(
			'<label class="rwp-checkbox-label"><input %s id="%s" name="%s" type="checkbox"> %s</label>',
			$this->checked( $field ),
			$field['id'], $field['id'],
			isset( $field['description'] ) ? $field['description'] : ''
		);
	}

	private function editor( $field ) {
		wp_editor( $this->value( $field ), $field['id'], [
			'wpautop' => isset( $field['wpautop'] ) ? true : false,
			'media_buttons' => isset( $field['media-buttons'] ) ? true : false,
			'textarea_name' => $field['id'],
			'textarea_rows' => isset( $field['rows'] ) ? isset( $field['rows'] ) : 20,
			'teeny' => isset( $field['teeny'] ) ? true : false
		] );
	}

	private function input( $field ) {
		if ( $field['type'] === 'media' ) {
			$field['type'] = 'text';
		}
		printf(
			'<input class="regular-text %s" id="%s" name="%s" %s type="%s" value="%s">',
			isset( $field['class'] ) ? $field['class'] : '',
			$field['id'], $field['id'],
			isset( $field['pattern'] ) ? "pattern='{$field['pattern']}'" : '',
			$field['type'],
			$this->value( $field )
		);
	}

	private function input_minmax( $field ) {
		printf(
			'<input class="regular-text" id="%s" %s %s name="%s" %s type="%s" value="%s">',
			$field['id'],
			isset( $field['max'] ) ? "max='{$field['max']}'" : '',
			isset( $field['min'] ) ? "min='{$field['min']}'" : '',
			$field['id'],
			isset( $field['step'] ) ? "step='{$field['step']}'" : '',
			$field['type'],
			$this->value( $field )
		);
	}

	private function media_button( $field ) {
		printf(
			' <button class="button rwp-media-toggle" data-modal-button="%s" data-modal-title="%s" data-return="%s" id="%s_button" name="%s_button" type="button">%s</button>',
			isset( $field['modal-button'] ) ? $field['modal-button'] : __( 'Select this file', 'cffapt' ),
			isset( $field['modal-title'] ) ? $field['modal-title'] : __( 'Choose a file', 'cffapt' ),
			$field['return'],
			$field['id'], $field['id'],
			isset( $field['button-text'] ) ? $field['button-text'] : __( 'Upload', 'cffapt' )
		);
	}

	private function value( $field ) {
		global $post;
		if ( metadata_exists( 'post', $post->ID, $field['id'] ) ) {
			$value = get_post_meta( $post->ID, $field['id'], true );
		} else if ( isset( $field['default'] ) ) {
			$value = $field['default'];
		} else {
			return '';
		}
		return str_replace( '\u0027', "'", $value );
	}

    private function checked( $field ) {
		global $post;
		if ( metadata_exists( 'post', $post->ID, $field['id'] ) ) {
			$value = get_post_meta( $post->ID, $field['id'], true );
			if ( $value === 'on' ) {
				return 'checked';
			}
			return '';
		} else if ( isset( $field['checked'] ) ) {
			return 'checked';
		}
		return '';
	}

}
new Comparison_Boxes;