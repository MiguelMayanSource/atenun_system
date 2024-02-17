<style>
span.error {
    font-size: 12px;
    position: absolute;
    -webkit-border-radius: 3px;
    -moz-border-radius: 3px;
    border-radius: 3px;
    top: -20px;
    right: -15px;
    z-index: 2;
    height: 25px;
    line-height: 1;
    background-color: #e34f4f;
    color: #fff;
    font-weight: normal;
    display: inline-block;
    padding: 6px 8px;
}

span.error:after {
    content: '';
    position: absolute;
    border-style: solid;
    border-width: 0 6px 6px 0;
    border-color: transparent #e34f4f;
    display: block;
    width: 0;
    z-index: 1;
    bottom: -6px;
    left: 20%;
}

#formValidate .wizard>.content {
    min-height: 25em;
}

#example-vertical.wizard>.content {
    min-height: 24.5em;
}

.image_galery {
    position: relative;
    box-sizing: border-box;
    transition: all 0.2s ease;
    border-radius: 6px;
    background-size: cover;
    background-position: center center;
    background-repeat: no-repeat;
    float: left;
    margin: 1.858736%;
    width: 29.615861214%;
    height: 150px;
    box-shadow: 0 4px 10px 0 rgb(51 51 51 / 25%);
}


.file_control_custom {
    box-sizing: border-box;
    position: absolute;
    top: 0;
    right: 0;
    left: 0;
    z-index: 5;
    height: auto;
    overflow: hidden;
    line-height: 1.5;
    user-select: none;
    background-clip: padding-box;
    border-radius: 0.25rem;
    height: auto;
    border: 1px solid #f1f2f3;
    color: #3b3f5c;
    font-size: 15px;
    padding: 8px 10px;
    letter-spacing: 1px;
    background-color: #f1f2f3;
    cursor: pointer;
    margin: 30px;
}


.custom-file-container input[type=file] {
    position: absolute;
    top: 0;
    min-width: 100%;
    min-height: auto;
    filter: alpha(opacity=0);
    opacity: 0;
    outline: none;
    background: white;
    cursor: inherit;
    display: block;
    z-index: 1000;
    cursor: pointer;
}

.circle.wizard>.steps .current:not(.done) a .number,
.circle.wizard>.steps .current:not(.done) a:hover .number,
.circle.wizard>.steps .current:not(.done) a:active .number {
    border-color: #0e1726;
    background-color: #0e1726;
    color: #fff;
}

.circle.wizard>.steps .done a .number {
    border-color: #0e1726;
}

.circle.wizard>.steps ul li.done::after,
.circle.wizard>.steps ul li.done::before {
    background-color: #0e1726;
}

.wizard>.actions a {
    background-color: #0e1726;

}

.input[type="radio"] {
    display: none !important;
}

.custom-file-container__custom-file__custom-file-control {
    background: #fff !important;
}

.close1:before {
    content: '✕';
    top: 0px;
    position: absolute;
    right: 3px;
    font-weight: bold;
    color: white;
}

.close1 {
    position: absolute;
    top: -10px;
    right: -10px;
    background: red;
    padding: 10px;
    box-sizing: border-box;
    border-radius: 50%;
    width: 10px;
    height: 10px;
    cursor: pointer;
}

label {
    color: black !important;
}

.back12 {
    background: #f1f2f3;
    margin-top: 27px;
    width: auto;
    -webkit-border-radius: 5px;
    -moz-border-radius: 5px;
    border-radius: 5px;
    padding: 20px 20px 0px 20px
}
</style>

