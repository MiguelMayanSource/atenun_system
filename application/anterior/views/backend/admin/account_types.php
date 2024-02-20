<?php $tipos = $this->crud_model->getAccountTypes();?>
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
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="title-header"></div>
                            <div class="btn-toolbar mb-2">
                                <div class="">
                                    <a class="btn btn-primary" href="<?php echo base_url();?>admin/bank_accounts/">
                                        <i class="bx bx-arrow-back"></i> Ir a cuentas bancarias
                                    </a>
                                    &nbsp;
                                    &nbsp;
                                    <a class="btn btn-info" type="button" href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url().'modal/popup/account_type_new_modal/';?>')">+ Nuevo tipo</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <table class="table table-bordered dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nombre</th>
                                        <th>Descripción</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $cont = 1; foreach($tipos->result_array() as $tp):?>
                                    <tr>
                                        <td><?php echo $cont++;?></td>
                                        <td><?php echo $tp['name'];?></td>
                                        <td><?php echo $tp['description'];?></td>
                                        <td>
                                            <a class="btn btn-<?php if($tp['status'] == 1) echo "success"; else echo "danger";?> btn-rounded" href="javascript:void(0);">
                                                <?php if($tp['status'] == 1) echo "Activo"; else echo "Inactivo";?>
                                            </a>
                                        </td>
                                        <td>
                                            <a class="btn btn-primary" href="javascript:void(0)" onclick="showAjaxModal('<?php echo base_url().'modal/popup/account_type_edit_modal/'.base64_encode($tp['account_type_id']);?>')">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            &nbsp;
                                            &nbsp;
                                                <?php if($tp['status'] == 1):?>
                                            <a class="btn btn-warning" href="javascript:void(0);" onclick="desactivarTipo('<?php echo base64_encode($tp['account_type_id']);?>', '<?php echo $tp['name'];?>')">
                                                <i class="mdi mdi-block-helper"></i>
                                            </a>
                                                <?php else:?>
                                            <a class="btn btn-success" href="javascript:void(0);" onclick="activarTipo('<?php echo base64_encode($tp['account_type_id']);?>', '<?php echo $tp['name'];?>')">
                                                <i class="fas fa-check-circle"></i>
                                            </a>
                                                <?php endif;?>
                                            &nbsp;
                                            &nbsp;
                                            <a class="btn btn-danger" href="javascript:void(0)" onclick="eliminarTipo('<?php echo base64_encode($tp['account_type_id']);?>', '<?php echo $tp['name'];?>')">
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
    function desactivarTipo(id,nombre) {
        Swal.fire({
            title: '¿Estás seguro de desactivar el tipo de cuenta?',
            text: "¡El tipo de cuenta "+nombre+", no aparecerá en todos los formularios que se necesite!, puedes reactivarlo después.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Desactivar',
            cancelButtonText: 'Cancelar',
            padding: '2em'
        }).then(function(result) {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url();?>admin/account_types/deactivate/",
                    data: {
                        id: id,
                    },
                    beforeSend: function () {
                        Swal.fire({
                            title: "Cargando",
                            text: "Espera a que se desactive el tipo de cuenta.",
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
                            text: "El tipo de cuenta "+nombre+" ha sido desactivado.",
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

    function activarTipo(id,nombre) {
        Swal.fire({
            title: '¿Estás seguro de activar el tipo de cuenta?',
            text: "¡El tipo de cuenta "+nombre+", volverá a aparecer en todos los formularios que se necesite!",
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Activar',
            cancelButtonText: 'Cancelar',
            padding: '2em'
        }).then(function(result) {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url();?>admin/account_types/activate/",
                    data: {
                        id: id,
                    },
                    beforeSend: function () {
                        Swal.fire({
                            title: "Cargando",
                            text: "Espera a que se active el tipo de cuenta.",
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
                            text: "El tipo de cuenta "+nombre+" ha sido activado.",
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

    function eliminarTipo(id,nombre) {
        Swal.fire({
            title: '¿Estás seguro de eliminar el tipo de cuenta?',
            text: "¡El tipo de cuenta "+nombre+" se eliminará definitivamente, no podrás revertir esta acción!",
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Eliminar',
            cancelButtonText: 'Cancelar',
            padding: '2em'
        }).then(function(result) {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url();?>admin/account_types/delete/",
                    data: {
                        id: id,
                    },
                    beforeSend: function () {
                        Swal.fire({
                            title: "Cargando",
                            text: "Espera a que se elimine el tipo de cuenta.",
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
                            text: "El tipo de cuenta "+nombre+" ha sido eliminado.",
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