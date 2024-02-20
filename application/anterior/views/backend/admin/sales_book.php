<?php $ventas = $this->crud_model->getSalesBook($initial, $final, $institution_id.'-'.$camp.'-'.$text);
    $checks = json_decode($this->crud_model->getInfo("checks_sales"));
    log_message("error", "Checks Sales: ".json_encode($checks));?>
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
                                <h4 class="card-title">Libro de Ventas</h4>
                            </div>
                            <form method="post" action="<?php echo base_url();?>admin/sales_book/">
                                <div class="row">
                                    <div class="col-lg-6 mb-3">
                                        <div class="form-group">
                                            <label for="">Establecimiento</label>
                                            <select name="institution_id" id="" class="form-control" onchange="this.form.submit()">
                                                <option value="">Todos</option>
                                                <?php $inst = $this->crud_model->getInstitutionRegistered();
                                                    foreach($inst->result_array() as $in):?>
                                                <option value="<?php echo $in['institution_id'];?>" <?php if ($in['institution_id'] == $institution_id) echo "selected";?>><?php echo $in['name'];?></option>
                                                <?php endforeach;?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                        <div class="form-group mb-3">
                                            <label for="">Seleccione un campo</label>
                                            <div class="input-group">
                                                <select name="camp" class="form-control">
                                                    <option value="">Sin filtro</option>
                                                    <option value="invoice" <?php if($camp == "invoice") echo "selected";?>>Número de factura</option>
                                                    <option value="nit" <?php if($camp == "nit") echo "selected";?>>NIT del cliente</option>
                                                    <option value="name" <?php if($camp == "name") echo "selected";?>>Nombre del cliente</option>
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
                                            <label for="final">Fecha inicial:</label>
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
                        <?php if ($institution_id != ''):
                            $ins = $this->crud_model->getInstitution($institution_id);?>
                        <div class="col-lg-6 mb-3" style="display:none;">
                            <table class="table-bordered">
                                <tr>
                                    <td>CONTRIBUYENTE:</td>
                                    <td><?php echo $ins['personal_name'];?></td>
                                </tr>
                                <tr>
                                    <td>NOMBRE COMERCIAL:</td>
                                    <td><?php echo $ins['name'];?></td>
                                </tr>
                                <tr>
                                    <td>DIRECCIÓN COMERCIAL:</td>
                                    <td><?php echo $ins['address'];?></td>
                                </tr>
                            </table>
                        </div>
                        <?php endif;?>
                        <div class="col-lg-4 mb-3" style="">
                            <div class="dropdown dropend" style="">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-expanded="false" aria-haspopup="true">
                                    Ocultar columnas <i class="mdi mdi-chevron-right"></i>
                                </button>
                                <div class="dropdown-menu" style="" aria-labelledby="dropdownMenuButton">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="dropdown-item">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="checks_columns[]" id="check-move-1" value="1" onclick="colHideAjax(this, 1)" />
                                                    <label class="form-check-label" for="check-move-1">#</label>
                                                </div>
                                            </div>
                                            <div class="dropdown-item">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="checks_columns[]" id="check-move-2" value="2" onclick="colHideAjax(this, 2)" />
                                                    <label class="form-check-label" for="check-move-2">DOCUMENTO NO</label>
                                                </div>
                                            </div>
                                            <div class="dropdown-item">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="checks_columns[]" id="check-move-3" value="3" onclick="colHideAjax(this, 3)" />
                                                    <label class="form-check-label" for="check-move-3"></label>
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
                                                    <label class="form-check-label" for="check-move-6">NIT</label>
                                                </div>
                                            </div>
                                            <div class="dropdown-item">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="checks_columns[]" id="check-move-7" value="7" onclick="colHideAjax(this, 7)" />
                                                    <label class="form-check-label" for="check-move-7">COMPRADOR</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="dropdown-item">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="checks_columns[]" id="check-move-8" value="8" onclick="colHideAjax(this, 8)" />
                                                    <label class="form-check-label" for="check-move-8">EXPORTACION Q</label>
                                                </div>
                                            </div>
                                            <div class="dropdown-item">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="checks_columns[]" id="check-move-9" value="9" onclick="colHideAjax(this, 9)" />
                                                    <label class="form-check-label" for="check-move-9">BIENES PRE. NETO</label>
                                                </div>
                                            </div>
                                            <div class="dropdown-item">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="checks_columns[]" id="check-move-10" value="10" onclick="colHideAjax(this, 10)" />
                                                    <label class="form-check-label" for="check-move-10">BIENES EXENTOS</label>
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
                                                    <label class="form-check-label" for="check-move-12">IVA Q.</label>
                                                </div>
                                            </div>
                                            <div class="dropdown-item">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="checks_columns[]" id="check-move-13" value="13" onclick="colHideAjax(this, 13)" />
                                                    <label class="form-check-label" for="check-move-13">TOTAL</label>
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
                                                <th class="column-1">#</th>
                                                <th class="column-2 text-left">DOCUMENTO<br>NO</th>
                                                <th class="column-3 text-left"></th>
                                                <th class="column-4 text-left">FECHA</th>
                                                <th class="column-5 text-left">TIPO DE<br>DOCUMENTO</th>
                                                <th class="column-6 text-left">NIT</th>
                                                <th class="column-7 text-left">COMPRADOR</th>
                                                <th class="column-8 text-center">EXPORTACION<br>Q</th>
                                                <th class="column-9 text-center">BIENES<br>PRE. NETO</th>
                                                <th class="column-10 text-center">BIENES<br>EXENTOS</th>
                                                <th class="column-11 text-center">SERVICIOS<br>PRE. NETO</th>
                                                <th class="column-12 text-center">IVA Q.</th>
                                                <th class="column-13 text-center">TOTAL</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $totExpo = 0; $totBien = 0; $totExen = 0; $totServ = 0; $totIVA = 0;  $totalTotal = 0;
                                                $cont = 0; $n = 1; foreach($ventas->result_array() as $vt):
                                                $ins = $this->crud_model->getInstitution($vt['institution_id']);
                                                $issue = $this->crud_model->getIssueByInvoice($vt['datetime']);?>
                                            <tr>
                                                <td class="column-1 text-left"><?php echo $n++;?></td>
                                                <td class="column-2 text-left"><?php if(count($issue) > 0) echo $issue['no_serie'];?></td>
                                                <td class="column-3 text-left"><?php echo $vt['invoice'];?></td>
                                                <td class="column-4 text-right"><?php echo date("d/m/Y", strtotime($vt['date']));?></td>
                                                <td class="column-5 text-left">DOCUMENTO</td>
                                                <td class="column-6 text-left"><?php if($vt['type_id'] == "NIT") echo $vt['nit']; elseif ($vt['type_id'] == "CUI") echo $vt['cui'];?></td>
                                                <td class="column-7 text-left"><?php echo $vt['name'];?></td>
                                                <td class="column-8 text-right"><?php if($vt['status'] == 1 && $vt['type'] == 'E' && $vt['exempt'] == 0) echo number_format($vt['amount'],2,'.',','); else echo "0.00";?></td>
                                                <td class="column-9 text-right"><?php if($vt['status'] == 1 && ($vt['type'] == 'V' || $vt[''] == '') && $vt['exempt'] == 0) echo number_format($vt['amount'],2,'.',','); else echo "0.00";?></td>
                                                <td class="column-10 text-right"><?php if($vt['status'] == 1 && ($vt['type'] == 'V' || $vt[''] == '') && $vt['exempt'] == 1) echo number_format($vt['amount'],2,'.',','); else echo "0.00";?></td>
                                                <td class="column-11 text-right"><?php if($vt['status'] == 1 && $vt['type'] == 'S' && $vt['exempt'] == 0) echo number_format($vt['amount'],2,'.',','); else echo "0.00";?></td>
                                                <td class="column-12 text-right"><?php if($vt['status'] == 1 && $vt['exempt'] == 0) echo number_format($vt['iva'],2,'.',','); else echo "0.00";?></td>
                                                <td class="column-13 text-right"><?php if($vt['status'] == 1) echo number_format($vt['total'],2,'.',','); else echo "0.00";?></td>
                                            </tr>
                                            <?php if ($vt['status'] == 1) { 
                                                if($vt['type'] == 'E' && $vt['exempt'] == 0) $totExpo += $vt['amount'];
                                                if(($vt['type'] == 'V' || $vt[''] == '') && $vt['exempt'] == 0) $totBien += $vt['amount'];
                                                if(($vt['type'] == 'V' || $vt[''] == '') && $vt['exempt'] == 1) $totExen += $vt['amount'];
                                                if($vt['type'] == 'S' && $vt['exempt'] == 0) $totServ += $vt['amount'];
                                                if($vt['exempt'] == 0) $totIVA += $vt['iva'];
                                                $totalTotal += $vt['total'];
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
                                                <th class="column-8 text-right"><?php echo number_format($totExpo,2,'.',',');?></th>
                                                <th class="column-9 text-right"><?php echo number_format($totBien,2,'.',',');?></th>
                                                <th class="column-10 text-right"><?php echo number_format($totExen,2,'.',',');?></th>
                                                <th class="column-11 text-right"><?php echo number_format($totServ,2,'.',',');?></th>
                                                <th class="column-12 text-right"><?php echo number_format($totIVA,2,'.',',');?></th>
                                                <th class="column-13 text-right"><?php echo number_format($totalTotal,2,'.',',');?></th>
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
        <form method="POST" action="<?php echo base_url();?>admin/printFormType/sales_book/" id="frmS" target="_blank">
            <input type="hidden" class="initial" name="initial" value="<?php echo $initial;?>" />
            <input type="hidden" class="final" name="final" value="<?php echo $final;?>" />
            <input type="hidden" class="institution_id" name="institution_id" value="<?php echo $institution_id;?>" />
            <input type="hidden" class="camp" name="camp" value="<?php echo $camp;?>" />
            <input type="hidden" class="text" name="text" value="<?php echo $text;?>" />
            <input type="hidden" id="type" name="type" value="" />
        </form>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $(".btn-group .focus-btn-group").hide();
        <?php for ($i=1; $i <= 13; $i++):?>
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
        if (checked) $(".column-"+i).show();
        else $(".column-"+i).hide();
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
            url: "<?php echo base_url();?>admin/setChecksSales/",
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