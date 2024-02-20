<?php $bancos = $this->crud_model->getBanks();?>
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
                            <div class="btn-toolbar mb-3">
                                <div class="">
                                    <a class="btn btn-info" type="button" href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url().'modal/popup/bank_new_modal/';?>')">+ Nuevo banco</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
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
                                    <?php $cont = 1; foreach($bancos->result_array() as $bk):?>
                                    <tr>
                                        <td><?php echo $cont++;?></td>
                                        <td><?php echo $bk['name'];?></td>
                                        <td><?php echo $bk['description'];?></td>
                                        <td class="text-center">
                                            <a class="btn btn-sm btn-<?php if($bk['status'] == 1) echo "success"; else echo "danger";?> btn-rounded" href="javascript:void(0);">
                                                <?php if($bk['status'] == 1) echo "Activo"; else echo "Inactivo";?>
                                            </a>
                                        </td>
                                        <td>
                                            <a class="btn btn-primary" href="javascript:void(0)" onclick="showAjaxModal('<?php echo base_url().'modal/popup/bank_edit_modal/'.base64_encode($bk['bank_id']);?>')">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            &nbsp;
                                            &nbsp;
                                                <?php if($bk['status'] == 1):?>
                                            <a class="btn btn-warning" href="javascript:void(0);" onclick="desactivarBanco('<?php echo base64_encode($bk['bank_id']);?>', '<?php echo $bk['name'];?>')">
                                                <i class="mdi mdi-block-helper"></i>
                                            </a>
                                                <?php else:?>
                                            <a class="btn btn-success" href="javascript:void(0);" onclick="activarBanco('<?php echo base64_encode($bk['bank_id']);?>', '<?php echo $bk['name'];?>')">
                                                <i class="fas fa-check-circle"></i>
                                            </a>
                                                <?php endif;?>
                                            &nbsp;
                                            &nbsp;
                                            <a class="btn btn-danger" href="javascript:void(0)" onclick="eliminarBanco('<?php echo base64_encode($bk['bank_id']);?>', '<?php echo $$bk['name'];?>')">
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
    function desactivarBanco(id,nombre) {
        Swal.fire({
            title: '¿Estás seguro de desactivar el banco?',
            text: "¡El banco "+nombre+", no aparecerá en todos los formularios que se necesite!, puedes reactivarlo después.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Desactivar',
            cancelButtonText: 'Cancelar',
            padding: '2em'
        }).then(function(result) {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url();?>doctor/banks/deactivate/",
                    data: {
                        id: id,
                    },
                    beforeSend: function () {
                        Swal.fire({
                            title: "Cargando",
                            text: "Espera a que se desactive el banco.",
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
                            text: "El banco "+nombre+" ha sido desactivado.",
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

    function activarBanco(id,nombre) {
        Swal.fire({
            title: '¿Estás seguro de activar el banco?',
            text: "¡El banco "+nombre+", volverá a aparecer en todos los formularios que se necesite!",
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Activar',
            cancelButtonText: 'Cancelar',
            padding: '2em'
        }).then(function(result) {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url();?>doctor/banks/activate/",
                    data: {
                        id: id,
                    },
                    beforeSend: function () {
                        Swal.fire({
                            title: "Cargando",
                            text: "Espera a que se active el banco.",
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
                            text: "El banco "+nombre+" ha sido activado.",
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

    function eliminarBanco(id,nombre) {
        Swal.fire({
            title: '¿Estás seguro de eliminar banco?',
            text: "¡El banco "+nombre+" se eliminará definitivamente, no podrás revertir esta acción!",
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Eliminar',
            cancelButtonText: 'Cancelar',
            padding: '2em'
        }).then(function(result) {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url();?>doctor/banks/delete/",
                    data: {
                        id: id,
                    },
                    beforeSend: function () {
                        Swal.fire({
                            title: "Cargando",
                            text: "Espera a que se elimine el banco.",
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
                            text: "El banco "+nombre+" ha sido eliminada.",
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