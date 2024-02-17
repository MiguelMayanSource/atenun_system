<?php 
    $admin_id = $id_;  
    $documents = $this->db->get_where('document', array('user_id'=>$admin_id, 'user_type'=>'admin', 'status'=>1));
    $deptos = $this->db->get('departamento');
    $roles = $this->db->get_where('role', array('status'=>1)); 
    $this->db->where('admin_id', $admin_id);
    $info = $this->db->get('admin')->result_array(); 
    foreach($info as $details): 
        $owner = $this->crud_model->account_owner();
        $muns = $this->db->get_where('municipio', array('departamento_id'=>$details['departamento_id']));
?>
<link href="<?php echo base_url();?>public/assets/appointments/css/select2.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<div class="todo-app-w">
    <div class="todo-sidebar">
        <div id="sticky">
            <div class="todo-sidebar-section" style="border-bottom:0px">
                <div class="todo-sidebar-section-contents">
                    <ul class="tasks-list">
                        <li class="side-li">
                            <a class="side-items active" href="<?php echo base_url();?>doctor/admin_profile/<?php echo base64_encode($details['admin_id']);?>/"><i style="padding-right: 10px;    font-size: 22px;" class="picons-thin-icon-thin-0002_write_pencil_new_edit"></i> <?php if($owner == 1):?> Editar perfil <?php else:?> Ver
                                perfil<?php endif;?> <span class="side-active"></span></a>
                        </li>
                        <li class="side-li">
                            <a class="side-items" href="<?php echo base_url();?>doctor/notifications/<?php echo base64_encode($details['admin_id']);?>/"><i style="padding-right: 10px;font-size: 22px;" class="picons-thin-icon-thin-0543_world_earth_worldwide_location_travel"></i> Notificaciones </a>
                        </li>
                        <li class="side-li">
                            <a class="side-items" href="<?php echo base_url();?>doctor/admin_security/<?php echo base64_encode($details['admin_id']);?>/"><i style="padding-right: 10px;font-size: 22px;" class="picons-thin-icon-thin-0705_user_profile_security_password_permissions"></i> Contraseña y seguridad </a>
                        </li>
                        <li class="side-li">
                            <a class="side-items" href="<?php echo base_url();?>doctor/admin_activity/<?php echo base64_encode($details['admin_id']);?>/"><i style="padding-right: 10px;font-size: 22px;" class="picons-thin-icon-thin-0244_text_bullets_list"></i> Registro de Actividad </a>
                        </li>
                    </ul>
                    <div class="text-center account-container"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="todo-content" style="margin-bottom: 10%;">
        <h4 class="todo-content-header">
            <?php if($owner == 1):?>
            <i class="batch-icon-arrow-right"></i><span>Editar perfil - <?php echo $this->accounts_model->get_name('admin',$details['admin_id']);?></span>
            <?php else:?>
            <i class="batch-icon-arrow-right"></i><span>Perfil de doctor - <?php echo $this->accounts_model->get_name('admin',$details['admin_id']);?></span>
            <?php endif;?>
        </h4>
        <div class="row">
            <div class="col-sm-12">
                <?php if($owner == 1):?>
                <div class="alert alert-info">
                    <span class="alert-title"><i class="batch-icon-spam"></i> Mantén actualizados los datos.</span>
                    <span class="alert-content">Recuerda siempre mantener todos los datos actualizados en esta sección, si no estám actualizados es posible que no se envíen notificaciones o se tengan problemas de comunicación con <span class="alert-lined"><a href="javascript:void(0);" style="color:#0044e9">Medicaby</a>.</span></span>
                </div>
                <?php endif;?>
            </div>
            <div class="col-sm-8">
                <div class="tasks-section">
                    <form action="<?php echo base_url();?>doctor/doctors/edit/<?php echo $details['admin_id'];?>" method="POST" id="doctorUpdate" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-sm-12 mb-2">
                                <div class="tasks-section" style="background: #fff; padding: 24px; border-radius: 25px; border: 1px solid #ccc;">
                                    <div class="row">
                                        <div class="col-sm-12 ">
                                            <div class="avatar-upload">
                                                <?php if($owner == 1):?>
                                                <div class="avatar-edit">
                                                    <input type='file' name="photo" id="imageUpload" accept=".png, .jpg, .jpeg" />
                                                    <label for="imageUpload"></label>
                                                </div>
                                                <?php endif;?>
                                                <div class="avatar-preview" style="border: 2px solid #198cff8f;">
                                                    <div id="imagePreview" style="background-image: url(<?php echo $this->accounts_model->get_photo('admin', $details['admin_id']);?>);"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Primer Nombre<span style="color:red">*</span></label>
                                                <input style="border: 1px solid #198cff8f;" type="text" name="first_name" value="<?php echo $details['first_name'];?>" required="" class="form-control" <?php if($owner != '1'):?> readonly="" <?php endif;?>>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Segundo Nombre</label>
                                                <input style="border: 1px solid #198cff8f;" type="text" name="second_name" value="<?php echo $details['second_name'];?>" class="form-control" <?php if($owner != '1'):?> readonly="" <?php endif;?>>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Tercer Nombre</label>
                                                <input style="border: 1px solid #198cff8f;" type="text" name="third_name" value="<?php echo $details['third_name'];?>" class="form-control" <?php if($owner != 1):?> readonly <?php endif;?> />
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Primer Apellido<span style="color:red">*</span></label>
                                                <input style="border: 1px solid #198cff8f;" type="text" name="last_name" required="" value="<?php echo $details['last_name'];?>" class="form-control" <?php if($owner != 1):?> readonly="" <?php endif;?>>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Segundo Apellido</label>
                                                <input style="border: 1px solid #198cff8f;" type="text" name="second_last_name" value="<?php echo $details['second_last_name'];?>" class="form-control" <?php if($owner != 1):?> readonly="" <?php endif;?>>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Apellido de casada</label>
                                                <input style="border: 1px solid #198cff8f;" type="text" name="married_last_name" value="<?php echo $details['married_last_name'];?>" class="form-control" <?php if($owner != 1):?> readonly="" <?php endif;?>>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group date-time-picker m-b-15">
                                                <label for="simpleinvput">Nacimiento</label>
                                                <div class="input-group date datepicker" id="DoctorPicker1">
                                                    <input style="border: 1px solid #198cff8f;" type="text" id="applyDate" name="date_of_birth" autocomplete="off" style="border: 1px solid #198cff8f;" value="<?php echo $details['date_of_birth'];?>" class="form-control" <?php if($owner != 1):?> readonly="" <?php endif;?>>
                                                    <span style="display: none;" class="input-group-addon"><i data-feather="calendar"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Identificación<span style="color:red">*</span></label> <span class="" id="errordpi"></span>
                                                <input style="border: 1px solid #198cff8f;" type="text" name="dpi" id="dpi" required="" value="<?php echo $details['dpi']?>" onkeyup="validateDPI(this.value);" class="form-control" <?php if($owner != 1):?> readonly="" <?php endif;?>>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Celular<span style="color:red">*</span></label>
                                                <input style="border: 1px solid #198cff8f;" type="tel" name="phone" value="<?php echo $details['phone']?>" required="" class="form-control" <?php if($owner != 1):?> readonly="" <?php endif;?>>
                                                <small>* Ingresar código de área p.j: 502xxxx-xxxx</small>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Correo<span style="color:red">*</span></label> <span class="" id="errorm"></span>
                                                <input style="border: 1px solid #198cff8f;" type="email" name="email" id="email" required="" value="<?php echo $details['email']?>" onkeyup="validateEmail();" class="form-control" <?php if($owner != 1):?> readonly="" <?php endif;?>>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Estado civil</label>
                                                <div class="input-group">
                                                    <div class="form-check" style="padding-left: 0px; padding-right:1px">
                                                        <input <?php if($details['marital_status'] == 0) echo "checked";?> class="radiobutton" type="radio" name="marital_status" id="single1" value="0" <?php if($owner != 1):?> disabled="" <?php endif;?>><label class="radiobutton-label" for="single1">Soltero</label>
                                                    </div>
                                                    <div class="form-check" style="padding-left: 0px;">
                                                        <input <?php if($details['marital_status'] == 1) echo "checked";?> class="radiobutton" type="radio" name="marital_status" id="maried1" value="1" <?php if($owner != 1):?> disabled="" <?php endif;?>><label class="radiobutton-label" for="maried1">Casado</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Género:</label>
                                                <div class="input-group">
                                                    <div class="form-check" style="padding-left: 0px; padding-right:1px">
                                                        <input <?php if($details['gender'] == 'M') echo "checked";?> class="radiobutton" type="radio" name="gender" id="radio3" value="M" <?php if($owner != 1):?> disabled="" <?php endif;?>><label class="radiobutton-label" for="radio3">Masculino</label>
                                                    </div>
                                                    <div class="form-check" style="padding-left: 0px;">
                                                        <input <?php if($details['gender'] == 'F') echo "checked";?> class="radiobutton" type="radio" name="gender" id="radio4" value="F" <?php if($owner != 1):?> disabled="" <?php endif;?>><label class="radiobutton-label" for="radio4">Femenino</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php if($owner == 1):?>
                                        <div class="col-sm-6">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Salario<span style="color:red">*</span></label>
                                                <input <?php if($owner != 1):?> readonly="" <?php endif;?> style="border: 1px solid #198cff8f;" type="number" value="<?php echo $details['salary']?>" name="salary" class="form-control">
                                            </div>
                                        </div>
                                        <?php endif;?>
                                        <div class="col-sm-<?php if($owner == 1):?>6<?php else:?>12<?php endif;?>">
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
                                        <div class="col-sm-12">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Usuario</label>
                                                <input style="border: 1px solid #198cff8f;" type="text" name="" value="<?php echo $details['username'];?>" class="form-control" readonly="">
                                            </div>
                                        </div>
                                        <?php /* if($owner == 1):?>
                                        <div class="col-sm-6">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Firma</label>
                                                <label class="labelx" for="apply"><input type="file" name="signature" class="inputx" id="apply" accept=".jpg, .png, .jpeg">Seleccionar</label>
                                                <small id="fileResponse"></small>
                                            </div>
                                        </div>
                                        <?php endif; */?>
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
                                                <label for="simpleinput">Dirección</label>
                                                <textarea type="text" style="border: 1px solid #198cff8f;" rows="3" name="address" class="form-control" <?php if($owner != 1):?> readonly="" <?php endif;?>><?php echo $details['address'];?></textarea>
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
                                            <h6>Información académica</h6>
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
                                        <div class="col-sm-6">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Número de Colegiado</label>
                                                <input style="border: 1px solid #198cff8f;" type="text" name="no_college" value="<?php echo $details['no_college']?>" class="form-control" <?php if($owner != 1):?> readonly="" <?php endif;?> />
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
                <h5 class="panel-content-title" style="font-weight:100">Servicios que utilizas para iniciar sesión en Medicaby.</h5>
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
                            <a href="<?php echo base_url().'public/uploads/doctor_documents/'.$dc['name'];?>" target="_blank">
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
$('.itemName').select2();
</script>
<script src="<?php echo base_url();?>public/assets/back/js/jquery-3.1.1.min.js"></script>
<script type="text/javascript">
    /* document.getElementById('apply').onchange = function() {
        var filename = this.value.replace(/C:\\fakepath\\/i, '')
        $("#fileResponse").html('<b>Archivo seleccionado:</b> ' + filename);
    }; */
    
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
<script src="<?php echo base_url();?>public/assets/theme/input/jquery.fileuploader.min.js" type="text/javascript"></script>
<script>
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
    
    $("#doctorUpdate").submit(function(e) {
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
<?php  endforeach; ?>