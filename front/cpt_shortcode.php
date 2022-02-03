<?php
add_shortcode( 'cpt-product-display', 'cffapt_product_display_shortcode_fuc' );
function cffapt_product_display_shortcode_fuc( $atts ) {
    $atts = shortcode_atts( array(
        'id' => '',
    ), $atts, 'cffapt' );

    $postID = $atts['id'];

    if( !$postID ) {
        return false;
    }

    
    $cffapt_list_link = get_post_meta( $postID, 'cffapt_list_link', true );
    $cffapt_details_repeater = get_post_meta( $postID, 'cffapt_details_repeater', true );
    
    ob_start();

    ?>

        <?php if( $cffapt_list_link ): ?>
            <div class="listLinkWrap">
                <ol>
                    <?php foreach( $cffapt_list_link as $listLink ): ?>
                        <li>
                            <a href="<?php echo $listLink['cffapt_link']; ?>" target="_blank" rel="noopener noreferrer"><?php echo $listLink['cffapt_title']; ?></a>
                        </li>
                    <?php endforeach; ?>
                </ol>
            </div>
        <?php endif; ?>

        <?php 
            $i=1;
            if( $cffapt_details_repeater ): 
        ?>
            <div class="productDetailsWrap">
                <?php foreach( $cffapt_details_repeater as $productDetail ): ?>

                    <div class="productDisplay">

                        <h3><span><?php echo $i; ?></span> <?php echo $productDetail['cffapt_title']; ?></h3>

                        <div class="contentWrap">
                            <?php echo $productDetail['cffapt_content']; ?>
                        </div>

                        <div class="imgWrap">
                            <a href="<?php echo $productDetail['cffapt_link']; ?>" target="_blank" rel="noopener noreferrer">
                                <img src="<?php echo $productDetail['cffapt_image']; ?>" alt="">
                            </a>
                            <div class="ratingWrap"></div>
                            <div class="btnWrap">
                                <a href="<?php echo $productDetail['cffapt_link']; ?>" target="_blank" rel="noopener noreferrer">Check Price On Amazon</a>
                            </div>
                        </div>

                        <div class="proCronWrap">

                            <div class="boxWrap proBox">
                                <h4>Pros</h4>
                                <div class="boxContent">
                                    <?php if( $productDetail['cffapt_pros'] ): ?>
                                        <ul>
                                            <?php foreach( $productDetail['cffapt_pros'] as $pro ): ?>
                                                <li><i class="fa fa-check" style="color:#8bb900"></i> <?php echo $pro['cffapt_pros']; ?></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="boxWrap conBox">
                                <h4>Cons</h4>
                                <div class="boxContent">
                                    <?php if( $productDetail['cffapt_cons'] ): ?>
                                        <ul>
                                            <?php foreach( $productDetail['cffapt_cons'] as $con ): ?>
                                                <li><i class="fa fa-ban" style="color:#c00"></i> <?php echo $con['cffapt_cons']; ?></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    <?php endif; ?>
                                </div>
                            </div>

                        </div>

                    </div>

                <?php $i++; endforeach; ?>
            </div>
        <?php endif; ?>

    <?php
    return ob_get_clean();

}