<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>

<div class="content-header">
    <h1>Company Settings</h1>
    <p>Kelola informasi perusahaan dan konten website</p>
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

<div class="settings-container">
    <form id="settingsForm">
        <?= csrf_field() ?>

        <!-- Company Information Section -->
        <div class="settings-section">
            <h3>Informasi Perusahaan</h3>
            <div class="form-grid">
                <div class="form-group">
                    <label for="company_name">Nama Perusahaan</label>
                    <input type="text" id="company_name" name="company_name"
                        value="<?= isset($settings['company_name']) ? esc($settings['company_name']['value']) : '' ?>">
                </div>

                <div class="form-group">
                    <label for="company_tagline">Tagline</label>
                    <input type="text" id="company_tagline" name="company_tagline"
                        value="<?= isset($settings['company_tagline']) ? esc($settings['company_tagline']['value']) : '' ?>">
                </div>

                <div class="form-group full-width">
                    <label for="company_description">Deskripsi Perusahaan</label>
                    <textarea id="company_description" name="company_description" rows="3"><?= isset($settings['company_description']) ? esc($settings['company_description']['value']) : '' ?></textarea>
                </div>

                <div class="form-group full-width">
                    <label for="company_vision">Visi</label>
                    <textarea id="company_vision" name="company_vision" rows="3"><?= isset($settings['company_vision']) ? esc($settings['company_vision']['value']) : '' ?></textarea>
                </div>

                <div class="form-group full-width">
                    <label for="company_mission">Misi</label>
                    <textarea id="company_mission" name="company_mission" rows="3"><?= isset($settings['company_mission']) ? esc($settings['company_mission']['value']) : '' ?></textarea>
                </div>
            </div>
        </div>

        <!-- Contact Information Section -->
        <div class="settings-section">
            <h3>Informasi Kontak</h3>
            <div class="form-grid">
                <div class="form-group full-width">
                    <label for="contact_address">Alamat</label>
                    <textarea id="contact_address" name="contact_address" rows="2"><?= isset($settings['contact_address']) ? esc($settings['contact_address']['value']) : '' ?></textarea>
                </div>

                <div class="form-group">
                    <label for="contact_phone">Telepon</label>
                    <input type="text" id="contact_phone" name="contact_phone"
                        value="<?= isset($settings['contact_phone']) ? esc($settings['contact_phone']['value']) : '' ?>">
                </div>

                <div class="form-group">
                    <label for="contact_email">Email</label>
                    <input type="email" id="contact_email" name="contact_email"
                        value="<?= isset($settings['contact_email']) ? esc($settings['contact_email']['value']) : '' ?>">
                </div>

                <div class="form-group full-width">
                    <label for="contact_hours">Jam Operasional</label>
                    <textarea id="contact_hours" name="contact_hours" rows="2"><?= isset($settings['contact_hours']) ? esc($settings['contact_hours']['value']) : '' ?></textarea>
                </div>
            </div>
        </div>

        <!-- Map Settings Section -->
        <div class="settings-section">
            <h3>Pengaturan Peta</h3>
            <div class="form-grid">
                <div class="form-group">
                    <label for="map_latitude">Latitude</label>
                    <input type="text" id="map_latitude" name="map_latitude"
                        value="<?= isset($settings['map_latitude']) ? esc($settings['map_latitude']['value']) : '' ?>">
                </div>

                <div class="form-group">
                    <label for="map_longitude">Longitude</label>
                    <input type="text" id="map_longitude" name="map_longitude"
                        value="<?= isset($settings['map_longitude']) ? esc($settings['map_longitude']['value']) : '' ?>">
                </div>
                <div class="form-group full-width">
                    <label for="mapbox_token">Mapbox Access Token</label>
                    <input type="text" id="mapbox_token" name="mapbox_token"
                        value="<?= isset($settings['mapbox_token']) ? esc($settings['mapbox_token']['value']) : '' ?>">
                </div>
            </div>
        </div>

        <!-- Image Settings Section -->
        <div class="settings-section">
            <h3>Pengaturan Gambar</h3>
            <div class="form-grid">
                <div class="form-group full-width">
                    <label for="company_logo">Logo Perusahaan</label>
                    <div class="image-upload-container">
                        <input type="hidden" id="company_logo" name="company_logo"
                            value="<?= isset($settings['company_logo']) ? esc($settings['company_logo']['value']) : '' ?>">
                        <div class="image-preview" id="company_logo_preview">
                            <?php if (isset($settings['company_logo']) && !empty($settings['company_logo']['value'])): ?>
                                <img src="<?= base_url('assets/images/uploads/' . $settings['company_logo']['value']) ?>" alt="Company Logo">
                                <button type="button" class="remove-image" onclick="removeImage('company_logo')">×</button>
                            <?php else: ?>
                                <div class="placeholder">Belum ada logo</div>
                            <?php endif; ?>
                        </div>
                        <input type="file" id="company_logo_file" accept="image/*" onchange="uploadImage('company_logo', this)">
                        <label for="company_logo_file" class="upload-btn">Pilih Logo</label>
                    </div>
                </div>

                <div class="form-group full-width">
                    <label for="hero_background_image">Background Hero Section</label>
                    <div class="image-upload-container">
                        <input type="hidden" id="hero_background_image" name="hero_background_image"
                            value="<?= isset($settings['hero_background_image']) ? esc($settings['hero_background_image']['value']) : '' ?>">
                        <div class="image-preview" id="hero_background_image_preview">
                            <?php if (isset($settings['hero_background_image']) && !empty($settings['hero_background_image']['value'])): ?>
                                <img src="<?= base_url('assets/images/uploads/' . $settings['hero_background_image']['value']) ?>" alt="Hero Background">
                                <button type="button" class="remove-image" onclick="removeImage('hero_background_image')">×</button>
                            <?php else: ?>
                                <div class="placeholder">Belum ada background</div>
                            <?php endif; ?>
                        </div>
                        <input type="file" id="hero_background_image_file" accept="image/*" onchange="uploadImage('hero_background_image', this)">
                        <label for="hero_background_image_file" class="upload-btn">Pilih Background</label>
                    </div>
                </div>

                <div class="form-group full-width">
                    <label for="about_image">Gambar About Section</label>
                    <div class="image-upload-container">
                        <input type="hidden" id="about_image" name="about_image"
                            value="<?= isset($settings['about_image']) ? esc($settings['about_image']['value']) : '' ?>">
                        <div class="image-preview" id="about_image_preview">
                            <?php if (isset($settings['about_image']) && !empty($settings['about_image']['value'])): ?>
                                <img src="<?= base_url('assets/images/uploads/' . $settings['about_image']['value']) ?>" alt="About Image">
                                <button type="button" class="remove-image" onclick="removeImage('about_image')">×</button>
                            <?php else: ?>
                                <div class="placeholder">Belum ada gambar</div>
                            <?php endif; ?>
                        </div>
                        <input type="file" id="about_image_file" accept="image/*" onchange="uploadImage('about_image', this)">
                        <label for="about_image_file" class="upload-btn">Pilih Gambar</label>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">
                <span class="btn-text">Simpan Perubahan</span>
                <span class="btn-loading" style="display: none;">Menyimpan...</span>
            </button>
            <button type="button" class="btn btn-secondary" onclick="resetForm()">Reset</button>
            <button type="button" class="btn btn-warning" onclick="testImageDeletion()" style="margin-left: 10px;">Test Delete</button>
        </div>
    </form>
