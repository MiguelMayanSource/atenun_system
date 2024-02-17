<?php $owner = $this->db->get_where('admin',array('admin_id'=>$this->session->userdata('login_user_id')) )->row()->owner;
    $deptos = $this->db->get('departamento');
    $roles = $this->db->get_where('role', array('status'=>1));?>
<link href="<?php echo base_url();?>public/assets/appointments/css/select2.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<div class="todo-app-w">
    <div class="todo-content" style="margin-bottom: 8%;">
        <form action="<?php echo base_url();?>doctor/admins/new" method="POST" enctype="multipart/form-data" id="doc_form">
        <div class="row">
            <div class="col-xl-8 col-lg-8 col-sm-12" style="float: none; margin: 0 auto;">
                <div class="tasks-section" style="background: #fff; padding: 24px; border-radius: 25px; border: 1px solid #ccc;">
                    <h4 class="todo-content-header">
                        <i class="batch-icon-arrow-right"></i><span>Agregar nuevo administrador </span>
                    </h4>
                    <div class="col-sm-12">
                        <div class="alert alert-info">
                            <span class="alert-title"><i class="batch-icon-spam"></i> Complete los datos obligatorios *.</span>
                        </div>
                    </div>
                    <input type="hidden" name="owner" value="1" class="form-control">
                    <div class="row">
                        <div class="col-sm-12 ">
                            <div class="avatar-upload">
                                <div class="avatar-edit">
                                    <input type='file' name="photo" id="imageUpload" accept=".png, .jpg, .jpeg" />
                                    <label for="imageUpload"></label>
                                </div>
                                <div class="avatar-preview" style="border: 2px solid #198cff8f;">
                                    <div id="imagePreview" style="background-image: url(<?php echo base_url();?>public/uploads/user.png);"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group m-b-15">
                                <label for="simpleinput">Primer Nombre<span style="color:red">*</span></label>
                                <input style="border: 1px solid #198cff8f;" type="text" name="first_name" required="" class="form-control">
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
                                <input style="border: 1px solid #198cff8f;" type="text" name="last_name" required="" class="form-control">
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

                        <div class="col-sm-6">
                            <div class="form-group date-time-picker m-b-15">
                                <label for="simpleinvput">Nacimiento</label>
                                <div class="input-group date datepicker" id="DoctorPicker1">
                                    <input style="border: 1px solid #198cff8f;" type="text" id="applyDate" name="date_of_birth" autocomplete="off" style="border: 1px solid #198cff8f;" value="<?php echo date('d/m/Y');?>" class="form-control">
                                    <span style="display: none;" class="input-group-addon"><i data-feather="calendar"></i></span>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group m-b-15">
                                <label for="simpleinput">Identificación<span style="color:red">*</span></label> <span class="" id="errordpi"></span>
                                <input style="border: 1px solid #198cff8f;" type="number" name="dpi" id="dpi" required="" onkeyup="validateDPI(this.value);" class="form-control">

                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group m-b-15">
                                <label for="simpleinput">Celular<span style="color:red">*</span></label>
                                <input style="border: 1px solid #198cff8f;" type="tel" name="phone" required="" class="form-control">
                                <small>* Ingresar código de área p.j: 502xxxxxxxx</small>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group m-b-15">
                                <label for="simpleinput">Correo<span style="color:red">*</span></label> <span class="" id="errorm"></span>
                                <input style="border: 1px solid #198cff8f;" type="email" name="email" id="email" required="" onkeyup="validateEmail();" onchange="validateEmail();" class="form-control">
                                <small>* Los datos de acceso serán enviados a la dirección de correo que proporcionaste arriba.</small>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Estado civil</label>
                                <div class="input-group">
                                    <div class="form-check" style="padding-left: 0px;padding-right: 8px;">
                                        <input checked="" class="radiobutton" type="radio" name="marital_status" id="single1" checked value="0"><label class="radiobutton-label" for="single1">Soltero</label>
                                    </div>
                                    <div class="form-check" style="padding-left: 0px;">
                                        <input class="radiobutton" type="radio" name="marital_status" id="maried1" value="1"><label class="radiobutton-label" for="maried1">Casado</label>
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
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group m-b-15">
                                <label for="simpleinput">Rol de usuario:<span style="color:red">*</span></label>
                                <select class="form-control" name="role_id" required>
                                    <option value="" selected>Seleccione un rol de usuario</option>
                                    <?php foreach($roles->result_array() as $rol):?>
                                    <option value="<?php echo $rol['role_id'];?>"><?php echo $rol['name'];?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                        </div>
                        <!-- <div class="col-sm-6">
                            <div class="form-group m-b-15">
                                <label for="simpleinput">Firma</label>
                                <label class="labelx" for="apply"><input type="file" name="signature" class="inputx" id="apply" accept=".jpeg,.png,.jpg">Seleccionar</label>
                                <small id="fileResponse"></small>
                            </div>
                        </div>-->
                    </div>
                </div>
            </div>
        </div><br>
        <div class="row">
            <div class="col-xl-8 col-lg-8 col-sm-12" style="float: none; margin: 0 auto;">
                <div class="tasks-section" style="background: #fff; padding: 24px; border-radius: 25px; border: 1px solid #ccc;">
                    <div class="row">
                        <div class="col-sm-12">
                            <h6>Información demográfica</h6>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group m-b-15">
                                <label for="simpleinput">Dirección</label>
                                <textarea type="text" style="border: 1px solid #198cff8f;" rows="3" name="address" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group m-b-15">
                                <label for="simpleinput">País:</label>
                                <select class="form-control" name="country" id="country" required>
                                    <option value="Guatemala" selected>Guatemala</option>
                                </select>   
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group m-b-15">
                                <label for="simpleinput">Departamento:<span style="color:red">*</span></label>
                                <select class="form-control" name="departamento_id" id="department" required onchange="getMunicipalities('department', 'municipality')">
                                    <option value="" selected>Seleccione un departamento</option>
                                    <?php foreach($deptos->result_array() as $dp):?>
                                    <option value="<?php echo $dp['departamento_id'];?>"><?php echo $dp['name'];?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group m-b-15">
                                <label for="simpleinput">Municipio:<span style="color:red">*</span></label>
                                <select class="form-control" name="municipio_id" id="municipality" required>
                                    <option value="" selected>Selecciona primero un departamento</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group m-b-15">
                                <label for="simpleinput">Ciudad:</label>
                                <input type="text" style="border: 1px solid #198cff8f;" name="city" value="" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group m-b-15">
                                <label for="simpleinput">Código Postal:</label>
                                <input type="text" style="border: 1px solid #198cff8f;" name="postal_code" value="" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group m-b-15">
                                <label for="simpleinput">Número exterior:</label>
                                <input type="text" style="border: 1px solid #198cff8f;" name="outdoor_number" value="" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group m-b-15">
                                <label for="simpleinput">Número interior:</label>
                                <input type="text" style="border: 1px solid #198cff8f;" name="interior_number" value="" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><br>
        <div class="row">
            <div class="col-xl-8 col-lg-8 col-sm-12" style="float: none; margin: 0 auto;">
                <div class="tasks-section" style="background: #fff; padding: 24px; border-radius: 25px; border: 1px solid #ccc;">
                    <div class="row">
                        <div class="col-sm-12">
                            <h6>Información de académica</h6>
                        </div>
                        <div class="col-sm-6">
                            <label for="simpleinput">Profesión<span style="color:red">*</span></label>
                            <input type="text" name="profession" required="" class="form-control" value="">
                        </div>
                        <div class="col-sm-6">
                            <label for="simpleinput">Titulo académico<span style="color:red">*</span></label>
                            <input type="text" name="academic_title" required="" class="form-control" value="">
                        </div>
                        <div class="col-sm-6 mt-4">
                            <label for="simpleinput">Lugar de estudios<span style="color:red">*</span></label>
                            <input type="text" name="place_study" required="" class="form-control" value="">
                        </div>
                        <div class="col-sm-6 mt-4">
                            <label for="simpleinput">Número de colegiado</label>
                            <input type="text" name="no_college" class="form-control" value="">
                        </div>
                        <div class="col-sm-6 mt-4">
                            <div class="form-group date-time-picker m-b-15">
                                <label for="simpleinvput">Fecha de inicio de estudios</label>
                                <div class="input-group date datepicker" id="DoctorPicker5">
                                    <input type="text" id="applyDate" name="date_study_start" autocomplete="off" style="border: 1px solid #198cff8f;" value="" class="form-control">
                                    <span style="display: none;" class="input-group-addon"><i data-feather="calendar"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 mt-4">
                            <div class="form-group date-time-picker m-b-15">
                                <label for="simpleinvput">Fecha fin de estudios</label>
                                <div class="input-group date datepicker" id="DoctorPicker6">
                                    <input type="text" id="applyDate" name="date_study_end" autocomplete="off" style="border: 1px solid #198cff8f;" value="" class="form-control">
                                    <span style="display: none;" class="input-group-addon"><i data-feather="calendar"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group m-b-15">
                                <label for="simpleinput">Comentarios adicionales:</label>
                                <textarea type="text" style="border: 1px solid #198cff8f;" name="comments" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><br>
        <div class="row">
            <div class="col-xl-8 col-lg-8 col-sm-12" style="float: none; margin: 0 auto;">
                <div class="tasks-section" style="background: #fff; padding: 24px; border-radius: 25px; border: 1px solid #ccc;">
                    <div class="row">
                        <div class="col-sm-12">
                            <h6>Información de empresa</h6>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group m-b-15">
                                <label for="simpleinput">Dirección:</label>
                                <textarea type="text" style="border: 1px solid #198cff8f;" name="address_company" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group m-b-15">
                                <label for="simpleinput">País:</label>
                                <select class="form-control" name="country_company" id="country_company" required>
                                    <option value="Guatemala" selected>Guatemala</option>
                                </select>   
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group m-b-15">
                                <label for="simpleinput">Estado:</label>
                                <input type="text" style="border: 1px solid #198cff8f;" name="state_company" value="" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group m-b-15">
                                <label for="simpleinput">Ciudad:</label>
                                <input type="text" style="border: 1px solid #198cff8f;" name="city_company" value="" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group m-b-15">
                                <label for="simpleinput">Código Postal:</label>
                                <input type="text" style="border: 1px solid #198cff8f;" name="postal_code_company" value="" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group m-b-15">
                                <label for="simpleinput">Número exterior:</label>
                                <input type="text" style="border: 1px solid #198cff8f;" name="outdoor_number_company" value="" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group m-b-15">
                                <label for="simpleinput">Número interior:</label>
                                <input type="text" style="border: 1px solid #198cff8f;" name="interior_number_company" value="" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group date-time-picker m-b-15">
                                <label for="simpleinvput">Fecha de inicio de labores</label>
                                <div class="input-group date datepicker" id="DoctorPicker3">
                                    <input type="text" id="applyDate" name="date_work_start" autocomplete="off" style="border: 1px solid #198cff8f;" value="" class="form-control">
                                    <span style="display: none;" class="input-group-addon"><i data-feather="calendar"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group m-b-15">
                                <label for="simpleinput">Salario base:<span style="color:red">*</span></label>
                                <input type="number" style="border: 1px solid #198cff8f;" name="salary" required="" value="" class="form-control" step="0.01" min="0">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group m-b-15">
                                <label for="simpleinput">Bonificación:<span style="color:red">*</span></label>
                                <input type="number" style="border: 1px solid #198cff8f;" name="bonus" required="" value="" class="form-control" step="0.01" min="0">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <label for="simpleinput">Puesto<span style="color:red">*</span></label>
                            <input type="text" name="charge" required="" class="form-control" value="">
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group date-time-picker m-b-15">
                                <label for="simpleinvput">Fecha de inicio de contrato</label>
                                <div class="input-group date datepicker" id="DoctorPicker2">
                                    <input type="text" id="applyDate" name="date_contract_start" autocomplete="off" style="border: 1px solid #198cff8f;" value="" class="form-control">
                                    <span style="display: none;" class="input-group-addon"><i data-feather="calendar"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <label for="simpleinput">Tipo de jornada laboral<span style="color:red">*</span></label>
                            <select class="form-control" name="type_workday" required>
                                <option value="1" selected>Diurna</option>
                                <option value="2">Mixta</option>
                                <option value="3">No sujeto a limitaciones</option>
                                <option value="4">Nocturan</option>
                                <option value="5">Tiempo parcial</option>
                            </select>
                        </div>
                        <div class="col-sm-4">
                            <label for="simpleinput">Tipo de pago<span style="color:red">*</span></label>
                            <select class="form-control" name="payment_type" required>
                                <option value="1" selected>Mensual</option>
                                <option value="2">Quincenal</option>
                                <option value="3">Semanal</option>
                                <option value="4">Diario</option>
                                <option value="5">Destajo</option>
                                <option value="6">Hoja</option>
                            </select>
                        </div>
                        <div class="col-sm-4">
                            <label for="simpleinput">Tiempo de plazo laboral<span style="color:red">*</span></label>
                            <select class="form-control" name="work_time" required>
                                <option value="1" selected>Indefinido</option>
                                <option value="2">Definido</option>
                                <option value="3">Por obra determinada</option>
                                <option value="4">Aprendiz</option>
                                <option value="5">Destajo</option>
                                <option value="6">Hoja</option>
                            </select>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group date-time-picker m-b-15">
                                <label for="simpleinvput">Fecha de fin laboral</label>
                                <div class="input-group date datepicker" id="DoctorPicker7">
                                    <input type="text" id="applyDate" name="date_work_end" autocomplete="off" style="border: 1px solid #198cff8f;" value="" class="form-control">
                                    <span style="display: none;" class="input-group-addon"><i data-feather="calendar"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><br>
        <div class="row">
            <div class="col-xl-8 col-lg-8 col-sm-12" style="float: none; margin: 0 auto;">
                <div class="tasks-section" style="background: #fff; padding: 24px; border-radius: 25px; border: 1px solid #ccc;">
                    <div class="row">
                        <div class="col-sm-12">
                            <h6>Documentos</h6>
                        </div>
                        <div class="col-sm-12 mb-4">
                            <div class="row">
                                <div class="col-sm-12">
                                    <label for="simpleinput">Firma:</label>
                                    <input type="file" name="signature" accept="image/*, application/pdf" />
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 mb-4">
                            <div class="row">
                                <div class="col-sm-12">
                                    <label for="simpleinput">Título académico:</label>
                                    <input type="file" name="doc_academic" accept="image/*, application/pdf" />
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 mb-4">
                            <div class="row">
                                <div class="col-sm-6">
                                    <label for="simpleinput">DPI:</label>
                                    <input type="file" name="doc_dpi" accept="image/*, application/pdf" />
                                </div>
                                <div class="col-sm-6">
                                    <label for="simpleinput">Vencimiento:</label>
                                    <input type="date" class="form-control" name="expiration_dpi" value="<?php echo date("Y-m-d");?>" />
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 mb-4">
                            <div class="row">
                                <div class="col-sm-6">
                                    <label for="simpleinput">Contrato laboral:</label>
                                    <input type="file" name="doc_contract" accept="image/*, application/pdf" />
                                </div>
                                <div class="col-sm-6">
                                    <label for="simpleinput">Vencimiento:</label>
                                    <input type="date" class="form-control" name="expiration_contract" value="<?php echo date("Y-m-d");?>" />
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 mb-4">
                            <div class="row">
                                <div class="col-sm-6">
                                    <label for="simpleinput">RTU:</label>
                                    <input type="file" name="doc_rtu" accept="image/*, application/pdf" />
                                </div>
                                <div class="col-sm-6">
                                    <label for="simpleinput">Vencimiento:</label>
                                    <input type="date" class="form-control" name="expiration_rtu" value="<?php echo date("Y-m-d");?>" />
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 mb-4">
                            <div class="row">
                                <div class="col-sm-6">
                                    <label for="simpleinput">Constancia de salud:</label>
                                    <input type="file" name="doc_health" accept="image/*, application/pdf" />
                                </div>
                                <div class="col-sm-6">
                                    <label for="simpleinput">Vencimiento:</label>
                                    <input type="date" class="form-control" name="expiration_health" value="<?php echo date("Y-m-d");?>" />
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 mb-4">
                            <div class="row">
                                <div class="col-sm-6">
                                    <label for="simpleinput">Antecedentes penales:</label>
                                    <input type="file" name="doc_criminal" accept="image/*, application/pdf" />
                                </div>
                                <div class="col-sm-6">
                                    <label for="simpleinput">Vencimiento:</label>
                                    <input type="date" class="form-control" name="expiration_criminal" value="<?php echo date("Y-m-d");?>" />
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 mb-4">
                            <div class="row">
                                <div class="col-sm-6">
                                    <label for="simpleinput">Antecedentes policiales:</label>
                                    <input type="file" name="doc_police" accept="image/*, application/pdf" />
                                </div>
                                <div class="col-sm-6">
                                    <label for="simpleinput">Vencimiento:</label>
                                    <input type="date" class="form-control" name="expiration_police" value="<?php echo date("Y-m-d");?>" />
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 mb-4">
                            <div class="row">
                                <div class="col-sm-6">
                                    <label for="simpleinput">Recibo de agua/luz:</label>
                                    <input type="file" name="doc_receipt" accept="image/*, application/pdf" />
                                </div>
                                <div class="col-sm-6">
                                    <label for="simpleinput">Vencimiento:</label>
                                    <input type="date" class="form-control" name="expiration_receipt" value="<?php echo date("Y-m-d");?>" />
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 mb-4">
                            <div class="row">
                                <div class="col-sm-6">
                                    <label for="simpleinput">Constancia laboral:</label>
                                    <input type="file" name="doc_employment" accept="image/*, application/pdf" />
                                </div>
                                <div class="col-sm-6">
                                    <label for="simpleinput">Vencimiento:</label>
                                    <input type="date" class="form-control" name="expiration_employment" value="<?php echo date("Y-m-d");?>" />
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 mb-4">
                            <div class="row">
                                <div class="col-sm-6">
                                    <label for="simpleinput">Cartas de recomendaciones:</label>
                                    <input type="file" name="doc_recommend" accept="image/*, application/pdf" />
                                </div>
                                <div class="col-sm-6">
                                    <label for="simpleinput">Vencimiento:</label>
                                    <input type="date" class="form-control" name="expiration_recommend" value="<?php echo date("Y-m-d");?>" />
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 mb-4">
                            <div class="row">
                                <div class="col-sm-6">
                                    <label for="simpleinput">Constancia renas:</label>
                                    <input type="file" name="doc_renas" accept="image/*, application/pdf" />
                                </div>
                                <div class="col-sm-6">
                                    <label for="simpleinput">Vencimiento:</label>
                                    <input type="date" class="form-control" name="expiration_renas" value="<?php echo date("Y-m-d");?>" />
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group m-b-15">
                                <button class="btn btn-primary" type="submit" style="display: flex;">Guardar datos </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </form>
    </div>
