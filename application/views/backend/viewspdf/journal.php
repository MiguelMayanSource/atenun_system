<!doctype html>
<?php 
    ini_set("memory_limit","500M");
    setlocale(LC_TIME,"es_ES");
    $diario = $this->crud_model->getJournal($initial, $final, $nom_id);
    $debe = 0; $haber = 0;
?>
<html>
    <head> <meta charset="gb18030"> </head>
    <body style="margin: 0px; font-size: 12px; font-family: 'Poppins'; font-weight: bold;">
        <main>
            <div style="width: 100%;">
                <p style="text-align: center; align-content: center; margin-left: 5px;">
                    LIBRO DIARIO<br>
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
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px; width: 5%;">#</th>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px; width: 55%;"></th>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px; width: 20%;">DEBE</th>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px; width: 20%;">HABER</th>
                        </tr>
                    </thead>
                </table>
                <?php foreach($diario->result_array() as $dr):?>
                <table style="font-size: 12px; font-family: 'Poppins'; border: 1px solid black; border-collapse: collapse;width: 100%;">
                    <thead style="border-top: 1px solid #e0e6ed; border-bottom: 1px solid #e0e6ed;">
                        <tr style="background-color: #eff2f7;">
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px; width: 5%;"><?php echo $dr['departure_id'];?></th>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px; width: 55%;"><?php echo date("d/m/Y", strtotime($dr['date']));?></th>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px; width: 20%;"></th>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px; width: 20%;"></th>
                        </tr>
                    </thead>
                    <tbody style="border-top: 1px solid #e0e6ed; border-bottom: 1px solid #e0e6ed;">
                        <?php $detalles = $this->crud_model->getDetailsDeparture($dr['departure_id']);
                            foreach ($detalles->result_array() as $dt): $nom_id = $dt['nomenclature_id']; $nom = $this->crud_model->nomenByID($nom_id);?>
                        <tr>
                            <td style="border: 1px solid black; border-collapse: collapse;"></td>
                            <td style="border: 1px solid black; border-collapse: collapse;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php echo $nom['code'].' '.$nom['name'];?>
                                </span>
                            </td>
                            <td style="border: 1px solid black; border-collapse: collapse; text-align: right;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php if($dt['debit'] != '') echo "Q.".number_format($dt['debit'],2,".",",");?>
                                </span>
                            </td>
                            <td style="border: 1px solid black; border-collapse: collapse; text-align: right;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php if($dt['credit'] != '') echo "Q.".number_format($dt['credit'],2,".",",");?>
                                </span>
                            </td>
                        </tr>
                        <?php $debe += $dt['debit']; $haber += $dt['credit']; endforeach;?>
                    </tbody>
                    <tfoot style="border-top: 1px solid #e0e6ed; border-bottom: 1px solid #e0e6ed;">
                        <tr>
                            <td style="border: 1px solid black; border-collapse: collapse;"></td>
                            <td style="border: 1px solid black; border-collapse: collapse;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php echo $dr['details'];?>
                                </span>
                            </td>
                            <td style="border: 1px solid black; border-collapse: collapse; text-align: right;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    Q.<?php echo number_format($dr['total'],2,".",",");?>
                                </span>
                            </td>
                            <td style="border: 1px solid black; border-collapse: collapse; text-align: right;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    Q.<?php echo number_format($dr['total'],2,".",",");?>
                                </span>
                            </td>
                        </tr>
                    </tfoot>
                </table>
                <?php endforeach;?>
                <table style="font-size: 12px; font-family: 'Poppins'; border: 1px solid black; border-collapse: collapse;width: 100%;">
                    <thead style="border-top: 1px solid #e0e6ed; border-bottom: 1px solid #e0e6ed;">
                        <tr style="background-color: #eff2f7;">
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px; width: 5%;"></th>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px; width: 55%;">TOTALES:</th>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px; width: 20%; text-align: right;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    Q.<?php echo number_format($debe,2,".",",");?>
                                </span>
                            </th>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px; width: 20%; text-align: right;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    Q.<?php echo number_format($haber,2,".",",");?>
                                </span>
                            </th>
                        </tr>
                    </thead>
                </table>
            </div>
        </main>
    </body>
</html>