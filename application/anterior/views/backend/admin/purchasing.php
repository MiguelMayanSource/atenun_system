<?php $compras = $this->crud_model->getPurchasing($initial, $final, $institution_id.'-'.$camp.'-'.$text);
    $checks = json_decode($this->crud_model->getInfo("checks_purchase"));?>
<link href="<?php echo base_url();?>public/assets/libs/admin-resources/rwd-table/rwd-table.min.css" rel="stylesheet" type="text/css" />
<style type="text/css">
    .btn-toolbar {
        display: none !important;
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
                <a class="add-buton" href="<?php echo base_url();?>admin/accounting/">Regresar</a>
                <a class="add-buton" href="javascript:void(0);" onclick="modal_lg('<?php echo base_url();?>modal/popup/modal_accounting_books/')">Libros contables</a>
            </div>
            <div class="card-box">
                <div class="card-b">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="title-header">
                                <h4 class="card-title">Libro de Compras</h4>
                            </div>
                            <form method="post" action="<?php echo base_url();?>admin/purchasing/" id="frm">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group mb-3">
                                            <label for="">Seleccione un campo</label>
                                            <div class="input-group">
                                                <select name="camp" class="form-control">
                                                    <option value="">Sin filtro</option>
                                                    <option value="number" <?php if($camp == "number") echo "selected";?>>Número de factura</option>
                                                    <option value="nit" <?php if($camp == "nit") echo "selected";?>>NIT del proveedor</option>
                                                    <option value="name" <?php if($camp == "name") echo "selected";?>>Nombre del proveedor</option>
                                                </select>
                                                <input type="text" class="form-control" name="text" value="<?php echo $text?>" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-5 col-md-5 col-sm-5">
                                        <div class="mb-3">
                                            <label for="initial">Fecha inicial:</label>
                                            <input type="date" class="form-control" name="initial" id="initial" value="<?php echo $initial;?>" required />
                                            <small class="text-danger" id="msgInicial"></small>
                                        </div>
                                    </div>
                                    <div class="col-lg-5 col-md-5 col-sm-5">
                                        <div class="mb-3">
                                            <label for="final">Fecha final:</label>
                                            <input type="date" class="form-control" name="final" id="final" value="<?php echo $final;?>" required />
                                            <small class="text-danger" id="msgFinal"></small>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <br> 
                                        <div class="mb-3">
                                            <div class="">
                                                <button class="btn btn-info" type="submit">
                                                    <i class="mdi mdi-eye"></i>
                                                    <span>Ver</span>
                                                </button>
                                                &nbsp;
                                                &nbsp;
                                                <input type="button" class="btn btn-danger" value="PDF" onclick="submitFormType(this.value)" />
                                                &nbsp;
                                                &nbsp;
                                                <input type="button" class="btn btn-success" value="EXCEL" onclick="submitFormType(this.value)" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-lg-4 mb-3" style="">
                            <div class="dropdown dropend" style="">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-expanded="false" area-haspopup="true">
                                    Ocultar columnas <i class="mdi mdi-chevron-right"></i>
                                </button>
                                <div class="dropdown-menu" style="" aria-labelledby="dropdownMenuButton">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="dropdown-item">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="checks_columns[]" id="check-move-1" value="1" onclick="colHideAjax(this, 1)" />
                                                    <label class="form-check-label" for="check-move-1">DOCTO NO</label>
                                                </div>
                                            </div>
                                            <div class="dropdown-item">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="checks_columns[]" id="check-move-2" value="2" onclick="colHideAjax(this, 2)" />
                                                    <label class="form-check-label" for="check-move-2">SERIE</label>
                                                </div>
                                            </div>
                                            <div class="dropdown-item">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="checks_columns[]" id="check-move-3" value="3" onclick="colHideAjax(this, 3)" />
                                                    <label class="form-check-label" for="check-move-3">NUMERO</label>
                                                </div>
                                            </div>
                                            <div class="dropdown-item">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="checks_columns[]" id="check-move-4" value="4" onclick="colHideAjax(this, 4)" />
                                                    <label class="form-check-label" for="check-move-4">FECHA</label>
                                                </div>
                                            </div>
                                            <div class="dropdown-item">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="checks_columns[]" id="check-move-5" value="5" onclick="colHideAjax(this, 5)" />
                                                    <label class="form-check-label" for="check-move-5">TIPO DE DOCUMENTO</label>
                                                </div>
                                            </div>
                                            <div class="dropdown-item">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="checks_columns[]" id="check-move-6" value="6" onclick="colHideAjax(this, 6)" />
                                                    <label class="form-check-label" for="check-move-6">NIT O CEDULA</label>
                                                </div>
                                            </div>
                                            <div class="dropdown-item">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="checks_columns[]" id="check-move-7" value="7" onclick="colHideAjax(this, 7)" />
                                                    <label class="form-check-label" for="check-move-7">PROVEEDOR, VENDEDOR O<br>PRESTADOR DEL SERVICIO</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="dropdown-item">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="checks_columns[]" id="check-move-8" value="8" onclick="colHideAjax(this, 8)" />
                                                    <label class="form-check-label" for="check-move-8">PEQUEÑO CONTRIB.</label>
                                                </div>
                                            </div>
                                            <div class="dropdown-item">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="checks_columns[]" id="check-move-9" value="9" onclick="colHideAjax(this, 9)" />
                                                    <label class="form-check-label" for="check-move-9">COMPRAS COMBUSTIBLE</label>
                                                </div>
                                            </div>
                                            <div class="dropdown-item">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="checks_columns[]" id="check-move-10" value="10" onclick="colHideAjax(this, 10)" />
                                                    <label class="form-check-label" for="check-move-10">COMPRAS PRE. NETO</label>
                                                </div>
                                            </div>
                                            <div class="dropdown-item">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="checks_columns[]" id="check-move-11" value="11" onclick="colHideAjax(this, 11)" />
                                                    <label class="form-check-label" for="check-move-11">SERVICIOS PRE. NETO</label>
                                                </div>
                                            </div>
                                            <div class="dropdown-item">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="checks_columns[]" id="check-move-12" value="12" onclick="colHideAjax(this, 12)" />
                                                    <label class="form-check-label" for="check-move-12">IMPORTACION</label>
                                                </div>
                                            </div>
                                            <div class="dropdown-item">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="checks_columns[]" id="check-move-13" value="13" onclick="colHideAjax(this, 13)" />
                                                    <label class="form-check-label" for="check-move-13">IVA</label>
                                                </div>
                                            </div>
                                            <div class="dropdown-item">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="checks_columns[]" id="check-move-14" value="14" onclick="colHideAjax(this, 14)" />
                                                    <label class="form-check-label" for="check-move-14">EXENTO</label>
                                                </div>
                                            </div>
                                            <div class="dropdown-item">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="checks_columns[]" id="check-move-15" value="15" onclick="colHideAjax(this, 15)" />
                                                    <label class="form-check-label" for="check-move-15">TOTAL</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="table-rep-plugin">
                                <div class="table-responsive mb-0" data-pattern="priority-columns">
                                    <table id="table-companies-1" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th class="column-1">DOCTO</th>
                                                <th rowspan="2" class="column-2">SERIE</th>
                                                <th rowspan="2" class="column-3">NUMERO</th>
                                                <th rowspan="2" class="column-4 text-center">FECHA</th>
                                                <th rowspan="2" class="column-5 text-center">TIPO DE DOCUMENTO</th>
                                                <th rowspan="2" class="column-6 text-center">NIT O<br>CEDULA</th>
                                                <th rowspan="2" class="column-7"></th>
                                                <th rowspan="2" class="column-8 text-center">PEQUEÑO<br>CONTRIB.</th>
                                                <th rowspan="2" class="column-9 text-center">COMPRAS<br>COMBUSTIBLE</th>
                                                <th rowspan="2" class="column-10 text-center">COMPRAS<br>BIENES</th>
                                                <th rowspan="2" class="column-11 text-center">SERVICIOS</th>
                                                <th rowspan="2" class="column-12 text-center">IMPORTACION</th>
                                                <th rowspan="2" class="column-13 text-center">IVA</th>
                                                <th rowspan="2" class="column-14 text-center">EXENTO</th>
                                                <th rowspan="2" class="column-15 text-center">TOTAL</th>
                                            </tr>
                                            <tr>
                                                <th class="column-1 text-center">No</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $totPeq = 0; $totGas = 0; $totCom = 0; $totSer = 0; $totImp = 0; $totIVA = 0; $totExe = 0; $totTotal = 0;
                                                $cont = 0; $n = 1; foreach($compras->result_array() as $cp):
                                                $total = $cp['total']; $amount = $total / 1.12;
                                                $iva = $amount * 0.12; $isr = 0;
                                                if ($amount >= 30000) $isr = $amount * 0.07;
                                                else if ($amount >= 2500) $isr = $amount * 0.05;
                                                $prov = $this->crud_model->getProvidersByID($cp['provider_id']);?>
                                            <tr>
                                                <td class="column-1"><?php echo $n++;?></td>
                                                <td class="column-2"><?php echo $cp['serie'];?></td>
                                                <td class="column-3 text-right"><?php echo $cp['number'];?></td>
                                                <td class="column-4"><?php echo date("d/m/Y", strtotime($cp['date']));?></td>
                                                <td class="column-5"><?php if($cp['document_type'] == "FACT") echo "FC"; elseif($cp['document_type'] == "FCAM") echo "FCAMBIARIA"; elseif($cp['document_type'] == "FACT-P") echo "FCPC"; elseif($cp['document_type'] == '') echo "NC"; else echo "NC";?></td>
                                                <td class="column-6 text-center"><?php echo $cp['nit'];?></td>
                                                <td class="column-7"><?php echo $prov['name'];?></td>
                                                <td class="column-8 text-right"><?php if($cp['status'] == 1 && $cp['regime'] == 'P') echo number_format($amount,2,'.',','); else echo "0.00";?></td>
                                                <td class="column-9 text-right"><?php if($cp['status'] == 1 && $cp['regime'] == 'G' && $cp['type'] == 'G' && $cp['exempt'] == 0) echo number_format($amount,2,'.',','); else echo "0.00";?></td>
                                                <td class="column-10 text-right"><?php if($cp['status'] == 1 && $cp['regime'] == 'G' && $cp['type'] == 'C' && $cp['exempt'] == 0) echo number_format($amount,2,'.',','); else echo "0.00";?></td>
                                                <td class="column-11 text-right"><?php if($cp['status'] == 1 && $cp['regime'] == 'G' && $cp['type'] == 'S' && $cp['exempt'] == 0) echo number_format($amount,2,'.',','); else echo "0.00";?></td>
                                                <td class="column-12 text-right"><?php if($cp['status'] == 1 && $cp['regime'] == 'G' && $cp['type'] == 'I' && $cp['exempt'] == 0) echo number_format($amount,2,'.',','); else echo "0.00";?></td>
                                                <td class="column-13 text-right"><?php if($cp['status'] == 1 && $cp['regime'] == 'G' && $cp['exempt'] == 0) echo number_format($iva,2,".",","); else echo "0.00";?></td>
                                                <td class="column-14 text-right"><?php if($cp['status'] == 1 && $cp['exempt'] == 1) echo number_format($amount,2,'.',','); else echo "0.00";?></td>
                                                <td class="column-15 text-right"><?php if($cp['status'] == 1) echo number_format($cp['total'],2,'.',','); else echo "0.00";?></td>
                                            </tr>
                                            <?php if($cp['status'] == 1) {
                                                if($cp['regime'] == 'P') $totPeq += $amount;
                                                if($cp['regime'] == 'G' && $cp['type'] == 'G' && $cp['exempt'] == 0) $totGas += $amount;
                                                if($cp['regime'] == 'G' && $cp['type'] == 'C' && $cp['exempt'] == 0) $totCom += $amount;
                                                if($cp['regime'] == 'G' && $cp['type'] == 'S' && $cp['exempt'] == 0) $totSer += $amount;
                                                if($cp['regime'] == 'G' && $cp['type'] == 'I' && $cp['exempt'] == 0) $totImp += $amount;
                                                if($cp['regime'] == 'G' && $cp['exempt'] == 0) $totIVA += $iva;
                                                if($cp['exempt'] == 1) $totExe += $amount;
                                                $totTotal += $cp['total'];
                                            }?>
                                            <?php $cont++; endforeach;?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th class="column-1"></th>
                                                <th class="column-2"></th>
                                                <th class="column-3"></th>
                                                <th class="column-4"></th>
                                                <th class="column-5"></th>
                                                <th class="column-6"></th>
                                                <th class="column-7 text-right">TOTALES:</th>
                                                <th class="column-8 text-right"><?php echo number_format($totPeq,2,'.',',');?></th>
                                                <th class="column-9 text-right"><?php echo number_format($totGas,2,'.',',');?></th>
                                                <th class="column-10 text-right"><?php echo number_format($totCom,2,'.',',');?></th>
                                                <th class="column-11 text-right"><?php echo number_format($totSer,2,'.',',');?></th>
                                                <th class="column-12 text-right"><?php echo number_format($totImp,2,'.',',');?></th>
                                                <th class="column-13 text-right"><?php echo number_format($totIVA,2,'.',',');?></th>
                                                <th class="column-14 text-right"><?php echo number_format($totExe,2,'.',',');?></th>
                                                <th class="column-15 text-right"><?php echo number_format($totTotal,2,'.',',');?></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <form method="POST" action="<?php echo base_url();?>admin/printFormType/purchasing/" id="frmP" target="">
            <input type="hidden" name="initial" value="<?php echo $initial;?>" />
            <input type="hidden" name="final" value="<?php echo $final;?>" />
            <input type="hidden" name="camp" value="<?php echo $camp;?>" />
            <input type="hidden" name="text" value="<?php echo $text;?>" />
            <input type="hidden" id="type" name="type" value="" />
        </form>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $(".btn-group .focus-btn-group").hide();
        <?php for ($i=1; $i <= 15; $i++):?>
        initialChecked(<?php echo $i;?>, <?php if(in_array($i, $checks)) echo "true"; else echo "false";?>);
        <?php endfor;?>
    });

    function initialChecked(i, checked) {
        $("#check-move-"+i).prop("checked", checked);
        if (checked) $(".column-"+i).show();
        else $(".column-"+i).hide();
    }

    function submitFormType(type) {
        $("#type").val(type);
        if (type == "PDF") $("#frmP").attr("target", "_blank");
        else $("#frmP").attr("target", '');
        $("#frmP").submit();
    }

    function colHideAjax(check, i) {
        checked = $(check).prop("checked");
        if (checked) $(".column-"+i).show();
        else $(".column-"+i).hide();
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
            url: "<?php echo base_url();?>admin/setChecksPurchase/",
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