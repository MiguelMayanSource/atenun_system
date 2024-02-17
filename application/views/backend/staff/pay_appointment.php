<style>
@media (max-width: 768px) {
    .order-box {
        padding: 15px;
    }

    .order-box .order-items-table {
        text-align: center;
        border-bottom: none;
        margin-bottom: 0px;
    }

    .order-box .order-items-table .quantity-input .form-control {
        -webkit-box-flex: 1;
        flex: 1;
    }

    .order-box .order-items-table .product-price {
        font-size: 1.5rem;
        color: #047bf8;
    }

    .order-box .order-items-table .product-image {
        max-width: 120px;
        max-height: 120px;
        margin: 0px auto;
    }

    .order-box .order-items-table .product-remove-btn {
        position: absolute;
        top: 10px;
        right: 0px;
        font-size: 24px;
    }

    .order-box .order-items-table .table thead {
        display: none;
    }

    .order-box .order-items-table .table tbody tr {
        display: block;
        border-bottom: 1px solid #eee;
        position: relative;
    }

    .order-box .order-items-table .table tbody tr td {
        display: block;
        border: none;
        padding: 5px;
    }

    .ecommerce-customer-info {
        margin-top: 20px;
    }
}

.box-style,
.invoice-w,
.order-box,
.ecommerce-customer-info {
    border-radius: 6px;
    background-color: #fff;
    box-shadow: 0px 2px 4px rgba(126, 142, 177, 0.12);
}

.order-box {
    padding: 30px;
}

.order-box .order-details-box {
    display: -webkit-box;
    display: flex;
    -webkit-box-pack: justify;
    justify-content: space-between;
    margin-bottom: 20px;
    -webkit-box-align: center;
    align-items: center;
}

.order-box .order-details-box .order-main-info span {
    display: block;
    color: #adb5bd;
    line-height: 1.3;
}

.order-box .order-details-box .order-main-info strong {
    display: block;
    font-size: 1.5rem;
    line-height: 1.3;
}

.order-box .order-details-box .order-sub-info span {
    display: block;
    color: #adb5bd;
    line-height: 1.3;
    font-size: 0.775rem;
}

.order-box .order-details-box .order-sub-info strong {
    display: block;
    font-size: 0.9rem;
    line-height: 1.3;
}

.order-box .order-controls {
    background-color: #FFF7EA;
    border: 1px solid #E9D9C1;
    padding: 10px;
    margin-bottom: 20px;
}

.order-box .order-controls .form-group {
    margin-right: 15px;
    padding-right: 15px;
    border-right: 1px solid rgba(0, 0, 0, 0.05);
}

.order-box .order-controls .form-group label {
    margin-right: 5px;
}

.order-box .order-controls .form-group:last-child {
    border-right: none;
    margin-right: 0px;
    padding-right: 0px;
    margin-left: auto;
}

.order-box .order-items-table {
    margin-bottom: 40px;
    padding-bottom: 20px;
    border-bottom: 1px solid rgba(0, 0, 0, 0.1);
}

.order-box .order-items-table .product-image {
    width: 70px;
    height: 70px;
    background-size: contain;
    background-repeat: no-repeat;
    background-position: center center;
}

.order-box .order-items-table .product-name {
    font-weight: 500;
    font-size: 1.25rem;
    line-height: 1.3;
}

.order-box .order-items-table .product-remove-btn {
    color: #E08989;
    font-size: 16px;
}

.order-box .order-items-table .product-details {
    color: #adb5bd;
    font-size: 0.8rem;
}

.order-box .order-items-table .product-details strong {
    color: #3E4B5B;
}

.order-box .order-items-table .product-details .color-box {
    width: 10px;
    height: 10px;
    display: inline-block;
    margin-left: 5px;
    margin-right: 10px;
}

.order-box .order-items-table .product-price {
    font-weight: 500;
    font-size: 1.25rem;
}

.order-box .order-items-table .quantity-input .input-group-text {
    padding-left: 5px !important;
    padding-right: 5px !important;
}

.order-box .order-items-table .quantity-input .form-control {
    -webkit-box-flex: 0;
    flex: 0 0 45px;
    text-align: center;
    font-weight: 500;
}

.order-box .order-section-heading {
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    padding-bottom: 10px;
    margin-bottom: 15px;
}

.ecommerce-customer-info {
    padding: 30px;
}

.ecommerce-customer-info .ecommerce-customer-main-info {
    text-align: center;
    margin-bottom: 20px;
    padding-bottom: 20px;
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
}

.ecommerce-customer-info .ecommerce-customer-main-info .ecc-avatar {
    width: 90px;
    height: 90px;
    background-size: cover;
    background-position: center center;
    border-radius: 50%;
    background-color: #fff;
    margin: 0px auto;
    box-shadow: 0px 0px 0px 10px #fff;
}

.ecommerce-customer-info .ecommerce-customer-main-info .ecc-name {
    margin-top: 10px;
    font-weight: 500;
    font-size: 1.25rem;
}

.ecommerce-customer-info .ecommerce-customer-sub-info {
    margin-bottom: 30px;
}

.ecommerce-customer-info .ecc-sub-info-row {
    margin-bottom: 10px;
}

.ecommerce-customer-info .ecc-sub-info-row+.ecc-sub-info-row {
    padding-top: 10px;
    border-top: 1px solid rgba(0, 0, 0, 0.05);
}

.ecommerce-customer-info .ecc-sub-info-row .sub-info-label {
    display: block;
    color: #adb5bd;
    text-transform: uppercase;
    letter-spacing: 1px;
    font-size: 0.8rem;
    margin-bottom: 4px;
}

.ecommerce-customer-info .ecc-sub-info-row .sub-info-value {
    display: block;
}

.ecommerce-customer-info .ecc-sub-info-row .sub-info-value img {
    margin-right: 5px;
}

.ecommerce-customer-info .os-tabs-controls .nav {
    flex-wrap: nowrap;
}

.ecommerce-customer-info .os-tabs-controls .nav-link {
    white-space: nowrap;
    padding: 10px 0px;
}

.order-summary-row {
    display: -webkit-box;
    display: flex;
    -webkit-box-pack: justify;
    justify-content: space-between;
    -webkit-box-align: center;
    align-items: center;
}

