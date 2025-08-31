<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="row">
        <div class="col-lg-6">
            <?= form_open('admin/editSiswa/' . $siswa['id']); ?>

            <div class="form-group">
                <label for="nama">Nama Lengkap</label>
                <input type="text" class="form-control" id="nama" name="nama" value="<?= set_value('nama', $siswa['nama']); ?>">
                <?= form_error('nama', '<small class="text-danger pl-1">', '</small>'); ?>
            </div>

            <div class="form-group">
                <label for="nis">NIS</label>
                <input type="text" class="form-control" id="nis" name="nis" value="<?= set_value('nis', $siswa['nis']); ?>">
                <?= form_error('nis', '<small class="text-danger pl-1">', '</small>'); ?>
            </div>

            <div class="form-group">
                <label for="kelas">Kelas</label>
                <input type="text" class="form-control" id="kelas" name="kelas" value="<?= set_value('kelas', $siswa['kelas']); ?>">
                <?= form_error('kelas', '<small class="text-danger pl-1">', '</small>'); ?>
            </div>

            <div class="form-group">
                <label for="jenis_kelamin">Jenis Kelamin</label>
                <select class="form-control" id="jenis_kelamin" name="jenis_kelamin">
                    <option value="">-- Pilih --</option>
                    <option value="Laki-laki" <?= set_select('jenis_kelamin', 'Laki-laki', $siswa['jenis_kelamin'] == 'Laki-laki'); ?>>Laki-laki</option>
                    <option value="Perempuan" <?= set_select('jenis_kelamin', 'Perempuan', $siswa['jenis_kelamin'] == 'Perempuan'); ?>>Perempuan</option>
                </select>
                <?= form_error('jenis_kelamin', '<small class="text-danger pl-1">', '</small>'); ?>
            </div>

            <button type="submit" class="btn btn-success">Simpan</button>
            <a href="<?= base_url('admin/siswa'); ?>" class="btn btn-secondary">Kembali</a>

            <?= form_close(); ?>
        </div>
    </div>
</div>
