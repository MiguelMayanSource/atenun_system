<?php $data = $this->db->get_where('surgery_room',array('surgery_room_id'=>$param2))->row(); ?>
<div class="modal-content animated fadeInDown">
    <form action="<?php echo base_url();?>staff/surgery_room/update/<?php echo $param2;?>" method="POST">
        <div class="modal-header" style="background-color:#fff; box-shadow: 0 4px 2px -2px 000;">
            <h4 style="font-size:21px; color:#565b6b; font-family:'Poppins';"><span style="vertical-align:-3px">
                    Actualizar sala de habitaciones.
                </span></h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group m-b-15">
                                <label for="simpleinput">Nombre</label>
                                <input type="text" name="name" required="" class="form-control" value="<?php echo $data->name ;?>">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group m-b-15">
                                <label for="simpleinput">Descripción</label>
                                <textarea type="text" name="description" required="" class="form-control"><?php echo $data->description?></textarea>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group m-b-15">
                                <label for="simpleinput">Estado</label>
                                <select name="status" required="" class="form-control">
                                    <option value="1" <?php echo $data->status == '1' ? "selected" :"";?>>Libre</option>
                                    <option value="2" <?php echo $data->status == '2' ? "selected" :"";?>>En limpieza</option>
                                    <option value="3" <?php echo $data->status == '3' ? "selected" :"";?>>Ocupada</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="button-confirm">Guardar</button>
        </div>
    </form>
</div>