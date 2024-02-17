<?php 
    $cuentas = $this->crud_model->getBankAccountsActive();
    $info = $this->crud_model->getFinalBalanceAccount($bank_account_id, $initial, $final);
    $balance = $this->crud_model->getBalanceFinalBank($bank_account_id, $initial, $final);
    $credits = $this->crud_model->getCreditNotes($bank_account_id, $initial, $final);
    $debits = $this->crud_model->getDebitNotes($bank_account_id, $initial, $final);
    $checks = $this->crud_model->getCheckDrawn($bank_account_id, $initial, $final);
    $deposits = $this->crud_model->getDepositTransit($bank_account_id, $initial, $final);
?>  
<script src="<?php echo base_url();?>public/assets/libs/select2/js/select2.min.js"></script>
<link href="<?php echo base_url();?>public/assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
<style type="text/css">
    .container-justify {
        display: flex;
        justify-content: space-between;
    }
</style>
<div id="main-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="card-box">
                <div class="card-b">
                    <a class="btn btn-info" style="float: right;" href="<?php echo base_url();?>staff/bank_conciliations/">
                        <i class="bx bx-arrow-back"></i> Regresar
                    </a>
                    <h4 class="card-title text-center" style="margin-left:6%"><?php echo $this->crud_model->getInfo("system_name");?></h4>
                    <h4 class="card-title text-center" style="margin-left:6%">Conciliación bancaria</h4>
                    <div class="row">
                        <div class="col-lg-12">
                            <form action="<?php echo base_url();?>staff/bank_conciliation/" method="POST">
                                <div class="row">
                                    <div class="col-lg-3"></div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <select class="form-control select2-cuentas" name="bank_account_id" id="bank_account_id" required onchange="this.form.submit()" required>
                                                <option value="">Selecciona una cuenta bancaria</option>
                                                <?php foreach ($cuentas->result_array() as $ct):?>
                                                <option value="<?php echo $ct['bank_account_id'];?>" <?php if($ct['bank_account_id'] == $bank_account_id) echo "selected";?>><?php echo $ct['code'].' - '.$ct['name'];?></option>
                                                <?php endforeach;?>
                                            </select>
                                            <small class="text-danger" id="msgAccount"></small>
                                        </div>
                                    </div>
                                    <div class="col-lg-3"></div>
                                    <div class="col-lg-3"></div>
                                    <div class="col-lg-6 mb-3">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <input class="form-control" type="date" name="initial" id="initial" value="<?php echo $initial;?>" required>
                                                <input class="form-control" type="date" name="final" id="final" value="<?php echo $final;?>" required>
                                                <button class="btn btn-info" type="submit" id="">Cargar</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3"></div>
                                </div>
                            </form>
                        </div>
                        <div class="col-lg-12">
                            <form action="<?php echo base_url();?>staff/bank_conciliation/save/" method="POST" id="frmC" target="">
                                <input type="hidden" name="bank_account_id" value="<?php echo $bank_account_id;?>" />
                                <input type="hidden" name="initial" value="<?php echo $initial;?> "/>
                                <input type="hidden" name="final" value="<?php echo $final;?> "/>
                                <input type="hidden" name="type" id="type" value="" />
                                <div class="row">
                                    <div class="col-lg-12">
                                        <table class="table table-bordered mb-3">
                                            <thead class="table-light">
                                                <tr>
                                                    <th class="text-center" style="width: 50%"></th>
                                                    <th class="text-center" style="width: 25%">Parcial</th>
                                                    <th class="text-center" style="width: 25%">Total</th>
                                                </tr>
                                                <tr>
                                                    <th style="width: 50%">SALDO FINAL SEGÚN EL LIBRO MAYOR DE BANCOS</th>
                                                    <th class="text-center" style="width: 25%"></th>
                                                    <th style="width: 25%;">
                                                        <div class="container-justify">
                                                            <div><?php if ($balance < 0) echo '-';?>Q</div>
                                                            <div><span id="spnBalanceLedge"><?php echo number_format(abs($balance),2,".",",");?></span></div>
                                                        </div>
                                                        <input type="hidden" name="balance_ledge" id="balance_ledge" value="<?php echo number_format($balance,2,".","");?>" />
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td id="rowsNoteCredit">
                                                        <span>(+) Notas de Crédito<span>
                                                        <input type="button" class="btn btn-primary" style="float: right;" id="btn_add_credit" onclick="addCredit()" value="+" />
                                                        <?php $nC = 1; foreach($credits->result_array() as $cd):?>
                                                        <div id="row_note_credit_<?php echo $nC;?>">
                                                            <input type="hidden" name="cont_credit[]" id="cont_credit_<?php echo $nC;?>" value="<?php echo $nC;?>" />
                                                            <div class="form-group">
                                                                <input type="text" class="form-control" name="note_credit[]" id="note_credit_<?php echo $nC;?>" value="<?php echo $cd['description'];?>" placeholder="Descripción" />
                                                            </div>
                                                        </div>
                                                        <?php $nC++; endforeach;?>
                                                    </td>
                                                    <td id="rowsAmountCredit">
                                                        <input type="button" class="btn" style="float: right;" value="" disabled />
                                                        <div class="container-justify">
                                                            <div>Q</div>
                                                            <div><span id="spnNoteCredit">-</span></div>
                                                        </div>
                                                        <input type="hidden" name="total_note_credit" id="total_note_credit" value="0.00" />
                                                        <?php $nCr = 1; foreach($credits->result_array() as $cd):?>
                                                        <div id="row_amount_credit_<?php echo $nCr;?>">
                                                            <div class="form-group">
                                                                <div class="input-group">
                                                                    <span class="input-group-addon input-group-prepend">
                                                                        <span class="input-group-text">Q</span>
                                                                    </span>
                                                                    <input type="number" class="form-control" name="amount_credit[]" id="amount_credit_<?php echo $nCr;?>" step="0.01" min="0" oninput="sumCredit()" value="<?php echo $cd['amount'];?>" required />
                                                                    <input type="button" class="btn btn-danger" value="x" onclick="deleteCredit(<?php echo $nCr;?>)" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php $nCr++; endforeach;?>
                                                    </td>
                                                    <td>
                                                        <div class="container-justify">
                                                            <div>Q</div>
                                                            <div><span id="sumNoteCredit">-</span></div>
                                                        </div>
                                                        <input type="hidden" name="subtotal_note_credit" id="subtotal_note_credit">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td id="rowsNoteDebit">
                                                        <span>(-) Notas de Dédito</span>
                                                        <input type="button" class="btn btn-primary" style="float: right;" onclick="addDebit()" value="+" />
                                                        <?php $nDe = 1; foreach($debits->result_array() as $db):?>
                                                        <div id="row_note_debit_<?php echo $nDe;?>">
                                                            <input type="hidden" name="cont_debit[]" id="cont_debit_<?php echo $nDe;?>" value="<?php echo $nDe;?>" />
                                                            <div class="form-group">
                                                                <input type="text" class="form-control" name="note_debit[]" id="note_debit_<?php echo $nDe;?>" value="<?php echo $db['description'];?>" placeholder="Descripción" />
                                                            </div>
                                                        </div>
                                                        <?php $nDe++; endforeach;?>
                                                    </td>
                                                    <td id="rowsAmountDebit">
                                                        <input type="button" class="btn" style="float: right;" value="" disabled />
                                                        <div class="container-justify">
                                                            <div>Q</div>
                                                            <div><span id="spnNoteDebit">-</span></div>
                                                        </div>
                                                        <input type="hidden" name="total_note_debit" id="total_note_debit" value="0.00" />
                                                        <?php $nDe = 1; foreach($debits->result_array() as $db):?>
                                                        <div id="row_amount_debit_<?php echo $nDe;?>">
                                                            <div class="form-group">
                                                                <div class="input-group">
                                                                    <span class="input-group-addon input-group-prepend">
                                                                        <span class="input-group-text">Q</span>
                                                                    </span>
                                                                    <input type="number" class="form-control" name="amount_debit[]" id="amount_debit_<?php echo $nDe;?>" step="0.01" min="0" oninput="sumDebit()" value="<?php echo $db['amount'];?>" required />
                                                                    <input type="button" class="btn btn-danger" value="x" onclick="deleteDebit(<?php echo $nDe;?>)" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php $nDe++; endforeach;?>
                                                    </td>
                                                    <td>
                                                        <div class="container-justify">
                                                            <div>Q</div>
                                                            <div><span id="sumNoteDebit">-</span></div>
                                                        </div>
                                                        <input type="hidden" name="subtotal_note_debit" id="subtotal_note_debit">
                                                    </td>
                                                </tr>
                                            </tbody>
                                            <tfoot>
                                                <tr class="table-light">
                                                    <th>Saldo a conciliar</th>
                                                    <th></th>
                                                    <th>
                                                        <div class="container-justify">
                                                            <div>Q</div>
                                                            <div><span id="spnBalance1">-</span></div>
                                                        </div>
                                                        <input type="hidden" name="balance_1" id="balance_1" value="0.00" />
                                                    </th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                    <div class="col-lg-12">
                                        <table class="table table-bordered mb-0">
                                            <thead class="table-light">
                                                <tr>
                                                    <th style="width: 50%">SALDO FINAL SEGÚN EL ESTADO DE CUENTA</th>
                                                    <th class="text-center" style="width: 25%"></th>
                                                    <th style="width: 25%;">
                                                        <div class="form-group">
                                                            <div class="input-group">
                                                                <span class="input-group-addon input-group-prepend">
                                                                    <span class="input-group-text">Q</span>
                                                                </span>
                                                                <input type="number" class="form-control" name="balance_account" id="balance_account" value="0.00" min="" step="0.01" required oninput="addTotals()" />
                                                            </div>
                                                        </div>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td id="rowsNoteCheck">
                                                        <span>(-) Cheques girados y no cobrados</span>
                                                        <input type="button" class="btn btn-primary" style="float: right;" onclick="addCheck()" value="+" />
                                                        <?php $nCG = 1; foreach($checks->result_array() as $db):?>
                                                        <div id="row_note_check_<?php echo $nCG;?>">
                                                            <input type="hidden" name="cont_check[]" id="cont_check_<?php echo $nCG;?>" value="<?php echo $nCG;?>" />
                                                            <div class="form-group">
                                                                <input type="text" class="form-control" name="note_check[]" id="note_check_<?php echo $nCG;?>" value="<?php echo $db['description'];?>" placeholder="Descripción" />
                                                            </div>
                                                        </div>
                                                        <?php $nCG++; endforeach;?>
                                                    </td>
                                                    <td id="rowsAmountCheck">
                                                        <input type="button" class="btn" style="float: right;" value="" disabled />
                                                        <div class="container-justify">
                                                            <div>Q</div>
                                                            <div><span id="spnBankCheck">-</span></div>
                                                        </div>
                                                        <input type="hidden" name="total_bank_check" id="total_bank_check" value="0.00" />
                                                        <?php $nC = 1; foreach($checks->result_array() as $db):?>
                                                        <div id="row_amount_check_<?php echo $nC;?>">
                                                            <div class="form-group">
                                                                <div class="input-group">
                                                                    <span class="input-group-addon input-group-prepend">
                                                                        <span class="input-group-text">Q</span>
                                                                    </span>
                                                                    <input type="number" class="form-control" name="amount_check[]" id="amount_check_<?php echo $nC;?>" step="0.01" min="0" oninput="sumCheck()" value="<?php echo $db['amount'];?>" required />
                                                                    <input type="button" class="btn btn-danger" value="x" onclick="deleteCheck(<?php echo $nC;?>)" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php $nC++; endforeach;?>
                                                    </td>
                                                    <td>
                                                        <div class="container-justify">
                                                            <div>Q</div>
                                                            <div><span id="sumBankCheck">-</span></div>
                                                        </div>
                                                        <input type="hidden" name="subtotal_bank_check" id="subtotal_bank_check">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td id="rowsNoteDeposit">
                                                        <span>(+) Depositos en tránsito</span>
                                                        <input type="button" class="btn btn-primary" style="float: right;" onclick="addDeposit()" value="+" />
                                                        <?php $nDT = 1; foreach($deposits->result_array() as $dp):?>
                                                        <div id="row_note_deposit_1">
                                                            <input type="hidden" name="cont_deposit[]" id="cont_deposit_<?php echo $nDT;?>" value="<?php echo $nDT;?>" />
                                                            <div class="form-group">
                                                                <input type="text" class="form-control" name="note_deposit[]" id="note_deposit_<?php echo $nDT;?>" placeholder="Descripción" />
                                                            </div>
                                                        </div>
                                                        <?php $nDT++; endforeach;?>
                                                    </td>
                                                    <td id="rowsAmountDeposit">
                                                        <input type="button" class="btn" style="float: right;" value="" disabled />
                                                        <div class="container-justify">
                                                            <div>Q</div>
                                                            <div><span id="spnBankDeposit">-</span></div>
                                                        </div>
                                                        <input type="hidden" name="total_bank_deposit" id="total_bank_deposit" value="0.00" />
                                                        <?php $nDT = 1; foreach($deposits->result_array() as $dp):?>
                                                        <div id="row_amount_deposit_1">
                                                            <div class="form-group">
                                                                <div class="input-group">
                                                                    <span class="input-group-addon input-group-prepend">
                                                                        <span class="input-group-text">Q</span>
                                                                    </span>
                                                                    <input type="number" class="form-control" name="amount_deposit[]" id="amount_deposit_<?php echo $nDT;?>" step="0.01" min="0" oninput="sumDeposit()" value="" />
                                                                    <input type="button" class="btn btn-danger" value="x" onclick="deleteDeposit(<?php echo $nDT;?>)" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php $nDT++; endforeach;?>
                                                    </td>
                                                    <td>
                                                        <div class="container-justify">
                                                            <div>Q</div>
                                                            <div><span id="sumBankDeposit">-</span></div>
                                                        </div>
                                                        <input type="hidden" name="subtotal_bank_deposit" id="subtotal_bank_deposit">
                                                    </td>
                                                </tr>
                                            </tbody>
                                            <tfoot>
                                                <tr class="table-light">
                                                    <th>Saldo a conciliar</th>
                                                    <th></th>
                                                    <th>
                                                        <div class="container-justify">
                                                            <div>Q</div>
                                                            <div><span id="spnBalance2">-</span></div>
                                                        </div>
                                                        <input type="hidden" name="balance_2" id="balance_2" value="0.00" />
                                                    </th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                    <div class="col-lg-6 mt-3">
                                        <div>
                                            <table class="table table-bordered mb-0">
                                                <tr><td>Elabora:</td></tr>
                                                <tr>
                                                    <td class="text-center">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control text-center" name="elaborate_name" id="elaborate_name" value="" placeholder="Nombre" />
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-center">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control text-center" name="elaborate_charge" id="elaborate_charge" value="Auxiliar" placeholder="Cargo" />
                                                        </div>
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
                                                        <div class="form-group">
                                                            <input type="text" class="form-control text-center" name="approve_name" id="approve_name" value="" placeholder="Nombre" />
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-center">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control text-center" name="approve_charge" id="approve_charge" value="Gerente financiero" placeholder="Cargo" />
                                                        </div>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-lg-3"></div>
                                    <div class="col-lg-6 mt-3">
                                        <div>
                                            <table class="table table-bordered mb-0">
                                                <tr><td>Revisa:</td></tr>
                                                <tr>
                                                    <td class="text-center">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control text-center" name="check_name" id="check_name" value="" placeholder="Nombre" />
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-center">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control text-center" name="check_charge" id="check_charge" value="Administrador" placeholder="Cargo" />
                                                        </div>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-lg-3"></div>
                                    <div class="col-lg-12 mb-3">
                                        <!-- <input type="button" class="btn btn-danger" value="PDF" onclick="submitFormType('PDF')" />
                                        &nbsp; &nbsp;
                                        <input type="button" class="btn btn-success" value="Excel" onclick="submitFormType('EXCEL')" /> -->
                                        <?php if ($bank_account_id != ''):?>
                                        <input type="submit" class="btn btn-success" value="Guardar">
                                        <?php else:?>
                                        <small class="text-danger">Debe seleccionar una cuenta bancaria</small>
                                        <?php endif;?>
                                    </div>
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
    var contCredit = <?php echo $nCr;?>;
    var contDebit = <?php echo $nDe;?>;
    var contCheck = <?php echo $nCG;?>;
    var contDeposit = <?php echo $nDT;?>;

    $(document).ready(function () {
        sumCredit();
        sumDebit();
        sumCheck();
        sumDeposit();
        $('#frmC').on('keyup keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) { 
                e.preventDefault();
                return false;
            }
        });
    });
    
    $('.select2-cuentas').select2({ 
        placeholder: "Escribe el código o nombre de alguna cuenta",
    });

    function addCredit() {
        var note = '<div id="row_note_credit_'+contCredit+'"><input type="hidden" name="cont_credit[]" id="cont_credit_'+contCredit+'" value="'+contCredit+'" /><div class="form-group"><input type="text" class="form-control" name="note_credit[]" id="note_credit_'+contCredit+'" placeholder="Descripción" required /></div></div>';
        var amount = '<div id="row_amount_credit_'+contCredit+'"><div class="form-group"><div class="input-group"><span class="input-group-addon input-group-prepend"><span class="input-group-text">Q</span></span><input type="number" class="form-control" name="amount_credit[]" id="amount_credit_'+contCredit+'" step="0.01" min="0" oninput="sumCredit()" value="" required /><input type="button" class="btn btn-danger" value="x" onclick="deleteCredit('+contCredit+')" /></div></div</div>';
        $("#rowsNoteCredit").append(note);
        $("#rowsAmountCredit").append(amount);
        contCredit++;
    }

    function deleteCredit(i) {
        $("#row_note_credit_"+i).remove();
        $("#row_amount_credit_"+i).remove();
    }

    function addDebit() {
        var note = '<div id="row_note_debit_'+contDebit+'"><input type="hidden" name="cont_debit[]" id="cont_debit_'+contDebit+'" value="'+contDebit+'" /><div class="form-group"><input type="text" class="form-control" name="note_debit[]" id="note_debit_'+contDebit+'" placeholder="Descripción" required /></div></div>';
        var amount = '<div id="row_amount_debit_'+contDebit+'"><div class="form-group"><div class="input-group"><span class="input-group-addon input-group-prepend"><span class="input-group-text">Q</span></span><input type="number" class="form-control" name="amount_debit[]" id="amount_debit_'+contDebit+'" step="0.01" min="0" oninput="sumDebit()" value="" required /><input type="button" class="btn btn-danger" value="x" onclick="deleteDebit('+contDebit+')" /></div></div</div>';
        $("#rowsNoteDebit").append(note);
        $("#rowsAmountDebit").append(amount);
        contDebit++;
    }

    function deleteDebit(i) {
        $("#row_note_debit_"+i).remove();
        $("#row_amount_debit_"+i).remove();
    }

    function addCheck() {
        var note = '<div id="row_note_check_'+contCheck+'"><input type="hidden" name="cont_check[]" id="cont_check_'+contCheck+'" value="'+contCheck+'" /><div class="form-group"><input type="text" class="form-control" name="note_check[]" id="note_check_'+contCheck+'" placeholder="Descripción" required /></div></div>';
        var amount = '<div id="row_amount_check_'+contCheck+'"><div class="form-group"><div class="input-group"><span class="input-group-addon input-group-prepend"><span class="input-group-text">Q</span></span><input type="number" class="form-control" name="amount_check[]" id="amount_check_'+contCheck+'" step="0.01" min="0" oninput="sumCheck()" value="" required /><input type="button" class="btn btn-danger" value="x" onclick="deleteCheck('+contCheck+')" /></div></div</div>';
        $("#rowsNoteCheck").append(note);
        $("#rowsAmountCheck").append(amount);
        contCheck++;
    }

    function deleteCheck(i) {
        $("#row_note_check_"+i).remove();
        $("#row_amount_check_"+i).remove();
    }

    function addDeposit() {
        var note = '<div id="row_note_deposit_'+contDeposit+'"><input type="hidden" name="cont_deposit[]" id="cont_deposit_'+contDeposit+'" value="'+contDeposit+'" /><div class="form-group"><input type="text" class="form-control" name="note_deposit[]" id="note_deposit_'+contDeposit+'" placeholder="Descripción" required /></div></div>';
        var amount = '<div id="row_amount_deposit_'+contDeposit+'"><div class="form-group"><div class="input-group"><span class="input-group-addon input-group-prepend"><span class="input-group-text">Q</span></span><input type="number" class="form-control" name="amount_deposit[]" id="amount_deposit_'+contDeposit+'" step="0.01" min="0" oninput="sumDeposit()" value="" required /><input type="button" class="btn btn-danger" value="x" onclick="deleteDeposit('+contDeposit+')" /></div></div</div>';
        $("#rowsNoteDeposit").append(note);
        $("#rowsAmountDeposit").append(amount);
        contDeposit++;
    }

    function deleteDeposit(i) {
        $("#row_note_deposit_"+i).remove();
        $("#row_amount_deposit_"+i).remove();
    }

    function sumCredit() {
        var totalAmount = 0;
        var amount = $("input[name='amount_credit[]']").map(function () {
            var value = this.value;
            if (value == '') value = 0;
            return value;
        });
        for (var i = 0; i < amount.length; i++) {
            totalAmount += parseFloat(amount[i]);
        }
        $("#spnNoteCredit").text(totalAmount.toFixed(2));
        $("#total_note_credit").val(totalAmount.toFixed(2));
        addTotals();
    }

    function sumDebit() {
        var totalAmount = 0;
        var amount = $("input[name='amount_debit[]']").map(function () {
            var value = this.value;
            if (value == '') value = 0;
            return value;
        });
        for (var i = 0; i < amount.length; i++) {
            totalAmount += parseFloat(amount[i]);
        }
        $("#spnNoteDebit").text(totalAmount.toFixed(2));
        $("#total_note_debit").val(totalAmount.toFixed(2));
        addTotals();
    }

    function sumCheck() {
        var totalAmount = 0;
        var amount = $("input[name='amount_check[]']").map(function () {
            var value = this.value;
            if (value == '') value = 0;
            return value;
        });
        for (var i = 0; i < amount.length; i++) {
            totalAmount += parseFloat(amount[i]);
        }
        $("#spnBankCheck").text(totalAmount.toFixed(2));
        $("#total_bank_check").val(totalAmount.toFixed(2));
        addTotals();
    }

    function sumDeposit() {
        var totalAmount = 0;
        var amount = $("input[name='amount_deposit[]']").map(function () {
            var value = this.value;
            if (value == '') value = 0;
            return value;
        });
        for (var i = 0; i < amount.length; i++) {
            totalAmount += parseFloat(amount[i]);
        }
        $("#spnBankDeposit").text(totalAmount.toFixed(2));
        $("#total_bank_deposit").val(totalAmount.toFixed(2));
        addTotals();
    }

    function addTotals() {
        var total_ledge = 0;
        var subtotal_note_credit = 0;
        var subtotal_note_debit = 0;
        var balance_ledge = $("#balance_ledge").val();
        if (balance_ledge == '') balance_ledge = 0;
        var note_credit = $("#total_note_credit").val();
        if (note_credit == '') note_credit = 0;
        subtotal_note_credit = parseFloat(balance_ledge) + parseFloat(note_credit);
        $("#sumNoteCredit").text(subtotal_note_credit.toFixed(2));
        $("#subtotal_note_credit").val(subtotal_note_credit.toFixed(2));
        var note_debit = $("#total_note_debit").val();
        if (note_debit == '') note_debit = 0;
        subtotal_note_debit = parseFloat(balance_ledge) + parseFloat(note_credit) - parseFloat(note_debit);
        $("#sumNoteDebit").text(subtotal_note_debit.toFixed(2));
        $("#subtotal_note_debit").val(subtotal_note_debit.toFixed(2));
        total_ledge = subtotal_note_debit;
        $("#spnBalance1").text(total_ledge.toFixed(1));
        $("#balance_1").val(total_ledge.toFixed(2));

        var total_account = 0;
        var subtotal_bank_check = 0;
        var subtotal_bank_deposit = 0;
        var balance_account = $("#balance_account").val();
        if (balance_account == '') balance_account = 0;
        var bank_check = $("#total_bank_check").val();
        if (bank_check == '') bank_check = 0;
        subtotal_bank_check = parseFloat(balance_account) - parseFloat(bank_check);
        $("#sumBankCheck").text(subtotal_bank_check.toFixed(2));
        $("#subtotal_bank_check").val(subtotal_bank_check.toFixed(2));
        var bank_deposit = $("#total_bank_deposit").val();
        if (bank_deposit == '') bank_deposit = 0;
        subtotal_bank_deposit = parseFloat(balance_account) - parseFloat(bank_check) + parseFloat(bank_deposit);
        $("#sumBankDeposit").text(subtotal_bank_deposit.toFixed(2));
        $("#subtotal_bank_deposit").val(subtotal_bank_deposit.toFixed(2));
        total_account = subtotal_bank_deposit;
        $("#spnBalance2").text(total_account.toFixed(2));
        $("#balance_2").val(total_account.toFixed(2));
    }

    function submitFormType(type) {
        $("#type").val(type);
        if(type == 'PDF') $("#frmC").attr("target", "_blank");
        else $("#frmC").attr("target", '');
        $("#frmC").submit();
    }
</script>