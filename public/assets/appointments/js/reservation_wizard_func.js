jQuery(function($) {
    "use strict";


    $("#wizard_container").wizard({

        stepsWrapper: "#wrapped",
        submit: ".submit",
        beforeForward: function(event, state) {

            if (state.stepIndex === 2) {


                console.log($(".appointment_date").val());

                if ($(".appointment_date").val() != "") {

                    return true;
                } else {
                    Swal.fire({
                        title: 'ATENCION',
                        text: "Debe seleccionar una fecha.",
                        type: 'info',
                    });
                    return false;

                }

            } else if (state.stepIndex === 3) {



                if ($("#check").val() != "0") {

                    return true;
                } else {
                    Swal.fire({
                        title: 'ATENCION',
                        text: "Debe seleccionar una hora.",
                        type: 'info',
                    });
                    return false;

                }

            } else if (state.stepIndex === 4) {
                var error = 0;
                var patient = $('select[name ="patient_id"]').val();
                var nuevo = $('input[name ="patient_type"]').val();
                var first_name = $('input[name ="first_name"]').val();
                var last_name = $('input[name ="last_name"]').val();
                var phone = $('input[name ="phone"]').val();
                var email = $('input[name ="email"]').val();
                var date_of_birth = $('input[name ="date_of_birth"]').val();
                var gender = $('input[name ="gender"]').val();
                var status = $('input[name ="status"]').val();
                var dpi = $('input[name ="dpi"]').val();


                console.log(nuevo)


                if (nuevo == 0) {
                    //validar telefono
                    console.log(patient);
                    if (patient == "") {
                        error++;

                        $('#errorpat').removeClass('error');
                        $('#errorpat').removeClass('error_show');
                        $('#errorpat').removeClass('success_show');

                        $('#errorpat').text('Debe selecionar un paciente').addClass('error').animate({}, 300);

                        return false
                    } else {


                        $('#errorpat').removeClass('error');
                        $('#errorpat').removeClass('error_show');
                        $('#errorpat').removeClass('success_show');
                        $('#errorpat').text('');
                        return true

                    }


                }

                if (nuevo == 1) {

                    //validar nombre
                    if (first_name == "") {



                        $('#errorn').removeClass('error');
                        $('#errorn').removeClass('error_show');
                        $('#errorn').removeClass('success_show');

                        $('#errorn').text('Debe ingresar un nombre').addClass('error').animate({}, 300);

                        error++;
                    } else {


                        $('#errorn').removeClass('error');
                        $('#errorn').removeClass('error_show');
                        $('#errorn').removeClass('success_show');
                        $('#errorn').text('');

                    }


                    //validar apellido
                    if (last_name == "") {



                        $('#errorl').removeClass('error');
                        $('#errorl').removeClass('error_show');
                        $('#errorl').removeClass('success_show');

                        $('#errorl').text('Debe ingresar un nombre').addClass('error').animate({}, 300);

                        error++;
                    } else {


                        $('#errorl').removeClass('error');
                        $('#errorl').removeClass('error_show');
                        $('#errorl').removeClass('success_show');
                        $('#errorl').text('');

                    }


                    //validar dpi

                    if (dpi.length != '13' || dpi == "") {
                        error++;

                        $('#errordpi').removeClass('error');
                        $('#errordpi').removeClass('error_show');
                        $('#errordpi').removeClass('success');

                        $('#errordpi').text('no es un dpi valido').addClass('error').animate({}, 300);


                    } else {


                        $('#errordpi').removeClass('error');
                        $('#errordpi').removeClass('error_show');
                        $('#errordpi').removeClass('success');
                        $('#errordpi').text('');

                    }





                    //validar correo electronico
                    var validacion_email = /^[a-zA-Z0-9_\.\-]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$/;

                    if (!validacion_email.test(email)) {
                        error++;

                        $('#errorm').removeClass('error');
                        $('#errorm').removeClass('error_show');
                        $('#errorm').removeClass('success');

                        $('#errorm').text('correo electronico no valido').addClass('error').animate({}, 300);

                    } else {


                        $('#errorm').removeClass('error');
                        $('#errorm').removeClass('error_show');
                        $('#errorm').removeClass('success');
                        $('#errorm').text('');

                    }




                    if (error > 0)
                        return false
                    else
                        return true


                }

            }

        }
    }).validate({
        errorPlacement: function(error, element) {
            if (element.is(':radio') || element.is(':checkbox')) {
                error.insertBefore(element.next());
            } else {
                error.insertAfter(element);
            }
        }
    });

    //  progress bar
    $("#progressbar").progressbar();
    $("#wizard_container").wizard({
        afterSelect: function(event, state) {
            $("#progressbar").progressbar("value", state.percentComplete);
            $("#location").text("(" + state.stepsComplete + "/" + state.stepsPossible + ")");


        }
    });




    $("#wizard_container_staff").wizard({

        stepsWrapper: "#wrapped",
        submit: ".submit",
        beforeForward: function(event, state) {

            if (state.stepIndex === 3) {


                console.log($(".appointment_date").val());

                if ($(".appointment_date").val() != "") {

                    return true;
                } else {
                    Swal.fire({
                        title: 'ATENCION',
                        text: "Debe seleccionar una fecha.",
                        type: 'info',
                    });
                    return false;

                }

            } else if (state.stepIndex === 4) {



                if ($("#check").val() != "0") {

                    return true;
                } else {
                    Swal.fire({
                        title: 'ATENCION',
                        text: "Debe seleccionar una hora.",
                        type: 'info',
                    });
                    return false;

                }

            } else if (state.stepIndex === 5) {
                var error = 0;
                var patient = $('select[name ="patient_id"]').val();
                var nuevo = $('input[name ="patient_type"]').val();
                var first_name = $('input[name ="first_name"]').val();
                var last_name = $('input[name ="last_name"]').val();
                var phone = $('input[name ="phone"]').val();
                var email = $('input[name ="email"]').val();
                var date_of_birth = $('input[name ="date_of_birth"]').val();
                var gender = $('input[name ="gender"]').val();
                var status = $('input[name ="status"]').val();
                var dpi = $('input[name ="dpi"]').val();


                console.log(nuevo)


                if (nuevo == 0) {
                    //validar telefono
                    console.log(patient);
                    if (patient == "") {
                        error++;

                        $('#errorpat').removeClass('error');
                        $('#errorpat').removeClass('error_show');
                        $('#errorpat').removeClass('success_show');

                        $('#errorpat').text('Debe selecionar un paciente').addClass('error').animate({}, 300);

                        return false
                    } else {


                        $('#errorpat').removeClass('error');
                        $('#errorpat').removeClass('error_show');
                        $('#errorpat').removeClass('success_show');

                        return true

                    }


                }

                if (nuevo == 1) {

                    //validar nombre
                    if (first_name == "") {



                        $('#errorn').removeClass('error');
                        $('#errorn').removeClass('error_show');
                        $('#errorn').removeClass('success_show');

                        $('#errorn').text('Debe ingresar un nombre').addClass('error').animate({}, 300);

                        error++;
                    } else {


                        $('#errorn').removeClass('error');
                        $('#errorn').removeClass('error_show');
                        $('#errorn').removeClass('success_show');


                    }


                    //validar apellido
                    if (last_name == "") {



                        $('#errorl').removeClass('error');
                        $('#errorl').removeClass('error_show');
                        $('#errorl').removeClass('success_show');

                        $('#errorl').text('Debe ingresar un nombre').addClass('error').animate({}, 300);

                        error++;
                    } else {


                        $('#errorl').removeClass('error');
                        $('#errorl').removeClass('error_show');
                        $('#errorl').removeClass('success_show');


                    }



                    if (error > 0)
                        return false
                    else
                        return true


                }

            }

        }
    }).validate({
        errorPlacement: function(error, element) {
            if (element.is(':radio') || element.is(':checkbox')) {
                error.insertBefore(element.next());
            } else {
                error.insertAfter(element);
            }
        }
    });

    //  progress bar
    $("#progressbar").progressbar();
    $("#wizard_container_staff").wizard({
        afterSelect: function(event, state) {
            $("#progressbar").progressbar("value", state.percentComplete);
            $("#location").text("(" + state.stepsComplete + "/" + state.stepsPossible + ")");


        }
    });



});