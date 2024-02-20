   	<div id="main-content">
   	    <div class="row">
   	        <div class="col-sm-12">
   	            <div class="title-header">
   	                <h3 class="module-title">Resultados de la búsqueda</h3>
   	            </div>
   	        </div>
   	        <?php 
		        $this->db->order_by('first_name', 'ASC');
				$search_query = $this->db->query('SELECT *  FROM patient  WHERE  CONCAT_WS(" ", first_name, last_name ) LIKE  "%'.$like.'%" AND status != "0"');   
				if($search_query->num_rows() > 0):
			?>
   	        <div class="col-sm-12">
   	            <div class="table-responsive">
   	                <table class="table table-padded">
   	                    <thead>
   	                        <tr>
   	                            <th>Paciente</th>
   	                            <th>Género</th>
   	                            <th>Contactos</th>
   	                            <th>Última cita</th>
   	                            <th>Edad</th>
   	                            <th>Acciones</th>
   	                        </tr>
   	                    </thead>
   	                    <tbody>
   	                        <?php foreach($search_query->result_array() as $pt): ?>
   	                        <tr>
   	                            <td>
   	                                <div class="user-with-avatar">
   	                                    <img alt="" src="<?php echo $this->accounts_model->get_photo('patient', $pt['patient_id']);?>"><span> <?php echo $this->accounts_model->get_name('patient', $pt['patient_id']);?> </span>
   	                                </div>
   	                            </td>
   	                            <td>
   	                                <div class="patient-gender-male">
   	                                    <?php echo $pt['gender'] =='M' ?  'Masculino' : 'Femenino'; ?>
   	                                </div>
   	                            </td>
   	                            <td style="width:250px">
   	                                <div class="patient-contact">
   	                                    <?php if($pt['whatsapp_status']!= 0 ):?>
   	                                    <a href="https://wa.me/<?php echo $pt['phone']?>" target="_blank" data-toggle="tooltip" data-placement="top" title="WhatsApp" class="no-decoration"><i class="icon-container picons-social-icon-whatsapp"></i></a>
   	                                    <?php endif;?>
   	                                    <a href="tel:+502<?php echo $pt['phone']?>" class="no-decoration" data-toggle="tooltip" data-placement="top" title="Llamar"><i class="icon-container picons-thin-icon-thin-0289_mobile_phone_call_ringing_nfc"></i></a>
   	                                    <?php if($pt['email_status']!= 0 ):?>
   	                                    <a href="mailto:<?php echo $pt['email']?>" class="no-decoration" data-toggle="tooltip" data-placement="top" title="Correo" target="_blank"><i class="icon-container picons-social-icon-gmail"></i></a>
   	                                    <?php endif;?>
   	                                </div>
   	                            </td>
   	                            <td>
   	                                <span class="smaller lighter">
   	                                    <?php 
                                        $this->db->order_by('appointment_id', 'desc');
                                        $this->db->where('patient_id', $pt['patient_id']);
                                        $app_pt = $this->db->get('appointment')->row();
                                        echo $this->crud_model->formatear2($app_pt->date);      
                                    ?>
   	                                </span>
   	                            </td>
   	                            <td class="nowrap">
   	                                <span style="color:#99bf2d;font-weight:bold;    font-family: 'CircularStd', sans-serif;font-size: 13px;">
   	                                    <?php
									   $originalDate = $pt['date_of_birth'];
                                        $newDate = date("d-m-Y", strtotime($originalDate));
                                    ?>
   	                                    <?php echo $this->accounts_model->get_age($newDate);?>
   	                                </span>
   	                            </td>
   	                            <td class="row-actions">
   	                                <div class="dropdown">
   	                                    <div class="dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
   	                                        <i class="batch-icon-ellipsis" style="color:#3634a9;font-size: 20px;"></i>
   	                                    </div>
   	                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
   	                                        <a class="dropdown-item" href="<?php echo base_url(); ?>admin/patient_profile/<?php echo base64_encode($pt['patient_id']); ?>">Perfil</a>
   	                                        <a class="dropdown-item" href="javascript:void(0);" onclick="delete_patient('<?php echo $pt['patient_id'];?>')">Eliminar</a>
   	                                    </div>
   	                                </div>
   	                            </td>
   	                        </tr>
   	                        <?php endforeach;?>
   	                    </tbody>
   	                </table>
   	            </div>
   	        </div>
   	        <?php else:?>
   	        <h1 style="text-align:center;font-size:22px; font-weight:normal;margin-top:5%;">Lo sentimos, no encontramos ninguna coincidencia <br><br> <img src="https://miaula.com.gt/demo/uploads/no_results.png" style="width:30%" /></h1>
   	        <?php endif;?>





   	    </div>
   	</div>

   	<script type="text/javascript">
function delete_patient(patient_id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "También se eliminará toda la información asociada a este paciente.",
        type: 'info',
        showCancelButton: true,
        confirmButtonColor: '#9fd13b',
        cancelButtonColor: '#fd4f57',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.value) {
            location.href = "<?php echo base_url();?>admin/patients/delete/" + patient_id;
        }
    })
}
   	</script>