<link rel="stylesheet" href="<?php echo base_url();?>public/assets/search/estilo.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<style>
a img {
    max-width: 50px;
    -webkit-transition: all 0.25s ease;
    transition: all 0.25s ease;
}

a img:hover {
    -webkit-transform: translateY(-5px) scale(1.02);
    transform: translateY(-5px) scale(1.02);
}

input[type="radio"] {
    width: 30px;
    height: 30px;
    border-radius: 15px;
    border: 2px solid #0844e98a;
    background-color: white;
    -webkit-appearance: none;
    /*to disable the default appearance of radio button*/
    -moz-appearance: none;
}

input[type="radio"]:focus {
    /*no need, if you don't disable default appearance*/
    outline: none;
    /*to remove the square border on focus*/
}

input[type="radio"]:checked {
    /*no need, if you don't disable default appearance*/
    background-color: #0844e98a;
}

input[type="radio"]:checked~span:first-of-type {
    color: white;
}

label span:first-of-type {
    position: relative;
    left: -24px;
    font-size: 15px;
    font-weight: 700;
    color: #0844e98a;
}

label span {

    position: relative;
    top: -10px;
}

.lbl {
    margin-right: -10px;
    margin-bottom: 0px !important;
}
</style>
<script>
$(".prejoin-preview-status").css("background", "#e20016!important");
</script>

<?php 
    $treatment_id = base64_decode($id_);
    $this->db->where('treatment_id', $treatment_id);
    $info = $this->db->get('odonto_treatment')->result_array();    
    foreach($info as $details):
    
    $patient_id             = $details['patient_id'];
    $ex                     = $this->crud_model->appointment_status_treatment($details['treatment_id']);
    $exp                    = explode('-', $ex);
    $stat                   = $exp[0];
    $appointment_id         = $exp[1];
    $practice               = $this->db->get_where('appointment', array('appointment_id' => $appointment_id))->row()->practice;
    $currency               = $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->currency;
    $appointment_comment    = $this->db->get_where('appointment', array('appointment_id' => $appointment_id))->row()->doctor_comment;
    $appoints               = $this->db->get_where('appointment', array('treatment_id' => $treatment_id))->result_array();
    $consulta               = 0;
    if($practice > 0)
    {
        $consulta               = $this->db->get_where('service', array('service_id' => $practice))->row()->cost;
    }
    $totalfinal = $consulta;
    $cts_ant = 0;
    $abonos = 0;
?>