.order-summary-row.as-total .order-summary-label {
    font-weight: 500;
    font-size: 1.25rem;
    color: #3E4B5B;
}

.order-summary-row.as-total .order-summary-value {
    font-weight: 500;
    font-size: 1.5rem;
}

.order-summary-row .order-summary-label {
    color: #adb5bd;
}

.order-summary-row .order-summary-label strong {
    display: block;
    color: #3E4B5B;
    font-size: 0.8rem;
}

.order-summary-row .order-summary-value {
    font-weight: 500;
}

.order-summary-row+.order-summary-row {
    border-top: 1px solid rgba(0, 0, 0, 0.05);
    padding-top: 5px;
    margin-top: 5px;
}

.order-summary-row+.order-summary-row.as-total {
    margin-top: 20px;
    padding-top: 10px;
    border-top: 3px solid #222;
}
</style>
<link href="<?php echo base_url();?>public/assets/appointments/css/select2.css" rel="stylesheet" />
<div id="main-content">
    <?php
     $cash = $this->crud_model->getNomenCash();
     $brl = $this->crud_model->getAccountByBankName("Banrural");
     $bam = $this->crud_model->getAccountByBankName("BAM");
        $currency = $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->currency;
       
        $cart_total = 0;
        $_id = base64_decode($id_);
        $this->db->where('appointment_id', $_id);
        $num = $this->db->get('cart')->num_rows();
        //$prescription_id = $this->db->get_where('prescription', array('appointment_id' => $_id))->num_rows();
        if($num==0){
        $this->db->where('appointment_id', $_id);
        $info = $this->db->get('appointment')->result_array();    
        foreach($info as $details):
        
         $charge =  $this->db->get_where('product_price',array('product_id'=>$details['practice'],'insurance_id'=>0))->row()->price;
         if($details['status']==6):?>
    <form action="<?php echo base_url();?>staff/appointments/pay_1/<?php echo $_id; ?>" method="POST">
        <?php endif;?>
        
        <?php if($details['status']==10):?>
    <form action="<?php echo base_url();?>staff/appointments/pay_2/<?php echo $_id; ?>" method="POST">
        <?php endif;?>
        
        
        <div class="row">
            <div class="col-md-8">
                <div class="order-box">
                    <div class="order-details-box">
                        <div class="order-main-info">
                            <strong style="font-size:25px;"><?php if($details['status']==1) echo 'Detalles de venta'; else echo 'Detalles de la cotización';?></strong>
                        </div>
                        <div class="dropdown" style="float:right">
                            <button class="btn btn-secondary" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="float:right; margin-top:15px;margin-right:10%;background:#0176fe; color:#fff; border:0px;border-radius:5px;-webkit-box-shadow: 0px 2px 14px rgba(1, 118, 254, 0.40); box-shadow: 0px 2px 14px rgba(1,118, 254, 0.40); ">
                                <i class="batch-icon-ellipsis"></i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="width:auto; text-align:left;overflow-y:hidden">
                                <?php if($details['status'] == 1):?>
                                    <a class="dropdown-item" target="_blank" href="<?php echo base_url();?>staff/print_receipt/<?php echo $details['sale_id'];?>/<?php echo $details['patient_id'];?>">Imprimir</a>
                                    <a class="dropdown-item" href="javascript:void(0);" onclick="send_email(<?php echo $details['sale_id'];?>,'<?php echo $details['patient_id'];?>')">Enviar por correo</a>
                                    <a class="dropdown-item" href="javascript:void(0);" onclick="send_whatsapp(<?php echo $details['sale_id'];?>,'<?php echo $details['patient_id'];?>')">Enviar por whatsapp</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="order-details-box">
                        <div class="order-main-info">
                            <strong style="font-size:38px;"> Detalles de la cita</strong>
                        </div>
                    </div>
                    <hr>
                    <h4>Cargos de la consulta</h4>
                    <div>
                        <table style="width:90%">
                            <tbody>
                                <tr style="font-family:'Poppins';font-size:14px;">
                                    <td>
                                        <b><?php echo $this->db->get_where('product',array('product_id'=>$details['practice']))->row()->name; ?></b>
                                    </td>
                                    <td class="text-right">
                                        <strong><?php 
                                        echo $currency.'. '.number_format($charge,'2','.',','); ?></strong>
                                        <input type="hidden" name="total_charges" value="<?php echo $charge; ?>" />
                                        <input type="hidden" name="service" value="<?php echo $details['practice']; ?>" />
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <hr>
                    <?php if($details['status'] == '10'):?>
                    
                    <?php 
                        $productsext = $this->db->get_where('product_move',array('origin_id'=>$_id,'origin_type'=>'appointment'))->result_array();  
                        if(count($productsext) > 0):
                    ?>
                    <div class="order-items-table">
                        <h5>Productos y Medicamentos extras</h5>
                       <table class="table " id="products">
                            <tr>
                                <th>
                                    Producto<span class="text-danger">*</span>
                                </th>
                                <th>
                                    Cantidad<span class="text-danger">*</span>
                                </th>
                                <th>
                                    C/U<span class="text-danger">*</span>
                                </th>
                                <th>
                                    Descuento/Seguro
                                </th>
                                <th>
                                    Total
                                </th>
                                <th class="col-sm-1">

                                </th>
                            </tr>
                            <?php 
                            
                            foreach( $productsext as $pextras):
                                
                            $prexprice = $this->inventory_model->get_product_price($pextras['product_id'],0); 
                            
                            ?>
                            <tr>
                                <td style="width: 150px">
                                    <?php echo $this->db->get_where('product',array('product_id'=>$pextras['product_id']))->row()->name;?>
                                </td>
                                <td>
                                    <input type="hidden" value="<?= $pextras['amount']; ?>" name="amount[]" required="" onchange="getSbtotal('<?php echo  $pextras['product_move_id']; ?>')" onKeyUp="getSbtotal('<?php echo  $pextras['product_move_id']; ?>')" id="amount_<?php echo  $pextras['product_move_id']; ?>">
                                    <?php echo $pextras['amount'].' '.$this->db->get_where('unity',array('code'=>$pextras['unity']))->row()->name; ?>
                                </td>
                                <td style="width: 150px">
                                    <div class="form-group">
                                        <div class="input-group">

                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Q</span>
                                            </div>
                                            <input required type="text" style="max-width: 90px;" step="any" value="<?php   echo $prexprice; ?>" class="form-control" name="subtotal[]" required="" id="sb_<?php echo $pextras['product_move_id']; ?>" onchange="getSbtotal('<?php echo $pextras['product_move_id']; ?>')" onKeyUp="getSbtotal('<?php echo $pextras['product_move_id']; ?>')">
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <select class="form-control" onchange="getSbtotal('<?php echo $pextras['product_move_id']; ?>')" name="tdiscount[]" id="tdes_<?php echo $pextras['product_move_id']; ?>">
                                                    <option value="Q">Q</option>
                                                    <option value="%">%</option>
                                                    <option value="P">P</option>
                                                </select>
                                            </div>
                                            <input type="number" style="max-width: 90px;" step="any" class="form-control" name="discount[]" required="" id="des_<?php echo $pextras['product_move_id']; ?>" onchange="getSbtotal('<?php echo $pextras['product_move_id']; ?>')" onKeyUp="getSbtotal('<?php echo $pextras['product_move_id']; ?>')">
                                        </div>
                                        <small id="tdessmall_<?php echo $pextras['product_move_id']; ?>"></small>

                                    </div>
                                </td>
                                <td style="width: 100px">
                                    <div class="form-group">
                                        <span id="tl_<?php echo $pextras['product_move_id']; ?>">Q. <?php $extrasbtotal = $prexprice*$pextras['amount']; $extratotal += $extrasbtotal; echo number_format($extrasbtotal,2,'.',',');?></span>
                                        <input class="total" type="hidden" id="inputtl_<?php echo $pextras['product_move_id']; ?>" value="0" name="total[]">
                                    </div>
                                </td>
                                <td class="col-sm-1">

                                </td>
                            </tr>
                            <?php endforeach; ?>
                             <tr>
                               
                                <td style="text-align:right;" colspan="4">
                                    TOTAL: 
                                </td>
                                <td class="col-sm-1">
                                    <?php echo 'Q. '.number_format($extratotal,2,'.',','); ?>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <?php endif; ?>
                    
                    
                    
                    <div class="order-items-table">
                        
                        <input type="hidden" name="patient_id" value="<?php echo $details['patient_id']?>" />
                        <input type="hidden" name="appointment_id" value="<?php echo $_id;?>" />
                        <h4>Medicamentos</h4>
                        <div class="table-responsive">

                      
                            <table class="table " id="products">
                            <tr>
                                <th>
                                     Categoría<span class="text-danger">*</span>
                                </th>
                                <th>
                                    Producto<span class="text-danger">*</span>
                                </th>
                                <th>
                                Cantidad<span class="text-danger">*</span>
                                </th>
                                <th>
                                    C/U<span class="text-danger">*</span>
                                </th>
                                <th>
                                    Descuento
                                </th>
                                <th>
                                    Total
                                </th>
                                <th class="col-sm-1">

                                </th>
                            </tr>
                            <tr>
                                <td>
                                    <select class="form-control mb3 select2"  name="cat_id[]" onchange="getProducts(this.value,'<?php $_id = uniqid(); echo $_id;?>')" ;>
                                        <option value="">Seleccionar</option>
                                        <option value="0">Todos</option>
                                        <?php  $products = $this->db->get_where('category', array('status'=>1))->result_array();
                                            foreach ($products as $product): ?>
                                        <option value="<?php echo $product['id']; ?>"><?php echo $product['name']?></option>
                                        <?php endforeach;  ?>
                                    </select>
                                </td>
                                <td style="width: 200px">
                                    <select class="form-control mb3 select2"  name="product_id[]" id="prod_<?php echo $_id; ?>" onchange="getPres(this.value,'<?php echo $_id;?>')" ;>
                                        <option value="">Seleccionar</option>
                                    </select>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <input type="number" step="any" class="form-control" name="amount[]" required="" onchange="getSbtotal('<?php echo $_id; ?>')" onKeyUp="getSbtotal('<?php echo $_id; ?>')" id="amount_<?php echo $_id; ?>">
                                            <div class="input-group-append" id="unity_<?php echo $_id; ?>">

                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <div class="input-group">

                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Q</span>
                                            </div>
                                            <input required type="number" step="any" class="form-control" name="subtotal[]" required="" id="sb_<?php echo $_id; ?>" onchange="getSbtotal('<?php echo $_id; ?>')" onKeyUp="getSbtotal('<?php echo $_id; ?>')">
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <select class="form-control" onchange="getSbtotal('<?php echo $_id; ?>')" name="tdiscount[]" id="tdes_<?php echo $_id; ?>">
                                                    <option value="Q">Q</option>
                                                    <option value="%">%</option>
                                                    <option value="P">P</option>
                                                </select>
                                            </div>
                                            <input type="number" step="any" class="form-control" name="discount[]" required="" id="des_<?php echo $_id; ?>" onchange="getSbtotal('<?php echo $_id; ?>')" onKeyUp="getSbtotal('<?php echo $_id; ?>')">
                                        </div>
                                        <small id="tdessmall_<?php echo $_id; ?>"></small>

                                    </div>
                                </td>
                                <td style="width: 100px">
                                    <div class="form-group">
                                        <span id="tl_<?php echo $_id; ?>">Q.</span>
                                        <input class="total" type="hidden" id="inputtl_<?php echo $_id; ?>" value="0" name="total[]">
                                    </div>
                                </td>
                                <td class="col-sm-1">

                                </td>
                            </tr>
                        </table>
                          
                            <div class="col-sm-12" style="margin-top: 15px;">
                                <button type="button" class="btn btn-info btn-sm" onclick="addProduct()">Agregar otro producto</button>
                            </div>
                        </div>
                        <div id="labs">
                        </div>
                        <div id="rays">
                        </div>
                    </div>
                    <?php endif;?>
                    <div class="col-sm-12" style="margin-top: 15px;">
                        <div class="order-foot">
                            <div class="row">
                                <div class="col-md-7">

                                    <div class="row">
                                        <div class="col-md-12 mb-4">
                                            <h5>Nota</h5>
                                            <div class="form-group">
                                                <textarea class="form-control" name="description" placeholder="Escribe una nota a esta consulta..." rows="7"></textarea>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-5" id="resumen">
                                    <h5 class="order-section-heading">Resumen</h5>
                                    <?php
                                        if($details['status'] == 0):
                                    ?>
                                    <div class="order-summary-row">
                                        <div class="order-summary-label">
                                            <span>Consulta</span>
                                        </div>
                                        <div id="sb_total" class="order-summary-value" style="display:none"><?php echo $charge ;?></div>
                                        <div class="order-summary-value"><?php echo $currency.'. '.$charge ;?></div>
                                    </div>
                                    <?php endif; ?>
                                    <?php if($details['status'] == 10):?>
                                    <div class="order-summary-row" id="total_labs_result">
                                        <div class="order-summary-label">
                                            <span>Servicios o medicamentos extras</span>
                                        </div>
                                        <div class="order-summary-value" id="total_extras"><?php echo 'Q. '.number_format($extratotal,2,'.',','); ?></div>
                                    </div>
                                    <div class="order-summary-row" id="total_labs_result">
                                        <div class="order-summary-label">
                                            <span>Laboratorios</span>
                                        </div>
                                        <div class="order-summary-value" id="total_labs_amout"><?php echo $currency.'. '.$charge ;?></div>
                                    </div>
                                    <div class="order-summary-row" id="total_rayos">
                                        <div class="order-summary-label">
                                            <span>Rayos X</span>
                                        </div>
                                        <div  class="order-summary-value" id="total_rayos_amout"><?php echo $currency.'. '.$charge ;?></div>
                                    </div>
                                    <?php endif; ?>
                                    <div class="order-summary-row as-total" id="tot">
                                        <div class="order-summary-label"><span>Total</span></div>
                                        <div id="grand_total" class="order-summary-value"><?php echo $currency.'. '.number_format($charge,'2','.',',');?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="ecommerce-customer-info">
                    <h3 style="color:#43485c">Detalles del paciente</h3>
                    <hr>
                    <div class="ecommerce-customer-main-info">
                        <div class="ecc-avatar" style="background-image: url(<?php echo $this->accounts_model->get_photo('patient',$details['patient_id']);?>)"></div>
                        <div class="ecc-name">
                            <?php echo $this->accounts_model->short_name('patient', $details['patient_id']);?>
                        </div>
                    </div>
                    <div class="ecommerce-customer-sub-info">
                        <div class="ecc-sub-info-row">
                            <div class="sub-info-label">
                                Responsable de la consulta
                            </div>
                            <div class="sub-info-value">
                                <span>
                                    <?php echo $this->accounts_model->short_name('admin',$details['doctor_id']);?>
                                </span>
                            </div>
                        </div>
                        <div class="ecc-sub-info-row">
                            <div class="sub-info-label">
                                Fecha y hora de la consulta
                            </div>
                            <div class="sub-info-value">
                                <span><?php echo $details['date']." ".$details['time'];?></span>
                            </div>
                        </div>
                    </div>
                    <div class="tab-content">
                        <div class="col-lg-12 col-md-12 col-ms-12 mb-2 row">
                            <h5 class="font-size-14 mt-2">Datos de facturación: <span class="text-danger">*</span></h5>

                            <div class="col-lg-12 col-md-12 col-ms-12 mb-2">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-check form-check-right mb-1">
                                            <input class="form-check-input" type="radio" name="type_id" id="type_id_1" value="NIT" checked />
                                            <label class="form-check-label" for="type_id_1">NIT</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-check form-check-right mb-1">
                                            <input class="form-check-input" type="radio" name="type_id" id="type_id_2" value="CUI" />
                                            <label class="form-check-label" for="type_id_2">CUI</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-4"></div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 col-ms-12 mb-2">
                                <div class="" id="divNIT">
                                    <div class="col-form-label">NIT:</div>
                                    <input type="text" class="form-control" name="nit" id="nit" value="CF" placeholder="NIT" onblur="verifyClient()" />
                                    <small class="text-danger msgClient"></small>
                                </div>
                                <div class="" id="divCUI" style="display:none;">
                                    <div class="col-form-label">CUI:</div>
                                    <input type="text" class="form-control" name="cui" id="cui" value="" placeholder="CUI" onblur="verifyClient()" maxlength="15" />
                                    <small class="text-danger msgClient"></small>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 col-ms-12 mb-2" style="display:none;" id="divConsFinal">
                                <div class="">
                                    <div class="col-form-label">CONSUMIDOR FINAL</div>
                                    <select name="" id="final_consumer" class="form-select" onchange="setNewClient()">
                                        <option value="N" selected>Nuevo</option>
                                        <?php $final_cons = $this->crud_model->getClientsCF();
                                                                foreach($final_cons->result_array() as $fn):?>
                                        <option value="<?php echo $fn['client_id'];?>"><?php echo $fn['first_name'].' '.$fn['last_name'];?></option>
                                        <?php endforeach;?>
                                    </select>
                                </div>
                            </div>
                            <input type="hidden" name="client_id" id="client_id" value="0" />
                            <input type="hidden" name="type_client" id="type_client" value="C" />
                            <input type="hidden" name="first_name" id="first_name" value="CONSUMIDOR" />
                            <input type="hidden" name="last_name" id="last_name" value="FINAL" />
                            <div class="col-sm-12 mb-2">
                                <div class="">
                                    <div class="col-form-label">Nombre:</div>
                                    <input type="text" class="form-control" name="full_name" required id="full_name" value="CONSUMIDOR FINAL" placeholder="" oninput="changeFullName()">
                                </div>
                            </div>
                            <div class="col-lg-12 mb-2" id="divTelefono" style="display:none;">
                                <div class="">
                                    <div class="col-form-label">Teléfono:</div>
                                    <input type="text" class="form-control" name="phone" id="phone" value="" placeholder="" oninput="verifyCredit()" />
                                </div>
                            </div>
                            <div class="col-lg-12 mb-2">
                                <div class="">
                                    <div class="col-form-label">Dirección:</div>
                                    <textarea name="address" id="address" rows="1" required class="form-control" placeholder="">Ciudad</textarea>
                                </div>
                            </div>
                            <div class="col-lg-1" style="display:none;">
                                <div class="">
                                    <label for="" class="col-form-label">Exento de IVA</label><br>
                                    <input type="checkbox" id="check_exempt" name="exempt" switch="info" value="1" />
                                    <label for="check_exempt" data-on-label="Si" data-off-label="No"></label>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-ms-12 mb-2 row">
                            <div class="col-lg-12 mb-2">
                                <div class="">
                                    <label for="" class="col-form-label">Método de pago</label>
                                    <select name="method" id="method" class="form-control" onchange="verifyMethod()">
                                        <option value="1" selected>Efectivo</option>
                                        <option value="3">Transacción Bancaria</option>
                                        <option value="5">POS</option>
                                        <option value="6">Visa Link</option>
                                        <option value="4">Crédito</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12 mb-2">
                                <div class="row">
                                    <div class="col-lg-12 mb-2" id="divCash" style="">
                                        <div class="">
                                            <label for="cash_id" class="col-form-label">Cuenta de caja</label><br>
                                            <select name="cash_id" id="cash_id" class="form-control select2-cash" required >
                                                <option value="">Seleccione una cuenta</option>
                                                <?php foreach($cash->result_array() AS $ch): ?>

                                                <option value="<?php echo $ch['nomenclature_id'];?>"><?php echo $ch['name'].' '.$ch['code'];?></option>
                                                <?php  endforeach;?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 mb-2" id="divAccounts" style="display:none;">
                                        <div class="form-group">
                                            <label for="bank_account_id" class="col-form-label">Cuenta bancaria</label><br>
                                            <select name="bank_account_id" id="bank_account_id" class="form-control select2-bank" onchange="checkAccount(this.value)">
                                                <option value="">Seleccione una cuenta</option>
                                                <?php foreach($bam->result_array() AS $ct):?>
                                                <option value="<?php echo $ct['bank_account_id'];?>"><?php echo $ct['name'].' '.$ct['code'];?></option>
                                                <?php endforeach;?>
                                                <?php foreach($brl->result_array() AS $ct):?>
                                                <option value="<?php echo $ct['bank_account_id'];?>"><?php echo $ct['name'].' '.$ct['code'];?></option>
                                                <?php endforeach;?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-12" id="divTypeTransfer" style="display:none;">
                                        <h5 class="font-size-14 mt-2 mb-2">Método de transacción</h5>
                                        <div class="row">
                                            <div class="col-lg-3">
                                                <div class="form-check form-check-right mb-3">
                                                    <input class="form-check-input" type="radio" name="type_transfer" id="type_transfer_1" value="T" checked />
                                                    <label class="form-check-label" for="type_transfer_1">Transferencia</label>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-check form-check-right mb-3">
                                                    <input class="form-check-input" type="radio" name="type_transfer" id="type_transfer_2" value="C" />
                                                    <label class="form-check-label" for="type_transfer_2">Cheque</label>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-check form-check-right mb-3">
                                                    <input class="form-check-input" type="radio" name="type_transfer" id="type_transfer_3" value="D" />
                                                    <label class="form-check-label" for="type_transfer_3">Depósito</label>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-check form-check-right mb-3">
                                                    <input class="form-check-input" type="radio" name="type_transfer" id="type_transfer_4" value="Tr" />
                                                    <label class="form-check-label" for="type_transfer_4">Tarjeta</label>
                                                </div>
                                            </div>
                                            <div class="col-sm-12" id="fact">
                                                <div class="form-group m-b-15">
                                                    <label for="simpleinput">No. referencia</label></label>
                                                    <div class="form-group">
                                                        <input type="text" name="reference_code" class="form-control">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-12" id="fact2">
                                                <div class="form-group m-b-15">
                                                    <label for="simpleinput">Subir imagen</label>
                                                    <label class="labelx" for="apply2"><input type="file" name="reference_file" class="inputx" id="apply2" accept="image/*,.pdf">Seleccionar</label>
                                                    <small id="fileResponse2"></small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12" id="divDays" style="display:none;">
                                        <div class="form-group">
                                            <label for="bank_account_id" class="col-form-label">Dias</label>
                                            <input type="number" class="form-control" name="days" id="days" value="0" step="1" min="0" oninput="verifyCredit()" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 col-ms-12 mb-2">
                                <div class="form-group">
                                    <label for="bank_account_id" class="col-form-label">Establecimientos</label>
                                    <select name="establecimiento_id"  class="form-select form-control" required onchange="getDataInstitution()">
                                        <option value="">Seleccione un establecimiento</option>
                                        <?php $insts = $this->crud_model->getInstitutionMode();
                                                        foreach ($insts->result_array() as $in):?>
                                        <option value="<?php echo $in['establecimiento_id'];?>"><?php echo $in['nombre']." (".$in['afiliacion'].")";?></option>
                                        <?php endforeach;?>
                                    </select>
                                    <br>
                                </div>
                            </div>
                            <?php if($details['status'] == '6'): ?>
                                <button class="btn btn-success" type="submit">Realizar cobro</button>
                            <?php elseif($details['status'] == '10'): ?>
                                <button class="btn btn-success" type="submit">Finalizar consulta</button>
                            <?php elseif($details['status'] == '1'): ?>
                                <div class="alert alert-success">
                                    <span class="alert-title"><i class="batch-icon-spam"></i> Cita ya cancelada.</span>
                                    <span class="alert-content">Esta cita ya a sido cobrada el doctor debe finalizarla para continuar con el proceso de cobro. </span>
                                </div>
                            <?php else: ?>
                                <div class="alert alert-info">
                                    <span class="alert-title"><i class="batch-icon-spam"></i> Cita pendiente de confirmar.</span>
                                    <span class="alert-content">Esta cita no ha sido confirmada por el paciente, debe confirmar primero para realizar el cobro. </span>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </form>
    <?php 
    
    endforeach; 
    
        }else
        {
        $cart_total = 0;
        $this->db->where('appointment_id', $_id);
        $info = $this->db->get('cart')->result_array();    
        foreach($info as $details): ?>
    <div class="row">
        <div class="col-md-8">
            <div class="order-box">
                
                <div class="order-details-box">
                    <div class="order-main-info">
                        <strong style="font-size:38px;"> Detalles de la consulta</strong>
                    </div>
                    <div class="dropdown" style="float:right">
                        <button class="btn btn-secondary" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="float:right; margin-top:15px;margin-right:10%;background:#0176fe; color:#fff; border:0px;border-radius:5px;-webkit-box-shadow: 0px 2px 14px rgba(1, 118, 254, 0.40); box-shadow: 0px 2px 14px rgba(1,118, 254, 0.40); ">
                            <i class="batch-icon-ellipsis"></i>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="width:auto; text-align:left;overflow-y:hidden">
                            <a class="dropdown-item" target="_blank" href="<?php echo base_url();?>staff/patient_profile/<?php echo base64_encode($details['patient_id']);?>/">Perfil del paciente</a>
                            <a class="dropdown-item" href="<?php echo base_url();?>staff/pay_appointment/email/<?php echo $_id;?>/<?php echo $details['patient_id']?>">Enviar recibo por correo</a>
                            <?php if($prescription_id > 0):?>
                            <a class="dropdown-item" target="_blank" href="<?php echo base_url();?>staff/print_prescription_details/<?php echo $_id;?>">Imprimir receta</a>
                            <?php endif;?>

                        </div>
                    </div>
                </div>
                <hr>
                <h4>Cargos de la consulta</h4>

                <div>
                    <table style="width:90%">
                        <tbody>
                            <tr style="font-family:'Poppins';font-size:14px;">
                                <td>
                                    <b>Valor de la consulta:</b>
                                </td>
                                <td class="text-right">
                                    <strong><?php echo $currency.'. '.number_format($appointment_total=$this->db->get_where('appointment', array('appointment_id' => $_id))->row()->charges,'2','.',','); ?></strong>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <hr>

            </div>
        </div>

        <div class="col-md-4">
            <div class="ecommerce-customer-info">
                <h3 style="color:#43485c">Detalles del paciente</h3>
                <hr>
                <div class="ecommerce-customer-main-info">
                    <div class="ecc-avatar" style="background-image: url(<?php echo $this->accounts_model->get_photo('patient',$details['patient_id']);?>)"></div>
                    <div class="ecc-name">
                        <?php echo $this->accounts_model->short_name('patient', $details['patient_id']);?>
                    </div>
                </div>
                <div class="ecommerce-customer-sub-info">
                    <div class="ecc-sub-info-row">
                        <div class="sub-info-label">
                            Correo
                        </div>
                        <div class="sub-info-value">
                            <?php echo $this->db->get_where('patient', array('patient_id'=>$details['patient_id']))->row()->email;?>
                        </div>
                    </div>
                    <div class="ecc-sub-info-row">
                        <div class="sub-info-label">
                            Celular
                        </div>
                        <div class="sub-info-value">
                            +<?php echo $this->db->get_where('patient', array('patient_id'=>$details['patient_id']))->row()->phone;?>
                        </div>
                    </div>
                </div>
                <div class="tab-content">
                    <div class="ecc-sub-info-row">
                        <div class="sub-info-label">
                            Dirección
                        </div>
                        <div class="sub-info-value">
                            <p><?php echo $this->db->get_where('patient', array('patient_id'=>$details['patient_id']))->row()->address;?></p>
                        </div>
                    </div>
                    <div class="ecc-sub-info-row">
                        <div class="sub-info-label">
                            Fecha y hora de la consulta
                        </div>
                        <div class="sub-info-value">
                            <span><?php echo $details['date'];?></span>
                        </div>
                    </div>
                    <div class="ecc-sub-info-row">
                        <div class="sub-info-label">
                            Responsable de la consulta
                        </div>
                        <div class="sub-info-value">
                            <span>
                                <? 
                                        if($details['user_type'] == 'admin')
                                        {
                                            echo $this->accounts_model->gender($details['user_id']);
                                        }
                                    ?>
                                <?php echo $this->accounts_model->short_name($details['user_type'],$details['user_id']);?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php 
    endforeach; };
    ?>

