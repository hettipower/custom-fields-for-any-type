<?php
add_shortcode( 'cpt-faqs', 'cffapt_faqs_shortcode_fuc' );
function cffapt_faqs_shortcode_fuc( $atts ) {
    $atts = shortcode_atts( array(
        'id' => '',
    ), $atts, 'cffapt' );

    $postID = $atts['id'];

    if( !$postID ) {
        return false;
    }
    
    ob_start();

        $cffapt_faqs = get_post_meta( $postID, 'cffapt_faqs', true );

    ?>  
        <?php if( $cffapt_faqs ): ?>
            <div class="cffapt_shortcodeWrapper">
                <h2>Frequently Asked Questions</h2>
                <div class="faqContentWrap">
                    <?php foreach( $cffapt_faqs as $faq ): ?>
                        <div class="shortcodeItem">
                            <h3><?php echo $faq['cffapt_question']; ?> <i class="fas fa-chevron-down"></i></h3>
                            <div class="shortcodeContent"><?php echo $faq['cffapt_answer']; ?></div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

    <?php
    return ob_get_clean();

}