<div class="todo-app-w">
    <div class="todo-sidebar">
        <div id="sticky">
            <div class="todo-sidebar-section" style="border-bottom:0px">
                <div class="todo-sidebar-section-contents">
                    <ul class="tasks-list">
                        <li class="side-li">
                            <a class="side-items" href="<?php echo base_url();?>staff/patient_profile/<?php echo base64_encode($details['patient_id']);?>/"><i class="side-icon picons-thin-icon-thin-0002_write_pencil_new_edit"></i> Editar perfil </a>
                        </li>
                        <li class="side-li">
                            <a class="side-items" href="<?php echo base_url();?>staff/medical_history/<?php echo base64_encode($details['patient_id']);?>/"><i class="side-icon picons-thin-icon-thin-0299_address_book_contacts"></i> Historial </a>
                        </li>
                        <li class="side-li">
                            <a class="side-items" href="<?php echo base_url();?>staff/patient_security/<?php echo base64_encode($details['patient_id']);?>/"><i class="side-icon picons-thin-icon-thin-0705_user_profile_security_password_permissions"></i> Contraseña y seguridad </a>
                        </li>
                        <li class="side-li">
                            <a class="side-items" href="<?php echo base_url();?>staff/medical_prescriptions/<?php echo base64_encode($details['patient_id']);?>/"><i class="side-icon picons-thin-icon-thin-0003_write_pencil_new_edit"></i> Recetas </a>
                        </li>
                        <li class="side-li">
                            <a class="side-items" href="<?php echo base_url();?>staff/patient_files/<?php echo base64_encode($details['patient_id']);?>/"><i class="side-icon picons-thin-icon-thin-0119_folder_open_full_documents"></i> Archivos </a>
                        </li>
                        <li class="side-li">
                            <a class="side-items active" href="<?php echo base_url();?>staff/treatment/<?php echo base64_encode($details['patient_id']);?>/"><i class="side-icon picons-thin-icon-thin-0826_teeth_tooth_dental"></i> Planes de tratamiento <span class="side-active"></span></a>
                        </li>
                        <li class="side-li">
                            <a class="side-items" href="<?php echo base_url();?>staff/patient_appointments/<?php echo base64_encode($details['patient_id']);?>/"><i class="side-icon picons-thin-icon-thin-0021_calendar_month_day_planner"></i> Citas </a>
                        </li>
                        <li class="side-li">
                            <a class="side-items" href="<?php echo base_url();?>staff/patient_financial/<?php echo base64_encode($details['patient_id']);?>/"><i class="side-icon picons-thin-icon-thin-0425_money_payment_dollar_cash"></i> Financiero </a>
                        </li>
                        <li class="side-li" style="border:none"></li>
                        <li class="side-li" style="border:none"></li>
                    </ul>

                </div>
            </div>
        </div>
    </div>
    <style>
    a img {
        max-width: 45px;
        max-height: 90px;
        -webkit-transition: all 0.25s ease;
        transition: all 0.25s ease;
    }

    a img:hover {
        -webkit-transform: translateY(-5px) scale(1.02);
        transform: translateY(-5px) scale(1.02);
    }
    </style>
    <div class="todo-content" style="background-color: #f0f0f8;padding-bottom: 15%;">
        <h4 class="todo-content-header">
            <a href="<?php echo base_url();?>staff/treatment/<?php echo base64_encode($patient_id);?>"><i class="batch-icon-arrow-left"></i></a> <span>Detalles del tratamiento - <?php echo $details['name'];?></span>
        </h4>

        <a class="add-buton pull-right" href="javascript:void(0);" onclick="modal_lg('<?php echo base_url();?>modal/popup/modal_medical_history/<?php echo $patient_id?>');">Historial medico</a>
        <span class="app-divider2"></span>
        <form action="<?php echo base_url();?>staff/update_treatment" method="POST">
            <div class="row">
                <div class="col-sm-12">
                    <div class="alert alert-info">
                        <span class="alert-title"><i class="batch-icon-spam"></i> Iniciar plan.</span>
                        <span class="alert-content">Asegúrate de asociar los tratamientos a las piezas afectadas correctamente antes de guardar los <span class="alert-lined"><a href="javascript:void(0);" style="color:#0044e9">cambios</a>.</span></span>
                    </div>
                </div>
                <?php 
                $this->db->order_by('allergie_id', 'desc');
                $this->db->where('patient_id',$patient_id);
                $allergies = $this->db->get('allergie');
                if($allergies->num_rows() > 0):
            ?>
                <div class="col-sm-12">
                    <div class="alert alert-danger">
                        <span class="alert-title"><i class="batch-icon-spam"></i>ALERGIAS.</span>
                        <span class="alert-content">Antes de cualquier procedimiento tome en cuenta lo siguientes alergias del paciente.</span>
                        <?php  ?>
                        <ul>
                            <?php 
                        foreach($allergies->result_array() as $row):
                        ?>
                            <li> <?php echo $row['name'];?><a href="javascript:void(0):" onclick="delete_allergie('<?php echo $row['allergie_id'];?>')"></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
                <?php endif;?>
            </div>
            <div class="col-sm-12">
                <?php if($this->crud_model->treatmentss($details['treatment_id']) > 0):?>
                <a class="btn btn-primary pull-right" style="margin-right: 22px;" onclick="window.location.href='<?php echo base_url();?>staff/treatment_archive/pdf/<?php echo $details['treatment_id'];?>/<?php echo $patient_id;?>';" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="Descargar pdf"><i class="side-icon picons-thin-icon-thin-0123_download_cloud_file_sync"></i></a>
                <a class="btn btn-danger pull-right" style="margin-right: 10px;" onclick="window.open('<?php echo base_url();?>staff/treatment_archive/email/<?php echo $details['treatment_id'];?>/<?php echo $patient_id;?>');" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="Enviar recibo por correo"><i class="side-icon picons-thin-icon-thin-0315_email_mail_post_send"></i></a>
                <?php endif;?>
                <h4>Paciente: <?php echo $this->accounts_model->get_name('patient',$patient_id);?>.</h4>
                <span class="app-divider2"></span>
                <?php if($details['status'] != 2):?>
                <div class="card-widget" style="background:#1399f938;">
                    <h5 class="panel-content-title">Odontograma</h5>
                    <span class="app-divider2"></span>
                    <div class="row">
                        <?php include 'plan_odonto.php';?>
                    </div>
                </div>
                <?php endif;?>
                <?php 
                        $this->db->group_by('tooth_id');
                        $this->db->where('odonto_treatment_id', $details['treatment_id']);
                        $refresh_query = $this->db->get('tooth_treatment');
                        $final = 0;
                        if($refresh_query->num_rows() > 0):
                         $final = $this->crud_model->sum_treats($details['treatment_id']);   
                    ?>
                <style>
                .table th {
                    padding: 10px 10px 10px 10px !important;
                }

                .table td {
                    padding: 10px 10px 0px 10px !important;
                }
                </style>
                <div class="card-widget" id="resumen" style="border: 1px solid #c6c6cc;">
                    <h5 class="panel-content-title">Tratamientos actuales</h5>
                    <span class="app-divider2"></span>
                    <div class="table-responsive">
                        <div class="col-sm-12">
                            <table class="table table-bordered">
                                <tr style="color:#59636d">
                                    <th>Pieza</th>
                                    <th>Procedimiento</th>
                                    <th>Fecha</th>
                                    <th>Descripción</th>
                                    <th>Estado</th>
                                    <th>Total</th>
                                </tr>
                                <?php 
                            		
                            		    foreach($refresh_query->result_array() as $tr):
                            		    $tot = 0;
                                        $st = 0;
                                        $this->db->where('tooth_id', $tr['tooth_id']);
                                        $this->db->where('odonto_treatment_id', $details['treatment_id']);
                                        $treat = $this->db->get('tooth_treatment');
                                    ?>

                                <?php   
                                    if(count($appoints)>=2)
                                    {
                                        foreach($appoints as $nrs)
                                        {
                                            if($nrs['appointment_id'] != $appointment_id)
                                            {
                                                $cts_ant += $this->db->get_where('service', array('service_id' => $nrs['practice'] ))->row()->cost;
                                            }
                                        }
                                    }
                                    $abonos = $this->crud_model->total_pay_credits($patient_id,$details['treatment_id']);
                                    $totalfinal = ($final-$details['discount']-$abonos)+($consulta+$cts_ant);
                                    ?>
                                <tr style="font-size:14px">
                                    <td><?php echo  $tr['tooth_id'];?> </td>
                                    <td>
                                        <ul style="padding-left: 17px!important;">
                                            <?php foreach($treat->result_array() as $row):?>

                                            <li>
                                                <?php if($row['status'] > 0):?>
                                                <i style="color:#0044e9;font-weight:bold;" class="picons-thin-icon-thin-0154_ok_successful_check" data-toggle="tooltip" data-placement="top" title="Finalizado"></i>
                                                <?php else:?>
                                                <?php $st++;?>
                                                <i style="color:grey;font-weight:bold;" onClick="set_status('<?php echo $row['tooth_treatment_id'];?>','<?php echo $details['treatment_id'];?>')" class="picons-thin-icon-thin-0154_ok_successful_check" data-toggle="tooltip" data-placement="top" title="¿Marcar como finalizado?"></i>
                                                <?php endif;?>
                                                <?php $price = $this->db->get_where('process', array('process_id' => $row['process']))->row()->price;
                                                if($row['status'] == 0 && $totalfinal != 0 && $price <= $totalfinal):?>
                                                <i style="color:#fd4f57;font-weight:bold;" onClick="tooth_delete('<?php echo $row['tooth_treatment_id'];?>')" class="picons-thin-icon-thin-0056_bin_trash_recycle_delete_garbage_empty" data-toggle="tooltip" data-placement="top" title="Eliminar procedimiento"></i>
                                                <?php endif;?>
                                                <?php echo $this->db->get_where('process', array('process_id' => $row['process']))->row()->name;?>
                                                <?php $tot += $price; ?>
                                            </li>
                                            <?php endforeach;?>
                                        </ul>
                                    </td>
                                    <td><span class="smaller lighter"><?php echo $tr['date'];?></span></td>
                                    <td><span class="smaller lighter"><?php echo $tr['comment'];?></span></td>
                                    <?php if($st>0):?>
                                    <td> <span class="smaller lighter">En progreso</span> </td>
                                    <?php else:?>
                                    <td> <span class="smaller lighter">Finalizado</span></td>
                                    <?php endif;?>
                                    <td><?php echo $currency;?>. <?php echo number_format($tot,'2', '.', ',');?></td>
                                </tr>
                                <?php endforeach;?>
                            </table>
                        </div>
                    </div>
                </div>
                <?php else:?>
                <?php   
                if(count($appoints)>=2)
                {
                    foreach($appoints as $nrs)
                    {
                        if($nrs['appointment_id'] != $appointment_id)
                        {
                            $cts_ant += $this->db->get_where('service', array('service_id' => $nrs['practice'] ))->row()->cost;
                        }
                    }
                }
                $abonos = $this->crud_model->total_pay_credits($patient_id,$details['treatment_id']);
                $totalfinal = ($final-$details['discount']-$abonos)+($consulta+$cts_ant);
                ?>
                <?php endif;?>

                <?php $prescrips = $this->crud_model->num_prescriptions($details['patient_id'], $treatment_id);
                if(count($prescrips) > 0 && $details['status'] == 2):?>
                <div class="card-widget" style="border: 1px solid #c6c6cc;">
                    <h5 class="panel-content-title">Receta de medicamentos</h5>
                    <span class="app-divider2"></span>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-sm-12">
                                    <?php 
                                     foreach($appoints as $bn):
                                         
                                     $refresh_query  = $this->db->get_where('prescription',array('appointment_id' => $bn['appointment_id']));
                                     if($refresh_query->num_rows() > 0):?>

                                    <label><b>Medicamentos de la fecha: <?php echo $bn['date'];?></b></label>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <tr style="background-color:#f9fbfc; color:#59636d">
                                                <th>Medicamento</th>
                                                <th>Tomar</th>
                                                <th>Frecuencia</th>
                                                <th>Duración</th>
                                            </tr>
                                            <?php foreach($refresh_query->result_array() as $row): ?>
                                            <tr>
                                                <td><?php echo $row['medicine']; ?></td>
                                                <td><?php echo $row['quantity'] ?></td>
                                                <td><?php echo $row['frequency'] ?></td>
                                                <td><?php echo $row['duration'] ?></td>
                                            </tr><?php endforeach;?>
                                        </table>
                                    </div><br>
                                    <?php  endif;endforeach;?>
                                </div>
                            </div>
                            <hr>
                        </div>
                    </div>
                </div>
                <?php elseif($this->db->get_where('prescription', array('patient_id' => $details['patient_id'], 'appointment_id' => $appointment_id))->num_rows() < 1 && $details['status'] == 2):?>
                <br>
                <?php else:?>
                <input type="hidden" name="appointment_id" id="appointment_id" value="<?php echo $appointment_id;?>">
                <input type="hidden" name="patient_id" id="patient_id" value="<?php echo $patient_id; ?>">
                <input type="hidden" name="saldo_final" id="saldo_final" value="<?php echo $totalfinal; ?>">
                <div class="card-widget" style="border: 1px solid #c6c6cc;">
                    <h5 class="panel-content-title">Receta de medicamentos</h5>
                    <span class="app-divider2"></span>
                    <div class="row" style="overflow-x:auto">
                        <div class="col-md-12">
                            <div class="row">
                                <?php if($details['status'] != 2):?>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Medicamento</label>
                                        <input type="text" class="form-control" placeholder="Medicamento" autocomplete="off" id="medicine" />
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Tomar</label>
                                        <input type="text" class="form-control" autocomplete="off" id="drink" placeholder="Cantidad" />
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Frecuencia</label>
                                        <input type="text" class="form-control" autocomplete="off" id="frequency" placeholder="Cada " />
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Duración</label>
                                        <input type="text" class="form-control" autocomplete="off" id="duration" placeholder="Durante" />
                                    </div>
                                </div>
                                <hr>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <a class="btn btn-info" id="submit_button" href="javascript:void(0);">+</a>
                                    </div>
                                </div>

                                <?php endif; ?>
                                <div class="col-sm-12" id="table_results">
                                    <table class="table">
                                        <tr style="background-color:#f9fbfc; color:#59636d">
                                            <th>Medicamento</th>
                                            <th>Tomar</th>
                                            <th>Frecuencia</th>
                                            <th>Duración</th>
                                            <th>--</th>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <hr>
                        </div>
                    </div>
                </div>
                <?php endif;?>
            </div>

            <div class="col-sm-12">
                <div class="card-widget" style="border: 1px solid #c6c6cc;">
                    <h5 class="panel-content-title">Comentarios</h5>
                    <span class="app-divider2"></span>
                    <div class="row">
                        <div class="col-sm-6">
                            <label>Indicaciones médicas de la cita:</label>
                            <textarea id="ckeditorEmail" <?php if($details['status'] == '2'):?>readonly="" <?php endif;?> name="commentary"><?php echo $appointment_comment; ?></textarea>
                        </div>
                        <div class="col-sm-6">
                            <label>Notas <small><b>(para uso administrativo)</b></small></label>
                            <textarea id="ckeditor11" <?php if($details['status'] == '2'):?>readonly="" <?php endif;?> name="commentary2"><?php echo $details['commentary_priv']; ?></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-12" id="resumen2">
                <div class="row">
                    <div class="col-md-6 ml-auto">
                        <div class="card-widget" style="border: 1px solid #c6c6cc;">
                            <?php
                                $this->db->order_by('payment_credit_id', 'DESC');
                                $refresh_query = $this->db->get_where('payment_credit', array('patient_id' => $patient_id, 'tooth_treatment_id' => $details['treatment_id']))->result_array(); 
                                if(count($refresh_query) > 0 ):
                            ?>
                            <h5 class="panel-content-title">Abonos</h5>
                            <span class="app-divider2"></span>
                            <div class="table-responsive">
                                <table class="table table-padded">
                                    <tr style="color:#59636d">
                                        <th>ID</th>
                                        <th>Fecha</th>
                                        <th>Hora</th>
                                        <th>Ingresado por</th>
                                        <th>Cantidad</th>
                                        <th>Detalles</th>
                                        <?php if($details['status'] != '2'):?>
                                        <th>Eliminar</th>
                                        <?php endif;?>
                                    </tr>
                                    <?php 
                                		    $total = 0;
                                		  
                                		    foreach($refresh_query as $tr):
                                            $total +=  $tr['amount'];
                                        ?>
                                    <tr style="font-size:14px">
                                        <td><?php echo  $tr['payment_credit_id'];?> </td>
                                        <td><span class="smaller lighter"><?php echo date('d/m/Y', strtotime($tr['date']));?></span></td>
                                        <td><span class="smaller lighter"><?php echo $tr['time'];?></span></td>
                                        <?php if($tr['user_type'] == 'doctor'):?>
                                        <td><span class="smaller lighter"><?php echo $this->accounts_model->short_name('admin', $tr['user_id']);?></span></td>
                                        <?php else:?>
                                        <td><span class="smaller lighter"><?php echo $this->accounts_model->short_name($tr['user_type'], $tr['user_id']);?></span></td>
                                        <?php endif;?>
                                        <td> <span class="smaller lighter"><?php echo $currency.'. '.number_format($tr['amount'],'2', '.', ',');?></span></td>

                                        <td> <span class="smaller lighter"><?php echo $tr['details'];?></span></td>
                                        <?php if($details['status'] != '2'):?>
                                        <td class="text-center"><i style="color:#fd4f57;font-weight:bold;" onClick="pay_delete('<?php echo $tr['payment_credit_id'];?>')" class="picons-thin-icon-thin-0056_bin_trash_recycle_delete_garbage_empty" data-toggle="tooltip" data-placement="top" title="Eliminar abono"></i></td>
                                        <?php endif;?>
                                    </tr>
                                    <?php endforeach;?>

                                    <tr style="font-size:14px">
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td><span class="smaller lighter">Total</span></td>

                                        <td> <span class="smaller lighter"><?php echo $currency.'. '.number_format($total,'2', '.', ',');?></span></td>

                                        <td> <span class="smaller lighter"></span></td>
                                    </tr>
                                </table>
                            </div>
                            <?php else: ?>
                            <center><br>
                                <h4 style="text-align:center;color:#4d4a81;margin-top:2%;">Aún no se tiene registro de abonos</h4><br><br>

                                <img src="<?php echo base_url();?>public/uploads/money.png" style="width:35%" />
                            </center>
                            <br>
                            <br>

                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="col-md-6 ml-auto">
                        <div class="card-widget" style="border: 1px solid #c6c6cc;">
                            <h5 class="panel-content-title">Resumen</h5>
                            <span class="app-divider2"></span>
                            <div class="table-responsive">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td>Total</td>
                                            <td class="text-right"><?php echo $currency;?>. <?php echo number_format($final,2,'.',',');?></td>
                                        </tr>
                                        <tr>
                                            <td>Descuento</td>
                                            <td><input <?php if($details['status'] == '2' || $totalfinal == 0 ):?>readonly="" <?endif;?> value="<?php if($details['discount'] == '') echo '0.00'; else echo $details['discount'];?>" class="form-control text-right" max="<?php echo $totalfinal;?>" min="1" name="discount" data-inputmask="'alias': 'currency'"><br></td>
                                        </tr>
                                        <tr>
                                            <td><?php if($practice <= 0 && $details['status'] != '2'):?>
                                                <i style="color:green;font-weight:bold;" onClick="add_consult('<?php echo $appointment_id;?>','<?php echo $details['treatment_id'];?>')" class="picons-thin-icon-thin-0154_ok_successful_check"></i>
                                                <?php elseif($totalfinal != 0 && $practice > 0 && $details['status'] != '2' && $consulta <= $totalfinal):?>
                                                <i style="color:red;font-weight:bold;" onClick="delete_consult('<?php echo $appointment_id;?>','<?php echo $details['treatment_id'];?>')" class="picons-thin-icon-thin-0153_delete_exit_remove_close"></i>
                                                <?php endif;?>
                                                Consulta
                                            </td>
                                            <td><input readonly="" value="<?php if($practice == '' || $practice == 0) echo $currency.'. 0.00'; else echo $currency.'. '.$consulta;?>" class="form-control text-right"><br></td>
                                        </tr>
                                        <?php if(count($appoints) >= 2):
                                            ?>
                                        <tr class="bg-light">
                                            <td class="text-bold-800">Consultas anteriores</td>
                                            <td class="text-bold-800 text-right"><?php echo $currency.'. '.number_format($cts_ant,2,'.',',');?></td>
                                        </tr>
                                        <?php endif;?>
                                        <tr class="bg-light">
                                            <td class="text-bold-800">Total Final</td>
                                            <td class="text-bold-800 text-right"><?php echo $currency;?>. <?php echo number_format(($final+$consulta+$cts_ant)-$details['discount'],2,'.',',');?></td>
                                        </tr>
                                        <tr>

                                            <td>Abonos</td>
                                            <td class="text-right"><?php echo $currency;?>. <?php echo number_format($abonos,2,'.',',');?></td>
                                        </tr>
                                        <tr class="bg-light">
                                            <td class="text-bold-800">Saldo</td>
                                            <td class="text-bold-800 text-right"><?php echo $currency;?>. <?php echo number_format($totalfinal,2,'.',',');?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php if($details['status'] != '2'):?>
            <input type="hidden" value="<?php echo $details['treatment_id'];?>" name="treatment_id" />
            <input type="hidden" name="sts" id="sts" value="<?php echo $stat;?>">
            <hr>
            <div class="col-sm-12 col-lg-12" id="resumen22">
                <div class="row">
                    <div class="col-sm-12 col-lg-4">
                        <div class="form-group">
                            <button type="submit" class="btn btn-success full-width">Guardar</button>
                        </div>
                    </div>
                    <?php   $treatments = $this->crud_model->treatments_status($details['treatment_id']);
                    if((($final+$consulta+$cts_ant)-$abonos-$details['discount']) != 0):?>
                    <div class="col-sm-12 col-lg-4">
                        <div class="form-group">
                            <a class="btn btn-primary full-width" href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_add_pay_credit/<?php echo $details['treatment_id'];?>/<?php echo $patient_id;?>/<?php echo $totalfinal;?>');">Abonar</a>
                        </div>
                    </div>
                    <?php endif;?>
                    <?php if($abonos == (($final+$consulta+$cts_ant)-$details['discount']) && $abonos != 0 && $treatments == 0):?>
                    <div class="col-sm-12 col-lg-4">
                        <div class="form-group">
                            <a class="btn btn-danger full-width" href="<?php echo base_url().'staff/update_treatment/close_treatment/'.$treatment_id.'/'.$patient_id;?>">Finalizar tratamiento</a>
                        </div>
                    </div>
                    <?php endif;?>
                    <?php if( $stat != 4):?>
                    <div class="col-sm-12 col-lg-4">
                        <div class="form-group">
                            <a class="btn btn-warning full-width" href="<?php echo base_url().'staff/update_treatment/end_appointment/'.$treatment_id.'/'.$patient_id;?>">Finalizar cita</a>
                        </div>
                    </div>
                    <?php else:?>
                    <div class="col-sm-12 col-lg-4">
                        <div class="form-group">
                            <a class="btn btn-warning full-width" onclick="modal_lg('<?php echo base_url();?>modal/popup/new_treatment/<?php echo $patient_id.'/'.$details['treatment_id'];?>');" href="javascript:void(0);"><span>Agendar próxima cita</span></a>
                        </div>
                    </div>
                    <?php endif;?>
                </div>
            </div>

            <?php else:?>
            <div class="col-sm-12">
                <a class="btn btn-warning" href="javascript:void(0);">Estado: Finalizado</a>
            </div>
            <?php endif;?>
    </div>
    </form>
