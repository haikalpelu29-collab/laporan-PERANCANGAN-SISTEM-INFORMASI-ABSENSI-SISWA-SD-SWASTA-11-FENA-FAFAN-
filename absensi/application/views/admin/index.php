<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $title; ?></h1>
    </div>

    <!-- Content Row -->
    <div class="row">
		 <!-- Optional Row - Bisa ditambah grafik, info penting, atau berita -->
		 <div class="row">
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 bg-primary text-white">
                    <h6 class="m-0 font-weight-bold">Selamat Datang di Sistem Informasi SD Swasta 11 Fena Fafan !</h6>
                </div>
                <div class="card-body">
                    <p>Halo, <strong><?= $user['name']; ?></strong>! Anda login sebagai <strong><?= $user['role_id'] == 1 ? 'Administrator' : 'User'; ?></strong>.</p>
                    <p>Gunakan menu di sebelah kiri untuk mengelola data seperti siswa, guru, absensi, dan lainnya.</p>
                </div>
            </div>
        </div>
		 <!-- Total Siswa -->
		 <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Siswa</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_siswa; ?> Orang</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-graduate fa-2x text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Guru -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Total Guru</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_guru; ?> Orang</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-chalkboard-teacher fa-2x text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pengguna Login -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Mata Pelajaran</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_mapel; ?> Mata Pelajaran</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-circle fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
		<!-- Grafik Jumlah Siswa per Kelas -->
		<div class="row text-center">
			<div class="col-lg-8 mx-auto">
				<div class="card shadow mb-4">
					<div class="card-header py-3 bg-info text-white">
						<h6 class="m-0 font-weight-bold">Grafik Jumlah Siswa per Kelas</h6>
					</div>
					<div class="card-body">
						<canvas id="siswaChart"></canvas>
					</div>
				</div>
			</div>
		</div>
    </div>
</div>
<!-- /.container-fluid -->
