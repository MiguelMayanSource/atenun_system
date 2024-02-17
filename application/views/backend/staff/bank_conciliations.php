<?php $concils = $this->crud_model->getBankConciliations();?>
<script src="<?php echo base_url();?>public/uploads/sweetalert2.all.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="<?php echo base_url();?>public/assets/libs/select2/js/select2.min.js"></script>
<link href="<?php echo base_url();?>public/assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
<div id="main-content">
    <div class="row">
        <div class="col-12">
            <div class="title-header">
                <a class="add-buton" href="<?php echo base_url();?>staff/accounting/">Regresar</a>
                <a class="add-buton" href="<?php echo base_url();?>staff/cash_flows/">Flujo de efectivo</a>
            </div>
            <div class="card-box">
                <div class="card-b">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="title-header">
                                <h4 class="card-title">Conciliaciones bancarias</h4>
                            </div>
                            <div class="btn-toolbar mb-2">
                                <div class="">
                                    <a type="button" class="btn btn-info" href="<?php echo base_url();?>staff/bank_conciliation/">
                                        <span class="glyphicon glyphicon-screenshot"></span>Generar conciliación
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Cuenta</th>
                                        <th>Inicial</th>
                                        <th>Final</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $cont = 1; foreach ($concils->result_array() as $cl):
                                        $acc = $this->crud_model->getAccountBank($cl['bank_account_id']);?>
                                    <tr>
                                        <th scope="row"><?php echo $cont++;?></th>
                                        <td><?php echo $acc['code'].' - '.$acc['name'];?></td>
                                        <td><?php echo date("d/m/Y", strtotime($cl['initial']));?></td>
                                        <td><?php echo date("d/m/Y", strtotime($cl['final']));?></td>
                                        <td>
                                            <a class="btn btn-secondary" href="<?php echo base_url().'staff/bank_conciliation_detail/'.base64_encode($cl['bank_conciliation_id'])?>" >
                                                <i class="mdi mdi-file-document"></i>
                                            </a>
                                            &nbsp;
                                            &nbsp;
                                            <a class="btn btn-danger" href="javascript:void(0)" onclick="eliminarConciliación('<?php echo base64_encode($cl['bank_conciliation_id']);?>')">
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
    function eliminarConciliación(id) {
        Swal.fire({
            title: '¿Estás seguro de eliminar la conciliación?',
            text: "¡La conciliación se eliminará definitivamente, no podrás revertir esta acción!",
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
                    url: "<?php echo base_url();?>staff/bank_conciliations/delete/",
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