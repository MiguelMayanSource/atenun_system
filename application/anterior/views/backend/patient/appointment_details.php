    <link rel="stylesheet" href="<?php echo base_url();?>public/assets/search/estilo.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <style>

        input[type="radio"] {
  width: 30px;
  height: 30px;
  border-radius: 15px;
  border: 2px solid #0844e98a;
  background-color: white;
  -webkit-appearance: none; /*to disable the default appearance of radio button*/
  -moz-appearance: none;
}

input[type="radio"]:focus { /*no need, if you don't disable default appearance*/
  outline: none; /*to remove the square border on focus*/
}

input[type="radio"]:checked { /*no need, if you don't disable default appearance*/
  background-color: #0844e98a;
}

input[type="radio"]:checked ~ span:first-of-type {
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
.lbl{
    margin-right: -10px;
    margin-bottom:0px!important;
}
    </style>
    
    <?php   
        $appointment_id = base64_decode($id_);
        $this->db->where('appointment_id', $appointment_id);
        $info = $this->db->get('appointment')->result_array();
        foreach ($info as $details):
        $patient_id = $details['patient_id'];
    ?>
    <div class="todo-app-w">
    <div id="main-content">
        <form action="<?php echo base_url();?>patient/appointment/finish" method="POST">
            <input type="hidden" name="appointment_id" id="appointment_id" value="<?php echo $details['appointment_id'];?>">
            <input type="hidden" name="patient_id" id="patient_id" value="<?php echo $this->db->get_where('patient', array('patient_id' => $details['patient_id']))->row()->patient_id; ?>">
            <div class="row">
                <div class="col-sm-8" >
                <?php if($details['practice']==21):?>
                    <div class="card-widget" style="border: 1px solid #c6c6cc;">
                        <h5 class="panel-content-title">Teleconsulta</h5>
                        <span class="app-divider2"></span>
                        <div class="row">
                            <div class="col-sm-12">
                                <div id="teleconsulta" style="height: 400px;">
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif;?>
                    <div class="card-widget" style="border: 1px solid #c6c6cc;">
                        <h5 class="panel-content-title">Detalles de la cita</h5>
                        <span class="app-divider2"></span>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="alert alert-pending">
                                    <b>Fecha y hora</b>
                                    <span style="display:block"><?php echo $this->crud_model->formatear($details['date'])." a las ".$details['time']; ?></span>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="alert alert-rep">
                                    <b>Motivo, molestias o síntomas del paciente:</b>
                                    <span style="display:block"><?php echo $details['comment']; ?></span>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Observaciones médicas:</label>
                                    <textarea id="ckeditorEmail" name="reason" rows="5" readonly="">
                                        <?php if ($details['status'] == 4): ?> <?php echo $this->db->get_where('appointment', array( 'appointment_id' => $appointment_id))->row()->reason; ?> <?php endif; ?>
                                    </textarea>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Exploración fisíca:</label>
                                    <textarea cols="80" id="ckeditorEmail1" name="exploration" rows="5" readonly="">
                                        <?php    if ($details['status'] == 4):     echo $this->db->get_where('appointment', array('appointment_id' => $appointment_id  ))->row()->physical_exploration;?> <?php    endif;?>
                                    </textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-widget" style="border: 1px solid #c6c6cc;">
                        <h5 class="panel-content-title">Sígnos vitales</h5>
                        <span class="app-divider2"></span>
                        <div class="row">
                            <?php if ($this->crud_model->check_item('signs') == 1): ?>
                                <?php include 'vital.php';?>
                            <?php endif;  ?>
                        </div>
                    </div>
                    <div class="card-widget" style="border: 1px solid #c6c6cc;">       
                        <h5 class="panel-content-title">Receta de medicamentos</h5>
                        <span class="app-divider2"></span>
                        <div class="row">    
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-sm-12" id="table_results">
                                       
                                    </div>
                                </div>
                                <hr>
                            </div>
                        </div>
                    </div>
                    <div class="card-widget" style="border: 1px solid #c6c6cc;">
                        <h5 class="panel-content-title">Seguimiento nutriológico</h5>
                        <span class="app-divider2"></span>
                        <div class="row">
                            <?php if ($this->crud_model->check_item('nutri') == 1): ?>
                                <?php include 'nutriology.php';?>
                            <?php endif;?>
                        </div>
                    </div>
                    <div class="card-widget" style="border: 1px solid #c6c6cc;">
                        <h5 class="panel-content-title">Cetosis</h5>
                        <span class="app-divider2"></span>
                        <div class="row">
                            <?php if ($this->crud_model->check_item('cetosis') == 1): ?>
                                <?php include 'cetosis.php';?>
                            <?php endif;?>
                        </div>
                    </div>
                    <div class="card-widget" style="border: 1px solid #c6c6cc;">
                        <h5 class="panel-content-title">Comentarios</h5>
                        <span class="app-divider2"></span>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Instrucciones médicas:</label>
                                    <textarea cols="80" id="ckeditorEmail12" name="instructions" rows="5" readonly="">
                                    <?php    if ($details['status'] == 4): echo $this->db->get_where('appointment', array( 'appointment_id' => $appointment_id  ))->row()->patient_comment;?> <?php    endif;  ?>
                                    </textarea>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Plan de tratamiento:</label>
                                    <textarea cols="80" id="ckplan" name="ckplan" rows="5" readonly="">
                                        <?php    if ($details['status'] == 4):  echo $this->db->get_where('appointment', array(   'appointment_id' => $appointment_id  ))->row()->treatment_plan;?> <?php    endif;?>
                                    </textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4" >
                <div class=""  id="sticky" >
                    <div class="card-widget"  style="border: 1px solid #c6c6cc;">
                        <h4 class="panel-content-title">Paciente</h4>
                        <span class="app-divider2"></span>
                        <div class="row">
                                <div class="col-sm-12">
                                    <div class="patient-info">
    		                            <div class="profile-tile-box">
    		                            <div class="pt-avatar-w"><img alt="" src="<?php echo $this->accounts_model->get_photo('patient', $details['patient_id']);?>"></div>
    		                            <div class="pt-user-last">
        		                            <a href="<?php echo base_url(); ?>patient/patients/patient_profile/<?php echo base64_encode($details['patient_id']); ?>" style="color:black;text-decoration:none;"><?php echo $this->accounts_model->get_name('patient',$details['patient_id']);?></a>.</div>
    		                            <br>
    		                            <div class="pt-user-med">
    		                                <div class="row">
    		                                    <div class="col-sm-6 col-md-12 col-lg-6">
    		                                        <div style="overflow-wrap: anywhere;background: #f9fafc; width: 100%; padding: 10px; border-radius: 10px; border: 2px dotted #c6c6cc;margin-bottom: 10px!important;padding-left: 20px; text-align: left;margin: 0 auto;">
    		                                            <span style="display: block;">Edad:</span> <span style="font-weight: bold;">
    		                                                <?php $originalDate = $this->db->get_where('patient', array('patient_id' => $details['patient_id']))->row()->date_of_birth; $newDate = date("d-m-Y", strtotime($originalDate)); ?>
    		                                                <?php echo $this->accounts_model->get_age($newDate);?>.
        		                                        </span>
    		                                        </div>
    		                                    </div>
    		                                    <div class="col-sm-6 col-md-12 col-lg-6">
    		                                        <div style="overflow-wrap: anywhere;background: #f9fafc; width: 100%; padding: 10px; border-radius: 10px; border: 2px dotted #c6c6cc;margin-bottom: 10px!important;padding-left: 20px; text-align: left;margin: 0 auto;">
        		                                        <span style="display: block;">Género:</span> <span style="font-weight: bold;"> <?php $gen = $this->db->get_where('patient', array('patient_id' => $details['patient_id']))->row()->gender; echo $gen =='M' ?  'Masculino' : 'Femenino'; ?></span>
    		                                        </div>  
    		                                    </div>
    		                                    <div class="col-sm-6 col-md-12 col-lg-6">
    		                                        <div style="overflow-wrap: anywhere;background: #f9fafc; width: 100%; padding: 10px; border-radius: 10px; border: 2px dotted #c6c6cc;margin-bottom: 10px!important;padding-left: 20px; text-align: left;margin: 0 auto;">
        		                                        <span style="display: block;">Tipo sanguíneo:</span> <span style="font-weight: bold;"> <?php $blood = $this->db->get_where('patient', array('patient_id' => $details['patient_id']))->row()->blood; if($blood != '') echo $blood; else echo 'No especificado'; ?></span>
    		                                        </div>        
    		                                    </div>
    		                                    <div class="col-sm-6 col-md-12 col-lg-6">
    		                                        <div style="overflow-wrap: anywhere;background: #f9fafc; width: 100%; padding: 10px; border-radius: 10px; border: 2px dotted #c6c6cc;margin-bottom: 10px!important;padding-left: 20px; text-align: left; margin: 0 auto;">
        		                                        <span style="display: block;">Estado cívil:</span> <span style="font-weight: bold;"><?php $ms = $this->db->get_where('patient', array('patient_id' => $details['patient_id']))->row()->marital_status; echo $ms =='0' ?  'Soltero' : 'Casado';?></span>
    		                                        </div>        
    		                                    </div>
    		                                    <div class="col-sm-6 col-md-12 col-lg-6">
    		                                        <div style="overflow-wrap: anywhere;background: #f9fafc; width: 100%; padding: 10px; border-radius: 10px; border: 2px dotted #c6c6cc;margin-bottom: 10px!important;padding-left: 20px; text-align: left; margin: 0 auto;">
        		                                        <span style="display: block;">Correo:</span> <span style="font-weight: bold;"><?php echo $this->db->get_where('patient', array('patient_id' => $details['patient_id']))->row()->email; ?></span>
    		                                        </div>        
    		                                    </div>
    		                                    <div class="col-sm-6 col-md-12 col-lg-6">
    		                                        <div style="overflow-wrap: anywhere;background: #f9fafc; width: 100%; padding: 10px; border-radius: 10px; border: 2px dotted #c6c6cc;margin-bottom: 10px!important;padding-left: 20px; text-align: left; margin: 0 auto;">
    		                                            <span style="display: block;">Celular:</span> <span style="font-weight: bold;"><?php echo $this->db->get_where('patient', array('patient_id' => $details['patient_id']))->row()->phone; ?></span>
        		                                    </div>      
    		                                    </div>
    		                                    <div class="col-sm-12 col-md-12 col-lg-12">
    		                                        <center><span class="app-divider"></span></center>
    		                                        <a class="btn btn-success custom-radius" href="<?php echo base_url();?>patient/dashboard/<?php echo  base64_encode($details['patient_id']);?>">
    		                                            Ir al perfil
    		                                        </a>
    		                                        <a class="btn btn-primary custom-radius" href="<?php echo base_url();?>patient/medical_history/<?php echo  base64_encode($details['patient_id']);?>">
    		                                            Historial médico
    		                                        </a>
    		                                        <a class="btn btn-danger custom-radius" href="<?php echo base_url();?>patient/patient_files/<?php echo  base64_encode($details['patient_id']);?> ">
    		                                            Archivos
    		                                        </a>
    		                                    </div>
    		                                </div>
    		                            </div>
        		                    </div>
    		                    </div>
                            </div>
                        </div>
                    </div>
                    <div id="resumen">
                    <div class="card-widget" style="border: 1px solid #c6c6cc;" >
                        <h4 class="panel-content-title">Resumen</h4>
                        <span class="app-divider2"></span>
                        <div class="row"  >
                                <div class="col-sm-7">
                                        <span style="text-align:left"><b>Practica:</b> </span> 
                                    </div>     
                                    <div class="col-sm-5">
                                        <span style="float:left"><b>Cargos:</b></span> 
                                    </div>  

                              
                                <div class="col-sm-7">
                                <span style="float:right">
    		                                    <?php if ($details['practice'] > 0): ?>
                                                    <?php echo $this->db->get_where('service', array( 'service_id' => $details['practice']))->row()->name;?>.
                                                <?php else: ?>
                                                    Otros servicios.
                                                <?php endif; ?> 
                                                </span>
    		                    </div>      
                            
                                    <div class="col-sm-5">        
                                    <span style="float:left">
                                                    <?php
                                                    if($details['status']!= 4):

                                                        if ($details['practice'] > 0): ?>
                                                            <input type="number" class="form-control monto" style="width: 150px; margin-right:0;" value="<?php echo $su = $this->db->get_where('service', array( 'service_id' => $details['practice']))->row()->cost; ?>" onkeyup="change_amout(this.value)" onchange="change_amout(this.value)" <?php echo $details['status']== 1? '' : 'disabled' ;?>/><br>
                                                        <?php else: ?>
                                                            <input type="number" class="form-control monto" style="width: 150px; margin-right:0;" value="0" onkeyup="change_amout(this.value)" onchange="change_amout(this.value)" <?php echo $details['status']== 1? '' : 'disabled' ;?>/><br>
                                                        <?php endif; 
                                                        else: ?>

                                                            <input type="number" class="form-control monto" style="width: 150px; margin-right:0;" value="<?php echo $details['charges'] ?>" onkeyup="change_amout(this.value)" onchange="change_amout(this.value)" disabled /><br>


                                                        <?php endif;?>
                                    </span>
                                    </div>
  
                                    <div class="col-sm-12">
    		                            <span style="    background: #fafbfe; padding: 15px;
                                            border: 2px dotted #748be6;
                                            border-radius: 15px;
                                            display: block;
                                            font-size: 25px;
                                            font-weight: 700;
                                            width: 100%;
                                            font-family: 'Quicksand';">
                                            Total: Q. 
                                            <input id="totalGeneral" type="hidden" name="total_appointment" value="<?php echo number_format($su,2,'.',',') ;?>"> <span id="total_text"> <?php echo $details['status'] != 4 ? number_format($su,2,'.',','):$details['charges'];?></span>
                                    </span>
    		                            <hr>

                                    
                            </div>
                            </div>
                         </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    </div>
    <?php if($details['practice']==21):?>
    <script src="https://meet.jit.si/external_api.js"></script>
<script>
    var domain = "meet.jit.si";
    var options = {
        userInfo : { 
            email : '<?php echo $this->db->get_where('patient',array('patient_id'=>$details['patient_id']))->row()->email;?>' , 
            displayName : ' <?php echo $this->accounts_model->get_name('patient', $details['patient_id']);?>',
            moderator: true,
        },
        roomName: "<?php echo base64_encode("Consulta_".$details['date'].$appointment_id);?>",
        width: "100%",
        height: "100%",
        parentNode: document.querySelector('#teleconsulta'),
        configOverwrite: {},
        interfaceConfigOverwrite: { 
            DISABLE_DOMINANT_SPEAKER_INDICATOR: true,
            SHOW_BRAND_WATERMARK: false,
            SHOW_JITSI_WATERMARK: false,
            SHOW_WATERMARK_FOR_GUESTS: false,
            DEFAULT_BACKGROUND: '<?php echo $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->theme?>',
            DEFAULT_LOGO_URL: 'https://medicaby.com/resources/app-logo/logo.svg',
        },
    }
    var api = new JitsiMeetExternalAPI(domain, options);
        api.executeCommand('subject', 'test');
</script>
<?endif;?>
    <script>


function sistemaI()
{
    $("#spanI").css("color", "black");
    $("#spanM").css("color", "#8492a6");
    $('#results').val(0);
    $('#mass').val(0); 
    $('#heightM').hide(500);
    $('#weightM').hide(500);
    $('#heightI').show(500);
    $('#weightI').show(500);
    $('#heightinchI').show(500);
    
}

function sistemaM()
{
    $("#spanI").css("color", "#8492a6");
    $("#spanM").css("color", "black");
    $('#results').val(0);
    $('#mass').val(0); 
    $('#heightM').show(500);
    $('#weightM').show(500);
    $('#heightI').hide(500);
    $('#weightI').hide(500);
    $('#heightinchI').hide(500);
    
}

    function multi() {

        var height = $('#height').val();
        var weight = $('#weight').val();


        Meters = height;
        Kilos = weight;

        Square = Meters * Meters;
        var results = Math.round(Kilos * 10 / Square) / 10;

        $('#results').val(results.toFixed(2));
        $('#mass').val(results.toFixed(2));
    }
    
    
  function imcIngles() {

        	//get value for height - feet	
        	var feet = $("input[name=feet]").val();
        	
        	//get value for height - inches and set value to 0 if field is empty
            var inches = $("input[name=inches]").val() || 0;
        
        	//calculate total inches 
        	var totalInches = eval(feet*12) + eval(inches);
        
        	//get value for weight
        	var totalWeight = $("input[name=pounds]").val();
        	
        	
        	var m = totalInches/39.370;
        	var kg = totalWeight/2.2046;
        	
        	
            $('#height').val(m);
            $('#weight').val(kg);
        
        
        	if(totalWeight == "")
        	{
            $('#results').val(0);
            $('#mass').val(0); 
        	}else
        	{
        	          	//convert to integer
            var weight = parseFloat(totalWeight, 10);
            var height = parseFloat(totalInches, 10);
        
        	//calculate BMI
            var bmi = Math.round(weight * 703 * 10 / height / height) / 10;
            
            $('#results').val(bmi.toFixed(2));
            $('#mass').val(bmi.toFixed(2));  
        	    
        	}
        	
	
    }
    
    
    
    
    var patient_id = $("#patient_id").val(); 

    
    
    
    
    $(document).ready(function() {

    
        update_table(<?php echo $patient_id;?>); 
        $("#submit_button").click(function() {
            var medicine = $("#medicine").val();
            var quantity = $("#drink").val();
            var frequency = $("#frequency").val();
            var duration = $("#duration").val();

            if (appointment_id != '' && medicine != '' && quantity != '' && frequency != '' && duration != '') {
                $.ajax({
                    url: "<?php echo base_url();?>patient/prescriptions/create/",
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
                        update_table(<?php echo $patient_id;?>);
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

    function delete_element(element_id) 
    {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "También se eliminará toda la información asociada a este usuario.",
                type: 'info',
                showCancelButton: true,
                confirmButtonColor: '#9fd13b',
                cancelButtonColor: '#fd4f57',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.value) 
                {
            $.ajax({
                url: '<?php echo base_url();?>patient/prescriptions/delete/' + element_id,
                success: function(response) {
                    update_table(<?php echo $patient_id;?>);
                }
            });
        }
            })
    }

    function update_table(appointment_id) {
        $.ajax({
            url: '<?php echo base_url();?>patient/update_prescription_table/' + appointment_id,
            success: function(response) {
                jQuery('#table_results').html(response);
            }
        });
    }
    
    
     function update_tooth_table(appointment_id){
        $.ajax({
            url: '<?php echo base_url();?>patient/update_tooth_table/' + appointment_id,
            success: function(response){
                jQuery('#table_results_tooth').html(response);
            }
        });
    }
    
    function tooth_delete(element_id)
    {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "También se eliminará toda la información asociada a este usuario.",
                type: 'info',
                showCancelButton: true,
                confirmButtonColor: '#9fd13b',
                cancelButtonColor: '#fd4f57',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.value) 
                {
                     $.ajax({
                url: '<?php echo base_url();?>patient/tooth_delete/' + element_id,
                success: function(response) {

                    update_tooth_table(appointment_id);
                    $( "#resumen" ).load(window.location.href + " #resumen" );
                  

                }
            });
                }
            })
        }
    
    function set_status(element_id)
    {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "Si marcas el tratamiento se dara como finalizado.",
            type: 'info',
            showCancelButton: true,
            confirmButtonColor:  '#9fd13b',
            cancelButtonColor: '#fd4f57',
            confirmButtonText: 'Sí, finalizar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if(result.value){
                $.ajax({
                    url: '<?php echo base_url();?>patient/set_status/' + element_id,
                    success: function(response){
                        update_tooth_table(appointment_id);
                        $( "#resumen" ).load(window.location.href + " #resumen" );
                      
                    }
                    
            });
                }
            })
    } 


    
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
</script>
<script src="<?php echo base_url();?>public/assets/theme/js/sticky-sidebar.js"></script>
<script src="<?php echo base_url();?>public/assets/theme/js/jquery.sticky.js"></script>
<script src="<?php echo base_url();?>public/assets/theme/js/PositionSticky/dist/PositionSticky.js"></script>
<script src="<?php echo base_url();?>public/assets/back/ckeditor/ckeditor.js"></script>

