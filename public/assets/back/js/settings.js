    $(".picker").colorPick({
        'initialColor' : initialColor,
        'palette': ["#089bab", "#fead55", "#f36b7f", "#6b86f3", "#3734a9", "#0044e9", "#0d4290", "#fd4f57", "#a01a7a", "#232a3b"],
        'onColorSelected': function() {
            $("#theme").val(this.color);
            this.element.css({'backgroundColor': this.color, 'color': this.color});
        }
    });
    var show =  false
    function dataModule (){ 
        if(!show){
            $("#modules").show('500'); 
            show = true;
        }else{
            $("#modules").hide('500'); 
            show = false;
        } 
    }
    
    function downloadData()
    {
        var status = stats;
        var d =  { 
            mod_appointments: $('#mod_appointments').val(), 
            mod_patients: $('#mod_patients').val(), 
            mod_doctors: $('#mod_doctors').val(), 
            mod_staff: $('#mod_staff').val(), 
            mod_egresos: $('#mod_egresos').val(), 
            mod_ingresos: $('#mod_ingresos').val(), 
        };
        if(status==0){
            Swal.fire({
                title: '¿Desea solicitar toda su información?',
                text: "Este proceso puede tomar de 4 a 7 dias habiles.",
                type: 'info',
                showCancelButton: true,
                confirmButtonColor: '#9fd13b',
                cancelButtonColor: '#fd4f57',
                confirmButtonText: 'Sí, continuar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        type:"POST",
                        url: baseURL+"doctor/solicite_data",
                        data: d,
                        success:function (data) 
                        {
                            console.log(data);
                            const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-right',
                            showConfirmButton: false,
                            timer: 5000
                        }); 
                        Toast.fire({
                            type: 'success',
                            title: 'La solicitud ha sido enviada correctamente'
                        });
                        },error:function(jqXHR, textStatus, errorThrown)
                        {
                            //console.log('error: '+ errorThrown);
                        }
                    });
                }
            });
            }else
            {
                Swal.fire({
                    title: 'La solicitud ya fue enviada',
                    text: "Este proceso puede tomar de 4 a 7 dias habiles, te contactaremos para confirmar el envio de la información.",
                    type: 'info',
                    showCancelButton: false,
                });
            }
        };
        $('.app-email-w').toggleClass('compact-side-menu');
            $('.ae-side-menu-toggler').on('click', function () {
            $('.app-email-w').toggleClass('compact-side-menu');
        });
    
        $('[name="mod_appointments"]').change(function()
        {
            if ($(this).is(':checked')) {
                $('#mod_appointments').val(1);
            }else{
                $('#mod_appointments').val(0);
            };
        });
        $('[name="mod_patients"]').change(function()
        {
            if ($(this).is(':checked')) {
                $('#mod_patients').val(1);
            }else{
                $('#mod_patients').val(0);
            };
        });
            
        $('[name="mod_doctors"]').change(function()
        {
            if ($(this).is(':checked')) {
                $('#mod_doctors').val(1);
            }else{
                $('#mod_doctors').val(0);
            };
        });
        
        $('[name="mod_staff"]').change(function()
        {
            if ($(this).is(':checked')) {
                $('#mod_staff').val(1);
            }else{
                $('#mod_staff').val(0);
            };
        });
        $('[name="mod_egresos"]').change(function()
        {
            if ($(this).is(':checked')) {
                $('#mod_egresos').val(1);
            }else{
                $('#mod_egresos').val(0);
            };
        });
        $('[name="mod_ingresos"]').change(function()
        {
            if ($(this).is(':checked')) {
                $('#mod_ingresos').val(1);
            }else{
                $('#mod_ingresos').val(0);
            };
        });
        $("#modules").hide();   
        $('[name="send_survey"]').change(function()
        {
            if ($(this).is(':checked')) {
                $("#send_survey").show('500');
                $("#survey_id").attr("required", true);
            }else{
                $("#send_survey").hide('500');
                $("#survey_id").attr("required", false);
            };
        });
        $('[name="send_schedule"]').change(function()
        {
            if ($(this).is(':checked')) {
                $("#send_schedule").show('500');
                $("#hour").attr("required", true);
            }else{
                $("#send_schedule").hide('500');
                $("#hour").attr("required", true);
            };
        });
            
        $('[name="send_reminder"]').change(function()
        {
            if ($(this).is(':checked')) {
                $("#send_reminder").show('500');
                $("#reminder").attr("required", true);
            }else{
                $("#send_reminder").hide('500');
                $("#reminder").attr("required", false);
            };
        });
            
        function close_sessions()
        {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "Se cerrarán todas las sesiones abiertas en tus dispositivos, puede que alguna información no se guarde durante este proceso. ¿Aún así, desea continuar?",
                type: 'info',
                showCancelButton: true,
                confirmButtonColor: '#9fd13b',
                cancelButtonColor: '#fd4f57',
                confirmButtonText: 'Sí, continuar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.value) 
                {
                    location.href = baseURL+"doctor/settings/sessions/";
                }
            })
        }
        
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#imagePreview').css('background-image', 'url('+e.target.result +')');
                $('#imagePreview').hide();
                $('#imagePreview').fadeIn(650);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#imageUpload").change(function() {
        readURL(this);
    });