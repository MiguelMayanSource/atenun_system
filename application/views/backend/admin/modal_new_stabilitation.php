<div class="modal-content animated fadeInDown">
    <form id="formNewPat" action="<?php echo base_url();?>admin/stabilitation/new" method="POST" enctype="multipart/form-data">
        <div class="modal-header" style="background-color:#fff;box-shadow: 0 4px 2px -2px 000;">
            <h4 style="font-size:21px; color:#565b6b; font-family:'Poppins';"><span style="vertical-align:-3px"> <i class="batch-icon-user-2-add"></i> Agregar nueva hospitalización.</span></h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body" style="background-color:#fff;">
            <div class="col-xl-12 col-lg-12 col-sm-12" style="float: none; margin: 0 auto;">
                <h4 class="todo-content-header">
                    <i class="batch-icon-arrow-right"></i><span>Paciente</span>
                </h4>
                <br>
                <div class="row">
                    <div class="form-group col-sm-12">
                        <select class="itemName form-control select2" style="width:100%" name="patient_id" required="required">
                            <option value="">Seleccionar</option>
                            <?php 
										                $this->db->order_by('first_name', 'ASC');
										                $this->db->where('status !=', '0');
										                $query = $this->db->get('patient')->result_array();
                                                        foreach($query as $pat):
                                                    ?>
                            <option value="<?php echo $pat['patient_id'];?>">
                                <?php echo $this->accounts_model->get_name('patient', $pat['patient_id']); ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <br>
                <h4 class="todo-content-header">
                    <i class="batch-icon-arrow-right"></i><span>Ingreso Hospitalario</span>
                </h4>
                <br>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Tipo de ingreso:</label>
                            <div class="input-group">
                                <div class="form-check" style="padding-left: 0px;">
                                    <input checked class="radiobutton" type="radio" name="entry_type" id="radio5" value="Ambulatorio"><label class="radiobutton-label" for="radio5">Ambulatorio</label>
                                </div>
                                <div class="form-check">
                                    <input class="radiobutton" type="radio" name="entry_type" id="radio6" value="Estacionario"><label class="radiobutton-label" for="radio6">Estacionario</label>
                                </div>

                                <div class="form-check mr-2">
                                    <input class="radiobutton" type="radio" name="entry_type" id="radio7" value="Hospitalización"><label class="radiobutton-label" for="radio7">Hospitalización</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group m-b-15">
                            <label for="simpleinput">Habitación</label>
                            <select class="itemName form-control select2" style="width:100%" name="room_id" required="required">
                                <option value="">Seleccionar</option>
                                <?php 
                               
                                $this->db->where('status', '1');
                                $query = $this->db->get('room')->result_array();
                                foreach($query as $pat):
                            ?>
                                <option value="<?php echo $pat['room_id'];?>">
                                    <?php echo $pat['name']; ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group m-b-15">
                            <label for="simpleinput">Fecha de Ingreso</label>
                            <input style="border: 1px solid #198cff8f;" type="date" name="entry_date" class="form-control" value="<?php echo date('Y-m-d');?>">
                        </div>
                    </div>
                    <div class="col-sm-6">
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
                                $this->db->where('status !=', '0');
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
        <div class="modal-footer">
            <button type="submit" class="button-confirm">Enviar</button>
        </div>
    </form>
</div>
<script src="<?php echo base_url();?>public/assets/search/bootstrap3-typeahead.js"></script>
<script src="<?php echo base_url();?>public/assets/theme/js/select2.min.js"></script>
<script type="text/javascript">
$(".itemName").select2();
</script>