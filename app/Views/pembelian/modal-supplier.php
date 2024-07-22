<!-- ISI POS -->
<div class="modal fade" id="modalsupplier" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalToggleLabel">DATA SUPPLIER</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Tabel Buku -->
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>ID supplier</th>
                            <th>Nama supplier</th>
                            <th>No HP</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        foreach ($supplier as $value) : ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $value['ID_Supplier'] ?></td>
                                <td><?= $value['Nama'] ?></td>
                                <td><?= $value['No_HP'] ?></td>
                                <td><button onclick="selectsupplier('<?= $value['ID_Supplier'] ?>','<?= $value['Nama_supplier'] ?>')" class="btn btn-success"><i class="fa fa-plus"></i>Pilih</button></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <!-- END Tabel Buku -->
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
<!-- END ISI POS -->
<script>
    function selectsupplier(id, name) {
        $('#ID_Supplier').val(id);
        $('#Nama').val(name);
        $('#modalsupplier').modal('hide');
    }
</script>