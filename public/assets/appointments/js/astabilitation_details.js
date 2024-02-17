function multi() {
    var height = $("#height").val();
    var weight = $("#weight").val();
    Meters = height;
    Kilos = weight;
    Square = Meters * Meters;
    var results = Math.round((Kilos * 10) / Square) / 10;
    $("#results").val(results.toFixed(2));
    $("#mass").val(results.toFixed(2));
}

function imcIngles() {
    var feet = $("input[name=feet]").val();
    var inches = $("input[name=inches]").val() || 0;
    var totalInches = eval(feet * 12) + eval(inches);
    var totalWeight = $("input[name=pounds]").val();
    var m = totalInches / 39.37;
    var kg = totalWeight / 2.2046;
    $("#height").val(m);
    $("#weight").val(kg);
    if (totalWeight == "") {
        $("#results").val(0);
        $("#mass").val(0);
    } else {
        var weight = parseFloat(totalWeight, 10);
        var height = parseFloat(totalInches, 10);
        var bmi = Math.round((weight * 703 * 10) / height / height) / 10;
        $("#results").val(bmi.toFixed(2));
        $("#mass").val(bmi.toFixed(2));
    }
}


var patient_id = $("#patient_id").val();

function submit_treatment(app_id) {
    var stabilitation_id = $("#stabilitation_id_" + app_id).val();
    var medicine = $("#medicine_" + app_id).val();
    var quantity = $("#drink_" + app_id).val();
    var frequency = $("#frequency_" + app_id).val();
    var duration = $("#duration_" + app_id).val();
    var treatment_id = $("#duration" + app_id).val();
    console.log(duration);
    if (
        stabilitation_id != "" &&
        medicine != "" &&
        quantity != "" &&
        frequency != "" &&
        duration != ""
    ) {
        $.ajax({
            url: base_url + "doctor/prescriptions/create_estb/",
            type: "POST",
            data: {
                medicine: medicine,
                quantity: quantity,
                frequency: frequency,
                duration: duration,
                stabilitation_id: stabilitation_id,
                patient_id: patient_id,
            },
            success: function(result) {
                $("#medicine_" + app_id).val("");
                $("#drink_" + app_id).val("");
                $("#frequency_" + app_id).val("");
                $("#duration_" + app_id).val("");
                update_table_est(stabilitation_id);
            },
        });
    } else {
        const Toast = Swal.mixin({
            toast: true,
            position: "top-right",
            showConfirmButton: false,
            timer: 5000,
        });
        Toast.fire({
            type: "error",
            title: "Todos los campos son necesarios",
        });
    }
}

function submit_insumo(app_id) {
    var stabilitation_id = $("#stabilitation_id_" + app_id).val();
    var product_estb_id = $("#product_estb_id_" + app_id).val();
    var product_cantidad_id = $("#product_cantidad_id_" + app_id).val();
    var product_descuento_id = $("#product_descuento_id_" + app_id).val();

    if (
        stabilitation_id != "" &&
        product_estb_id != "" &&
        product_cantidad_id != "" &&
        product_cantidad_id >= product_descuento_id
       
    ) {
        $.ajax({
            url: base_url + "doctor/product_estb/add_estb/",
            type: "POST",
            data: {
                product_estb_id: product_estb_id,
                stabilitation_id: stabilitation_id,
                product_cantidad_id: product_cantidad_id,
                product_descuento_id: product_descuento_id
            },
            success: function(result) {
                //$("#product_estb_id_" + app_id).val("");
                update_insumo_est(stabilitation_id);
                $("#product_estb_id_" + app_id).val('');
                $("#product_cantidad_id_" + app_id).val('');
                $("#product_descuento_id_" + app_id).val('');

            },
        });
    } else {
        const Toast = Swal.mixin({
            toast: true,
            position: "top-right",
            showConfirmButton: false,
            timer: 5000,
        });
        Toast.fire({
            type: "error",
            title: "Todos los campos son necesarios",
        });
    }
}

