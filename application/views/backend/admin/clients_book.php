<?php $checks = json_decode($this->crud_model->getInfo("checks_clients")); setlocale(LC_TIME,"es_ES");?>
<link href="<?php echo base_url();?>public/assets/libs/admin-resources/rwd-table/rwd-table.min.css" rel="stylesheet" type="text/css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="<?php echo base_url();?>public/assets/libs/select2/js/select2.min.js"></script>
<link href="<?php echo base_url();?>public/assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
<?php include "navigation_accountant.php";?>
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
            <div class="card-box">
                <div class="card-b">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="title-header">
                                <h4 class="card-title text-center">
                                    CUENTAS POR COBRAR<br>
                                    <?php ?><br>
                                    <?php echo $this->crud_model->getInfo("system_name")."<br>";
                                        echo $this->crud_model->getInfo("description")."<br>";
                                        echo "Nit: ".$this->crud_model->getInfo("nit"),"<br>";
                                        if ($initial != '' && $final != '') {
                                            echo "<br> DEL ".strtoupper(strftime("%d DE %B AL ", strtotime($initial))).date('d ', strtotime($final));
                                            if (date('m', strtotime($initial)) != date('m', strtotime($final))) echo strftime("DE %B ", strtotime($final));
                                            echo strftime("DEL %Y", strtotime($final));
                                        }?>
                                </h4>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <form method="post" action="<?php echo base_url();?>admin/clients_book/">
                                <div class="row">
                                    <div class="col-lg-6 mb-3">
                                        <div class="form-group">
                                            <label for="">Cliente</label>
                                            <select name="client_id" id="client_id" class="form-control" onchange="this.form.submit()"></select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <div class="form-group">
                                            <label for="">Estado</label>
                                            <select class="form-control" name="commission" id="commission" onchange="this.form.submit()">
                                                <option value="">Todas</option>
                                                <option value="<=" <?php if($commission == "<=") echo "selected";?>>A tiempo</option>
                                                <option value=">" <?php if($commission == '>') echo "selected";?>>Vencidos</option>
                                            </select>
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
                        <div class="col-lg-4 mb-3">
                            <div class="dropdown dropend" style="">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
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
                                                    <label class="form-check-label" for="check-move-2">Cod. Cliente</label>
                                                </div>
                                            </div>
                                            <div class="dropdown-item">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="checks_columns[]" id="check-move-3" value="3" onclick="colHideAjax(this, 3)" />
                                                    <label class="form-check-label" for="check-move-3">Nombre del cliente</label>
                                                </div>
                                            </div>
                                            <div class="dropdown-item">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="checks_columns[]" id="check-move-4" value="4" onclick="colHideAjax(this, 4)" />
                                                    <label class="form-check-label" for="check-move-4">Nit</label>
                                                </div>
                                            </div>
                                            <div class="dropdown-item">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="checks_columns[]" id="check-move-5" value="5" onclick="colHideAjax(this, 5)" />
                                                    <label class="form-check-label" for="check-move-5">Dirección</label>
                                                </div>
                                            </div>
                                            <div class="dropdown-item">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="checks_columns[]" id="check-move-6" value="6" onclick="colHideAjax(this, 6)" />
                                                    <label class="form-check-label" for="check-move-6">Tel</label>
                                                </div>
                                            </div>
                                            <div class="dropdown-item">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="checks_columns[]" id="check-move-7" value="7" onclick="colHideAjax(this, 7)" />
                                                    <label class="form-check-label" for="check-move-7">Vendedor</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="dropdown-item">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="checks_columns[]" id="check-move-8" value="8" onclick="colHideAjax(this, 8)" />
                                                    <label class="form-check-label" for="check-move-8">No. de factura</label>
                                                </div>
                                            </div>
                                            <div class="dropdown-item">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="checks_columns[]" id="check-move-9" value="9" onclick="colHideAjax(this, 9)" />
                                                    <label class="form-check-label" for="check-move-9">Fecha de emisión</label>
                                                </div>
                                            </div>
                                            <div class="dropdown-item">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="checks_columns[]" id="check-move-10" value="10" onclick="colHideAjax(this, 10)" />
                                                    <label class="form-check-label" for="check-move-10">Fecha de vencimiento</label>
                                                </div>
                                            </div>
                                            <div class="dropdown-item">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="checks_columns[]" id="check-move-11" value="11" onclick="colHideAjax(this, 11)" />
                                                    <label class="form-check-label" for="check-move-11">Cargo total</label>
                                                </div>
                                            </div>
                                            <div class="dropdown-item">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="checks_columns[]" id="check-move-12" value="12" onclick="colHideAjax(this, 12)" />
                                                    <label class="form-check-label" for="check-move-12">Abonos</label>
                                                </div>
                                            </div>
                                            <div class="dropdown-item">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="checks_columns[]" id="check-move-13" value="13" onclick="colHideAjax(this, 13)" />
                                                    <label class="form-check-label" for="check-move-13">Saldo pendiente</label>
                                                </div>
                                            </div>
                                            <div class="dropdown-item">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="checks_columns[]" id="check-move-14" value="14" onclick="colHideAjax(this, 14)" />
                                                    <label class="form-check-label" for="check-move-14">Comentarios</label>
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
                                                <th class="column-2 text-center">Cod.<br>Cliente</th>
                                                <th class="column-3 text-center">Nombre del<br>cliente</th>
                                                <th class="column-4 text-center">Nit</th>
                                                <th class="column-5 text-center">Dirección</th>
                                                <th class="column-6 text-center">Tel</th>
                                                <th class="column-7 text-center">Vendedor</th>
                                                <th class="column-8 text-center">No. de<br>factura</th>
                                                <th class="column-9 text-center">Fecha de<br>emisión</th>
                                                <th class="column-10 text-center">Fecha de<br>vencimiento</th>
                                                <th class="column-11 text-center">Cargo total</th>
                                                <th class="column-12 text-center">Abonos</th>
                                                <th class="column-13 text-center">Saldo pendiente</th>
                                                <th class="column-14 text-center">Comentarios</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $totalTotal = 0; $totalCharge = 0; $totalResidue = 0; $totalCashed = 0; $totalCredit = 0;
                                                $cont = 1; foreach($ventas->result_array() as $vt):
                                                $date = ''; $color = '3C9B11';
                                                if($issue['date'] != '') $date = $issue['date']; else $date = $vt['date'];
                                                $numVen = strtotime($date."+ 60 days"); $numHoy = strtotime($hoy);
                                                if ($numHoy > $numVen) $color = 'F21416';?>
                                            <tr>
                                                <td class="column-1" style="font-weight: bold; color: #<?php echo $color;?>!important"><?php echo $cont++;?></td>
                                                <td class="column-2" style="font-weight: bold; color: #<?php echo $color;?>!important"><?php echo $vt['code'];?></td>
                                                <td class="column-3" style="font-weight: bold; color: #<?php echo $color;?>!important"><?php echo $vt['first_name'].' '.$vt['last_name'];?></td>
                                                <td class="column-4" style="font-weight: bold; color: #<?php echo $color;?>!important"><?php echo $vt['nit'];?></td>
                                                <td class="column-5" style="font-weight: bold; color: #<?php echo $color;?>!important"><?php echo $vt['address'];?></td>
                                                <td class="column-6" style="font-weight: bold; color: #<?php echo $color;?>!important"><?php echo $vt['phone'];?></td>
                                                <td class="column-7" style="font-weight: bold; color: #<?php echo $color;?>!important"><?php echo $visit['name'];?></td>
                                                <td class="column-8" style="font-weight: bold; color: #<?php echo $color;?>!important"><?php echo $vt['invoice'];?></td>
                                                <td class="column-9" style="font-weight: bold; color: #<?php echo $color;?>!important"><?php echo date("d/m/Y", strtotime($date));?></td>
                                                <td class="column-10" style="font-weight: bold; color: #<?php echo $color;?>!important"><?php echo date("d/m/Y", strtotime($vt['due_date']));?></td>
                                                <td class="column-11" style="font-weight: bold; color: #<?php echo $color;?>!important">
                                                    <div class="container-justify">
                                                        <div>Q</div>
                                                        <div><?php echo number_format($vt['total_due'],2,'.',',');?></div>
                                                    </div>
                                                </td>
                                                <td class="column-12" style="font-weight: bold; color: #<?php echo $color;?>!important">
                                                    <div class="container-justify">
                                                        <div>Q</div>
                                                        <div><?php if($vt['type_invoice'] == 'C') echo number_format($vt['charges'],2,'.',','); else echo '-';?></div>
                                                    </div>
                                                </td>
                                                <td class="column-13" style="font-weight: bold; color: #<?php echo $color;?>!important">
                                                    <div class="container-justify">
                                                        <div>Q</div>
                                                        <div><?php if($vt['type_invoice'] == 'C') echo number_format($vt['residue'],2,'.',','); else echo '-';?></div>
                                                    </div>
                                                </td>
                                                <td class="column-14" style="font-weight: bold; color: #<?php echo $color;?>!important"><?php echo $vt['details'];?></td>
                                            </tr>
                                            <?php $totalTotal += $vt['total_due']; 
                                                $totalCharge += $vt['charges']; 
                                                $totalResidue += $vt['residue'];
                                                endforeach;?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th class="column-1"></th>
                                                <th class="column-2"></th>
                                                <th class="column-3"></th>
                                                <th class="column-4"></th>
                                                <th class="column-5"></th>
                                                <th class="column-6"></th>
                                                <th class="column-7"></th>
                                                <th class="column-8"></th>
                                                <th class="column-9"></th>
                                                <th class="column-10">Totales</th>
                                                <th class="column-11">
                                                    <div class="container-justify">
                                                        <div>Q</div>
                                                        <div><?php echo number_format($totalTotal,2,'.',',');?></div>
                                                    </div>
                                                </th>
                                                <th class="column-12">
                                                    <div class="container-justify">
                                                        <div>Q</div>
                                                        <div><?php echo number_format($totalCharge,2,'.',',');?></div>
                                                    </div>
                                                </th>
                                                <th class="column-13">
                                                    <div class="container-justify">
                                                        <div>Q</div>
                                                        <div><?php echo number_format($totalResidue,2,'.',',');?></div>
                                                    </div>
                                                </th>
                                                <th class="column-14"></th>
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
        <form method="POST" action="<?php echo base_url();?>admin/printFormType/clients_book/" id="frmC" target="_blank">
            <input type="hidden" name="initial" value="<?php echo $initial;?>" />
            <input type="hidden" name="final" value="<?php echo $final;?>" />
            <input type="hidden" name="visitor_id" value="<?php echo $visitor_id;?>" />
            <input type="hidden" name="client_id" value="<?php echo $client_id;?>" />
            <input type="hidden" name="commission" value="<?php echo $commission;?>" />
            <input type="hidden" id="type" name="type" value="" />
        </form>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $(".btn-group .focus-btn-group").hide();
        <?php for ($i=1; $i <= 14; $i++):?>
        initialChecked(<?php echo $i;?>, <?php if(in_array($i, $checks)) echo "true"; else echo "false";?>);
        <?php endfor;?>
    });
    
    $("#client_id").select2({
        placeholder: "Escribe el nit o nombre de algun cliente",
        <?php if($client_id == '' || $client_id == 'T'):?>
        data: [{"id": 'T', "text": 'Todos', "selected": true}],
        <?php elseif($client_id != '' && $client_id != 'T' && $client_id != 0):
            $clien = $this->crud_model->getClient($client_id);?>
        data: [{"id": '<?php echo $client_id;?>', "text": '<?php echo $clien['nit'].' - '.$clien['first_name'].' '.$clien['last_name'];?>', "selected": true}],
        <?php endif;?>
        ajax: {
            url: "<?php echo base_url();?>admin/getClientSearchAjax/",
            type: "POST",
            dataType: "json",
            delay: 250,
            data: function (params) {
                return {
                    searchTerm: params.term,
                    id: '<?php echo $client_id;?>',
                    cf: 'no',
                };
            },
            processResults: function (response) {
                return {
                    results: response
                };
            }
        }
    });

    function submitFormType(type) {
        $("#type").val(type);
        if (type == "PDF") $("#frmC").attr("target", "_blank");
        else $("#frmC").attr("target", '');
        $("#frmC").submit();
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
        var nDoc = 0; var nCom = 0; var nBase = 0;
        var vals = [];
        $("input[name='checks_columns[]']").each(function () {
            var val = this.value;
            if ($(this).is(":checked")) {
                vals.push(val); 
                if (val == 3 || val == 4) nDoc++;
                if (val == 5 || val == 6) nCom++;
                if (val == 9 || val == 10) nBase++;
            }
        });
        if (nDoc <= 0) {
            $("#column-doc").hide();
        } else {
            $("#column-doc").show();
            $("#column-doc").attr("colspan", nDoc);
        }
        if (nCom <= 0) {
            $("#column-com").hide();
        } else {
            $("#column-com").show();
            $("#column-com").attr("colspan", nCom);
        }
        if (nBase <= 0) {
            $("#column-base").hide();
        } else {
            $("#column-base").show();
            $("#column-base").attr("colspan", nBase);
        }
        $.ajax({
            type: "POST",
            url: "<?php echo base_url();?>admin/setChecksClients/",
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