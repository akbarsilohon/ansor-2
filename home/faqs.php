<?php
$option = get_option('gp_ansor', []);
$faqs_items = $option['faqs_items'] ?? [];
?>

<section class="ansor_visi_misi">
    <div class="container">
        <h2 class="section_heading"><span>FAQs</span></h2>
        <div class="ansor_faq_wrapper">
            <?php 
            if ( ! empty( $faqs_items ) && is_array( $faqs_items ) ) : 
                foreach ( $faqs_items as $faq ) : 
                    $question = $faq['q'] ?? '';
                    $answer   = $faq['a'] ?? '';
                    if ( empty( $question ) || empty( $answer ) ) continue; 
            ?>
                <div class="faq_item">
                    <button class="faq_trigger">
                        <span><?php echo esc_html( $question ); ?></span>
                        <i class="fa-solid fa-chevron-down"></i>
                    </button>
                    <div class="faq_panel">
                        <div class="faq_content">
                            <p><?php echo nl2br( esc_html( $answer ) ); ?></p>
                        </div>
                    </div>
                </div>
            <?php 
                endforeach; 
            else :
                ?>
                <div class="faq_item">
                    <button class="faq_trigger" style="cursor: default;">
                        <span>Belum ada data FAQs tentang <?php bloginfo( 'name' ); ?>.</span>
                    </button>
                </div>
                <?php 
            endif; 
            ?>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const triggers = document.querySelectorAll('.faq_trigger');

        triggers.forEach(trigger => {
            trigger.addEventListener('click', function () {
                const currentItem = this.parentElement;
                const panel = this.nextElementSibling;
                const isActive = currentItem.classList.contains('active');

                document.querySelectorAll('.faq_item').forEach(item => {
                    item.classList.remove('active');
                    item.querySelector('.faq_panel').style.maxHeight = null;
                });

                if (!isActive) {
                    currentItem.classList.add('active');
                    panel.style.maxHeight = panel.scrollHeight + "px";
                }
            });
        });
    });
</script>