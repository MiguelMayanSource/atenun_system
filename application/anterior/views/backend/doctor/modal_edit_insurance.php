    <?php
        $this->db->where('insurance_id', $param2);
        $insurances = $this->db->get('insurance')->result_array();
        foreach($insurances as $row):
    ?>

    <div class="modal-content animated fadeInDown">
        <form action="<?php echo base_url();?>doctor/insurance/update/<?php echo $row['insurance_id'];?>" method="POST">
            <div class="modal-header" style="background-color:#fff; box-shadow: 0 4px 2px -2px 000;">
                <h4 style="font-size:21px; color:#565b6b; font-family:'Poppins';"><span style="vertical-align:-3px"> Actualizar aseguradora.</span></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-8">
                                <div class="form-group m-b-15">
                                    <label for="simpleinput">Nombre</label>
                                    <input type="text" name="name" required="" value="<?php echo $row['name'] ?>" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group m-b-15">
                                    <label for="simpleinput">Nit</label>
                                    <input type="text" name="nit" required="" value="<?php echo $row['nit'] ?>" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group m-b-15">
                                    <label for="simpleinput">Dia de facturación</label>
                                    <input type="number" name="date" min="1"  max="31" required="" value="<?php echo $row['date'] ?>" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group m-b-15">
                                    <label for="simpleinput">Detalles</label>
                                    <textarea  name="address" required="" class="form-control"><?php echo $row['address'] ?></textarea>
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