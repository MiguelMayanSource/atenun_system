<?php 
    $currency_id = base64_decode($param2);
    $mon = $this->crud_model->getCurrency($currency_id);
?>
<div class="modal-content animated fadeInDown">
    <form action="<?php echo base_url();?>staff/currencies/edit/" method="POST">
        <div class="modal-header" style="background-color:#fff; box-shadow: 0 4px 2px -2px 000;">
            <h4 style="font-size:21px; color:#565b6b; font-family:'Poppins';"><span style="vertical-align:-3px">Actualizar moneda</span></h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <div class="container">
                    <div class="row">
                        <input type="hidden" name="currency_id" id="currency_id" value="<?php echo $currency_id;?>">
                        <div class="col-sm-12 mb-3">
                            <div class="form-group">
                                <label class="col-form-label">Nombre:</label>
                                <input type="text" class="form-control" name="name" value="<?php echo $mon['name'];?>" required />
                            </div>
                        </div>
                        <div class="col-sm-12 mb-3">
                            <div class="form-group">
                                <label class="col-form-label">Símbolo:</label>
                                <input type="text" class="form-control" name="symbol" value="<?php echo $mon['symbol'];?>" required />
                            </div>
                        </div>
                        <div class="col-sm-12 mb-3">
                            <div class="form-group">
                                <label class="col-form-label">Código ISO:</label>
                                <input type="text" class="form-control" name="code" value="<?php echo $mon['code'];?>" required />
                            </div>
                        </div>
                        <div class="col-sm-12 mb-3">
                            <div class="form-group">
                                <label class="col-form-label">Origen:</label>
                                <input type="text" class="form-control" name="origin" value="<?php echo $mon['origin'];?>" required />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">&times; Cancelar</button>
            <button type="submit" class="button-confirm" id="editCurrency">Guardar</button>
        </div>
    </form>
</div>