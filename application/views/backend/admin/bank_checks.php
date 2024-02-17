<?php $checks = $this->crud_model->getBankChecksFilters($initial, $final, $account_id);?>
<script src="<?php echo base_url();?>public/uploads/sweetalert2.all.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="<?php echo base_url();?>public/assets/libs/select2/js/select2.min.js"></script>
<link href="<?php echo base_url();?>public/assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
<?php include "navigation_bank.php";?>
<style type="text/css">
    .btn-toolbar {
        display: none !important;
    }
    
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
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="title-header">
                                <h4 class="card-title"></h4>
                            </div>
                            <form method="post" action="<?php echo base_url();?>admin/bank_checks/">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="">Cuentas bancarias</label><br>
                                            <select name="account_id" id="account_id" class="form-control" onchange="this.form.submit()">
                                                <option value="">Selecciona una cuenta</option>
                                                <?php $accounts = $this->crud_model->getBankAccountsActive();
                                                    foreach ($accounts->result_array() as $ac):
                                                    $bank = $this->crud_model->getBank($ac['bank_id']);?>
                                                <option value="<?php echo $ac['bank_account_id'];?>" <?php if($ac['bank_account_id'] == $account_id) echo "selected";?>><?php echo $ac['code'].' '.$bank['name'];?></option>
                                                <?php endforeach;?>
                                            </select>
                                            <small class="text-danger" id="msgAccount"></small>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="mb-3">
                                            <label for="initial">Fecha inicial:</label>
                                            <input type="date" class="form-control" name="initial" id="initial" value="<?php echo $initial;?>" required />
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="mb-3">
                                            <label for="final">Fecha inicial:</label>
                                            <input type="date" class="form-control" name="final" id="final" value="<?php echo $final;?>" required />
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="col-mb-3">
                                            <br> 
                                            <button class="btn btn-info" type="submit">
                                                <i class="mdi mdi-eye"></i>
                                                <span>Ver</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <div class="">
                                    <button type="button" class="btn btn-info" onclick="modal_lg('<?php echo base_url().'modal/popup/bank_check_new_modal/';?>')">+ Nuevo cheque</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table id="datatable-buttons" class="table table-bordered nowrap w-100">
                                    <thead class="table-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Fecha</th>
                                            <th>Cuenta bancaria</th>
                                            <th>Cheque No.</th>
                                            <th>Total</th>
                                            <th>Paguese a</th>
                                            <th>Estado</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $cont = 1; foreach ($checks->result_array() as $ck):
                                            $acc = $this->crud_model->getInfoAccount($ck['bank_account_id']);?>
                                        <tr>
                                            <th><?php echo $cont++;?></th>
                                            <td><?php echo date("d/m/Y", strtotime($ck['date']));?></td>
                                            <td><?php echo $acc['code'].' '.$acc['bank'];?></td>
                                            <td><?php echo $ck['no_check'];?></td>
                                            <td>
                                                <div class="container-justify">
                                                    <div>Q</div>
                                                    <div><?php echo number_format($ck['amount'],2,'.',',');?></div>
                                                </div>
                                            </td>
                                            <td><?php echo $ck['pay_to'];?></td>
                                            <td class="text-center">
                                                <?php if($ck['status'] == 1):?>
                                                <button type="button" class="btn btn-success btn-sm btn-rounded waves-effect waves-light">Activo</button>
                                                <?php else:?>
                                                <button type="button" class="btn btn-danger btn-sm btn-rounded waves-effect waves-light">Anulado</button>
                                                <?php endif;?>
                                            </td>
                                            <td>
                                                <a class="btn btn-primary" href="javascript:void(0);" onclick="modal_lg('<?php echo base_url().'modal/popup/bank_check_edit_modal/'.base64_encode($ck['bank_check_id']);?>')">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                &nbsp;&nbsp;
                                                <a class="btn btn-info" href="<?php echo base_url().'admin/printPDF/check/'.base64_encode($ck['bank_check_id']);?>" target="_blank">
                                                    <i class="mdi mdi-printer"></i>
                                                </a>
                                                <?php if($ck['status'] == 1):?>
                                                &nbsp;&nbsp;
                                                <a class="btn btn-warning" href="javascript:void(0);" onclick="anularCheque('<?php echo base64_encode($ck['bank_check_id']);?>', '<?php echo $ck['no_check'];?>', '<?php echo $acc['code'].' '.$acc['bank'];?>')">
                                                    <i class="mdi mdi-block-helper"></i>
                                                </a>
                                                <?php endif;?>
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
</div>
<script type="text/javascript">
    
    $('#account_id').select2({
        placeholder: "Escribe el código de algún rubro",
    });
    
    function anularCheque(id,no,nombre) {
        Swal.fire({
            title: '¿Estás seguro de anular el cheque bancario?',
            text: "¡El cheque no. "+no+", de la cuenta bancaria: "+nombre+", no podrá utilizarse de nuevo, no podrás revertir esta acción!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Anular',
            cancelButtonText: 'Cancelar',
            padding: '2em'
        }).then(function(result) {
            console.log("Result", result);
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url();?>admin/bank_checks/cancel/",
                    data: {
                        id: id,
                    },
                    dataType: "json",
                    beforeSend: function () {
                        Swal.fire({
                            title: "Cargando",
                            text: "Espera a que se desactive el cheque.",
                            padding: '2em',
                            allowOutsideClick: false,
                            onOpen: function () {
                                swal.showLoading()
                            }
                        });
                    },
                    success: function (data) {
                        console.log(data);
                        Swal.fire({
                            title: 'Hecho!',
                            text: "El cheque no. "+no+", de la cuenta bancaria: "+nombre+", ha sido anulado.",
                            type: 'success',
                            showCancelButton: false,
                            confirmButtonText: 'OK',
                            padding: '2em'
                        }).then(function(){
                            location.reload();
                        });
                    },
                    error: function (e) {
                        console.log("Error: ", e);
                        Swal.fire({
                            title: 'Vaya!',
                            text: "Ha ocurrido un error, intentalo más tarde.",
                            type: 'error',
                            showCancelButton: false,
                            confirmButtonText: 'OK',
                            padding: '2em'
                        });
                    }
                });
            }
        });
    }
    
    function eliminarCheque(id,no,nombre) {
        Swal.fire({
            title: '¿Estás seguro de eliminar el cheque bancario?',
            text: "¡El cheque no. "+no+", de la cuenta bancaria: "+nombre+", se eliminará definitivamente, no podrás revertir esta acción!",
            type: 'question',
            showCancelButton: true,
            confirmButtonText: 'Eliminar',
            cancelButtonText: 'Cancelar',
            padding: '2em'
        }).then(function(result) {
            console.log("Result:", result);
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url();?>admin/bank_checks/delete/",
                    data: {
                        id: id,
                    },
                    beforeSend: function () {
                        Swal.fire({
                            title: "Cargando",
                            text: "Espera a que se elimine el cheque no..",
                            padding: '2em',
                            allowOutsideClick: false,
                            onOpen: function () {
                                swal.showLoading()
                            }
                        });
                    },
                    success: function (response) {
                        console.log(response);
                        Swal.fire({
                            title: 'Hecho!',
                            text: "El cheque no. "+no+", de la cuenta bancaria: "+nombre+", ha sido eliminado.",
                            type: 'success',
                            showCancelButton: false,
                            confirmButtonText: 'OK',
                            padding: '2em'
                        }).then(function(){
                            location.reload();
                        });
                    },
                    error: function (e) {
                        console.log("Error: ", e);
                        Swal.fire({
                            title: 'Vaya!',
                            text: "Ha ocurrido un error, intentalo más tarde.",
                            type: 'error',
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