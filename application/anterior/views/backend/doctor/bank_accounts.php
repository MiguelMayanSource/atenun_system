<?php $cuentas = $this->crud_model->getBanksAccounts($property);?>
<script src="<?php echo base_url();?>public/uploads/sweetalert2.all.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="<?php echo base_url();?>public/assets/libs/select2/js/select2.min.js"></script>
<link href="<?php echo base_url();?>public/assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
<?php include "navigation_bank.php";?>
<div id="main-content">
    <div class="row">
        <div class="col-12">
            <div class="card-box">
                <div class="card-b">
                    <div class="title-header"></div>
                    <ul class="nav nav-pills nav-justified mb-3" role="tablist">
                        <li class="nav-item waves-effect waves-light">
                            <a class="nav-link <?php if($property == 1) echo "active";?>" href="<?php echo base_url().'doctor/bank_accounts/1';?>">
                                <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                <span class="d-none d-sm-block">Propias</span> 
                            </a>
                        </li>
                        <li class="nav-item waves-effect waves-light">
                            <a class="nav-link <?php if($property == 2) echo "active";?>" href="<?php echo base_url().'doctor/bank_accounts/2';?>">
                                <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                <span class="d-none d-sm-block">Terceros</span> 
                            </a>
                        </li>
                    </ul>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="btn-toolbar mb-3">
                                <div class="">
                                    <a class="btn btn-info" type="button" href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url().'modal/popup/bank_account_new_modal/'.$property;?>')">+ Nueva cuenta</a>
                                    &nbsp;
                                    &nbsp;
                                    <a href="<?php echo base_url();?>doctor/account_types/" class="btn btn-primary">
                                        <span class="glyphicon glyphicon-screenshot"></span>Tipos de cuenta
                                    </a>
                                </div>  
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Número de cuenta</th>
                                        <th>Nombre</th>
                                        <th>Banco</th>
                                        <th>Tipo de cuenta</th>
                                        <th>Moneda</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $cont = 1; foreach($cuentas->result_array() as $ct):?>
                                    <tr>
                                        <td><?php echo $cont++;?></td>
                                        <td><?php echo $ct['code'];?></td>
                                        <td><?php echo $ct['name'];?></td>
                                        <?php $bank = $this->crud_model->getBank($ct['bank_id']);?>
                                        <td><?php echo $bank['name'];?></td>
                                        <?php $type = $this->crud_model->getAccountBank($ct['account_type_id']);?>
                                        <td><?php echo $type['name'];?></td>
                                        <?php $mon = $this->crud_model->getCurrency($ct['currency_id']);?>
                                        <td><?php echo $mon['symbol'];?></td>
                                        <td class="text-center">
                                            <a class="btn btn-sm btn-<?php if($ct['status'] == 1) echo "success"; else echo "danger";?> btn-rounded" href="javascript:void(0);">
                                                <?php if($ct['status'] == 1) echo "Activo"; else echo "Inactivo";?>
                                            </a>
                                        </td>
                                        <td>
                                            <a class="btn btn-primary" href="javascript:void(0)" onclick="showAjaxModal('<?php echo base_url().'modal/popup/bank_account_edit_modal/'.base64_encode($ct['bank_account_id']).'/'.$property;?>')">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            &nbsp;
                                            &nbsp;
                                                <?php if($ct['status'] == 1):?>
                                            <a class="btn btn-warning" href="javascript:void(0);" onclick="desactivarCuenta('<?php echo base64_encode($ct['bank_account_id']);?>', '<?php echo $ct['name'];?>')">
                                                <i class="mdi mdi-block-helper"></i>
                                            </a>
                                                <?php else:?>
                                            <a class="btn btn-success" href="javascript:void(0);" onclick="activarCuenta('<?php echo base64_encode($ct['bank_account_id']);?>', '<?php echo $ct['name'];?>')">
                                                <i class="fas fa-check-circle"></i>
                                            </a>
                                                <?php endif;?>
                                            &nbsp;
                                            &nbsp;
                                            <a class="btn btn-danger" href="javascript:void(0)" onclick="eliminarCuenta('<?php echo base64_encode($ct['bank_account_id']);?>', '<?php echo $ct['name'];?>')">
                                                <i class="mdi mdi-delete"></i>
                                            </a>
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
    function desactivarCuenta(id,nombre) {
        Swal.fire({
            title: '¿Estás seguro de desactivar la cuenta bancaria?',
            text: "¡La cuenta bancaria "+nombre+", no aparecerá en todos los formularios que se necesite!, puedes reactivarla después.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Desactivar',
            cancelButtonText: 'Cancelar',
            padding: '2em'
        }).then(function(result) {
            
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url();?>doctor/bank_accounts/deactivate/",
                    data: {
                        id: id,
                    },
                    beforeSend: function () {
                        Swal.fire({
                            title: "Cargando",
                            text: "Espera a que se desactive la cuenta bancaria.",
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
                            text: "La cuenta bancaria "+nombre+" ha sido desactivada.",
                            icon: 'success',
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

    function activarCuenta(id,nombre) {
        Swal.fire({
            title: '¿Estás seguro de activar la cuenta bancaria?',
            text: "¡La cuenta bancaria "+nombre+", volverá a aparecer en todos los formularios que se necesite!",
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Activar',
            cancelButtonText: 'Cancelar',
            padding: '2em'
        }).then(function(result) {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url();?>doctor/bank_accounts/activate/",
                    data: {
                        id: id,
                    },
                    beforeSend: function () {
                        Swal.fire({
                            title: "Cargando",
                            text: "Espera a que se active la cuenta bancaria.",
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
                            text: "La cuenta bancaria "+nombre+" ha sido activada.",
                            icon: 'success',
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

    function eliminarCuenta(id,nombre) {
        Swal.fire({
            title: '¿Estás seguro de eliminar la cuenta bancaria?',
            text: "¡La cuenta bancaria "+nombre+" se eliminará definitivamente, no podrás revertir esta acción!",
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Eliminar',
            cancelButtonText: 'Cancelar',
            padding: '2em'
        }).then(function(result) {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url();?>doctor/bank_accounts/delete/",
                    data: {
                        id: id,
                    },
                    beforeSend: function () {
                        Swal.fire({
                            title: "Cargando",
                            text: "Espera a que se elimine la cuenta bancaria.",
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
                            text: "La cuenta bancaria "+nombre+" ha sido eliminada.",
                            icon: 'success',
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