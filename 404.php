<?php get_header(); ?>

<style>
.error_404_section {
    padding: 8rem 0 6rem 0;
    min-height: 75vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(120deg, rgba(46, 204, 113, 0.08), rgba(255, 255, 255, 0.9));
    text-align: center;
}

.error_container {
    max-width: 600px;
    margin: 0 auto;
    padding: 0 20px;
}

.error_code {
    font-family: 'Yeseva One', serif;
    font-size: 8rem;
    line-height: 1;
    color: var(--accent);
    margin-bottom: 1rem;
    letter-spacing: -0.05em;
    animation: pulseError 3s ease-in-out infinite;
}

.error_title {
    font-family: 'Yeseva One', serif;
    font-size: 2.5rem;
    color: var(--contrast);
    margin-bottom: 1.25rem;
    line-height: 1.2;
}

.error_text {
    font-size: 1.125rem;
    color: var(--base-2);
    margin-bottom: 2.5rem;
    line-height: 1.7;
}

.error_btn {
    display: inline-block;
    background-color: var(--accent);
    color: #ffffff;
    padding: 14px 36px;
    border-radius: 10px;
    font-size: 15px;
    font-weight: 600;
    transition: background-color 0.3s ease, transform 0.2s ease, box-shadow 0.3s ease;
    box-shadow: 0 4px 15px rgba(5, 102, 71, 0.2);
}

.error_btn:hover {
    background-color: var(--contrast);
    color: #ffffff;
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(15, 23, 42, 0.2);
}

@keyframes pulseError {
    0% { transform: scale(1); opacity: 0.9; }
    50% { transform: scale(1.03); opacity: 1; }
    100% { transform: scale(1); opacity: 0.9; }
}

@media (max-width: 580px) {
    .error_404_section {
        padding: 10rem 0 4rem 0;
    }
    .error_code {
        font-size: 6rem;
    }
    .error_title {
        font-size: 1.8rem;
    }
    .error_text {
        font-size: 1rem;
        margin-bottom: 2rem;
    }
    .error_btn {
        padding: 12px 28px;
        font-size: 14px;
    }
}
</style>

<section class="error_404_section">
    <div class="error_container">
        <div class="error_code">404</div>
        <h1 class="error_title">Halaman Tidak Ditemukan</h1>
        <p class="error_text">Maaf, halaman yang Anda cari tidak ada atau telah dipindahkan. Silakan kembali ke halaman utama untuk menemukan informasi yang Anda butuhkan.</p>
        <a href="<?php echo esc_url(home_url('/')); ?>" class="error_btn">Kembali ke Beranda</a>
    </div>
</section>

<?php get_footer(); ?>