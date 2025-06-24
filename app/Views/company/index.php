<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<!-- Hero Section -->
<section class="hero" id="beranda" <?php if (isset($settings['hero_background_image']) && !empty($settings['hero_background_image']['value'])): ?>
    style="background-image: linear-gradient(rgba(40, 40, 40, 0.8), rgba(40, 40, 40, 0.8)), url('<?= base_url('assets/images/uploads/' . $settings['hero_background_image']['value']) ?>');"
    <?php endif; ?>>
    <div class="container">
        <div class="hero-content">
            <h1><span class="highlight"><?= esc($company_tagline) ?></span></h1>
            <p><?= esc($company_description) ?></p>
            <a href="#tentang" class="cta-button">Pelajari Lebih Lanjut</a>
        </div>
    </div>
</section>

<!-- About Section -->
<section class="section" id="tentang">
    <div class="container">
        <div class="section-title">
            <h2>Tentang Kami</h2>
            <p>Mengenal lebih dekat visi, misi, dan komitmen kami dalam memberikan layanan terbaik</p>
        </div>
        <div class="about-content">
            <div class="about-text">
                <h3>Visi & Misi Perusahaan</h3>
                <p><strong>Visi:</strong> <?= esc($company_vision) ?></p>
                <p><strong>Misi:</strong> <?= esc($company_mission) ?></p>
                <p>Dengan pengalaman bertahun-tahun di industri perdagangan, kami berkomitmen untuk terus berinovasi dan memberikan nilai terbaik bagi seluruh stakeholder.</p>
            </div>
            <div class="about-image">
                <?php if (isset($settings['about_image']) && !empty($settings['about_image']['value'])): ?>
                    <img src="<?= base_url('assets/images/uploads/' . $settings['about_image']['value']) ?>" alt="About <?= esc($company_name) ?>">
                <?php else: ?>
                    <span>Ilustrasi Perusahaan</span>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<!-- Services Section -->
<section class="section services" id="layanan">
    <div class="container">
        <div class="section-title">
            <h2>Layanan Kami</h2>
            <p>Berbagai layanan unggulan yang kami tawarkan untuk mendukung kebutuhan bisnis Anda</p>
        </div>
        <div class="services-grid">
            <?php if (!empty($services)): ?>
                <?php foreach ($services as $service): ?> <div class="service-card">
                        <div class="service-icon">
                            <i class="<?= esc($service['icon']) ?>"></i>
                        </div>
                        <h3><?= esc($service['title']) ?></h3>
                        <p><?= esc($service['description']) ?></p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <!-- Default services if none in database -->
                <div class="service-card">
                    <div class="service-icon">📊</div>
                    <h3>Konsultasi Bisnis</h3>
                    <p>Memberikan konsultasi strategis untuk mengoptimalkan kinerja bisnis dan mencapai target yang diinginkan.</p>
                </div>
                <div class="service-card">
                    <div class="service-icon">🤝</div>
                    <h3>Kemitraan Strategis</h3>
                    <p>Membangun jaringan kemitraan yang kuat untuk memperluas jangkauan bisnis dan peluang pasar.</p>
                </div>
                <div class="service-card">
                    <div class="service-icon">🚚</div>
                    <h3>Distribusi & Logistik</h3>
                    <p>Layanan distribusi dan logistik yang efisien untuk memastikan produk sampai tepat waktu dan kondisi prima.</p>
                </div>
                <div class="service-card">
                    <div class="service-icon">📈</div>
                    <h3>Analisis Pasar</h3>
                    <p>Analisis mendalam tentang tren pasar dan peluang bisnis untuk pengambilan keputusan yang tepat.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Portfolio Section -->
