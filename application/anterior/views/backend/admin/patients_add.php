<link rel="stylesheet" href="<?php echo base_url();?>public/assets/back/intl-tel-input/css/intlTelInput.min.css">
<style>
.floated-chat-btn {
    z-index: 9999;
    position: fixed;
    bottom: 110px;
    right: 10px;
    background: #0089FF;
    border-radius: 10px;
    color: #fff !important;
    font-weight: 500;
    border: 2px solid #088dcd;
    padding: 0.375rem 0.75rem;
}

.select2-container {
    width: 25vh !important;
}
</style>
<?php $owner = $this->db->get_where('admin',array('admin_id'=>$this->session->userdata('login_user_id')) )->row()->owner;?>
<link href="<?php echo base_url();?>public/assets/appointments/css/select2.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<form action="<?php echo base_url();?>admin/patients/create" method="POST" enctype="multipart/form-data" id="doc_form">
    <input type="hidden" name="category" value="<?php echo $category; ?>">
    <div class="todo-app-w">
        <div class="todo-content">
            <div class="row">
                <div class="col-xl-11 col-lg-11 col-sm-12" style="float: none; margin: 0 auto;">
                    <div class="tasks-section" style="background: #fff; padding: 24px; border-radius: 25px; border: 1px solid #ccc;">
                        <h4 class="todo-content-header">
                            <i class="batch-icon-arrow-right"></i><span>Información</span>
                        </h4>
                        <div class="col-sm-12">
                            <div class="alert alert-info">
                                <span class="alert-title">
                                    <i class="batch-icon-spam"></i>
                                    Complete los datos obligatorios*.
                                </span>
                            </div>
                        </div>

                        <div class="row" id="patient_0">
                            <div class="col-sm-12 ">
                                <div class="avatar-upload">
                                    <div class="avatar-edit">
                                        <input type='file' name="photo" id="imageUpload" accept=".png, .jpg, .jpeg" />
                                        <label for="imageUpload"></label>
                                    </div>
                                    <div class="avatar-preview" style="border: 2px solid #198cff8f;">
                                        <div id="imagePreview" style="background-image: url(<?php echo base_url();?>public/uploads/user.png);">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group m-b-15">
                                    <label for="simpleinput">Primer Nombre<span style="color:red">*</span></label>
                                    <input style="border: 1px solid #198cff8f;" type="text" name="first_name" id="first_name" required="" class="form-control required_0">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group m-b-15">
                                    <label for="simpleinput">Segundo Nombre</label>
                                    <input style="border: 1px solid #198cff8f;" type="text" name="second_name" class="form-control">
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group m-b-15">
                                    <label for="simpleinput">Tercer Nombre</label>
                                    <input style="border: 1px solid #198cff8f;" type="text" name="third_name" class="form-control">
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group m-b-15">
                                    <label for="simpleinput">Primer Apellido<span style="color:red">*</span></label>
                                    <input style="border: 1px solid #198cff8f;" type="text" name="last_name" id="last_name" required="" class="form-control required_0">
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group m-b-15">
                                    <label for="simpleinput">Segundo Apellido</label>
                                    <input style="border: 1px solid #198cff8f;" type="text" name="second_last_name" class="form-control">
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group m-b-15">
                                    <label for="simpleinput">Apellido de casada</label>
                                    <input style="border: 1px solid #198cff8f;" type="text" name="married_last_name" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group m-b-15">
                                    <label for="simpleinput">Celular<span style="color:red">*</span></label>
                                    <input style="border: 1px solid #198cff8f; padding-left: 100px!important;" type="tel" name="phone" id="phone" required=""  class="form-control required_0">
                                    <input type="hidden" name="area_code" value="502">
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <div class="form-group m-b-15">
                                    <label for="simpleinput">Teléfono</label>
                                    <input style="border: 1px solid #198cff8f; padding-left: 100px!important;" type="tel"  id="tel" class="form-control" >
                                    <input type="hidden" name="area_code_tel" value="502">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group m-b-15">
                                    <label for="simpleinput">Email</label>
                                    <input style="border: 1px solid #198cff8f;" type="email" name="email" id="email"  class="form-control required_0" value="">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group date-time-picker m-b-15">
                                    <label for="simpleinvput">Fecha de Nacimiento<span style="color:red">*</span></label>
                                    <div class="input-group date datepicker" id="DoctorPicker1">
                                        <input onchange="patientInCharge(this.value)" type="text" id="applyDate" required="true" name="date_of_birth" required="" autocomplete="off" style="border: 1px solid #198cff8f;" class="form-control required_0">
                                        <span style="display: none;" class="input-group-addon"><i data-feather="calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" value="0" name="older_patient" />
                            <div class="col-sm-3 representante" style="display:none">
                                <div class="form-group">
                                    <label for="card">Representante</label>
                                    <div class="input-group">
                                        <select name="responsable_id" class="form-control" onchange="InCharge(this.value);">
                                            <option value="">Seleccionar</option>
                                            <option value="0">Agregar Nuevo</option>
                                            <?php 
                                          $patient = $this->db->get_where('patient',array('status'=>1))->result_array();
                                          foreach($patient as $rs):
                                        ?>
                                            <option value="<?php echo $rs['patient_id'];?>"><?php echo $rs['first_name'].' '.$rs['second_name'].' '.$rs['last_name'].' '.$rs['second_last_name'];?></option>
                                            <?php endforeach;?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3 dpi " style="display:none">
                                <div class="form-group m-b-15">
                                    <label for="simpleinput">Identificación</label>
                                    <span class="" id="errordpi"></span>
                                    <input style="border: 1px solid #198cff8f;" type="number" name="dpi" id="dpi"  class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group m-b-15">
                                    <label for="simpleinput">Nacionalidad<span style="color:red">*</span></label>
                                    <input style="border: 1px solid #198cff8f;" type="text" name="nationality" id="nationality" required="" class="form-control ">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group m-b-15">
                                    <label for="simpleinput">Ocupación</label>
                                    <input style="border: 1px solid #198cff8f;" type="text" name="profession" class="form-control">
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <div class="form-group m-b-15">
                                    <label for="simpleinput">Lugar de Trabajo</label>
                                    <input style="border: 1px solid #198cff8f;" type="tel" name="workplace" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group m-b-15">
                                    <label for="simpleinput">Seguro <span style="color:red">*</span></label><br>
                                    <select class="itemName form-control select2 " style="border: 1px solid #198cff8f;" id="insurances_1"  style="width:100%" name="insurances[]" multiple>
                                        <option value="">Seleccionar</option>
                                        <?php 
								        	$specialties = $this->db->get('insurance')->result_array();
								        	foreach($specialties as $cat):
								    	?>
                                        <option value="<?php echo $cat['insurance_id'];?>"><?php echo $cat['name'];?></option>
                                        <?php endforeach;?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Estado civil</label>
                                    <div class="input-group">
                                        <div class="form-check" style="padding-left: 0px;padding-right: 8px;">
                                            <input checked="" class="radiobutton" type="radio" name="marital_status" id="radio1" checked value="0"><label class="radiobutton-label" for="radio1">Soltero</label>
                                        </div>
                                        <div class="form-check" style="padding-left: 0px;">
                                            <input class="radiobutton" type="radio" name="marital_status" id="radio2" value="1"><label class="radiobutton-label" for="radio2">Casado</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Sexo:</label>
                                    <div class="input-group">
                                        <div class="form-check" style="padding-left: 0px;padding-right: 8px;">
                                            <input checked="" class="radiobutton" type="radio" name="gender" id="radio3" value="M"><label class="radiobutton-label" for="radio3">Masculino</label>
                                        </div>
                                        <div class="form-check" style="padding-left: 0px;">
                                            <input class="radiobutton" type="radio" name="gender" id="radio4" value="F"><label class="radiobutton-label" for="radio4">Femenino</label>
                                        </div>
                                        <div class="form-check" style="">
                                            <input class="radiobutton" type="radio" name="gender" id="radio5" value="O"><label class="radiobutton-label" for="radio5">Otros</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="todo-app-w" id="address">
        <div class="todo-content">
            <div class="row">
                <div class="col-xl-11 col-lg-11 col-sm-12" style="float: none; margin: 0 auto;">
                    <div class="tasks-section" style="background: #fff; padding: 24px; border-radius: 25px; border: 1px solid #ccc;">
                        <h4 class="todo-content-header">
                            <i class="batch-icon-arrow-right"></i><span>Información demográfica</span>
                        </h4>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group m-b-15">
                                    <label for="simpleinput">Dirección<span style="color:red">*</span></label>
                                    <textarea type="text" style="border: 1px solid #198cff8f;" rows="3" name="address" required="" class="form-control"></textarea>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="card">Departamento<span style="color:red">*</span></label>
                                    <div class="input-group">
                                        <select name="dpto" class="form-control" onchange="get_depto(this.value, '1');">
                                            <option value="">Seleccionar</option>
                                            <?php 
                                      $deptos = $this->db->get('departamento')->result_array();
                                      foreach($deptos as $rs):
                                    ?>
                                            <option value="<?php echo $rs['departamento_id'];?>"><?php echo $rs['name'];?></option>
                                            <?php endforeach;?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group m-b-15">
                                    <label>Municipio</label> <span style="color:red;">*</span>
                                    <select class="form-control" name="muni" id="selector_coleccion_1" required>
                                        <option>Seleccionar</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group m-b-15">
                                    <label for="simpleinput">Ciudad</label>
                                    <input style="border: 1px solid #198cff8f;" type="text" name="city" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group m-b-15">
                                    <label for="simpleinput">Código Postal</label>
                                    <input style="border: 1px solid #198cff8f;" type="text" name="postal_code" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="todo-app-w" id="invoice" style="display:none">
        <div class="todo-content">
            <div class="row">
                <div class="col-xl-11 col-lg-11 col-sm-12" style="float: none; margin: 0 auto;">
                    <div class="tasks-section" style="background: #fff; padding: 24px; border-radius: 25px; border: 1px solid #ccc;">
                        <h4 class="todo-content-header">
                            <i class="batch-icon-arrow-right"></i><span>Información de Facturación</span>
                        </h4>
                        <div class="row">
                            <div class="col-sm-12">
                                <h6>NIT 1</h6>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group m-b-15">
                                    <label for="simpleinput">Nombre</label>

                                    <input style="border: 1px solid #198cff8f;" type="text" name="name_nit_1" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group m-b-15">
                                    <label for="simpleinput">NIT</label>

                                    <input style="border: 1px solid #198cff8f;" type="number" name="nit_1" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group m-b-15">
                                    <label for="simpleinput">Dirección</label>

                                    <input style="border: 1px solid #198cff8f;" type="text" name="address_nit_1" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <h6>NIT 2</h6>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group m-b-15">
                                    <label for="simpleinput">Nombre</label>

                                    <input style="border: 1px solid #198cff8f;" type="text" name="name_nit_2" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group m-b-15">
                                    <label for="simpleinput">NIT</label>

                                    <input style="border: 1px solid #198cff8f;" type="number" name="nit_2" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group m-b-15">
                                    <label for="simpleinput">Dirección</label>

                                    <input style="border: 1px solid #198cff8f;" type="text" name="address_nit_2" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <h6>NIT 3</h6>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group m-b-15">
                                    <label for="simpleinput">Nombre</label>

                                    <input style="border: 1px solid #198cff8f;" type="text" name="name_nit_3" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group m-b-15">
                                    <label for="simpleinput">NIT</label>

                                    <input style="border: 1px solid #198cff8f;" type="number" name="nit_3" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group m-b-15">
                                    <label for="simpleinput">Dirección</label>

                                    <input style="border: 1px solid #198cff8f;" type="text" name="address_nit_3" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="in_charge" style="display:none">
        <div class="todo-app-w">
            <div class="todo-content">
                <div class="row">
                    <div class="col-xl-11 col-lg-11 col-sm-12" style="float: none; margin: 0 auto;">
                        <div class="tasks-section" style="background: #fff; padding: 24px; border-radius: 25px; border: 1px solid #ccc;">
                            <h4 class="todo-content-header">
                                <i class="batch-icon-arrow-right"></i><span>Información del Representante</span>
                            </h4>
                            <div class="col-sm-12">
                                <div class="alert alert-info">
                                    <span class="alert-title">
                                        <i class="batch-icon-spam"></i>
                                        Complete los datos obligatorios*.
                                    </span>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12 ">
                                    <div class="avatar-upload">
                                        <div class="avatar-edit">
                                            <input type='file' name="photo_rep" id="imageUpload" accept=".png, .jpg, .jpeg" />
                                            <label for="imageUpload"></label>
                                        </div>
                                        <div class="avatar-preview" style="border: 2px solid #198cff8f;">
                                            <div id="imagePreview" style="background-image: url(<?php echo base_url();?>public/uploads/user.png);">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group m-b-15">
                                        <label for="simpleinput">Primer Nombre<span style="color:red">*</span></label>
                                        <input style="border: 1px solid #198cff8f;" type="text" name="first_name_rep" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group m-b-15">
                                        <label for="simpleinput">Segundo Nombre</label>
                                        <input style="border: 1px solid #198cff8f;" type="text" name="second_name_rep" class="form-control">
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group m-b-15">
                                        <label for="simpleinput">Tercer Nombre</label>
                                        <input style="border: 1px solid #198cff8f;" type="text" name="third_name_rep" class="form-control">
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group m-b-15">
                                        <label for="simpleinput">Primer Apellido<span style="color:red">*</span></label>
                                        <input style="border: 1px solid #198cff8f;" type="text" name="last_name_rep" class="form-control">
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group m-b-15">
                                        <label for="simpleinput">Segundo Apellido</label>
                                        <input style="border: 1px solid #198cff8f;" type="text" name="second_last_name_rep" class="form-control">
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group m-b-15">
                                        <label for="simpleinput">Apellido de casada</label>
                                        <input style="border: 1px solid #198cff8f;" type="text" name="married_last_name_rep" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group m-b-15">
                                        <label for="simpleinput">Celular<span style="color:red">*</span></label>
                                        <input style="border: 1px solid #198cff8f; padding-left: 100px!important; " type="tel" name="phone_rep" id="phone_rep"  class="form-control">
                                        <input type="hidden" name="phone1-number-full" value="">
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group m-b-15">
                                        <label for="simpleinput">Teléfono</label>
                                        <input style="border: 1px solid #198cff8f; padding-left: 100px!important;" type="tel" id="tel2" class="form-control">
                                        <input type="hidden" name="phone_contact_rep" value="">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group date-time-picker m-b-15">
                                        <label for="simpleinvput">Fecha de Nacimiento<span style="color:red">*</span></label>
                                        <div class="input-group date datepicker" id="DoctorPicker1">
                                            <input type="text" id="applyDate" name="date_of_birth_rep" id="date_of_birth_rep" autocomplete="off" style="border: 1px solid #198cff8f;" class="form-control">
                                            <span style="display: none;" class="input-group-addon"><i data-feather="calendar"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3  ">
                                    <div class="form-group m-b-15">
                                        <label for="simpleinput">Identificación<span style="color:red">*</span></label>
                                        <span class="" id="errordpi_rep"></span>
                                        <input style="border: 1px solid #198cff8f;" type="number" name="dpi_rep" id="dpi_rep" onkeyup="validateDPI(this.value, '_rep');" class="form-control ">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group m-b-15">
                                        <label for="simpleinput">Nacionalidad<span style="color:red">*</span></label>
                                        <input style="border: 1px solid #198cff8f;" type="text" name="nationality_rep" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group m-b-15">
                                        <label for="simpleinput">Ocupación<span style="color:red">*</span></label>
                                        <input style="border: 1px solid #198cff8f;" type="text" name="profession_rep" class="form-control">
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group m-b-15">
                                        <label for="simpleinput">Lugar de Trabajo</label>
                                        <input style="border: 1px solid #198cff8f;" type="tel" name="workplace_rep" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group m-b-15">
                                        <label for="simpleinput">Seguro <span style="color:red">*</span></label><br>
                                        <select class="  select22" style="border: 1px solid #198cff8f;" style="width:100px" name="insurances_rep[]" multiple>
                                            <option value="">Seleccionar</option>
                                            <?php 
								        	$specialties = $this->db->get('insurance')->result_array();
								        	foreach($specialties as $cat):
								    	?>
                                            <option value="<?php echo $cat['insurance_id'];?>"><?php echo $cat['name'];?></option>
                                            <?php endforeach;?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Estado civil</label>
                                        <div class="input-group">
                                            <div class="form-check" style="padding-left: 0px;padding-right: 8px;">
                                                <input checked="" class="radiobutton" type="radio" name="marital_status_rep" id="radio6" checked value="0"><label class="radiobutton-label" for="radio6">Soltero</label>
                                            </div>
                                            <div class="form-check" style="padding-left: 0px;">
                                                <input class="radiobutton" type="radio" name="marital_status_rep" id="radio7" value="1"><label class="radiobutton-label" for="radio7">Casado</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Sexo:</label>
                                        <div class="input-group">
                                            <div class="form-check" style="padding-left: 0px;padding-right: 8px;">
                                                <input checked="" class="radiobutton" type="radio" name="gender_rep" id="radio8" value="M"><label class="radiobutton-label" for="radio8">Masculino</label>
                                            </div>
                                            <div class="form-check" style="padding-left: 0px;">
                                                <input class="radiobutton" type="radio" name="gender_rep" id="radio9" value="F"><label class="radiobutton-label" for="radio9">Femenino</label>
                                            </div>
                                            <div class="form-check" style="">
                                                <input class="radiobutton" type="radio" name="gender_rep" id="radio10" value="O"><label class="radiobutton-label" for="radio10">Otros</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="todo-app-w">
            <div class="todo-content">
                <div class="row">
                    <div class="col-xl-11 col-lg-11 col-sm-12" style="float: none; margin: 0 auto;">
                        <div class="tasks-section" style="background: #fff; padding: 24px; border-radius: 25px; border: 1px solid #ccc;">
                            <h4 class="todo-content-header">
                                <i class="batch-icon-arrow-right"></i><span>Información demográfica</span>
                            </h4>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group m-b-15">
                                        <label for="simpleinput">Dirección</label>
                                        <textarea type="text" style="border: 1px solid #198cff8f;" rows="3" name="address_rep" class="form-control"></textarea>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="card">Departamento<span style="color:red">*</span></label>
                                        <div class="input-group">
                                            <select name="dpto_rep" class="form-control" onchange="get_depto(this.value, '2');">
                                                <option value="">Seleccionar</option>
                                                <?php 
                                      $deptos = $this->db->get('departamento')->result_array();
                                      foreach($deptos as $rs):
                                    ?>
                                                <option value="<?php echo $rs['departamento_id'];?>"><?php echo $rs['name'];?></option>
                                                <?php endforeach;?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group m-b-15">
                                        <label>Municipio</label> <span style="color:red;">*</span>
                                        <select class="form-control " name="muni_rep" id="selector_coleccion_2" >
                                            <option>Seleccionar</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group m-b-15">
                                        <label for="simpleinput">Ciudad</label>
                                        <input style="border: 1px solid #198cff8f;" type="text" name="city_rep" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group m-b-15">
                                        <label for="simpleinput">Código Postal</label>
                                        <input style="border: 1px solid #198cff8f;" type="text" name="postal_code_rep" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group m-b-15">
                                        <label for="simpleinput">Número de nacional</label>

                                        <input style="border: 1px solid #198cff8f;" type="number" name="n_nacional_rep" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group m-b-15">
                                        <label for="simpleinput">Número de extranjero</label>

                                        <input style="border: 1px solid #198cff8f;" type="number" name="n_extranjero_rep" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="todo-app-w">
            <div class="todo-content">
                <div class="row">
                    <div class="col-xl-11 col-lg-11 col-sm-12" style="float: none; margin: 0 auto;">
                        <div class="tasks-section" style="background: #fff; padding: 24px; border-radius: 25px; border: 1px solid #ccc;">
                            <h4 class="todo-content-header">
                                <i class="batch-icon-arrow-right"></i><span>Información de Facturación</span>
                            </h4>
                            <div class="row">
                                <div class="col-sm-12">
                                    <h6>NIT 1</h6>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group m-b-15">
                                        <label for="simpleinput">Nombre</label>

                                        <input style="border: 1px solid #198cff8f;" type="text" name="name_nit_1_rep" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group m-b-15">
                                        <label for="simpleinput">NIT</label>

                                        <input style="border: 1px solid #198cff8f;" type="number" name="nit_1_rep" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group m-b-15">
                                        <label for="simpleinput">Dirección</label>

                                        <input style="border: 1px solid #198cff8f;" type="text" name="address_nit_1_rep" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <h6>NIT 2</h6>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group m-b-15">
                                        <label for="simpleinput">Nombre</label>

                                        <input style="border: 1px solid #198cff8f;" type="text" name="name_nit_2_rep" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group m-b-15">
                                        <label for="simpleinput">NIT</label>

                                        <input style="border: 1px solid #198cff8f;" type="number" name="nit_2_rep" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group m-b-15">
                                        <label for="simpleinput">Dirección</label>

                                        <input style="border: 1px solid #198cff8f;" type="text" name="address_nit_2_rep" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <h6>NIT 3</h6>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group m-b-15">
                                        <label for="simpleinput">Nombre</label>

                                        <input style="border: 1px solid #198cff8f;" type="text" name="name_nit_3_rep" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group m-b-15">
                                        <label for="simpleinput">NIT</label>

                                        <input style="border: 1px solid #198cff8f;" type="number" name="nit_3_rep" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group m-b-15">
                                        <label for="simpleinput">Dirección</label>

                                        <input style="border: 1px solid #198cff8f;" type="text" name="address_nit_3_rep" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-12" style="padding-right:80px">
        <div class="form-group m-b-15" style="text-align: right;">
            <button class="btn btn-primary">Guardar datos</button>
        </div>
    </div>
    <br>
    <br>
    <br>
    <br>
  
    					

