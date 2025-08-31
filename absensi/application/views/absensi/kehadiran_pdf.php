<!DOCTYPE html>
<html>
<head>
    <title>Laporan Kehadiran Siswa</title>
    <style>
        body {
            font-family: "Times New Roman", serif;
            font-size: 12px;
            margin: 20px;
        }

        h3 {
            text-align: center;
            margin-bottom: 10px;
        }

        .info-table {
            border-collapse: collapse;
            width: 50%;
            margin-bottom: 10px;
        }

        .info-table td {
            border: none;
            padding: 3px 5px;
            text-align: left;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 10px;
            font-size: 12px;
        }

        th, td {
            border: 1px solid black;
            padding: 5px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        .ttd {
            margin-top: 50px;
            text-align: right;
        }

        .ttd p {
            margin: 2px 0;
        }
    </style>
</head>
<body>

<?php
    // Konversi nama bulan
    $nama_bulan = $bulan ? date('F', mktime(0, 0, 0, $bulan, 10)) : 'Semua Bulan';
    $semester_txt = $semester ? (($semester == '1') ? 'Semester 1' : 'Semester 2') : 'Semua Semester';
?>

    <h3>Laporan Kehadiran Siswa</h3>

    <!-- Tabel Informasi -->
    <table class="info-table">
        <tr>
            <td><strong>Nama</strong></td>
            <td>:</td>
            <td><?= htmlspecialchars($siswa['nama']); ?></td>
        </tr>
        <tr>
            <td><strong>Kelas</strong></td>
            <td>:</td>
            <td><?= htmlspecialchars($siswa['kelas']); ?></td>
        </tr>
        <tr>
            <td><strong>Mata Pelajaran</strong></td>
            <td>:</td>
            <td><?= htmlspecialchars($nama_mapel); ?></td>
        </tr>
        <tr>
            <td><strong>Tahun Ajaran</strong></td>
            <td>:</td>
            <td><?= htmlspecialchars($tahun_ajaran); ?></td>
        </tr>
        <tr>
            <td><strong>Semester</strong></td>
            <td>:</td>
            <td><?= $semester_txt; ?></td>
        </tr>
        <tr>
            <td><strong>Bulan</strong></td>
            <td>:</td>
            <td><?= $nama_bulan; ?></td>
        </tr>
    </table>

    <!-- Tabel Data Kehadiran -->
    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Status</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($kehadiran)): ?>
                <?php foreach ($kehadiran as $k): ?>
                    <tr>
                        <td><?= date('d-m-Y', strtotime($k['tanggal'])); ?></td>
                        <td><?= htmlspecialchars($k['status']); ?></td>
                        <td><?= htmlspecialchars($k['keterangan']); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="3">Tidak ada data kehadiran.</td></tr>
            <?php endif; ?>
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
                <u><strong>Nama Kepala Sekolah</strong></u><br>
                NIP: 1234567890
            </td>
        </tr>
    </table>

</body>
</html>