function submit_discount(app_id) {
    
    var stabilitation_ref_id = app_id;
    var amount = $("#amount_discount").val();
    var description = $("#description_discount" ).val();
    
    console.log(stabilitation_ref_id, amount, description);
    
    if (stabilitation_ref_id != "" && amount != "" && description != "") 
    {
        $.ajax({
            url: base_url + "doctor/discount_estb/add_estb/",
            type: "POST",
            data: {
                stabilitation_ref_id: stabilitation_ref_id,
                amount: amount,
                description: description
            },
            success: function(result) {
                $("#description_discount" ).val('');
                $("#amount_discount").val('');
                
                update_discount_est(stabilitation_ref_id);
                const Toast = Swal.mixin({
                toast: true,
                position: "top-right",
                showConfirmButton: false,
                timer: 5000,
                    });
                    Toast.fire({
                        type: "success",
                        title: "Agregado",
                    });
            },
        });
    } else {
        const Toast = Swal.mixin({
            toast: true,
            position: "top-right",
            showConfirmButton: false,
            timer: 5000,
        });
        Toast.fire({
            type: "error",
            title: "Todos los campos son necesarios",
        });
    }
}
function submit_service(app_id) {
    var stabilitation_id = $("#stabilitation_id_" + app_id).val();
    var service_estb_id = $("#service_estb_id_" + app_id).val();
    var service_cantidad_id = $("#service_cantidad_id_" + app_id).val();

    if (stabilitation_id != "" && service_estb_id != "" && service_cantidad_id != "") {
        $.ajax({
            url: base_url + "doctor/service_estb/add_estb/",
            type: "POST",
            data: {
                service_estb_id: service_estb_id,
                stabilitation_id: stabilitation_id,
                service_cantidad_id: service_cantidad_id,
            },
            success: function(result) {
                $("#service_estb_id_" + app_id).val("");
                update_service_est(stabilitation_id);
                $("#service_estb_id_" + app_id).val('');
                $("#service_cantidad_id_" + app_id).val('');


            },
        });
    } else {
        const Toast = Swal.mixin({
            toast: true,
            position: "top-right",
            showConfirmButton: false,
            timer: 5000,
        });
        Toast.fire({
            type: "error",
            title: "Todos los campos son necesarios",
        });
    }
}

function submit_laboratory(app_id) {
    var stabilitation_id = $("#stabilitation_id_" + app_id).val();
    var laboratory_id = $("#laboratory_id_" + app_id).val();

    if (stabilitation_id != "" && laboratory_id != "") {
        $.ajax({
            url: base_url + "doctor/laboratories/add_est/",
            type: "POST",
            data: {
                laboratory_id: laboratory_id,
                stabilitation_id: stabilitation_id,
            },
            success: function(result) {
                $("#laboratory_id_" + app_id).val("");
                update_laboratory_est(stabilitation_id);
            },
        });
    } else {
        const Toast = Swal.mixin({
            toast: true,
            position: "top-right",
            showConfirmButton: false,
            timer: 5000,
        });
        Toast.fire({
            type: "error",
            title: "Todos los campos son necesarios",
        });
    }
}

function submit_rayos_x(app_id) {
    var stabilitation_id = $("#stabilitation_id_" + app_id).val();
    var rayos_x = $("#rayos_x_" + app_id).val();

    if (stabilitation_id != "" && rayos_x != "") {
        $.ajax({
            url: base_url + "doctor/rayos_x/add_est/",
            type: "POST",
            data: {
                rayos_x: rayos_x,
                stabilitation_id: stabilitation_id,
            },
            success: function(result) {
                $("#rayos_x_" + app_id).val("");
                update_rayos_x_est(stabilitation_id);
            },
        });
    } else {
        const Toast = Swal.mixin({
            toast: true,
            position: "top-right",
            showConfirmButton: false,
            timer: 5000,
        });
        Toast.fire({
            type: "error",
            title: "Todos los campos son necesarios",
        });
    }
}

$(document).ready(function() {
    test()
    $(".itemName").select2();
    $(".itemName2").select2();
    $("#d-" + app).click();
   
});

function test()
{
    console.log('Ready');
}



function delete_discount(element_id,stb_id) {
    Swal.fire({
        title:  "¿Estás seguro?",
        text:   "Se eliminará este descuento.",
        type:   "info",
        showCancelButton: true,
        confirmButtonColor: "#9fd13b",
        cancelButtonColor: "#fd4f57",
        confirmButtonText: "Sí, eliminar",
        cancelButtonText: "Cancelar",
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: base_url + "doctor/discount_estb/delete_estb/" + element_id,
                success: function(response) {
                   update_discount_est(stb_id);
                },
            });
        }
    });
}


function delete_treatment(element_id, stabilitation_id) {
    Swal.fire({
        title: "¿Estás seguro?",
        text: "Se eliminará la información a este medicamento.",
        type: "info",
        showCancelButton: true,
        confirmButtonColor: "#9fd13b",
        cancelButtonColor: "#fd4f57",
        confirmButtonText: "Sí, eliminar",
        cancelButtonText: "Cancelar",
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: base_url + "doctor/prescriptions/delete_estb/" + element_id,
                success: function(response) {
                    update_table_est(stabilitation_id);
                },
            });
        }
    });
}



