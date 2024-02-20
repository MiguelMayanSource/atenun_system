<div class="modal-content animated fadeInDown">
    <div class="modal-header" style="background-color:#fff;">
        <h4 style="font-size:21px; color:#565b6b; font-family:'Poppins';">
            <span style="vertical-align:-3px">Agregar producto</span>
        </h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
    </div>
    <form action="<?php echo base_url();?>doctor/inventory_products/create_product/" method="POST" enctype="multipart/form-data">
        <div class="modal-body">
            <div class="form-group">
                <div class="container">
                    <div class="row">
                        <input type="hidden" name="inventory_id" value="<?php echo $param2;?>">
                        <div class="col-sm-12">
                            <hr>
                            <div class="middles">
                                <label>
                                    <input type="radio" id="exist" value="0" onclick="validate(0)" name="product_type" checked required />
                                    <div class="front-end box">
                                        <span>Existente</span>
                                    </div>
                                </label>
                                <label>
                                    <input type="radio" id="new" value="1" onclick="validate(1)" name="product_type" />
                                    <div class="back-end box">
                                        <span>Nuevo</span>
                                    </div>
                                </label>
                            </div>
                            <hr>
                        </div>
                        <div class="col-md-12 row" id="is_exist">
                            <div class="col-sm-12 col-md-12 mb-3">
                                <label class="form-label" for="exampleFormControlSelect9"><b>Producto:</b></label><span style="color:red">*</span>
                                <select class="form-control mb3 select2"  name="product_id" onchange="getPres(this.value,'<?php $_id = uniqid(); echo $_id;?>')" ;>
                                    <option value="">Seleccionar</option>
                                    <?php  $products = $this->db->get_where('product', array('type'=>1,'status'=>1))->result_array();
                                            foreach ($products as $product): ?>
                                    <option value="<?php echo $product['product_id']; ?>"><?php echo $product['code'].' - '.$product['name']?></option>
                                    <?php endforeach;  ?>
                                </select>
                            </div>
                            <div class="col-sm-12 col-md-6 mb-3">
                                <div class="form-group">
                                    <label> <b>Unidades</b> </label><span class="text-danger">*</span>
                                    <div class="input-group">
                                        <input type="number" step="any" class="form-control" name="amount1"  >
                                        <div class="input-group-append">
                                            <select name="unity1" class="form-control"  required>

                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-ms-12 mb-3">
                                <label for="costo" class="form-label">Costo</label><span style="color:red">*</span>
                                <input type="number" step="any" class="form-control" name="cost1">
                            </div>
                        </div>
                        <div class="col-md-12 row" id="is_new" style="display:none">
                            <div class="col-sm-12 col-md-12 mb-3">
                                <label class="form-label" for="exampleFormControlSelect9">Catégoria:</label><span style="color:red">*</span>
                                <select class=" mb3 select2"  name="category_id">
                                    <option value="">Seleccionar</option>
                                    <?php  $cats = $this->db->get_where('category', array('status'=>1))->result_array();
                                            foreach ($cats as $cat): ?>
                                    <option value="<?php echo $cat['id']; ?>"><?php echo $cat['name']?></option>
                                    <?php endforeach;  ?>
                                </select>
                            </div>
                            <div class="col-md-8 col-ms-12 mb-3">
                                <label for="nombre" class="form-label">Nombre del producto</label><span style="color:red">*</span>
                                <input type="text" class="form-control" name="name" value="<?php echo $row['name'];?>">
                            </div>
                            <div class="col-md-4 col-ms-12 mb-3">
                                <label for="codigoProducto" class="form-label">Código de producto</label><span style="color:red">*</span>
                                <input type="text" class="form-control" name="code" value="<?php echo $row['code'];?>">
                            </div>
                            <div class="col-sm-4">
                                <label class="form-label" for="exampleFormControlSelect9">Proveedor:</label><span style="color:red">*</span>
                                <select class="form-control mb3 select2" name="provider_id">
                                    <option value="">Seleccionar</option>
                                    <?php 
                                        $provaider = $this->db->get_where('staff',array('status'=>1,'category'=>3))->result_array(); 
                                        foreach($provaider as $row):
                                    ?>
                                    <option value="<?php echo $row['staff_id'];?>"><?php echo $row['first_name'];?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                            <div class="col-md-4 col-ms-12 mb-3">
                                <label for="expiration" class="form-label">Fecha de expiración</label>
                                <input type="date" class="form-control" name="expiration">
                            </div>
                            <div class="col-sm-12 col-md-4 mb-3">
                                <div class="form-group">
                                    <label> <b>Cantidad y unidad principal</b> </label><span class="text-danger">*</span>
                                    <div class="input-group">
                                        <input type="number" step="any" class="form-control" name="amount2" >
                                        <div class="input-group-append">
                                            <select name="unity2" class="form-control">
                                                <optgroup label="Otras">
                                                    <option value="gt">Goteros</option>
                                                    <option value="am">Ampollas</option>
                                                    <option value="pil">Pildoras</option>
                                                    <option value="pas">Pastillas</option>
                                                    <option value="un">Frascos</option>
                                                    <option value="un">Unidades</option>
                                                    <option value="un">Cajas</option>
                                                </optgroup>
                                                <optgroup label="Unidades de Peso">
                                                    <option value="lb">Libras</option>
                                                    <option value="oz">Onzas</option>
                                                </optgroup>
                                                <optgroup label="Unidades de Liquidos">
                                                    <option value="ml">Mililitros</option>
                                                    <option value="lt">Litros</option>
                                                    <option value="gl">Galones</option>
                                                </optgroup>
                                                <optgroup label="Unidades de longitud">
                                                    <option value="pl">pulgadas</option>
                                                    <option value="pie">pie</option>
                                                    <option value="yd">Yarda</option>
                                                </optgroup>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-ms-12 mb-3">
                                <label for="alert" class="form-label">Cantidad para alertar</label><span style="color:red">*</span>
                                <input type="number" class="form-control" name="alert">
                            </div>
                            <div class="col-md-3 col-ms-12 mb-3">
                                <label for="alert" class="form-label">Puntos de descuento</label><span style="color:red">*</span>
                                <input type="number" class="form-control" name="points">
                            </div>
                            <div class="col-md-6 col-ms-12 mb-3">
                                <label for="costo" class="form-label">Costo</label><span style="color:red">*</span>
                                <input type="number" step="any" class="form-control" name="cost">
                            </div>

                            <div class="col-md-4 col-ms-12 mb-3">
                                <label for="price_1" class="form-label">Precio 1(Atenun)</label><span style="color:red">*</span>
                                <input type="number" step="any" class="form-control" name="price_1">
                            </div>
                            <div class="col-md-4 col-ms-12 mb-3">
                                <label for="price_2" class="form-label">Precio 2 (Empresas)</label>
                                <input type="number" step="any" class="form-control" name="price_2">
                            </div>
                            <div class="col-md-4 col-ms-12 mb-3">
                                <label for="price_3" class="form-label">Precio 3 (Seguro)</label>
                                <input type="number" step="any" class="form-control" name="price_3">
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label> Kit </label>
                                    <div class="input-group">
                                        <input type="number" step="any" class="form-control" name="pa_amount" aria-label="Text input with dropdown button">
                                        <div class="input-group-append">
                                            <select name="packaging" class="form-control">
                                                <option value="">Seleccionar</option>
                                                <option value="cj">Caja</option>
                                                <option value="fr">Frasco</option>
                                                <option value="gl">Galón</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label> Presentación </label>
                                    <div class="input-group">
                                        <input type="number" step="any" class="form-control" name="p_amount" aria-label="Text input with dropdown button">
                                        <div class="input-group-append">
                                            <select name="presentation" class="form-control">
                                                <option value="">Seleccionar</option>
                                                <option value="cj">Caja</option>
                                                <option value="bl">Blisters</option>
                                                <option value="fr">Frascos</option>
                                                <option value="rl">Rollos</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label> Unidades </label><span class="text-danger">*</span>
                                    <div class="input-group">
                                        <input type="number" step="any" class="form-control" name="u_amount" aria-label="Text input with dropdown button">
                                        <div class="input-group-append">
                                            <select name="unity" class="form-control" required>
                                                <optgroup label="Otras">
                                                    <option value="gt">Goteros</option>
                                                    <option value="am">Ampollas</option>
                                                    <option value="pil">Pildoras</option>
                                                    <option value="pas">Pastillas</option>
                                                    <option value="un">Frascos</option>
                                                    <option value="un">Unidades</option>
                                                    <option value="un">Cajas</option>
                                                </optgroup>
                                                <optgroup label="Unidades de Peso">
                                                    <option value="lb">Libras</option>
                                                    <option value="oz">Onzas</option>
                                                </optgroup>
                                                <optgroup label="Unidades de Liquidos">
                                                    <option value="ml">Mililitros</option>
                                                    <option value="lt">Litros</option>
                                                    <option value="gl">Galones</option>
                                                </optgroup>
                                                <optgroup label="Unidades de longitud">
                                                    <option value="pl">pulgadas</option>
                                                    <option value="pie">pie</option>
                                                    <option value="yd">Yarda</option>
                                                </optgroup>
                                            </select>
                                        </div>
                                    </div>
                                </div>
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
        </div>
        <div class="modal-footer">
            <button type="submit" class="button-confirm">Agregar</button>
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

