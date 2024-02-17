<?php $deptos = $this->db->get('departamento'); $roles = $this->db->get_where('role', array('status'=>1));?>
<div id="main-content">
    <div class="todo-content conts">
        <form action="<?php echo base_url();?>staff/staff/new/<?php echo $type;?>" method="POST" enctype="multipart/form-data" id="form">
            <div class="row">
                <div class="col-xl-8 col-lg-8 col-sm-12" style="float: none; margin: 0 auto;">
                    <div class="tasks-section" style="background: #fff; padding: 24px; border-radius: 25px; border: 1px solid #ccc;">
                        <h4 class="todo-content-header">
                            <i class="batch-icon-arrow-right"></i><span> Ingresar nuevo usuario</span>
                        </h4>
                        <div class="row">
                            <input type="hidden" name="category" value="<?php echo $type;?>" />
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
                            <div class="col-sm-12">
                                <h6>Información básica</h6>
                            </div>
                            <hr>
                            <div class="col-sm-6">
                                <div class="form-group m-b-15">
                                    <label for="simpleinput">Nombres:<span style="color:red">*</span></label>
                                    <input type="text" style="border: 1px solid #198cff8f;" name="first_name" required="" value="" class="form-control">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group m-b-15">
                                    <label for="simpleinput">Apellidos:<span style="color:red">*</span></label>
                                    <input type="text" style="border: 1px solid #198cff8f;" name="last_name" required="" value="" class="form-control">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group date-time-picker m-b-15">
                                    <label for="simpleinvput">Nacimiento<span style="color:red">*</span></label>
                                    <div class="input-group date datepicker" id="DoctorPicker1">
                                        <input type="text" id="applyDate" name="date_of_birth" autocomplete="off" required="" style="border: 1px solid #198cff8f;" value="" class="form-control" >
                                        <span style="display: none;" class="input-group-addon"><i data-feather="calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group m-b-15">
                                    <label for="simpleinput">Correo electrónico:<span style="color:red">*</span></label>
                                    <input type="email" style="border: 1px solid #198cff8f;" name="email" required="email" value="" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group m-b-15">
                                    <label for="simpleinput">Celular:<span style="color:red">*</span></label>
                                    <input type="text" style="border: 1px solid #198cff8f;" name="phone" required="" value="" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group m-b-15">
                                    <label for="simpleinput">DPI/No. Identificación:<span style="color:red">*</span></label>
                                    <input type="text" style="border: 1px solid #198cff8f;" name="dpi" required="" value="" class="form-control" />
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Sexo:</label>
                                    <div class="input-group">
                                        <div class="form-check" style="padding-left: 0px;">
                                            <input checked class="radiobutton" type="radio" name="gender" id="radio3" value="M"><label class="radiobutton-label" for="radio3">Masculino</label>
                                        </div>
                                        <div class="form-check mr-3">
                                            <input class="radiobutton" type="radio" name="gender" id="radio4" value="F"><label class="radiobutton-label" for="radio4">Femenino</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Estado Civil:</label>
                                    <div class="input-group">
                                        <div class="form-check" style="padding-left: 0px;">
                                            <input checked class="radiobutton" type="radio" name="marital_status" id="radio5" value="0"><label class="radiobutton-label" for="radio5">Soltero</label>
                                        </div>
                                        <div class="form-check mr-3">
                                            <input class="radiobutton" type="radio" name="marital_status" id="radio6" value="1"><label class="radiobutton-label" for="radio6">Casado</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
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
                        </div>
                    </div>
                </div>
            </div><br>
            <div class="row">
                <div class="col-xl-8 col-lg-8 col-sm-12" style="float: none; margin: 0 auto;">
                    <div class="tasks-section" style="background: #fff; padding: 24px; border-radius: 25px; border: 1px solid #ccc;">
                        <h6 class="todo-content-header">
                            <i class="batch-icon-arrow-right"></i><span>Información demográfica</span>
                        </h6>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group m-b-15">
                                    <label for="simpleinput">Dirección:<span style="color:red">*</span></label>
                                    <textarea type="text" style="border: 1px solid #198cff8f;" name="address" class="form-control" required="" ></textarea>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group m-b-15">
                                    <label for="simpleinput">País:<span style="color:red">*</span></label>
                                    <input type="text" style="border: 1px solid #198cff8f;" name="country" value="Guatemala" readonly class="form-control">
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
                    <div class="task-section" style="background: #fff; padding: 24px; border-radius: 25px; border: 1px solid #ccc;">
                        <h6 class="todo-content-header">
                            <i class="batch-icon-arrow-right"></i><span>Información académica</span>
                        </h6>
                        <div class="row">
                            <hr>
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
                                <input type="text" name="collegiate_number" class="form-control" value="">
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
                    <div class="task-section" style="background: #fff; padding: 24px; border-radius: 25px; border: 1px solid #ccc;">
                        <h6 class="todo-content-header">
                            <i class="batch-icon-arrow-right"></i><span>Información de empresa</span>
                        </h6>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group m-b-15">
                                    <label for="simpleinput">Dirección:</label>
                                    <textarea type="text" style="border: 1px solid #198cff8f;" name="address_company" class="form-control"></textarea>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group m-b-15">
                                    <label for="simpleinput">País:</label>
                                    <input type="text" style="border: 1px solid #198cff8f;" name="country_company" value="" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group m-b-15">
                                    <label for="simpleinput">Departamento:</label>
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
                                    <div class="input-group date datepicker" id="DoctorPicker2">
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
                                    <label for="simpleinput">Bonificación:</label>
                                    <input type="number" style="border: 1px solid #198cff8f;" name="bonus"  value="" class="form-control" step="0.01" min="0">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <label for="simpleinput">Puesto<span style="color:red">*</span></label>
                                <input type="text" name="charge" required="" class="form-control" value="">
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group date-time-picker m-b-15">
                                    <label for="simpleinvput">Fecha de inicio de contrato <span style="color:red">*</span></label>
                                    <div class="input-group date datepicker" id="DoctorPicker3">
                                        <input required="" type="text" id="applyDate" name="date_contract_start" autocomplete="off" style="border: 1px solid #198cff8f;" value="" class="form-control" required>
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
                                    <div class="input-group date datepicker" id="DoctorPicker4">
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
                    <div class="task-section" style="background: #fff; padding: 24px; border-radius: 25px; border: 1px solid #ccc;">
                        <h6 class="todo-content-header">
                            <i class="batch-icon-arrow-right"></i><span>Documentos</span>
                        </h6>
                        <div class="row">
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
                            <div class="col-sm-12 mb-4">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <label for="simpleinput">Título académico:</label>
                                        <input type="file" name="doc_academic" accept="image/*, application/pdf" />
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="simpleinput">Vencimiento:</label>
                                        <input type="date" class="form-control" name="expiration_academic" value="<?php echo date("Y-m-d");?>" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group m-b-15">
                                    <button class="btn btn-primary" type="submit">Guardar usuario</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<script src="<?php echo base_url();?>public/assets/back/js/jquery-3.1.1.min.js"></script>
<script src="<?php echo base_url();?>public/assets/theme/input/jquery.fileuploader.min.js" type="text/javascript"></script>
<script>
    $(document).ready(function() {
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
        var depto_id = $("#"+deptos).val();
        if (depto_id != '') {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url();?>staff/get_municipio/"+depto_id,
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
    
    
    $("#form").submit(function(e) {
        console.log('Enviando form');
        $('button[type="submit"]').attr('disabled', 'disabled');
        $('button[type="submit"]').html('Guardando...');
    });


</script>