    <div class="white-box">
        <div class="os-tabs-w">
            <div class="os-tabs-controls">
                <ul class="navx nav-tabs">
                    <li class="nav-item text-center">
                        <a class="nav-link  " href="<?php echo base_url();?>staff/inventory/">
                            <div class="navWidget"><i class="picons-thin-icon-thin-0820_medicine_drugs_ill_pill"></i></div>
                            <span>Inventarios</span>
                        </a>
                    </li>
                    <li class="nav-item text-center">
                        <a class="nav-link " href="<?php echo base_url();?>staff/solicitudes/">
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
                    <h3 class="module-title">Combos o paquetes</h3>
                    <a class="add-buton pull-right" href="javascript:void(0);" data-toggle="modal" data-target="#2new_category">+ Nuevo combo</a>
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
                                            <th>Nombre</th>
                                            <th>Costo</th>
                                            <th>Precio 1</th>
                                            <th>Precio 1</th>
                                            <th>Precio 3</th>
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


    <div class="modal" id="2new_category">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content animated fadeInDown">
                <form action="<?php echo base_url();?>staff/solicitudes/create" method="POST">
                    <div class="modal-header" style="background-color:#fff; box-shadow: 0 4px 2px -2px 000;">
                        <h4 style="font-size:21px; color:#565b6b; font-family:'Poppins';"><span style="vertical-align:-3px"> <i class="picons-thin-icon-thin-0001_compose_write_pencil_new"></i>
                                Agregar nuevo combo. </span></h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body" style="background-color:#f1f3f7;">
                        <div class="form-group">
                            <div class="container">
                                <div class="row">
                                    <div class="col-sm-12 row">
                                        <div class="col-sm-6">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Nombre</label>
                                                <input type="text" name="name" class="form-control" id="product">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Código</label>
                                                <input type="text" name="code" class="form-control" id="description">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 row" id="products">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label> Cantidad y unidad </label><span class="text-danger">*</span>
                                            <div class="input-group">
                                                <input type="number" step="any" class="form-control" name="amount[]" required="" aria-label="Text input with dropdown button" value="<?php echo $row['amount'];?>">
                                                <div class="input-group-append">
                                                    <select name="unity[]" class="form-control">

                                                        <optgroup label="Otras">
                                                            <option value="gt" <?php echo $row['unity']== 'gt'?'Selected':'';?>>Goteros</option>
                                                            <option value="am" <?php echo $row['unity']== 'am'?'Selected':'';?>>Ampollas</option>
                                                            <option value="pil" <?php echo $row['unity']== 'pil'?'Selected':'';?>>Pildoras</option>
                                                            <option value="pas" <?php echo $row['unity']== 'pas'?'Selected':'';?>>Pastillas</option>
                                                            <option value="un" <?php echo $row['unity']== 'un'?'Selected':'';?>>Unidades</option>
                                                        </optgroup>
                                                        <optgroup label="Unidades de Peso">
                                                            <option value="lb" <?php echo $row['unity']== 'lb'?'Selected':'';?>>Libras</option>
                                                            <option value="oz" <?php echo $row['unity']== 'oz'?'Selected':'';?>>Onzas</option>
                                                        </optgroup>
                                                        <optgroup label="Unidades de Liquidos">
                                                            <option value="ml" <?php echo $row['unity']== 'ml'?'Selected':'';?>>Mililitros</option>
                                                            <option value="lt" <?php echo $row['unity']== 'lt'?'Selected':'';?>>Litros</option>
                                                            <option value="gl" <?php echo $row['unity']== 'gl'?'Selected':'';?>>Galones</option>
                                                        </optgroup>
                                                        <optgroup label="Unidades de longitud">
                                                            <option value="pl" <?php echo $row['unity']== 'pl'?'Selected':'';?>>pulgadas</option>
                                                            <option value="pie" <?php echo $row['unity']== 'pie'?'Selected':'';?>>pie</option>
                                                            <option value="yd" <?php echo $row['unity']== 'yd'?'Selected':'';?>>Yarda</option>
                                                        </optgroup>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 mb-3">
                                        <label class="form-label" for="exampleFormControlSelect9">Producto:</label><span style="color:red">*</span>
                                        <select class="form-control mb3 select2" data-table="" required name="product_id[]">
                                            <option value="">Seleccionar</option>
                                            <?php  $products = $this->db->get_where('product', array('type'=>1,'status'=>1))->result_array();
                                            foreach ($products as $product): ?>
                                            <option value="<?php echo $product['product_id']; ?>" <?php echo $product['product_id']==$row['product_id']?'Selected':'';?>><?php echo $product['code'].' - '.$product['name']?></option>
                                            <?php endforeach;  ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-12 text-right">
                                    <a class="btn btn-success " onclick="addProduct()" href="#"><i class="picons-thin-icon-thin-0151_plus_add_new"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer text-right">
                        <div>
                            <button type="submit" class="button-confirm">Guardar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
