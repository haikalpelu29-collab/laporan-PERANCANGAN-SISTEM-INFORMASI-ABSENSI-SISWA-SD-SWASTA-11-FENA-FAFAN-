<h1 class="h3 mb-4 ml-3 text-gray-800"><?= $title; ?></h1>
<form method="GET" class="form-inline mb-4 ml-3 pb-2 pl-1" style="background-color: aqua; border-radius:10px">
	<div>
		<label class="mr-2"><strong>Bulan:</strong></label>
		<select name="bulan" class="form-control mr-3">
			<option value="">-- Semua Bulan --</option>
			<?php for ($b = 1; $b <= 12; $b++): ?>
				<option value="<?= $b ?>" <?= $b == $this->input->get('bulan') ? 'selected' : '' ?>>
					<?= date('F', mktime(0, 0, 0, $b, 10)); ?>
				</option>
			<?php endfor; ?>
		</select>
	</div>
	<div>
		<label class="mr-2"><strong>Kelas:</strong></label>
		<select name="kelas" class="form-control mr-3">
			<option value="">-- Semua Kelas --</option>
			<?php foreach ($kelasList as $k): ?>
				<option value="<?= $k['kelas'] ?>" <?= $k['kelas'] == $this->input->get('kelas') ? 'selected' : '' ?>>
					<?= $k['kelas'] ?>
				</option>
			<?php endforeach; ?>
		</select>
	</div>
	<div>
		<label class="mr-2"><strong>Mata Pelajaran:</strong></label>
		<select name="mapel" class="form-control mr-3">
			<option value="">-- Semua Mapel --</option>
			<?php foreach ($mapelList as $m): ?>
				<option value="<?= $m['id_mapel'] ?>" <?= $m['id_mapel'] == $this->input->get('mapel') ? 'selected' : '' ?>>
					<?= htmlspecialchars($m['nama_mapel']) ?>
				</option>
			<?php endforeach; ?>
		</select>
	</div>
	<div>
		<label class="mr-2"><strong>Tahun Ajaran:</strong></label>
		<select name="tahun_ajaran" class="form-control mr-3">
			<option value="">-- Semua Tahun --</option>
			<?php foreach ($tahun_ajaran_list as $ta): ?>
				<option value="<?= $ta['nama_tahun']; ?>" <?= $ta['nama_tahun'] == $this->input->get('tahun_ajaran') ? 'selected' : '' ?>>
					<?= $ta['nama_tahun']; ?>
				</option>
			<?php endforeach; ?>
		</select>
	</div>
	<div>
		<label class="mr-2"><strong>Semester:</strong></label>
		<select name="semester" class="form-control mr-3">
			<option value="">-- Semua Semester --</option>
			<option value="1" <?= $this->input->get('semester') == '1' ? 'selected' : ''; ?>>1</option>
			<option value="2" <?= $this->input->get('semester') == '2' ? 'selected' : ''; ?>>2</option>
		</select>
	</div>

	<button type="submit" class="btn btn-primary btn-sm">Filter</button>

	<a href="<?= base_url('absensi/export_pdf?bulan=' . $this->input->get('bulan') . '&kelas=' . $this->input->get('kelas') . '&mapel=' . $this->input->get('mapel') . '&tahun_ajaran=' . $this->input->get('tahun_ajaran') . '&semester=' . $this->input->get('semester')); ?>" 
	class="btn btn-danger ml-3 btn-sm" target="_blank">
		Export PDF
	</a>
</form>
<div class="table-responsive ml-3">
    <table class="table table-bordered table-striped">
        <thead>
            <tr class="text-center">
                <th>No</th>
                <th>Nama Siswa</th>
                <th>Kelas</th>
                <th>Mata Pelajaran</th>
                <th>Hadir</th>
                <th>Izin</th>
                <th>Sakit</th>
                <th>Alpha</th>
                <th>Total Pertemuan</th>
                <th>Persentase</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($persentase_mapel)): ?>
                <tr>
                    <td colspan="10" class="text-center">Data tidak ditemukan</td>
                </tr>
            <?php else: ?>
                <?php $no = $start + 1; foreach ($persentase_mapel as $p): ?>
                    <tr>
                        <td class="text-center"><?= $no++; ?></td>
                        <td><?= htmlspecialchars($p['nama_siswa']); ?></td>
                        <td class="text-center"><?= htmlspecialchars($p['kelas']); ?></td>
                        <td><?= htmlspecialchars($p['nama_mapel']); ?></td>
                        <td class="text-center"><?= $p['hadir']; ?></td>
                        <td class="text-center"><?= $p['izin']; ?></td>
                        <td class="text-center"><?= $p['sakit']; ?></td>
                        <td class="text-center"><?= $p['alpha']; ?></td>
                        <td class="text-center"><?= $p['total']; ?></td>
                        <td class="text-center"><?= ($p['total'] > 0) ? round(($p['hadir'] / $p['total']) * 100, 2) . '%' : '0%' ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<div class="mt-3 ml-3">
	<?= $pagination; ?>
</div>	

