<?php
/**
 * 
 * Retrieving the values:
 * Menus = get_post_meta( get_the_ID(), 'cffapt_menus', true )
 */
class Simple_Menu_Fields {
	private $config = '{"title":"Simple Menu","prefix":"cffapt_","domain":"cffapt","class_name":"Simple_Menu_Fields","post-type":["page"],"context":"normal","priority":"default","fields":[{"type":"text","label":"Menu","id":"menu_item"},{"type":"text","label":"Link","id":"menu_link"}]}';

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
		if ( isset( $_POST['cffapt_menus'] ) ) {
            update_post_meta( $post_id, 'cffapt_menus', $_POST['cffapt_menus'] );
        }
	}

	public function add_meta_box_callback() {
		$this->fields_table();
	}

	private function fields_table() {
        global $post;
		?>
        
        <div class="repeater repeaterWrap">
            <div data-repeater-list="cffapt_menus">
                <?php 
                    if ( metadata_exists( 'post', $post->ID, 'cffapt_menus' ) ): 
                        $cffapt_menus = get_post_meta( $post->ID, 'cffapt_menus', true );
                        if( $cffapt_menus ): 
                            $i=1;
                            foreach( $cffapt_menus as $menu ):
                ?>  
                    <div data-repeater-item class="repeaterItemWrap">

                        <div class="fieldsWrap">
                            <div class="field">
                                <label for="menu_item_<?php echo $i; ?>">Menu</label>
                                <div class="contorl">
                                    <input class="regular-text" id="menu_item_<?php echo $i; ?>" name="menu_item" type="text" value="<?php echo $menu['menu_item']; ?>">
                                </div>
                            </div>

                            <div class="field">
                                <label for="menu_link_<?php echo $i; ?>">Link</label>
                                <div class="contorl">
                                    <input class="regular-text" id="menu_link_<?php echo $i; ?>" name="menu_link" type="text" value="<?php echo $menu['menu_link']; ?>">
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

new Simple_Menu_Fields;
