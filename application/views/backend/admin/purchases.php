    <div class="white-box">
        <div class="os-tabs-w">
            <div class="os-tabs-controls">
                <ul class="navx nav-tabs">
                    <li class="nav-item text-center">
                        <a class="nav-link  " href="<?php echo base_url();?>admin/inventory/">
                            <div class="navWidget"><i class="picons-thin-icon-thin-0820_medicine_drugs_ill_pill"></i></div>
                            <span>Inventarios</span>
                        </a>
                    </li>
                    <li class="nav-item text-center">
                        <a class="nav-link current" href="<?php echo base_url();?>admin/purchases/">
                            <div class="navWidget"><i class="picons-thin-icon-thin-0101_notes_text_notebook"></i></div>
                            <span>Ordenes de compra</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div id="main-content">
        <div class="row">
            <div class="col-sm-12"><br>
                <div class="title-header">
                    <h3 class="module-title">Ordenes de compra</h3>
                    <a class="add-buton pull-right" href="<?php echo base_url()?>admin/new_purchase">+ Nuevo orden</a>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card-b">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="table-responsive">
                                <table class="table table-padded" id="user_data">
                                    <thead>
                                        <tr>
                                            <th>Código</th>
                                            <th>Fecha</th>
                                            <th>Proveedor</th>
                                            <th>Total</th>
                                            <th>Estado</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" language="javascript">
$(document).ready(function() {
    var dataTable = $('#user_data').DataTable({
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            url: "<?php echo base_url() . 'admin/getTable/pedidos'; ?>",
            type: "POST"
        },
        "columnDefs": [{
            "targets": 0,
            "orderable": false,
        }, ],
    });
});


function deletePedido(category_id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "También se eliminará toda la información asociada al producto.",
        type: 'info',
        showCancelButton: true,
        confirmButtonColor: '#9fd13b',
        cancelButtonColor: '#fd4f57',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.value) {
            location.href = "<?php echo base_url();?>admin/solicitudes/delete/" + category_id;
        }
    })
}

function setPedidos(category_id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "Se marcara este pedido como completado.",
        type: 'info',
        showCancelButton: true,
        confirmButtonColor: '#9fd13b',
        cancelButtonColor: '#fd4f57',
        confirmButtonText: 'Sí, completar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.value) {
            location.href = "<?php echo base_url();?>admin/solicitudes/set/" + category_id;
        }
    })
}
    </script>