<div class="white-box">
    <div class="os-tabs-w">
        <div class="os-tabs-controls">
            <ul class="navx nav-tabs">
                <li class="nav-item text-center">
                    <a class="nav-link  " href="<?php echo base_url();?>staff/inventory/">
                        <div class="navWidget"><i class="picons-thin-icon-thin-0820_medicine_drugs_ill_pill"></i></div> <span>Farmacia</span>
                    </a>
                </li>
                <li class="nav-item text-center">
                    <a class="nav-link " href="<?php echo base_url();?>staff/inventory_iv/">
                        <div class="navWidget"><i class="picons-thin-icon-thin-0820_medicine_drugs_ill_pill"></i></div> <span>Medicamentos IV</span>
                    </a>
                </li>
                <li class="nav-item text-center">
                    <a class="nav-link " href="<?php echo base_url();?>staff/laboratories/">
                        <div class="navWidget"><i class="picons-thin-icon-thin-0816_microscope_laboratory"></i></div><span>Laboratorios</span>
                    </a>
                </li>
                <li class="nav-item text-center">
                    <a class="nav-link current" href="<?php echo base_url();?>staff/rayos_x/">
                        <div class="navWidget"><i class="picons-thin-icon-thin-0827_body_weight_fitness_health_fat"></i></div><span>Rayos X</span>
                    </a>
                </li>
                <li class="nav-item text-center">
                    <a class="nav-link" href="<?php echo base_url();?>staff/product_estb/">
                        <div class="navWidget"><i class="picons-thin-icon-thin-0723_nurse_medicine_hospital_doctor"></i></div><span>Productos de estabilización</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
<div id="main-content">
    <div class="row ">
        <div class="col-sm-12">
            <div class="title-header"><br>
                <h3 class="module-title">Rayos X</h3>
                <a class="add-buton pull-right" href="javascript:void(0);" data-toggle="modal" data-target="#123myModal">+ Nuevo Rayos X</a>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card-b">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="table-responsive">
                            <table class="table table-padded" id="user_data">
                                <thead>
                                    <tr>

                                        <th>No.</th>
                                        <th>Nombre</th>
                                        <th>Precio de día</th>
                                        <th>Precio de noche</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal" id="123myModal">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content animated fadeInDown">
            <form action="<?php echo base_url();?>staff/rayos_x/create" method="POST">
                <div class="modal-header" style="background-color:#fff; box-shadow: 0 4px 2px -2px 000;">
                    <h4 style="font-size:21px; color:#565b6b; font-family:'Poppins';"><span style="vertical-align:-3px"> Agregar rayos x.</span></h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="container">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group m-b-15">
                                        <label for="simpleinput">Nombre</label>
                                        <input type="text" name="name" required="" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group m-b-15">
                                        <label for="simpleinput">Precio de día</label>
                                        <input type="text" name="price_day" required="" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group m-b-15">
                                        <label for="simpleinput">Precio de noche</label>
                                        <input type="text" name="price_night" required="" class="form-control">
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="button-confirm">Enviar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript" language="javascript">
$(document).ready(function() {
    var dataTable = $('#user_data').DataTable({
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            url: "<?php echo base_url() . 'staff/getTable/rayos_x'; ?>",
            type: "POST"
        },

        "columnDefs": [{
            "targets": 0,
            "orderable": false,
        }, ],
        fixedColumns: true,
    });
});
</script>
<script type="text/javascript">
function delete(laboratory_id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "Esta acción no puede deshacerse. ¿Aún así, desea continuar?",
        type: 'info',
        showCancelButton: true,
        confirmButtonColor: '#9fd13b',
        cancelButtonColor: '#fd4f57',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.value) {
            location.href = "<?php echo base_url();?>staff/laboratories/delete/" + laboratory_id;
        }
    })
}
</script>