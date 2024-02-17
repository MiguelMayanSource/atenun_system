<!doctype html>
<?php 
    ini_set("memory_limit","500M");
    setlocale(LC_TIME,"es_ES");
    $check = $this->crud_model->getBankCheck($bank_check_id);
?>
<html style="">
    <head> <meta charset="gb18030"> </head>
    <body style="">
        <div style="height: 100%;">
            <div style="padding-top: 81px; padding-left: 155px; display: table; clear: both;">
                <div style="width: 400px; height: auto; text-align:center; font-size: 12px;"><?php echo $check['place'].', '.date("d/m/Y", strtotime($check['date']));?></div>
                <div style="width: 115px; height: auto; text-align:center; font-size: 12px; margin-top: -18px; margin-left: 390px;">**<?php echo number_format($check['amount'],2,".",",");?>**</div>
            </div>
            <div style="padding-top: 5px; padding-left: 100px; display: table; clear: both;">
                <div style="width: 510px; height: auto; text-align:center; font-size: 12px; margin-left: 20px;"><?php echo $check['pay_to'];?></div>
            </div>
            <div style="padding-top: 4px; padding-left: 115px; display: table; clear: both;">
                <div style="width: 495px; height: auto; text-align:center; font-size: 12px; margin-left: 20px;"><?php echo $check['amount_letter'];?></div>
            </div>
            <div style="padding-top: 19px; padding-left: 250px; display: table; clear: both;">
                <div style="width: 100px; height: auto; text-align:center; font-size: 12px;">NO NEGOCIABLE</div>
            </div>
        </div>
    </body>
</html>