</div>
<script src="<?php echo base_url();?>public/assets/theme/js/select2.min.js"></script>
<script type="text/javascript">

  <?php if($details['status'] == '10'):?>
$(function(){
    $('.select2').select2();
    getProducts(this.value, '<?php  echo $_id;?>')
    getLaboratories();
    getRayos()
    calculate_grand_total()

});

<?php endif;?>

function getProducts(product_id, variant_id) {
    $.ajax({
        url: '<?php echo base_url();?>staff/get_products/' + product_id,
        success: function(response) {
           
            if (response != "")
                jQuery('#prod_' + variant_id).html(response);
            else
                jQuery('#prod_' + variant_id).html('');
        }
    });
}


function getPrice(product_id, variant_id) {

    var price = $('input[name="ctype_id"]:checked').val();
   
    $.ajax({
        url: '<?php echo base_url();?>staff/get_product_price/' + product_id + '/' + price,
        success: function(response) {
           
            jQuery('#sb_' + variant_id).val(response);
            jQuery('#sb_' + variant_id).attr('readonly', true);
            jQuery('#des_' + variant_id).attr('max', response);

        }
    });
}

function getPres(product_id, variant_id) {
    $.ajax({
        url: '<?php echo base_url();?>staff/get_product_pres/' + product_id,
        success: function(response) {
            if (response != "")
                jQuery('#unity_' + variant_id).html(` <select name = "unity[]" class = "form-control" required = "" >${response} < /select>`);
            else
                jQuery('#unity_' + variant_id).html('');
            getPrice(product_id, variant_id)

        }
    });
}



