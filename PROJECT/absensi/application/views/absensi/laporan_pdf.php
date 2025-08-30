<!DOCTYPE html>
<html>
<head>
    <title>Laporan Persentase Kehadiran</title>
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
    $nama_bulan = (!empty($_GET['bulan']))
        ? date('F', mktime(0, 0, 0, $_GET['bulan'], 10))
        : 'Semua Bulan';

    $kelas = !empty($_GET['kelas']) ? $_GET['kelas'] : 'Semua Kelas';
    $mapel = (!empty($_GET['mapel']) && !empty($persentase_mapel[0]['nama_mapel']))
        ? htmlspecialchars($persentase_mapel[0]['nama_mapel'])
        : 'Semua Mapel';

    $tahun_ajaran = !empty($_GET['tahun_ajaran']) ? $_GET['tahun_ajaran'] : 'Semua Tahun Ajaran';
    $semester = !empty($_GET['semester'])
        ? (($_GET['semester'] == '1') ? 'Semester 1' : 'Semester 2')
        : 'Semua Semester';
?>

    <h3>Laporan Persentase Kehadiran Siswa</h3>

    <!-- Tabel Informasi -->
    <table class="info-table">
        <tr>
            <td><strong>Tahun Ajaran</strong></td>
            <td>:</td>
            <td><?= $tahun_ajaran; ?></td>
        </tr>
        <tr>
            <td><strong>Semester</strong></td>
            <td>:</td>
            <td><?= $semester; ?></td>
        </tr>
        <tr>
            <td><strong>Bulan</strong></td>
            <td>:</td>
            <td><?= $nama_bulan; ?></td>
        </tr>
        <tr>
            <td><strong>Kelas</strong></td>
            <td>:</td>
            <td><?= $kelas; ?></td>
        </tr>
        <tr>
            <td><strong>Mata Pelajaran</strong></td>
            <td>:</td>
            <td><?= $mapel; ?></td>
        </tr>
    </table>

    <!-- Tabel Data Kehadiran -->
    <table>
        <thead>
            <tr>
                <th>Nama Siswa</th>
                <th>Kelas</th>
                <th>Mata Pelajaran</th>
                <th>Hadir</th>
                <th>Izin</th>
                <th>Sakit</th>
                <th>Alpha</th>
                <th>Total Pertemuan</th>
                <th>Persentase</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($persentase_mapel as $p): ?>
                <tr>
                    <td><?= htmlspecialchars($p['nama_siswa']); ?></td>
                    <td><?= htmlspecialchars($p['kelas']); ?></td>
                    <td><?= htmlspecialchars($p['nama_mapel']); ?></td>
                    <td><?= $p['hadir']; ?></td>
                    <td><?= $p['izin']; ?></td>
                    <td><?= $p['sakit']; ?></td>
                    <td><?= $p['alpha']; ?></td>
                    <td><?= $p['total']; ?></td>
                    <td>
                        <?= ($p['total'] > 0) ? round(($p['hadir'] / $p['total']) * 100, 2) . '%' : '0%'; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($persentase_mapel)): ?>
                <tr>
                    <td colspan="9">Tidak ada data kehadiran.</td>
                </tr>
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
