<?php $grupos = $this->crud_model->getGroupsAccount(); 
    $debit = 0; $credit = 0; $total = 0;?>
<script src="<?php echo base_url();?>public/assets/libs/select2/js/select2.min.js"></script>
<link href="<?php echo base_url();?>public/assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
<div class="row">
    <input type="hidden" name="initial" id="initial" value="<?php echo $initial;?>" />
    <input type="hidden" name="final" id="final" value="<?php echo $final;?>" />
    <div class="col-lg-12">
        <div class="">
            <table class="table table-bordered mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="text-center" style="width: 45%">Cuenta</th>
                        <th class="text-center" style="width: 25%">Debe</th>
                        <th class="text-center" style="width: 25%">Haber</th>
                        <th class="text-center" style="width: 5%"></th>
                    </tr>
                </thead>
                <tbody id="rowInputs">
                    <tr class="" id="rowField_1">
                        <?php $nom = $this->crud_model->getNomenByCode("");
                            $nom_id = $nom['nomenclature_id'];?>
                        <td id="selectNomen_1">
                            <div class="input-group">
                                <div style="width:80%">
                                    <select class="form-control select2-nom" id="nomen_id_1" name="nomen_id[]" onchange="verifyNomen(this.value, 1)">
                                        <option value="">Seleccionar</option>
                                        <?php foreach($grupos->result_array() as $gp):?>
                                            <?php if($gp['hide'] != 1):?>
                                        <option value="<?php echo $gp['group_account_id'];?>"><?php echo $gp['code'].' '.$gp['name'];?></option>
                                        <?php endif; $rubros = $this->crud_model->getNomenByGroup($gp['group_account_id']); 
                                            foreach ($rubros->result_array() as $rb):?>
                                        <option value="<?php echo $rb['nomenclature_id'];?>" <?php if($rb['nomenclature_id'] == $nom_id) echo "selected";?>><?php echo $rb['code'].' '.$rb['name'];?></option>
                                        <?php endforeach; endforeach;?>
                                    </select>
                                </div>
                                <input type="hidden" name="type_nom[]" id="type_nom_1" value="nomenclature" />
                            </div>
                            <small class="text-danger" id="msgNomen_1"></small>
                        </td>
                        <td>
                            <div class="input-group">
                                <span class="input-group-addon input-group-prepend">
                                    <span class="input-group-text">Q</span>
                                </span>
                                <input type="number" class="form-control debe" id="debe_1" name="debe[]" value="<?php echo $total;?>" step="0.01" min="0" oninput="sumarTotales()" />
                            </div>
                        </td>
                        <td>
                            <div class="input-group">
                                <span class="input-group-addon input-group-prepend">
                                    <span class="input-group-text">Q</span>
                                </span>
                                <input type="number" class="form-control haber" id="haber_1" name="haber[]" value="" step="0.01" min="0" oninput="sumarTotales()" />
                            </div>
                        </td>
                        <td>
                            <div style="display:flex;">
                                <button class="btn btn-danger" type="button" onclick="deleteParent(1)">x</button>
                            </div>
                        </td>
                    </tr>
                    <tr class="" id="rowField_2">
                        <?php $nom = $this->crud_model->getNomenByCode("");
                            $nom_id = $nom['nomenclature_id'];?>
                        <td id="selectNomen_2">
                            <div class="input-group">
                                <div style="width:80%">
                                    <select class="form-control select2-nom" id="nomen_id_2" name="nomen_id[]" onchange="verifyNomen(this.value, 1)">
                                        <option value="">Seleccionar</option>
                                        <?php foreach($grupos->result_array() as $gp):?>
                                            <?php if($gp['hide'] != 1):?>
                                        <option value="<?php echo $gp['group_account_id'];?>"><?php echo $gp['code'].' '.$gp['name'];?></option>
                                        <?php endif; $rubros = $this->crud_model->getNomenByGroup($gp['group_account_id']); 
                                            foreach ($rubros->result_array() as $rb):?>
                                        <option value="<?php echo $rb['nomenclature_id'];?>" <?php if($rb['nomenclature_id'] == $nom_id) echo "selected";?>><?php echo $rb['code'].' '.$rb['name'];?></option>
                                        <?php endforeach; endforeach;?>
                                    </select>
                                </div>
                                <input type="hidden" name="type_nom[]" id="type_nom_2" value="nomenclature" />
                            </div>
                            <small class="text-danger" id="msgNomen_2"></small>
                        </td>
                        <td>
                            <div class="input-group">
                                <span class="input-group-addon input-group-prepend">
                                    <span class="input-group-text">Q</span>
                                </span>
                                <input type="number" class="form-control debe" id="debe_2" name="debe[]" value="" step="0.01" min="0" oninput="sumarTotales()" />
                            </div>
                        </td>
                        <td>
                            <div class="input-group">
                                <span class="input-group-addon input-group-prepend">
                                    <span class="input-group-text">Q</span>
                                </span>
                                <input type="number" class="form-control haber" id="haber_2" name="haber[]" value="<?php echo $total;?>" step="0.01" min="0" oninput="sumarTotales()" />
                            </div>
                        </td>
                        <td>
                            <div style="display:flex;">
                                <button class="btn btn-danger" type="button" onclick="deleteParent(2)">x</button>
                            </div>
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <?php if ($debit >= $credit) $total = $debit; else $total = $credit;?>
                    <tr>
                        <input type="hidden" name="total" id="total" value="<?php echo $total;?>"/>
                        <td colspan="3" style="text-align: right;"><span id="msgRubro" class="text-danger"></span></td>
                        <td><button class="btn btn-primary" type="button" onclick="addFieldSelect()" id="btnSelect">+<span id="spinnerSelect" class="text-warning"></span></button></td>
                    </tr>
                    <tr>
                        <td style="text-align: right !important;"><b><u>Total:</u></b></td>
                        <td class="text-center">
                            <b><u><span id="spnDebe"><?php if($debit < 0) echo '-'; echo "Q.".number_format(abs($debit),2,'.',',');?></span></u></b>
                            <input type="hidden" name="totalDebe" id="totalDebe" value="<?php echo $debit;?>" />
                            <small id="msgTotalDebe" class="text-danger"></small>
                        </td>
                        <td class="text-center">
                            <b><u><span id="spnHaber"><?php if($debit < 0) echo '-'; echo "Q.".number_format(abs($credit),2,'.',',');?></span></u></b>
                            <input type="hidden" name="totalHaber" id="totalHaber" value="<?php echo $credit;?>" />
                            <small id="msgTotalHaber" class="text-danger"></small>
                        </td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <div class="col-lg-12 mt-3">
        <label for="">Detalles/comentarios</label>
        <textarea rows="3" cols="" class="form-control" name="details" required>Razón por contabilizar las deprecaciones correspondientes de maquinaria</textarea>
    </div>
    <div class="col-lg-6 mt-2">
        <div class="form-group">
            <input type="submit" class="btn btn-success mt-lg-0" id="saveDeparture" value="Guardar"/>
        </div>
        <small class="text-danger" id="msgVerifyData"></small>
    </div>
