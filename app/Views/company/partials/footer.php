<footer class="footer">
    <div class="container">
        <div class="footer-content">
            <div class="footer-section">
                <h3><?= isset($company_name) ? esc($company_name) : 'PT. Samsudi Indoniaga Sedaya' ?></h3>
                <p>Solusi niaga terpercaya untuk kemajuan bisnis Anda di Indonesia.</p>
            </div>
            <div class="footer-section">
                <h3>Navigasi</h3>
                <ul style="list-style: none;">
                    <li><a href="<?= base_url() ?>#beranda"><i class="fas fa-home"></i> Beranda</a></li>
                    <li><a href="<?= base_url() ?>#tentang"><i class="fas fa-info-circle"></i> Tentang Kami</a></li>
                    <li><a href="<?= base_url() ?>#layanan"><i class="fas fa-cogs"></i> Layanan</a></li>
                    <li><a href="<?= base_url() ?>#portofolio"><i class="fas fa-briefcase"></i> Portofolio</a></li>
                    <li><a href="<?= base_url() ?>#kontak"><i class="fas fa-envelope"></i> Kontak</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>Media Sosial</h3>
                <ul style="list-style: none;">
                    <li><a href="#" target="_blank"><i class="fab fa-facebook"></i> Facebook</a></li>
                    <li><a href="#" target="_blank"><i class="fab fa-linkedin"></i> LinkedIn</a></li>
                    <li><a href="#" target="_blank"><i class="fab fa-instagram"></i> Instagram</a></li>
                    <li><a href="#" target="_blank"><i class="fab fa-twitter"></i> Twitter</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; <?= date('Y') ?> <?= isset($company_name) ? esc($company_name) : 'PT. Samsudi Indoniaga Sedaya' ?>. Hak Cipta Dilindungi.</p>
        </div>
    </div>
</footer>