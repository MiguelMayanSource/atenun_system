<?php 
    setlocale(LC_TIME,"es_ES");
    $checks = json_decode($this->crud_model->getInfo("checks_bank"));
    $movs = $this->crud_model->getTransferAccount($account_id, $initial, $final, $no_policy);
    $adjs = $this->crud_model->getTransferAdjustAccount($account_id, $initial, $final, $no_policy);
    $info = $this->crud_model->getInfoAccount($account_id);
    $saldo = $this->crud_model->getInitialBalanceBank($account_id, $initial);
    log_message("error", "Libro de bancos");
    log_message("error", "Saldo inicial: $saldo");
    $totEg = 0; $totIn = 0; $nIn = 0; $nEg = 0;
    $totVen = 0; $totCob1 = 0; $totPre = 0; $totCob2 = 0; $totCob3 = 0; $totCob4 = 0; $totCob5 = 0; $totAnt = 0; $totInt = 0; $totTra1 = 0; $totOtro1 = 0; 
    $totCom = 0; $totPro = 0; $totPOp = 0; $totPAn = 0; $totPPr = 0; $totDiv = 0; $totPag1 = 0; $totPag2 = 0; $totPag3 = 0; $totTra2 = 0; $totGas = 0; $totDec = 0; $totOtro2 = 0;
    $sumIn = 0; $sumEg = 0; $nCol = 6; $nRow = 3;