function delete_service(element_id, stabilitation_id) {

    Swal.fire({
        title: "¿Estás seguro?",
        text: "Se eliminará la información a este medicamento.",
        type: "info",
        showCancelButton: true,
        confirmButtonColor: "#9fd13b",
        cancelButtonColor: "#fd4f57",
        confirmButtonText: "Sí, eliminar",
        cancelButtonText: "Cancelar",
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: base_url + "doctor/service_estb/delete_est/" + element_id,
                success: function(response) {
                    console.log(element_id);
                    update_service_est(stabilitation_id);
                },
            });
        }
    });
}

function delete_rayos_x(element_id, stabilitation_id) {
    Swal.fire({
        title: "¿Estás seguro?",
        text: "Se eliminará la información a este medicamento.",
        type: "info",
        showCancelButton: true,
        confirmButtonColor: "#9fd13b",
        cancelButtonColor: "#fd4f57",
        confirmButtonText: "Sí, eliminar",
        cancelButtonText: "Cancelar",
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: base_url + "doctor/rayos_x/delete_est/" + element_id,
                success: function(response) {
                    update_rayos_x_est(stabilitation_id);
                },
            });
        }
    });
}

function delete_insumo(element_id, stabilitation_id) {
    Swal.fire({
        title: "¿Estás seguro?",
        text: "Se eliminará la información a este medicamento.",
        type: "info",
        showCancelButton: true,
        confirmButtonColor: "#9fd13b",
        cancelButtonColor: "#fd4f57",
        confirmButtonText: "Sí, eliminar",
        cancelButtonText: "Cancelar",
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: base_url + "doctor/product_estb/delete_estb/" + element_id,
                success: function(response) {
                    update_insumo_est(stabilitation_id);
                },
            });
        }
    });
}

function update_discount_est(stabilitation_id) {
    $.ajax({
        url: base_url + "doctor/update_discount_table_est/" + stabilitation_id,
        success: function(response) {
            jQuery("#table_discount").html(response);
        },
    });

    $("#resumen").load(window.location.href + " #resumen");
}

function update_table_est(stabilitation_id) {
    $.ajax({
        url: base_url + "doctor/update_prescription_table_est/" + stabilitation_id,
        success: function(response) {
            jQuery("#table_results_" + stabilitation_id).html(response);
        },
    });

    $("#resumen").load(window.location.href + " #resumen");
}

function update_service_est(stabilitation_id) {
    $.ajax({
        url: base_url + "doctor/update_service_table/" + stabilitation_id,
        success: function(response) {
            jQuery("#table_service_" + stabilitation_id).html(response);
        },
    });

    $("#resumen").load(window.location.href + " #resumen");
}

function update_insumo_est(stabilitation_id) {
    $.ajax({
        url: base_url + "doctor/update_insumo_table/" + stabilitation_id,
        success: function(response) {
            jQuery("#table_insumo_" + stabilitation_id).html(response);
        },
    });

    $("#resumen").load(window.location.href + " #resumen");
}

function update_laboratory_est(stabilitation_id) {
    $.ajax({
        url: base_url + "doctor/update_laboratory_table_est/" + stabilitation_id,
        success: function(response) {
            jQuery("#table_laboratory_" + stabilitation_id).html(response);
        },
    });

    $("#resumen").load(window.location.href + " #resumen");
}

function update_rayos_x_est(stabilitation_id) {
    $.ajax({
        url: base_url + "doctor/update_rayos_x_table_est/" + stabilitation_id,
        success: function(response) {
            jQuery("#table_rayos_x_" + stabilitation_id).html(response);
        },
    });

    $("#resumen").load(window.location.href + " #resumen");
}

function drink() {
    $("#drink").typeahead({
        source: [
            "1/2 tableta",
            "1 tableta",
            "2 tabletas",
            "1 ampolleta",
            "1 cápsula",
            "2 cápsulas",
            "1 pastilla",
            "2 pastillas",
            "1 cucharada",
            "1 gota",
            "2 gotas",
            "2.5 ML",
            "5 ML",
            "10 ML",
        ],
        autoSelect: false,
        items: 1000,
        minLength: 0,
    });
    $("#drink").trigger("keyup");
    $("#drink").focus();
}

function frequency() {
    $("#frequency").typeahead({
        source: [
            "cada 4 horas",
            "cada 6 horas",
            "cada 8 horas",
            "cada 12 horas",
            "cada 24 horas",
        ],
        autoSelect: false,
        items: 1000,
        minLength: 0,
    });
    $("#frequency").trigger("keyup");
    $("#frequency").focus();
}

function duration() {
    $("#duration").typeahead({
        source: ["3 días", "5 días", "7 días", "10 días", "15 días", "30 dias"],
        autoSelect: false,
        items: 1000,
        minLength: 0,
    });
    $("#duration").trigger("keyup");
    $("#duration").focus();
}

$(document).on("keyup", function(e) {
    if ($("#drink").is(":focus")) {
        var code = e.keyCode ? e.keyCode : e.which;
        if (code == 9) {
            drink();
        }
    }
});

