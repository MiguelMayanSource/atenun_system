<!doctype html>
<?php 
    ini_set("memory_limit","500M");
    setlocale(LC_TIME,"es_ES");
    $cuentas = $this->crud_model->getLedger($initial, $final, $nomenclature_id);
    $totalDebe = 0; $totalHaber = 0; $count = 1; $signo = '';
?>
<html>
    <head> <meta charset="gb18030"> </head>
    <body style="margin: 0px; font-size: 12px; font-family: 'Poppins'; font-weight: bold;">
        <main>
            <div style="width: 100%;">
                <p style="text-align: center; align-content: center; margin-left: 5px;">
                    LIBRO MAYOR<br>
                    <?php echo $this->crud_model->getInfo('description');?><br>
                    <?php echo $this->crud_model->getInfo('system_name');?><br>
                    DEL <?php echo strtoupper(strftime("%d DE %B AL ", strtotime($initial))).date('d ', strtotime($final));
                            if (date('m', strtotime($initial)) != date('m', strtotime($final))) echo strftime("DE %B ", strtotime($final));
                            echo strftime("DEL %Y", strtotime($final));?>
                </p>
            </div>
            <div style="">
                <table style="font-size: 12px; font-family: 'Poppins'; border: 1px solid black; border-collapse: collapse;width: 100%;">
                    <thead style="border-top: 1px solid #e0e6ed; border-bottom: 1px solid #e0e6ed;">
                        <tr style="background-color: #eff2f7;">
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px; width: 15%;">#</th>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px; width: 45%;">CUENTA</th>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px; width: 20%;">DEBE</th>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px; width: 20%;">HABER</th>
                        </tr>
                    </thead>
                </table>
                <?php foreach($cuentas->result_array() as $ct): 
                    $debe = 0; $haber = 0; $restante = 0;
                    $exNom = explode('.', $ct['code']);
                    $tipo = $exNom[0];
                ?>
                <table style="font-size: 12px; font-family: 'Poppins'; border: 1px solid black; border-collapse: collapse;width: 100%;">
                    <thead style="border-top: 1px solid #e0e6ed; border-bottom: 1px solid #e0e6ed;">
                        <tr style="background-color: #eff2f7;">
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px; width: 15%;"><?php echo $count++;?></th>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px; width: 45%;"><?php echo $ct['code'].' '.$ct['name'];?></th>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px; width: 20%;"></th>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px; width: 20%;"></th>
                        </tr>
                    </thead>
                    <tbody style="border-top: 1px solid #e0e6ed; border-bottom: 1px solid #e0e6ed;">
                        <?php $detalles = $this->crud_model->getDetailLedger($ct['nomenclature_id'], $initial, $final);
                            foreach ($detalles->result_array() as $dt):?>
                        <tr>
                            <td style="border: 1px solid black; border-collapse: collapse;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php echo date("d/m/Y", strtotime($dt['date']));?>
                                </span>
                            </td>
                            <td style="border: 1px solid black; border-collapse: collapse;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php echo $dt['details'];?>
                                </span>
                            </td>
                            <td style="border: 1px solid black; border-collapse: collapse; text-align: right;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php if($dt['debit'] != '') echo "Q.".number_format($dt['debit'],2,'.',',');?>
                                </span>
                            </td>
                            <td style="border: 1px solid black; border-collapse: collapse; text-align: right;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php if($dt['credit'] != '') echo "Q.".number_format($dt['credit'],2,'.',',');?>
                                </span>
                            </td>
                        </tr>
                        <?php $debe += $dt['debit']; $haber += $dt['credit']; endforeach;?>
                        <tr style="border-top: 1px solid #e0e6ed; border-bottom: 1px solid #e0e6ed;">
                            <th style="border: 1px solid black; border-collapse: collapse;"></th>
                            <th style="border: 1px solid black; border-collapse: collapse;"></th>
                            <th style="border: 1px solid black; border-collapse: collapse; text-align: right;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    Q.<?php echo number_format($debe,2,'.',',');?>
                                </span>
                            </th>
                            <th style="border: 1px solid black; border-collapse: collapse; text-align: right;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    Q.<?php echo number_format($haber,2,'.',',');?>
                                </span>
                            </th>
                        </tr>
                        <tr style="border-top: 1px solid #e0e6ed; border-bottom: 1px solid #e0e6ed;">
                            <?php if($tipo == 1 || $tipo == 5) $restante = $debe - $haber; if($tipo == 2 || $tipo == 3 || $tipo == 4) $restante = $haber - $debe;
                                if($restante < 0) $signo = '-'; else $signo = '';?>
                            <th style="border: 1px solid black; border-collapse: collapse;"></th>
                            <th style="border: 1px solid black; border-collapse: collapse; text-align: right;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    SALDO:
                                </span>
                            </th>
                            <th style="border: 1px solid black; border-collapse: collapse; text-align: right;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php if($tipo == 1 || $tipo == 5) echo $signo."Q.".number_format(abs($restante),2,'.',',');?>
                                </span>
                            </th>
                            <th style="border: 1px solid black; border-collapse: collapse; text-align: right;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                <?php if($tipo == 2 || $tipo == 3 || $tipo == 4) echo $signo."Q.".number_format(abs($restante),2,'.',',');?>
                                </span>
                            </th>
                        </tr>
                    </tbody>
                </table>
                <?php endforeach;?>
            </div>
        </main>
    </body>
</html>