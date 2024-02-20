<style type="text/css">
    .switch {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 34px;
    }
    
    /* Hide default HTML checkbox */
    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }
    
    /* The slider */
    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        -webkit-transition: .4s;
        transition: .4s;
    }
    
    .slider:before {
        position: absolute;
        content: "";
        height: 26px;
        width: 26px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        -webkit-transition: .4s;
        transition: .4s;
    }
    
    input:checked + .slider {
        background-color: #2196F3;
    }
    
    input:focus + .slider {
        box-shadow: 0 0 1px #2196F3;
    }
    
    input:checked + .slider:before {
        -webkit-transform: translateX(26px);
        -ms-transform: translateX(26px);
        transform: translateX(26px);
    }
    
    /* Rounded sliders */
    .slider.round {
        border-radius: 34px;
    }
    
    .slider.round:before {
        border-radius: 50%;
    }
    
    .border-check {
        border: 1px solid #ccc!important;
        border-radius: 16px;
    }
</style>
<div class="white-box">
    <div class="os-tabs-w">
        <div class="os-tabs-controls">
            <ul class="navx nav-tabs">
                <li class="nav-item text-center">
                    <a class="nav-link" href="<?php echo base_url();?>doctor/settings/">
                        <div class="navWidget"><i class="picons-thin-icon-thin-0049_settings_panel_equalizer_preferences"></i></div> <span>Configuración</span>
                    </a>
                </li>
                <li class="nav-item text-center">
                    <a class="nav-link" href="<?php echo base_url();?>doctor/insurance/">
                        <div class="navWidget"><i class="picons-thin-icon-thin-0823_hospital_ill_medicine_doctor_ambulance"></i></div> <span>Aseguradoras</span>
                    </a>
                </li>
                <li class="nav-item text-center">
                    <a class="nav-link" href="<?php echo base_url();?>doctor/clinics/">
                        <div class="navWidget"><i class="picons-thin-icon-thin-0047_home_flat"></i></div> <span>Sucursales</span>
                    </a>
                </li>
                <li class="nav-item text-center">
                    <a class="nav-link" href="<?php echo base_url();?>doctor/specialties/">
                        <div class="navWidget"><i class="picons-thin-icon-thin-0825_stetoscope_doctor_hospital_ill"></i></div><span>Especialidades</span>
                    </a>
                </li>
                <li class="nav-item text-center">
                    <a class="nav-link" href="<?php echo base_url();?>doctor/surveys/">
                        <div class="navWidget"><i class="picons-thin-icon-thin-0065_bullet_list_view"></i></div><span>Encuestas</span>
                    </a>
                </li>
                 <li class="nav-item text-center">
                    <a class="nav-link" href="<?php echo base_url();?>doctor/forms/">
                        <div class="navWidget"><i class="picons-thin-icon-thin-0064_bullet_list_view"></i></div> <span>Formularios</span>
                    </a>
                </li>
                <li class="nav-item text-center">
                    <a class="nav-link current" href="<?php echo base_url();?>doctor/roles/">
                        <div class="navWidget"><i class="picons-thin-icon-thin-0711_young_boy_user_profile_avatar_man_male"></i></div> <span>Roles de usuario</span>
                    </a>
                </li>

            </ul>
        </div>
    </div>
