<section class="ansor_visi_misi">
    <div class="container">
        <h2 class="section_heading"><span>FAQs</span></h2>
        
        <div class="ansor_faq_wrapper">
            <div class="faq_item">
                <button class="faq_trigger">
                    <span>Bagaimana cara mendaftar menjadi anggota GP Ansor Pati?</span>
                    <i class="fa-solid fa-chevron-down"></i>
                </button>
                <div class="faq_panel">
                    <div class="faq_content">
                        <p>Pendaftaran dapat dilakukan secara offline melalui Pimpinan Ranting (tingkat desa) atau Pimpinan Anak Cabang (tingkat kecamatan) setempat di wilayah Kabupaten Pati dengan mengikuti Pelatihan Kader Dasar (PKD) sebagai syarat wajib keanggotaan.</p>
                    </div>
                </div>
            </div>

            <div class="faq_item">
                <button class="faq_trigger">
                    <span>Apa perbedaan antara GP Ansor dan Banser?</span>
                    <i class="fa-solid fa-chevron-down"></i>
                </button>
                <div class="faq_panel">
                    <div class="faq_content">
                        <p>GP Ansor adalah organisasi pemuda otonom di bawah Nahdlatul Ulama. Sedangkan BANSER (Barisan Ansor Serbaguna) merupakan lembaga semi-otonom dari GP Ansor yang bertugas sebagai tenaga inti untuk pengamanan, kemanusiaan, dan bela negara.</p>
                    </div>
                </div>
            </div>

            <div class="faq_item">
                <button class="faq_trigger">
                    <span>Di mana alamat kantor sekretariat PC GP Ansor Kabupaten Pati?</span>
                    <i class="fa-solid fa-chevron-down"></i>
                </button>
                <div class="faq_panel">
                    <div class="faq_content">
                        <p>Kantor Sekretariat Pimpinan Cabang GP Ansor Kabupaten Pati berpusat di kompleks Gedung PCNU Kabupaten Pati, Jalan Dr. Susanto No. 11, Pati, Jawa Tengah.</p>
                    </div>
                </div>
            </div>

            <div class="faq_item">
                <button class="faq_trigger">
                    <span>Apakah kegiatan Majelis Dzikir dan Shalawat Rijalul Ansor terbuka untuk umum?</span>
                    <i class="fa-solid fa-chevron-down"></i>
                </button>
                <div class="faq_panel">
                    <div class="faq_content">
                        <p>Ya, benar. Seluruh kegiatan amaliah keagamaan, zikir, tahlil, dan lantunan shalawat yang diadakan oleh Majelis Dzikir dan Shalawat (MDS) Rijalul Ansor terbuka lebar untuk seluruh pemuda dan masyarakat umum di Kabupaten Pati.</p>
                    </div>
                </div>
            </div>
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