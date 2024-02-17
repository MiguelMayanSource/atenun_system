<?php $trans = $this->crud_model->getBankTransfers($initial, $final, $account_id);?>
<?php $cuentas = $this->crud_model->getBankAccountsActive();?>  
<script src="<?php echo base_url();?>public/uploads/sweetalert2.all.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="<?php echo base_url();?>public/assets/libs/select2/js/select2.min.js"></script>
<link href="<?php echo base_url();?>public/assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
<?php include "navigation_bank.php";?>
<style type="text/css">
    .container-justify {
        display: flex;
        justify-content: space-between; /* Can be changed in the live sample */
    }
</style>
<div id="main-content">
    <div class="row">
        <div class="col-12">
            <div class="card-box">
                <div class="card-b">
                    <h4 class="card-title"></h4>
                    <div class="row">
                        <div class="col-lg-12 mb-3">
                            <div class="title-header"></div>
                            <form class="repeater" action="<?php echo base_url();?>staff/bank_transfers/" method="POST" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-lg-5">
                                        <div class="form-group">
                                            <label for="">Cuenta bancaria</label><br>
                                            <select name="account_id" id="account_id" class="form-control" onchange="this.form.submit()">
                                                <option value="">Todas</option>
                                                <?php foreach($cuentas->result_array() as $ct):
                                                    $bank = $this->crud_model->getBank($ct['bank_id']);?>
                                                <option value="<?php echo $ct['bank_account_id'];?>" <?php if($ct['bank_account_id'] == $account_id) echo "selected";?>><?php echo $ct['code'].' '.$bank['name'];?></option>
                                                <?php endforeach;?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="">Fecha inicial</label>
                                        <input type="date" class="form-control" name="initial" value="<?php echo $initial;?>" />
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="">Fecha final</label>
                                        <input type="date" class="form-control" name="final" value="<?php echo $final;?>" />
                                    </div>
                                    <div class="col-lg-1">
                                        <br>
                                        <button class="btn btn-info" type="submit">Ver</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-lg-12">
                            <div class="btn-toolbar">
                                <div class="">
                                    <a class="btn btn-info" type="button" href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url().'modal/popup/bank_transfer_new_modal/';?>')">
                                        <span class="glyphicon glyphicon-screenshot"></span>Registrar transferencia
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 mb-0">
                            <table class="table table-bordered dt-responsive mb-0" id="datatable">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th class="text-center">Fecha</th>
                                        <th class="text-center">Código</th>
                                        <th class="text-center">Cuenta</th>
                                        <th class="text-center">Concepto</th>
                                        <th class="text-center">Monto</th>
                                        <th class="text-center">Saldo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $cont = 1; foreach($trans->result_array() as $ts):?>
                                    <tr>
                                        <td><?php echo $cont++;?></td>
                                        <td><?php echo date("d/m/Y", strtotime($ts['date']));?></td>
                                        <td><?php echo $ts['code'];?></td>
                                        <?php $cuenta = $this->crud_model->getBankAccount($ts['bank_account_id']);?>
                                        <td><?php echo $cuenta['code'].' - '.$cuenta['name'];?></td>
                                        <td><?php echo $ts['description'];?></td>
                                        <td style="">
                                            <div class="container-justify">
                                                <div><b><?php if($ts['type'] == 0) echo '-';?>Q</b></div>
                                                <div><b><?php echo number_format($ts['amount'],2,'.',',');?></b></div>
                                            </div>
                                        </td>
                                        <td style="">
                                            <div class="container-justify">
                                                <div><b><?php if($ts['balance'] < 0) echo '-';?>Q</b></div>
                                                <div><b><?php echo number_format(abs($ts['balance']),2,'.',',');?></b></div>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach;?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $('#account_id').select2({ 
        placeholder: "Todas las cuentas",
    });
    
    $(document).ready(function () {
        $('#datatable').DataTable({
            'bPaginate': false
        });
    });

</script>