<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success"><?= $this->session->flashdata('success'); ?></div>
    <?php endif; ?>

    <div class="row mt-4">
        <div class="col-lg-8">
            <table class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Mata Pelajaran</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; foreach ($mapel as $m): ?>
                        <tr>
                            <td class="text-center"><?= $i++; ?></td>
                            <td><?= $m['nama_mapel']; ?></td>
							<td class="text-center">
							<a href="<?= base_url(); ?>mapel/lihat/<?= $m['id_mapel']; ?>" class="btn btn-sm btn-success">Absensi</a>
							<a href="<?= base_url(); ?>absensi/laporan/<?= $m['id_mapel']; ?>" class="btn btn-sm btn-primary">Cek Absensi</a>
							</td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if (empty($mapel)): ?>
                        <tr><td colspan="2" class="text-center">Belum ada data.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
