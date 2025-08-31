<div class="container-fluid">
    <h3><?= $title; ?></h3>
    <h5 class="mb-3"><?= $target_user['name']; ?></h5>

    <?= $this->session->flashdata('message'); ?>

    <table class="table table-hover table-dark">
        <thead>
            <tr>
                <th>No</th>
                <th>Mata Pelajaran</th>
                <th>Access</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; ?>
            <?php foreach ($mata_pelajaran as $mapel) : ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $mapel['nama_mapel']; ?></td>
                    <td>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox"
                                <?= check_mapel_access($user_id, $mapel['id_mapel']); ?>
                                data-user="<?= $user_id; ?>" data-mapel="<?= $mapel['id_mapel']; ?>">
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
