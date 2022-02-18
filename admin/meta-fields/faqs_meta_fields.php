<?php
/**
 * 
 * Retrieving the values:
 * FAQs = get_post_meta( get_the_ID(), 'cffapt_faqs', true )
 */
class CFFAPT_FAQs {
	private $config = '{"title":"FAQs","prefix":"cffapt_","domain":"cffapt","class_name":"CFFAPT_FAQs","post-type":["post"],"context":"normal","priority":"default","fields":[{"type":"text","label":"Question","id":"cffapt_question"},{"type":"textarea","label":"Answer","id":"cffapt_answer"}]}';

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
		if ( isset( $_POST['cffapt_faqs'] ) ) {
            update_post_meta( $post_id, 'cffapt_faqs', $_POST['cffapt_faqs'] );
        }
	}

	public function add_meta_box_callback() {
		$this->fields_table();
	}

	private function fields_table() {
		global $post;
		?>
            <div class="repeater repeaterWrap">
                <div data-repeater-list="cffapt_faqs">
                    <?php 
                        if ( metadata_exists( 'post', $post->ID, 'cffapt_faqs' ) ): 
                            $cffapt_faqs = get_post_meta( $post->ID, 'cffapt_faqs', true );
                            if( $cffapt_faqs ): 
                                $i=1;
                                foreach( $cffapt_faqs as $faq ):
                    ?>  
                        <div data-repeater-item class="repeaterItemWrap">

                            <div class="fieldsWrap">
                                <div class="field">
                                    <label for="cffapt_question_<?php echo $i; ?>">Question</label>
                                    <div class="contorl">
                                        <input class="regular-text" id="cffapt_question_<?php echo $i; ?>" name="cffapt_question" type="text" value="<?php echo $faq['cffapt_question']; ?>">
                                    </div>
                                </div>

                                <div class="field">
                                    <label for="cffapt_answer_<?php echo $i; ?>">Answer</label>
                                    <div class="contorl">
                                        <textarea class="regular-text" id="cffapt_answer_<?php echo $i; ?>" name="cffapt_answer" rows="5"><?php echo $faq['cffapt_answer']; ?></textarea>
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
            </div>
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
			case 'textarea':
				$this->textarea( $field );
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

	private function textarea( $field ) {
		printf(
			'<textarea class="regular-text" id="%s" name="%s" rows="%d">%s</textarea>',
			$field['id'], $field['id'],
			isset( $field['rows'] ) ? $field['rows'] : 5,
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

}
new CFFAPT_FAQs;