<?php 
    $hoy = date("Y-m-d");
    $activo = 0; $pasivo = 0; $capital = 0;
    $checks = json_decode($this->crud_model->getInfo("checks_general"));
    setlocale(LC_TIME,"es_ES");
?>
<style type="text/css">
    .top-edge { 
        border-top-width: 1.5px !important; 
        border-top-color: #000 !important;
    }

    .bottom-edge { 
        border-bottom-width: 1.5px !important; 
        border-bottom-color: #000 !important;
    }

    .bottom-double-edge {
        border-bottom-style: double !important; 
        border-bottom-width: 4.5px !important; 
        border-bottom-color: #000 !important;
    }
    
    .container-justify {
        display: flex;
        justify-content: space-between;
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
                        <div class="col-lg-12">
                            <div class="title-header">
                                <h4 class="card-title text-center">BALANCE GENERAL</h4>
                                <h4 class="card-title text-center"><?php echo $this->crud_model->getInfo("description");?></h4>
                                <h4 class="card-title text-center"><?php echo $this->crud_model->getInfo("system_name");?></h4>
                            </div>
                        </div>
                        <div class="col-lg-3"></div>
                        <div class="col-lg-6 mb-3">
                            <form class="repeater" action="<?php echo base_url();?>staff/general/" method="POST" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <input type="date" class="form-control" name="initial" id="initial" value="<?php echo $initial;?>" required />
                                                <input type="date" class="form-control" name="final" id="final" value="<?php echo $final;?>" required />
                                                <button class="btn btn-info" type="submit">Ver</button>
                                            </div>
                                            <small class="text-danger" id="msgDates"></small>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-lg-3"></div>
                        <div class="col-lg-4 mb-3" style="">
                            <div class="dropdown dropend" style="">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-expanded="false" aria-haspopup="true">
                                    Ocultar filas <i class="mdi mdi-chevron-right"></i>
                                </button>
                                <div class="dropdown-menu" style="" aria-labelledby="dropdownMenuButton">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="dropdown-item">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="checks_columns[]" id="check-move-1" value="1" onclick="colHideAjax(this, 1)" />
                                                    <label class="form-check-label" for="check-move-1">Nivel 1</label>
                                                </div>
                                            </div>
                                            <div class="dropdown-item">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="checks_columns[]" id="check-move-2" value="2" onclick="colHideAjax(this, 2)" />
                                                    <label class="form-check-label" for="check-move-2">Nivel 2</label>
                                                </div>
                                            </div>
                                            <div class="dropdown-item">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="checks_columns[]" id="check-move-3" value="3" onclick="colHideAjax(this, 3)" />
                                                    <label class="form-check-label" for="check-move-3">Nivel 3</label>
                                                </div>
                                            </div>
                                            <div class="dropdown-item">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="checks_columns[]" id="check-move-4" value="4" onclick="colHideAjax(this, 4)" />
                                                    <label class="form-check-label" for="check-move-4">Nivel 4</label>
                                                </div>
                                            </div>
                                            <div class="dropdown-item">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="checks_columns[]" id="check-move-5" value="5" onclick="colHideAjax(this, 5)" />
                                                    <label class="form-check-label" for="check-move-5">Nivel 5</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 mb-3">
                            <table class="table table-bordered mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-center" style="width: 10%"></th>
                                        <th class="text-center" style="width: 27.5%"></th>
                                        <th class="text-center" style="width: 12.5%"></th>
                                        <th class="text-center" style="width: 12.5%"></th>
                                        <th class="text-center" style="width: 12.5%"></th>
                                        <th class="text-center" style="width: 12.5%"></th>
                                        <th class="text-center" style="width: 12.5%"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $lev1 = $this->crud_model->getNomenByCode("1");
                                        $total = $this->crud_model->getTotalLevelUpBalance($initial, $final, $lev1['code'], $lev1['level'], $lev1['code'][0]);
                                        $activo = $total;?>
                                    <tr class="row-1">
                                        <td><?php echo $lev1['code'];?></td>
                                        <td><?php echo $lev1['name'];?></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td class="text-right">
                                            <?php echo number_format($total,2,'.',',');?>
                                        </td>
                                    </tr>
                                    <?php $lev2 = $this->crud_model->getLevelsDownBalance($lev1['code'], $lev1['level']);
                                        // log_message("error", "Lev 2 Code: ".$lev1['code'].", Lev 2 Level: ".$lev1['level']."--------------------------------------");
                                        foreach($lev2->result_array() as $lv2):
                                            $total = $this->crud_model->getTotalLevelUpBalance($initial, $final, $lv2['code'], $lv2['level'], $lv2['code'][0]);?>
                                    <tr class="row-2">
                                        <td><?php echo $lv2['code'];?></td>
                                        <td><?php echo $lv2['name'];?></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td class="text-right">
                                            <?php echo number_format($total,2,'.',',');?>
                                        </td>
                                        <td></td>
                                    </tr>
                                    <?php $lev3 = $this->crud_model->getLevelsDownBalance($lv2['code'], $lv2['level']);
                                        // log_message("error", "Lev 3 Code: ".$lv2['code'].", Lev 3 Level: ".$lv2['level']."--------------------------------------");
                                        foreach($lev3->result_array() as $lv3):
                                            $total = $this->crud_model->getTotalLevelUpBalance($initial, $final, $lv3['code'], $lv3['level'], $lv3['code'][0]);?>
                                    <tr class="row-3">
                                        <td><?php echo $lv3['code'];?></td>
                                        <td><?php echo $lv3['name'];?></td>
                                        <td></td>
                                        <td></td>
                                        <td class="text-right">
                                            <?php echo number_format($total,2,'.',',');?>
                                        </td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <?php $lev4 = $this->crud_model->getLevelsDownBalance($lv3['code'], $lv3['level']);
                                        // log_message("error", "Lev 4 Code: ".$lv3['code'].", Lev 4 Level: ".$lv3['level']."--------------------------------------");
                                        foreach($lev4->result_array() as $lv4):
                                            $total = $this->crud_model->getTotalLevelUpBalance($initial, $final, $lv4['code'], $lv4['level'], $lv4['code'][0]);?>
                                    <tr class="row-4">
                                        <td><?php echo $lv4['code'];?></td>
                                        <td><?php echo $lv4['name'];?></td>
                                        <td></td>
                                        <td class="text-right">
                                            <?php echo number_format($total,2,'.',',');?>
                                        </td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <?php $lev5 = $this->crud_model->getLevelsDownBalance($lv4['code'], $lv4['level']);
                                        // log_message("error", "Lev 5 Code: ".$lv4['code'].", Lev 5 Level: ".$lv4['level']."--------------------------------------");
                                        foreach($lev5->result_array() as $lv5):
                                            $total = $this->crud_model->getTotalYearNom($lv5['nomenclature_id'], $initial, $final, $lv5['code'][0]);?>
                                    <tr class="row-5">
                                        <td><?php echo $lv5['code'];?></td>
                                        <td><?php echo $lv5['name'];?></td>
                                        <td class="text-right">
                                            <?php echo number_format($total,2,'.',',');?>
                                        </td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <?php endforeach; endforeach; endforeach; endforeach;?>
                                    <tr>
                                        <td></td>
                                        <td><b>SUMA DEL ACTIVO</b></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td class="text-right">
                                            <div style="border-top: 2px !important; border-bottom: 2px !important; border-collapse: collapse !important;"><b><?php echo number_format($activo,2,'.',',');?></b></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <?php $lev1 = $this->crud_model->getNomenByCode("2");
                                        $total = $this->crud_model->getTotalLevelUpBalance($initial, $final, $lev1['code'], $lev1['level'], $lev1['code'][0]);
                                        $pasivo = $total;?>
                                    <tr class="row-1">
                                        <td><?php echo $lev1['code'];?></td>
                                        <td><?php echo $lev1['name'];?></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td class="text-right">
                                            <?php echo number_format($total,2,'.',',');?>
                                        </td>
                                    </tr>
                                    <?php $lev2 = $this->crud_model->getLevelsDownBalance($lev1['code'], $lev1['level']);
                                        // log_message("error", "Lev 2 Code: ".$lev1['code'].", Lev 2 Level: ".$lev1['level']."--------------------------------------");
                                        foreach($lev2->result_array() as $lv2):
                                            $total = $this->crud_model->getTotalLevelUpBalance($initial, $final, $lv2['code'], $lv2['level'], $lv2['code'][0]);?>
                                    <tr class="row-2">
                                        <td><?php echo $lv2['code'];?></td>
                                        <td><?php echo $lv2['name'];?></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td class="text-right">
                                            <?php echo number_format($total,2,'.',',');?>
                                        </td>
                                        <td></td>
                                    </tr>
                                    <?php $lev3 = $this->crud_model->getLevelsDownBalance($lv2['code'], $lv2['level']);
                                        // log_message("error", "Lev 3 Code: ".$lv2['code'].", Lev 3 Level: ".$lv2['level']."--------------------------------------");
                                        foreach($lev3->result_array() as $lv3):
                                            $total = $this->crud_model->getTotalLevelUpBalance($initial, $final, $lv3['code'], $lv3['level'], $lv3['code'][0]);?>
                                    <tr class="row-3">
                                        <td><?php echo $lv3['code'];?></td>
                                        <td><?php echo $lv3['name'];?></td>
                                        <td></td>
                                        <td></td>
                                        <td class="text-right">
                                            <?php echo number_format($total,2,'.',',');?>
                                        </td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <?php $lev4 = $this->crud_model->getLevelsDownBalance($lv3['code'], $lv3['level']);
                                        // log_message("error", "Lev 4 Code: ".$lv3['code'].", Lev 4 Level: ".$lv3['level']."--------------------------------------");
                                        foreach($lev4->result_array() as $lv4):
                                            $total = $this->crud_model->getTotalLevelUpBalance($initial, $final, $lv4['code'], $lv4['level'], $lv4['code'][0]);?>
                                    <tr class="row-4">
                                        <td><?php echo $lv4['code'];?></td>
                                        <td><?php echo $lv4['name'];?></td>
                                        <td></td>
                                        <td class="text-right">
                                            <?php echo number_format($total,2,'.',',');?>
                                        </td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <?php $lev5 = $this->crud_model->getLevelsDownBalance($lv4['code'], $lv4['level']);
                                        // log_message("error", "Lev 5 Code: ".$lv4['code'].", Lev 5 Level: ".$lv4['level']."--------------------------------------");
                                        foreach($lev5->result_array() as $lv5):
                                            $total = $this->crud_model->getTotalYearNom($lv5['nomenclature_id'], $initial, $final, $lv5['code'][0]);?>
                                    <tr class="row-5">
                                        <td><?php echo $lv5['code'];?></td>
                                        <td><?php echo $lv5['name'];?></td>
                                        <td class="text-right">
                                            <?php echo number_format($total,2,'.',',');?>
                                        </td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <?php endforeach; endforeach; endforeach; endforeach;?>
                                    <tr>
                                        <td></td>
                                        <td><b>SUMA DEL PASIVO</b></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td class="text-right">
                                            <div style="border-top: 2px !important; border-bottom: 2px !important; border-collapse: collapse !important;"><b><?php echo number_format($pasivo,2,'.',',');?></b></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <?php $lev1 = $this->crud_model->getNomenByCode("3");
                                        $total = $this->crud_model->getTotalLevelUpBalance($initial, $final, $lev1['code'], $lev1['level'], $lev1['code'][0]);
                                        $capital = $total;?>
                                    <tr class="row-1">
                                        <td><?php echo $lev1['code'];?></td>
                                        <td><?php echo $lev1['name'];?></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td class="text-right">
                                            <?php echo number_format($total,2,'.',',');?>
                                        </td>
                                    </tr>
                                    <?php $lev2 = $this->crud_model->getLevelsDownBalance($lev1['code'], $lev1['level']);
                                        // log_message("error", "Lev 2 Code: ".$lev1['code'].", Lev 2 Level: ".$lev1['level']."--------------------------------------");
                                        foreach($lev2->result_array() as $lv2):
                                            $total = $this->crud_model->getTotalLevelUpBalance($initial, $final, $lv2['code'], $lv2['level'], $lv2['code'][0]);?>
                                    <tr class="row-2">
                                        <td><?php echo $lv2['code'];?></td>
                                        <td><?php echo $lv2['name'];?></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td class="text-right">
                                            <?php echo number_format($total,2,'.',',');?>
                                        </td>
                                        <td></td>
                                    </tr>
                                    <?php $lev3 = $this->crud_model->getLevelsDownBalance($lv2['code'], $lv2['level']);
                                        // log_message("error", "Lev 3 Code: ".$lv2['code'].", Lev 3 Level: ".$lv2['level']."--------------------------------------");
                                        foreach($lev3->result_array() as $lv3):
                                            $total = $this->crud_model->getTotalLevelUpBalance($initial, $final, $lv3['code'], $lv3['level'], $lv3['code'][0]);?>
                                    <tr class="row-3">
                                        <td><?php echo $lv3['code'];?></td>
                                        <td><?php echo $lv3['name'];?></td>
                                        <td></td>
                                        <td></td>
                                        <td class="text-right">
                                            <?php echo number_format($total,2,'.',',');?>
                                        </td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <?php $lev4 = $this->crud_model->getLevelsDownBalance($lv3['code'], $lv3['level']);
                                        // log_message("error", "Lev 4 Code: ".$lv3['code'].", Lev 4 Level: ".$lv3['level']."--------------------------------------");
                                        foreach($lev4->result_array() as $lv4):
                                            $total = $this->crud_model->getTotalLevelUpBalance($initial, $final, $lv4['code'], $lv4['level'], $lv4['code'][0]);?>
                                    <tr class="row-4">
                                        <td><?php echo $lv4['code'];?></td>
                                        <td><?php echo $lv4['name'];?></td>
                                        <td></td>
                                        <td class="text-right">
                                            <?php echo number_format($total,2,'.',',');?>
                                        </td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <?php $lev5 = $this->crud_model->getLevelsDownBalance($lv4['code'], $lv4['level']);
                                        // log_message("error", "Lev 5 Code: ".$lv4['code'].", Lev 5 Level: ".$lv4['level']."--------------------------------------");
                                        foreach($lev5->result_array() as $lv5):
                                            $total = $this->crud_model->getTotalYearNom($lv5['nomenclature_id'], $initial, $final, $lv5['code'][0]);?>
                                    <tr class="row-5">
                                        <td><?php echo $lv5['code'];?></td>
                                        <td><?php echo $lv5['name'];?></td>
                                        <td class="text-right">
                                            <?php echo number_format($total,2,'.',',');?>
                                        </td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <?php endforeach; endforeach; endforeach; endforeach;?>
                                    <tr>
                                        <td></td>
                                        <td><b>SUMA DEL CAPITAL</b></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td class="text-right">
                                            <div style="border-top: 2px !important; border-bottom: 2px !important; border-collapse: collapse !important;"><b><?php echo number_format($capital,2,'.',',');?></b></div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-lg-12 mb-3">
                            <div class="form-group">
                                <label class="col-form-label">CERTIFICA:</label>
                                <textarea rows="5" cols="" class="form-control" name="description" id="description"></textarea>
                                <small class="text-danger" id="msgDescription"></small>
                            </div>
                        </div>
                        <div class="col-lg-12 mt-3">
                            <input type="button" class="btn btn-danger" value="PDF" onclick="submitFormType('PDF')" />
                            &nbsp;&nbsp;
                            <input type="button" class="btn btn-success" value="Excel" onclick="submitFormType('EXCEL')" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <form method="post" action="<?php echo base_url();?>staff/printFormType/general/" id="frmG" target="">
            <input type="hidden" name="initial" id="initial_hidden" value="<?php echo $initial;?>" />
            <input type="hidden" name="final" id="final_hidden" value="<?php echo $final;?>" />
            <input type="hidden" name="description" id="description_hidden" value="" />
            <input type="hidden" name="legal_name" id="legal_name_hidden" />
            <input type="hidden" name="legal_charge" id="legal_charge_hidden" value="Representante legal" />
            <input type="hidden" name="account_name" id="account_name_hidden" />
            <input type="hidden" name="account_charge" id="account_charge_hidden" value="Contador" />
            <input type="hidden" name="type" id="type" value="" />
        </form>
    </div>
</div>
<script type="text/javascript">
    function submitFormType(type) {
        $("#type").val(type);
        if (type == "PDF") $("#frmG").attr("target", "_blank");
        else $("#frmG").attr("target", '');
        validateForm();
        $("#frmG").submit();
    }
    
    function validateForm() {
        var initial = $("#initial").val();
        var final = $("#final").val();
        var description = $("#description").val();
        var legal_name = $("#legal_name").val();
        var legal_charge = $("#legal_charge").val();
        var account_name = $("#account_name").val();
        var account_charge = $("#account_charge").val();

        if (initial == '' || final == '') $("#msgDates").text("La fecha inicial o final está vacía.");
        if (description == '') $("#msgDescription").text("Ingrese una descripción.");
        if (legal_name == '') $("#msgLegalName").text("Ingrese un nombre.");
        if (legal_charge == '') $("#msgLegalCharge").text("Ingrese un cargo.");
        if (account_name == '') $("#msgAccountName").text("Ingrese un nombre.");
        if (account_charge == '') $("#msgAccountCharge").text("Ingrese un cargo.");
    }
    
    $("#description").on("change keyup paste", function () {
        var desc = $(this).val();
        if (desc != '') $("#msgDescription").text('');
        else $("#msgDescription").text("Ingrese una descripción.");
        $("#description_hidden").val(desc);
    });

    $("#legal_name").on("input", function () {
        var name = $(this).val();
        $("#legal_name_hidden").val(name);
    });

    $("#legal_charge").on("input", function () {
        var charge = $(this).val();
        if (charge != '') $("#msgLegalCharge").text('');
        else $("#msgLegalCharge").text("Ingrese un cargo.");
        $("#legal_charge_hidden").val(charge);
    });
    
    $("#account_name").on("input", function () {
        var name = $(this).val();
        $("#account_name_hidden").val(name);
    });

    $("#account_charge").on("input", function () {
        var charge = $(this).val();
        if (charge != '') $("#msgAccountCharge").text('');
        else $("#msgAccountCharge").text("Ingrese un cargo.");
        $("#account_charge_hidden").val(charge);
    });
    
    $(document).ready(function () {
        $(".btn-group .focus-btn-group").hide();
        <?php for ($i=1; $i <= 5; $i++):?>
        initialChecked(<?php echo $i;?>, <?php if(in_array($i, $checks)) echo "true"; else echo "false";?>);
        <?php endfor;?>
    });

    function submitFormType(type) {
        $("#type").val(type);
        if (type == "PDF") $("#frmS").attr("target", "_blank");
        else $("#frmS").attr("target", '');
        $("#frmS").submit();
    }

    function initialChecked(i, checked) {
        $("#check-move-"+i).prop("checked", checked);
        if (checked) $(".row-"+i).show();
        else $(".row-"+i).hide();
    }

    function colHideAjax(check, i) {
        checked = $(check).prop("checked");
        if (checked) $(".row-"+i).show();
        else $(".row-"+i).hide();
        setArrayValues();
    }

    function setArrayValues() {
        var vals = [];
        $("input[name='checks_columns[]']").each(function () {
            var val = this.value;
            if ($(this).is(":checked")) {
                vals.push(val);
            }
        });
        $.ajax({
            type: "POST",
            url: "<?php echo base_url();?>staff/setChecksGeneral/",
            data: {
                vals: vals,
            },
            dataType: "json",
            beforeSend: function () {},
            success: function (data) {
                console.log(data);
            },
            error: function (e) {
                console.log("Error: ", e);
            }
        });
    }
</script>