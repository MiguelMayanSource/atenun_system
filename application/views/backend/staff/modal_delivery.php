<?php 

    $data_edit = $this->db->get_where('sample',array('sample_id'=>$param2))->result_array();
    foreach($data_edit as $row):
    $code = $row['code'];
?>
<form action="<?php echo base_url();?>staff/samples/delivery/<?php echo $code; ?>" method="post" enctype="multipart/form-data" id='formGroup'>
    <div class="modal-content animated fadeInDown">
        <div class="modal-header" style="background-color:#fff; box-shadow: 0 4px 2px -2px 000;">
            <h4 style="font-size:21px; color:#565b6b; font-family:'Poppins';"><span style="vertical-align:-3px"> <i class="batch-icon-heart-full"></i> Enviar resultados</span></h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            <div class="widget widget-activity-one">
                <div class="widget-content">
                    <div class="mt-container mx-auto ps ps--active-y">
                        <div class='container row'>
                            <div class='col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 '>
                                <div class="form-group">
                                    <label for="name">Fecha de Entrega</label>
                                    <input type="date" class="form-control" name='delivery_date' required value='<?php echo date('Y-m-d') ;?>'>
                                </div>
                            </div>
                            <div class='col-xl-12 col-lg-12 col-md-12 col-sm-6 col-6'>
                                <div class="form-group">
                                    <h4>Método de Entrega</h4>
                                    <div class="row">
                                        <div class="col-4">
                                            <label for="">Correo</label><br>
                                            <label class="switch s-icons s-outline s-outline-primary  mr-2">
                                                <input type="checkbox"  value='1' name='send_email'>
                                                <span class="slider round"></span>
                                            </label>
                                        </div>
                                        <div class="col-4">
                                            <label for="">WhatsApp</label><br>
                                            <label class="switch s-icons s-outline s-outline-success mr-2">
                                                <input type="checkbox"  value='1' name='send_whatsapp'>
                                                <span class="slider round"></span>
                                            </label>
                                        </div>
                                        <div class="col-4">
                                            <label for="">Fisico</label><br>
                                            <label class="switch s-icons s-outline s-outline-success mr-2">
                                                <input type="checkbox"  value='1' name='send_fisico'>
                                                <span class="slider round"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="button-confirm">Enviar</button>
        </div>
        <?php endforeach; ?>
    </div>
</form>
<script>
$("#formGroup").submit(function(e) {
    e.preventDefault();
    var form = $(this);
    var url = form.attr('action');
    $.ajax({
        type: "POST",
        url: url,
        data: new FormData(this),
        processData: false,
        contentType: false,
        beforeSend: function() {
          
        },
        success: function(response) {
            console.log('enviado');
            $('.close').click();

        },
        error: function() {
            console.log("error");
        }
    });
});
</script>