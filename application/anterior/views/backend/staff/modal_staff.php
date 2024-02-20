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


span.success {
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
    background-color: green;
    color: #fff;
    font-weight: normal;
    display: inline-block;
    padding: 6px 8px;
}


span.success:after {
    content: '';
    position: absolute;
    border-style: solid;
    border-width: 0 6px 6px 0;
    border-color: transparent green;
    display: block;
    width: 0;
    z-index: 1;
    bottom: -6px;
    left: 20%;
}
</style>
<link href="https://anton.miaula.com.gt/assets/theme/css/bootstrap-clockpicker.min.css" rel="stylesheet">
<link href="<?php echo base_url();?>style/appointments/css/select2.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<script src="https://dentalstudio.com.gt/app/style/back/js/datepicker.js"></script>
<?php
        $this->db->where('staff_id', $param2);
        $staff = $this->db->get('staff')->result_array();
        foreach($staff as $row):
    ?>
<div class="modal-content animated fadeInDown" style="border-radius:20px;">
    <div class="modal-header" style="background-color:#fff;border-radius:20px;">
        <h4 style="font-size:21px; color:#565b6b; font-family:'Poppins';">
            <span style="vertical-align:-3px">Actualizar usuario</span>
        </h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
    </div>
    <form action="<?php echo base_url();?>staff/staff/update/<?php echo $row['staff_id'];?>" method="POST" enctype="multipart/form-data" id="staffUpdate">
        <input type="hidden" name="category" value="<?php echo $param2?>">
        <div class="modal-body" style="background-color:#f1f3f7;">
            <div class="form-group">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group m-b-15">
                                <label for="simpleinput">Primer Nombre<span style="color:red">*</span></label>
                                <input type="text" name="first_name" required="" value="<?php echo $row['first_name'];?>" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group m-b-15">
                                <label for="simpleinput">Segundo Nombre</label>
                                <input type="text" name="second_name" value="<?php echo $row['second_name'];?>" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group m-b-15">
                                <label for="simpleinput">Tercer Nombre</label>
                                <input type="text" name="third_name" value="<?php echo $row['third_name'];?>" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group m-b-15">
                                <label for="simpleinput">Primer Apellido<span style="color:red">*</span></label>
                                <input type="text" name="last_name" required="" value="<?php echo $row['last_name'];?>" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group m-b-15">
                                <label for="simpleinput">Segundo Apellido</label>
                                <input type="text" name="second_last_name" value="<?php echo $row['second_last_name'];?>" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group m-b-15">
                                <label for="simpleinput">Apellido de casada</label>
                                <input type="text" name="married_last_name" value="<?php echo $row['married_last_name'];?>" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group date-time-picker m-b-15">
                                <label for="simpleinvput">Nacimiento<span style="color:red">*</span></label>
                                <div class="input-group date " id="">
                                    <input type="date" required="" name="date_of_birth" value="<?php echo $row['date_of_birth'];?>" class="form-control"><span class="input-group-addon"><i data-feather="calendar"></i></span>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <div class="form-group m-b-15">
                                <label for="simpleinput">Identificación<span style="color:red">*</span></label> <span class="" id="errordpi"></span>
                                <input type="number" name="dpi" id="dpi" required="" value="<?php echo $row['dpi'];?>" onkeyup="validateDPI(this.value);" class="form-control">

                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group m-b-15">
                                <label for="simpleinput">Celular<span style="color:red">*</span></label>
                                <input type="text" name="phone" required="" value="<?php echo $row['phone'];?>" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group m-b-15">
                                <label for="simpleinput">Correo<span style="color:red">*</span></label> <span class="" id="errorm"></span>
                                <input type="email" name="email" id="email" required="" value="<?php echo $row['email'];?>" onkeyup="validateEmail();" class="form-control">

                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group m-b-15">
                                <label for="simpleinput">Chargo<span style="color:red">*</span></label>
                                <input type="text" name="charge" value="<?php echo $row['charge'];?>" class="form-control">
                            </div>

                        </div>
                        <div class="col-sm-4">
                            <div class="form-group m-b-15">
                                <label for="simpleinput">Salario<span style="color:red">*</span></label>


                                <div class="row">
                                    <div class="col-sm-1" style="font-size:25px">
                                        Q.
                                    </div>
                                    <div class="col-sm-10">
                                        <input type="number" name="salary" value="<?php echo $row['salary'] ?>" class="form-control">
                                    </div>


                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Género:</label>
                                <div class="input-group">
                                    <div class="form-check" style="padding-left: 0px;padding-right:2px">
                                        <input checked class="radiobutton" type="radio" name="gender" <?php if($row['gender'] == "M") echo "checked";?> id="radio3" value="M">
                                        <label class="radiobutton-label" for="radio3">Masculino</label>
                                    </div>
                                    <div class="form-check" style="padding-left: 0px;">
                                        <input class="radiobutton" type="radio" name="gender" <?php if($row['gender'] == "F") echo "checked";?> id="radio4" value="F">
                                        <label class="radiobutton-label" for="radio4">Femenino</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <label>Redes sociales</label>
                            <div class="row">

                                <div class="col-sm-5">
                                    <div class="col-sm-12">
                                        <div class="form-group m-b-15">
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox mr-sm-2">
                                                    <input type="checkbox" id="invc" name="Facebook" <?php if($row['facebook'] != '') echo 'checked';?> value="1" class="custom-control-input check">
                                                    <label class="custom-control-label" for="invc">Facebook</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12" id="fb">
                                        <div class="form-group m-b-15">
                                            <label for="simpleinput">Ingrese link de Facebook</label></label>
                                            <div class="form-group">
                                                <input style="border: 1px solid #198cff8f;" type="text" name="link_facebook" value="<?php echo $row['facebook'];?>" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-5">
                                    <div class="col-sm-12">
                                        <div class="form-group m-b-15">
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox mr-sm-2">
                                                    <input style="border: 1px solid #198cff8f;" <?php if($row['instagram'] != '') echo 'checked';?> type="checkbox" id="invc3" name="Instagram" value="1" class="custom-control-input check">
                                                    <label class="custom-control-label" for="invc3">Instagram</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12" id="Ig">
                                        <div class="form-group m-b-15">
                                            <label for="simpleinput">Ingrese link de Instagram</label></label>
                                            <div class="form-group">
                                                <input style="border: 1px solid #198cff8f;" type="text" name="link_instagram" value="<?php echo $row['instagram'];?>" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-2">
                                    <div class="col-sm-12">
                                        <div class="form-group m-b-15">
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox mr-sm-2">
                                                    <input type="checkbox" id="invc2" name="Whatsapp" <?php if($row['whatsapp'] == 1) echo 'checked';?> value="1" class="custom-control-input check">
                                                    <label class="custom-control-label" for="invc2">WhatsApp</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group m-b-15">
                                <label for="simpleinput">Dirección</label>
                                <textarea type="text" name="address" class="form-control"><?php echo $row['address'];?></textarea>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group m-b-15">
                                <label for="simpleinput">Fotografía</label>
                                <input type="file" name="photo" class="form-control">
                            </div>
                        </div>


                        <div class="col-sm-12">
                            <label>¿Modulos a los que tendra acceso?</label>
                            <div class="row">


                                <div class="col-sm-2">
                                    <div class="form-group m-b-15">
                                        <label style="font-size:9px;">¿Podra dar permisos?</label>
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="modulos1" name="moduls" value="1" <?php if($row['panel'] == 1) echo "checked";?> class="custom-control-input">
                                            <label class="custom-control-label" for="modulos1">Si</label>
                                        </div>
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="modulosno1" name="moduls" value="0" <?php if($row['panel'] == 0) echo "checked";?> class="custom-control-input">
                                            <label class="custom-control-label" for="modulosno1">No</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-2">
                                    <div class="form-group m-b-15">
                                        <label>Tablero</label>
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="panel1" name="panel" value="1" <?php if($row['panel'] == 1) echo "checked";?> class="custom-control-input">
                                            <label class="custom-control-label" for="panel1">Si</label>
                                        </div>
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="panelno1" name="panel" value="0" <?php if($row['panel'] == 0) echo "checked";?> class="custom-control-input">
                                            <label class="custom-control-label" for="panelno1">No</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-2">
                                    <div class="form-group m-b-15">
                                        <label>Chat</label>
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="chat1" name="chat" value="1" <?php if($row['chat'] == 1) echo "checked";?> class="custom-control-input">
                                            <label class="custom-control-label" for="chat1">Si</label>
                                        </div>
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="chatno1" name="chat" value="0" <?php if($row['chat'] == 0) echo "checked";?> class="custom-control-input">
                                            <label class="custom-control-label" for="chatno1">No</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-2">
                                    <div class="form-group m-b-15">
                                        <label>Cirugias</label>
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="appointments1" name="appointments" value="1" <?php if($row['appointments'] == 1) echo "checked";?> class="custom-control-input">
                                            <label class="custom-control-label" for="appointments1">Si</label>
                                        </div>
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="appointmentsno1" name="appointments" value="0" <?php if($row['appointments'] == 0) echo "checked";?> class="custom-control-input">
                                            <label class="custom-control-label" for="appointmentsno1">No</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-2">
                                    <div class="form-group m-b-15">
                                        <label>Pacientes</label>
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="patients1" name="patients" value="1" <?php if($row['patients'] == 1) echo "checked";?> class="custom-control-input">
                                            <label class="custom-control-label" for="patients1">Si</label>
                                        </div>
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="patientsno1" name="patients" value="0" <?php if($row['patients'] == 0) echo "checked";?> class="custom-control-input">
                                            <label class="custom-control-label" for="patientsno1">No</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-2">
                                    <div class="form-group m-b-15">
                                        <label>Doctores</label>
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="doctors1" name="doctors" value="1" <?php if($row['doctors'] == 1) echo "checked";?> class="custom-control-input">
                                            <label class="custom-control-label" for="doctors1">Si</label>
                                        </div>
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="doctorsno1" name="doctors" value="0" <?php if($row['doctors'] == 0) echo "checked";?> class="custom-control-input">
                                            <label class="custom-control-label" for="doctorsno1">No</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-2">
                                    <div class="form-group m-b-15">
                                        <label>Equipo</label>
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="staff1" name="staff" value="1" <?php if($row['staff'] == 1) echo "checked";?> class="custom-control-input">
                                            <label class="custom-control-label" for="staff1">Si</label>
                                        </div>
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="staffno1" name="staff" value="0" <?php if($row['staff'] == 0) echo "checked";?> class="custom-control-input">
                                            <label class="custom-control-label" for="staffno1">No</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-2">
                                    <div class="form-group m-b-15">
                                        <label>Inventario</label>
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="inventory1" name="inventory" value="1" <?php if($row['inventory'] == 1) echo "checked";?> class="custom-control-input">
                                            <label class="custom-control-label" for="inventory1">Si</label>
                                        </div>
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="inventoryno1" name="inventory" value="0" <?php if($row['inventory'] == 0) echo "checked";?> class="custom-control-input">
                                            <label class="custom-control-label" for="inventoryno1">No</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-2">
                                    <div class="form-group m-b-15">
                                        <label>Finanzas</label>
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="financial1" name="financial" value="1" <?php if($row['financial'] == 1) echo "checked";?> class="custom-control-input">
                                            <label class="custom-control-label" for="financial1">Si</label>
                                        </div>
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="financialno1" name="financial" value="0" <?php if($row['financial'] == 0) echo "checked";?> class="custom-control-input">
                                            <label class="custom-control-label" for="financialno1">No</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-2">
                                    <div class="form-group m-b-15">
                                        <label>Reportes</label>
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="reports1" name="reports" value="1" <?php if($row['reports'] == 1) echo "checked";?> class="custom-control-input">
                                            <label class="custom-control-label" for="reports1">Si</label>
                                        </div>
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="reportsno1" name="reports" value="0" <?php if($row['reports'] == 0) echo "checked";?> class="custom-control-input">
                                            <label class="custom-control-label" for="reportsno1">No</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-2">
                                    <div class="form-group m-b-15">
                                        <label>Configuración</label>
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="settings1" name="settings" value="1" <?php if($row['settings'] == 1) echo "checked";?> class="custom-control-input">
                                            <label class="custom-control-label" for="settings1">Si</label>
                                        </div>
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="settingsno1" name="settings" value="0" <?php if($row['settings'] == 0) echo "checked";?> class="custom-control-input">
                                            <label class="custom-control-label" for="settingsno1">No</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="button-confirm">Actualizar</button>
        </div>
    </form>
