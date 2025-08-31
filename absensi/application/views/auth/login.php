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
	<script src="https://www.google.com/recaptcha/api.js?hl=id" async defer></script>
	<style>
		body {
			background: linear-gradient(to right, rgba(44, 62, 80, 0.8), rgba(52, 152, 219, 0.8)),
						url('<?= base_url("assets/img/bg-pendidikan.png"); ?>') no-repeat center center fixed;
			background-size: cover;
			font-family: 'Poppins', sans-serif;
		}

		.login-card {
			background: linear-gradient(135deg, #2c3e50, #3498db);
			color: #fff;
			border: none;
			border-radius: 15px;
			box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
			backdrop-filter: blur(6px);
			padding: 2rem;
		}

		.login-card input.form-control {
			border-radius: 10px;
			border: none;
			padding: 12px 15px;
		}

		.login-card input.form-control::placeholder {
			color: #ccc;
		}

		.login-card .btn-primary {
			background-color: #f1c40f;
			border: none;
			font-weight: 600;
			color: #2c3e50;
			transition: 0.3s;
		}

		.login-card .btn-primary:hover {
			background-color: #e1b80e;
			color: #fff;
		}

		.login-card .text-center h4 {
			font-weight: 700;
			font-size: 1.5rem;
			margin-bottom: 1rem;
		}

		.login-card img {
			border-radius: 50%;
			background: #fff;
			padding: 5px;
		}

		.form-control:focus {
			box-shadow: 0 0 0 0.2rem rgba(241, 196, 15, 0.5);
		}

		.form-error {
			font-size: 0.85rem;
		}
	</style>
</head>

<body>
    <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="col-lg-5">
           <div class="card login-card">
                <div class="card-body">
                    <div class="text-center">
                        <img src="<?= base_url('assets/img/avatar.png'); ?>" alt="Avatar" class=" mb-3" style="width: 80px; height: 80px;">
                        <h4>Selamat Datang !!</h4>
                    </div>
                    <?= $this->session->flashdata('message'); ?>
                    <form class="user mt-3" method="post" action="<?= base_url('auth/login'); ?>">
                        <div class="form-group">
                            <input type="text" class="form-control form-control-user" id="email" placeholder="Email" name="email" value="<?= set_value('email'); ?>">
                            <?= form_error('email','<small class="text-danger pl-3">','</small>'); ?>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control form-control-user" id="password" placeholder="Password" name="password">
                            <?= form_error('password','<small class="text-danger pl-3">','</small>'); ?>
                        </div>
						<div class="g-recaptcha" data-sitekey="6Ld_FoYrAAAAAG_TGQN-kjkKwcdUjTMutuh9KcIQ"></div>
                        <button type="submit" class="btn btn-primary btn-user btn-block mt-3">
                            Masuk
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<!-- Bootstrap Core JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Core Theme JS -->
<script src="<?= base_url('assets/js/scripts.js'); ?>"></script>
	<!-- Bootstrap core JavaScript-->
<script src="<?= base_url('assets'); ?>/vendor/jquery/jquery.min.js"></script>
<script src="<?= base_url('assets'); ?>/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="<?= base_url('assets'); ?>/vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="<?= base_url('assets'); ?>/js/sb-admin-2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>

</body>

</html>