</div>
<div id="main-content">
    <div class="row">
        <div class="col-md-12">
            <div class="card-box">
                <div class="card-h">
                    <h5 class="card-caption">Asigna los permisos al rol de usuario:</h5>
                </div>
                <div class="card-b">
                    <div class="row">
                        <div class="col-lg-12">
                            <?php $this->db->where('role_id', $role_id);
                                $roles = $this->db->get('role')->result_array();
                                foreach($roles as $rl):
                                    $perm = unserialize($rl['permissions']);?>
                            <form action="<?php echo base_url().'doctor/permissions/apply/'.base64_encode($role_id);?>" method="POST" enctype="multipart/form-data">
                                <h6><?php echo $rl['name'];?></h6>
                                <hr>
                                <div class="row">
                                    <div class="col-lg-12 mb-1 border-check">
                                        <label class="mt-2">Chat:</label>
                                        <label class="switch">
                                            <input type="checkbox" name="view_chat" id="view_chat" value="1" <?php if($perm['view_chat'] == 1) echo "checked";?> />
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                    <div class="col-lg-12 mb-1 border-check">
                                        <div class="row">
                                            <div class="col-lg-12 mb-1 mt-2">
                                                <label>Usuarios:</label>
                                                <label class="switch">
                                                    <input type="checkbox" class="principal" name="view_admins" id="view_admins" value="1" data-permission="admins" onclick="showPermissions(this)" <?php if($perm['view_admins'] == 1) echo "checked";?> />
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                            <div class="col-lg-12" id="div_admins" style="display:none;">
                                                <div class="row">
                                                    <div class="col-lg-2">
                                                        <label>Crear</label>
                                                        <label class="switch">
                                                            <input type="checkbox" name="create_admins" id="create_admins" value="1" <?php if($perm['create_admins'] == 1) echo "checked";?> />
                                                            <span class="slider round"></span>
                                                        </label>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <label>Editar</label>
                                                        <label class="switch">
                                                            <input type="checkbox" name="edit_admins" id="edit_admins" value="1" <?php if($perm['edit_admins'] == 1) echo "checked";?> />
                                                            <span class="slider round"></span>
                                                        </label>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <label>Eliminar</label>
                                                        <label class="switch">
                                                            <input type="checkbox" name="delete_admins" id="delete_admins" value="1" <?php if($perm['delete_admins'] == 1) echo "checked";?> />
                                                            <span class="slider round"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 mb-1 border-check">
                                        <label class="mt-2">Citas:</label>
                                        <label class="switch">
                                            <input type="checkbox" name="view_appointments" id="view_appointments" value="1" <?php if($perm['view_appointments'] == 1) echo "checked";?> />
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                    <div class="col-lg-12 mb-1 border-check">
                                        <div class="row">
                                            <div class="col-lg-12 mb-1 mt-2">
                                                <label>Pacientes:</label>
                                                <label class="switch">
                                                    <input type="checkbox" class="principal" name="view_patients" id="view_patients" value="1" data-permission="patients" onclick="showPermissions(this)" <?php if($perm['view_patients'] == 1) echo "checked";?> />
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                            <div class="col-lg-12 mb-1" id="div_patients" style="display:none;">
                                                <div class="row">
                                                    <div class="col-lg-2">
                                                        <label>Crear</label>
                                                        <label class="switch">
                                                            <input type="checkbox" name="create_patients" id="create_patients" value="1" <?php if($perm['create_patients'] == 1) echo "checked";?> />
                                                            <span class="slider round"></span>
                                                        </label>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <label>Editar</label>
                                                        <label class="switch">
                                                            <input type="checkbox" name="edit_patients" id="edit_patients" value="1" <?php if($perm['edit_patients'] == 1) echo "checked";?> />
                                                            <span class="slider round"></span>
                                                        </label>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <label>Eliminar</label>
                                                        <label class="switch">
                                                            <input type="checkbox" name="delete_patients" id="delete_patients" value="1" <?php if($perm['delete_patients'] == 1) echo "checked";?> />
                                                            <span class="slider round"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 mb-1 border-check">
                                        <label class="mt-2">Hospitalización:</label>
                                        <label class="switch">
                                            <input type="checkbox" name="view_stabilitation" id="view_stabilitation" value="1" <?php if($perm['view_stabilitation'] == 1) echo "checked";?> />
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                    <div class="col-lg-12 mb-1 border-check">
                                        <label class="mt-2">Inventario:</label>
                                        <label class="switch">
                                            <input type="checkbox" name="view_inventory" id="view_inventory" value="1" <?php if($perm['view_inventory'] == 1) echo "checked";?> />
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                    <div class="col-lg-12 mb-1 border-check">
                                        <label class="mt-2">Ventas:</label>
                                        <label class="switch">
                                            <input type="checkbox" name="view_sales" id="view_sales" value="1" <?php if($perm['view_sales'] == 1) echo "checked";?> />
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                    <div class="col-lg-12 mb-1 border-check">
                                        <label class="mt-2">Planes:</label>
                                        <label class="switch">
                                            <input type="checkbox" name="view_plans" id="view_plans" value="1" <?php if($perm['view_plans'] == 1) echo "checked";?> />
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                    <div class="col-lg-12 mb-1 border-check">
                                        <label class="mt-2">Laboratorios:</label>
                                        <label class="switch">
                                            <input type="checkbox" name="view_laboratories" id="view_laboratories" value="1" <?php if($perm['view_laboratories'] == 1) echo "checked";?> />
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                    <div class="col-lg-12 mb-1 border-check">
                                        <label class="mt-2">Finanzas:</label>
                                        <label class="switch">
                                            <input type="checkbox" name="view_financial" id="view_financial" value="1" <?php if($perm['view_financial'] == 1) echo "checked";?> />
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                    <div class="col-lg-12 mb-1 border-check">
                                        <label class="mt-2">Reportes:</label>
                                        <label class="switch">
                                            <input type="checkbox" name="view_reports" id="view_reports" value="1" <?php if($perm['view_reports'] == 1) echo "checked";?> />
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                    <div class="col-lg-12 mb-1 border-check">
                                        <label class="mt-2">Contabilidad:</label>
                                        <label class="switch">
                                            <input type="checkbox" name="view_accounting" id="view_accounting" value="1" <?php if($perm['view_accounting'] == 1) echo "checked";?> />
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                    <div class="col-lg-12 mb-1 border-check">
                                        <label class="mt-2">Bancos:</label>
                                        <label class="switch">
                                            <input type="checkbox" name="view_banks" id="view_banks" value="1" <?php if($perm['view_banks'] == 1) echo "checked";?> />
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                    <div class="col-lg-12 mb-1 border-check">
                                        <label class="mt-2">Configuración:</label>
                                        <label class="switch">
                                            <input type="checkbox" name="view_settings" id="view_settings" value="1" <?php if($perm['view_settings'] == 1) echo "checked";?> />
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                    <div class="col-sm-12 mt-4">
                                        <button type="submit" class="btn btn-success"><i class="picons-thin-icon-thin-0154_ok_successful_check"></i> Aplicar cambios</button>
                                    </div>
                                </div>
                            </form>
                            <?php endforeach;?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $(".principal").each(function () {
            showPermissions(this);
        });
    });

    function showPermissions(check) {
        var data = check.getAttribute("data-permission");
        console.log("Data:", data);
        if (check.checked) $("#div_"+data).show(300);
        else $("#div_"+data).hide(300);
    }
</script>