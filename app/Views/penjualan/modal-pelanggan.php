<!-- ISI POS -->
<div class="modal fade" id="modalPelanggan" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalToggleLabel">DATA PELANGGAN</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Tabel Pelanggan -->
                <table class="datatablesSimple">
                    <thead>
                        <tr>
                            <th width=10%>No</th>
                            <th width=20%>ID Pelanggan</th>
                            <th width=30%>Nama Pelanggan</th>
                            <th width=25%>No HP</th>
                            <th width=15%>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        foreach ($cust as $value) : ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $value['ID_Pelanggan'] ?></td>
                                <td><?= $value['Nama_Pelanggan'] ?></td>
                                <td><?= $value['No_HP'] ?></td>
                                <td>
                                    <button onclick="selectPelanggan('<?= $value['ID_Pelanggan'] ?>',
                                    '<?= $value['Nama_Pelanggan'] ?>')" class="btn btn-success"><i class="fa fa-cart-plus"></i> Tambahkan</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <!-- END Tabel Pelanggan -->
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
<!-- END ISI POS -->

<script>
    function selectPelanggan(id, name) {
        $('#ID_Pelanggan').val(id);
        $('#Nama_Pelanggan').val(name);
        $('#modalPelanggan').modal('hide');
    }
    // function select(id, nameproduk, price) {
    //     $.ajax({
    //         url: "< ?= base_url('jual/produk') ?>",
    //         method: "POST",
    //         data: {
    //             id: id,
    //             nameproduk: name,
    //             qty: 1,
    //             price: price
    //         },
    //         success: function(data) {
    //             load()
    //         }
    //     });
    // }
</script>