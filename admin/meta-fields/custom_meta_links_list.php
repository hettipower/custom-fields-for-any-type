<?php
/**
 * Retrieving the values:
 * List Links = get_post_meta( get_the_ID(), 'cffapt_list_link', true )
 * Links Settings = get_post_meta( get_the_ID(), 'cffapt_link_settings', true )
 */
class CFFAPT_Link_List {
	private $configCustomFields = '{"title":"Link List Repeater","prefix":"cffapt_","domain":"cffapt","class_name":"CFFAPT_Link_List","post-type":["page"],"context":"normal","priority":"default","fields":[{"type":"select","label":"Link Settings","options":"off : Off\r\ninternal_links : Internal Links\r\nexternal_links : External Links","id":"cffapt_link_settings"}]}';
    private $config = '{"title":"Link List Repeater","prefix":"cffapt_","domain":"cffapt","class_name":"CFFAPT_Link_List","post-type":["page"],"context":"normal","priority":"default","fields":[{"type":"text","label":"Title","id":"cffapt_title"},{"type":"url","label":"Link","id":"cffapt_link"}]}';

	public function __construct() {
		$this->config = json_decode( $this->config, true );
        $this->configCustomFields = json_decode( $this->configCustomFields, true );
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

        if ( isset( $_POST['list_link'] ) ) {
            update_post_meta( $post_id, 'cffapt_list_link', $_POST['list_link'] );
        }

        foreach ( $this->configCustomFields['fields'] as $field ) {
			switch ( $field['type'] ) {
                case 'checkbox':
					update_post_meta( $post_id, $field['id'], isset( $_POST[ $field['id'] ] ) ? $_POST[ $field['id'] ] : '' );
					break;
				default:
					if ( isset( $_POST[ $field['id'] ] ) ) {
						$sanitized = sanitize_text_field( $_POST[ $field['id'] ] );
						update_post_meta( $post_id, $field['id'], $sanitized );
					}
					break;
			}
		}

	}

	public function add_meta_box_callback() {
		$this->fields_table();
	}

	private function fields_table() {
        global $post;
	?>
        <table class="form-table" role="presentation">
			<tbody><?php
				foreach ( $this->configCustomFields['fields'] as $field ) {
					?><tr>
						<th scope="row"><?php $this->label( $field ); ?></th>
						<td><?php $this->field( $field ); ?></td>
					</tr><?php
				}
			?></tbody>
		</table>
        <!-- <div class="repeater repeaterWrap">
            <div data-repeater-list="list_link">
                <?php 
                    if ( metadata_exists( 'post', $post->ID, 'cffapt_list_link' ) ): 
                        $cffapt_list_links = get_post_meta( $post->ID, 'cffapt_list_link', true );
                        if( $cffapt_list_links ): 
                            $i=1;
                            foreach( $cffapt_list_links as $cffapt_list_link ):
                ?>  
                    <div data-repeater-item class="repeaterItemWrap">

                        <div class="fieldsWrap">
                            <div class="field">
                                <label for="cffapt_title_<?php echo $i; ?>">Title</label>
                                <div class="contorl">
                                    <input class="regular-text" id="cffapt_title_<?php echo $i; ?>" name="cffapt_title" type="text" value="<?php echo $cffapt_list_link['cffapt_title']; ?>">
                                </div>
                            </div>

                            <div class="field">
                                <label for="cffapt_link_<?php echo $i; ?>">Link</label>
                                <div class="contorl">
                                    <input class="regular-text" id="cffapt_link_<?php echo $i; ?>" name="cffapt_link" type="url" value="<?php echo $cffapt_list_link['cffapt_link']; ?>">
                                </div>
                            </div>
                        </div>

                        <input data-repeater-delete type="button" value="Delete" class="delete"/>
                    </div>
                    <?php $i++; endforeach; endif; ?>
                <?php else: ?>
                    <div data-repeater-item class="repeaterItemWrap">
                        <div class="fieldsWrap">
                            <?php foreach ( $this->config['fields'] as $field ): ?>
                                <div class="field">
                                    <?php $this->label( $field ); ?>
                                    <div class="contorl"><?php $this->field( $field ); ?></div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <input data-repeater-delete type="button" value="Delete" class="delete" />
                    </div>
                <?php endif; ?>
            </div>
            <input data-repeater-create type="button" value="Add" class="add"/>
            <div class="clear"></div>
        </div> -->
        <?php
	}

	private function label( $field ) {
		switch ( $field['type'] ) {
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
			case 'select':
				$this->select( $field );
				break;
			default:
				$this->input( $field );
		}
	}

	private function input( $field ) {
		printf(
			'<input class="regular-text %s" id="%s" name="%s" %s type="%s" value="%s">',
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
			$value = $field['default'];
		} else {
			return '';
		}
		return str_replace( '\u0027', "'", $value );
	}

    private function checkbox( $field ) {
		printf(
			'<label class="rwp-checkbox-label"><input %s id="%s" name="%s" type="checkbox"> %s</label>',
			$this->checked( $field ),
			$field['id'], $field['id'],
			isset( $field['description'] ) ? $field['description'] : ''
		);
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

	private function select( $field ) {
		printf(
			'<select id="%s" name="%s">%s</select>',
			$field['id'], $field['id'],
			$this->select_options( $field )
		);
	}

	private function select_selected( $field, $current ) {
		$value = $this->value( $field );
		if ( $value === $current ) {
			return 'selected';
		}
		return '';
	}

	private function select_options( $field ) {
		$output = [];
		$options = explode( "\r\n", $field['options'] );
		$i = 0;
		foreach ( $options as $option ) {
			$pair = explode( ':', $option );
			$pair = array_map( 'trim', $pair );
			$output[] = sprintf(
				'<option %s value="%s"> %s</option>',
				$this->select_selected( $field, $pair[0] ),
				$pair[0], $pair[1]
			);
			$i++;
		}
		return implode( '<br>', $output );
	}

}
new CFFAPT_Link_List;