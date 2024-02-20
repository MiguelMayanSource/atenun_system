
<div class="todo-app-w">
    <div class="todo-content" id="resumen">
        <h4 class="todo-content-header">
            <i class="batch-icon-arrow-right"></i><span>Quimioterapias </span>
        </h4>
        <?php
                $this->db->order_by('treatment_id','desc');
                $appointments = $this->db->get('patient_treatment');
                if(count($appointments->result_array()) > 0): ?>

        <div class="row">
            <div class="col-sm-12">
                <div class="alert alert-info">
                    <span class="alert-title"><i class="batch-icon-spam"></i> Historial de tratamientos.</span>
                    <span class="alert-content">Aquí podrás gestionar todos los planes de tratamiento realizados y en progreso de tu <span class="alert-lined"><a href="javascript:void(0);" style="color:#0044e9">paciente</a>.</span></span>
                </div>
                <?php if($this->crud_model->treatments_count($patient_id) == 0):?>
                <a class="btn btn-info pull-right" style="margin-top: 16px; margin-right:16px;" onclick="modal_lg('<?php echo base_url();?>modal/popup/new_treatment/<?php echo $patient_id;?>');" href="javascript:void(0);"><i class="side-icon picons-thin-icon-thin-0826_teeth_tooth_dental"></i> <span>Iniciar plan</span></a>
                <?php endif;?>
            </div>

            <div class="col-sm-12">
                <div class="tasks-section">
                    <div class="table-responsive">
                        <table class="table table-padded">
                            <thead>
                                <th>Paciente</th>
                                <th>Especialista</th>
                                <th>Fecha</th>
                                <th>Estado</th>
                                <th>Tipo</th>
                                <th>Acciones</th>
                            </thead>
                            <tbody>
                                <?php 
                        $n = 1; foreach($appointments->result_array() as $appointment): ?>
                                <tr style="font-family:'Poppins';font-size:14px;">
                                    <td><a href="<?php echo base_url();?>doctor/treatment_details/<?php echo base64_encode($appointment['treatment_id']);?>">
                                            <img src="<?php echo $this->accounts_model->get_photo('patient', $appointment['patient_id']);?>" width="35px" style="padding-right:6px">
                                            <?php echo $this->accounts_model->short_name('patient', $appointment['patient_id']);?>
                                        </a></td>
                                    <td><?php echo $this->accounts_model->gender($appointment['doctor_id']).' '.$this->accounts_model->short_name('admin',$appointment['doctor_id']);?></td>
                                    <td class="precio-ingreso"><?php echo $appointment['date'];?></td>
                                    <td>
                                        <?php if($appointment['status'] == 0):?>
                                        Nuevo
                                        <?php elseif($appointment['status'] == 1):?>
                                        En proceso
                                        <?php elseif($appointment['status'] == 2):?>
                                        Finalizado
                                        <?php endif;?>
                                    </td>
                                    <td>
                                        <span class="badge badge-info"><?php if($appointment['type'] == 0):?>
                                            Infantil
                                            <?php elseif($appointment['type'] == 1):?>
                                            Adulto
                                            <?php elseif($appointment['type'] == 2):?>
                                            Mixto
                                            <?php endif;?>
                                        </span>
                                    </td>
                                    <td>
                                        <?php if($this->crud_model->treatmentss($appointment['treatment_id']) > 0):?>
                                        <i onclick="window.open('<?php echo base_url();?>doctor/treatment_archive/email/<?php echo $appointment['treatment_id'];?>/<?php echo $patient_id;?>');" class="picons-thin-icon-thin-0315_email_mail_post_send" style="font-size:20px;color:#0176fe" data-toggle="tooltip" data-placement="top" title="Enviar recibo por correo"></i>
                                        <i onclick="window.location.href='<?php echo base_url();?>doctor/treatment_archive/pdf/<?php echo $appointment['treatment_id'];?>/<?php echo $patient_id;?>';" class="picons-thin-icon-thin-0123_download_cloud_file_sync" style="font-size:20px;color:#0176fe" data-toggle="tooltip" data-placement="top" title="" data-original-title="Descargar PDF"></i>
                                        <?php endif;?>
                                        <i style="color:#fd4f57;font-weight:bold;" onClick="treatment_delete('<?php echo $appointment['treatment_id'];?>')" class="picons-thin-icon-thin-0056_bin_trash_recycle_delete_garbage_empty" style="font-size:20px;color:#0176fe" data-toggle="tooltip" data-placement="top" title="Eliminar tratamiento"></i>
                                    </td>
                                </tr>
                                <?php endforeach;?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <?php else: ?>
        <div class="card-box">
            <a class="btn btn-info pull-right" style="margin-top: 16px; margin-right:16px;" onclick="modal_lg('<?php echo base_url();?>modal/popup/new_treatment/<?php echo $patient_id;?>');" href="javascript:void(0);"><i class="side-icon picons-thin-icon-thin-0826_teeth_tooth_dental"></i> <span>Iniciar plan</span></a>
            <br><br><br>
            <center><br>
                <h4 style="text-align:center;color:#4d4a81;margin-top:2%;">Aún no se tiene registro de tratamientos</h4><br>

                <img src="<?php echo base_url();?>public/uploads/tratamiento.svg" style="width:35%" />
            </center>
        </div>
        <?php endif;?>



    </div>
</div>


<script src="<?php echo base_url();?>public/assets/theme/js/sticky-sidebar.js"></script>
<script src="<?php echo base_url();?>public/assets/theme/js/jquery.sticky.js"></script>
<script src="<?php echo base_url();?>public/assets/theme/js/PositionSticky/dist/PositionSticky.js"></script>
<script>
function treatment_delete(element_id) {

    Swal.fire({
        title: '¿Estás seguro?',
        text: "Si elimina el tratamiento, eliminará también las citas y abonos vinculadas a este...",
        type: 'info',
        showCancelButton: true,
        confirmButtonColor: '#9fd13b',
        cancelButtonColor: '#fd4f57',
        confirmButtonText: 'Sí, finalizar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: '<?php echo base_url();?>doctor/treatment_archive/delete/' + element_id,
                success: function(response) {
                    location.reload();
                }

            });
        }
    })
}
</script>
<script>
var sidebar = new StickySidebar('#sticky', {
    topSpacing: 0
});
</script>
