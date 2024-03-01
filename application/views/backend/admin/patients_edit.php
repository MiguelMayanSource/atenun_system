<?php 
    $patient_id = base64_decode($patient_id);
    $patient = $this->db->get_where('patient', array('patient_id' => $patient_id))->result_array();
    foreach($patient as $details):
?>
<div class="todo-app-w">
    <form action="<?php echo base_url();?>admin/patients/update/<?php echo $details['patient_id']?>" method="POST" enctype="multipart/form-data" >
        <div class="todo-content conts">
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
                                                <div id="imagePreview" style="background-image: url(<?php echo $this->accounts_model->get_photo('patient', $patient_id);?>);">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group m-b-15">
                                            <label for="simpleinput">Primer Nombre<span style="color:red">*</span></label>
                                            <input style="border: 1px solid #198cff8f;" type="text" name="first_name" id="first_name" required="" class="form-control required_0" value="<?php echo $details['first_name'];?>">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group m-b-15">
                                            <label for="simpleinput">Segundo Nombre</label>
                                            <input style="border: 1px solid #198cff8f;" type="text" name="second_name" class="form-control" value="<?php echo $details['second_name'];?>">
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group m-b-15">
                                            <label for="simpleinput">Tercer Nombre</label>
                                            <input style="border: 1px solid #198cff8f;" type="text" name="third_name" class="form-control" value="<?php echo $details['third_name'];?>">
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group m-b-15">
                                            <label for="simpleinput">Primer Apellido<span style="color:red">*</span></label>
                                            <input style="border: 1px solid #198cff8f;" type="text" name="last_name" id="last_name" required="" class="form-control required_0" value="<?php echo $details['last_name'];?>">
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group m-b-15">
                                            <label for="simpleinput">Segundo Apellido</label>
                                            <input style="border: 1px solid #198cff8f;" type="text" name="second_last_name" class="form-control" value="<?php echo $details['second_last_name'];?>">
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group m-b-15">
                                            <label for="simpleinput">Apellido de casada</label>
                                            <input style="border: 1px solid #198cff8f;" type="text" name="married_last_name" class="form-control" value="<?php echo $details['married_last_name'];?>">
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group m-b-15">
                                            <label for="simpleinput">Celular<span style="color:red">*</span></label>
                                            <input style="border: 1px solid #198cff8f;" type="tel" name="phone" id="phone" required="" maxlength="11" class="form-control required_0" value="<?php echo $details['phone'];?>">
                                            <small>*</small>
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="form-group m-b-15">
                                            <label for="simpleinput">Teléfono</label>
                                            <input style="border: 1px solid #198cff8f;" type="tel" name="phone_contact" class="form-control" maxlength="8" value="<?php echo $details['phone_contact'];?>">
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group m-b-15">
                                            <label for="simpleinput">Email</label>
                                            <input style="border: 1px solid #198cff8f;" type="email" name="email" id="email" class="form-control required_0" value="<?php echo $details['email'];?>">
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group date-time-picker m-b-15">
                                            <label for="simpleinvput">Fecha de Nacimiento<span style="color:red">*</span></label>
                                            <div class="input-group date datepicker" id="DoctorPicker1">
                                                <input onchange="patientInCharge(this.value)" type="text" id="applyDate" required="true" name="date_of_birth" required="" autocomplete="off" style="border: 1px solid #198cff8f;" class="form-control required_0" value="<?php echo $details['date_of_birth'];?>">
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
                                                    <option value="">Agregar Nuevo</option>
                                                    <?php 
                                                        $patient = $this->db->get_where('patient',array('status'=>1))->result_array();
                                                        foreach($patient as $rs):
                                                        ?>
                                                    <option value="<?php echo $rs['patient_id'];?>" <?php if($rs['patient_id'] == $details['responsable_id']){echo 'selected';}?>><?php echo $rs['first_name'].' '.$rs['second_name'].' '.$rs['last_name'].' '.$rs['second_last_name'];?></option>
                                                    <?php endforeach;?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 dpi " style="display:none">
                                        <div class="form-group m-b-15">
                                            <label for="simpleinput">Identificación<span style="color:red">*</span></label>
                                            <span class="" id="errordpi"></span>
                                            <input style="border: 1px solid #198cff8f;" type="number" name="dpi" id="dpi" onkeyup="validateDPI(this.value, '');" class="form-control" value="<?php echo $details['dpi'];?>">
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group m-b-15">
                                            <label for="simpleinput">Nacionalidad<span style="color:red">*</span></label>
                                            <input style="border: 1px solid #198cff8f;" type="text" name="nationality" id="nationality" required="" class="form-control required_0" value="<?php echo $details['nationality'];?>">
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group m-b-15">
                                            <label for="simpleinput">Ocupación</label>
                                            <input style="border: 1px solid #198cff8f;" type="text" name="profession" class="form-control" value="<?php echo $details['profession'];?>">
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="form-group m-b-15">
                                            <label for="simpleinput">Lugar de Trabajo</label>
                                            <input style="border: 1px solid #198cff8f;" type="text" name="workplace" class="form-control" value="<?php echo $details['workplace'];?>">
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group m-b-15">
                                            <label for="simpleinput">Seguro <span style="color:red">*</span></label><br>
                                            <select class="itemName form-control select2 " style="border: 1px solid #198cff8f;" id="insurances_1" style="width:100%" name="insurances[]" multiple>
                                                <option value="">Seleccionar</option>
                                                <?php 
                                                $insurances = $this->db->query('SELECT i.insurance_id,i.name,(SELECT count(*) FROM insurance_patients ps where ps.patient_id = '.$details['patient_id'].' and ps.insurance_id = i.insurance_id ) AS NumAsignaciones FROM insurance i')->result_array();
                                                foreach($insurances as $in):
                                            ?>
                                                <option value="<?php echo $in['insurance_id'];?>" <?php echo $in['NumAsignaciones']==1?'selected':'';?>><?php echo $in['name'];?></option>
                                                <?php endforeach;?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group m-b-15">
                                            <label for="simpleinput">Entidad <span style="color:red">*</span></label><br>

                                            <select class="itemName form-control select2 " style="border: 1px solid #198cff8f;" id="entity_id" style="width:100%" name="entity_id[]" multiple>
                                                <?php                                                
                                                $insurancess = $this->db->query('SELECT i.entity_id,i.first_name,(SELECT count(*) FROM entity_patients ps where ps.patient_id = '.$details['patient_id'].' and ps.entity_id = i.entity_id ) AS NumAsignaciones FROM entity i')->result_array();
                                                foreach($insurancess as $in): ?>

                                                <option value="<?php echo $in['entity_id'];?>" <?php echo $in['NumAsignaciones']==1?'selected':'';?> ><?php echo $in['first_name'];?></option>
                                                <?php endforeach;?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>Estado civil</label>
                                            <div class="input-group">
                                                <div class="form-check" style="padding-left: 0px;padding-right: 8px;">
                                                    <input class="radiobutton" type="radio" name="marital_status" id="single1" value="0" <?php echo $details['marital_status']== 0 ?'checked':'';?>><label class="radiobutton-label" for="single1">Soltero</label>
                                                </div>
                                                <div class="form-check" style="padding-left: 0px;">
                                                    <input class="radiobutton" type="radio" name="marital_status" id="maried1" value="1" <?php echo $details['marital_status']== 1 ?'checked':'';?>><label class="radiobutton-label" for="maried1">Casado</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Sexo:</label>
                                            <div class="input-group">
                                                <div class="form-check" style="padding-left: 0px;padding-right: 8px;">
                                                    <input class="radiobutton" type="radio" name="gender" id="radio3" value="M" <?php echo $details['gender']=='M'?'checked':'';?>><label class="radiobutton-label" for="radio3">Masculino</label>
                                                </div>
                                                <div class="form-check" style="padding-left: 0px;">
                                                    <input class="radiobutton" type="radio" name="gender" id="radio4" value="F" <?php echo $details['gender']=='F'?'checked':'';?>><label class="radiobutton-label" for="radio4">Femenino</label>
                                                </div>
                                                <div class="form-check" style="">
                                                    <input class="radiobutton" type="radio" name="gender" id="radio5" value="O" <?php echo $details['gender']=='O'?'checked':'';?>><label class="radiobutton-label" for="radio5">Otros</label>
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
                                            <textarea type="text" style="border: 1px solid #198cff8f;" rows="3" name="address" required="" class="form-control"><?php echo $details['address']; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="card">Departamento <span style="color:red;">*</span></label>
                                            <div class="input-group">
                                                <select name="dpto" class="form-control" onchange="get_depto(this.value, '1');">
                                                    <option value="">Seleccionar</option>
                                                    <?php 
                                                    $deptos = $this->db->get('departamento')->result_array();
                                                    foreach($deptos as $rs):
                                                    ?>
                                                    <option value="<?php echo $rs['departamento_id'];?>" <?php echo $details['dpto']==$rs['departamento_id']?'selected':'';?>><?php echo $rs['name'];?></option>
                                                    <?php endforeach;?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group m-b-15">
                                            <label>Municipio</label> <span style="color:red;">*</span>
                                            <select class="form-control" name="muni" id="selector_coleccion_1">
                                                <option value="">Seleccionar</option>
                                                <?php 
                                                    $munis = $this->db->where('departamento_id', $details['dpto'])->get('municipio')->result_array();
                                                    foreach($munis as $rs):
                                                    ?>
                                                <option value="<?php echo $rs['id'];?>" <?php echo $details['muni']==$rs['id']?'selected':'';?>><?php echo $rs['name'];?></option>
                                                <?php endforeach;?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group m-b-15">
                                            <label for="simpleinput">Ciudad</label>
                                            <input style="border: 1px solid #198cff8f;" type="text" name="city" class="form-control" value="<?php echo $details['city']; ?>">
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group m-b-15">
                                            <label for="simpleinput">Código Postal</label>
                                            <input style="border: 1px solid #198cff8f;" type="text" name="postal_code" class="form-control" value="<?php echo $details['postal_code']; ?>">
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

                                            <input style="border: 1px solid #198cff8f;" type="text" name="name_nit_1" class="form-control" value="<?php echo $details['name_nit_1']; ?>">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group m-b-15">
                                            <label for="simpleinput">NIT</label>

                                            <input style="border: 1px solid #198cff8f;" type="number" name="nit_1" class="form-control" value="<?php echo $details['nit_1']; ?>">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group m-b-15">
                                            <label for="simpleinput">Dirección</label>

                                            <input style="border: 1px solid #198cff8f;" type="text" name="address_nit_1" class="form-control" value="<?php echo $details['address_nit_1']; ?>">
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <h6>NIT 2</h6>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group m-b-15">
                                            <label for="simpleinput">Nombre</label>

                                            <input style="border: 1px solid #198cff8f;" type="text" name="name_nit_2" class="form-control" value="<?php echo $details['name_nit_2']; ?>">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group m-b-15">
                                            <label for="simpleinput">NIT</label>

                                            <input style="border: 1px solid #198cff8f;" type="number" name="nit_2" class="form-control" value="<?php echo $details['nit_2']; ?>">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group m-b-15">
                                            <label for="simpleinput">Dirección</label>

                                            <input style="border: 1px solid #198cff8f;" type="text" name="address_nit_2" class="form-control" value="<?php echo $details['address_nit_2']; ?>">
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <h6>NIT 3</h6>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group m-b-15">
                                            <label for="simpleinput">Nombre</label>

                                            <input style="border: 1px solid #198cff8f;" type="text" name="name_nit_3" class="form-control" value="<?php echo $details['name_nit_3']; ?>">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group m-b-15">
                                            <label for="simpleinput">NIT</label>

                                            <input style="border: 1px solid #198cff8f;" type="number" name="nit_3" class="form-control" value="<?php echo $details['nit_3']; ?>">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group m-b-15">
                                            <label for="simpleinput">Dirección</label>

                                            <input style="border: 1px solid #198cff8f;" type="text" name="address_nit_3" class="form-control" value="<?php echo $details['address_nit_3']; ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php if($details['responsable_id'] != ''):
                $responsable = $this->db->get_where('patient', array('patient_id' => $details['responsable_id']))->result_array();
                foreach($responsable as $rdetails):
                ?>

            <div class="in_charge" style="display:<?php echo ($details['responsable_id'] != '') ? 'block' : 'none';?>">
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
                                                    <input type='file' name="photo_rep" id="imageUpload2" accept=".png, .jpg, .jpeg" />
                                                    <label for="imageUpload2"></label>
                                                </div>
                                                <div class="avatar-preview" style="border: 2px solid #198cff8f;">
                                                    <div id="imagePreview2" style="background-image: url(<?php echo $this->accounts_model->get_photo('patient', $rdetails['patient_id']);?>);">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Primer Nombre<span style="color:red">*</span></label>
                                                <input style="border: 1px solid #198cff8f;" type="text" name="first_name_rep" class="form-control" value="<?php echo $rdetails['first_name'];?>">
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Segundo Nombre</label>
                                                <input style="border: 1px solid #198cff8f;" type="text" name="second_name_rep" class="form-control" value="<?php echo $rdetails['second_name'];?>">
                                            </div>
                                        </div>

                                        <div class="col-sm-4">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Tercer Nombre</label>
                                                <input style="border: 1px solid #198cff8f;" type="text" name="third_name_rep" class="form-control" value="<?php echo $rdetails['third_name'];?>">
                                            </div>
                                        </div>

                                        <div class="col-sm-4">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Primer Apellido<span style="color:red">*</span></label>
                                                <input style="border: 1px solid #198cff8f;" type="text" name="last_name_rep" class="form-control" value="<?php echo $rdetails['last_name'];?>">
                                            </div>
                                        </div>

                                        <div class="col-sm-4">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Segundo Apellido</label>
                                                <input style="border: 1px solid #198cff8f;" type="text" name="second_last_name_rep" class="form-control" value="<?php echo $rdetails['second_last_name'];?>">
                                            </div>
                                        </div>

                                        <div class="col-sm-4">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Apellido de casada</label>
                                                <input style="border: 1px solid #198cff8f;" type="text" name="married_last_name_rep" class="form-control" value="<?php echo $rdetails['married_last_name'];?>">
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Celular<span style="color:red">*</span></label>
                                                <input style="border: 1px solid #198cff8f;" type="tel" name="phone_rep" maxlength="11" class="form-control" value="<?php echo $rdetails['phone'];?>">
                                                <small>* Ingresar código de área p.j: 502xxxxxxxx</small>
                                            </div>
                                        </div>

                                        <div class="col-sm-3">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Teléfono</label>
                                                <input style="border: 1px solid #198cff8f;" type="tel" name="phone_contact_rep" class="form-control" maxlength="8" value="<?php echo $rdetails['phone_contact'];?>">
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group date-time-picker m-b-15">
                                                <label for="simpleinvput">Fecha de Nacimiento<span style="color:red">*</span></label>
                                                <div class="input-group date datepicker" id="DoctorPicker1">
                                                    <input type="text" id="applyDate" name="date_of_birth_rep" id="date_of_birth_rep" autocomplete="off" style="border: 1px solid #198cff8f;" class="form-control" value="<?php echo $rdetails['date_of_birth'];?>">
                                                    <span style="display: none;" class="input-group-addon"><i data-feather="calendar"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-3  ">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Identificación<span style="color:red">*</span></label>
                                                <span class="" id="errordpi_rep"></span>
                                                <input style="border: 1px solid #198cff8f;" type="number" name="dpi_rep" id="dpi_rep" onkeyup="validateDPI(this.value, '_rep');" class="form-control " value="<?php echo $rdetails['dpi'];?>">
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Nacionalidad<span style="color:red">*</span></label>
                                                <input style="border: 1px solid #198cff8f;" type="text" name="nationality_rep" class="form-control" value="<?php echo $rdetails['nationality'];?>">
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Ocupación<span style="color:red">*</span></label>
                                                <input style="border: 1px solid #198cff8f;" type="text" name="profession_rep" class="form-control" value="<?php echo $rdetails['profession'];?>">
                                            </div>
                                        </div>

                                        <div class="col-sm-3">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Lugar de Trabajo</label>
                                                <input style="border: 1px solid #198cff8f;" type="tel" name="workplace_rep" class="form-control" value="<?php echo $rdetails['workplace'];?>">
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Seguro <span style="color:red">*</span></label><br>
                                                <select class="  select22" style="border: 1px solid #198cff8f;" style="width:100px" name="insurances_rep[]" multiple>
                                                    <option value="">Seleccionar</option>
                                                    <?php 
                                                            $insurances = $this->db->query('SELECT i.insurance_id,i.name,(SELECT count(*) FROM insurance_patients ps where ps.patient_id = '.$rdetails['patient_id'].' and ps.insurance_id = i.insurance_id ) AS NumAsignaciones FROM insurance i')->result_array();
                                                            foreach($insurances as $in):
                                                        ?>
                                                    <option value="<?php echo $in['insurance_id'];?>" <?php echo $in['NumAsignaciones']==1?'selected':'';?>><?php echo $in['name'];?></option>
                                                    <?php endforeach;?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label>Estado civil</label>
                                                <div class="input-group">
                                                    <div class="form-check" style="padding-left: 0px;padding-right: 8px;">
                                                        <input <?php echo $rdetails['marital_status'] == '0' ? 'checked' : '';?> class="radiobutton" type="radio" name="marital_status_rep" id="single1_rep" value="0"><label class="radiobutton-label" for="single1_rep">Soltero</label>
                                                    </div>
                                                    <div class="form-check" style="padding-left: 0px;">
                                                        <input <?php echo $rdetails['marital_status'] == '1' ? 'checked' : '';?> class="radiobutton" type="radio" name="marital_status_rep" id="maried1_rep" value="1"><label class="radiobutton-label" for="maried1_rep">Casado</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Sexo:</label>
                                                <div class="input-group">
                                                    <div class="form-check" style="padding-left: 0px;padding-right: 8px;">
                                                        <input <?php echo $rdetails['gender'] == 'M' ? 'checked' : '';?> class="radiobutton" type="radio" name="gender_rep" id="radio3_rep" value="M"><label class="radiobutton-label" for="radio3_rep">Masculino</label>
                                                    </div>
                                                    <div class="form-check" style="padding-left: 0px;">
                                                        <input <?php echo $rdetails['gender'] == 'F' ? 'checked' : '';?> class="radiobutton" type="radio" name="gender_rep" id="radio4_rep" value="F"><label class="radiobutton-label" for="radio4_rep">Femenino</label>
                                                    </div>
                                                    <div class="form-check" style="">
                                                        <input <?php echo $rdetails['gender'] == 'O' ? 'checked' : '';?> class="radiobutton" type="radio" name="gender_rep" id="radio5_rep" value="O"><label class="radiobutton-label" for="radio5_rep">Otros</label>
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
                                                <textarea type="text" style="border: 1px solid #198cff8f;" rows="3" name="address_rep" class="form-control"><?php echo $rdetails['address'] ?></textarea>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="card">Departamento</label>
                                                <div class="input-group">
                                                    <select name="dpto_rep" class="form-control" onchange="get_depto(this.value, '2');">
                                                        <option value="">Seleccionar</option>
                                                        <?php 
                                                        $deptos = $this->db->get('departamento')->result_array();
                                                        foreach($deptos as $rs):
                                                        ?>
                                                        <option value="<?php echo $rs['departamento_id'];?>" <?php echo $rdetails['dpto']==$rs['departamento_id']?'selected':'';?>><?php echo $rs['name'];?></option>
                                                        <?php endforeach;?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group m-b-15">
                                                <label>Municipio</label> <span style="color:red;">*</span>
                                                <select class="form-control " name="muni_rep" id="selector_coleccion_2">
                                                    <option>Seleccionar</option>
                                                    <?php 
                                                    $munis = $this->db->where('departamento_id', $rdetails['dpto'])->get('municipio')->result_array();
                                                    foreach($munis as $rs):
                                                    ?>
                                                    <option value="<?php echo $rs['id'];?>" <?php echo $rdetails['muni']==$rs['id']?'selected':'';?>><?php echo $rs['name'];?></option>
                                                    <?php endforeach;?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Ciudad</label>
                                                <input style="border: 1px solid #198cff8f;" type="text" name="city_rep" class="form-control" value="<?php echo $rdetails['city'];?>">
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Código Postal</label>
                                                <input style="border: 1px solid #198cff8f;" type="text" name="postal_code_rep" class="form-control" value="<?php echo $rdetails['postal_code'];?>">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Número de nacional</label>

                                                <input style="border: 1px solid #198cff8f;" type="number" name="n_nacional_rep" class="form-control" value="<?php echo $rdetails['n_nacional'];?>">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Número de extranjero</label>

                                                <input style="border: 1px solid #198cff8f;" type="number" name="n_extranjero_rep" class="form-control" value="<?php echo $rdetails['n_extranjero'];?>">
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

                                                <input style="border: 1px solid #198cff8f;" type="text" name="name_nit_1_rep" class="form-control" value="<?php echo $rdetails['name_nit_1'];?>">
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">NIT</label>

                                                <input style="border: 1px solid #198cff8f;" type="number" name="nit_1_rep" class="form-control" value="<?php echo $rdetails['nit_1'];?>">
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Dirección</label>

                                                <input style="border: 1px solid #198cff8f;" type="text" name="address_nit_1_rep" class="form-control" value="<?php echo $rdetails['address_nit_1'];?>">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <h6>NIT 2</h6>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Nombre</label>

                                                <input style="border: 1px solid #198cff8f;" type="text" name="name_nit_2_rep" class="form-control" value="<?php echo $rdetails['name_nit_2'];?>">
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">NIT</label>

                                                <input style="border: 1px solid #198cff8f;" type="number" name="nit_2_rep" class="form-control" value="<?php echo $rdetails['nit_2'];?>">
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Dirección</label>

                                                <input style="border: 1px solid #198cff8f;" type="text" name="address_nit_2_rep" class="form-control" value="<?php echo $rdetails['address_nit_2'];?>">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <h6>NIT 3</h6>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Nombre</label>

                                                <input style="border: 1px solid #198cff8f;" type="text" name="name_nit_3_rep" class="form-control" value="<?php echo $rdetails['name_nit_3'];?>">
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">NIT</label>

                                                <input style="border: 1px solid #198cff8f;" type="number" name="nit_3_rep" class="form-control" value="<?php echo $rdetails['nit_3'];?>">
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Dirección</label>

                                                <input style="border: 1px solid #198cff8f;" type="text" name="address_nit_3_rep" class="form-control" value="<?php echo $rdetails['address_nit_3'];?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; endif; ?>
            <div style="z-index: 9999;position: fixed; bottom: 10px;right: 10px;" class="floated-customizer-btn third-floated-btn">
                <button type="submit" class="btn" style="color:white;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 16 16">
                        <path fill="currentColor" d="M5 2v2.5A1.5 1.5 0 0 0 6.5 6h2A1.5 1.5 0 0 0 10 4.5V2h.379a2 2 0 0 1 1.414.586l1.621 1.621A2 2 0 0 1 14 5.621V12a2 2 0 0 1-2 2V9.5A1.5 1.5 0 0 0 10.5 8h-5C4.673 8 4 8.669 4 9.498V14a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h1Zm1 0v2.5a.5.5 0 0 0 .5.5h2a.5.5 0 0 0 .5-.5V2H6ZM5 14h6V9.5a.5.5 0 0 0-.5-.5h-5c-.277 0-.5.223-.5.498V14Z" />
                    </svg>
                </button>
            </div>
        </div>
    </form>
