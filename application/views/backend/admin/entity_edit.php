<?php $deptos = $this->db->get('departamento');
    $banks = $this->crud_model->getBanksActive();
    $currs = $this->crud_model->getCurrenciesActive();
    $acctyp = $this->crud_model->getAccountTypesActive();
    $comRef = $this->db->get_where('commercial_reference_entity', array('entity_id'=>$type, 'status'=>1));
    $this->db->select('*');
    $this->db->from('entity');
    $this->db->join('entity_data', 'entity.entity_id = entity_data.entity_id');
    $this->db->where('entity.entity_id', $type);
    $id_entity = $this->db->get()->result_array();
    ?>
<div id="main-content">
    <div class="todo-content conts">
        <div class="row">
            <div class="col-xl-8 col-lg-8 col-sm-12" style="float: none; margin: 0 auto;">
                <div class="tasks-section" style="background: #fff; padding: 24px; border-radius: 25px; border: 1px solid #ccc;">
                    <h4 class="todo-content-header">
                        <i class="batch-icon-arrow-right"></i><span> Editar Entidad: </span>
                    </h4>
                </div>
            </div>
        </div><br>
    <?php foreach($id_entity as $row):
        $muns = $this->db->get_where('municipio', array('departamento_id'=>$row['departamento_id']));
        $muns_com = $this->db->get_where('municipio', array('departamento_id'=>$row['departamento_id_empresa']));
        ?>
        <form action="<?php echo base_url();?>admin/entity/edit/<?php echo $type."/".$category ?>" method="POST" enctype="multipart/form-data">
            <div class="row">
                <div class="col-xl-8 col-lg-8 col-sm-12" style="float: none; margin: 0 auto;">
                    <div class="tasks-section" style="background: #fff; padding: 24px; border-radius: 25px; border: 1px solid #ccc;">
                        <div class="row">
                            <div class="col-sm-12">
                                <h6>Datos Generales:</h6>
                            </div>
                            <hr>
                            <div class="col-sm-12">
                                <div class="form-group date-time-picker m-b-15">
                                    <label for="simpleinvput">Fecha de solicitud:<span style="color:red">*</span></label>
                                    <div class="input-group date datepicker" id="DoctorPicker1">
                                        <input type="text" id="applyDate" value="<?php echo $row["application_date"]; ?>"  name="application_date" autocomplete="off" style="border: 1px solid #198cff8f;" value="" required class="form-control">
                                        <span style="display: none;" class="input-group-addon"><i data-feather="calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group m-b-15">
                                    <label for="simpleinput">Nombre completo:<span style="color:red">*</span></label>
                                    <input type="text" style="border: 1px solid #198cff8f;" value="<?php echo $row["first_name"]; ?>" name="full_name" required="" value="" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group m-b-15">
                                    <label for="simpleinput">Nombre comercial:<span style="color:red">*</span></label>
                                    <input type="text" style="border: 1px solid #198cff8f;"  value="<?php echo $row["last_name"]; ?>" name="tradename" required="" value="" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group m-b-15">
                                    <label for="simpleinput">Dirección fiscal:<span style="color:red">*</span></label>
                                    <textarea type="text" style="border: 1px solid #198cff8f;" name="fiscal_address" class="form-control" required><?php echo $row["fiscal_address"]; ?></textarea>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group m-b-15">
                                    <label for="simpleinput">Dirección comercial:<span style="color:red">*</span></label>
                                    <textarea type="text" style="border: 1px solid #198cff8f;"name="commercial_address" class="form-control" required><?php echo $row["commercial_address"]; ?></textarea>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group m-b-15">
                                    <label for="simpleinput">Correo electrónico:</label>
                                    <input type="email" style="border: 1px solid #198cff8f;" value="<?php echo $row["email"]; ?>" name="email" value="" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group m-b-15">
                                    <label for="simpleinput">Sitio web de la empresa:</label>
                                    <input type="text" style="border: 1px solid #198cff8f;" value="<?php echo $row["website"]; ?>" name="website" value="" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group m-b-15">
                                    <label for="simpleinput">NIT:<span style="color:red">*</span></label>
                                    <input type="text" style="border: 1px solid #198cff8f;" value="<?php echo $row["nit"]; ?>" name="nit" required="" value="" class="form-control" />
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group m-b-15">
                                    <label for="simpleinput">Código de área del teléfono:</label>
                                    <input type="number" style="border: 1px solid #198cff8f;" value="<?php echo $row["area_code"]; ?>" name="area_code" value="" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group m-b-15">
                                    <label for="simpleinput">Teléfono 1:<span style="color:red">*</span></label>
                                    <input type="text" style="border: 1px solid #198cff8f;" value="<?php echo $row["phone"]; ?>" name="phone_1" required="" value="" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group m-b-15">
                                    <label for="simpleinput">Teléfono 2:</label>
                                    <input type="text" style="border: 1px solid #198cff8f;" value="<?php echo $row["phone_2"]; ?>" name="phone_2" value="" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group m-b-15">
                                    <label for="simpleinput">Teléfono 3:</label>
                                    <input type="text" style="border: 1px solid #198cff8f;" value="<?php echo $row["phone_3"]; ?>" name="phone_3" value="" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-xl-8 col-lg-8 col-sm-12" style="float: none; margin: 0 auto;">
                    <div class="tasks-section" style="background: #fff; padding: 24px; border-radius: 25px; border: 1px solid #ccc;">
                        <div class="row">
                            <div class="col-sm-12">
                                <h6>Información demográfica</h6>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group m-b-15">
                                    <label for="simpleinput">Dirección:</label>
                                    <textarea type="text" style="border: 1px solid #198cff8f;" name="address" class="form-control"><?php echo $row["address"]; ?></textarea>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group m-b-15">
                                    <label for="simpleinput">País:<span style="color:red">*</span></label>
                                    <select class="form-control" name="country" value="<?php echo $row["country"]; ?>" id="country" required>
                                        <option value="Guatemala" selected>Guatemala</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group m-b-15">
                                    <label for="simpleinput">Departamento:<span style="color:red">*</span></label>
                                    <select class="form-control" name="departamento_id" value="<?php echo $row["departamento_id"]; ?>" id="department" required onchange="getMunicipalities(this, 'municipality')">
                                        <option value="" selected>Seleccione un departamento</option>
                                        <?php foreach($deptos->result_array() as $dp):?>
                                        <option value="<?php echo $dp['departamento_id'];?>" <?php echo ($dp['departamento_id'] == $row["departamento_id"]) ? "selected" : "" ?>><?php echo $dp['name'];?></option>
                                        <?php endforeach;?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group m-b-15">
                                    <label for="simpleinput">Municipio:<span style="color:red">*</span></label>
                                    <select class="form-control" name="municipio_id" id="municipality" required>
                                                    <?php foreach($muns->result_array() as $mn):?>
                                                    <option value="<?php echo $mn['id'];?>" <?php if($mn['id'] == $row['municipio_id']) echo "selected";?>><?php echo $mn['name'];?></option>
                                                    <?php endforeach;?>
                                                </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group m-b-15">
                                    <label for="simpleinput">Ciudad:</label>
                                    <input type="text" style="border: 1px solid #198cff8f;" name="city"  value="<?php echo $row["city"]; ?>" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group m-b-15">
                                    <label for="simpleinput">Código Postal:</label>
                                    <input type="text" style="border: 1px solid #198cff8f;" name="postal_code"  value="<?php echo $row["postal_code"]; ?>" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group m-b-15">
                                    <label for="simpleinput">Número exterior:</label>
                                    <input type="text" style="border: 1px solid #198cff8f;" name="outdoor_number"  value="<?php echo $row["outdoor_number"]; ?>" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group m-b-15">
                                    <label for="simpleinput">Número interior:</label>
                                    <input type="text" style="border: 1px solid #198cff8f;" name="interior_number"  value="<?php echo $row["interior_number"]; ?>" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group m-b-15">
                                    <label for="simpleinput">Puesto:</label>
                                    <input type="text" style="border: 1px solid #198cff8f;" name="charge"  value="<?php echo $row["charge"]; ?>" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group m-b-15">
                                    <label for="simpleinput">Celular de contacto</label>
                                    <input type="text" style="border: 1px solid #198cff8f;" name="phone_contact"  value="<?php echo $row["phone_contact"]; ?>" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-xl-8 col-lg-8 col-sm-12" style="float: none; margin: 0 auto;">
                    <div class="task-section" style="background: #fff; padding: 24px; border-radius: 25px; border: 1px solid #ccc;">
                        <h6 class="todo-content-header">
                            <i class="batch-icon-arrow-right"></i><span>Datos legales</span>
                        </h6>
                        <div class="row">
                            <hr>
                            <div class="col-sm-4">
                                <label for="simpleinput">Nombre completo</label>
                                <input type="text" name="full_name_legal"  value="<?php echo $row["full_name_legal"]; ?>" class="form-control" value="">
                            </div>
                            <div class="col-sm-4">
                                <label for="simpleinput">Número DPI</label>
                                <input type="text" name="dpi_legal"  value="<?php echo $row["dpi_legal"]; ?>" class="form-control" value="">
                            </div>
                            <div class="col-sm-4">
                                <label for="simpleinput">Patente de comercio</label>
                                <input type="text" name="commercial_patent"  value="<?php echo $row["commercial_patent"]; ?>" class="form-control" value="">
                            </div>
                        </div>
                    </div>
                </div>
            </div><br>
            <div class="row">
                <div class="col-xl-8 col-lg-8 col-sm-12" style="float: none; margin: 0 auto;">
                    <div class="task-section" style="background: #fff; padding: 24px; border-radius: 25px; border: 1px solid #ccc;">
                        <h6 class="todo-content-header">
                            <i class="batch-icon-arrow-right"></i><span>Contactos</span>
                        </h6>
                        <div class="row">
                            <hr>
                            <div class="col-sm-12">
                                <h6>Representante de ventas</h6>
                            </div>
                            <div class="col-sm-4">
                                <label for="simpleinput">Nombre:</label>
                                <input type="text" name="full_name_represent" value="<?php echo $row["full_name_represent"]; ?>" class="form-control" value="">
                            </div>
                            <div class="col-sm-4">
                                <label for="simpleinput">Teléfono:</label>
                                <input type="text" name="phone_represent" value="<?php echo $row["phone_represent"]; ?>" class="form-control" value="">
                            </div>
                            <div class="col-sm-4">
                                <label for="simpleinput">Correo:</label>
                                <input type="text" name="email_represent" value="<?php echo $row["email_represent"]; ?>" class="form-control" value="">
                            </div>
                            <div class="col-sm-12 mt-3">
                                <h6>Gerente de ventas</h6>
                            </div>
                            <div class="col-sm-4">
                                <label for="simpleinput">Nombre:</label>
                                <input type="text" name="full_name_manager" value="<?php echo $row["full_name_manager"]; ?>" class="form-control" value="">
                            </div>
                            <div class="col-sm-4">
                                <label for="simpleinput">Teléfono:</label>
                                <input type="text" name="phone_manager" value="<?php echo $row["phone_manager"]; ?>" class="form-control" value="">
                            </div>
                            <div class="col-sm-4">
                                <label for="simpleinput">Correo:</label>
                                <input type="text" name="email_manager" value="<?php echo $row["email_manager"]; ?>" class="form-control" value="">
                            </div>
                            <div class="col-sm-12 mt-3">
                                <h6>Cuentas por cobrar</h6>
                            </div>
                            <div class="col-sm-4">
                                <label for="simpleinput">Nombre:</label>
                                <input type="text" name="full_name_accounts" value="<?php echo $row["full_name_accounts"]; ?>" class="form-control" value="">
                            </div>
                            <div class="col-sm-4">
                                <label for="simpleinput">Teléfono:</label>
                                <input type="text" name="phone_accounts" value="<?php echo $row["phone_accounts"]; ?>" class="form-control" value="">
                            </div>
                            <div class="col-sm-4">
                                <label for="simpleinput">Correo:</label>
                                <input type="text" name="email_accounts" value="<?php echo $row["email_accounts"]; ?>" class="form-control" value="">
                            </div>
                            <div class="col-sm-12 mt-3">
                                <h6>Facturación</h6>
                            </div>
                            <div class="col-sm-4">
                                <label for="simpleinput">Nombre:</label>
                                <input type="text" name="full_name_billing" value="<?php echo $row["full_name_billing"]; ?>" class="form-control" value="">
                            </div>
                            <div class="col-sm-4">
                                <label for="simpleinput">Teléfono:</label>
                                <input type="text" name="phone_billing" value="<?php echo $row["phone_billing"]; ?>" class="form-control" value="">
                            </div>
                            <div class="col-sm-4">
                                <label for="simpleinput">Correo:</label>
                                <input type="text" name="email_billing" value="<?php echo $row["email_billing"]; ?>" class="form-control" value="">
                            </div>
                            <div class="col-sm-12 mt-3">
                                <h6>Finanzas</h6>
                            </div>
                            <div class="col-sm-4">
                                <label for="simpleinput">Nombre:</label>
                                <input type="text" name="full_name_finance" value="<?php echo $row["full_name_finance"]; ?>" class="form-control" value="">
                            </div>
                            <div class="col-sm-4">
                                <label for="simpleinput">Teléfono:</label>
                                <input type="text" name="phone_finance" value="<?php echo $row["phone_finance"]; ?>" class="form-control" value="">
                            </div>
                            <div class="col-sm-4">
                                <label for="simpleinput">Correo:</label>
                                <input type="text" name="email_finance" value="<?php echo $row["email_finance"]; ?>" class="form-control" value="">
                            </div>
                            <div class="col-sm-12 mt-3">
                                <h6>Contabilidad</h6>
                            </div>
                            <div class="col-sm-4">
                                <label for="simpleinput">Nombre:</label>
                                <input type="text" name="full_name_accounting" value="<?php echo $row["full_name_accounting"]; ?>" class="form-control" value="">
                            </div>
                            <div class="col-sm-4">
                                <label for="simpleinput">Teléfono:</label>
                                <input type="text" name="phone_accounting" value="<?php echo $row["phone_accounting"]; ?>" class="form-control" value="">
                            </div>
                            <div class="col-sm-4">
                                <label for="simpleinput">Correo:</label>
                                <input type="text" name="email_accounting" value="<?php echo $row["email_accounting"]; ?>" class="form-control" value="">
                            </div>
                        </div>
                    </div>
                </div>
            </div><br>
            <div class="row">
                <div class="col-xl-8 col-lg-8 col-sm-12" style="float: none; margin: 0 auto;">
                    <div class="task-section" style="background: #fff; padding: 24px; border-radius: 25px; border: 1px solid #ccc;">
                        <h6 class="todo-content-header">
                            <i class="batch-icon-arrow-right"></i><span>Referencias comerciales</span>
                        </h6>
                        <div class="row">
                        <?php foreach($comRef->result_array() as $cr):?>
                                        <input type="hidden" name="commercial_reference_id[]" value="<?php echo $cr['commercial_reference_entity_id'];?>" />
                                        <div class="col-sm-6">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Nombre:<span style="color:red">*</span></label>
                                                <input type="text" name="first_name_reference[]" required="" class="form-control" value="<?php echo $cr['first_name'];?>">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Apellido:<span style="color:red">*</span></label>
                                                <input type="text" name="last_name_reference[]" required="" class="form-control" value="<?php echo $cr['last_name'];?>">
                                            </div>
                                        </div>
                                        <div class="col-sm-6 mt-2">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Telefóno:<span style="color:red">*</span></label>
                                                <input type="text" name="phone_reference[]" required="" class="form-control" value="<?php echo $cr['phone'];?>">
                                            </div>
                                        </div>
                                        <div class="col-sm-6 mt-2">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Empresa o persona:<span style="color:red">*</span></label>
                                                <input type="text" name="company_person_reference[]" required="" class="form-control" value="<?php echo $cr['company_person'];?>">
                                            </div>
                                        </div>
                                        <div class="col-sm-12"><hr></div>
                                        <?php endforeach;?>
                        </div>
                    </div>
                </div>
            </div><br>
            <div class="row">
                <div class="col-xl-8 col-lg-8 col-sm-12" style="float: none; margin: 0 auto;">
                    <div class="task-section" style="background: #fff; padding: 24px; border-radius: 25px; border: 1px solid #ccc;">
                        <h6 class="todo-content-header">
                            <i class="batch-icon-arrow-right"></i><span>Línea de productos o servicios que proporcionan</span>
                        </h6>
                        <div class="row">
                            <hr>
                            <div class="col-sm-12">
                                <label for="simpleinput">Lista<span style="color:red">*</span></label>
                                <select class="form-control" name="provider_service_id" required>
                                    <option value="" selected>Seleccione una opcion</option>
                                    <?php $services = $this->crud_model->getProviderServices();
                                        foreach($services->result_array() as $ps):?>
                                    <option value="<?php echo $ps['provider_service_id'];?>" <?php if($ps['provider_service_id'] == $row['provider_service_id']) echo "selected";?>><?php echo $ps['name'];?></option>
                                    <?php endforeach;?>
                                </select>
                                
                            <div class="col-sm-12 mt-4">
                                <div class="form-group m-b-15">
                                    <button class="btn btn-primary" type="submit">Guardar Entidad</button>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><br>

        </form>
    <?php endforeach; ?>
    </div>
