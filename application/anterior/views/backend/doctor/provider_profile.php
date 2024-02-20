<?php 
    $staff_id = base64_decode($id_);
    $documents = $this->db->get_where('document', array('user_id'=>$staff_id, 'user_type'=>'staff', 'status'=>1));
    $data = $this->db->get_where('provider_data', array('staff_id'=>$staff_id, 'status'=>1))->row_array();
    $comRef = $this->db->get_where('commercial_reference', array('staff_id'=>$staff_id, 'status'=>1));
    $bankRef = $this->db->get_where('bank_reference', array('staff_id'=>$staff_id, 'status'=>1));
    $banks = $this->crud_model->getBanksActive();
    $currs = $this->crud_model->getCurrenciesActive();
    $acctyp = $this->crud_model->getAccountTypesActive();
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
                    <?php if($data['type_provider'] == 1):?>
                    <form action="<?php echo base_url();?>doctor/providers/edit_single/<?php echo $details['staff_id'];?>" method="POST" enctype="multipart/form-data" id="form">
                        <div class="row">
                            <div class="col-sm-12 mb-2">
                                <div class="tasks-section" style="background: #fff; padding: 24px; border-radius: 25px; border: 1px solid #ccc;">
                                    <div class="row">
                                        <div class="col-sm-12 ">
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
                                        <div class="col-sm-12">
                                            <div class="form-group date-time-picker m-b-15">
                                                <label for="simpleinvput">Nacimiento</label>
                                                <div class="input-group date datepicker" id="DoctorPicker1">
                                                    <input type="text" id="applyDate" name="application_date" autocomplete="off" style="border: 1px solid #198cff8f;" value="<?php echo $data['application_date'];?>" class="form-control">
                                                    <span style="display: none;" class="input-group-addon"><i data-feather="calendar"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Nombre Completo:</label>
                                                <input type="text" style="border: 1px solid #198cff8f;" name="full_name" required="" value="<?php echo $details['first_name'] ?>" class="form-control">
                                            </div>
                                        </div>
            
                                        <div class="col-sm-12">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Nombre Comercial:</label>
                                                <input type="text" style="border: 1px solid #198cff8f;" name="tradename" required="" value="<?php echo $details['last_name'] ?>" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Dirección fiscal:<span style="color:red">*</span></label>
                                                <textarea type="text" style="border: 1px solid #198cff8f;" name="fiscal_address" class="form-control" required><?php echo $data['fiscal_address'];?></textarea>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Dirección comercial:<span style="color:red">*</span></label>
                                                <textarea type="text" style="border: 1px solid #198cff8f;" name="commercial_address" class="form-control" required><?php echo $data['commercial_address'];?></textarea>
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
                                                <label for="simpleinput">Sitio web de la empresa:</label>
                                                <input type="text" style="border: 1px solid #198cff8f;" name="website" value="<?php echo $data['website'];?>" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">NIT:<span style="color:red">*</span></label>
                                                <input type="text" style="border: 1px solid #198cff8f;" name="nit" required="" value="<?php echo $data['nit'];?>" class="form-control" />
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Código de área del teléfono:</label>
                                                <input type="number" style="border: 1px solid #198cff8f;" name="area_code" value="<?php echo $data['area_code'];?>" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Celular:</label>
                                                <input type="text" style="border: 1px solid #198cff8f;" name="phone_1" required="" value="<?php echo $details['phone'] ?>" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Teléfono 2:</label>
                                                <input type="text" style="border: 1px solid #198cff8f;" name="phone_2" value="<?php echo $data['phone_2'];?>" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Teléfono 3:</label>
                                                <input type="text" style="border: 1px solid #198cff8f;" name="phone_3" value="<?php echo $data['phone_3'];?>" class="form-control">
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
                                            <h6>Datos legales</h6>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Nombre completo</label>
                                                <input type="text" name="full_name_legal"  class="form-control" value="<?php echo $data['full_name_legal'];?>">
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Número DPI</label>
                                                <input type="text" name="dpi_legal"  class="form-control" value="<?php echo $data['dpi_legal'];?>">
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Patente de comercio</label>
                                                <input type="text" name="commercial_patent" class="form-control" value="<?php echo $data['commercial_patent'];?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 mb-2">
                                <div class="tasks-section" style="background: #fff; padding: 24px; border-radius: 25px; border: 1px solid #ccc;">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <h6>Contactos</h6>
                                        </div>
                                        <div class="col-sm-12">
                                            <h6>Representante de ventas</h6>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Nombre:</label>
                                                <input type="text" name="full_name_represent"  class="form-control" value="<?php echo $data['full_name_represent'];?>">
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Teléfono:</label>
                                                <input type="text" name="phone_represent"  class="form-control" value="<?php echo $data['phone_represent'];?>">
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Correo:</label>
                                                <input type="text" name="email_represent" class="form-control" value="<?php echo $data['email_represent'];?>">
                                            </div>
                                        </div>
                                        <div class="col-sm-12 mt-3">
                                            <h6>Gerente de ventas</h6>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Nombre:</label>
                                                <input type="text" name="full_name_manager" class="form-control" value="<?php echo $data['full_name_manager'];?>">
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Teléfono:</label>
                                                <input type="text" name="phone_manager" class="form-control" value="<?php echo $data['phone_manager'];?>">
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Correo:</label>
                                                <input type="text" name="email_manager" class="form-control" value="<?php echo $data['email_manager'];?>">
                                            </div>
                                        </div>
                                        <div class="col-sm-12 mt-3">
                                            <h6>Cuentas por cobrar</h6>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Nombre:</label>
                                                <input type="text" name="full_name_accounts" class="form-control" value="<?php echo $data['full_name_accounts'];?>">
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Teléfono:</label>
                                                <input type="text" name="phone_accounts" class="form-control" value="<?php echo $data['phone_accounts'];?>">
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Correo:</label>
                                                <input type="text" name="email_accounts" class="form-control" value="<?php echo $data['email_accounts'];?>">
                                            </div>
                                        </div>
                                        <div class="col-sm-12 mt-3">
                                            <h6>Facturación</h6>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Nombre:</label>
                                                <input type="text" name="full_name_billing" class="form-control" value="<?php echo $data['full_name_billing'];?>">
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Teléfono:</label>
                                                <input type="text" name="phone_billing" class="form-control" value="<?php echo $data['phone_billing'];?>">
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Correo:</label>
                                                <input type="text" name="email_billing" class="form-control" value="<?php echo $data['email_billing'];?>">
                                            </div>
                                        </div>
                                        <div class="col-sm-12 mt-3">
                                            <h6>Finanzas</h6>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Nombre:</label>
                                                <input type="text" name="full_name_finance" class="form-control" value="<?php echo $data['full_name_finance'];?>">
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Teléfono:</label>
                                                <input type="text" name="phone_finance" class="form-control" value="<?php echo $data['phone_finance'];?>">
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Correo:</label>
                                                <input type="text" name="email_finance" class="form-control" value="<?php echo $data['email_finance'];?>">
                                            </div>
                                        </div>
                                        <div class="col-sm-12 mt-3">
                                            <h6>Contabilidad</h6>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Nombre:</label>
                                                <input type="text" name="full_name_accounting" class="form-control" value="<?php echo $data['full_name_accounting'];?>">
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Teléfono:</label>
                                                <input type="text" name="phone_accounting" class="form-control" value="<?php echo $data['phone_accounting'];?>">
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Correo:</label>
                                                <input type="text" name="email_accounting" class="form-control" value="<?php echo $data['email_accounting'];?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 mb-2">
                                <div class="tasks-section" style="background: #fff; padding: 24px; border-radius: 25px; border: 1px solid #ccc;">
                                    <div class="row">
                                        <div class="col-sm-12 mt-3">
                                            <h6>Referencias comerciales</h6>
                                        </div>
                                        <?php foreach($comRef->result_array() as $cr):?>
                                        <input type="hidden" name="commercial_reference_id[]" value="<?php echo $cr['commercial_reference_id'];?>" />
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
                            <div class="col-sm-12 mb-2">
                                <div class="tasks-section" style="background: #fff; padding: 24px; border-radius: 25px; border: 1px solid #ccc;">
                                    <div class="row">
                                        <div class="col-sm-12 mt-3">
                                            <h6>Línea de productos o servicios que proporcionan</h6>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Lista<span style="color:red">*</span></label>
                                                <select class="form-control" name="provider_service_id" required>
                                                    <option value="" selected>Seleccione una opcion</option>
                                                    <?php $services = $this->crud_model->getProviderServices();
                                                        foreach($services->result_array() as $ps):?>
                                                    <option value="<?php echo $ps['provider_service_id'];?>" <?php if($ps['provider_service_id'] == $data['provider_service_id']) echo "selected";?>><?php echo $ps['name'];?></option>
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
                                        <div class="col-sm-12 mt-3">
                                            <h6>Información fiscal</h6>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group m-b-15">
                                                <label>Aplica:</label>
                                                <div class="input-group">
                                                    <div class="form-check" style="padding-left: 0px;">
                                                        <input <?php if($data['apply_fiscal'] == 0) echo "checked";?> class="radiobutton" type="radio" name="apply_fiscal" id="radio3" value="0"><label class="radiobutton-label" for="radio3">No</label>
                                                    </div>
                                                    <div class="form-check mr-3">
                                                        <input <?php if($data['apply_fiscal'] == 1) echo "checked";?> class="radiobutton" type="radio" name="apply_fiscal" id="radio4" value="1"><label class="radiobutton-label" for="radio4">Si</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 mt-2">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Lista<span style="color:red">*</span></label>
                                                <select class="form-control" name="fiscal_data" required>
                                                    <option value="1" <?php if($data['fiscal_data'] == 1) echo "selected";?>>Sujetos a pagos trimestrales</option>
                                                    <option value="2" <?php if($data['fiscal_data'] == 2) echo "selected";?>>Emisor de factura</option>
                                                    <option value="3" <?php if($data['fiscal_data'] == 3) echo "selected";?>>Agentes retenedores de IVA</option>
                                                    <option value="4" <?php if($data['fiscal_data'] == 4) echo "selected";?>>Pequeño contribuyente</option>
                                                </select>
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
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 mb-2">
                                <div class="tasks-section" style="background: #fff; padding: 24px; border-radius: 25px; border: 1px solid #ccc;">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <h6>Referencias bancarias</h6>
                                        </div>
                                        <?php foreach($bankRef->result_array() as $br):?>
                                        <input type="hidden" name="bank_reference_id[]" value="<?php echo $br['bank_reference_id'];?>" />
                                        <div class="col-sm-4">
                                            <label for="simpleinput">Banco:<span style="color:red">*</span></label>
                                            <select class="form-control" name="bank_id[]" required>
                                                <option value="">Seleccione una opción</option>
                                                <?php foreach($banks->result_array() as $bk):?>
                                                <option value="<?php echo $bk['bank_id'];?>" <?php if($bk['bank_id'] == $br['bank_id']) echo "selected";?>><?php echo $bk['name'];?></option>
                                                <?php endforeach;?>
                                            </select>
                                        </div>
                                        <div class="col-sm-4">
                                            <label for="simpleinput">Cuenta a nombre de:<span style="color:red">*</span></label>
                                            <input type="text" name="account_name[]" required="" class="form-control" value="<?php echo $br['account_name'];?>">
                                        </div>
                                        <div class="col-sm-4">
                                            <label for="simpleinput">Tipo de moneda<span style="color:red">*</span></label>
                                            <select class="form-control" name="currency_id[]" required>
                                                <option value="">Seleccione una opción</option>
                                                <?php foreach($currs->result_array() as $cr):?>
                                                <option value="<?php echo $cr['currency_id'];?>" <?php if($cr['currency_id'] == $br['currency_id']) echo "selected";?>><?php echo $cr['name']." (".$cr['symbol'].")";?></option>
                                                <?php endforeach;?>
                                            </select>
                                        </div>
                                        <div class="col-sm-4">
                                            <label for="simpleinput">Número de cuenta:<span style="color:red">*</span></label>
                                            <input type="text" name="account_no[]" required="" class="form-control" value="<?php echo $br['account_name'];?>">
                                        </div>
                                        <div class="col-sm-4">
                                            <label for="simpleinput">Tipo de cuenta<span style="color:red">*</span></label>
                                            <select class="form-control" name="account_type_id[]" required>
                                                <option value="">Seleccione una opción</option>
                                                <?php foreach($acctyp->result_array() as $at):?>
                                                <option value="<?php echo $at['account_type_id'];?>" <?php if($at['account_type_id'] == $br['account_type_id']) echo "selected";?>><?php echo $at['name'];?></option>
                                                <?php endforeach;?>
                                            </select>
                                        </div>
                                        <div class="col-sm-12"><hr></div>
                                        <?php endforeach;?>
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
                    <?php elseif($data['type_provider'] == 2):?>
                    <form action="<?php echo base_url();?>doctor/providers/edit_legal/<?php echo $details['staff_id'];?>" method="POST" enctype="multipart/form-data" id="form">
                        <div class="row">
                            <div class="col-sm-12 mb-2">
                                <div class="tasks-section" style="background: #fff; padding: 24px; border-radius: 25px; border: 1px solid #ccc;">
                                    <div class="row">
                                        <div class="col-sm-12 ">
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
                                        <div class="col-sm-12">
                                            <div class="form-group date-time-picker m-b-15">
                                                <label for="simpleinvput">Nacimiento</label>
                                                <div class="input-group date datepicker" id="DoctorPicker1">
                                                    <input type="text" id="applyDate" name="application_date" autocomplete="off" style="border: 1px solid #198cff8f;" value="<?php echo $data['application_date'];?>" class="form-control">
                                                    <span style="display: none;" class="input-group-addon"><i data-feather="calendar"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Nombre Completo:</label>
                                                <input type="text" style="border: 1px solid #198cff8f;" name="full_name" required="" value="<?php echo $details['first_name'] ?>" class="form-control">
                                            </div>
                                        </div>
            
                                        <div class="col-sm-12">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Nombre Comercial:</label>
                                                <input type="text" style="border: 1px solid #198cff8f;" name="tradename" required="" value="<?php echo $details['last_name'] ?>" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Dirección fiscal:<span style="color:red">*</span></label>
                                                <textarea type="text" style="border: 1px solid #198cff8f;" name="fiscal_address" class="form-control" required><?php echo $data['fiscal_address'];?></textarea>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Dirección comercial:<span style="color:red">*</span></label>
                                                <textarea type="text" style="border: 1px solid #198cff8f;" name="commercial_address" class="form-control" required><?php echo $data['commercial_address'];?></textarea>
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
                                                <label for="simpleinput">Sitio web de la empresa:</label>
                                                <input type="text" style="border: 1px solid #198cff8f;" name="website" value="<?php echo $data['website'];?>" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">NIT:<span style="color:red">*</span></label>
                                                <input type="text" style="border: 1px solid #198cff8f;" name="nit" required="" value="<?php echo $data['nit'];?>" class="form-control" />
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Código de área del teléfono:</label>
                                                <input type="number" style="border: 1px solid #198cff8f;" name="area_code" value="<?php echo $data['area_code'];?>" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Celular:</label>
                                                <input type="text" style="border: 1px solid #198cff8f;" name="phone_1" required="" value="<?php echo $details['phone'] ?>" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Teléfono 2:</label>
                                                <input type="text" style="border: 1px solid #198cff8f;" name="phone_2" value="<?php echo $data['phone_2'];?>" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Teléfono 3:</label>
                                                <input type="text" style="border: 1px solid #198cff8f;" name="phone_3" value="<?php echo $data['phone_3'];?>" class="form-control">
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
                                        <div class="col-sm-6">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Puesto:</label>
                                                <input type="text" style="border: 1px solid #198cff8f;" name="charge" value="<?php echo $details['charge'];?>" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Celular de contacto</label>
                                                <input type="text" style="border: 1px solid #198cff8f;" name="phone_contact" value="<?php echo $data['phone_contact'];?>" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 mb-2">
                                <div class="tasks-section" style="background: #fff; padding: 24px; border-radius: 25px; border: 1px solid #ccc;">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <h6>Datos legales</h6>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Nombre completo<span style="color:red">*</span></label>
                                                <input type="text" name="full_name_legal" required="" class="form-control" value="<?php echo $data['full_name_legal'];?>">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Número DPI<span style="color:red">*</span></label>
                                                <input type="text" name="dpi_legal" required="" class="form-control" value="<?php echo $data['dpi_legal'];?>">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Patente de comercio</label>
                                                <input type="text" name="commercial_patent" class="form-control" value="<?php echo $data['commercial_patent'];?>">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">NIT:</label>
                                                <input type="text" style="border: 1px solid #198cff8f;" name="nit_legal" required="" value="<?php echo $data['nit_legal'];?>" class="form-control" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 mb-2">
                                <div class="tasks-section" style="background: #fff; padding: 24px; border-radius: 25px; border: 1px solid #ccc;">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <h6>Contactos</h6>
                                        </div>
                                        <div class="col-sm-12">
                                            <h6>Representante de ventas</h6>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Nombre:</label>
                                                <input type="text" name="full_name_represent" required="" class="form-control" value="<?php echo $data['full_name_represent'];?>">
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Teléfono:</label>
                                                <input type="text" name="phone_represent" required="" class="form-control" value="<?php echo $data['phone_represent'];?>">
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Correo:</label>
                                                <input type="text" name="email_represent" class="form-control" value="<?php echo $data['email_represent'];?>">
                                            </div>
                                        </div>
                                        <div class="col-sm-12 mt-3">
                                            <h6>Gerente de ventas</h6>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Nombre:</label>
                                                <input type="text" name="full_name_manager" class="form-control" value="<?php echo $data['full_name_manager'];?>">
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Teléfono:</label>
                                                <input type="text" name="phone_manager" class="form-control" value="<?php echo $data['phone_manager'];?>">
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Correo:</label>
                                                <input type="text" name="email_manager" class="form-control" value="<?php echo $data['email_manager'];?>">
                                            </div>
                                        </div>
                                        <div class="col-sm-12 mt-3">
                                            <h6>Cuentas por cobrar</h6>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Nombre:</label>
                                                <input type="text" name="full_name_accounts" class="form-control" value="<?php echo $data['full_name_accounts'];?>">
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Teléfono:</label>
                                                <input type="text" name="phone_accounts" class="form-control" value="<?php echo $data['phone_accounts'];?>">
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Correo:</label>
                                                <input type="text" name="email_accounts" class="form-control" value="<?php echo $data['email_accounts'];?>">
                                            </div>
                                        </div>
                                        <div class="col-sm-12 mt-3">
                                            <h6>Facturación</h6>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Nombre:</label>
                                                <input type="text" name="full_name_billing" class="form-control" value="<?php echo $data['full_name_billing'];?>">
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Teléfono:</label>
                                                <input type="text" name="phone_billing" class="form-control" value="<?php echo $data['phone_billing'];?>">
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Correo:</label>
                                                <input type="text" name="email_billing" class="form-control" value="<?php echo $data['email_billing'];?>">
                                            </div>
                                        </div>
                                        <div class="col-sm-12 mt-3">
                                            <h6>Finanzas</h6>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Nombre:</label>
                                                <input type="text" name="full_name_finance" class="form-control" value="<?php echo $data['full_name_finance'];?>">
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Teléfono:</label>
                                                <input type="text" name="phone_finance" class="form-control" value="<?php echo $data['phone_finance'];?>">
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Correo:</label>
                                                <input type="text" name="email_finance" class="form-control" value="<?php echo $data['email_finance'];?>">
                                            </div>
                                        </div>
                                        <div class="col-sm-12 mt-3">
                                            <h6>Contabilidad</h6>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Nombre:</label>
                                                <input type="text" name="full_name_accounting" class="form-control" value="<?php echo $data['full_name_accounting'];?>">
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Teléfono:</label>
                                                <input type="text" name="phone_accounting" class="form-control" value="<?php echo $data['phone_accounting'];?>">
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Correo:</label>
                                                <input type="text" name="email_accounting" class="form-control" value="<?php echo $data['email_accounting'];?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 mb-2">
                                <div class="tasks-section" style="background: #fff; padding: 24px; border-radius: 25px; border: 1px solid #ccc;">
                                    <div class="row">
                                        <div class="col-sm-12 mt-3">
                                            <h6>Referencias comerciales</h6>
                                        </div>
                                        <?php foreach($comRef->result_array() as $cr):?>
                                        <input type="hidden" name="commercial_reference_id[]" value="<?php echo $cr['commercial_reference_id'];?>" />
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
                            <div class="col-sm-12 mb-2">
                                <div class="tasks-section" style="background: #fff; padding: 24px; border-radius: 25px; border: 1px solid #ccc;">
                                    <div class="row">
                                        <div class="col-sm-12 mt-3">
                                            <h6>Línea de productos o servicios que proporcionan</h6>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Lista<span style="color:red">*</span></label>
                                                <select class="form-control" name="provider_service_id" required>
                                                    <option value="" selected>Seleccione una opcion</option>
                                                    <?php $services = $this->crud_model->getProviderServices();
                                                        foreach($services->result_array() as $ps):?>
                                                    <option value="<?php echo $ps['provider_service_id'];?>" <?php if($ps['provider_service_id'] == $data['provider_service_id']) echo "selected";?>><?php echo $ps['name'];?></option>
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
                                        <div class="col-sm-12 mt-3">
                                            <h6>Información fiscal</h6>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group m-b-15">
                                                <label>Aplica:</label>
                                                <div class="input-group">
                                                    <div class="form-check" style="padding-left: 0px;">
                                                        <input <?php if($data['apply_fiscal'] == 0) echo "checked";?> class="radiobutton" type="radio" name="apply_fiscal" id="radio3" value="0"><label class="radiobutton-label" for="radio3">No</label>
                                                    </div>
                                                    <div class="form-check mr-3">
                                                        <input <?php if($data['apply_fiscal'] == 1) echo "checked";?> class="radiobutton" type="radio" name="apply_fiscal" id="radio4" value="1"><label class="radiobutton-label" for="radio4">Si</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 mt-2">
                                            <div class="form-group m-b-15">
                                                <label for="simpleinput">Lista<span style="color:red">*</span></label>
                                                <select class="form-control" name="fiscal_data" required>
                                                    <option value="1" <?php if($data['fiscal_data'] == 1) echo "selected";?>>Sujetos a pagos trimestrales</option>
                                                    <option value="2" <?php if($data['fiscal_data'] == 2) echo "selected";?>>Emisor de factura</option>
                                                    <option value="3" <?php if($data['fiscal_data'] == 3) echo "selected";?>>Agentes retenedores de IVA</option>
                                                    <option value="4" <?php if($data['fiscal_data'] == 4) echo "selected";?>>Pequeño contribuyente</option>
                                                </select>
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
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 mb-2">
                                <div class="tasks-section" style="background: #fff; padding: 24px; border-radius: 25px; border: 1px solid #ccc;">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <h6>Referencias bancarias</h6>
                                        </div>
                                        <?php foreach($bankRef->result_array() as $br):?>
                                        <input type="hidden" name="bank_reference_id[]" value="<?php echo $br['bank_reference_id'];?>" />
                                        <div class="col-sm-4">
                                            <label for="simpleinput">Banco:<span style="color:red">*</span></label>
                                            <select class="form-control" name="bank_id[]" required>
                                                <option value="">Seleccione una opción</option>
                                                <?php foreach($banks->result_array() as $bk):?>
                                                <option value="<?php echo $bk['bank_id'];?>" <?php if($bk['bank_id'] == $br['bank_id']) echo "selected";?>><?php echo $bk['name'];?></option>
                                                <?php endforeach;?>
                                            </select>
                                        </div>
                                        <div class="col-sm-4">
                                            <label for="simpleinput">Cuenta a nombre de:<span style="color:red">*</span></label>
                                            <input type="text" name="account_name[]" required="" class="form-control" value="<?php echo $br['account_name'];?>">
                                        </div>
                                        <div class="col-sm-4">
                                            <label for="simpleinput">Tipo de moneda<span style="color:red">*</span></label>
                                            <select class="form-control" name="currency_id[]" required>
                                                <option value="">Seleccione una opción</option>
                                                <?php foreach($currs->result_array() as $cr):?>
                                                <option value="<?php echo $cr['currency_id'];?>" <?php if($cr['currency_id'] == $br['currency_id']) echo "selected";?>><?php echo $cr['name']." (".$cr['symbol'].")";?></option>
                                                <?php endforeach;?>
                                            </select>
                                        </div>
                                        <div class="col-sm-4">
                                            <label for="simpleinput">Número de cuenta:<span style="color:red">*</span></label>
                                            <input type="text" name="account_no[]" required="" class="form-control" value="<?php echo $br['account_name'];?>">
                                        </div>
                                        <div class="col-sm-4">
                                            <label for="simpleinput">Tipo de cuenta<span style="color:red">*</span></label>
                                            <select class="form-control" name="account_type_id[]" required>
                                                <option value="">Seleccione una opción</option>
                                                <?php foreach($acctyp->result_array() as $at):?>
                                                <option value="<?php echo $at['account_type_id'];?>" <?php if($at['account_type_id'] == $br['account_type_id']) echo "selected";?>><?php echo $at['name'];?></option>
                                                <?php endforeach;?>
                                            </select>
                                        </div>
                                        <div class="col-sm-12"><hr></div>
                                        <?php endforeach;?>
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
                                                    <label for="simpleinput">DPI RP:</label>
                                                    <input type="file" name="doc_dpi_rp" accept="image/*, application/pdf" />
                                                </div>
                                                <div class="col-sm-6">
                                                    <label for="simpleinput">Vencimiento:</label>
                                                    <input type="date" class="form-control" name="expiration_dpi_rp" value="<?php echo date("Y-m-d");?>" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 mb-4 mt-2">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <label for="simpleinput">RTU de empresa:</label>
                                                    <input type="file" name="doc_rtu_company" accept="image/*, application/pdf" />
                                                </div>
                                                <div class="col-sm-6">
                                                    <label for="simpleinput">Vencimiento:</label>
                                                    <input type="date" class="form-control" name="expiration_rtu_company" value="<?php echo date("Y-m-d");?>" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 mb-4 mt-2">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <label for="simpleinput">RTU RP:</label>
                                                    <input type="file" name="doc_rtu_rp" accept="image/*, application/pdf" />
                                                </div>
                                                <div class="col-sm-6">
                                                    <label for="simpleinput">Vencimiento:</label>
                                                    <input type="date" class="form-control" name="expiration_rtu_rp" value="<?php echo date("Y-m-d");?>" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 mb-4">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <label for="simpleinput">Patente de comercio:</label>
                                                    <input type="file" name="doc_commercial_patent" accept="image/*, application/pdf" />
                                                </div>
                                                <div class="col-sm-6">
                                                    <label for="simpleinput">Vencimiento:</label>
                                                    <input type="date" class="form-control" name="expiration_commercial_patent" value="<?php echo date("Y-m-d");?>" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 mb-4">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <label for="simpleinput">Patente de sociedad:</label>
                                                    <input type="file" name="doc_partner_patent" accept="image/*, application/pdf" />
                                                </div>
                                                <div class="col-sm-6">
                                                    <label for="simpleinput">Vencimiento:</label>
                                                    <input type="date" class="form-control" name="expiration_partner_patent" value="<?php echo date("Y-m-d");?>" />
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
                                                    <label for="simpleinput">Constancia bancaria:</label>
                                                    <input type="file" name="doc_bank_statement" accept="image/*, application/pdf" />
                                                </div>
                                                <div class="col-sm-6">
                                                    <label for="simpleinput">Vencimiento:</label>
                                                    <input type="date" class="form-control" name="expiration_bank_statement" value="<?php echo date("Y-m-d");?>" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 mb-4">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <label for="simpleinput">Solvencia fiscal:</label>
                                                    <input type="file" name="doc_fiscal_solvency" accept="image/*, application/pdf" />
                                                </div>
                                                <div class="col-sm-6">
                                                    <label for="simpleinput">Vencimiento:</label>
                                                    <input type="date" class="form-control" name="expiration_fiscal_solvency" value="<?php echo date("Y-m-d");?>" />
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
                    <?php endif;?>
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
                                                        <?php if($dc['type'] == "dpi_rp") echo "DPI RP";
                                                            if($dc['type'] == "rtu") echo "RTU";
                                                            if($dc['type'] == "rtu_company") echo "RTU de empresa";
                                                            if($dc['type'] == "rtu_rp") echo "RTU RP";
                                                            if($dc['type'] == "commercial_patent") echo "Patentes de comercio";
                                                            if($dc['type'] == "partner_patent") echo "Patente de sociedad";
                                                            if($dc['type'] == "receipt") echo "Recibo de agua/luz";
                                                            if($dc['type'] == "bank_statement") echo "Constancia bancaria";
                                                            if($dc['type'] == "fiscal_solvency") echo "Solviencia Fiscal";?>
                                                    </b>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="bar-level-1" style="width: 100%;background:#fff; margin-top: -6px;">
                                            Vencimiento: <?php echo date("d/m/Y", strtotime($dc['expiration'])); ?>
                                        </div>
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
    
    
    $(document).ready(function() {
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
        
        fileUpDPIRP = $('input[name="doc_dpi_rp"]').fileuploader({
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
        
        fileUpRTUCompany = $('input[name="doc_rtu_company"]').fileuploader({
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
        
        fileUpRTURP = $('input[name="doc_rtu_rp"]').fileuploader({
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
        
        fileUpComPat = $('input[name="doc_commercial_patent"]').fileuploader({
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
        
        fileUpPartPat = $('input[name="doc_partner_patent"]').fileuploader({
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
        
        fileUpBankStat = $('input[name="doc_bank_statement"]').fileuploader({
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
        
        fileUpFisSol = $('input[name="doc_fiscal_solvency"]').fileuploader({
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