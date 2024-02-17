    <?php
        $this->db->where('specialtie_id', $param2);
        $specialties = $this->db->get('specialtie')->result_array();
        foreach($specialties as $row):
    ?>

    <div class="modal-content animated fadeInDown">
        <form action="<?php echo base_url();?>staff/specialties/update/<?php echo $row['specialtie_id'];?>" method="POST">
            <div class="modal-header" style="background-color:#fff; box-shadow: 0 4px 2px -2px 000;">
                <h4 style="font-size:21px; color:#565b6b; font-family:'Poppins';"><span style="vertical-align:-3px"> Actualizar especialidad.</span></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group m-b-15">
                                    <label for="simpleinput">Nombre</label>
                                    <input type="text" name="name" required="" value="<?php echo $row['name'] ?>" class="form-control">
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