function generateUniqueId() {
    var timestamp = new Date().valueOf(); // Get the current timestamp as a starting point
    var randomId = Math.random().toString(36).substring(2); // Generate a random string
    var uniqueId = timestamp + "-" + randomId; // Combine the timestamp and random string to create the unique ID
    return uniqueId;
}


function addProduct() {
    $id = generateUniqueId();
    $('#products').append(`
    <tr>
        <td>
            <select class="form-control mb3 select2"  name="cat_id[]" onchange="getProducts(this.value,'${$id}')" ;>
                <option value="">Seleccionar</option>
                <option value="0">Todos</option>
                <?php  $products = $this->db->get_where('category', array('status'=>1))->result_array();
                    foreach ($products as $product): ?>
                <option value="<?php echo $product['id']; ?>"><?php echo $product['name']?></option>
                <?php endforeach;  ?>
            </select>
        </td>
        <td >
            <select class="form-control mb3 select2" id="prod_${$id}"  name="product_id[]" onchange="getPres(this.value,'${$id}')" ;>
                <option value="">Seleccionar</option>
            </select>
        </td>
        <td >
            <div class="form-group">
                <div class="input-group">
                    <input type="number" step="any" class="form-control" name="amount[]" required="" onchange="getSbtotal('${$id}')" onKeyUp="getSbtotal('${$id}')" id="amount_${$id}">
                    <div class="input-group-append">
                        <select name="unity[]" class="form-control" id="unity_${$id}" required>
                        </select>
                    </div>
                </div>
            </div>
        </td>
        <td >
            <div class="form-group">
                <div class="input-group">

                    <div class="input-group-prepend">
                        <span class="input-group-text">Q</span>
                    </div>
                    <input required type="number" step="any" class="form-control" name="sbtotal[]" required="" id="sb_${$id}" onchange="getSbtotal('${$id}')" onKeyUp="getSbtotal('${$id}')">
                </div>
            </div>
        </td>
        <td >
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Q</span>
                    </div>
                    <input required type="number" step="any" class="form-control" name="discount[]" required="" id="des_${$id}" onchange="getSbtotal('${$id}')" onKeyUp="getSbtotal('${$id}')">
                </div>
            </div>
        </td>
        <td class="col-sm-1">
            <div class="form-group">
                <span id="tl_${$id}">Q.</span>
                <input class="total" type="hidden" id="inputtl_${$id}" value="0" name="total[]">
            </div>
        </td>
        <td class="col-sm-1">
            <i onclick="delete_element(this)" class="picons-thin-icon-thin-0056_bin_trash_recycle_delete_garbage_empty" style="color:#fd4f57;cursor:pointer;" data-toggle="tooltip" data-placement="top" title="" data-original-title="Eliminar"></i>
        </td>
    </tr>
    `);
    getProducts(0, $id)
    $('.select2').select2();
}

