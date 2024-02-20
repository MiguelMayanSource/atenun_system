<div class="modal-content animated fadeInDown">
    <form id="formNewPat" action="<?php echo base_url();?>staff/clients/create" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="client_status" value="1" />
        <div class="modal-header" style="background-color:#fff;box-shadow: 0 4px 2px -2px 000;">
            <h4 style="font-size:21px; color:#565b6b; font-family:'Poppins';"><span style="vertical-align:-3px"> <i class="batch-icon-user-2-add"></i> Agregar nuevo cliente.</span></h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <div class="container">
                    <div class="row"> 
                        <div class="col-sm-3">
                            <div class="form-group m-b-15">
                                <label for="simpleinput"><span style="color:red">*</span> Primer Nombre</label>
                                <input type="text" name="first_name" required="" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group m-b-15"> 
                                <label for="simpleinput">Segundo nombre</label> 
                                <input type="text" name="second_name" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group m-b-15">
                                <label for="simpleinput">Primer apelldio</label>
                                <input type="text" name="last_name" class="form-control">
                            </div>
                        </div>
                        
                        <div class="col-sm-3">
                            <div class="form-group m-b-15">
                                <label for="simpleinput">Segundo apellido</label>
                                <input type="text" name="second_last_name" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group m-b-15">
                                <label for="simpleinput"> Identificación<span class="" id="errordpi"></span></label>
                                <input type="number" name="dpi" maxlength="13" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" class="form-control" onkeyup="validateDPI(this.value);">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group m-b-15">
                                <label for="simpleinput"> NIT<span class="" ></span></label>
                                <input type="text" name="nit" maxlength="13"  class="form-control" >
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group m-b-15">
                                <label for="simpleinput">Correo <span class="" id="errorm"></span></label>
                                <input type="email" name="email" class="form-control" onkeyup="validateEmail();">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group m-b-15">
                                <label for="simpleinput"><span style="color:red">*</span> Número de teléfono
                                    celular</label>
                                <input type="number" maxlength="15" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" name="phone" required="" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group m-b-15">
                                <label for="simpleinput">Número de teléfono de contacto</label>
                                <input type="number" name="phone_contact" maxlength="15" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group m-b-15">
                                <label for="simpleinput">Dirección</label>
                                <textarea type="text" name="address" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="button-confirm">Enviar</button>
        </div>
    </form>
