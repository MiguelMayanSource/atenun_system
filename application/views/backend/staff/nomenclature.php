<?php $types = $this->crud_model->getHeadingsTypes(); $cont = 1;?>
<script src="<?php echo base_url();?>public/uploads/sweetalert2.all.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/7.1.96/css/materialdesignicons.min.css" integrity="sha512-NaaXI5f4rdmlThv3ZAVS44U9yNWJaUYWzPhvlg5SC7nMRvQYV9suauRK3gVbxh7qjE33ApTPD+hkOW78VSHyeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<div id="main-content">
    <div class="row">
        <div class="col-md-12">
            <div class="title-header">
                <a class="add-buton" href="<?php echo base_url();?>staff/accounting/">Regresar</a>
                <a class="add-buton" href="<?php echo base_url();?>staff/departures/">Pártidas</a>
            </div>
            <div class="card-box">
                <div class="card-b">
                    <div class="row">
                       
                        <div class="col-sm-12">
                             <div class="title-header">
                                <a class="add-buton " href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url().'modal/popup/nomen_new_modal/';?>')">+ Nuevo rubro</a>
                            </div>
                            <table class="table table-bordered dt-responsive mb-0" id="datatable">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 5%">#</th>
                                        <th style="width: 15%">Código</th>
                                        <th style="width: 20%">Nombre</th>
                                        <th style="width: 15%">Figura en...</th>
                                        <th style="width: 20%">Descripción</th>
                                        <th style="width: 10%">Estado</th>
                                        <th style="width: 15%"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($types->result_array() as $tp):?>
                                        <?php if($tp['hide'] == 0):
                                            $st = $this->crud_model->getStatement($tp['statement_id']);?>
                                    <tr class="table-light">
                                        <td><?php echo $cont++;?></td>
                                        <td><?php echo $tp['code'];?></td>
                                        <td><?php echo $tp['name'];?></td>
                                        <td><?php echo $st['name'];?></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                        <?php endif;?>
                                    <?php $heads = $this->crud_model->getHeadsByType($tp['heading_type_id']);
                                        foreach ($heads->result_array() as $hd):?>
                                            <?php if($hd['hide'] == 0):
                                                $st = $this->crud_model->getStatement($hd['statement_id']);?>
                                    <tr class="table-light">
                                        <td><?php echo $cont++;?></td>
                                        <td><?php echo $hd['code'];?></td>
                                        <td><?php echo $hd['name'];?></td>
                                        <td><?php echo $st['name'];?></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                            <?php endif;?>
                                    <?php $groups = $this->crud_model->getGroupsByHead($hd['heading_id']);
                                            foreach ($groups->result_array() as $gp):
                                                $st = $this->crud_model->getStatement($hd['statement_id']);?>
                                                <?php if($gp['hide'] == 0):
                                                    $st = $this->crud_model->getStatement($tp['statement_id']);?>
                                    <tr class="table-light">
                                        <td><?php echo $cont++;?></td>
                                        <td><?php echo $gp['code'];?></td>
                                        <td><?php echo $gp['name'];?></td>
                                        <td><?php echo $st['name'];?></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                                <?php endif;?>
                                    <?php $cuentas = $this->crud_model->getAccountByGroup($gp['group_account_id']);
                                                foreach ($cuentas->result_array() as $ct):
                                                    $st = $this->crud_model->getStatement($ct['statement_id']);?>
                                    <tr>
                                        <td><?php echo $cont++;?></td>
                                        <td><?php echo $ct['code'];?></td>
                                        <td><?php echo $ct['name'];?></td>
                                        <td><?php if($ct['balance'] == 1) echo "Balance General"; if($ct['balance'] == 1 && $ct['statement'] == 1) echo " - "; if($ct['statement'] == 1) echo "Estado de Resultados"; if($ct['balance'] != 1 && $ct['statement'] != 1) echo "Solo para control";?></td>
                                        <td><?php echo $ct['description'];?></td>
                                        <td class="text-center">
                                            <a class="btn btn-<?php if($ct['status'] == 1) echo "success"; else echo "danger";?> btn-sm btn-rounded" href="javascript:void(0);">
                                                <?php if($ct['status'] == 1) echo "Activo"; else echo "Inactivo";?>
                                            </a>
                                        </td>
                                        <td>
                                            <a class="btn btn-primary" href="javascript:void(0)" onclick="showAjaxModal('<?php echo base_url().'modal/popup/nomen_edit_modal/'.base64_encode($ct['nomenclature_id']);?>')">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <?php $id = $ct['nomenclature_id'];
                                                if($id != 25 && $id != 58 && $id != 27 && $id != 30 && $id != 33 && $id != 59 && $id != 61 && $id != 67 && $id != 137 && $id != 160):?>
                                            &nbsp;
                                            &nbsp;
                                                <?php if($ct['status'] == 1):?>
                                            <a class="btn btn-warning" href="javascript:void(0);" onclick="desactivarNomen('<?php echo base64_encode($ct['nomenclature_id']);?>', '<?php echo $ct['code'].' - '.$ct['name'];?>')">
                                                <i class="mdi mdi-block-helper"></i>
                                            </a>
                                                <?php else:?>
                                            <a class="btn btn-success" href="javascript:void(0);" onclick="activarNomen('<?php echo base64_encode($ct['nomenclature_id']);?>', '<?php echo $ct['code'].' - '.$ct['name'];?>')">
                                                <i class="fas fa-check-circle"></i>
                                            </a>
                                                <?php endif;?>
                                            <?php endif;?>
                                        </td>
                                    </tr>
                                                <?php endforeach;?>
                                            <?php endforeach;?>
                                        <?php endforeach;?>
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
<script type="text/javascript" >
    var rubro = false;

    $(document).ready(function () {
        $('#datatable').DataTable({
            'bPaginate': false
        });
    });

    function desactivarNomen(id,nombre) {
        Swal.fire({
            title: '¿Estás seguro de desactivar la cuenta?',
            text: "¡La cuenta "+nombre+", no aparecerá en todos los formularios que se necesite!, puedes reactivarlo después.",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Desactivar',
            cancelButtonText: 'Cancelar',
            padding: '2em'
        }).then(function(result) {
            console.log(result);
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url();?>staff/nomenclature/deactivate_nomen/"+id,
                    beforeSend: function () {
                        Swal.fire({
                            title: "Cargando",
                            text: "Espera a que se desactive la cuenta.",
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
                            text: "La cuenta "+nombre+" ha sido desactivada.",
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

    function activarNomen(id,nombre) {
        Swal.fire({
            title: '¿Estás seguro de activar la cuenta?',
            text: "¡La cuenta "+nombre+", volverá a aparecer en todos los formularios que se necesite!",
            type: 'question',
            showCancelButton: true,
            confirmButtonText: 'Activar',
            cancelButtonText: 'Cancelar',
            padding: '2em'
        }).then(function(result) {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url();?>staff/nomenclature/activate_nomen/"+id,
                    beforeSend: function () {
                        Swal.fire({
                            title: "Cargando",
                            text: "Espera a que se active la cuenta.",
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
                            text: "La cuenta "+nombre+" ha sido activada.",
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

    function eliminarNomen(id,nombre) {
        Swal.fire({
            title: '¿Estás seguro de eliminar la cuenta?',
            text: "¡La cuenta "+nombre+" se eliminará definitivamente, no podrás revertir esta acción!",
            type: 'question',
            showCancelButton: true,
            confirmButtonText: 'Eliminar',
            cancelButtonText: 'Cancelar',
            padding: '2em'
        }).then(function(result) {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url();?>staff/nomenclature/delete_nomen/"+id,
                    beforeSend: function () {
                        Swal.fire({
                            title: "Cargando",
                            text: "Espera a que se elimine la cuenta.",
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
                            text: "La cuenta "+nombre+" ha sido eliminada.",
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