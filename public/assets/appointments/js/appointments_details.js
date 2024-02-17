function multi() {
    var height = $('#height').val();
    var weight = $('#weight').val();
    Meters = height;
    Kilos = weight;
    Square = Meters * Meters;
    var results = Math.round(Kilos * 10 / Square) / 10;
    $('#results').val(results.toFixed(2));
    $('#mass').val(results.toFixed(2));
}

function imcIngles() {
    var feet = $("input[name=feet]").val();
    var inches = $("input[name=inches]").val() || 0;
    var totalInches = eval(feet*12) + eval(inches);
    var totalWeight = $("input[name=pounds]").val();
    var m = totalInches/39.370;
    var kg = totalWeight/2.2046;
    $('#height').val(m);
    $('#weight').val(kg);
    if(totalWeight == "")
    {
        $('#results').val(0);
        $('#mass').val(0); 
    }else
    {
        var weight = parseFloat(totalWeight, 10);
        var height = parseFloat(totalInches, 10);
        var bmi = Math.round(weight * 703 * 10 / height / height) / 10;
        $('#results').val(bmi.toFixed(2));
        $('#mass').val(bmi.toFixed(2));  
    }
}

var appointment_id = $("#appointment_id").val(); 
 
$(document).ready(function() {

    console.log(app);
    $( "#d-"+app ).click();


    $('.itemName').select2();
    $('.itemName2').select2();

    


});


    
function submit_recet(code)
{
    var medicine = $("#med").val();
    var sugest_id = $("#med_sugest").val();
    if (code != '' && medicine != '' ) {
        $.ajax({
            url: url + "prescriptions/create/",
            type: 'POST',
            data: {
                medicine: medicine,
                sugest_id: sugest_id,
                code: code,
                patient_id: patient_id
            },
            success: function(result) {
                $("#med").val('');
                $('#med_sugest').val(0);
                update_table(code);
            }
        });
    } else {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-right',
            showConfirmButton: false,
            timer: 5000
        });
        Toast.fire({
            type: 'error',
            title: 'Todos los campos son necesarios'
        })
    }
};


function submit_laboratory_app(appointment_id){
    var laboratory_id = $("#laboratory_id_"+appointment_id).val();
   
    if (appointment_id != '' && laboratory_id != ''  ) {
        $.ajax({
            url: url + "laboratories/add_app/",
            type: 'POST',
            data: {
                laboratory_id: laboratory_id,
                appointment_id: appointment_id,
               
            },
            success: function(result) {
                $("#laboratory_id").val('');
                update_laboratory(appointment_id);
            }
        });
    } else {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-right',
            showConfirmButton: false,
            timer: 5000
        });
        Toast.fire({
            type: 'error',
            title: 'Todos los campos son necesarios'
        })
    }
};



function submit_rayos_x (appointment_id){
    var rayos_x_id = $("#rayos_x_id_"+appointment_id).val();
   
    if (appointment_id != '' && rayos_x_id != ''  ) {
        $.ajax({
            url: url + "rayos_x/add_app/",
            type: 'POST',
            data: {
                rayos_x_id: rayos_x_id,
                appointment_id: appointment_id,
               
            },
            success: function(result) {
                $("#rayos_x_id").val('');
                update_rayos_x(appointment_id);
            }
        });
    } else {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-right',
            showConfirmButton: false,
            timer: 5000
        });
        Toast.fire({
            type: 'error',
            title: 'Todos los campos son necesarios'
        })
    }
};



function delete_element(element_id, appointment_id) 
{
        Swal.fire({
            title: '¿Estás seguro?',
            text: "Se eliminará la información a este medicamento.",
            type: 'info',
            showCancelButton: true,
            confirmButtonColor: '#9fd13b',
            cancelButtonColor: '#fd4f57',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.value) 
            {
        $.ajax({
            url: url + 'prescriptions/delete_medicine/' + element_id,
            success: function(response) {
                update_table(appointment_id);
            }
        });
        }
    })
}

