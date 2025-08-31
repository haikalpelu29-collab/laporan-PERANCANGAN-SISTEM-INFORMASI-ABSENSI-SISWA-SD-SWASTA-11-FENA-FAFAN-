<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

   
    <a href="<?= base_url('mapel/export_pdf'); ?>" class="btn btn-danger mb-3"><i class="fas fa-file-pdf"></i> Export PDF</a>

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Nama Siswa</th>
                    <th>Mata Pelajaran</th>
                    <th>Status</th>
                    <th>Keterangan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($riwayat as $r) : ?>
                    <tr>
                        <td><?= date('d-m-Y', strtotime($r['tanggal'])); ?></td>
                        <td><?= $r['nama_siswa']; ?></td>
                        <td><?= $r['nama_mapel']; ?></td>
                        <td><?= $r['status']; ?></td>
                        <td><?= $r['keterangan']; ?></td>
                        <td>
                            <a href="<?= base_url('mapel/edit_absensi/' . $r['id_absensi']); ?>" class="btn btn-sm btn-warning">Edit</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