<script>
var sidebar = new StickySidebar('#sticky', {topSpacing: 20});


    if (typeof CKEDITOR !== 'undefined') {
        CKEDITOR.disableAutoInline = true;
        if ($('#ckeditorEmail').length) {
            CKEDITOR.config.uiColor = '#ffffff';
            CKEDITOR.config.toolbar = [
                ['Bold', 'Italic', '-', 'NumberedList', 'BulletedList', '-', 'Link', 'Unlink', '-', 'About']
            ];
            CKEDITOR.config.height = 110;
            CKEDITOR.replace('reason');
        }
        if ($('#ckeditorEmail1').length) {
            CKEDITOR.config.uiColor = '#ffffff';
            CKEDITOR.config.toolbar = [
                ['Bold', 'Italic', '-', 'NumberedList', 'BulletedList', '-', 'Link', 'Unlink', '-', 'About']
            ];
            CKEDITOR.config.height = 110;
            CKEDITOR.replace('exploration');
        }
        if ($('#ckeditorEmail12').length) {
            CKEDITOR.config.uiColor = '#ffffff';
            CKEDITOR.config.toolbar = [
                ['Bold', 'Italic', '-', 'NumberedList', 'BulletedList', '-', 'Link', 'Unlink', '-', 'About']
            ];
            CKEDITOR.config.height = 110;
            CKEDITOR.replace('instructions');
        }
        if ($('#ckplan').length) {
            CKEDITOR.config.uiColor = '#ffffff';
            CKEDITOR.config.toolbar = [
                ['Bold', 'Italic', '-', 'NumberedList', 'BulletedList', '-', 'Link', 'Unlink', '-', 'About']
            ];
            CKEDITOR.config.height = 110;
            CKEDITOR.replace('ckplan');
        }
    }
