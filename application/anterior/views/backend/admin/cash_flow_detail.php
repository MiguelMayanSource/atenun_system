<?php 
    $info = $this->crud_model->getCashFlow($cash_flow_id);
    $opes = $this->crud_model->getCashFlowType($cash_flow_id, "AO");
    $invs = $this->crud_model->getCashFlowType($cash_flow_id, "AI");
    $fina = $this->crud_model->getCashFlowType($cash_flow_id, "AF");
    setlocale(LC_TIME,"es_ES");
?>  
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
                    <a class="btn btn-info" style="float: right;" href="<?php echo base_url();?>admin/cash_flows/">
                        <i class="bx bx-arrow-back"></i> Regresar
                    </a>
                    <h4 class="card-title text-center" style="margin-left:6%">FLUJO DE EFECTIVO</h4>
                    <h4 class="card-title text-center" style="margin-left:6%"><?php echo $this->crud_model->getInfo("description");?></h4>
                    <h4 class="card-title text-center"><?php echo $this->crud_model->getInfo("system_name");?></h4>
                    <form action="<?php echo base_url();?>admin/printFormType/cash_flow/" method="POST" id="frmC" target="">
                        <input type="hidden" name="initial" value="<?php echo $initial;?> "/>
                        <input type="hidden" name="final" value="<?php echo $final;?> "/>
                        <input type="hidden" name="type" id="type" value="" />
                        <div class="row">
                            <div class="col-lg-12 mb-3">
                                <div class="text-center">
                                    <label for="" class=""><?php echo date("d/m/Y", strtotime($info['initial'])).' - '.date("d/m/Y", strtotime($info['final']));?></label>
                                </div>
                            </div>
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
                                                <td>
                                                    <div class="container-justify">
                                                        <div><?php if ($info['utility'] < 0) echo '-';?>Q</div>
                                                        <div><span id=""><?php echo number_format(abs($info['utility']),2,'.',',');?></span></div>
                                                    </div>
                                                    <input type="hidden" name="utility" id="utility" value="<?php echo number_format($info['utility'],2,'.','');?>" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Cuentas que no originan movimiento de efectivo</td>
                                                <td></td>
                                                <td></td>
                                                <td>
                                                    <div class="container-justify">
                                                        <div><?php if ($info['no_moves'] < 0) echo '-';?>Q</div>
                                                        <div><span id=""><?php echo number_format(abs($info['no_moves']),2,'.',',');?></span></div>
                                                    </div>
                                                    <input type="hidden" name="no_moves" id="no_moves" value="<?php echo number_format($info['no_moves'],2,'.','');?>" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>CONCILIACIÓN ENTRE LA UTILIDAD NETA Y FLUJO DE EFECTIVO PROVISTO POR</td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td>ACTIVIDADES DE OPERACIÓN</td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            <?php $nOp = 1; foreach($opes->result_array() as $op):?>
                                            <tr>
                                                <td id="rowsNoteOperation">
                                                    <span><?php echo $op['description'];?></span>
                                                    <div id="row_note_operation_<?php echo $nOp;?>">
                                                        <input type="hidden" name="cont_operation[]" id="cont_operation_<?php echo $nOp;?>" value="<?php echo $nOp;?>" />
                                                        <input type="hidden" name="note_operation[]" id="note_operation_<?php echo $nOp;?>" value="<?php echo $op['description'];?>"/>
                                                    </div>
                                                </td>
                                                <td id="rowsAmountOperation">
                                                    <div class="container-justify">
                                                        <div>Q</div>
                                                        <div><span id="spnNoteOperation"><?php echo number_format($op['amount'],2,'.',',');?></span></div>
                                                    </div>
                                                    <input type="hidden" name="amount_operation[]" id="amount_operation_<?php echo $nOp;?>" value="<?php echo $op['amount'];?>" />
                                                </td>
                                            </tr>
                                            <?php $nOp++; endforeach;?>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td>
                                                    <div class="container-justify">
                                                        <div><?php if($info['subtotal_operation'] < 0) echo '-';?>Q</div>
                                                        <div><span id="spnSubtOperation"><?php echo number_format(abs($info['subtotal_operation']))?></span></div>
                                                    </div>
                                                    <input type="hidden" name="subtotal_operation" id="subtotal_operation" value="<?php echo $info['subtotal_operation'];?>">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>ACTIVIDADES DE INVERSIÓN</td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            <?php $nIn = 1; foreach($invs->result_array() as $in):?>
                                            <tr>
                                                <td id="rowsNoteInvest">
                                                    <span><?php echo $in['description'];?></span>
                                                    <div id="row_note_invest_<?php echo $nIn;?>">
                                                        <input type="hidden" name="cont_invest[]" id="cont_invest_<?php echo $nIn;?>" value="<?php echo $nIn;?>" />
                                                        <input type="hidden" name="note_invest[]" id="note_invest_<?php echo $nIn;?>" value="<?php echo $in['description'];?>"/>
                                                    </div>
                                                </td>
                                                <td id="rowsAmountInvest">
                                                    <div class="container-justify">
                                                        <div>Q</div>
                                                        <div><span id="spnNoteInvest"><?php echo number_format($in['amount'],2,'.',',');?></span></div>
                                                    </div>
                                                    <input type="hidden" name="amount_invest[]" id="amount_invest_<?php echo $nIn;?>" value="<?php echo $in['amount'];?>" />
                                                </td>
                                            </tr>
                                            <?php $nIn++; endforeach;?>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td>
                                                    <div class="container-justify">
                                                        <div><?php if($info['subtotal_invest'] < 0) echo '-';?>Q</div>
                                                        <div><span id="spnSubtInvest"><?php echo number_format(abs($info['subtotal_invest']))?></span></div>
                                                    </div>
                                                    <input type="hidden" name="subtotal_invest" id="subtotal_invest" value="<?php echo $info['subtotal_invest'];?>">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>ACTIVIDADES DE FINANCIAMIENTO</td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            <?php $nFn = 1; foreach($fina->result_array() as $fn):?>
                                            <tr>
                                                <td id="rowsNoteFinance">
                                                    <span><?php echo $fn['description'];?></span>
                                                    <div id="row_note_finance_<?php echo $nFn;?>">
                                                        <input type="hidden" name="cont_finance[]" id="cont_finance_<?php echo $nFn;?>" value="<?php echo $nFn;?>" />
                                                        <input type="hidden" name="note_finance[]" id="note_finance_<?php echo $nFn;?>" value="<?php echo $fn['description'];?>"/>
                                                    </div>
                                                </td>
                                                <td id="rowsAmountFinance">
                                                    <div class="container-justify">
                                                        <div>Q</div>
                                                        <div><span id="spnNotefinance"><?php echo number_format($fn['amount'],2,'.',',');?></span></div>
                                                    </div>
                                                    <input type="hidden" name="amount_finance[]" id="amount_finance_<?php echo $nFn;?>" value="<?php echo $fn['amount'];?>" />
                                                </td>
                                            </tr>
                                            <?php $nFn++; endforeach;?>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td>
                                                    <div class="container-justify">
                                                        <div><?php if($info['subtotal_finance'] < 0) echo '-';?>Q</div>
                                                        <div><span id="spnSubtFinance"><?php echo number_format(abs($info['subtotal_finance']))?></span></div>
                                                    </div>
                                                    <input type="hidden" name="subtotal_finance" id="subtotal_finance" value="<?php echo $info['subtotal_finance'];?>">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td>
                                                    <div class="container-justify">
                                                        <div><?php if($info['total_activities'] < 0) echo '-';?>Q</div>
                                                        <div><span id="spnSubtInvest"><?php echo number_format(abs($info['total_activities']))?></span></div>
                                                    </div>
                                                    <input type="hidden" name="total_activities" id="total_activities" value="<?php echo $info['total_activities'];?>" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <input type="hidden" id="check_equals" name="check_equals" value="<?php echo $info['check_equals'];?>" checked />
                                                </td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            <tr class="equals-amounts">
                                                <td>AUMENTO NETO EN EFECTIVO Y EQUIVALENTES DE EFECTIVO EN EL PERÍODO</td>
                                                <td></td>
                                                <td></td>
                                                <td>
                                                    <div class="container-justify">
                                                        <div><?php if ($info['increase'] < 0) echo '-';?>Q</div>
                                                        <div><span id=""><?php echo number_format(abs($info['increase']),2,'.',',');?></span></div>
                                                    </div>
                                                    <input type="hidden" name="increase" id="increase" value="<?php echo number_format($info['increase'],2,'.','');?>" />
                                                </td>
                                            </tr>
                                            <tr class="equals-amounts">
                                                <td>EFECTIVO Y EQUIVALENTES DE EFECTIVO DEL <span id="spanInitial"><?php echo strtoupper(strftime("%d de %B del %Y", strtotime($info['initial'])));?></span></td>
                                                <td></td>
                                                <td></td>
                                                <td>
                                                    <div class="container-justify">
                                                        <div><?php if ($info['equal_initial'] < 0) echo '-';?>Q</div>
                                                        <div><span id=""><?php echo number_format(abs($info['equal_initial']),2,'.',',');?></span></div>
                                                    </div>
                                                    <input type="hidden" name="equal_initial" id="equal_initial" value="<?php echo number_format($info['equal_initial'],2,'.','');?>" />
                                                </td>
                                            </tr>
                                            <tr class="equals-amounts">
                                                <td>EFECTIVO Y EQUIVALENTES DE EFECTIVO AL <span id="spanFinal"><?php echo strtoupper(strftime("%d de %B del %Y", strtotime($info['final'])));?></td>
                                                <td></td>
                                                <td></td>
                                                <td>
                                                    <div class="container-justify">
                                                        <div><?php if ($info['equal_final'] < 0) echo '-';?>Q</div>
                                                        <div><span id=""><?php echo number_format(abs($info['equal_final']),2,'.',',');?></span></div>
                                                    </div>
                                                    <input type="hidden" name="equal_final" id="equal_final" value="<?php echo number_format($info['equal_final'],2,'.','');?>" />
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-lg-12 mb-3">
                                <span><?php echo $info['description'];?></span>
                                <input type="hidden" name="description" id="description" value="<?php echo $info['description'];?>" />
                            </div>
                            <div class="col-lg-12 mb-3">
                                <h4 class="card-title text-center"><?php echo $this->crud_model->getInfo("address").' '.strftime("%d de %B del %Y", strtotime($hoy));?></h4>
                            </div>
                            <div class="col-lg-6 mt-3">
                                <div>
                                    <table class="table table-bordered mb-0">
                                        <tr><td></td></tr>
                                        <tr>
                                            <td class="text-center">
                                                <span><?php echo $info['legal_name'];?></span>
                                                <input type="hidden" name="legal_name" id="legal_name" value="<?php echo $info['legal_name'];?>" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">
                                                <span><?php echo $info['legal_charge'];?></span>
                                                <input type="hidden" name="legal_charge" id="legal_charge" value="<?php echo $info['legal_charge'];?>" />
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="col-lg-6 mt-3">
                                <div>
                                    <table class="table table-bordered mb-0">
                                        <tr><td></td></tr>
                                        <tr>
                                            <td class="text-center">
                                                <span><?php echo $info['account_name'];?></span>
                                                <input type="hidden" name="account_name" id="account_name" value="<?php echo $info['account_name'];?>" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">
                                                <span><?php echo $info['account_charge'];?></span>
                                                <input type="hidden" name="account_charge" id="account_charge" value="<?php echo $info['account_charge'];?>" />
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="col-lg-12 mt-3">
                                <input type="button" class="btn btn-danger" value="PDF" onclick="submitForm('PDF')" />
                                &nbsp;&nbsp;
                                <input type="button" class="btn btn-success" value="Excel" onclick="submitForm('EXCEL')" />
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function submitForm(type) {
        $("#type").val(type);
        if(type == 'PDF') $("#frmC").attr("target", "_blank");
        else $("#frmC").attr("target", '');
        $("#frmC").submit();
    }
</script>