<?php
        $this->db->where('clinic_id', $param2);
        $clinics = $this->db->get('clinic')->result_array();
        foreach($clinics as $clinic):
    ?>
<div class="modal-content animated fadeInDown">
    <div class="modal-header" style="background-color:#fff;">
        <h4 style="font-size:21px; color:#565b6b; font-family:'Poppins';">
            <span style="vertical-align:-3px">Actualizar clínica</span>
        </h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
    </div>
    <form action="<?php echo base_url();?>staff/clinics/update/<?php echo $clinic['clinic_id'];?>" method="POST">
        <div class="modal-body" style="background-color:#f1f3f7;">
            <div class="form-group">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group m-b-15">
                                <label for="simpleinput">Nombre</label>
                                <input type="text" name="name" required="" value="<?php echo $clinic['name'];?>" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group m-b-15">
                                <label for="simpleinput">Teléfono</label>
                                <input type="number" name="phone" required="" class="form-control" value="<?php echo $clinic['phone'];?>">
                                <small>* Ingresar código de área p.j: 502xxxxxxxx</small>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group m-b-15">
                                <label for="simpleinput">Horario matutino <small>(Inicial)</small></label>
                                <div class="input-group clockpicker" data-align="bottom" data-autoclose="true">
                                    <div class="input-group date timepicker" id="horainicio5" data-target-input="nearest">
                                        <input type="text" name="morning" required="" class="form-control datetimepicker-input" data-toggle="datetimepicker" data-target="#horainicio5" value="<?php echo $clinic['morning'];?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group m-b-15">
                                <label for="simpleinput">Horario matutino <small>(Final)</small></label>
                                <div class="input-group clockpicker" data-align="bottom" data-autoclose="true">
                                    <div class="input-group date timepicker" id="horainicio6" data-target-input="nearest">
                                        <input type="text" name="b_morning" required="" class="form-control datetimepicker-input" data-toggle="datetimepicker" data-target="#horainicio6" value="<?php echo $clinic['b_morning'];?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group m-b-15">
                                <label for="simpleinput">Horario vespertino <small>(Inicial)</small></label>
                                <div class="input-group clockpicker" data-align="top" data-autoclose="true">
                                    <div class="input-group date timepicker" id="horainicio7" data-target-input="nearest">
                                        <input type="text" name="afternoon" required="" class="form-control datetimepicker-input" data-toggle="datetimepicker" data-target="#horainicio7" value="<?php echo $clinic['afternoon'];?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group m-b-15">
                                <label for="simpleinput">Horario vespertino <small>(Final)</small></label>
                                <div class="input-group clockpicker" data-align="top" data-autoclose="true">
                                    <div class="input-group date timepicker" id="horainicio8" data-target-input="nearest">
                                        <input type="text" name="b_afternoon" required="" class="form-control datetimepicker-input" data-toggle="datetimepicker" data-target="#horainicio8" value="<?php echo $clinic['b_afternoon'];?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group m-b-15">
                                <label for="simpleinput">Correo electrónico</label>
                                <input type="email" name="email" required="" class="form-control" value="<?php echo $clinic['email'];?>">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group m-b-15">
                                <label for="simpleinput">Intervalo entre citas</label>
                                <input type="number" name="interval" required="" class="form-control" value="<?php echo $clinic['time_interval'];?>">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group m-b-15">
                                <label for="simpleinput">Dirección</label>
                                <textarea type="text" name="address" required="" class="form-control"><?php echo $clinic['address'];?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="button-confirm">Actualizar</button>
        </div>
    </form>
</div>
<?php endforeach;?>

<script src="<?php echo base_url();?>public/assets/back/js/timepicker.js"></script>