<?php 
    $info = $this->crud_model->getBankConciliation($bank_conciliation_id);
    $credits = $this->crud_model->getBankConciliationType($bank_conciliation_id, "NC");
    $debits = $this->crud_model->getBankConciliationType($bank_conciliation_id, "ND");
    $checks = $this->crud_model->getBankConciliationType($bank_conciliation_id, "BC");
    $deposits = $this->crud_model->getBankConciliationType($bank_conciliation_id, "BD");
    $acc = $this->crud_model->getAccountBank($info['bank_account_id']);
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
                    <a class="btn btn-info" style="float: right;" href="<?php echo base_url();?>staff/bank_conciliations/">
                        <i class="bx bx-arrow-back"></i> Regresar
                    </a>
                    <h4 class="card-title text-center" style="margin-left:6%"><?php echo $this->crud_model->getInfo("system_name");?></h4>
                    <h4 class="card-title text-center" style="margin-left:6%">Conciliación bancaria</h4>
                    <div class="row">
                        <div class="col-lg-12">
                            <form action="<?php echo base_url();?>staff/bank_conciliation/" method="POST">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="text-center">
                                            <label for="" class=""><?php echo $acc['code'].' - '.$acc['name'];?></label>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 mb-3">
                                        <div class="text-center">
                                            <label for="" class=""><?php echo date("d/m/Y", strtotime($info['initial'])).' - '.date("d/m/Y", strtotime($info['final']));?></label>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-lg-12">
                            <form action="<?php echo base_url();?>staff/printFormType/conciliation/" method="POST" id="frmC" target="">
                                <input type="hidden" name="id" value="<?php echo $bank_conciliation_id;?>">
                                <input type="hidden" name="bank_account_id" id="bank_account_id" value="<?php echo $info['bank_account_id'];?>" />
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
                                                            <div><?php if ($info['balance_ledge'] < 0) echo '-';?>Q</div>
                                                            <div><span id="spnBalanceLedge"><?php echo number_format(abs($info['balance_ledge']),2,'.',',');?></span></div>
                                                        </div>
                                                        <input type="hidden" name="balance_ledge" id="balance_ledge" value="<?php echo number_format($info['balance_ledge'],2,'.','');?>" />
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td><span>(+) Notas de Crédito<span></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                                <?php $nCr = 1; foreach($credits->result_array() as $cd):?>
                                                <tr>
                                                    <td id="rowsNoteCredit">
                                                        <span><?php echo $cd['description'];?></span>
                                                        <div id="row_note_credit_<?php echo $nCr;?>">
                                                            <input type="hidden" name="cont_credit[]" id="cont_credit_<?php echo $nCr;?>" value="<?php echo $nCr;?>" />
                                                            <input type="hidden" name="note_credit[]" id="note_credit_<?php echo $nCr;?>" value="<?php echo $cd['description'];?>"/>
                                                        </div>
                                                    </td>
                                                    <td id="rowsAmountCredit">
                                                        <div class="container-justify">
                                                            <div><?php if($cd['amount'] < 0) echo '-';?>Q</div>
                                                            <div><span id="spnNoteCredit"><?php echo number_format($cd['amount'],2,'.',',');?></span></div>
                                                        </div>
                                                        <input type="hidden" name="amount_credit[]" id="amount_credit_<?php echo $nCr;?>" value="<?php echo $cd['amount'];?>" />
                                                    </td>
                                                </tr>
                                                <?php $nCr++; endforeach;?>
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td>
                                                        <div class="container-justify">
                                                            <div><?php if($info['subtotal_note_credit'] < 0) echo '-';?>Q</div>
                                                            <div><span id="spnNoteCredit"><?php echo number_format(abs($info['subtotal_note_credit']))?></span></div>
                                                        </div>
                                                        <input type="hidden" name="subtotal_note_credit" id="subtotal_note_credit" value="<?php echo $info['subtotal_note_credit'];?>">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><span>(-) Notas de Dédito</span></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                                <?php $nDb = 1; foreach($debits->result_array() as $db):?>
                                                <tr>
                                                    <td id="rowsNoteDebit">
                                                        <span><?php echo $db['description'];?></span>
                                                        <div id="row_note_debit_<?php echo $nD;?>">
                                                            <input type="hidden" name="cont_debit[]" id="cont_debit_<?php echo $nDb;?>" value="<?php echo $nDb;?>" />
                                                            <input type="hidden" name="note_debit[]" id="note_debit_<?php echo $nDb;?>" value="<?php echo $db['description'];?>"/>
                                                        </div>
                                                    </td>
                                                    <td id="rowsAmountDebit">
                                                        <div class="container-justify">
                                                            <div><?php if($db['amount'] < 0) echo '-';?>Q</div>
                                                            <div><span id="spnNotedebit"><?php echo number_format($db['amount'],2,'.',',');?></span></div>
                                                        </div>
                                                        <input type="hidden" name="amount_debit[]" id="amount_debit_<?php echo $nDr;?>" value="<?php echo $db['amount'];?>" />
                                                    </td>
                                                </tr>
                                                <?php $nDr++; endforeach;?>
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td>
                                                        <div class="container-justify">
                                                            <div><?php if($info['subtotal_note_debit'] < 0) echo '-';?>Q</div>
                                                            <div><span id="spnNoteDebit"><?php echo number_format(abs($info['subtotal_note_debit']))?></span></div>
                                                        </div>
                                                        <input type="hidden" name="subtotal_note_debit" id="subtotal_note_debit" value="<?php echo $info['subtotal_note_debit'];?>">
                                                    </td>
                                                </tr>
                                            </tbody>
                                            <tfoot>
                                                <tr class="table-light">
                                                    <th>Saldo a conciliar</th>
                                                    <th></th>
                                                    <th>
                                                        <div class="container-justify">
                                                            <div><?php if($info['balance_1'] < 0) echo '-';?>Q</div>
                                                            <div><span id="spnBalance1"><?php echo number_format($info['balance_1'],2,'.',',');?></span></div>
                                                        </div>
                                                        <input type="hidden" name="balance_1" id="balance_1" value="<?php echo $info['balance_1'];?>" />
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
                                                        <div class="container-justify">
                                                            <div><?php if ($info['balance_account'] < 0) echo '-';?>Q</div>
                                                            <div><span id="spnBalanceLedge"><?php echo number_format(abs($info['balance_account']),2,'.',',');?></span></div>
                                                        </div>
                                                        <input type="hidden" name="balance_account" id="balance_account" value="<?php echo number_format($info['balance_account'],2,'.','');?>" />
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td><span>(-) Cheques girados y no cobrados<span></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                                <?php $nCG = 1; foreach($checks->result_array() as $db):?>
                                                <tr>
                                                    <td id="rowsNoteCheck">
                                                        <span><?php echo $db['description'];?></span>
                                                        <div id="row_note_check_<?php echo $nCG;?>">
                                                            <input type="hidden" name="cont_check[]" id="cont_check_<?php echo $nCG;?>" value="<?php echo $nCG;?>" />
                                                            <input type="hidden" name="note_check[]" id="note_check_<?php echo $nCG;?>" value="<?php echo $db['description'];?>"/>
                                                        </div>
                                                    </td>
                                                    <td id="rowsAmountCheck">
                                                        <div class="container-justify">
                                                            <div><?php if($db['amount'] < 0) echo '-';?>Q</div>
                                                            <div><span id="spnNoteCheck"><?php echo number_format($db['amount'],2,'.',',');?></span></div>
                                                        </div>
                                                        <input type="hidden" name="amount_check[]" id="amount_check_<?php echo $nCG;?>" value="<?php echo $db['amount'];?>" />
                                                    </td>
                                                </tr>
                                                <?php $nCG++; endforeach;?>
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td>
                                                        <div class="container-justify">
                                                            <div><?php if($info['subtotal_bank_check'] < 0) echo '-';?>Q</div>
                                                            <div><span id="spnNoteDebit"><?php echo number_format(abs($info['subtotal_bank_check']))?></span></div>
                                                        </div>
                                                        <input type="hidden" name="subtotal_bank_check" id="subtotal_bank_check" value="<?php echo $info['subtotal_bank_check'];?>">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><span>(+) Depositos en tránsito<span></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                                <?php $nCG = 1; foreach($deposits->result_array() as $db):?>
                                                <tr>
                                                    <td id="rowsNoteDeposit">
                                                        <span><?php echo $db['description'];?></span>
                                                        <div id="row_note_deposit_<?php echo $nCG;?>">
                                                            <input type="hidden" name="cont_deposit[]" id="cont_deposit_<?php echo $nCG;?>" value="<?php echo $nCG;?>" />
                                                            <input type="hidden" name="note_deposit[]" id="note_deposit_<?php echo $nCG;?>" value="<?php echo $db['description'];?>"/>
                                                        </div>
                                                    </td>
                                                    <td id="rowsAmountDeposit">
                                                        <div class="container-justify">
                                                            <div><?php if($db['amount'] < 0) echo '-';?>Q</div>
                                                            <div><span id="spnNoteDeposit"><?php echo number_format($db['amount'],2,'.',',');?></span></div>
                                                        </div>
                                                        <input type="hidden" name="amount_deposit[]" id="amount_deposit_<?php echo $nCG;?>" value="<?php echo $db['amount'];?>" />
                                                    </td>
                                                </tr>
                                                <?php $nCG++; endforeach;?>
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td>
                                                        <div class="container-justify">
                                                            <div><?php if($info['subtotal_bank_deposit'] < 0) echo '-';?>Q</div>
                                                            <div><span id="spnNoteDebit"><?php echo number_format(abs($info['subtotal_bank_deposit']))?></span></div>
                                                        </div>
                                                        <input type="hidden" name="subtotal_bank_deposit" id="subtotal_bank_deposit" value="<?php echo $info['subtotal_bank_deposit'];?>">
                                                    </td>
                                                </tr>
                                            </tbody>
                                            <tfoot>
                                                <tr class="table-light">
                                                    <th>Saldo a conciliar</th>
                                                    <th></th>
                                                    <th>
                                                        <div class="container-justify">
                                                            <div><?php if($info['balance_2'] < 0) echo '-';?>Q</div>
                                                            <div><span id="spnBalance2"><?php echo number_format($info['balance_2'],2,'.',',');?></span></div>
                                                        </div>
                                                        <input type="hidden" name="balance_2" id="balance_2" value="<?php echo $info['balance_2'];?>" />
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
                                                        <span><?php echo $info['elaborate_name'];?></span>
                                                        <input type="hidden" name="elaborate_name" id="elaborate_name" value="<?php echo $info['elaborate_name'];?>" />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-center">
                                                        <span><?php echo $info['elaborate_charge'];?></span>
                                                        <input type="hidden" name="elaborate_charge" id="elaborate_charge" value="<?php echo $info['elaborate_charge'];?>" />
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
                                                        <span><?php echo $info['approve_name'];?></span>
                                                        <input type="hidden" name="approve_name" id="approve_name" value="<?php echo $info['approve_name'];?>" />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-center">
                                                        <span><?php echo $info['approve_charge'];?></span>
                                                        <input type="hidden" name="approve_charge" id="approve_charge" value="<?php echo $info['approve_charge'];?>" />
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
                                                        <span><?php echo $info['check_name'];?></span>
                                                        <input type="hidden" name="check_name" id="check_name" value="<?php echo $info['check_name'];?>" />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-center">
                                                        <span><?php echo $info['check_charge'];?></span>
                                                        <input type="hidden" name="check_charge" id="check_charge" value="<?php echo $info['check_charge'];?>" />
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-lg-3"></div>
                                    <div class="col-lg-12 mb-3">
                                        <input type="button" class="btn btn-danger" value="PDF" onclick="submitFormType('PDF')" />
                                        &nbsp; &nbsp;
                                        <input type="button" class="btn btn-success" value="Excel" onclick="submitFormType('EXCEL')" />
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
    function submitFormType(type) {
        $("#type").val(type);
        if(type == 'PDF') $("#frmC").attr("target", "_blank");
        else $("#frmC").attr("target", '');
        $("#frmC").submit();
    }
</script>