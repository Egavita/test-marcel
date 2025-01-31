<html>

<head>
    <style>
        .title {
            text-align: center;
            font-family: Arial, Helvetica, sans-serif;
        }

        .left {
            text-align: left;
        }

        .right {
            text-align: right;
        }

        .border-table {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
            text-align: center;
            font-size: 12px;
        }

        .border-table th {
            border: 1px solid #000;
            background-color: #e1e3e9;
            font-weight: bold;
        }

        .border-table td {
            border: 1px solid #000;
        }
    </style>
</head>

<body>
    <main>
        <div class="title">
            <h1>LAPORAN TRANSAKSI</h1>
        </div>
        <div>
            <table class="border-table">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th width="15%">No Transaksi</th>
                        <th width="15%">Pengguna</th>
                        <th width="15%">Tanggal Transaksi</th>
                        <th width="15%">Pelanggan</th>
                        <th width="20%">Layanan</th>
                        <th width="15%">Total</th>

                    </tr>
                </thead>
                <?php $no = 1;
                foreach ($result as $value) : ?>
                    <tr>
                        <td width="5%"><?= $no++ ?></td>
                        <td width="15%"><?= $value['No_Transaksi'] ?></td>
                        <td width="15%"><?= $value['Nama_Pengguna'] ?></td>
                        <td width="15%"><?= date("d/m/y H:i:s", strtotime($value['tgl_transaksi'])) ?></td>
                        <td width="15%"><?= $value['Nama_Pelanggan'] ?></td>
                        <td width="20%"><?= $value['Nama_Layanan'] ?></td>
                        <td width="15%"><?= number_to_currency($value['total'], 'IDR', 'id_ID', 2) ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </main>
</body>

</html>