</div>

<script type="text/javascript">
<?php if($row['facebook'] == ''):?>
$('#fb').hide();
<?php endif;?>
<?php if($row['instagram'] == ''):?>
$('#Ig').hide();
<?php endif;?>
$(function() {
    $('[name="Facebook"]').change(function() {
        if ($(this).is(':checked')) {
            $('#fb').show(500);
        } else {
            $('#fb').hide(500);
        };
    });
});

$(function() {
    $('[name="Instagram"]').change(function() {
        if ($(this).is(':checked')) {
            $('#Ig').show(500);
        } else {
            $('#Ig').hide(500);
        };
    });
});
</script>
<?php endforeach;?>

<link href="https://anton.miaula.com.gt/assets/theme/input/jquery.fileuploader.min.css" media="all" rel="stylesheet">
<link href="http://educaby.com/work/style/input/font-fileuploader.css" rel="stylesheet">
<script src="http://educaby.com/work/style/input/jquery.fileuploader.min.js" type="text/javascript"></script>

<script>
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

        $.ajax({
            type: "POST",
            url: "https://medicaby.com/staff/check_m",
            data: {
                'mail': email
            },
            success: function(data) {

                console.log(data.available);
                if (data.available > 0) {

                    $('#errorm').removeClass('error');
                    $('#errorm').removeClass('error_show');
                    $('#errorm').removeClass('success');
                    $('#errorm').text('correo electronico no disponible').addClass('error').animate({}, 300);
                    $('input[name ="email"]')[0].setCustomValidity('correo electronico no disponible');

                } else {
                    $('#errorm').removeClass('error');
                    $('#errorm').removeClass('error_show');
                    $('#errorm').removeClass('success_show');

                    $('#errorm').text('Este correo esta disponible').addClass('success').animate({}, 300);
                    $('input[name ="email"]')[0].setCustomValidity('');
                }

            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log('error: ' + errorThrown);
            }

        });




    }
};
$(document).ready(function() {
    $('input[name="photo"]').fileuploader({
        theme: 'default',
    });
});
</script>