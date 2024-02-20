<div class="modal-content animated fadeInDown">
    <form action="<?php echo base_url();?>admin/services/create" method="POST">
        <div class="modal-header" style="background-color:#fff; box-shadow: 0 4px 2px -2px 000;">
            <h4 style="font-size:21px; color:#565b6b; font-family:'Poppins';"><span style="vertical-align:-3px"> <i class="batch-icon-heart-full"></i> Agregar nuevo servicio.</span></h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group m-b-15">
                                <label for="simpleinput">Nombre</label>
                                <input type="text" name="name" required="" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group m-b-15">
                                <label for="simpleinput">Costo</label>
                                <input type="number" name="cost" required="" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group m-b-15">
                                <label for="simpleinput">Descripción</label>
                                <textarea type="text" name="description" required="" class="form-control"></textarea>
                            </div>
                            <small>* Las ganancias establecidas en <b>Financiero</b> serán calculadas automáticamente mediante el <b>Costo</b> que ingreses en cada servicio.</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="button-confirm">Enviar</button>
        </div>
    </form>
</div>