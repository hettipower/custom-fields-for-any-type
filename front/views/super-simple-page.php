<?php /* Template Name: Super Simple Page */ ?>
<?php get_header(); 

$cffapt_menus = get_post_meta( get_the_ID(), 'cffapt_menus', true );
$latest_posts = get_post_meta( get_the_ID(), 'latest_posts', true );
?>

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

<div class="simplePageWrap">
    <?php if( $cffapt_menus ): ?>
    <hr />
        <div class="menuWrap">Menu:
            <?php 
                $i=1;
                foreach( $cffapt_menus as $menu ): 
            ?>
                <a href="<?php echo $menu['menu_link']; ?>"><?php echo $menu['menu_item']; ?></a>
                <?php 
                    if( count($cffapt_menus) != $i ) {
                        echo '|';
                    }
                ?>
            <?php $i++; endforeach; ?>
        </div>
    <hr />
    <?php endif; ?>

    <h1><?php the_title(); ?></h1>
    <?php the_content(); ?>

    <hr />

    <div class="latestPostWrap">
        <p>Latest Posts</p>
        <?php if( $latest_posts ): ?>
            <ul>
                <?php foreach( $latest_posts as $latestPost ): ?>
                    <li>
                        <a href="<?php echo $latestPost['post_link']; ?>"><?php echo $latestPost['title']; ?></a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>

</div>

<?php endwhile; endif; ?>

<?php get_footer();

