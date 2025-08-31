
<!-- Bootstrap Core JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Core Theme JS -->
<script src="<?= base_url('assets/js/scripts.js'); ?>"></script>
	<!-- Bootstrap core JavaScript-->
  <script src="<?= base_url('assets'); ?>/vendor/jquery/jquery.min.js"></script>
    <script src="<?= base_url('assets'); ?>/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?= base_url('assets'); ?>/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?= base_url('assets'); ?>/js/sb-admin-2.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
		<script>
    $(document).ready(function () {
        $('#form-tracking').on('submit', function (e) {
            e.preventDefault();

            var kode = $('#kode').val();

            $.ajax({
                url: "<?= base_url('tracking/cek_status') ?>",
                type: "POST",
                data: {kode: kode},
                success: function (response) {
                    var data = JSON.parse(response);
                    if (data.status !== 'not found') {
                        var html = `
                            <ul class="list-group">
                                <li class="list-group-item">Kode: ${data.kode}</li>
                                <li class="list-group-item">Status: ${data.status}</li>
                                <li class="list-group-item">Tanggal Update: ${data.updated_at}</li>
                            </ul>
                            <div class="progress mt-3">
                                <div class="progress-bar bg-success" role="progressbar" style="width: ${data.progress}%;" aria-valuenow="${data.progress}" aria-valuemin="0" aria-valuemax="100">
                                    ${data.progress}%
                                </div>
                            </div>
                        `;
                    } else {
                        var html = '<div class="alert alert-danger">Kode tidak ditemukan!</div>';
                    }
                    $('#status-tracking').html(html);
                }
            });
        });
    });
</script>

</body>

</html>
