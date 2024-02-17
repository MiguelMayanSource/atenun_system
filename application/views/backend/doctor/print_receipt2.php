<!doctype html>
<html>

<head>
</head>
<style>
body {
    font-size: 16px;
}

*,
::after,
::before {
    box-sizing: border-box;
}

p {
    margin-top: 0;
    margin-bottom: 1rem;
}

b {
    font-weight: bolder;
}

small {
    font-size: 80%;
}

img {
    vertical-align: middle;
    border-style: none;
}

small {
    font-size: 80%;
    font-weight: 400;
}

@media print {

    *,
    ::after,
    ::before {
        text-shadow: none !important;
        box-shadow: none !important;
    }

    img {
        page-break-inside: avoid;
    }

    p {
        orphans: 3;
        widows: 3;
    }
}

._print-content_ztkcf7 {
    width: 100%;
    color: #000;
    page-break-inside: avoid;
}

._print-content_ztkcf7 p {
    margin: 0;
}

._prescription-drug_6ovcpi {
    margin-bottom: 10px;
}

._medical-instructions-title_6ovcpi {
    font-weight: 700;
}

._header_ztkcf7 {
    display: flex;
    padding-bottom: 10px;
}

._header_ztkcf7 img {
    margin: 0;
    padding: 0;
}

._header-logo_ztkcf7,
._header-meta_ztkcf7 {
    width: 25%;
}

._header-logo_ztkcf7 {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: flex-start;
}

._header-logo_ztkcf7 img {
    max-height: 100px;
}

._header-meta_ztkcf7 {
    display: flex;
    flex-direction: column;
    justify-content: flex-end;
    align-items: flex-end;
    font-size: 12px;
}

._header-profile_ztkcf7 {
    display: flex;
    flex-direction: column;
    justify-content: flex-end;
    width: 50%;
    align-items: center;
}

._header-specialty_ztkcf7 {
    text-transform: uppercase;
    font-weight: 700;
}

._header-specialty_ztkcf7 {
    font-size: 16px;
}

._body_ztkcf7 {
    font-size: 13px;
}

._body-bg-image_ztkcf7 {
    display: none;
}

._body-person-info_ztkcf7 {
    display: flex;
    justify-content: space-between;
    margin-bottom: 10px;
    padding: 8px 0;
    border-top: 2px solid #000;
    border-bottom: 2px solid #000;
}

._body-person-info-date_ztkcf7 {
    display: none;
}

._body-prescription-info_ztkcf7 {
    min-height: 150px;
}

._body-signature_ztkcf7 {
    width: 33%;
    margin: 50px 0 30px auto;
    padding-top: 5px;
    border-top: 2px solid #000;
    text-align: center;
    font-size: 14px;
}

._footer_ztkcf7 {
    display: flex;
    justify-content: space-between;
    margin-top: 5px;
    padding: 10px 0;
    border-top: 2px solid #000;
    font-size: 10px;
}

._footer-app-branding_ztkcf7 {
    text-align: right;
}

._is-subtitle_1cmxxr img {
    position: absolute;
    top: 0;
    right: 0;
    left: 0;
    z-index: -1;
    width: 100%;
    height: 100%;
}

._is-subtitle_1cmxxr {
    position: relative;
    float: none;
    margin: 0 0 10px;
    padding: 3px 8px 3px 10px;
    font-size: 13px;
    font-weight: 700;
    font-style: italic;
    z-index: 0;
}
</style>
<?php 
        $info = $this->db->get_where('sale', array('sale_id' => $cart_id))->result_array();
        foreach($info as $inf):
    ?>
<?php $currency = $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->currency;?>

