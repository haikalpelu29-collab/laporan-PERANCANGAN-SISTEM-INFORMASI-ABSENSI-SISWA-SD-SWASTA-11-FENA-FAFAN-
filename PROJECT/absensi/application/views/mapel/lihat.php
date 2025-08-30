<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <!-- Flash message -->
    <?= $this->session->flashdata('message'); ?>

    <!-- Filter Kelas -->
    <form method="get" class="form-inline mb-3">
        <div class="form-group">
            <label for="kelas" class="mr-2">Filter Kelas:</label>
            <select name="kelas" id="kelas" class="form-control mr-2">
                <option value="">-- Semua Kelas --</option>
                <?php
                $daftar_kelas = ['1A', '1B', '2A', '2B', '3A', '3B','4A', '4B', '5A', '5B', '6A', '6B'];
                foreach ($daftar_kelas as $kelas_option) {
                    $selected = ($kelas_option == $kelas_filter) ? 'selected' : '';
                    echo "<option value='$kelas_option' $selected>$kelas_option</option>";
                }
                ?>
            </select>
            <button type="submit" class="btn btn-primary btn-sm">Tampilkan</button>
        </div>
    </form>

    <!-- Form Absensi -->
    <form action="<?= base_url('mapel/simpan_absensi'); ?>" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id_mapel" value="<?= $mapel['id_mapel']; ?>">

        <div class="form-group col-lg-3">
            <label for="tanggal">Tanggal Absensi</label>
            <input type="date" name="tanggal" class="form-control" required>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="thead-light">
                    <tr>
                        <th>No</th>
                        <th>Nama Siswa</th>
                        <th>NIS</th>
                        <th>Kelas</th>
                        <th>Status</th>
                        <th>Keterangan</th>
                        <th>Upload Surat (Izin/Sakit)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($siswa)) : ?>
                        <tr>
                            <td colspan="7" class="text-center">Tidak ada siswa ditemukan.</td>
                        </tr>
                    <?php else : ?>
                        <?php $i = 1; foreach ($siswa as $index => $s) : ?>
                            <tr>
                                <td><?= $i++; ?></td>
                                <td><?= $s['nama']; ?></td>
                                <td><?= $s['nis']; ?></td>
                                <td><?= $s['kelas']; ?></td>
                                <td>
                                    <select name="status[]" class="form-control" required>
                                        <option value="Hadir">Hadir</option>
                                        <option value="Izin">Izin</option>
                                        <option value="Sakit">Sakit</option>
                                        <option value="Alpha">Alpha</option>
                                    </select>
                                </td>
                                <td>
                                    <input type="text" name="keterangan[]" class="form-control" placeholder="Opsional">
                                    <input type="hidden" name="id_user[]" value="<?= $s['id']; ?>">
                                </td>
                                <td>
									<input type="file" name="surat_sakit_izin[]" class="form-control-file" accept="image/*,.pdf" capture="environment">
								</td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php if (!empty($siswa)) : ?>
            <button type="submit" class="btn btn-success btn-sm">Simpan</button>
        <?php endif; ?>
    </form>
</div>
