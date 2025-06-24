<header class="header" id="header">
    <div class="container">
        <div class="header-content"> <a href="<?= base_url() ?>" class="logo">
                <div class="logo-icon">
                    <?php if (isset($settings['company_logo']) && !empty($settings['company_logo']['value'])): ?>
                        <img src="<?= base_url('assets/images/uploads/' . $settings['company_logo']['value']) ?>" alt="<?= esc($company_name) ?> Logo" class="logo-image">
                    <?php else: ?>
                        <?= isset($company_logo) ? esc($company_logo) : 'SIS' ?>
                    <?php endif; ?>
                </div>
                <?= isset($company_name) ? esc($company_name) : 'PT. Samsudi Indoniaga Sedaya' ?>
            </a>
            <nav>
                <ul class="nav">
                    <li><a href="<?= base_url() ?>#beranda"><i class="fas fa-home"></i> Beranda</a></li>
                    <li><a href="<?= base_url() ?>#tentang"><i class="fas fa-info-circle"></i> Tentang Kami</a></li>
                    <li><a href="<?= base_url() ?>#layanan"><i class="fas fa-cogs"></i> Layanan</a></li>
                    <li><a href="<?= base_url() ?>#portofolio"><i class="fas fa-briefcase"></i> Portofolio</a></li>
                    <li><a href="<?= base_url() ?>#kontak"><i class="fas fa-envelope"></i> Kontak</a></li>
                </ul>
                <div class="mobile-menu">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </nav>
        </div>
    </div>
</header>