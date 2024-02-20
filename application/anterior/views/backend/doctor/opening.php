<?php $open = $this->crud_model->getReopening();?>
<script src="<?php echo base_url();?>public/uploads/sweetalert2.all.min.js"></script>
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
            <div class="title-header">
                <a class="add-buton" href="<?php echo base_url();?>doctor/accounting/">Regresar</a>
                <a class="add-buton" href="javascript:void(0);" onclick="modal_lg('<?php echo base_url();?>modal/popup/modal_accounting_acr/')">Ajustes, cierres y reaperturas</a>
            </div>
            <div class="card-box">
                <div class="card-b">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="title-header"></div>
                            <div class="mb-3">
                                <div class="">
                                    <a class="btn btn-info" href="<?php echo base_url();?>doctor/opening_departure/">
                                        <span class="glyphicon glyphicon-screenshot"></span>Registrar reapertura
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th style="width: 10%">#</th>
                                            <th style="width: 40%">Periodo</th>
                                            <th style="width: 35%">Total</th>
                                            <th style="width: 15%">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $cont = 1; foreach($open->result_array() as $op):
                                            $dep = $this->crud_model->getDepByACR("reopening", $op['reopening_id']);?>
                                        <tr>
                                            <td><?php echo $cont++;?></td>
                                            <td><?php echo $op['period'];?></td>
                                            <td>
                                                <div class="container-justify">
                                                    <div>Q</div>
                                                    <div><?php echo number_format(abs($dep['total']),2,'.',',');?></div>
                                                </div>
                                            </td>
                                            <td>
                                                <a class="btn btn-primary" href="<?php echo base_url()."doctor/opening_detail/".base64_encode($op['reopening_id']);?>"><i class="bx bx-detail"></i></a>
                                                &nbsp;
                                                &nbsp;
                                                <a class="btn btn-danger" href="javascript:void(0)" onclick="eliminarCierre('<?php echo base64_encode($op['reopening_id']);?>')">
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
</div>
<script type="text/javascript">
    function eliminarCierre(id) {
        Swal.fire({
            title: '¿Estás seguro de eliminar el cierre?',
            text: "¡El cierre se eliminará definitivamente, no podrás revertir esta acción!",
            type: 'question',
            showCancelButton: true,
            confirmButtonText: 'Eliminar',
            cancelButtonText: 'Cancelar',
            padding: '2em'
        }).then(function(result) {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url();?>doctor/opening/delete/",
                    data: {
                        id: id,
                    },
                    beforeSend: function () {
                        Swal.fire({
                            title: "Cargando",
                            text: "Espera a que se elimine el cierre.",
                            padding: '2em',
                            allowOutsideClick: false,
                            didOpen: function () {
                                swal.showLoading()
                            }
                        });
                    },
                    success: function (response) {
                        console.log(response);
                        Swal.fire({
                            title: 'Hecho!',
                            text: "El cierre ha sido eliminado.",
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