</div>
</div>


<script src="<?php echo base_url();?>public/assets/theme/js/sticky-sidebar.js"></script>
<script src="<?php echo base_url();?>public/assets/theme/js/jquery.sticky.js"></script>
<script src="<?php echo base_url();?>public/assets/theme/js/PositionSticky/dist/PositionSticky.js"></script>
<script src="<?php echo base_url();?>public/assets/back/ckeditor/ckeditor.js"></script>
<script>
if (typeof CKEDITOR !== 'undefined') {
    CKEDITOR.disableAutoInline = true;
    if ($('#ckeditorEmail').length) {
        CKEDITOR.config.uiColor = '#ffffff';
        CKEDITOR.config.toolbar = [
            ['Bold', 'Italic', '-', 'NumberedList', 'BulletedList', '-', 'Link', 'Unlink', '-', 'About']
        ];
        CKEDITOR.config.height = 110;
        CKEDITOR.replace('commentary');
        CKEDITOR.replace('commentary2');
    }
}

var sidebar = new StickySidebar('#sticky', {
    topSpacing: 0
});
</script>
<?php  endforeach; ?>

<script>
<?php if ($this->db->get_where('prescription', array('patient_id' => $patient_id, 'appointment_id' => $appointment_id))->num_rows() > 0): ?>
update_table(<?php echo $appointment_id;?>);
<?php endif; ?>
var appointment_id = $("#appointment_id").val();
var patient_id = $("#patient_id").val();

