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
<link href="<?php echo base_url();?>public/assets/appointments/css/select2.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<div id="main-content">
    <div class="card-widget">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link " href="<?php echo base_url();?>staff/question_board/<?php echo $codigo;?>/">Detalles</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo base_url();?>staff/questions/<?php echo $codigo;?>">Preguntas</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="<?php echo base_url();?>staff/survey_results/<?php echo $codigo;?>">Resultados</a>
            </li>
        </ul>
        <br>
        <div class="pageContent2">
            <div class="content-box">
                <div id="main-content">
                    <div class="card-box">
                        <div class="card-h">
                            <h3 class="text-center">
                                <?php $this->db->where('survey_id',$codigo); echo $this->db->count_all_results('survery_result');?> respuestas para esta encuesta.
                            </h3>
                            <hr>
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" role="tab" data-toggle="tab" aria-expanded="false" aria-selected="false" style="color:#007bff" href="#summary">Resumen</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" role="tab" data-toggle="tab" aria-expanded="false" aria-selected="true" href="#single">Individual</a>
                                </li>
                            </ul>
                            <br>
                        </div>
                    </div>
                    <div class="tasks-list-w">
                        <div class="team-tablist-content tab-content" style="padding: 0 !important;">
                            <div role="tabpanel" class="tab-pane animated fadeInUp active" id="summary">
                                <?php 
                                    $questions = $this->db->get_where('question', array('survey_id' => $codigo))->result_array();
                                    foreach($questions as $rows):
                                ?>
                                <div class="card-box">
                                    <div class="card-h">
                                        <h2 class="card-caption">
                                            <span><?php echo $rows['question'];?></span>
                                        </h2>
                                    </div>
                                    <table class="table table-bordered">
                                        <?php 
                        		            $submitted_answer = $this->db->get_where('survery_result', array('survey_id' => $codigo))->result_array();
                		                    foreach ($submitted_answer as $row_answer):?>
                                        <tr>
                                            <td>
                                                <?php
                        		                    $n = 0;
                                                    $reply = json_decode($row_answer['answer_script'], true);
                                                    foreach($reply as $repl)
                                                    {
                                                        if ($rows['question_id']== $repl['question_id'])
                                                        {
                                                            $n++;
                                                            $v1 = str_replace('["','',$repl['submitted_answer']);
                                                            $v2 = str_replace('"]','',$v1);
                                                            $type = $this->db->get_where('question', array('question_id' => $repl['question_id']))->row()->type;
                                                            echo $v2;
                                                        }
                                                    }
                        		                ?>
                                            </td>
                                        </tr>
                                        <?php endforeach;?>
                                    </table>
                                </div>
                                <?php endforeach;?>
                            </div>
                            <div role="tabpanel" class="tab-pane animated fadeInUp" id="questions">
                                <div class="card-box">
                                    <div class="card-h">
                                        <h2 class="card-caption">
                                            <span style="font-size:24px;"><?php $this->db->where('survey_id',$codigo); echo $this->db->count_all_results('survery_result');?> respuestas.</span>
                                        </h2>
                                    </div>
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane animated fadeInUp" id="single">
                                <div class="card-box"><br>
                                    <div class="card-h">
                                        <h5 class="card-caption">
                                            Seleccionar paciente
                                        </h5>
                                    </div>
                                    <div class="form-group">
                                        <select class="itemName form-control select2" style="width:100%" name="patient_id" onchange="update_table(this.value)">
                                            <option value="">Seleccionar</option>
                                            <?php 
										            $query = $this->db->get_where('survery_result', array('survey_id' => $codigo))->result_array();
                                                    foreach($query as $pat):
                                                ?>
                                            <option value="<?php echo $pat['patient_id'];?>"><?php echo $this->accounts_model->get_name('patient', $pat['patient_id']);?></option>
                                            <?php endforeach;?>
                                        </select>
                                    </div>
                                </div>
                                <div id="response">
                                </div>
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
<script type="text/javascript">
function update_table(patient_id) {
    var code = '<?php echo $codigo;?>';
    $.ajax({
        url: '<?php echo base_url();?>staff/get_reply/' + code + '/' + patient_id,
        success: function(response) {
            jQuery('#response').html(response);
        }
    });
}
$('.itemName').select2();
</script>
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