<body onload="window.print()">
    <div id="printMe" class="_print-content_ztkcf7 ember-view">
        <div>
            <div class="_header_ztkcf7">
                <div class="_header-logo_ztkcf7">
                    <img src="<?php echo base_url();?>public/uploads/<?php echo $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->logo;?>" alt="Medicaby" style="width:60%;">
                </div>
                <div class="_header-profile_ztkcf7">
                </div>
                <div class="_header-meta_ztkcf7">
                    <p><b>Recibo de compra</b></p>
                    <p>Generado por: <b>Medicaby</b></p>
                    <p>Impreso por: <b>
                            <?php if($this->session->userdata('login_type') == 'staff'): echo $this->accounts_model->short_name('staff',$this->session->userdata('login_user_id'));
                            elseif($this->session->userdata('login_type') == 'patient'): echo $this->accounts_model->short_name('patient',$this->session->userdata('login_user_id'));
                            else: echo $this->accounts_model->short_name('admin',$this->session->userdata('login_user_id')); endif;?></b></p>
                    <p>Fecha: <b><?php echo date('d/m/Y H:i a');?></b></p>
                    <p>Correlativo: <b><?php echo $sale_id;?></b></p>
                </div>
            </div>
            <div class="_body_ztkcf7">
                <div class="_body-person-info_ztkcf7">
                    <div class="_body-person-name_ztkcf7">
                        <b>Paciente: </b><span><?php echo $this->accounts_model->short_name('patient',$inf['patient_id']);?></span><br>
                        <b>Dirección: </b><span><?php echo $this->db->get_where('patient', array('patient_id' => $inf['patient_id']))->row()->address;?></span>
                    </div>
                    <div></div>
                    <div>
                        <b>Teléfono: </b><?php echo $this->db->get_where('patient', array('patient_id' => $inf['patient_id']))->row()->phone;?><br>
                        <b>Fecha de compra: </b><?php echo $inf['date'];?>
                    </div>
                </div>
                <div>

                </div>


                <div class="_body-prescription-info_ztkcf7">
                    <div class="ember-view">

                        <?php $detalles = unserialize($inf['products']);  
                    
                    if(count($detalles)>0):
                    ?>
                        <h2>Medicamentos</h2>
                        <table cellpadding="0" cellspacing="0" style="width: 100%; text-align: left; ">
                            <tr style="border:1px; padding:5px;font-size: 12px; border-top:1px solid black">
                                <td style="background: #eee;font-style:italic; font-weight:bold;padding:2px;width:60%;">
                                    Producto
                                </td>
                                <td style="background: #eee;font-style:italic; font-weight:bold;padding:2px;">
                                    Precio
                                </td>
                                <td style="background: #eee;font-style:italic; font-weight:bold;padding:2px;">
                                    Cantidad
                                </td>
                                <td style="background: #eee;font-style:italic; font-weight:bold;padding:2px;">
                                    Descuento
                                </td>
                                <td style="background: #eee;font-style:italic; font-weight:bold;padding:2px;">
                                    Subtotal
                                </td>
                            </tr>
                            <?php  
                $detalles = unserialize($inf['products']);  
                foreach($detalles as $prod): 
            ?>
                            <tr>
                                <td style="padding:5px;font-size: 12px; ">
                                    <b style="font-size: 12px;"><?php  $products = $this->db->get_where('product', array('product_id'=>$prod['product_id']))->result_array();
                                            foreach ($products as $product): ?>
                                        <?php echo $product['code'].' - '.$product['name']?>
                                        <?php endforeach;  ?></b>
                                </td>
                                <td style="padding:5px;font-size: 12px;">
                                    <b style="font-size: 12px;"><?php echo $currency.'. '.number_format($prod['subtotal'],'2','.',',');?></b>
                                </td>
                                <td style="padding:5px;font-size: 12px;">
                                    <b style="font-size: 12px;"> <?php echo $prod['amount'].' '.$this->crud_model->pluralizar($prod['amount'],$this->db->get_where('unity',array('code'=>$prod['unity']))->row()->name); ?></b>
                                </td>
                                <td style="padding:5px;font-size: 12px;">
                                    <b style="font-size: 12px;"><?php echo $currency.'. '.number_format($prod['discount'],'2','.',',');?></b>
                                </td>
                                <td style="padding:5px;font-size: 12px;">
                                    <b style="font-size: 12px;"><?php echo $currency.'. '.number_format($prod['total'],'2','.',',');?></b><br><br>
                                </td>
                            </tr>
                            <?php endforeach;?>

                        </table>
                        <?php endif?>

                        <table cellpadding="0" cellspacing="0" style="width: 100%; text-align: left; margin-top:50px;">
                            <tbody>
                                <tr>
                                    <td colspan="4" style="padding:10px;font-size: 17px;text-align:right;border:1px; border-top:1px solid black">
                                        <b>TOTAL: </b>
                                        <?php echo $currency.'. '.number_format($inf['total'],'2','.',',');?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="_footer_ztkcf7">
                <div>
                    <div>Dirección:</div>
                    <?php echo $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->address;?>
                </div>
                <div>
                    Teléfono: <br>
                    <?php echo $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->phone;?>
                </div>
                <div class="_footer-app-branding_ztkcf7"><?php $sys_name = $this->db->get_where('settings', array('type' => 'system_name'))->row()->description;?>
                    <p>Recibo electrónico generado con <?php echo $sys_name;?></p>
                    <b><?php echo base_url();?></b>
                </div>
            </div>
        </div>
    </div>
</body>
<?php endforeach;?>
</body>

</html>