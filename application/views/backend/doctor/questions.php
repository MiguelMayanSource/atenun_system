<style>
.nav-tabs .nav-item.show .nav-link,
.nav-tabs .nav-link.active {
    color: #ffffff;
    background-color: #0a1b43;
    border-color: #dee2e6 #dee2e6 #fff;
}
</style>
<?php if($codigo != ""): 
        $info = $this->db->get_where('survey', array('survey_id' => $codigo))->result_array();
        foreach($info as $row):
?>
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
                    <a class="nav-link" href="<?php echo base_url();?>doctor/forms/">
                        <div class="navWidget"><i class="picons-thin-icon-thin-0064_bullet_list_view"></i></div> <span>Formularios</span>
                    </a>
                </li>
                <li class="nav-item text-center">
                    <a class="nav-link" href="<?php echo base_url();?>doctor/clinics/">
                        <div class="navWidget"><i class="picons-thin-icon-thin-0047_home_flat"></i></div> <span>Sucursales</span>
                    </a>
                </li>
                <li class="nav-item text-center">
                    <a class="nav-link" href="<?php echo base_url();?>doctor/services/">
                        <div class="navWidget"><i class="picons-thin-icon-thin-0813_heart_vitals_pulse_rate_health"></i></div> <span>Servicios</span>
                    </a>
                </li>
                <?php  
                    
                    $odonto = $this->db->get_where('clinic', array('clinic_id'=>$this->session->userdata('current_clinic')))->row()->odonto;
                    if($odonto != ''):
                
                        ?>
                <li class="nav-item text-center">
                    <a class="nav-link" href="<?php echo base_url();?>doctor/thooth_procedures/">
                        <div class="navWidget"><i class="picons-thin-icon-thin-0826_teeth_tooth_dental"></i></div> <span>Procedimientos</span>
                    </a>
                </li>
                <?php endif;?>
                <li class="nav-item text-center">
                    <a class="nav-link" href="<?php echo base_url();?>doctor/specialties/">
                        <div class="navWidget"><i class="picons-thin-icon-thin-0825_stetoscope_doctor_hospital_ill"></i></div><span>Especialidades</span>
                    </a>
                </li>
                <li class="nav-item text-center">
                    <a class="nav-link" href="<?php echo base_url();?>doctor/laboratories/">
                        <div class="navWidget"><i class="picons-thin-icon-thin-0817_tube_laboratory_chemistry"></i></div><span>Laboratorios</span>
                    </a>
                </li>
                <li class="nav-item text-center">
                    <a class="nav-link current" href="<?php echo base_url();?>doctor/surveys/">
                        <div class="navWidget"><i class="picons-thin-icon-thin-0065_bullet_list_view"></i></div><span>Encuestas</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>

<div id="main-content">
    <div class="card-widget">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link" href="<?php echo base_url();?>doctor/question_board/<?php echo $codigo;?>/">Detalles</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="<?php echo base_url();?>doctor/questions/<?php echo $codigo;?>">Preguntas</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo base_url();?>doctor/survey_results/<?php echo $codigo;?>">Resultados</a>
            </li>
        </ul>
        <br>
        <div class="pageContent padding0">
            <div class="card-box padding0">
                <div class="card-h  ">
                    <h5 class="card-caption">Administrar preguntas</h5>
                </div>
                <div class="card-b">
                    <div class="container-fluid">
                        <div class="alert alert-info">
                            <span class="alert-title"><i class="batch-icon-spam"></i> Añade preguntas a tus encuestas.</span>
                            <span class="alert-content">Todas estas serán las preguntas que tus pacientes deberán responder en la encuesta que envíes, tienes la opción de crear preguntas de satisfacción, opción múltiple y preguntas <span class="alert-lined">abiertas.</span></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="table-responsive">
                                <?php
                                    $preguntas = $this->db->get_where('question', array('survey_id' => $codigo))->result_array(); 
                                     if(count($preguntas)>0): ?>
                                <table class="table custom-table table-striped">
                                    <thead style="color: #a2a5b9;">
                                        <tr>
                                            <th>ID</th>
                                            <th>Tipo</th>
                                            <th>Pregunta</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
	                                        $id = 1;
	                                        foreach($preguntas as $pregunta):?>
                                        <tr style="font-family:'Poppins';font-size:14px;font-weight:bold;color:#4b4a55" class="">
                                            <td>#PR-<?php echo $id++;?></td>
                                            <td>
                                                <?php if($pregunta['type'] == 'text'):?>
                                                <span class="badge badge-info">Texto Libre</span>
                                                <?php elseif($pregunta['type'] == 'multiple_choice'):?>
                                                <span class="badge badge-success">Opción Múltiple</span>
                                                <?php elseif($pregunta['type'] == 'satisfaction'):?>
                                                <span class="badge badge-warning">Satisfacción</span>
                                                <?php endif;?>
                                            </td>
                                            <td><?php echo substr(strip_tags($pregunta['question']), 0,120);?></td>
                                            <td>
                                                <?php if($pregunta['type'] == 'text'|| $pregunta['type'] == 'satisfaction'):?>
                                                <a href="javascript:void(0);" onclick="modal_lg('<?php echo base_url();?>modal/popup/modal_question/<?php echo $pregunta['question_id'];?>');"><i style="vertical-align:-3px;color:#a7aabb;font-size:18px;font-weight:bold;" class="picons-thin-icon-thin-0002_write_pencil_new_edit"></i></a>
                                                <?php elseif($pregunta['type'] == 'multiple_choice'):?>
                                                <a href="<?php echo base_url();?>doctor/update_multiple/<?php echo $pregunta['question_id'];?>"><i style="vertical-align:-3px;color:#a7aabb;font-size:18px;font-weight:bold;" class="picons-thin-icon-thin-0002_write_pencil_new_edit"></i></a>
                                                <?php endif;?>
                                                <a href="javascript:void(0);" onclick="delete_question('<?php echo $pregunta['question_id'];?>')"><i style="vertical-align:-3px;color:#a7aabb;font-size:18px;font-weight:bold;" class="picons-thin-icon-thin-0056_bin_trash_recycle_delete_garbage_empty"></i></a>
                                            </td>
                                        </tr>
                                        <?php   endforeach;?>
                                    </tbody>
                                </table>
                                <?php else:?>
                                <div style="margin-top:10%">
                                    <center style="font-size:15px;color:#808080!important">Agrega tu primer pregunta a la encuesta utilizando el botón azul ubicado en la parte inferior derecha.</center>
                                    <center><i class="picons-thin-icon-thin-0307_chat_discussion_yes_no_pro_contra_conversation" style="font-size:105px;color:#808080;"></i></center>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endforeach;?>
