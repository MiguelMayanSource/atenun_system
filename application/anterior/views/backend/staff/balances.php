<?php 
    $saldos = $this->crud_model->getSumBalance($initial, $final);
    $debe = 0; $haber = 0;
?>
<style type="text/css">
    .container-justify {
        display: flex;
        justify-content: space-between; /* Can be changed in the live sample */
    }
</style>
<div id="main-content">
    <div class="row">
        <div class="col-12">
            <div class="title-header">
                <a class="add-buton" href="<?php echo base_url();?>staff/accounting/">Regresar</a>
                <a class="add-buton" href="javascript:void(0);" onclick="modal_lg('<?php echo base_url();?>modal/popup/modal_accounting_books/')">Libros contables</a>
            </div>
            <div class="card-box">
                <div class="card-b">
                    <div class="row">
                        <div class="col-lg-12 mb-5">
                            <div class="title-header">
                                <a class="" href="javascript:void(0);">Balance de saldos</a>
                            </div>
                            <form class="repeater" action="<?php echo base_url();?>staff/balances/" method="POST" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-lg-5">
                                        <label for="">Fecha inicial</label>
                                        <input type="date" class="form-control" name="initial" value="<?php echo $initial;?>" />
                                    </div>
                                    <div class="col-lg-5">
                                        <label for="">Fecha final</label>
                                        <input type="date" class="form-control" name="final" value="<?php echo $final;?>" />
                                    </div>
                                    <div class="col-lg-2">
                                        <br>
                                        <button class="btn btn-info" type="submit">Ver</button>
                                        &nbsp;
                                        &nbsp;
                                        <input type="button" class="btn btn-danger" value="PDF" onclick="submitFormType('PDF')" />
                                        &nbsp;
                                        &nbsp;
                                        <input type="button" class="btn btn-success" value="EXCEL" onclick="submitFormType('EXCEL')" />
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-lg-12">
                            <table class="table mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-center" style="width: 5%">#</th>
                                        <th class="text-center" style="width: 45%">RUBRO</th>
                                        <th class="text-center" style="width: 25%">DEBE</th>
                                        <th class="text-center" style="width: 25%">HABER</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $cont = 1; foreach ($saldos->result_array() as $sl):?>
                                    <tr>
                                        <td><?php echo $cont++;?></td>
                                        <td><b><?php echo $sl['code'].' '.$sl['name'];?></b></td>
                                        <?php $info = explode('.', $sl['code']);
                                            if($info[0] == 1 || $info[0] == 5) $saldo = $sl['debe'] - $sl['haber']; elseif($info[0] == 2 || $info[0] == 3 || $info[0] == 4) $saldo = $sl['haber'] - $sl['debe'];?>
                                        <td style="">
                                            <?php if($info[0] == 1 || $info[0] == 5):?>
                                            <div class="container-justify">
                                                <div><b><?php if($saldo < 0) echo '-';?>Q</b></div> 
                                                <div><b><?php echo number_format(abs($saldo),2,'.',',');?></b></div>
                                            </div>
                                            <?php endif;?>
                                        </td>
                                        <td style="">
                                            <?php if($info[0] == 2 || $info[0] == 3 || $info[0] == 4):?>
                                            <div class="container-justify">
                                                <div><b><?php if($saldo < 0) echo '-';?>Q</b></div> 
                                                <div><b><?php echo "Q.".number_format(abs($saldo),2,'.',',');?></b></div>
                                            </div>
                                            <?php endif;?>
                                        </td>
                                    </tr>
                                    <?php $debe += $dt['debit']; $haber += $dt['credit']; endforeach;?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <form method="POST" action="<?php echo base_url();?>staff/printFormType/balances" id="frmB" target="">
            <input type="hidden" name="initial" value="<?php echo $initial;?>" />
            <input type="hidden" name="final" value="<?php echo $final;?>" />
            <input type="hidden" name="type" id="type" value="" />
        </form>
    </div>
</div>
<script type="text/javascript">
    function submitFormType(type) {
        validateForm();
        $("#type").val(type);
        if (type == "PDF") $("#frmB").attr("target", "_blank");
        else $("#frmB").attr("target", '');
        $("#frmB").submit();
    }

    function validateForm() {
        var initial = $("#initial").val();
        var final = $("#final").val();

        if (initial == '') $("#msgInicial").text("La fecha inicial está vacía.");
        if (final == '') $("#msgFinal").text("La fecha final está vacía.");
    }
</script>