</div>
<script type="text/javascript">
    var cont = 5;
    var addNom = false;
    var rowsDH = true;
    
    $('.select2-nom').select2({
        placeholder: "Escribe el código de algún rubro",
    });

    function verifyNomen(id, i) {
        var type = '';
        var text = $("#nomen_id_"+i+" option:selected").text();
        var arrText = text.split(' ');
        var code = arrText[0];
        var arrCode = code.split('.');
        var len = arrCode.length;
        if (len == 4) type = "nomenclature";
        else if (len == 3) type = "group_account";
        else if (len == 2) type = "heading";
        else if (len == 1) type = "heading_type";
        $("#type_nom_"+i).val(type);
    }
    
    function addFieldSelect() {
        if (addNom == false) {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url();?>admin/addFieldSelectClose/",
                data: {
                    cont: cont,
                },
                dataType: "json",
                beforeSend: function (){
                    $("#btnSelect").prop("disabled", true);
                    $("#btnSelect").addClass("spinner-border");
                    addNom = true;
                },
                success: function (data) {
                    console.log(data)
                    $("#btnSelect").prop("disabled", false);
                    $("#btnSelect").removeClass("spinner-border");
                    $("#msgRubro").text('');
                    $("#rowInputs").append(data.field);
                    cont++;
                    addNom = false;
                    sumarTotales();
                },
                error: function (e) {
                    $("#btnSelect").prop("disabled", false);
                    $("#btnSelect").removeClass("spinner-border");
                    $("#msgRubro").text("Error al agregar");
                    console.log("Error: ", e);
                    addNom = false;
                }
            });
        }
    }
    
    function sumarTotales() {
        var totalDebe = 0; var totalHaber = 0; var compareDH = 0;
        var total = $("#total").val();
        var debe = $("input[name='debe[]']").map(function(){
            var cantidad = this.value;
            if (cantidad == '') cantidad = 0;
            return parseFloat(cantidad);
        }).get();
        var haber = $("input[name='haber[]']").map(function(){
            var cantidad = this.value;
            if (cantidad == '') cantidad = 0;
            return parseFloat(cantidad);
        }).get();
        var filaD = $("input[name='debe[]']").map(function(){
            return this.value;
        }).get();
        var filaH = $("input[name='haber[]']").map(function(){
            return this.value;
        }).get();
        for (i = 0; i < debe.length; i++) {
            totalDebe += debe[i];
            totalHaber += haber[i];
            if ((filaD[i] != '' && filaH[i] != '') && (filaD[i] == '' && filaH[i] == '')) compareDH++;
        }

        if (totalDebe >= totalHaber) total = totalDebe;
        else total = totalDebe;

        $("#total").val(total.toFixed(2));
        if (compareDH > 0) rowsDH = false;
        else rowsDH = true;

        $("#spnDebe").text("Q."+totalDebe.toFixed(2));
        $("#totalDebe").val(totalDebe.toFixed(2));
        $("#spnHaber").text("Q."+totalHaber.toFixed(2));
        $("#totalHaber").val(totalHaber.toFixed(2));

        verifyData();
    }

    function deleteParent(i) {
        $("#rowField_"+i).remove();
        sumarTotales();
    }

    function verifyData() {
        var mensaje = '';
        if (rowsDH && period) $("#saveDeparture").prop("disabled", false);
        else $("#saveDeparture").prop("disabled", true);
        
        if (rowsDH == false) mensaje += 'Hay por lo menos una cuenta que tiene cantidades tanto en el debe como en el haber.<br>';
        if (period == false) mensaje += 'Se debe registrar con fecha de un periodo diferente.<br>'; 

        if (mensaje.length > 0) $("#msgVerifyData").html(mensaje);
        else $("#msgVerifyData").html('');
    }
</script>
        