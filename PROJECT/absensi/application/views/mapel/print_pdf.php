<!DOCTYPE html>
<html>
<head>
    <title>Laporan Riwayat Absensi</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #333; padding: 8px; text-align: left; }
        th { background-color: #f5f5f5; }
    </style>
</head>
<body>

<h3 style="text-align: center;">Laporan Riwayat Absensi</h3>

<table>
    <thead>
        <tr>
            <th>Tanggal</th>
            <th>Nama Siswa</th>
            <th>Mata Pelajaran</th>
            <th>Status</th>
            <th>Keterangan</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($riwayat as $r): ?>
        <tr>
            <td><?= date('d-m-Y', strtotime($r['tanggal'])); ?></td>
            <td><?= $r['nama_siswa']; ?></td>
            <td><?= $r['nama_mapel']; ?></td>
            <td><?= $r['status']; ?></td>
            <td><?= $r['keterangan']; ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

</body>
</html>
