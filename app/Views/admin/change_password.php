<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>
<div class="content-header">
    <h1>Ganti Password Admin</h1>
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
<?php if (session()->getFlashdata('errors')): ?>
    <div class="alert alert-danger">
        <?php foreach (session()->getFlashdata('errors') as $err): ?>
            <div><?= esc($err) ?></div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
<form method="post" action="<?= base_url('admin/update-password') ?>" class="form-box" style="max-width:400px;">
    <?= csrf_field() ?>
    <div class="form-group">
        <label for="old_password">Password Lama</label>
        <input type="password" name="old_password" id="old_password" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="new_password">Password Baru</label>
        <input type="password" name="new_password" id="new_password" class="form-control" required minlength="6">
    </div>
    <div class="form-group">
        <label for="confirm_password">Konfirmasi Password Baru</label>
        <input type="password" name="confirm_password" id="confirm_password" class="form-control" required minlength="6">
    </div>
    <button type="submit" class="btn btn-primary">Ganti Password</button>
</form>
<?= $this->endSection() ?>