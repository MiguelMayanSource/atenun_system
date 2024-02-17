<?php $flows = $this->crud_model->getCashFlows();?>
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
        <div class="col-12">
            <div class="title-header">
                <a class="add-buton" href="<?php echo base_url();?>admin/accounting/">Regresar</a>
                <a class="add-buton" href="<?php echo base_url();?>admin/bank_conciliations/">Conciliación bancaria</a>
            </div>
            <div class="card-box">
                <div class="card-b">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="title-header">
                                <h4 class="card-title">Flujos de efectivo registrados</h4>
                            </div>
                            <div class="btn-toolbar mb-2">
                                <div class="">
                                    <a type="button" class="btn btn-info" href="<?php echo base_url();?>admin/cash_flow/">
                                        <span class="glyphicon glyphicon-screenshot"></span>Generar flujo de efectivo
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Inicial</th>
                                        <th>Final</th>
                                        <th>Utilidad</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $cont = 1; foreach ($flows->result_array() as $fl):
                                        $acc = $this->crud_model->getAccountBank($fl['bank_account_id']);?>
                                    <tr>
                                        <th scope="row"><?php echo $cont++;?></th>
                                        <td><?php echo date("d/m/Y", strtotime($fl['initial']));?></td>
                                        <td><?php echo date("d/m/Y", strtotime($fl['final']));?></td>
                                        <td>
                                            <div class="container-justify">
                                                <div><?php if($fl['utility'] < 0) echo '-';?>Q</div>
                                                <div><?php echo number_format(abs($fl['utility']),2,'.',',');?></div>
                                            </div>
                                        </td>
                                        <td>
                                            <a class="btn btn-secondary" href="<?php echo base_url().'admin/cash_flow_detail/'.base64_encode($fl['cash_flow_id'])?>" >
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            &nbsp;
                                            &nbsp;
                                            <a class="btn btn-danger" href="javascript:void(0)" onclick="eliminarFlujoEfectivo('<?php echo base64_encode($fl['cash_flow_id']);?>')">
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
<script src="<?php echo base_url();?>public/assets/libs/sweetalert2/sweetalert2.min.js"></script>
<script src="<?php echo base_url();?>public/assets/js/pages/sweet-alerts.init.js"></script>
<script type="text/javascript">
    function eliminarFlujoEfectivo(id) {
        Swal.fire({
            title: '¿Estás seguro de eliminar la conciliación?',
            text: "¡La conciliación se eliminará definitivamente, no podrás revertir esta acción!",
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Eliminar',
            cancelButtonText: 'Cancelar',
            padding: '2em'
        }).then(function(result) {
            // console.log("Result:", result);
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url();?>admin/cash_flows/delete/",
                    data: {
                        id: id,
                    },
                    beforeSend: function () {
                        Swal.fire({
                            title: "Cargando",
                            text: "Espera a que se elimine la conciliación.",
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
                            text: "La conciliación ha sido eliminado.",
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