function getPres(product_id, variant_id) {
    $.ajax({
        url: '<?php echo base_url();?>doctor/get_product_pres/' + product_id,
        success: function(response) {
            jQuery('select[name="unity1"]').html(response);
        }
    });
}


function validate($type) {
    if ($type == 0) {
        $('#is_exist').show(300);
        $('#is_new').hide(300);

        $('input[name="cost1"]').attr('required', true);
        $('select[name="unity1"]').attr('required', true);
        $('select[name="product_id"]').attr('required', true);


        $('select[name="category_id"]').attr('required', false);
        $('input[name="name"]').attr('required', false);
        $('input[name="code"]').attr('required', false);
        $('select[name="provider_id"]').attr('required', false);
        $('input[name="cost"]').attr('required', false);
        $('input[name="price_1"]').attr('required', false);
        $('input[name="u_amount"]').attr('required', false);
        $('input[name="unity"]').attr('required', false);
        $('input[name="alert"]').attr('required', false);

    }
    if ($type == 1) {
        $('#is_exist').hide(300);
        $('#is_new').show(300);

        $('input[name="cost1"]').attr('required', false);
        $('select[name="unity1"]').attr('required', false);
        $('select[name="product_id"]').attr('required', false);

        $('select[name="category_id"]').attr('required', true);
        $('input[name="name"]').attr('required', true);
        $('input[name="code"]').attr('required', true);
        $('select[name="provider_id"]').attr('required', true);
        $('input[name="cost"]').attr('required', true);
        $('input[name="price_1"]').attr('required', true);
        $('input[name="u_amount"]').attr('required', true);
        $('input[name="unity"]').attr('required', true);
        $('input[name="alert"]').attr('required', true);
    }
}

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