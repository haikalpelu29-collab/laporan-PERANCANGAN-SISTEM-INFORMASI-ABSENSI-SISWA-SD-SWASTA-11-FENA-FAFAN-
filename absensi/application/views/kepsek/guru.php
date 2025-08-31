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
                                Jumlah Guru</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_guru; ?> orang</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-tie fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

   <!-- Tabel daftar guru dan mata pelajaran -->
	<div class="card shadow mb-4">
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
					<thead>
						<tr class="text-center">
							<th>No</th>
							<th>Nama</th>
							<th>Mata Pelajaran</th>
						</tr>
					</thead>
					<tbody>
						<?php 
						$no = 1;
						$current_guru = '';
						foreach ($guru_mapel as $row): 
							if ($current_guru != $row->nama_guru) {
								if ($current_guru != '') {
									echo "</td></tr>";
								}
								echo "<tr>";
								echo "<td class='text-center'>" . $no++ . "</td>";
								echo "<td>{$row->nama_guru}</td><td>";
								$current_guru = $row->nama_guru;
								echo $row->nama_mapel;
							} else {
								echo ", " . $row->nama_mapel;
							}
						endforeach; 
						if ($current_guru != '') {
							echo "</td></tr>";
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