<link href="<?php echo base_url();?>public/super/plugins/file-upload/file-upload-with-preview.min.css" rel="stylesheet" type="text/css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<div id="main-content">
    <div class="col-xl-12  col-lg-12 col-sm-12  layout-spacing">
        <div class="card-widget br-6">
            <div class="widget-heading">
                <h4> <a href="#" onclick="history.back()">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left-circle" data-darkreader-inline-stroke="" style="--darkreader-inline-stroke:currentColor;">
                            <circle cx="12" cy="12" r="10"></circle>
                            <polyline points="12 8 8 12 12 16"></polyline>
                            <line x1="16" y1="12" x2="8" y2="12"></line>
                        </svg>
                    </a>Laboratorios</h4>
            </div>
            <div class="back12" style="   ">
                <div class="widget-heading">
                    <h4>Agregar examen</h4>
                </div>
                <?php 
                $lab_type = 1;
                if($lab_type == 2):
            ?>
                <div class="row ">
                    <div class="col-sm-12 col-md-4">
                        <div class="form-group m-b-15">
                            <select class="form-control basic" name="laboratory_fields_id" id="laboratory_fields_id">
                                <?php 
                              $fields = $this->db->get_where('laboratory_fields', array('status'=>1))->result_array();
                              foreach ($fields as $filed) {
                                  echo '<option value="'.$filed['laboratory_fields_id'].'">'.$filed['name'].'</option>';
                              }
                            
                            ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-12 ">
                        <div class="form-group m-b-15" style="float: right;">
                            <button class="btn btn-info" class=" form-control" onclick="addField()">Agregar</button>
                        </div>
                    </div>
                </div>
                <?php endif;
               if($lab_type == 1):
            ?>
                <div class="row newField">
                    <div class="col-sm-12 col-md-4">
                        <div class="form-group m-b-15">
                            <label for="simpleinput">Nombre<span style="color:red">*</span></label>
                            <input type="text" class=" form-control" name="name" id="name">
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-2">
                        <div class="form-group m-b-15">
                            <label for="simpleinput">Unidad</label>
                            <input type="text" class=" form-control" id="unity">
                            <small></small>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-2">
                        <div class="form-group m-b-15">
                            <label for="simpleinput">Referencia</label>
                            <input type="text" class=" form-control" id="reference">
                            <small></small>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-12 ">
                        <div class="form-group m-b-15" style="float: right;padding: 0px 10px;">
                            <button class="btn btn-info" class=" form-control" onclick="addNewField()">Agregar</button>
                        </div>
                    </div>
                </div>
                <?php endif;?>


            </div>
            <div class="back12">
                <h3><?php echo $this->db->get_where('product',array('product_id'=>$laboratory_id))->row()->name;?></h3>

                <input type="hidden" class=" form-control" name="laboratory_id" id="laboratory_id" value="<?php echo $laboratory_id?>">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>-</th>
                            <th>Unidad</th>
                            <th style="width:500px;">Referencia</th>
                            <th>Acciones</th>
                        </tr>
                        <tbody class="row_position">

                            <?php 
                                $fields = $this->db->query("SELECT * FROM `laboratory_template` WHERE laboratory_id = ".$laboratory_id." AND status = 1")->result_array();
                                $cont = 1;
                                $cont2 = 1;
                                foreach($fields as $row):
                                $field = $this->db->get_where('laboratory_fields',array('laboratory_fields_id'=>$row['laboratory_fields_id']))->row_array();
                            ?>
                            <tr class="rows" id="<?php echo $field['laboratory_fields_id']?>">
                                <td class="indice" style="white-space:nowrap;width:50px"><?php echo $cont++?></td>
                                <td style="width:250px"><?php echo $field['name']; ?></td>
                                <td style="white-space:nowrap;width:100px"><input type="text" class="form-control" autocomplete="off" name="'.$field['name'].'" readonly></td>
                                <td style="white-space:nowrap;width:200px"><?php echo $field['unity']?></td>
                                <td style=" "><?php echo $field['reference']?></td>
                                <td>

                                    <?php    if($lab_type == 1): ?>
                                    <a href="javascript:void(0)" onclick="editField(<?php echo $field['laboratory_fields_id']; ?>)" class="bs-tooltip" title="Editar">
                                        <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                        </svg>
                                    </a>
                                    <a href="javascript:void(0)" onclick="deleteField('<?php echo $field['laboratory_fields_id'];?>')" class="bs-tooltip" title="Eliminar">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-circle table-cancel">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <line x1="15" y1="9" x2="9" y2="15"></line>
                                            <line x1="9" y1="9" x2="15" y2="15"></line>
                                        </svg>
                                    </a>
                                    <?php endif;?>
                                    <?php    if($lab_type == 2): ?>
                                    <a href="javascript:void(0)" onclick="deleteFieldTemplate('<?php echo $row['laboratory_template_id'];?>')" class="bs-tooltip" title="Eliminar">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-circle table-cancel">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <line x1="15" y1="9" x2="9" y2="15"></line>
                                            <line x1="9" y1="9" x2="15" y2="15"></line>
                                        </svg>
                                    </a>
                                    <?php endif;?>
                                </td>
                            </tr>
                            <tr id="edit_<?php echo $field['laboratory_fields_id']?>" style="display:none;">
                                <td class="indice" style="white-space:nowrap;width:50px"><?php echo $cont2++?></td>
                                <td style="white-space:nowrap;width:250px"><input type="text" class=" form-control" id="name_<?php echo $field['laboratory_fields_id']?>" value="<?php echo $field['name']?>"></td>
                                <td style="white-space:nowrap;width:100px"><input type="text" class="form-control" autocomplete="off" readonly></td>
                                <td style="white-space:nowrap;width:200px"><input type="text" class=" form-control" id="unity_<?php echo $field['laboratory_fields_id']?>" value="<?php echo $field['unity']?>"></td>
                                <td style="white-space:nowrap;width:200px"><input type="text" class=" form-control" id="reference_<?php echo $field['laboratory_fields_id']?>" value="<?php echo $field['reference']?>"></td>
                                <td>
                                    <a href="javascript:void(0)" onclick="saveField('<?php echo $field['laboratory_fields_id']?>')">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-circle">
                                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                            <polyline points="22 4 12 14.01 9 11.01"></polyline>
                                        </svg>
                                    </a>
                                    <a href="javascript:void(0)" onclick="editField('<?php echo $field['laboratory_fields_id']?>')" class="bs-tooltip" title="Cancelar">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-circle table-cancel">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <line x1="15" y1="9" x2="9" y2="15"></line>
                                            <line x1="9" y1="9" x2="15" y2="15"></line>
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach;?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
function editField(field) {
    $('#' + field).toggle();
    $('#edit_' + field).toggle();
}

