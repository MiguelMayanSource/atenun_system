<?php $rubros = $this->crud_model->getNomenclature(); ?>
<script src="<?php echo base_url();?>public/uploads/sweetalert2.all.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="<?php echo base_url();?>public/assets/libs/select2/js/select2.min.js"></script>
<link href="<?php echo base_url();?>public/assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
<style type="text/css">
    .btn-toolbar {
        display: none !important;
    }
</style>
<div id="main-content">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <h4 class="card-title mb-4">Inicio de partida</h4>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3" style="float: right;">
                                <div class="btn-group focus-btn-group">
                                    <a class="btn btn-info" href="<?php echo base_url();?>staff/departures/">
                                        <i class="bx bx-arrow-back"></i> Ir a partidas
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <form class="repeater" action="<?php echo base_url();?>staff/departure/create/" method="POST" enctype="multipart/form-data">
                                <input type="hidden" id="total" name="total" value="" />
                                <div class="row">
                                    <div class="col-lg-12 mb-3">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label for="">Fecha de la partida</label>
                                                    <input type="date" class="form-control" name="date" id="date" value="<?php echo date("Y-m-d");?>" onchange="verifyPeriod()" />
                                                    <small class="text-danger" id="msgDate"></small>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label for="" class="">Área de gastos</label>
                                                    <select class="form-control" name="department_id" id="department_id">
                                                        <option value="">Ninguno</option>
                                                        <?php $deptos = $this->crud_model->getDeptosActive();
                                                            foreach($deptos->result_array() as $dp):?>
                                                        <option value="<?php echo $dp['department_id'];?>" <?php if($dp['department_id'] == 2) echo "selected";?>><?php echo $dp['name'];?></option>
                                                        <?php endforeach;?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-2">
                                                <div class="form-check form-switch form-switch-lg mb-3" dir="ltr">
                                                    <input class="form-check-input" type="checkbox" name="adjust" id="adjust" value="1" />
                                                    <label class="form-check-label" for="adjust">Ajuste</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="iva" id="iva" value="" />
                                    <input type="hidden" name="isr" id="isr" value="" />
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
                                                        <td id="selectNomen_1">
                                                            <div class="input-group">
                                                                <div style="width:80%">
                                                                    <select class="form-control select2-nom" id="nomen_id_1" name="nomen_id[]" onchange="verifyNomen(this.value, 1)" required >
                                                                        <option value="">Seleccionar</option>
                                                                        <?php foreach ($rubros->result_array() as $rb):?>
                                                                        <option value="<?php echo $rb['nomenclature_id'];?>"><?php echo $rb['code'].' '.$rb['name'];?></option>
                                                                        <?php endforeach;?>
                                                                    </select>
                                                                </div>
                                                                <span class="input-group-addon input-group-append" id="divSwitch_1" style="display: none;">
                                                                    <span class="input-group-text">
                                                                        <input type="checkbox" class="check-purchase" id="switch_1" switch="info" onchange="checkPurchase(this, 1)" />
                                                                        <label for="switch_1" data-on-label="" data-off-label="Ver"></label>
                                                                    </span>
                                                                </span>
                                                                <input type="hidden" id="purchase_1" name="purchase[]" value="" />
                                                                <input type="hidden" id="from_id_1" name="from_id[]" value="" />
                                                            </div>
                                                            <small class="text-danger" id="msgNomen_1"></small>
                                                        </td>
                                                        <td>
                                                            <div class="input-group">
                                                                <span class="input-group-addon input-group-prepend">
                                                                    <span class="input-group-text">Q</span>
                                                                </span>
                                                                <input type="number" class="form-control debe" id="debe_1" name="debe[]" value="" step="0.01" min="0" oninput="sumarTotales()" />
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="input-group">
                                                                <span class="input-group-addon input-group-prepend">
                                                                    <span class="input-group-text">Q</span>
                                                                </span>
                                                                <input type="number" class="form-control .haber" id="haber_1" name="haber[]" value="" step="0.01" min="0" oninput="sumarTotales()" />
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div style="display:flex;">
                                                                <div class="">
                                                                    <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" type="button" id="btn_group_1">...</button>
                                                                    <div class="dropdown-menu" aria-labelledby="btn_group_1">
                                                                        <a class="dropdown-item" href="javascript:void(0);" onclick="checkIVASelect(12, 'C', 1)">IVA regimen general - Crédito Fiscal</a>
                                                                        <a class="dropdown-item" href="javascript:void(0);" onclick="checkIVASelect(12, 'D', 1)">IVA regimen general - Débito Fiscal</a>
                                                                        <a class="dropdown-item" href="javascript:void(0);" onclick="checkISRSelect(1, 'G')">ISR Régimen General</a>
                                                                        <a class="dropdown-item" href="javascript:void(0);" onclick="checkRetenSelect('G', 1)">Retención de IVA General</a>
                                                                        <a class="dropdown-item" href="javascript:void(0);" onclick="checkRetenSelect('P', 1)">Retención de IVA Peq. Contribuyente</a>
                                                                        <a class="dropdown-item" href="javascript:void(0);" onclick="checkExeSelect(1)">Exenta del IVA</a>
                                                                    </div>
                                                                </div>
                                                                &nbsp;
                                                                <button class="btn btn-danger" type="button" onclick="deleteParent(1)">x</button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td colspan="3" style="text-align: right;"><span id="msgRubro" class="text-danger"></span></td>
                                                        <td><button class="btn btn-primary" type="button" onclick="addFieldSelect()" id="btnSelect">+<span id="spinnerSelect" class="text-warning"></span></button></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="text-align: right !important;"><b><u>Total:</u></b></td>
                                                        <td class="text-center">
                                                            <b><u><span id="spnDebe"></span></u></b>
                                                            <input type="hidden" name="totalDebe" id="totalDebe" value="0.00" />
                                                            <small id="msgTotalDebe" class="text-danger"></small>
                                                        </td>
                                                        <td class="text-center">
                                                            <b><u><span id="spnHaber"></span></u></b>
                                                            <input type="hidden" name="totalHaber" id="totalHaber" value="0.00" />
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
                                        <textarea rows="3" cols="" class="form-control" name="details" required></textarea>
                                    </div>
                                    <div class="col-lg-12 mt-3" id="tablePurchase" style="display: none;">
                                        <h4 class="card-title">Detalles de facturas</h4>
                                        <div class="table-responsive mb-0">
                                            <table class="table table-bordered mb-0" id="">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th colspan="4" class="text-center">Documento</th>
                                                        <th class="text-center"></th>
                                                        <th class="text-center"></th>
                                                        <th class="text-center">Tipo</th>
                                                        <th colspan="5" class="text-center">Cantidades</th>
                                                        <th></th>
                                                    </tr>
                                                    <tr>
                                                        <th style="min-width: 200px;">Fecha</th>
                                                        <th style="min-width: 200px;">Tipo</th>
                                                        <th style="min-width: 150px;">Serie</th>
                                                        <th style="min-width: 200px;">Numero</th>
                                                        <th style="min-width: 300px;">Proveedor</th>
                                                        <th style="min-width: 200px;">Establecimiento</th>
                                                        <th style="min-width: 200px;" class="text-center">Compra</th>
                                                        <th style="min-width: 200px;">Cantidad Q.</th>
                                                        <th>Regimen</th>
                                                        <th>Excento</th>
                                                        <th style="min-width: 200px;">IVA Q.</th>
                                                        <th style="min-width: 200px;">ISR Q.</th>
                                                        <th style=""></th>
                                                    </tr>
                                                </thead>
                                                <tbody id="rowsPurchase"></tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th colspan="12"></th>
                                                        <th><input type="button" id="btnPurchase" class="btn btn-primary" value="+" onclick="addDataPurchase()" /></th>
                                                    </tr>
                                                    <tr>
                                                        <th colspan="6"></th>
                                                        <th style="text-align: right;">Totales:</th>
                                                        <th>
                                                            Q.<span id="spnTotCant">-</span>
                                                            <input type="hidden" name="totCant" id="totCant" value="" />
                                                        </th>
                                                        <th></th>
                                                        <th></th>
                                                        <th>
                                                            Q.<span id="spnTotIVA">-</span>
                                                            <input type="hidden" name="totIVA" id="totIVA" value="" />
                                                        </th>
                                                        <th>
                                                            Q.<span id="spnTotISR">-</span>
                                                            <input type="hidden" name="totISR" id="totISR" value="" />
                                                        </th>
                                                        <th></th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 mt-3">
                                        <input type="submit" class="btn btn-success mt-lg-0" id="saveDeparture" value="Guardar"/>
                                    </div>
                                    <small class="text-danger" id="msgVerifyData"></small>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    var addHdg = false;
    var addPur = false;
    var cont = 2;
    var purCont = 1;
    var res = 0;
    var equalDH = false;
    var totalDH = false;
    var rowsDH = false;
    var purchase = true;
    var num_doc = true;
    var period = true;

    $(document).ready(function () {
        verifyPeriod();
    });

    $('.select2-nom').select2({
        placeholder: "Escribe el código de algún rubro",
    });

    function verifyNomen(id, i) {
        var ids = $("[name='nomen_id[]']").map(function(){
            return this.value;
        }).get();
        var compras = $("[name='purchase[]']").map(function(){
            return this.value;
        }).get();
        if (id != '' && id != 25 && id != 58 && $("#rowIVA_"+i).length <= 0) {
            $("#btn_group_"+i).show(500);
        }
        if (id != '') {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url();?>staff/nomenByIDJson",
                data: {
                    id: id
                },
                dataType: "json",
                beforeSend: function () {},
                success: function (data) {
                    console.log(data);
                    if (data.purchase == 1) {
                        var dataPurchase = data.purchase;
                        var total = Number($("#total").val());
                        $.ajax({
                            type: "POST",
                            url: "<?php echo base_url();?>staff/inputsPurchase/",
                            data: {
                                cont: purCont,
                                index: i,
                                name: data.name,
                                total: total,
                            },
                            dataType: "json",
                            beforeSend: function () {},
                            success: function (data) {
                                $("#divSwitch_"+i).show(300);
                                $("#rowsPurchase").append(data.inputs);
                                $("#purchase_"+i).val(dataPurchase);
                                cantPartial(purCont);
                                purCont++;
                                verifyPurchase();
                            },
                            error: function (e) {
                                console.log("Error: ", e);
                                $("#msgNomen_"+i).text("Error al agregar los campos de compras");
                            }
                        });
                    }
                },
                error: function (e) {
                    console.log("Error: ", e);
                    $("#msgNomen_"+i).text("Error al buscar");
                }
            });
        }
        sumarTotales();
    }

    function addFieldSelect() {
        if (addHdg == false) {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url();?>staff/addFieldSelect/",
                data: {
                    cont: cont,
                },
                dataType: "json",
                beforeSend: function (){
                    $("#btnSelect").prop("disabled", true);
                    $("#btnSelect").addClass("spinner-border");
                    addHdg = true;
                },
                success: function (data) {
                    console.log(data)
                    $("#btnSelect").prop("disabled", false);
                    $("#btnSelect").removeClass("spinner-border");
                    $("#msgRubro").text('');
                    $("#rowInputs").append(data.field);
                    cont++;
                    addHdg = false;
                    sumarTotales();
                },
                error: function (e) {
                    $("#btnSelect").prop("disabled", false);
                    $("#btnSelect").removeClass("spinner-border");
                    $("#msgRubro").text("Error al agregar");
                    console.log("Error: ", e);
                    addHdg = false;
                }
            });
        }
    }

    function checkIVASelect(por, nom, i) {
        var cant = 0; var sin_iva = 0; var iva = 0; var isr = 0; var reten = 0; 
        var desc = ''; var id = 0; var res = 0; var isr_cant = 0; var reten_cant = 0; 
        var nom_id = $("#nomen_id_"+i).val();
        if (nom_id != '') {
            $("#msgNomen_"+i).text('');
            var divIVA = $("#rowIVA_"+i).length;
            var divISR = $("#rowISR_"+i).length;
            var divReten = $("#rowReten_"+i).length;
            var debe = $("#debe_"+i).val();
            var haber = $("#haber_"+i).val();
            if (debe != '') cant = parseFloat(debe);
            else if (haber != '') cant = parseFloat(haber);
            if (divIVA > 0) {
                var debeIVA = $("#debeIVA_"+i).val();
                var haberIVA = $("#haberIVA_"+i).val();
                if (debeIVA != '') cant += parseFloat(debeIVA);
                else if (haberIVA != '') cant += parseFloat(haberIVA);
            }
            if (divISR > 0) {
                var debeISR = $("#debeISR_"+i).val();
                var haberISR = $("#haberISR_"+i).val();
                if (debeISR != '') cant += parseFloat(debeISR);
                else if (haberISR != '') cant += parseFloat(haberISR);
            }
            if (divReten > 0) {
                var debeReten = $("#debeReten_"+i).val();
                var haberReten = $("#haberReten_"+i).val();
                if (debeReten != '') cant += parseFloat(debeReten);
                else if (haberReten != '') cant += parseFloat(haberReten);
            }
            if (por == 5) {
                desc = 'P';
                iva = parseFloat(cant) * (por / 100);
                sin_iva = parseFloat(cant) - iva;
            } else if (por == 12) {
                desc = 'G';
                sin_iva = parseFloat(cant) / 1.12;
                iva = sin_iva * (por / 100);
            }
            if (sin_iva > 30000) isr = sin_iva * 0.07;
            else if (sin_iva > 0 && sin_iva <= 30000) isr = sin_iva * 0.05;
            reten = iva * 0.15;
            if (divISR > 0) {
                isr_cant = isr;
                if (nom == 'C') $("#debeISR_"+i).val(isr.toFixed(2));
                if (nom == 'D') $("#haberISR_"+i).val(isr.toFixed(2));
            }
            if (divReten > 0) {
                reten_cant = reten;
                if (nom == 'C') $("#debeIVA_"+i).val(iva.toFixed(2));
                if (nom == 'D') $("#haberIVA_"+i).val(iva.toFixed(2));
            }
            res = sin_iva - isr_cant - reten_cant;
            if (divIVA > 0) {
                if (nom == 'C') {
                    id = 25;
                    $("#debe_"+i).val(res.toFixed(2));
                    $("#debeIVA_"+i).val(iva.toFixed(2));
                    $("#haber_"+i).val('');
                    $("#haberIVA_"+i).val('');
                } else if (nom == 'D') {
                    id = 58;
                    $("#haber_"+i).val(res.toFixed(2));
                    $("#haberIVA_"+i).val(iva.toFixed(2));
                    $("#debe_"+i).val('');
                    $("#debeIVA_"+i).val('');
                }
                $("#from_id_IVA_"+i).val(nom_id);
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url();?>staff/nomenByIDJson",
                    data: {
                        id: id,
                    },
                    dataType: "json",
                    beforeSend: function () {},
                    success: function (data) {
                        console.log(data);
                        $("#msgNomenIVA_"+i).text('');
                        $("#nomen_id_IVA_"+i).val(data.nomenclature_id);
                        $("#nameIVA_"+i).text(data.code+' '+data.name);
                    },
                    error: function (e) {
                        console.log("Error: ", e);
                        $("#msgNomenIVA_"+i).text("Error al cambiar");
                    }
                });
            } else {
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url();?>staff/addIVASelect/",
                    data: {
                        nomen: nom,
                        reg: desc,
                        index: i,
                        cont: cont,
                        cant: cant,
                        iva: iva,
                        res: res,
                        nom_id: nom_id,
                    },
                    dataType: "json",
                    beforeSend: function () {
                        $("#btn_group_"+i).prop("disabled", true);
                        $("#btn_group_"+i).addClass("spinner-border");
                        $("#btnSelect").prop("disabled", true);
                        $("#btnSelect").addClass("spinner-border");
                    },
                    success: function (data) {
                        console.log(data);
                        $("#btn_group_"+i).prop("disabled", false);
                        $("#btn_group_"+i).removeClass("spinner-border");
                        $("#btnSelect").prop("disabled", false);
                        $("#btnSelect").removeClass("spinner-border");
                        $("#msgRubro").text('');
                        $("#rowInputs").append(data.rubro);
                        if (nom == 'C') $("#debe_"+i).val(data.restante);
                        else if (nom == 'D') $("#haber_"+i).val(data.restante);
                        cont++;
                        sumarTotales();
                    },
                    error: function (e){
                        console.log("Error: ", e);
                        $("#btn_group_"+i).prop("disabled", false);
                        $("#btn_group_"+i).removeClass("spinner-border");
                        $("#btnSelect").prop("disabled", false);
                        $("#btnSelect").removeClass("spinner-border");
                        $("#msgNomen_"+i).text("Error al agregar el IVA");
                    }
                });
            }
        } else {
            $("#msgNomen_"+i).text("Debes seleccionar un rubro primero");
        }
        sumarTotales();
    }

    function checkISRSelect(i, reg) {
        var cant = 0; var sin_iva = 0; var iva = 0; var isr = 0; var reten = 0; var iva_cant = 0; var reten_cant = 0; var res = 0; var parte = 0;
        var nom_id = $("#nomen_id_"+i).val();
        if (nom_id != '') {
            $("#msgNomen_"+i).text('');
            var divISR = $("#rowISR_"+i).length;
            var divIVA = $("#rowIVA_"+i).length;
            var divReten = $("#rowReten_"+i).length;
            var debe = $("#debe_"+i).val();
            var haber = $("#haber_"+i).val();
            if (debe != '') {
                cant = parseFloat(debe);
                parte = 0;
            }
            else if (haber != '') {
                cant = parseFloat(haber);
                parte = 1;
            }
            if (divISR > 0) {
                var debeISR = $("#debeISR_"+i).val();
                var haberISR = $("#haberISR_"+i).val();
                if (debeISR != '') cant += parseFloat(debeISR);
                else if (haberISR != '') cant += parseFloat(haberISR);
            }
            if (divIVA > 0) {
                var debeIVA = $("#debeIVA_"+i).val();
                var haberIVA = $("#haberIVA_"+i).val();
                if (debeIVA != '') cant += parseFloat(debeIVA);
                else if (haberIVA != '') cant += parseFloat(haberIVA);
            }
            if (divReten > 0) {
                var debeReten = $("#debeReten_"+i).val();
                var haberReten = $("#haberReten_"+i).val();
                if (debeReten != '') cant += parseFloat(debeReten);
                else if (haberReten != '') cant += parseFloat(haberReten);
            }
            if (reg == 'G') {
                sin_iva = cant / 1.12;
                iva = sin_iva * 0.12;
            } else if (reg == 'P') {
                iva = cant * 0.05;
                sin_iva = cant - iva;
            }
            if (sin_iva > 30000) isr = sin_iva * 0.07;
            else if (sin_iva > 0 && sin_iva <= 30000) isr = sin_iva * 0.05;
            reten = iva * 0.15;
            if (divIVA > 0) {
                iva_cant = iva;
                if (debe != '') $("#debeIVA_"+i).val(iva.toFixed(2));
                else if (haber != '') $("#haberIVA_"+i).val(iva.toFixed(2));
            }
            if (divReten > 0) {
                reten_cant = reten;
                if (debe != '') $("#debeIVA_"+i).val(iva.toFixed(2));
                else if (haber != '') $("#haberIVA_"+i).val(iva.toFixed(2));
            }
            res = cant - iva_cant - isr - reten_cant;
            if (divISR <= 0) {
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url();?>staff/addISRSelect/",
                    data: {
                        idx: i,
                        cant: cant,
                        cont: cont,
                        isr: isr,
                        res: res,
                        parte: parte,
                        nom_id: nom_id,
                    },
                    dataType: "json",
                    beforeSend: function () {
                        $("#btn_group_"+i).prop("disabled", true);
                        $("#btn_group_"+i).addClass("spinner-border");
                        $("#btnSelect").prop("disabled", true);
                        $("#btnSelect").addClass("spinner-border");
                    },
                    success: function (data) {
                        console.log(data);
                        cont++;
                        $("#btn_group_"+i).prop("disabled", false);
                        $("#btn_group_"+i).removeClass("spinner-border");
                        $("#btnSelect").prop("disabled", false);
                        $("#btnSelect").removeClass("spinner-border");
                        $("#msgRubro").text('');
                        $("#rowInputs").append(data.rubro);
                        if (debe != '') $("#debe_"+i).val(data.restante);
                        if (haber != '') $("#haber_"+i).val(data.restante);
                        sumarTotales();
                    },
                    error: function (e) {
                        console.log("Error: ", e);
                        $("#btn_group_"+i).prop("disabled", false);
                        $("#btn_group_"+i).removeClass("spinner-border");
                        $("#btnSelect").prop("disabled", false);
                        $("#btnSelect").removeClass("spinner-border");
                        $("#msgNomen_"+i).text("Error al agregar el rubro del ISR");
                    }
                });
            } else {
                if (debe != '') {
                    $("#debe_"+i).val(res.toFixed(2));
                    $("#debeISR_"+i).val(isr.toFixed(2));
                } else if (haber != '') {
                    $("#haber_"+i).val(res.toFixed(2));
                    $("#haberISR_"+i).val(isr.toFixed(2));
                }
                $("#from_id_ISR_"+i).val(nom_id);
                sumarTotales();
            }
        } else {
            $("#msgNomen_"+i).text("Debes seleccionar un rubro primero");
        }
    }

    function checkRetenSelect(reg, i) {
        var cant = 0; var sin_iva = 0; var iva = 0; var isr = 0; var reten = 0; var iva_cant = 0; var isr_cant = 0; var res = 0; var parte = 0;
        var nom_id = $("#nomen_id_"+i).val();
        if (nom_id != '') {
            $("#msgNomen_"+i).text('');
            var divReten = $("#rowReten_"+i).length;
            var divIVA = $("#rowIVA_"+i).length;
            var divISR = $("#rowISR_"+i).length;
            var debe = $("#debe_"+i).val();
            var haber = $("#haber_"+i).val();
            if (debe != '') {
                cant = parseFloat(debe);
                parte = 0;
            }
            else if (haber != '') {
                cant = parseFloat(haber);
                parte = 1;
            }
            if (divReten > 0) {
                var debeReten = $("#debeReten_"+i).val();
                var haberReten = $("#haberReten_"+i).val();
                if (debeReten != '') cant += parseFloat(debeReten);
                else if (haberReten != '') cant += parseFloat(haberReten);
            }
            if (divIVA > 0) {
                var debeIVA = $("#debeIVA_"+i).val();
                var haberIVA = $("#haberIVA_"+i).val();
                if (debeIVA != '') cant += parseFloat(debeIVA);
                else if (haberIVA != '') cant += parseFloat(haberIVA);
            }
            if (divISR > 0) {
                var debeISR = $("#debeISR_"+i).val();
                var haberISR = $("#haberISR_"+i).val();
                if (debeISR != '') cant += parseFloat(debeISR);
                else if (haberISR != '') cant += parseFloat(haberISR);
            }
            if (reg == 'G') {
                sin_iva = cant / 1.12;
                iva = sin_iva * 0.12;
                reten = iva * 0.15;
            } else if (reg == 'P') {
                reten = cant * 0.05;
            }
            if (sin_iva > 0 && sin_iva <= 30000) isr = sin_iva * 0.05;
            else if (sin_iva > 30000) isr = sin_iva * 0.07; 
            if (divIVA > 0) {
                iva_cant = iva;
                if (debe != '') $("#debeIVA_"+i).val(iva.toFixed(2));
                else if (haber != '') $("#haberIVA_"+i).val(iva.toFixed(2));
            }
            if (divISR > 0) {
                isr_cant = isr;
                if (debe != '') $("#debeISR_"+i).val(isr.toFixed(2));
                else if (haber != '') $("#haberISR_"+i).val(isr.toFixed(2));
            }
            res = cant - iva_cant - isr_cant - reten;
            if (divReten <= 0) {
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url();?>staff/addRetenSelect/",
                    data: {
                        idx: i,
                        cant: cant,
                        cont: cont,
                        reten: reten,
                        res: res,
                        parte: parte,
                        nom_id: nom_id,
                    },
                    dataType: "json",
                    beforeSend: function () {
                        $("#btn_group_"+i).prop("disabled", true);
                        $("#btn_group_"+i).addClass("spinner-border");
                        $("#btnSelect").prop("disabled", true);
                        $("#btnSelect").addClass("spinner-border");
                    },
                    success: function (data) {
                        console.log(data);
                        cont++;
                        $("#btn_group_"+i).prop("disabled", false);
                        $("#btn_group_"+i).removeClass("spinner-border");
                        $("#btnSelect").prop("disabled", false);
                        $("#btnSelect").removeClass("spinner-border");
                        $("#msgRubro").text('');
                        $("#rowInputs").append(data.rubro);
                        if (debe != '') $("#debe_"+i).val(data.restante);
                        if (haber != '') $("#haber_"+i).val(data.restante);
                        sumarTotales();
                    },
                    error: function (e) {
                        console.log("Error: ", e);
                        $("#btn_group_"+i).prop("disabled", false);
                        $("#btn_group_"+i).removeClass("spinner-border");
                        $("#btnSelect").prop("disabled", false);
                        $("#btnSelect").removeClass("spinner-border");
                        $("#msgNomen_"+i).text("Error al agregar el rubro de retención");
                    }
                });
            } else {
                if (debe != '') {
                    $("#debe_"+i).val(res.toFixed(2));
                    $("#debeReten_"+i).val(reten.toFixed(2));
                } else if (haber != '') {
                    $("#haber_"+i).val(res.toFixed(2));
                    $("#haberReten_"+i).val(reten.toFixed(2));
                }
                $("#from_id_Reten_"+i).val(nom_id);
                sumarTotales();
            }
        } else {
            $("#msgNomen_"+i).text("Debes seleccionar un rubro primero");
        }
    }

    function checkExeSelect(i) {
        var cant = 0; var sin_iva = 0; var iva = 0; var isr = 0; var reten = 0; var exen = 0; var iva_cant = 0; var isr_cant = 0; var reten_cant = 0; var res = 0; var parte = 0;
        var nom_id = $("#nomen_id_"+i).val();
        if (nom_id != '') {
            $("#msgNomen_"+i).text('');
            var divExe = $("#rowExe_"+i).length;
            var divIVA = $("#rowIVA_"+i).length;
            var divISR = $("#rowISR_"+i).length;
            var divReten = $("#rowReten_"+i).length;
            var debe = $("#debe_"+i).val();
            var haber = $("#haber_"+i).val();
            if (debe != '') {
                cant = parseFloat(debe);
                parte = 0;
            }
            else if (haber != '') {
                cant = parseFloat(haber);
                parte = 1;
            }
            if (divExe > 0) { 
                var debeExe = $("#debeExe_"+i).val();
                var haberExe = $("#haberExe_"+i).val();
                if (debeExe != '') cant += parseFloat(debeExe);
                else if (haberExe != '') cant += parseFloat(haberExe);
            }
            if (divIVA > 0) {
                var debeIVA = $("#debeIVA_"+i).val();
                var haberIVA = $("#haberIVA_"+i).val();
                if (debeIVA != '') cant += parseFloat(debeIVA);
                else if (haberIVA != '') cant += parseFloat(haberIVA);
            }
            if (divISR > 0) {
                var debeISR = $("#debeISR_"+i).val();
                var haberISR = $("#haberISR_"+i).val();
                if (debeISR != '') cant += parseFloat(debeISR);
                else if (haberISR != '') cant += parseFloat(haberISR);
            }
            if (divReten > 0) {
                var debeReten = $("#debeReten_"+i).val();
                var haberReten = $("#haberReten_"+i).val();
                if (debeReten != '') cant += parseFloat(debeReten);
                else if (haberReten != '') cant += parseFloat(haberReten);
            }
            sin_iva = cant / 1.12;
            iva = sin_iva * 0.12;
            exen = iva;
            if (sin_iva > 0 && sin_iva <= 30000) isr = sin_iva * 0.05;
            else if (sin_iva > 30000) isr = sin_iva * 0.07; 
            reten = iva * 0.15;
            if (divIVA > 0) {
                iva_cant = iva;
                if (debe != '') $("#debeIVA_"+i).val(iva.toFixed(2));
                else if (haber != '') $("#haberIVA_"+i).val(iva.toFixed(2));
            }
            if (divISR > 0) {
                isr_cant = isr;
                if (debe != '') $("#debeISR_"+i).val(isr.toFixed(2));
                else if (haber != '') $("#haberISR_"+i).val(isr.toFixed(2));
            }
            if (divReten > 0) {
                reten_cant = reten;
                if (debe != '') $("#debeReten_"+i).val(reten.toFixed(2));
                else if (haber != '') $("#haberReten_"+i).val(reten.toFixed(2));
            }
            res = cant - exen - iva_cant - isr_cant - reten_cant;
            if (divExe > 0) {
                if (debe != '') {
                    $("#debe_"+i).val(res.toFixed(2));
                    $("#debeExen_"+i).val(exen.toFixed(2));
                } else if (haber != '') {
                    $("#haber_"+i).val(res.toFixed(2));
                    $("#haberExen_"+i).val(exen.toFixed(2));
                }
                $("#from_id_Exen_"+i).val(nom_id);
                sumarTotales();
            } else {
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url();?>staff/addExenSelect/",
                    data: {
                        idx: i,
                        cant: cant,
                        cont: cont,
                        exen: exen,
                        res: res,
                        parte: parte,
                        nom_id: nom_id,
                    },
                    dataType: "json",
                    beforeSend: function () {
                        $("#btn_group_"+i).prop("disabled", true);
                        $("#btn_group_"+i).addClass("spinner-border");
                        $("#btnSelect").prop("disabled", true);
                        $("#btnSelect").addClass("spinner-border");
                    },
                    success: function (data) {
                        console.log(data);
                        cont++;
                        $("#btn_group_"+i).prop("disabled", false);
                        $("#btn_group_"+i).removeClass("spinner-border");
                        $("#btnSelect").prop("disabled", false);
                        $("#btnSelect").removeClass("spinner-border");
                        $("#msgRubro").text('');
                        $("#rowInputs").append(data.rubro);
                        if (debe != '') $("#debe_"+i).val(data.restante);
                        if (haber != '') $("#haber_"+i).val(data.restante);
                        sumarTotales();
                    },
                    error: function (e) {
                        console.log("Error: ", e);
                        $("#btn_group_"+i).prop("disabled", false);
                        $("#btn_group_"+i).removeClass("spinner-border");
                        $("#btnSelect").prop("disabled", false);
                        $("#btnSelect").removeClass("spinner-border");
                        $("#msgNomen_"+i).text("Error al agregar el rubro de exención");
                    }
                });
            }
        } else {
            $("#msgNomen_"+i).text("Debes seleccionar un rubro primero");
        }
    }

    function deleteParent(i) {
        $("#rowField_"+i).remove();
        sumarTotales();
    }

    function deleteIVA(i) {
        $("#rowIVA_"+i).remove();
        sumarTotales();
    }

    function deleteISR(i) {
        $("#rowISR_"+i).remove();
        sumarTotales();
    }

    function deleteReten(i) {
        $("#rowReten_"+i).remove();
        sumarTotales();
    }

    function deleteExen(i) {
        $("#rowExen_"+i).remove();
        sumarTotales();
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
            if (filaD[i] != '' && filaH[i] != '') compareDH++;
        }
        verifyPurchase();
        
        var totPur = 0;

        if (totalDebe == totalHaber) {
            equalDH = true;
            $("#total").val(totalDebe.toFixed(2));
            totPur = totalDebe.toFixed(2);
        } else { 
            equalDH = false;
            if (totalDebe > totalHaber) {
                $("#total").val(totalDebe.toFixed(2));
                totPur = totalDebe.toFixed(2);
            } else {
                $("#total").val(totalHaber.toFixed(2));
                totPur = totalHaber.toFixed(2);
            }
        }
        
        console.log("Purchase length:", $('input[name="cont_purchase[]"').length);
        $('input[name="cont_purchase[]"').each(function() {
            var ixp = $(this).val();
            $("#cant_"+ixp).val(totPur);
            cantPartial(ixp);
        });

        if (totalDebe == total && totalHaber == total) totalDH = true;
        else totalDH = false;

        if (compareDH > 0) rowsDH = false;
        else rowsDH = true;

        $("#spnDebe").text("Q."+totalDebe.toFixed(2));
        $("#totalDebe").val(totalDebe.toFixed(2));
        $("#spnHaber").text("Q."+totalHaber.toFixed(2));
        $("#totalHaber").val(totalHaber.toFixed(2));

        verifyData();
    }

    function addDataPurchase() {
        if (!addPur) {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url();?>staff/inputsPurchase/",
                data: {
                    cont: purCont,
                },
                dataType: "json",
                beforeSend: function () {
                    addPur = true;
                    $("#btnPurchase").prop("disabled", true);
                    $("#btnPurchase").addClass("spinner-border");
                },
                success: function (data) {
                    console.log(data);
                    $("#rowsPurchase").append(data.inputs);
                    purCont++;
                    addPur = false;
                    $("#btnPurchase").prop("disabled", false);
                    $("#btnPurchase").removeClass("spinner-border");
                    verifyPurchase();
                },
                error: function (e) {
                    console.log("Error: ", e);
                    addPur = false;
                    $("#btnPurchase").prop("disabled", false);
                    $("#btnPurchase").removeClass("spinner-border");
                    $("#msgNomen_"+i).text("Error al agregar los campos de compras");
                }
            });
        }
    }

    function removePurchase(i) {
        $("#dataPurchase_"+i).remove();
        sumPartial();
        verifyPurchase();
    }
    
    function cantPartial(i) {
        var sin_iva = 0; var iva = 0; var isr = 0; var reg = '';
        var rowsISR = $(".select2-isr").length;
        var cant = $("#cant_"+i).val();
        if (cant == '') cant = 0;
        sin_iva = parseFloat(cant);
        if ($("#check_regime_"+i).is(":checked")) reg = 'G'; 
        else reg = 'P';
        if (reg == 'G') {
            sin_iva = parseFloat(cant) / 1.12;
            iva = sin_iva * (12 / 100);
            if (rowsISR > 0) {
                if (parseFloat(sin_iva) > 2800 && parseFloat(sin_iva) <= 30000) isr = parseFloat(sin_iva) * 0.05;
                else if (parseFloat(sin_iva) > 30000) isr = parseFloat(sin_iva) * 0.07;
            }
        } else if (reg == 'P') {
            iva = 0;
            isr = 0;
        }
        $("#regime_"+i).val(reg);
        if ($("#check_exempt_"+i).is(":checked")) {
            $("#sin_iva_"+i).val(parseFloat(cant).toFixed(2));
            $("#iva_"+i).val(0.00);
        } else {
            $("#sin_iva_"+i).val(sin_iva.toFixed(2));
            $("#iva_"+i).val(iva.toFixed(2));
        }
        $("#hidden_iva_"+i).val(iva.toFixed(2));
        $("#isr_"+i).val(isr.toFixed(2));
        sumPartial();
    }

    function sumPartial() {
        var totCant = 0; var totIVA = 0; var totISR = 0;
        var cant = $("input[name='cant[]']").map(function(){
            var val = this.value;
            if (val == '') val = 0;
            return val;
        }).get();
        var iva = $("input[name='iva_pur[]']").map(function(){
            var val = this.value;
            if (val == '') val = 0;
            return val;
        }).get();
        var isr = $("input[name='isr_pur[]']").map(function(){
            var val = this.value;
            if (val == '') val = 0;
            return val;
        }).get();
        for (i = 0; i < cant.length; i++) {
            var ct = cant[i];
            var iv = iva[i];
            var is = isr[i];
            totCant += parseFloat(ct);
            totIVA += parseFloat(iv);
            totISR += parseFloat(is);
        }
        $("#spnTotCant").text(totCant.toFixed(2));
        $("#totCant").val(totCant.toFixed(2));
        $("#spnTotIVA").text(totIVA.toFixed(2));
        $("#totIVA").val(totIVA.toFixed(2));
        $("#iva").val(totIVA.toFixed(2));
        $("#spnTotISR").text(totISR.toFixed(2));
        $("#totISR").val(totISR.toFixed(2));
        $("#isr").val(totISR.toFixed(2));
    }

    function checkPurchase(check, i) {
        if (check.checked == true) {
            $("#tablePurchase").show(500);
            $(".check-purchase").prop("checked", true);
        } else {
            $("#tablePurchase").hide(500);
            $(".check-purchase").prop("checked", false);
        }
    }

    function dataProvider(id, i) {
        if (id != '' && id != 'N') {
            $("#dataProvider_"+i).hide(300);
            $.ajax({
                type: "POST",
                url: "<?php echo base_url();?>staff/getProviderJson/",
                data: {
                    id: id,
                },
                dataType: "json",
                beforeSend: function () {},
                success: function (data) {
                    console.log(data);
                    $("#name_"+i).val(data.name);
                    $("#nit_"+i).val(data.nit);
                    verifyPurchase();
                },
                error: function (e) {
                    console.log("Error: ", e);
                    $("#msgNomen_"+c).text("Error al cargar los datos del proveedor");
                }
            });
        } else if (id == 'N') {
            $("#name_"+i).val('');
            $("#nit_"+i).val('');
            $("#dataProvider_"+i).show(300);
            verifyPurchase();
        } else {
            $("#name_"+i).val('');
            $("#nit_"+i).val('');
            $("#dataProvider_"+i).hide(300);
            verifyPurchase();
        }
    }

    function verifyPurchase() {
        var n = 0;
        var compras = $("input[name='purchase[]']").map(function(){
            return this.value;
        }).get();
        if (jQuery.inArray('1', compras) != -1) {
            var cont_pur = $("input[name='cont_purchase[]']").map(function(){
                return this.value;
            }).get();
            for (i = 0; i < cont_pur.length; i++) {
                var inx = cont_pur[i];
                var type = $("#document_type_"+inx).val();
                var serie = $("#serie_"+inx).val();
                var number = $("#number_"+inx).val();
                var name = $("#name_"+inx).val();
                if (type == '' || serie == '' || number == '' || name == '') n++;
            }
            if (n > 0) purchase = false;
            else purchase = true;
        } else {
            purchase = true;
        }
        verifyData();
    }

    function searchNumDoc(i) {
        var number = $("#number_"+i).val();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url();?>staff/countExistPurchase/",
            data: {
                number: number
            },
            dataType: "json",
            beforeSend: function () {
                $("#spnNumber_"+i).text("Buscando...");
            },
            success: function (data) {
                console.log(data);
                $("#val_number_"+i).val(data.count);
                if (data.count <= 0) $("#spnNumber_"+i).text('');
                else $("#spnNumber_"+i).text("Número de documento existente");
                verifyNumDoc();
            },
            error: function (e) {
                console.log("Error: ", e);
                $("#spnNumber_"+i).text("Error al buscar el número de documento");
            }
        });
    }
    
    function verifyNumDoc() {
        var n = 0;
        var compras = $("input[name='purchase[]']").map(function(){
            return this.value;
        }).get();
        if (jQuery.inArray('1', compras) != -1) {
            var cont_pur = $("input[name='cont_purchase[]']").map(function(){
                return this.value;
            }).get();
            $("input[name='val_number[]'").each(function () {
                if (this.value > 0) n++;
            });
            if (n > 0) num_doc = false;
            else num_doc = true;
        } else {
            num_doc = true;
        }
        verifyData();
    }

    function verifyPeriod() {
        var date = $("#date").val();
        if (date != '') {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url();?>staff/verifyPeriod/",
                data: {
                    date: date,
                },
                dataType: "json",
                beforeSend: function () {
                    period = false;
                    verifyData();
                },
                success: function (data) {
                    console.log(data);
                    if (data.results <= 0 || data.check == 1) {
                        period = true;
                        $("#msgDate").text('');
                    }
                    else {
                        period = false;
                        $("#msgDate").text("No puede crear partidas de este periodo");
                    }
                    verifyData();
                },
                error: function (e) {
                    console.log("Error: ", e);
                    period = false;
                    verifyData();
                }
            });
        } else {
            period = false;
        }
    }

    function verifyData() {
        var mensaje = '';
        if (rowsDH && purchase && num_doc && period) {
            $("#saveDeparture").prop("disabled", false);
        } else {
            $("#saveDeparture").prop("disabled", true);
        }

        /* if (equalDH == false) mensaje += 'Los totales del debe y haber no coinciden entre si.<br>';
        if (totalDH == false) mensaje += 'El total del debo o del haber no coinciden con la cantidad total.<br>'; */
        if (rowsDH == false) mensaje += 'Hay por lo menos una cuenta que tiene cantidades tanto en el debe como en el haber.<br>';
        if (purchase == false) mensaje += 'Faltan algunos datos de la compra.<br>'; 
        if (num_doc == false) mensaje += 'Hay números de documentos ya registrados.<br>'; 
        if (period == false) mensaje += 'Se debe registrar con fecha de un periodo diferente.<br>'; 

        if (mensaje.length > 0) {
            $("#msgVerifyData").html(mensaje);
        } else {
            $("#msgVerifyData").html('');
        }
    }
</script>