<!doctype html>
<?php 
    ini_set("memory_limit","500M");
    setlocale(LC_TIME,"es_ES");
    $compras = $this->crud_model->getPurchasing($initial, $final, $institution_id.'-'.$camp.'-'.$text);
    $columns = $this->crud_model->getInfo("checks_purchase");
    $checks = json_decode($this->crud_model->getInfo("checks_purchase"));
    $totPeq = 0; $totGas = 0; $totCom = 0; $totSer = 0; $totImp = 0; $totIVA = 0; $totExe = 0; $totTotal = 0;
?>
<html>
    <head> <meta charset="gb18030"> </head>
    <body style="margin: 0px; font-size: 12px; font-family: 'Poppins'; font-weight: bold;">
        <main>
            <div style="width: 100%; display: table; clear: both;">
                <div style="width: 100%;">
                    <p style="text-align: center; align-content: center; margin-left: 5px;">
                        LIBRO DE COMPRAS Y SERVICIOS ADQUIRIDOS<br>
                        <b><?php echo $this->crud_model->getInfo('system_name');?></b>
                    </p>
                </div>
            </div>
            <div style="width: 100%; display: table; clear: both;">
                <div style="width: 50%; float: left;">
                    <p style="margin-left: 5px;">PERIODO: <u><?php echo "DEL ".strtoupper(strftime("%d DEL %B", strtotime($initial))." AL ".strftime("%d DEL %Y", strtotime($final)));?></u></p>
                </div>
                <div style="width: 50%; float: left;">
                    <p style="margin-left: 5px;">NIT: <u><?php echo $this->crud_model->getInfo('nit');?></u></p>
                </div>
            </div>
            <div style="">
                <table style="font-size: 12px; font-family: 'Poppins'; border: 1px solid black; border-collapse: collapse;width: 100%;">
                    <thead style="border-top: 1px solid #e0e6ed; border-bottom: 1px solid #e0e6ed;">
                        <tr style="background-color: #eff2f7;">
                            <?php if (in_array(1, $checks)):?>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">DOCTO</th>
                            <?php endif; if (in_array(2, $checks)):?>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;" rowspan="2">SERIE</th>
                            <?php endif; if (in_array(3, $checks)):?>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;" rowspan="2">NUMERO</th>
                            <?php endif; if (in_array(4, $checks)):?>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px; text-align: center;" rowspan="2">FECHA</th>
                            <?php endif; if (in_array(5, $checks)):?>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px; text-align: center;" rowspan="2">TIPO DE<br>DOCUMENTO</th>
                            <?php endif; if (in_array(6, $checks)):?>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px; text-align: center;" rowspan="2">NIT O<br>CEDULA</th>
                            <?php endif; if (in_array(7, $checks)):?>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;" rowspan="2">PROVEEDOR, VENDEDOR<br>O PRESTADOR DEL SERVICIO</th>
                            <?php endif; if (in_array(8, $checks)):?>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px; text-align: center;" rowspan="2">PEQUEÑO<br>CONTRIB.</th>
                            <?php endif; if (in_array(9, $checks)):?>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px; text-align: center;" rowspan="2">COMPRAS<br>COMBUSTIBLE</th>
                            <?php endif; if (in_array(10, $checks)):?>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px; text-align: center;" rowspan="2">COMPRAS<br>PRE. NETO</th>
                            <?php endif; if (in_array(11, $checks)):?>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px; text-align: center;" rowspan="2">SERVICIOS<br>PRE. NETO</th>
                            <?php endif; if (in_array(12, $checks)):?>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px; text-align: center;" rowspan="2">IMPORTACION</th>
                            <?php endif; if (in_array(13, $checks)):?>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px; text-align: center;" rowspan="2">IVA</th>
                            <?php endif; if (in_array(14, $checks)):?>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px; text-align: center;" rowspan="2">EXENTO</th>
                            <?php endif; if (in_array(15, $checks)):?>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px; text-align: center;" rowspan="2">TOTAL</th>
                            <?php endif;?>
                        </tr>
                        <tr style="background-color: #eff2f7;">
                            <?php if (in_array(1, $checks)):?>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">No</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody style="border-top: 1px solid #e0e6ed; border-bottom: 1px solid #e0e6ed;">
                        <?php foreach ($compras->result_array() as $cp):
                            $total = $cp['total']; $amount = $total / 1.12;
                            $iva = $amount * 0.12; $isr = 0;
                            if ($amount >= 30000) $isr = $amount * 0.07;
                            else if ($amount >= 2500) $isr = $amount * 0.05;
                            $prov = $this->crud_model->getProvidersByID($cp['provider_id']);?>
                        <tr>
                            <?php if (in_array(1, $checks)):?>
                            <td style="border: 1px solid black; border-collapse: collapse; text-align:center;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php echo $n++;?>
                                </span>
                            </td>
                            <?php endif; if (in_array(2, $checks)):?>
                            <td style="border: 1px solid black; border-collapse: collapse; text-align:center;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php echo $cp['serie'];?>
                                </span>
                            </td>
                            <?php endif; if (in_array(3, $checks)):?>
                            <td style="border: 1px solid black; border-collapse: collapse; text-align:center;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php echo $cp['number'];?>
                                </span>
                            </td>
                            <?php endif; if (in_array(4, $checks)):?>
                            <td style="border: 1px solid black; border-collapse: collapse;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php echo date("d/m/Y", strtotime($cp['date']));?>
                                </span>
                            </td>
                            <?php endif; if (in_array(5, $checks)):?>
                            <td style="border: 1px solid black; border-collapse: collapse;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php if($cp['document_type'] == "FACT") echo "FACTURA"; elseif($cp['document_type'] == "FCAM") echo "FACTURA CAMBIARIA"; elseif($cp['document_type'] == "FACT-P") echo "FACTURA PC"; elseif($cp['document_type'] == '') echo "NC"; else echo "NC";?>
                                </span>
                            </td>
                            <?php endif; if (in_array(6, $checks)):?>
                            <td style="border: 1px solid black; border-collapse: collapse; text-align:center;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php echo $prov['nit'];?>
                                </span>
                            </td>
                            <?php endif; if (in_array(7, $checks)):?>
                            <td style="border: 1px solid black; border-collapse: collapse;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php echo $prov['name'];?>
                                </span>
                            </td>
                            <?php endif; if (in_array(8, $checks)):?>
                            <td style="border: 1px solid black; border-collapse: collapse; text-align:right;"><?php if($cp['status'] == 1 && $cp['regime'] == 'P') echo number_format($amount,2,'.',','); else echo "0.00";?></td>
                            <?php endif; if (in_array(9, $checks)):?>
                            <td style="border: 1px solid black; border-collapse: collapse; text-align:right;"><?php if($cp['status'] == 1 && $cp['regime'] == 'G' && $cp['type'] == 'G' && $cp['exempt'] == 0) echo number_format($amount,2,'.',','); else echo "0.00";?></td>
                            <?php endif; if (in_array(10, $checks)):?>
                            <td style="border: 1px solid black; border-collapse: collapse; text-align:right;"><?php if($cp['status'] == 1 && $cp['regime'] == 'G' && $cp['type'] == 'C' && $cp['exempt'] == 0) echo number_format($amount,2,'.',','); else echo "0.00";?></td>
                            <?php endif; if (in_array(11, $checks)):?>
                            <td style="border: 1px solid black; border-collapse: collapse; text-align:right;"><?php if($cp['status'] == 1 && $cp['regime'] == 'G' && $cp['type'] == 'S' && $cp['exempt'] == 0) echo number_format($amount,2,'.',','); else echo "0.00";?></td>
                            <?php endif; if (in_array(12, $checks)):?>
                            <td style="border: 1px solid black; border-collapse: collapse; text-align:right;"><?php if($cp['status'] == 1 && $cp['regime'] == 'G' && $cp['type'] == 'I' && $cp['exempt'] == 0) echo number_format($amount,2,'.',','); else echo "0.00";?></td>
                            <?php endif; if (in_array(13, $checks)):?>
                            <td style="border: 1px solid black; border-collapse: collapse; text-align:right;"><?php if($cp['status'] == 1 && $cp['regime'] == 'G' && $cp['exempt'] == 0) echo number_format($iva,2,".",","); else echo "0.00";?></td>
                            <?php endif; if (in_array(14, $checks)):?>
                            <td style="border: 1px solid black; border-collapse: collapse; text-align:right;"><?php if($cp['status'] == 1 && $cp['exempt'] == 1) echo number_format($amount,2,'.',','); else echo "0.00";?></td>
                            <?php endif; if (in_array(15, $checks)):?>
                            <td style="border: 1px solid black; border-collapse: collapse; text-align:right;"><?php if($cp['status'] == 1) echo number_format($cp['total'],2,'.',','); else echo "0.00";?></td>
                            <?php endif;?>
                        </tr>
                        <?php if($cp['status'] == 1) {
                            if($cp['regime'] == 'P') $totPeq += $amount;
                            if($cp['regime'] == 'G' && $cp['type'] == 'G' && $cp['exempt'] == 0) $totGas += $amount;
                            if($cp['regime'] == 'G' && $cp['type'] == 'C' && $cp['exempt'] == 0) $totCom += $amount;
                            if($cp['regime'] == 'G' && $cp['type'] == 'S' && $cp['exempt'] == 0) $totSer += $amount;
                            if($cp['regime'] == 'G' && $cp['type'] == 'I' && $cp['exempt'] == 0) $totImp += $amount;
                            if($cp['regime'] == 'G' && $cp['exempt'] == 0) $totIVA += $iva;
                            if($cp['exempt'] == 1) $totExe += $amount;
                            $totTotal += $cp['total'];
                        }?>
                        <?php $cont++; endforeach;?>
                    </tbody>
                    <tfoot style="border-top: 1px solid #e0e6ed; border-bottom: 1px solid #e0e6ed;">
                        <tr style="background-color: #eff2f7;">
                            <?php if (in_array(1, $checks)):?>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;"></th>
                            <?php endif; if (in_array(2, $checks)):?>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;"></th>
                            <?php endif; if (in_array(3, $checks)):?>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;"></th>
                            <?php endif; if (in_array(4, $checks)):?>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;"></th>
                            <?php endif; if (in_array(5, $checks)):?>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;"></th>
                            <?php endif; if (in_array(6, $checks)):?>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;"></th>
                            <?php endif; if (in_array(7, $checks)):?>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px; text-align: right;">TOTALES</th>
                            <?php endif; if (in_array(8, $checks)):?>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px; text-align: right;"></th>
                            <?php endif; if (in_array(9, $checks)):?>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px; text-align: right;"></th>
                            <?php endif; if (in_array(10, $checks)):?>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px; text-align: right;"></th>
                            <?php endif; if (in_array(11, $checks)):?>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px; text-align: right;"></th>
                            <?php endif; if (in_array(12, $checks)):?>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px; text-align: right;"></th>
                            <?php endif; if (in_array(13, $checks)):?>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px; text-align: right;"></th>
                            <?php endif; if (in_array(14, $checks)):?>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px; text-align: right;"></th>
                            <?php endif; if (in_array(15, $checks)):?>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px; text-align: right;"></th>
                            <?php endif;?>
                        </tr>
                        <tr style="background-color: #eff2f7;">
                            <?php if (in_array(1, $checks)):?>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;"></th>
                            <?php endif; if (in_array(2, $checks)):?>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;"></th>
                            <?php endif; if (in_array(3, $checks)):?>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;"></th>
                            <?php endif; if (in_array(4, $checks)):?>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;"></th>
                            <?php endif; if (in_array(5, $checks)):?>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;"></th>
                            <?php endif; if (in_array(6, $checks)):?>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;"></th>
                            <?php endif; if (in_array(7, $checks)):?>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;"></th>
                            <?php endif; if (in_array(8, $checks)):?>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px; text-align: right;"><?php echo number_format($totPeq,2,'.',',');?></th>
                            <?php endif; if (in_array(9, $checks)):?>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px; text-align: right;"><?php echo number_format($totGas,2,'.',',');?></th>
                            <?php endif; if (in_array(10, $checks)):?>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px; text-align: right;"><?php echo number_format($totCom,2,'.',',');?></th>
                            <?php endif; if (in_array(11, $checks)):?>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px; text-align: right;"><?php echo number_format($totSer,2,'.',',');?></th>
                            <?php endif; if (in_array(12, $checks)):?>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px; text-align: right;"><?php echo number_format($totImp,2,'.',',');?></th>
                            <?php endif; if (in_array(13, $checks)):?>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px; text-align: right;"><?php echo number_format($totIVA,2,'.',',');?></th>
                            <?php endif; if (in_array(14, $checks)):?>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px; text-align: right;"><?php echo number_format($totExe,2,'.',',');?></th>
                            <?php endif; if (in_array(15, $checks)):?>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px; text-align: right;"><?php echo number_format($totTotal,2,'.',',');?></th>
                            <?php endif;?>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </main>
    </body>
</html>