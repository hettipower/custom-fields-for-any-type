<?php
/**
 * Retrieving the values:
 * Details Repeater = get_post_meta( get_the_ID(), 'cffapt_details_repeater', true )
 */
class CFFAPT_Post_Meta {
	private $config = '{"title":"Details Repeater","prefix":"cffapt_","domain":"cffapt","class_name":"CFFAPT_Post_Meta","post-type":["post","page"],"context":"normal","priority":"default","cpt":"timer","fields":[{"type":"text","label":"Title","id":"cffapt_title"},{"type":"textarea","label":"Content","id":"cffapt_content"},{"type":"media","label":"Image","return":"url","id":"cffapt_image"},{"type":"number","label":"Rating","max":"5","min":"1","id":"cffapt_rating"},{"type":"url","label":"Link","id":"cffapt_link"},{"type":"text","label":"Pros","id":"cffapt_pros"},{"type":"text","label":"Cons","id":"cffapt_cons"}]}';

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

		$cffapt_settings_options = get_option( 'cffapt_options' );
        $cffapt_post_types = $cffapt_settings_options['cffapt_post_types'];

		if( $cffapt_post_types ) {
			if ( in_array( $typenow, $cffapt_post_types ) ) {
				wp_enqueue_media();
			}
		}
	}

	public function admin_head() {
		global $typenow;

		$cffapt_settings_options = get_option( 'cffapt_options' );
        $cffapt_post_types = $cffapt_settings_options['cffapt_post_types'];

		if( $cffapt_post_types ){
			if ( in_array( $typenow, $cffapt_post_types ) ) {
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
			}
		}
	}

	public function save_post( $post_id ) {

		if ( isset( $_POST['cffapt_details_repeater'] ) ) {
            update_post_meta( $post_id, 'cffapt_details_repeater', $_POST['cffapt_details_repeater'] );
        }
	}

	public function add_meta_box_callback() {
		$this->fields_table();
	}

	private function fields_table() {
		global $post;
	?>
		<div class="repeaterNested repeaterWrap">
			<div data-repeater-list="cffapt_details_repeater">

				<?php 
                    if ( metadata_exists( 'post', $post->ID, 'cffapt_details_repeater' ) ): 
                        $cffapt_details_repeaters = get_post_meta( $post->ID, 'cffapt_details_repeater', true );
                        if( $cffapt_details_repeaters ): 
                            $i=1;
                            foreach( $cffapt_details_repeaters as $cffapt_details_repeater ):
								$cffapt_pros = $cffapt_details_repeater['cffapt_pros'];
								$cffapt_cons = $cffapt_details_repeater['cffapt_cons'];
                ?> 
					<div data-repeater-item class="repeaterItemWrap">
						<div class="fieldsWrap">

							<div class="field">
								<label for="cffapt_title_<?php echo $i; ?>">Title</label>
								<div class="contorl">
									<input class="regular-text" id="cffapt_title_<?php echo $i; ?>" name="cffapt_title" type="text" value="<?php echo $cffapt_details_repeater['cffapt_title']; ?>">
								</div>
							</div>

							<div class="field">
								<label for="cffapt_content_<?php echo $i; ?>">Content</label>
								<div class="contorl">
									<textarea class="regular-text" id="cffapt_content_<?php echo $i; ?>" name="cffapt_content" rows="5"><?php echo $cffapt_details_repeater['cffapt_content']; ?></textarea>
								</div>
							</div>

							<div class="field">
								<label for="cffapt_image_<?php echo $i; ?>">Image</label>
								<div class="contorl">
									<input class="regular-text" id="cffapt_image_<?php echo $i; ?>" name="cffapt_image" type="text" value="<?php echo $cffapt_details_repeater['cffapt_image']; ?>">
									<button class="button rwp-media-toggle" data-modal-button="Select this file" data-modal-title="Choose a file" data-return="url" id="cffapt_image_<?php echo $i; ?>_button" name="cffapt_image_<?php echo $i; ?>_button" type="button">Upload</button>
								</div>
							</div>

							<div class="field">
								<label for="cffapt_rating_<?php echo $i; ?>">Rating</label>
								<div class="contorl">
									<input class="regular-text" id="cffapt_rating_<?php echo $i; ?>" name="cffapt_rating" type="number" value="<?php echo $cffapt_details_repeater['cffapt_rating']; ?>" min="1" max="5" >
								</div>
							</div>

							<div class="field">
								<label for="cffapt_link_<?php echo $i; ?>">Link</label>
								<div class="contorl">
									<input class="regular-text" id="cffapt_link_<?php echo $i; ?>" name="cffapt_link" type="url" value="<?php echo $cffapt_details_repeater['cffapt_link']; ?>">
								</div>
							</div>

							<?php 
								if( $cffapt_pros ): 
									$x=1;
							?>
								<div class="inner-repeater">
									<div data-repeater-list="cffapt_pros">

										<?php foreach( $cffapt_pros as $pro ): ?>
											<div data-repeater-item class="repeaterItemWrap">

												<div class="fieldsWrap">
													<div class="field">
														<label for="cffapt_pros_<?php echo $i; ?>_<?php echo $x; ?>">Pros</label>
														<div class="contorl">
															<input class="regular-text" id="cffapt_pros_<?php echo $i; ?>_<?php echo $x; ?>" name="cffapt_pros" type="text" value="<?php echo $pro['cffapt_pros']; ?>">
														</div>
													</div>
												</div>

												<input data-repeater-delete type="button" value="Delete Pro" class="delete"/>
											</div>
										<?php $x++; endforeach; ?>

									</div>
									<input data-repeater-create type="button" value="Add Pro" class="add"/>
									<div class="clear"></div>
								</div>
							<?php 
								endif;
								if( $cffapt_cons ): 
									$j=1;
							?>
								<div class="inner-repeater">
									<div data-repeater-list="cffapt_cons">

										<?php foreach( $cffapt_cons as $con ): ?>
											<div data-repeater-item class="repeaterItemWrap">

												<div class="fieldsWrap">
													<div class="field">
														<label for="cffapt_cons_<?php echo $i; ?>_<?php echo $j; ?>">Cons</label>
														<div class="contorl">
															<input class="regular-text" id="cffapt_cons_<?php echo $i; ?>_<?php echo $j; ?>" name="cffapt_cons" type="text" value="<?php echo $con['cffapt_cons']; ?>">
														</div>
													</div>
												</div>

												<input data-repeater-delete type="button" value="Delete Con" class="delete"/>
											</div>
										<?php $j++; endforeach; ?>

									</div>
									<input data-repeater-create type="button" value="Add Con" class="add"/>
									<div class="clear"></div>
								</div>

							<?php endif; ?>

						</div>
						<input data-repeater-delete type="button" value="Delete" class="delete" />
					</div>

				<?php $i++; endforeach; endif; else: ?>

					<div data-repeater-item class="repeaterItemWrap">
						<div class="fieldsWrap">

							<?php foreach ( $this->config['fields'] as $field ): ?>

								<?php if( $field['id'] == 'cffapt_pros' ): ?>
									<div class="inner-repeater">
										<div data-repeater-list="cffapt_pros">
											<div data-repeater-item class="repeaterItemWrap">

												<div class="fieldsWrap">
													<div class="field">
														<?php $this->label( $field ); ?>
														<div class="contorl"><?php $this->field( $field ); ?></div>
													</div>
												</div>

												<input data-repeater-delete type="button" value="Delete Pro" class="delete"/>
											</div>
										</div>
										<input data-repeater-create type="button" value="Add Pro" class="add"/>
										<div class="clear"></div>
									</div>
								<?php elseif( $field['id'] == 'cffapt_cons' ): ?>
									<div class="inner-repeater">
										<div data-repeater-list="cffapt_cons">
											<div data-repeater-item class="repeaterItemWrap">

												<div class="fieldsWrap">
													<div class="field">
														<?php $this->label( $field ); ?>
														<div class="contorl"><?php $this->field( $field ); ?></div>
													</div>
												</div>

												<input data-repeater-delete type="button" value="Delete Con" class="delete"/>
											</div>
										</div>
										<input data-repeater-create type="button" value="Add Con" class="add"/>
										<div class="clear"></div>
									</div>
								<?php else: ?>
									<div class="field">
										<?php $this->label( $field ); ?>
										<div class="contorl"><?php $this->field( $field ); ?></div>
									</div>
								<?php endif; ?>

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
			case 'editor':
				echo '<div class="label">' . $field['label'] . '</div>';
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
			case 'textarea':
				$this->textarea( $field );
				break;
			default:
				$this->input( $field );
		}
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
new CFFAPT_Post_Meta;