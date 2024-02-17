<!doctype html>
<?php 
    ini_set("memory_limit","500M");
    setlocale(LC_TIME,"es_ES");
    $ventas = $this->crud_model->getSalesBook($initial, $final, $institution_id.'-'.$camp.'-'.$text);
    $checks = json_decode($this->crud_model->getInfo("checks_sales")); $n = 1; $cont = 0;
    $totDocs = 0; $totalBien1 = 0; $totalServ1 = 0; $totalBien2 = 0; $totalServ2 = 0; $totalBien3 = 0; $totalServ3 = 0; $totalBien4 = 0; $totalServ4 = 0; $totalIVA = 0; $totalTotal = 0;
    $nIni = 0; $nDoc = 0; $nCom = 0; $nLoc = 0; $nExt = 0; $nFin = 0; $nBGR = 0; $nBEX = 0; $nGFE = 0; $nEXE = 0; $nDID = 0; $nTOI = 0; $nTOD = 0; $nTOC = 0;
    $nTB3 = 0; $nTS3 = 0; $nTB4 = 0; $nTS4 = 0; $totIVATran = 0;
    for ($i=1; $i <= 21; $i++) {
        if (in_array($i, $checks)) {
            if ($i == 2 || $i == 3) { $nIni++; $nTOI++; }
            if ($i >= 4 && $i <= 7) $nDoc++;
            if ($i >= 8 && $i <= 11) $nCom++;
            if ($i >= 12 && $i <= 15) $nLoc++;
            if ($i >= 16 && $i <= 19) $nExt++;
            if ($i == 20 || $i == 21) $nFin++; 
            if ($i == 12 || $i == 13) $nBGR++; 
            if ($i == 14 || $i == 15) $nBEX++; 
            if ($i == 16 || $i == 17) $nGFE++; 
            if ($i == 18 || $i == 19) $nEXE++; 
            if ($i == 9 || $i == 10) $nDID++; 
            if ($i >= 4 && $i <= 6) $nTOD++; 
            if ($i >= 8 && $i <= 11) $nTOC++; 
        }
    }
    log_message("error", "nIni: $nIni, nDoc: $nDoc, nCom: $nCom, nLoc: $nLoc, nExt: $nExt, nFin: $nFin, nBGR: $nBGR, nBEX: $nBEX, nGFE: $nGFE, nEXE: $nEXE, nDID: $nDID, nTOI: $nTOI, nTOD: $nTOD, nTOC: $nTOC");
