<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

	<a href="<?= base_url('admin/daftar_alpha'); ?>" class="btn btn-warning position-relative">
		<i class="fas fa-bell"></i> Pemberitahuan Siswa Alpha

		<?php if (!empty($notifikasi_alpha)): ?>
			<span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
				<?= count($notifikasi_alpha); ?>
			</span>
		<?php endif; ?>
	</a>
</div>
<div class="row mt-4">
    <!-- Grafik 1 -->
    <div class="col-md-6">
        <div class="card shadow mb-4">
            <div class="card-header bg-primary text-white">
                <h6 class="m-0 font-weight-bold">Grafik Statistik Sekolah</h6>
            </div>
            <div class="card-body">
                <canvas id="statistikChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Grafik 2 -->
    <div class="col-md-6">
        <div class="card shadow mb-4">
            <div class="card-header bg-primary text-white">
                <h6 class="m-0 font-weight-bold">Grafik Jumlah Siswa L/P</h6>
            </div>
            <div class="card-body">
                <canvas id="statistikjenisChart"></canvas>
            </div>
        </div>
    </div>
</div>
<!-- End of Main Content -->
