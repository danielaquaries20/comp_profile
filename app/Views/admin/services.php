<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>

<div class="content-header">
    <h1>Services Management</h1>
    <p>Kelola layanan yang ditampilkan di website</p>
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
        <h3>Daftar Layanan</h3>
        <div>
            <button type="button" class="btn btn-primary" onclick="showAddModal()">Tambah Layanan</button>
        </div>
    </div>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>Icon</th>
                    <th>Judul</th>
                    <th>Deskripsi</th>
                    <th>Urutan</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody id="servicesTable">
                <?php if (empty($services)): ?>
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 40px; color: #666;">
                            Belum ada layanan. <a href="#" onclick="showAddModal()">Tambah layanan pertama</a>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($services as $service): ?> <tr data-id="<?= $service['id'] ?>">
                            <td style="font-size: 24px; text-align: center;">
                                <i class="<?= esc($service['icon']) ?>"></i>
                            </td>
                            <td><?= esc($service['title']) ?></td>
                            <td>
                                <div class="description-preview" title="<?= esc($service['description']) ?>">
                                    <?= esc(substr($service['description'], 0, 80)) ?><?= strlen($service['description']) > 80 ? '...' : '' ?>
                                </div>
                            </td>
                            <td><?= $service['sort_order'] ?></td>
                            <td>
                                <span class="status-badge status-<?= $service['is_active'] ? 'active' : 'inactive' ?>">
                                    <?= $service['is_active'] ? 'Aktif' : 'Tidak Aktif' ?>
                                </span>
                            </td>
                            <td>
                                <button class="action-btn btn-edit" onclick="editService(<?= $service['id'] ?>)">Edit</button>
                                <button class="action-btn btn-delete" onclick="deleteService(<?= $service['id'] ?>)">Hapus</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Service Modal -->