?>
<html>
    <head> <meta charset="gb18030"> </head>
    <body style="margin: 0px; font-size: 12px; font-family: 'Poppins'; font-weight: bold;">
        <main>
            <div style="width: 100%; display: table; clear: both;">
                <div style="width: 100%; float: left;">
                    <p style="margin-left: 5px; text-align: center; align-content: center;">
                        LIBRO DE VENTAS Y SERVICIOS PRESTADOS<br>
                        <b><?php echo $this->crud_model->getInfo('system_name');?></b>
                    </p>
                </div>
            </div>
            <?php if ($institution_id != ''): $ins = $this->crud_model->getInstitution($institution_id);?>
            <div>
                <table style="font-size: 12px; font-family: 'Poppins'; border: 1px solid black; border-collapse: collapse; border-top: 1px solid #e0e6ed; border-bottom: 1px solid #e0e6ed;">
                    <tr style="border-top: 1px solid #e0e6ed; border-bottom: 1px solid #e0e6ed;">
                        <td style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                            CONTRIBUYENTE:
                        </td>
                        <td style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                            <?php echo $ins['personal_name'];?>
                        </td>
                    </tr>
                    <tr style="border-top: 1px solid #e0e6ed; border-bottom: 1px solid #e0e6ed;">
                        <td style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                            NOMBRE COMERCIAL:
                        </td>
                        <td style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                            <?php echo $ins['name'];?>
                        </td>
                    </tr>
                    <tr style="border-top: 1px solid #e0e6ed; border-bottom: 1px solid #e0e6ed;">
                        <td style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                            DIRECCIÓN COMERCIAL:
                        </td>
                        <td style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                            <?php echo $ins['personal_name'];?>
                        </td>
                    </tr>
                </table>
            </div>
            <?php endif;?>
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
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;"></th>
                            <?php endif; if ($nIni > 0):?>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;" colspan="<?php echo $nIni;?>" rowspan="2"></th>
                            <?php endif; if ($nDoc > 0):?>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;" colspan="<?php echo $nDoc;?>" rowspan="2">Datos del Documento</th>
                            <?php endif; if ($nCom > 0):?>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;" colspan="<?php echo $nCom;?>" rowspan="2">Datos Cliente/Comprador</th>
                            <?php endif; if ($nLoc > 0):?>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;" colspan="<?php echo $nLoc;?>">Local</th>
                            <?php endif; if ($nExt > 0):?>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;" colspan="<?php echo $nExt;?>">Exportación/Transferencia</th>
                            <?php endif; if ($nFin > 0):?>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;" colspan="<?php echo $nFin;?>" rowspan="2"></th>
                            <?php endif;?>
                        </tr>
                        <tr style="background-color: #eff2f7;">
                            <?php if (in_array(1, $checks)):?>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;"></th>
                            <?php endif; if ($nBGR > 0):?>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;" colspan="<?php echo $nBGR;?>">Base Gravada</th>
                            <?php endif; if ($nBEX > 0):?>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;" colspan="<?php echo $nBEX;?>">Base Exenta</th>
                            <?php endif; if ($nGFE > 0):?>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;" colspan="<?php echo $nGFE;?>">Gravada (Fact.<br>Especiales)</th>
                            <?php endif; if ($nEXE > 0):?>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;" colspan="<?php echo $nEXE;?>">Exentas</th>
                            <?php endif;?>
                        </tr>
                        <tr style="background-color: #eff2f7;">
                            <?php if (in_array(1, $checks)):?>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;" rowspan="2">#</th>
                            <?php endif; if (in_array(2, $checks)):?>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;" rowspan="2">FECHA</th>
                            <?php endif; if (in_array(3, $checks)):?>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;" rowspan="2">Estable-<br>cimiento</th>
                            <?php endif; if (in_array(4, $checks)):?>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;" rowspan="2">Tipo</th>
                            <?php endif; if (in_array(5, $checks)):?>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;" rowspan="2">Estado</th>
                            <?php endif; if (in_array(6, $checks)):?>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;" rowspan="2">Serie</th>
                            <?php endif; if (in_array(7, $checks)):?>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;" rowspan="2">Número</th>
                            <?php endif; if (in_array(8, $checks)):?>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;" rowspan="2">NIT</th>
                            <?php endif; if ($nDID > 0):?>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;" colspan="<?php echo $nDID;?>">Doc. de ID</th>
                            <?php endif; if (in_array(11, $checks)):?>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;" rowspan="2">Nombre</th>
                            <?php endif; if (in_array(12, $checks)):?>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;" rowspan="2">Bienes</th>
                            <?php endif; if (in_array(13, $checks)):?>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;" rowspan="2">Servicios</th>
                            <?php endif; if (in_array(14, $checks)):?>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;" rowspan="2">Bienes</th>
                            <?php endif; if (in_array(15, $checks)):?>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;" rowspan="2">Servicios</th>
                            <?php endif; if (in_array(16, $checks)):?>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;" rowspan="2">Bienes</th>
                            <?php endif; if (in_array(17, $checks)):?>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;" rowspan="2">Servicios</th>
                            <?php endif; if (in_array(18, $checks)):?>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;" rowspan="2">Bienes</th>
                            <?php endif; if (in_array(19, $checks)):?>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;" rowspan="2">Servicios</th>
                            <?php endif; if (in_array(20, $checks)):?>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;" rowspan="2">IVA Débito<br>Fiscal</th>
                            <?php endif; if (in_array(21, $checks)):?>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;" rowspan="2">TOTALES</th>
                            <?php endif;?>
                        </tr>
                        <tr style="background-color: #eff2f7;">
                            <?php if (in_array(9, $checks)):?>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">Tipo</th>
                            <?php endif; if (in_array(10, $checks)):?>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">Número</th>
                            <?php endif;?>
                        </tr>
                    </thead>
                    <tbody style="border-top: 1px solid #e0e6ed; border-bottom: 1px solid #e0e6ed;">
                        <?php foreach ($ventas->result_array() as $vt):
                            $ins = $this->crud_model->getInstitution($vt['institution_id']);
                            $issue = $this->crud_model->getIssueBySale($vt['sale_id']);?>
                        <tr>
                            <?php if (in_array(1, $checks)):?>
                            <td style="border: 1px solid black; border-collapse: collapse; text-align: center;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php echo $n;?>
                                </span>
                            </td>
                            <?php endif; if (in_array(2, $checks)):?>
                            <td style="border: 1px solid black; border-collapse: collapse; text-align: center;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php echo date("d/m/Y", strtotime($vt['date']));?>
                                </span>
                            </td>
                            <?php endif; if (in_array(3, $checks)):?>
                            <td style="border: 1px solid black; border-collapse: collapse; text-align: center;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php echo $ins['code']; if($ins['mode'] == 0) echo " *";?>
                                </span>
                            </td>
                            <?php endif; if (in_array(4, $checks)):?>
                            <td style="border: 1px solid black; border-collapse: collapse; text-align: center;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php if($vt['type_invoice'] == 'N') echo "FCE"; elseif($vt['type_invoice'] == 'C') echo "FCAM"; elseif($vt['type_note'] == 'C') echo "N.C"; elseif($vt['type_note'] == 'D') echo "N.D"; elseif($vt['type_note'] == 'A') echo 'N';?>
                                </span>
                            </td>
                            <?php endif; if (in_array(5, $checks)):?>
                            <td style="border: 1px solid black; border-collapse: collapse; text-align: center;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php if(count($issue) > 0) { if($issue['state'] == 1) echo 'E'; else echo 'A'; }?>
                                </span>
                            </td>
                            <?php endif; if (in_array(6, $checks)):?>
                            <td style="border: 1px solid black; border-collapse: collapse; text-align: center;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php  if(count($issue) > 0) echo $issue['no_serie'];?>
                                </span>
                            </td>
                            <?php endif; if (in_array(7, $checks)):?>
                            <td style="border: 1px solid black; border-collapse: collapse; text-align: center;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php echo $vt['invoice'];?>
                                </span>
                            </td>
                            <?php endif; if (in_array(8, $checks)):?>
                            <td style="border: 1px solid black; border-collapse: collapse; text-align: center;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php if($vt['type_id'] == "NIT") echo $vt['nit']; elseif ($vt['type_id'] == "CUI") echo $vt['cui'];?>
                                </span>
                            </td>
                            <?php endif; if (in_array(9, $checks)):?>
                            <td style="border: 1px solid black; border-collapse: collapse; text-align: center;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php ?>
                                </span>
                            </td>
                            <?php endif; if (in_array(10, $checks)):?>
                            <td style="border: 1px solid black; border-collapse: collapse; text-align: center;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php ?>
                                </span>
                            </td>
                            <?php endif; if (in_array(11, $checks)):?>
                            <td style="border: 1px solid black; border-collapse: collapse; text-align: center;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php echo $vt['name'];?>
                                </span>
                            </td>
                            <?php endif; if (in_array(12, $checks)):?>
                            <td style="border: 1px solid black; border-collapse: collapse; text-align: right;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php if($vt['status'] == 1 && ($vt['type'] == 'V' || $vt['type'] == '') && $vt['exempt'] == 0) echo number_format($vt['amount'],2,'.',','); else echo "0.00";?>
                                </span>
                            </td>
                            <?php endif; if (in_array(13, $checks)):?>
                            <td style="border: 1px solid black; border-collapse: collapse; text-align: right;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php if($vt['status'] == 1 && $vt['type'] == 'S' && $vt['exempt'] == 0) echo number_format($vt['amount'],2,'.',','); else echo "0.00";?>
                                </span>
                            </td>
                            <?php endif; if (in_array(14, $checks)):?>
                            <td style="border: 1px solid black; border-collapse: collapse; text-align: right;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php if($vt['status'] == 1 && ($vt['type'] == 'V' || $vt['type'] == '') && $vt['exempt'] == 1) echo number_format($vt['amount'],2,'.',','); else echo "0.00";?>
                                </span>
                            </td>
                            <?php endif; if (in_array(15, $checks)):?>
                            <td style="border: 1px solid black; border-collapse: collapse; text-align: right;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php if($vt['status'] == 1 && $vt['type'] == 'S' && $vt['exempt'] == 1) echo number_format($vt['amount'],2,'.',','); else echo "0.00";?>
                                </span>
                            </td>
                            <?php endif; if (in_array(16, $checks)):?>
                            <td style="border: 1px solid black; border-collapse: collapse; text-align: right;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php if($vt['status'] == 1 && $vt['type'] == 'VE' && $vt['exempt'] == 0) echo number_format($vt['amount'],2,'.',','); else echo "0.00";?>
                                </span>
                            </td>
                            <?php endif; if (in_array(17, $checks)):?>
                            <td style="border: 1px solid black; border-collapse: collapse; text-align: right;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php if($vt['status'] == 1 && $vt['type'] == 'SE' && $vt['exempt'] == 0) echo number_format($vt['amount'],2,'.',','); else echo "0.00";?>
                                </span>
                            </td>
                            <?php endif; if (in_array(18, $checks)):?>
                            <td style="border: 1px solid black; border-collapse: collapse; text-align: right;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php if($vt['status'] == 1 && $vt['type'] == 'VE' && $vt['exempt'] == 1) echo number_format($vt['amount'],2,'.',','); else echo "0.00";?>
                                </span>
                            </td>
                            <?php endif; if (in_array(19, $checks)):?>
                            <td style="border: 1px solid black; border-collapse: collapse; text-align: right;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php if($vt['status'] == 1 && $vt['type'] == 'SE' && $vt['exempt'] == 1) echo number_format($vt['amount'],2,'.',','); else echo "0.00";?>
                                </span>
                            </td>
                            <?php endif; if (in_array(20, $checks)):?>
                            <td style="border: 1px solid black; border-collapse: collapse; text-align: right;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php if($vt['status'] == 1 && $vt['exempt'] == 0) echo number_format($vt['iva'],2,".",","); else echo "0.00";?>
                                </span>
                            </td>
                            <?php endif; if (in_array(21, $checks)):?>
                            <td style="border: 1px solid black; border-collapse: collapse; text-align: right;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php if($vt['status'] == 1) echo number_format($vt['total'],2,".",","); else echo "0.00";?>
                                </span>
                            </td>
                            <?php endif;?>
                        </tr>
                        <?php if($vt['status'] == 1) {
                            if($vt['status'] == 1 && ($vt['type'] == 'V' || $vt['type'] == '') && $vt['exempt'] == 0) $totalBien1 += $vt['amount']; if($vt['status'] == 1 && $vt['type'] == 'S' && $vt['exempt'] == 0) $totalServ1 += $vt['amount']; 
                            if($vt['status'] == 1 && ($vt['type'] == 'V' || $vt['type'] == '') && $vt['exempt'] == 1) $totalBien2 += $vt['amount']; if($vt['status'] == 1 && $vt['type'] == 'S' && $vt['exempt'] == 1) $totalServ2 += $vt['amount']; 
                            if($vt['status'] == 1 && $vt['type'] == 'VE' && $vt['exempt'] == 0) { $totalBien3 += $vt['amount']; $nTB3++; } if($vt['status'] == 1 && $vt['type'] == 'SE' && $vt['exempt'] == 0) $totalServ3 += $vt['amount'];
                            if($vt['status'] == 1 && $vt['type'] == 'VE' && $vt['exempt'] == 1) { $totalBien4 += $vt['amount']; $nTB4++; } if($vt['status'] == 1 && $vt['type'] == 'SE' && $vt['exempt'] == 1) $totalServ4 += $vt['amount'];
                            if($vt['exempt'] == 0) $totalIVA += $vt['iva']; $totalTotal += $vt['total']; 
                            if($vt['type'] == 'VE') $totIVATran += $vt['iva'];
                        }?>
                        <?php $cont++; endforeach;?>
                    </tbody>
                    <tfoot style="border-top: 1px solid #e0e6ed; border-bottom: 1px solid #e0e6ed;">
                        <tr>
                            <?php if (in_array(1, $checks)):?>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;text-align: right;"></th>
                            <?php endif; if ($nTOI > 0):?>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;text-align: right;" colspan="<?php echo $nTOI;?>"></th>
                            <?php endif; if ($nTOD > 0):?>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;text-align: right;" colspan="<?php echo $nTOD;?>">Total:</th>
                            <?php endif; if (in_array(7, $checks)):?>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;text-align: right;"><?php echo $cont;?></th>
                            <?php endif; if ($nTOC > 0):?>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;text-align: right;" colspan="<?php echo $nTOC;?>">Totales en Q</th>
                            <?php endif; if (in_array(12, $checks)):?>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;text-align: right;"><?php echo number_format($totalBien1,2,'.',',');?></th>
                            <?php endif; if (in_array(13, $checks)):?>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;text-align: right;"><?php echo number_format($totalServ1,2,'.',',');?></th>
                            <?php endif; if (in_array(14, $checks)):?>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;text-align: right;"><?php echo number_format($totalBien2,2,'.',',');?></th>
                            <?php endif; if (in_array(15, $checks)):?>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;text-align: right;"><?php echo number_format($totalServ2,2,'.',',');?></th>
                            <?php endif; if (in_array(16, $checks)):?>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;text-align: right;"><?php echo number_format($totalBien3,2,'.',',');?></th>
                            <?php endif; if (in_array(17, $checks)):?>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;text-align: right;"><?php echo number_format($totalServ3,2,'.',',');?></th>
                            <?php endif; if (in_array(18, $checks)):?>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;text-align: right;"><?php echo number_format($totalBien4,2,'.',',');?></th>
                            <?php endif; if (in_array(19, $checks)):?>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;text-align: right;"><?php echo number_format($totalServ4,2,'.',',');?></th>
                            <?php endif; if (in_array(20, $checks)):?>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;text-align: right;"><?php echo number_format($totalIVA,2,'.',',');?></th>
                            <?php endif; if (in_array(21, $checks)):?>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;text-align: right;"><?php echo number_format($totalTotal,2,'.',',');?></th>
                            <?php endif;?>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div style="margin-top: 1rem; text-align: center; padding-right: 250px; padding-left: 250px;">
                <table style="font-size: 12px; font-family: 'Poppins'; border: 1px solid black; border-collapse: collapse;width: 100%;">
                    <thead style="border-top: 1px solid #e0e6ed; border-bottom: 1px solid #e0e6ed;">
                        <tr style="background-color: #eff2f7;">
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px; text-center: center;" colspan="3">TRANSFERENCIAS</th>
                        </tr>
                        <tr style="background-color: #eff2f7;">
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px; text-center: center;">Gravadas</th>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px; text-center: center;">Exentas</th>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px; text-center: center;" rowspan="2">IVA Débito Fiscal</th>
                        </tr>
                        <tr style="background-color: #eff2f7;">
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px; text-center: center;">Bienes</th>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px; text-center: center;">Bienes</th>
                        </tr>
                    </thead>
                    <tbody style="border-top: 1px solid #e0e6ed; border-bottom: 1px solid #e0e6ed;">
                        <tr>
                            <td style="border: 1px solid black; border-collapse: collapse; text-align: center;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php echo $nTB3;?>
                                </span>
                            </td>
                            <td style="border: 1px solid black; border-collapse: collapse; text-align: center;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php echo $nTB4;?>
                                </span>
                            </td>
                            <td style="border: 1px solid black; border-collapse: collapse; text-align: center;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php echo number_format($totIVATran,2,'.',',');?>
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <table style="font-size: 12px; font-family: 'Poppins'; border: 1px solid black; border-collapse: collapse;width: 100%; margin-top: 1rem;">
                    <thead style="border-top: 1px solid #e0e6ed; border-bottom: 1px solid #e0e6ed;">
                        <tr style="background-color: #eff2f7;">
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px; text-center: center;" colspan="3">Resumen de Constancias</th>
                        </tr>
                        <tr style="background-color: #eff2f7;">
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px; text-center: center;">Cantidad</th>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px; text-center: center;">Tipo de Constancias</th>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px; text-center: center;">Total</th>
                        </tr>
                    </thead>
                    <tbody style="border-top: 1px solid #e0e6ed; border-bottom: 1px solid #e0e6ed;">
                        <tr>
                            <td style="border: 1px solid black; border-collapse: collapse; text-align: center;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    0
                                </span>
                            </td>
                            <td style="border: 1px solid black; border-collapse: collapse; text-align: center;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    Constancias de Adquicición de Insumos
                                </span>
                            </td>
                            <td style="border: 1px solid black; border-collapse: collapse; text-align: center;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php echo number_format(0,2,'.',',');?>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid black; border-collapse: collapse; text-align: center;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    0
                                </span>
                            </td>
                            <td style="border: 1px solid black; border-collapse: collapse; text-align: center;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    CConstancias de Exención de IVA
                                </span>
                            </td>
                            <td style="border: 1px solid black; border-collapse: collapse; text-align: center;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php echo number_format(0,2,'.',',');?>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid black; border-collapse: collapse; text-align: center;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    0
                                </span>
                            </td>
                            <td style="border: 1px solid black; border-collapse: collapse; text-align: center;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    Constancias de Retención de IVA
                                </span>
                            </td>
                            <td style="border: 1px solid black; border-collapse: collapse; text-align: center;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php echo number_format(0,2,'.',',');?>
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </main>
    </body>
</html>