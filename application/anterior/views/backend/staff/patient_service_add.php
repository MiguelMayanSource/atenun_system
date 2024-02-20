<link href="<?php echo base_url(); ?>public/assets/appointments/css/select2.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<style>
.resultado td:hover {
    background: #8950fc2b;
}

.table>tbody>tr>td:hover {
    background: #8950fc2b;
}

@media (min-width: 1200px) {
    .table-responsive { 
        overflow-x: scroll !important;
    }
}
</style>
<div id="main-content">
    <div class="card-widget layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-6">
                    <form action="<?php echo base_url() . 'staff/patient_service_add/create/' . $param2; ?>" method="post" enctype="multipart/form-data" id='formSample'>
                        <input type='hidden' name="total" value="0" id="total" />
                        <div class='row'>
                            <input type="hidden" class="form-control" name='patient_id' id='patient_id' value='0'>
                            <div class='col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-3'>
                                <div class="form-group" id="buscarPaciente">
                                    <label><span id='buscar'>Buscar</span> paciente<span style="color:red;">*</span></label>
                                    <input autocomplete="off" class="form-control" name='name' required id='patient' onkeyUp="getPatients(this.value)" placeholder='Buscar paciente'>
                                </div>
                                <div id="class_loader" class="spinner-border text-primary" style="display:none;" role="status"><span class="sr-only">Loading...</span></div>
                                <table id='result' class='table'>

                                </table>
                            </div>
                            <div class='col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12'>
                                <div class="form-group">
                                    <label>Análisis previo:</label>
                                    <select class='form-control' id='previa' disabled>
                                        <option value="1">Si</option>
                                        <option value="0" selected>No</option>
                                    </select>
                                    <input type="hidden" name="previa" value='No'>
                                </div>
                                <div class="table-responsive mb-4 mt-4" id='table_patologia' hidden>
                                    <table class="table table-hover" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Fecha</th>
                                                <th>Código</th>
                                                <th>Estudios</th>
                                                <th>Informe</th>
                                            </tr> 
                                        </thead>
                                        <tbody id='Anteriores'>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class='col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 '>
                                <div class="form-group">
                                    <label>Médico referente<span style="color:red;">*</span></label>
                                    <select name="doctors_id" class='form-control basic' required id='doctor_id'>
                                        <option value="">Seleccionar</option>
                                        <?php $this->db->order_by('first_name', 'ASC');
                                            $doctors = $this->db->get_where('admin', array('status !=' => 0, 'owner' => 0))->result_array();foreach ($doctors as $doc): ?>
                                        <option value="<?php echo $doc['admin_id']; ?>"><?php echo $doc['first_name'] . ' ' . $doc['last_name']; ?></option>
                                        <?php endforeach;?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Comentarios</label>
                                    <textarea class='form-control' name="several_doctors" cols="30" rows="3" placeholder='Comentarios'></textarea>
                                </div>
                            </div>
                            <div class='col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12'>
                                <div class="form-group">
                                    <label>Fecha de procedimiento </label>
                                    <input type="date" class="form-control" name='fecha_procedimiento'>
                                </div>
                            </div>
                            <div class='col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12'>
                                <div class="form-group">
                                    <label>Fecha de recibido</label>
                                    <input type="date" class="form-control" name='fecha_recibido' value='<?php echo date('Y-m-d'); ?>' readonly>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
                                <label>Prioridad:<span style="color:red;">*</span></label>
                                <select name="status_priority" class='form-control '>
                                    <option value="1" selected>Normal</option>
                                    <option value="2">Prioridad</option>
                                    <option value="4">Urgencia</option>
                                </select>
                            </div>
                            <input type='hidden' name="payment_type" class='form-control ' id="payment_type" onchange="getPrice2()" value="0" />
                            <div class='col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 row'>
                                <div class="table-responsive col-12 row">
                                    <table class="table" style="margin: 20px;">
                                        <tbody id="piezas">
                                            <tr>
                                                <td>
                                                    <div class="" style="width:230px;">
                                                        <label for="simpleinput">Categorias:</label>
                                                        <input type="hidden" name="cat" value="0" />
                                                        <select onchange="laboratoriesExamns(this.value,0)" class="form-control basic labs" name="laboratories[]" id="laboratories_0">
                                                            <option value="">Seleccionar</option>
                                                            <?php
                                                                         
                                                                $db = $this->db->query('SELECT * FROM `subcategory` where category_id = 5')->result_array();
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
                                                        <select class="form-control basic labs" name="exmans" id="examns_0">
                                                            <option value="">Seleccionar</option>
                                                        </select>
                                                    </div>
                                                    <input class='form-control total' type="hidden" min='0' onchange="sum_total()" onkeyup="sum_total()" name='price[]' id='ttl-0' readonly="true">
                                                </td>
                                                <td>
                                                    <div class="" style="width:200px;">
                                                        <label>Observación</label>
                                                        <input class='form-control ' type="text" name='details'>
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

                            <div class='col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12'>
                                <div class="form-group">
                                    <label>Datos positivos:</label>
                                    <textarea oninput="this.value = this.value.toUpperCase()" class='form-control' name='datos_positivos' id='datos_positivos'></textarea>
                                </div>
                            </div>

                            <div class='col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12'>
                                <div class="form-group">
                                    <label>Diagnóstico previo:</label>
                                    <textarea oninput="this.value = this.value.toUpperCase()" class="form-control" name='diagnostico' row='3' id='diagnostico'></textarea>
                                </div>
                            </div>
                            <div class='col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12'>
                                <div class="form-group">
                                    <label>¿Quién entrega la muestra?<span style="color:red;">*</span></label>
                                    <input type="text" class="form-control" name='delivered_by' required></input>
                                </div>
                            </div>
                            <div class='col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12'>
                                <div class="form-group">
                                    <label>Dirección de recepción:<span style="color:red;">*</span></label>
                                    <textarea oninput="this.value = this.value.toUpperCase()" class="form-control" name='address_r' row='3' required></textarea>
                                </div>
                            </div>
                            <div class='col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 '>
                                <div class="form-group">
                                    <button style='Float:right;' type="submit" class="btn btn-primary submit">Guardar</button>
                                    <a style='Float:right; display:none' href="javascript:void(0);" class="btn btn-info print_recipe" onclick="">Imprimir recibo</a>
                                    <a style='Float:right; display:none' href="<?php echo base_url(); ?>admin/samples_new" class="btn btn-warning sample_new">Nueva orden</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/print-js/1.6.0/print.js" integrity="sha512-/fgTphwXa3lqAhN+I8gG8AvuaTErm1YxpUjbdCvwfTMyv8UZnFyId7ft5736xQ6CyQN4Nzr21lBuWWA9RTCXCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
