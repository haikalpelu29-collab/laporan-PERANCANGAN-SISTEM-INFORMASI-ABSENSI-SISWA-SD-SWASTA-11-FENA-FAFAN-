<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <!-- Filter Tahun Ajaran dan Semester -->
    <div class="card shadow mb-4">
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
                        <select name="semester" class="form-control">
                            <option value="">-- Pilih Semester --</option>
                            <option value="1" <?= ($semester_terpilih == '1') ? 'selected' : ''; ?>>1</option>
                            <option value="2" <?= ($semester_terpilih == '2') ? 'selected' : ''; ?>>2</option>
                        </select>
                    </div>
                    <div class="col-md-3 mt-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary btn-sm">Filter</button>
                        <a href="<?= base_url('admin/daftar_alpha'); ?>" class="btn btn-secondary btn-sm ml-2">Reset</a>
						<a href="<?= base_url('admin/export_alpha_pdf?tahun_ajaran=' . $tahun_ajaran_terpilih . '&semester=' . $semester_terpilih); ?>" 
						class="btn btn-danger btn-sm ml-2" target="_blank">
						Export PDF
						</a>

                    </div>
                </div>
            </form>

            <!-- Tabel Daftar Alpha -->
            <div class="table-responsive">
                <table class="table table-bordered table-striped text-center">
                    <thead class="thead-dark">
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Kelas</th>
                            <th>Mata Pelajaran</th>
                            <th>Total Alpha</th>
							<th>Tanggal Alpha</th>
                        </tr>
                    </thead>
                    <tbody>
						<?php if (!empty($siswa_alpha)): ?>
							<?php $no = ($this->input->get('per_page') ?? 0) + 1; foreach ($siswa_alpha as $s): ?>
								<tr>
									<td><?= $no++; ?></td>
									<td class="text-left"><?= htmlspecialchars($s['nama']); ?></td>
									<td><?= htmlspecialchars($s['kelas']); ?></td>
									<td class="text-left"><?= htmlspecialchars($s['nama_mapel']); ?></td>
									<td><?= $s['jumlah_alpha']; ?> kali</td>
									<td class="text-left"><?= $s['tanggal_alpha']; ?></td>
								</tr>
							<?php endforeach; ?>
						<?php else: ?>
							<tr>
								<td colspan="6" class="text-muted text-center">Tidak ada siswa yang alpha lebih dari 3 kali.</td>
							</tr>
						<?php endif; ?>
					</tbody>
                </table>
            </div>
			<div class="mt-3 text-center">
				<?= $pagination; ?>
			</div>
        </div>
    </div>
</div>