function update_table(appointment_id) {
    $.ajax({
        url: '<?php  echo base_url();?>staff/update_prescription_table/' + appointment_id,
        success: function(response) {
            jQuery('#table_results').html(response);
        }
    });
}

function set_status(element_id, element_id2) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "Se marcará como finalizado el procedimiento en este tratamiento.",
        type: 'info',
        showCancelButton: true,
        confirmButtonColor: '#9fd13b',
        cancelButtonColor: '#fd4f57',
        confirmButtonText: 'Sí, finalizar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: '<?php echo base_url();?>staff/set_status_treatment/' + element_id + '/' + element_id2,
                success: function(response) {
                    location.reload();
                }

            });
        }
    })
}


function delete_consult(element_id, element_id2) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "Se eliminará el procedimiento en este tratamiento.",
        type: 'info',
        showCancelButton: true,
        confirmButtonColor: '#9fd13b',
        cancelButtonColor: '#fd4f57',
        confirmButtonText: 'Sí, finalizar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: '<?php echo base_url();?>staff/update_treatment/not_consult/' + element_id + '/' + element_id2,
                success: function(response) {
                    location.reload();

                }

            });
        }
    })
}



function add_consult(element_id, element_id2) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "Se agregará el precio de la consulta al total de esta cita del tratamiento.",
        type: 'info',
        showCancelButton: true,
        confirmButtonColor: '#9fd13b',
        cancelButtonColor: '#fd4f57',
        confirmButtonText: 'Sí, finalizar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: '<?php echo base_url();?>staff/update_treatment/add_consult/' + element_id + '/' + element_id2,
                success: function(response) {
                    location.reload();

                }

            });
        }
    })
}