$(document).ready(function() {
    $('.select2').select2();
})

function delete_element(obj) {
    $(obj).parent().parent().remove();
}


function addProduct() {

    $('#products').append(`
    <div class="col-sm-12 row">
        <div class="col-sm-4">
            <div class="form-group">
                <label> Cantidad y unidad </label><span class="text-danger">*</span>
                <div class="input-group">
                    <input type="number" step="any" class="form-control" name="amount[]" required="" aria-label="Text input with dropdown button" value="<?php echo $row['u_amount'];?>">
                    <div class="input-group-append">
                        <select name="unity[]" class="form-control">
                            <optgroup label="Otras">
                                <option value="gt">Goteros</option>
                                <option value="am">Ampollas</option>
                                <option value="pil">Pildoras</option>
                                <option value="pas">Pastillas</option>
                                <option value="un">Unidades</option>
                            </optgroup>
                            <optgroup label="Unidades de Peso">
                                <option value="lb">Libras</option>
                                <option value="oz">Onzas</option>
                            </optgroup>
                            <optgroup label="Unidades de Liquidos">
                                <option value="ml">Mililitros</option>
                                <option value="lt">Litros</option>
                                <option value="gl">Galones</option>
                            </optgroup>
                            <optgroup label="Unidades de longitud">
                                <option value="pl">pulgadas</option>
                                <option value="pie">pie</option>
                                <option value="yd">Yarda</option>
                            </optgroup>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-5 mb-3">
            <label class="form-label" for="exampleFormControlSelect9">Producto:</label><span style="color:red">*</span>
            <select class="form-control mb3 select2" data-table="" required name="product_id[]">
                <option value="">Seleccionar</option>
                <?php  $products = $this->db->get_where('product', array('type'=>1,'status'=>1))->result_array();
            foreach ($products as $product): ?>
                <option value="<?php echo $product['product_id']; ?>"><?php echo $product['code'].' - '.$product['name']?></option>
                <?php endforeach;  ?>
            </select>
        </div>
        <div class="col-md-2 col-ms-12 mb-3">
            <label for="codigoProducto" class="form-label">Costo</label><span style="color:red">*</span>
            <input type="number" class="form-control" name="cost[]" required value="<?php echo $row['code'];?>">
        </div>
        <div class="col-md-1 col-ms-12 mb-3">
            <br>
            <i onclick="delete_element(this)" class="picons-thin-icon-thin-0056_bin_trash_recycle_delete_garbage_empty" style="font-size:22px;color:#fd4f57;cursor:pointer;" data-toggle="tooltip" data-placement="top" title="" data-original-title="Eliminar"></i>
        </div>
    </div>
    `);


}
    </script>
    <script type="text/javascript" language="javascript">
$(document).ready(function() {


    var dataTable = $('#user_data').DataTable({
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            url: "<?php echo base_url() . 'staff/getTable/combos'; ?>",
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
            location.href = "<?php echo base_url();?>staff/solicitudes/delete/" + category_id;
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
            location.href = "<?php echo base_url();?>staff/solicitudes/set/" + category_id;
        }
    })
}
    </script>