<?php get_header(); ?>

<div class="single_spacer"></div>
<div class="container">
    <div class="page_normal-box">
        <div class="ansor_single-post">
            <div class="single_breadchumb">
                <a href="<?php echo home_url(); ?>" class="bread_url">Home</a>
                <span class="sparator_single">
                    <i class="fa-solid fa-caret-right"></i>
                </span>
                <a href="<?php the_permalink(); ?>" class="bread_url"><?php the_title(); ?></a>
            </div>

            <?php the_title('<h1 class="single-post-title">', '</h1>'); ?>

            <?php if ( has_post_thumbnail() ) { ?>
                <figure class="single_post-thumbnail">
                    <?php the_post_thumbnail( 'full', array(
                        'class'   => 'single_post-thumbnail-img',
                        'loading' => 'eager'
                    )); ?>
                </figure>
            <?php } ?>

            <article id="post-<?php the_ID(); ?>" class="single_post-body">
                <?php the_content(); ?>
            </article>
        </div>
    </div>
</div>

<?php get_footer();