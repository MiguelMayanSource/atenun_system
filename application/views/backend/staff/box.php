<style>
.card.card-custom {
    -webkit-box-shadow: 0px 0px 30px 0px rgba(82, 63, 105, 0.05);
    box-shadow: 0px 0px 30px 0px rgba(82, 63, 105, 0.05);
    border: 0;
}

.font-weight-boldest {
    font-weight: 700;
}

.font-size-h1 {
    font-size: 2rem !important;
}
</style>
<?php
$box = $this->db->get_where('box',array('user_id'=>$this->session->userdata('login_user_id'),'user_type'=>$this->session->userdata('login_type'),'status'=>1));
if($box->num_rows() > 0):
?>

<div id="main-content">
    <div class="">
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <div class="card card-custom gutter-b">
                            <div class="card-body d- flex f lex-column">
                                <div class="d-f lex align-ite ms-center justify-con tent -between flex-g row-1">
                                    <div class="mr-2">
                                        <h3 class="font-weight-bolder"><?php echo $this->accounts_model->get_name($box->row()->user_type,$box->row()->user_id); ?></h3>
                                    </div>
                                    <div class="font-weight-boldest font-size-h1 ">
                                        <?php echo $box->row()->start_time; ?> </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" id="ingresos" name="ingresos" value="0" step="0.01" class="form-control" aria-label="Text input with checkbox" readonly="true">
                    </div>
                </div>


                <div class="col-sm-4">
                    <div class="form-group">
                        <div class="card card-custom gutter-b">
                            <div class="card-body d- flex f lex-column">
                                <div class="d-f lex align-ite ms-center justify-con tent -between flex-g row-1">
                                    <div class="mr-2">
                                        <h3 class="font-weight-bolder">Caja chica:</h3>
                                    </div>
                                    <div class="font-weight-boldest font-size-h1 text-warning">
                                        Q<?php echo $this->inventory_model->get_total_cajac($box->row()->box_id);?></div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="monto_limite" value="98" step="0.01" class="form-control" aria-label="Text input with checkbox" readonly="true">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <div class="card card-custom gutter-b">
                            <div class="card-body d- flex f lex-column">
                                <div class="d-f lex align-ite ms-center justify-con tent -between flex-g row-1">
                                    <div class="mr-2">
                                        <h3 class="font-weight-bolder">Caja de ventas:</h3>
                                    </div>
                                    <div class="font-weight-boldest font-size-h1 text-success">
                                        Q<?php echo $this->inventory_model->get_total_cajav($box->row()->box_id);?> </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" id="ingresos" name="ingresos" value="0" step="0.01" class="form-control" aria-label="Text input with checkbox" readonly="true">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <div class="card card-custom gutter-b">
                            <div class="card-body d- flex f lex-column">
                                <div class="d-f lex align-ite ms-center justify-con tent -between flex-g row-1">
                                    <div class="mr-2">
                                        <h3 class="font-weight-bolder">Banco:</h3>
                                    </div>
                                    <div class="font-weight-boldest font-size-h1 text-info">
                                        Q<?php echo $this->inventory_model->get_total_banco($box->row()->box_id);?> </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="caja_nueva" id="caja_nueva" step="0.01" value="0" class="form-control" aria-label="Text input with checkbox" readonly="true">
                    </div>
                </div>
    <style>
        .table td, .table th {
  padding: 0;
}
    </style>
                <div class="col-sm-12">
                    <div class="form-group">
                        <div class="card card-custom gutter-b">
                            <div class="card-header ">
                                <h3 class="font-weight-bolder">Ventas realizadas</h3>
                            </div>
                            <div class="card-body d- flex f lex-column">
                                <div class='table-responsive'>
                                    <table class=" " style="width:100%" id="sales_box" >
                                     <thead> 
                                            <tr>
                                                <th>Fecha</th>
                                                <th>Cliente</th>
                                                <th>Producto</th>
                                                <th>Unidad</th>
                                                <th>Precio</th>
                                                <th>Descuento</th>
                                                <th>Total</th>
                                                <th>No. de Factura</th>
                                                <th>Tipo de Pago</th>
                                                <th>Ingresa</th>
                                                <th>Servicio o Bien</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                           
                                            <?php
                                                $ventas_realizadas = $this->db->get_where('sale',array('box_id'=>$box->row()->box_id));
                                                if($ventas_realizadas->num_rows() > 0):
                                                    $cont =  1;
                                                    foreach($ventas_realizadas->result_array() as $venta):

                                                        $detalles = unserialize($venta['products']);  
                                                        foreach($detalles as $prod): 
                                                        
                                                            $cart_total += $prod['ordered_quantity']*$item['selling_price'];
                                                            $product = $this->db->get_where('product', array('product_id'=>$prod['product_id']))->row_array();
                                                    ?>
                                                        <tr>
                                                            <td  style="font-size:12px;width:200px;white-space:nowrap" >
                                                                <?php  echo $venta['date']; ?>
                                                            </td>
                                                            <td  style="font-size:12px;width:200px;white-space:nowrap" >
                                                                <?php echo $this->accounts_model->get_name($venta['user_type'],$venta['user_id']); ?>
                                                            </td>
                                                            <td style="font-size:12px;width:200px;white-space:nowrap">
                                                                <?php  echo $product['code'].' - '.$product['name']; ?> 
                                                            </td>
                                                            <td style="font-size:12px;width:200px;white-space:nowrap">
                                                                <?php echo $prod['amount'].' '.$this->crud_model->pluralizar($prod['amount'],$this->db->get_where('unity',array('code'=>$prod['unity']))->row()->name); ?>
                                                            </td>
                                                            <td style="font-size:12px;width:200px;white-space:nowrap">
                                                                <?php echo $currency.number_format($prod['subtotal'],2,'.',','); ?>
                                                            </td>
                                                            <td style="font-size:12px;width:200px;white-space:nowrap">
                                                                <?php echo $currency.number_format($prod['discount'],2,'.',','); ?>
                                                            </td>
                                                            <td style="font-size:12px;width:200px;white-space:nowrap">
                                                                <?php echo $currency.number_format($prod['total'],2,'.',','); ?>
                                                            </td>
                                                            <td  style="font-size:12px;width:200px;white-space:nowrap" >
                                                                <?php  echo $venta['date']; ?>
                                                            </td>
                                                            <td  style="font-size:12px;width:200px;white-space:nowrap" >
                                                               
                                                            </td>
                                                            <td  style="font-size:12px;width:200px;white-space:nowrap" >
                                                               
                                                            </td>
                                                            <td  style="font-size:12px;width:200px;white-space:nowrap" >
                                                                <?php  echo $product['type'] == 1 ? 'Bien' : 'Servicio'; ?>
                                                            </td>
                                                        </tr>
                                                        <?php endforeach;?>
                                                    <?php
                                                    endforeach;
                                                endif;
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <a class="btn btn-danger" href="javascript:void(0);" onclick="modal_lg('<?php echo base_url();?>modal/popup/modal_close_box/<?php echo $appointment['appointment_id'];?>');">Cerrar Caja</a>
                <!-- <div class="col-sm-6">
                    <div class="form-group">
                        <h3 class="font-weight-bolder"><b>Total en la caja chica</b> <span class="text-danger">*</span></h3>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text font-weight-boldest font-size-h1">Q</span>
                            </div>
                            <input type="number" name="ver_caja" id="ver_caja" value="0.00" step="0.01" required="true" min="0" class="form-control font-weight-boldest font-size-h1" aria-label="Text input with checkbox" oninput="verificar()">
                        </div>
                    </div>
                    <div class="form-group">
                        <h3 class="font-weight-bolder"><b>Total en la caja de ventas</b> <span class="text-danger">*</span></h3>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text font-weight-boldest font-size-h1">Q</span>
                            </div>
                            <input type="number" name="ver_caja" id="ver_caja" value="0.00" step="0.01" required="true" min="0" class="form-control font-weight-boldest font-size-h1" aria-label="Text input with checkbox" oninput="verificar()">
                        </div>
                    </div>
                    <div class="form-group">
                        <h3 class="font-weight-bolder"><b>Total en bancos</b> <span class="text-danger">*</span></h3>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text font-weight-boldest font-size-h1">Q</span>
                            </div>
                            <input type="number" name="ver_caja" id="ver_caja" value="0.00" step="0.01" required="true" min="0" class="form-control font-weight-boldest font-size-h1" aria-label="Text input with checkbox" oninput="verificar()">
                        </div>
                    </div>
                    <div class="form-group">
                        <h3 class="font-weight-bolder"><b>Notas:</b></h3>
                        <div class="input-group">
                            <textarea class="form-control" name="notes" aria-label="Text input with checkbox" rows="3">Ninguna</textarea>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success">Cerrar caja</button>
                </div> -->
            </div>
    </div>
</div>
<script>
    $('#sales_box').DataTable({
    
        "bAutoWidth":false,
    "scrollX": true,
    "ordering": false,
   
});
</script>
<?php endif;?>