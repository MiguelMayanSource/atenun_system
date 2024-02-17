    <?php
        $this->db->where('id', $param2);
        $categories = $this->db->get('subcategory')->result_array();
        foreach($categories as $row):
    ?>
    <div class="modal-content animated fadeInDown">
        <form action="<?php echo base_url();?>admin/subcategories/update/<?php echo $row['id'];?>" method="POST">
            <div class="modal-header" style="background-color:#fff;  box-shadow: 0 4px 2px -2px 000;">
                <h4 style="font-size:21px; color:#565b6b; font-family:'Poppins';"><span style="vertical-align:-3px"> <i class="picons-thin-icon-thin-0001_compose_write_pencil_new"></i> Actualizar categoría.</span></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <div class="container">
                        <div class="row">
                        <div class="col-sm-12">
                                    <div class="form-group m-b-15">
                                        <label for="simpleinput">Categoría</label>
                                        <select name="category_id" class="form-control">
                                            <option value="">Seleccione una categoría</option>
                                            <?php 
                                                $this->db->where('status',1);
                                                $categories = $this->db->get('category')->result_array();
                                                foreach($categories as $rs):
                                            ?>
                                            <option value="<?php echo $rs['id'];?>" <?php echo ($row['category_id'] == $rs['id']) ? 'selected' : '';?>><?php echo $rs['name'];?></option>
                                            <?php endforeach;?>
                                        </select>
                                    </div>
                                </div>
                            <div class="col-sm-12">
                                <div class="form-group m-b-15">
                                    <label for="simpleinput">Nombre</label>
                                    <input type="text" name="name" value="<?php echo $row['name'];?>" required="" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group m-b-15">
                                    <label for="simpleinput">Descripción</label>
                                    <textarea type="text" name="description" rows="5" class="form-control"><?php echo $row['description'];?></textarea>
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
    <?php endforeach;?>