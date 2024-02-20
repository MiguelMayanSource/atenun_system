<?php  $vs = $this->db->get('vital_sign')->num_rows()+1;?>
<h5 class="panel-content-title">Finalizar turno</h5>
<span class="app-divider2"></span>
<div class="row" style="    font-size: 12px;">
<form id="formTurn" action="<?php echo base_url();?>admin/stabilitation/finish" method="POST" enctype="multipart/form-data">
<input type="hidden" name="stabilitation_id" value="<?php echo $stabilitation_id;?>">       
<input type="hidden" name="patient_id" value="<?php echo $patient_id;?>">       
<div class="modal-header" style="background-color:#fff;box-shadow: 0 4px 2px -2px 000;">
            <h4 style="font-size:21px; color:#565b6b; font-family:'Poppins';"><span style="vertical-align:-3px"> <i class="batch-icon-user-2-add"></i> Agregar nueva hospitalización.</span></h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body" style="background-color:#fff;">
            <div class="col-xl-12 col-lg-12 col-sm-12" style="float: none; margin: 0 auto;">
               
                <div class="row">
                   
                    <div class="col-sm-4">
                        <div class="form-group m-b-15">
                            <label for="simpleinput">Habitación</label>
                            <select class="itemName form-control select2" style="width:100%" name="room_id" required="required">
                                <option value="">Seleccionar</option>
                                <?php 
                                $rm_id = $this->db->get_where('stabilitation_ref',array('stabilitation_ref_id'=>$stabilitation_id))->row()->room_id;
                                $this->db->where('status', '1');
                                $query = $this->db->get('room')->result_array();
                                foreach($query as $pat):
                            ?>
                                <option value="<?php echo $pat['room_id'];?>" <?php echo $rm_id == $pat['room_id'] ? 'Selected':''; ?> >
                                    <?php echo $pat['name']; ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group m-b-15">
                            <label for="simpleinput">Fecha de Ingreso</label>
                            <input style="border: 1px solid #198cff8f;" type="date" name="entry_date" class="form-control" value="<?php echo date('Y-m-d');?>">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group m-b-15">
                            <label for="simpleinput">Hora de Ingreso</label>
                            <input style="border: 1px solid #198cff8f;" type="time" name="entry_time" class="form-control" value="<?php echo date('H:i')?>">
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group m-b-15">
                            <label for="simpleinput">Médico</label>
                            <select class="itemName form-control select2" style="width:100%" name="doctor_id" required="required">
                                <option value="">Seleccionar</option>
                                <?php 
                                $this->db->order_by('admin_id', 'ASC');
                                $this->db->where('status', '1');
                                $this->db->where('owner', '0');
                                $this->db->where('type', 'doctor');
                                $query = $this->db->get('admin')->result_array();
                                foreach($query as $pat):
                            ?>
                                <option value="<?php echo $pat['admin_id'];?>">
                                    <?php echo $this->accounts_model->get_name('admin', $pat['admin_id']); ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group m-b-15">
                            <label for="simpleinput">Enfermero</label>
                            <select class="itemName form-control select2" style="width:100%" name="staff_id" required="required">
                                <option value="">Seleccionar</option>
                                <?php 
                                $this->db->order_by('staff_id', 'ASC');
                                $this->db->where('status', '1');
                                $this->db->where('role_id', '6');
                                $query = $this->db->get('staff')->result_array();
                                foreach($query as $pat):
                            ?>
                                <option value="<?php echo $pat['staff_id'];?>">
                                    <?php echo $this->accounts_model->get_name('staff', $pat['staff_id']); ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <br>
            </div>
        </div>
        <div class='col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 '>
            <div class="form-group">
                <button style='Float:right;' type="submit" class="btn btn-primary submit">Guardar</button>
            </div>
        </div>
    </form>
    <a class="btn btn-danger" style="margin-left:10px;" href="javascript:void(0)" onclick="load_view('patient_turns','turns',{'stabilitation_id':<?php echo $stabilitation_id; ?>,'patient_id':<?php echo $patient_id; ?>})">Cancelar</a>
</div>

<script>

$("#formTurn").submit(function(e) {
    e.preventDefault();


  
    var form = $(this);
    var url = form.attr('action');
    $.ajax({
        type: "POST",
        url: url,
        data: new FormData(this),
        processData: false,
        contentType: false,
        beforeSend: function() {
            
            $('.submit').html('Guardando....');
            $(".submit").attr('disabled', true);
        },
        success: function(response) {

            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: 'Orden registrada',
                showConfirmButton: false,
                timer: 1500
            });

            load_view('patient_turns','turns',{'stabilitation_id':<?php echo $stabilitation_id; ?>,'patient_id':<?php echo $patient_id; ?>})

        },
        complete: function() {
         
        },
        error: function() {
            console.log("error");
        }
    });



});


</script>