</div>

<!-- Confirmation Modal -->
<div id="confirmModal" class="modal confirm-modal" style="display: none;">
    <div class="modal-content">
        <div class="modal-body">
            <div class="confirm-icon">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <div class="confirm-title" id="confirmTitle">Konfirmasi Hapus</div>
            <div class="confirm-message" id="confirmMessage">
                Yakin ingin menghapus gambar ini?
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn-cancel" onclick="closeConfirmModal()">Batal</button>
            <button type="button" class="btn-confirm" id="confirmButton" onclick="executeRemoveImage()">Hapus</button>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

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
        margin: 15% auto;
        border: none;
        border-radius: 12px;
        width: 90%;
        max-width: 400px;
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

    .modal-body {
        padding: 30px;
        text-align: center;
    }

    .modal-footer {
        padding: 0 30px 30px;
        display: flex;
        justify-content: center;
        gap: 15px;
    }

    /* Confirmation Modal Styles */
    .confirm-modal .modal-content {
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

    /* Add CSS for warning alerts */
    .alert-warning {
        background-color: #fff3cd;
        border-color: #ffeaa7;
        color: #856404;
    }
</style>

<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
    document.getElementById('settingsForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        const form = e.target;
        const submitBtn = form.querySelector('button[type="submit"]');
        const btnText = submitBtn.querySelector('.btn-text');
        const btnLoading = submitBtn.querySelector('.btn-loading');

        // Show loading state
        submitBtn.disabled = true;
        btnText.style.display = 'none';
        btnLoading.style.display = 'inline';

        try {
            const formData = new FormData(form);
            const settings = [];

            // Convert form data to settings array
            for (let [key, value] of formData.entries()) {
                if (key !== 'csrf_test_name') {
                    let type = 'text';
                    if (key.includes('description') || key.includes('vision') || key.includes('mission') || key.includes('address') || key.includes('hours')) {
                        type = 'textarea';
                    } else if (key.includes('email')) {
                        type = 'email';
                    } else if (key.includes('phone')) {
                        type = 'phone';
                    }

                    settings.push({
                        key: key,
                        value: value,
                        type: type
                    });
                }
            }

            const response = await fetch('<?= base_url('api/company/settings/bulk') ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    settings: settings
                })
            });

            const result = await response.json();

            if (result.status === 'success') {
                showAlert('success', 'Pengaturan berhasil disimpan!');
            } else {
                showAlert('error', 'Gagal menyimpan pengaturan: ' + (result.message || 'Unknown error'));
            }
        } catch (error) {
            showAlert('error', 'Terjadi kesalahan: ' + error.message);
        } finally {
            // Reset loading state
            submitBtn.disabled = false;
            btnText.style.display = 'inline';
            btnLoading.style.display = 'none';
        }
    });

    function resetForm() {
        if (confirm('Yakin ingin mereset form? Perubahan yang belum disimpan akan hilang.')) {
            document.getElementById('settingsForm').reset();
        }
    }

    async function uploadImage(fieldName, fileInput) {
        const file = fileInput.files[0];
        if (!file) return;

        // Validate file size (2MB max)
        if (file.size > 2 * 1024 * 1024) {
            showAlert('error', 'File terlalu besar! Maksimal 2MB.');
            fileInput.value = '';
            return;
        }

        // Validate file type
        if (!file.type.startsWith('image/')) {
            showAlert('error', 'File harus berupa gambar!');
            fileInput.value = '';
            return;
        }

        const formData = new FormData();
        formData.append('image', file);

        try {
            // Show loading state
            const preview = document.getElementById(fieldName + '_preview');
            preview.innerHTML = '<div class="placeholder">Uploading...</div>';

            const response = await fetch('<?= base_url('upload/image') ?>', {
                method: 'POST',
                body: formData
            });

            const result = await response.json();

            if (result.status === 'success') {
                // Update hidden input
                document.getElementById(fieldName).value = result.data.filename;

                // Update preview
                preview.innerHTML = `
                    <img src="${result.data.url}" alt="Preview">
                    <button type="button" class="remove-image" onclick="removeImage('${fieldName}')">×</button>
                `;

                showAlert('success', 'Gambar berhasil diupload!');
            } else {
                preview.innerHTML = '<div class="placeholder">Upload gagal</div>';
                showAlert('error', 'Upload gagal: ' + (result.message || 'Unknown error'));
            }
        } catch (error) {
            const preview = document.getElementById(fieldName + '_preview');
            preview.innerHTML = '<div class="placeholder">Upload gagal</div>';
            showAlert('error', 'Terjadi kesalahan: ' + error.message);
        }

        // Reset file input
        fileInput.value = '';
    }

    function removeImage(fieldName) {
        // Show confirmation modal instead of alert
        currentRemoveField = fieldName;
        document.getElementById('confirmMessage').textContent = 'Yakin ingin menghapus gambar ini? Tindakan ini tidak dapat dibatalkan.';
        document.getElementById('confirmModal').style.display = 'block';
    }

    let currentRemoveField = null;

    function closeConfirmModal() {
        document.getElementById('confirmModal').style.display = 'none';
        currentRemoveField = null;
    }
    async function executeRemoveImage() {
        if (!currentRemoveField) return;

        console.log('Executing remove image for:', currentRemoveField);

        const fieldName = currentRemoveField;
        const currentImageValue = document.getElementById(fieldName).value;

        // Show loading state
        const preview = document.getElementById(fieldName + '_preview');
        const originalContent = preview.innerHTML;
        preview.innerHTML = '<div class="placeholder">Menghapus gambar...</div>';

        try {
            // First, delete the physical file if it exists
            if (currentImageValue) {
                const deleteResponse = await fetch('<?= base_url('upload/delete-image') ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('input[name="<?= csrf_token() ?>"]').value
                    },
                    body: JSON.stringify({
                        filename: currentImageValue
                    })
                });

                const deleteResult = await deleteResponse.json();
                console.log('Delete file response:', deleteResult);
            }

            // Then update database to clear the setting
            const settingsData = {
                settings: [{
                    key: fieldName,
                    value: '',
                    type: 'image'
                }]
            };

            const response = await fetch('<?= base_url('api/company/settings/bulk') ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify(settingsData)
            });

            const data = await response.json();
            console.log('Database update response:', data);

            if (data.status === 'success') {
                // Clear UI only after successful database update
                document.getElementById(fieldName).value = '';
                preview.innerHTML = '<div class="placeholder">Belum ada gambar</div>';
                showNotification('Gambar berhasil dihapus', 'success');
            } else {
                // Restore original content on error
                preview.innerHTML = originalContent;
                showNotification('Error: ' + (data.message || 'Unknown error'), 'error');
            }
        } catch (error) {
            console.error('Error:', error);
            // Restore original content on error
            preview.innerHTML = originalContent;
            showNotification('Gagal menghapus gambar: ' + error.message, 'error');
        }

        closeConfirmModal();
    } // Test function for debugging
    async function testImageDeletion() {
        console.log('Testing image deletion...');

        try {
            // Test API call directly
            const response = await fetch('<?= base_url('api/company/settings/bulk') ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    settings: [{
                        key: 'company_logo',
                        value: '',
                        type: 'image'
                    }]
                })
            });

            console.log('Response status:', response.status);
            const data = await response.json();
            console.log('API Response:', data);
            showNotification('Test API call: ' + data.status, data.status === 'success' ? 'success' : 'error');
        } catch (error) {
            console.error('Test Error:', error);
            showNotification('Test Error: ' + error.message, 'error');
        }
    }

    // Close modal when clicking outside
    window.onclick = function(event) {
        const confirmModal = document.getElementById('confirmModal');
        if (event.target === confirmModal) {
            closeConfirmModal();
        }
    };

    function showAlert(type, message) {
        showNotification(message, type);
    }

    function showNotification(message, type) {
        // Remove existing alerts
        const existingAlerts = document.querySelectorAll('.alert');
        existingAlerts.forEach(alert => alert.remove());

        // Create new alert with better styling
        const alert = document.createElement('div');
        let alertClass = 'alert-danger'; // default
        if (type === 'success') alertClass = 'alert-success';
        if (type === 'warning') alertClass = 'alert-warning';

        alert.className = `alert ${alertClass}`;
        alert.style.cssText = `
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
        alert.textContent = message;

        document.body.appendChild(alert);

        // Auto remove after 4 seconds
        setTimeout(() => {
            alert.style.animation = 'slideOutRight 0.3s ease-in';
            setTimeout(() => {
                if (alert.parentNode) {
                    alert.parentNode.removeChild(alert);
                }
            }, 300);
        }, 4000);
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