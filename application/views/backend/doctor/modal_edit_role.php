<?php $role_id = base64_decode($param2);
    $role = $this->accounts_model->getRole($role_id);?>
<div class="modal-content animated fadeInDown">
    <form action="<?php echo base_url().'doctor/roles/edit/'.$param2;?>" method="POST">
        <div class="modal-header" style="background-color:#fff; box-shadow: 0 4px 2px -2px 000;">
            <h4 style="font-size:21px; color:#565b6b; font-family:'Poppins';"><span style="vertical-align:-3px">Editar rol de usuario</span></h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12 mb-3">
                            <div class="form-group">
                                <label class="col-form-label">Nombre:</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="name" maxlength="100" value="<?php echo $role['name'];?>" required />
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 mb-3">
                            <div class="form-group">
                                <label class="col-form-label">Descripción:</label>
                                <textarea class="form-control" name="description" id="description"><?php echo $role['description'];?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">&times; Cancelar</button>
            <button type="submit" class="button-confirm" id="saveRole">Guardar</button>
        </div>
    </form>
</div>
<script type="text/javascript">
</script>