$('input[type="text"]').on('input', function() {

    this.value = this.value.toUpperCase()

})

$(".basic2").select2({});
$(".basic").select2();
$('#result').hide();
$('#bill').hide();



function getAge(fecha) {
    var hoy = new Date();
    var cumpleanos = new Date(fecha);
    var edad = hoy.getFullYear() - cumpleanos.getFullYear();
    var m = hoy.getMonth() - cumpleanos.getMonth();

    if (m < 0 || (m === 0 && hoy.getDate() < cumpleanos.getDate())) {
        edad--;
    }
    $(".age").val(edad);
}

function newPatient() {
    $('#patient_id').val(0);
    $('#result').hide(500);
    $('#buscar').html('Nuevo');
}

function getPatients(name) {

    $('#class_loader').show();
    if (name.length > 0) {
        $.ajax({
            url: "<?php echo base_url() . 'admin/getPatients/'; ?>",
            type: "POST",
            data: {
                name: name,
            },
            success: function(response) {
                $('#class_loader').hide();
                $('#result').show();
                $('#result').html(response);
                // console.log(response);
            },
            error: function() {
                console.log("error");
            }
        });
    }
}

function paciente(paciente_id, doctor_id) {
    //console.log('paciente_id:' + paciente_id);
    //console.log('Doctor_id:' + doctor_id);
    $('#result').hide(500);
    $('#patient_id').val(paciente_id);
    $('#doctor_id').val(doctor_id).change();

    $('#buscar').html('Buscar');

    getDiagnostico(doctor_id);
}


function getDiagnostico(doctor_id) {
    var patient = $('#patient_id').val();

    $.ajax({
        url: "<?php echo base_url() . 'admin/getDiagnostico'; ?>",
        type: "POST",
        dataType: "json",
        data: {
            doctor_id: doctor_id,
            patient: patient,
        },
        success: function(response) {
            //console.log(response);
            if (response != 0) {

                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: 'Paciente Encontrado',
                    showConfirmButton: false,
                    timer: 1500
                })

                var patient = response[0][0];
                $("#birthday").val(patient.date_of_birth);
                $('#age').val(patient.age);
                $('#phone').val(patient.phone);
                $("#gender").val(patient.gender).change();
                $("#activities").val(patient.activities);
                $("#patient_id").val(patient.patient_id);
                $("#patient").val(patient.first_name + ' ' + patient.last_name);


                var sample = response[1][0];

                $("#fecha_manarquia").val(sample.manarquia_date);
                $("#fecha_menopausia").val(sample.menopause_date);
                $("#ciclos_menstruales").val(sample.menstrual_cycle);
                $("#FUR").val(sample.FUR);
                $("#gestas").val(sample.deeds);
                $("#partos").val(sample.birth);
                $("#abortos").val(sample.abortion);
                $("#fecha_ultimo_parto").val(sample.birth_date);
                $("#DIU").val(sample.DIU);
                $("#tx_hormonal").val(sample.tx_hormonal);
                $("#datos_positivos").val(sample.positive_data);
                $("#previa").val('1').change();
                $("#diagnostico").val(sample.diagnosis);

                $('#table_patologia').removeAttr('hidden');
                $('#Anteriores').html(response[2])

                if (patient.gender == "Masculino") {
                    $('#gineco').hide(500);
                } else {
                    $('#gineco').show(500);

                }

            } else {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'error',
                    title: 'Paciente No Encontrado',
                    showConfirmButton: false,
                    timer: 1500
                })
            }

        },
        error: function() {
            console.log("error");
        }

    });

}