</div>

<script src="<?php echo base_url();?>public/assets/theme/input/jquery.fileuploader.min.js" type="text/javascript"></script>
<script type="text/javascript">
$('.itemName').select2();
</script>

<script>
    /* document.getElementById('apply').onchange = function() {
        var filename = this.value.replace(/C:\\fakepath\\/i, '')
        $("#fileResponse").html('<b>Archivo seleccionado:</b> ' + filename);
    }; */
    
    $(document).ready(function() {
        fileSignature = $('input[name="signature"]').fileuploader({
            // Options will go here
            maxSize: 50,
            enableApi: true,
            captions: {
                button: function(options) {
                    return 'Seleccionar ' + (options.limit == 1 ? 'archivo' : 'archivos');
                },
                feedback: function(options) {
                    return 'Seleccionar ' + (options.limit == 1 ? 'archivo' : 'archivos') +
                        ' para subir';
                },
                feedback2: function(options) {
                    return options.length + ' ' + (options.length > 1 ? 'files were' : 'file was') +
                        ' chosen';
                },
                confirm: 'Confirmar',
                cancel: 'Cancelar',
                name: 'Nombre',
                type: 'tipo',
                size: 'Tamaño',
                dimensions: 'Dimensions',
                duration: 'Duración',
                crop: 'Cortar',
                rotate: 'Rotar',
                sort: 'Ordenar',
                download: 'Descargar',
                remove: 'Borrar',
                drop: 'Arrastar archivos para subir',
                paste: '<div class="fileuploader-pending-loader"></div> Pasting a file, click here to cancel.',
                removeConfirmation: 'Estas seguro de querer eliminar este archivo?',
                errors: {
                    filesLimit: function(options) {
                        return 'Only ${limit} ' + (options.limit == 1 ? 'archivo' : 'archivos') +
                            ' pueden subirse.'
                    },
                    filesType: 'Only ${extensions} archivos no se pueden subir.',
                    fileSize: '${name} es demasiado grande selecciona archivos menores a ${fileMaxSize}MB.',
                    filesSizeAll: 'Los archivos selecionados son demasiado grandes selecciona archivos menores a ${maxSize} MB.',
                    fileName: 'Ya existe un archivo con el nombre de ${name}.',
                    remoteFile: 'No se permiten archivos remotos.',
                    folderUpload: 'No se permiten carpetas.'
                }
            },
            dialogs: {
                // alert dialog
                alert: function(text) {

                    Swal.fire({
                        title: 'Archivo demasiado pesado.',
                        titleTextColor: '#000',
                        html: 'Los archivos deben ser menores a <strong>50 MB</strong>.',
                    })
                },


            }

        });
        
        fileUpAcad = $('input[name="doc_academic"]').fileuploader({
            // Options will go here
            maxSize: 50,
            enableApi: true,
            captions: {
                button: function(options) {
                    return 'Seleccionar ' + (options.limit == 1 ? 'archivo' : 'archivos');
                },
                feedback: function(options) {
                    return 'Seleccionar ' + (options.limit == 1 ? 'archivo' : 'archivos') +
                        ' para subir';
                },
                feedback2: function(options) {
                    return options.length + ' ' + (options.length > 1 ? 'files were' : 'file was') +
                        ' chosen';
                },
                confirm: 'Confirmar',
                cancel: 'Cancelar',
                name: 'Nombre',
                type: 'tipo',
                size: 'Tamaño',
                dimensions: 'Dimensions',
                duration: 'Duración',
                crop: 'Cortar',
                rotate: 'Rotar',
                sort: 'Ordenar',
                download: 'Descargar',
                remove: 'Borrar',
                drop: 'Arrastar archivos para subir',
                paste: '<div class="fileuploader-pending-loader"></div> Pasting a file, click here to cancel.',
                removeConfirmation: 'Estas seguro de querer eliminar este archivo?',
                errors: {
                    filesLimit: function(options) {
                        return 'Only ${limit} ' + (options.limit == 1 ? 'archivo' : 'archivos') +
                            ' pueden subirse.'
                    },
                    filesType: 'Only ${extensions} archivos no se pueden subir.',
                    fileSize: '${name} es demasiado grande selecciona archivos menores a ${fileMaxSize}MB.',
                    filesSizeAll: 'Los archivos selecionados son demasiado grandes selecciona archivos menores a ${maxSize} MB.',
                    fileName: 'Ya existe un archivo con el nombre de ${name}.',
                    remoteFile: 'No se permiten archivos remotos.',
                    folderUpload: 'No se permiten carpetas.'
                }
            },
            dialogs: {
                // alert dialog
                alert: function(text) {

                    Swal.fire({
                        title: 'Archivo demasiado pesado.',
                        titleTextColor: '#000',
                        html: 'Los archivos deben ser menores a <strong>50 MB</strong>.',
                    })
                },
            }
        });
        
        fileUpDPI = $('input[name="doc_dpi"]').fileuploader({
            // Options will go here
            maxSize: 50,
            enableApi: true,
            captions: {
                button: function(options) {
                    return 'Seleccionar ' + (options.limit == 1 ? 'archivo' : 'archivos');
                },
                feedback: function(options) {
                    return 'Seleccionar ' + (options.limit == 1 ? 'archivo' : 'archivos') +
                        ' para subir';
                },
                feedback2: function(options) {
                    return options.length + ' ' + (options.length > 1 ? 'files were' : 'file was') +
                        ' chosen';
                },
                confirm: 'Confirmar',
                cancel: 'Cancelar',
                name: 'Nombre',
                type: 'tipo',
                size: 'Tamaño',
                dimensions: 'Dimensions',
                duration: 'Duración',
                crop: 'Cortar',
                rotate: 'Rotar',
                sort: 'Ordenar',
                download: 'Descargar',
                remove: 'Borrar',
                drop: 'Arrastar archivos para subir',
                paste: '<div class="fileuploader-pending-loader"></div> Pasting a file, click here to cancel.',
                removeConfirmation: 'Estas seguro de querer eliminar este archivo?',
                errors: {
                    filesLimit: function(options) {
                        return 'Only ${limit} ' + (options.limit == 1 ? 'archivo' : 'archivos') +
                            ' pueden subirse.'
                    },
                    filesType: 'Only ${extensions} archivos no se pueden subir.',
                    fileSize: '${name} es demasiado grande selecciona archivos menores a ${fileMaxSize}MB.',
                    filesSizeAll: 'Los archivos selecionados son demasiado grandes selecciona archivos menores a ${maxSize} MB.',
                    fileName: 'Ya existe un archivo con el nombre de ${name}.',
                    remoteFile: 'No se permiten archivos remotos.',
                    folderUpload: 'No se permiten carpetas.'
                }
            },
            dialogs: {
                // alert dialog
                alert: function(text) {

                    Swal.fire({
                        title: 'Archivo demasiado pesado.',
                        titleTextColor: '#000',
                        html: 'Los archivos deben ser menores a <strong>50 MB</strong>.',
                    })
                },
            }
        });
        
        fileUpCon = $('input[name="doc_contract"]').fileuploader({
            // Options will go here
            maxSize: 50,
            enableApi: true,
            captions: {
                button: function(options) {
                    return 'Seleccionar ' + (options.limit == 1 ? 'archivo' : 'archivos');
                },
                feedback: function(options) {
                    return 'Seleccionar ' + (options.limit == 1 ? 'archivo' : 'archivos') +
                        ' para subir';
                },
                feedback2: function(options) {
                    return options.length + ' ' + (options.length > 1 ? 'files were' : 'file was') +
                        ' chosen';
                },
                confirm: 'Confirmar',
                cancel: 'Cancelar',
                name: 'Nombre',
                type: 'tipo',
                size: 'Tamaño',
                dimensions: 'Dimensions',
                duration: 'Duración',
                crop: 'Cortar',
                rotate: 'Rotar',
                sort: 'Ordenar',
                download: 'Descargar',
                remove: 'Borrar',
                drop: 'Arrastar archivos para subir',
                paste: '<div class="fileuploader-pending-loader"></div> Pasting a file, click here to cancel.',
                removeConfirmation: 'Estas seguro de querer eliminar este archivo?',
                errors: {
                    filesLimit: function(options) {
                        return 'Only ${limit} ' + (options.limit == 1 ? 'archivo' : 'archivos') +
                            ' pueden subirse.'
                    },
                    filesType: 'Only ${extensions} archivos no se pueden subir.',
                    fileSize: '${name} es demasiado grande selecciona archivos menores a ${fileMaxSize}MB.',
                    filesSizeAll: 'Los archivos selecionados son demasiado grandes selecciona archivos menores a ${maxSize} MB.',
                    fileName: 'Ya existe un archivo con el nombre de ${name}.',
                    remoteFile: 'No se permiten archivos remotos.',
                    folderUpload: 'No se permiten carpetas.'
                }
            },
            dialogs: {
                // alert dialog
                alert: function(text) {

                    Swal.fire({
                        title: 'Archivo demasiado pesado.',
                        titleTextColor: '#000',
                        html: 'Los archivos deben ser menores a <strong>50 MB</strong>.',
                    })
                },
            }
        });
        
        fileUpRTU = $('input[name="doc_rtu"]').fileuploader({
            // Options will go here
            maxSize: 50,
            enableApi: true,
            captions: {
                button: function(options) {
                    return 'Seleccionar ' + (options.limit == 1 ? 'archivo' : 'archivos');
                },
                feedback: function(options) {
                    return 'Seleccionar ' + (options.limit == 1 ? 'archivo' : 'archivos') +
                        ' para subir';
                },
                feedback2: function(options) {
                    return options.length + ' ' + (options.length > 1 ? 'files were' : 'file was') +
                        ' chosen';
                },
                confirm: 'Confirmar',
                cancel: 'Cancelar',
                name: 'Nombre',
                type: 'tipo',
                size: 'Tamaño',
                dimensions: 'Dimensions',
                duration: 'Duración',
                crop: 'Cortar',
                rotate: 'Rotar',
                sort: 'Ordenar',
                download: 'Descargar',
                remove: 'Borrar',
                drop: 'Arrastar archivos para subir',
                paste: '<div class="fileuploader-pending-loader"></div> Pasting a file, click here to cancel.',
                removeConfirmation: 'Estas seguro de querer eliminar este archivo?',
                errors: {
                    filesLimit: function(options) {
                        return 'Only ${limit} ' + (options.limit == 1 ? 'archivo' : 'archivos') +
                            ' pueden subirse.'
                    },
                    filesType: 'Only ${extensions} archivos no se pueden subir.',
                    fileSize: '${name} es demasiado grande selecciona archivos menores a ${fileMaxSize}MB.',
                    filesSizeAll: 'Los archivos selecionados son demasiado grandes selecciona archivos menores a ${maxSize} MB.',
                    fileName: 'Ya existe un archivo con el nombre de ${name}.',
                    remoteFile: 'No se permiten archivos remotos.',
                    folderUpload: 'No se permiten carpetas.'
                }
            },
            dialogs: {
                // alert dialog
                alert: function(text) {

                    Swal.fire({
                        title: 'Archivo demasiado pesado.',
                        titleTextColor: '#000',
                        html: 'Los archivos deben ser menores a <strong>50 MB</strong>.',
                    })
                },
            }
        });
        
        fileUpHealth = $('input[name="doc_health"]').fileuploader({
            // Options will go here
            maxSize: 50,
            enableApi: true,
            captions: {
                button: function(options) {
                    return 'Seleccionar ' + (options.limit == 1 ? 'archivo' : 'archivos');
                },
                feedback: function(options) {
                    return 'Seleccionar ' + (options.limit == 1 ? 'archivo' : 'archivos') +
                        ' para subir';
                },
                feedback2: function(options) {
                    return options.length + ' ' + (options.length > 1 ? 'files were' : 'file was') +
                        ' chosen';
                },
                confirm: 'Confirmar',
                cancel: 'Cancelar',
                name: 'Nombre',
                type: 'tipo',
                size: 'Tamaño',
                dimensions: 'Dimensions',
                duration: 'Duración',
                crop: 'Cortar',
                rotate: 'Rotar',
                sort: 'Ordenar',
                download: 'Descargar',
                remove: 'Borrar',
                drop: 'Arrastar archivos para subir',
                paste: '<div class="fileuploader-pending-loader"></div> Pasting a file, click here to cancel.',
                removeConfirmation: 'Estas seguro de querer eliminar este archivo?',
                errors: {
                    filesLimit: function(options) {
                        return 'Only ${limit} ' + (options.limit == 1 ? 'archivo' : 'archivos') +
                            ' pueden subirse.'
                    },
                    filesType: 'Only ${extensions} archivos no se pueden subir.',
                    fileSize: '${name} es demasiado grande selecciona archivos menores a ${fileMaxSize}MB.',
                    filesSizeAll: 'Los archivos selecionados son demasiado grandes selecciona archivos menores a ${maxSize} MB.',
                    fileName: 'Ya existe un archivo con el nombre de ${name}.',
                    remoteFile: 'No se permiten archivos remotos.',
                    folderUpload: 'No se permiten carpetas.'
                }
            },
            dialogs: {
                // alert dialog
                alert: function(text) {

                    Swal.fire({
                        title: 'Archivo demasiado pesado.',
                        titleTextColor: '#000',
                        html: 'Los archivos deben ser menores a <strong>50 MB</strong>.',
                    })
                },
            }
        });
        
        fileUpCrim = $('input[name="doc_criminal"]').fileuploader({
            // Options will go here
            maxSize: 50,
            enableApi: true,
            captions: {
                button: function(options) {
                    return 'Seleccionar ' + (options.limit == 1 ? 'archivo' : 'archivos');
                },
                feedback: function(options) {
                    return 'Seleccionar ' + (options.limit == 1 ? 'archivo' : 'archivos') +
                        ' para subir';
                },
                feedback2: function(options) {
                    return options.length + ' ' + (options.length > 1 ? 'files were' : 'file was') +
                        ' chosen';
                },
                confirm: 'Confirmar',
                cancel: 'Cancelar',
                name: 'Nombre',
                type: 'tipo',
                size: 'Tamaño',
                dimensions: 'Dimensions',
                duration: 'Duración',
                crop: 'Cortar',
                rotate: 'Rotar',
                sort: 'Ordenar',
                download: 'Descargar',
                remove: 'Borrar',
                drop: 'Arrastar archivos para subir',
                paste: '<div class="fileuploader-pending-loader"></div> Pasting a file, click here to cancel.',
                removeConfirmation: 'Estas seguro de querer eliminar este archivo?',
                errors: {
                    filesLimit: function(options) {
                        return 'Only ${limit} ' + (options.limit == 1 ? 'archivo' : 'archivos') +
                            ' pueden subirse.'
                    },
                    filesType: 'Only ${extensions} archivos no se pueden subir.',
                    fileSize: '${name} es demasiado grande selecciona archivos menores a ${fileMaxSize}MB.',
                    filesSizeAll: 'Los archivos selecionados son demasiado grandes selecciona archivos menores a ${maxSize} MB.',
                    fileName: 'Ya existe un archivo con el nombre de ${name}.',
                    remoteFile: 'No se permiten archivos remotos.',
                    folderUpload: 'No se permiten carpetas.'
                }
            },
            dialogs: {
                // alert dialog
                alert: function(text) {

                    Swal.fire({
                        title: 'Archivo demasiado pesado.',
                        titleTextColor: '#000',
                        html: 'Los archivos deben ser menores a <strong>50 MB</strong>.',
                    })
                },
            }
        });
        
        fileUpPoli = $('input[name="doc_police"]').fileuploader({
            // Options will go here
            maxSize: 50,
            enableApi: true,
            captions: {
                button: function(options) {
                    return 'Seleccionar ' + (options.limit == 1 ? 'archivo' : 'archivos');
                },
                feedback: function(options) {
                    return 'Seleccionar ' + (options.limit == 1 ? 'archivo' : 'archivos') +
                        ' para subir';
                },
                feedback2: function(options) {
                    return options.length + ' ' + (options.length > 1 ? 'files were' : 'file was') +
                        ' chosen';
                },
                confirm: 'Confirmar',
                cancel: 'Cancelar',
                name: 'Nombre',
                type: 'tipo',
                size: 'Tamaño',
                dimensions: 'Dimensions',
                duration: 'Duración',
                crop: 'Cortar',
                rotate: 'Rotar',
                sort: 'Ordenar',
                download: 'Descargar',
                remove: 'Borrar',
                drop: 'Arrastar archivos para subir',
                paste: '<div class="fileuploader-pending-loader"></div> Pasting a file, click here to cancel.',
                removeConfirmation: 'Estas seguro de querer eliminar este archivo?',
                errors: {
                    filesLimit: function(options) {
                        return 'Only ${limit} ' + (options.limit == 1 ? 'archivo' : 'archivos') +
                            ' pueden subirse.'
                    },
                    filesType: 'Only ${extensions} archivos no se pueden subir.',
                    fileSize: '${name} es demasiado grande selecciona archivos menores a ${fileMaxSize}MB.',
                    filesSizeAll: 'Los archivos selecionados son demasiado grandes selecciona archivos menores a ${maxSize} MB.',
                    fileName: 'Ya existe un archivo con el nombre de ${name}.',
                    remoteFile: 'No se permiten archivos remotos.',
                    folderUpload: 'No se permiten carpetas.'
                }
            },
            dialogs: {
                // alert dialog
                alert: function(text) {

                    Swal.fire({
                        title: 'Archivo demasiado pesado.',
                        titleTextColor: '#000',
                        html: 'Los archivos deben ser menores a <strong>50 MB</strong>.',
                    })
                },
            }
        });
        
        fileUpRec = $('input[name="doc_receipt"]').fileuploader({
            // Options will go here
            maxSize: 50,
            enableApi: true,
            captions: {
                button: function(options) {
                    return 'Seleccionar ' + (options.limit == 1 ? 'archivo' : 'archivos');
                },
                feedback: function(options) {
                    return 'Seleccionar ' + (options.limit == 1 ? 'archivo' : 'archivos') +
                        ' para subir';
                },
                feedback2: function(options) {
                    return options.length + ' ' + (options.length > 1 ? 'files were' : 'file was') +
                        ' chosen';
                },
                confirm: 'Confirmar',
                cancel: 'Cancelar',
                name: 'Nombre',
                type: 'tipo',
                size: 'Tamaño',
                dimensions: 'Dimensions',
                duration: 'Duración',
                crop: 'Cortar',
                rotate: 'Rotar',
                sort: 'Ordenar',
                download: 'Descargar',
                remove: 'Borrar',
                drop: 'Arrastar archivos para subir',
                paste: '<div class="fileuploader-pending-loader"></div> Pasting a file, click here to cancel.',
                removeConfirmation: 'Estas seguro de querer eliminar este archivo?',
                errors: {
                    filesLimit: function(options) {
                        return 'Only ${limit} ' + (options.limit == 1 ? 'archivo' : 'archivos') +
                            ' pueden subirse.'
                    },
                    filesType: 'Only ${extensions} archivos no se pueden subir.',
                    fileSize: '${name} es demasiado grande selecciona archivos menores a ${fileMaxSize}MB.',
                    filesSizeAll: 'Los archivos selecionados son demasiado grandes selecciona archivos menores a ${maxSize} MB.',
                    fileName: 'Ya existe un archivo con el nombre de ${name}.',
                    remoteFile: 'No se permiten archivos remotos.',
                    folderUpload: 'No se permiten carpetas.'
                }
            },
            dialogs: {
                // alert dialog
                alert: function(text) {

                    Swal.fire({
                        title: 'Archivo demasiado pesado.',
                        titleTextColor: '#000',
                        html: 'Los archivos deben ser menores a <strong>50 MB</strong>.',
                    })
                },
            }
        });
        
        fileUpEmp = $('input[name="doc_employment"]').fileuploader({
            // Options will go here
            maxSize: 50,
            enableApi: true,
            captions: {
                button: function(options) {
                    return 'Seleccionar ' + (options.limit == 1 ? 'archivo' : 'archivos');
                },
                feedback: function(options) {
                    return 'Seleccionar ' + (options.limit == 1 ? 'archivo' : 'archivos') +
                        ' para subir';
                },
                feedback2: function(options) {
                    return options.length + ' ' + (options.length > 1 ? 'files were' : 'file was') +
                        ' chosen';
                },
                confirm: 'Confirmar',
                cancel: 'Cancelar',
                name: 'Nombre',
                type: 'tipo',
                size: 'Tamaño',
                dimensions: 'Dimensions',
                duration: 'Duración',
                crop: 'Cortar',
                rotate: 'Rotar',
                sort: 'Ordenar',
                download: 'Descargar',
                remove: 'Borrar',
                drop: 'Arrastar archivos para subir',
                paste: '<div class="fileuploader-pending-loader"></div> Pasting a file, click here to cancel.',
                removeConfirmation: 'Estas seguro de querer eliminar este archivo?',
                errors: {
                    filesLimit: function(options) {
                        return 'Only ${limit} ' + (options.limit == 1 ? 'archivo' : 'archivos') +
                            ' pueden subirse.'
                    },
                    filesType: 'Only ${extensions} archivos no se pueden subir.',
                    fileSize: '${name} es demasiado grande selecciona archivos menores a ${fileMaxSize}MB.',
                    filesSizeAll: 'Los archivos selecionados son demasiado grandes selecciona archivos menores a ${maxSize} MB.',
                    fileName: 'Ya existe un archivo con el nombre de ${name}.',
                    remoteFile: 'No se permiten archivos remotos.',
                    folderUpload: 'No se permiten carpetas.'
                }
            },
            dialogs: {
                // alert dialog
                alert: function(text) {

                    Swal.fire({
                        title: 'Archivo demasiado pesado.',
                        titleTextColor: '#000',
                        html: 'Los archivos deben ser menores a <strong>50 MB</strong>.',
                    })
                },
            }
        });
        
        fileUpRecom = $('input[name="doc_recommend"]').fileuploader({
            // Options will go here
            maxSize: 50,
            enableApi: true,
            captions: {
                button: function(options) {
                    return 'Seleccionar ' + (options.limit == 1 ? 'archivo' : 'archivos');
                },
                feedback: function(options) {
                    return 'Seleccionar ' + (options.limit == 1 ? 'archivo' : 'archivos') +
                        ' para subir';
                },
                feedback2: function(options) {
                    return options.length + ' ' + (options.length > 1 ? 'files were' : 'file was') +
                        ' chosen';
                },
                confirm: 'Confirmar',
                cancel: 'Cancelar',
                name: 'Nombre',
                type: 'tipo',
                size: 'Tamaño',
                dimensions: 'Dimensions',
                duration: 'Duración',
                crop: 'Cortar',
                rotate: 'Rotar',
                sort: 'Ordenar',
                download: 'Descargar',
                remove: 'Borrar',
                drop: 'Arrastar archivos para subir',
                paste: '<div class="fileuploader-pending-loader"></div> Pasting a file, click here to cancel.',
                removeConfirmation: 'Estas seguro de querer eliminar este archivo?',
                errors: {
                    filesLimit: function(options) {
                        return 'Only ${limit} ' + (options.limit == 1 ? 'archivo' : 'archivos') +
                            ' pueden subirse.'
                    },
                    filesType: 'Only ${extensions} archivos no se pueden subir.',
                    fileSize: '${name} es demasiado grande selecciona archivos menores a ${fileMaxSize}MB.',
                    filesSizeAll: 'Los archivos selecionados son demasiado grandes selecciona archivos menores a ${maxSize} MB.',
                    fileName: 'Ya existe un archivo con el nombre de ${name}.',
                    remoteFile: 'No se permiten archivos remotos.',
                    folderUpload: 'No se permiten carpetas.'
                }
            },
            dialogs: {
                // alert dialog
                alert: function(text) {

                    Swal.fire({
                        title: 'Archivo demasiado pesado.',
                        titleTextColor: '#000',
                        html: 'Los archivos deben ser menores a <strong>50 MB</strong>.',
                    })
                },
            }
        });
        
        fileUpRenas = $('input[name="doc_renas"]').fileuploader({
            // Options will go here
            maxSize: 50,
            enableApi: true,
            captions: {
                button: function(options) {
                    return 'Seleccionar ' + (options.limit == 1 ? 'archivo' : 'archivos');
                },
                feedback: function(options) {
                    return 'Seleccionar ' + (options.limit == 1 ? 'archivo' : 'archivos') +
                        ' para subir';
                },
                feedback2: function(options) {
                    return options.length + ' ' + (options.length > 1 ? 'files were' : 'file was') +
                        ' chosen';
                },
                confirm: 'Confirmar',
                cancel: 'Cancelar',
                name: 'Nombre',
                type: 'tipo',
                size: 'Tamaño',
                dimensions: 'Dimensions',
                duration: 'Duración',
                crop: 'Cortar',
                rotate: 'Rotar',
                sort: 'Ordenar',
                download: 'Descargar',
                remove: 'Borrar',
                drop: 'Arrastar archivos para subir',
                paste: '<div class="fileuploader-pending-loader"></div> Pasting a file, click here to cancel.',
                removeConfirmation: 'Estas seguro de querer eliminar este archivo?',
                errors: {
                    filesLimit: function(options) {
                        return 'Only ${limit} ' + (options.limit == 1 ? 'archivo' : 'archivos') +
                            ' pueden subirse.'
                    },
                    filesType: 'Only ${extensions} archivos no se pueden subir.',
                    fileSize: '${name} es demasiado grande selecciona archivos menores a ${fileMaxSize}MB.',
                    filesSizeAll: 'Los archivos selecionados son demasiado grandes selecciona archivos menores a ${maxSize} MB.',
                    fileName: 'Ya existe un archivo con el nombre de ${name}.',
                    remoteFile: 'No se permiten archivos remotos.',
                    folderUpload: 'No se permiten carpetas.'
                }
            },
            dialogs: {
                // alert dialog
                alert: function(text) {

                    Swal.fire({
                        title: 'Archivo demasiado pesado.',
                        titleTextColor: '#000',
                        html: 'Los archivos deben ser menores a <strong>50 MB</strong>.',
                    })
                },
            }
        });
    });
        
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
        if ($('#DoctorPicker3').length) {
            var date = new Date();
            var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
            $('#DoctorPicker3').datepicker({
                format: "dd/mm/yyyy",
                todayHighlight: true,
                autoclose: true
            });
        }
        if ($('#DoctorPicker4').length) {
            var date = new Date();
            var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
            $('#DoctorPicker4').datepicker({
                format: "dd/mm/yyyy",
                todayHighlight: true,
                autoclose: true
            });
        }
        if ($('#DoctorPicker5').length) {
            var date = new Date();
            var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
            $('#DoctorPicker5').datepicker({
                format: "dd/mm/yyyy",
                todayHighlight: true,
                autoclose: true
            });
        }
        if ($('#DoctorPicker6').length) {
            var date = new Date();
            var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
            $('#DoctorPicker6').datepicker({
                format: "dd/mm/yyyy",
                todayHighlight: true,
                autoclose: true
            });
        }
        if ($('#DoctorPicker7').length) {
            var date = new Date();
            var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
            $('#DoctorPicker7').datepicker({
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
    
    function validateDPI(ddd) {
        var $this = $(this);
        var $parent = $this.parent();
        var $next = $this.next();
        var cui = ddd;
    
        if (cui && cuiIsValid(cui)) {
    
            $('#errordpi').removeClass('error');
            $('#errordpi').removeClass('error_show');
            $('#errordpi').removeClass('success');
    
            $('#errordpi').text('DPI válido').addClass('success').animate({}, 300);
            $('input[name ="dpi"]')[0].setCustomValidity('');
    
        } else if (cui) {
    
            $('#errordpi').removeClass('error');
            $('#errordpi').removeClass('error_show');
            $('#errordpi').removeClass('success');
    
            $('#errordpi').text('Debe ingresar un DPI válido').addClass('error').animate({}, 300);
            $('input[name ="dpi"]')[0].setCustomValidity('DPI no valido');
    
        } else {
    
            $('#errordpi').removeClass('error');
            $('#errordpi').removeClass('error_show');
            $('#errordpi').removeClass('success');
    
            $('#errordpi').text('DPI no válido').addClass('error').animate({}, 300);
            $('input[name ="dpi"]')[0].setCustomValidity('DPI no puede quedar vacio');
    
        }
    };
    
    //Validar correo electronico  
    function validateEmail() {
    
        var email = $('input[name ="email"]').val();
    
        console.log(email);
    
        //validar correo electronico
        var validacion_email = /^[a-zA-Z0-9_\.\-]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$/;
    
        if (!validacion_email.test(email)) {
    
            $('#errorm').removeClass('error');
            $('#errorm').removeClass('error_show');
            $('#errorm').removeClass('success');
    
            $('#errorm').text('correo electronico no valido').addClass('error').animate({}, 300);
            $('input[name ="email"]')[0].setCustomValidity('correo no valido');
    
        } else {
    
            $('#errorm').removeClass('error');
            $('#errorm').removeClass('error_show');
            $('#errorm').removeClass('success_show');
    
            $('#errorm').text('Este correo valido').addClass('success').animate({}, 300);
            $('input[name ="email"]')[0].setCustomValidity('');
    
        }
    };
    
    function getMunicipalities(deptos, muni) {
        var depto_id = $("#"+deptos).val();
        if (depto_id != '') {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url();?>doctor/get_municipio/"+depto_id,
                success: function (response) {
                    console.log(response);
                    $("#"+muni).html(response);
                }, 
                error: function (e) {
                    console.log("Error: ", e);
                }
            });
        }
    }
    
    $("#doc_form").submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        var $form = $(this);
        var url = $form.attr('action');

        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            beforeSend: function() {
                $('button[type="submit"]').attr('disabled', 'disabled');
                $('button[type="submit"]').html('Guardando...');
                $('button[type="submit"]').append('<i class="loading" ></i>');
            },
            success: function(data) {
                
                $(".loading").remove();
                $('button[type="submit"]').html('Guardado');
                window.location.href='<?php echo base_url(); ?>doctor/admins';
            },
            error: function(xhr, status, error) {
               
                console.log(xhr,status, error);
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });

</script>