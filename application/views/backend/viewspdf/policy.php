<!doctype html>
<?php 
    ini_set("memory_limit","500M");
    setlocale(LC_TIME,"es_ES");
    $pol = $this->crud_model->getPolicy($policy_id);
    log_message("error", "Póliza: ".json_encode($pol));
    $dep = $this->crud_model->getDepartureByID($pol['departure_id']);
    $detalles = $this->crud_model->getDetailsDeparture($pol['departure_id']);
    $transfer = false;
?>
<html>
    <head> <meta charset="gb18030"> </head>
    <body style="margin: 0px; font-size: 12px; font-family: 'Poppins'; font-weight: bold;">
        <main>
            <div style="width: 100%;">
                <p style="margin-left: 5px; border-bottom: 1px solid black;">
                    <b><?php echo $this->crud_model->getInfo('system_name');?></b><br>
                    <?php echo $this->crud_model->getInfo('description');?><br>
                    <?php echo $this->crud_model->getInfo('address');?><br>
                    Tel. <?php echo $this->crud_model->getInfo('phone');?>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <span style="float:right; text-align:right;">No. De Póliza contable <b><?php echo $pol['no_policy'];?></b></span>
                </p>
            </div>
            <div style="width: 100%;">
                <p style="margin-left: 5px;">
                    Fecha: <?php echo date("d/m/Y", strtotime($dep['date']));?><br>
                    Tipo de póliza: <?php echo $pol['type'];?><br>
                    Concepto: <?php echo $dep['details'];?>
                </p>
            </div>
            <?php if($pol['bank'] == 1):?>
                    <?php if($pol['reference_bank'] == 'bank_check'):
                    $check = $this->crud_model->getBankCheck($pol['reference_id']);
                    $acc = $this->crud_model->getInfoAccount($check['bank_account_id']);
                    log_message("error", "Banco: ".$acc['bank']);?>
                    <?php if($acc['bank'] == "BAM"):?>
            <div style="background-image: url('<?php echo base_url();?>public/uploads/checks/check_bam.png'); width: 100%; height: 280px; background-position: center; background-repeat: no-repeat; background-size: cover; margin-bottom: 10px; border: 1px solid;">
                <div style="padding-top: 15px; padding-left: 180px; display: table; clear: both;">
                    <div style="width: 525px; height: auto; font-size: 13px;"><b><?php echo $acc['code'];?></b></div>
                </div>
                <div style="padding-left: 540px; display: table; clear: both; margin-top: -8px;">
                    <div style="width: 525px; height: auto; text-align:center; font-size: 15px;"><b><?php echo $check['no_check'];?></b></div>
                </div>
                <div style="padding-top: 35px; padding-left: 125px; display: table; clear: both;">
                    <div style="width: 400px; height: auto; text-align:center; font-size: 12px;"><?php echo $check['place'].', '.date("d/m/Y", strtotime($check['date']));?></div>
                    <div style="width: 115px; height: auto; text-align:center; font-size: 12px; margin-top: -18px; margin-left: 430px;">**<?php echo number_format($check['amount'],2,".",",");?>**</div>
                </div>
                <div style="padding-top: 18px; padding-left: 80px; display: table; clear: both;">
                    <div style="width: 525px; height: auto; text-align:center; font-size: 12px;"><?php echo $check['pay_to'];?></div>
                </div>
                <div style="padding-top: 17px; padding-left: 50px; display: table; clear: both;">
                    <div style="width: 490px; height: auto; text-align:center; font-size: 12px;"><?php echo $check['amount_letter'];?></div>
                </div>
                <div style="padding-top: 35px; padding-left: 150px; display: table; clear: both;">
                    <div style="width: 100px; height: auto; text-align:center; font-size: 12px;">NO NEGOCIABLE</div>
                </div>
            </div>
                    <?php elseif($acc['bank'] == "BAC"):?>
            <div style="background-image: url('<?php echo base_url();?>public/uploads/checks/check_bac.jpg'); width: 100%; height:300px; background-position: center; background-repeat: no-repeat; background-size: cover; margin-bottom: 10px;">
                <div style="padding-top: 50px; padding-left: 500px; display: table; clear: both;">
                    <div style="width: 525px; height: auto; text-align:center; font-size: 13px;"><b><?php echo $check['no_check'];?></b></div>
                </div>
                <div style="padding-top: 25px; padding-left: 120px; display: table; clear: both;">
                    <div style="width: 370px; height: auto; text-align:center; font-size: 12px;"><?php echo $check['place'].', '.date("d/m/Y", strtotime($check['date']));?></div>
                    <div style="width: 140px; height: auto; text-align:center; font-size: 12px; margin-top: -18px; margin-left: 400px;">**<?php echo number_format($check['amount'],2,".",",");?>**</div>
                </div>
                <div style="padding-top: 12px; padding-left: 105px; display: table; clear: both;">
                    <div style="width: 510px; height: auto; text-align:center; font-size: 12px;"><?php echo $check['pay_to'];?></div>
                </div>
                <div style="padding-top: 10px; padding-left: 75px; display: table; clear: both;">
                    <div style="width: 495px; height: auto; text-align:center; font-size: 12px;"><?php echo $check['amount_letter'];?></div>
                </div>
            </div>
                    <?php elseif($acc['bank'] == "Banrural"):?>
            <div style="background-image: url('<?php echo base_url();?>public/uploads/checks/check_banrural.jpg'); width: 100%; height: 300px; background-position: center; background-repeat: no-repeat; background-size: cover; margin-bottom: 10px; border: 1px solid;">
                <div style="padding-top: 8px; padding-left: 475px; display: table; clear: both;">
                    <div style="width: 525px; height: auto; text-align:center; font-size: 15px;"><b><?php echo $check['no_check'];?></b></div>
                </div>
                <div style="padding-top: 73px; padding-left: 75px; display: table; clear: both;">
                    <div style="width: 400px; height: auto; text-align:center; font-size: 12px;"><?php echo $check['place'].', '.date("d/m/Y", strtotime($check['date']));?></div>
                    <div style="width: 115px; height: auto; text-align:center; font-size: 12px; margin-top: -18px; margin-left: 500px;">**<?php echo number_format($check['amount'],2,".",",");?>**</div>
                </div>
                <div style="padding-top: 13px; padding-left: 90px; display: table; clear: both;">
                    <div style="width: 525px; height: auto; text-align:center; font-size: 12px;"><?php echo $check['pay_to'];?></div>
                </div>
                <div style="padding-top: 10px; padding-left: 50px; display: table; clear: both;">
                    <div style="width: 525px; height: auto; text-align:center; font-size: 12px;"><?php echo $check['amount_letter'];?></div>
                </div>
            </div>
                <?php endif;?>
            <?php else: $transfer = true; endif; endif;?>
            <div style="width: 100%; margin-bottom: 10px;">
                <p style="">ASIENTO CONTABLE</p>
            </div>
            <div style="">
                <table style="margin-bottom: 1.5rem !important; font-size: 12px; font-family: 'Poppins'; width: 100%;">
                    <thead style="">
                        <tr style="border-top: 1px solid black; border-collapse: collapse; border-bottom: 1px solid black; border-collapse: collapse;">
                            <th style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px; width: 10%; text-align:left;">
                                No.
                            </th>
                            <th style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px; width: 15%; text-align:left;">
                                Rubro
                            </th>
                            <th style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px; width: 35%; text-align:left;">
                                Cuenta contable
                            </th>
                            <th style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px; width: 20%;">
                                Debe
                            </th>
                            <th style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px; width: 20%;">
                                Haber
                            </th>
                        </tr>
                    </thead>
                    <tbody style="">
                        <?php foreach ($detalles->result_array() as $dt):
                            $nom_id = $dt['nomenclature_id']; 
                            $nom = $this->crud_model->nomenByID($nom_id);?>
                        <tr>
                            <td style="">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php echo $dt['number'];?>
                                </span>
                            </td>
                            <td style="">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php echo $nom['code'];?>
                                </span>
                            </td>
                            <td style="">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php echo $nom['name'];?>
                                </span>
                            </td>
                            <td style="text-align:right;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php if($dt['debit'] != '') echo "Q.".number_format($dt['debit'],2,".",",");?>
                                </span>
                            </td>
                            <td style="text-align:right;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php if($dt['credit'] != '') echo "Q.".number_format($dt['credit'],2,".",",");?>
                                </span>
                            </td>
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th style=""></th>
                            <th style=""></th>
                            <th style="text-align:left;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    Sumas iguales
                                </span>
                            </th>
                            <th style="text-align:right; border-bottom:1px solid black; border-collapse:collapse;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px; ">
                                    Q.<?php echo number_format($dep['total'],2,".",",");?>
                                </span>
                            </th>
                            <th style="text-align:right; border-bottom:1px solid black; border-collapse:collapse;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    Q.<?php echo number_format($dep['total'],2,".",",");?>
                                </span>
                            </th>
                        </tr>
                        <tr>
                            <th colspan="3" style="text-align: left;">
                                Razón: <?php echo $dep['details']; if($transfer) echo ", transferencia bancaria";?>
                            </th>
                            <th style=""></th>
                            <th style=""></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <br><br>
            <div style="width: 100%;">
                <table style="margin-bottom: 1.5rem !important; font-size: 12px; font-family: 'Poppins'; border: 1px solid black; border-collapse: collapse;width: 100%;">
                    <thead style="border-top: 1px solid #e0e6ed; border-bottom: 1px solid #e0e6ed;">
                        <tr style="">
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px; text-align: center; width: 30%;">
                                Aprueba
                            </th>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px; text-align: center; width: 30%;">
                                Realiza
                            </th>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px; text-align: center; width: 40%;">
                                Receptor
                            </th>
                        </tr>
                    </thead>
                    <tbody style="border-top: 1px solid #e0e6ed; border-bottom: 1px solid #e0e6ed;">
                        <tr style="height: 225px;">
                            <td style="border: 1px solid black; border-collapse: collapse;height: 50px;">f.</td>
                            <td style="border: 1px solid black; border-collapse: collapse;">f.</td>
                            <td style="border: 1px solid black; border-collapse: collapse;">f.</td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid black; border-collapse: collapse; text-align: center;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php echo $pol['approve_name'];?>
                                </span>
                            </td>
                            <td style="border: 1px solid black; border-collapse: collapse; text-align: center;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php echo $pol['maker_name'];?>
                                </span>
                            </td>
                            <td style="border: 1px solid black; border-collapse: collapse; text-align: left; height: 25px;">Nombre</td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid black; border-collapse: collapse; text-align: center;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php echo $pol['approve_charge'];?>
                                </span>
                            </td>
                            <td style="border: 1px solid black; border-collapse: collapse; text-align: center;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php echo $pol['maker_charge'];?>
                                </span>
                            </td>
                            <td style="border: 1px solid black; border-collapse: collapse; text-align: left; height: 25px;">DPI</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </main>
    </body>
</html>