</script>
<?php
endforeach;
?>
<script type="text/javascript">



    function confirm_appointment(appointment_id) {
        Swal.fire({
            title: 'Confirmar esta acción',
            text: "Esta acción no puede deshacerse, la cita comentará inmediatamente después de la confirmación.",
            type: 'info',
            showCancelButton: true,
            confirmButtonColor: '#9fd13b',
            cancelButtonColor: '#fd4f57',
            confirmButtonText: 'Continuar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.value) {
                location.href = "<?php echo base_url(); ?>patient/appointments/start/" + appointment_id;
            }
        })
    }
   
    
        function cancel(appointment_id)
        {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "La cita será marcada como cancelada, está acción no se puede deshacer.",
                type: 'info',
                showCancelButton: true,
                confirmButtonColor: '#9fd13b',
                cancelButtonColor: '#fd4f57',
                confirmButtonText: 'Confirmar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.value) 
                {
                    location.href = "<?php echo base_url();?>patient/appointments/cancel/"+appointment_id;
                }
            })
        }
        function confirm(appointment_id)
        {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "La cita será marcada como confirmada, está acción no se puede deshacer.",
                type: 'info',
                showCancelButton: true,
                confirmButtonColor: '#9fd13b',
                cancelButtonColor: '#fd4f57',
                confirmButtonText: 'Confirmar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.value) 
                {
                    location.href = "<?php echo base_url();?>patient/appointments/confirm_appointment_det/"+appointment_id;
                }
            })
        }
        function delete_appointment(appointment_id)
        {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "También se eliminará toda la información asociada a la cita.",
                type: 'info',
                showCancelButton: true,
                confirmButtonColor: '#9fd13b',
                cancelButtonColor: '#fd4f57',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.value) 
                {
                    location.href = "<?php echo base_url();?>patient/appointments/delete/"+appointment_id;
                }
            })
        }
    </script>
    
    
 
   
   <script>
    function change_amout(amount) 
    {

        var total = 0;

        $(".monto").each(function() {

        if (isNaN(parseFloat($(this).val()))) {

            total += 0;

        } else {

            total += parseFloat($(this).val());

        }

        });
      tt = document.getElementById("total_text");
      tt.innerText= total;

      n = document.getElementById("totalGeneral");
      n.value = total;
      console.log(n.value);
      
    }
// When the user scrolls the page, execute myFunction
    function set_amout() {

        var temtotal = 0;
        var amount = $('#amount').val();
        var text = $('#total').html('Q' + amount);
    
      
    items = document.getElementsByClassName("itemTotalNeto")

    for (var i = 0; i < items.length; i++) {

     items[i].addEventListener('change', function() {

      
        temtotal = parseInt("0"+n.value) + parseInt("0"+this.value) - parseInt("0"+this.defaultValue);
     this.defaultValue = this.value;
     });
    }
    
    n.value = temtoal;
    console.log(n.value);
    };

  </script>