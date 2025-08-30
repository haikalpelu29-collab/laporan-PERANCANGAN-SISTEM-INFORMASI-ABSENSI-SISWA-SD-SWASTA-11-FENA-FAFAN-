<h3>Filter Siswa Berdasarkan Kelas</h3>
<form method="get" action="<?= base_url('siswa') ?>">
    <input type="text" name="kelas" placeholder="Misal: 5A" />
    <button type="submit">Filter</button>
</form>

<h3>Daftar Siswa</h3>
<a href="<?= base_url('siswa/tambah') ?>">Tambah Siswa</a>
<table border="1">
    <tr><th>Nama</th><th>NIS</th><th>Kelas</th><th>Aksi</th></tr>
    <?php foreach ($siswa as $s): ?>
    <tr>
        <td><?= $s['nama'] ?></td>
        <td><?= $s['nis'] ?></td>
        <td><?= $s['kelas'] ?></td>
        <td>
            <a href="<?= base_url('siswa/edit/'.$s['id']) ?>">Edit</a> |
            <a href="<?= base_url('siswa/hapus/'.$s['id']) ?>" onclick="return confirm('Yakin?')">Hapus</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
