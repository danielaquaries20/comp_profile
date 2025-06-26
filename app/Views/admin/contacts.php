<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>

<div class="content-header">
    <h1>Contact Messages</h1>
    <p>Kelola pesan masuk dari website</p>
</div>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success">
        <?= session()->getFlashdata('success') ?>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger">
        <?= session()->getFlashdata('error') ?>
    </div>
<?php endif; ?>

<div class="stats">
    <div class="stat-card">
        <div class="stat-number"><?= count($contacts) ?></div>
        <div>Total Pesan</div>
    </div>
    <div class="stat-card">
        <div class="stat-number"><?= $unread_count ?></div>
        <div>Belum Dibaca</div>
    </div>
    <div class="stat-card">
        <div class="stat-number"><?= count($contacts) - $unread_count ?></div>
        <div>Sudah Dibaca</div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3>Semua Pesan Kontak</h3>
        <div class="header-actions">
            <button class="btn btn-secondary" onclick="markAllAsRead()">
                <i class="fas fa-check-double"></i> Tandai Semua Dibaca
            </button>
            <button class="btn btn-danger" onclick="deleteAllRead()">
                <i class="fas fa-trash"></i> Hapus Yang Sudah Dibaca
            </button>
        </div>
    </div>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <!-- <th>Telepon</th> -->
                    <th>Pesan</th>
                    <th>Investasi</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($contacts)): ?>
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 40px; color: #666;">
                            <i class="fas fa-inbox" style="font-size: 48px; margin-bottom: 15px; opacity: 0.5;"></i>
                            <br>
                            Belum ada pesan kontak masuk.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($contacts as $contact): ?>
                        <tr class="<?= $contact['status'] === 'unread' ? 'unread-row' : '' ?>">
                            <td><?= date('d/m/Y H:i', strtotime($contact['created_at'])) ?></td>
                            <td>
                                <strong><?= esc($contact['nama']) ?></strong>
                                <?php if ($contact['status'] === 'unread'): ?>
                                    <span class="new-badge">NEW</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="mailto:<?= esc($contact['email']) ?>" class="email-link">
                                    <?= esc($contact['email']) ?>
                                </a>
                            </td>
                            <!-- <td>
                                <?php if (!empty($contact['telepon'])): ?>
                                    <a href="tel:<?= esc($contact['telepon']) ?>" class="phone-link">
                                        <?= esc($contact['telepon']) ?>
                                    </a>
                                <?php else: ?>
                                    <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td> -->
                            <td>
                                <div class="message-preview" title="<?= esc($contact['pesan']) ?>">
                                    <?= esc(substr($contact['pesan'], 0, 80)) ?>
                                    <?= strlen($contact['pesan']) > 80 ? '...' : '' ?>
                                </div>
                                <button class="btn-link" onclick="showFullMessage(<?= $contact['id'] ?>)">
                                    <i class="fas fa-expand-alt"></i> Lihat Lengkap
                                </button>
                            </td>
                            <td>
                                Rp<?= number_format($contact['investasi_idr'], 2, ',', '.') ?><br>
                                <span id="jpy-<?= $contact['id'] ?>" class="text-muted small">¥...</span><br>
                                <button class="btn btn-sm btn-outline-primary"
                                    onclick="convertSingleToJPY(<?= $contact['id'] ?>, <?= $contact['investasi_idr'] ?>)">
                                    To Yen
                                </button>
                            </td>
                            <td>
                                <span class="status-badge status-<?= $contact['status'] ?>">
                                    <?= $contact['status'] === 'unread' ? 'Belum Dibaca' : 'Sudah Dibaca' ?>
                                </span>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <?php if ($contact['status'] === 'unread'): ?>
                                        <a href="<?= base_url('admin/mark-read/' . $contact['id']) ?>" class="action-btn btn-read"
                                            title="Tandai sebagai dibaca">
                                            <i class="fas fa-check"></i>
                                        </a>
                                    <?php endif; ?>
                                    <button class="action-btn btn-reply" onclick="replyToContact(<?= $contact['id'] ?>)"
                                        title="Balas">
                                        <i class="fas fa-reply"></i>
                                    </button>
                                    <a href="<?= base_url('admin/delete/' . $contact['id']) ?>" class="action-btn btn-delete"
                                        title="Hapus" onclick="return confirm('Yakin ingin menghapus pesan ini?')">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Message Detail Modal -->
<div id="messageModal" class="modal" style="display: none;">
    <div class="modal-content modal-lg">
        <div class="modal-header">
            <h3>Detail Pesan</h3>
            <button class="modal-close" onclick="closeModal('messageModal')">&times;</button>
        </div>
        <div class="modal-body" id="messageModalBody">
            <!-- Content will be loaded here -->
        </div>
        <div class="modal-footer">
            <button class="btn btn-secondary" onclick="closeModal('messageModal')">Tutup</button>
            <button class="btn btn-primary" onclick="replyFromModal()">
                <i class="fas fa-reply"></i> Balas
            </button>
        </div>
    </div>
