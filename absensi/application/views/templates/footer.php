
            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; SD Swasta 11 Fena Fafan <?= date('Y'); ?></span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="<?= base_url('auth/logout'); ?>">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="<?= base_url('assets/vendor/jquery/jquery.min.js'); ?>"></script>
    <script src="<?= base_url('assets/vendor/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="<?= base_url('assets/vendor/jquery-easing/jquery.easing.min.js'); ?>"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?= base_url('assets/js/sb-admin-2.min.js'); ?>"></script>

	<script>
		$('.form-check-input').on('click', function(){
			const menuId = $(this).data('menu');
			const roleId = $(this).data('role');

			$.ajax({
				url:"<?= base_url('admin/changeaccess'); ?>",
				type: 'post',
				data: {
					menuId: menuId,
					roleId: roleId
				},
				success:function(){
					document.location.href = "<?= base_url('admin/roleaccess/'); ?>" + roleId;
				}
			});
		});
	</script>
	<script>
		document.querySelectorAll('.filter-kelas').forEach(select => {
			select.addEventListener('change', function() {
				const selectedKelas = this.value;
				const tbody = this.closest('.accordion-body').querySelector('tbody');
				const rows = tbody.querySelectorAll('tr');

				rows.forEach(row => {
					const rowKelas = row.getAttribute('data-kelas');
					if (!selectedKelas || rowKelas === selectedKelas) {
						row.style.display = '';
					} else {
						row.style.display = 'none';
					}
				});
			});
		});
	</script>

		<!-- Script Chart.js -->
	<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
	<script>
		const ctx = document.getElementById('siswaChart').getContext('2d');
		const siswaChart = new Chart(ctx, {
			type: 'bar',
			data: {
				labels: <?= json_encode(array_keys($grafik_kelas)); ?>,
				datasets: [{
					label: 'Jumlah Siswa',
					data: <?= json_encode(array_values($grafik_kelas)); ?>,
					backgroundColor: 'rgba(54, 162, 235, 0.7)',
					borderColor: 'rgba(54, 162, 235, 1)',
					borderWidth: 1
				}]
			},
			options: {
				scales: {
					y: { beginAtZero: true }
				}
			}
		});
	</script>

	<script>
		const atx = document.getElementById('statistikChart').getContext('2d');
		const statistikChart = new Chart(atx, {
			type: 'bar',
			data: {
				labels: ['Siswa', 'Guru', 'Mata Pelajaran'],
				datasets: [{
					label: 'Jumlah',
					data: [<?= $total_siswa; ?>, <?= $total_guru; ?>, <?= $total_mapel; ?>],
					backgroundColor: [
						'rgba(54, 162, 235, 0.7)',
						'rgba(255, 206, 86, 0.7)',
						'rgba(75, 192, 192, 0.7)'
					],
					borderColor: [
						'rgba(54, 162, 235, 1)',
						'rgba(255, 206, 86, 1)',
						'rgba(75, 192, 192, 1)'
					],
					borderWidth: 1
				}]
			},
			options: {
				scales: {
					y: { beginAtZero: true }
				}
			}
		});
	</script>

	<script>
		const btx = document.getElementById('statistikjenisChart').getContext('2d');
		const statistikjenisChart = new Chart(btx, {
			type: 'bar',
			data: {
				labels: ['Laki-laki', 'Perempuan'],
				datasets: [{
					label: 'Jumlah Siswa',
					data: [<?= $jumlah_laki ?>, <?= $jumlah_perempuan ?>],
					backgroundColor: ['#4e73df', '#f6c23e'],
					borderColor: ['#2e59d9', '#dda20a'],
					borderWidth: 1
				}]
			},
			options: {
				scales: {
					y: {
						beginAtZero: true,
						ticks: {
							stepSize: 1
						}
					}
				},
				plugins: {
					legend: {
						display: false
					}
				}
			}
		});
	</script>

	<script>
		const ktx = document.getElementById('grafikKehadiran').getContext('2d');

		const chartData = {
			labels: <?= json_encode(array_column($kehadiran, 'mapel')); ?>,
			datasets: [{
				label: 'Hadir',
				data: <?= json_encode(array_column($kehadiran, 'hadir')); ?>,
				backgroundColor: 'rgb(75, 192, 192)'
			}, {
				label: 'Izin',
				data: <?= json_encode(array_column($kehadiran, 'izin')); ?>,
				backgroundColor: 'rgb(50, 220, 12)'
			}, {
				label: 'Sakit',
				data: <?= json_encode(array_column($kehadiran, 'sakit')); ?>,
				backgroundColor: 'rgb(255, 238, 3)'
			}, {
				label: 'Alpha',
				data: <?= json_encode(array_column($kehadiran, 'alpha')); ?>,
				backgroundColor: 'rgb(253, 0, 55)'
			}]
		};

		const chartOptions = {
			responsive: true,
			plugins: {
				legend: {
					position: 'top'
				},
				title: {
					display: false
				}
			},
			scales: {
				x: {
					stacked: true
				},
				y: {
					stacked: true,
					beginAtZero: true
				}
			}
		};

		new Chart(ktx, {
			type: 'bar',
			data: chartData,
			options: chartOptions
		});
	</script>

</body>

</html>