<?php endif;?>
<div style="z-index: 9999;position: fixed; bottom: 10px;right: 10px;" class="floated-customizer-btn third-floated-btn">
    <div class="icon-w"> <i class="os-icon batch-icon-add"></i></div>
</div>
<div class="floated-customizer-panel">
    <div class="fcp-content">
        <div class="close-customizer-btn">
            <i class="os-icon os-icon-x"></i>
        </div>
        <div class="fcp-group">
            <div class="fcp-group-header">
                Selecciona una opción
            </div>
            <div class="fcp-group-contents">
                <div class="fcp-field">
                    <a href="javascript:void(0);" data-target="#888Modal" data-toggle="modal"><label for="">Nivel de satisfacción</label></a>
                </div>
                <div class="fcp-field">
                    <a href="<?php echo base_url();?>doctor/multiple_choice/<?php echo $codigo;?>/"><label for="">Opción múltiple</label></a>
                </div>
                <div class="fcp-field">
                    <a href="javascript:void(0);" data-target="#124Modal" data-toggle="modal"><label for="">Texto libre</label></a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="888Modal">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content animated fadeInDown" style="border-radius:20px;">
            <form action="<?php echo base_url();?>doctor/questions/satisfaction/<?php echo $codigo;?>" method="post">
                <div class="modal-header" style="background-color:#fff;border-radius:20px;  box-shadow: 0 4px 2px -2px 000;">
                    <h4 style="font-size:21px; color:#565b6b; font-family:'Poppins';"><span style="vertical-align:-3px"> <i class="batch-icon-bullhorn"></i> Realiza tu pregunta de satisfacción.</span></h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body" style="background-color:#f1f3f7;">
                    <div class="form-group">
                        <div class="container">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <textarea name="question" class="form-control"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="button-confirm">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal" id="124Modal">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content animated fadeInDown" style="border-radius:20px;">
            <form action="<?php echo base_url();?>doctor/questions/text/<?php echo $codigo;?>" method="post">
                <div class="modal-header" style="background-color:#fff;border-radius:20px;  box-shadow: 0 4px 2px -2px 000;">
                    <h4 style="font-size:21px; color:#565b6b; font-family:'Poppins';"><span style="vertical-align:-3px"> <i class="batch-icon-bullhorn"></i> Realiza tu pregunta de texto libre.</span></h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body" style="background-color:#f1f3f7;">
                    <div class="form-group">
                        <div class="container">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <textarea name="question" class="form-control"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="button-confirm">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="https://miaula.com.gt/demo/assets/theme/js/demo_customizer.js?version=4.4.0"></script>
<script>
$('.ae-side-menu-toggler').on('click', function() {
    $('.app-email-w').toggleClass('compact-side-menu');
});
if ($('.app-email-w').length) {
    if (is_display_type('phone') || is_display_type('tablet')) {
        $('.app-email-w').addClass('compact-side-menu');
    }
}
</script>
<script type="text/javascript">
function delete_question(question_id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "Esta acción no puede deshacerse. ¿Aún así, desea continuar?",
        type: 'info',
        showCancelButton: true,
        confirmButtonColor: '#9fd13b',
        cancelButtonColor: '#fd4f57',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.value) {
            location.href = "<?php echo base_url();?>doctor/questions/delete/" + question_id;
        }
    })
}
</script>