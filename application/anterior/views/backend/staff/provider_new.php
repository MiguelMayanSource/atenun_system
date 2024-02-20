<?php $deptos = $this->db->get('departamento');
    $banks = $this->crud_model->getBanksActive();
    $currs = $this->crud_model->getCurrenciesActive();
    $acctyp = $this->crud_model->getAccountTypesActive();?>
<div id="main-content">
    <div class="todo-content conts">
        <div class="row">
            <div class="col-xl-8 col-lg-8 col-sm-12" style="float: none; margin: 0 auto;">
                <div class="tasks-section" style="background: #fff; padding: 24px; border-radius: 25px; border: 1px solid #ccc;">
                    <h4 class="todo-content-header">
                        <i class="batch-icon-arrow-right"></i><span> Ingresar nuevo proveedor</span>
                    </h4>
                    <div class="row">
                        <div class="col-sm-12">
                            <h6>Tipo de proveedor:</h6>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="form-check" style="padding-left: 0px;">
                                        <input class="radiobutton" type="radio" name="type_provider" id="radio1" value="1" checked><label class="radiobutton-label" for="radio1">Persona individual</label>
                                    </div>
                                    <div class="form-check mr-3">
                                        <input class="radiobutton" type="radio" name="type_provider" id="radio2" value="2"><label class="radiobutton-label" for="radio2">Persona jurídica</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><br>
        <form action="<?php echo base_url();?>staff/providers/new_single/" method="POST" enctype="multipart/form-data" id="formS">
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
                                        <input type="text" id="applyDate" name="application_date" autocomplete="off" style="border: 1px solid #198cff8f;" value="" required class="form-control">
                                        <span style="display: none;" class="input-group-addon"><i data-feather="calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group m-b-15">
                                    <label for="simpleinput">Nombre completo:<span style="color:red">*</span></label>
                                    <input type="text" style="border: 1px solid #198cff8f;" name="full_name" required="" value="" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group m-b-15">
                                    <label for="simpleinput">Nombre comercial:<span style="color:red">*</span></label>
                                    <input type="text" style="border: 1px solid #198cff8f;" name="tradename" required="" value="" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group m-b-15">
                                    <label for="simpleinput">Dirección fiscal:<span style="color:red">*</span></label>
                                    <textarea type="text" style="border: 1px solid #198cff8f;" name="fiscal_address" class="form-control" required></textarea>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group m-b-15">
                                    <label for="simpleinput">Dirección comercial:<span style="color:red">*</span></label>
                                    <textarea type="text" style="border: 1px solid #198cff8f;" name="commercial_address" class="form-control" required></textarea>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group m-b-15">
                                    <label for="simpleinput">Correo electrónico:</label>
                                    <input type="email" style="border: 1px solid #198cff8f;" name="email" value="" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group m-b-15">
                                    <label for="simpleinput">Sitio web de la empresa:</label>
                                    <input type="text" style="border: 1px solid #198cff8f;" name="website" value="" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group m-b-15">
                                    <label for="simpleinput">NIT:<span style="color:red">*</span></label>
                                    <input type="text" style="border: 1px solid #198cff8f;" name="nit" required="" value="" class="form-control" />
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group m-b-15">
                                    <label for="simpleinput">Código de área del teléfono:</label>
                                    <input type="number" style="border: 1px solid #198cff8f;" name="area_code" value="" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group m-b-15">
                                    <label for="simpleinput">Teléfono 1:<span style="color:red">*</span></label>
                                    <input type="text" style="border: 1px solid #198cff8f;" name="phone_1" required="" value="" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group m-b-15">
                                    <label for="simpleinput">Teléfono 2:</label>
                                    <input type="text" style="border: 1px solid #198cff8f;" name="phone_2" value="" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group m-b-15">
                                    <label for="simpleinput">Teléfono 3:</label>
                                    <input type="text" style="border: 1px solid #198cff8f;" name="phone_3" value="" class="form-control">
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
                                    <textarea type="text" style="border: 1px solid #198cff8f;" name="address" class="form-control"><?php echo $details['address'];?></textarea>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group m-b-15">
                                    <label for="simpleinput">País:<span style="color:red">*</span></label>
                                    <select class="form-control" name="country" id="country" required>
                                        <option value="Guatemala" selected>Guatemala</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group m-b-15">
                                    <label for="simpleinput">Departamento:<span style="color:red">*</span></label>
                                    <select class="form-control" name="departamento_id" id="department" required onchange="getMunicipalities(this, 'municipality')">
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
                                <input type="text" name="full_name_legal" class="form-control" value="">
                            </div>
                            <div class="col-sm-4">
                                <label for="simpleinput">Número DPI</label>
                                <input type="text" name="dpi_legal" class="form-control" value="">
                            </div>
                            <div class="col-sm-4">
                                <label for="simpleinput">Patente de comercio</label>
                                <input type="text" name="commercial_patent" class="form-control" value="">
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
                                <input type="text" name="full_name_represent" class="form-control" value="">
                            </div>
                            <div class="col-sm-4">
                                <label for="simpleinput">Teléfono:</label>
                                <input type="text" name="phone_represent" class="form-control" value="">
                            </div>
                            <div class="col-sm-4">
                                <label for="simpleinput">Correo:</label>
                                <input type="text" name="email_represent" class="form-control" value="">
                            </div>
                            <div class="col-sm-12 mt-3">
                                <h6>Gerente de ventas</h6>
                            </div>
                            <div class="col-sm-4">
                                <label for="simpleinput">Nombre:</label>
                                <input type="text" name="full_name_manager" class="form-control" value="">
                            </div>
                            <div class="col-sm-4">
                                <label for="simpleinput">Teléfono:</label>
                                <input type="text" name="phone_manager" class="form-control" value="">
                            </div>
                            <div class="col-sm-4">
                                <label for="simpleinput">Correo:</label>
                                <input type="text" name="email_manager" class="form-control" value="">
                            </div>
                            <div class="col-sm-12 mt-3">
                                <h6>Cuentas por cobrar</h6>
                            </div>
                            <div class="col-sm-4">
                                <label for="simpleinput">Nombre:</label>
                                <input type="text" name="full_name_accounts" class="form-control" value="">
                            </div>
                            <div class="col-sm-4">
                                <label for="simpleinput">Teléfono:</label>
                                <input type="text" name="phone_accounts" class="form-control" value="">
                            </div>
                            <div class="col-sm-4">
                                <label for="simpleinput">Correo:</label>
                                <input type="text" name="email_accounts" class="form-control" value="">
                            </div>
                            <div class="col-sm-12 mt-3">
                                <h6>Facturación</h6>
                            </div>
                            <div class="col-sm-4">
                                <label for="simpleinput">Nombre:</label>
                                <input type="text" name="full_name_billing" class="form-control" value="">
                            </div>
                            <div class="col-sm-4">
                                <label for="simpleinput">Teléfono:</label>
                                <input type="text" name="phone_billing" class="form-control" value="">
                            </div>
                            <div class="col-sm-4">
                                <label for="simpleinput">Correo:</label>
                                <input type="text" name="email_billing" class="form-control" value="">
                            </div>
                            <div class="col-sm-12 mt-3">
                                <h6>Finanzas</h6>
                            </div>
                            <div class="col-sm-4">
                                <label for="simpleinput">Nombre:</label>
                                <input type="text" name="full_name_finance" class="form-control" value="">
                            </div>
                            <div class="col-sm-4">
                                <label for="simpleinput">Teléfono:</label>
                                <input type="text" name="phone_finance" class="form-control" value="">
                            </div>
                            <div class="col-sm-4">
                                <label for="simpleinput">Correo:</label>
                                <input type="text" name="email_finance" class="form-control" value="">
                            </div>
                            <div class="col-sm-12 mt-3">
                                <h6>Contabilidad</h6>
                            </div>
                            <div class="col-sm-4">
                                <label for="simpleinput">Nombre:</label>
                                <input type="text" name="full_name_accounting" class="form-control" value="">
                            </div>
                            <div class="col-sm-4">
                                <label for="simpleinput">Teléfono:</label>
                                <input type="text" name="phone_accounting" class="form-control" value="">
                            </div>
                            <div class="col-sm-4">
                                <label for="simpleinput">Correo:</label>
                                <input type="text" name="email_accounting" class="form-control" value="">
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
                            <div class="col-sm-6">
                                <label for="simpleinput">Nombre:</label>
                                <input type="text" name="first_name_reference[]" class="form-control" value="">
                            </div>
                            <div class="col-sm-6">
                                <label for="simpleinput">Apellido:</label>
                                <input type="text" name="last_name_reference[]" class="form-control" value="">
                            </div>
                            <div class="col-sm-6 mt-2">
                                <label for="simpleinput">Telefóno:</label>
                                <input type="text" name="phone_reference[]" class="form-control" value="">
                            </div>
                            <div class="col-sm-6 mt-2">
                                <label for="simpleinput">Empresa o persona:</label>
                                <input type="text" name="company_person_reference[]" class="form-control" value="">
                            </div>
                            <div class="col-sm-12">
                                <hr>
                            </div>
                            <div class="col-sm-6">
                                <label for="simpleinput">Nombre:</label>
                                <input type="text" name="first_name_reference[]" class="form-control" value="">
                            </div>
                            <div class="col-sm-6">
                                <label for="simpleinput">Apellido:</label>
                                <input type="text" name="last_name_reference[]" class="form-control" value="">
                            </div>
                            <div class="col-sm-6 mt-2">
                                <label for="simpleinput">Telefóno:</label>
                                <input type="text" name="phone_reference[]" class="form-control" value="">
                            </div>
                            <div class="col-sm-6 mt-2">
                                <label for="simpleinput">Empresa o persona:</label>
                                <input type="text" name="company_person_reference[]" class="form-control" value="">
                            </div>
                            <div class="col-sm-12">
                                <hr>
                            </div>
                            <div class="col-sm-6">
                                <label for="simpleinput">Nombre:</label>
                                <input type="text" name="first_name_reference[]" class="form-control" value="">
                            </div>
                            <div class="col-sm-6">
                                <label for="simpleinput">Apellido:</label>
                                <input type="text" name="last_name_reference[]" class="form-control" value="">
                            </div>
                            <div class="col-sm-6 mt-2">
                                <label for="simpleinput">Telefóno:</label>
                                <input type="text" name="phone_reference[]" class="form-control" value="">
                            </div>
                            <div class="col-sm-6 mt-2">
                                <label for="simpleinput">Empresa o persona:</label>
                                <input type="text" name="company_person_reference[]" class="form-control" value="">
                            </div>
                            <div class="col-sm-12">
                                <hr>
                            </div>
                            <div class="col-sm-6">
                                <label for="simpleinput">Nombre:</label>
                                <input type="text" name="first_name_reference[]" class="form-control" value="">
                            </div>
                            <div class="col-sm-6">
                                <label for="simpleinput">Apellido:</label>
                                <input type="text" name="last_name_reference[]" class="form-control" value="">
                            </div>
                            <div class="col-sm-6 mt-2">
                                <label for="simpleinput">Telefóno:</label>
                                <input type="text" name="phone_reference[]" class="form-control" value="">
                            </div>
                            <div class="col-sm-6 mt-2">
                                <label for="simpleinput">Empresa o persona:</label>
                                <input type="text" name="company_person_reference[]" class="form-control" value="">
                            </div>
                            <div class="col-sm-12">
                                <hr>
                            </div>
                            <div class="col-sm-6">
                                <label for="simpleinput">Nombre:</label>
                                <input type="text" name="first_name_reference[]" class="form-control" value="">
                            </div>
                            <div class="col-sm-6">
                                <label for="simpleinput">Apellido:</label>
                                <input type="text" name="last_name_reference[]" class="form-control" value="">
                            </div>
                            <div class="col-sm-6 mt-2">
                                <label for="simpleinput">Telefóno:</label>
                                <input type="text" name="phone_reference[]" class="form-control" value="">
                            </div>
                            <div class="col-sm-6 mt-2">
                                <label for="simpleinput">Empresa o persona:</label>
                                <input type="text" name="company_person_reference[]" class="form-control" value="">
                            </div>
                            <div class="col-sm-12">
                                <hr>
                            </div>
                            <div class="col-sm-6">
                                <label for="simpleinput">Nombre:</label>
                                <input type="text" name="first_name_reference[]" class="form-control" value="">
                            </div>
                            <div class="col-sm-6">
                                <label for="simpleinput">Apellido:</label>
                                <input type="text" name="last_name_reference[]" class="form-control" value="">
                            </div>
                            <div class="col-sm-6 mt-2">
                                <label for="simpleinput">Telefóno:</label>
                                <input type="text" name="phone_reference[]" class="form-control" value="">
                            </div>
                            <div class="col-sm-6 mt-2">
                                <label for="simpleinput">Empresa o persona:</label>
                                <input type="text" name="company_person_reference[]" class="form-control" value="">
                            </div>
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
                                    <option value="<?php echo $ps['provider_service_id'];?>"><?php echo $ps['name'];?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div><br>
            <div class="row">
                <div class="col-xl-8 col-lg-8 col-sm-12" style="float: none; margin: 0 auto;">
                    <div class="task-section" style="background: #fff; padding: 24px; border-radius: 25px; border: 1px solid #ccc;">
                        <h6 class="todo-content-header">
                            <i class="batch-icon-arrow-right"></i><span>Información fiscal</span>
                        </h6>
                        <div class="row">
                            <hr>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Aplica:</label>
                                    <div class="input-group">
                                        <div class="form-check" style="padding-left: 0px;">
                                            <input class="radiobutton" type="radio" name="apply_fiscal" id="radio3" value="1" checked><label class="radiobutton-label" for="radio3">Si</label>
                                        </div>
                                        <div class="form-check mr-3">
                                            <input class="radiobutton" type="radio" name="apply_fiscal" id="radio4" value="0"><label class="radiobutton-label" for="radio4">No</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 mt-2">
                                <label for="simpleinput">Lista<span style="color:red">*</span></label>
                                <select class="form-control" name="fiscal_data" required>
                                    <option value="1" selected>Sujetos a pagos trimestrales</option>
                                    <option value="2">Emisor de factura</option>
                                    <option value="3">Agentes retenedores de IVA</option>
                                    <option value="4">Pequeño contribuyente</option>
                                </select>
                            </div>
                            <div class="col-sm-12 mb-4 mt-2">
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
            </div><br>
            <div class="row">
                <div class="col-xl-8 col-lg-8 col-sm-12" style="float: none; margin: 0 auto;">
                    <div class="task-section" style="background: #fff; padding: 24px; border-radius: 25px; border: 1px solid #ccc;">
                        <h6 class="todo-content-header">
                            <i class="batch-icon-arrow-right"></i><span>Referencias bancarias</span>
                        </h6>
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="simpleinput">Banco:</label>
                                <select class="form-control" name="bank_id[]">
                                    <option value="">Seleccione una opción</option>
                                    <?php foreach($banks->result_array() as $bk):?>
                                    <option value="<?php echo $bk['bank_id'];?>"><?php echo $bk['name'];?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <label for="simpleinput">Cuenta a nombre de:</label>
                                <input type="text" name="account_name[]" class="form-control" value="">
                            </div>
                            <div class="col-sm-4">
                                <label for="simpleinput">Tipo de moneda</label>
                                <select class="form-control" name="currency_id[]">
                                    <option value="">Seleccione una opción</option>
                                    <?php foreach($currs->result_array() as $cr):?>
                                    <option value="<?php echo $cr['currency_id'];?>"><?php echo $cr['name']." (".$cr['symbol'].")";?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <label for="simpleinput">Número de cuenta:</label>
                                <input type="text" name="account_no[]" class="form-control" value="">
                            </div>
                            <div class="col-sm-4">
                                <label for="simpleinput">Tipo de cuenta</label>
                                <select class="form-control" name="account_type_id[]">
                                    <option value="">Seleccione una opción</option>
                                    <?php foreach($acctyp->result_array() as $at):?>
                                    <option value="<?php echo $at['account_type_id'];?>"><?php echo $at['name'];?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                            <div class="col-sm-12">
                                <hr>
                            </div>
                            <div class="col-sm-4">
                                <label for="simpleinput">Banco:</label>
                                <select class="form-control" name="bank_id[]">
                                    <option value="">Seleccione una opción</option>
                                    <?php foreach($banks->result_array() as $bk):?>
                                    <option value="<?php echo $bk['bank_id'];?>"><?php echo $bk['name'];?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <label for="simpleinput">Cuenta a nombre de:</label>
                                <input type="text" name="account_name[]" class="form-control" value="">
                            </div>
                            <div class="col-sm-4">
                                <label for="simpleinput">Tipo de moneda:</label>
                                <select class="form-control" name="currency_id[]">
                                    <option value="">Seleccione una opción</option>
                                    <?php foreach($currs->result_array() as $cr):?>
                                    <option value="<?php echo $cr['currency_id'];?>"><?php echo $cr['name']." (".$cr['symbol'].")";?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <label for="simpleinput">Número de cuenta:</label>
                                <input type="text" name="account_no[]" class="form-control" value="">
                            </div>
                            <div class="col-sm-4">
                                <label for="simpleinput">Tipo de cuenta:</label>
                                <select class="form-control" name="account_type_id[]">
                                    <option value="">Seleccione una opción</option>
                                    <?php foreach($acctyp->result_array() as $at):?>
                                    <option value="<?php echo $at['account_type_id'];?>"><?php echo $at['name'];?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                            <div class="col-sm-12">
                                <hr>
                            </div>
                            <div class="col-sm-4">
                                <label for="simpleinput">Banco:</label>
                                <select class="form-control" name="bank_id[]">
                                    <option value="">Seleccione una opción</option>
                                    <?php foreach($banks->result_array() as $bk):?>
                                    <option value="<?php echo $bk['bank_id'];?>"><?php echo $bk['name'];?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <label for="simpleinput">Cuenta a nombre de:</label>
                                <input type="text" name="account_name[]" class="form-control" value="">
                            </div>
                            <div class="col-sm-4">
                                <label for="simpleinput">Tipo de moneda:</label>
                                <select class="form-control" name="currency_id[]">
                                    <option value="">Seleccione una opción</option>
                                    <?php foreach($currs->result_array() as $cr):?>
                                    <option value="<?php echo $cr['currency_id'];?>"><?php echo $cr['name']." (".$cr['symbol'].")";?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <label for="simpleinput">Número de cuenta:</label>
                                <input type="text" name="account_no[]" class="form-control" value="">
                            </div>
                            <div class="col-sm-4">
                                <label for="simpleinput">Tipo de cuenta:</label>
                                <select class="form-control" name="account_type_id[]">
                                    <option value="">Seleccione una opción</option>
                                    <?php foreach($acctyp->result_array() as $at):?>
                                    <option value="<?php echo $at['account_type_id'];?>"><?php echo $at['name'];?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                            <div class="col-sm-12">
                                <hr>
                            </div>
                            <div class="col-sm-4">
                                <label for="simpleinput">Banco:</label>
                                <select class="form-control" name="bank_id[]">
                                    <option value="">Seleccione una opción</option>
                                    <?php foreach($banks->result_array() as $bk):?>
                                    <option value="<?php echo $bk['bank_id'];?>"><?php echo $bk['name'];?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <label for="simpleinput">Cuenta a nombre de:</label>
                                <input type="text" name="account_name[]" class="form-control" value="">
                            </div>
                            <div class="col-sm-4">
                                <label for="simpleinput">Tipo de moneda:</label>
                                <select class="form-control" name="currency_id[]">
                                    <option value="">Seleccione una opción</option>
                                    <?php foreach($currs->result_array() as $cr):?>
                                    <option value="<?php echo $cr['currency_id'];?>"><?php echo $cr['name']." (".$cr['symbol'].")";?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <label for="simpleinput">Número de cuenta:</label>
                                <input type="text" name="account_no[]" class="form-control" value="">
                            </div>
                            <div class="col-sm-4">
                                <label for="simpleinput">Tipo de cuenta:</label>
                                <select class="form-control" name="account_type_id[]">
                                    <option value="">Seleccione una opción</option>
                                    <?php foreach($acctyp->result_array() as $at):?>
                                    <option value="<?php echo $at['account_type_id'];?>"><?php echo $at['name'];?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                            <div class="col-sm-12 mt-4">
                                <div class="form-group m-b-15">
                                    <button class="btn btn-primary" type="submit">Guardar proveedor</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><br>
        </form>
        <form action="<?php echo base_url();?>staff/providers/new_legal/" method="POST" enctype="multipart/form-data" id="formL" style="display:none;">
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
                                    <div class="input-group date datepicker" id="DoctorPicker2">
                                        <input type="text" id="applyDate" name="application_date" autocomplete="off" style="border: 1px solid #198cff8f;" value="" class="form-control" required>
                                        <span style="display: none;" class="input-group-addon"><i data-feather="calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group m-b-15">
                                    <label for="simpleinput">Nombre completo:<span style="color:red">*</span></label>
                                    <input type="text" style="border: 1px solid #198cff8f;" name="full_name" required="" value="" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group m-b-15">
                                    <label for="simpleinput">Nombre comercial:<span style="color:red">*</span></label>
                                    <input type="text" style="border: 1px solid #198cff8f;" name="tradename" required="" value="" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group m-b-15">
                                    <label for="simpleinput">Dirección fiscal:<span style="color:red">*</span></label>
                                    <textarea type="text" style="border: 1px solid #198cff8f;" name="fiscal_address" class="form-control" required></textarea>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group m-b-15">
                                    <label for="simpleinput">Dirección comercial:</label>
                                    <textarea type="text" style="border: 1px solid #198cff8f;" name="commercial_address" class="form-control" required></textarea>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group m-b-15">
                                    <label for="simpleinput">Correo electrónico:</label>
                                    <input type="email" style="border: 1px solid #198cff8f;" name="email" value="" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group m-b-15">
                                    <label for="simpleinput">Sitio web de la empresa:</label>
                                    <input type="text" style="border: 1px solid #198cff8f;" name="email" value="" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group m-b-15">
                                    <label for="simpleinput">NIT:</label>
                                    <input type="text" style="border: 1px solid #198cff8f;" name="nit" value="" class="form-control" />
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group m-b-15">
                                    <label for="simpleinput">Código de área del teléfono:</label>
                                    <input type="number" style="border: 1px solid #198cff8f;" name="area_code" value="" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group m-b-15">
                                    <label for="simpleinput">Teléfono 1:<span style="color:red">*</span></label>
                                    <input type="text" style="border: 1px solid #198cff8f;" name="phone_1" required="" value="" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group m-b-15">
                                    <label for="simpleinput">Teléfono 2:</label>
                                    <input type="text" style="border: 1px solid #198cff8f;" name="phone_2" value="" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group m-b-15">
                                    <label for="simpleinput">Teléfono 3:</label>
                                    <input type="text" style="border: 1px solid #198cff8f;" name="phone_3" value="" class="form-control">
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
                                    <textarea type="text" style="border: 1px solid #198cff8f;" name="address" class="form-control"><?php echo $details['address'];?></textarea>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group m-b-15">
                                    <label for="simpleinput">País:<span style="color:red">*</span></label>
                                    <select class="form-control" name="country" id="country" required>
                                    <option value="Guatemala" selected>Guatemala</option>
                                </select> 
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group m-b-15">
                                    <label for="simpleinput">Departamento:<span style="color:red">*</span></label>
                                    <select class="form-control" name="departamento_id" id="department" required onchange="getMunicipalities(this, 'municipality1')">
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
                                    <select class="form-control" name="municipio_id" id="municipality1" required>


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
                            <div class="col-sm-6">
                                <label for="simpleinput">Nombre completo</label>
                                <input type="text" name="full_name_legal" class="form-control" value="">
                            </div>
                            <div class="col-sm-6">
                                <label for="simpleinput">Número DPI</label>
                                <input type="text" name="dpi_legal" class="form-control" value="">
                            </div>
                            <div class="col-sm-6 mt-2">
                                <label for="simpleinput">Patente de comercio</label>
                                <input type="text" name="commercial_patent" class="form-control" value="">
                            </div>
                            <div class="col-sm-6 mt-2">
                                <div class="form-group m-b-15">
                                    <label for="simpleinput">NIT:</label>
                                    <input type="text" style="border: 1px solid #198cff8f;" name="nit_legal" value="" class="form-control" />
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
                            <i class="batch-icon-arrow-right"></i><span>Contactos</span>
                        </h6>
                        <div class="row">
                            <hr>
                            <div class="col-sm-12">
                                <h6>Representante de ventas</h6>
                            </div>
                            <div class="col-sm-4">
                                <label for="simpleinput">Nombre:</label>
                                <input type="text" name="full_name_represent" class="form-control" value="">
                            </div>
                            <div class="col-sm-4">
                                <label for="simpleinput">Teléfono:</label>
                                <input type="text" name="phone_represent" class="form-control" value="">
                            </div>
                            <div class="col-sm-4">
                                <label for="simpleinput">Correo:</label>
                                <input type="text" name="email_represent" class="form-control" value="">
                            </div>
                            <div class="col-sm-12 mt-3">
                                <h6>Gerente de ventas</h6>
                            </div>
                            <div class="col-sm-4">
                                <label for="simpleinput">Nombre:</label>
                                <input type="text" name="full_name_manager" class="form-control" value="">
                            </div>
                            <div class="col-sm-4">
                                <label for="simpleinput">Teléfono:</label>
                                <input type="text" name="phone_manager" class="form-control" value="">
                            </div>
                            <div class="col-sm-4">
                                <label for="simpleinput">Correo:</label>
                                <input type="text" name="email_manager" class="form-control" value="">
                            </div>
                            <div class="col-sm-12 mt-3">
                                <h6>Cuentas por cobrar</h6>
                            </div>
                            <div class="col-sm-4">
                                <label for="simpleinput">Nombre:</label>
                                <input type="text" name="full_name_accounts" class="form-control" value="">
                            </div>
                            <div class="col-sm-4">
                                <label for="simpleinput">Teléfono:</label>
                                <input type="text" name="phone_accounts" class="form-control" value="">
                            </div>
                            <div class="col-sm-4">
                                <label for="simpleinput">Correo</label>
                                <input type="text" name="email_accounts" class="form-control" value="">
                            </div>
                            <div class="col-sm-12 mt-3">
                                <h6>Facturación</h6>
                            </div>
                            <div class="col-sm-4">
                                <label for="simpleinput">Nombre:</label>
                                <input type="text" name="full_name_billing" class="form-control" value="">
                            </div>
                            <div class="col-sm-4">
                                <label for="simpleinput">Teléfono:</label>
                                <input type="text" name="phone_billing" class="form-control" value="">
                            </div>
                            <div class="col-sm-4">
                                <label for="simpleinput">Correo:</label>
                                <input type="text" name="email_billing" class="form-control" value="">
                            </div>
                            <div class="col-sm-12 mt-3">
                                <h6>Finanzas</h6>
                            </div>
                            <div class="col-sm-4">
                                <label for="simpleinput">Nombre:</label>
                                <input type="text" name="full_name_finance" class="form-control" value="">
                            </div>
                            <div class="col-sm-4">
                                <label for="simpleinput">Teléfono:</label>
                                <input type="text" name="phone_finance" class="form-control" value="">
                            </div>
                            <div class="col-sm-4">
                                <label for="simpleinput">Correo:</label>
                                <input type="text" name="email_finance" class="form-control" value="">
                            </div>
                            <div class="col-sm-12 mt-3">
                                <h6>Contabilidad</h6>
                            </div>
                            <div class="col-sm-4">
                                <label for="simpleinput">Nombre:</label>
                                <input type="text" name="full_name_accounting" class="form-control" value="">
                            </div>
                            <div class="col-sm-4">
                                <label for="simpleinput">Teléfono:</label>
                                <input type="text" name="phone_accounting" class="form-control" value="">
                            </div>
                            <div class="col-sm-4">
                                <label for="simpleinput">Correo:</label>
                                <input type="text" name="email_accounting" class="form-control" value="">
                            </div>
                        </div>
                    </div>
                </div>
            </div><br>
            <div class="row">
                <div class="col-xl-8 col-lg-8 col-sm-12" style="float: none; margin: 0 auto;">
                    <div class="task-section" style="background: #fff; padding: 24px; border-radius: 25px; border: 1px solid #ccc;">
                        <h6 class="todo-content-header">
                            <i class="batch-icon-arrow-right"></i><span>Representantes comerciales</span>
                        </h6>
                        <div class="row">
                            <div class="col-sm-6">
                                <label for="simpleinput">Nombre:<span style="color:red">*</span></label>
                                <input type="text" name="first_name_reference[]" required="" class="form-control" value="">
                            </div>
                            <div class="col-sm-6">
                                <label for="simpleinput">Apellido:<span style="color:red">*</span></label>
                                <input type="text" name="last_name_reference[]" required="" class="form-control" value="">
                            </div>
                            <div class="col-sm-6 mt-2">
                                <label for="simpleinput">Telefóno<span style="color:red">*</span></label>
                                <input type="text" name="phone_reference[]" required="" class="form-control" value="">
                            </div>
                            <div class="col-sm-6 mt-2">
                                <label for="simpleinput">Empresa o persona<span style="color:red">*</span></label>
                                <input type="text" name="company_person_reference[]" required="" class="form-control" value="">
                            </div>
                            <div class="col-sm-12">
                                <hr>
                            </div>
                            <div class="col-sm-6">
                                <label for="simpleinput">Nombre:</label>
                                <input type="text" name="first_name_reference[]" class="form-control" value="">
                            </div>
                            <div class="col-sm-6">
                                <label for="simpleinput">Apellido:</label>
                                <input type="text" name="last_name_reference[]" class="form-control" value="">
                            </div>
                            <div class="col-sm-6 mt-2">
                                <label for="simpleinput">Telefóno:</label>
                                <input type="text" name="phone_reference[]" class="form-control" value="">
                            </div>
                            <div class="col-sm-6 mt-2">
                                <label for="simpleinput">Empresa o persona:</label>
                                <input type="text" name="company_person_reference[]" class="form-control" value="">
                            </div>
                            <div class="col-sm-12">
                                <hr>
                            </div>
                            <div class="col-sm-6">
                                <label for="simpleinput">Nombre:</label>
                                <input type="text" name="first_name_reference[]" class="form-control" value="">
                            </div>
                            <div class="col-sm-6">
                                <label for="simpleinput">Apellido:</label>
                                <input type="text" name="last_name_reference[]" class="form-control" value="">
                            </div>
                            <div class="col-sm-6 mt-2">
                                <label for="simpleinput">Telefóno:</label>
                                <input type="text" name="phone_reference[]" class="form-control" value="">
                            </div>
                            <div class="col-sm-6 mt-2">
                                <label for="simpleinput">Empresa o persona:</label>
                                <input type="text" name="company_person_reference[]" class="form-control" value="">
                            </div>
                            <div class="col-sm-12">
                                <hr>
                            </div>
                            <div class="col-sm-6">
                                <label for="simpleinput">Nombre:</label>
                                <input type="text" name="first_name_reference[]" class="form-control" value="">
                            </div>
                            <div class="col-sm-6">
                                <label for="simpleinput">Apellido:</label>
                                <input type="text" name="last_name_reference[]" class="form-control" value="">
                            </div>
                            <div class="col-sm-6 mt-2">
                                <label for="simpleinput">Telefóno:</label>
                                <input type="text" name="phone_reference[]" class="form-control" value="">
                            </div>
                            <div class="col-sm-6 mt-2">
                                <label for="simpleinput">Empresa o persona:</label>
                                <input type="text" name="company_person_reference[]" class="form-control" value="">
                            </div>
                            <div class="col-sm-12">
                                <hr>
                            </div>
                            <div class="col-sm-6">
                                <label for="simpleinput">Nombre:</label>
                                <input type="text" name="first_name_reference[]" class="form-control" value="">
                            </div>
                            <div class="col-sm-6">
                                <label for="simpleinput">Apellido:</label>
                                <input type="text" name="last_name_reference[]" class="form-control" value="">
                            </div>
                            <div class="col-sm-6 mt-2">
                                <label for="simpleinput">Telefóno:</label>
                                <input type="text" name="phone_reference[]" class="form-control" value="">
                            </div>
                            <div class="col-sm-6 mt-2">
                                <label for="simpleinput">Empresa o persona:</label>
                                <input type="text" name="company_person_reference[]" class="form-control" value="">
                            </div>
                            <div class="col-sm-12">
                                <hr>
                            </div>
                            <div class="col-sm-6">
                                <label for="simpleinput">Nombre:</label>
                                <input type="text" name="first_name_reference[]" class="form-control" value="">
                            </div>
                            <div class="col-sm-6">
                                <label for="simpleinput">Apellido:</label>
                                <input type="text" name="last_name_reference[]" class="form-control" value="">
                            </div>
                            <div class="col-sm-6 mt-2">
                                <label for="simpleinput">Telefóno:</label>
                                <input type="text" name="phone_reference[]" class="form-control" value="">
                            </div>
                            <div class="col-sm-6 mt-2">
                                <label for="simpleinput">Empresa o persona:</label>
                                <input type="text" name="company_person_reference[]" class="form-control" value="">
                            </div>
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
                                    <option value="<?php echo $ps['provider_service_id'];?>"><?php echo $ps['name'];?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div><br>
            <div class="row">
                <div class="col-xl-8 col-lg-8 col-sm-12" style="float: none; margin: 0 auto;">
                    <div class="task-section" style="background: #fff; padding: 24px; border-radius: 25px; border: 1px solid #ccc;">
                        <h6 class="todo-content-header">
                            <i class="batch-icon-arrow-right"></i><span>Información fiscal</span>
                        </h6>
                        <div class="row">
                            <hr>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Aplica:</label>
                                    <div class="input-group">
                                        <div class="form-check" style="padding-left: 0px;">
                                            <input class="radiobutton" type="radio" name="apply_fiscal_legal" id="radio5" value="1" checked><label class="radiobutton-label" for="radio5">Si</label>
                                        </div>
                                        <div class="form-check mr-3">
                                            <input class="radiobutton" type="radio" name="apply_fiscal_legal" id="radio6" value="0"><label class="radiobutton-label" for="radio6">No</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <label for="simpleinput">Lista<span style="color:red">*</span></label>
                                <select class="form-control" name="fiscal_data" required>
                                    <option value="1" selected>Sujetos a pagos trimestrales</option>
                                    <option value="2">Emisor de factura</option>
                                    <option value="3">Agentes retenedores de IVA</option>
                                    <option value="4">Pequeño contribuyente</option>
                                </select>
                            </div>
                            <div class="col-sm-12 mb-4 mt-2">
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
            </div><br>
            <div class="row">
                <div class="col-xl-8 col-lg-8 col-sm-12" style="float: none; margin: 0 auto;">
                    <div class="task-section" style="background: #fff; padding: 24px; border-radius: 25px; border: 1px solid #ccc;">
                        <h6 class="todo-content-header">
                            <i class="batch-icon-arrow-right"></i><span>Referencias bancarias</span>
                        </h6>
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="simpleinput">Banco:<span style="color:red">*</span></label>
                                <select class="form-control" name="bank_id[]">
                                    <option value="">Seleccione una opción</option>
                                    <?php foreach($banks->result_array() as $bk):?>
                                    <option value="<?php echo $bk['bank_id'];?>"><?php echo $bk['name'];?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <label for="simpleinput">Cuenta a nombre de:<span style="color:red">*</span></label>
                                <input type="text" name="account_name[]" class="form-control" value="">
                            </div>
                            <div class="col-sm-4">
                                <label for="simpleinput">Tipo de moneda<span style="color:red">*</span></label>
                                <select class="form-control" name="currency_id[]">
                                    <option value="">Seleccione una opción</option>
                                    <?php foreach($currs->result_array() as $cr):?>
                                    <option value="<?php echo $cr['currency_id'];?>"><?php echo $cr['name']." (".$cr['symbol'].")";?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                            <div class="col-sm-4 mt-2">
                                <label for="simpleinput">Número de cuenta:<span style="color:red">*</span></label>
                                <input type="text" name="account_no[]" required="" class="form-control" value="">
                            </div>
                            <div class="col-sm-4">
                                <label for="simpleinput">Tipo de cuenta<span style="color:red">*</span></label>
                                <select class="form-control" name="account_type_id[]" required>
                                    <option value="">Seleccione una opción</option>
                                    <?php foreach($acctyp->result_array() as $at):?>
                                    <option value="<?php echo $at['account_type_id'];?>"><?php echo $at['name'];?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                            <div class="col-sm-12">
                                <hr>
                            </div>
                            <div class="col-sm-4">
                                <label for="simpleinput">Banco:</label>
                                <select class="form-control" name="bank_id[]">
                                    <option value="">Seleccione una opción</option>
                                    <?php foreach($banks->result_array() as $bk):?>
                                    <option value="<?php echo $bk['bank_id'];?>"><?php echo $bk['name'];?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <label for="simpleinput">Cuenta a nombre de:</label>
                                <input type="text" name="account_name[]" class="form-control" value="">
                            </div>
                            <div class="col-sm-4">
                                <label for="simpleinput">Tipo de moneda:</label>
                                <select class="form-control" name="currency_id[]">
                                    <option value="">Seleccione una opción</option>
                                    <?php foreach($currs->result_array() as $cr):?>
                                    <option value="<?php echo $cr['currency_id'];?>"><?php echo $cr['name']." (".$cr['symbol'].")";?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                            <div class="col-sm-4 mt-2">
                                <label for="simpleinput">Número de cuenta:</label>
                                <input type="text" name="account_no[]" class="form-control" value="">
                            </div>
                            <div class="col-sm-4">
                                <label for="simpleinput">Tipo de cuenta:</label>
                                <select class="form-control" name="account_type_id[]">
                                    <option value="">Seleccione una opción</option>
                                    <?php foreach($acctyp->result_array() as $at):?>
                                    <option value="<?php echo $at['account_type_id'];?>"><?php echo $at['name'];?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                            <div class="col-sm-12">
                                <hr>
                            </div>
                            <div class="col-sm-4">
                                <label for="simpleinput">Banco:</label>
                                <select class="form-control" name="bank_id[]">
                                    <option value="">Seleccione una opción</option>
                                    <?php foreach($banks->result_array() as $bk):?>
                                    <option value="<?php echo $bk['bank_id'];?>"><?php echo $bk['name'];?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <label for="simpleinput">Cuenta a nombre de:</label>
                                <input type="text" name="account_name[]" class="form-control" value="">
                            </div>
                            <div class="col-sm-4">
                                <label for="simpleinput">Tipo de moneda:</label>
                                <select class="form-control" name="currency_id[]">
                                    <option value="">Seleccione una opción</option>
                                    <?php foreach($currs->result_array() as $cr):?>
                                    <option value="<?php echo $cr['currency_id'];?>"><?php echo $cr['name']." (".$cr['symbol'].")";?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                            <div class="col-sm-4 mt-2">
                                <label for="simpleinput">Número de cuenta:</label>
                                <input type="text" name="account_no[]" class="form-control" value="">
                            </div>
                            <div class="col-sm-4">
                                <label for="simpleinput">Tipo de cuenta:</label>
                                <select class="form-control" name="account_type_id[]">
                                    <option value="">Seleccione una opción</option>
                                    <?php foreach($acctyp->result_array() as $at):?>
                                    <option value="<?php echo $at['account_type_id'];?>"><?php echo $at['name'];?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                            <div class="col-sm-12">
                                <hr>
                            </div>
                            <div class="col-sm-4">
                                <label for="simpleinput">Banco:</label>
                                <select class="form-control" name="bank_id[]">
                                    <option value="">Seleccione una opción</option>
                                    <?php foreach($banks->result_array() as $bk):?>
                                    <option value="<?php echo $bk['bank_id'];?>"><?php echo $bk['name'];?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <label for="simpleinput">Cuenta a nombre de:</label>
                                <input type="text" name="account_name[]" class="form-control" value="">
                            </div>
                            <div class="col-sm-4">
                                <label for="simpleinput">Tipo de moneda:</label>
                                <select class="form-control" name="currency_id[]">
                                    <option value="">Seleccione una opción</option>
                                    <?php foreach($currs->result_array() as $cr):?>
                                    <option value="<?php echo $cr['currency_id'];?>"><?php echo $cr['name']." (".$cr['symbol'].")";?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                            <div class="col-sm-4 mt-2">
                                <label for="simpleinput">Número de cuenta:</label>
                                <input type="text" name="account_no[]" class="form-control" value="">
                            </div>
                            <div class="col-sm-4">
                                <label for="simpleinput">Tipo de cuenta:</label>
                                <select class="form-control" name="account_type_id[]">
                                    <option value="">Seleccione una opción</option>
                                    <?php foreach($acctyp->result_array() as $at):?>
                                    <option value="<?php echo $at['account_type_id'];?>"><?php echo $at['name'];?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div><br>
            <div class="row">
                <div class="col-xl-8 col-lg-8 col-sm-12" style="float: none; margin: 0 auto;">
                    <div class="task-section" style="background: #fff; padding: 24px; border-radius: 25px; border: 1px solid #ccc;">
                        <h6 class="todo-content-header">
                            <i class="batch-icon-arrow-right"></i><span>Información de pago:</span>
                        </h6>
                        <div class="row">
                            <hr>
                            <div class="col-sm-12">
                                <label for="simpleinput">Días de crédito:</label>
                                <input type="number" class="form-control" name="credit_days" min="0" max="" value="" />
                            </div>
                        </div>
                    </div>
                </div>
            </div><br>
            <div class="row">
                <div class="col-xl-8 col-lg-8 col-sm-12" style="float: none; margin: 0 auto;">
                    <div class="task-section" style="background: #fff; padding: 24px; border-radius: 25px; border: 1px solid #ccc;">
                        <h6 class="todo-content-header">
                            <i class="batch-icon-arrow-right"></i><span>Documentos:</span>
                        </h6>
                        <div class="row">
                            <hr>
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
                                    <button class="btn btn-primary" type="submit">Guardar proveedor</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><br>
        </form>
    </div>
</div>
<script src="<?php echo base_url();?>public/assets/back/js/jquery-3.1.1.min.js"></script>
<script src="<?php echo base_url();?>public/assets/theme/input/jquery.fileuploader.min.js" type="text/javascript"></script>
<script>
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
            url: "<?php echo base_url();?>staff/get_municipio/" + depto_id,
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

$('input[type=radio][name=type_provider]').change(function() {
    if (this.value == 1) {
        $("#formS").show(300);
        $("#formL").hide(300);
    } else if (this.value == 2) {
        $("#formS").hide(300);
        $("#formL").show(300);
    }
});

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
            window.location.replace("<?php echo base_url();?>staff/providers/");
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

$("#formL").submit(function(e) {
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
            window.location.replace("<?php echo base_url();?>staff/providers/");
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
        url: '<?php echo base_url(); ?>staff/get_municipio/' + coleccion,
        success: function(response) {
            jQuery('#municipality_company').html(response);
        }
    });
}
</script>