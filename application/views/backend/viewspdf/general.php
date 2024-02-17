<!doctype html>
<?php 
    ini_set("memory_limit","500M");
    setlocale(LC_TIME,"es_ES");
    $hoy = date("Y-m-d");
    $tipos = $this->crud_model->getHeadsTypesGeneral();
    $val = $this->crud_model->getUtilityGeneral($initial, $final);
    $cashes = $this->crud_model->getCashNomen();
    $cash = 0;
    $pettyCash = $this->crud_model->getPettyCash();
    $cash_petty = 0;
    $activo = 0; $act_corriente = 0; $act_no_corriente = 0;
    $pasivo = 0; $pas_corriente = 0; $pas_no_corriente = 0;
    $patrimonio = 0; $capital = 0; $utilidad = 0;
    $reserva = $val['legal']; $bruta = $val['gross']; $neta = $val['net'];
    $bancos = 0; $cuentas_cobrar = 0; $deprec = 0;
?>
<html>
    <head> <meta charset="gb18030"> </head>
    <body style="margin:0px; font-size: 15px; font-family:'Poppins'; font-weight:bold;">
        <main>
            <div style="width:100%;">
                <p style="text-align:center; align-content:center; margin-left:5px; font-size:12px; font-family:'Poppins';">
                    BALANCE GENERAL<br>
                    <?php echo $this->crud_model->getInfo('description');?><br>
                    <?php echo $this->crud_model->getInfo('system_name');?><br>
                    DEL <?php echo strtoupper(strftime("%d DEL %B", strtotime($initial)).' AL '.strftime("%d DE %B DEL %Y", strtotime($final)));?>
                </p>
            </div>
            <div style="">
                <table style="margin-bottom:0 !important; font-size:10px; font-family:'Poppins'; width:100%;">
                    <thead style="">
                        <tr style="background-color: #eff2f7;">
                            <th style=" margin-right:5px; margin-left:5px; margin-top:5px; margin-bottom:5px;">Rubro</th>
                            <th style=" margin-right:5px; margin-left:5px; margin-top:5px; margin-bottom:5px;"></th>
                            <th style=" margin-right:5px; margin-left:5px; margin-top:5px; margin-bottom:5px;"></th>
                            <th style=" margin-right:5px; margin-left:5px; margin-top:5px; margin-bottom:5px;"></th>
                            <th style=" margin-right:5px; margin-left:5px; margin-top:5px; margin-bottom:5px;"></th>
                        </tr>
                    </thead>
                    <tbody style="">
                        <?php $type = $this->crud_model->getHeadTypeByCode("1");?>
                        <tr>
                            <td style="">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php echo $type['code'];?>
                                </span>
                            </td>
                            <td style="text-align:center; align-content:center;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php echo $type['name'];?>
                                </span>
                            </td>
                            <td style=""></td>
                            <td style=""></td>
                            <td style=""></td>
                        </tr>
                        <?php $head = $this->crud_model->getHeadByCode("1.01");?>
                        <tr>
                            <td style="">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php echo $head['code'];?>
                                </span>
                            </td>
                            <td style="">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php echo strtoupper($head['name']);?>
                                </span>
                            </td>
                            <td style=""></td>
                            <td style=""></td>
                            <td style=""></td>
                        </tr>
                        <?php $nCash = 1; foreach ($cashes->result_array() as $ch):
                            $total = $this->crud_model->getTotalYearNom($ch['nomenclature_id'], $initial, $final, 1);
                            $activo += $total; $act_corriente += $total; $cash += $total;?>
                        <tr>
                            <td style="">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php echo $ch['code'];?>
                                </span>
                            </td>
                            <td style="">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php echo $ch['name'];?>
                                </span>
                            </td>
                            <td style="text-align: right;">
                                <?php if($cashes->num_rows() > 1):?>
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php if($total < 0) echo '-'; echo "Q.".number_format(abs($total),2,".",",");?>
                                </span>
                                <?php endif;?>
                            </td>
                            <td style="text-align: right;">
                                <?php if($cashes->num_rows() == 1):?>
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php if($total < 0) echo '-'; echo "Q.".number_format(abs($total),2,".",",");?>
                                </span>
                                <?php endif; if($cashes->num_rows() > 1 && $cashes->num_rows() == $nCash):?>
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php if($cash < 0) echo '-'; echo "Q.".number_format(abs($cash),2,".",",");?>
                                </span>
                                <?php endif;?>
                            </td>
                            <td style=""></td>
                        </tr>
                        <?php $nCash++; endforeach;?>
                        <?php $nPetCash = 1; foreach ($pettyCash->result_array() as $ch):
                            $total = $this->crud_model->getTotalYearNom($ch['nomenclature_id'], $initial, $final, 1);
                            $activo += $total; $act_corriente += $total; $petty_cash += $total;?>
                        <tr>
                            <td style="">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php echo $ch['code'];?>
                                </span>
                            </td>
                            <td style="">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php echo $ch['name'];?>
                                </span>
                            </td>
                            <td style="text-align: right;">
                                <?php if($pettyCash->num_rows() > 1):?>
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php if($total < 0) echo '-'; echo "Q.".number_format(abs($total),2,".",",");?>
                                </span>
                                <?php endif;?>
                            </td>
                            <td style="text-align: right;">
                                <?php if($pettyCash->num_rows() == 1):?>
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php if($total < 0) echo '-'; echo "Q.".number_format(abs($total),2,".",",");?>
                                </span>
                                <?php endif; if($pettyCash->num_rows() > 1 && $pettyCash->num_rows() == $nPetCash):?>
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php if($petty_cash < 0) echo '-'; echo "Q.".number_format(abs($petty_cash),2,".",",");?>
                                </span>
                                <?php endif;?>
                            </td>
                            <td style=""></td>
                        </tr>
                        <?php $nPetCash++; endforeach;?>
                        <?php for ($i=1; $i <= 6; $i++):?>
                        <?php $nom = $this->crud_model->getNomenByCode("1.01.02.00$i");
                            $total = $this->crud_model->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 1);
                            $activo += $total; $act_corriente += $total; $bancos += $total;?>
                        <tr>
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
                            <td style="text-align: right;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php if($total < 0) echo '-'; echo "Q.".number_format(abs($total),2,".",",");?>
                                </span>
                            </td>
                            <td style=""></td>
                            <td style=""></td>
                        </tr>
                        <?php endfor;?>
                        <?php $group = $this->crud_model->getGroupByCode("1.01.02");?>
                        <tr>
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
                            <td style=""></td>
                            <td style="text-align: right;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php if($bancos < 0) echo '-'; echo "Q.".number_format(abs($bancos),2,".",",");?>
                                </span>
                            </td>
                            <td style=""></td>
                        </tr>
                        <?php $group = $this->crud_model->getGroupByCode("1.01.03");?>
                        <tr>
                            <td style="">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php echo $group['code'];?>
                                </span>
                            </td>
                            <td style="">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php echo strtoupper($group['name']);?>
                                </span>
                            </td>
                            <td style=""></td>
                            <td style=""></td>
                            <td style=""></td>
                        </tr>
                        <?php $nom = $this->crud_model->getNomenByCode("1.01.03.001");
                            $total = 0;
                            if (strtotime($final) < strtotime($hoy)) $total = $this->crud_model->getTotalInventoryStatement($final);
                            else $total = $this->crud_model->getTotalInventoryStatement();
                            $activo += $total; $act_corriente += $total;?>
                        <tr>
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
                            <td style=""></td>
                            <td style="text-align: right;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php if($total < 0) echo '-'; echo "Q.".number_format(abs($total),2,".",",");?>
                                </span>
                            </td>
                            <td style=""></td>
                        </tr>
                        <?php $group = $this->crud_model->getGroupByCode("1.01.04");?>
                        <tr>
                            <td style="">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php echo $group['code'];?>
                                </span>
                            </td>
                            <td style="">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php echo strtoupper($group['name']);?>
                                </span>
                            </td>
                            <td style=""></td>
                            <td style=""></td>
                            <td style=""></td>
                        </tr>
                        <?php $nom = $this->crud_model->getNomenByCode("1.01.04.001");
                            $total = $this->crud_model->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 1);
                            $activo += $total; $act_corriente += $total; $cuentas_cobrar += $total; ?>
                        <tr>
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
                            <td style="text-align: right;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php if($total < 0) echo '-'; echo "Q.".number_format(abs($total),2,".",",");?>
                                </span>
                            </td>
                            <td style=""></td>
                            <td style=""></td>
                        </tr>
                        <?php $nom = $this->crud_model->getNomenByCode("1.01.04.002");
                            $total = $total * 0.03; $activo -= $total; $act_corriente -= $total; $cuentas_cobrar -= $total;?>
                        <tr>
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
                            <td style="border-bottom:1px solid black; border-collapse:collapse; text-align: right;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php if($total < 0) echo '-'; echo "Q.".number_format(abs($total),2,".",",");?>
                                </span>
                            </td>
                            <td style="text-align: right;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px; text-align: right;">
                                    <?php if($cuentas_cobrar < 0) echo '-'; echo "Q.".number_format(abs($cuentas_cobrar),2,".",",");?>
                                </span>
                            </td>
                            <td style=""></td>
                        </tr>
                        <?php $nom = $this->crud_model->getNomenByCode("1.01.05.001");
                            $total = $this->crud_model->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 1);
                            $activo += $total; $act_corriente += $total;?>
                        <tr>
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
                            <td style=""></td>
                            <td style="border-bottom:1px solid black; border-collapse:collapse; text-align: right;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php if($total < 0) echo '-'; echo "Q.".number_format(abs($total),2,".",",");?>
                                </span>
                            </td>
                            <td style=""></td>
                        </tr>
                        <tr>
                            <td style=""></td>
                            <td style=""></td>
                            <td style=""></td>
                            <td style=""></td>
                            <td style="">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px; text-align: right;">
                                    <?php if($act_corriente < 0) echo '-'; echo "Q.".number_format(abs($act_corriente),2,".",",");?>
                                </span>
                            </td>
                        </tr>
                        <?php $head = $this->crud_model->getHeadByCode("1.02");?>
                        <tr>
                            <td style="">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php echo $head['code'];?>
                                </span>
                            </td>
                            <td style="">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php echo strtoupper($head['name']);?>
                                </span>
                            </td>
                            <td style=""></td>
                            <td style=""></td>
                            <td style=""></td>
                        </tr>
                        <?php for ($i=1; $i <= 9; $i++):?>
                        <?php $nom = $this->crud_model->getNomenByCode("1.02.01.00$i");
                            $total = $this->crud_model->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 1);
                            $activo += $total; $act_no_corriente += $total; $depreciacion += $total;?>
                        <tr>
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
                            <td style="text-align: right;<?php if(($i % 2) == 0) echo " border-bottom:1px solid black; border-collapse:collapse;";?>">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php echo "Q.".number_format(abs($total),2,".",",");?>
                                </span>
                            </td>
                            <td style="text-align: right;">
                                <?php if(($i % 2) == 0):?>
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php if($depreciacion < 0) echo '-'; echo "Q.".number_format(abs($depreciacion),2,".",",");?>
                                </span>
                                <?php endif;?>
                            </td>
                            <td style=""></td>
                        </tr>
                        <?php if(($i % 2) == 0) $depreciacion = 0; endfor;?>
                        <tr>
                            <td style=""></td>
                            <td style=""></td>
                            <td style="border-bottom:1px solid black; border-collapse:collapse;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;"></span>
                            </td>
                            <td style="border-bottom:1px solid black; border-collapse:collapse; text-align: right;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php if($total < 0) echo '-'; echo "Q.".number_format(abs($total),2,".",",");?>
                                </span>
                            </td>
                            <td style=""></td>
                        </tr>
                        <tr>
                            <td style=""></td>
                            <td style=""></td>
                            <td style=""></td>
                            <td style="border-bottom:1px solid black; border-collapse:collapse;"></td>
                            <td style="border-bottom:1px solid black; border-collapse:collapse; text-align: right;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php if($act_no_corriente < 0) echo '-'; echo "Q.".number_format(abs($act_no_corriente),2,".",",");?>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td style=""></td>
                            <td style="">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">TOTAL DEL ACTIVO</span>
                            </td>
                            <td style=""></td>
                            <td style="border-bottom:1px solid black; border-collapse:collapse;"></td>
                            <td style="border-bottom:1px solid black; border-collapse:collapse; text-align: right;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php if($activo < 0) echo '-'; echo "Q.".number_format(abs($activo),2,".",",");?>
                                </span>
                            </td>
                        </tr>
                        <?php $type = $this->crud_model->getHeadTypeByCode("2");?>
                        <tr>
                            <td style="">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php echo $type['code'];?>
                                </span>
                            </td>
                            <td style="text-align:center; align-content:center;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php echo strtoupper($type['name']);?>
                                </span>
                            </td>
                            <td style=""></td>
                            <td style="border-top:1px solid black; border-collapse:collapse;"></td>
                            <td style="border-top:1px solid black; border-collapse:collapse;"></td>
                        </tr>
                        <?php $head = $this->crud_model->getHeadByCode("2.01");?>
                        <tr>
                            <td style="">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php echo $head['code'];?>
                                </span>
                            </td>
                            <td style="">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php echo strtoupper($head['name']);?>
                                </span>
                            </td>
                            <td style=""></td>
                            <td style=""></td>
                            <td style=""></td>
                        </tr>
                        <?php for ($i=1; $i <= 5; $i++):?>
                        <?php $nom = $this->crud_model->getNomenByCode("2.01.01.00$i");
                            $total = $this->crud_model->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 2);
                            $pasivo += $total; $pas_corriente += $total;?>
                        <tr>
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
                            <td style=""></td>
                            <td style="text-align: right;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php if($total < 0) echo '-'; echo "Q.".number_format(abs($total),2,".",",");?>
                                </span>
                            </td>
                            <td style=""></td>
                        </tr>
                        <?php endfor;?>
                        <tr>
                            <td style=""></td>
                            <td style=""></td>
                            <td style=""></td>
                            <td style=""></td>
                            <td style="text-align: right;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php if($pas_corriente < 0) echo '-'; echo "Q.".number_format(abs($pas_corriente),2,".",",");?>
                                </span>
                            </td>
                        </tr>
                        <?php $head = $this->crud_model->getHeadByCode("2.02");?>
                        <tr>
                            <td style="">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php echo $head['code'];?>
                                </span>
                            </td>
                            <td style="">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php echo strtoupper($head['name']);?>
                                </span>
                            </td>
                            <td style=""></td>
                            <td style=""></td>
                            <td style=""></td>
                        </tr>
                        <?php $nom = $this->crud_model->getNomenByCode("2.02.01.001");
                            $total = $this->crud_model->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 2);
                            $pasivo += $total; $pas_no_corriente += $total;?>
                        <tr>
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
                            <td style=""></td>
                            <td style="text-align: right;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php if($total < 0) echo '-'; echo "Q.".number_format(abs($total),2,".",",");?>
                                </span>
                            </td>
                            <td style=""></td>
                        </tr>
                        <tr>
                            <td style=""></td>
                            <td style=""></td>
                            <td style=""></td>
                            <td style=""></td>
                            <td style="text-align: right;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php if($pas_no_corriente < 0) echo '-'; echo "Q.".number_format(abs($pas_no_corriente),2,".",",");?>
                                </span>
                            </td>
                        </tr>
                        <?php $head = $this->crud_model->getHeadByCode("3.01");?>
                        <tr>
                            <td style="">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php echo $head['code'];?>
                                </span>
                            </td>
                            <td style="">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php echo strtoupper($head['name']);?>
                                </span>
                            </td>
                            <td style=""></td>
                            <td style=""></td>
                            <td style=""></td>
                        </tr>
                        <?php $group = $this->crud_model->getGroupByCode("3.01.01");?>
                        <tr>
                            <td style="">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php echo $group['code'];?>
                                </span>
                            </td>
                            <td style="">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php echo strtoupper($group['name']);?>
                                </span>
                            </td>
                            <td style=""></td>
                            <td style=""></td>
                            <td style=""></td>
                        </tr>
                        <?php $nom = $this->crud_model->getNomenByCode("3.01.01.001");
                            $total = $this->crud_model->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 3);
                            $patrimonio += $total; $capital += $total;?>
                        <tr>
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
                            <td style="text-align: right;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php if($total < 0) echo '-'; echo "Q.".number_format(abs($total),2,".",",");?>
                                </span>
                            </td>
                            <td style=""></td>
                            <td style=""></td>
                        </tr>
                        <?php $nom = $this->crud_model->getNomenByCode("3.01.01.002");
                            $total = $this->crud_model->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 1);
                            $patrimonio -= $total; $capital -= $total;?>
                        <tr>
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
                            <td style="text-align: right;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php if($total < 0) echo '-'; echo "Q.".number_format(abs($total),2,".",",");?>
                                </span>
                            </td>
                            <td style="text-align: right;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php if($capital < 0) echo '-'; echo "Q.".number_format(abs($capital),2,".",",");?>
                                </span>
                            </td>
                            <td style=""></td>
                        </tr>
                        <?php $group = $this->crud_model->getGroupByCodeName("3.02.01", "reserva");?>
                        <tr>
                            <td style="">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php echo $group['code'];?>
                                </span>
                            </td>
                            <td style="">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php echo strtoupper($group['name']);?>
                                </span>
                            </td>
                            <td style=""></td>
                            <td style=""></td>
                            <td style=""></td>
                        </tr>
                        <?php $nom = $this->crud_model->getNomenByCodeName("3.02.01.001", "reserva");
                            $patrimonio += $reserva;?>
                        <tr>
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
                            <td style=""></td>
                            <td style="text-align: right;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php if($reserva < 0) echo '-'; echo "Q.".number_format(abs($reserva),2,".",",");?>
                                </span>
                            </td>
                            <td style=""></td>
                        </tr>
                        <?php $nom = $this->crud_model->getNomenByCode("3.02.01.003");
                            $total = $activo - $pasivo - $capital - $reserva - $neta;
                            $patrimonio += $total;?>
                        <tr>
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
                            <td style="text-align: right;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php if($total < 0) echo '-'; echo "Q.".number_format(abs($total),2,".",",");?>
                                </span>
                            </td>
                            <td style=""></td>
                            <td style=""></td>
                            <td style=""></td>
                        </tr>
                        <?php $nom = $this->crud_model->getNomenByCode("3.02.01.002");
                            $patrimonio += $neta; $utilidad += $total + $neta;?>
                        <tr>
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
                            <td style="text-align: right;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php if($neta < 0) echo '-'; echo "Q.".number_format(abs($neta),2,".",",");?>
                                </span>
                            </td>
                            <td style="text-align: right;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php if($utilidad < 0) echo '-'; echo "Q.".number_format(abs($utilidad),2,".",",");?>
                                </span>
                            </td>
                            <td style=""></td>
                        </tr>
                        <tr>
                            <td style=""></td>
                            <td style=""></td>
                            <td style=""></td>
                            <td style="border-bottom:1px solid black; border-collapse:collapse;"></td>
                            <td style="border-bottom:1px solid black; border-collapse:collapse; text-align: right;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php if($patrimonio < 0) echo '-'; echo "Q.".number_format(abs($patrimonio),2,".",",");?>
                                </span>
                            </td>
                        </tr>
                        <?php $patrimonio += $pasivo;?>
                        <tr>
                            <td style="">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">3.02.02.003</span>
                            </td>
                            <td style="">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">TOTAL DE PASIVO Y CAPITAL</span>
                            </td>
                            <td style=""></td>
                            <td style="border-bottom:1px solid black; border-collapse:collapse;"></td>
                            <td style="border-bottom:1px solid black; border-collapse:collapse; text-align: right;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php if($patrimonio < 0) echo '-'; echo "Q.".number_format(abs($patrimonio),2,".",",");?>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td style=""></td>
                            <td style=""></td>
                            <td style=""></td>
                            <td style="border-top:1px solid black; border-collapse:collapse;"></td>
                            <td style="border-top:1px solid black; border-collapse:collapse;"></td>
                        </tr>
                    </tbody>
                    <tfoot></tfoot>
                </table>
            </div>
            <div style="width: 100%;">
                <p style="text-align:center; align-content:center; margin-left:5px; font-size:9px; font-family:'Poppins'; margin-bottom:0px;"><?php echo $description;?></p>
                <p style="text-align:center; align-content:center; margin-left:5px; font-size:9px; font-family:'Poppins'; margin-top:0px;"><?php echo $this->crud_model->getInfo("address").' '.strftime("%d de %B del %Y");?></p>
            </div>
            <br><br>
            <div style="width: 100%; display: table; clear: both;">
                <div style="width: 50%; float: left;">
                    <p style="text-align:center; align-content:center; margin-left:5px; font-size:9px; font-family:'Poppins';">
                        ______________________________________<br>
                        <?php echo $legal_name;?><br>
                        <?php echo $legal_charge;?>
                    </p>
                </div>
                <div style="width: 50%; float: right;">
                    <p style="text-align:center; align-content:center; margin-left:5px; font-size:9px; font-family:'Poppins';">
                        ______________________________________<br>
                        <?php echo $account_name;?><br>
                        <?php echo $account_charge;?>
                    </p>
                </div>
            </div>
        </main>
    </body>
</html>