function tooth_delete(element_id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "Se eliminará este procedimiento.",
        type: 'info',
        showCancelButton: true,
        confirmButtonColor: '#9fd13b',
        cancelButtonColor: '#fd4f57',
        confirmButtonText: 'Sí, finalizar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: '<?php echo base_url();?>staff/delete_tooth_treatment/' + element_id,
                success: function(response) {
                    location.reload();
                }

            });
        }
    })
}

$(document).ready(function() {

    $("#submit_button").click(function() {
        var medicine = $("#medicine").val();
        var quantity = $("#drink").val();
        var frequency = $("#frequency").val();
        var duration = $("#duration").val();

        if (appointment_id != '' && medicine != '' && quantity != '' && frequency != '' && duration != '') {
            $.ajax({
                url: "<?php echo base_url();?>staff/prescriptions/create/",
                type: 'POST',
                data: {
                    medicine: medicine,
                    quantity: quantity,
                    frequency: frequency,
                    duration: duration,
                    appointment_id: appointment_id,
                    patient_id: patient_id
                },
                success: function(result) {
                    $("#medicine").val('');
                    $("#drink").val('');
                    $("#frequency").val('');
                    $("#duration").val('');
                    $("#patient_id").val('');
                    update_table(<?php echo $appointment_id;?>);
                }
            });
        } else {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-right',
                showConfirmButton: false,
                timer: 5000
            });
            Toast.fire({
                type: 'error',
                title: 'Todos los campos son necesarios'
            })
        }
    });
});
</script>