$(document).on("keyup", function(e) {
    if ($("#frequency").is(":focus")) {
        var code = e.keyCode ? e.keyCode : e.which;
        if (code == 9) {
            frequency();
        }
    }
});
$(document).on("keyup", function(e) {
    if ($("#duration").is(":focus")) {
        var code = e.keyCode ? e.keyCode : e.which;
        if (code == 9) {
            duration();
        }
    }
});
$("#drink").click(function() {
    drink();
});
$("#frequency").click(function() {
    frequency();
});
$("#duration").click(function() {
    duration();
});
$("#patient_id").click(function() {
    patient_id();
});

if (typeof CKEDITOR !== "undefined") {
    CKEDITOR.disableAutoInline = true;
    if ($("#ckeditorEmail").length) {
        CKEDITOR.config.uiColor = "#ffffff";
        CKEDITOR.config.toolbar = [
            [
                "Bold",
                "Italic",
                "-",
                "NumberedList",
                "BulletedList",
                "-",
                "Link",
                "Unlink",
                "-",
                "About",
            ],
        ];
        CKEDITOR.config.height = 110;
        CKEDITOR.replace("reason");
    }
    if ($("#ckeditorEmail1").length) {
        CKEDITOR.config.uiColor = "#ffffff";
        CKEDITOR.config.toolbar = [
            [
                "Bold",
                "Italic",
                "-",
                "NumberedList",
                "BulletedList",
                "-",
                "Link",
                "Unlink",
                "-",
                "About",
            ],
        ];
        CKEDITOR.config.height = 110;
        CKEDITOR.replace("exploration");
    }
    if ($("#ckeditorEmail12").length) {
        CKEDITOR.config.uiColor = "#ffffff";
        CKEDITOR.config.toolbar = [
            [
                "Bold",
                "Italic",
                "-",
                "NumberedList",
                "BulletedList",
                "-",
                "Link",
                "Unlink",
                "-",
                "About",
            ],
        ];
        CKEDITOR.config.height = 110;
        CKEDITOR.replace("instructions");
    }
    if ($("#ckplan").length) {
        CKEDITOR.config.uiColor = "#ffffff";
        CKEDITOR.config.toolbar = [
            [
                "Bold",
                "Italic",
                "-",
                "NumberedList",
                "BulletedList",
                "-",
                "Link",
                "Unlink",
                "-",
                "About",
            ],
        ];
        CKEDITOR.config.height = 110;
        CKEDITOR.replace("ckplan");
    }
}

function confirm_appointment(stabilitation_id) {
    Swal.fire({
        title: "Confirmar esta acción",
        text: "Esta acción no puede deshacerse, la cita comentará inmediatamente después de la confirmación.",
        type: "info",
        showCancelButton: true,
        confirmButtonColor: "#9fd13b",
        cancelButtonColor: "#fd4f57",
        confirmButtonText: "Continuar",
        cancelButtonText: "Cancelar",
    }).then((result) => {
        if (result.value) {
            location.href =
                base_url + "doctor/appointments/start/" + stabilitation_id;
        }
    });
}

function showAjaxModal(url) {
    jQuery("#exampleModal .modal-dialog").html(
        '<center><img style="background-color:#fff;border-radius:50%; width:85px" src="https://mayansource.dev/medesk/uploads/loader.gif" /></center>'
    );
    jQuery("#exampleModal").modal("show", { backdrop: "true" });
    $.ajax({
        url: url,
        success: function(response) {
            jQuery("#exampleModal .modal-dialog").html(response);
        },
    });
}

function change_amout(amount) {
    var total = 0;
    var descuento = 0;
    total = parseFloat($(".monto").val());
    services = parseFloat($(".services").val());
    if ($(".descuento").val() != "") {
        descuento = parseFloat($(".descuento").val());
    }


    sbt = services + total - descuento;

    tt = document.getElementById("total_text");
    tt.innerText = sbt;
    n = document.getElementById("totalGeneral");
    n.value = sbt;


    $.ajax({
        url: base_url + "doctor/product_estb/add_discount/",
        type: "POST",
        data: {

            stabilitation_ref_id: ref,
            total: sbt,
            descuento: descuento
        },
        success: function(result) {


        },
    });
}

function set_amout() {
    var amount = $("#amount").val();
    var text = $("#total").html("Q" + amount);
}
items = document.getElementsByClassName("itemTotalNeto");
for (var i = 0; i < items.length; i++) {
    items[i].addEventListener("change", function() {
        n = document.getElementById("totalGeneral");
        n.value =
            parseInt("0" + n.value) +
            parseInt("0" + this.value) -
            parseInt("0" + this.defaultValue);
        this.defaultValue = this.value;
    });
}