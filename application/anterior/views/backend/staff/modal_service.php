    <link href="https://anton.miaula.com.gt/assets/theme/css/bootstrap-clockpicker.min.css" rel="stylesheet">
    <?php
        $this->db->where('service_id', $param2);
        $services = $this->db->get('service')->result_array();
        foreach($services as $row):
    ?>
    <link rel="stylesheet" href="http://dentalstudio.com.gt/app/style/back/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content animated fadeInDown">
            <form action="<?php echo base_url();?>staff/services/update/<?php echo $row['service_id'];?>" method="POST">
                <div class="modal-header" style="background-color:#fff;  box-shadow: 0 4px 2px -2px 000;">
                    <h4 style="font-size:21px; color:#565b6b; font-family:'Poppins';"><span style="vertical-align:-3px"> Actualizar servicio.</span></h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="container">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group m-b-15">
                                        <label for="simpleinput">Nombre</label>
                                        <input type="text" name="name" required="" value="<?php echo $row['name'] ?>" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group m-b-15">
                                        <label for="simpleinput">Costo</label>
                                        <input type="number" name="cost" required="" value="<?php echo $row['cost'] ?>" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group m-b-15">
                                        <label for="simpleinput">Descripción</label>
                                        <textarea type="text" name="description" required="" class="form-control"><?php echo $row['description'];?> </textarea>
                                    </div>
                                    <small>* Las ganancias establecidas en <b>Financiero</b> serán calculadas automáticamente mediante el <b>Costo</b> que ingreses en cada servicio.</small>
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