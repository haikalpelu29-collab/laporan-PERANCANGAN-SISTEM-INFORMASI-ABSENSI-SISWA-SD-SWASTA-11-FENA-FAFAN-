<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title> <?= $title; ?> </title>

    <!-- Custom fonts dan style -->
    <link href="<?= base_url('assets'); ?>/vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="<?= base_url('assets'); ?>/css/sb-admin-2.min.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="<?= base_url('assets/favicon.ico'); ?>" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" />
    <link href="<?= base_url('assets/css/styles.css'); ?>" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css">

    <style>
        body {
            background: url('<?= base_url("assets/img/bg-pendidikan.png"); ?>') no-repeat center center fixed;
            background-size: cover;
        }
    </style>
</head>

<body>
    <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="col-lg-5">
            <div class="card border-0 shadow-lg" style="background: rgb(199, 196, 196); backdrop-filter: blur(10px);">
                <div class="card-body p-4">
                    <div class="text-center">
                        <img src="<?= base_url('assets/img/avatar.png'); ?>" alt="Avatar" class="mb-3" style="width: 80px; height: 80px;">
                        <h4>Daftar Akun</h4>
                    </div>
                    <?= $this->session->flashdata('message'); ?>
                    <form class="user mt-3" method="post" action="<?= base_url('auth/registrasi'); ?>">
                        <div class="form-group">
                            <input type="text" class="form-control form-control-user" id="name" name="name"
                                   placeholder="Nama Lengkap" value="<?= set_value('name'); ?>">
                            <?= form_error('name', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control form-control-user" id="no_hp" name="no_hp"
                                   placeholder="No Hp" value="<?= set_value('no_hp'); ?>">
                            <?= form_error('no_hp', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control form-control-user" id="email" name="email"
                                   placeholder="Email" value="<?= set_value('email'); ?>">
                            <?= form_error('email', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <input type="password" class="form-control form-control-user"
                                       id="password1" name="password1" placeholder="Password">
                                <?= form_error('password1', '<small class="text-danger pl-3">', '</small>'); ?>
                            </div>
                            <div class="col-sm-6">
                                <input type="password" class="form-control form-control-user"
                                       id="password2" name="password2" placeholder="Konfirmasi Password">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-user btn-block">
                            Daftar
                        </button>
                    </form>
                    <div class="text-center mt-3">
                        <a class="small" href="<?= base_url('auth/login'); ?>" style="text-decoration: none;">Sudah punya akun? Masuk!</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JS -->
    <script src="<?= base_url('assets'); ?>/vendor/jquery/jquery.min.js"></script>
    <script src="<?= base_url('assets'); ?>/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url('assets'); ?>/vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="<?= base_url('assets'); ?>/js/sb-admin-2.min.js"></script>
    <script src="<?= base_url('assets/js/scripts.js'); ?>"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
</body>

</html>