<script src="<?php echo base_url();?>public/assets/search/bootstrap3-typeahead.js"></script>
<script>
function drink() {
    $('#drink').typeahead({
        source: ['1/2 tableta', '1 tableta', '2 tabletas', '1 ampolleta', '1 cápsula', '2 cápsulas', '1 pastilla', '2 pastillas', '1 cucharada', '1 gota', '2 gotas', '2.5 ML', '5 ML', '10 ML'],
        autoSelect: false,
        items: 1000,
        minLength: 0
    });
    $('#drink').trigger('keyup');
    $('#drink').focus();
}

function frequency() {
    $('#frequency').typeahead({
        source: ['cada 4 horas', 'cada 6 horas', 'cada 8 horas', 'cada 12 horas', 'cada 24 horas'],
        autoSelect: false,
        items: 1000,
        minLength: 0
    });
    $('#frequency').trigger('keyup');
    $('#frequency').focus();
}

function duration() {
    $('#duration').typeahead({
        source: ['3 días', '5 días', '7 días', '10 días', '15 días', '30 dias'],
        autoSelect: false,
        items: 1000,
        minLength: 0
    });
    $('#duration').trigger('keyup');
    $('#duration').focus();
}

$(document).on("keyup", function(e) {
    if ($('#drink').is(":focus")) {
        var code = (e.keyCode ? e.keyCode : e.which);
        if (code == 9) {
            drink();
        }
    }
});

