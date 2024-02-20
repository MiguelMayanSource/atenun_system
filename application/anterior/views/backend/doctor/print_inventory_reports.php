<!doctype html>
<html>

    <head>
    </head>
    <style>
    @page {
        margin: 0;
    }

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
        position: absolute;
        top: 950px;
        width: 90%;

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

    <body style="margin:50px" onload="window.print()">
        <div id="printMe" class="_print-content_ztkcf7 ember-view">
            <div>
                <div class="_header_ztkcf7">
                    <div class="_header-logo_ztkcf7">
                        <img src="<?php echo base_url();?>public/uploads/<?php echo $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->logo;?>" alt="Medicaby" style="width:80%;">
                    </div>
                    <div class="_header-profile_ztkcf7">
                    </div>
                    <div class="_header-meta_ztkcf7">
                        <p>Generado por: <b>CMHM</b></p>
                        <p>Impreso por: <b> <?php echo $this->accounts_model->short_name($this->session->userdata('login_type') =='doctor' ? 'admin' :$this->session->userdata('login_type') ,$this->session->userdata('login_user_id'));?> </b>
                        </p>
                        <p> <b><?php   
                                    setlocale(LC_ALL,"es_ES");
                                    echo strftime("%d de %B de %Y")
                                
                                ?></b></p>
                    </div>
                </div>
                <div class="_body_ztkcf7">
                    <div class="_body-person-info_ztkcf7s">
                        <div class="ember-view">
                            <h2 style="padding:5px; text-align:center;">REPORTE INVINTARIOS DE <?php echo $type; ?></h2>
                            <table cellpadding="0" cellspacing="0" style="width: 100%; text-align: left; ">
                                <tr style="background: #eee;border:1px; padding:5px;font-size: 12px; width:auto;">
                                    <td style="border:1px;border-top: 2px solid #000; border-bottom:2px solid black;background: #eee;font-style:italic; font-weight:bold;padding:2px;width:auto;">#</td>
                                    <td style="border:1px; border-top: 2px solid #000;border-bottom:2px solid black;background: #eee;font-style:italic; font-weight:bold;padding:2px;width:auto;">Nombre</td>
                                    <td style="border:1px; border-top: 2px solid #000;border-bottom:2px solid black;background: #eee;font-style:italic; font-weight:bold;padding:2px;width:auto;">Código</td>
                                    <td style="border:1px; border-top: 2px solid #000;border-bottom:2px solid black;background: #eee;font-style:italic; font-weight:bold;padding:2px;width:auto;">Precio</td>
                                    <td style="border:1px; border-top: 2px solid #000;border-bottom:2px solid black;background: #eee;font-style:italic; font-weight:bold;padding:2px;width:auto;">Fecha Expriación</td>
                                    <td style="border:1px; border-top: 2px solid #000;border-bottom:2px solid black;background: #eee;font-style:italic; font-weight:bold;padding:2px;width:auto;">Existencias</td>
                                </tr> <?php
                                        $cont= 1 ;
                                        foreach ($result as $row):
                                            $expiration = explode("-",$this->crud_model->get_inventory_expired($row['product_id']));
                                       ?>
                                <tr>
                                    <td style="padding:5px;font-size: 12px; width:auto;">
                                        <b style="font-size: 12px;"><?php echo  $row['product_id']; ?></b>
                                    </td>
                                    <td style="padding:5px;font-size: 12px;width:auto; ">
                                        <b style="font-size: 12px;"><?php echo $row['name'];?></b>
                                    </td>
                                    <td style="padding:5px;font-size: 12px;width:auto; ">
                                        <b style="font-size: 12px;"><?php echo $row['code'];?></b>
                                    </td>
                                    <td style="padding:5px;font-size: 12px;width:auto;">
                                        <b style="font-size: 12px;"><?php echo 'Q. '.number_format($row['price'],'2','.',',');?></b>
                                    </td>
                                    <td style="padding:5px;font-size: 12px;width:auto;">
                                        <?php echo $expiration[2].'/'.$expiration[1].'/'.$expiration[0]?>
                                    </td>
                                    <td style="padding:5px;font-size: 12px;width:auto;">
                                        <?php echo  $this->crud_model->get_inventory($row['product_id'])  ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </table>
                        </div>
                    </div>
                    <div class="_footer_ztkcf7">
                        <div>
                            <div>Dirección:</div> <?php echo $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->address;?>
                        </div>
                        <div> Teléfono: <br> <?php echo $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->phone;?> </div>
                        <div class="_footer-app-branding_ztkcf7"> <?php $sys_name = $this->db->get_where('settings', array('type' => 'system_name'))->row()->description;?> <p>Recibo electrónico generado con <?php echo $sys_name;?> </p>
                            <b><?php echo base_url();?></b>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>

</html>
