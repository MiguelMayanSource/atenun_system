<!doctype html>
<?php 
    ini_set("memory_limit","500M");
    setlocale(LC_TIME,"es_ES");
    $movs = $this->crud_model->getTransferAccount($account_id, $initial, $final);
    $adjs = $this->crud_model->getTransferAdjustAccount($account_id, $initial, $final);
    $info = $this->crud_model->getInfoAccount($account_id);
    $saldo = $this->crud_model->getInitialBalanceBank($account_id, $initial);
    $totEg = 0; $totIn = 0; $nIn = 0; $nEg = 0;
    $totVen = 0; $totCli = 0; $totPre = 0; $totCob1 = 0; $totCob2 = 0; $totCob3 = 0; $totCob4 = 0; $totCob5 = 0; $totAnt = 0; $totInt = 0; $totTra1 = 0; $totOtro1 = 0; 
    $totCom = 0; $totPro = 0; $totOp = 0; $totPAn = 0; $totPPr = 0; $totDiv = 0; $totPag1 = 0; $totPag2 = 0; $totPag3 = 0; $totTra2 = 0; $totGas = 0; $totDec = 0; $totOtro2 = 0;
    $sumIn = 0; $sumEg = 0;
?>
<html>
    <head> <meta charset="gb18030"> </head>
    <body style="margin: 0px; font-size: 10px; font-family: 'Poppins'; font-weight: bold;">
        <main>
            <div style="width: 100%; display: table; clear: both;">
                <div style="width: 100%;">
                    <p style="text-align: center; align-content: center; margin-left: 5px; font-size: 10px;">
                        <b>LIBRO DE BANCOS</b><br>
                        <?php echo $this->crud_model->getInfo('description');?><br>
                        <b><?php echo $this->crud_model->getInfo('system_name');?></b>
                    </p>
                </div>
                <div style="width: 50%; float: left;">
                    <p style="margin-left: 5px; font-size: 10px;">
                        CUENTA: <?php echo $info['code'];?><br>
                        BANCO: <?php echo $info['bank'];?><br>
                        MES: DEL <?php echo strtoupper(strftime("%d DEL %B", strtotime($initial)).' AL '.strftime("%d DEL %Y", strtotime($final)));?>
                    </p>
                </div>
                <div style="width: 50%; float: left; font-size: 10px;">
                    <p style="margin-left: 5px;">MONEDA: <?php echo $info['iso']." - ".$info['currency'];?></p>
                </div>
            </div>
            <div style="">
                <table style="font-size: 10px; font-family: 'Poppins'; border: 1px solid black; border-collapse: collapse;width: 100%;">
                    <thead style="border-top: 1px solid #e0e6ed; border-bottom: 1px solid #e0e6ed;">
                        <tr style="">
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">FECHA</th>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">DESCRIPCIÓN</th>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">POL</th>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">EGRESOS</th>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">INGRESOS</th>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">Acumulado</th>
                        </tr>
                    </thead>
                    <tbody style="border-top: 1px solid #e0e6ed; border-bottom: 1px solid #e0e6ed;">
                        <?php if ($account_id != ''):?>
                        <tr>
                            <td style="border: 1px solid black; border-collapse: collapse;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php echo strtoupper(strftime("%B", strtotime($initial)));?>
                                </span>
                            </td>
                            <td style="border: 1px solid black; border-collapse: collapse; text-align: center;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    SALDO INICIAL
                                </span>
                            </td>
                            <td style="border: 1px solid black; border-collapse: collapse;"></td>
                            <td style="border: 1px solid black; border-collapse: collapse;"></td>
                            <td style="border: 1px solid black; border-collapse: collapse; text-align: right;"></td>
                            <td style="border: 1px solid black; border-collapse: collapse; text-align: right;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    Q.<?php echo number_format($saldo,2,".",",");?>
                                </span>
                            </td>
                        </tr>
                        <?php endif;?>
                        <?php foreach ($movs->result_array() as $mv):
                            $acc = $this->crud_model->getAccountBank($mv['bank_account_id']);
                            $no_policy = $this->crud_model->getNoPolicyByBank($mv['reference_id'], $acc['nomenclature_id']);?>
                        <tr>
                            <td style="border: 1px solid black; border-collapse: collapse;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php echo date("d/m/Y", strtotime($mv['date']));?>
                                </span>
                            </td>
                            <td style="border: 1px solid black; border-collapse: collapse;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php if($mv['no_check'] != '') echo "No. Cheque: ".$mv['no_check'];
                                        if($mv['description'] != '' && $mv['no_check'] != '') echo ", "; 
                                        echo $mv['description'];
                                        if($mv['description'] != '' && $mv['no_check'] == '') echo ", "; 
                                        if($mv['no_check'] == '') echo $mv['code'];?>
                                </span>
                            </td>
                            <td style="border: 1px solid black; border-collapse: collapse;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php echo $no_policy;?>
                                </span>
                            </td>
                            <td style="border: 1px solid black; border-collapse: collapse; text-align: right;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    Q.<?php if($mv['type'] == 0) echo number_format($mv['amount'],2,".",","); else echo '-';?>
                                </span>
                            </td>
                            <td style="border: 1px solid black; border-collapse: collapse; text-align: right;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    Q.<?php if($mv['type'] == 1) echo number_format($mv['amount'],2,".",","); else echo '-';?>
                                </span>
                            </td>
                            <?php if($mv['type'] == 1) $saldo += $mv['amount']; if($mv['type'] == 0) $saldo -= $mv['amount'];?>
                            <td style="border: 1px solid black; border-collapse: collapse; text-align: right;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php if($saldo < 0) echo '-'; echo "Q.".number_format(abs($saldo),2,".",",");?>
                                </span>
                            </td>
                        </tr>
                        <?php if($mv['type'] == 0) $totEg += $mv['amount']; if($mv['type'] == 1) $totIn += $mv['amount']; 
                            if($mv['move'] == 1) $totVen += $mv['amount']; if($mv['move'] == 2) $totCob1 += $mv['amount']; if($mv['move'] == 3) $totPre += $mv['amount']; if($mv['move'] == 4) $totCob2 += $mv['amount']; 
                            if($mv['move'] == 5) $totCob3 += $mv['amount']; if($mv['move'] == 6) $totCob4 += $mv['amount']; if($mv['move'] == 7) $totCob5 += $mv['amount']; if($mv['move'] == 8) $totAnt += $mv['amount']; 
                            if($mv['move'] == 9) $totInt += $mv['amount']; if($mv['move'] == 10) $totTra1 += $mv['amount']; if($mv['move'] == 11) $totOtro1 += $mv['amount']; if($mv['move'] == 12) $totCom += $mv['amount']; 
                            if($mv['move'] == 13) $totPro += $mv['amount']; if($mv['move'] == 14) $totPOp += $mv['amount']; if($mv['move'] == 15) $totPAn += $mv['amount']; if($mv['move'] == 16) $totPPr += $mv['amount']; 
                            if($mv['move'] == 17) $totDiv += $mv['amount']; if($mv['move'] == 18) $totPag1 += $mv['amount']; if($mv['move'] == 19) $totPag2 += $mv['amount']; if($mv['move'] == 20) $totPag3 += $mv['amount']; 
                            if($mv['move'] == 21) $totTra2 += $mv['amount']; if($mv['move'] == 22) $totGas += $mv['amount']; if($mv['move'] == 23) $totDec += $mv['amount']; if($mv['move'] == 24) $totOtro2 += $mv['amount'];
                            endforeach;?>
                        <?php if ($account_id != ''):?>
                        <tr style="">
                            <td style="border: 1px solid black; border-collapse: collapse;"></td>
                            <td style="border: 1px solid black; border-collapse: collapse;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    Ajustes
                                </span>
                            </td>
                            <td style="border: 1px solid black; border-collapse: collapse;"></td>
                            <td style="border: 1px solid black; border-collapse: collapse;"></td>
                            <td style="border: 1px solid black; border-collapse: collapse; text-align: right;"></td>
                            <td style="border: 1px solid black; border-collapse: collapse; text-align: right;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php if($saldo < 0) echo '-'; echo "Q.".number_format($saldo,2,".",",");?>
                                </span>
                            </td>
                        </tr>
                        <?php endif;?>
                        <?php foreach ($adjs->result_array() as $ad):
                            $pol = $this->crud_model->getPolicyByDep($ad['reference_id'])->row_array();?>
                        <tr>
                            <td style="border: 1px solid black; border-collapse: collapse;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php echo date("d/m/Y", strtotime($ad['date']));?>
                                </span>
                            </td>
                            <td style="border: 1px solid black; border-collapse: collapse;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php if($ad['no_check'] != '') echo "No. Cheque: ".$ad['no_check'];
                                        if($ad['description'] != '' && $ad['no_check'] != '') echo ", "; 
                                        echo $ad['description'];
                                        if($ad['description'] != '' && $ad['no_check'] == '') echo ", "; 
                                        if($ad['no_check'] == '') echo $ad['code'];?>
                                </span>
                            </td>
                            <td style="border: 1px solid black; border-collapse: collapse;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php echo $pol['no_policy'];?>
                                </span>
                            </td>
                            <td style="border: 1px solid black; border-collapse: collapse; text-align: right;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    Q.<?php if($ad['type'] == 0) echo number_format($ad['amount'],2,".",","); else echo '-';?>
                                </span>
                            </td>
                            <td style="border: 1px solid black; border-collapse: collapse; text-align: right;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    Q.<?php if($ad['type'] == 1) echo number_format($ad['amount'],2,".",","); else echo '-';?>
                                </span>
                            </td>
                            <?php if($ad['type'] == 1) $saldo += $ad['amount']; if($ad['type'] == 0) $saldo -= $ad['amount'];?>
                            <td style="border: 1px solid black; border-collapse: collapse; text-align: right;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php if($saldo < 0) echo '-'; echo "Q.".number_format(abs($saldo),2,".",",");?>
                                </span>
                            </td>
                        </tr>
                        <?php if($ad['type'] == 0) $totEg += $ad['amount']; if($ad['type'] == 1) $totIn += $ad['amount']; 
                            if($ad['move'] == 1) $totVen += $ad['amount']; if($ad['move'] == 2) $totCob1 += $ad['amount']; if($ad['move'] == 3) $totPre += $ad['amount']; if($ad['move'] == 4) $totCob2 += $ad['amount']; 
                            if($ad['move'] == 5) $totCob3 += $ad['amount']; if($ad['move'] == 6) $totCob4 += $ad['amount']; if($ad['move'] == 7) $totCob5 += $ad['amount']; if($ad['move'] == 8) $totAnt += $ad['amount']; 
                            if($ad['move'] == 9) $totInt += $ad['amount']; if($ad['move'] == 10) $totTra1 += $ad['amount']; if($ad['move'] == 11) $totOtro1 += $ad['amount']; if($ad['move'] == 12) $totCom += $ad['amount']; 
                            if($ad['move'] == 13) $totPro += $ad['amount']; if($ad['move'] == 14) $totPOp += $ad['amount']; if($ad['move'] == 15) $totPAn += $ad['amount']; if($ad['move'] == 16) $totPPr += $ad['amount']; 
                            if($ad['move'] == 17) $totDiv += $ad['amount']; if($ad['move'] == 18) $totPag1 += $ad['amount']; if($ad['move'] == 19) $totPag2 += $ad['amount']; if($ad['move'] == 20) $totPag3 += $ad['amount']; 
                            if($ad['move'] == 21) $totTra2 += $ad['amount']; if($ad['move'] == 22) $totGas += $ad['amount']; if($ad['move'] == 23) $totDec += $ad['amount']; if($ad['move'] == 24) $totOtro2 += $ad['amount'];
                            endforeach;?>
                    </tbody>
                    <tfoot style="border-top: 1px solid #e0e6ed; border-bottom: 1px solid #e0e6ed;">
                        <tr style="">
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;"></th>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px; text-align: left;">SALDO FINAL PARA EL SIGUIENTE PERIODO</th>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;"></th>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;text-align: right;"></th>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;text-align: right;"></th>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;text-align: right;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php if($saldo < 0) echo '-'; echo "Q.".number_format(abs($saldo),2,".",",");?>
                                </span>
                            </th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <br><br><br>
            <div style="width: 100%; display: table; clear: both;">
                <div style="width: 50%; float: left;">
                    <p style="text-align: center; align-content: center; margin-left: 5px;">
                        Elabora:______________________________<br>
                        <?php echo $maker_name;?><br>
                        <?php echo $maker_charge;?>
                    </p>
                </div>
                <div style="width: 50%; float: right;">
                    <p style="text-align: center; align-content: center; margin-left: 5px;">
                        Aprueba:______________________________<br>
                        <?php echo $approve_name;?><br>
                        <?php echo $approve_charge;?>
                    </p>
                </div>
            </div>
        </main>
    </body>
</html>