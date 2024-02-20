<?php 
    $staff_id = base64_decode($id_);
    $documents = $this->db->get_where('document', array('user_id'=>$staff_id, 'user_type'=>'staff', 'status'=>1));
    $roles = $this->db->get_where('role', array('status'=>1));
    $this->db->where('staff_id', $staff_id);
    $info = $this->db->get('staff')->result_array();    
    $deptos = $this->db->get('departamento');
    foreach($info as $details):
        $muns = $this->db->get_where('municipio', array('departamento_id'=>$details['departamento_id']));
        $muns_com = $this->db->get_where('municipio', array('departamento_id'=>$details['departamento_id_empresa']));
?>
<script src="<?php echo base_url();?>public/uploads/sweetalert2.all.min.js"></script>
<script src="<?php echo base_url();?>public/assets/libs/select2/js/select2.min.js"></script>
<link href="<?php echo base_url();?>public/assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
<div class="todo-app-w">
    <div class="todo-sidebar">
        <div id="sticky">
            <div class="todo-sidebar-section" style="border-bottom:0px">
                <div class="todo-sidebar-section-contents">
                    <ul class="tasks-list">
                        <li class="side-li">
                            <a class="side-items active" href="<?php echo base_url();?>doctor/staff_profile/<?php echo base64_encode($staff_id);?>/"><i style="padding-right: 10px; font-size: 22px;" class="picons-thin-icon-thin-0002_write_pencil_new_edit"></i> Editar perfil <span class="side-active"></span> </a>
                        </li>
                        <li class="side-li">
                            <a class="side-items" href="<?php echo base_url();?>doctor/staff_notifications/<?php echo base64_encode($staff_id);?>/"><i style="padding-right: 10px;font-size: 22px;" class="picons-thin-icon-thin-0543_world_earth_worldwide_location_travel"></i> Notificaciones </a>
                        </li>
                        <li class="side-li">
                            <a class="side-items" href="<?php echo base_url();?>doctor/staff_security/<?php echo base64_encode($staff_id);?>/"><i style="padding-right: 10px;font-size: 22px;" class="picons-thin-icon-thin-0705_user_profile_security_password_permissions"></i> Contraseña y seguridad </a>
                        </li>
                        <li class="side-li">
                            <a class="side-items" href="<?php echo base_url();?>doctor/staff_activity/<?php echo base64_encode($staff_id);?>/"><i style="padding-right: 10px;font-size: 22px;" class="picons-thin-icon-thin-0244_text_bullets_list"></i> Registro de actividad </a>
                        </li>
                        <li class="side-li">
                            <a class="side-items" href="<?php echo base_url();?>doctor/staff_permissions/<?php echo base64_encode($staff_id);?>/"><i style="padding-right: 10px;font-size: 22px;" class="picons-thin-icon-thin-0015_fountain_pen"></i> Permisos </a>
                        </li>
                    </ul>
                    <div class="text-center account-container"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="todo-content conts">
        <h4 class="todo-content-header">
            <i class="batch-icon-arrow-right"></i><span>Editar perfil - <?php echo $this->accounts_model->get_name('staff',$details['staff_id']);?></span>
        </h4>
        <div class="row">
            <div class="col-sm-12">
                <div class="alert alert-info">
                    <span class="alert-title"><i class="batch-icon-spam"></i> Manten actualizados tus datos.</span>
                    <span class="alert-content">Recuerda siempre mantener todos tus datos actualizados en esta sección, si no los actualizas es posible que no recibas notificaciones o tengas problemas de comunicación con <span class="alert-lined"><a href="javascript:void(0);" style="color:#0044e9">Medicaby</a>.</span></span>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="tasks-section">
                    <form action="<?php echo base_url();?>doctor/staff/edit/<?php echo $details['staff_id'];?>" method="POST" enctype="multipart/form-data" id="form">
                        <div class="row">
                            <div class="col-sm-12 mb-2">
                                <div class="tasks-section" style="background: #fff; padding: 24px; border-radius: 25px; border: 1px solid #ccc;">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="avatar-upload">
                                                <div class="avatar-edit">
                                                    <input type='file' name="photo" id="imageUpload" accept=".png, .jpg, .jpeg" />
                                                    <label for="imageUpload"></label>
                                                </div>
                                                <div class="avatar-preview" style="border: 2px solid #198cff8f;">
                                                    <div id="imagePreview" style="background-image: url(<?php echo $this->accounts_model->get_photo('staff', $staff_id);?>);"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Nombres:</label>
                                                <input type="text" style="border: 1px solid #198cff8f;" name="first_name" required="" value="<?php echo $details['first_name'] ?>" class="form-control">
                                            </div>
                                        </div>
            
                                        <div class="col-sm-6">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Apellidos:</label>
                                                <input type="text" style="border: 1px solid #198cff8f;" name="last_name" required="" value="<?php echo $details['last_name'] ?>" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group date-time-picker m-b-15">
                                                <label for="simpleinvput">Nacimiento</label>
                                                <div class="input-group date datepicker" id="DoctorPicker1">
                                                    <input type="text" id="applyDate" name="date_of_birth" autocomplete="off" style="border: 1px solid #198cff8f;" value="<?php echo $details['date_of_birth'];?>" class="form-control">
                                                    <span style="display: none;" class="input-group-addon"><i data-feather="calendar"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Correo:</label>
                                                <input type="email" style="border: 1px solid #198cff8f;" name="email" required="email" value="<?php echo $details['email'] ?>" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Celular:</label>
                                                <input type="text" style="border: 1px solid #198cff8f;" name="phone" required="" value="<?php echo $details['phone'] ?>" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">DPI/Identificación:</label>
                                                <input type="text" style="border: 1px solid #198cff8f;" name="dpi" required="" value="<?php echo $details['dpi'] ?>" class="form-control" />
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Sexo:</label>
                                                <div class="input-group">
                                                    <div class="form-check" style="padding-left: 0px;">
                                                        <input <?php if($details['gender'] == "M") echo "checked";?> class="radiobutton" type="radio" name="gender" id="radio1" value="M"><label class="radiobutton-label" for="radio1">Masculino</label>
                                                    </div>
                                                    <div class="form-check mr-3">
                                                        <input <?php if($details['gender'] == "F") echo "checked";?> class="radiobutton" type="radio" name="gender" id="radio2" value="F"><label class="radiobutton-label" for="radio2">Femenino</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Estado Civil:</label>
                                                <div class="input-group">
                                                    <div class="form-check" style="padding-left: 0px;">
                                                        <input <?php if($details['marital_status'] == 0) echo "checked";?> class="radiobutton" type="radio" name="marital_status" id="radio3" value="0"><label class="radiobutton-label" for="radio3">Soltero</label>
                                                    </div>
                                                    <div class="form-check mr-3">
                                                        <input <?php if($details['marital_status'] == 1) echo "checked";?> class="radiobutton" type="radio" name="marital_status" id="radio4" value="1"><label class="radiobutton-label" for="radio4">Casado</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Rol de usuario:</label>
                                                <select class="form-control" name="role_id" required>
                                                    <option value="">Seleccione un rol de usuario</option>
                                                    <?php foreach($roles->result_array() as $rol):?>
                                                    <option value="<?php echo $rol['role_id'];?>" <?php if($rol['role_id'] == $details['role_id']) echo "selected";?>><?php echo $rol['name'];?></option>
                                                    <?php endforeach;?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 mb-2">
                                <div class="tasks-section" style="background: #fff; padding: 24px; border-radius: 25px; border: 1px solid #ccc;">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <h6>Información demográfica</h6>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Dirección:</label>
                                                <textarea type="text" style="border: 1px solid #198cff8f;" name="address" class="form-control"><?php echo $details['address'];?></textarea>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">País:</label>
                                                <input type="text" style="border: 1px solid #198cff8f;" name="country" value="<?php echo $details['country'];?>" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Departamento:</label>
                                                <select class="form-control" name="departamento_id" id="department" required onchange="getMunicipalities('department', 'municipality')">
                                                    <option value="" selected>Seleccione un departamento</option>
                                                    <?php foreach($deptos->result_array() as $dp):?>
                                                    <option value="<?php echo $dp['departamento_id'];?>" <?php if($dp['departamento_id'] == $details['departamento_id']) echo "selected";?>><?php echo $dp['name'];?></option>
                                                    <?php endforeach;?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Municipio:</label>
                                                <select class="form-control" name="municipio_id" id="municipality" required>
                                                    <?php foreach($muns->result_array() as $mn):?>
                                                    <option value="<?php echo $mn['id'];?>" <?php if($mn['id'] == $details['municipio_id']) echo "selected";?>><?php echo $mn['name'];?></option>
                                                    <?php endforeach;?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Ciudad:</label>
                                                <input type="text" style="border: 1px solid #198cff8f;" name="city" value="<?php echo $details['city'];?>" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Código Postal:</label>
                                                <input type="text" style="border: 1px solid #198cff8f;" name="postal_code" value="<?php echo $details['postal_code'];?>" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Número exterior:</label>
                                                <input type="text" style="border: 1px solid #198cff8f;" name="outdoor_number" value="<?php echo $details['outdoor_number'];?>" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Número interior:</label>
                                                <input type="text" style="border: 1px solid #198cff8f;" name="interior_number" value="<?php echo $details['interior_number'];?>" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 mb-2">
                                <div class="tasks-section" style="background: #fff; padding: 24px; border-radius: 25px; border: 1px solid #ccc;">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <h6>Información acádemica</h6>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group mb-15">
                                                <label for="simpleinput">Profesión<span style="color:red">*</span></label>
                                                <input type="text" name="profession" required="" class="form-control" value="<?php echo $details['profession'];?>">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group mb-15">
                                                <label for="simpleinput">Titulo académico<span style="color:red">*</span></label>
                                                <input type="text" name="academic_title" required="" class="form-control" value="<?php echo $details['academic_title'];?>">
                                            </div>
                                        </div>
                                        <div class="col-sm-6 mt-4">
                                            <div class="form-group mb-15">
                                                <label for="simpleinput">Lugar de estudios<span style="color:red">*</span></label>
                                                <input type="text" name="place_study" required="" class="form-control" value="<?php echo $details['place_study'];?>">
                                            </div>
                                        </div>
                                        <div class="col-sm-6 mt-4">
                                            <div class="form-group mb-15">
                                                <label for="simpleinput">Número de colegiado<span style="color:red">*</span></label>
                                                <input type="text" name="collegiate_number" class="form-control" value="<?php echo $details['collegiate_number'];?>">
                                            </div>
                                        </div>
                                        <div class="col-sm-6 mt-4">
                                            <div class="form-group date-time-picker m-b-15">
                                                <label for="simpleinvput">Fecha de inicio de estudios</label>
                                                <div class="input-group date datepicker" id="DoctorPicker5">
                                                    <input type="text" id="applyDate" name="date_study_start" autocomplete="off" style="border: 1px solid #198cff8f;" value="<?php echo $details['date_study_start'];?>" class="form-control">
                                                    <span style="display: none;" class="input-group-addon"><i data-feather="calendar"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 mt-4">
                                            <div class="form-group date-time-picker m-b-15">
                                                <label for="simpleinvput">Fecha fin de estudios</label>
                                                <div class="input-group date datepicker" id="DoctorPicker6">
                                                    <input type="text" id="applyDate" name="date_study_end" autocomplete="off" style="border: 1px solid #198cff8f;" value="<?php echo $details['date_study_end'];?>" class="form-control">
                                                    <span style="display: none;" class="input-group-addon"><i data-feather="calendar"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Comentarios adicionales:</label>
                                                <textarea type="text" style="border: 1px solid #198cff8f;" name="comments" class="form-control"><?php echo $details['comments'];?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-sm-12 mb-2">
                                <div class="tasks-section" style="background: #fff; padding: 24px; border-radius: 25px; border: 1px solid #ccc;">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <h6>Información de empresa</h6>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Dirección:</label>
                                                <textarea type="text" style="border: 1px solid #198cff8f;" name="address_company" class="form-control"><?php echo $details['address_company'];?></textarea>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">País:</label>
                                                <input type="text" style="border: 1px solid #198cff8f;" name="country_company" value="<?php echo $details['country_company'];?>" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Estado:</label>
                                                <input type="text" style="border: 1px solid #198cff8f;" name="state_company" value="<?php echo $details['state_company'];?>" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Ciudad:</label>
                                                <input type="text" style="border: 1px solid #198cff8f;" name="city_company" value="<?php echo $details['city_company'];?>" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Código Postal:</label>
                                                <input type="text" style="border: 1px solid #198cff8f;" name="postal_code_company" value="<?php echo $details['postal_code_company'];?>" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Número exterior:</label>
                                                <input type="text" style="border: 1px solid #198cff8f;" name="outdoor_number_company" value="<?php echo $details['outdoor_number_company'];?>" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Número interior:</label>
                                                <input type="text" style="border: 1px solid #198cff8f;" name="interior_number_company" value="<?php echo $details['interior_number_company'];?>" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group date-time-picker m-b-15">
                                                <label for="simpleinvput">Fecha de inicio de labores</label>
                                                <div class="input-group date datepicker" id="DoctorPicker2">
                                                    <input type="text" id="applyDate" name="date_work_start" autocomplete="off" style="border: 1px solid #198cff8f;" value="<?php echo $details['date_work_start'];?>" class="form-control">
                                                    <span style="display: none;" class="input-group-addon"><i data-feather="calendar"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Salario base:</label>
                                                <input type="number" style="border: 1px solid #198cff8f;" name="salary" required="" value="<?php echo $details['salary'];?>" class="form-control" step="0.01" min="0">
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Bonificación:</label>
                                                <input type="number" style="border: 1px solid #198cff8f;" name="bonus" required="" value="<?php echo $details['bonus'];?>" class="form-control" step="0.01" min="0">
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <label for="simpleinput">Puesto<span style="color:red">*</span></label>
                                            <input type="text" name="charge" required="" class="form-control" value="<?php echo $details['charge'];?>">
                                        </div>
            
                                        <div class="col-sm-4">
                                            <div class="form-group date-time-picker m-b-15">
                                                <label for="simpleinvput">Fecha de inicio de contrato</label>
                                                <div class="input-group date datepicker" id="DoctorPicker3">
                                                    <input type="text" id="applyDate" name="date_contract_start" autocomplete="off" style="border: 1px solid #198cff8f;" value="<?php echo $details['date_contract_start'];?>" class="form-control">
                                                    <span style="display: none;" class="input-group-addon"><i data-feather="calendar"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <label for="simpleinput">Tipo de jornada laboral<span style="color:red">*</span></label>
                                            <select class="form-control" name="type_workday">
                                                <option value="1" <?php if($details['type_workday'] == 1) echo "selected";?>>Diurna</option>
                                                <option value="2" <?php if($details['type_workday'] == 2) echo "selected";?>>Mixta</option>
                                                <option value="3" <?php if($details['type_workday'] == 3) echo "selected";?>>No sujeto a limitaciones</option>
                                                <option value="4" <?php if($details['type_workday'] == 4) echo "selected";?>>Nocturan</option>
                                                <option value="5" <?php if($details['type_workday'] == 5) echo "selected";?>>Tiempo parcial</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-4">
                                            <label for="simpleinput">Tipo de pago<span style="color:red">*</span></label>
                                            <select class="form-control" name="payment_type">
                                                <option value="1" <?php if($details['payment_type'] == 1) echo "selected";?>>Mensual</option>
                                                <option value="2" <?php if($details['payment_type'] == 2) echo "selected";?>>Quincenal</option>
                                                <option value="3" <?php if($details['payment_type'] == 3) echo "selected";?>>Semanal</option>
                                                <option value="4" <?php if($details['payment_type'] == 4) echo "selected";?>>Diario</option>
                                                <option value="5" <?php if($details['payment_type'] == 5) echo "selected";?>>Destajo</option>
                                                <option value="6" <?php if($details['payment_type'] == 6) echo "selected";?>>Hoja</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-4">
                                            <label for="simpleinput">Tiempo de plazo laboral<span style="color:red">*</span></label>
                                            <select class="form-control" name="work_time">
                                                <option value="1" <?php if($details['work_time'] == 1) echo "selected";?>>Indefinido</option>
                                                <option value="2" <?php if($details['work_time'] == 2) echo "selected";?>>Definido</option>
                                                <option value="3" <?php if($details['work_time'] == 3) echo "selected";?>>Por obra determinada</option>
                                                <option value="4" <?php if($details['work_time'] == 4) echo "selected";?>>Aprendiz</option>
                                                <option value="5" <?php if($details['work_time'] == 5) echo "selected";?>>Destajo</option>
                                                <option value="6" <?php if($details['work_time'] == 6) echo "selected";?>>Hoja</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group date-time-picker m-b-15">
                                                <label for="simpleinvput">Fecha de fin laboral</label>
                                                <div class="input-group date datepicker" id="DoctorPicker4">
                                                    <input type="text" id="applyDate" name="date_work_end" autocomplete="off" style="border: 1px solid #198cff8f;" value="<?php echo $details['date_work_end'];?>" class="form-control">
                                                    <span style="display: none;" class="input-group-addon"><i data-feather="calendar"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 mb-2">
                                <div class="tasks-section" style="background: #fff; padding: 24px; border-radius: 25px; border: 1px solid #ccc;">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <h6>Documentos</h6>
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
                                                <button class="btn btn-primary">Aplicar cambios</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
            <div class="col-sm-4">
                <!--<br>
                <h5 class="panel-content-title" style="font-weight:100">Servicios que usas para iniciar sesión en Medicaby.</h5>
                <span class="app-divider2"></span>
                <div class="support-ticket  <?php echo $details['gm_id'] == '' ? '':'active'; ?>" id="google">
                    <div class="st-body">
                        <div class="avatar">
                            <img src="<?php echo base_url();?>public/assets/theme/images/google.png" style="width: 40px;">
                        </div>
                        <div class="ticket-content">
                            <div class="ticket-description">
                                <div class="os-progress-bar primary">
                                    <div class="bar-labels">
                                        <div class="bar-label-left">
                                            <span class="bigger"><b>Google</b></span>
                                        </div>
                                    </div>
                                    <div class="bar-level-1" style="width: 100%;background:#fff;margin-top: -6px;">
                                        <?php echo $details['gm_id'] == '' ? 'Sin vincular':'Vinculado'; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="support-ticket <?php echo $details['fb_id'] == '' ? '':'active'; ?>">
                    <div class="st-body">
                        <div class="avatar">
                            <img src="<?php echo base_url();?>public/assets/theme/images/fb.png" style="width: 40px;">
                        </div>
                        <div class="ticket-content">
                            <div class="ticket-description">
                                <div class="os-progress-bar primary">
                                    <div class="bar-labels">
                                        <div class="bar-label-left">
                                            <span class="bigger"><b>Facebook</b></span>
                                        </div>
                                    </div>
                                    <div class="bar-level-1" style="width: 100%;background:#fff; margin-top: -6px;">
                                        <?php echo $details['fb_id'] == '' ? 'Sin vincular':'Vinculado'; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>--><br>
                <h5 class="panel-content-title" style="font-weight:100">Documentos:</h5>
                <?php foreach($documents->result_array() as $dc):?>
                <div class="support-ticket" id="ticketDoc_<?php echo $dc['document_id'];?>">
                    <div class="st-body">
                        <div class="avatar">
                            <a href="<?php echo base_url().'public/uploads/staff_documents/'.$dc['name'];?>" target="_blank">
                                <img src="<?php echo base_url();?>public/assets/images/download.png" style="width: 35px; ">
                            </a>
                        </div>
                        <div class="ticket-content">
                            <div class="ticket-description">
                                <div class="os-progress-bar primary">
                                    <div class="bar-labels">
                                        <div class="bar-label-left">
                                            <span class="bigger">
                                                <b>
                                                    <?php if($dc['type'] == "dpi") echo "DPI";
                                                        if($dc['type'] == "contract") echo "Contrato laboral";
                                                        if($dc['type'] == "rtu") echo "RTU";
                                                        if($dc['type'] == "health") echo "Constancia de salud";
                                                        if($dc['type'] == "criminal") echo "Antecedentes penales";
                                                        if($dc['type'] == "police") echo "Antecedentes policiales";
                                                        if($dc['type'] == "receipt") echo "Recibo de agua/luz";
                                                        if($dc['type'] == "employment") echo "Constancia laboral";
                                                        if($dc['type'] == "recommend") echo "Cartas de recomendaciones";
                                                        if($dc['type'] == "renas") echo "Constancia renas";
                                                        if($dc['type'] == "academic") echo "Título académico";?>
                                                </b>
                                            </span>
                                        </div>
                                    </div>
                                    <?php if($dc['expiration'] != ''):?>
                                    <div class="bar-level-1 <?php if (strtotime($dc['expiration']) <= strtotime(date("Y-m-d"))) echo "text-danger";?>" style="width: 100%;background:#fff; margin-top: -6px;">
                                        Vencimiento: <?php echo date("d/m/Y", strtotime($dc['expiration'])); ?>
                                    </div>
                                    <?php endif;?>
                                </div>
                            </div>
                        </div>
                        <div style="float: right;">
                            &nbsp;
                            &nbsp;
                            <a class="btn btn-danger" href="javascript:void(0)" onclick="deactivateDocument('<?php echo $dc['document_id'];?>')" id="deleteDoc_<?php echo $dc['document_id'];?>">
                                <i class="mdi mdi-delete"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <?php endforeach;?>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    <?php if($details['facebook'] == ''):?>
    $('#fb').hide();
    <?php endif;?>
    <?php if($details['instagram'] == ''):?>
    $('#Ig').hide();
    <?php endif;?>
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
<script src="<?php echo base_url();?>public/assets/back/js/jquery-3.1.1.min.js"></script>
<script src="<?php echo base_url();?>public/assets/theme/input/jquery.fileuploader.min.js" type="text/javascript"></script>
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
        if ($('#DoctorPicker1').length) {
            var date = new Date();
            var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
            $('#DoctorPicker1').datepicker({
                format: "dd/mm/yyyy",
                todayHighlight: true,
                autoclose: true
            });
        }
    });
    
    
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

