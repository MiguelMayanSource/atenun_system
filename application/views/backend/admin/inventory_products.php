<div class="white-box">
    <div class="os-tabs-w">
        <div class="os-tabs-controls">
            <ul class="navx nav-tabs">
                <li class="nav-item text-center">
                    <a class="nav-link current " href="<?php echo base_url();?>admin/inventory/">
                        <div class="navWidget"><i class="picons-thin-icon-thin-0820_medicine_drugs_ill_pill"></i></div>
                        <span>Inventarios</span>
                    </a>
                </li>
                <li class="nav-item text-center">
                    <a class="nav-link" href="<?php echo base_url();?>admin/purchases/">
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
        <div class="col-sm-12">
            <div class="title-header"><br>
                <h3 class="module-title"><?php echo $this->db->get_where('inventory',array('inventory_id'=>$inventory_id))->row()->name;?></h3>
                <div>
                    <a class="add-buton-success pull-right" href="javascript:void(0);" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <div class="pi-settings os-dropdown-trigger">
                            Eliminar <i class="fa fa-caret-down"></i>
                        </div>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" id="dropdown">
                        <a class="dropdown-item" href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_product_masive_delete/<?php echo $inventory_id; ?>');">Eliminar productos</a>
                        <a class="dropdown-item" href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_service_masive_delete/<?php echo $inventory_id; ?>');">Eliminar servicios</a>
                    </div>
                </div>
                <div>
                    <a class="add-buton-success pull-right" href="javascript:void(0);" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <div class="pi-settings os-dropdown-trigger">
                            Exportar <i class="fa fa-caret-down"></i>
                        </div>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" id="dropdown">
                        <a class="dropdown-item" href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_product_export/<?php echo $inventory_id; ?>');">Exportar productos</a>
                        <a class="dropdown-item" href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_service_export/<?php echo $inventory_id; ?>');">Exportar servicios</a>
                        <a class="dropdown-item" href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_prices_export/<?php echo $inventory_id; ?>');">Exportar precios</a>
                    </div>
                </div>
                <div>

                    <a class="add-buton-success pull-right" href="javascript:void(0);" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <div class="pi-settings os-dropdown-trigger">
                            Importar <i class="fa fa-caret-down"></i>
                        </div>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_service_imp_import/<?php echo $inventory_id; ?>');">Importar implementos de servicios</a>
                        <a class="dropdown-item" href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_service_import/<?php echo $inventory_id; ?>');">Importar servicios</a>
                        <a class="dropdown-item" href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_product_import/<?php echo $inventory_id; ?>');">Importar inventario</a>
                        <a class="dropdown-item" href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_price_import/<?php echo $inventory_id; ?>');">Importar precios</a>
                    </div>
                </div>
                <!-- Small button groups (default and split) -->
                <div>
                    <a class="add-buton pull-right" href="javascript:void(0);" id="dropdownMenuButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <div class="pi-settings os-dropdown-trigger">
                            Agregar <i class="fa fa-caret-down"></i>
                        </div>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                        <a class="dropdown-item" href="javascript:void(0);" onclick="modal_lg('<?php echo base_url();?>modal/popup/modal_add_product/<?php echo $inventory_id; ?>');">+ Nuevo Producto</a>
                        <a class="dropdown-item" href="javascript:void(0);" onclick="modal_lg('<?php echo base_url();?>modal/popup/modal_add_service/<?php echo $inventory_id; ?>');">+ Nuevo Servicio</a>
                        <a class="dropdown-item" href="javascript:void(0);" onclick="modal_lg('<?php echo base_url();?>modal/popup/modal_add_laboratory/<?php echo $inventory_id; ?>');">+ Nuevo laboratorio</a>
                        <a class="dropdown-item" href="<?php echo base_url();?>admin/categories">+ Categorías</a>
                        <a class="dropdown-item" href="<?php echo base_url();?>admin/subcategories">+ Subcategorías</a>
                    </div>
                </div>
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
                                        <th>TIPO</th>
                                        <th>CÓDIGO</th>
                                        <th>CATEGORIA</th>
                                        <th>NOMBRE DE MEDICAMENTO</th>
                                        <th>PRESENTACIÓN</th>
                                        <th>PROVEEDORES</th>
                                        <th>COSTO UNITARIO</th>
                                        <th>PRECIO ATENUN</th>
                                        <th>EXISTENCIA</th>
                                        <th>ACCIONES</th>
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
        "lengthMenu": [
            [10, 25, 50, 100, 250, 500, -1],
            [10, 25, 50, 100, 250, 500, "Todos"]
        ],
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            url: "<?php echo base_url() . 'admin/getTable/inventory/'.$inventory_id; ?>",
            type: "POST"
        },

        "columnDefs": [{
            "targets": 0,
            "orderable": false,
        }, ],
        fixedColumns: true,
    });
});
</script>

<link href="<?php echo base_url();?>public/assets/appointments/css/select2.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<script type="text/javascript">
$('.itemName').select2();
</script>

<script>
$(document).ready(function() {
    $('form').submit(function() {
        $('button[type="submit"]').prop('disabled', true);
    });
});
</script>


<script type="text/javascript">
function delete_inventory(product_id) {
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
            location.href = "<?php echo base_url();?>admin/inventory_products/delete/" + product_id;
        }
    })
}
</script>