<section class="section" id="portofolio">
    <div class="container">
        <div class="section-title">
            <h2>Mitra & Klien</h2>
            <p>Berbagai perusahaan terkemuka yang telah mempercayakan kemitraan bisnis dengan kami</p>
        </div>
        <div class="portfolio-carousel">
            <?php if (!empty($partners)): ?>
                <?php foreach ($partners as $partner): ?>
                    <div class="portfolio-item">
                        <?php if (!empty($partner['logo'])): ?>
                            <img src="<?= base_url('assets/images/uploads/' . $partner['logo']) ?>"
                                alt="<?= esc($partner['name']) ?>"
                                class="partner-logo">
                        <?php endif; ?>
                        <div class="partner-info">
                            <h4><?= esc($partner['name']) ?></h4>
                            <?php if (!empty($partner['description'])): ?>
                                <p><?= esc($partner['description']) ?></p>
                            <?php endif; ?>
                            <?php if (!empty($partner['website_url'])): ?>
                                <a href="<?= esc($partner['website_url']) ?>" target="_blank" rel="noopener" class="partner-link">
                                    <i class="fas fa-external-link-alt"></i> Kunjungi Website
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <!-- Default partners if none in database -->
                <div class="portfolio-item">
                    <div class="partner-info">
                        <h4>PT. Teknologi Masa Depan</h4>
                        <p>Partner teknologi terdepan dalam solusi digital</p>
                    </div>
                </div>
                <div class="portfolio-item">
                    <div class="partner-info">
                        <h4>CV. Mitra Sukses Bersama</h4>
                        <p>Kemitraan strategis dalam bidang perdagangan</p>
                    </div>
                </div>
                <div class="portfolio-item">
                    <div class="partner-info">
                        <h4>PT. Global Niaga Indonesia</h4>
                        <p>Partner distribusi dengan jangkauan nasional</p>
                    </div>
                </div>
                <div class="portfolio-item">
                    <div class="partner-info">
                        <h4>PT. Inovasi Digital Nusantara</h4>
                        <p>Solusi inovasi digital untuk transformasi bisnis</p>
                    </div>
                </div>
                <div class="portfolio-item">
                    <div class="partner-info">
                        <h4>CV. Sinergi Bisnis Mandiri</h4>
                        <p>Kemitraan bisnis yang saling menguntungkan</p>
                    </div>
                </div>
                <div class="portfolio-item">
                    <div class="partner-info">
                        <h4>PT. Konsultan Profesional</h4>
                        <p>Layanan konsultasi bisnis dan manajemen</p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Map Section -->
