<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
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
            </table>
        </div>
    </div>
	<!-- Grafik Kehadiran -->
	<div class="card shadow mb-4">
		<div class="card-body">
			<h5 class="text-center">Grafik Kehadiran Siswa per Mata Pelajaran</h5>
			<canvas id="grafikKehadiran" height="100"></canvas>
		</div>
	</div>

    <?php if ($this->session->flashdata('message')): ?>
        <?= $this->session->flashdata('message'); ?>
    <?php endif; ?>

    <!-- Filter Tahun Ajaran dan Semester -->
    <div class="card shadow mt-1">
        <div class="card-body">
            <form method="get" action="">
                <div class="row mb-3">
                    <div class="col-md-3">
                        <label for="tahun_ajaran">Tahun Ajaran</label>
                        <select name="tahun_ajaran" class="form-control">
                            <option value="">-- Pilih Tahun Ajaran --</option>
                            <?php foreach ($tahun_ajaran_list as $ta): ?>
                                <option value="<?= $ta['nama_tahun']; ?>" <?= ($tahun_ajaran_terpilih == $ta['nama_tahun']) ? 'selected' : ''; ?>>
                                    <?= $ta['nama_tahun']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="semester">Semester</label>
                        <select name="semester" id="semester" class="form-control">
                            <option value="">-- Pilih Semester --</option>
                            <option value="1" <?= ($this->input->get('semester') == '1') ? 'selected' : ''; ?>>1</option>
                            <option value="2" <?= ($this->input->get('semester') == '2') ? 'selected' : ''; ?>>2</option>
                        </select>
                    </div>
                    <div class="col-md-3 mt-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary btn-sm">Filter</button>
						<a href="<?= base_url('absensi/export_siswa?siswa_id=' . $siswa['id'] . '&tahun_ajaran=' . $tahun_ajaran_terpilih . '&semester=' . $this->input->get('semester')); ?>" class="btn btn-danger ml-2 btn-sm" target="_blank">
							Export PDF
						</a>
                    </div>
                </div>
            </form>

            <!-- Tabel Data -->
            <table class="table table-bordered table-striped">
                <thead class="thead-light text-center">
                    <tr>
                        <th>No</th>
                        <th>Mata Pelajaran</th>
                        <th>Hadir</th>
                        <th>Izin</th>
                        <th>Sakit</th>
                        <th>Alpha</th>
                        <th>Total Pertemuan</th>
                        <th>Persentase (%)</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($kehadiran)): ?>
                        <?php $no = 1; foreach ($kehadiran as $k): ?>
                            <tr class="text-center">
                                <td><?= $no++; ?></td>
                                <td class="text-left"><?= htmlspecialchars($k['mapel']); ?></td>
                                <td><?= $k['hadir']; ?></td>
                                <td><?= $k['izin']; ?></td>
                                <td><?= $k['sakit']; ?></td>
                                <td><?= $k['alpha']; ?></td>
                                <td><?= $k['total']; ?></td>
                                <td><?= $k['presentase']; ?>%</td>
								<td>
									<a href="<?= base_url('absensi/detail_kehadiran?siswa_id=' . $siswa['id'] . '&mapel_id=' . $k['id_mapel'] . '&tahun_ajaran=' . urlencode($tahun_ajaran_terpilih) . '&semester=' . $semester_terpilih); ?>" 
									class="badge badge-primary" style="text-decoration: none;">
									Detail
									</a>
								</td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="9" class="text-center text-muted">Tidak ada data kehadiran.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
