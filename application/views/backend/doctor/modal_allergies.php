	    <div class="modal-content animated fadeInDown" style="border-radius:20px;">
	        <div class="modal-header" style="background-color:#fff;border-radius:20px;  box-shadow: 0 4px 2px -2px 000;">
	            <h4 style="font-size:21px; color:#565b6b; font-family:'Poppins';"><span style="vertical-align:-3px"> <i class="picons-thin-icon-thin-0825_stetoscope_doctor_hospital_ill"></i> Registrar alergias</span></h4>
	            <button type="button" class="close" data-dismiss="modal" id="close">&times;</button>
	        </div>
	        <div class="modal-body" style="background-color:#f1f3f7;">
	            <div class="form-group">
	                <div class="container">
	                    <div class="row">
	                        <div class="col-sm-10">
	                            <div class="form-group m-b-15">
	                                <label for="simpleinput">Alergia</label>
	                                <input type="text" id="name" class="form-control">
	                            </div>
	                        </div>
	                        <div class="col-sm-2">
	                            <div class="form-group m-b-15">
	                                <input type="submit" id="submit_button" value="+" class="btn btn-info" style="margin-top:27px" />
	                            </div>
	                        </div>
	                        <div class="col-sm-12" id="table_results">
	                        </div>
	                    </div>
	                </div>
	            </div>
	        </div>
	        <div class="modal-footer" style="text-align:center; padding:20px;"></div>
	    </div>

	    <script>
var post_message = 'Se ha registrado la alergia correctamente';
$(document).ready(function() {
    var patient_id = <?php echo $param2;?>;
    update_table(patient_id);

    $("#submit_button").click(function() {

        var name = $("#name").val();

        console.log(patient_id);
        console.log(name);

        if (patient_id != "" && name != "") {
            $.ajax({
                url: "<?php echo base_url();?>doctor/patients/allergies/",
                type: 'POST',
                data: {
                    patient_id: patient_id,
                    name: name
                },
                success: function(result) {
                    update_table(patient_id);
                    $("#name").val('');
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'bottom-right',
                        showConfirmButton: false,
                        timer: 5000
                    });
                    Toast.fire({
                        type: 'success',
                        title: post_message
                    });

                    location.reload();


                }
            });
        }
    });



});
	    </script>

	    <script>
var patient_id = $("#patient_id").val();
<?php if($this->db->order_by('allergie_id','desc')->get_where('allergie',array('patient_id' => $param2))->num_rows() > 0):?>
update_table(patient_id);
<?php endif;?>

function update_table(patient_id) {
    $.ajax({
        url: '<?php echo base_url();?>doctor/update_allergie_table/' + patient_id,
        success: function(response) {
            jQuery('#table_results').html(response);
        }
    });
}
	    </script>