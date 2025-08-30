<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
    <?= $this->session->flashdata('message'); ?>

    <a href="<?= base_url('admin/siswa'); ?>" class="btn btn-secondary btn-sm mb-3">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Tahun Ajaran</h6>
            <a href="#formTambah" class="btn btn-primary btn-sm" data-toggle="collapse">
			<i class="fas fa-calendar-alt"></i> Tambah Tahun Ajaran
            </a>
        </div>
        <div class="card-body">
            <div id="formTambah" class="collapse mb-3">
                <form action="<?= base_url('absensi/tambah'); ?>" method="post" class="form-inline">
                    <input type="text" name="nama_tahun" class="form-control mr-2" placeholder="Contoh: 2025/2026" required>
                    <button type="submit" class="btn btn-success btn-sm">Simpan</button>
                </form>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="thead-light text-center">
                        <tr>
                            <th>No</th>
                            <th>Nama Tahun Ajaran</th>
                            <th>Status Aktif</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach ($tahun_ajaran as $ta): ?>
                            <tr class="text-center">
                                <td><?= $no++; ?></td>
                                <td><?= htmlspecialchars($ta['nama_tahun']); ?></td>
                                <td>
                                    <?php if ($ta['aktif'] == 'Ya'): ?>
                                        <span class="badge badge-success">Aktif</span>
                                    <?php else: ?>
                                        <a href="<?= base_url('admin/setTahunAktif/' . $ta['id']); ?>" class="btn btn-outline-primary btn-sm">Jadikan Aktif</a>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="<?= base_url('admin/editTahunAjaran/' . $ta['id']); ?>" class="btn btn-success btn-sm">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <a href="<?= base_url('admin/hapusTahunAjaran/' . $ta['id']); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?');">
                                        <i class="fas fa-trash"></i> Hapus
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