function delete_laboratory(element_id, appointment_id) 
{
        Swal.fire({
            title: '¿Estás seguro?',
            text: "Se eliminará la información a este medicamento.",
            type: 'info',
            showCancelButton: true,
            confirmButtonColor: '#9fd13b',
            cancelButtonColor: '#fd4f57',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.value) 
            {
        $.ajax({
            url: url + 'laboratories/delete_app/' + element_id,
            success: function(response) {
                update_laboratory(appointment_id);
            }
        });
        }
    })
}

function delete_rayos_x(element_id, appointment_id) 
{
        Swal.fire({
            title: '¿Estás seguro?',
            text: "Se eliminará la información a este medicamento.",
            type: 'info',
            showCancelButton: true,
            confirmButtonColor: '#9fd13b',
            cancelButtonColor: '#fd4f57',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.value) 
            {
        $.ajax({
            url: url + 'rayos_x/delete_app/' + element_id,
            success: function(response) {
                update_rayos_x(appointment_id);
            }
        });
        }
    })
}

function update_table(code) {
    $.ajax({
        url: url + 'update_prescription_table/' + code,
        success: function(response) {
            jQuery('#table_results').html(response);
        }
    });
}


function update_laboratory(appointment_id) {
    $.ajax({
        url: url + 'update_laboratory_table/' + appointment_id,
        success: function(response) {
            jQuery('#table_laboratory_'+appointment_id).html(response);
        }
    });
}

function update_rayos_x(appointment_id) {
    $.ajax({
        url: url + 'update_rayos_x/' + appointment_id,
        success: function(response) {
            jQuery('#table_rayos_x_'+appointment_id).html(response);
        }
    });
}


function update_table_est(appointment_id) {
    $.ajax({
        url: url + 'update_prescription_table_est/' + appointment_id,
        success: function(response) {
            jQuery('#table_results').html(response);
        }
    });
}


function update_laboratory_est(appointment_id) {
    $.ajax({
        url: url + 'update_laboratory_table_est/' + appointment_id,
        success: function(response) {
            jQuery('#table_laboratory').html(response);
        }
    });
}

function update_rayos_x_est(appointment_id) {
    $.ajax({
        url: url + 'update_rayos_x_est/' + appointment_id,
        success: function(response) {
            jQuery('#table_rayos_x').html(response);
        }
    });
}

function drink() {
    $('#drink').typeahead({
        source: ['1/2 tableta', '1 tableta', '2 tabletas', '1 ampolleta', '1 cápsula', '2 cápsulas', '1 pastilla', '2 pastillas', '1 cucharada', '1 gota', '2 gotas', '2.5 ML', '5 ML', '10 ML'],
        autoSelect: false,
        items: 1000,
        minLength: 0
    });
    $('#drink').trigger('keyup');
    $('#drink').focus();
}

function frequency() {
    $('#frequency').typeahead({
        source: ['cada 4 horas', 'cada 6 horas', 'cada 8 horas', 'cada 12 horas', 'cada 24 horas'],
        autoSelect: false,
        items: 1000,
        minLength: 0
    });
    $('#frequency').trigger('keyup');
    $('#frequency').focus();
}

function duration() {
    $('#duration').typeahead({
        source: ['3 días', '5 días', '7 días', '10 días', '15 días', '30 dias'],
        autoSelect: false,
        items: 1000,
        minLength: 0
    });
    $('#duration').trigger('keyup');
    $('#duration').focus();
}

$(document).on("keyup", function(e) {
    if ($('#drink').is(":focus")) {
        var code = (e.keyCode ? e.keyCode : e.which);
        if (code == 9) {
            drink();
        }
    }
});

