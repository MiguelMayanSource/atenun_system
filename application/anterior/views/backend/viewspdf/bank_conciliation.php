<!doctype html>
<?php 
    ini_set("memory_limit","500M");
    setlocale(LC_TIME,"es_ES");
    $acc = $this->crud_model->getBankAccount($bank_account_id);
?>
<html>
    <head> <meta charset="gb18030"> </head>
    <body style="margin: 0px; font-size: 12px; font-family: 'Poppins'; font-weight: bold;">
        <main>
            <div style="width: 100%;">
                <p style="text-align: center; align-content: center; margin-left: 5px;">
                    <?php echo $this->crud_model->getInfo('system_name');?><br>
                    <?php echo $this->crud_model->getInfo('description');?><br>
                    Conciliación bancaria<br>
                    Banco <?php echo $acc['name'].' '.$acc['code'];?><br>
                    Del <?php echo strftime("%d de %B", strtotime($initial)).' al '.strftime("%d del %Y", strtotime($final));?><br>
                </p>
            </div>
            <div style="">
                <table style="margin-bottom: 1.5rem !important; font-size: 12px; font-family: 'Poppins'; width: 100%;">
                    <thead style="border-top: 1px solid #e0e6ed; border-bottom: 1px solid #e0e6ed;">
                        <tr style="">
                            <th style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px; width: 70%;"></th>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px; width: 15%; background-color: #d8d8d8;">
                                Parcial
                            </th>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px; width: 15%; background-color: #d8d8d8;">
                                Total
                            </th>
                        </tr>
                        <tr style="background-color: #d8d8d8;">
                            <th style="border-top: 1px solid black; border-bottom: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px; text-align: left;">
                                SALDO FINAL SEGÚN EL LIBRO MAYOR DE BANCOS
                            </th>
                            <th style="border-top: 1px solid black; border-bottom: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;"></th>
                            <th style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px; text-align: right;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php if($balance_ledge < 0) echo '-'; echo "Q.".number_format(abs($balance_ledge),2,'.',',');?>
                                </span>
                            </th>
                        </tr>
                    </thead>
                    <tbody style="">
                        <tr>
                            <td style="">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    (+) Notas de Crédito
                                </span>
                            </td>
                            <td style="text-align:right;"></td>
                            <td style="text-align:right;"></td>
                        </tr>
                        <?php for ($i=0; $i < count($note_credit); $i++):?>
                        <tr>
                            <td style="">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php echo $note_credit[$i];?>
                                </span>
                            </td>
                            <td style="text-align:right;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    Q.<?php echo number_format($amount_credit[$i],2,'.',',');?>
                                </span>
                            </td>
                            <td style="text-align:right;"></td>
                        </tr>
                        <?php endfor;?>
                        <?php if(count($note_credit) > 0):?>
                        <tr>
                            <td style="">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    Subtotal
                                </span>
                            </td>
                            <td style=""></td>
                            <td style="text-align:right;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php if($subtotal_note_credit < 0) echo '-'; echo "Q.".number_format(abs($subtotal_note_credit),2,'.',',');?>
                                </span>
                            </td>
                        </tr>
                        <?php endif;?>
                        <tr>
                            <td style="">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    (-) Notas de Dédito
                                </span>
                            </td>
                            <td style="text-align:right;"></td>
                            <td style="text-align:right;"></td>
                        </tr>
                        <?php for ($i=0; $i < count($note_debit); $i++):?>
                        <tr>
                            <td style="">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php echo $note_debit[$i];?>
                                </span>
                            </td>
                            <td style="text-align:right;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    Q.<?php echo number_format($amount_debit[$i],2,'.',',');?>
                                </span>
                            </td>
                            <td style="text-align: right;">
                                <?php if($i == (count($note_debit)-1)):?>
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php if($subtotal_note_debit < 0) echo '-'; echo "Q.".number_format(abs($subtotal_note_debit),2,'.',',');?>
                                </span>
                                <?php endif;?>
                            </td>
                        </tr>
                        <?php endfor;?>
                    </tbody>
                    <tfoot>
                        <tr style="background-color: #d8d8d8;">
                            <th style="border-top: 1px solid black; border-bottom: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px; text-align: left;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    Saldo a conciliar
                                </span>
                            </th>
                            <th style="border-top: 1px solid black; border-bottom: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;"></th>
                            <th style="border-bottom: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px; text-align: right;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php if($balance_1 < 0) echo '-'; echo "Q.".number_format(abs($balance_1),2,'.',',');?>
                                </span>
                            </th>
                        </tr>
                        <tr style="">
                            <th style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px; text-align: left;"></th>
                            <th style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;"></th>
                            <th style="border-top: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px; text-align: right;"></th>
                        </tr>
                    </tfoot>
                </table>
                <table style="margin-bottom: 1.5rem !important; font-size: 12px; font-family: 'Poppins'; width: 100%;">
                    <thead style="">
                        <tr style="background-color: #d8d8d8;">
                            <th style="border-top: 1px solid black; border-bottom: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px; width: 70%; text-align: left;">
                                SALDO FINAL SEGÚN EL ESTADO DE CUENTA
                            </th>
                            <th style="border-top: 1px solid black; border-bottom: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px; width: 15%;"></th>
                            <th style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px; width: 15%; text-align: right;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php if($balance_account < 0) echo '-'; echo "Q.".number_format(abs($balance_account),2,'.',',');?>
                                </span>
                            </th>
                        </tr>
                    </thead>
                    <tbody style="">
                        <tr>
                            <td style="">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    (-) Cheques girados y no cobrados
                                </span>
                            </td>
                            <td style="text-align:right;"></td>
                            <td style="text-align:right;"></td>
                        </tr>
                        <?php for ($i=0; $i < count($note_check); $i++):?>
                        <tr>
                            <td style="">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php echo $note_check[$i];?>
                                </span>
                            </td>
                            <td style="text-align:right;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    Q.<?php echo number_format($amount_check[$i],2,'.',',');?>
                                </span>
                            </td>
                            <td style="text-align:right;"></td>
                        </tr>
                        <?php endfor;?>
                        <tr>
                            <td style="">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    Subtotal
                                </span>
                            </td>
                            <td style=""></td>
                            <td style="text-align:right;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php if($subtotal_bank_check < 0) echo '-'; echo "Q.".number_format(abs($subtotal_bank_check),2,'.',',');?>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td style="">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    (+) Depositos en tránsito
                                </span>
                            </td>
                            <td style="text-align:right;"></td>
                            <td style="text-align:right;"></td>
                        </tr>
                        <?php for ($i=0; $i < count($note_deposit); $i++):?>
                        <tr>
                            <td style="">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php echo $note_deposit[$i];?>
                                </span>
                            </td>
                            <td style="text-align:right;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    Q.<?php echo number_format($amount_deposit[$i],2,'.',',');?>
                                </span>
                            </td>
                            <?php if($i == (count($note_deposit)-1)):?>
                            <td style="text-align:right;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php if($subtotal_bank_deposit < 0) echo '-'; echo "Q.".number_format(abs($subtotal_bank_deposit),2,'.',',');?>
                                </span>
                            </td>
                            <?php endif;?>
                        </tr>
                        <?php endfor;?>
                    </tbody>
                    <tfoot>
                        <tr style="background-color: #d8d8d8;">
                            <th style="border-top: 1px solid black; border-bottom: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px; text-align: left;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    Saldo a conciliar
                                </span>
                            </th>
                            <th style="border-top: 1px solid black; border-bottom: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;"></th>
                            <th style="border-bottom: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px; text-align: right;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php if($balance_2 < 0) echo '-'; echo "Q.".number_format($balance_2,2,'.',',');?>
                                </span>
                            </th>
                        </tr>
                        <tr style="">
                            <th style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px; text-align: left;"></th>
                            <th style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;"></th>
                            <th style="border-top: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px; text-align: right;"></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <br><br><br><br><br>
            <div style="width: 100%; display: table; clear: both;">
                <div style="width: 50%; float: left;">
                    <p style="text-align: center; align-content: center; margin-left: 5px;">
                        Elabora:______________________________<br>
                        <?php echo $elaborate_name;?><br>
                        <?php echo $elaborate_charge;?>
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
            <br><br><br><br><br>
            <div style="width: 100%;">
                <p style="text-align: center; align-content: center; margin-left: 5px;">
                    Revisa:______________________________<br>
                    <?php echo $check_name;?><br>
                    <?php echo $check_charge;?>
                </p>
            </div>
        </main>
    </body>
</html>