</div>
<script src="<?php echo base_url();?>public/assets/back/js/jquery-3.1.1.min.js"></script>
<script src="<?php echo base_url();?>public/assets/theme/input/jquery.fileuploader.min.js" type="text/javascript"></script>

<script>

$(function() {
    'use strict';
    if ($('#DoctorPicker1').length) {
        var date = new Date();
        var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
        $('#DoctorPicker1').datepicker({
            format: "dd/mm/yyyy",
            todayHighlight: true,
            autoclose: true
        });
    }
    if ($('#DoctorPicker2').length) {
        var date = new Date();
        var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
        $('#DoctorPicker2').datepicker({
            format: "dd/mm/yyyy",
            todayHighlight: true,
            autoclose: true
        });
    }
});

$('.ae-side-menu-toggler').on('click', function() {
    $('.app-side').toggleClass('compact-side-menu');
});

if ($('.app-side').length) {
    if (is_display_type('phone') || is_display_type('tablet')) {
        $('.app-side').addClass('compact-side-menu');
    }
}
</script>
<script>
var bool = false;

function showPass() {
    if (bool) {
        bool = false;
        $('#fpassword').hide(500);
        $('#spassword').hide(500);
        $('#btnpassword').hide(500);
    } else {
        $('#fpassword').show(500);
        $('#spassword').show(500);
        $('#btnpassword').show(500);
        bool = true;
    }
}