function getPrice(element, price_id) {

    const laboratory_id = $('#laboratories_' + price_id).val();
    const fields = $('#examns_' + price_id).select2("val");
    const payment_type = $('#payment_type').val();

    console.log(price_id,fields);

    $.ajax({
        url: "<?php echo base_url() . 'admin/getPrice/'; ?>",
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

function getPrice2() {
    var price_id = 0;
    $('.labs').each(function() {

        var fields = $('#examns_' + price_id).select2("val");
        var payment_type = $('#payment_type').val();
        var laboratory_id = $('#laboratories_' + price_id).val();
        console.log('f:' + fields);
        console.log('p:' + payment_type);
        console.log('l:' + laboratory_id);

        $.ajax({
            url: "<?php echo base_url() . 'admin/getPrice/'; ?>",
            type: "POST",
            data: {
                fields: fields,
                laboratory_id: laboratory_id,
                payment_type: payment_type
            },
            success: function(response) {

                console.log('price:' + response);
                $("#ttl-" + price_id).val(response);
                sum_total()

            },
            complete: function() {
                price_id++;
            },
            error: function() {
                console.log("error");
            }

        });



    });


}

function getFactura(facturado) {
    if (facturado == '1') {
        $('#factura').show(500);
    } else {
        $('#factura').hide(500);
    }
}

function getCredito(credito) {
    if (credito == '1') {
        $('.pago').hide(500);
        $('#bill').show(500);
        $('.bill').attr('required', true);
    } else {
        $('.pago').show(500);
        $('#bill').hide(500);
        $('.bill').removeAttr('required');
    }
}

function getMetodo(metodo) {
    if (metodo == '1' || metodo == '') {
        $('.referencia').hide(500);
    } else {
        $('.referencia').show(500);
    }
}



function addPieza() {

    var id = $('.labs').length;
    var category_id = $('#category_id').val();
    $.ajax({
        url: "<?php echo base_url() . 'admin/getPieza'; ?>",
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



function price_priority(value) {
    var total = 0;
    $('.basic2').each(function(i, val) {
        //console.log(i)
        //console.log(value, $(this).val(), i);
        getPrecio($(this).val(), i)
    });

}


$("#formSample").submit(function(e) {
    e.preventDefault();


    var total = $('#total').val();
    var priority = 0;
    $('.priority').each(function() {
        if ($(this).val() == 5)
            priority++;

    });

    if (total > 0 && priority == 0) {

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
                    title: 'Muestra registrada',
                    showConfirmButton: false,
                    timer: 1500
                });
                $('.submit').hide();
                $('.print_recipe').attr('onclick', `print("${response}")`);
                $('.print_recipe').show();
                $('.sample_new').show();
                console.log(response);



            },
            complete: function() {
                $("#addSample").removeAttr('disabled');
            },
            error: function() {
                console.log("error");
            }
        });
    } else if (total == 0 && priority > 0) {

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
                    title: 'Muestra registrada',
                    showConfirmButton: false,
                    timer: 1500
                });
                $('.submit').hide();
                $('.print_recipe').attr('onclick', `print("${response}")`);
                $('.print_recipe').show();
                console.log(response);



            },
            complete: function() {
                $("#addSample").removeAttr('disabled');
            },
            error: function() {
                console.log("error");
            }
        });
    } else {
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'error',
            title: 'Valor no puede ser 0',
            showConfirmButton: false,
            timer: 1500
        });
        return false;
    }



});



function print(code) {

    $.ajax({
        url: "<?php echo base_url() . 'admin/samples/get/'; ?>",
        type: 'post',
        data: {
            code: code
        },
        success: function(data) {
            //console.log(data);
            printJS({
                printable: data,
                type: "raw-html",
                css: ["<?php echo base_url() . 'public/assets/css/ticket.css'; ?>"],
            });

        },
        error: function(e) {
            console.log("ERROR : ", e);
        }

    });

}

function laboratoriesExamns(value, no) {

    $.ajax({
        url: '<?php echo base_url() ?>admin/getExamns',
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
</script>