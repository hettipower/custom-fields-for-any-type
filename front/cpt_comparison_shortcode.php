<?php
add_shortcode( 'cpt-comparison-boxes', 'cffapt_comparison_shortcode_fuc' );
function cffapt_comparison_shortcode_fuc( $atts ) {
    $atts = shortcode_atts( array(
        'id' => '',
    ), $atts, 'cffapt' );

    $postID = $atts['id'];

    if( !$postID ) {
        return false;
    }

    $cffapt_box_title = get_post_meta( $postID, 'cffapt_box_title', true );
    $cffapt_box_sub_title = get_post_meta( $postID, 'cffapt_box_sub_title', true );
    
    $cffapt_title_1 = get_post_meta( $postID, 'cffapt_title_1', true );
    $cffapt_image_1 = get_post_meta( $postID, 'cffapt_image_1', true );
    $cffapt_rating_1 = get_post_meta( $postID, 'cffapt_rating_1', true );
    $cffapt_details_1 = get_post_meta( $postID, 'cffapt_details_1', true );
    $cffapt_link_1 = get_post_meta( $postID, 'cffapt_link_1', true );
    $cffapt_activate_box_1 = get_post_meta( $postID, 'cffapt_activate_box_1', true );

    $cffapt_title_2 = get_post_meta( $postID, 'cffapt_title_2', true );
    $cffapt_image_2 = get_post_meta( $postID, 'cffapt_image_2', true );
    $cffapt_rating_2 = get_post_meta( $postID, 'cffapt_rating_2', true );
    $cffapt_details_2 = get_post_meta( $postID, 'cffapt_details_2', true );
    $cffapt_link_2 = get_post_meta( $postID, 'cffapt_link_2', true );
    $cffapt_activate_box_2 = get_post_meta( $postID, 'cffapt_activate_box_2', true );

    $cffapt_title_3 = get_post_meta( $postID, 'cffapt_title_3', true );
    $cffapt_image_3 = get_post_meta( $postID, 'cffapt_image_3', true );
    $cffapt_rating_3 = get_post_meta( $postID, 'cffapt_rating_3', true );
    $cffapt_details_3 = get_post_meta( $postID, 'cffapt_details_3', true );
    $cffapt_link_3 = get_post_meta( $postID, 'cffapt_link_3', true );
    $cffapt_activate_box_3 = get_post_meta( $postID, 'cffapt_activate_box_3', true );
    
    ob_start();

    ?>
        <div class="comparisonBoxesWrap">
            <?php if( $cffapt_box_title ): ?>
                <h2><?php echo $cffapt_box_title; ?></h2>
            <?php endif; ?>
            
            <?php if( $cffapt_box_sub_title ): ?>
                <div class="subtitleWrap"><?php echo $cffapt_box_sub_title; ?></div>
            <?php endif; ?>
            
            <div class="comparisonBoxesInnerWrap">

                <?php if( $cffapt_activate_box_1 ): ?>
                    <div class="comparisonBox">
                        <h4><a href="<?php echo $cffapt_link_1; ?>" target="_blank" rel="noopener noreferrer"><?php echo $cffapt_title_1; ?></a></h4>

                        <div class="imgWrap">
                            <a href="<?php echo $cffapt_link_1; ?>" target="_blank" rel="noopener noreferrer">
                                <img src="<?php echo $cffapt_image_1; ?>" alt="<?php echo $cffapt_title_1; ?>" title="<?php echo $cffapt_title_1; ?>" />
                            </a>
                        </div>

                        <?php if( $cffapt_rating_1 ): ?>
                            <div class="ratingWrap">
                                <span class="ratings">
                                    <span class="starActive" style="width: <?php echo ($cffapt_rating_1/5) * 100; ?>%">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                    </span>
                                    <span class="starInactive">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                    </span>
                                </span>
                            </div>
                        <?php endif; ?>

                        <div class="details"><?php echo $cffapt_details_1; ?></div>
                        <div class="btnWrap">
                            <a href="<?php echo $cffapt_link_1; ?>" target="_blank" rel="noopener noreferrer">Click here for price</a>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if( $cffapt_activate_box_2 ): ?>
                    <div class="comparisonBox">
                        <h4><a href="<?php echo $cffapt_link_2; ?>" target="_blank" rel="noopener noreferrer"><?php echo $cffapt_title_2; ?></a></h4>

                        <div class="imgWrap">
                            <a href="<?php echo $cffapt_link_2; ?>" target="_blank" rel="noopener noreferrer">
                                <img src="<?php echo $cffapt_image_2; ?>" alt="<?php echo $cffapt_title_2; ?>" title="<?php echo $cffapt_title_2; ?>" />
                            </a>
                        </div>

                        <?php if( $cffapt_rating_2 ): ?>
                            <div class="ratingWrap">
                                <span class="ratings">
                                    <span class="starActive" style="width: <?php echo ($cffapt_rating_2/5) * 100; ?>%">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                    </span>
                                    <span class="starInactive">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                    </span>
                                </span>
                            </div>
                        <?php endif; ?>

                        <div class="details"><?php echo $cffapt_details_2; ?></div>
                        <div class="btnWrap">
                            <a href="<?php echo $cffapt_link_2; ?>" target="_blank" rel="noopener noreferrer">Click here for price</a>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if( $cffapt_activate_box_3 ): ?>
                    <div class="comparisonBox">
                        <h4><a href="<?php echo $cffapt_link_3; ?>" target="_blank" rel="noopener noreferrer"><?php echo $cffapt_title_3; ?></a></h4>

                        <div class="imgWrap">
                            <a href="<?php echo $cffapt_link_3; ?>" target="_blank" rel="noopener noreferrer">
                                <img src="<?php echo $cffapt_image_3; ?>" alt="<?php echo $cffapt_title_3; ?>" title="<?php echo $cffapt_title_3; ?>" />
                            </a>
                        </div>

                        <?php if( $cffapt_rating_3 ): ?>
                            <div class="ratingWrap">
                                <span class="ratings">
                                    <span class="starActive" style="width: <?php echo ($cffapt_rating_3/5) * 100; ?>%">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                    </span>
                                    <span class="starInactive">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                    </span>
                                </span>
                            </div>
                        <?php endif; ?>

                        <div class="details"><?php echo $cffapt_details_3; ?></div>
                        <div class="btnWrap">
                            <a href="<?php echo $cffapt_link_3; ?>" target="_blank" rel="noopener noreferrer">Click here for price</a>
                        </div>
                    </div>
                <?php endif; ?>

            </div>

        </div>

    <?php
    return ob_get_clean();

}