<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? esc($title) : 'PT. Samsudi Indoniaga Sedaya' ?></title>
    <meta name="description" content="<?= isset($meta_description) ? esc($meta_description) : 'Solusi niaga terpercaya untuk kemajuan bisnis Anda di Indonesia' ?>">

    <!-- External CSS -->
    <link href="https://api.mapbox.com/mapbox-gl-js/v2.15.0/mapbox-gl.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/css/main.css') ?>">

    <!-- Additional CSS if needed -->
    <?= $this->renderSection('css') ?>
</head>

<body>
    <!-- Header -->
    <?= $this->include('company/partials/header') ?>

    <!-- Main Content -->
    <main>
        <?= $this->renderSection('content') ?>
    </main>

    <!-- Footer -->
    <?= $this->include('company/partials/footer') ?>

    <!-- JavaScript -->
    <script src="https://api.mapbox.com/mapbox-gl-js/v2.15.0/mapbox-gl.js"></script>
    <script src="<?= base_url('assets/js/main.js') ?>"></script>

    <!-- Additional JS if needed -->
    <?= $this->renderSection('js') ?>
</body>

</html>