</div>
<script src="<?php echo base_url();?>public/assets/back/js/jquery-3.1.1.min.js"></script>
<script src="<?php echo base_url();?>public/assets/theme/js/sticky-sidebar.js"></script>
<script src="<?php echo base_url();?>public/assets/theme/js/jquery.sticky.js"></script>
<script src="<?php echo base_url();?>public/assets/theme/js/PositionSticky/dist/PositionSticky.js"></script>
<link href="<?php echo base_url();?>public/assets/appointments/css/select2.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
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

function readURL2(input) {
    console.log('readurl2')
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#imagePreview2').css('background-image', 'url(' + e.target.result + ')');
            $('#imagePreview2').hide();
            $('#imagePreview2').fadeIn(650);
        }
        reader.readAsDataURL(input.files[0]);
    }
}
$("#imageUpload2").change(function() {
    readURL2(this);
});
$(function() {
    'use strict';
    $('.itemName').select2();
    $('.select22').select2();
    $("#applyDate").trigger("change");
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
$('.ae-side-menu-toggler').on('click', function() {
    $('.app-side').toggleClass('compact-side-menu');
});
if ($('.app-side').length) {
    if (is_display_type('phone') || is_display_type('tablet')) {
        $('.app-side').addClass('compact-side-menu');
    }
}
//Validar correo electronico  
function validateEXP(exp) {
    console.log(exp);
    $.ajax({
        type: "POST",
        url: "<?php echo base_url();?>admin/check_patient_exp",
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

function get_depto(coleccion, inx) {
    $.ajax({
        url: '<?php echo base_url(); ?>admin/get_municipio/' + coleccion,
        success: function(response) {
            jQuery('#selector_coleccion_' + inx).html(response);
        }
    });
}

</script>
<?php endforeach; ?>