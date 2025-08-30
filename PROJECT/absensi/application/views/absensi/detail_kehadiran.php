<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

	<!-- Tombol Export PDF -->
	<div class=" mt-3 mb-3">
		<a href="<?= base_url('absensi/export_pdf_kehadiran?siswa_id=' . $this->input->get('siswa_id') . '&mapel_id=' . $this->input->get('mapel_id') . '&tahun_ajaran=' . $this->input->get('tahun_ajaran') . '&semester=' . $this->input->get('semester') . '&bulan=' . $this->input->get('bulan')) ?>" target="_blank" class="btn btn-sm btn-danger">
			<i class="fas fa-file-pdf"></i> Export PDF
		</a>
	</div>

    <!-- Tabel Identitas Siswa -->
    <div class="card shadow mb-3">
        <div class="card-body p-3">
            <table class="table table-bordered table-striped" style="border: none;">
                <tr>
                    <th width="25%">Nama</th>
					<td class="text-center" width="5%">:</td>
                    <td><?= htmlspecialchars($siswa['nama']); ?></td>
                </tr>
                <tr>
                    <th>Kelas</th>
					<td class="text-center">:</td>
                    <td><?= htmlspecialchars($siswa['kelas']); ?></td>
                </tr>
                <tr>
                    <th>Mata Pelajaran</th>
					<td class="text-center">:</td>
                    <td><?= htmlspecialchars($nama_mapel); ?></td>
                </tr>
            </table>
        </div>
    </div>

    <!-- Filter Form -->
    <div class="card mb-3 shadow">
        <div class="card-body">
            <form method="get" action="">
                <input type="hidden" name="siswa_id" value="<?= $this->input->get('siswa_id'); ?>">
                <input type="hidden" name="mapel_id" value="<?= $this->input->get('mapel_id'); ?>">
                <div class="row">
                    <!-- Tahun Ajaran -->
                    <div class="col-md-4">
                        <label for="tahun_ajaran">Tahun Ajaran</label>
                        <select name="tahun_ajaran" class="form-control" required>
                            <option value="">-- Pilih Tahun Ajaran --</option>
                            <?php foreach ($tahun_ajaran_list as $ta): ?>
                                <option value="<?= $ta['nama_tahun']; ?>" <?= ($this->input->get('tahun_ajaran') == $ta['nama_tahun']) ? 'selected' : ''; ?>>
                                    <?= $ta['nama_tahun']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Semester -->
                    <div class="col-md-3">
                        <label for="semester">Semester</label>
                        <select name="semester" class="form-control" required>
                            <option value="">-- Pilih Semester --</option>
                            <option value="1" <?= ($this->input->get('semester') == '1') ? 'selected' : ''; ?>>1</option>
                            <option value="2" <?= ($this->input->get('semester') == '2') ? 'selected' : ''; ?>>2</option>
                        </select>
                    </div>

                    <!-- Bulan -->
                    <div class="col-md-3">
                        <label for="bulan">Bulan</label>
                        <select name="bulan" class="form-control">
                            <option value="">-- Semua Bulan --</option>
                            <?php
                            $bulanList = [
                                '01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April',
                                '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus',
                                '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
                            ];
                            foreach ($bulanList as $num => $nama): ?>
                                <option value="<?= $num; ?>" <?= ($this->input->get('bulan') == $num) ? 'selected' : ''; ?>>
                                    <?= $nama; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-sm btn-primary mt-2 w-100">Tampilkan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabel Kehadiran -->
    <div class="card shadow">
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead class="thead-light text-center">
                    <tr>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($kehadiran)): ?>
                        <?php foreach ($kehadiran as $k): ?>
                            <tr class="text-center">
                                <td><?= date('d-m-Y', strtotime($k['tanggal'])); ?></td>
                                <td><?= $k['status']; ?></td>
                                <td><?= $k['keterangan']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3" class="text-center text-muted">Tidak ada data kehadiran.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
			<!-- Pagination -->
			<?php if (!empty($pagination)): ?>
				<div class="mt-3">
					<?= $pagination; ?>
				</div>
			<?php endif; ?>
        </div>
    </div>
</div>