</form>
<script src="<?php echo base_url(); ?>public/assets/back/intl-tel-input/js/intlTelInput.min.js"></script>

<script type="text/javascript">
$(document).ready(function() {

    var phone_input = document.querySelector("#phone");
        var iti = window.intlTelInput(phone_input, {
            dropdownContainer: document.body,
            initialCountry: 'gt',
            separateDialCode: true,
            utilsScript: "<?php echo base_url();?>public/assets/back/intl-tel-input/js/utils.js",
        });

      
        phone_input.addEventListener('countrychange', function(e) {
          
            $("input[name='area_code']").val(iti.getSelectedCountryData().dialCode );
        });

        //////////////////////////////

        var phone_input2 = document.querySelector("#tel");

        var iti2 = window.intlTelInput(phone_input2, {
            dropdownContainer: document.body,
            initialCountry: 'gt',
            separateDialCode: true,
            utilsScript: "<?php echo base_url();?>public/assets/back/intl-tel-input/js/utils.js",
        });

      
        $(phone_input2).find("countrychange").on('change', function(e) {
            
            $("input[name='area_code_tel']").val(iti2.getSelectedCountryData().dialCode);
          
        });


        ///////////////////////////////


        var phone_input1 = document.querySelector("#phone_rep");
        var iti2 = window.intlTelInput(phone_input1, {
            dropdownContainer: document.body,
            initialCountry: 'gt',
            separateDialCode: false,
            utilsScript: "<?php echo base_url();?>public/assets/back/intl-tel-input/js/utils.js",
        });

      
        phone_input1.addEventListener('countrychange', function(e) {
          
            $("input[name='phone1-number-full']").val(iti2.getSelectedCountryData().dialCode +  $("#phone_rep").val());
        });


        $("#phone_rep").on('keyup', function() {
        	$("input[name='phone1-number-full']").val( iti2.getSelectedCountryData().dialCode +  $("#phone_rep").val());
        	
        });


    



        var phone_input3 = document.querySelector("#tel2");
        var iti2 = window.intlTelInput(phone_input3, {
            dropdownContainer: document.body,
            initialCountry: 'gt',
            separateDialCode: true,
            utilsScript: "<?php echo base_url();?>public/assets/back/intl-tel-input/js/utils.js",
        });

      
        phone_input3.addEventListener('countrychange', function(e) {
          
            $("input[phone_contact_rep']").val(iti2.getSelectedCountryData().dialCode +  $("#tel2").val());
        });


        $("#tel2").on('keyup', function() {
        	$("input[phone_contact_rep']").val( iti2.getSelectedCountryData().dialCode +  $("#tel2").val());
        	
        });



    var type = $('input[name="patient_type"]:checked').val();
    if (type == 0) {
        $(".required_0").prop("required", true);
        $(".required_1").removeAttr("required");
    }

    if (type == 1) {
        $("#date_of_birth_rep").removeAttr("required");
        $(".required_1").prop("required", true);
        $(".required_0").removeAttr("required");
    }
});

