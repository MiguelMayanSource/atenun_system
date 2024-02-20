<!doctype html>
<?php 
    ini_set("memory_limit","500M");
    setlocale(LC_TIME,"es_ES");
    $acc = $this->crud_model->getBankAccount($bank_account_id);
    log_message("error", "Check equals: ".$check_equals);
?>
<html>
    <head> <meta charset="gb18030"> </head>
    <body style="margin: 0px; font-size: 12px; font-family: 'Poppins'; font-weight: bold;">
        <main>
            <div style="width: 100%;">
                <p style="text-align: center; align-content: center; margin-left: 5px;">
                    FLUJO DE EFECTIVO<br>
                    <?php echo $this->crud_model->getInfo('description');?><br>
                    <?php echo $this->crud_model->getInfo('system_name');?><br>
                    Del <?php echo strftime("%d de %B", strtotime($initial)).' al '.strftime("%d del %Y", strtotime($final));?><br>
                </p>
            </div>
            <div style="">
                <table style="margin-bottom: 1.5rem !important; font-size: 12px; font-family: 'Poppins'; width: 100%;">
                    <thead style="">
                        <tr style="">
                            <th style=" margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px; width: 40%;"></th>
                            <th style=" margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px; width: 20%;"></th>
                            <th style=" margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px; width: 20%;"></th>
                            <th style=" margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px; width: 20%;"></th>
                        </tr>
                    </thead>
                    <tbody style="">
                        <tr>
                            <td style="">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    Utilidad del Ejercicio
                                </span>
                            </td>
                            <td style="text-align: right;"></td>
                            <td style="text-align: right;"></td>
                            <td style="text-align: right;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php if($utility < 0) echo '-'; echo "Q.".number_format(abs($utility),2,".",",");?>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td style="">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    Cuentas que no originan movimiento de efectivo
                                </span>
                            </td>
                            <td style="text-align: right;"></td>
                            <td style="text-align: right;"></td>
                            <td style="text-align: right;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php echo "Q.".number_format(abs($no_moves),2,".",",");?>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td style=""></td>
                            <td style=""></td>
                            <td style=""></td>
                            <td style=""></td>
                        </tr>
                        <tr>
                            <td style="">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <b>CONCILIACIÓN ENTRE LA UTILIDAD NETA</b>
                                </span>
                            </td>
                            <td style="text-align: right;"></td>
                            <td style="text-align: right;"></td>
                            <td style="text-align: right;"></td>
                        </tr>
                        <tr>
                            <td style="">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <b>Y FLUJO DE EFECTIVO PROVISTO POR</b>
                                </span>
                            </td>
                            <td style="text-align: right;"></td>
                            <td style="text-align: right;"></td>
                            <td style="text-align: right;"></td>
                        </tr>
                        <tr>
                            <td style=""></td>
                            <td style=""></td>
                            <td style=""></td>
                            <td style=""></td>
                        </tr>
                        <tr>
                            <td style="">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    Actividades de Operación
                                </span>
                            </td>
                            <td style="text-align: right;"></td>
                            <td style="text-align: right;"></td>
                            <td style="text-align: right;"></td>
                        </tr>
                        <?php for ($i=0; $i < count($note_operation); $i++):?>
                        <tr>
                            <td style="">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php echo $note_operation[$i];?>
                                </span>
                            </td>
                            <td style="text-align: right; <?php if($i == (count($note_operation) - 1) && count($note_operation) > 1) echo "border-bottom:1px solid black; border-collapse:collapse;";?>">
                                <?php if (count($note_operation) > 1):?>
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    Q.<?php echo number_format(abs($amount_operation[$i]),2,".",",");?>
                                </span>
                                <?php endif;?>
                            </td>
                            <td style="text-align: right;">
                                <?php if (count($note_operation) == 1):?>
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php echo "Q.".number_format(abs($subtotal_operation),2,".",",");?>
                                </span>
                                <?php endif;?>
                            </td>
                            <td style="text-align: right;"></td>
                        </tr>
                        <?php endfor;?>
                        <?php if (count($note_operation) == 1):?>
                        <tr>
                            <td style=""></td>
                            <td style=""></td>
                            <td style=""></td>
                            <td style=""></td>
                        </tr>
                        <?php endif;?>
                        <?php if (count($note_operation) > 1):?>
                        <tr>
                            <td style=""></td>
                            <td style=""></td>
                            <td style="text-align: right;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php echo "Q.".number_format(abs($subtotal_operation),2,".",",");?>
                                </span>
                            </td>
                            <td style=""></td>
                        </tr>
                        <?php endif;?>
                        <tr>
                            <td style=""></td>
                            <td style=""></td>
                            <td style=""></td>
                            <td style=""></td>
                        </tr>
                        <tr>
                            <td style="">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    ACTIVIDADES DE INVERSIÓN
                                </span>
                            </td>
                            <td style="text-align: right;"></td>
                            <td style="text-align: right;"></td>
                            <td style="text-align: right;"></td>
                        </tr>
                        <?php for ($i=0; $i < count($note_invest); $i++):?>
                        <tr>
                            <td style="">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php echo $note_invest[$i];?>
                                </span>
                            </td>
                            <td style="text-align: right;">
                                <?php if (count($note_invest) > 1):?>
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    Q.<?php echo number_format(abs($amount_invest[$i]),2,".",",");?>
                                </span>
                                <?php endif;?>
                            </td>
                            <td style="text-align: right;">
                                <?php if (count($note_invest) == 1):?>
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php echo "Q.".number_format(abs($subtotal_invest),2,".",",");?>
                                </span>
                                <?php endif;?>
                            </td>
                            <td style="text-align: right;"></td>
                        </tr>
                        <?php endfor;?>
                        <?php if (count($note_invest) > 1):?>
                        <tr>
                            <td style=""></td>
                            <td style=""></td>
                            <td style=""></td>
                            <td style=""></td>
                        </tr>
                        <?php endif;?>
                        <?php if (count($note_invest) > 1):?>
                        <tr>
                            <td style=""></td>
                            <td style=""></td>
                            <td style="text-align: right;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php echo "Q.".number_format(abs($subtotal_invest),2,".",",");?>
                                </span>
                            </td>
                            <td style=""></td>
                        </tr>
                        <?php endif;?>
                        <tr>
                            <td style=""></td>
                            <td style=""></td>
                            <td style=""></td>
                            <td style=""></td>
                        </tr>
                        <tr>
                            <td style="">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    ACTIVIDADES DE FINANCIAMIENTO
                                </span>
                            </td>
                            <td style="text-align: right;"></td>
                            <td style="text-align: right;"></td>
                            <td style="text-align: right;"></td>
                        </tr>
                        <?php for ($i=0; $i < count($note_finance); $i++):?>
                        <tr>
                            <td style="">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php echo $note_finance[$i];?>
                                </span>
                            </td>
                            <td style="text-align: right;"></td>
                            <td style="text-align: right;<?php if($i == (count($note_finance) - 1)) echo " border-bottom:1px solid black; border-collapse:collapse;";?>">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    Q.<?php echo number_format(abs($amount_finance[$i]),2,".",",");?>
                                </span>
                            </td>
                            <td style="text-align: right;<?php if($i == (count($note_finance) - 1)) echo " border-bottom:1px solid black; border-collapse:collapse;";?>">
                                <?php if($i == (count($note_finance) - 1)):?>
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php  echo "Q.".number_format(abs($total_activities),2,".",",");?>
                                </span>
                                <?php endif?>
                            </td>
                        </tr>
                        <?php endfor;?>
                        <tr>
                            <td style=""></td>
                            <td style=""></td>
                            <td style=""></td>
                            <td style=""></td>
                        </tr>
                        <?php if($check_equals == 1):?>
                        <tr>
                            <td style="">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    AUMENTO NETO DE EFECTIVO
                                </span>
                            </td>
                            <td style=""></td>
                            <td style=""></td>
                            <td style=""></td>
                        </tr>
                        <tr>
                            <td style="">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    Y EQUIVALENTES DE EFECTIVO
                                </span>
                            </td>
                            <td style=""></td>
                            <td style="border-bottom:1px solid black; border-collapse:collapse;"></td>
                            <td style="text-align: right; border-bottom:1px solid black; border-collapse:collapse;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php echo "Q.".number_format(abs($increase),2,".",",");?>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td style=""></td>
                            <td style=""></td>
                            <td style=""></td>
                            <td style=""></td>
                        </tr>
                        <tr>
                            <td style="">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    EFECTIVO Y EQUIVALENTES DE EFECTIVO
                                </span>
                            </td>
                            <td style=""></td>
                            <td style=""></td>
                            <td style=""></td>
                        </tr>
                        <tr>
                            <td style="">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    DEL <?php echo strtoupper(strftime("%d de %B del %Y", strtotime($initial)));?>
                                </span>
                            </td>
                            <td style=""></td>
                            <td style="border-bottom:1px solid black; border-collapse:collapse;"></td>
                            <td style="text-align: right; border-bottom:1px solid black; border-collapse:collapse;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php echo "Q.".number_format(abs($equal_initial),2,".",",");?>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td style=""></td>
                            <td style=""></td>
                            <td style=""></td>
                            <td style=""></td>
                        </tr>
                        <tr>
                            <td style="">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    EFECTIVO Y EQUIVALENTES DE EFECTIVO
                                </span>
                            </td>
                            <td style=""></td>
                            <td style=""></td>
                            <td style=""></td>
                        </tr>
                        <tr>
                            <td style="">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    AL <?php echo strtoupper(strftime("%d de %B del %Y", strtotime($final)));?>
                                </span>
                            </td>
                            <td style=""></td>
                            <td style="border-bottom:1px solid black; border-collapse:collapse;"></td>
                            <td style="text-align: right;border-bottom:1px solid black; border-collapse:collapse;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php echo "Q.".number_format(abs($equal_final),2,".",",");?>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td style=""></td>
                            <td style=""></td>
                            <td style="border-top:1px solid black; border-collapse:collapse;"></td>
                            <td style="border-top:1px solid black; border-collapse:collapse;"></td>
                        </tr>
                        <?php endif;?>
                    </tbody>
                </table>
            </div>
            <div style="width: 100%;">
                <p style="text-align: center; align-content: center; margin-left: 5px;"><?php echo $description;?></p>
                <p style="text-align: center; align-content: center; margin-left: 5px;"><?php echo $this->crud_model->getInfo("address").' '.strftime("%d de %B del %Y");?></p>
            </div>
            <br><br><br><br><br>
            <div style="width: 100%; display: table; clear: both;">
                <div style="width: 50%; float: left;">
                    <p style="text-align: center; align-content: center; margin-left: 5px;">
                        ______________________________________<br>
                        <?php echo $legal_name;?><br>
                        <?php echo $legal_charge;?>
                    </p>
                </div>
                <div style="width: 50%; float: right;">
                    <p style="text-align: center; align-content: center; margin-left: 5px;">
                        ______________________________________<br>
                        <?php echo $account_name;?><br>
                        <?php echo $account_charge;?>
                    </p>
                </div>
            </div>
        </main>
    </body>
</html>