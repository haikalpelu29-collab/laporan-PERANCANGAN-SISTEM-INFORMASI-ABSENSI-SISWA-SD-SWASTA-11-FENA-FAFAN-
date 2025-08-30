<div class="container-fluid">
    <!-- Judul halaman -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <!-- Pesan flash -->
    <?= $this->session->flashdata('message'); ?>

    <!-- Tombol tambah siswa -->
    <a href="<?= base_url('admin/tambahSiswa'); ?>" class="btn btn-primary mb-3 btn-sm">
        <i class="fas fa-user-plus"></i> Tambah Siswa
    </a>
	<!-- Tombol Kelola Tahun Ajaran -->
	<a href="<?= base_url('admin/tahunajaran'); ?>" class="btn btn-info btn-sm mb-3">
		<i class="fas fa-calendar-alt"></i> Kelola Tahun Ajaran
	</a>

	<!-- Form pencarian -->
	<form method="GET" action="<?= base_url('admin/siswa'); ?>" class="form-inline mb-3">
		<input type="text" name="keyword" class="form-control mr-2" placeholder="Cari siswa..." value="<?= html_escape($this->input->get('keyword')); ?>">
		<button type="submit" class="btn btn-sm btn-info mr-2">
			<i class="fas fa-search"></i> Cari
		</button>
		<a href="<?= base_url('admin/siswa'); ?>" class="btn btn-sm btn-secondary">
			<i class="fas fa-sync-alt"></i> Tampilkan Semua
		</a>
	</form>

    <!-- Tabel daftar siswa -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>NIS</th>
                            <th>Kelas</th>
                            <th>Jenis Kelamin</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
					<?php $no = $start + 1; ?>
                        <?php foreach ($siswa as $s): ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= htmlspecialchars($s['nama']); ?></td>
                                <td><?= htmlspecialchars($s['nis']); ?></td>
                                <td><?= htmlspecialchars($s['kelas']); ?></td>
                                <td><?= htmlspecialchars($s['jenis_kelamin']); ?></td>
                                <td>
                                    <a href="<?= base_url('admin/editSiswa/' . $s['id']); ?>" class="btn btn-success btn-sm">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <a href="<?= base_url('admin/hapusSiswa/' . $s['id']); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data siswa ini?');">
                                        <i class="fas fa-trash"></i> Hapus
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <?php if (empty($siswa)): ?>
                            <tr>
                                <td colspan="6" class="text-center text-muted">Belum ada data siswa.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
				<div class="mt-3 text-center">
					<?= $this->pagination->create_links(); ?>
				</div>
            </div>
        </div>
    </div>
</div>
