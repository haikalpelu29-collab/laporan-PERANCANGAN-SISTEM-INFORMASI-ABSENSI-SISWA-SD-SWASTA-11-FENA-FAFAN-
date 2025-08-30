<div class="container mt-4">
    <h3>Selamat Datang, <strong><?= $user['name']; ?></strong></h3>

    <div class="row mt-3">
        <div class="col-md-4">
            <img src="<?= base_url('assets/img/profile/') . $user['image']; ?>" class="img-thumbnail">
        </div>
        <div class="col-md-8">
            <ul class="list-group">
                <li class="list-group-item"><strong>Nama:</strong> <?= $user['name']; ?></li>
                <li class="list-group-item"><strong>Email:</strong> <?= $user['email']; ?></li>
                <li class="list-group-item"><strong>No HP:</strong> <?= $user['no_hp']; ?></li>
                <li class="list-group-item"><strong>Aktif Sejak:</strong> <?= date('d M Y', $user['date_created']); ?></li>
            </ul>
        </div>
    </div>

    <a href="<?= base_url('user/edit'); ?>" class="btn btn-primary mt-3">Edit Profil</a>
    <a href="<?= base_url('user/changepassword'); ?>" class="btn btn-warning mt-3">Ganti Password</a>
</div>
