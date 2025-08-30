<?php
$grouped = [];
foreach ($absensi as $row) {
    $grouped[$row->tahun][$row->bulan][$row->tanggal][] = $row;
}
?>

<div class="container mt-4">
    <h2 class="mb-4">📁 Daftar Absensi (Tahun → Bulan → Tanggal)</h2>
	<?= $this->session->flashdata('message'); ?>
    <div class="accordion" id="accordionTahun">
        <?php $tahunIndex = 0; ?>
        <?php foreach ($grouped as $tahun => $bulanData): ?>
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingTahun<?= $tahunIndex ?>">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTahun<?= $tahunIndex ?>" aria-expanded="true">
                        📁 <?= $tahun ?>
                    </button>
                </h2>
                <div id="collapseTahun<?= $tahunIndex ?>" class="accordion-collapse collapse show" data-bs-parent="#accordionTahun">
                    <div class="accordion-body">
                        <div class="accordion" id="accordionBulan<?= $tahunIndex ?>">
                            <?php $bulanIndex = 0; ?>
                            <?php foreach ($bulanData as $bulan => $tanggalData): ?>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingBulan<?= $tahunIndex ?>_<?= $bulanIndex ?>">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseBulan<?= $tahunIndex ?>_<?= $bulanIndex ?>">
                                            📁 <?= date('F', mktime(0, 0, 0, $bulan, 1)) ?>
                                        </button>
                                    </h2>
                                    <div id="collapseBulan<?= $tahunIndex ?>_<?= $bulanIndex ?>" class="accordion-collapse collapse" data-bs-parent="#accordionBulan<?= $tahunIndex ?>">
                                        <div class="accordion-body">
                                            <div class="accordion" id="accordionTanggal<?= $tahunIndex ?>_<?= $bulanIndex ?>">
                                                <?php $tglIndex = 0; ?>
                                                <?php foreach ($tanggalData as $tanggal => $rows): ?>
                                                    <div class="accordion-item">
                                                        <h2 class="accordion-header" id="headingTanggal<?= $tahunIndex ?>_<?= $bulanIndex ?>_<?= $tglIndex ?>">
                                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTanggal<?= $tahunIndex ?>_<?= $bulanIndex ?>_<?= $tglIndex ?>">
                                                                📅 <?= date('d-m-Y', strtotime($tanggal)) ?>
                                                            </button>
                                                        </h2>
                                                        <div id="collapseTanggal<?= $tahunIndex ?>_<?= $bulanIndex ?>_<?= $tglIndex ?>" class="accordion-collapse collapse">
                                                            <div class="accordion-body">
																<!-- Dropdown Filter Kelas -->
																<div class="mb-3">
																	<label for="filterKelas<?= $tahunIndex ?>_<?= $bulanIndex ?>_<?= $tglIndex ?>" class="form-label">Filter berdasarkan kelas:</label>
																	<select class="form-select filter-kelas" id="filterKelas<?= $tahunIndex ?>_<?= $bulanIndex ?>_<?= $tglIndex ?>">
																		<option value="">Semua Kelas</option>
																		<?php
																		$kelasList = array_unique(array_map(function($r) { return $r->kelas; }, $rows));
																		sort($kelasList);
																		foreach ($kelasList as $kelas): ?>
																			<option value="<?= $kelas ?>"><?= $kelas ?></option>
																		<?php endforeach; ?>
																	</select>
																</div>

															<table class="table table-striped table-bordered table-hover">
																<thead class="table-dark">
																	<tr>
																		<th class="text-center">Nama Siswa</th>
																		<th class="text-center">Kelas</th>
																		<th class="text-center">Mata Pelajaran</th>
																		<th class="text-center">Status</th>
																		<th class="text-center">Keterangan</th>
																	</tr>
																</thead>
																<tbody>
																	<?php foreach ($rows as $row): ?>
																		<tr data-kelas="<?= $row->kelas ?>">
																			<td><?= $row->nama_siswa ?></td>
																			<td class="text-center"><?= $row->kelas ?></td>
																			<td><?= $row->nama_mapel ?></td>
																			<td class="text-center"><?= ucfirst($row->status) ?></td>
																			<td><?= $row->keterangan ?></td>
																		</tr>
																	<?php endforeach; ?>
																</tbody>
															</table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php $tglIndex++; ?>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php $bulanIndex++; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php $tahunIndex++; ?>
        <?php endforeach; ?>
    </div>
</div>
