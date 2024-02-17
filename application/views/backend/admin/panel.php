	
  <?php  
 
  if($this->session->userdata('login_type') != 'admin' ):
   
  ?>
    <div id="main-content">
		<div class="row">
		    <div class="col-sm-4">
		        <div class="panel-content">
		            <h1 class="panel-content-title">Tablero</h1>
		            <span class="panel-subtitle">¿Qué tienes para hoy?</span>
		            <ul class="appointment-list">
                    <?php 
                    $clinic_id = $this->session->userdata('current_clinic');
                    $clinic_id = $this->session->userdata('current_clinic');
                    $inicial   = $this->db->get_where('clinic', array('clinic_id' => $clinic_id))->row()->morning;
                    $x         = round($this->db->get_where('clinic', array('clinic_id' => $clinic_id))->row()->morning);
                    $final     = $this->db->get_where('clinic', array('clinic_id' => $clinic_id))->row()->b_morning;
                    $inicial2  = $this->db->get_where('clinic', array('clinic_id' => $clinic_id))->row()->afternoon;
                    $fday = $this->db->get_where('clinic', array('clinic_id' => $clinic_id))->row()->b_afternoon; 
                    $y    = date('h:i', strtotime($fday));
                    $xy   = round($fday);
                    $intervalo = $this->db->get_where('clinic', array('clinic_id' => $clinic_id))->row()->time_interval;
                    $horas = $this->crud_model->interval($inicial, $final, $intervalo);
                    $cont=0;
                    $next_app = "";
                    


                                for($i = $x; $i <= $xy; $i++): 
                    
                                    $min = array("00","30");
                                    foreach($min as $v):
                                    if($i < 10) $querys = '0'.$i.':'.$v; else $querys = $i.':'.$v;
                
                                    $appointments =  $this->crud_model->list_today_doc($this->session->userdata('doctor_id'),date('d/m/Y'),$clinic_id, $querys)->result_array();
                     
                                    foreach($appointments as $appointment):
                                        
                                        $hr = strtotime($appointment['time']); 
                                        $t =  date("H:i",$hr+'1740');

                                        if( date('H:i') >= $appointment['time'] &&  date('H:i') <= $t )
                                        {
                                            $next_app  = $appointment['appointment_id'];

                                        }
                                    

                                 if($appointment['status'] != 5):?>
                                <li data-toggle="tooltip" data-placement="right" title="<?php echo $appointment['comment']?>" class=" <?php  if($next_app  == $appointment['appointment_id']){ echo 'current'; $cont++; }?> " ><i class="batch-icon-user-4"></i> <span class="app-text"><?php echo $appointment['practice'] == 0 ? 'Otros servicios' : $this->db->get_where('service', array('service_id' => $appointment['practice']))->row()->name; ?></span> <span class="pull-right"> <?php echo $appointment['time'];?></span></li>
                               <?php else:?>
                                <li data-toggle="tooltip" data-placement="right" title="<?php echo $appointment['comment']?>" class=" <?php  if($next_app  == $appointment['appointment_id']){ echo 'current'; $cont++; }?> " ><i class="batch-icon-user-4"></i> <span class="app-text"><?php echo $appointment['Title']?></span> <span class="pull-right"> <?php echo $appointment['time'];?></span></li>
                               
                               
                               
                               
                                <?php
                            
                               
                                     
                            
                               endif; endforeach;?>
                            <?php endforeach;?>
                            <?php endfor;?>
		            </ul>
		            <center><span class="app-divider"></span></center>
		            <a class="blue-action-button" href="javascript:void(0);" onclick="modal_lg('<?php echo base_url();?>modal/popup/modal_new_event/');" >Agregar nuevo evento</a>
                    <a class="white-action-button"  href="<?php echo base_url();?>doctor/appointment/">Agregar nueva cita</a>
		        </div>
		        <div class="card-widget">
                <h4 class="panel-content-title">Citas por día</h4>
                        <span class="app-divider2"></span>
		            <canvas id="myChart" height="180" style="width:100%"></canvas>
		        </div>
		    </div>
		    <div class="col-sm-8">
		        <div class="row">
		            <div class="col-sm-12">
    		            <div class="card-widget">
                         <?php if($next_app == ""):?>
                            <h4 class="hello">¡Hola, <?php echo $this->accounts_model->gender($this->session->userdata('login_user_id')); ?> <?php echo $this->accounts_model->get_last_name('admin', $this->session->userdata('login_user_id'));?>!</h4> 
    		                <div class="panel-cta-w cta-with-media purple">
    		                    <div class="cta-content">
    		                        <p class="cta-header">Actualmente no tienes una cita o un evento activo.</p>
    		                        <a class="blue-action-button medium"  href="<?php echo base_url();?>doctor/appointment/" >Programar nueva cita </a>
    		                        </div>
    		                        <div class="cta-media">
    		                            <img alt="" src="https://medicaby.com/resources/app-icons/dr.png">
    		                        </div>
    		                    </div>
    		                </div>
                         <?php else: 
                            $sta = $this->db->get_where('appointment', array('appointment_id'=>$next_app))->row()->status;
                            if($sta == 5):
                            ?>  
                                <h4 class="hello">¡Hola, <?php echo $this->accounts_model->gender($this->session->userdata('login_user_id')); ?> <?php echo $this->accounts_model->get_last_name('admin', $this->session->userdata('login_user_id'));?>!</h4> 
                                <div class="panel-cta-w cta-with-media purple">
                                    <div class="cta-content">
                                        <p class="cta-header">Recuerda que tienes  <?php echo $this->db->get_where('appointment', array('appointment_id'=>$next_app))->row()->Title; ?>, <?php echo $this->db->get_where('appointment', array('appointment_id'=>$next_app))->row()->comment; ?></p>
                                        <a class="blue-action-button medium"  href="#"  >A las <?php echo $t = $this->db->get_where('appointment', array('appointment_id'=>$next_app))->row()->time; ?> Hrs.</a>
                                        </div>
                                        <div class="cta-media">
                                            <img alt="" src="https://medicaby.com/resources/app-icons/dr.png">
                                        </div>
                                    </div>
                                </div>
                            <?php else: ?>
                                <h4 class="hello">¡Hola, <?php echo $this->accounts_model->gender($this->session->userdata('login_user_id')); ?> <?php echo $this->accounts_model->get_last_name('admin', $this->session->userdata('login_user_id'));?>!</h4> 
                                <div class="panel-cta-w cta-with-media purple">
                                    <div class="cta-content">
                                        <p class="cta-header">Recuerda que tienes una cita con  <?php $patient_id = $this->db->get_where('appointment', array('appointment_id'=>$next_app))->row()->patient_id; $service_id = $this->db->get_where('appointment', array('appointment_id'=>$next_app))->row()->practice; echo $this->accounts_model->get_name('patient', $patient_id);?>, para <?php echo $service_id!="0" ? $this->db->get_where('service', array('service_id' => $service_id))->row()->name:'otros servicios'; ?></p>
                                        <a class="blue-action-button medium"  <?php $treatment = $this->db->get_where('appointment', array('appointment_id'=>$next_app))->row()->treatment_id; if($treatment == 0):?>href="<?php echo base_url().'doctor/appointment_details/'.base64_encode($next_app);?>" <?php else: ?>href="<?php echo base_url().'doctor/treatment_details/'.base64_encode($treatment);?>"<?php endif;?> >Vamos a ello. </a>
                                        </div>
                                        <div class="cta-media">
                                            <img alt="" src="https://medicaby.com/resources/app-icons/dr.png">
                                        </div>
                                    </div>
                                </div>
                         <?php   endif;?>

                        <?php endif;?>
		                </div>
		            </div>
		            <div class="card-widget" style="padding: 20px;border-radius: 15px;">
		                <h4 class="panel-content-title">Citas pendientes</h4>
                        <span class="app-divider2"></span>
		                <div style="padding-top:15px">
		                    <div class="row">
		                        <div class="col-sm-12 text-center">
		                            <div class="cls-scroll">
                                <?php 
                                
                                
                                for($i = $x; $i <= $xy; $i++): 
                    
                                                    $min = array("00","30");
                                                    foreach($min as $v):
                                                    if($i < 10) $querys = '0'.$i.':'.$v; else $querys = $i.':'.$v;

                                                    $appointments =  $this->crud_model->appointment_today_doc($this->session->userdata('doctor_id'),date('d/m/Y'),$clinic_id, $querys)->result_array();
                                                    

                                                    foreach($appointments as $appointment):

                                                        if($appointment['time']  <= $final && date('H:i') <= $final):?>
                                            

                                                <div class="today-appointment today-appointment-inlined">
                                                    <a class="today-appointment-box <?php  if($next_app  != $appointment['appointment_id']){ echo 'app-inactive'; $cont++; }?>" <?php if($appointment['treatment_id'] == 0):?> href="<?php echo base_url().'doctor/appointment_details/'.base64_encode($appointment['appointment_id']);?>" <?php else: ?> href="<?php echo base_url().'doctor/treatment_details/'.base64_encode($appointment['treatment_id']);?>" <?php endif;?>>
                                                        <div class="pt-avatar-w">
                                                            <i class="batch-icon-user-2"></i>
                                                        </div>
                                                        <div class="pt-user-name">
                                                            <?php echo $this->accounts_model->get_name('patient', $appointment['patient_id']);?>
                                                        </div>
                                                        <div class="pt-user-date">
                                                        <?php $new = $this->db->get_where('appointment',array('patient_id'=>$appointment['patient_id']))->num_rows();
                                  
                                                                if($new < 2):
                                                                ?>
                                                                Nuevo
                                                                <?php else: ?>
                                                                
                                                                Frecuente
                                                            <?php endif;?>
                                                        </div>
                                                        <div class="pt-user-time">
                                                        <?php echo $appointment['time'];?> <?php if($appointment['time'] < '12:00') echo 'AM'; else echo 'PM';?>
                                                        </div>
                                                    </a>
                                                </div>
                                                
                                                
                                                <?php endif; 
                                            
                                            if($appointment['time']  >= $final && date('H:i')  >= $final): ?>
                                            

                                                <div class="today-appointment today-appointment-inlined">
                                                    <a class="today-appointment-box <?php  if($next_app  != $appointment['appointment_id']){ echo 'app-inactive'; $cont++; }?>" <?php if($appointment['treatment_id'] == 0):?> href="<?php echo base_url().'doctor/appointment_details/'.base64_encode($appointment['appointment_id']);?>" <?php else: ?> href="<?php echo base_url().'doctor/treatment_details/'.base64_encode($appointment['treatment_id']);?>" <?php endif;?>>
                                                        <div class="pt-avatar-w">
                                                            <i class="batch-icon-user-2"></i>
                                                        </div>
                                                        <div class="pt-user-name">
                                                            <?php echo $this->accounts_model->get_name('patient', $appointment['patient_id']);?>
                                                        </div>
                                                        <div class="pt-user-date">
                                                        <?php $new = $this->db->get_where('appointment',array('patient_id'=>$appointment['patient_id']))->num_rows();
                                  
                                                                if($new < 2):
                                                                ?>
                                                                Nuevo
                                                                <?php else: ?>
                                                                
                                                                Frecuente
                                                            <?php endif;?>
                                                        </div>
                                                        <div class="pt-user-time">
                                                        <?php echo $appointment['time'];?> <?php if($appointment['time'] < '12:00') echo 'AM'; else echo 'PM';?>
                                                        </div>
                                                    </a>
                                                </div>
                                                
                                                
                                                <?php endif; 
                                            
                                            
                                            
                                            endforeach;?>
                                            <?php endforeach;?>
                                <?php endfor;?>
                                    
                                   </div>
                                </div>
		                    </div>
		                </div>
		                <h4 class="panel-content-title">Tus estadísticas</h4>
		                <div style="padding-top:15px">
    		                <div class="row">
		                        <div class="col-sm-6">
    		                        <div class="support-ticket ">
                                        <div class="st-body">
                                            <div class="avatar">
                                                <i class="icon-panel picons-thin-icon-thin-0385_graph_pie_chart_statistics"></i>
                                            </div>
                                            <div class="ticket-content">
                                                <div class="ticket-description">
                                                    <div class="os-progress-bar primary">
                                                        <div class="bar-labels">
                                                            <div class="bar-label-left">
                                                                <span class="bigger">Citas pendientes</span>
                                                            </div>
                                                            <div class="bar-label-right">
                                                                <span class="info"><?php echo $this->crud_model->count_pendientes_dashboard();?>%</span>
                                                            </div>
                                                        </div>
                                                        <div class="bar-level-1" style="width: 100%">
                                                            <div class="bar-level-2" style="width: 100%">
                                                                <div class="bar-level-3" style="width: <?php echo $this->crud_model->count_pendientes_dashboard();?>%"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
		                        </div>
		                        <div class="col-sm-6">
    		                        <div class="support-ticket ">
                                        <div class="st-body">
                                            <div class="avatar">
                                                <i class="icon-panel picons-thin-icon-thin-0385_graph_pie_chart_statistics"></i>
                                            </div>
                                            <div class="ticket-content">
                                                <div class="ticket-description">
                                                    <div class="os-progress-bar primary">
                                                        <div class="bar-labels">
                                                            <div class="bar-label-left">
                                                                <span class="bigger">Citas completadas</span>
                                                            </div>
                                                            <div class="bar-label-right">
                                                                <span class="info"><?php echo $this->crud_model->count_archived_dashboard();?>%</span>
                                                            </div>
                                                        </div>
                                                        <div class="bar-level-1" style="width: 100%">
                                                            <div class="bar-level-2" style="width: 100%">
                                                                <div class="bar-level-3" style="width: <?php echo $this->crud_model->count_archived_dashboard();?>%"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
		                        </div>
		                        <div class="col-sm-6">
    		                        <div class="support-ticket ">
                                        <div class="st-body">
                                            <div class="avatar">
                                                <i class="icon-panel picons-thin-icon-thin-0385_graph_pie_chart_statistics"></i>
                                            </div>
                                            <div class="ticket-content">
                                                <div class="ticket-description">
                                                    <div class="os-progress-bar primary">
                                                        <div class="bar-labels">
                                                            <div class="bar-label-left">
                                                                <span class="bigger">Citas canceladas</span>
                                                            </div>
                                                            <div class="bar-label-right">
                                                                <span class="info"><?php echo $this->crud_model->count_archived_dashboard();?>%</span>
                                                            </div>
                                                        </div>
                                                        <div class="bar-level-1" style="width: 100%">
                                                            <div class="bar-level-2" style="width: 100%">
                                                                <div class="bar-level-3" style="width: <?php echo $this->crud_model->count_archived_dashboard();?>%"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
		                        </div>
		                        <div class="col-sm-6">
    		                        <div class="support-ticket ">
                                        <div class="st-body">
                                            <div class="avatar">
                                                <i class="icon-panel picons-thin-icon-thin-0385_graph_pie_chart_statistics"></i>
                                            </div>
                                            <div class="ticket-content">
                                                <div class="ticket-description">
                                                    <div class="os-progress-bar primary">
                                                        <div class="bar-labels">
                                                            <div class="bar-label-left">
                                                                <span class="bigger">Citas reprogramadas</span>
                                                            </div>
                                                            <div class="bar-label-right">
                                                                <span class="info"><?php echo $this->crud_model->count_rescheduled_dashboard();?>%</span>
                                                            </div>
                                                        </div>
                                                        <div class="bar-level-1" style="width: 100%">
                                                            <div class="bar-level-2" style="width: 100%">
                                                                <div class="bar-level-3" style="width: <?php echo $this->crud_model->count_rescheduled_dashboard();?>%"></div>
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
		            </div>
		        </div>
		    </div>
		</div>

        <script src="https://rawgit.com/nnnick/Chart.js/v1.0.2/Chart.min.js"></script>
	<script>
	    Chart.types.Bar.extend({
            name: "BarAlt",
            initialize: function (data) {
                Chart.types.Bar.prototype.initialize.apply(this, arguments);
                if (this.options.curvature !== undefined && this.options.curvature <= 1) 
                {
                    var rectangleDraw = this.datasets[0].bars[0].draw;
                    var self = this;
                    var radius = this.datasets[0].bars[0].width * this.options.curvature * 0.5;
                    this.datasets.forEach(function (dataset) {
                        dataset.bars.forEach(function (bar) {
                            bar.draw = function () {
                                var y = bar.y;
                                bar.y = Math.min(bar.y + radius, self.scale.endPoint - 1);
                                var barRadius = (bar.y - y);
                                rectangleDraw.apply(bar, arguments);
                                Chart.helpers.drawRoundedRectangle(self.chart.ctx, bar.x - bar.width / 2, bar.y - barRadius + 1, bar.width, bar.height, barRadius);
                                ctx.fill();
                                bar.y = y;
                            }
                        })
                    })
                }
            }
        });
        var lineChartData = {
        labels:[<?php $week = $this->crud_model->date_week(date('Y-m-d'));
                foreach($week as $w)
                {

                    echo substr($w, -2).',';

                }
        ?>],
                datasets: [
                {
                    fillColor: "<?php echo $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->theme?>",
                    strokeColor: "<?php echo $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->theme?>",
                    data: [<?php $week = $this->crud_model->date_week(date('Y-m-d'));
                                foreach($week as $w)
                                {

                                    echo $this->crud_model->fill_week($w).',';

                                }
                        ?>]
                }
            ]
        };
        var ctx = document.getElementById("myChart").getContext("2d");
        var myLine = new Chart(ctx).BarAlt(lineChartData, {
            curvature: 1
        });
	</script>
    <?php else: ?>
    	<div id="main-content">
		<div class="row">
		    <div class="col-sm-12">
		        <div class="row">
		            <div class="col-sm-12">
    		            <div class="card-widget">
                            <h4 class="hello">¡Hola,  <?php echo $this->accounts_model->get_last_name('admin', $this->session->userdata('login_user_id'));?>!</h4> 
    		                <div class="panel-cta-w cta-with-media purple">
    		                    <div class="cta-content">
    		                        <p class="cta-header">Bienvenido al tablero principal, acá podras controlar lo que realizan los doctores y tu equipo de trabajo, ver informes y llevar el control de los pacientes.</p>
    		                        <div class="cta-media">
    		                            <img alt="" style="width:120px; height:150px;" src="https://medicaby.com/resources/app-icons/dr.png">
    		                        </div>
    		                    </div>
    		                </div>
		                </div>
                    </div>
                    <div class="col-sm-6">
    		            <div class="card-widget">
                             <h4 class="panel-content-title">Citas de los ultimos 15 dias</h4>
                                <span class="app-divider2"></span>
		                        <canvas id="myChart" height="180" style="width:100%"></canvas>
		                </div>
                    </div>
                    <div class="col-sm-6">
		            <div class="" style="padding: 20px;border-radius: 15px;">
		                <h4 class="panel-content-title">Usuarios</h4>
                        <span class="app-divider2"></span>
		                <div style="padding-top:15px">
		                    <div class="row">
		                    </div>
		                </div>
		                <div style="padding-top:15px">
    		                <div class="row">
		                        <div class="col-sm-4">
                                    <div class="profile-tile profile-tile-inlined">
                                        <div class="profile-tile-box">
                                            <div class="pt-avatar-w"><img style="width:200px; height:180px;" alt="" src="<?php echo base_url();?>public/uploads/doctors.svg"></div>
                                            <div class="pt-user-last" style="font-size:30px">Doctores</div>
                                            <span class="badge badge-warning" style="font-size:30px"><?php echo $this->db->get_where('admin',array('status !='=>0,'owner'=>0))->num_rows();?></span>
                                            <div class="pt-user-name" onclick="window.location.href='<?php echo base_url();?>admin/doctors';">ir</div>
                                        </div>
                                    </div>
		                        </div>
		                        <div class="col-sm-4">
                                    <div class="profile-tile profile-tile-inlined">
                                        <div class="profile-tile-box">
                                            <div class="pt-avatar-w"><img style="width:200px; height:180px;" alt="" src="<?php echo base_url();?>public/uploads/personal.svg"></div>
                                            <div class="pt-user-last" style="font-size:30px">Equipo</div>
                                            <span class="badge badge-warning" style="font-size:30px"><?php echo $this->db->get_where('staff',array('status !='=>0))->num_rows();?></span>
                                            <div class="pt-user-name" onclick="window.location.href='<?php echo base_url();?>admin/staff';">ir</div>
                                        </div>
                                    </div>
		                        </div>
		                        <div class="col-sm-4">
                                    <div class="profile-tile profile-tile-inlined">
                                        <div class="profile-tile-box">
                                            <div class="pt-avatar-w"><img style="width:200px; height:180px;" alt="" src="<?php echo base_url();?>public/uploads/Paciente.svg"></div>
                                            <div class="pt-user-last" style="font-size:30px">Pacientes</div>
                                            <span class="badge badge-warning" style="font-size:30px"><?php echo $this->db->get_where('patient',array('status !='=>0))->num_rows();?></span>
                                            <div class="pt-user-name" onclick="window.location.href='<?php echo base_url();?>admin/patients';">ir</div>
                                        </div>
                                    </div>
		                        </div>
		                    </div>
		                </div>
		            </div>
		        </div>
		    </div>
		</div>


        <script src="https://rawgit.com/nnnick/Chart.js/v1.0.2/Chart.min.js"></script>
	<script>
	    Chart.types.Bar.extend({
            name: "BarAlt",
            initialize: function (data) {
                Chart.types.Bar.prototype.initialize.apply(this, arguments);
                if (this.options.curvature !== undefined && this.options.curvature <= 1) 
                {
                    var rectangleDraw = this.datasets[0].bars[0].draw;
                    var self = this;
                    var radius = this.datasets[0].bars[0].width * this.options.curvature * 0.5;
                    this.datasets.forEach(function (dataset) {
                        dataset.bars.forEach(function (bar) {
                            bar.draw = function () {
                                var y = bar.y;
                                bar.y = Math.min(bar.y + radius, self.scale.endPoint - 1);
                                var barRadius = (bar.y - y);
                                rectangleDraw.apply(bar, arguments);
                                Chart.helpers.drawRoundedRectangle(self.chart.ctx, bar.x - bar.width / 2, bar.y - barRadius + 1, bar.width, bar.height, barRadius);
                                ctx.fill();
                                bar.y = y;
                            }
                        })
                    })
                }
            }
        });
        var lineChartData = {
        labels:[<?php $week = $this->crud_model->date_week(date('Y-m-d'));
                foreach($week as $w)
                {

                    echo substr($w, -2).',';

                }
        ?>],
                datasets: [
                {
                    fillColor: "<?php echo $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->theme?>",
                    strokeColor: "<?php echo $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->theme?>",
                    data: [<?php $week = $this->crud_model->date_week(date('Y-m-d'));
                                foreach($week as $w)
                                {

                                    echo $this->crud_model->fill_week_sop($w).',';

                                }
                        ?>]
                }
            ]
        };
        var ctx = document.getElementById("myChart").getContext("2d");
        var myLine = new Chart(ctx).BarAlt(lineChartData, {
            curvature: 1
        });
	</script>
    <?php endif;?>
	

	