<!--<div id="main-content">
	    <div class="row">

		    <div class="col-sm-4">

		        <div class="card-box">
					<div class="row">
					    <div class="col-sm-12 m-b-30 row">
                             
                                <div class="col-md-4">
                                    <input style="display:none" id="fpassword" name="titulo" autocomplete="off" type="password" onkeyup="validatePass()" placeholder="Nueva contraseña" class="form-control" required>
                                </div>

                                <div class="col-md-4">
                                    <span id="errorm"></span>
                                    <input style="display:none" id="spassword" name="titulo" autocomplete="off" type="password" onkeyup="validatePass()" placeholder="Repetir contraseña" class="form-control" required>
                                </div>
                            
					        <button style="display:none" class="btn btn-success" id="btnpassword" disabled onclick="changePass()" >Cambiar contraseña</button>
					    </div>

					
					</div>
				</div>
		    </div>
	    </div>
	</div>-->
<?php endforeach;?>
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
    
    function changePass() {
        Swal.fire({
            title: 'Confirmar esta acción',
            text: "Se enviará un correo al paciente con la información de la cita. ¿Seguro deseas continuar?",
            type: 'info',
            showCancelButton: true,
            confirmButtonColor: '#9fd13b',
            cancelButtonColor: '#fd4f57',
            confirmButtonText: 'Enviar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: "<?php echo base_url();?>doctor/password_change_pass",
                    type: 'POST',
                    data: {
                        'id': <?php echo base64_decode($id_);?>,
                        'pass': $('#spassword').val()
                    },
                    success: function(data) {
    
                        if (data = 'success') {
                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'top-right',
                                showConfirmButton: false,
                                timer: 5000
                            });
                            Toast.fire({
                                type: 'success',
                                title: 'cambiado correctamente'
                            });
    
                            $('#fpassword').hide(500);
                            $('#spassword').hide(500);
                            $('#btnpassword').hide(500);
    
                            $('#fpassword').val('');
                            $('#spassword').val('');
    
                            bool = false;
    
                        } else {
                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'top-right',
                                showConfirmButton: false,
                                timer: 5000
                            });
                            Toast.fire({
                                type: 'error',
                                title: data
                            })
                        }
    
                    },
                    error: function(data) {
                        /*
                         * Se ejecuta si la peticón ha sido erronea
                         * */
                        alert("Problemas al tratar de enviar el formulario");
                    }
                });
            }
        });
    }
    
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
    
    function deactivateDocument(id) {
        Swal.fire({
            title: '¿Estás seguro de eliminar el documento?',
            text: "¡No podrás deshacer esta acción!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Eliminar',
            cancelButtonText: 'Cancelar',
            padding: '2em'
        }).then(function(result) {
            console.log(result);
            if (result.value) {
                $("#deleteDoc_"+id).prop("disabled", true);
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url();?>doctor/deactivate_document/"+id,
                    success: function (response) {
                        console.log(response);
                        if (response) {
                            $("#ticketDoc_"+id).fadeOut("normal", function() {
                                $(this).remove();
                            });
                        } else {
                            $("#deleteDoc_"+id).prop("disabled", false);
                        }
                    }, 
                    error: function (e) {
                        console.log("Error: ", e);
                        $("#deleteDoc_"+id).prop("disabled", false);
                    }
                });
            }
        });
    }
    
    $("#form").submit(function(e) {
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
                location.reload();
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
</script>