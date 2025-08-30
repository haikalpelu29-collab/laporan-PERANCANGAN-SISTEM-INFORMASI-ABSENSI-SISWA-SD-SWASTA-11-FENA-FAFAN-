<!DOCTYPE html>
<html>
<head>
    <title>Laporan Alpha</title>
    <style>
        table { width: 100%; border-collapse: collapse; font-size: 12px; }
        th, td { border: 1px solid #000; padding: 5px; }
        th { background-color: #f0f0f0; }
		.no{text-align: center;}
    </style>
</head>
<body>
    <h3 style="text-align: center;">Laporan Siswa Alpha</h3>
    <p>Tahun Ajaran: <?= $tahun_ajaran ?> | Semester: <?= $semester ?></p>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Kelas</th>
                <th>Mata Pelajaran</th>
                <th>Total Alpha</th>
                <th>Tanggal Alpha</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; foreach ($siswa_alpha as $s): ?>
            <tr>
                <td class="no"><?= $no++ ?></td>
                <td><?= $s['nama'] ?></td>
                <td class="no"><?= $s['kelas'] ?></td>
                <td><?= $s['nama_mapel'] ?></td>
                <td class="no"><?= $s['jumlah_alpha'] ?></td>
                <td><?= str_replace('<br>', '<br> ', $s['tanggal_alpha']) ?></td>
            </tr>
            <?php endforeach ?>
        </tbody>
    </table>
	 <!-- Tanda Tangan -->
	 <br><br>
    <table style="width:100%; border: none;">
        <tr>
            <td style="border: none; width: 65%;"></td>
            <td style="border: none; text-align: center;">
                <?= date('d F Y'); ?><br>
                Kepala Sekolah,<br><br><br><br><br>
                <u><strong>Rony R. Tesiatu, S.Pd</strong></u><br>
                NIP: 1234567890
            </td>
        </tr>
    </table>
</body>
</html>
