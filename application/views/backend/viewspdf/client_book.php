<!doctype html>
<?php 
    ini_set("memory_limit","500M");
    setlocale(LC_TIME,"es_ES");
    $checks = json_decode($this->crud_model->getInfo("checks_clients"));
    $totalTotal = 0; $totalCharge = 0; $totalCashed = 0; $totalCredit = 0; $totalResidue = 0; $cont = 1;
?>
<html>
    <head> <meta charset="gb18030"> </head>
    <body style="margin: 0px; font-size: 12px; font-family: 'Poppins'; font-weight: bold;">
        <main>
            <div style="width: 100%; display: table; clear: both;">
                <div style="width: 100%; float: left;">
                    <p style="margin-left: 5px; text-align: center; align-content: center;">
                        CUENTAS POR COBRAR<br>
                        <?php echo $this->crud_model->getInfo("system_name")."<br>";
                            echo $this->crud_model->getInfo("description")."<br>";
                            echo "Nit: ".$this->crud_model->getInfo("nit"),"<br>";
                            if ($initial != '' && $final != '') {
                                echo "<br> DEL ".strtoupper(strftime("%d DE %B AL ", strtotime($initial))).date('d ', strtotime($final));
                                if (date('m', strtotime($initial)) != date('m', strtotime($final))) echo strftime("DE %B ", strtotime($final));
                                echo strftime("DEL %Y", strtotime($final));
                            }?>
                    </p>
                </div>
            </div>
            <div style="">
                <table style="font-size: 12px; font-family: 'Poppins'; border: 1px solid black; border-collapse: collapse;width: 100%;">
                    <thead style="border-top: 1px solid #e0e6ed; border-bottom: 1px solid #e0e6ed;">
                        <tr style="background-color: #eff2f7;">
                            <?php if (in_array(1, $checks)):?>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">#</th>
                            <?php endif; if (in_array(2, $checks)):?>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">Cod.<br>Cliente</th>
                            <?php endif; if (in_array(3, $checks)):?>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">Nombre del<br>cliente</th>
                            <?php endif; if (in_array(4, $checks)):?>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">Nit</th>
                            <?php endif; if (in_array(5, $checks)):?>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">Dirección</th>
                            <?php endif; if (in_array(6, $checks)):?>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">Tel</th>
                            <?php endif; if (in_array(7, $checks)):?>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">Vendedor</th>
                            <?php endif; if (in_array(8, $checks)):?>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">No. de<br>factura</th>
                            <?php endif; if (in_array(9, $checks)):?>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">Fecha de<br>emisión</th>
                            <?php endif; if (in_array(10, $checks)):?>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">Fecha de<br>vencimiento</th>
                            <?php endif; if (in_array(11, $checks)):?>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">Cargo total</th>
                            <?php endif; if (in_array(12, $checks)):?>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">Abonos</th>
                            <?php endif; if (in_array(13, $checks)):?>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">Saldo pendiente</th>
                            <?php endif; if (in_array(14, $checks)):?>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">Comentarios</th>
                            <?php endif;?>
                        </tr>
                    </thead>
                    <tbody style="border-top: 1px solid #e0e6ed; border-bottom: 1px solid #e0e6ed;">
                        <?php foreach ($ventas->result_array() as $vt):
                            $visit = $this->crud_model->getVisitor($vt['visitor_id']);
                            $issue = $this->crud_model->getIssueBySale($vt['sale_id']);?>
                        <tr>
                            <?php if (in_array(1, $checks)):?>
                            <td style="border: 1px solid black; border-collapse: collapse; text-align: left;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php echo $cont++;?>
                                </span>
                            </td>
                            <?php endif; if (in_array(2, $checks)):?>
                            <td style="border: 1px solid black; border-collapse: collapse;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php echo $vt['code'];?>
                                </span>
                            </td>
                            <?php endif; if (in_array(3, $checks)):?>
                            <td style="border: 1px solid black; border-collapse: collapse;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php echo $vt['first_name'].' '.$vt['last_name'];?>
                                </span>
                            </td>
                            <?php endif; if (in_array(4, $checks)):?>
                            <td style="border: 1px solid black; border-collapse: collapse;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php echo $vt['nit'];?>
                                </span>
                            </td>
                            <?php endif; if (in_array(5, $checks)):?>
                            <td style="border: 1px solid black; border-collapse: collapse;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php echo $vt['address'];?>
                                </span>
                            </td>
                            <?php endif; if (in_array(6, $checks)):?>
                            <td style="border: 1px solid black; border-collapse: collapse;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php echo $vt['phone'];?>
                                </span>
                            </td>
                            <?php endif; if (in_array(7, $checks)):?>
                            <td style="border: 1px solid black; border-collapse: collapse;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php echo $visit['name'];?>
                                </span>
                            </td>
                            <?php endif; if (in_array(8, $checks)):?>
                            <td style="border: 1px solid black; border-collapse: collapse;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php echo $vt['invoice'];?>
                                </span>
                            </td>
                            <?php endif; if (in_array(9, $checks)):?>
                            <td style="border: 1px solid black; border-collapse: collapse;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php if($issue['date'] != '') echo date("d/m/Y", strtotime($issue['date_issue'])); else echo date("d/m/Y", strtotime($vt['date']));?>
                                </span>
                            </td>
                            <?php endif; if (in_array(10, $checks)):?>
                            <td style="border: 1px solid black; border-collapse: collapse;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php if($vt['due_date'] != '') echo date("d/m/Y", strtotime($vt['due_date']));?>
                                </span>
                            </td>
                            <?php endif; if (in_array(11, $checks)):?>
                            <td style="border: 1px solid black; border-collapse: collapse; text-align: right;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    Q.<?php echo number_format($vt['total_due'],2,'.',',');?>
                                </span>
                            </td>
                            <?php endif; if (in_array(12, $checks)):?>
                            <td style="border: 1px solid black; border-collapse: collapse; text-align: right;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    Q.<?php if($vt['type_invoice'] == 'C') echo number_format($vt['charges'],2,'.',','); else echo '-';?>
                                </span>
                            </td>
                            <?php endif; if (in_array(13, $checks)):?>
                            <td style="border: 1px solid black; border-collapse: collapse; text-align: right;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    Q.<?php if($vt['type_invoice'] == 'C') echo number_format($vt['residue'],2,'.',','); else echo '-';?>
                                </span>
                            </td>
                            <?php endif; if (in_array(14, $checks)):?>
                            <td style="border: 1px solid black; border-collapse: collapse;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    Q.<?php echo $vt['details'];?>
                                </span>
                            </td>
                            <?php endif;?>
                        </tr>
                        <?php $totalTotal += $vt['total']; 
                            if($vt['type_invoice'] == 'C') { 
                                $totalCharge += $vt['charges']; 
                                $totalResidue += $vt['residue'];
                                $totalCredit += $vt['total'];
                            } elseif($vt['type_invoice'] == 'N') { 
                                $totalCashed += $vt['total']; 
                            }
                            endforeach;?>
                    </tbody>
                    <tfoot style="border-top: 1px solid #e0e6ed; border-bottom: 1px solid #e0e6ed;">
                        <tr>
                            <?php if (in_array(1, $checks)):?>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;text-align: right;"></th>
                            <?php endif; if (in_array(2, $checks)):?>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;text-align: right;"></th>
                            <?php endif; if (in_array(3, $checks)):?>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;text-align: right;"></th>
                            <?php endif; if (in_array(4, $checks)):?>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;text-align: right;"></th>
                            <?php endif; if (in_array(5, $checks)):?>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;text-align: right;"></th>
                            <?php endif; if (in_array(6, $checks)):?>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;text-align: right;"></th>
                            <?php endif; if (in_array(7, $checks)):?>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;text-align: right;"></th>
                            <?php endif; if (in_array(8, $checks)):?>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;text-align: right;"></th>
                            <?php endif; if (in_array(9, $checks)):?>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;text-align: right;"></th>
                            <?php endif; if (in_array(10, $checks)):?>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;text-align: right;">Totales:</th>
                            <?php endif; if (in_array(11, $checks)):?>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;text-align: right;">Q.<?php echo number_format($totalTotal,2,'.',',');?></th>
                            <?php endif; if (in_array(12, $checks)):?>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;text-align: right;">Q.<?php echo number_format($totalCharge,2,'.',',');?></th>
                            <?php endif; if (in_array(13, $checks)):?>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;text-align: right;">Q.<?php echo number_format($totalResidue,2,'.',',');?></th>
                            <?php endif; if (in_array(14, $checks)):?>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;text-align: right;"></th>
                            <?php endif;?>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </main>
    </body>
</html>