/* $( ".row_position" ).sortable({  
        delay: 150,  
        stop: function() {  
            var selectedData = new Array();  
            $('.rows').each(function() {  
                selectedData.push($(this).attr("id"));  
            });  
           // updateOrder(selectedData);  
           console.log(selectedData)
        }  
    });  
  */

function showNew() {
    $('.newField').toggle(500);
}


function updateOrder(data) {
    $.ajax({
        url: "ajaxPro.php",
        type: 'post',
        data: {
            position: data
        },
        success: function() {
            alert('your change successfully saved');
        }
    })
}

function addField() {


    var indice = $('.indice').length + 1;
    var laboratory_id = $('#laboratory_id').val();
    var laboratory_fields_id = $('#laboratory_fields_id').val();

    if (laboratory_fields_id != "") {

        $.ajax({
            url: "<?php echo base_url();?>admin/laboratory_fields/add",
            type: 'post',
            data: {
                laboratory_id: laboratory_id,
                laboratory_fields_id: laboratory_fields_id,
            },

            success: function() {

                Toast = Swal.mixin({
                    toast: true,
                    position: 'top-right',
                    showConfirmButton: false,
                    timer: 5000
                });

                Toast.fire({
                    icon: 'success',
                    title: 'Agregado...'
                })
                $(".table").load(window.location.href + " .table");

            }
        })

    } else {

        Toast.fire({
            type: 'error',
            title: 'Name is required...'
        })
    }


}

function addNewField() {


    var indice = $('.indice').length + 1;
    var laboratory_id = $('#laboratory_id').val();
    var name = $('#name').val();
    var unity = $('#unity').val();
    var reference = $('#reference').val();
    var price = $('#price').val();
    var price_esp = $('#price_esp').val();

    if (name != "") {

        $.ajax({
            url: "<?php echo base_url();?>admin/laboratory_fields/new_field",
            type: 'post',
            data: {
                laboratory_id: laboratory_id,
                name: name,
                unity: unity,
                reference: reference,
                price: price,
                price_esp: price_esp
            },

            success: function() {

                Toast = Swal.mixin({
                    toast: true,
                    position: 'top-right',
                    showConfirmButton: false,
                    timer: 5000
                });

                Toast.fire({
                    icon: 'success',
                    title: 'Agregado...'
                })
                $(".table").load(window.location.href + " .table");

            }
        })

    } else {

        Toast.fire({
            type: 'error',
            title: 'Name is required...'
        })
    }


}

function saveField(field_id) {

    var name = $('#name_' + field_id).val();
    var unity = $('#unity_' + field_id).val();
    var reference = $('#reference_' + field_id).val();
    var price = $('#price_' + field_id).val();
    var price_esp = $('#price_esp_' + field_id).val();
    if (name != "") {

        $.ajax({
            url: "<?php echo base_url();?>admin/laboratory_fields/edit",
            type: 'post',
            data: {
                field_id: field_id,
                name: name,
                unity: unity,
                reference: reference,
                price: price,
                price_esp: price_esp
            },

            complete: function() {

                Toast = Swal.mixin({
                    toast: true,
                    position: 'top-right',
                    showConfirmButton: false,
                    timer: 5000
                });

                Toast.fire({
                    icon: 'success',
                    title: 'Actualizado...'
                })
                $(".table").load(window.location.href + " .table");

            }
        })

    } else {

        Toast.fire({
            icon: 'error',
            title: 'Name is required...'
        })
    }


}




function deleteField(field_id) {
    console.log('eliminado');
    $.ajax({
        url: "<?php echo base_url();?>admin/laboratory_fields/delete/" + field_id,
        type: 'post',
        data: {
            field_id: field_id,
        },

        complete: function() {

            Toast = Swal.mixin({
                toast: true,
                position: 'top-right',
                showConfirmButton: false,
                timer: 5000
            });

            Toast.fire({
                icon: 'success',
                title: 'Eliminado...'
            })
            $(".table").load(window.location.href + " .table");

        }
    })

}


function deleteFieldTemplate(laboratory_template_id) {
    console.log('eliminado');
    $.ajax({
        url: "<?php echo base_url();?>admin/laboratory_fields/delete_field/" + laboratory_template_id,
        type: 'post',
        data: {
            laboratory_template_id: laboratory_template_id,
        },

        complete: function() {

            Toast = Swal.mixin({
                toast: true,
                position: 'top-right',
                showConfirmButton: false,
                timer: 5000
            });

            Toast.fire({
                icon: 'success',
                title: 'Eliminado...'
            })
            $(".table").load(window.location.href + " .table");

        }
    })

}
</script>