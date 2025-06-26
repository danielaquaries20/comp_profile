<?= $this->extend('admin/layout') ?>

<?= $this->section('css') ?>
<style>
    /* Modal Styles */
    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(2px);
    }

    .modal-content {
        background-color: #fff;
        margin: 5% auto;
        border: none;
        border-radius: 12px;
        width: 90%;
        max-width: 600px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        animation: modalFadeIn 0.3s ease-out;
    }

    @keyframes modalFadeIn {
        from {
            opacity: 0;
            transform: translateY(-50px) scale(0.9);
        }

        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    .modal-header {
        padding: 20px 25px 0;
        border-bottom: none;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .modal-header h3 {
        margin: 0;
        color: #333;
        font-size: 1.4rem;
    }

    .close {
        color: #aaa;
        font-size: 24px;
        font-weight: bold;
        cursor: pointer;
        background: none;
        border: none;
        padding: 0;
        line-height: 1;
        transition: color 0.3s ease;
    }

    .close:hover {
        color: #333;
    }

    .modal-body {
        padding: 20px 25px;
    }

    .modal-footer {
        padding: 0 25px 25px;
        display: flex;
        justify-content: flex-end;
        gap: 10px;
    }

    /* Confirmation Modal Styles */
    .confirm-modal .modal-content {
        max-width: 400px;
        text-align: center;
    }

    .confirm-icon {
        font-size: 3rem;
        color: #f39c12;
        margin-bottom: 15px;
    }

    .confirm-title {
        font-size: 1.3rem;
        font-weight: 600;
        color: #333;
        margin-bottom: 10px;
    }

    .confirm-message {
        color: #666;
        margin-bottom: 25px;
        line-height: 1.5;
    }

    /* Partner Logo Preview */
    .logo-preview {
        max-width: 100px;
        max-height: 60px;
        object-fit: contain;
        border: 1px solid #ddd;
        border-radius: 4px;
        padding: 5px;
    }

    .logo-placeholder {
        width: 100px;
        height: 60px;
        background: #f8f9fa;
        border: 2px dashed #ddd;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 4px;
        color: #999;
        font-size: 12px;
        text-align: center;
    }

    /* File upload styling */
    .file-upload-wrapper {
        position: relative;
        display: inline-block;
        cursor: pointer;
    }

    .file-upload-input {
        position: absolute;
        opacity: 0;
        width: 100%;
        height: 100%;
        cursor: pointer;
    }

    .file-upload-label {
        display: inline-block;
        padding: 8px 16px;
        background: #007bff;
        color: white;
        border-radius: 4px;
        cursor: pointer;
        transition: background 0.3s;
    }

    .file-upload-label:hover {
        background: #0056b3;
    }

    /* Button styles */
    .btn-confirm {
        background: #dc3545;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 6px;
        cursor: pointer;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-confirm:hover {
        background: #c82333;
        transform: translateY(-1px);
    }

    .btn-cancel {
        background: #6c757d;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 6px;
        cursor: pointer;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-cancel:hover {
        background: #545b62;
        transform: translateY(-1px);
    }

    /* Ensure buttons are clickable */
    .action-btn {
        padding: 5px 10px;
        margin: 2px;
        border: none;
        border-radius: 3px;
        cursor: pointer;
        font-size: 12px;
        text-decoration: none;
        display: inline-block;
        transition: opacity 0.3s;
        position: relative;
        z-index: 1;
    }

    .action-btn:hover {
        opacity: 0.8;
    }

    .btn-edit {
        background: #007bff;
        color: white;
    }

    .btn-delete {
        background: #dc3545;
        color: white;
    }

    .btn:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }

    .btn-primary {
        background: #D80000;
        color: white;
        border: none;
        padding: 10px 15px;
        border-radius: 5px;
        cursor: pointer;
        font-weight: 500;
        position: relative;
        z-index: 1;
    }

    .btn-primary:hover {
        background: #c70000;
    }

    .btn-secondary {
        background: #6c757d;
        color: white;
        border: none;
        padding: 10px 15px;
        border-radius: 5px;
        cursor: pointer;
        font-weight: 500;
    }

    .btn-secondary:hover {
        background: #545b62;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="content-header">
    <h1>Partners Management</h1>
    <p>Kelola mitra dan partner yang ditampilkan di website</p>
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

<div class="card">
    <div class="card-header">
        <h3>Daftar Partner</h3>
        <button type="button" class="btn btn-primary" onclick="showAddModal()">Tambah Partner</button>
    </div>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>Logo</th>
                    <th>Nama Partner</th>
                    <th>Website</th>
                    <th>Deskripsi</th>
                    <th>Urutan</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody id="partnersTable">
                <?php if (empty($partners)): ?>
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 40px; color: #666;">
                            Belum ada partner. <a href="#" onclick="showAddModal()">Tambah partner pertama</a>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($partners as $partner): ?>
                        <tr data-id="<?= $partner['id'] ?>">
                            <td style="text-align: center;">
                                <?php if (!empty($partner['logo'])): ?>
                                    <img src="<?= base_url('assets/images/uploads/' . $partner['logo']) ?>"
                                        alt="<?= esc($partner['name']) ?>" class="logo-preview">
                                <?php else: ?>
                                    <div class="logo-placeholder">No Logo</div>
                                <?php endif; ?>
                            </td>
                            <td><?= esc($partner['name']) ?></td>
                            <td>
                                <?php if (!empty($partner['website_url'])): ?>
                                    <a href="<?= esc($partner['website_url']) ?>" target="_blank" rel="noopener">
                                        <i class="fas fa-external-link-alt"></i> Website
                                    </a>
                                <?php else: ?>
                                    <span style="color: #999;">-</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if (!empty($partner['description'])): ?>
                                    <div class="description-preview" title="<?= esc($partner['description']) ?>">
                                        <?= esc(substr($partner['description'], 0, 60)) ?><?= strlen($partner['description']) > 60 ? '...' : '' ?>
                                    </div>
                                <?php else: ?>
                                    <span style="color: #999;">-</span>
                                <?php endif; ?>
                            </td>
                            <td><?= $partner['sort_order'] ?></td>
                            <td>
                                <span class="status-badge status-<?= $partner['is_active'] ? 'active' : 'inactive' ?>">
                                    <?= $partner['is_active'] ? 'Aktif' : 'Tidak Aktif' ?>
                                </span>
                            </td>
                            <td>
                                <button type="button" class="action-btn btn-edit" onclick="editPartner(<?= $partner['id'] ?>)" title="Edit Partner">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <button type="button" class="action-btn btn-delete" onclick="confirmDeletePartner(<?= $partner['id'] ?>, '<?= addslashes($partner['name']) ?>')" title="Hapus Partner">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Partner Modal -->
<div id="partnerModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 id="modalTitle">Tambah Partner</h3>
            <span class="close" onclick="closeModal()">&times;</span>
        </div>
        <div class="modal-body">
            <form id="partnerForm">
                <input type="hidden" id="partnerId" name="id">

                <div class="form-group">
                    <label for="partnerName">Nama Partner</label>
                    <input type="text" id="partnerName" name="name" required maxlength="100">
                </div>

                <div class="form-group">
                    <label for="partnerLogo">Logo Partner</label>
                    <div id="logoPreview" style="margin-bottom: 10px;"></div>
                    <div class="file-upload-wrapper">
                        <input type="file" id="partnerLogo" name="logo" class="file-upload-input" accept="image/*" onchange="previewLogo(this)">
                        <label for="partnerLogo" class="file-upload-label">
                            <i class="fas fa-upload"></i> Pilih Logo
                        </label>
                    </div>
                    <small style="color: #666; font-size: 12px; display: block; margin-top: 5px;">
                        Format: JPG, PNG, GIF. Maksimal 2MB. Rekomendasi ukuran: 200x120px
                    </small>
                </div>

                <div class="form-group">
                    <label for="partnerWebsite">Website URL</label>
                    <input type="url" id="partnerWebsite" name="website_url" placeholder="https://example.com" maxlength="255">
                </div>

                <div class="form-group">
                    <label for="partnerDescription">Deskripsi</label>
                    <textarea id="partnerDescription" name="description" rows="3" maxlength="1000" placeholder="Deskripsi singkat tentang partner..."></textarea>
                </div>

                <div class="form-group">
                    <label for="partnerSortOrder">Urutan Tampil</label>
                    <input type="number" id="partnerSortOrder" name="sort_order" min="0" value="0">
                </div>

                <div class="form-group">
                    <label>
                        <input type="checkbox" id="partnerIsActive" name="is_active" value="1" checked>
                        Aktif (tampilkan di website)
                    </label>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" onclick="closeModal()">Batal</button>
            <button type="button" class="btn btn-primary" onclick="savePartner()">Simpan</button>
        </div>
    </div>
</div>

<!-- Confirmation Modal -->
<div id="confirmModal" class="modal confirm-modal">
    <div class="modal-content">
        <div class="modal-body">
            <div class="confirm-icon">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <div class="confirm-title" id="confirmTitle">Konfirmasi Hapus</div>
            <div class="confirm-message" id="confirmMessage">
                Apakah Anda yakin ingin menghapus partner ini?
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn-cancel" onclick="closeConfirmModal()">Batal</button>
            <button type="button" class="btn-confirm" id="confirmButton" onclick="executeDelete()">Hapus</button>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
    // Wait for DOM to be ready
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM ready, Partner Management loaded');

        // Test button click events
        const addButton = document.querySelector('.btn-primary');
        if (addButton) {
            console.log('Add button found');
        }

        const editButtons = document.querySelectorAll('.btn-edit');
        console.log('Edit buttons found:', editButtons.length);

        const deleteButtons = document.querySelectorAll('.btn-delete');
        console.log('Delete buttons found:', deleteButtons.length);
    });
    let currentPartnerId = null;
    let deletePartnerId = null;

    // Modal functions
    function showAddModal() {
        console.log('showAddModal called');
        document.getElementById('modalTitle').textContent = 'Tambah Partner';
        document.getElementById('partnerForm').reset();
        document.getElementById('partnerId').value = '';
        document.getElementById('logoPreview').innerHTML = '';
        currentPartnerId = null;
        document.getElementById('partnerModal').style.display = 'block';
    }

    function editPartner(id) {
        console.log('editPartner called with id:', id);
        fetch(`<?= base_url('api/partners') ?>/${id}`)
            .then(response => response.json())
            .then(data => {
                console.log('Edit partner response:', data);
                if (data.status === 'success') {
                    const partner = data.data;
                    document.getElementById('modalTitle').textContent = 'Edit Partner';
                    document.getElementById('partnerId').value = partner.id;
                    document.getElementById('partnerName').value = partner.name;
                    document.getElementById('partnerWebsite').value = partner.website_url || '';
                    document.getElementById('partnerDescription').value = partner.description || '';
                    document.getElementById('partnerSortOrder').value = partner.sort_order;
                    document.getElementById('partnerIsActive').checked = partner.is_active == 1;

                    // Show logo preview if exists
                    const logoPreview = document.getElementById('logoPreview');
                    if (partner.logo) {
                        logoPreview.innerHTML = `<img src="<?= base_url('assets/images/uploads') ?>/${partner.logo}" alt="Current Logo" class="logo-preview">`;
                    } else {
                        logoPreview.innerHTML = '';
                    }

                    currentPartnerId = id;
                    document.getElementById('partnerModal').style.display = 'block';
                } else {
                    showNotification('Error: ' + data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Gagal memuat data partner', 'error');
            });
    }

    function closeModal() {
        document.getElementById('partnerModal').style.display = 'none';
        currentPartnerId = null;
    }

    function confirmDeletePartner(id, name) {
        console.log('confirmDeletePartner called with id:', id, 'name:', name);
        deletePartnerId = id;
        document.getElementById('confirmMessage').textContent =
            `Yakin ingin menghapus partner "${name}"? Tindakan ini tidak dapat dibatalkan.`;
        document.getElementById('confirmModal').style.display = 'block';
    }

    function closeConfirmModal() {
        document.getElementById('confirmModal').style.display = 'none';
        deletePartnerId = null;
    }

    function executeDelete() {
        if (!deletePartnerId) return;

        fetch(`<?= base_url('api/partners') ?>/${deletePartnerId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                }
            })
            .then(response => response.json())
            .then(data => {
                closeConfirmModal();
                if (data.status === 'success') {
                    showNotification('Partner berhasil dihapus', 'success');
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                } else {
                    showNotification('Error: ' + data.message, 'error');
                }
            })
            .catch(error => {
                closeConfirmModal();
                console.error('Error:', error);
                showNotification('Gagal menghapus partner', 'error');
            });
    }

    function previewLogo(input) {
        const preview = document.getElementById('logoPreview');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.innerHTML = `<img src="${e.target.result}" alt="Logo Preview" class="logo-preview">`;
            }
            reader.readAsDataURL(input.files[0]);
        } else {
            preview.innerHTML = '';
        }
    }
    async function savePartner() {
        console.log('savePartner called');
        const form = document.getElementById('partnerForm');
        const formData = new FormData();

        // Add form fields
        formData.append('name', document.getElementById('partnerName').value);
        formData.append('website_url', document.getElementById('partnerWebsite').value);
        formData.append('description', document.getElementById('partnerDescription').value);
        formData.append('sort_order', document.getElementById('partnerSortOrder').value);
        formData.append('is_active', document.getElementById('partnerIsActive').checked ? 1 : 0);

        // Handle logo upload if file is selected
        const logoFile = document.getElementById('partnerLogo').files[0];
        let logoFileName = null;
        if (logoFile) {
            // Upload logo first
            const uploadData = new FormData();
            uploadData.append('image', logoFile);

            try {
                const uploadResponse = await fetch('<?= base_url('upload/image') ?>', {
                    method: 'POST',
                    body: uploadData
                });
                const uploadResult = await uploadResponse.json();

                if (uploadResult.status === 'success') {
                    logoFileName = uploadResult.data.filename;
                } else {
                    showNotification('Gagal upload logo: ' + uploadResult.message, 'error');
                    return;
                }
            } catch (error) {
                showNotification('Gagal upload logo', 'error');
                return;
            }
        }

        // Prepare partner data
        const partnerData = {
            name: document.getElementById('partnerName').value,
            website_url: document.getElementById('partnerWebsite').value,
            description: document.getElementById('partnerDescription').value,
            sort_order: parseInt(document.getElementById('partnerSortOrder').value),
            is_active: document.getElementById('partnerIsActive').checked ? 1 : 0
        };
        if (logoFileName) {
            partnerData.logo = logoFileName;
        }

        // Save partner
        const url = currentPartnerId ? `<?= base_url('api/partners') ?>/${currentPartnerId}` : '<?= base_url('api/partners') ?>/';
        const method = currentPartnerId ? 'PUT' : 'POST';

        fetch(url, {
                method: method,
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(partnerData)
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    closeModal();
                    showNotification(currentPartnerId ? 'Partner berhasil diupdate' : 'Partner berhasil ditambahkan', 'success');
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                } else {
                    showNotification('Error: ' + data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Gagal menyimpan partner', 'error');
            });
    }

    // Close modal when clicking outside
    window.onclick = function(event) {
        const partnerModal = document.getElementById('partnerModal');
        const confirmModal = document.getElementById('confirmModal');

        if (event.target === partnerModal) {
            closeModal();
        }
        if (event.target === confirmModal) {
            closeConfirmModal();
        }
    }

    // Notification function
    function showNotification(message, type) {
        // Create notification element
        const notification = document.createElement('div');
        notification.className = `alert alert-${type === 'success' ? 'success' : 'danger'}`;
        notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 10000;
        min-width: 300px;
        padding: 15px;
        border-radius: 6px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        animation: slideInRight 0.3s ease-out;
    `;
        notification.textContent = message;

        document.body.appendChild(notification);

        // Auto remove after 3 seconds
        setTimeout(() => {
            notification.style.animation = 'slideOutRight 0.3s ease-in';
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.parentNode.removeChild(notification);
                }
            }, 300);
        }, 3000);
    }

    // Add CSS for animations
    const style = document.createElement('style');
    style.textContent = `
    @keyframes slideInRight {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    @keyframes slideOutRight {
        from { transform: translateX(0); opacity: 1; }
        to { transform: translateX(100%); opacity: 0; }
    }
`;
    document.head.appendChild(style);
</script>
<?= $this->endSection() ?>