$(document).on("keyup", function(e) {
    if ($('#frequency').is(":focus")) {
        var code = (e.keyCode ? e.keyCode : e.which);
        if (code == 9) {
            frequency();
        }
    }
});
$(document).on("keyup", function(e) {
    if ($('#duration').is(":focus")) {
        var code = (e.keyCode ? e.keyCode : e.which);
        if (code == 9) {
            duration();
        }
    }
});

$('#drink').click(
    function() {
        drink();
    });
$('#frequency').click(
    function() {
        frequency();
    });
$('#duration').click(
    function() {
        duration();
    });
$('#patient_id').click(
    function() {
        patient_id();
    });


function delete_element(element_id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "Se eliminará la información a este procedimiento.",
        type: 'info',
        showCancelButton: true,
        confirmButtonColor: '#9fd13b',
        cancelButtonColor: '#fd4f57',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: '<?php echo base_url();?>staff/prescriptions/delete/' + element_id,
                success: function(response) {
                    update_table(<?php echo $appointment_id;?>);
                }
            });
        }
    })
}

function pay_delete(element_id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "Se eliminará el pago y lo vinculado al mismo.",
        type: 'info',
        showCancelButton: true,
        confirmButtonColor: '#9fd13b',
        cancelButtonColor: '#fd4f57',
        confirmButtonText: 'Sí, finalizar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: '<?php echo base_url();?>staff/update_treatment/delete/' + element_id,
                success: function(response) {
                    location.reload();

                }

            });
        }
    })
}
</script>