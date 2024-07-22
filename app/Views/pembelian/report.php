<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>

<main style="margin-top: 20px;">
    <div class="container-fluid px-4 pt-4" style="background-color: #FFF5F9;">
        <h1 class="mb-4">LAPORAN PEMBELIAN</h1>
        <div class="card mb-4">
            <div class="card-body">
                <!-- Filter -->
                <form action="/beli/laporan/filter" method="post">
                    <div class="container">
                        <div class="row">
                            <div class="col-4">
                                <input type="date" class="form-control" name="tgl_awal"
                                    value="<?= $tanggal['tgl_awal'] ?>" title="Tanggal Awal">
                            </div>
                            <div class="col-4">
                                <input type="date" class="form-control" name="tgl_akhir"
                                    value="<?= $tanggal['tgl_akhir'] ?>" title="Tanggal Akhir">
                            </div>
                            <div class="col-4">
                                <button class="btn btn-primary">Filter</button>
                            </div>
                        </div>
                    </div>
                    </from>
                    <br>
                    <!--- Isi Report --->
                    <a target="_blank" class="btn btn-primary mb-3" type="button"
                        href="<?= base_url('beli/exportpdf') ?>">
                        Export PDF
                    </a>
                    <a class="btn btn-dark mb-3" type="button" href="<?= base_url('beli/exportexcel') ?>">
                        Export Excel
                    </a>
                    <table class="border-table datatables">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>ID Pembelian</th>
                                <th>Pengguna</th>
                                <th>Tanggal Transaksi</th>
                                <th>Total</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        </tbody>
                        <?php $no = 1;
                        foreach ($result as $value): ?>
                        <tr>
                            <td>
                                <?= $no++ ?>
                            </td>
                            <td>
                                <?= $value['ID_Beli'] ?>
                            </td>
                            <td>
                                <?= $value['Nama_Pengguna'] ?>
                            </td>
                            <td>
                                <?= date("d/m/Y H:i:s", strtotime($value['tgl_transaksi'])) ?>
                            </td>
                            <td>
                                <?= number_to_currency($value['total'], 'IDR', 'id_ID', 2) ?>
                            </td>
                            <td><a target="_blank" class="btn btn-primary mb-3" type="button"
                                    href="<?= base_url('beli/notapdf/' . $value['ID_Beli']) ?>">PDF</a>
                                <a target="_blank" class="btn btn-dark mb-3" type="button"
                                    href="<?= base_url('beli/notaexcel/' . $value['ID_Beli']) ?>">Excel</a>
                            </td>
                        </tr>
                        <tr>
                            <td width="75%">
                                <strong>Total Transaksi</strong>
                            </td>
                            <td width="25%">
                                Total
                            </td>
                        </tr>   
                        <?php endforeach; ?>
                        </body>
                    </table>
            </div>
        </div>
    </div>
</main>
<?= $this->endSection() ?>