<div id="serviceModal" class="modal" style="display: none;">
    <div class="modal-content">
        <div class="modal-header">
            <h3 id="modalTitle">Tambah Layanan</h3>
            <span class="close" onclick="closeModal()">&times;</span>
        </div>
        <form id="serviceForm">
            <input type="hidden" id="serviceId" name="id">
            <div class="form-group">
                <label for="serviceTitle">Judul Layanan</label>
                <input type="text" id="serviceTitle" name="title" required maxlength="100">
            </div>
            <div class="form-group">
                <label for="serviceIcon">Pilih Icon</label>
                <input type="hidden" id="serviceIcon" name="icon" required>

                <!-- Selected Icon Preview -->
                <div class="selected-icon-preview" id="selectedIconPreview" onclick="toggleIconPicker()">
                    <div class="icon-preview-container">
                        <i class="fas fa-question-circle" id="selectedIconDisplay"></i>
                        <span class="icon-name" id="selectedIconName">Klik untuk pilih icon</span>
                        <small class="icon-hint">Klik untuk memilih icon</small>
                    </div>
                </div>

                <!-- Icon Grid (Hidden by default) -->
                <div class="icon-grid" id="iconGrid" style="display: none;">
                    <div class="icon-grid-header">
                        <h4>Pilih Icon</h4>
                        <button type="button" class="close-icon-picker" onclick="closeIconPicker()">&times;</button>
                    </div>

                    <!-- Business & Finance Icons -->
                    <div class="icon-category">
                        <h4>Bisnis & Keuangan</h4>
                        <div class="icon-list">
                            <div class="icon-item" data-icon="fas fa-chart-line" data-name="Chart Line">
                                <i class="fas fa-chart-line"></i>
                                <span>Chart</span>
                            </div>
                            <div class="icon-item" data-icon="fas fa-handshake" data-name="Handshake">
                                <i class="fas fa-handshake"></i>
                                <span>Partnership</span>
                            </div>
                            <div class="icon-item" data-icon="fas fa-money-bill-wave" data-name="Money">
                                <i class="fas fa-money-bill-wave"></i>
                                <span>Money</span>
                            </div>
                            <div class="icon-item" data-icon="fas fa-calculator" data-name="Calculator">
                                <i class="fas fa-calculator"></i>
                                <span>Calculator</span>
                            </div>
                            <div class="icon-item" data-icon="fas fa-briefcase" data-name="Briefcase">
                                <i class="fas fa-briefcase"></i>
                                <span>Business</span>
                            </div>
                            <div class="icon-item" data-icon="fas fa-dollar-sign" data-name="Dollar">
                                <i class="fas fa-dollar-sign"></i>
                                <span>Dollar</span>
                            </div>
                        </div>
                    </div>

                    <!-- Technology Icons -->
                    <div class="icon-category">
                        <h4>Teknologi</h4>
                        <div class="icon-list">
                            <div class="icon-item" data-icon="fas fa-cogs" data-name="Settings">
                                <i class="fas fa-cogs"></i>
                                <span>Settings</span>
                            </div>
                            <div class="icon-item" data-icon="fas fa-laptop" data-name="Laptop">
                                <i class="fas fa-laptop"></i>
                                <span>Laptop</span>
                            </div>
                            <div class="icon-item" data-icon="fas fa-mobile-alt" data-name="Mobile">
                                <i class="fas fa-mobile-alt"></i>
                                <span>Mobile</span>
                            </div>
                            <div class="icon-item" data-icon="fas fa-wifi" data-name="WiFi">
                                <i class="fas fa-wifi"></i>
                                <span>WiFi</span>
                            </div>
                            <div class="icon-item" data-icon="fas fa-database" data-name="Database">
                                <i class="fas fa-database"></i>
                                <span>Database</span>
                            </div>
                            <div class="icon-item" data-icon="fas fa-server" data-name="Server">
                                <i class="fas fa-server"></i>
                                <span>Server</span>
                            </div>
                        </div>
                    </div>

                    <!-- Service Icons -->
                    <div class="icon-category">
                        <h4>Layanan</h4>
                        <div class="icon-list">
                            <div class="icon-item" data-icon="fas fa-shipping-fast" data-name="Shipping">
                                <i class="fas fa-shipping-fast"></i>
                                <span>Shipping</span>
                            </div>
                            <div class="icon-item" data-icon="fas fa-user-tie" data-name="Consultant">
                                <i class="fas fa-user-tie"></i>
                                <span>Consultant</span>
                            </div>
                            <div class="icon-item" data-icon="fas fa-headset" data-name="Support">
                                <i class="fas fa-headset"></i>
                                <span>Support</span>
                            </div>
                            <div class="icon-item" data-icon="fas fa-tools" data-name="Tools">
                                <i class="fas fa-tools"></i>
                                <span>Tools</span>
                            </div>
                            <div class="icon-item" data-icon="fas fa-shield-alt" data-name="Security">
                                <i class="fas fa-shield-alt"></i>
                                <span>Security</span>
                            </div>
                            <div class="icon-item" data-icon="fas fa-award" data-name="Award">
                                <i class="fas fa-award"></i>
                                <span>Award</span>
                            </div>
                        </div>
                    </div>

                    <!-- Communication Icons -->
                    <div class="icon-category">
                        <h4>Komunikasi</h4>
                        <div class="icon-list">
                            <div class="icon-item" data-icon="fas fa-envelope" data-name="Email">
                                <i class="fas fa-envelope"></i>
                                <span>Email</span>
                            </div>
                            <div class="icon-item" data-icon="fas fa-phone" data-name="Phone">
                                <i class="fas fa-phone"></i>
                                <span>Phone</span>
                            </div>
                            <div class="icon-item" data-icon="fas fa-comments" data-name="Chat">
                                <i class="fas fa-comments"></i>
                                <span>Chat</span>
                            </div>
                            <div class="icon-item" data-icon="fas fa-bullhorn" data-name="Announcement">
                                <i class="fas fa-bullhorn"></i>
                                <span>Announcement</span>
                            </div>
                            <div class="icon-item" data-icon="fas fa-globe" data-name="Global">
                                <i class="fas fa-globe"></i>
                                <span>Global</span>
                            </div>
                            <div class="icon-item" data-icon="fas fa-satellite-dish" data-name="Satellite">
                                <i class="fas fa-satellite-dish"></i>
                                <span>Satellite</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="serviceDescription">Deskripsi</label>
                <textarea id="serviceDescription" name="description" required maxlength="500" rows="4"></textarea>
            </div>
            <div class="form-group">
                <label for="serviceSortOrder">Urutan</label>
                <input type="number" id="serviceSortOrder" name="sort_order" min="0" value="0">
            </div>
            <div class="form-group">
                <label>
                    <input type="checkbox" id="serviceIsActive" name="is_active" checked>
                    Aktif
                </label>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <span class="btn-text">Simpan</span>
                    <span class="btn-loading" style="display: none;">Menyimpan...</span>
                </button>
                <button type="button" class="btn btn-secondary" onclick="closeModal()">Batal</button>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('css') ?>
