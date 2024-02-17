<?php
        $this->db->where('equipment_id', $param2);
        $equipo = $this->db->get('equipment')->result_array();
        foreach($equipo as $row):
    ?>
<div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content animated fadeInDown">
        <form action="<?php echo base_url();?>staff/equipment/update/<?php echo $row['equipment_id'];?>" method="POST">
            <div class="modal-header" style="background-color:#fff; box-shadow: 0 4px 2px -2px 000;">
                <h4 style="font-size:21px; color:#565b6b; font-family:'Poppins';"><span style="vertical-align:-3px">
                        Actualizar Equipo.</span></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" style="background-color:#f1f3f7;">
                <div class="form-group">
                    <div class="container">
                        <div class="row">

                            <div class="col-sm-4">
                                <div class="form-group m-b-15">
                                    <label for="simpleinput">Nombre del equipo</label>
                                    <input type="text" name="name" required="" class="form-control" value='<?php echo $row['name'];?>'>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <div class="form-group m-b-15">
                                    <label for="simpleinput">Marca</label>
                                    <input type="text" name="marca" required="" class="form-control" value='<?php echo $row['marca'];?>'>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group m-b-15">
                                    <label for="simpleinput">Modelo</label>
                                    <input type="text" name="modelo" required="" class="form-control" value='<?php echo $row['modelo'];?>'>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <div class="form-group m-b-15">
                                    <label for="simpleinput">localizacion</label>
                                    <input type="text" name="location" required="" class="form-control" value='<?php echo $row['location'];?>'>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group m-b-15">
                                    <label for="simpleinput">Descripción</label>
                                    <textarea name="description" id="" cols="30" rows="5" class='form-control'><?php echo $row['description'];?></textarea>
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