</div>

<!-- Reply Modal -->
<div id="replyModal" class="modal" style="display: none;">
    <div class="modal-content modal-lg">
        <div class="modal-header">
            <h3>Balas Pesan</h3>
            <button class="modal-close" onclick="closeModal('replyModal')">&times;</button>
        </div>
        <div class="modal-body">
            <form id="replyForm">
                <div class="form-group">
                    <label for="replyTo">Kepada:</label>
                    <input type="email" id="replyTo" name="replyTo" readonly>
                </div>
                <div class="form-group">
                    <label for="replySubject">Subject:</label>
                    <input type="text" id="replySubject" name="replySubject" required>
                </div>
                <div class="form-group">
                    <label for="replyMessage">Pesan:</label>
                    <textarea id="replyMessage" name="replyMessage" rows="5" required></textarea>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button class="btn btn-secondary" onclick="closeModal('replyModal')">Batal</button>
            <button class="btn btn-primary" onclick="sendReply()">
                <i class="fas fa-paper-plane"></i> Kirim
            </button>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('css') ?>
<style>
    .stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-card {
        background: white;
        padding: 25px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        text-align: center;
    }

    .stat-number {
        font-size: 36px;
        font-weight: bold;
        color: #D80000;
        margin-bottom: 5px;
    }

    .card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .header-actions {
        display: flex;
        gap: 10px;
    }

    .unread-row {
        background: #f8f9fa;
        font-weight: 500;
    }

    .new-badge {
        background: #D80000;
        color: white;
        font-size: 10px;
        padding: 2px 6px;
        border-radius: 10px;
        margin-left: 5px;
    }

    .email-link,
    .phone-link {
        color: #D80000;
        text-decoration: none;
    }

    .email-link:hover,
    .phone-link:hover {
        text-decoration: underline;
    }

    .message-preview {
        margin-bottom: 5px;
        line-height: 1.4;
    }

    .btn-link {
        background: none;
        border: none;
        color: #666;
        cursor: pointer;
        font-size: 12px;
        padding: 0;
    }

    .btn-link:hover {
        color: #D80000;
    }

    .action-buttons {
        display: flex;
        gap: 5px;
    }

    .action-btn {
        padding: 5px 8px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        font-size: 12px;
    }

    .btn-read {
        background: #28a745;
        color: white;
    }

    .btn-reply {
        background: #007bff;
        color: white;
    }

    .btn-delete {
        background: #dc3545;
        color: white;
    }

    .action-btn:hover {
        opacity: 0.8;
        color: white;
        text-decoration: none;
    }

    .status-badge {
        padding: 4px 8px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 500;
    }

    .status-unread {
        background: #ffeaa7;
        color: #d63031;
    }

    .status-read {
        background: #55a3ff;
        color: white;
    }

    .modal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 1000;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .modal-content {
        background: white;
        border-radius: 8px;
        max-height: 90vh;
        overflow-y: auto;
        max-width: 90%;
        width: 500px;
    }

    .modal-lg {
        width: 700px;
    }

    .modal-header {
        padding: 20px;
        border-bottom: 1px solid #ddd;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .modal-body {
        padding: 20px;
    }

    .modal-footer {
        padding: 20px;
        border-top: 1px solid #ddd;
        display: flex;
        justify-content: flex-end;
        gap: 10px;
    }

    .modal-close {
        background: none;
        border: none;
        font-size: 24px;
        cursor: pointer;
        color: #666;
    }

    .modal-close:hover {
        color: #D80000;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
    // function showFullMessage(contactId) {
    //     // Get contact data from PHP (you might want to make an AJAX call here)
    //     const contact = <?= json_encode($contacts) ?>.find(c => c.id == contactId);

    //     if (contact) {
    //         document.getElementById('messageModalBody').innerHTML = `
    //             <div class="contact-detail">
    //                 <h4>${contact.nama}</h4>
    //                 <p><strong>Email:</strong> <a href="mailto:${contact.email}">${contact.email}</a></p>
    //                 ${contact.telepon ? `<p><strong>Telepon:</strong> <a href="tel:${contact.telepon}">${contact.telepon}</a></p>` : ''}
    //                 <p><strong>Tanggal:</strong> ${new Date(contact.created_at).toLocaleString('id-ID')}</p>
    //                 <hr>
    //                 <h5>Pesan:</h5>
    //                 <div class="message-content">${contact.pesan}</div>
    //             </div>
    //         `;
    //         document.getElementById('messageModal').style.display = 'flex';
    //     }
    // }


    async function convertSingleToJPY(contactId, amountIDR) {
        try {
            const response = await fetch(`https://api.exchangerate.host/convert?from=IDR&to=JPY&amount=${amountIDR}&access_key=22d4d67c09ee6844f050bca05cc0d91c`);
            const data = await response.json();

            if (data.success) {
                const jpy = data.result;
                const el = document.getElementById(`jpy-${contactId}`);
                el.textContent = `≈ ¥ ${jpy.toLocaleString('ja-JP', { minimumFractionDigits: 0 })}`;
                el.classList.remove('text-muted');
            } else {
                showNotification('Gagal konversi: ' + data.error?.info || 'Unknown error', 'error');
            }
        } catch (error) {
            console.error('Gagal mengambil data kurs:', error);
            showNotification('Terjadi kesalahan saat mengambil kurs.', 'error');
        }
    }


    // Jalankan saat halaman dimuat
    window.addEventListener('DOMContentLoaded', convertToJPY);

    function showFullMessage(contactId) {
        const contact = <?= json_encode($contacts) ?>.find(c => c.id == contactId);

        if (contact) {
            document.getElementById('messageModalBody').innerHTML = `
            <div class="contact-detail">
                <h4>${contact.nama}</h4>
                <p><strong>Email:</strong> <a href="mailto:${contact.email}">${contact.email}</a></p>
                ${contact.telepon ? `<p><strong>Telepon:</strong> <a href="tel:${contact.telepon}">${contact.telepon}</a></p>` : ''}
                <p><strong>Tanggal:</strong> ${new Date(contact.created_at).toLocaleString('id-ID')}</p>
                <p><strong>Investasi:</strong> Rp ${parseFloat(contact.investasi_idr).toLocaleString('id-ID', { minimumFractionDigits: 2 })}</p>
                <hr>
                <h5>Pesan:</h5>
                <div class="message-content">${contact.pesan}</div>
            </div>
        `;
            document.getElementById('messageModal').style.display = 'flex';
        }
    }


    function replyToContact(contactId) {
        const contact = <?= json_encode($contacts) ?>.find(c => c.id == contactId);

        if (contact) {
            document.getElementById('replyTo').value = contact.email;
            document.getElementById('replySubject').value = `Re: Pesan dari ${contact.nama}`;
            document.getElementById('replyMessage').value = `Halo ${contact.nama},\n\nTerima kasih atas pesan Anda.\n\nSalam,\nPT. Samsudi Indoniaga Sedaya`;
            document.getElementById('replyModal').style.display = 'flex';
        }
    }

    function replyFromModal() {
        const email = document.getElementById('messageModalBody').querySelector('a[href^="mailto:"]').textContent;
        const name = document.getElementById('messageModalBody').querySelector('h4').textContent;

        closeModal('messageModal');

        document.getElementById('replyTo').value = email;
        document.getElementById('replySubject').value = `Re: Pesan dari ${name}`;
        document.getElementById('replyMessage').value = `Halo ${name},\n\nTerima kasih atas pesan Anda.\n\nSalam,\nPT. Samsudi Indoniaga Sedaya`;
        document.getElementById('replyModal').style.display = 'flex';
    }

    function sendReply() {
        const email = document.getElementById('replyTo').value;
        const subject = document.getElementById('replySubject').value;
        const message = document.getElementById('replyMessage').value;

        // Create mailto link
        const mailtoLink = `mailto:${email}?subject=${encodeURIComponent(subject)}&body=${encodeURIComponent(message)}`;
        window.open(mailtoLink);

        closeModal('replyModal');

        // Show success message
        showNotification('Email client dibuka. Silakan kirim pesan melalui aplikasi email Anda.', 'success');
    }

    function closeModal(modalId) {
        document.getElementById(modalId).style.display = 'none';
    }

    function markAllAsRead() {
        if (confirm('Tandai semua pesan sebagai sudah dibaca?')) {
            window.location.href = '<?= base_url('admin/mark-all-read') ?>';
        }
    }

    function deleteAllRead() {
        if (confirm('Hapus semua pesan yang sudah dibaca? Tindakan ini tidak dapat dibatalkan.')) {
            window.location.href = '<?= base_url('admin/delete-all-read') ?>';
        }
    }

    function showNotification(message, type) {
        const alert = document.createElement('div');
        alert.className = `alert alert-${type === 'success' ? 'success' : 'danger'}`;
        alert.textContent = message;
        alert.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 10000;
            min-width: 300px;
            padding: 15px;
            border-radius: 6px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        `;

        document.body.appendChild(alert);

        setTimeout(() => {
            alert.remove();
        }, 4000);
    }

    // Close modal when clicking outside
    window.onclick = function (event) {
        const modals = document.querySelectorAll('.modal');
        modals.forEach(modal => {
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        });
    };
</script>
<?= $this->endSection() ?>