<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <!-- Card Total Guru -->
    <div class="row">
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Jumlah Mata Pelajaran</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_mapel; ?> Pelajaran</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-tie fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

	<div class="row mt-4">
        <div class="col-lg-8">
            <table class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Mata Pelajaran</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; foreach ($mapel as $m): ?>
                        <tr>
                            <td class="text-center"><?= $i++; ?></td>
                            <td><?= $m['nama_mapel']; ?></td>
							<td class="text-center">
							<a href="<?= base_url(); ?>absensi/kepsek/<?= $m['id_mapel']; ?>" class="btn btn-sm btn-primary">Cek Absensi</a>
							</td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if (empty($mapel)): ?>
                        <tr><td colspan="2" class="text-center">Belum ada data.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
