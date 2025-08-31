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

        .table-info {
            width: 40%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        .table-info td {
            border: none;
            padding: 2px 5px;
            text-align: left;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 12px;
        }

        th, td {
            border: 1px solid #000;
            padding: 6px;
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

    <h3>LAPORAN KEHADIRAN SISWA</h3>

    <!-- Informasi Siswa -->
    <table class="table-info">
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
            <td><strong>Tahun Ajaran</strong></td>
            <td>:</td>
            <td><?= $tahun_ajaran_terpilih; ?></td>
        </tr>
        <tr>
            <td><strong>Semester</strong></td>
            <td>:</td>
            <td><?= $semester; ?></td>
        </tr>
    </table>

    <!-- Tabel Kehadiran -->
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Mata Pelajaran</th>
                <th>Hadir</th>
                <th>Izin</th>
                <th>Sakit</th>
                <th>Alpha</th>
                <th>Total</th>
                <th>Persentase (%)</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; foreach ($kehadiran as $k): ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= htmlspecialchars($k['mapel']); ?></td>
                    <td><?= $k['hadir']; ?></td>
                    <td><?= $k['izin']; ?></td>
                    <td><?= $k['sakit']; ?></td>
                    <td><?= $k['alpha']; ?></td>
                    <td><?= $k['total']; ?></td>
                    <td>
                        <?= ($k['total'] > 0) ? round(($k['hadir'] / $k['total']) * 100, 2) . '%' : '0%'; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($kehadiran)): ?>
                <tr>
                    <td colspan="8">Tidak ada data kehadiran.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Tanda Tangan -->
    <br><br>
    <table style="width:100%; border: none;">
        <tr>
            <td style="border: none; width: 70%;"></td>
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