function deleteParentElement(n) {
    n.parentNode.parentNode.parentNode.removeChild(n.parentNode.parentNode);
    calculate_grand_total();
}




function send_email(app_id) {
    Swal.fire({
        title: 'Confirmar esta acción',
        text: "Se enviará un correo al paciente con la información de la compra. ¿Seguro deseas continuar?",
        type: 'info',
        showCancelButton: true,
        confirmButtonColor: '#9fd13b',
        cancelButtonColor: '#fd4f57',
        confirmButtonText: 'Enviar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.value) {
            location.href = "<?php echo base_url();?>staff/pay_appointment/email/" + app_id;
        }
    })
}
</script>
<script src="<?php echo base_url();?>public/assets/search/bootstrap3-typeahead.js"></script>
<script>

var count = 1;
var total = 0;
var totalSum = 0;

function show_response(variant_id) {
    $.ajax({
        url: '<?php echo base_url();?>staff/sales_order_entry_response/' + variant_id,
        success: function(response) {

            jQuery('#sales_order_entry_1').html(response);
            $('#add_entry_button').prop('disabled', false);

        }
    });
}

function append_sales_order_entry() {
    var selected_variants = '';
    $(".variant").each(function() {
        selected_variants += $(this).val() + '.';

    });
    count++;
    $.ajax({
        url: '<?php echo base_url();?>staff/sales_order_append_entry_response/' + count + '/' + selected_variants,
        success: function(response) {
            jQuery('#sales_order_entry_append').append(response);
            $('#add_entry_button').prop('disabled', true);


        }
    });
}

