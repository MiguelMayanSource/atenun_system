<!doctype html>
<?php 
    ini_set("memory_limit","500M");
    setlocale(LC_TIME,"es_ES");
    $ingresos = $this->crud_model->getIncomeStatement();
    $egresos = $this->crud_model->getExpenseStatement();
    $totalIngresos = 0;
    $totalEgresos = 0;
    $ventas = 0;
    $mercaderias = 0;
    $compras = 0;
    $operacion = 0;
    $margen = 0;
    $admin = 0;
    $financieros = 0;
    $productos = 0;
    $gastos = 0;
    $restante = 0;
?>
<html>
    <head> <meta charset="gb18030"> </head>
    <body style="margin: 0px; font-size: 9px; font-family: 'Poppins'; font-weight: bold;">
        <main>
            <div style="width: 100%;">
                <p style="text-align:center; align-content:center; margin-left:5px; font-size:10px; font-family:'Poppins';">
                    ESTADO DE RESULTADOS<br>
                    <?php echo $this->crud_model->getInfo('description');?><br>
                    <?php echo $this->crud_model->getInfo('system_name');?><br>
                    DEL <?php echo strtoupper(strftime("%d DEL %B", strtotime($initial)).' AL '.strftime("%d DE %B DEL %Y", strtotime($final)));?><br>
                </p>
            </div>
            <div style="">
                <table style="margin-bottom:0.5rem !important; font-size: 9px; font-family: 'Poppins'; width: 100%;">
                    <thead style="">
                        <tr style="background-color: #eff2f7;">
                            <th style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px; width: 15%">Rubro</th>
                            <th style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px; width: 40%"></th>
                            <th style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px; width: 15%"></th>
                            <th style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px; width: 15%"></th>
                            <th style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px; width: 15%"></th>
                        </tr>
                    </thead>
                    <tbody style="">
                        <?php $group = $this->crud_model->getGroupByCode("4.01.01");?>
                        <tr>
                            <td style="">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php echo $group['code'];?>
                                </span>
                            </td>
                            <td style="">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php echo $group['name'];?>
                                </span>
                            </td>
                            <td style=""></td>
                            <td style=""></td>
                            <td style=""></td>
                        </tr>
                        <?php $nom = $this->crud_model->getNomenByCode("4.02.01.001");
                            $total = $this->crud_model->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 4);
                            $ventas += $total;
                            $totalIngresos += $total;?>
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
                        <?php $nom = $this->crud_model->getNomenByCode("4.01.01.001");
                            $total = $this->crud_model->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 4);
                            $ventas += $total;
                            $totalIngresos += $total;?>
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
                        <?php $nom = $this->crud_model->getNomenByCode("4.01.01.002");
                            $total = $this->crud_model->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 4);
                            $ventas += $total;
                            $totalIngresos += $total;?>
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
                            <td style="">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">Ventas netas</span>
                            </td>
                            <td style=""></td>
                            <td style=""></td>
                            <td style="text-align: right;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php if($totalIngresos < 0) echo '-'; echo "Q.".number_format(abs($totalIngresos),2,".",",");?>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td style=""></td>
                            <td style="">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">menos</span>
                            </td>
                            <td style=""></td>
                            <td style=""></td>
                            <td style=""></td>
                        </tr>
                        <?php $group = $this->crud_model->getGroupByCode("5.01.01");?>
                        <tr>
                            <td style="">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php echo $group['code'];?>
                                </span>
                            </td>
                            <td style="">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php echo $group['name'];?>
                                </span>
                            </td>
                            <td style=""></td>
                            <td style=""></td>
                            <td style=""></td>
                        </tr>
                        <?php $nom = $this->crud_model->getNomenByCode("5.01.01.001");
                            $total = $this->crud_model->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 5);
                            $mercaderias += $total;?>
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
                        <?php $nom = $this->crud_model->getNomenByCode("5.01.01.002");
                            $total = $this->crud_model->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 5);
                            $compras += $total;
                            $mercaderias += $total;?>
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
                        <?php $nom = $this->crud_model->getNomenByCode("5.01.01.003");
                            $total = $this->crud_model->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 5);
                            $compras += $total;
                            $mercaderias += $total;?>
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
                        <?php $nom = $this->crud_model->getNomenByCode("5.01.01.006");
                            $total = $this->crud_model->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 5);
                            $compras += $total;
                            $mercaderias += $total;?>
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
                            <td style="border-bottom:1px solid black; border-collapse:collapse; text-align: right;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php if($compras < 0) echo '-'; echo "Q.".number_format(abs($compras),2,".",",");?>
                                </span>
                            </td>
                            <td style=""></td>
                        </tr>
                        <?php $nom = $this->crud_model->getNomenByCode("5.01.01.007");
                            $total = $this->crud_model->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 5);?>
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
                                    <?php if($mercaderias < 0) echo '-'; echo "Q.".number_format(abs($mercaderias),2,".",",");?>
                                </span>
                            </td>
                            <td style=""></td>
                        </tr>
                        <?php $nom = $this->crud_model->getNomenByCode("5.01.01.008");
                            if (strtotime($final) < strtotime($hoy)) $total = $this->crud_model->getTotalInventoryStatement($final);
                            else $total = $this->crud_model->getTotalInventoryStatement();
                            if ($mercaderias > $total) $totalMerc = $mercaderias - $total;
                            else $totalMerc = $total - $mercaderias;?>
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
                            <td style="border-bottom:1px solid black; border-collapse:collapse; text-align: right;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php if($totalMerc < 0) echo '-'; echo "Q.".number_format(abs($totalMerc),2,".",",");?>
                                </span>
                            </td>
                        </tr>
                        <?php $nom = $this->crud_model->getNomenByCode("5.01.01.009");
                            $total = $totalIngresos - $totalMerc;
                            $totalEgresos += $totalMerc;?>
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
                            <td style=""></td>
                            <td style="text-align: right;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php if($total < 0) echo '-'; echo "Q.".number_format(abs($total),2,".",",");?>
                                </span>
                            </td>
                        </tr>
                        <?php $group = $this->crud_model->getGroupByCode("5.02.01");?>
                        <tr>
                            <td style="">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php echo $group['code'];?>
                                </span>
                            </td>
                            <td style="">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php echo $group['name'];?>
                                </span>
                            </td>
                            <td style=""></td>
                            <td style=""></td>
                            <td style=""></td>
                        </tr>
                        <?php $nom = $this->crud_model->getNomenByCode("5.02.01.001");?>
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
                            <td style=""></td>
                            <td style=""></td>
                        </tr>
                        <?php $nom = $this->crud_model->getNomenByCode("5.02.01.002");
                            $total = $this->crud_model->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 5);
                            $operacion += $total;
                            $totalEgresos += $total;?>
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
                        <?php $nom = $this->crud_model->getNomenByCode("5.02.01.003");
                            $total = $this->crud_model->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 5);
                            $operacion += $total;
                            $totalEgresos += $total;?>
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
                        <?php $nom = $this->crud_model->getNomenByCode("5.02.01.004");
                            $total = $this->crud_model->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 5);
                            $operacion += $total;
                            $totalEgresos += $total;?>
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
                        <?php $nom = $this->crud_model->getNomenByCode("5.02.01.005");
                            $total = $this->crud_model->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 5);
                            $operacion += $total;
                            $totalEgresos += $total;?>
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
                        <?php $nom = $this->crud_model->getNomenByCode("5.02.01.006");
                            $total = $this->crud_model->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 5);
                            $operacion += $total;
                            $totalEgresos += $total;?>
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
                        <?php $nom = $this->crud_model->getNomenByCode("5.02.01.007");
                            $total = $this->crud_model->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 5);
                            $operacion += $total;
                            $totalEgresos += $total;?>
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
                        <?php $nom = $this->crud_model->getNomenByCode("5.02.01.008");
                            $total = $this->crud_model->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 5);
                            $operacion += $total;
                            $totalEgresos += $total;?>
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
                        <?php $nom = $this->crud_model->getNomenByCode("5.02.01.009");
                            $total = $this->crud_model->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 5);
                            $operacion += $total;
                            $totalEgresos += $total;?>
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
                        <?php $nom = $this->crud_model->getNomenByCode("5.02.01.010");
                            $total = $this->crud_model->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 5);
                            $operacion += $total;
                            $totalEgresos += $total;?>
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
                        <?php $nom = $this->crud_model->getNomenByCode("5.02.01.011");
                            $total = $this->crud_model->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 5);
                            $operacion += $total;
                            $totalEgresos += $total;?>
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
                        <?php $nom = $this->crud_model->getNomenByCode("5.02.01.012");
                            $total = $this->crud_model->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 5);
                            $operacion += $total;
                            $totalEgresos += $total;?>
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
                        <?php $nom = $this->crud_model->getNomenByCode("5.02.01.013");
                            $total = $this->crud_model->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 5);
                            $operacion += $total;
                            $totalEgresos += $total;?>
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
                        <?php $nom = $this->crud_model->getNomenByCode("5.02.01.014");
                            $total = $this->crud_model->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 5);
                            $operacion += $total;
                            $totalEgresos += $total;?>
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
                        <?php $nom = $this->crud_model->getNomenByCode("5.02.01.015");
                            $total = $this->crud_model->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 5);
                            $operacion += $total;
                            $totalEgresos += $total;?>
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
                        <?php $nom = $this->crud_model->getNomenByCode("5.02.01.016");
                            $total = $this->crud_model->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 5);
                            $operacion += $total;
                            $totalEgresos += $total;?>
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
                        <?php $nom = $this->crud_model->getNomenByCode("5.02.01.017");
                            $total = $this->crud_model->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 5);
                            $operacion += $total;
                            $totalEgresos += $total;?>
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
                        <?php $nom = $this->crud_model->getNomenByCode("5.02.01.018");
                            $total = $this->crud_model->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 5);
                            $operacion += $total;
                            $totalEgresos += $total;?>
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
                        <?php $nom = $this->crud_model->getNomenByCode("5.02.01.019");
                            $total = $this->crud_model->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 5);
                            $operacion += $total;
                            $totalEgresos += $total;?>
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
                        <?php $nom = $this->crud_model->getNomenByCode("5.02.01.020");
                            $total = $this->crud_model->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 5);
                            $operacion += $total;
                            $totalEgresos += $total;?>
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
                        <?php $nom = $this->crud_model->getNomenByCode("5.02.01.021");
                            $total = $this->crud_model->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 5);
                            $operacion += $total;
                            $totalEgresos += $total;?>
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
                            <td style="border-bottom:1px solid black; border-collapse:collapse;"></td>
                            <td style="border-bottom:1px solid black; border-collapse:collapse; text-align: right;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php if($operacion < 0) echo '-'; echo "Q.".number_format(abs($operacion),2,".",",");?>
                                </span>
                            </td>
                        </tr>
                        <?php $nom = $this->crud_model->getNomenByCode("5.02.01.022");
                            $margen = $totalIngresos - $totalEgresos;?>
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
                            <td style=""></td>
                            <td style="text-align: right;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php if($margen < 0) echo '-'; echo "Q.".number_format(abs($margen),2,".",",");?>
                                </span>
                            </td>
                        </tr>
                        <?php $nom = $this->crud_model->getNomenByCode("5.02.01.023");?>
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
                            <td style=""></td>
                            <td style=""></td>
                        </tr>
                        <?php $nom = $this->crud_model->getNomenByCode("5.02.01.024");
                            $total = $this->crud_model->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 5);
                            $admin += $total;
                            $totalEgresos += $total;?>
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
                        <?php $nom = $this->crud_model->getNomenByCode("5.02.01.025");
                            $total = $this->crud_model->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 5);
                            $admin += $total;
                            $totalEgresos += $total;?>
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
                        <?php $nom = $this->crud_model->getNomenByCode("5.02.01.026");
                            $total = $this->crud_model->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 5);
                            $admin += $total;
                            $totalEgresos += $total;?>
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
                        <?php $nom = $this->crud_model->getNomenByCode("5.02.01.027");
                            $total = $this->crud_model->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 5);
                            $admin += $total;
                            $totalEgresos += $total;?>
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
                        <?php $nom = $this->crud_model->getNomenByCode("5.02.01.028");
                            $total = $this->crud_model->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 5);
                            $admin += $total;
                            $totalEgresos += $total;?>
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
                            <td style="border-bottom:1px solid black; border-collapse:collapse;"></td>
                            <td style="border-bottom:1px solid black; border-collapse:collapse; text-align: right;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php if($admin < 0) echo '-'; echo "Q.".number_format(abs($admin),2,".",",");?>
                                </span>
                            </td>
                        </tr>
                        <?php $nom = $this->crud_model->getNomenByCode("5.02.01.034");
                            $margen = $totalIngresos - $totalEgresos;?>
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
                            <td style=""></td>
                            <td style="text-align: right;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php if($margen < 0) echo '-'; echo "Q.".number_format(abs($margen),2,".",",");?>
                                </span>
                            </td>
                        </tr>
                        <?php $group = $this->crud_model->getGroupByCode("5.03.01");?>
                        <tr>
                            <td style="">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php echo $group['code'];?>
                                </span>
                            </td>
                            <td style="">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php echo $group['name'];?>
                                </span>
                            </td>
                            <td style=""></td>
                            <td style=""></td>
                            <td style=""></td>
                        </tr>
                        <?php $nom = $this->crud_model->getNomenByCode("5.03.01.001");
                            $total = $this->crud_model->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 5);
                            $financieros += $total;
                            $totalEgresos += $total;?>
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
                        <?php $nom = $this->crud_model->getNomenByCode("5.03.01.002");
                            $total = $this->crud_model->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 5);
                            $financieros += $total;
                            $totalEgresos += $total;?>
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
                        <?php $nom = $this->crud_model->getNomenByCode("5.03.01.003");
                            $total = $this->crud_model->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 5);
                            $financieros += $total;
                            $totalEgresos += $total;?>
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
                        <?php $nom = $this->crud_model->getNomenByCode("5.03.01.004");
                            $total = $this->crud_model->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 5);
                            $financieros += $total;
                            $totalEgresos += $total;?>
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
                        <?php $nom = $this->crud_model->getNomenByCode("5.03.01.005");
                            $total = $this->crud_model->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 5);
                            $financieros += $total;
                            $totalEgresos += $total;?>
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
                        <tr>
                            <td style=""></td>
                            <td style=""></td>
                            <td style=""></td>
                            <td style="text-align: right;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php if($financieros < 0) echo '-'; echo "Q.".number_format(abs($financieros),2,".",",");?>
                                </span>
                            </td>
                            <td style=""></td>
                        </tr>
                        <?php $group = $this->crud_model->getGroupByCode("5.04.01");?>
                        <tr>
                            <td style="">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php echo $group['code'];?>
                                </span>
                            </td>
                            <td style="">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php echo $group['name'];?>
                                </span>
                            </td>
                            <td style=""></td>
                            <td style=""></td>
                            <td style=""></td>
                        </tr>
                        <?php $nom = $this->crud_model->getNomenByCode("5.04.01.001");
                            $total = $this->crud_model->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 5);
                            $productos += $total;
                            $totalEgresos -= $total;?>
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
                        <?php $nom = $this->crud_model->getNomenByCode("5.04.01.002");
                            $total = $this->crud_model->getTotalYearNom($nom['nomenclature_id'], $initial, $final, 5);
                            $productos += $total;
                            $totalEgresos -= $total;
                            $gastos = $financieros - $productos;?>
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
                            <td style="border-bottom:1px solid black; border-collapse:collapse; text-align: right;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php if($productos < 0) echo '-'; echo "Q.".number_format(abs($productos),2,".",",");?>
                                </span>
                            </td>
                            <td style="border-bottom:1px solid black; border-collapse:collapse; text-align: right;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php if($gastos < 0) echo '-'; echo "Q.".number_format(abs($gastos),2,".",",");?>
                                </span>
                            </td>
                        </tr>
                        <?php $head = $this->crud_model->getHeadByCode("3.02");
                            $restante = $totalIngresos - $totalEgresos;?>
                        <tr>
                            <td style=""></td>
                            <td style="">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php echo $head['name'];?>
                                </span>
                            </td>
                            <td style=""></td>
                            <td style=""></td>
                            <td style=""></td>
                        </tr>
                        <?php if ($restante >= 0):
                            $utilidad = $this->crud_model->getGroupEquityLike("ganancia", $head['heading_id']);?>
                        <?php foreach($utilidad->result_array() as $ut):?>
                        <tr>
                            <td style="">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php echo $ut['code'];?>
                                </span>
                            </td>
                            <td style="">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php echo $ut['name'];?>
                                </span>
                            </td>
                            <td style=""></td>
                            <td style=""></td>
                            <td style=""></td>
                        </tr>
                        <?php $cuentas = $this->crud_model->getNomenLikeStatement("del periodo", $ut['heading_type_id'], $ut['heading_id'], $ut['group_account_id']);
                            foreach($cuentas->result_array() as $ct):?>
                        <tr>
                            <td style="">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php echo $ct['code'];?>
                                </span>
                            </td>
                            <td style="">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php echo $ct['name'];?>
                                </span>
                            </td>
                            <td style=""></td>
                            <td style=""></td>
                            <td style="text-align: right;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php echo "Q.".number_format($restante,2,".",",");?>
                                </span>
                            </td>
                        </tr>
                        <?php endforeach; endforeach; else: 
                            $perdida = $this->crud_model->getGroupEquityLike("perdida", $head['heading_id']);?>
                        <?php foreach($perdida->result_array() as $pd):?>
                        <tr>
                            <td style="">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php echo $pd['code'];?>
                                </span>
                            </td>
                            <td style="">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php echo $pd['name'];?>
                                </span>
                            </td>
                            <td style=""></td>
                            <td style=""></td>
                            <td style=""></td>
                        </tr>
                        <?php endforeach; endif;
                            if ($restante > 0):?>
                        <?php $head = $this->crud_model->getHeadByCode("3.01");
                            $reserva = $this->crud_model->getGroupEquityLike("reserva", $head['heading_id']);?>
                        <?php foreach($reserva->result_array() as $rs):?>
                        <tr>
                            <td style="">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php echo $rs['code'];?>
                                </span>
                            </td>
                            <td style="">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php echo $rs['name'];?>
                                </span>
                            </td>
                            <td style=""></td>
                            <td style=""></td>
                            <td style=""></td>
                        </tr>
                        <?php $cuentas = $this->crud_model->getNomenGeneral($rs['heading_type_id'], $rs['heading_id'], $rs['group_account_id']);
                            $legal = $restante * 0.05;
                            foreach($cuentas->result_array() as $ct):?>
                        <tr>
                            <td style="">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php echo $ct['code'];?>
                                </span>
                            </td>
                            <td style="">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php echo $ct['name'];?>
                                </span>
                            </td>
                            <td style=""></td>
                            <td style="border-bottom:1px solid black; border-collapse:collapse;"></td>
                            <td style="border-bottom:1px solid black; border-collapse:collapse; text-align: right;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php if($legal < 0) echo '-'; echo "Q.".number_format(abs($legal),2,".",",");?>
                                </span>
                            </td>
                        </tr>
                        <?php endforeach; endforeach; $restante -= $legal; endif;
                            $head = $this->crud_model->getHeadByCode("3.02");
                            if ($restante >= 0) $neta = $this->crud_model->getGroupEquityLike("ganancia", $head['heading_id']);
                            else $neta = $this->crud_model->getGroupEquityLike("perdida", $head['heading_id']);
                        ?>
                        <?php foreach($neta->result_array() as $nt):
                            $cuentas = $this->crud_model->getNomenLikeStatement("neta del ejercicio", $nt['heading_type_id'], $nt['heading_id'], $nt['group_account_id']);?>
                        <?php foreach($cuentas->result_array() as $ct):?>
                        <tr>
                            <td style="">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php echo $ct['code'];?>
                                </span>
                            </td>
                            <td style="">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php echo $ct['name'];?>
                                </span>
                            </td>
                            <td style=""></td>
                            <td style="border-bottom:1px solid black; border-collapse:collapse;"></td>
                            <td style="border-bottom:1px solid black; border-collapse:collapse; text-align: right;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php if($restante < 0) echo '-'; echo "Q.".number_format(abs($restante),2,".",",");?>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td style=""></td>
                            <td style=""></td>
                            <td style=""></td>
                            <td style="border-top: 1px solid black; border-collapse: collapse;"></td>
                            <td style="border-top: 1px solid black; border-collapse: collapse;"></td>
                        </tr>
                        <?php endforeach; endforeach;?>
                    </tbody>
                    <tfoot></tfoot>
                </table>
            </div>
            <div style="width:100%; margin-top:0px;">
                <p style="text-align:center; align-content:center; margin-left:5px; font-size:10px; font-family:'Poppins'; margin-bottom:0px;"><?php echo $description;?>.</p>
                <p style="text-align:center; align-content:center; margin-left:5px; font-size:10px; font-family:'Poppins'; margin-top:0px;"><?php echo $this->crud_model->getInfo("address").' '.strftime("%d de %B del %Y");?></p>
            </div>
            <br><br><br>
            <div style="width:100%; display:table; clear:both;">
                <div style="width: 50%; float: left;">
                    <p style="text-align:center; align-content:center; margin-left:5px; font-size:10px; font-family:'Poppins';">
                        ______________________________________<br>
                        <?php echo $legal_name;?><br>
                        <?php echo $legal_charge;?>
                    </p>
                </div>
                <div style="width: 50%; float: right;">
                    <p style="text-align:center; align-content:center; margin-left:5px; font-size:10px; font-family:'Poppins';">
                        ______________________________________<br>
                        <?php echo $account_name;?><br>
                        <?php echo $account_charge;?>
                    </p>
                </div>
            </div>
        </main>
    </body>
</html>