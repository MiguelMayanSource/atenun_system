<h5 class="panel-content-title">Nueva orden de laboratorio</h5>
<span class="app-divider2"></span>
<div class="row">
    <div class="col-md-12">
        <form action="<?php echo base_url().'/'.$this->session->userdata('login_type').'/samples/create/'.$param2;?>" method="post" enctype="multipart/form-data" id='formSample'>
            <div class='row'>
                <input type="hidden" class="form-control" name='patient_id' id='patient_id' value='<?php echo $patient_id;?>'>
                <input type='hidden' name="total" value="0" id="total" />
                <input type='hidden' name="origin_id" value="<?php echo $origin_id;?>" />
                <input type='hidden' name="origin" value="<?php echo $origin_type; ?>" />
                <input type='hidden' name="doctors_id" value="<?php echo $this->session->userdata('login_user_id');?>" />
                <div class='col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 '>
                    <div class="form-group">
                        <label>Fecha de procedimiento </label>
                        <input type="date" class="form-control" name='fecha_recibido'>
                    </div>
                </div>
                <div class='col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 '>
                    <div class="form-group">
                        <label>Comentarios</label>
                        <textarea class='form-control' name="several_doctors" cols="30" rows="3" placeholder='Comentarios'></textarea>
                    </div>
                </div>
                <div class='col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 row'>
                    <div class="table-responsive col-12 row">
                        <table class="table" style="margin: 20px;">
                            <tbody id="piezas">
                                <tr>
                                    <td>
                                        <div class="" style="width:230px;">
                                            <label for="simpleinput">Categorias:</label>
                                            <input type="hidden" name="cat[]" value="0" />
                                            <select onchange="laboratoriesExamns(this.value,0)" class="form-control basic labs" name="laboratories[]" id="laboratories_0">
                                                <option value="">Seleccionar</option>
                                                <?php
                                                             
                                                    $db = $this->db->query('SELECT * FROM `subcategory` where category_id = 15')->result_array();
                                                    foreach ($db as $info):
                                                ?>
                                                <option value="<?php echo $info['id']; ?>"><?php echo $info['name'] ?></option>
                                                <?php endforeach;?>
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="" style="width:230px;">
                                            <label for="simpleinput">Examenes:</label>
                                            <select class="form-control basic labs" name="exmans[]" id="examns_0">
                                                <option value="">Seleccionar</option>
                                            </select>
                                        </div>
                                        <input class='form-control total' type="hidden" min='0' onchange="sum_total()" onkeyup="sum_total()" name='price[]' id='ttl-0' readonly="true">
                                    </td>
                                    <td style="white-space: nowrap">
                                        <div class="" style="width:200px;">
                                            <label> Tipo de espécimen: <span style="color:red;">*</span></label>
                                            <select name="estudio[]" class="form-control">
                                                <option value="SANGRE COMPLETA">SANGRE COMPLETA</option>
                                                <option value="SUERO">SUERO</option>
                                                <option value="PLASMA">PLASMA</option>
                                                <option value="HECES">HECES</option>
                                                <option value="ORINA">ORINA</option>
                                                <option value="OTRO">OTRO</option>
                                            </select>
                                        </div>
                                    </td>
                                   
                                    <td>
                                        <div class="" style="width:200px;">
                                            <label>Observación</label>
                                            <input class='form-control ' type="text" name='details[]'>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class='col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 row'>
                    <div class='col-xl-3 col-lg-3 col-md-3 col-sm-3 col-3'>
                        <div class="form-group">
                            <br>
                            <a class="btn btn-success" onclick="addPieza()">
                                +
                            </a>
                        </div>
                    </div>
                </div>
                <div class='col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 '>
                    <div class="form-group">
                        <a class="btn btn-danger" style="margin-left:10px;" href="javascript:void(0)" onclick="load_view('patient_labs','labs',{'patient_id':<?php echo $patient_id;?>,'origin_type':'<?php echo $origin_type;?>','origin_id':<?php echo $origin_id;?>})">Terminar</a>
                        <button style='Float:right;' type="submit" class="btn btn-primary submit">Guardar</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
$(document).ready(function() {

    $('input[name="patient_id"]').val(patient_id)
    $(".basic2").select2({});
    $(".basic").select2();
    $('#result').hide();
    $('#bill').hide();


    if ($('#order_med').length) {
        CKEDITOR.config.uiColor = '#ffffff';
        CKEDITOR.config.height = 500;
        var editor = CKEDITOR.replace('order_med', {
            extraPlugins: 'autogrow,justify'
        });
        editor.on('instanceReady', function() {
            this.document.on("keyup", function() {
                save_content({
                    'table': 'medic_order',
                    'code': '<?php echo $medic_order; ?>',
                    'content': editor.getData(),
                    'date': $('input[name="order_date"]').val(),
                    'type': 1
                });
            });
        });

        $('input[name="order_date"]').on('change', function() {
            save_content({
                'table': 'medic_order',
                'code': '<?php echo $medic_order; ?>',
                'content': editor.getData(),
                'date': $('input[name="order_date"]').val(),
                'type': 1
            });
        });


    }
})

function laboratoriesExamns(value, no) {

    $.ajax({
        url: '<?php echo base_url().'/'.$this->session->userdata('login_type').'/'; ?>getExamns',
        type: 'POST',
        data: {
            laboratories: value,
        },
        success: function(result) {

            console.log(result);
            $('#examns_' + no).html(result);


            Toast = Swal.mixin({
                toast: true,
                position: 'top-right',
                showConfirmButton: false,
                timer: 5000
            });
            Toast.fire({
                type: 'success',
                title: 'Categoría seleccionada...'
            })
        },
        complete: function() {

            getPrice(value, no)
        }
    });
}

function getPrice(element, price_id) {

    const laboratory_id = $('#laboratories_' + price_id).val();
    const fields = $('#examns_' + price_id).select2("val");
    const payment_type = $('#payment_type').val();

    console.log(fields);

    $.ajax({
        url: "<?php echo base_url().'/'.$this->session->userdata('login_type').'/getPrice/';?>",
        type: "POST",
        data: {
            laboratory_id: laboratory_id,
            fields: fields,
            payment_type: payment_type
        },
        success: function(response) {


            $("#ttl-" + price_id).val(response);
            sum_total()

        },
        error: function() {
            console.log("error");
        }

    });
}

function sum_total() {
    var total = 0;

    $('.total').each(function(i, val) {
        //console.log(i)
        total += parseFloat($(this).val());
    });
    var grand_total = parseFloat(total);

    $('#total_text').html(grand_total.toFixed(2));
    $('#total').val(grand_total.toFixed(2));
}

function addPieza() {

    var id = $('.labs').length;
    var category_id = $('#category_id').val();
    $.ajax({
        url: "<?php echo base_url().'/'.$this->session->userdata('login_type').'/getPieza2';?>",
        type: "POST",
        data: {
            category: category_id,
            id: id,
        },
        success: function(response) {


            //console.log(response);
            $('#piezas').append(response);
            $(".basic2").select2({});
            $(".basic").select2();
        },
        error: function() {
            console.log("error");
        }
    });


}

function deletePieza(element) {
    element.parentElement.parentElement.remove();
    element.remove();
    sum_total();
}

$("#formSample").submit(function(e) {
    e.preventDefault();


    var total = $('#total').val();
    var priority = 0;
    $('.priority').each(function() {
        if ($(this).val() == 5)
            priority++;

    });

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
                icon: 'success',
                title: 'Orden registrada',
                showConfirmButton: false,
                timer: 1500
            });

            load_view('patient_labs', 'labs', {
                'patient_id': patient_id
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