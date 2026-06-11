<section class="news ansor-mt-4rem" id="ansor_news">
    <div class="container">
        <h2 class="section_heading">Kabar <span>Ansor</span></h2>
        <?php 
        $news = new WP_Query( array(
            'posts_per_page'    =>  5,
            'post_type'         =>  'post',
            'post_status'       =>  'publish'
        ));

        $i = 0;

        if( $news->have_posts()){ ?>
            <div class="ansor_block">
                <?php while( $i < min( 1, $news->post_count ) && $news->have_posts()){
                    $news->the_post();
                    $i++; ?>
                    <article class="new_first">
                        <div class="asset_mamen">
                            <h2 class="news_heading">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_title(); ?>
                                </a>
                            </h2>
                            <span class="news_date">
                                <i class="fa-solid fa-calendar-days"></i>
                                <?php echo get_the_date(); ?>
                            </span>
                            <?php the_excerpt(); ?>
                            <a href="<?php the_permalink(); ?>" class="hero-btn">Selengkapnya</a>
                        </div>
                        <a href="<?php the_permalink(); ?>" class="news_image">
                            <?php echo gp_ansor_thumbnail( get_the_ID(), 'full', 'lazy', 'news_thumb' ); ?>
                        </a>
                    </article>
                    <?php
                } ?>

                <div class="ansor_grid4">
                    <?php while( $news->have_posts()){
                        $news->the_post();
                        $i++; ?>
                        <article class="ansor_next-news">
                            <a href="<?php the_permalink(); ?>" class="next_news-img">
                                <?php echo gp_ansor_thumbnail( get_the_ID(), 'full', 'lazy', 'news_thumb' ); ?>
                            </a>
                            <div class="nextnews-aset">
                                <h3 class="next_title">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_title(); ?>
                                    </a>
                                </h3>
                                <span class="news_date">
                                    <i class="fa-solid fa-calendar-days"></i>
                                    <?php echo get_the_date(); ?>
                                </span>
                            </div>
                        </article>
                        <?php
                    } ?>
                </div>

                <br><br>
                <center>
                    <a href="<?php echo home_url('berita'); ?>" class="hero-btn">
                        Lihat Semua
                    </a>
                </center>
            </div>
            <?php
        }

        wp_reset_postdata();
        ?>
    </div>
</section>