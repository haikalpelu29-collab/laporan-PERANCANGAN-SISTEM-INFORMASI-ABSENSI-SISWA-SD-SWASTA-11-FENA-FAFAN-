<div class="container-fluid">
    <!-- Judul halaman -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
	<!-- Form pencarian -->
	<form method="GET" action="<?= base_url('absensi/siswa'); ?>" class="form-inline mb-3">
		<input type="text" name="keyword" class="form-control mr-2" placeholder="Cari siswa..." value="<?= html_escape($this->input->get('keyword')); ?>">
		<button type="submit" class="btn btn-sm btn-info mr-2">
			<i class="fas fa-search"></i> Cari
		</button>
		<a href="<?= base_url('absensi/siswa'); ?>" class="btn btn-sm btn-secondary">
			<i class="fas fa-sync-alt"></i> Tampilkan Semua
		</a>
	</form>

    <!-- Tabel daftar siswa -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr class="text-center">
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
                                <td class="text-center"><?= $no++; ?></td>
                                <td><?= htmlspecialchars($s['nama']); ?></td>
                                <td class="text-center"><?= htmlspecialchars($s['nis']); ?></td>
                                <td class="text-center"><?= htmlspecialchars($s['kelas']); ?></td>
                                <td ><?= htmlspecialchars($s['jenis_kelamin']); ?></td>
								<td class="text-center">
                                    <a href="<?= base_url('absensi/presentase_siswa/' . $s['id']); ?>" class="btn btn-sm btn-primary">
                                        <i class="fas fa-chart-pie"></i> Lihat Presentase
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
				<div class="mt-3">
					<?= $this->pagination->create_links(); ?>
				</div>
            </div>
        </div>
    </div>
</div>
