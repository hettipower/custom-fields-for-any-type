<?php
/**
 * 
 * Retrieving the values:
 * Latest Posts = get_post_meta( get_the_ID(), 'latest_posts', true )
 */
class Simple_Posts_Fields {
	private $config = '{"title":"Latest Posts","prefix":"cffapt_","domain":"cffapt","class_name":"Simple_Posts_Fields","post-type":["page"],"context":"normal","priority":"default","fields":[{"type":"text","label":"Title","id":"title"},{"type":"text","label":"Link","id":"post_link"}]}';

	public function __construct() {
		$this->config = json_decode( $this->config, true );
        
		add_action( 'add_meta_boxes', [ $this, 'add_meta_boxes' ] );
		add_action( 'save_post', [ $this, 'save_post' ] );
	}

	public function add_meta_boxes() {

        global $post;
        $user_selected_template = get_page_template_slug($post->ID);

        if( $user_selected_template != 'super-simple-page.php' ) {
            return false;
        }

		foreach ( $this->config['post-type'] as $screen ) {
			add_meta_box(
				sanitize_title( $this->config['title'] ),
				$this->config['title'],
				[ $this, 'add_meta_box_callback' ],
				$screen,
				$this->config['context'],
				$this->config['priority']
			);
		}
	}

	public function save_post( $post_id ) {
		if ( isset( $_POST['latest_posts'] ) ) {
            update_post_meta( $post_id, 'latest_posts', $_POST['latest_posts'] );
        }
	}

	public function add_meta_box_callback() {
		$this->fields_table();
	}

	private function fields_table() {
        global $post;
		?>
        
        <div class="repeater repeaterWrap">
            <div data-repeater-list="latest_posts">
                <?php 
                    if ( metadata_exists( 'post', $post->ID, 'latest_posts' ) ): 
                        $latest_posts = get_post_meta( $post->ID, 'latest_posts', true );
                        if( $latest_posts ): 
                            $i=1;
                            foreach( $latest_posts as $latestPost ):
                ?>  
                    <div data-repeater-item class="repeaterItemWrap">

                        <div class="fieldsWrap">
                            <div class="field">
                                <label for="title_<?php echo $i; ?>">Title</label>
                                <div class="contorl">
                                    <input class="regular-text" id="title_<?php echo $i; ?>" name="title" type="text" value="<?php echo $latestPost['title']; ?>">
                                </div>
                            </div>

                            <div class="field">
                                <label for="post_link_<?php echo $i; ?>">Link</label>
                                <div class="contorl">
                                    <input class="regular-text" id="post_link_<?php echo $i; ?>" name="post_link" type="text" value="<?php echo $latestPost['post_link']; ?>">
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

}

new Simple_Posts_Fields;
