<!-- Menggunakan layout utama admin/layout.php sebagai kerangka halaman ini. -->
<?= $this->extend('admin/layout') ?>

<!-- Membuka section content agar isi halaman ini dimasukkan ke bagian layout utama. -->
<?= $this->section('content') ?>
<div class="content-header">
    <h1>Ganti Password Admin</h1>
</div>
<!-- Menampilkan pesan sukses jika password berhasil diganti. -->
<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success">
        <?= session()->getFlashdata('success') ?>
    </div>
<?php endif; ?>
<!-- Menampilkan pesan error umum (misal password lama salah). -->
<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger">
        <?= session()->getFlashdata('error') ?>
    </div>
<?php endif; ?>
<!-- Menampilkan error validasi (misalnya password baru tidak sesuai atau terlalu pendek). -->
<?php if (session()->getFlashdata('errors')): ?>
    <div class="alert alert-danger">
        <!-- Menampilkan daftar pesan validasi error satu per satu dengan perlindungan esc() agar aman dari XSS. -->
        <?php foreach (session()->getFlashdata('errors') as $err): ?>
            <div><?= esc($err) ?></div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
<!-- Formulir dikirim ke URL admin/update-password menggunakan metode POST. Dibatasi lebarnya agar tampil rapi. -->
<form method="post" action="<?= base_url('admin/update-password') ?>" class="form-box" style="max-width:400px;">
    <!-- Menambahkan CSRF token untuk keamanan terhadap serangan Cross Site Request Forgery. -->
    <?= csrf_field() ?>

    <!-- Field untuk memasukkan password lama. Wajib diisi. -->
    <div class="form-group">
        <label for="old_password">Password Lama</label>
        <input type="password" name="old_password" id="old_password" class="form-control" required>
    </div>

    <!-- Field untuk password baru. Validasi HTML minimum 6 karakter. -->
    <div class="form-group">
        <label for="new_password">Password Baru</label>
        <input type="password" name="new_password" id="new_password" class="form-control" required minlength="6">
    </div>

    <!-- Field untuk konfirmasi password baru. Harus cocok dengan new_password. -->
    <div class="form-group">
        <label for="confirm_password">Konfirmasi Password Baru</label>
        <input type="password" name="confirm_password" id="confirm_password" class="form-control" required minlength="6">
    </div>

    <br>
    <!-- Tombol utama untuk mengirimkan form. -->
    <button type="submit" class="btn btn-primary">Ganti Password</button>
</form>
<?= $this->endSection() ?>