<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title> <?= $title; ?> </title>

    <!-- Custom fonts for this template-->
    <link href="<?= base_url('assets'); ?>/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="<?= base_url('assets'); ?>/https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?= base_url('assets'); ?>/css/sb-admin-2.min.css" rel="stylesheet">
	 <!-- Favicon -->
	 <link rel="icon" type="image/x-icon" href="<?= base_url('assets/favicon.ico'); ?>" />

	<!-- Bootstrap Icons -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />

	<!-- Google Fonts -->
	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" />

	<!-- Core Theme CSS -->
	<link href="<?= base_url('assets/css/styles.css'); ?>" rel="stylesheet" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css">
</head>

<body class="bg-gradient-light">
	<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm pl-2">
	<a class="navbar-brand fw-bold" href="#">SD SWASTA 11 FENA FAFAN</a>
    <div class="container">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('auth'); ?>">Beranda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('auth/tracking'); ?>">Lacak Barang</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('auth/about'); ?>">Tentang Kami</a>
                </li>
            </ul>
            <a class="btn btn-primary btn-sm" href="<?= base_url('auth/login'); ?>">Masuk</a>
        </div>
    </div>
</nav>