<section class="section map-section">
    <div class="container">
        <div class="section-title">
            <h2>Lokasi Perusahaan</h2>
            <p>Temukan lokasi kantor kami untuk kunjungan atau pertemuan bisnis</p>
        </div>
        <div class="map-container">
            <div id="map"></div>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section class="section" id="kontak">
    <div class="container">
        <div class="section-title">
            <h2>Kontak Kami</h2>
            <p>Hubungi kami untuk informasi lebih lanjut atau diskusi kemitraan bisnis</p>
        </div>
        <div class="contact-content">
            <div class="contact-form">
                <h3>Kirim Pesan</h3>
                <form action="<?= base_url('contact/submit') ?>" method="post" novalidate id="contactForm">
                    <?= csrf_field() ?>
                    <div class="form-group">
                        <label for="nama">Nama Lengkap</label>
                        <input type="text" id="nama" name="nama" value="<?= old('nama') ?>" autocomplete="name">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" id="email" name="email" value="<?= old('email') ?>" autocomplete="email">
                    </div>
                    <div class="form-group">
                        <label for="pesan">Pesan</label>
                        <textarea id="pesan" name="pesan" rows="5"><?= old('pesan') ?></textarea>
                    </div>
                    <button type="button" class="submit-btn" id="submitBtn">Kirim Pesan</button>
                </form>
            </div>
            <div class="contact-info">
                <h3>Informasi Kontak</h3>
                <div class="contact-item">
                    <strong>Alamat:</strong>
                    <?= $contact_info['address'] ?>
                </div>
                <div class="contact-item">
                    <strong>Telepon:</strong>
                    <?= esc($contact_info['phone']) ?>
                </div>
                <div class="contact-item">
                    <strong>Email:</strong>
                    <?= esc($contact_info['email']) ?>
                </div>
                <div class="contact-item">
                    <strong>Jam Operasional:</strong>
                    <?= $contact_info['hours'] ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
    console.log('JavaScript loaded');

    // Notification system
    <?php if (session()->getFlashdata('success')): ?>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Success notification triggered');
            showNotification('success', 'Berhasil!', '<?= addslashes(session()->getFlashdata('success')) ?>');
        });
    <?php endif; ?>

    <?php if (session()->getFlashdata('errors')): ?>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Error notification triggered');
            let errors = <?= json_encode(array_values(session()->getFlashdata('errors'))) ?>;
            let errorMessage = errors.join('<br>');
            showNotification('error', 'Terjadi Kesalahan!', errorMessage);
        });
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Single error notification triggered');
            showNotification('error', 'Terjadi Kesalahan!', '<?= addslashes(session()->getFlashdata('error')) ?>');
        });
    <?php endif; ?>

    function showNotification(type, title, message) {
        console.log('showNotification called:', type, title, message);

        // Create notification overlay
        const overlay = document.createElement('div');
        overlay.className = 'notification-overlay';

        // Create notification box
        const box = document.createElement('div');
        box.className = `notification-box ${type}`;

        // Icon based on type
        const iconClass = type === 'success' ? 'fas fa-check' : 'fas fa-exclamation-triangle';

        box.innerHTML = `
            <button class="notification-close" onclick="closeNotification(this)">&times;</button>
            <div class="notification-icon">
                <i class="${iconClass}"></i>
            </div>
            <h3>${title}</h3>
            <p>${message}</p>
            <button class="notification-btn ${type}" onclick="closeNotification(this)">OK</button>
        `;

        overlay.appendChild(box);
        document.body.appendChild(overlay);

        console.log('Notification box added to DOM');

        // Auto close after 5 seconds
        setTimeout(() => {
            if (overlay.parentNode) {
                closeNotification(overlay);
            }
        }, 5000);
    }

    function closeNotification(element) {
        console.log('closeNotification called');
        const overlay = element.closest('.notification-overlay') || element;
        if (overlay) {
            overlay.style.animation = 'fadeOut 0.3s ease-in-out';
            setTimeout(() => {
                if (overlay.parentNode) {
                    overlay.parentNode.removeChild(overlay);
                }
            }, 300);
        }
    } // Form validation
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM loaded, setting up form validation');

        const contactForm = document.getElementById('contactForm');
        const submitBtn = document.getElementById('submitBtn');

        if (contactForm) {
            console.log('Contact form found');

            // Completely disable browser validation
            contactForm.setAttribute('novalidate', 'true');
            contactForm.noValidate = true;

            // Remove any validation attributes from inputs
            const inputs = contactForm.querySelectorAll('input, textarea');
            inputs.forEach(input => {
                input.removeAttribute('required');
                input.removeAttribute('pattern');
                input.removeAttribute('minlength');
                input.removeAttribute('maxlength');
                input.removeAttribute('min');
                input.removeAttribute('max');

                // Override browser validation
                input.addEventListener('invalid', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    return false;
                });
            });

            // Override form submit completely
            contactForm.onsubmit = function(e) {
                e.preventDefault();
                e.stopPropagation();
                e.stopImmediatePropagation();

                console.log('Form submit intercepted via onsubmit');

                validateAndSubmit();
                return false;
            };

            // Also add event listener as backup
            contactForm.addEventListener('submit', function(e) {
                e.preventDefault();
                e.stopPropagation();
                e.stopImmediatePropagation();

                console.log('Form submit intercepted via addEventListener');

                validateAndSubmit();
                return false;
            }, true); // Use capture phase

            // Prevent button click from triggering browser validation
            submitBtn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();

                console.log('Submit button clicked');

                validateAndSubmit();
                return false;
            });
        }

        function validateAndSubmit() {
            console.log('validateAndSubmit called');

            // Get form values
            const nama = document.getElementById('nama').value.trim();
            const email = document.getElementById('email').value.trim();
            const pesan = document.getElementById('pesan').value.trim();

            console.log('Form data:', {
                nama,
                email,
                pesan
            });

            // Validation rules
            const errors = [];

            if (nama.length === 0) {
                errors.push('Nama tidak boleh kosong');
            } else if (nama.length < 3) {
                errors.push('Nama harus minimal 3 karakter');
            }

            if (email.length === 0) {
                errors.push('Email tidak boleh kosong');
            } else if (!isValidEmail(email)) {
                errors.push('Format email tidak valid');
            }

            if (pesan.length === 0) {
                errors.push('Pesan tidak boleh kosong');
            } else if (pesan.length < 10) {
                errors.push('Pesan harus minimal 10 karakter');
            }

            console.log('Validation errors:', errors);

            // Show errors or submit form
            if (errors.length > 0) {
                showNotification('error', 'Terjadi Kesalahan!', errors.join('<br>'));
            } else {
                console.log('Validation passed, submitting form...');
                const submitBtn = document.getElementById('submitBtn');
                submitBtn.disabled = true;
                submitBtn.textContent = 'Mengirim...';

                setTimeout(() => {
                    submitFormManually();
                }, 100);
            }
        }

        function submitFormManually() {
            console.log('submitFormManually called');
            const form = document.getElementById('contactForm');

            // Create a new form element to avoid all event listeners
            const newForm = document.createElement('form');
            newForm.method = 'POST';
            newForm.action = form.action;
            newForm.style.display = 'none';

            // Copy all form data
            const formData = new FormData(form);
            for (let [key, value] of formData.entries()) {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = key;
                input.value = value;
                newForm.appendChild(input);
            }

            // Submit the new form
            document.body.appendChild(newForm);
            console.log('Submitting form manually...');
            newForm.submit();
        }
    });

    function isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    // Initialize Mapbox map
    mapboxgl.accessToken = '<?= $mapbox_token ?>';

    const map = new mapboxgl.Map({
        container: 'map',
        style: 'mapbox://styles/mapbox/streets-v12',
        center: [<?= $contact_info['coordinates']['lng'] ?>, <?= $contact_info['coordinates']['lat'] ?>], // longitude, latitude
        zoom: 15
    });

    // Add marker for company location
    const marker = new mapboxgl.Marker({
            color: '#D80000'
        })
        .setLngLat([<?= $contact_info['coordinates']['lng'] ?>, <?= $contact_info['coordinates']['lat'] ?>])
        .setPopup(new mapboxgl.Popup({
                offset: 25
            })
            .setHTML('<h3><?= esc($company_name) ?></h3><p>Lokasi Perusahaan</p>'))
        .addTo(map);

    // Add navigation controls
    map.addControl(new mapboxgl.NavigationControl());
</script>
<?= $this->endSection() ?>