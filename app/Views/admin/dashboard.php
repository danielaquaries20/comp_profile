<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>

<div class="content-header">
    <h1>Dashboard</h1>
    <p>Selamat datang di panel admin PT. Samsudi Indoniaga Sedaya</p>
</div>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success">
        <?= session()->getFlashdata('success') ?>
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
        <h3>Pesan Kontak Terbaru</h3>
    </div>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Pesan</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($contacts)): ?>
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 40px; color: #666;">
                            Belum ada pesan kontak.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($contacts as $contact): ?>
                        <tr>
                            <td><?= date('d/m/Y H:i', strtotime($contact['created_at'])) ?></td>
                            <td><?= esc($contact['nama']) ?></td>
                            <td><?= esc($contact['email']) ?></td>
                            <td>
                                <div class="message-preview" title="<?= esc($contact['pesan']) ?>">
                                    <?= esc(substr($contact['pesan'], 0, 50)) ?><?= strlen($contact['pesan']) > 50 ? '...' : '' ?>
                                </div>
                            </td>
                            <td>
                                <span class="status-badge status-<?= $contact['status'] ?>">
                                    <?= $contact['status'] === 'unread' ? 'Belum Dibaca' : 'Sudah Dibaca' ?>
                                </span>
                            </td>
                            <td>
                                <?php if ($contact['status'] === 'unread'): ?>
                                    <a href="<?= base_url('admin/mark-read/' . $contact['id']) ?>"
                                        class="action-btn btn-read">Tandai Dibaca</a>
                                <?php endif; ?>
                                <a href="<?= base_url('admin/delete/' . $contact['id']) ?>"
                                    class="action-btn btn-delete"
                                    onclick="return confirm('Yakin ingin menghapus pesan ini?')">Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
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
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        text-align: center;
    }

    .stat-number {
        font-size: 2em;
        font-weight: bold;
        color: #D80000;
    }

    .message-preview {
        max-width: 200px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .status-badge {
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 600;
    }

    .status-unread {
        background: #fff3cd;
        color: #856404;
    }

    .status-read {
        background: #d1ecf1;
        color: #0c5460;
    }

    @media (max-width: 768px) {
        .message-preview {
            max-width: 100px;
        }
    }
</style>
<?= $this->endSection() ?>
padding: 0 20px;
display: flex;
justify-content: space-between;
align-items: center;
}

.header h1 {
font-size: 24px;
}

.logout-btn {
background: rgba(255, 255, 255, 0.2);
color: white;
padding: 8px 20px;
text-decoration: none;
border-radius: 5px;
transition: background 0.3s ease;
}

.logout-btn:hover {
background: rgba(255, 255, 255, 0.3);
}

.container {
max-width: 1200px;
margin: 0 auto;
padding: 20px;
}

.stats {
display: grid;
grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
gap: 20px;
margin-bottom: 30px;
}

.stat-card {
background: white;
padding: 20px;
border-radius: 10px;
box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
text-align: center;
}

.stat-number {
font-size: 2em;
font-weight: bold;
color: #D80000;
}

.contacts-table {
background: white;
border-radius: 10px;
box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
overflow: hidden;
}

.table-header {
background: #f8f9fa;
padding: 20px;
border-bottom: 1px solid #eee;
}

.table-header h2 {
color: #333;
}

table {
width: 100%;
border-collapse: collapse;
}

th,
td {
padding: 12px;
text-align: left;
border-bottom: 1px solid #eee;
}

th {
background: #f8f9fa;
font-weight: 600;
color: #666;
}

.status-badge {
padding: 4px 8px;
border-radius: 4px;
font-size: 12px;
font-weight: 600;
}

.status-unread {
background: #fff3cd;
color: #856404;
}

.status-read {
background: #d1ecf1;
color: #0c5460;
}

.action-btn {
padding: 4px 8px;
border: none;
border-radius: 4px;
cursor: pointer;
font-size: 12px;
margin-right: 5px;
text-decoration: none;
display: inline-block;
}

.btn-read {
background: #28a745;
color: white;
}

.btn-delete {
background: #dc3545;
color: white;
}

.alert {
padding: 15px;
margin-bottom: 20px;
border-radius: 4px;
}

.alert-success {
color: #155724;
background-color: #d4edda;
border: 1px solid #c3e6cb;
}

.message-preview {
max-width: 200px;
overflow: hidden;
text-overflow: ellipsis;
white-space: nowrap;
}

@media (max-width: 768px) {
.table-responsive {
overflow-x: auto;
}

.message-preview {
max-width: 100px;
}
}
</style>
</head>

<body>
    <header class="header">
        <div class="header-content">
            <h1>Admin Dashboard</h1>
            <a href="<?= base_url('admin/logout') ?>" class="logout-btn">Logout</a>
        </div>
    </header>

    <div class="container">
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success">
                <?= session()->getFlashdata('success') ?>
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

        <div class="contacts-table">
            <div class="table-header">
                <h2>Pesan Kontak</h2>
            </div>

            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Pesan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($contacts)): ?>
                            <tr>
                                <td colspan="6" style="text-align: center; padding: 40px; color: #666;">
                                    Belum ada pesan kontak.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($contacts as $contact): ?>
                                <tr>
                                    <td><?= date('d/m/Y H:i', strtotime($contact['created_at'])) ?></td>
                                    <td><?= esc($contact['nama']) ?></td>
                                    <td><?= esc($contact['email']) ?></td>
                                    <td>
                                        <div class="message-preview" title="<?= esc($contact['pesan']) ?>">
                                            <?= esc(substr($contact['pesan'], 0, 50)) ?><?= strlen($contact['pesan']) > 50 ? '...' : '' ?>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="status-badge status-<?= $contact['status'] ?>">
                                            <?= $contact['status'] === 'unread' ? 'Belum Dibaca' : 'Sudah Dibaca' ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?php if ($contact['status'] === 'unread'): ?>
                                            <a href="<?= base_url('admin/mark-read/' . $contact['id']) ?>"
                                                class="action-btn btn-read">Tandai Dibaca</a>
                                        <?php endif; ?>
                                        <a href="<?= base_url('admin/delete/' . $contact['id']) ?>"
                                            class="action-btn btn-delete"
                                            onclick="return confirm('Yakin ingin menghapus pesan ini?')">Hapus</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>