</div>
<script type="text/javascript">
document.getElementById('apply').onchange = function() {
    var filename = this.value.replace(/C:\\fakepath\\/i, '')
    $("#fileResponse").html('<b>Archivo seleccionado:</b> ' + filename);
};
$(function() {
    'use strict';
    if ($('#DoctorPicker1').length) {
        var date = new Date();
        var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
        $('#DoctorPicker1').datepicker({
            format: "dd/mm/yyyy",
            todayHighlight: true,
            autoclose: true
        });
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

    cui = cui.replace(/\s/, '');
    var depto = parseInt(cui.substring(9, 11), 10);
    var muni = parseInt(cui.substring(11, 13));
    var numero = cui.substring(0, 8);
    var verificador = parseInt(cui.substring(8, 9));

    // Se asume que la codificación de Municipios y 
    // departamentos es la misma que esta publicada en 
    // http://goo.gl/EsxN1a

    // Listado de municipios actualizado segun:
    // http://goo.gl/QLNglm

    // Este listado contiene la cantidad de municipios
    // existentes en cada departamento para poder 
    // determinar el código máximo aceptado por cada 
    // uno de los departamentos.
    var munisPorDepto = [
        /* 01 - Guatemala tiene:      */
        17 /* municipios. */ ,
        /* 02 - El Progreso tiene:    */
        8 /* municipios. */ ,
        /* 03 - Sacatepéquez tiene:   */
        16 /* municipios. */ ,
        /* 04 - Chimaltenango tiene:  */
        16 /* municipios. */ ,
        /* 05 - Escuintla tiene:      */
        13 /* municipios. */ ,
        /* 06 - Santa Rosa tiene:     */
        14 /* municipios. */ ,
        /* 07 - Sololá tiene:         */
        19 /* municipios. */ ,
        /* 08 - Totonicapán tiene:    */
        8 /* municipios. */ ,
        /* 09 - Quetzaltenango tiene: */
        24 /* municipios. */ ,
        /* 10 - Suchitepéquez tiene:  */
        21 /* municipios. */ ,
        /* 11 - Retalhuleu tiene:     */
        9 /* municipios. */ ,
        /* 12 - San Marcos tiene:     */
        30 /* municipios. */ ,
        /* 13 - Huehuetenango tiene:  */
        32 /* municipios. */ ,
        /* 14 - Quiché tiene:         */
        21 /* municipios. */ ,
        /* 15 - Baja Verapaz tiene:   */
        8 /* municipios. */ ,
        /* 16 - Alta Verapaz tiene:   */
        17 /* municipios. */ ,
        /* 17 - Petén tiene:          */
        14 /* municipios. */ ,
        /* 18 - Izabal tiene:         */
        5 /* municipios. */ ,
        /* 19 - Zacapa tiene:         */
        11 /* municipios. */ ,
        /* 20 - Chiquimula tiene:     */
        11 /* municipios. */ ,
        /* 21 - Jalapa tiene:         */
        7 /* municipios. */ ,
        /* 22 - Jutiapa tiene:        */
        17 /* municipios. */
    ];

    if (depto === 0 || muni === 0) {
        console.log("CUI con código de municipio o departamento inválido.");
        return false;
    }

    if (depto > munisPorDepto.length) {
        console.log("CUI con código de departamento inválido.");
        return false;
    }

    if (muni > munisPorDepto[depto - 1]) {
        console.log("CUI con código de municipio inválido.");
        return false;
    }

    // Se verifica el correlativo con base 
    // en el algoritmo del complemento 11.
    var total = 0;

    for (var i = 0; i < numero.length; i++) {
        total += numero[i] * (i + 2);
    }

    var modulo = (total % 11);

    console.log("CUI con módulo: " + modulo);
    return modulo === verificador;
};

function validateDPI(ddd) {
    var $this = $(this);
    var $parent = $this.parent();
    var $next = $this.next();
    var cui = ddd;



    if (cui && cuiIsValid(cui)) {



        $('#errordpi').removeClass('error');
        $('#errordpi').removeClass('error_show');
        $('#errordpi').removeClass('success');

        $('#errordpi').text('DPI valido').addClass('success').animate({}, 300);
        $('input[name ="dpi"]')[0].setCustomValidity('');

    } else if (cui) {



        $('#errordpi').removeClass('error');
        $('#errordpi').removeClass('error_show');
        $('#errordpi').removeClass('success');

        $('#errordpi').text('Debe ingresar un DPI').addClass('error').animate({}, 300);
        $('input[name ="dpi"]')[0].setCustomValidity('DPI no valido');

    } else {


        $('#errordpi').removeClass('error');
        $('#errordpi').removeClass('error_show');
        $('#errordpi').removeClass('success');

        $('#errordpi').text('DPI no valido').addClass('error').animate({}, 300);
        $('input[name ="dpi"]')[0].setCustomValidity('DPI no puede quedar vacio');



    }
};


//Validar correo electronico  
function validateEmail() {

    var email = $('input[name ="email"]').val();

    console.log(email);


    //validar correo electronico
    var validacion_email = /^[a-zA-Z0-9_\.\-]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$/;

    if (!validacion_email.test(email)) {


        $('#errorm').removeClass('error');
        $('#errorm').removeClass('error_show');
        $('#errorm').removeClass('success');

        $('#errorm').text('correo electronico no valido').addClass('error').animate({}, 300);
        $('input[name ="email"]')[0].setCustomValidity('correo no valido');

    } else {


        $('#errorm').removeClass('error');
        $('#errorm').removeClass('error_show');
        $('#errorm').removeClass('success');
        $('#errorm').text('correo electronico valido').addClass('success').animate({}, 300);
        $('input[name ="email"]')[0].setCustomValidity('');

    }
};







//validar DPI
</script>