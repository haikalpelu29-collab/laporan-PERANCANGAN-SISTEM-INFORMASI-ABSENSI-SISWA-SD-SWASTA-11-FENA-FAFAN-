<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <form action="<?= base_url('mapel/update_absensi'); ?>" method="post">
	<input type="hidden" name="id_absensi" value="<?= $absensi['id_absensi']; ?>">
	<input type="hidden" name="id_mapel" value="<?= $absensi['id_mapel']; ?>">
	<input type="hidden" name="tanggal" value="<?= $absensi['tanggal']; ?>">

        <div class="form-group">
            <label>Status</label>
            <select class="form-control" name="status">
                <option value="Hadir" <?= $absensi['status'] == 'Hadir' ? 'selected' : '' ?>>Hadir</option>
                <option value="Sakit" <?= $absensi['status'] == 'Sakit' ? 'selected' : '' ?>>Sakit</option>
                <option value="Izin" <?= $absensi['status'] == 'Izin' ? 'selected' : '' ?>>Izin</option>
                <option value="Alpha" <?= $absensi['status'] == 'Alpha' ? 'selected' : '' ?>>Alpha</option>
            </select>
        </div>

        <div class="form-group">
            <label>Keterangan</label>
            <textarea name="keterangan" class="form-control"><?= $absensi['keterangan']; ?></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
