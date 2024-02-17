    <?php
        $this->db->where('laboratory_id', $param2);
        $laboratories = $this->db->get('laboratory')->result_array();
        foreach($laboratories as $row):
    ?>
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content animated fadeInDown">
            <form action="<?php echo base_url();?>admin/laboratories/update/<?php echo $row['laboratory_id'];?>" method="POST">
                <div class="modal-header" style="background-color:#fff; box-shadow: 0 4px 2px -2px 000;">
                    <h4 style="font-size:21px; color:#565b6b; font-family:'Poppins';"><span style="vertical-align:-3px"> Actualizar laboratorio.</span></h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body" style="background-color:#f1f3f7;">
                    <div class="form-group">
                        <div class="container">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group m-b-15">
                                        <label for="simpleinput">Nombre</label>
                                        <input type="text" name="name" required="" value="<?php echo $row['name'];?>" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group m-b-15">
                                        <label for="simpleinput">Precio de día</label>
                                        <input type="text" name="price_day" required="" value="<?php echo $row['price_day'];?>" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group m-b-15">
                                        <label for="simpleinput">Precio de noche</label>
                                        <input type="text" name="price_night" required="" value="<?php echo $row['price_night'];?>" class="form-control">
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
    </div>
    <?php endforeach;?>