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

        $listHasData = check_list_has_data($cffapt_list_link);

    ?>
        <?php if( $listHasData ): ?>
            <div class="listLinkWrap">
                <ol>
                    <?php foreach( $cffapt_list_link as $listLink ): ?>
                        <li>
                            <a href="<?php echo $listLink['cffapt_link']; ?>" target="_blank" rel="noopener noreferrer nofollow"><?php echo $listLink['cffapt_title']; ?></a>
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

                        <?php if( $productDetail['cffapt_title'] ): ?>
                            <h3><span class="count"><?php echo $i; ?></span> <?php echo $productDetail['cffapt_title']; ?></h3>
                        <?php endif; ?>

                        <div class="contentWrap">
                            <?php echo $productDetail['cffapt_content']; ?>
                        </div>

                        <div class="imgWrap">
                            <a href="<?php echo $productDetail['cffapt_link']; ?>" target="_blank" rel="noopener noreferrer nofollow">
                                <img src="<?php echo $productDetail['cffapt_image']; ?>" alt="<?php echo $productDetail['cffapt_title']; ?>" title="<?php echo $productDetail['cffapt_title']; ?>">
                            </a>

                            <?php $cffapt_rating = $productDetail['cffapt_rating']; ?>
                            <?php if( $cffapt_rating ): ?>
                            <div class="ratingWrap">
                                Our rating:
                                <span class="ratings">
                                    <span class="starActive" style="width: <?php echo ($cffapt_rating/5) * 100; ?>%">
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
                                <span class="ratingCount">(<?php echo $cffapt_rating; ?> / 5)</span>
                            </div>
                            <?php endif; ?>

                            <div class="btnWrap">
                                <a href="<?php echo $productDetail['cffapt_link']; ?>" target="_blank" rel="noopener noreferrer nofollow">Check Price On Amazon <br/><i class="fa fa-arrow-right"></i></a>
                            </div>
                        </div>

                        <div class="proCronWrap">

                            <?php
                                $prosHasData = check_pros_has_data($productDetail['cffapt_pros']);
                                $consHasData = check_cons_has_data($productDetail['cffapt_cons'])
                            ?>

                            <?php if( $prosHasData ): ?>
                                <div class="boxWrap proBox">
                                    <h4>Pros</h4>
                                    <div class="boxContent">
                                        <ul>
                                            <?php foreach( $productDetail['cffapt_pros'] as $pro ): ?>
                                                <li><i class="fa fa-check" style="color:#8bb900"></i> <?php echo $pro['cffapt_pros']; ?></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                </div>
                            <?php endif; ?>

                            
                            <?php if( $consHasData ): ?>
                                <div class="boxWrap conBox">
                                    <h4>Cons</h4>
                                    <div class="boxContent">
                                        <ul>
                                            <?php foreach( $productDetail['cffapt_cons'] as $con ): ?>
                                                <li><i class="fa fa-ban" style="color:#c00"></i> <?php echo $con['cffapt_cons']; ?></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                </div>
                            <?php endif; ?>

                        </div>

                    </div>

                <?php $i++; endforeach; ?>
            </div>
        <?php endif; ?>

    <?php
    return ob_get_clean();

}

function check_list_has_data($listArr) {
    if( $listArr ){
        foreach( $listArr as $list ) {
            if( $list['cffapt_link'] ) {
                return true;
            }
        }
    }

    return false;
}

function check_pros_has_data($pros) {
    if( $pros ){
        foreach( $pros as $pro ) {
            if( $pro['cffapt_pros'] ) {
                return true;
            }
        }
    }

    return false;
}

function check_cons_has_data($cons) {
    if( $cons ){
        foreach( $cons as $con ) {
            if( $con['cffapt_cons'] ) {
                return true;
            }
        }
    }

    return false;
}