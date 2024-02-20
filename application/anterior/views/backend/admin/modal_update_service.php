<?php
        $this->db->where('service_id', $param2);
        $products = $this->db->get('service')->result_array();
        foreach($products as $row):
    ?>
<div class="modal-content animated fadeInDown">
    <form action="<?php echo base_url();?>admin/services/update/<?php echo $param2?>" method="POST" enctype="multipart/form-data">
        <div class="modal-header" style="background-color:#fff; box-shadow: 0 4px 2px -2px 000;">
            <h4 style="font-size:21px; color:#565b6b; font-family:'Poppins';"><span style="vertical-align:-3px">
                    <i class="picons-thin-icon-thin-0001_compose_write_pencil_new"></i> Acutalizar servicio</span></h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group m-b-15">
                                <label for="simpleinput">Nombre</label>
                                <input type="text" name="name" step="any" required="" value="<?php echo $row['name']?>" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group m-b-15">
                                <label for="simpleinput">Costo</label>
                                <input type="number" name="cost" step="any" required="" value="<?php echo $row['cost']?>" class="form-control" min='0'>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group m-b-15">
                                <label for="simpleinput">Precio</label>
                                <input type="number" name="price" step="any" required="" value="<?php echo $row['price']?>" class="form-control" min='0'>
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


<script>
document.getElementById('apply2').onchange = function() {
    var filename = this.value.replace(/C:\\fakepath\\/i, '')
    $("#fileResponse2").html('<b>Archivo seleccionado:</b> ' + filename);
};
</script>