$(document).on("keyup", function(e) {
    if ($('#frequency').is(":focus")) {
        var code = (e.keyCode ? e.keyCode : e.which);
        if (code == 9) {
            frequency();
        }
    }
});
$(document).on("keyup", function(e) {
    if ($('#duration').is(":focus")) {
        var code = (e.keyCode ? e.keyCode : e.which);
        if (code == 9) {
            duration();
        }
    }
    });
    $('#drink').click(
    function() {
        drink();
    });
    $('#frequency').click(
    function() {
        frequency();
    });
    $('#duration').click(
    function() {
        duration();
    });
    $('#patient_id').click(
    function() {
        patient_id();
    });

if (typeof CKEDITOR !== 'undefined') {
    CKEDITOR.disableAutoInline = true;
    if ($('#ckeditorEmail').length) {
        CKEDITOR.config.uiColor = '#ffffff';
        CKEDITOR.config.toolbar = [
            ['Bold', 'Italic', '-', 'NumberedList', 'BulletedList', '-', 'Link', 'Unlink', '-', 'About']
        ];
        CKEDITOR.config.height = 110;
        CKEDITOR.replace('reason');
    }
    if ($('#ckeditorEmail1').length) {
        CKEDITOR.config.uiColor = '#ffffff';
        CKEDITOR.config.toolbar = [
            ['Bold', 'Italic', '-', 'NumberedList', 'BulletedList', '-', 'Link', 'Unlink', '-', 'About']
        ];
        CKEDITOR.config.height = 110;
        CKEDITOR.replace('exploration');
    }
    if ($('#ckeditorEmail12').length) {
        CKEDITOR.config.uiColor = '#ffffff';
        CKEDITOR.config.toolbar = [
            ['Bold', 'Italic', '-', 'NumberedList', 'BulletedList', '-', 'Link', 'Unlink', '-', 'About']
        ];
        CKEDITOR.config.height = 110;
        CKEDITOR.replace('instructions');
    }
    if ($('#ckplan').length) {
        CKEDITOR.config.uiColor = '#ffffff';
        CKEDITOR.config.toolbar = [
            ['Bold', 'Italic', '-', 'NumberedList', 'BulletedList', '-', 'Link', 'Unlink', '-', 'About']
        ];
        CKEDITOR.config.height = 110;
        CKEDITOR.replace('ckplan');
    }
}

function confirm_appointment(appointment_id) {
    Swal.fire({
        title: 'Confirmar esta acción',
        text: "Esta acción no puede deshacerse, la cita comentará inmediatamente después de la confirmación.",
        type: 'info',
        showCancelButton: true,
        confirmButtonColor: '#9fd13b',
        cancelButtonColor: '#fd4f57',
        confirmButtonText: 'Continuar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.value) {
            location.href = url + "appointments/start/" + appointment_id;
        }
    })
}

function showAjaxModal(url)
{
    jQuery('#exampleModal .modal-dialog').html('<center><img style="background-color:#fff;border-radius:50%; width:85px" src="https://mayansource.dev/medesk/uploads/loader.gif" /></center>');
    jQuery('#exampleModal').modal('show', {backdrop: 'true'});
    $.ajax({
        url: url,
        success: function(response)
        {
            jQuery('#exampleModal .modal-dialog').html(response);
        }
    });
}

function change_amout(amount) 
{
    var total = 0;
    $(".monto").each(function() {
    if (isNaN(parseFloat($(this).val()))) {
        total += 0;
    } else {
        total += parseFloat($(this).val());
    }
    });
  tt = document.getElementById("total_text");
  tt.innerText= total;
  n = document.getElementById("totalGeneral");
  n.value = total;
}
function set_amout() {
    var amount = $('#amount').val();
    var text = $('#total').html('Q' + amount);
}
items = document.getElementsByClassName("itemTotalNeto")
for (var i = 0; i < items.length; i++) {
 items[i].addEventListener('change', function() {
  n = document.getElementById("totalGeneral");
  n.value = parseInt("0"+n.value) + parseInt("0"+this.value) - parseInt("0"+this.defaultValue);
 this.defaultValue = this.value;
 });
};
