<div class="modal-content animated fadeInDown">
    <form action="<?php echo base_url();?>staff/currencies/new/" method="POST">
        <div class="modal-header" style="background-color:#fff; box-shadow: 0 4px 2px -2px 000;">
            <h4 style="font-size:21px; color:#565b6b; font-family:'Poppins';"><span style="vertical-align:-3px">Nueva moneda</span></h4>
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
                                    <input type="text" class="form-control" name="name" id="name" required />
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 mb-3">
                            <div class="form-group">
                                <label class="col-form-label">Símbolo:</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="symbol" id="symbol" required />
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 mb-3">
                            <div class="form-group">
                                <label class="col-form-label">Código ISO:</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="code" id="code" required />
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 mb-3">
                            <div class="form-group">
                                <label class="col-form-label">Origen:</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="origin" id="origin" required />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">&times; Cancelar</button>
            <button type="submit" class="button-confirm" id="saveCurrency">Guardar</button>
        </div>
    </form>
</div>