$('.select22').select2();
$('.itemName').select2();

function get_depto(coleccion, inx) {
    $.ajax({
        url: '<?php echo base_url(); ?>admin/get_municipio/' + coleccion,
        success: function(response) {
            jQuery('#selector_coleccion_' + inx).html(response);
        }
    });
}




function patientType(type) {
    if (type == 0) {
        $('#patient_0').show(500);
        $('#patient_1').hide(500);
        $('#representante_legal').hide(500);
        $(".required_0").prop("required", true);
        $(".required_1").removeAttr("required");
    }

    if (type == 1) {
        $('#patient_0').hide(500);
        $('#patient_1').show(500);
        $('#representante_legal').show(500);
        $('.in_charge').hide(500);
        $("#date_of_birth_rep").removeAttr("required");
        $(".required_1").prop("required", true);
        $(".required_0").removeAttr("required");
    }
}

function patientSingle(status) {

    if (!status) {
        $('#conyuge').show();
    } else {
        $('#conyuge').hide();
    }
}


function patientInCharge(age) {
    let d = age.split("/");
    let dob = new Date(d[2] + '/' + d[1] + '/' + d[0]);
    var today = new Date();
    console.log(today);
    console.log(dob);
    var age = Math.floor((today - dob) / (365.25 * 24 * 60 * 60 * 1000));
    console.log(age + ' years old');

    if (age < 18) {
        $('.representante').show(500);
        $('.dpi').hide(500);
        $('#invoice').hide(500);
        $('input[name=older_patient]').val('0');
    } else {
        $('.representante').hide(500);
        $('#invoice').show(500);
        $('.dpi').show(500);
        $('input[name=older_patient]').val(1);
        $('.in_charge').hide(500);
        $("#date_of_birth_rep").removeAttr("required");
    }

}

