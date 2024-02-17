<?php 
    $account_type_id = base64_decode($param2);
    $tipo = $this->crud_model->getAccountType($account_type_id);
?>
<div class="modal-content animated fadeInDown">
    <form action="<?php echo base_url();?>doctor/account_types/edit/" method="POST">
        <div class="modal-header" style="background-color:#fff; box-shadow: 0 4px 2px -2px 000;">
            <h4 style="font-size:21px; color:#565b6b; font-family:'Poppins';"><span style="vertical-align:-3px">Actualizar tipo de cuenta</span></h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <div class="container">
                    <div class="row">
                        <input type="hidden" name="account_type_id" id="account_type_id" value="<?php echo $account_type_id;?>">
                        <div class="col-sm-12 mb-3">
                            <div class="form-group">
                                <label class="col-form-label">Nombre:</label>
                                <input type="text" class="form-control" name="name" value="<?php echo $tipo['name'];?>" required />
                            </div>
                        </div>
                        <div class="col-sm-12 mb-3">
                            <div class="form-group">
                                <label class="col-form-label">Descripción:</label>
                                <textarea name="description" id="" cols="30" rows="3" class="form-control"><?php echo $tipo['description'];?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">&times; Cancelar</button>
            <button type="submit" class="button-confirm" id="editTypeAccount">Guardar</button>
        </div>
    </form>
</div>