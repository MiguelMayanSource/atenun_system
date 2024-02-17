<!doctype html>
<?php 
    ini_set("memory_limit","500M");
    setlocale(LC_TIME,"es_ES");
    $saldos = $this->crud_model->getSumBalance($initial, $final);
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
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px; width: 45%;">RUBRO</th>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px; width: 25%;">DEBE</th>
                            <th style="border: 1px solid black; border-collapse: collapse; margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px; width: 25%;">HABER</th>
                        </tr>
                    </thead>
                    <tbody style="border-top: 1px solid #e0e6ed; border-bottom: 1px solid #e0e6ed;">
                        <?php $cont = 1; foreach ($saldos->result_array() as $sl):?>
                        <tr>
                            <td style="border: 1px solid black; border-collapse: collapse;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php echo $cont++;?>
                                </span>
                            </td>
                            <td style="border: 1px solid black; border-collapse: collapse;">
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php echo $sl['code'].' '.$sl['name'];?>
                                </span>
                            </td>
                            <?php $info = explode('.', $sl['code']);
                                if($info[0] == 1 || $info[0] == 5) $saldo = $sl['debe'] - $sl['haber']; elseif($info[0] == 2 || $info[0] == 3 || $info[0] == 4) $saldo = $sl['haber'] - $sl['debe'];?>
                            <td style="border: 1px solid black; border-collapse: collapse; text-align: right;">
                                <?php if($info[0] == 1 || $info[0] == 5):?>
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php if($saldo < 0) echo '-'; echo 'Q'.number_format(abs($saldo),2,'.',',');?>
                                </span>
                                <?php endif;?>
                            </td>
                            <td style="border: 1px solid black; border-collapse: collapse; text-align: right;">
                                <?php if($info[0] == 2 || $info[0] == 3 || $info[0] == 4):?>
                                <span style="margin-right:5px; margin-left:5px; margin-top: 5px; margin-bottom:5px;">
                                    <?php if($saldo < 0) echo '-'; echo 'Q'.number_format(abs($saldo),2,'.',',');?>
                                </span>
                                <?php endif;?>
                            </td>
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
            </div>
        </main>
    </body>
</html>