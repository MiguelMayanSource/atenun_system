       <?php $folder = $this->db->get_where('patient_file', array('patient_file_id' => base64_decode($param2)))->row_array(); ?>
       <div class="modal-content animated fadeInDown">
           <div class="modal-header" style="background-color:#fff;  box-shadow: 0 4px 2px -2px 000;">
               <h4 style="font-size:21px; color:#565b6b; font-family:'Poppins';"><span style="vertical-align:-3px"> <i class="picons-thin-icon-thin-0001_compose_write_pencil_new"></i> Crear carpeta.</span></h4>
               <button type="button" class="close" data-dismiss="modal">&times;</button>
           </div>
           <div class="modal-body">

               <div class="form-group row" id="loadingx" style="display:none;">
                   <div class="col-sm-12 text-center">
                       <label>Creando la carpeta, por favor espera...</label><br>
                       <img src="<?php echo base_url();?>public/uploads/loading.gif" width="50px" />
                   </div>
               </div>
               <div class="form-group row" id="create">
                   <div class="col-sm-12">
                       <div class="form-group">
                           <label>Nombre</label>
                           <input class="form-control" name="name" id="name" required="" type="text" value="<?php echo  $folder['name'] ?>">
                       </div>
                   </div>
               </div>
           </div>
           <div class="modal-footer">
               <button type="submit" id="submit_btn" class="button-confirm">Guardar</button>
           </div>
       </div>

       <script>
$(document).ready(function() {
    $("#submit_btn").click(function() {
        $("#loadingx").show(500);
        $("#create").hide(500);
        $("#submit_btn").hide(500);
        var name = $("#name").val();
        if (name != "") {
            $.ajax({
                url: "<?php echo base_url();?>admin/patient_files/edit_folder",
                type: 'POST',
                data: {
                    name: name,
                    patient_file_id: <?php echo  $folder['patient_file_id'] ?>
                },
                success: function(result) {
                    $("#name").val('');
                    $('#exampleModal').modal('toggle');
                    load_view('patient_files', 'files', {
                        'patient_id': <?php echo  $folder['patient_id'] ?>,
                        'parent_id': <?php echo  $folder['parent_id'] ?>
                    });
                }
            });
        }
    });
});
       </script>