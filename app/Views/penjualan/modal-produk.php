<div class="modal fade" id="modalProduk" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalToggleLabel">DATA PRODUK</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!--Tabel Buku -->
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th width=5%>No</th>
                            <th width=10%>ID Produk</th>
                            <th width=30%>Nama Produk</th>
                            <th width=20%>Brand Produk</th>
                            <th width=20%>Harga Produk</th>
                            <th width=15%>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        foreach ($produk as $value) : ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $value['ID_Produk'] ?></td>
                                <td><?= $value['Nama_Produk'] ?></td>
                                <td><?= $value['Brand_Produk'] ?></td>
                                <td><?= $value['Harga_Produk'] ?></td>
                                <td>
                                    <button onclick="select('<?= $value['ID_Produk'] ?>',
                                    '<?= $value['Nama_Produk'] ?>')" class="btn btn-success"><i class="fa fa-cart-plus"></i>Tambahkan </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <!-- -->
            </div>
            <div class=" modal-footer">
                <button class="btn btn-primary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
<script>
    function select(id, name) {
        $('#ID_Produk').val(id);
        $('#Nama_Produk').val(name);
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