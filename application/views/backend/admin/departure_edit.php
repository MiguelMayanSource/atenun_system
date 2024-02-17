<?php 
    $todos = $this->crud_model->getNomenclature();
    $par = $this->crud_model->getDepartureByID($departure_id);
    $detalles = $this->crud_model->getDetailsDeparture($departure_id);
    $provs = $this->crud_model->getProvidersActive();
    $inst2 = $this->crud_model->getInstitutions();
    $inst = $this->crud_model->getInstitutionProduction();
    $porcentaje = 0;
    $cont = 1; $nPur = 0;
    $rowSinIVA = 0;
    $sinIVA = $par['total'] - $par['iva'];
    log_message("error", "Department: ".$par['department_id']);
?>
<script src="<?php echo base_url();?>public/uploads/sweetalert2.all.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="<?php echo base_url();?>public/assets/libs/select2/js/select2.min.js"></script>
<link href="<?php echo base_url();?>public/assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
<style type="text/css">
    .select2 {
        min-width: 100px;
    }

    .btn-toolbar {
        display: none !important;
    }
</style>
<div id="main-content">
    <div class="row">
        <div class="col-12">
            <div class="card-box">
                <div class="card-b">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="title-header">
                                <h4 class="card-title mb-4">Inicio de partida</h4>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3" style="float: right;">
                                <div class="btn-group focus-btn-group">
                                    <a class="btn btn-info" href="<?php echo base_url();?>admin/departures/">
                                        <i class="bx bx-arrow-back"></i> Ir a partidas
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <form class="repeater" action="<?php echo base_url();?>admin/departure/edit" method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="departure_id" id="departure_id" value="<?php echo $departure_id;?>" />
                                <input type="hidden" id="total" name="total" value="<?php echo $par['total'];?>" />
                                <div class="row">
                                    <div class="col-lg-12 mb-3">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <label for="">Fecha de la partida</label>
                                                <input type="date" class="form-control" name="date" id="date" value="<?php echo $par['date'];?>" />
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label for="" class="">Área de gastos</label>
                                                    <select class="form-control" name="department_id" id="department_id">
                                                        <option value="">Ninguno</option>
                                                        <?php $deptos = $this->crud_model->getDeptosActive();
                                                            foreach($deptos->result_array() as $dp):?>
                                                        <option value="<?php echo $dp['department_id'];?>" <?php if($dp['department_id'] == $par['department_id']) echo "selected";?>><?php echo $dp['name'];?></option>
                                                        <?php endforeach;?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-2">
                                                <div class="form-check form-switch form-switch-lg mb-3" dir="ltr">
                                                    <input class="form-check-input" type="checkbox" name="adjust" id="adjust" value="1" <?php if($par['adjust'] == 1) echo "checked";?> />
                                                    <label class="form-check-label" for="adjust">Ajuste</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="iva" id="iva" value="<?php echo $par['iva'];?>" />
                                    <input type="hidden" name="isr" id="isr" value="<?php echo $par['isr'];?>" />
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
                                                    <?php $row = 0;
                                                        foreach ($detalles->result_array() as $dt):
                                                        $nom_id = $dt['nomenclature_id']; 
                                                        $nom = $this->crud_model->nomenByID($nom_id); $name_low = strtolower($nom['name']);
                                                        if(strpos($name_low, "isr") !== false && $dt['from_id'] != '') $rubros = $this->crud_model->getNomenISR();
                                                        elseif(strpos($name_low, "reten") !== false && $dt['from_id'] != '') $rubros = $this->crud_model->getNomenReten();
                                                        elseif(strpos($name_low, "exen") !== false && $dt['from_id'] != '') $rubros = $this->crud_model->getNomenExen();
                                                        elseif ($nom_id != 25 && $nom_id != 58 && $dt['from_id'] != '') $rubros = $this->crud_model->getNomenclature();
                                                        else {
                                                            $rubros = $todos;
                                                            $row = $cont;
                                                        }
                                                        if ($nom['purchase'] == 1) $nPur++;
                                                    ?>
                                                    <tr class="text-center" id="<?php if(($nom_id == 25 || $nom_id == 58) && $dt['from_id'] != '') echo "rowIVA_$row"; elseif(strpos($name_low, "isr") !== false && $dt['from_id'] != '') echo "rowISR_$row"; elseif(strpos($name_low, "reten") !== false && $dt['from_id'] != '') echo "rowReten_$row"; elseif(strpos($name_low, "exen") !== false && $dt['from_id'] != '') echo "rowExen_$row"; else echo "rowField_$cont";?>">
                                                        <input type="hidden" name="departure_detail_id[]" value="<?php echo $dt['departure_detail_id'];?>" />
                                                        <td id="selectNomen_<?php echo $cont;?>">
                                                            <?php if($nom_id == 25 || $nom_id == 58):?>
                                                            <b id="nameIVA_<?php echo $row;?>"><?php echo $nom['code'].' '.$nom['name'];?></b>
                                                            <input type="hidden" id="nomen_id_IVA_<?php echo $row;?>" name="nomen_id[]" value="<?php echo $nom_id;?>" />
                                                            <?php else: ?>
                                                            <div class="input-group">
                                                                <select class="form-control select2-<?php if(strpos($name_low, "isr") !== false) echo "isr"; elseif(strpos($name_low, "reten") !== false) echo "reten"; elseif(strpos($name_low, "exen") !== false) echo "exen"; else echo "nom";?>" id="nomen_id_<?php echo $cont;?>" name="nomen_id[]" onchange="verifyNomen(this.value, <?php echo $cont;?>)" required>
                                                                    <option value="">Seleccionar</option>
                                                                    <?php foreach ($rubros->result_array() as $rb):?>
                                                                    <option value="<?php echo $rb['nomenclature_id'];?>" <?php if($rb['nomenclature_id'] == $nom_id) echo "selected";?>><?php echo $rb['code'].' '.$rb['name'];?></option>
                                                                    <?php endforeach;?>
                                                                </select>
                                                                <span class="input-group-addon input-group-append" id="divSwitch_<?php echo $cont;?>" style="<?php if($nom['purchase'] != 1) echo "display:none;"?>">
                                                                    <span class="input-group-text">
                                                                        <input type="checkbox" class="check-purchase" id="switch_<?php echo $cont;?>" switch="info" onchange="checkPurchase(this, '<?php echo $cont;?>')" <?php if($nom['purchase'] == 1) echo "checked";?> />
                                                                        <label for="switch_<?php echo $cont;?>" data-on-label="" data-off-label="Ver"></label>
                                                                    </span>
                                                                </span>
                                                            </div>
                                                            <?php endif;?>
                                                            <input type="hidden" id="purchase_<?php echo $cont;?>" name="purchase[]" value="<?php echo $nom['purchase'];?>" />
                                                            <input type="hidden" id="from_id_<?php if($nom_id == 25 || $nom_id == 58) echo "IVA_$row"; elseif(strpos($name_low, "isr") !== false) echo "ISR_$row"; elseif(strpos($name_low, "reten") !== false) echo "Reten_$row"; elseif(strpos($name_low, "exen") !== false) echo "Exen_$row"; else echo "rowField_$cont";?>" name="from_id[]" value="<?php echo $dt['from_id'];?>" />
                                                            <small class="text-danger" id="msgNomen<?php if($$nom_id == 25 || $nom_id == 58) echo "IVA"; elseif(strpos($name_low, "isr") !== false) echo "ISR"; elseif(strpos($name_low, "reten") !== false) echo "Reten"; elseif(strpos($name_low, "exen") !== false) echo "Exen"; echo '_'.$row;?>"></small>
                                                        </td>
                                                        <td>
                                                            <div class="input-group">
                                                                <span class="input-group-addon input-group-prepend">
                                                                    <span class="input-group-text">Q</span>
                                                                </span>
                                                                <input type="number" class="form-control" id="debe<?php if($nom_id == 25 || $nom_id == 58) echo 'IVA'; elseif(strpos($name_low, "isr") !== false) echo "ISR"; elseif(strpos($name_low, "reten") !== false) echo "Reten"; elseif(strpos($name_low, "exen") !== false) echo "Exen"; else echo '_'.$row;?>" name="debe[]" value="<?php if($dt['debit'] > 0) echo $dt['debit'];?>" step="0.01" min="0" oninput="sumarTotales()" />
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="input-group">
                                                                <span class="input-group-addon input-group-prepend">
                                                                    <span class="input-group-text">Q</span>
                                                                </span>
                                                                <input type="number" class="form-control" id="haber<?php if($nom_id == 25 || $nom_id == 58) echo 'IVA'; elseif(strpos($name_low, "isr") !== false) echo "ISR"; elseif(strpos($name_low, "reten") !== false) echo "Reten"; elseif(strpos($name_low, "exen") !== false) echo "Exen"; else echo '_'.$row;?>" name="haber[]" value="<?php if($dt['credit'] > 0) echo $dt['credit'];?>" step="0.01" min="0" oninput="sumarTotales()" />
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div style="display:flex;">
                                                                <?php if($nom_id != 25 && $nom_id != 58 && strpos($name_low, "isr") === false && strpos($name_low, "reten") === false && strpos($name_low, "exen") === false):?>
                                                                <div class="btn-group">
                                                                    <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" type="button" id="btn_group_<?php echo $cont;?>" style="<?php if(strpos($name_low, 'isr') !== false || strpos($name_low, 'reten') !== false || strpos($name_low, 'exen') !== false) echo "display:none;";?>">...</button>
                                                                    <div class="dropdown-menu">
                                                                        <a class="dropdown-item" href="javascript:void(0);" onclick="checkIVASelect(12, 'C', <?php echo $cont;?>)">IVA regimen general - Crédito Fiscal</a>
                                                                        <a class="dropdown-item" href="javascript:void(0);" onclick="checkIVASelect(12, 'D', <?php echo $cont;?>)">IVA regimen general - Débito Fiscal</a>
                                                                        <a class="dropdown-item" href="javascript:void(0);" onclick="checkISRSelect(<?php echo $cont;?>, 'G')">ISR Régimen General</a>
                                                                        <a class="dropdown-item" href="javascript:void(0);" onclick="checkRetenSelect('G', <?php echo $cont;?>)">Retención de IVA General</a>
                                                                        <a class="dropdown-item" href="javascript:void(0);" onclick="checkRetenSelect('P', <?php echo $cont;?>)">Retención de IVA Peq. Contribuyente</a>
                                                                        <a class="dropdown-item" href="javascript:void(0);" onclick="checkExeSelect(<?php echo $cont;?>)">Exenta del IVA</a>
                                                                    </div>
                                                                </div>
                                                                &nbsp;
                                                                <?php endif;?>
                                                                <button class="btn btn-danger" type="button" onclick="deleteDetail(<?php echo $row;?>, <?php echo $dt['departure_detail_id'];?>, '<?php if($nom_id == 25 || $nom_id == 58) echo 'IVA'; elseif(strpos($name_low, 'isr') !== false) echo 'ISR'; elseif(strpos($name_low, 'reten') !== false) echo 'Reten'; elseif(strpos($name_low, 'reten') !== false) echo 'Exen'; else echo 'General';?>')">x</button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <?php $cont++; endforeach;?>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td colspan="3" style="text-align: right;"><span id="msgRubro" class="text-danger"></span></td>
                                                        <td><button class="btn btn-primary" type="button" onclick="addFieldSelect()" id="btnSelect">+<span id="spinnerSelect" class="text-warning"></span></button></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="text-align: right !important;"><b><u>Total:</u></b></td>
                                                        <td class="text-center">
                                                            <b><u><span id="spnDebe">Q.<?php echo number_format($par['total'],2,".",",")?></span></u></b>
                                                            <input type="hidden" name="totalDebe" id="totalDebe" value="<?php echo $par['total'];?>" />
                                                            <small id="msgTotalDebe" class="text-danger"></small>
                                                        </td>
                                                        <td class="text-center">
                                                            <b><u><span id="spnHaber">Q.<?php echo number_format($par['total'],2,".",",")?></span></u></b>
                                                            <input type="hidden" name="totalHaber" id="totalHaber" value="<?php echo $par['total'];?>" />
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
                                        <textarea rows="3" cols="" class="form-control" name="details" required><?php echo $par['details'];?></textarea>
                                    </div>
                                    <?php $pur = $this->crud_model->getPurchaseByDep($departure_id);?>
                                    <div class="col-lg-12 mt-3" id="tablePurchase" style="<?php if ($pur->num_rows() <= 0 && $nPur <= 0) echo "display:none;";?>">
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
                                                <tbody id="rowsPurchase">
                                                    <?php $contPur = 1; $totSumPur = 0; $totIVAPur = 0; $totISRPur = 0;
                                                        foreach ($pur->result_array() as $pr):?>
                                                    <tr id="dataPurchase_<?php echo $contPur;?>">
                                                        <td>
                                                            <div class="form-group">
                                                                <input type="date" class="form-control" name="date_pur[]" id="date_<?php echo $contPur;?>" value="<?php echo $pr['date'];?>" />
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <input type="hidden" name="purchase_id[]" id="purchase_id_<?php echo $contPur;?>" value="<?php echo $pr['purchase_id'];?>" />
                                                            <input type="hidden" name="cont_purchase[]" id="cont_purchase_<?php echo $contPur;?>" value="<?php echo $contPur;?>" />
                                                            <div class="form-group">
                                                                <input type="text" class="form-control" name="document_type[]" id="document_type_<?php echo $contPur;?>" value="<?php echo $pr['document_type'];?>" oninput="verifyPurchase()" />
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group">
                                                                <input type="text" class="form-control" name="serie[]" id="serie_<?php echo $contPur;?>" value="<?php echo $pr['serie'];?>" />
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group">
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control" name="number[]" id="number_<?php echo $contPur;?>" value="<?php echo $pr['number'];?>" placeholder="Número" oninput="verifyPurchase()" onblur="searchNumDoc(<?php echo $contPur;?>, <?php echo $pr['purchase_id'];?>)" />
                                                                </div>
                                                                <small class="text-danger" id="spnNumber_<?php echo $contPur;?>"></small>
                                                                <input type="hidden" name="val_number[]" id="val_number_<?php echo $contPur;?>" value="0" />
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group">
                                                                <div class="input-group">
                                                                    <select class="form-control select2-provider-purchase" name="provider_id[]" id="provider_id_<?php echo $contPur;?>" onchange="dataProvider(this.value, <?php echo $contPur;?>)"><option value="">Selecciona un proveedor</option><option value="N">Nuevo</option>
                                                                        <?php foreach ($provs->result_array() as $pv):?>
                                                                        <option value="<?php echo $pv['provider_id'];?>" <?php if($pv['provider_id'] == $pr['provider_id']) echo "selected";?>><?php echo $pv['nit'].' '.$pv['name'];?></option>
                                                                        <?php endforeach;?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="form-group" id="dataProvider_<?php echo $contPur;?>" style="display:none;">
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control" name="name[]" id="name_<?php echo $contPur;?>" value="<?php echo $pr['name'];?>" placeholder="Nombre" oninput="verifyPurchase()" />
                                                                </div>
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control" name="nit[]" id="nit_<?php echo $contPur;?>" value="<?php echo $pr['nit'];?>" placeholder="NIT" />
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group">
                                                                <div class="input-group">
                                                                    <select class="form-control" name="institution_id[]" id="institution_id_<?php echo $contPur;?>" ><option value="">Selecciona una establecimiento</option>
                                                                    <?php /* foreach ($inst->result_array() as $in):?>
                                                                    <option value="<?php echo $in['institution_id'];?>" <?php if ($in['institution_id'] == $pr['institution_id']) echo "selected";?>><?php echo $in['code'].' - '.$in['name'];?></option>
                                                                    <?php endforeach; */?>
                                                                    <?php foreach ($inst2->result_array() as $in):?>
                                                                    <option value="<?php echo $in['institution_id'];?>" <?php if ($in['institution_id'] == $pr['institution_id']) echo "selected";?>><?php echo $in['code'].' - '.$in['name'];?></option>
                                                                    <?php endforeach;?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group">
                                                                <select class="form-control" name="type[]" id="type_<?php echo $contPur;?>">
                                                                    <option value="C" <?php if($pr['type'] == 'C') echo "selected";?>>Bien</option>
                                                                    <option value="S" <?php if($pr['type'] == 'S') echo "selected";?>>Servicio</option>
                                                                    <option value="I" <?php if($pr['type'] == 'I') echo "selected";?>>Importación</option>
                                                                </select>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group">
                                                                <input type="number" class="form-control" name="cant[]" id="cant_<?php echo $contPur;?>" value="<?php echo $pr['total'];?>" placeholder="Cantidad" oninput="cantPartial(<?php echo $contPur;?>)" step="0.01" min="1" max="" />
                                                                <input type="hidden" name="sin_iva[]" id="sin_iva_<?php echo $contPur;?>" value="<?php echo $pr['amount'];?>" />
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group">
                                                                <input type="checkbox" id="check_regime_<?php echo $contPur;?>" switch="primary" value="1" onclick="cantPartial(<?php echo $contPur;?>)" <?php if($pr['regime'] == 'G') echo "checked";?> />
                                                                <label for="check_regime_<?php echo $contPur;?>" data-on-label="Gen" data-off-label="Peq"></label>
                                                            </div>
                                                            <input type="hidden" id="regime_<?php echo $contPur;?>" name="regime[]" value="<?php if($pr['regime'] == 'G') echo 'G'; elseif($pr['regime'] == 'P') echo 'P';?>" />
                                                        </td>
                                                        <td>
                                                            <div class="form-group">
                                                                <input type="checkbox" id="check_exempt_<?php echo $contPur;?>" name="exempt[]" switch="info" value="1" onclick="cantPartial(<?php echo $contPur;?>)" <?php if($pr['exempt'] == 1) echo "checked";?> />
                                                                <label for="check_exempt_<?php echo $contPur;?>" data-on-label="Si" data-off-label="No"></label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group">
                                                                <input type="number" class="form-control" name="iva_pur[]" id="iva_<?php echo $contPur;?>" value="<?php if($pr['exempt'] != 1) echo $pr['iva'];?>" placeholder="0" step="0.01" min="0" oninput="sumPartial()" />
                                                                <input type="hidden" name="hidden_iva[]" id="hidden_iva_<?php echo $contPur;?>" value="<?php echo $pr['iva'];?>" />
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group">
                                                                <input type="number" class="form-control" name="isr_pur[]" id="isr_<?php echo $contPur;?>" value="<?php echo $pr['isr'];?>" placeholder="0" step="0.01" min="0" oninput="sumPartial()" />
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <input type="button" class="btn btn-danger" value="x" onclick="deletePurchase(<?php echo $contPur;?>, <?php echo $pr['purchase_id'];?>)" />
                                                        </td>
                                                    </tr>
                                                    <?php $contPur++; $totSumPur += $pr['total']; $totIVAPur += $pr['iva']; $totISRPur += $pr['isr']; endforeach;?>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th colspan="12"></th>
                                                        <th><input type="button" id="btnPurchase" class="btn btn-primary" value="+" onclick="addDataPurchase()" /></th>
                                                    </tr>
                                                    <tr>
                                                        <th colspan="6"></th>
                                                        <th style="text-align: right;">Totales:</th>
                                                        <th>
                                                            Q.<span id="spnTotCant"><?php echo number_format($totSumPur,2,'.',',');?></span>
                                                            <input type="hidden" name="totCant" id="totCant" value="<?php echo $totSumPur;?>" />
                                                        </th>
                                                        <th></th>
                                                        <th></th>
                                                        <th>
                                                            Q.<span id="spnTotIVA"><?php echo number_format($totIVAPur,2,'.',',');?></span>
                                                            <input type="hidden" name="totIVA" id="totIVA" value="<?php echo $totIVAPur;?>" />
                                                        </th>
                                                        <th>
                                                            Q.<span id="spnTotISR"><?php echo number_format($totISRPur,2,'.',',');?></span>
                                                            <input type="hidden" name="totISR" id="totISR" value="<?php echo $totISRPur;?>" />
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
                                        &nbsp;&nbsp;
                                        <a href="<?php echo base_url().'admin/policy_departure/'.base64_encode($departure_id);?>" class="btn btn-secondary">Póliza(s)</a>
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
    var cont = <?php echo $cont;?>;
    var purCont = <?php echo $contPur;?>;
    var res = 0;
    var equalDH = false;
    var totalDH = false;
    var rowsDH = false;
    var purchase = true;
    var num_doc = true;
    var period = true;

    $(document).ready(function () {
        sumarTotales();
        verifyPeriod();
        $(window).bind('load', function(){
            $("#rowsPurchase-clone").remove();
        });
    });

    $('.select2-nom').select2({
        placeholder: "Escribe el código de algún rubro",
    });

    $('.select2-isr').select2({
        placeholder: "Selecciona un rubro de ISR",
    });

    $('.select2-reten').select2({
        placeholder: "Selecciona un rubro de retención",
    });

    $('.select2-exen').select2({
        placeholder: "Selecciona un rubro de retención",
    });

    $(".select2-provider-purchase").select2({
        placeholder: "Escribe el código o nombre de algún producto",
        ajax: {
            url: "<?php echo base_url();?>admin/getProviderAjax/1",
            type: "POST",
            dataType: "json",
            delay: 250,
            data: function (params) {
                return {
                    searchTerm: params.term,
                };
            },
            processResults: function (response) {
                return {
                    results: response
                };
            }
        }
    });

    function verifyPeriod() {
        var date = $("#date").val();
        if (date != '') {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url();?>admin/verifyPeriod/",
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
                        $("#msgDate").text("No puede editar partidas de este periodo");
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
                url: "<?php echo base_url();?>admin/nomenByIDJson",
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
                            url: "<?php echo base_url();?>admin/inputsPurchase",
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
                url: "<?php echo base_url();?>admin/addFieldSelect/",
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
                    console.log(data);
                    $("#btnSelect").prop("disabled", false);
                    $("#btnSelect").removeClass("spinner-border");
                    $("#msgRubro").text('');
                    $("#rowInputs").append(data.field);
                    cont++;
                    addHdg = false;
                    sumarTotales();
                },
                error: function () {
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
                    url: "<?php echo base_url();?>admin/nomenByIDJson",
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
                    url: "<?php echo base_url();?>admin/addIVASelect/",
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
                    url: "<?php echo base_url();?>admin/addISRSelect/",
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
        var cant = 0; var sin_iva = 0; var iva = 0; var isr = 0; var reten = 0; var iva_cant = 0; var reten_cant = 0; var res = 0; var parte = 0;
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
            var divReten = $("#rowReten_"+i).length;
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
            if (divIVA > 0) {
                if (reg == 'G') {
                    sin_iva = cant / 1.12;
                    iva = sin_iva * 0.12;
                    reten = iva * 0.15;
                } else if (reg == 'P') {
                    iva = cant * 0.05;
                    sin_iva = cant - iva;
                    reten = iva * 0.05;
                }
            } else {
                sin_iva = cant;
                if (reg == 'G') reten = sin_iva * 0.15;
                else if (reg == 'P') reten = sin_iva * 0.05;
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
                    url: "<?php echo base_url();?>admin/addRetenSelect/",
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
                sumarTotales();
            } else {
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url();?>admin/addExenSelect/",
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
            var total = Number($("#total").val());
            $.ajax({
                type: "POST",
                url: "<?php echo base_url();?>admin/inputsPurchase/",
                data: {
                    cont: purCont,
                    total: total,
                },
                dataType: "json",
                beforeSend: function () {
                    addPur = true;
                    $("#btnPurchase").prop("disabled", true);
                    $("#btnPurchase").addClass("spinner-border");
                },
                success: function (data) {
                    $("#rowsPurchase").append(data.inputs);
                    cantPartial(purCont);
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
        console.log("removePurchase: "+i);
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
        console.log("sumPartial");
        console.log("Cant:", $("input[name='cant[]']").length, "IVA:", $("input[name='iva_pur[]']").length, "ISR:", $("input[name='isr_pur[]']").length,);
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
        console.log("Cantidad:", totCant, "IVA:", totIVA, "ISR:", totISR);
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
            $(".check-purchase").each(function() {
                $(this).prop("checked", true);
            });
        } else {
            $("#tablePurchase").hide(500);
            $(".check-purchase").each(function() {
                $(this).prop("checked", false);
            });
        }
    }

    function dataProvider(id, i, c) {
        if (id != '' && id != 'N') {
            $("#dataProvider_"+i).hide(300);
            $.ajax({
                type: "POST",
                url: "<?php echo base_url();?>admin/getProviderJson/",
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

    function searchNumDoc(i, id) {
        var number = $("#number_"+i).val();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url();?>admin/countOtherExistPurchase/",
            data: {
                id: id,
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
        if (period == false) mensaje += 'No se puede editar la partida con la fecha establecida por cierres.<br>'; 

        if (mensaje.length > 0) {
            $("#msgVerifyData").html(mensaje);
        } else {
            $("#msgVerifyData").html('');
        }
        
    }

    function deleteDetail(i, id, inx) {
        Swal.fire({
            title: '¡Advertencia!',
            text: "Si eliminas este rubro, el cambio se aplicará de manera inmediata, y no podrá revertirse, deberás agregarlo de nuevo.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Eliminar',
            cancelButtonText: 'Cancelar',
            padding: '2em'
        }).then(function(result) {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url();?>admin/departure_edit/deactivate_detail/",
                    data: {
                        id: id,
                    },
                    beforeSend: function () {
                        Swal.fire({
                            title: "Cargando",
                            text: "Espera a que se eliminé el rubro.",
                            padding: '2em',
                            allowOutsideClick: false,
                            onOpen: function () {
                                swal.showLoading()
                            }
                        });
                    },
                    success: function (response) {
                        console.log(response);
                        if (response == 1) {
                            Swal.fire({
                                title: 'Hecho!',
                                text: "El rubro ha sido eliminado de la partida.",
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonText: 'OK',
                                padding: '2em'
                            }).then(function(){
                                if (inx == "IVA") deleteIVA(i);
                                else if (inx == "ISR") deleteISR(i);
                                else if (inx == "Reten") deleteReten(i);
                                else if (inx == "Exen") deleteExen(i);
                                else deleteParent(i);
                            });
                        } else {
                            Swal.fire({
                                title: 'Vaya!',
                                text: "Ha ocurrido un error, intentalo más tarde.",
                                icon: 'error',
                                showCancelButton: false,
                                confirmButtonText: 'OK',
                                padding: '2em'
                            });
                        }
                    },
                    error: function (e) {
                        console.log("Error: ", e);
                        Swal.fire({
                            title: 'Vaya!',
                            text: "Ha ocurrido un error, intentalo más tarde.",
                            icon: 'error',
                            showCancelButton: false,
                            confirmButtonText: 'OK',
                            padding: '2em'
                        });
                    }
                });
            }
        });
    }
    
    function deletePurchase(i, id) {
        Swal.fire({
            title: '¡Advertencia!',
            text: "Si eliminas esta factura, el cambio se aplicará de manera inmediata, y no podrá revertirse, deberás agregarla de nuevo.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Eliminar',
            cancelButtonText: 'Cancelar',
            padding: '2em'
        }).then(function(result) {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url();?>admin/departure_edit/deactivate_purchase/",
                    data: {
                        id: id,
                    },
                    beforeSend: function () {
                        Swal.fire({
                            title: "Cargando",
                            text: "Espera a que se eliminé la factura.",
                            padding: '2em',
                            allowOutsideClick: false,
                            onOpen: function () {
                                swal.showLoading()
                            }
                        });
                    },
                    success: function (response) {
                        console.log(response);
                        if (response == 1) {
                            removePurchase(i);
                            Swal.fire({
                                title: 'Hecho!',
                                text: "La factura ha sido eliminada.",
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonText: 'OK',
                                padding: '2em'
                            });
                        } else {
                            Swal.fire({
                                title: 'Vaya!',
                                text: "Ha ocurrido un error, intentalo más tarde.",
                                icon: 'error',
                                showCancelButton: false,
                                confirmButtonText: 'OK',
                                padding: '2em'
                            });
                        }
                    },
                    error: function (e) {
                        console.log("Error: ", e);
                        Swal.fire({
                            title: 'Vaya!',
                            text: "Ha ocurrido un error, intentalo más tarde.",
                            icon: 'error',
                            showCancelButton: false,
                            confirmButtonText: 'OK',
                            padding: '2em'
                        });
                    }
                });
            }
        });
    }
</script>