function deleteParentElement(n) {
    n.parentNode.parentNode.parentNode.removeChild(n.parentNode.parentNode);
    calculate_grand_total();
}

function getSbtotal(variant_id) {
    var cant = $('#amount_' + variant_id).val() || 0;
    var sub = $('#sb_' + variant_id).val() || 0;
    var des = $('#des_' + variant_id).val() || 0;

    var total = (cant * sub) - des;

    $('#tl_' + variant_id).html('Q' + total.toFixed(2));
    $('#inputtl_' + variant_id).val(total.toFixed(2));

    calculate_grand_total();

}

function calculate_grand_total() {
    var total = 0;
    var total_labs = 0;
    var total_rays = 0;
    
    $('.total').each(function() {
        total += parseFloat($(this).val());
    })
    
    total += $('input[name="total_charges"]').val();
      $('.total_labs').each(function() {
        total_labs += parseFloat($(this).val());
    })
    
      $('.total_rays').each(function() {
        total_rays += parseFloat($(this).val());
    })
    
    $('#total_labs_amout').html('Q' + total_labs.toFixed(2));
    
    $('#total_rayos_amout').html('Q' + total_rays.toFixed(2));
    $('#grand_total').html('Q' + total.toFixed(2));


}


$("input[type='radio'][name='type_id']").change(function() {
    var val = this.value;
    if (val == "NIT") {
        $("#divCUI").hide(300);
        $("#divNIT").show(300);

    } else if (val == "CUI") {
        $("#divNIT").hide(500);
        $("#divCUI").show(300);
    }
    verifyClient();
});