function InCharge(a) {
    if (a == 0) {
        $('.in_charge').show(500);
        $("#date_of_birth_rep").prop("required", true);
    } else {
        $('.in_charge').hide(500);
        $("#date_of_birth_rep").removeAttr("required");
    }


}

function _calculateAge(birthday) { // birthday is a date
    var ageDifMs = Date.now() - birthday.getTime();
    var ageDate = new Date(ageDifMs); // miliseconds from epoch
    return Math.abs(ageDate.getUTCFullYear() - 1970);
}
</script>

<script>
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#imagePreview').css('background-image', 'url(' + e.target.result + ')');
            $('#imagePreview').hide();
            $('#imagePreview').fadeIn(650);
        }
        reader.readAsDataURL(input.files[0]);
    }
}
$("#imageUpload").change(function() {
    readURL(this);
});
$(function() {
    'use strict';
    if ($('.datepicker').length) {
        var date = new Date();
        var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
        $('.datepicker').datepicker({
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

<script type="text/javascript">
$('#fb').hide();
$('#Ig').hide();
$(function() {
    $('[name="Facebook"]').change(function() {
        if ($(this).is(':checked')) {
            $('#fb').show(500);
        } else {
            $('#fb').hide(500);
        };
    });
});
$(function() {
    $('[name="Instagram"]').change(function() {
        if ($(this).is(':checked')) {
            $('#Ig').show(500);
        } else {
            $('#Ig').hide(500);
        };
    });
});
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
</script>

<script>
function cuiIsValid(cui) {
    var console = window.console;
    if (!cui) {
        console.log("CUI vacío");
        return true;
    }
    var cuiRegExp = /^[0-9]{4}\s?[0-9]{5}\s?[0-9]{4}$/;
    if (!cuiRegExp.test(cui)) {
        console.log("CUI con formato inválido");
        return false;
    }
    cui = cui.replace(/\s/, '');
    var depto = parseInt(cui.substring(9, 11), 10);
    var muni = parseInt(cui.substring(11, 13));
    var numero = cui.substring(0, 8);
    var verificador = parseInt(cui.substring(8, 9));
    // Se asume que la codificación de Municipios y 
    // departamentos es la misma que esta publicada en 
    // http://goo.gl/EsxN1a
    // Listado de municipios actualizado segun:
    // http://goo.gl/QLNglm
    // Este listado contiene la cantidad de municipios
    // existentes en cada departamento para poder 
    // determinar el código máximo aceptado por cada 
    // uno de los departamentos.
    var munisPorDepto = [
        /* 01 - Guatemala tiene:      */
        17 /* municipios. */ ,
        /* 02 - El Progreso tiene:    */
        8 /* municipios. */ ,
        /* 03 - Sacatepéquez tiene:   */
        16 /* municipios. */ ,
        /* 04 - Chimaltenango tiene:  */
        16 /* municipios. */ ,
        /* 05 - Escuintla tiene:      */
        13 /* municipios. */ ,
        /* 06 - Santa Rosa tiene:     */
        14 /* municipios. */ ,
        /* 07 - Sololá tiene:         */
        19 /* municipios. */ ,
        /* 08 - Totonicapán tiene:    */
        8 /* municipios. */ ,
        /* 09 - Quetzaltenango tiene: */
        24 /* municipios. */ ,
        /* 10 - Suchitepéquez tiene:  */
        21 /* municipios. */ ,
        /* 11 - Retalhuleu tiene:     */
        9 /* municipios. */ ,
        /* 12 - San Marcos tiene:     */
        30 /* municipios. */ ,
        /* 13 - Huehuetenango tiene:  */
        32 /* municipios. */ ,
        /* 14 - Quiché tiene:         */
        21 /* municipios. */ ,
        /* 15 - Baja Verapaz tiene:   */
        8 /* municipios. */ ,
        /* 16 - Alta Verapaz tiene:   */
        17 /* municipios. */ ,
        /* 17 - Petén tiene:          */
        14 /* municipios. */ ,
        /* 18 - Izabal tiene:         */
        5 /* municipios. */ ,
        /* 19 - Zacapa tiene:         */
        11 /* municipios. */ ,
        /* 20 - Chiquimula tiene:     */
        11 /* municipios. */ ,
        /* 21 - Jalapa tiene:         */
        7 /* municipios. */ ,
        /* 22 - Jutiapa tiene:        */
        17 /* municipios. */
    ];
    if (depto === 0 || muni === 0) {
        console.log("CUI con código de municipio o departamento inválido.");
        return false;
    }
    if (depto > munisPorDepto.length) {
        console.log("CUI con código de departamento inválido.");
        return false;
    }
    if (muni > munisPorDepto[depto - 1]) {
        console.log("CUI con código de municipio inválido.");
        return false;
    }
    // Se verifica el correlativo con base 
    // en el algoritmo del complemento 11.
    var total = 0;
    for (var i = 0; i < numero.length; i++) {
        total += numero[i] * (i + 2);
    }
    var modulo = (total % 11);
    console.log("CUI con módulo: " + modulo);
    return modulo === verificador;
};

function validateDPI(ddd, inx = '') {
    var $this = $(this);
    var $parent = $this.parent();
    var $next = $this.next();
    var cui = ddd;
    if (cui && cuiIsValid(cui)) {
        $('#errordpi').removeClass('error');
        $('#errordpi').removeClass('error_show');
        $('#errordpi').removeClass('success');
        $('#errordpi').text('DPI válido').addClass('success').animate({}, 300);
        $('input[name ="dpi' + inx + '"]')[0].setCustomValidity('');
    } else if (cui) {
        $('#errordpi').removeClass('error');
        $('#errordpi').removeClass('error_show');
        $('#errordpi').removeClass('success');
        $('#errordpi').text('Debe ingresar un DPI válido').addClass('error').animate({}, 300);
        $('input[name ="dpi' + inx + '"]')[0].setCustomValidity('DPI no valido');
    } else {
        $('#errordpi').removeClass('error');
        $('#errordpi').removeClass('error_show');
        $('#errordpi').removeClass('success');
        $('#errordpi').text('DPI no válido').addClass('error').animate({}, 300);
        $('input[name ="dpi' + inx + '"]')[0].setCustomValidity('DPI no puede quedar vacio');
    }
};
//Validar correo electronico  
function validateEXP(exp) {
    console.log(exp);
    $.ajax({
        type: "POST",
        url: "<?php echo base_url();?>staff/check_patient_exp",
        data: {
            'code': exp
        },
        success: function(data) {
            console.log(data.available);
            if (data.available > 0) {
                $('#errorcode').removeClass('error');
                $('#errorcode').removeClass('error_show');
                $('#errorcode').removeClass('success');
                $('#errorcode').text('El numero de expediente ya esta registrado').addClass('error').animate({}, 300);
                $('input[name ="code"]')[0].setCustomValidity('El numero de expediente ya esta registrado');
            } else {
                $('#errorcode').removeClass('error');
                $('#errorcode').removeClass('error_show');
                $('#errorcode').removeClass('success_show');
                $('#errorcode').text('Numero de expadiente valido.').addClass('success').animate({},
                    300);
                $('input[name ="code"]')[0].setCustomValidity('');
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log('error: ' + errorThrown);
        }
    });

};
</script>