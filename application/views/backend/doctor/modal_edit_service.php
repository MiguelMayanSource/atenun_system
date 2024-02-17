<?php
    $this->db->where('product_id', $param2);
    $products = $this->db->get('product')->result_array();
    foreach($products as $row):
?>
<div class="modal-content animated fadeInDown">
    <div class="modal-header" style="background-color:#fff;">
        <h4 style="font-size:21px; color:#565b6b; font-family:'Poppins';">
            <span style="vertical-align:-3px">Agregar servicio</span>
        </h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
    </div>
    <form action="<?php echo base_url();?>doctor/inventory_products/update_service/<?php echo $row['product_id'];?>" method="POST" enctype="multipart/form-data">
        <div class="modal-body">
            <div class="form-group">
                <div class="container">
                    <div class="row">
                        <input type="hidden" name="inventory_id" value="<?php echo $row['inventory_id']; ?>">
                        <div class="col-sm-12 col-md-8 mb-3">
                            <label class="form-label" for="exampleFormControlSelect9">Catégoria:</label><span style="color:red">*</span>
                            <select class=" mb3 select2" required name="category_id">
                                <option value="">Seleccionar</option>
                                <?php  $cats = $this->db->get_where('category', array('status'=>1))->result_array();
                                        foreach ($cats as $cat): ?>
                                <option value="<?php echo $cat['id']; ?>" <?php echo $cat['id'] == $row['category_id']? 'selected':'';?>><?php echo $cat['name']?></option>
                                <?php endforeach;  ?>
                            </select>
                        </div>
                        <div class="col-sm-4">
                            <label class="form-label" for="exampleFormControlSelect9">Proveedor:</label><span style="color:red">*</span>
                            <select class="form-control mb3 select2 " name="provider_id">
                                <option value="">Seleccionar</option>
                                <?php 
                                    $provaider = $this->db->get_where('staff',array('status'=>1,'category'=>3))->result_array(); 
                                    foreach($provaider as $rowp):
                                ?>
                                <option value="<?php echo $rowp['staff_id'];?>" <?php echo $rowp['staff_id'] == $row['provider']? 'selected':'';?>><?php echo $rowp['first_name'];?></option>
                                <?php endforeach;?>
                            </select>
                        </div>
                        <div class="col-md-4 col-ms-12 mb-3">
                            <label for="codigoProducto" class="form-label">Código del servicio</label><span style="color:red">*</span>
                            <input type="text" class="form-control" name="code" required value="<?php echo $row['code'];?>">
                        </div>
                        <div class="col-md-5 col-ms-12 mb-3">
                            <label for="nombre" class="form-label">Nombre del servicio</label><span style="color:red">*</span>
                            <input type="text" class="form-control" name="name" required value="<?php echo $row['name'];?>">
                        </div>
                        <div class="col-md-3 col-ms-12 mb-3">
                            <label for="nombre" class="form-label">Puntos de descuento</label><span style="color:red">*</span>
                            <input type="text" class="form-control" name="points" required value="<?php echo $row['points'];?>">
                        </div>
                        <div class="col-md-4 col-ms-12 mb-3">
                            <label for="costo" class="form-label">Costo</label><span style="color:red">*</span>
                            <input type="number" step="any" class="form-control" name="cost" required value="<?php echo $row['cost'];?>">
                        </div>

                        <div class="col-md-4 col-ms-12 mb-3">
                            <label for="price_1" class="form-label">Precio 1(Atenun)</label><span style="color:red">*</span>
                            <input type="number" step="any" class="form-control" name="price_1" required value="<?php echo $row['price_1'];?>">
                        </div>
                        <div class="col-md-4 col-ms-12 mb-3">
                            <label for="price_2" class="form-label">Precio 2 (Empresas)</label>
                            <input type="number" step="any" class="form-control" name="price_2" value="<?php echo $row['price_2'];?>">
                        </div>
                        <div class="col-md-4 col-ms-12 mb-3">
                            <label for="price_3" class="form-label">Precio 3 (Seguro)</label>
                            <input type="number" step="any" class="form-control" name="price_3" value="<?php echo $row['price_3'];?>">
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group m-b-15">
                                <label for="simpleinput">Imagen</label>
                                <label class="labelx" for="apply"><input type="file" name="image" class="inputx" id="apply" accept="image/*">Seleccionar</label>
                                <small id="fileResponse"></small>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="button-confirm">Actualizar</button>
        </div>
</div>
<script>

document.getElementById('apply').onchange = function () {
   var filename = this.value.replace(/C:\\fakepath\\/i, '')
   $( "#fileResponse" ).html('<b>Archivo seleccionado:</b> '+filename);
};
$(function() {

    $(".select2").select2({
        width: '100%'
    });



});

function openSelect(table, value, field) {

    $('#loader_' + field).show();
    $.ajax({
        url: "<?php echo base_url().'doctor/openSelect/';?>",
        type: "POST",
        data: {
            table: table,
            field: field,
            name: value,
        },
        success: function(response) {

            $('#loader_' + field).hide();
            $('#' + field + '_name').html('');
            $('#' + field + '_search').html(response);
            $('#' + field + '_new').focus();
            //console.log(response);
        },
        error: function() {
            console.log("error");
        }
    });

}

function getValues(table, value, field) {

    $('#loader_' + field).show();
    $.ajax({
        url: "<?php echo base_url().'doctor/getValues/';?>",
        type: "POST",
        data: {
            table: table,
            field: field,
            name: value,
        },
        success: function(response) {

            $('#loader_' + field).hide();
            $('#' + field + '_options').html(response);
            //console.log(response);
        },
        error: function() {
            console.log("error");
        }
    });

}


function selectValue(table, id, name, field) {

    if (field != "") {
        $('#' + field + '_search').html('');
        $('#' + field + '_options').html('');
        $('#' + field + '_name').append(`<option value="${id}" selected>${name}</option>`);
    }
}

function addValue(table, field) {

    value = $('#' + field + '_new').val();
    if (value != "") {
        $('#loader_' + field).show();
        $.ajax({
            url: "<?php echo base_url().'doctor/addValue/';?>",
            type: "POST",
            data: {
                table: table,
                name: value,
            },
            success: function(response) {
                $('#loader_' + field).hide();
                $('#' + field + '_search').html('');
                $('#' + field + '_options').html('');
                $('#' + field + '_name').append(`<option value="${response}" selected>${value}</option>`);
                //console.log(response);
            },
            error: function() {
                console.log("error");
            }
        });
    }
}

function deleteValue(table, element) {

    Swal.fire({
        title: '¿Estás seguro?',
        text: "También se eliminará toda la información asociada.",
        type: 'info',
        showCancelButton: true,
        confirmButtonColor: '#9fd13b',
        cancelButtonColor: '#fd4f57',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.value) {

            console.log($(element).data('id'));
            if (table != "") {

                $.ajax({
                    url: "<?php echo base_url().'doctor/deleteValue/';?>",
                    type: "POST",
                    data: {
                        table: table,
                        id: $(element).data('id'),

                    },
                    success: function(response) {
                        element.parentElement.remove();
                        element.remove();

                        //console.log(response);
                    },
                    error: function() {
                        console.log("error");
                    }
                });
            }

        }
    })
}
</script>
<?php endforeach;?>