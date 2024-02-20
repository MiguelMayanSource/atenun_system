<?php 
    $cuentas = $this->crud_model->getBankAccountsActive();
    $utilidad = $this->crud_model->getUtilityStatement($initial, $final);
    setlocale(LC_TIME,"es_ES");
?>  
<script src="<?php echo base_url();?>public/assets/libs/select2/js/select2.min.js"></script>
<link href="<?php echo base_url();?>public/assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
<style type="text/css">
    .container-justify {
        display: flex;
        justify-content: space-between; /* Can be changed in the live sample */
    }
</style>
<div id="main-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="card-box">
                <div class="card-b">
                    <a class="btn btn-info" style="float: right;" href="<?php echo base_url();?>staff/cash_flows/">
                        <i class="bx bx-arrow-back"></i> Regresar
                    </a>
                    <h4 class="card-title text-center" style="margin-left:6%">FLUJO DE EFECTIVO</h4>
                    <h4 class="card-title text-center" style="margin-left:6%"><?php echo $this->crud_model->getInfo("description");?></h4>
                    <h4 class="card-title text-center"><?php echo $this->crud_model->getInfo("system_name");?></h4>
                    <form action="<?php echo base_url();?>staff/cash_flow/save/" method="POST" id="frmC" target="">
                        <input type="hidden" name="type" id="type" value="" />
                        <div class="row">
                            <div class="col-lg-3"></div>
                            <div class="col-lg-6 mb-3">
                                <div class="form-group">
                                    <div class="input-group">
                                        <input class="form-control" type="date" name="initial" id="initial" value="<?php echo $initial;?>" required>
                                        <input class="form-control" type="date" name="final" id="final" value="<?php echo $final;?>" required>
                                        <button class="btn btn-info" type="button" id="btn_get_utility" onclick="getUtility()">Cargar</button>
                                    </div>
                                    <small class="text-danger" id="msgDate"></small>
                                </div>
                            </div>
                            <div class="col-lg-3"></div>
                            <div class="col-lg-12">
                                <div class="">
                                    <table class="table table-bordered mb-3">
                                        <thead class="">
                                            <tr>
                                                <th class="text-center" style="width: 40%"></th>
                                                <th class="text-center" style="width: 20%"></th>
                                                <th class="text-center" style="width: 20%"></th>
                                                <th class="text-center" style="width: 20%"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Utilidad del Ejercicio</td>
                                                <td></td>
                                                <td></td>
                                                <td style="text-align: right;">
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <span class="input-group-addon input-group-prepend">
                                                                <span class="input-group-text">Q</span>
                                                            </span>
                                                            <input type="number" class="form-control" name="utility" id="utility" value="<?php echo $utilidad;?>" required step="0.01" />
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Cuentas que no originan movimiento de efectivo</td>
                                                <td></td>
                                                <td></td>
                                                <td>
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <span class="input-group-addon input-group-prepend">
                                                                <span class="input-group-text">Q</span>
                                                            </span>
                                                            <input type="number" class="form-control" name="no_moves" id="no_moves" step="0.01" />
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>CONCILIACIÓN ENTRE LA UTILIDAD NETA Y FLUJO DE EFECTIVO PROVISTO POR</td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td id="rowsNoteOperation">
                                                    <span>ACTIVIDADES DE OPERACIÓN</span>
                                                    <input type="button" class="btn btn-primary" style="float: right;" id="btn_add_operation" onclick="addOperation()" value="+" />
                                                    <div id="row_note_operation_1">
                                                        <input type="hidden" name="cont_operation[]" id="cont_operation_1" value="1" />
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" name="note_operation[]" id="note_operation_1" placeholder="Descripción" />
                                                        </div>
                                                    </div>
                                                </td>
                                                <td id="rowsAmountOperation">
                                                    <input type="button" class="btn" style="float: right;" value="" disabled />
                                                    <div id="row_amount_operation_1">
                                                        <div class="form-group">
                                                            <div class="input-group">
                                                                <span class="input-group-addon input-group-prepend">
                                                                    <span class="input-group-text">Q</span>
                                                                </span>
                                                                <input type="number" class="form-control" name="amount_operation[]" id="amount_operation_1" step="0.01" oninput="sumOperation()" value="" required />
                                                                <input type="button" class="btn btn-danger" value="x" onclick="deleteOperation(1)" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td>
                                                    <div class="container-justify">
                                                        <div>Q</div>
                                                        <div><span id="spnSubtOperation">-</span></div>
                                                    </div>
                                                    <input type="hidden" name="subtotal_operation" id="subtotal_operation" value="0.00" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td id="rowsNoteInvest">
                                                    <span>ACTIVIDADES DE INVERSIÓN</span>
                                                    <input type="button" class="btn btn-primary" style="float: right;" id="btn_add_invest" onclick="addInvest()" value="+" />
                                                    <div id="row_note_invest_1">
                                                        <input type="hidden" name="cont_invest[]" id="cont_invest_1" value="1" />
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" name="note_invest[]" id="note_invest_1" placeholder="Descripción" />
                                                        </div>
                                                    </div>
                                                </td>
                                                <td id="rowsAmountInvest">
                                                    <input type="button" class="btn" style="float: right;" value="" disabled />
                                                    <div id="row_amount_invest_1">
                                                        <div class="form-group">
                                                            <div class="input-group">
                                                                <span class="input-group-addon input-group-prepend">
                                                                    <span class="input-group-text">Q</span>
                                                                </span>
                                                                <input type="number" class="form-control" name="amount_invest[]" id="amount_invest_1" step="0.01" oninput="sumInvest()" value="" required />
                                                                <input type="button" class="btn btn-danger" value="x" onclick="deleteInvest(1)" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td>
                                                    <div class="container-justify">
                                                        <div>Q</div>
                                                        <div><span id="spnSubtInvest">-</span></div>
                                                    </div>
                                                    <input type="hidden" name="subtotal_invest" id="subtotal_invest" value="0.00" />
                                                </td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td id="rowsNoteFinance">
                                                    <span>ACTIVIDADES DE FINANCIAMIENTO</span>
                                                    <input type="button" class="btn btn-primary" style="float: right;" id="btn_add_finance" onclick="addFinance()" value="+" />
                                                    <div id="row_note_finance_1">
                                                        <input type="hidden" name="cont_finance[]" id="cont_finance_1" value="1" />
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" name="note_finance[]" id="note_finance_1" placeholder="Descripción" />
                                                        </div>
                                                    </div>
                                                </td>
                                                <td id="rowsAmountFinance">
                                                    <input type="button" class="btn" style="float: right;" value="" disabled />
                                                    <div id="row_amount_finance_1">
                                                        <div class="form-group">
                                                            <div class="input-group">
                                                                <span class="input-group-addon input-group-prepend">
                                                                    <span class="input-group-text">Q</span>
                                                                </span>
                                                                <input type="number" class="form-control" name="amount_finance[]" id="amount_finance_1" step="0.01" oninput="sumFinance()" value="" required />
                                                                <input type="button" class="btn btn-danger" value="x" onclick="deleteFinance(1)" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td>
                                                    <div class="container-justify">
                                                        <div>Q</div>
                                                        <div><span id="spnSubtFinance">-</span></div>
                                                    </div>
                                                    <input type="hidden" name="subtotal_finance" id="subtotal_finance" value="0.00" />
                                                </td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td>
                                                    <div class="container-justify">
                                                        <div>Q</div>
                                                        <div><span id="spnTotalActivities">-</span></div>
                                                    </div>
                                                    <input type="hidden" name="total_activities" id="total_activities" value="0.00" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="form-group">
                                                        <div class="form-check form-switch form-switch-lg mb-3" dir="ltr">
                                                            <input class="form-check-input" type="checkbox" id="check_equals" name="check_equals" value="1" checked />
                                                            <label class="form-check-label" for="check_equals"></label>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            <tr class="equals-amounts">
                                                <td>AUMENTO NETO EN EFECTIVO Y EQUIVALENTES DE EFECTIVO EN EL PERÍODO</td>
                                                <td></td>
                                                <td></td>
                                                <td style="text-align: right;">
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <span class="input-group-addon input-group-prepend">
                                                                <span class="input-group-text">Q</span>
                                                            </span>
                                                            <input type="number" class="form-control" name="increase" id="increase" step="0.01" value="" />
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr class="equals-amounts">
                                                <td>EFECTIVO Y EQUIVALENTES DE EFECTIVO DEL <span id="spanInitial"><?php echo strtoupper(strftime("%d de %B del %Y", strtotime($initial)));?></span></td>
                                                <td></td>
                                                <td></td>
                                                <td style="text-align: right;">
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <span class="input-group-addon input-group-prepend">
                                                                <span class="input-group-text">Q</span>
                                                            </span>
                                                            <input type="number" class="form-control" name="equal_initial" id="equal_initial" step="0.01" value="" oninput="addEquality()" />
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr class="equals-amounts">
                                                <td>EFECTIVO Y EQUIVALENTES DE EFECTIVO AL <span id="spanFinal"><?php echo strtoupper(strftime("%d de %B del %Y", strtotime($final)));?></td>
                                                <td></td>
                                                <td></td>
                                                <td style="text-align: right;">
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <span class="input-group-addon input-group-prepend">
                                                                <span class="input-group-text">Q</span>
                                                            </span>
                                                            <input type="number" class="form-control" name="equal_final" id="equal_final" step="0.01" value="" oninput="addEquality()" />
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-lg-12 mb-3">
                                <div class="form-group">
                                    <textarea rows="5" cols="" class="form-control" name="description" id="description">El infrainscrito contador registrado ante la superintendencia de administración tributaria bajo el número de registro 12345 CERTIFICA que el presente Flujo de Efectivo presenta razonablemente la situación económica de la impresa de conformidad con los Principios de Contabilidad Generalmente aceptados por el periodo dado.</textarea>
                                    <small class="text-danger" id="msgDescription"></small>
                                </div>
                            </div>
                            <div class="col-lg-12 mb-3">
                                <h4 class="card-title text-center"><?php echo $this->crud_model->getInfo("address").' '.strftime("%d de %B del %Y", strtotime($hoy));?></h4>
                            </div>
                            <div class="col-lg-6 mt-3">
                                <div>
                                    <table class="table table-bordered mb-0">
                                        <tr>
                                            <td class="text-center">
                                                <div class="form-group">
                                                    <input type="text" class="form-control text-center" name="legal_name" id="legal_name" value="" placeholder="Nombre" />
                                                    <small class="text-danger" id="msgLegalName"></small>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">
                                                <div class="form-group">
                                                    <input type="text" class="form-control text-center" name="legal_charge" id="legal_charge" value="Representante legal" placeholder="Cargo" />
                                                    <small class="text-danger" id="msgLegalCharge"></small>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="col-lg-6 mt-3">
                                <div>
                                    <table class="table table-bordered mb-0">
                                        <tr>
                                            <td class="text-center">
                                                <div class="form-group">
                                                    <input type="text" class="form-control text-center" name="account_name" id="account_name" value="" placeholder="Nombre" />
                                                    <small class="text-danger" id="msgAccountName"></small>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">
                                                <div class="form-group">
                                                    <input type="text" class="form-control text-center" name="account_charge" id="account_charge" value="Contador@" placeholder="Cargo" />
                                                    <small class="text-danger" id="msgAccountCharge"></small>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="col-lg-12 mt-3">
                                <!-- <input type="button" class="btn btn-danger" value="PDF" onclick="submitForm('PDF')" />
                                &nbsp;&nbsp;
                                <input type="button" class="btn btn-success" value="Excel" onclick="submitForm('EXCEL')" /> -->
                                <input type="submit" class="btn btn-success" value="Guardar">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    var conOp = 2;
    var conIn = 2;
    var conFn = 2;

    function getUtility() {
        var initial = $("#initial").val();
        var final = $("#final").val();
        if (initial != '' && final != '') {
            $.ajax({
                type: "POST",
                url: "<?php  echo base_url();?>staff/getUtilityStatement/",
                data: {
                    initial: initial,
                    final: final,
                },
                dataType: "json",
                beforeSend: function () {
                    $("#btn_get_utility").prop("disabled", true);
                },
                success: function (data) {
                    console.log(data);
                    $("#utility").val(data.amount);
                    $("#spanInitial").text(data.initial);
                    $("#spanFinal").text(data.final);
                    $("#btn_get_utility").prop("disabled", false);
                },
                error: function (e) {
                    console.log("Error: ", e);
                    $("#msgDate").text("Error al obtener la utilidad del ejercicio");
                    $("#btn_get_utility").prop("disabled", false);
                }
            });
        } else {
            $("#msgDate").text("La fecha inicial y final no deben estar vacíos");
        }
    }

    function addOperation() {
        var note = '<div id="row_note_operation_'+conOp+'"><input type="hidden" name="cont_operation[]" id="cont_operation_'+conOp+'" value="'+conOp+'" /><div class="form-group"><input type="text" class="form-control" name="note_operation[]" id="note_operation_'+conOp+'" placeholder="Descripción" /></div></div>';
        var amount = '<div id="row_amount_operation_'+conOp+'"><div class="form-group"><div class="input-group"><span class="input-group-addon input-group-prepend"><span class="input-group-text">Q</span></span><input type="number" class="form-control" name="amount_operation[]" id="amount_operation_'+conOp+'" step="0.01" oninput="sumOperation()" value="" required /><input type="button" class="btn btn-danger" value="x" onclick="deleteOperation('+conOp+')" /></div></div></div>';
        $("#rowsNoteOperation").append(note);
        $("#rowsAmountOperation").append(amount);
        conOp++;
    }

    function deleteOperation(i) {
        $("#row_note_operation_"+i).remove();
        $("#row_amount_operation_"+i).remove();
        sumOperation();
    }

    function sumOperation() {
        var totalAmount = 0;
        var amount = $("input[name='amount_operation[]']").map(function () {
            var value = this.value;
            if (value == '') value = 0;
            return value;
        });
        for (var i = 0; i < amount.length; i++) {
            totalAmount += parseFloat(amount[i]);
        }
        $("#spnSubtOperation").text(totalAmount.toFixed(2));
        $("#subtotal_operation").val(totalAmount.toFixed(2));
        sumActivities();
    }

    function addInvest() {
        var note = '<div id="row_note_invest_'+conIn+'"><input type="hidden" name="cont_invest[]" id="cont_invest_'+conIn+'" value="'+conIn+'" /><div class="form-group"><input type="text" class="form-control" name="note_invest[]" id="note_invest_'+conIn+'" placeholder="Descripción" /></div></div>';
        var amount = '<div id="row_amount_invest_'+conIn+'"><div class="form-group"><div class="input-group"><span class="input-group-addon input-group-prepend"><span class="input-group-text">Q</span></span><input type="number" class="form-control" name="amount_invest[]" id="amount_invest_'+conIn+'" step="0.01" oninput="sumInvest()" value="" required /><input type="button" class="btn btn-danger" value="x" onclick="deleteInvest('+conIn+')" /></div></div></div>';
        $("#rowsNoteInvest").append(note);
        $("#rowsAmountInvest").append(amount);
        conIn++;
        console.log("Contador de inversión: " + conIn);
    }

    function deleteInvest(i) {
        $("#row_note_invest_"+i).remove();
        $("#row_amount_invest_"+i).remove();
        sumInvest();
    }

    function sumInvest() {
        var totalAmount = 0;
        var amount = $("input[name='amount_invest[]']").map(function () {
            var value = this.value;
            if (value == '') value = 0;
            return value;
        });
        for (var i = 0; i < amount.length; i++) {
            totalAmount += parseFloat(amount[i]);
        }
        $("#spnSubtInvest").text(totalAmount.toFixed(2));
        $("#subtotal_invest").val(totalAmount.toFixed(2));
        sumActivities();
    }

    function addFinance() {
        var note = '<div id="row_note_finance_'+conIn+'"><input type="hidden" name="cont_finance[]" id="cont_finance_'+conIn+'" value="'+conIn+'" /><div class="form-group"><input type="text" class="form-control" name="note_finance[]" id="note_finance_'+conIn+'" placeholder="Descripción" /></div></div>';
        var amount = '<div id="row_amount_finance_'+conIn+'"><div class="form-group"><div class="input-group"><span class="input-group-addon input-group-prepend"><span class="input-group-text">Q</span></span><input type="number" class="form-control" name="amount_finance[]" id="amount_finance_'+conIn+'" step="0.01" oninput="sumFinance()" value="" required /><input type="button" class="btn btn-danger" value="x" onclick="deleteFinance('+conIn+')" /></div></div></div>';
        $("#rowsNoteFinance").append(note);
        $("#rowsAmountFinance").append(amount);
        conIn++;
        console.log("Contador de inversión: " + conIn);
    }

    function deleteFinance(i) {
        $("#row_note_finance_"+i).remove();
        $("#row_amount_finance_"+i).remove();
        sumFinance();
    }

    function sumFinance() {
        var totalAmount = 0;
        var amount = $("input[name='amount_finance[]']").map(function () {
            var value = this.value;
            if (value == '') value = 0;
            return value;
        });
        for (var i = 0; i < amount.length; i++) {
            totalAmount += parseFloat(amount[i]);
        }
        $("#spnSubtFinance").text(totalAmount.toFixed(2));
        $("#subtotal_finance").val(totalAmount.toFixed(2));
        sumActivities();
    }

    function sumActivities() {
        var total = 0;
        var operation = $("#subtotal_operation").val();
        if (operation == '') operation = 0;
        var invest = $("#subtotal_invest").val();
        if (invest == '') invest = 0;
        var finance = $("#subtotal_finance").val();
        if (finance == '') finance = 0;
        total = parseFloat(operation) + parseFloat(invest) + parseFloat(finance);
        $("#spnTotalActivities").text(total.toFixed(2));
        $("#total_activities").val(total.toFixed(2));
    }

    $("#check_equals").change(function () { 
        if (this.checked){
            $(".equals-amounts").show(300);
        } else {
            $(".equals-amounts").hide(300);
        }
    });

    function addEquality() {
        var total = 0;
        var initial = $("#equal_initial").val();
        if (initial == '') initial = 0;
        var final = $("#equal_final").val();
        if (final == '') final = 0;
        total = parseFloat(initial) + parseFloat(final);
        $("#increase").val(total.toFixed(2));
    }

    function submitForm(type) {
        $("#type").val(type);
        if(type == 'PDF') $("#frmC").attr("target", "_blank");
        else $("#frmC").attr("target", '');
        $("#frmC").submit();
    }
</script>