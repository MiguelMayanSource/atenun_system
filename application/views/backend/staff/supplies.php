<div class="white-box">
    <div class="os-tabs-w">
        <div class="os-tabs-controls">
            <ul class="navx nav-tabs">
                <li class="nav-item text-center">
                    <a class="nav-link" href="<?php echo base_url();?>staff/inventory/">
                        <div class="navWidget"><i class="picons-thin-icon-thin-0820_medicine_drugs_ill_pill"></i></div>
                        <span>Inventario</span>
                    </a>
                </li>

                <li class="nav-item text-center">
                    <a class="nav-link" href="<?php echo base_url();?>staff/categories/">
                        <div class="navWidget"><i class="picons-thin-icon-thin-0172_structure_menu_submenu_navigation"></i></div>
                        <span>Categorías</span>
                    </a>
                </li>
                <li class="nav-item text-center">
                    <a class="nav-link " href="<?php echo base_url();?>staff/solicitudes/">
                        <div class="navWidget"><i class="picons-thin-icon-thin-0014_notebook_paper_todo"></i></div>
                        <span>Pedidos</span>
                    </a>
                </li>
                <li class="nav-item text-center">
                    <a class="nav-link" href="<?php echo base_url();?>staff/services/">
                        <div class="navWidget"><i class="picons-thin-icon-thin-0813_heart_vitals_pulse_rate_health"></i></div>
                        <span>Servicios</span>
                    </a>
                </li>
                <li class="nav-item text-center">
                    <a class="nav-link " href="<?php echo base_url();?>staff/equipment/">
                        <div class="navWidget"><i class="picons-thin-icon-thin-0053_settings_tools_pipe"></i></div>
                        <span>Equipo</span>
                    </a>
                </li>

                <li class="nav-item text-center">
                    <a class="nav-link current" href="<?php echo base_url();?>staff/supplies/">
                        <div class="navWidget"><i class="picons-thin-icon-thin-0172_structure_menu_submenu_navigation"></i></div>
                        <span>Suministros</span>
                    </a>
                </li>

            </ul>
        </div>
    </div>
</div>
<div id="main-content">
    <div class="row">
        <div class="col-sm-12">
            <div class="title-header"><br>
                <h3 class="module-title">INVENTARIO DE SUMINISTROS</h3>
                <a class="add-buton pull-right" href="javascript:void(0);" data-toggle="modal" data-target="#1new_product">+ Nuevo suministro</a>
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
                                        <th>NOMBRE</th>
                                        <th>LOCALIZACION</th>
                                        <th>DESCRIPCIÓN</th>
                                        <th>CANTIDAD</th>
                                        <th>ACCIONES</th>
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

<script type="text/javascript" language="javascript">
$(document).ready(function() {
    var dataTable = $('#user_data').DataTable({
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            url: "<?php echo base_url() . 'staff/getTable/supplies'; ?>",
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



<script src="<?php echo base_url();?>public/assets/back/js/jquery-3.1.1.min.js"></script>
<script src="<?php echo base_url();?>public/assets/back/js/colorPick.js"></script>
<script src="<?php echo base_url();?>public/assets/back/js/moment.min.js"></script>
<script src="<?php echo base_url();?>public/assets/back/js/tempusdominus-bootstrap-4.js"></script>
<script src="<?php echo base_url();?>public/assets/back/js/timepicker.js"></script>
<script src="<?php echo base_url();?>public/assets/back/js/settings.js"></script>
<script type="text/javascript">
$(function() {
    <?php if($this->crud_model->check_item('send_survey') == 0):?>
    $("#send_survey").hide();
    <?php endif;?>
    <?php if($this->crud_model->check_item('send_schedule') == 0):?>
    $("#send_schedule").hide();
    <?php endif;?>
    <?php if($this->crud_model->check_item('send_reminder') == 0):?>
    $("#send_reminder").hide();
    <?php endif;?>
});
</script>


<div class="modal" id="1new_product">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content animated fadeInDown">
            <form action="<?php echo base_url();?>staff/supplies/create" method="POST" enctype="multipart/form-data">
                <div class="modal-header" style="background-color:#fff; box-shadow: 0 4px 2px -2px 000;">
                    <h4 style="font-size:21px; color:#565b6b; font-family:'Poppins';"><span style="vertical-align:-3px">
                            <i class="picons-thin-icon-thin-0001_compose_write_pencil_new"></i> Agregar nuevo
                            suministro.</span></h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="container">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group m-b-15">
                                        <label for="simpleinput">Nombre</label>
                                        <input type="text" name="name" required="" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-8">
                                    <div class="form-group m-b-15">
                                        <label for="simpleinput">Cantidad</label>
                                        <input type="number" name="cantidad" required="" class="form-control" min='0'>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group m-b-15">
                                        <label for="simpleinput">localización</label>
                                        <input type="text" name="location" required="" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group m-b-15">
                                        <label for="simpleinput">Descripción</label>
                                        <textarea name="description" id="" cols="30" rows="5" class='form-control'></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="button-confirm">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<link href="<?php echo base_url();?>public/assets/appointments/css/select2.css" rel="stylesheet" />

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

<script type="text/javascript">
$('.itemName').select2();
</script>

<script>
document.getElementById('apply').onchange = function() {
    var filename = this.value.replace(/C:\\fakepath\\/i, '')
    $("#fileResponse").html('<b>Archivo seleccionado:</b> ' + filename);
};
$('.ae-side-menu-toggler').on('click', function() {
    $('.app-email-w').toggleClass('compact-side-menu');
});
if ($('.app-email-w').length) {
    if (is_display_type('phone') || is_display_type('tablet')) {
        $('.app-email-w').addClass('compact-side-menu');
    }
}
</script>


<script type="text/javascript">
function delete_supplies(product_id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "También se eliminará toda la información asociada al producto.",
        type: 'info',
        showCancelButton: true,
        confirmButtonColor: '#9fd13b',
        cancelButtonColor: '#fd4f57',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.value) {
            location.href = "<?php echo base_url();?>staff/supplies/delete/" + product_id;
        }
    })
}
</script>