?>
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
                <a class="add-buton" href="<?php echo base_url();?>doctor/accounting/">Regresar</a>
                <a class="add-buton" href="javascript:void(0);" onclick="modal_lg('<?php echo base_url();?>modal/popup/modal_accounting_books/')">Libros contables</a>
            </div>
            <div class="card-box">
                <div class="card-b">
                    <div class="row">
                        <div class="col-lg-12 mb-3">
                            <div class="title-header">
                                <h4 class="card-title mb-4">Libro de Bancos</h4>
                            </div>
                            <form class="repeater" action="<?php echo base_url();?>doctor/bank_book/" method="POST" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="">Cuentas bancarias</label>
                                            <select name="account_id" id="account_id" class="form-control" onchange="this.form.submit()">
                                                <option value="">Selecciona una cuenta</option>
                                                <?php $accounts = $this->crud_model->getBankAccountsActive();
                                                    foreach ($accounts->result_array() as $ac):?>
                                                <option value="<?php echo $ac['bank_account_id'];?>" <?php if($ac['bank_account_id'] == $account_id) echo "selected";?>><?php echo $ac['code'].' '.$ac['name'];?></option>
                                                <?php endforeach;?>
                                            </select>
                                            <small class="text-danger" id="msgAccount"></small>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="">No. de póliza</label>
                                            <input type="text" class="form-control" name="no_policy" value="<?php echo $no_policy;?>" />
                                        </div>
                                    </div>
                                    <div class="col-lg-5">
                                        <div class="form-group">
                                            <label for="">Fecha inicial</label>
                                            <input type="date" class="form-control" name="initial" value="<?php echo $initial;?>" />
                                            <small class="text-danger" id="msgInitial"></small>
                                        </div>
                                    </div>
                                    <div class="col-lg-5">
                                        <div class="form-group">
                                            <label for="">Fecha final</label>
                                            <input type="date" class="form-control" name="final" value="<?php echo $final;?>" />
                                            <small class="text-danger" id="msgFinal"></small>
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <br>
                                        <div class="col-mb-3">
                                            <div class="">
                                                <button class="btn btn-info" type="submit">
                                                    <i class="mdi mdi-eye"></i>
                                                    <span>Ver</span>
                                                </button>
                                                &nbsp;
                                                &nbsp;
                                                <input type="button" class="btn btn-danger" value="PDF" onclick="submitFormType('PDF')" />
                                                &nbsp;
                                                &nbsp;
                                                <input type="button" class="btn btn-success" value="EXCEL" onclick="submitFormType('EXCEL')" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-lg-5 mb-3">
                            <table class="table-bordered">
                                <tr>
                                    <td><b>Banco:</b></td>
                                    <td><span id="txtBank"><?php echo $info['bank'];?></span></td>
                                </tr>
                                <tr>
                                    <td><b>NOMBRE:</b></td>
                                    <td><span id="txtNombre"><?php echo $info['name_account'];?></span></td>
                                </tr>
                                <tr>
                                    <td><b>MONEDA:</b></td>
                                    <td><span id="txtMoneda"><?php echo $info['symbol'].' - '.$info['currency'];?></span></td>
                                </tr>
                                <tr>
                                    <td><b>NÚMERO:</b></td>
                                    <td><span id="txtNumero"><?php echo $info['code'];?></span></td>
                                </tr>
                                <tr>
                                    <td><b>Rubro del sistema contable:</b></td>
                                    <td><span id="txtRubro"><?php echo $info['key_code'].' '.$info['heading'];?></span></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-lg-4" style="">
                            <div class="dropdown" style="">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-expanded="false" area-haspopup="true">
                                    Ocultar columnas <i class="mdi mdi-chevron-down"></i>
                                </button>
                                <div class="dropdown-menu" style="" aria-labelledby="dropdownMenuButton">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="dropdown-item">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="checks_moves[]" id="check-move-25" value="25" onclick="colHideAjax(this, 25)" />
                                                    <label class="form-check-label" for="check-move-25">Categoria</label>
                                                </div>
                                            </div>
                                            <div class="dropdown-item text-center">Ingresos</div>
                                            <div class="dropdown-item">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="checks_moves[]" id="check-move-1" value="1" onclick="colHideAjax(this, 1)" />
                                                    <label class="form-check-label" for="check-move-1">Ventas al contado</label>
                                                </div>
                                            </div>
                                            <div class="dropdown-item">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="checks_moves[]" id="check-move-2" value="2" onclick="colHideAjax(this, 2)" />
                                                    <label class="form-check-label" for="check-move-2">Cobros Ctas. por <br>cobrar locales</label>
                                                </div>
                                            </div>
                                            <div class="dropdown-item">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="checks_moves[]" id="check-move-3" value="3" onclick="colHideAjax(this, 3)" />
                                                    <label class="form-check-label" for="check-move-3">Préstamos bancarios <br>desembolso</label>
                                                </div>
                                            </div>
                                            <div class="dropdown-item">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="checks_moves[]" id="check-move-4" value="4" onclick="colHideAjax(this, 4)" />
                                                    <label class="form-check-label" for="check-move-4">Cobros Ctas. por <br>cobrar exterior</label>
                                                </div>
                                            </div>
                                            <div class="dropdown-item">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="checks_moves[]" id="check-move-5" value="5" onclick="colHideAjax(this, 5)" />
                                                    <label class="form-check-label" for="check-move-5">Cobros Ctas. por <br>cobrar relacionadas locales <br>y del exterior(1)</label>
                                                </div>
                                            </div>
                                            <div class="dropdown-item">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="checks_moves[]" id="check-move-6" value="6" onclick="colHideAjax(this, 6)" />
                                                    <label class="form-check-label" for="check-move-6">Cobros Ctas. por <br>cobrar socios (2)</label>
                                                </div>
                                            </div>
                                            <div class="dropdown-item">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="checks_moves[]" id="check-move-7" value="7" onclick="colHideAjax(this, 7)" />
                                                    <label class="form-check-label" for="check-move-7">Cobros Ctas. por <br>cobrar empleados</label>
                                                </div>
                                            </div>
                                            <div class="dropdown-item">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="checks_moves[]" id="check-move-8" value="8" onclick="colHideAjax(this, 8)" />
                                                    <label class="form-check-label" for="check-move-8">Anticipo clientes</label>
                                                </div>
                                            </div>
                                            <div class="dropdown-item">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="checks_moves[]" id="check-move-9" value="9" onclick="colHideAjax(this, 9)" />
                                                    <label class="form-check-label" for="check-move-9">Intereses ganados</label>
                                                </div>
                                            </div>
                                            <div class="dropdown-item">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="checks_moves[]" id="check-move-10" value="10" onclick="colHideAjax(this, 10)" />
                                                    <label class="form-check-label" for="check-move-10">Transferencia de Fondos <br>entre cuentas (3)</label>
                                                </div>
                                            </div>
                                            <div class="dropdown-item">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="checks_moves[]" id="check-move-11" value="11" onclick="colHideAjax(this, 11)" />
                                                    <label class="form-check-label" for="check-move-11">Otros ingresos</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="dropdown-item text-center">Egresos</div>
                                            <div class="dropdown-item">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="checks_moves[]" id="check-move-12" value="12" onclick="colHideAjax(this, 12)" />
                                                    <label class="form-check-label" for="check-move-12">Pago compras al Contado</label>
                                                </div>
                                            </div>
                                            <div class="dropdown-item">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="checks_moves[]" id="check-move-13" value="13" onclick="colHideAjax(this, 13)" />
                                                    <label class="form-check-label" for="check-move-13">Pago proveedores</label>
                                                </div>
                                            </div>
                                            <div class="dropdown-item">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="checks_moves[]" id="check-move-14" value="14" onclick="colHideAjax(this, 14)" />
                                                    <label class="form-check-label" for="check-move-14">Pago Gastos Operativos</label>
                                                </div>
                                            </div>
                                            <div class="dropdown-item">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="checks_moves[]" id="check-move-15" value="15" onclick="colHideAjax(this, 15)" />
                                                    <label class="form-check-label" for="check-move-15">Pagos Anticipados</label>
                                                </div>
                                            </div>
                                            <div class="dropdown-item">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="checks_moves[]" id="check-move-16" value="16" onclick="colHideAjax(this, 16)" />
                                                    <label class="form-check-label" for="check-move-16">Pago de Prestamos (4)</label>
                                                </div>
                                            </div>
                                            <div class="dropdown-item">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="checks_moves[]" id="check-move-17" value="17" onclick="colHideAjax(this, 17)" />
                                                    <label class="form-check-label" for="check-move-17">Pago Dividendos (5)</label>
                                                </div>
                                            </div>
                                            <div class="dropdown-item">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="checks_moves[]" id="check-move-18" value="18" onclick="colHideAjax(this, 18)" />
                                                    <label class="form-check-label" for="check-move-18">Cuentas por Pagar <br>Socios (6)</label>
                                                </div>
                                            </div>
                                            <div class="dropdown-item">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="checks_moves[]" id="check-move-19" value="19" onclick="colHideAjax(this, 19)" />
                                                    <label class="form-check-label" for="check-move-19">Cuentas por pagar <br>relacionadas locales (7)</label>
                                                </div>
                                            </div>
                                            <div class="dropdown-item">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="checks_moves[]" id="check-move-20" value="20" onclick="colHideAjax(this, 20)" />
                                                    <label class="form-check-label" for="check-move-20">Cuentas por pagar <br>relacionadas exterior (8)</label>
                                                </div>
                                            </div>
                                            <div class="dropdown-item">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="checks_moves[]" id="check-move-21" value="21" onclick="colHideAjax(this, 21)" />
                                                    <label class="form-check-label" for="check-move-21">Transferencia de Fondos <br>entre Ctas. Bancarias (9)</label>
                                                </div>
                                            </div>
                                            <div class="dropdown-item">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="checks_moves[]" id="check-move-22" value="22" onclick="colHideAjax(this, 22)" />
                                                    <label class="form-check-label" for="check-move-22">Gastos financieros</label>
                                                </div>
                                            </div>
                                            <div class="dropdown-item">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="checks_moves[]" id="check-move-23" value="23" onclick="colHideAjax(this, 23)" />
                                                    <label class="form-check-label" for="check-move-23">Pagos a Declaraguate</label>
                                                </div>
                                            </div>
                                            <div class="dropdown-item">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="checks_moves[]" id="check-move-24" value="24" onclick="colHideAjax(this, 24)" />
                                                    <label class="form-check-label" for="check-move-24">Otros egresos</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="">Buscar</label>
                                <input type="search" class="form-control" name="search" id="search" value="" onkeyup="searchValues()" />
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="table-rep-plugin">
                                <div class="table-responsive mb-0" data-pattern="priority-columns">
                                    <table id="table-companies-1" class="table table-stripped table-bordered mb-0">
                                        <thead>
                                            <tr>
                                                <th colspan="7" class="text-center table-danger" id="col-concept">DEL <?php echo strtoupper(strftime("%d DEL %B", strtotime($initial)).' AL '.strftime("%d DE %B DEL %Y", strtotime($final)));?></th>
                                                <th colspan="11" class="text-center table-info" id="move-income">Ingresos</th>
                                                <th colspan="13" class="text-center table-success" id="move-expense">Egresos</th>
                                            </tr>
                                            <tr>
                                                <th class="text-center table-danger move-25"></th>
                                                <th class="text-center table-danger">Fecha</th>
                                                <th class="text-center table-danger">Descripción</th>
                                                <th class="text-center table-danger">No. de póliza</th>
                                                <th class="text-center table-danger">Egresos</th>
                                                <th class="text-center table-danger">Ingresos</th>
                                                <th class="text-center table-danger">Acumulado</th>
                                                <th class="text-center table-info move-1">Ventas al<br>Contado</th>
                                                <th class="text-center table-info move-2">Cobros Ctas.<br>por cobrar<br>locales</th>
                                                <th class="text-center table-info move-3">Préstamos<br>bancarios<br>desembolso</th>
                                                <th class="text-center table-info move-4">Cobros Ctas.<br>por cobrar<br>exterior</th>
                                                <th class="text-center table-warning move-5">Cobros Ctas.<br>por cobrar<br>relacionadas<br>locales y del<br>exterior (1)</th>
                                                <th class="text-center table-warning move-6">Cobros Ctas.<br>por cobrar<br>socios (2)</th>
                                                <th class="text-center table-info move-7">Cobros Ctas.<br>por cobrar<br>empleados</th>
                                                <th class="text-center table-info move-8">Anticipo<br>clientes</th>
                                                <th class="text-center table-info move-9">Intereses<br>ganados</th>
                                                <th class="text-center table-info move-10">Transferencia<br>de Fondos<br>entre cuentas<br>(3)</th>
                                                <th class="text-center table-info move-11">Otros ingresos</th>
                                                <th class="text-center table-warning move-12">Pago compras<br>al Contado</th>
                                                <th class="text-center table-success move-13">Pago<br>proveedores</th>
                                                <th class="text-center table-success move-14">Pago Gastos<br>Operativos</th>
                                                <th class="text-center table-success move-15">Pagos<br>Anticipados</th>
                                                <th class="text-center table-warning move-16">Pago de<br>Prestamos (4)</th>
                                                <th class="text-center table-warning move-17">Pago<br>Dividendos (5)</th>
                                                <th class="text-center table-warning move-18">Cuentas por<br>Pagar Socios<br>(6)</th>
                                                <th class="text-center table-warning move-19">Cuentas por<br>pagar<br>relacionadas<br>locales (7)</th>
                                                <th class="text-center table-warning move-20">Cuentas por<br>pagar<br>Relacionadas<br>Exterior (8)</th>
                                                <th class="text-center table-warning move-21">Transferencia<br>de Fondos<br>entre Ctas.<br>Bancarias (9)</th>
                                                <th class="text-center table-success move-22">Gastos<br>financieros</th>
                                                <th class="text-center table-success move-23">Pagos a<br>Declaraguate</th>
                                                <th class="text-center table-success move-24">Otros egresos</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if($account_id != ''):?>
                                            <tr>
                                                <td class="table-danger move-25"></td>
                                                <td class="table-danger"><?php echo strtoupper(strftime("%B", strtotime($initial)));?></td>
                                                <td class="table-danger text-center">SALDO INICIAL</td>
                                                <td class="table-danger"></td>
                                                <td class="table-danger"></td>
                                                <td class="table-danger"></td>
                                                <td class="table-danger">
                                                    <div class="container-justify">
                                                        <div><?php if($saldo < 0) echo '-';?>Q</div>
                                                        <div><?php echo number_format(abs($saldo),2,'.',',');?></div>
                                                    </div>
                                                </td>
                                                <td class="table-info move-1"></td>
                                                <td class="table-info move-2"></td>
                                                <td class="table-info move-3"></td>
                                                <td class="table-info move-4"></td>
                                                <td class="table-info move-5"></td>
                                                <td class="table-info move-6"></td>
                                                <td class="table-info move-7"></td>
                                                <td class="table-info move-8"></td>
                                                <td class="table-info move-9"></td>
                                                <td class="table-info move-10"></td>
                                                <td class="table-info move-11"></td>
                                                <td class="table-success move-12"></td>
                                                <td class="table-success move-13"></td>
                                                <td class="table-success move-14"></td>
                                                <td class="table-success move-15"></td>
                                                <td class="table-success move-16"></td>
                                                <td class="table-success move-17"></td>
                                                <td class="table-success move-18"></td>
                                                <td class="table-success move-19"></td>
                                                <td class="table-success move-20"></td>
                                                <td class="table-success move-21"></td>
                                                <td class="table-success move-22"></td>
                                                <td class="table-success move-23"></td>
                                                <td class="table-success move-24"></td>
                                            </tr>
                                            <?php endif;?>
                                            <?php $cont = 1; foreach ($movs->result_array() as $mv):
                                                $acc = $this->crud_model->getAccountBank($mv['bank_account_id']);
                                                $no_policy = $this->crud_model->getNoPolicyByBank($mv['reference_id'], $acc['nomenclature_id']);?>
                                            <tr>
                                                <td class="table-danger move-25">
                                                    <div class="form-group" style="min-width: 150px;">
                                                        <select name="" id="category_<?php echo $cont;?>" class="form-select" onchange="saveCategory(this.value, <?php echo $mv['bank_transfer_id'];?>)">
                                                            <option value="" <?php if($mv['category'] == '') echo "selected";?>></option>
                                                            <option value="5" <?php if($mv['category'] == 5) echo "selected";?>>Registrado</option>
                                                            <option value="1" <?php if($mv['category'] == 1) echo "selected";?>>Notas de Crédito</option>
                                                            <option value="2" <?php if($mv['category'] == 2) echo "selected";?>>Notas de Débito</option>
                                                            <option value="3" <?php if($mv['category'] == 3) echo "selected";?>>Cheques girados<br>y no cobrados</option>
                                                            <option value="4" <?php if($mv['category'] == 4) echo "selected";?>>Dépositos en transito</option>
                                                        </select>
                                                    </div>
                                                </td>
                                                <td class="table-danger"><?php echo date("d/m/Y", strtotime($mv['date']));?></td>
                                                <td class="table-danger">
                                                    <?php if($mv['no_check'] != '') echo "No. Cheque: ".$mv['no_check'];
                                                        if($mv['description'] != '' && $mv['no_check'] != '') echo ", "; 
                                                        echo $mv['description'];
                                                        if($mv['description'] != '' && $mv['no_check'] == '') echo ", "; 
                                                        if($mv['no_check'] == '') echo $mv['code'];?>
                                                </td>
                                                <td class="table-danger text-center"><?php echo $no_policy;?></td>
                                                <td class="<?php if($mv['type'] != 0) echo "table-danger"; elseif($mv['category'] == '') echo "table-danger"; elseif($mv['category'] == 5) echo "table-warning"; else echo "table-success";?>" <?php if($mv['type'] == 0) echo 'id="cellAmount_'.$mv['bank_transfer_id'].'"';?>>
                                                    <div class="container-justify">
                                                        <div>Q</div>
                                                        <div><?php if($mv['type'] == 0) echo number_format($mv['amount'],2,'.',','); else echo '-';?></div>
                                                    </div>
                                                </td>
                                                <td class="<?php if($mv['type'] != 1) echo "table-danger"; elseif($mv['category'] == '') echo "table-danger"; elseif($mv['category'] == 5) echo "table-warning"; else echo "table-success";?>" <?php if($mv['type'] == 1) echo 'id="cellAmount_'.$mv['bank_transfer_id'].'"';?>>
                                                    <div class="container-justify">
                                                        <div>Q</div>
                                                        <div><?php if($mv['type'] == 1) echo number_format($mv['amount'],2,'.',','); else echo '-';?></div>
                                                    </div>
                                                </td>
                                                <?php if($mv['type'] == 1) $saldo += $mv['amount']; if($mv['type'] == 0) $saldo -= $mv['amount'];?>
                                                <td class="table-danger">
                                                    <div class="container-justify">
                                                        <div><?php if($saldo < 0) echo '-';?>Q</div>
                                                        <div><?php echo number_format(abs($saldo),2,'.',',');?></div>
                                                    </div>
                                                </td>
                                                <td class="table-info move-1">
                                                    <div class="container-justify">
                                                        <?php if($mv['move'] == 1):?>
                                                        <div>Q</div>
                                                        <div><?php echo number_format($mv['amount'],2,'.',',');?></div>
                                                        <?php endif;?>
                                                    </div>
                                                </td>
                                                <td class="table-info move-2">
                                                    <div class="container-justify">
                                                        <?php if($mv['move'] == 2):?>
                                                        <div>Q</div>
                                                        <div><?php echo number_format($mv['amount'],2,'.',',');?></div>
                                                        <?php endif;?>
                                                    </div>
                                                </td>
                                                <td class="table-info move-3">
                                                    <div class="container-justify">
                                                        <?php if($mv['move'] == 3):?>
                                                        <div>Q</div>
                                                        <div><?php echo number_format($mv['amount'],2,'.',',');?></div>
                                                        <?php endif;?>
                                                    </div>
                                                </td>
                                                <td class="table-info move-4">
                                                    <div class="container-justify">
                                                        <?php if($mv['move'] == 4):?>
                                                        <div>Q</div>
                                                        <div><?php echo number_format($mv['amount'],2,'.',',');?></div>
                                                        <?php endif;?>
                                                    </div>
                                                </td>
                                                <td class="table-info move-5">
                                                    <div class="container-justify">
                                                        <?php if($mv['move'] == 5):?>
                                                        <div>Q</div>
                                                        <div><?php echo number_format($mv['amount'],2,'.',',');?></div>
                                                        <?php endif;?>
                                                    </div>
                                                </td>
                                                <td class="table-info move-6">
                                                    <div class="container-justify">
                                                        <?php if($mv['move'] == 6):?>
                                                        <div>Q</div>
                                                        <div><?php echo number_format($mv['amount'],2,'.',',');?></div>
                                                        <?php endif;?>
                                                    </div>
                                                </td>
                                                <td class="table-info move-7">
                                                    <div class="container-justify">
                                                        <?php if($mv['move'] == 7):?>
                                                        <div>Q</div>
                                                        <div><?php echo number_format($mv['amount'],2,'.',',');?></div>
                                                        <?php endif;?>
                                                    </div>
                                                </td>
                                                <td class="table-info move-8">
                                                    <div class="container-justify">
                                                        <?php if($mv['move'] == 8):?>
                                                        <div>Q</div>
                                                        <div><?php echo number_format($mv['amount'],2,'.',',');?></div>
                                                        <?php endif;?>
                                                    </div>
                                                </td>
                                                <td class="table-info move-9">
                                                    <div class="container-justify">
                                                        <?php if($mv['move'] == 9):?>
                                                        <div>Q</div>
                                                        <div><?php echo number_format($mv['amount'],2,'.',',');?></div>
                                                        <?php endif;?>
                                                    </div>
                                                </td>
                                                <td class="table-info move-10">
                                                    <div class="container-justify">
                                                        <?php if($mv['move'] == 10):?>
                                                        <div>Q</div>
                                                        <div><?php echo number_format($mv['amount'],2,'.',',');?></div>
                                                        <?php endif;?>
                                                    </div>
                                                </td>
                                                <td class="table-info move-11">
                                                    <div class="container-justify">
                                                        <?php if($mv['move'] == 11):?>
                                                        <div>Q</div>
                                                        <div><?php echo number_format($mv['amount'],2,'.',',');?></div>
                                                        <?php endif;?>
                                                    </div>
                                                </td>
                                                <td class="table-success move-12">
                                                    <div class="container-justify">
                                                        <?php if($mv['move'] == 12):?>
                                                        <div>Q</div>
                                                        <div><?php echo number_format($mv['amount'],2,'.',',');?></div>
                                                        <?php endif;?>
                                                    </div>
                                                </td>
                                                <td class="table-success move-13">
                                                    <div class="container-justify">
                                                        <?php if($mv['move'] == 13):?>
                                                        <div>Q</div>
                                                        <div><?php echo number_format($mv['amount'],2,'.',',');?></div>
                                                        <?php endif;?>
                                                    </div>
                                                </td>
                                                <td class="table-success move-14">
                                                    <div class="container-justify">
                                                        <?php if($mv['move'] == 14):?>
                                                        <div>Q</div>
                                                        <div><?php echo number_format($mv['amount'],2,'.',',');?></div>
                                                        <?php endif;?>
                                                    </div>
                                                </td>
                                                <td class="table-success move-15">
                                                    <div class="container-justify">
                                                        <?php if($mv['move'] == 15):?>
                                                        <div>Q</div>
                                                        <div><?php echo number_format($mv['amount'],2,'.',',');?></div>
                                                        <?php endif;?>
                                                    </div>
                                                </td>
                                                <td class="table-success move-16">
                                                    <div class="container-justify">
                                                        <?php if($mv['move'] == 16):?>
                                                        <div>Q</div>
                                                        <div><?php echo number_format($mv['amount'],2,'.',',');?></div>
                                                        <?php endif;?>
                                                    </div>
                                                </td>
                                                <td class="table-success move-17">
                                                    <div class="container-justify">
                                                        <?php if($mv['move'] == 17):?>
                                                        <div>Q</div>
                                                        <div><?php echo number_format($mv['amount'],2,'.',',');?></div>
                                                        <?php endif;?>
                                                    </div>
                                                </td>
                                                <td class="table-success move-18">
                                                    <div class="container-justify">
                                                        <?php if($mv['move'] == 18):?>
                                                        <div>Q</div>
                                                        <div><?php echo number_format($mv['amount'],2,'.',',');?></div>
                                                        <?php endif;?>
                                                    </div>
                                                </td>
                                                <td class="table-success move-19">
                                                    <div class="container-justify">
                                                        <?php if($mv['move'] == 19):?>
                                                        <div>Q</div>
                                                        <div><?php echo number_format($mv['amount'],2,'.',',');?></div>
                                                        <?php endif;?>
                                                    </div>
                                                </td>
                                                <td class="table-success move-20">
                                                    <div class="container-justify">
                                                        <?php if($mv['move'] == 20):?>
                                                        <div>Q</div>
                                                        <div><?php echo number_format($mv['amount'],2,'.',',');?></div>
                                                        <?php endif;?>
                                                    </div>
                                                </td>
                                                <td class="table-success move-21">
                                                    <div class="container-justify">
                                                        <?php if($mv['move'] == 21):?>
                                                        <div>Q</div>
                                                        <div><?php echo number_format($mv['amount'],2,'.',',');?></div>
                                                        <?php endif;?>
                                                    </div>
                                                </td>
                                                <td class="table-success move-22">
                                                    <div class="container-justify">
                                                        <?php if($mv['move'] == 22):?>
                                                        <div>Q</div>
                                                        <div><?php echo number_format($mv['amount'],2,'.',',');?></div>
                                                        <?php endif;?>
                                                    </div>
                                                </td>
                                                <td class="table-success move-23">
                                                    <div class="container-justify">
                                                        <?php if($mv['move'] == 23):?>
                                                        <div>Q</div>
                                                        <div><?php echo number_format($mv['amount'],2,'.',',');?></div>
                                                        <?php endif;?>
                                                    </div>
                                                </td>
                                                <td class="table-success move-24">
                                                    <div class="container-justify">
                                                        <?php if($mv['move'] == 24):?>
                                                        <div>Q</div>
                                                        <div><?php echo number_format($mv['amount'],2,'.',',');?></div>
                                                        <?php endif;?>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php if($mv['type'] == 0) $totEg += $mv['amount']; if($mv['type'] == 1) $totIn += $mv['amount']; 
                                                if($mv['move'] == 1) $totVen += $mv['amount']; if($mv['move'] == 2) $totCob1 += $mv['amount']; if($mv['move'] == 3) $totPre += $mv['amount']; if($mv['move'] == 4) $totCob2 += $mv['amount']; 
                                                if($mv['move'] == 5) $totCob3 += $mv['amount']; if($mv['move'] == 6) $totCob4 += $mv['amount']; if($mv['move'] == 7) $totCob5 += $mv['amount']; if($mv['move'] == 8) $totAnt += $mv['amount']; 
                                                if($mv['move'] == 9) $totInt += $mv['amount']; if($mv['move'] == 10) $totTra1 += $mv['amount']; if($mv['move'] == 11) $totOtro1 += $mv['amount']; if($mv['move'] == 12) $totCom += $mv['amount']; 
                                                if($mv['move'] == 13) $totPro += $mv['amount']; if($mv['move'] == 14) $totPOp += $mv['amount']; if($mv['move'] == 15) $totPAn += $mv['amount']; if($mv['move'] == 16) $totPPr += $mv['amount']; 
                                                if($mv['move'] == 17) $totDiv += $mv['amount']; if($mv['move'] == 18) $totPag1 += $mv['amount']; if($mv['move'] == 19) $totPag2 += $mv['amount']; if($mv['move'] == 20) $totPag3 += $mv['amount']; 
                                                if($mv['move'] == 21) $totTra2 += $mv['amount']; if($mv['move'] == 22) $totGas += $mv['amount']; if($mv['move'] == 23) $totDec += $mv['amount']; if($mv['move'] == 24) $totOtro2 += $mv['amount'];
                                                
                                                $cont++; endforeach;
                                                log_message("error", "Egresos: $totIn");
                                                log_message("error", "Ingresos: $totEg");?>
                                            <?php if($account_id != ''):?>
                                            <tr>
                                                <td class="table-danger move-25"></td>
                                                <td class="table-danger"></td>
                                                <td class="table-danger">Ajustes</td>
                                                <td class="table-danger"></td>
                                                <td class="table-danger"></td>
                                                <td class="table-danger"></td>
                                                <td class="table-danger">
                                                    <div class="container-justify">
                                                        <div><?php if($saldo < 0) echo '-';?>Q</div>
                                                        <div><?php echo number_format(abs($saldo),2,'.',',');?></div>
                                                    </div>
                                                </td>
                                                <td class="table-info move-1"></td>
                                                <td class="table-info move-2"></td>
                                                <td class="table-info move-3"></td>
                                                <td class="table-info move-4"></td>
                                                <td class="table-info move-5"></td>
                                                <td class="table-info move-6"></td>
                                                <td class="table-info move-7"></td>
                                                <td class="table-info move-8"></td>
                                                <td class="table-info move-9"></td>
                                                <td class="table-info move-10"></td>
                                                <td class="table-info move-11"></td>
                                                <td class="table-success move-12"></td>
                                                <td class="table-success move-13"></td>
                                                <td class="table-success move-14"></td>
                                                <td class="table-success move-15"></td>
                                                <td class="table-success move-16"></td>
                                                <td class="table-success move-17"></td>
                                                <td class="table-success move-18"></td>
                                                <td class="table-success move-19"></td>
                                                <td class="table-success move-20"></td>
                                                <td class="table-success move-21"></td>
                                                <td class="table-success move-22"></td>
                                                <td class="table-success move-23"></td>
                                                <td class="table-success move-24"></td>
                                            </tr>
                                            <?php endif;?>
                                            <?php foreach($adjs->result_array() as $ad):
                                                $acc = $this->crud_model->getAccountBank($ad['bank_account_id']);
                                                $no_policy = $this->crud_model->getNoPolicyByBank($ad['reference_id'], $acc['nomenclature_id']);?>
                                            <tr>
                                                <td class="table-danger move-25">
                                                    <div class="form-group" style="min-width: 150px;">
                                                        <select name="" id="category_<?php echo $cont;?>" class="form-select" onchange="saveCategory(this.value, <?php echo $ad['bank_transfer_id'];?>)">
                                                            <option value="" <?php if($ad['category'] == '') echo "selected";?>></option>
                                                            <option value="5" <?php if($ad['category'] == 5) echo "selected";?>>Registrado</option>
                                                            <option value="1" <?php if($ad['category'] == 1) echo "selected";?>>Notas de Crédito</option>
                                                            <option value="2" <?php if($ad['category'] == 2) echo "selected";?>>Notas de Débito</option>
                                                            <option value="3" <?php if($ad['category'] == 3) echo "selected";?>>Cheques girados<br>y no cobrados</option>
                                                            <option value="4" <?php if($ad['category'] == 4) echo "selected";?>>Dépositos en transito</option>
                                                        </select>
                                                    </div>
                                                </td>
                                                <td class="table-danger"><?php echo date("d/m/Y", strtotime($ad['date']));?></td>
                                                <td class="table-danger">
                                                    <?php if($ad['no_check'] != '') echo "No. Cheque: ".$ad['no_check'];
                                                        if($ad['description'] != '' && $ad['no_check'] != '') echo ", "; 
                                                        echo $ad['description'];
                                                        if($ad['description'] != '' && $ad['no_check'] == '') echo ", "; 
                                                        if($ad['no_check'] == '') echo $ad['code'];?>
                                                </td>
                                                <td class="table-danger text-center"><?php echo $no_policy;?></td>
                                                <td class="<?php if($ad['type'] != 0) echo "table-danger"; elseif($ad['category'] == '') echo "table-danger"; elseif($ad['category'] == 5) echo "table-warning"; else echo "table-success";?>" <?php if($ad['type'] == 0) echo 'id="cellAmount_'.$ad['bank_transfer_id'].'"';?>>
                                                    <div class="container-justify">
                                                        <div>Q</div>
                                                        <div><?php if($ad['type'] == 0) echo number_format($ad['amount'],2,'.',','); else echo '-';?></div>
                                                    </div>
                                                </td>
                                                <td class="<?php if($ad['type'] != 1) echo "table-danger"; elseif($ad['category'] == '') echo "table-danger"; elseif($ad['category'] == 5) echo "table-warning"; else echo "table-success";?>" <?php if($ad['type'] == 1) echo 'id="cellAmount_'.$ad['bank_transfer_id'].'"';?>>
                                                    <div class="container-justify">
                                                        <div>Q</div>
                                                        <div><?php if($ad['type'] == 1) echo number_format($ad['amount'],2,'.',','); else echo '-';?></div>
                                                    </div>
                                                </td>
                                                <?php if($ad['type'] == 1) $saldo += $ad['amount']; if($ad['type'] == 0) $saldo -= $ad['amount'];?>
                                                <td class="table-danger"><?php if($saldo < 0) echo '-'; echo "Q.".number_format(abs($saldo),2,".",",");?></td>
                                                <td class="table-info move-1">
                                                    <div class="container-justify">
                                                        <?php if($ad['move'] == 1):?>
                                                        <div>Q</div>
                                                        <div><?php echo number_format($ad['amount'],2,'.',',');?></div>
                                                        <?php endif;?>
                                                    </div>
                                                </td>
                                                <td class="table-info move-2">
                                                    <div class="container-justify">
                                                        <?php if($ad['move'] == 2):?>
                                                        <div>Q</div>
                                                        <div><?php echo number_format($ad['amount'],2,'.',',');?></div>
                                                        <?php endif;?>
                                                    </div>
                                                </td>
                                                <td class="table-info move-3">
                                                    <div class="container-justify">
                                                        <?php if($ad['move'] == 3):?>
                                                        <div>Q</div>
                                                        <div><?php echo number_format($ad['amount'],2,'.',',');?></div>
                                                        <?php endif;?>
                                                    </div>
                                                </td>
                                                <td class="table-info move-4">
                                                    <div class="container-justify">
                                                        <?php if($ad['move'] == 4):?>
                                                        <div>Q</div>
                                                        <div><?php echo number_format($ad['amount'],2,'.',',');?></div>
                                                        <?php endif;?>
                                                    </div>
                                                </td>
                                                <td class="table-info move-5">
                                                    <div class="container-justify">
                                                        <?php if($ad['move'] == 5):?>
                                                        <div>Q</div>
                                                        <div><?php echo number_format($ad['amount'],2,'.',',');?></div>
                                                        <?php endif;?>
                                                    </div>
                                                </td>
                                                <td class="table-info move-6">
                                                    <div class="container-justify">
                                                        <?php if($ad['move'] == 6):?>
                                                        <div>Q</div>
                                                        <div><?php echo number_format($ad['amount'],2,'.',',');?></div>
                                                        <?php endif;?>
                                                    </div>
                                                </td>
                                                <td class="table-info move-7">
                                                    <div class="container-justify">
                                                        <?php if($ad['move'] == 7):?>
                                                        <div>Q</div>
                                                        <div><?php echo number_format($ad['amount'],2,'.',',');?></div>
                                                        <?php endif;?>
                                                    </div>
                                                </td>
                                                <td class="table-info move-8">
                                                    <div class="container-justify">
                                                        <?php if($ad['move'] == 8):?>
                                                        <div>Q</div>
                                                        <div><?php echo number_format($ad['amount'],2,'.',',');?></div>
                                                        <?php endif;?>
                                                    </div>
                                                </td>
                                                <td class="table-info move-9">
                                                    <div class="container-justify">
                                                        <?php if($ad['move'] == 9):?>
                                                        <div>Q</div>
                                                        <div><?php echo number_format($ad['amount'],2,'.',',');?></div>
                                                        <?php endif;?>
                                                    </div>
                                                </td>
                                                <td class="table-info move-10">
                                                    <div class="container-justify">
                                                        <?php if($ad['move'] == 10):?>
                                                        <div>Q</div>
                                                        <div><?php echo number_format($ad['amount'],2,'.',',');?></div>
                                                        <?php endif;?>
                                                    </div>
                                                </td>
                                                <td class="table-info move-11">
                                                    <div class="container-justify">
                                                        <?php if($ad['move'] == 11):?>
                                                        <div>Q</div>
                                                        <div><?php echo number_format($ad['amount'],2,'.',',');?></div>
                                                        <?php endif;?>
                                                    </div>
                                                </td>
                                                <td class="table-success move-12">
                                                    <div class="container-justify">
                                                        <?php if($ad['move'] == 12):?>
                                                        <div>Q</div>
                                                        <div><?php echo number_format($ad['amount'],2,'.',',');?></div>
                                                        <?php endif;?>
                                                    </div>
                                                </td>
                                                <td class="table-success move-13">
                                                    <div class="container-justify">
                                                        <?php if($ad['move'] == 13):?>
                                                        <div>Q</div>
                                                        <div><?php echo number_format($ad['amount'],2,'.',',');?></div>
                                                        <?php endif;?>
                                                    </div>
                                                </td>
                                                <td class="table-success move-14">
                                                    <div class="container-justify">
                                                        <?php if($ad['move'] == 14):?>
                                                        <div>Q</div>
                                                        <div><?php echo number_format($ad['amount'],2,'.',',');?></div>
                                                        <?php endif;?>
                                                    </div>
                                                </td>
                                                <td class="table-success move-15">
                                                    <div class="container-justify">
                                                        <?php if($ad['move'] == 15):?>
                                                        <div>Q</div>
                                                        <div><?php echo number_format($ad['amount'],2,'.',',');?></div>
                                                        <?php endif;?>
                                                    </div>
                                                </td>
                                                <td class="table-success move-16">
                                                    <div class="container-justify">
                                                        <?php if($ad['move'] == 16):?>
                                                        <div>Q</div>
                                                        <div><?php echo number_format($ad['amount'],2,'.',',');?></div>
                                                        <?php endif;?>
                                                    </div>
                                                </td>
                                                <td class="table-success move-17">
                                                    <div class="container-justify">
                                                        <?php if($ad['move'] == 17):?>
                                                        <div>Q</div>
                                                        <div><?php echo number_format($ad['amount'],2,'.',',');?></div>
                                                        <?php endif;?>
                                                    </div>
                                                </td>
                                                <td class="table-success move-18">
                                                    <div class="container-justify">
                                                        <?php if($ad['move'] == 18):?>
                                                        <div>Q</div>
                                                        <div><?php echo number_format($ad['amount'],2,'.',',');?></div>
                                                        <?php endif;?>
                                                    </div>
                                                </td>
                                                <td class="table-success move-19">
                                                    <div class="container-justify">
                                                        <?php if($ad['move'] == 19):?>
                                                        <div>Q</div>
                                                        <div><?php echo number_format($ad['amount'],2,'.',',');?></div>
                                                        <?php endif;?>
                                                    </div>
                                                </td>
                                                <td class="table-success move-20">
                                                    <div class="container-justify">
                                                        <?php if($ad['move'] == 20):?>
                                                        <div>Q</div>
                                                        <div><?php echo number_format($ad['amount'],2,'.',',');?></div>
                                                        <?php endif;?>
                                                    </div>
                                                </td>
                                                <td class="table-success move-21">
                                                    <div class="container-justify">
                                                        <?php if($ad['move'] == 21):?>
                                                        <div>Q</div>
                                                        <div><?php echo number_format($ad['amount'],2,'.',',');?></div>
                                                        <?php endif;?>
                                                    </div>
                                                </td>
                                                <td class="table-success move-22">
                                                    <div class="container-justify">
                                                        <?php if($ad['move'] == 22):?>
                                                        <div>Q</div>
                                                        <div><?php echo number_format($ad['amount'],2,'.',',');?></div>
                                                        <?php endif;?>
                                                    </div>
                                                </td>
                                                <td class="table-success move-23">
                                                    <div class="container-justify">
                                                        <?php if($ad['move'] == 23):?>
                                                        <div>Q</div>
                                                        <div><?php echo number_format($ad['amount'],2,'.',',');?></div>
                                                        <?php endif;?>
                                                    </div>
                                                </td>
                                                <td class="table-success move-24">
                                                    <div class="container-justify">
                                                        <?php if($ad['move'] == 24):?>
                                                        <div>Q</div>
                                                        <div><?php echo number_format($ad['amount'],2,'.',',');?></div>
                                                        <?php endif;?>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php if($ad['type'] == 0) $totEg += $ad['amount']; if($ad['type'] == 1) $totIn += $ad['amount']; 
                                                if($ad['move'] == 1) $totVen += $ad['amount']; if($ad['move'] == 2) $totCob1 += $ad['amount']; if($ad['move'] == 3) $totPre += $ad['amount']; if($ad['move'] == 4) $totCob2 += $ad['amount']; 
                                                if($ad['move'] == 5) $totCob3 += $ad['amount']; if($ad['move'] == 6) $totCob4 += $ad['amount']; if($ad['move'] == 7) $totCob5 += $ad['amount']; if($ad['move'] == 8) $totAnt += $ad['amount']; 
                                                if($ad['move'] == 9) $totInt += $ad['amount']; if($ad['move'] == 10) $totTra1 += $ad['amount']; if($ad['move'] == 11) $totOtro1 += $ad['amount']; if($ad['move'] == 12) $totCom += $ad['amount']; 
                                                if($ad['move'] == 13) $totPro += $ad['amount']; if($ad['move'] == 14) $totPOp += $ad['amount']; if($ad['move'] == 15) $totPAn += $ad['amount']; if($ad['move'] == 16) $totPPr += $ad['amount']; 
                                                if($ad['move'] == 17) $totDiv += $ad['amount']; if($ad['move'] == 18) $totPag1 += $ad['amount']; if($ad['move'] == 19) $totPag2 += $ad['amount']; if($ad['move'] == 20) $totPag3 += $ad['amount']; 
                                                if($ad['move'] == 21) $totTra2 += $ad['amount']; if($ad['move'] == 22) $totGas += $ad['amount']; if($ad['move'] == 23) $totDec += $ad['amount']; if($ad['move'] == 24) $totOtro2 += $ad['amount'];
                                                endforeach;?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th class="table-danger move-25"></th>
                                                <th class="table-danger"><?php if($account_id != '') echo date("d/m/Y", strtotime($mv['date']));?></th>
                                                <th class="table-danger"><?php if($account_id != '') echo "SALDO FINAL PARA EL SIGUIENTE PERIODO";?></th>
                                                <th class="table-danger"></th>
                                                <th class="table-danger"></th>
                                                <th class="table-danger"></th>
                                                <th class="table-danger">
                                                    <div class="container-justify">
                                                        <div>Q</div>
                                                        <div><?php if($saldo > 0) echo number_format($saldo,2,".",","); else echo '-';?></div>
                                                    </div>
                                                </th>
                                                <th class="table-warning move-1">
                                                    <div class="container-justify">
                                                        <div>Q</div>
                                                        <div><?php if($totVen > 0) echo number_format($totVen,2,".",","); else echo '-';?></div>
                                                    </div>
                                                </th>
                                                <th class="move-2">
                                                    <div class="container-justify">
                                                        <div>Q</div>
                                                        <div><?php if($totCob1 > 0) echo number_format($totCob1,2,".",","); else echo '-';?></div>
                                                    </div>
                                                </th>
                                                <th class="table-warning move-3">
                                                    <div class="container-justify">
                                                        <div>Q</div>
                                                        <div><?php if($totPre > 0) echo number_format($totPre,2,".",","); else echo '-';?></div>
                                                    </div>
                                                </th>
                                                <th class="move-4">
                                                    <div class="container-justify">
                                                        <div>Q</div>
                                                        <div><?php if($totCob2 > 0) echo number_format($totCob2,2,".",","); else echo '-';?></div>
                                                    </div>
                                                </th>
                                                <th class="move-5">
                                                    <div class="container-justify">
                                                        <div>Q</div>
                                                        <div><?php if($totCob3 > 0) echo number_format($totCob3,2,".",","); else echo '-';?></div>
                                                    </div>
                                                </th>
                                                <th class="move-6">
                                                    <div class="container-justify">
                                                        <div>Q</div>
                                                        <div><?php if($totCob4 > 0) echo number_format($totCob4,2,".",","); else echo '-';?></div>
                                                    </div>
                                                </th>
                                                <th class="move-7">
                                                    <div class="container-justify">
                                                        <div>Q</div>
                                                        <div><?php if($totCob5 > 0) echo number_format($totCob5,2,".",","); else echo '-';?></div>
                                                    </div>
                                                </th>
                                                <th class="move-8">
                                                    <div class="container-justify">
                                                        <div>Q</div>
                                                        <div><?php if($totAnt > 0) echo number_format($totAnt,2,".",","); else echo '-';?></div>
                                                    </div>
                                                </th>
                                                <th class="table-warning move-9">
                                                    <div class="container-justify">
                                                        <div>Q</div>
                                                        <div><?php if($totInt > 0) echo number_format($totInt,2,".",","); else echo '-';?></div>
                                                    </div>
                                                </th>
                                                <th class="table-warning move-10">
                                                    <div class="container-justify">
                                                        <div>Q</div>
                                                        <div><?php if($totTra1 > 0) echo number_format($totTra1,2,".",","); else echo '-';?></div>
                                                    </div>
                                                </th>
                                                <th class="table-warning move-11">
                                                    <div class="container-justify">
                                                        <div>Q</div>
                                                        <div><?php if($totOtro1 > 0) echo number_format($totOtro1,2,".",","); else echo '-';?></div>
                                                    </div>
                                                </th>
                                                <th class="table-warning move-12">
                                                    <div class="container-justify">
                                                        <div>Q</div>
                                                        <div><?php if($totCom > 0) echo number_format($totCom,2,".",","); else echo '-';?></div>
                                                    </div>
                                                </th>
                                                <th class="table-warning move-13">
                                                    <div class="container-justify">
                                                        <div>Q</div>
                                                        <div><?php if($totPro > 0) echo number_format($totPro,2,".",","); else echo '-';?></div>
                                                    </div>
                                                </th>
                                                <th class="table-warning move-14">
                                                    <div class="container-justify">
                                                        <div>Q</div>
                                                        <div><?php if($totPOp > 0) echo number_format($totPOp,2,".",","); else echo '-';?></div>
                                                    </div>
                                                </th>
                                                <th class="table-warning move-15">
                                                    <div class="container-justify">
                                                        <div>Q</div>
                                                        <div><?php if($totPAn > 0) echo number_format($totPAn,2,".",","); else echo '-';?></div>
                                                    </div>
                                                </th>
                                                <th class="table-warning move-16">
                                                    <div class="container-justify">
                                                        <div>Q</div>
                                                        <div><?php if($totPPr > 0) echo number_format($totPPr,2,".",","); else echo '-';?></div>
                                                    </div>
                                                </th>
                                                <th class="table-warning move-17">
                                                    <div class="container-justify">
                                                        <div>Q</div>
                                                        <div><?php if($totDiv > 0) echo number_format($totDiv,2,".",","); else echo '-';?></div>
                                                    </div>
                                                </th>
                                                <th class="table-warning move-18">
                                                    <div class="container-justify">
                                                        <div>Q</div>
                                                        <div><?php if($totPag1 > 0) echo number_format($totPag1,2,".",","); else echo '-';?></div>
                                                    </div>
                                                </th>
                                                <th class="table-warning move-19">
                                                    <div class="container-justify">
                                                        <div>Q</div>
                                                        <div><?php if($totPag2 > 0) echo number_format($totPag2,2,".",","); else echo '-';?></div>
                                                    </div>
                                                </th>
                                                <th class="table-warning move-20">
                                                    <div class="container-justify">
                                                        <div>Q</div>
                                                        <div><?php if($totPag3 > 0) echo number_format($totPag3,2,".",","); else echo '-';?></div>
                                                    </div>
                                                </th>
                                                <th class="table-warning move-21">
                                                    <div class="container-justify">
                                                        <div>Q</div>
                                                        <div><?php if($totTra2 > 0) echo number_format($totTra2,2,".",","); else echo '-';?></div>
                                                    </div>
                                                </th>
                                                <th class="table-warning move-22">
                                                    <div class="container-justify">
                                                        <div>Q</div>
                                                        <div><?php if($totGas > 0) echo number_format($totGas,2,".",","); else echo '-';?></div>
                                                    </div>
                                                </th>
                                                <th class="table-warning move-23">
                                                    <div class="container-justify">
                                                        <div>Q</div>
                                                        <div><?php if($totDec > 0) echo number_format($totDec,2,".",","); else echo '-';?></div>
                                                    </div>
                                                </th>
                                                <th class="table-warning move-24">
                                                    <div class="container-justify">
                                                        <div>Q</div>
                                                        <div><?php if($totOtro2 > 0) echo number_format($totOtro2,2,".",","); else echo '-';?></div>
                                                    </div>
                                                </th>
                                            </tr>
                                            <?php $sumIn = $totVen + $totCob1 + $totPre + $totCob2 + $totCob3 + $totCob4 + $totCob5 + $totAnt + $totInt + $totTra1 + $totOtro1;
                                                $sumEg = $totCom + $totPro + $totPOp + $totPAn + $totPPr + $totDiv + $totPag1 + $totPag2 + $totPag3 + $totTra2 + $totGas + $totDec + $totOtro2;?>
                                            <tr>
                                                <th colspan="4" class="row-concept"></th>
                                                <th class="">
                                                    <div class="container-justify">
                                                        <div>Q</div>
                                                        <div><?php if($totEg > 0) echo number_format($totEg,2,".",","); else echo '-';?></div>
                                                    </div>
                                                </th>
                                                <th class="">
                                                    <div class="container-justify">
                                                        <div>Q</div>
                                                        <div><?php if($totIn > 0) echo number_format($totIn,2,".",","); else echo '-';?></div>
                                                    </div>
                                                </th>
                                                <th class=""></th>
                                                <th colspan="11" class="text-center adjust-income"></th>
                                                <th colspan="13" class="text-center adjust-expense"></th>
                                            </tr>
                                            <tr>
                                                <th colspan="4" class="row-concept"></th>
                                                <th class="">
                                                    <div class="container-justify">
                                                        <div>Q</div>
                                                        <div><?php if($sumEg > 0) echo number_format($sumEg,2,".",","); else echo '-';?></div>
                                                    </div>
                                                </th>
                                                <th class="">
                                                    <div class="container-justify">
                                                        <div>Q</div>
                                                        <div><?php if($sumIn > 0) echo number_format($sumIn,2,".",","); else echo '-';?></div>
                                                    </div>
                                                </th>
                                                <th class=""></th>
                                                <th colspan="11" class="text-center adjust-income"></th>
                                                <th colspan="13" class="text-center adjust-expense"></th>
                                            </tr>
                                            <?php $difEg = $totEg - $sumEg; $difIn = $totIn - $sumIn;?>
                                            <tr>
                                                <th colspan="4" class="row-concept"></th>
                                                <th class="">
                                                    <div class="container-justify">
                                                        <div><?php if($difEg < 0) echo '-';?>Q</div>
                                                        <div><?php echo number_format(abs($difEg),2,".",",");?></div>
                                                    </div>
                                                </th>
                                                <th class="">
                                                    <div class="container-justify">
                                                        <div><?php if($difIn < 0) echo '-';?>Q</div>
                                                        <div><?php echo number_format(abs($difIn),2,".",",");?></div>
                                                    </div>
                                                </th>
                                                <th class=""></th>
                                                <th colspan="11" class="text-center adjust-income"></th>
                                                <th colspan="13" class="text-center adjust-expense"></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 mt-3">
                            <div>
                                <table class="table table-bordered mb-0">
                                    <tr><td>Revisa:</td></tr>
                                    <tr>
                                        <td class="text-center">
                                            <input type="text" class="form-control text-center" name="maker_name" id="maker_name" value="" placeholder="Nombre" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            <input type="text" class="form-control text-center" name="maker_charge" id="maker_charge" value="Auxiliar Contable" placeholder="Cargo" />
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="col-lg-6 mt-3">
                            <div>
                                <table class="table table-bordered mb-0">
                                    <tr><td>Aprueba:</td></tr>
                                    <tr>
                                        <td class="text-center">
                                            <input type="text" class="form-control text-center" name="approve_name" id="approve_name" value="" placeholder="Nombre" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            <input type="text" class="form-control text-center" name="approve_charge" id="approve_charge" value="Gerente General" placeholder="Cargo" />
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <form method="POST" action="<?php echo base_url();?>doctor/printFormType/bank_book/" id="frmB" target="">
            <input type="hidden" class="initial" name="initial" value="<?php echo $initial;?>" />
            <input type="hidden" class="final" name="final" value="<?php echo $final;?>" />
            <input type="hidden" class="account" name="account_id" value="<?php echo $account_id;?>" />
            <input type="hidden" class="maker_name" name="maker_name" value="" />
            <input type="hidden" class="maker_charge" name="maker_charge" value="Auxiliar Contable" />
            <input type="hidden" class="approve_name" name="approve_name" value="" />
            <input type="hidden" class="approve_charge" name="approve_charge" value="Gerente General" />
            <input type="hidden" name="type" id="type" value="" />
        </form>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {

        $(".btn-group .focus-btn-group").hide();
        <?php for ($i=1; $i <= 25; $i++):?>
        initialChecked(<?php echo $i;?>, <?php if(in_array($i, $checks)) echo "true"; else echo "false";?>);
        <?php if (in_array($i, $checks)) {
            if ($i >= 1 && $i <= 11) $nIn++; 
            if ($i >= 12 && $i <= 24) $nEg++;
            if ($i == 25) {
                $nCol++;
                $nRow++;
            }
        }?>
        <?php endfor;?>
        <?php if($nIn <= 0):?>
        $("#move-income").hide();
        $(".adjust-income").hide();
        <?php else:?>
        $("#move-income").show();
        $("#move-income").attr("colspan", <?php echo $nIn;?>);
        $(".adjust-income").show();
        $(".adjust-income").attr("colspan", <?php echo $nIn;?>);
        console.log("celdas: "+$(".adjust-income").length);
        <?php endif;?>
        <?php if($nEg <= 0):?>
        $("#move-expense").hide();
        $(".adjust-expense").hide();
        <?php else:?>
        $("#move-expense").show();
        $("#move-expense").attr("colspan", <?php echo $nEg;?>);
        $(".adjust-expense").show();
        $(".adjust-expense").attr("colspan", <?php echo $nEg;?>);
        <?php endif;?>
        $("#col-concept").attr("colspan", <?php echo $nCol;?>);
        $(".row-concept").attr("colspan", <?php echo $nRow;?>);
    });

    function initialChecked(i, checked) {
        $("#check-move-"+i).prop("checked", checked);
        if (checked) $(".move-"+i).show();
        else $(".move-"+i).hide();
    }

    function submitFormType(type) {
        $("#type").val(type);
        var id = $("#account_id").val();
        var initial = $("#initial").val();
        var final = $("#final").val();

        $("#type").val(type);
        if (type == "PDF") $("#frmB").attr("target", "_blank");
        else $("#frmB").attr("target", '');

        if (id != '' && initial != '' && final != '') {
            $("#frmB").submit();
        }

        validateForm();
    }
    
    function validateForm() {
        var id = $("#account_id").val();
        var initial = $("#initial").val();
        var final = $("#final").val();
        var description = $("#description").val();
        var legal_name = $("#legal_name").val();
        var legal_charge = $("#legal_charge").val();
        var account_name = $("#account_name").val();
        var account_charge = $("#account_charge").val();

        if (id == '') $("#msgAccount").text("Debe seleccionar una cuenta bancaria");
        if (initial == '') $("#msgInitial").text("La fecha inicial está vacía.");
        if (final == '') $("#msgFinal").text("La fecha final está vacía.");
        if (description == '') $("#msgDescription").text("Ingrese una descripción.");
        if (legal_name == '') $("#msgLegalName").text("Ingrese un nombre.");
        if (legal_charge == '') $("#msgLegalCharge").text("Ingrese un cargo.");
        if (account_name == '') $("#msgAccountName").text("Ingrese un nombre.");
        if (account_charge == '') $("#msgAccountCharge").text("Ingrese un cargo.");
    }
    
    $("#maker_name").change(function () { 
        var name = $(this).val();
        $(".maker_name").val(name);
    });

    $("#maker_charge").change(function () { 
        var charge = $(this).val();
        $(".maker_charge").val(charge);
    });

    $("#approve_name").change(function () { 
        var name = $(this).val();
        $(".approve_name").val(name);
    });

    $("#approve_charge").change(function () { 
        var charge = $(this).val();
        $(".approve_charge").val(charge);
    });

    function colHideAjax(check, i) {
        checked = $(check).prop("checked");
        if (checked) $(".move-"+i).show();
        else $(".move-"+i).hide();
        setArrayValues();
    }

    function setArrayValues() {
        var nIn = 0; var nEg = 0; var nCol = 6; var nRow = 3;
        var vals = [];
        $("input[name='checks_moves[]']").each(function () {
            var val = this.value;
            if ($(this).is(":checked")) {
                vals.push(val); 
                if (val >= 1 && val<= 11) nIn++;
                if (val >= 12 && val <= 24) nEg++;
                if (val == 25) {
                    nCol++;
                    nRow++;
                }
            }
        });
        if (nIn <= 0) {
            $("#move-income").hide();
            $(".adjust-income").hide();
            $("#move-income-clone").hide();
        } else {
            $("#move-income").show();
            $("#move-income").attr("colspan", nIn);
            $(".adjust-income").show();
            $(".adjust-income").attr("colspan", nIn);
            $("#move-income-clone").show();
            $("#move-income-clone").attr("colspan", nIn);
        }
        if (nEg <= 0) {
            $("#move-expense").hide();
            $("#move-expense-clone").hide();
            $(".adjust-expense").hide();
        } else {
            $("#move-expense").show();
            $("#move-expense").attr("colspan", nEg);
            $(".adjust-expense").show();
            $(".adjust-expense").attr("colspan", nEg);
            $("#move-expense-clone").show();
            $("#move-expense-clone").attr("colspan", nEg);
        }
        $("#col-concept").attr("colspan", nCol);
        $(".row-concept").attr("colspan", nRow);
        $("#col-concept-clone").attr("colspan", nCol);
        $.ajax({
            type: "POST",
            url: "<?php echo base_url();?>doctor/setChecksBankBook/",
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

    function saveCategory(val, id) {
        if (val == '') {
            $("#cellAmount_"+id).removeClass("table-warning");
            $("#cellAmount_"+id).removeClass("table-success");
            $("#cellAmount_"+id).addClass("table-danger");
        } else if (val == 5) {
            $("#cellAmount_"+id).removeClass("table-danger");
            $("#cellAmount_"+id).removeClass("table-warning");
            $("#cellAmount_"+id).addClass("table-warning");
        } else {
            $("#cellAmount_"+id).removeClass("table-danger");
            $("#cellAmount_"+id).removeClass("table-warning");
            $("#cellAmount_"+id).addClass("table-success");
        }

        $.ajax({
            type: "POST",
            url: "<?php echo base_url();?>doctor/saveCategoryTransfer/",
            data: {
                category: val,
                id: id,
            },
            dataType: "json",
            beforeSend: function () {},
            success: function (data) {
                console.log(data);
            },
            error: function(e) {
                console.log("Error: ", e);
                alert("Error al guardar la categoría");
            }
        });
    }

    function searchValues() {
        var value = $("#search").val();

        $("#table-companies-1 tbody tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    }
</script>