<style>
    .description-preview {
        max-width: 300px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .status-active {
        background: #d4edda;
        color: #155724;
    }

    .status-inactive {
        background: #f8d7da;
        color: #721c24;
    }

    /* Modal Styles */
    .modal {
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .modal-content {
        background: white;
        border-radius: 10px;
        width: 90%;
        max-width: 500px;
        max-height: 90vh;
        overflow-y: auto;
    }

    .modal-header {
        padding: 20px;
        border-bottom: 1px solid #eee;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .modal-header h3 {
        margin: 0;
        color: #2c3e50;
    }

    .close {
        font-size: 28px;
        font-weight: bold;
        cursor: pointer;
        color: #999;
    }

    .close:hover {
        color: #D80000;
    }

    .modal form {
        padding: 20px;
    }

    .card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    /* Ensure buttons are clickable */
    .btn-primary,
    .btn-edit,
    .btn-delete {
        cursor: pointer;
        pointer-events: auto;
        position: relative;
        z-index: 1;
    }

    .btn-primary:hover,
    .btn-edit:hover,
    .btn-delete:hover {
        opacity: 0.9;
        transform: translateY(-1px);
    }

    /* Icon Picker Styles */
    .selected-icon-preview {
        margin-bottom: 15px;
        padding: 15px;
        border: 2px solid #e9ecef;
        border-radius: 8px;
        background: #f8f9fa;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .selected-icon-preview:hover {
        border-color: #D80000;
        background: #fff5f5;
        transform: translateY(-1px);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .icon-preview-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 8px;
    }

    .selected-icon-preview i {
        font-size: 2.5rem;
        color: #D80000;
        transition: transform 0.3s ease;
    }

    .selected-icon-preview:hover i {
        transform: scale(1.1);
    }

    .icon-name {
        font-weight: 500;
        color: #495057;
    }

    .icon-hint {
        font-size: 12px;
        color: #6c757d;
        font-style: italic;
    }

    .icon-grid {
        margin-top: 10px;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        background: white;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        animation: slideDown 0.3s ease-out;
    }

    .icon-grid-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 20px;
        border-bottom: 1px solid #e9ecef;
        background: #f8f9fa;
        border-radius: 8px 8px 0 0;
    }

    .icon-grid-header h4 {
        margin: 0;
        color: #495057;
        font-size: 16px;
        font-weight: 600;
    }

    .close-icon-picker {
        background: none;
        border: none;
        font-size: 24px;
        color: #6c757d;
        cursor: pointer;
        padding: 0;
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        transition: all 0.3s ease;
    }

    .close-icon-picker:hover {
        background: #e9ecef;
        color: #D80000;
    }

    .icon-grid .icon-category {
        margin-bottom: 20px;
        padding: 0 20px;
    }

    .icon-grid .icon-category:first-child {
        padding-top: 15px;
    }

    .icon-grid .icon-category:last-child {
        margin-bottom: 15px;
    }

    .icon-category h4 {
        margin: 0 0 10px 0;
        padding-bottom: 5px;
        border-bottom: 1px solid #e9ecef;
        color: #495057;
        font-size: 14px;
        font-weight: 600;
    }

    .icon-list {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(80px, 1fr));
        gap: 10px;
        max-height: 200px;
        overflow-y: auto;
        padding-right: 5px;
    }

    .icon-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 12px 8px;
        border: 1px solid #e9ecef;
        border-radius: 6px;
        cursor: pointer;
        transition: all 0.3s ease;
        background: white;
        text-align: center;
    }

    .icon-item:hover {
        border-color: #D80000;
        background: #fff5f5;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .icon-item.selected {
        border-color: #D80000;
        background: #D80000;
        color: white;
    }

    .icon-item i {
        font-size: 1.5rem;
        margin-bottom: 4px;
        transition: color 0.3s ease;
    }

    .icon-item.selected i {
        color: white;
    }

    .icon-item span {
        font-size: 10px;
        font-weight: 500;
        line-height: 1.2;
    }

    .icon-item.selected span {
        color: white;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
    console.log('Services JavaScript loaded');

    let editingServiceId = null;

    // Icon picker functionality
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM loaded, setting up services management');
        setupIconPicker();
        setupEventListeners();

        // Load services data
        loadServices();
    });

    function setupEventListeners() {
        // Test if buttons exist
        const addButton = document.querySelector('.btn-primary');
        const editButtons = document.querySelectorAll('.btn-edit');

        // Setup form submission handler
        const serviceForm = document.getElementById('serviceForm');
        if (serviceForm) {
            serviceForm.addEventListener('submit', handleFormSubmission);
        }

        // Add global error handler
        window.addEventListener('error', function(e) {
            console.error('JavaScript error:', e.error);
            console.error('Error message:', e.message);
            console.error('Error file:', e.filename);
            console.error('Error line:', e.lineno);
        });
    }

    function setupIconPicker() {
        const iconItems = document.querySelectorAll('.icon-item');
        const selectedIconDisplay = document.getElementById('selectedIconDisplay');
        const selectedIconName = document.getElementById('selectedIconName');
        const serviceIconInput = document.getElementById('serviceIcon');

        iconItems.forEach(item => {
            item.addEventListener('click', function() {
                // Remove previous selection
                iconItems.forEach(i => i.classList.remove('selected'));

                // Add selection to clicked item
                this.classList.add('selected');

                // Update preview
                const iconClass = this.dataset.icon;
                const iconName = this.dataset.name;

                selectedIconDisplay.className = iconClass;
                selectedIconName.textContent = iconName;
                serviceIconInput.value = iconClass;

                // Update preview styling
                const preview = document.querySelector('.selected-icon-preview');
                preview.style.borderColor = '#D80000';
                preview.style.background = '#fff5f5';

                // Hide icon picker after selection
                closeIconPicker();
            });
        });
    }

    // Toggle icon picker visibility
    function toggleIconPicker() {
        const iconGrid = document.getElementById('iconGrid');
        const isVisible = iconGrid.style.display !== 'none';

        if (isVisible) {
            closeIconPicker();
        } else {
            openIconPicker();
        }
    }

    // Open icon picker
    function openIconPicker() {
        const iconGrid = document.getElementById('iconGrid');
        iconGrid.style.display = 'block';
    }

    // Close icon picker
    function closeIconPicker() {
        const iconGrid = document.getElementById('iconGrid');
        iconGrid.style.display = 'none';
    } // Reset icon selection
    function resetIconSelection() {
        const iconItems = document.querySelectorAll('.icon-item');
        const selectedIconDisplay = document.getElementById('selectedIconDisplay');
        const selectedIconName = document.getElementById('selectedIconName');
        const serviceIconInput = document.getElementById('serviceIcon');
        const preview = document.querySelector('.selected-icon-preview');

        iconItems.forEach(i => i.classList.remove('selected'));
        selectedIconDisplay.className = 'fas fa-question-circle';
        selectedIconName.textContent = 'Klik untuk pilih icon';
        // Don't reset the input value here - let calling function handle it
        preview.style.borderColor = '#e9ecef';
        preview.style.background = '#f8f9fa';

        // Close icon picker
        closeIconPicker();
    }

    // Set selected icon (for edit mode)
    function setSelectedIcon(iconClass) {
        const iconItems = document.querySelectorAll('.icon-item');
        const selectedIconDisplay = document.getElementById('selectedIconDisplay');
        const selectedIconName = document.getElementById('selectedIconName');
        const serviceIconInput = document.getElementById('serviceIcon');
        const preview = document.querySelector('.selected-icon-preview');

        // Clear previous selection
        iconItems.forEach(i => i.classList.remove('selected'));

        // Find and select the matching icon
        const matchingItem = Array.from(iconItems).find(item => item.dataset.icon === iconClass);
        if (matchingItem) {
            matchingItem.classList.add('selected');
            selectedIconDisplay.className = iconClass;
            selectedIconName.textContent = matchingItem.dataset.name;
            serviceIconInput.value = iconClass;
            preview.style.borderColor = '#D80000';
            preview.style.background = '#fff5f5';
        } else {
            // If icon not found in list, show it anyway
            selectedIconDisplay.className = iconClass;
            selectedIconName.textContent = 'Custom Icon';
            serviceIconInput.value = iconClass;
            preview.style.borderColor = '#D80000';
            preview.style.background = '#fff5f5';
        }
    } // Show add modal
    function showAddModal() {
        try {
            document.getElementById('modalTitle').textContent = 'Tambah Layanan';
            document.getElementById('serviceForm').reset();
            document.getElementById('serviceId').value = '';
            editingServiceId = null;

            // Set default icon first
            const defaultIcon = 'fas fa-cogs';
            const serviceIconInput = document.getElementById('serviceIcon');
            const selectedIconDisplay = document.getElementById('selectedIconDisplay');
            const selectedIconName = document.getElementById('selectedIconName');
            const preview = document.querySelector('.selected-icon-preview');

            serviceIconInput.value = defaultIcon;
            selectedIconDisplay.className = defaultIcon;
            selectedIconName.textContent = 'Settings';
            preview.style.borderColor = '#D80000';
            preview.style.background = '#fff5f5';

            // Reset selection state
            const iconItems = document.querySelectorAll('.icon-item');
            iconItems.forEach(i => i.classList.remove('selected'));

            // Select the default icon in picker
            const defaultIconItem = document.querySelector(`[data-icon="${defaultIcon}"]`);
            if (defaultIconItem) {
                defaultIconItem.classList.add('selected');
            }

            document.getElementById('serviceModal').style.display = 'flex';
        } catch (error) {
            console.error('Error in showAddModal:', error);
        }
    } // Show edit modal
    async function editService(id) {
        try {
            const response = await fetch(`<?= base_url('api/company/services') ?>`);
            const result = await response.json();

            if (result.status === 'success') {
                const service = result.data.find(s => s.id == id);
                if (service) {
                    document.getElementById('modalTitle').textContent = 'Edit Layanan';
                    document.getElementById('serviceId').value = service.id;
                    document.getElementById('serviceTitle').value = service.title;
                    document.getElementById('serviceDescription').value = service.description;
                    document.getElementById('serviceSortOrder').value = service.sort_order;
                    document.getElementById('serviceIsActive').checked = service.is_active == 1;

                    // Set selected icon in picker
                    setSelectedIcon(service.icon);

                    editingServiceId = id;
                    document.getElementById('serviceModal').style.display = 'flex';
                }
            }
        } catch (error) {
            console.error('Error in editService:', error);
            alert('Error loading service data: ' + error.message);
        }
    } // Close modal
    function closeModal() {
        document.getElementById('serviceModal').style.display = 'none';
        editingServiceId = null;
        resetIconSelection(); // Reset icon picker when closing
    }

    // Delete service
    async function deleteService(id) {
        if (!confirm('Yakin ingin menghapus layanan ini?')) {
            return;
        }

        try {
            const response = await fetch(`<?= base_url('api/company/services') ?>/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            const result = await response.json();

            if (result.status === 'success') {
                showAlert('success', 'Layanan berhasil dihapus!');
                loadServices();
            } else {
                showAlert('error', 'Gagal menghapus layanan: ' + (result.message || 'Unknown error'));
            }
        } catch (error) {
            showAlert('error', 'Terjadi kesalahan: ' + error.message);
        }
    } // Handle form submission
    async function handleFormSubmission(e) {
        e.preventDefault();

        const form = e.target;
        const submitBtn = form.querySelector('button[type="submit"]');
        const btnText = submitBtn.querySelector('.btn-text');
        const btnLoading = submitBtn.querySelector('.btn-loading');

        if (!submitBtn) {
            console.error('Submit button not found!');
            return;
        }

        // Show loading state
        submitBtn.disabled = true;
        if (btnText) btnText.style.display = 'none';
        if (btnLoading) btnLoading.style.display = 'inline';
        try {
            const formData = new FormData(form);
            const data = {
                title: formData.get('title'),
                icon: formData.get('icon'),
                description: formData.get('description'),
                sort_order: parseInt(formData.get('sort_order')) || 0,
                is_active: formData.get('is_active') ? 1 : 0
            };

            console.log('Form data collected:', data);
            console.log('Form element:', form);
            console.log('FormData entries:');
            for (let [key, value] of formData.entries()) {
                console.log(`${key}: ${value}`);
            } // Debug icon field specifically
            const iconInput = document.getElementById('serviceIcon');
            const titleInput = document.getElementById('serviceTitle');
            const descInput = document.getElementById('serviceDescription');

            console.log('Icon input element:', iconInput);
            console.log('Title input element:', titleInput);
            console.log('Description input element:', descInput);

            console.log('Icon input value:', iconInput ? iconInput.value : 'NOT FOUND');
            console.log('Title input value:', titleInput ? titleInput.value : 'NOT FOUND');
            console.log('Description input value:', descInput ? descInput.value : 'NOT FOUND');

            console.log('Icon from FormData:', formData.get('icon'));
            console.log('Title from FormData:', formData.get('title'));
            console.log('Description from FormData:', formData.get('description')); // Validation
            if (!data.title || data.title.trim() === '') {
                showAlert('error', 'Judul layanan tidak boleh kosong');
                // Reset loading state
                submitBtn.disabled = false;
                if (btnText) btnText.style.display = 'inline';
                if (btnLoading) btnLoading.style.display = 'none';
                return;
            }

            if (!data.icon || data.icon.trim() === '') {
                showAlert('error', 'Icon harus dipilih');
                // Reset loading state
                submitBtn.disabled = false;
                if (btnText) btnText.style.display = 'inline';
                if (btnLoading) btnLoading.style.display = 'none';
                return;
            }

            if (!data.description || data.description.trim() === '') {
                showAlert('error', 'Deskripsi tidak boleh kosong');
                // Reset loading state
                submitBtn.disabled = false;
                if (btnText) btnText.style.display = 'inline';
                if (btnLoading) btnLoading.style.display = 'none';
                return;
            }

            let url = '<?= base_url('api/company/services') ?>';
            let method = 'POST';

            if (editingServiceId) {
                url += '/' + editingServiceId;
                method = 'PUT';
            }

            console.log('API URL:', url);
            console.log('Method:', method);

            const response = await fetch(url, {
                method: method,
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify(data)
            });
            console.log('Response status:', response.status);
            console.log('Response ok:', response.ok);

            const result = await response.json();
            console.log('Response result:', result);

            if (result.status === 'success') {
                showAlert('success', editingServiceId ? 'Layanan berhasil diupdate!' : 'Layanan berhasil ditambahkan!');
                closeModal();
                loadServices();
            } else {
                showAlert('error', 'Gagal menyimpan layanan: ' + (result.message || 'Unknown error'));
            }
        } catch (error) {
            console.error('Form submission error:', error);
            showAlert('error', 'Terjadi kesalahan: ' + error.message);
        } finally {
            // Reset loading state
            console.log('Resetting button state');
            submitBtn.disabled = false;
            if (btnText) btnText.style.display = 'inline';
            if (btnLoading) btnLoading.style.display = 'none';
        }
    }

    // Load services
    async function loadServices() {
        try {
            const response = await fetch('<?= base_url('api/company/services') ?>');
            const result = await response.json();

            if (result.status === 'success') {
                updateServicesTable(result.data);
            }
        } catch (error) {
            console.error('Error loading services:', error);
        }
    }

    // Update services table
    function updateServicesTable(services) {
        const tbody = document.getElementById('servicesTable');

        if (services.length === 0) {
            tbody.innerHTML = `
            <tr>
                <td colspan="6" style="text-align: center; padding: 40px; color: #666;">
                    Belum ada layanan. <a href="#" onclick="showAddModal()">Tambah layanan pertama</a>
                </td>
            </tr>
        `;
            return;
        }
        tbody.innerHTML = services.map(service => `
        <tr data-id="${service.id}">
            <td style="font-size: 24px; text-align: center;"><i class="${service.icon}"></i></td>
            <td>${service.title}</td>
            <td>
                <div class="description-preview" title="${service.description}">
                    ${service.description.length > 80 ? service.description.substring(0, 80) + '...' : service.description}
                </div>
            </td>
            <td>${service.sort_order}</td>
            <td>
                <span class="status-badge status-${service.is_active ? 'active' : 'inactive'}">
                    ${service.is_active ? 'Aktif' : 'Tidak Aktif'}
                </span>
            </td>
            <td>
                <button class="action-btn btn-edit" onclick="editService(${service.id})">Edit</button>
                <button class="action-btn btn-delete" onclick="deleteService(${service.id})">Hapus</button>
            </td>
        </tr>
    `).join('');
    }

    // Show alert function
    function showAlert(type, message) {
        // Remove existing alerts
        const existingAlerts = document.querySelectorAll('.alert');
        existingAlerts.forEach(alert => alert.remove());

        // Create new alert
        const alert = document.createElement('div');
        alert.className = `alert alert-${type}`;
        alert.textContent = message;

        // Insert after content header
        const contentHeader = document.querySelector('.content-header');
        contentHeader.parentNode.insertBefore(alert, contentHeader.nextSibling);

        // Auto remove after 5 seconds
        setTimeout(() => {
            alert.remove();
        }, 5000);
    }

    // Close modal when clicking outside
    window.onclick = function(event) {
        const modal = document.getElementById('serviceModal');
        if (event.target === modal) {
            closeModal();
        }
    }
</script>
<?= $this->endSection() ?>