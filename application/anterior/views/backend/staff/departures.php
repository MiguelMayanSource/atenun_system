<?php $partidas = $this->crud_model->getDeparturesActive($initial, $final, $nomenclature_id);
    $check = $this->crud_model->getInfo("check_close");?>
<script src="<?php echo base_url();?>public/uploads/sweetalert2.all.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="<?php echo base_url();?>public/assets/libs/select2/js/select2.min.js"></script>
<link href="<?php echo base_url();?>public/assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
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
                <a class="add-buton" href="<?php echo base_url();?>staff/accounting/">Regresar</a>
                <a class="add-buton" href="<?php echo base_url();?>staff/nomenclature/">Nomenclatura</a>
            </div>
            <div class="card-box">
                <div class="card-b">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="title-header">
                                <h4 class="card-title">Partidas registradas</h4>
                            </div>
                            <form method="post" action="<?php echo base_url();?>staff/departures/">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label for="">Nomenclature</label>
                                            <select name="nomenclature_id" id="select2-nom" class="form-control" onchange="this.form.submit()">
                                                <option value="T" <?php if ($nomenclature_id == 'T' || $nomenclature_id == '') echo "selected";?>>Todos</option>
                                                <?php $rubros = $this->crud_model->getNomenclature();
                                                    foreach($rubros->result_array() as $nm):?>
                                                <option value="<?php echo $nm['nomenclature_id'];?>" <?php if ($nm['nomenclature_id'] == $nomenclature_id) echo "selected";?>><?php echo $nm['code'].' '.$nm['name'];?></option>
                                                <?php endforeach;?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6"></div>
                                    <div class="col-sm-5">
                                        <div class="mb-3">
                                            <label for="initial">Fecha inicial:</label>
                                            <input type="date" class="form-control" name="initial" id="initial" value="<?php echo $initial;?>" required />
                                        </div>
                                    </div>
                                    <div class="col-sm-5">
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
                                    <a class="btn btn-info" href="<?php echo base_url();?>staff/departure">
                                        <span class="glyphicon glyphicon-screenshot"></span>Nueva partida
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th style="width: 5%">#</th>
                                            <th style="width: 15%">Fecha</th>
                                            <th style="width: 15%">Total</th>
                                            <th style="width: 50%">Detalles</th>
                                            <th style="width: 15%">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $cont = 1; foreach($partidas->result_array() as $pt):
                                            $close = $this->crud_model->verifyPeriodDeparture($pt['date']);?>
                                        <tr>
                                            <td><?php echo $cont++;?></td>
                                            <td><?php echo date("d/m/Y", strtotime($pt['date']));?></td>
                                            <td>
                                                <div class="container-justify">
                                                    <div>Q</div>
                                                    <div><?php echo number_format($pt['total'],2,".",",");?></div>
                                                </div>
                                            </td>
                                            <td><?php echo $pt['details'];?></td>
                                            <td>
                                                <?php if($close <= 0 || $check):?>
                                                <a class="btn btn-primary" href="<?php echo base_url().'staff/departure_edit/'.base64_encode($pt['departure_id']);?>">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                &nbsp;
                                                &nbsp;
                                                <?php endif;?>
                                                <a class="btn btn-secondary" href="<?php echo base_url().'staff/policy_departure/'.base64_encode($pt['departure_id']);?>">
                                                    <i class="mdi mdi-file-document"></i>
                                                </a>
                                                <?php if($close <= 0 || $check):?>
                                                &nbsp;
                                                &nbsp;
                                                <a class="btn btn-danger" href="javascript:void(0)" onclick="desactivarPartida('<?php echo base64_encode($pt['departure_id']);?>')">
                                                    <i class="mdi mdi-delete"></i>
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
    
    $('#select2-nom').select2({
        placeholder: "Escribe el código de algún rubro",
    });

    function desactivarPartida(id) {
        Swal.fire({
            title: '¿Estás seguro de eliminar la partida?',
            text: "¡La partida no aparecerá en todos los formularios que se necesite!, puedes reactivarlo después.",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Eliminar',
            cancelButtonText: 'Cancelar',
            padding: '2em'
        }).then(function(result) {
            console.log(result);
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url();?>staff/departures/deactivate/",
                    data: {
                        id: id,
                    },
                    beforeSend: function () {
                        Swal.fire({
                            title: "Cargando",
                            text: "Espera a que se elimine la partida.",
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
                            text: "La partida ha sido eliminada.",
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

    function activarPartida(id) {
        Swal.fire({
            title: '¿Estás seguro de activar la partida?',
            text: "¡La partida volverá a apareceren todos los formularios que se necesite!",
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Activar',
            cancelButtonText: 'Cancelar',
            padding: '2em'
        }).then(function(result) {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url();?>staff/departures/activate/",
                    data: {
                        id: id,
                    },
                    beforeSend: function () {
                        Swal.fire({
                            title: "Cargando",
                            text: "Espera a que se active la partida.",
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
                            text: "La partida ha sido activado.",
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

    function eliminarPartida(id) {
        Swal.fire({
            title: '¿Estás seguro de eliminar la partida?',
            text: "¡La partida se eliminará definitivamente, no podrás revertir esta acción!",
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Eliminar',
            cancelButtonText: 'Cancelar',
            padding: '2em'
        }).then(function(result) {
            console.log(result);
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url();?>staff/departures/delete/",
                    data: {
                        id: id,
                    },
                    dataType: "json",
                    beforeSend: function () {
                        Swal.fire({
                            title: "Cargando",
                            text: "Espera a que se elimine la partida.",
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
                            text: "La partida ha sido eliminado.",
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