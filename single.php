<?php get_header();

ansor_pati_value_post_popular( get_the_ID());

?>

<div class="single_spacer"></div>
<div class="container">
    <div class="ansor_sidebar-used">
        <div class="ansor_single-post">
            <div class="single_breadchumb">
                <a href="<?php echo home_url(); ?>" class="bread_url">Home</a>
                <span class="sparator_single">
                    <i class="fa-solid fa-caret-right"></i>
                </span>
                <a href="<?php echo home_url('berita'); ?>" class="bread_url">Index News</a>
                <span class="sparator_single">
                    <i class="fa-solid fa-caret-right"></i>
                </span>
                <?php echo ansor_cat_html_support('bread_url'); ?>
            </div>

            <?php the_title('<h1 class="single-post-title">', '</h1>'); ?>

            <div class="nm-meta">
                <span>
                    <i class="far fa-user"></i>
                    <span class="nm-lbl-oleh">Oleh </span>
                    <strong>
                        <?php $ids = get_post_field( 'post_author', get_the_ID()); ?>
                        <a href="<?php echo get_author_posts_url( $ids ); ?>">
                            <span><?php echo get_the_author_meta( 'display_name', $ids ); ?></span>
                        </a>
                    </strong>
                </span> 
                <span>•</span>
                <span>
                    <i class="far fa-calendar"></i> 
                    <time class="nm-dt-long"><?php echo get_the_date(); ?></time>
                </span> 
                <span>•</span>
                <span style="color: var(--accent); font-weight: bold;">
                    <i class="far fa-clock"></i>
                    <span class="nm-lbl-menit"><?php echo ansor_estimasi_waktu_baca(); ?></span> 
                </span>
            </div>
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

            <?php 
            $post_tags = get_the_tags(); 
            if ( ! empty( $post_tags ) ) : ?>
                <div class="nm-tags-box">
                    <?php foreach ( $post_tags as $tag ) : ?>
                        <a href="<?php echo esc_url( get_tag_link( $tag->term_id ) ); ?>" class="nm-tag-item">
                            <?php echo esc_html( $tag->name ); ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <div class="nm-credits">
                <div class="nm-share-left">
                    <?php $option = get_option('gp_ansor', []); ?>
                    <a href="<?php echo esc_url($option['google_link'] ?? '#'); ?>" target="_blank" class="btn-gn" aria-label="Ikuti di Google News">
                        <img src="https://muhammadiyah.or.id/wp-content/uploads/2026/01/icon_google_news-e1768095691586.png" alt="GNews">
                    </a>
                </div>
                <div class="nm-share-sep"></div>
                <div class="nm-share-right">
                    <div class="nm-share-icon-lbl">
                        <i class="fas fa-share-alt"></i>
                    </div>
                    
                    <?php 
                    $share_url   = urlencode(get_permalink());
                    $share_title = urlencode(get_the_title());
                    ?>
                    <a href="https://api.whatsapp.com/send?text=<?php echo $share_title; ?>%20-%20<?php echo $share_url; ?>" target="_blank" class="nm-share-btn btn-wa" aria-label="Bagikan ke WhatsApp">
                        <i class="fab fa-whatsapp"></i>
                        <span>WhatsApp</span>
                    </a>
                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $share_url; ?>" target="_blank" class="nm-share-btn btn-fb" aria-label="Bagikan ke Facebook">
                        <i class="fab fa-facebook-f"></i>
                        <span>Facebook</span>
                    </a>
                    <a href="https://twitter.com/intent/tweet?text=<?php echo $share_title; ?>&url=<?php echo $share_url; ?>" target="_blank" class="nm-share-btn btn-tw" aria-label="Bagikan ke Twitter">
                        <i class="fab fa-twitter"></i>
                        <span>Twitter</span>
                    </a>
                    <a href="https://t.me/share/url?url=<?php echo $share_url; ?>&text=<?php echo $share_title; ?>" target="_blank" class="nm-share-btn btn-tg" aria-label="Bagikan ke Telegram">
                        <i class="fab fa-telegram-plane"></i>
                        <span>Telegram</span>
                    </a>
                    <button onclick="copyToClipboard('<?php echo get_permalink(); ?>', this)" class="nm-share-btn btn-cp" aria-label="Salin Tautan">
                        <i class="fas fa-link"></i>
                        <span>Salin</span>
                    </button>
                </div>
            </div>

            <script>
                function copyToClipboard(text, element) {
                    navigator.clipboard.writeText(text).then(function() {
                        const textSpan = element.querySelector('span');
                        const originalText = textSpan.textContent;
                        textSpan.textContent = 'Tersalin!';
                        element.style.background = '#0f172a';
                        element.style.borderColor = '#0f172a';
                        
                        setTimeout(function() {
                            textSpan.textContent = originalText;
                            element.style.background = '';
                            element.style.borderColor = '';
                        }, 2000);
                    });
                }
            </script>

            
            <?php 
            // Related posts if Exists ======================
            $post_id = get_the_ID();
            $tags = wp_get_post_tags($post_id);
            $categories = wp_get_post_categories($post_id);

            $args = array(
                'post_type'      => 'post',
                'post_status'    => 'publish',
                'posts_per_page' => 6,
                'post__not_in'   => array($post_id),
                'category__in'   => $categories,
                'orderby'        => 'post__in',
            );

            $related = new WP_Query($args);

            if( $related->have_posts()){ ?>
                <div class="nm-related-sec">
                    <h3 class="nm-sec-head">Baca Juga</h3>
                    <div class="nm-rel-grid">
                        <?php while( $related->have_posts()){
                            $related->the_post(); ?>
                                <div class="nm-rel-card">
                                    <div class="nm-rel-thumb">
                                        <a href="<?php the_permalink(); ?>">
                                            <?php echo gp_ansor_thumbnail( get_the_ID(), 'full', 'lazy', 'related_imag-thumb'); ?>
                                        </a>
                                    </div>
                                    <h4 class="nm-rel-title">
                                        <a href="<?php the_permalink(); ?>">
                                            <?php the_title(); ?>
                                        </a>
                                    </h4>
                                </div>
                            <?php
                        } ?>
                    </div>
                </div>
                <?php
            }

            wp_reset_postdata();
            ?>
        </div>
        <?php get_sidebar(); ?>
    </div>
</div>

<?php get_footer();