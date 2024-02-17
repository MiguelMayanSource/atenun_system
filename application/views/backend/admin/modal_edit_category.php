<div class="modal-content animated fadeInDown">
    <div class="modal-header" style="background-color:#fff;box-shadow: 0 4px 2px -2px 000;">
        <h4 style="font-size:21px; color:#565b6b; font-family:'Poppins';">
            <span style="vertical-align:-3px"> Editar información del laboratorio<</span>
        </h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
    </div>
    <div class="modal-body" style="background-color:#fff;">
        <form action="<?php echo base_url();?>admin/laboratory/create/" method="post" enctype="multipart/form-data" id='formAdd'>
            <div class="widget widget-activity-one">
                <div class="widget-content">

                    <?php 

                    $data_edit = $this->db->get_where('laboratory',array('laboratory_id'=>base64_decode($param2)))->result_array();
                    foreach($data_edit as $row):
                    ?>

                    <form action="<?php echo base_url();?>admin/laboratory/update/<?php echo base64_decode($param2); ?>" method="post" enctype="multipart/form-data" id='form'>
                        <div class="widget widget-activity-one">
                            <div class="widget-content">
                                <div class="mt-container mx-auto ps ps--active-y">
                                    <div class='container row'>
                                        <div class='col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 '>
                                            <div class="form-group">
                                                <label for="name">Nombre</label>
                                                <input type="text" class="form-control" name='name' required value='<?php echo $row['name'] ;?>'>
                                            </div>
                                        </div>

                                        <div class='col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12'>
                                            <div class="form-group">
                                                <label>Descripción</label>
                                                <textarea class="form-control" rows="3" name="description"><?php echo $row['description'];?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i>Cerrar</button>
                                <button type="submit" class="btn btn-primary">Guardar</button>
                            </div>
                        </div>
                </div>
            </div>
        </form>
    </div>
</div>

< <script>
    $("#formAdd").bind("submit", function() {
    $(this).find(':button[type=submit]').prop('disabled', true);
    });
    </script>



    <script>
    $("#form").bind("submit", function() {
        $(this).find(':button[type=submit]').prop('disabled', true);
    });
    </script>
    <?php endforeach; ?>