function verifyClient() {
    var type = $('input[name="type_id"]:checked').val();
    if (type == "NIT") {
        var nit = $("#nit").val();
        var val = $.trim(nit.toUpperCase());
        if (nit == '') {
            $("#divConsFinal").hide(300);
            $(".msgClient").text("Debe ingresar el nit del cliente");
            $("#dataClient").hide(500);
            client = false;
            verifyData();
        } else if (val == 'CF' || val == 'C/F' || val == 'C F' || val == 'C /F' || val == 'C/ F') {
            $("#divConsFinal").hide(300);
            $("#client_id").val('0');
            $("#first_name").val("Consumidor");
            $("#last_name").val("Final");
            $("#full_name").val("Consumidor Final");
            $("#phone").val('');
            $("#address").val("Ciudad");
            $("#type_client").val("C");
            client = true;
            verifyTotal();
        } else if (nit == 'CONSUMIDOR FINAL') {
            $("#divConsFinal").show(300);
            setNewClient();
        } else {
            $("#divConsFinal").hide(300);
            $.ajax({
                type: "POST",
                url: "<?php echo base_url();?>staff/getClientJson/",
                data: {
                    type: type,
                    nit: nit,
                },
                dataType: "json",
                beforeSend: function() {
                    $(".msgClient").text("Buscando...");
                },
                success: function(data) {
                    if (data.results > 0) {
                        client = true;
                        $(".msgClient").text('');
                        $("#first_name").val(data.first_name);
                        $("#last_name").val(data.last_name);
                        $("#full_name").val(data.first_name + ' ' + data.last_name);
                        if (data.exist > 0) {
                            $("#client_id").val(data.client_id);
                            if (data.address != '') {

                                $("#address").val(data.address);
                            }
                            $("#phone").val(data.phone);
                            $("#type_client").val(data.type);
                        } else {
                            $("#client_id").val('N');
                            $("#address").val("Ciudad");
                            $("#phone").val('');
                            $("#type_client").val('C');
                        }
                    } else {
                        client = false;
                        $("#client_id").val('N');
                        $("#first_name").val('');
                        $("#last_name").val('');
                        $("#full_name").val('');
                        $("#address").val('');
                        $("#phone").val('');
                        $("#type_client").val('C');
                        $(".msgClient").text("No se ha encontrado el nit");
                    }

                    verifyData();
                },
                error: function(e) {
                    console.log("Error: ", e);
                    client = false;
                    $(".msgClient").text("Error al buscar los datos del cliente");
                    $("#dataClient").hide(500);
                    verifyData();
                }
            });
        }
    } else if (type == "CUI") {
        $("#divConsFinal").hide(300);
        var cui = $("#cui").val();
        var val = $.trim(cui.toUpperCase());
        if (cui == '') {
            $(".msgClient").text("Debe ingresar el cui del cliente");
            $("#dataClient").hide(500);
            client = false;
            verifyData();
        } else {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url();?>staff/getClientJson/",
                data: {
                    type: type,
                    cui: cui,
                },
                dataType: "json",
                beforeSend: function() {
                    $(".msgClient").text("Buscando...");
                },
                success: function(data) {
                    if (data.results > 0) {
                        $("#first_name").val(data.first_name);
                        $("#last_name").val(data.last_name);
                        $("#full_name").val(data.first_name + ' ' + data.last_name);
                        if (data.dead) {
                            client = false;
                            $(".msgClient").text("La persona consultada, falleció");
                        } else {
                            client = true;
                            $(".msgClient").text('');
                            if (data.exist > 0) {
                                $("#client_id").val(data.client_id);
                                if (data.address != '') {
                                    $("#address").val(data.address);
                                }
                                $("#phone").val(data.phone);
                                $("#type_client").val(data.type);
                            } else {
                                $("#client_id").val('N');
                                $("#address").val("Ciudad");
                                $("#phone").val('');
                                $("#type_client").val('C');
                            }
                        }
                    } else {
                        client = false;
                        $("#client_id").val('N');
                        $("#first_name").val('');
                        $("#last_name").val('');
                        $("#full_name").val('');
                        $("#address").val('');
                        $("#phone").val('');
                        $("#type_client").val('C');
                        $(".msgClient").text("No se ha encontrado el cui");
                    }
                    verifyData();
                },
                error: function(e) {
                    console.log("Error: ", e);
                    client = false;
                    $(".msgClient").text("Error al buscar los datos del cliente");
                    $("#dataClient").hide(500);
                    verifyData();
                }
            });
        }
    } else {
        client = false;
        $(".msgClient").text("Debe seleccionar un tipo de identificador del sistema");
        $("#dataClient").hide(500);
        verifyData();
    }
}

