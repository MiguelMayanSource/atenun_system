<?php $product = $this->db->get_where('product',array('product_id'=>$ID));?>
<div class="white-box" id="toRender">
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
        <div class="col-md-12 col-ms-12 ">
            <div class="card-widget">
                <h4 class="panel-content-title">Movimientos del producto</h4>
                <a target="_blank" class="add-buton pull-right" style="margin-right:1px;" href="<?php echo base_url();?>admin/print_kardex/<?php echo base64_encode($ID);?>">IMPRIMIR</a>
                <a class="add-buton pull-right" style="margin-right:1px;" href="<?php echo base_url();?>admin/excel_export_kardex/<?php echo base64_encode($ID);?>">EXCEL</a>
                <span class="app-divider2"></span>
                <div class="row">

                    <div class="col-sm-12">
                        <div class="table-responsive">

                            <table id="zero-config" class="table dt-table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>TIPO</th>
                                        <th>NO. REFERENCIA</th>
                                        <th>FECHA</th>
                                        <th>CANTIDAD</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                            $n = 1;
                            $clientes = $this->db->order_by('product_move_id', 'DESC')->get_where('product_move',array('product_id'=> $ID,'clinic_id' =>$this->session->userdata('current_clinic')))->result_array();
                                        foreach($clientes as $row):?>
                                    <tr>
                                        <?php if($row['status_mov'] == 1):?>
                                        <td><span style="color:#99bf2d;font-weight:bold;font-family: \'CircularStd\', sans-serif;font-size: 13px;">
                                                Entrada</span>
                                        </td>
                                        <?php else:?>
                                        <td><span style="color:red;font-weight:bold;font-family: \'CircularStd\', sans-serif;font-size: 13px;">
                                                Salida</span>
                                        </td>
                                        <?php endif;?>
                                        <td><span class="smaller lighter"><?php echo $row['invoice'];?></span></td>
                                        <td><span class="smaller lighter"><?php echo $row['date'] ;?> </span></td>
                                        <td><span class="smaller lighter"><?php echo $row['amount'].' '.$row['unity'];?></span></td>
                                    </tr>
                                    <?php endforeach;?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="1new_product">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content animated fadeInDown">
            <form action="<?php echo base_url();?>admin/history/add_medicamento/<?php echo $ID ;?>" method="POST" enctype="multipart/form-data">
                <div class="modal-header" style="background-color:#fff; box-shadow: 0 4px 2px -2px 000;">
                    <h4 style="font-size:21px; color:#565b6b; font-family:'Poppins';"><span style="vertical-align:-3px">
                            <i class="picons-thin-icon-thin-0001_compose_write_pencil_new"></i> Agregar a
                            inventario.</span></h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="container">
                            <div class="row">

                                <input type="hidden" name="code" value='<?php echo $product->row()->code;?>'>

                                <div class="col-sm-6">
                                    <div class="form-group m-b-15">
                                        <label for="simpleinput">Fecha de Ingreso</label>
                                        <input type="date" name="date" required="" class="form-control" value='<?php echo date('Y-m-d');?>'>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group m-b-15">
                                        <label for="simpleinput">Fecha de Vecimiento</label>
                                        <input type="date" name="expiration" required="" class="form-control" value='<?php echo date('Y-m-d');?>'>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group m-b-15">
                                        <label for="simpleinput">Cantidad</label>
                                        <input type="number" name="cantidad" required="" class="form-control" min='0'>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group m-b-15">
                                        <label for="simpleinput">Factura</label>
                                        <input type="text" name="factura" required="" class="form-control">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group m-b-15">
                                        <label for="simpleinput">Proveedor</label>
                                        <input type="text" name="proveedor" required="" class="form-control" value='<?php echo $product->row()->provider;?>'>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group m-b-15">
                                        <label for="simpleinput">Nombre</label>
                                        <input type="text" name="name" required="" class="form-control" value='<?php echo $product->row()->name ;?>'>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group m-b-15">
                                        <label for="simpleinput">Costo unitario</label>
                                        <input type="number" step="any" name="cost" required="" class="form-control" min='0' value='<?php echo $product->row()->cost ;?>'>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group m-b-15">
                                        <label for="simpleinput">Precio de venta </label>
                                        <input type="number" step="any" name="price" required="" class="form-control" min='0' value='<?php echo $product->row()->price ;?>'>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group m-b-15">
                                        <label for="simpleinput">Observación </label>
                                        <textarea name="obs" cols="30" rows="3" class='form-control'></textarea>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="button-confirm">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal" id="1remove_product">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content animated fadeInDown">
            <form action="<?php echo base_url();?>admin/history/remove_medicamento/<?php echo $ID ;?>" method="POST" enctype="multipart/form-data">
                <div class="modal-header" style="background-color:#fff; box-shadow: 0 4px 2px -2px 000;">
                    <h4 style="font-size:21px; color:#565b6b; font-family:'Poppins';"><span style="vertical-align:-3px">
                            <i class="picons-thin-icon-thin-0001_compose_write_pencil_new"></i> Descargar del inventario.</span></h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="container">
                            <div class="row">
                                <input type="hidden" name="code" value='<?php echo $product->row()->code;?>'>
                                <div class="col-sm-6">
                                    <div class="form-group m-b-15">
                                        <label for="simpleinput">Fecha</label>
                                        <input type="date" name="date" required="" class="form-control" value='<?php echo date('Y-m-d');?>'>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <input type="number" step="any" class="form-control" name="amount" required="" onKeyUp="getSbtotal('0')" id="amount_0">
                                            <div class="input-group-append" id="unity_0">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group m-b-15">
                                        <label for="simpleinput">Nombre</label>
                                        <input type="text" name="name" required="" class="form-control" value='<?php echo $product->row()->name ;?>'>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group m-b-15">
                                        <label for="simpleinput">Costo unitario</label>
                                        <input type="number" name="cost" required="" class="form-control" min='0' value='<?php echo $product->row()->cost ;?>'>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group m-b-15">
                                        <label for="simpleinput">Precio de venta </label>
                                        <input type="number" name="price" required="" class="form-control" min='0' value='<?php echo $product->row()->price ;?>'>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group m-b-15">
                                        <label for="simpleinput">Observación </label>
                                        <textarea name="obs" cols="30" rows="3" class='form-control'></textarea>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="button-confirm">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="<?php echo base_url();?>public/assets/back/js/jquery-3.1.1.min.js"></script>
<script type="text/javascript" language="javascript">

$(function(){
    getPres(<?php echo $ID; ?>,0);
})
function delete_inventory(product_id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "También se eliminará toda la información asociada al producto.",
        type: 'info',
        showCancelButton: true,
        confirmButtonColor: '#9fd13b',
        cancelButtonColor: '#fd4f57',Cantidad
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.value) {
            location.href = "<?php echo base_url();?>admin/inventory/delete/" + product_id;
        }
    })
}

function getPres(product_id, variant_id) {
    $.ajax({
        url: '<?php echo base_url();?>admin/get_product_pres/' + product_id,
        success: function(response) {
            console.log('opciones '+response);
            if (response !== "")
                jQuery('#unity_' + variant_id).html(` <select name="unity" class = "form-control" required = "" >${response} < /select>`);
            else
                jQuery('#unity_' + variant_id).html('');
            getPrice(product_id, variant_id)

        }
    });
}
</script>