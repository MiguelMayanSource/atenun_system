<style>
.nav-tabs .nav-item.show .nav-link,
.nav-tabs .nav-link.active {
    color: #ffffff;
    background-color: #0a1b43;
    border-color: #dee2e6 #dee2e6 #fff;
}
</style>
<?php 
    if($codigo != ""): 
    $info = $this->db->get_where('survey', array('survey_id' => $codigo))->result_array();
    foreach($info as $row): 
?>
<div class="white-box">
    <div class="os-tabs-w">
        <div class="os-tabs-controls">
            <ul class="navx nav-tabs">
                <li class="nav-item text-center">
                    <a class="nav-link" href="<?php echo base_url();?>staff/settings/">
                        <div class="navWidget"><i class="picons-thin-icon-thin-0049_settings_panel_equalizer_preferences"></i></div> <span>Configuración</span>
                    </a>
                </li>
                <li class="nav-item text-center">
                    <a class="nav-link" href="<?php echo base_url();?>staff/forms/">
                        <div class="navWidget"><i class="picons-thin-icon-thin-0064_bullet_list_view"></i></div> <span>Formularios</span>
                    </a>
                </li>
                <li class="nav-item text-center">
                    <a class="nav-link" href="<?php echo base_url();?>staff/clinics/">
                        <div class="navWidget"><i class="picons-thin-icon-thin-0047_home_flat"></i></div> <span>Sucursales</span>
                    </a>
                </li>
                <li class="nav-item text-center">
                    <a class="nav-link" href="<?php echo base_url();?>staff/services/">
                        <div class="navWidget"><i class="picons-thin-icon-thin-0813_heart_vitals_pulse_rate_health"></i></div> <span>Servicios</span>
                    </a>
                </li>
                <?php  
                            $odonto = $this->db->get_where('clinic', array('clinic_id'=>$this->session->userdata('current_clinic')))->row()->odonto;
                            if($odonto != ''):
                        ?>
                <li class="nav-item text-center">
                    <a class="nav-link" href="<?php echo base_url();?>staff/thooth_procedures/">
                        <div class="navWidget"><i class="picons-thin-icon-thin-0826_teeth_tooth_dental"></i></div> <span>Procedimientos</span>
                    </a>
                </li>
                <?php endif;?>
                <li class="nav-item text-center">
                    <a class="nav-link" href="<?php echo base_url();?>staff/specialties/">
                        <div class="navWidget"><i class="picons-thin-icon-thin-0825_stetoscope_doctor_hospital_ill"></i></div><span>Especialidades</span>
                    </a>
                </li>
                <li class="nav-item text-center">
                    <a class="nav-link" href="<?php echo base_url();?>staff/laboratories/">
                        <div class="navWidget"><i class="picons-thin-icon-thin-0817_tube_laboratory_chemistry"></i></div><span>Laboratorios</span>
                    </a>
                </li>
                <li class="nav-item text-center">
                    <a class="nav-link current" href="<?php echo base_url();?>staff/surveys/">
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
                <a class="nav-link active" href="<?php echo base_url();?>staff/question_board/<?php echo $codigo;?>/">Detalles</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo base_url();?>staff/questions/<?php echo $codigo;?>">Preguntas</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo base_url();?>staff/survey_results/<?php echo $codigo;?>">Resultados</a>
            </li>
        </ul>
        <br>
        <div class="content-box">
            <div class="card-h">
                <h3 class="card-caption"> <a href="<?php echo base_url();?>staff/surveys/"><i class="picons-thin-icon-thin-0159_arrow_back_left" style="font-size:19px"></i></a>
                    <span><?php echo $row['title'];?> </span>
                </h3>
                <hr>
            </div>
            <div class="tasks-section">
                <div class="tasks-header-w">
                    <span class="tasks-sub-header">Fecha de creación: <b><?php echo $row['date'];?></b>.</span>
                    <hr>
                </div>
                <div class="tasks-list-w">
                    <form action="<?php echo base_url();?>staff/surveys/update/<?php echo $codigo;?>" method="post">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label><b>Título:</b></label>
                                    <input type="text" class="form-control" name="title" value="<?php echo $row['title'];?>" required="">
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label><b>Descripción:</b></label>
                                    <textarea class="form-control" name="survey" id="ckeditorEmail1" required=""><?php echo $row['description'];?></textarea>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-primary">Aplicar cambios</button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<?php endforeach;?>
<?php endif;?>
<script src="https://wsg.com.gt/app/style/cms/bower_components/ckeditor/ckeditor.js"></script>
<script>
if (typeof CKEDITOR !== 'undefined') {
    CKEDITOR.disableAutoInline = true;
    if ($('#ckeditorEmail1').length) {
        CKEDITOR.config.uiColor = '#ffffff';
        CKEDITOR.config.toolbar = [
            ['Bold', 'Italic', '-', 'NumberedList', 'BulletedList', '-', 'Link', 'Unlink', '-', 'About']
        ];
        CKEDITOR.config.height = 225;
        CKEDITOR.replace('survey');
    }
}
</script>