function validatePass() {
    var fpass = $('#fpassword').val();
    var spass = $('#spassword').val();

    if (fpass == spass) {
        $('#btnpassword').prop('disabled', false);

        $('#errorm').removeClass('error');
        $('#errorm').removeClass('error_show');
        $('#errorm').removeClass('success');
        $('#errorm').text('');
    } else {
        $('#btnpassword').prop('disabled', true);
        $('#errorm').removeClass('error');
        $('#errorm').removeClass('error_show');
        $('#errorm').removeClass('success');
        $('#errorm').text('Las contraseñas no son iguales.').addClass('error').animate({}, 300);
    }
}

function getMunicipalities(deptos, muni) {
    var depto_id = $(deptos).val();
    if (depto_id != '') {
        $.ajax({
            type: "POST",
            url: "<?php echo base_url();?>admin/get_municipio/" + depto_id,
            success: function(response) {
                console.log(response);
                $("#" + muni).html(response);
            },
            error: function(e) {
                console.log("Error: ", e);
            }
        });
    }
}

$("#formS").submit(function(e) {
    e.preventDefault();
    var formData = new FormData(this);
    var $form = $(this);
    var url = $form.attr('action');

    $.ajax({
        url: url,
        type: 'POST',
        data: formData,
        xhr: function() {
            var xhr = $.ajaxSettings.xhr();

            if (xhr.upload) {
                xhr.upload.addEventListener("progress", this.progress, false);
            }

            return xhr;
        },
        beforeSend: function() {
            $('button[type="submit"]').attr('disabled', 'disabled');
            $('.fileuploader-input-caption').append('<div class="loading"></div>');
        },
        progress: function(e) {

            if (e.lengthComputable) {
                var t = Math.round(e.loaded * 99 / e.total).toString();
                var progressBar = $(".fileuploader-item").find('.progress-bar2');
                if (progressBar.length > 0) {
                    progressBar.show();
                    progressBar.find('span').html(t + "%");
                    progressBar.find('.fileuploader-progressbar .bar').width(t + "%");
                }
            }
        },
        success: function(data) {
            // socket.emit("new-notifications", {});

            var progressBar = $(".fileuploader-item").find('.progress-bar2');

            if (progressBar.length > 0) {
                progressBar.show();
                progressBar.find('span').html("100%");
                progressBar.find('.fileuploader-progressbar .bar').width("100%");
            }
            $(".loading").remove();
            window.location.replace("<?php echo base_url();?>admin/providers/");
        },
        error: function(xhr, status, error) {
            var err = eval("(" + xhr.responseText + ")");
            alert(err.Message);
        },
        cache: false,
        contentType: false,
        processData: false
    });
});


function get_depto(coleccion) {
    $.ajax({
        url: '<?php echo base_url(); ?>admin/get_municipio/' + coleccion,
        success: function(response) {
            jQuery('#municipality_company').html(response);
        }
    });
}
</script>