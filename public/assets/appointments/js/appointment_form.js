$(function() {
    "use strict";
    if ($("#DoctorPicker1").length) {
        var date = new Date();
        var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
        $("#DoctorPicker1").datepicker({
            format: "dd/mm/yyyy",
            todayHighlight: true,
            autoclose: true,
        });
    }
});

function showServices(inn) {
    setTimeout(function() {
        $(".forward").click();
    }, 250);
}

var odonto = 0;

function selectServices(inn) {
   
    setTimeout(function() {
        $(".forward").click();
    }, 250);
}

function patient_treatment(patient_id) {
    if (odonto == 1) {
        $.ajax({
            type: "POST",
            url: base_url + "doctor/patient_treatment/" + patient_id,
            dataType: "html",
            error: function(xhr, ajaxOptions, thrownError) {
                alert(
                    "Lo sentimos, algo salió mal, por favor intente de nuevo o llame a asistencia técnica"
                );
            },
            success: function(data) {
                $("#patient_treatment").empty();
                $("#patient_treatment").html(data);
                setTimeout(function() {
                    $(".forward").click();
                }, 250);
            },
        });
    } else {
        setTimeout(function() {
            $(".forward").click();
        }, 250);
    }
}

function showValue(inn) {
    $("#check").val(inn.value);
}

function new_treatment(inn) {
    if (inn == 0) {
        $("#new_treatment").css("display", "block");
        $("#name_treatment").prop("required", true);
        $('input[name="type_treatment"]').prop("required", true);
    } else {
        $("#new_treatment").css("display", "none");
        $("#name_treatment").prop("required", false);
        $('input[name="type_treatment"]').prop("required", false);
    }
}

function validate(inn) {
    $('input[name ="patient_type"]').val(inn);
}

function horario(datee) {
    setTimeout(function() {
        $(".forward").click();
    }, 250);
    var picked = document.querySelectorAll('[data-calendar-label="picked"]')[0];
    var h = [];
    $.ajax({
        url: base_url + "doctor/hour_busy",
        type: "POST",
        data: { date: picked.value, doctor_id: user_id },
        success: function(data) {
            $(".box").removeClass("busy");
            $(".check").prop("disabled", false);
            var time = new Date();
            var h = time.getHours();
            var m = time.getMinutes();
            var res = picked.value.split("/");

            if (res[0] == time.getDate()) {
                horas.forEach((hr) => {
                    if (h.toString().length == 1) {
                        th = "0" + h + ":" + m;
                    } else {
                        th = h + ":" + m;
                    }
                    if (th > hr) {
                        //  $("div[id='" + hr + "']").addClass("busy");
                        // $("input[id='" + hr + "']").prop("disabled", true);
                    }
                });
                horas2.forEach((hr) => {
                    if (h.toString().length == 1) {
                        th = "0" + h + ":" + m;
                    } else {
                        th = h + ":" + m;
                    }
                    if (th > hr) {
                        //$("div[id='" + hr + "']").addClass("busy");
                        //$("input[id='" + hr + "']").prop("disabled", true);
                    }
                });
            }
            data.forEach((c) => {
                // $("div[id='" + c.time + "']").addClass("busy");
                // $("input[id='" + c.time + "']").prop("disabled", true);
            });
        },
        error: function(jqXHR, textStatus, errorThrown) {},
    });
}
$(".itemName").select2();

$(document).ready(function() {
    $("input[name='patient_type']").click(function() {
        if ($("#exist").is(":checked")) {
            $("#is_exist").show(500);
            $("#first_name").hide(500);
            $("#second_name").hide(500);
            $("#last_name").hide(500);
            $("#second_last_name").hide(500);
            $("#phone").hide(500);
            $("#email").hide(500);
            $("#dpi").hide(500);
            $("#date_of_birth").hide(500);
            $("#whatsapp").hide(500);
            $("#gender").hide(500);
            $("#status").hide(500);
        } else {
            $("#is_exist").hide(500);
            $("#first_name").show(500);
            $("#second_name").show(500);
            $("#last_name").show(500);
            $("#second_last_name").show(500);
            $("#phone").show(500);
            $("#email").show(500);
            $("#dpi").show(500);
            $("#date_of_birth").show(500);
            $("#whatsapp").show(500);
            $("#gender").show(500);
            $("#status").show(500);
        }
    });

    function cuiIsValid(cui) {
        var console = window.console;
        if (!cui) {
            console.log("CUI vacío");
            return true;
        }

        var cuiRegExp = /^[0-9]{4}\s?[0-9]{5}\s?[0-9]{4}$/;

        if (!cuiRegExp.test(cui)) {
            console.log("CUI con formato inválido");
            return false;
        }

        cui = cui.replace(/\s/, "");
        var depto = parseInt(cui.substring(9, 11), 10);
        var muni = parseInt(cui.substring(11, 13));
        var numero = cui.substring(0, 8);
        var verificador = parseInt(cui.substring(8, 9));
        var munisPorDepto = [
            /* 01 - Guatemala tiene:      */
            17 /* municipios. */ /* 02 - El Progreso tiene:    */ , 8 /* municipios. */ /* 03 - Sacatepéquez tiene:   */ ,
            16 /* municipios. */ /* 04 - Chimaltenango tiene:  */ ,
            16 /* municipios. */ /* 05 - Escuintla tiene:      */ ,
            13 /* municipios. */ /* 06 - Santa Rosa tiene:     */ ,
            14 /* municipios. */ /* 07 - Sololá tiene:         */ ,
            19 /* municipios. */ /* 08 - Totonicapán tiene:    */ ,
            8 /* municipios. */ /* 09 - Quetzaltenango tiene: */ ,
            24 /* municipios. */ /* 10 - Suchitepéquez tiene:  */ ,
            21 /* municipios. */ /* 11 - Retalhuleu tiene:     */ ,
            9 /* municipios. */ /* 12 - San Marcos tiene:     */ ,
            30 /* municipios. */ /* 13 - Huehuetenango tiene:  */ ,
            32 /* municipios. */ /* 14 - Quiché tiene:         */ ,
            21 /* municipios. */ /* 15 - Baja Verapaz tiene:   */ ,
            8 /* municipios. */ /* 16 - Alta Verapaz tiene:   */ ,
            17 /* municipios. */ /* 17 - Petén tiene:          */ ,
            14 /* municipios. */ /* 18 - Izabal tiene:         */ ,
            5 /* municipios. */ /* 19 - Zacapa tiene:         */ ,
            11 /* municipios. */ /* 20 - Chiquimula tiene:     */ ,
            11 /* municipios. */ /* 21 - Jalapa tiene:         */ ,
            7 /* municipios. */ /* 22 - Jutiapa tiene:        */ ,
            17 /* municipios. */ ,
        ];
        if (depto === 0 || muni === 0) {
            return false;
        }
        if (depto > munisPorDepto.length) {
            return false;
        }
        if (muni > munisPorDepto[depto - 1]) {
            return false;
        }
        var total = 0;
        for (var i = 0; i < numero.length; i++) {
            total += numero[i] * (i + 2);
        }
        var modulo = total % 11;
        return modulo === verificador;
    }


});
window.addEventListener("load", function() {
    vanillaCalendar.init({
        disablePastDays: true,
    });
});