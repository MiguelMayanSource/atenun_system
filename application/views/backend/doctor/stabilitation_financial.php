<link rel="stylesheet" href="<?php echo base_url();?>public/assets/search/estilo.css">

<?php   
    $stabilitation_id = base64_decode($id_);
    $this->db->where('stabilitation_ref_id', $stabilitation_id);
    $info = $this->db->get('stabilitation_ref')->result_array();
    $currency  = $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->currency;
    foreach ($info as $det):
    $patient_id = $det['patient_id'];
     $status = $det['status'];
?>
<script>
var base_url = '<?php echo base_url();?>';
var ref = '<?php echo $det['stabilitation_ref_id'];?>';
</script>
<div id="main-content">
    <div class="row">
        <div class="col-sm-8">
            <?php if($det['status'] == 0 || $det['status'] == 1):?>
            <div class="col-sm-12">
                <div class="alert alert-info">
                    <span class="alert-title">
                        <i class="batch-icon-spam"></i>
                        Aun no esta finalizado.</span>
                    <span class="alert-content">
                        La hospitalización aun no ha sido guardada, los precios y costos finales pueden variar hasta que no se haya finalizado.
                    </span>
                </div>
            </div>
            <?php endif;?>

            <div class="card-widget" style="border: 1px solid #c6c6cc;">
                <h5 class="panel-content-title">Insumos</h5>
                <span class="app-divider2"></span>
                <div class="row">
                    <div class="col-md-12">
                        <div class="row" style="overflow-y:auto">
                            <div class="col-sm-12">
                                <?php 
                                    $insumos_total  = 0;
                                    $insumos_costo_total = 0;
                                    $stabilitations= $this->db->get_where('stabilitation',array('stabilitation_ref_id' => $det['stabilitation_ref_id']));
                                    if($stabilitations->num_rows() > 0)
                                    {
                                    
                                    $html_table = '
                                        <table class="table">
                                            <tr style="background-color:#f9fbfc; color:#59636d">
                                                <th>Nombre</th>
                                                <th  style="text-align:center">Cantidad</th>
                                                <th  style="text-align:center">Descuento</th>
                                                <th>Costo C/U</th>
                                                <th>Precio C/U</th>
                                                <th>Costo Total</th>
                                                <th>Precio Total</th>
                                            </tr>';
                                        
                                        foreach($stabilitations->result_array() as $stabilitation)
                                        {        
                                            $refresh_query  = $this->db->get_where('stabilitation_insum',array('stabilitation_id' => $stabilitation['stabilitation_id']));
                                    
                                            foreach($refresh_query->result_array() as $row)
                                            {
                                                $product = $this->db->get_where('product', array('product_id'=>$row['product_estb_id']))->row();
                                                $insumos_total += $row['subtotal'];
                                                $insumos_costo_total += $row['cantidad'] * $product->cost;
                                                $html_table .= '
                                                    <tr>
                                                        <td>'.$product->name.'</td>';
                                                        $html_table .= '<td style="text-align:center"> '.$row['cantidad'].' </td>';
                                                        $html_table .= '<td style="text-align:center"> '.$row['discount'].' </td>';
                                                        $html_table .= '<td> '.$currency.'. '.$product->cost.'</td>';
                                                        $html_table .= '<td> '.$currency.'. '.$row['price'].'</td>';
                                                        $html_table .= '<td> '.$currency.'. '.number_format($row['cantidad'] * $product->cost,2,'.',',').'</td>';
                                                        $html_table .= '<td> '.$currency.'. '.$row['subtotal'].' </td>';
                                                        $html_table .= '</tr>';   
                                            }
                                            
                                                    $html_table .= '<tr>';
                                                        $html_table .= '<td colspan="4">  </td>';
                                                        $html_table .= '<td><b> Totales:</b> </td>';
                                                        $html_table .= '<td><b> '.$currency.'. '.number_format($insumos_costo_total,2,'.','.').'</b></td>';
                                                        $html_table .= '<td><b> '.$currency.'. '.number_format($insumos_total,2,'.','.').'</b></td>';
                                                    $html_table .= '</tr>';  
                                                    
                                                    $html_table .= '<tr>';
                                                        $html_table .= '<td colspan="5">  </td>';
                                                        $html_table .= '<td><b> Ganancia:</b> </td>';
                                                        $html_table .= '<td><b> '.$currency.'. '.number_format($insumos_total-$insumos_costo_total,2,'.','.').'</b></td>';
                                                    $html_table .= '</tr>';  
                                                      
                                        }
                                    $html_table .='</table>';
                                        
                                        echo $html_table;
                                    }else{
                                        echo '<div class="col-sm-12"><br><center><h5 class="poppins">Aún no hay insumos agregados.</h5><br><img src="'.base_url().'public/uploads/medicamentos.svg" style="max-width:20%;"></center></div>';
                                    }
                                ?>
                            </div>
                        </div>
                        <hr>
                    </div>
                </div>
            </div>

            <div class="card-widget" style="border: 1px solid #c6c6cc;">
                <h5 class="panel-content-title">Servicios</h5>
                <span class="app-divider2"></span>
                <div class="row">
                    <div class="col-md-12">
                        <div class="row" style="overflow-y:auto">
                            <div class="col-sm-12">
                                <?php 
                                    $services_total  = 0;
                                    $services_costo_total  = 0;
                                    if($stabilitations->num_rows() > 0)
                                    {
                                    
                                    $html_table = '
                                        <table class="table">
                                            <tr style="background-color:#f9fbfc; color:#59636d">
                                                <th>Nombre</th>
                                                <th  style="text-align:center">Cantidad</th>
                                                <th>Costo C/U</th>
                                                <th>Precio C/U</th>
                                                <th>Costo total</th>
                                                <th>Precio total</th>
                                            </tr>';
                                        
                                        foreach($stabilitations->result_array() as $stabilitation)
                                        {        
                                            $refresh_query  = $this->db->get_where('stabilitation_service',array('stabilitation_id' => $stabilitation['stabilitation_id']));
                                    
                                            foreach($refresh_query->result_array() as $row)
                                            {
                                                $service = $this->db->get_where('service', array('service_id'=>$row['service_id']))->row();
                                                $services_total += $row['price'];
                                                $services_costo_total += $service->cost *$row['cantidad'];
                                                $html_table .= '<tr>';
                                                    $html_table .= '<td>'.$service->name.'</td>';
                                                    $html_table .= '<td style="text-align:center"> '.$row['cantidad'].' </td>';
                                                    $html_table .= '<td>'.$service->cost.'</td>';
                                                    $html_table .= '<td>'.$service->price.'</td>';
                                                    $html_table .= '<td>'.$currency.'. '.number_format($service->cost *$row['cantidad'],2,'.',',') .'</td>';
                                                    $html_table .= '<td> '.$currency.'. '.$row['price'].'</td>';
                                                    
                                                $html_table .= '</tr>';   
                                            }
                                            
                                            $html_table .= '<tr>';
                                                $html_table .= '<td colspan="3">  </td>';
                                                $html_table .= '<td><b> Totales:</b> </td>';
                                                $html_table .= '<td><b> '.$currency.'. '.number_format($services_costo_total,2,'.',',').'</b></td>';
                                                $html_table .= '<td><b> '.$currency.'. '.number_format($services_total,2,'.',',').'</b></td>';
                                            $html_table .= '</tr>';  
                                            
                                            $html_table .= '<tr>';
                                                $html_table .= '<td colspan="4">  </td>';
                                                $html_table .= '<td><b> Ganancia:</b> </td>';
                                                $html_table .= '<td><b> '.$currency.'. '.number_format($services_total-$services_costo_total,2,'.',',').'</b></td>';
                                            $html_table .= '</tr>';  
                                        }
                                    $html_table .='</table>';
                                        
                                        echo $html_table;
                                    }else{
                                        echo '<div class="col-sm-12"><br><center><h5 class="poppins">Aún no hay servicios agregados.</h5><br><img src="'.base_url().'public/uploads/medicamentos.svg" style="max-width:20%;"></center></div>';
                                    }
                                ?>
                            </div>
                        </div>
                        <hr>
                    </div>
                </div>
            </div>
            <div class="card-widget" style="border: 1px solid #c6c6cc;">
                <h5 class="panel-content-title">Descuentos</h5>
                <span class="app-divider2"></span>
                <div class="row">
                    <div class="col-md-12">
                        <div class="row" style="overflow-y:auto">
                            <div class="col-sm-12">
                                <?php 
                                    $total_descuentos  = 0;
                                    $refresh_query  = $this->db->get_where('stabilitation_discount',array('stabilitation_ref_id'=>$det['stabilitation_ref_id']));
                                    
                                    if($refresh_query->num_rows() > 0)
                                    {
                                    
                                    $html_table = '
                                        <table class="table">
                                            <tr style="background-color:#f9fbfc; color:#59636d">
                                                <th>Descripción</th>
                                                <th  style="text-align:center">Cantidad</th>
                                            </tr>';
                                           
                                            foreach($refresh_query->result_array() as $row)
                                            {
                                                $total_descuentos += $row['amount'];
                                                $html_table .= '<tr>';
                                                    $html_table .= '<td> '.$row['description'].' </td>';
                                                    $html_table .= '<td style="text-align:center"> '.$currency.'. '.number_format($row['amount'],2,'.',',').'</td>';
                                                $html_table .= '</tr>';   
                                            $html_table .= '<tr>';
                                                $html_table .= '<td style="text-align:right"><b> Total:</b> </td>';
                                                $html_table .= '<td style="text-align:center"><b> '.$currency.'. '.number_format($total_descuentos,2,'.',',').'</b></td>';
                                            $html_table .= '</tr>';  
                                            
                                        }
                                    $html_table .='</table>';
                                        
                                        echo $html_table;
                                    }else{
                                        echo '<div class="col-sm-12"><br><center><h5 class="poppins">Aún no hay descuentos agregados.</h5><br><img src="'.base_url().'public/uploads/medicamentos.svg" style="max-width:20%;"></center></div>';
                                    }
                                ?>
                            </div>
                        </div>
                        <hr>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-4">

            <form action="<?php echo base_url();?>doctor/stabilitation/end/<?php echo $det['stabilitation_ref_id'];?>" method="POST">
                <div id="resumen">
                    <div class="card-widget" style="border: 1px solid #c6c6cc;">
                        <h4 class="panel-content-title">Resumen</h4>
                        <span class="app-divider2"></span>
                        <div class="row">
                            <div class="col-sm-7">
                                <span style="text-align:left">
                                    <b>Practica:</b>
                                </span>
                            </div>
                            <div class="col-sm-5">
                                <span style="float:left">
                                    <b>Cargos:</b>
                                </span>
                            </div>

                            <?php 
                                $su = $insumos_total + $services_total  - $total_descuentos;
                                $cost = $insumos_costo_total + $services_costo_total;
                            ?>

                            <div class="col-sm-7">
                                <span style="float:left">
                                    Insumos.
                                </span>
                            </div>
                            <div class="col-sm-5">
                                <span style="float:left">
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">Q.</div>
                                        </div>
                                        <input type="text" class="form-control monto" style=" margin-right:0;" value="<?php echo number_format($insumos_total,2,'.',',');?>" onkeyup="change_amout(this.value)" onchange="change_amout(this.value)" disabled="disabled" /><br>
                                    </div>
                                </span>
                            </div>
                            <div class="col-sm-7">
                                <span style="float:left">
                                    Services.
                                </span>
                            </div>
                            <div class="col-sm-5">
                                <span style="float:left">
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">Q.</div>
                                        </div>
                                        <input type="text" class="form-control services" style=" margin-right:0;" value="<?php echo number_format($services_total,2,'.',',');?>" disabled="disabled" /><br>
                                    </div>
                                </span>
                            </div>
                            <div class="col-sm-7">
                                <span style="float:left">
                                    Otros descuentos
                                </span>
                            </div>
                            <div class="col-sm-5">
                                <span style="float:left">
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">Q.</div>
                                        </div>
                                        <input disabled value="<?php  echo number_format($total_descuentos,2,'.',',') ?>" type="text" class="form-control descuento" style="margin-right:0;" min='0' onkeyup="change_amout(this.value)" onchange="change_amout(this.value)" /><br>
                                    </div>
                                </span>
                            </div>
                            <div class="col-sm-12">
                                <span style=" background: #fafbfe; padding: 15px; border: 2px dotted #748be6; border-radius: 15px; display: block; font-size: 25px; font-weight: 700; width: 100%; font-family: 'Quicksand';">
                                    Total ingresado:
                                    <span id="total_text">
                                        <?php echo $currency.'. '.number_format($su,2,'.',',');?>
                                    </span>
                                    </br>
                                    Total de costo:
                                    <span id="total_text">
                                        <?php echo  $currency.'. '.number_format($cost,2,'.',',');?>
                                    </span>

                                </span>
                                <br>
                            </div>

                            <div class="col-sm-12">
                                <span style=" background: #fafbfe; padding: 15px; border: 2px dotted #748be6; border-radius: 15px; display: block; font-size: 25px; font-weight: 700; width: 100%; font-family: 'Quicksand';">
                                    Ganancia:
                                    <span id="total_text">
                                        <?php echo  $currency.'. '.number_format($su-$cost,2,'.',',');?>
                                    </span>
                                </span>
                                <br>
                            </div>
                            <?php if($det['status']==10):?>
                            <a class="btn btn-primary" href="<?php echo base_url();?>doctor/print_receipt/<?php echo base64_encode($det['stabilitation_ref_id']);?>" style="width:30%; float:right" target="_blank">
                                Resumen del paciente.
                            </a>
                            <?php endif;?>
                        </div>
                    </div>
                </div>
        </div>
        </form>
    </div>
</div>

<script src="<?php echo base_url();?>public/assets/search/bootstrap3-typeahead.js"></script>
<script src="<?php echo base_url();?>public/assets/theme/js/select2.min.js"></script>
<?php endforeach; ?>