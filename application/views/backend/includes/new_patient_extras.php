<h5 class="panel-content-title">Agregar servicio o producto extra</h5>
<span class="app-divider2"></span>
<div class="row">
    <div class="col-md-12"> 
        <form action="<?php echo base_url().'/'.$this->session->userdata('login_type').'/product_extra/add_product_extra';?>" method="post" enctype="multipart/form-data" id='formSample'>
            <div class='row'>
                <input type="hidden" class="form-control" name='patient_id' id='patient_id' value='<?php echo $patient_id;?>'>
                <input type='hidden' name="total" value="0" id="total" />
                <input type='hidden' name="origin_id" value="<?php echo $origin_id;?>" />
                <input type='hidden' name="origin_type" value="<?php echo $origin_type;?>" />
                <input type='hidden' name="doctor_id" value="<?php echo $this->session->userdata('login_user_id');?>" />
                <div class='col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 row'>
                    <div class=" col-12 row">
                        <table class="table " id="products">
                            <tr>
                                <th>
                                     Categoría<span class="text-danger">*</span>
                                </th>
                                <th>
                                    Producto<span class="text-danger">*</span>
                                </th>
                                <th>
                                    Cantidad<span class="text-danger">*</span>
                                </th>
                                <th class="col-sm-1">

                                </th>
                            </tr>
                            <tr>
                                <td>
                                    <select class="form-control mb3 select2"  name="cat_id[]" onchange="getProducts(this.value,'<?php $_id = uniqid(); echo $_id;?>')" ;>
                                        <option value="">Seleccionar</option>
                                        <option value="0">Todos</option>
                                        <?php  $products = $this->db->get_where('category', array('status'=>1))->result_array();
                                            foreach ($products as $product): ?>
                                        <option value="<?php echo $product['id']; ?>"><?php echo $product['name']?></option>
                                        <?php endforeach;  ?>
                                    </select>
                                </td>
                                <td style="width: 200px">
                                    <select class="form-control mb3 select2"  name="product_id[]" id="prod_<?php echo $_id; ?>" onchange="getPres(this.value,'<?php echo $_id;?>')" ;>
                                        <option value="">Seleccionar</option>
                                    </select>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <input type="number" step="any" class="form-control" name="amount[]" required=""  id="amount_<?php echo $_id; ?>">
                                            <div class="input-group-append" id="unity_<?php echo $_id; ?>">

                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="col-sm-1">

                                </td>
                            </tr>
                        </table>
                        <div class="col-sm-12" style="float:'right';margin-top: 15px;margin-bottom: 15px;">
                            <button type="button" class="btn btn-info btn-sm" onclick="addProduct()">Agregar</button>
                        </div>
                       
                    </div>
                </div>
                <div class='col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 '>
                    <div class="form-group">
                        <a class="btn btn-danger" style="margin-left:10px;" href="javascript:void(0)" onclick="load_view('patient_extras','extras',{'patient_id':<?php echo $patient_id;?>,'origin_type':'<?php echo $origin_type;?>','origin_id':<?php echo $origin_id;?>})">Terminar</a>
                        <button style='Float:right;' type="submit" class="btn btn-primary submit">Guardar</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<script>




function generateUniqueId() {
    var timestamp = new Date().valueOf(); // Get the current timestamp as a starting point
    var randomId = Math.random().toString(36).substring(2); // Generate a random string
    var uniqueId = timestamp + "-" + randomId; // Combine the timestamp and random string to create the unique ID
    return uniqueId;
}


function addProduct() {
    $id = generateUniqueId();
    $('#products').append(`
    <tr>
        <td>
            <select class="form-control mb3 select2"  name="cat_id[]" onchange="getProducts(this.value,'${$id}')" ;>
                <option value="">Seleccionar</option>
                <option value="0">Todos</option>
                <?php  $products = $this->db->get_where('category', array('status'=>1))->result_array();
                    foreach ($products as $product): ?>
                <option value="<?php echo $product['id']; ?>"><?php echo $product['name']?></option>
                <?php endforeach;  ?>
            </select>
        </td>
        <td >
            <select class="form-control mb3 select2" id="prod_${$id}"  name="product_id[]" onchange="getPres(this.value,'${$id}')" ;>
                <option value="">Seleccionar</option>
            </select>
        </td>
        <td >
            <div class="form-group">
                <div class="input-group">
                    <input type="number" step="any" class="form-control" name="amount[]" required="" onchange="getSbtotal('${$id}')" onKeyUp="getSbtotal('${$id}')" id="amount_${$id}">
                    <div class="input-group-append">
                        <select name="unity[]" class="form-control" id="unity_${$id}" required>
                        </select>
                    </div>
                </div>
            </div>
        </td>
        <td class="col-sm-1">
            <i onclick="delete_element(this)" class="picons-thin-icon-thin-0056_bin_trash_recycle_delete_garbage_empty" style="color:#fd4f57;cursor:pointer;" data-toggle="tooltip" data-placement="top" title="" data-original-title="Eliminar"></i>
        </td>
    </tr>
    `);
    getProducts(0, $id)
    $('.select2').select2();
}

function getProducts(product_id, variant_id) {
    $.ajax({
        url: '<?php echo base_url();?>admin/get_products/' + product_id,
        success: function(response) {
           
            if (response != "")
                jQuery('#prod_' + variant_id).html(response);
            else
                jQuery('#prod_' + variant_id).html('');
        }
    });
}

function getPres(product_id, variant_id) {
    $.ajax({
        url: '<?php echo base_url();?>admin/get_product_pres/' + product_id,
        success: function(response) {
            if (response != "")
                jQuery('#unity_' + variant_id).html(` <select name = "unity[]" class = "form-control" required = "" >${response} < /select>`);
            else
                jQuery('#unity_' + variant_id).html('');
           

        }
    });
}

function delete_element(obj) {
    $(obj).parent().parent().remove();
}


$("#formSample").submit(function(e) {
    e.preventDefault();



    $('.submit').attr('disabled', 'disabled');
    $('.submit').html('Guardando....');
    var form = $(this);
    var url = form.attr('action');
    $.ajax({
        type: "POST",
        url: url,
        data: new FormData(this),
        processData: false,
        contentType: false,
        beforeSend: function() {
            $("#addSample").attr('disabled', true);
        },
        success: function(response) {

            Swal.fire({
                toast: true,
                position: 'top-end',
                type: 'success',
                title: 'Agregado correctamente',
                showConfirmButton: false,
                timer: 1500
            });

            load_view('patient_extras', 'extras', {
                'patient_id': patient_id,
                'origin_id':'<?php echo $origin_id;?>',
                'origin_type':'<?php echo $origin_type; ?>',
            })


        },
        complete: function() {
            $("#addSample").removeAttr('disabled');
        },
        error: function() {
            console.log("error");
        }
    });



});
</script>