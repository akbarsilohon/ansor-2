<?php get_header(); ?>

<section class="news ansor-mt-4rem">
    <div class="container">
        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); 
            $post_id = get_the_ID();
            $gallery_images = get_post_meta($post_id, '_ansor_galeri_images', true);
        ?>
            <article id="galeri-single-<?php the_ID(); ?>" class="ansor_single_galeri_wrapper">
                <header class="galeri_single_header">
                    <span class="galeri_single_meta">
                        <i class="fa-solid fa-calendar-days"></i> <?php echo get_the_date('d F Y'); ?>
                    </span>
                    <h1 class="galeri_single_title"><?php the_title(); ?></h1>
                    <div class="galeri_single_excerpt">
                        <?php the_excerpt(); ?>
                    </div>
                </header>

                <div class="galeri_single_content">
                    <?php the_content(); ?>
                </div>

                <?php if ( ! empty($gallery_images) && is_array($gallery_images) ) : ?>
                    <div class="ansor_masonry_gallery">
                        <?php foreach ( $gallery_images as $image_id ) : 
                            $img_full = wp_get_attachment_image_src($image_id, 'full');
                            $img_thumb = wp_get_attachment_image_src($image_id, 'medium_large');
                            if ( $img_full && $img_thumb ) : ?>
                                <div class="masonry_gallery_item">
                                    <a href="<?php echo esc_url($img_full[0]); ?>" class="ansor_lightbox_trigger">
                                        <img src="<?php echo esc_url($img_thumb[0]); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy">
                                        <div class="masonry_item_overlay">
                                            <i class="fa-solid fa-magnifying-glass-plus"></i>
                                        </div>
                                    </a>
                                </div>
                            <?php endif; 
                        endforeach; ?>
                    </div>
                <?php endif; ?>
            </article>
        <?php endwhile; endif; ?>
    </div>
</section>

<div id="ansor_lightbox_modal" class="ansor_lightbox_modal" aria-hidden="true">
    <span class="lightbox_close">&times;</span>
    <button class="lightbox_nav prev" aria-label="Previous image">&#10094;</button>
    <button class="lightbox_nav next" aria-label="Next image">&#10095;</button>
    <div class="lightbox_content_wrapper">
        <img class="lightbox_main_img" id="lightbox_main_img" src="" alt="Lightbox View">
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const triggers = document.querySelectorAll('.ansor_lightbox_trigger');
        const modal = document.getElementById('ansor_lightbox_modal');
        const mainImg = document.getElementById('lightbox_main_img');
        const closeBtn = document.querySelector('.lightbox_close');
        const prevBtn = document.querySelector('.lightbox_nav.prev');
        const nextBtn = document.querySelector('.lightbox_nav.next');
        
        if (!modal || triggers.length === 0) return;

        let currentIndex = 0;
        const imagesArray = Array.from(triggers).map(trigger => trigger.getAttribute('href'));

        function openLightbox(index) {
            currentIndex = index;
            mainImg.src = imagesArray[currentIndex];
            modal.classList.add('show');
            document.body.style.overflow = 'hidden';
        }

        function closeLightbox() {
            modal.classList.remove('show');
            mainImg.src = '';
            document.body.style.overflow = '';
        }

        function showNext() {
            currentIndex = (currentIndex + 1) % imagesArray.length;
            mainImg.src = imagesArray[currentIndex];
        }

        function showPrev() {
            currentIndex = (currentIndex - 1 + imagesArray.length) % imagesArray.length;
            mainImg.src = imagesArray[currentIndex];
        }

        triggers.forEach((trigger, index) => {
            trigger.addEventListener('click', function (e) {
                e.preventDefault();
                openLightbox(index);
            });
        });

        closeBtn.addEventListener('click', closeLightbox);
        nextBtn.addEventListener('click', showNext);
        prevBtn.addEventListener('click', showPrev);

        modal.addEventListener('click', function (e) {
            if (e.target === modal || e.target.classList.contains('lightbox_content_wrapper')) {
                closeLightbox();
            }
        });

        document.addEventListener('keydown', function (e) {
            if (!modal.classList.contains('show')) return;
            if (e.key === 'Escape') closeLightbox();
            if (e.key === 'ArrowRight') showNext();
            if (e.key === 'ArrowLeft') showPrev();
        });
    });
</script>

<?php get_footer();