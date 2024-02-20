<!doctype html>
<?php 
    ini_set("memory_limit","500M");
    setlocale(LC_TIME,"es_ES");
    $debe = $this->crud_model->getJournalConsolidateDebitMax($initial, $final, $nom_id);
    $haber = $this->crud_model->getJournalConsolidateCreditMax($initial, $final, $nom_id);
    $totalDebe = 0; $totalHaber = 0; $count = 1; $data = array();
    $texto = "Movimiento correspondiente ";
    if (date('m', strtotime($initial)) == date('m', strtotime($final))) $texto .= strftime("%B", strtotime($initial));
    else $texto .= strftime("%d de %B AL ", strtotime($initial)).strftime("%d de %B del %Y", strtotime($final));
    $end = date("d/m/Y", strtotime($final));
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
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px; width: 5%;">#</th>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px; width: 55%;"></th>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px; width: 20%;">DEBE</th>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px; width: 20%;">HABER</th>
                        </tr>
                    </thead>
                </table>
                <?php foreach($debe->result_array() as $db):
                    $ids = explode(",", $db['ids']);?>
                    <?php if(!in_array($ids, $data)):
                        $totalDebe = 0; $totalHaber = 0; $totalDebe += $db['total']; array_push($data, $ids);?>
                <table style="font-size: 12px; font-family: 'Poppins'; border: 1px solid black; border-collapse: collapse;width: 100%;">
                    <thead style="border-top: 1px solid #e0e6ed; border-bottom: 1px solid #e0e6ed;">
                        <tr style="background-color: #eff2f7;">
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px; width: 5%;"><?php echo $count++;?></th>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px; width: 55%;"><?php echo $end;?></th>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px; width: 20%;"></th>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px; width: 20%;"></th>
                        </tr>
                    </thead>
                    <tbody style="border-top: 1px solid #e0e6ed; border-bottom: 1px solid #e0e6ed;">
                        <tr style="border-top: 1px solid #e0e6ed; border-bottom: 1px solid #e0e6ed;">
                            <th style="border: 1px solid black; border-collapse: collapse;"></th>
                            <th style="border: 1px solid black; border-collapse: collapse; text-align: left;"><?php echo $db['code'].' '.$db['name'];?></th>
                            <th style="border: 1px solid black; border-collapse: collapse; text-align: right;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    Q.<?php echo number_format($db['total'],2,'.',',');?>
                                </span>
                            </th>
                            <th style="border: 1px solid black; border-collapse: collapse; text-align: right;"></th>
                        </tr>
                        <?php $extra = $this->crud_model->getJournalConsolidateExtra("debit", $db['ids'], $db['nomenclature_id']);
                            foreach($extra->result_array() as $xt):
                                $totalDebe += $xt['total'];?>
                        <tr style="border-top: 1px solid #e0e6ed; border-bottom: 1px solid #e0e6ed;">
                            <th style="border: 1px solid black; border-collapse: collapse;"></th>
                            <th style="border: 1px solid black; border-collapse: collapse; text-align: left;"><?php echo $xt['code'].' '.$xt['name'];?></th>
                            <th style="border: 1px solid black; border-collapse: collapse; text-align: right;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    Q.<?php echo number_format($xt['total'],2,'.',',');?>
                                </span>
                            </th>
                            <th style="border: 1px solid black; border-collapse: collapse; text-align: right;"></th>
                        </tr>
                        <?php endforeach;?>
                        <?php $tax = $this->crud_model->getJournalConsolidateOther("debit", $db['ids'], $db['nomenclature_id']);
                            foreach($tax->result_array() as $tx):
                                $totalDebe += $tx['total'];?>
                        <tr style="border-top: 1px solid #e0e6ed; border-bottom: 1px solid #e0e6ed;">
                            <th style="border: 1px solid black; border-collapse: collapse;"></th>
                            <th style="border: 1px solid black; border-collapse: collapse; text-align: left;"><?php echo $tx['code'].' '.$tx['name'];?></th>
                            <th style="border: 1px solid black; border-collapse: collapse; text-align: right;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    Q.<?php echo number_format($tx['total'],2,'.',',');?>
                                </span>
                            </th>
                            <th style="border: 1px solid black; border-collapse: collapse; text-align: right;"></th>
                        </tr>
                        <?php $extra = $this->crud_model->getJournalConsolidateExtra("debit", $db['ids'], $tx['nomenclature_id']);
                            foreach($extra->result_array() as $xt):
                                $totalDebe += $xt['total'];?>
                        <tr style="border-top: 1px solid #e0e6ed; border-bottom: 1px solid #e0e6ed;">
                            <th style="border: 1px solid black; border-collapse: collapse;"></th>
                            <th style="border: 1px solid black; border-collapse: collapse; text-align: left;"><?php echo $xt['code'].' '.$xt['name'];?></th>
                            <th style="border: 1px solid black; border-collapse: collapse; text-align: right;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    Q.<?php echo number_format($xt['total'],2,'.',',');?>
                                </span>
                            </th>
                            <th style="border: 1px solid black; border-collapse: collapse; text-align: right;"></th>
                        </tr>
                        <?php endforeach; endforeach;?>
                        <?php $pay = $this->crud_model->getJournalConsolidatePay("credit", $db['ids']);
                            foreach($pay->result_array() as $py):
                                $totalHaber += $py['total'];?>
                        <tr style="border-top: 1px solid #e0e6ed; border-bottom: 1px solid #e0e6ed;">
                            <th style="border: 1px solid black; border-collapse: collapse;"></th>
                            <th style="border: 1px solid black; border-collapse: collapse; text-align: left;"><?php echo $py['code'].' '.$py['name'];?></th>
                            <th style="border: 1px solid black; border-collapse: collapse; text-align: right;"></th>
                            <th style="border: 1px solid black; border-collapse: collapse; text-align: right;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    Q.<?php echo number_format($py['total'],2,'.',',');?>
                                </span>
                            </th>
                        </tr>
                        <?php $extra = $this->crud_model->getJournalConsolidateExtra("credit", $db['ids'], $py['nomenclature_id']);
                            foreach($extra->result_array() as $xt):
                                $totalHaber += $xt['total'];?>
                        <tr style="border-top: 1px solid #e0e6ed; border-bottom: 1px solid #e0e6ed;">
                            <th style="border: 1px solid black; border-collapse: collapse;"></th>
                            <th style="border: 1px solid black; border-collapse: collapse; text-align: left;"><?php echo $xt['code'].' '.$xt['name'];?></th>
                            <th style="border: 1px solid black; border-collapse: collapse; text-align: right;"></th>
                            <th style="border: 1px solid black; border-collapse: collapse; text-align: right;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    Q.<?php echo number_format($xt['total'],2,'.',',');?>
                                </span>
                            </th>
                        </tr>
                        <?php endforeach; endforeach;?>
                        <tr style="border-top: 1px solid #e0e6ed; border-bottom: 1px solid #e0e6ed;">
                            <th style="border: 1px solid black; border-collapse: collapse;"></th>
                            <th style="border: 1px solid black; border-collapse: collapse; text-align: left;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php echo $texto;?>
                                </span>
                            </th>
                            <th style="border: 1px solid black; border-collapse: collapse; text-align: right;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    Q.<?php echo number_format($totalDebe,2,'.',',');?>
                                </span>
                            </th>
                            <th style="border: 1px solid black; border-collapse: collapse; text-align: right;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    Q.<?php echo number_format($totalHaber,2,'.',',');?>
                                </span>
                            </th>
                        </tr>
                    </tbody>
                </table>
                <?php endif; endforeach;?>
                <?php foreach($haber->result_array() as $hb):
                    $ids = explode(",",$db['ids']);?>
                    <?php if(!in_array($ids, $data)):
                        $totalDebe = 0; $totalHaber = 0; $totalHaber += $hb['total']; array_push($data, $ids);?>
                <table style="font-size: 12px; font-family: 'Poppins'; border: 1px solid black; border-collapse: collapse;width: 100%;">
                    <thead style="border-top: 1px solid #e0e6ed; border-bottom: 1px solid #e0e6ed;">
                        <tr style="background-color: #eff2f7;">
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px; width: 5%;"><?php echo $count++;?></th>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px; width: 55%;"><?php echo $end;?></th>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px; width: 20%;"></th>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px; width: 20%;"></th>
                        </tr>
                    </thead>
                    <tbody style="border-top: 1px solid #e0e6ed; border-bottom: 1px solid #e0e6ed;">
                        <?php $pay = $this->crud_model->getJournalConsolidatePay("debit", $hb['ids']);
                            foreach($pay->result_array() as $py):
                                $totalDebe += $py['total'];?>
                        <tr style="border-top: 1px solid #e0e6ed; border-bottom: 1px solid #e0e6ed;">
                            <th style="border: 1px solid black; border-collapse: collapse;"></th>
                            <th style="border: 1px solid black; border-collapse: collapse; text-align: left;"><?php echo $py['code'].' '.$py['name'];?></th>
                            <th style="border: 1px solid black; border-collapse: collapse; text-align: right;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    Q.<?php echo number_format($py['total'],2,'.',',');?>
                                </span>
                            </th>
                            <th style="border: 1px solid black; border-collapse: collapse; text-align: right;"></th>
                        </tr>
                        <?php $extra = $this->crud_model->getJournalConsolidateExtra("debit", $hb['ids'], $py['nomenclature_id']);
                            foreach($extra->result_array() as $xt):
                                $totalDebe += $xt['total'];?>
                        <tr style="border-top: 1px solid #e0e6ed; border-bottom: 1px solid #e0e6ed;">
                            <th style="border: 1px solid black; border-collapse: collapse;"></th>
                            <th style="border: 1px solid black; border-collapse: collapse; text-align: left;"><?php echo $xt['code'].' '.$xt['name'];?></th>
                            <th style="border: 1px solid black; border-collapse: collapse; text-align: right;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    Q.<?php echo number_format($xt['total'],2,'.',',');?>
                                </span>
                            </th>
                            <th style="border: 1px solid black; border-collapse: collapse; text-align: right;"></th>
                        </tr>
                        <?php endforeach; endforeach;?>
                        <tr style="border-top: 1px solid #e0e6ed; border-bottom: 1px solid #e0e6ed;">
                            <th style="border: 1px solid black; border-collapse: collapse;"></th>
                            <th style="border: 1px solid black; border-collapse: collapse; text-align: left;"><?php echo $hb['code'].' '.$hb['name'];?></th>
                            <th style="border: 1px solid black; border-collapse: collapse; text-align: right;"></th>
                            <th style="border: 1px solid black; border-collapse: collapse; text-align: right;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    Q.<?php echo number_format($hb['total'],2,'.',',');?>
                                </span>
                            </th>
                        </tr>
                        <?php $extra = $this->crud_model->getJournalConsolidateExtra("credit", $hb['ids'], $hb['nomenclature_id']);
                            foreach($extra->result_array() as $xt):
                                $totalHaber += $xt['total'];?>
                        <tr style="border-top: 1px solid #e0e6ed; border-bottom: 1px solid #e0e6ed;">
                            <th style="border: 1px solid black; border-collapse: collapse;"></th>
                            <th style="border: 1px solid black; border-collapse: collapse; text-align: left;"><?php echo $xt['code'].' '.$xt['name'];?></th>
                            <th style="border: 1px solid black; border-collapse: collapse; text-align: right;"></th>
                            <th style="border: 1px solid black; border-collapse: collapse; text-align: right;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    Q.<?php echo number_format($xt['total'],2,'.',',');?>
                                </span>
                            </th>
                        </tr>
                        <?php endforeach;?>
                        <?php $tax = $this->crud_model->getJournalConsolidateOther("credit", $hb['ids'], $hb['nomenclature_id']);
                            foreach($tax->result_array() as $tx):
                                $totalHaber += $tx['total'];?>
                        <tr style="border-top: 1px solid #e0e6ed; border-bottom: 1px solid #e0e6ed;">
                            <th style="border: 1px solid black; border-collapse: collapse;"></th>
                            <th style="border: 1px solid black; border-collapse: collapse; text-align: left;"><?php echo $tx['code'].' '.$tx['name'];?></th>
                            <th style="border: 1px solid black; border-collapse: collapse; text-align: right;"></th>
                            <th style="border: 1px solid black; border-collapse: collapse; text-align: right;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    Q.<?php echo number_format($tx['total'],2,'.',',');?>
                                </span>
                            </th>
                        </tr>
                        <?php $extra = $this->crud_model->getJournalConsolidateExtra("credit", $db['ids'], $tx['nomenclature_id']);
                            foreach($extra->result_array() as $xt):
                                $totalHaber += $xt['total'];?>
                        <tr style="border-top: 1px solid #e0e6ed; border-bottom: 1px solid #e0e6ed;">
                            <th style="border: 1px solid black; border-collapse: collapse;"></th>
                            <th style="border: 1px solid black; border-collapse: collapse; text-align: left;"><?php echo $xt['code'].' '.$xt['name'];?></th>
                            <th style="border: 1px solid black; border-collapse: collapse; text-align: right;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    Q.<?php echo number_format($xt['total'],2,'.',',');?>
                                </span>
                            </th>
                            <th style="border: 1px solid black; border-collapse: collapse; text-align: right;"></th>
                        </tr>
                        <?php endforeach;?>
                        <?php endforeach;?>
                        <tr style="border-top: 1px solid #e0e6ed; border-bottom: 1px solid #e0e6ed;">
                            <th style="border: 1px solid black; border-collapse: collapse;"></th>
                            <th style="border: 1px solid black; border-collapse: collapse; text-align: left;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php echo $texto;?>
                                </span>
                            </th>
                            <th style="border: 1px solid black; border-collapse: collapse; text-align: right;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    Q.<?php echo number_format($totalDebe,2,'.',',');?>
                                </span>
                            </th>
                            <th style="border: 1px solid black; border-collapse: collapse; text-align: right;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    Q.<?php echo number_format($totalHaber,2,'.',',');?>
                                </span>
                            </th>
                        </tr>
                    </tbody>
                </table>
                <?php endif; endforeach;?>
            </div>
        </main>
    </body>
</html>