function verifyMethod() {
    var cash_id = $("#cash_id").val();
    var account_id = $("#bank_account_id").val();
    var val = $("#method").val();
    if (val == 1) {
        $("#divAccounts").hide(300);
        $("#divTypeTransfer").hide(300);
        $("#divDays").hide(300);
        $("#divCash").show(300);
        $("#divTelefono").hide(300);

        $("#cash_id").attr('required', true);
        $("#bank_account_id").attr('required', false);
        $("#days").attr('required', false);

        if (cash_id == '') cash = false;
        else cash = true;
        bank = true;
    } else if (val == 3 || val == 2 || val == 5 || val == 6) {
        $("#divAccounts").show(300);
        $("#divTypeTransfer").show(300);
        $("#divDays").hide(300);
        $("#divCash").hide(300);
        $("#divTelefono").hide(300);

        $("#cash_id").attr('required', false);
        $("#bank_account_id").attr('required', true);
        $("#days").attr('required', false);

        if (account_id == '') bank = false;
        else bank = true;
        cash = true;
    } else if (val == 4) {
        $("#divAccounts").hide(300);
        $("#divTypeTransfer").hide(300);
        $("#divDays").show(300);
        $("#divCash").hide(300);
        $("#divTelefono").show(300);
        bank = true;
        cash = true;

        $("#cash_id").attr('required', false);
        $("#bank_account_id").attr('required', false);
        $("#days").attr('required', true);

    } else {
        $("#divAccounts").hide(300);
        $("#divTypeTransfer").hide(300);
        $("#divDays").hide(300);
        $("#divCash").hide(300);
        $("#divTelefono").hide(300);
        bank = true;
        cash = true;


    }

    if (val != 4) $("#type_invoice_1").prop("checked", true);
    else $("#type_invoice_2").prop("checked", true);
    verifyCredit();
}


function getLaboratories() {
    $.ajax({
        url: '<?php echo base_url();?>staff/labStatus/' + <?php echo base64_decode($id_);?>,
        success: function(response) {
            if (response != "")
                jQuery('#labs').html(response);
        }
    });
}

function labStatus(exam) {
    $.ajax({
        url: '<?php echo base_url();?>staff/samples/pay_exam/' + exam,
        success: function(response) 
        {
            getLaboratories()
        },
        complete: function()
        {
               calculate_grand_total();
        }
    });
}

function rayStatus(exam) {
    $.ajax({
        url: '<?php echo base_url();?>staff/rayx/pay_exam/' + exam,
        success: function(response) 
        {
            getRayos()
        }
    });
}


function getRayos() {
    $.ajax({
        url: '<?php echo base_url();?>staff/rayx/get_service/' + <?php echo base64_decode($id_);?>,
        success: function(response) {
           
            if (response != "")
                jQuery('#rays').html(response);
        },
        complete: function()
        {
               calculate_grand_total();
        }
    });
}
</script>