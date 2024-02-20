<?php setlocale(LC_TIME,"es_ES"); $cierres = $this->crud_model->getClosing($type);?>
<script src="<?php echo base_url();?>public/uploads/sweetalert2.all.min.js"></script>
<style type="text/css">
    .btn-toolbar {
        display: none !important;
    }
    
    .container-justify {
        display: flex;
        justify-content: space-between;
    }
</style>
<div id="main-content">
    <div class="row">
        <div class="col-12">
            <div class="title-header">
                <a class="add-buton" href="<?php echo base_url();?>admin/accounting/">Regresar</a>
                <a class="add-buton" href="javascript:void(0);" onclick="modal_lg('<?php echo base_url();?>modal/popup/modal_accounting_acr/')">Ajustes, cierres y reaperturas</a>
            </div>
            <div class="card-box">
                <div class="card-b">
                    <div class="title-header"></div>
                    <ul class="nav nav-pills nav-justified mb-3" role="tablist">
                        <li class="nav-item waves-effect waves-light">
                            <a class="nav-link <?php if($type == 'year') echo "active";?>" href="<?php echo base_url().'admin/closing/year';?>">
                                <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                <span class="d-none d-sm-block">Anual</span> 
                            </a>
                        </li>
                        <li class="nav-item waves-effect waves-light">
                            <a class="nav-link <?php if($type == 'month') echo "active";?>" href="<?php echo base_url().'admin/closing/month';?>">
                                <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                <span class="d-none d-sm-block">Mensual</span> 
                            </a>
                        </li>
                    </ul>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="">
                                <div class="mb-3">
                                    <a class="btn btn-info" href="<?php echo base_url();?>admin/closing_departure/">
                                        <span class="glyphicon glyphicon-screenshot"></span>Registrar cierre
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
                                            <th style="width: 25%">Categoria</th>
                                            <th style="width: 20%">Periodo</th>
                                            <th style="width: 20%">Tipo</th>
                                            <th style="width: 20%">Total</th>
                                            <th style="width: 10%">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $cont = 1; foreach($cierres->result_array() as $cr):
                                            $dep = $this->crud_model->getDepByACR("closing", $cr['closing_id']);?>
                                        <tr>
                                            <td><?php echo $cont++;?></td>
                                            <td>
                                                <?php if($cr['category'] == "sales_cost") echo "Costo de ventas";
                                                    elseif($cr['category'] == "final_inventory") echo "Inventario final";
                                                    elseif($cr['category'] == "profit_loss") echo "Pérdidas y Ganancias";
                                                    elseif($cr['category'] == "gross_sales") echo "Ventas brutas";
                                                    elseif($cr['category'] == "profit_account") { 
                                                        echo "Contabilización de la ";
                                                        if($dep['total'] >= 0) echo "ganancia";
                                                        else echo "pérdida";
                                                    }
                                                    elseif($cr['category'] == "equity_accounts") echo "Cierre cuentas patrimoniales";
                                                    elseif($cr['category'] == "other") echo "Otro";?>
                                            </td>
                                            <td><?php echo $cr['period']; ?></td>
                                            <td><?php if($cr['type'] == "year") echo "Anual"; elseif($cr['type'] == "month") echo "Mensual - ".ucfirst(strftime("%B", strtotime($cr['period'].'-'.$cr['month']."-01")));?></td>
                                            <td>
                                                <div class="container-justify">
                                                    <div>Q</div>
                                                    <div><?php echo number_format(abs($dep['total']),2,'.',',');?></div>
                                                </div>
                                            </td>
                                            <td>
                                                <a class="btn btn-primary" href="<?php echo base_url()."admin/closing_detail/".base64_encode($cr['closing_id']);?>"><i class="bx bx-detail"></i></a>
                                                &nbsp;
                                                &nbsp;
                                                <a class="btn btn-danger" href="javascript:void(0)" onclick="eliminarCierre('<?php echo base64_encode($cr['closing_id']);?>')">
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
                    url: "<?php echo base_url();?>admin/closing/delete/",
                    data: {
                        id: id,
                    },
                    beforeSend: function () {
                        Swal.fire({
                            title: "Cargando",
                            text: "Espera a que se elimine el cierre.",
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