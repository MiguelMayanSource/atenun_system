    <?php $current = $this->db->get_where('suscription', array('code' => $code))->result_array();
        foreach($current as $row):
    ?>
    <div class="white-box">
        <div class="os-tabs-w">
            <div class="os-tabs-controls">
                <ul class="navx nav-tabs">
                    <li class="nav-item text-center">
                        <a class="nav-link current" href="<?php echo base_url();?>admin/settings/">
                            <div class="navWidget"><i class="picons-thin-icon-thin-0049_settings_panel_equalizer_preferences"></i></div> <span>Configuración</span>
                        </a>
                    </li>
                    <li class="nav-item text-center">
                        <a class="nav-link" href="<?php echo base_url();?>admin/services/">
                            <div class="navWidget"><i class="picons-thin-icon-thin-0813_heart_vitals_pulse_rate_health"></i></div> <span>Servicios</span>
                        </a>
                    </li>
                    <li class="nav-item text-center">
                        <a class="nav-link" href="<?php echo base_url();?>admin/specialties/">
                            <div class="navWidget"><i class="picons-thin-icon-thin-0825_stetoscope_doctor_hospital_ill"></i></div><span>Especialidades</span>
                        </a>
                    </li>
                    <li class="nav-item text-center">
                        <a class="nav-link" href="<?php echo base_url();?>admin/laboratories/">
                            <div class="navWidget"><i class="picons-thin-icon-thin-0817_tube_laboratory_chemistry"></i></div><span>Laboratorios</span>
                        </a>
                    </li>
                    <li class="nav-item text-center">
                        <a class="nav-link" href="<?php echo base_url();?>admin/third/">
                            <div class="navWidget"><i class="picons-thin-icon-thin-0726_doctor_surgery_hospital"></i></div><span>Terceros</span>
                        </a>
                    </li>
                    <li class="nav-item text-center">
                        <a class="nav-link" href="<?php echo base_url();?>admin/surveys/">
                            <div class="navWidget"><i class="picons-thin-icon-thin-0065_bullet_list_view"></i></div><span>Encuestas</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="app-email-w" style="background-color:#f6f7f8;">
        <div class="app-email-i">
            <div class="ae-side-menu">
                <div class="aem-head">
                    <a class="ae-side-menu-toggler" href="javascript:void(0);" style="color:#000;"><i class="os-icon picons-thin-icon-thin-0069a_menu_hambuger" style="font-size:20px;"></i></a>
                </div>
                <ul class="ae-main-menu">
                    <li data-toggle="tooltip" data-placement="right" title="Configuración"><a href="<?php echo base_url();?>admin/settings/"><i class="app-icons picons-thin-icon-thin-0031_pin_bookmark"></i><span>Configuración</span></a></li>
                    <li class="active" data-toggle="tooltip" data-placement="right" title="Suscripción"><a href="<?php echo base_url();?>admin/subscription/"><i class="app-icons picons-thin-icon-thin-0031_pin_bookmark"></i><span>Suscripción</span></a></li>
                    <li data-toggle="tooltip" data-placement="right" title="Formularios"><a href="<?php echo base_url();?>admin/forms/"><i class="app-icons picons-thin-icon-thin-0031_pin_bookmark"></i><span>Formularios</span></a></li>
                    <li data-toggle="tooltip" data-placement="right" title="Sucursales"><a href="<?php echo base_url();?>admin/clinics/"><i class="app-icons picons-thin-icon-thin-0031_pin_bookmark"></i><span>Sucursales</span></a></li>
                </ul>
            </div>
            <div class="pageContent2">
                <div class="row">
                    <div class="col-md-12">
                        <div class="order-box">
                            <div class="row">
                                <div class="col-sm-12 text-center">
                                    <?php if($type == 'pg'):?>
                                    <img src="<?php echo base_url();?>style/back/images/alert.png" style="width:80px">
                                    <p>Tienes una factura pendiente, completa el pago con la información de abajo:</p>
                                    <?php else:?>
                                    <img src="<?php echo base_url();?>style/back/images/check.png" style="width:80px">
                                    <h4>Solicitud recibida</h4>
                                    <p>Encontrarás la información de pago más abajo:</p>
                                    <?php endif;?>
                                </div>
                                <div class="col-sm-12">
                                    <table style="width:100%" class="table table-striped">
                                        <tr>
                                            <td><b>Total a pagar:</b></td>
                                            <td style="text-align:right">$<?php echo $row['total_amount'];?>USD</td>
                                        </tr>
                                        <tr>
                                            <td><b>Método:</b></td>
                                            <?php if($row['method'] == 'bi'):?>
                                            <td style="text-align:right">Banco Industrial <img src="<?php echo base_url();?>style/back/images/bi.png" width="25"></td>
                                            <?php elseif($row['method'] == 'ban'):?>
                                            <td style="text-align:right">Banrural S.A <img src="<?php echo base_url();?>style/back/images/banru.png" width="25"></td>
                                            <?php elseif($row['method'] == 'pp'):?>
                                            <td style="text-align:right">PayPal <img src="<?php echo base_url();?>style/back/images/paypal.png" width="25"></td>
                                            <?php elseif($row['method'] == 'visa'):?>
                                            <td style="text-align:right">Tarjeta de Crédito/Débito <img src="<?php echo base_url();?>style/back/images/visa.png" width="25"></td>
                                            <?php endif;?>
                                        </tr>
                                        <tr>
                                            <td><b>Tipo de cuenta:</b></td>
                                            <td style="text-align:right"><?php echo $this->crud_model->getAccountInfo('account_type',$row['method']);?></td>
                                        </tr>
                                        <tr>
                                            <td><b>Nombre de cuenta:</b></td>
                                            <td style="text-align:right"><?php echo $this->crud_model->getAccountInfo('name',$row['method']);?></td>
                                        </tr>
                                        <tr>
                                            <td><b>Número de cuenta:</b></td>
                                            <td style="text-align:right"><?php echo $this->crud_model->getAccountInfo('account',$row['method']);?></td>
                                        </tr>
                                        <tr>
                                            <td><b>Moneda:</b></td>
                                            <td style="text-align:right"><?php echo $this->crud_model->getAccountInfo('currency',$row['method']);?></td>
                                        </tr>
                                        <tr>
                                            <td><b>NOTA:</b></td>
                                            <td style="text-align:right">Tu plan será actualizado una vez hayamos confirmado tu pago.</td>
                                        </tr>
                                        <tr>
                                            <td><b>Estado:</b></td>
                                            <?php if($row['status'] == 0):?>
                                            <td style="text-align:right"><b style="color:red">Pendiente</b></td>
                                            <?php else:?>
                                            <td style="text-align:right"><b style="color:#528410;">Completado</b></td>
                                            <?php endif;?>
                                        </tr>
                                    </table>
                                    <?php if($row['status'] == 0):?>
                                    <a class="btn btn-danger" onclick="return confirm('¿Estás seguro que deseas cancelar la factura? Tu suscripción no se completará y deberás crear una nueva.');" style="color:#fff;" href="<?php echo base_url();?>admin/subscription/cancel/<?php echo $row['code'];?>">Cancelar esta factura <i class="picons-thin-icon-thin-0153_delete_exit_remove_close"></i> </a><br><br>
                                    <?php else:?>
                                    <a class="btn btn-primary" style="color:#fff;" href="<?php echo base_url();?>admin/panel/">Regresar a tu tablero <i class="picons-thin-icon-thin-0160_arrow_next_right"></i> </a><br><br>
                                    <?php endif;?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach;?>