<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
    <?= $this->session->flashdata('message'); ?>

    <a href="<?= base_url('admin/tahunajaran'); ?>" class="btn btn-secondary btn-sm mb-3">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>

    <div class="card shadow">
        <div class="card-body">
            <form action="" method="post">
                <div class="form-group">
                    <label for="nama_tahun">Nama Tahun Ajaran</label>
                    <input type="text" name="nama_tahun" class="form-control" id="nama_tahun" value="<?= $tahun['nama_tahun']; ?>" required>
                </div>
                <div class="form-group form-check">
                    <input type="checkbox" class="form-check-input" name="aktif" id="aktif" value="Ya" <?= ($tahun['aktif'] == 'Ya') ? 'checked' : ''; ?>>
                    <label class="form-check-label" for="aktif">Jadikan Tahun Ajaran Aktif</label>
                </div>
                <button type="submit" class="btn btn-primary btn-sm mt-2">Simpan Perubahan</button>
            </form>
        </div>
    </div>
</div>
