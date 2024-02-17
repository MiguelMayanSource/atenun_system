<style>
.table.table-padded {
    border-collapse: separate;
    border-spacing: 0 5px;
}

.table.table-padded thead tr th {
    border: none;
    font-size: 0.81rem;
    color: rgba(90, 99, 126, 0.49);
    letter-spacing: 1px;
    padding: 0.3rem 1.1rem;
}

.table.table-padded tbody tr {
    border-radius: 4px;
    -webkit-transition: all 0.1s ease;
    transition: all 0.1s ease;
}

.table.table-padded tbody tr:hover {
    -webkit-box-shadow: 0px 2px 5px rgba(69, 101, 173, 0.1);
    box-shadow: 0px 2px 5px rgba(69, 101, 173, 0.1);
    -webkit-transform: translateY(-1px) scale(1.01);
    transform: translateY(-1px) scale(1.01);
}

.table.table-padded tbody td {
    padding: 0.9rem 1.1rem;
    background-color: #fff;
    border: none;
}

.table.table-padded tbody td.bolder {
    font-weight: 500;
    font-size: 0.99rem;
}

.table.table-padded tbody td img {
    display: inline-block;
    vertical-align: middle;
}

.table.table-padded tbody td img+span {
    display: inline-block;
    margin-left: 10px;
    vertical-align: middle;
}

.table.table-padded tbody td span+span {
    margin-left: 5px;
}

.table.table-padded tbody td .status-pill+span {
    margin-left: 10px;
}

.table.table-padded tbody td:first-child {
    border-radius: 14px 0px 0px 14px;
}

.table.table-padded tbody td:last-child {
    border-radius: 0px 14px 14px 0px;
    border-right: none;
}

.table.table-padded tbody tr:hover td {
    background: #667acd !important;
    color: #fff !important;
    -webkit-box-shadow: 0px 2px 14px rgba(102, 122, 205, 0.40);
    box-shadow: 0px 2px 14px rgba(102, 122, 205, 0.40);
}

.table.table-padded tbody tr:hover i {
    color: #fff !important;

}
</style>
<style>
.app-email-w a:focus,
.app-email-w a:hover {
    text-decoration: none;
}

.app-email-i {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-align: stretch;
    -ms-flex-align: stretch;
    align-items: stretch;
    border-radius: 6px;
}

.ae-side-menu {
    -webkit-box-flex: 0;
    -ms-flex: 0 0 200px;
    flex: 0 0 200px;
    min-height: 100vh;
    border-right: 1px solid rgba(0, 0, 0, 0.1);
    background-color: #fff;
}

.ae-side-menu .aem-head {
    padding: 10px 20px;
    height: 50px;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    border-bottom: 1px solid rgba(0, 0, 0, 0.1);
    font-size: 10px;
}

.ae-side-menu .ae-main-menu {
    list-style: none;
    padding: 0px;
    margin: 0px;
}

.ae-side-menu .ae-main-menu li {
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    position: relative;
}

.ae-side-menu .ae-main-menu li a {
    display: block;
    padding: 15px;
}

.ae-side-menu .ae-main-menu li a i {
    font-size: 20px;
    display: inline-block;
    vertical-align: middle;
    color: #000;
    -webkit-transition: all 0.2s ease;
    transition: all 0.2s ease;
}

.ae-side-menu .ae-main-menu li a span {
    margin-left: 7px;
    display: inline-block;
    vertical-align: middle;
    color: #000;
    font-weight: 500;
}

.ae-side-menu .ae-main-menu li:after {
    content: "";
    position: absolute;
    right: 0px;
    top: -1px;
    bottom: -1px;
    width: 5px;
    opacity: 0;
    background-color: #047bf8;
    -webkit-transition: all 0.3s ease;
    transition: all 0.3s ease;
}

.ae-side-menu .ae-main-menu li:hover a i {
    -webkit-transform: translateX(5px);
    transform: translateX(5px);
}

.ae-side-menu .ae-main-menu li:hover:after,
.ae-side-menu .ae-main-menu li.active:after {
    opacity: 1;
}

.ae-side-menu .ae-labels {
    margin-top: 20px;
}

.ae-side-menu .ae-labels .ae-labels-header {
    padding: 20px;
}

.ae-side-menu .ae-labels .ae-labels-header i {
    color: #000;
    font-size: 20px;
    vertical-align: middle;
    display: inline-block;
}

.ae-side-menu .ae-labels .ae-labels-header span {
    margin-left: 20px;
    font-weight: 500;
    vertical-align: middle;
    display: inline-block;
}

.ae-side-menu .ae-labels .ae-label {
    display: block;
    padding: 10px;
    padding-left: 30px;
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    position: relative;
    color: #000;
    white-space: nowrap;
}

.ae-side-menu .ae-labels .ae-label .label-pin {
    display: inline-block;
    width: 8px;
    height: 8px;
    border-radius: 10px;
    background-color: #047bf8;
    vertical-align: middle;
}

.ae-side-menu .ae-labels .ae-label .label-value {
    display: inline-block;
    vertical-align: middle;
    margin-left: 10px;
}

.ae-side-menu .ae-labels .ae-label:before {
    content: "";
    position: absolute;
    left: 10px;
    top: 50%;
    -webkit-transform: translateY(-50%);
    transform: translateY(-50%);
}

.ae-side-menu .ae-labels .ae-label.ae-label-red .label-pin {
    background-color: #e65252;
}

.ae-side-menu .ae-labels .ae-label.ae-label-green .label-pin {
    background-color: #99bf2d;
}

.ae-side-menu .ae-labels .ae-label.ae-label-yellow .label-pin {
    background-color: #fbe4a0;
}

/* #7. FOLDED STYLES */
.app-email-w.compact-side-menu .ae-side-menu {
    -webkit-box-flex: 0;
    -ms-flex: 0 1 60px;
    flex: 0 1 60px;
    text-align: center;
}

.app-email-w.compact-side-menu .ae-side-menu .aem-head {
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
}

.app-email-w.compact-side-menu .ae-side-menu .ae-main-menu li a span {
    display: none;
}

.app-email-w.compact-side-menu .ae-side-menu .ae-labels .ae-label {
    padding-left: 10px;
}

.app-email-w.compact-side-menu .ae-side-menu .ae-labels .ae-label span.label-value {
    display: none;
}

.app-email-w.compact-side-menu .ae-side-menu .ae-labels-header span {
    display: none;
}

.search_input {
    width: 230px;
    margin: 6px 20px 9px 10px;
    border-radius: 10px;
    border: 0;
    background: #f7f7f7;
    padding: 10px;
    outline: none;
}

.src i {
    position: absolute;
    font-size: 18px;
    top: 18px;
    left: 213px;
}

.icon_products {
    background: #ff5d81;
    padding: 5px;
    border-radius: 10px;
    color: #fff !important;
    text-align: center;
    height: 36px;
    font-size: 25px !important;
    width: 36px !important;
}

.icon_categories {
    background: #ffc55d;
    padding: 5px;
    text-align: center;
    border-radius: 10px;
    color: #fff !important;
    height: 36px;
    font-size: 25px !important;
    width: 36px !important;
}

.icon_sales {
    background: #ff905d;
    padding: 5px;
    text-align: center;
    height: 36px;
    border-radius: 10px;
    color: #fff !important;
    font-size: 25px !important;
    width: 36px !important;
}

.icon_new_sale {
    background: #667acd;
    padding: 5px;
    text-align: center;
    border-radius: 10px;
    height: 36px;
    color: #fff !important;
    font-size: 25px !important;
    width: 36px !important;
}

.ae-content-w {
    background-color: #fff;
    padding: 25px;
    border-radius: 15px;
    -webkit-box-flex: 1;
    -ms-flex: 1;
    flex: 1;
    margin-right: 30px;
    margin-left: 30px;
    margin-top: 25px;
}

.badge_category {
    background: #5d63bb;
    color: #fff;
    font-size: 13px;
    font-weight: normal;
    border-radius: 10px;
    padding: 1px 10px 1px 10px;
}

.alerta {
    width: 11px;
    height: 11px;
    border-radius: 30px;
    background-color: #fbe4a0;
    display: inline-block;
    vertical-align: middle;
}

.agotado {
    width: 11px;
    height: 11px;
    border-radius: 30px;
    background-color: #e65252;
    display: inline-block;
    vertical-align: middle;
}

.disponible {
    width: 11px;
    height: 11px;
    border-radius: 30px;
    background-color: #99bf2d;
    display: inline-block;
    vertical-align: middle;
}
</style>


<style>
.radio-tile-group {
    display: -webkit-box;
    display: flex;
    flex-wrap: wrap;
    -webkit-box-pack: center;
    justify-content: center;
}

.radio-tile-group .input-container {
    position: relative;
    height: 3rem;
    width: 3rem;
    margin: 0.5rem;
}

.radio-tile-group .input-container .radio-button {
    opacity: 0;
    position: absolute;
    top: 0;
    left: 0;
    height: 100%;
    width: 100%;
    margin: 0;
    cursor: pointer;
}

.radio-tile-group .input-container .radio-tile {
    display: -webkit-box;
    display: flex;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
    flex-direction: column;
    -webkit-box-align: center;
    align-items: center;
    -webkit-box-pack: center;
    justify-content: center;
    width: 100%;
    height: 100%;
    border: 2px solid #eee;
    border-radius: 50%;
    padding: 1rem;
    -webkit-transition: -webkit-transform 300ms ease;
    transition: -webkit-transform 300ms ease;
    transition: transform 300ms ease;
    transition: transform 300ms ease, -webkit-transform 300ms ease;
}

.radio-tile-group .input-container .radio-tile-label {
    text-align: center;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: #fff;
}

.radio-tile-group .input-container .radio-button:checked+.radio-tile {
    border: 3px solid #eee;
    -webkit-box-shadow: 0px 5px 12px rgba(0, 0, 0, 0.20);
    box-shadow: 0px 5px 12px rgba(0, 0, 0, 0.20);
    -webkit-transform: scale(1.2, 1.2);
    transform: scale(1.2, 1.2);
}

.radio-tile-group .input-container .radio-button:checked+.radio-tile .radio-tile-label {
    color: black;

    background-color: #fff;
}
</style>
<style>
.os-tabs-controls {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    overflow: auto;
    overflow-y: hidden;
    -webkit-box-pack: justify;
    -ms-flex-pack: justify;
    justify-content: space-between;
}

.os-tabs-controls .nav-tabs {
    -webkit-box-flex: 1;
    -ms-flex: 1;
    flex: 1;
}

.nav-tabs {
    border-bottom: 1px solid #dee2e6;
}

.nav {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    padding-left: 0;
    margin-bottom: 0;
    list-style: none;
}

.nav :hover {
    border: 0px;
    transition: .5s;
    -webkit-transform: translateY(-1px) scale(1);
    transform: translateY(-1px) scale(1);
}

.nav .current {
    color: #4d4d4d !important;
    border-bottom: 3px solid #089bab;
}

.nav .current span {
    color: #4d4d4d !important;
}

.nav-tabs .nav-item {
    transition: .5s;
    margin-bottom: 0px;
    margin-right: 1rem;
}

.nav-tabs .nav-item {
    margin-bottom: -1px;
}

.status-servicios {
    width: 50px;
    height: 50px;
    border-radius: 10px;
    background-color: rgba(132, 109, 251, 0.5);
    display: inline-block;
    vertical-align: middle;
}

.status-settings {
    width: 50px;
    height: 50px;
    border-radius: 10px;
    background-color: rgba(113, 194, 26, 0.5);
    display: inline-block;
    vertical-align: middle;
}

.status-especialidades {
    width: 50px;
    height: 50px;
    border-radius: 10px;
    background-color: rgba(51, 180, 234, 0.5);
    display: inline-block;
    vertical-align: middle;
}

.status-labs {
    width: 50px;
    height: 50px;
    border-radius: 10px;
    background-color: rgba(239, 187, 69, 0.5);
    display: inline-block;
    vertical-align: middle;
}

.nav-link span {
    display: block;
    font-size: 0.75rem;
    font-weight: 600;
    color: #b2b2b2;
}

.status-servicios i {
    margin-top: 12px;
    color: rgba(132, 109, 251, 1) !important;
}

.status-settings i {
    margin-top: 12px;
    color: rgba(113, 194, 26, 1) !important;
}

.status-especialidades i {
    margin-top: 12px;
    color: rgba(51, 180, 234, 1) !important;
}

.status-labs i {
    margin-top: 12px;
    color: rgba(239, 187, 69, 1) !important;
}

.nav-link i {
    display: inline-block;
    color: #b0c4f3;
    font-size: 26px;
    margin-bottom: 5px;
}

.white-box {
    background-color: #fff;
}

.cc-selector input {
    margin: 0;
    padding: 0;
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
}

.visa {
    background-image: url(<?php echo base_url();
    ?>uploads/re1.png);
}

.mastercard {
    background-image: url(<?php echo base_url();
    ?>uploads/rec2.png);
}

.cc-selector input:active+.drinkcard-cc {
    opacity: .2;
}

.cc-selector input:checked+.drinkcard-cc {
    -webkit-filter: none;
    -moz-filter: none;
    filter: none;
    border: 2px solid #1a84fe;
    border-radius: 10px;
}

.drinkcard-cc {
    cursor: pointer;
    background-size: cover;
    background-repeat: no-repeat;
    display: inline-block;
    width: 100%;
    height: 250px;
    -webkit-transition: all 100ms ease-in;
    -moz-transition: all 100ms ease-in;
    transition: all 100ms ease-in;
}

.drinkcard-cc:hover {
    -webkit-filter: brightness(1) grayscale(.1) opacity(.9);
    -moz-filter: brightness(1) grayscale(.1) opacity(.9);
    filter: brightness(1) grayscale(.1) opacity(.9);
}
</style>
<div class="white-box">
    <div class="os-tabs-w">
        <div class="os-tabs-controls">
            <ul class="nav nav-tabs">
                <li class="nav-item text-center">
                    <a class="nav-link current" href="<?php echo base_url();?>staff/settings/">
                        <div class="status-settings"><i class="picons-thin-icon-thin-0049_settings_panel_equalizer_preferences"></i></div> <span>Configuración</span>
                    </a>
                </li>
                <li class="nav-item text-center">
                    <a class="nav-link" href="<?php echo base_url();?>staff/services/">
                        <div class="status-servicios"><i class="picons-thin-icon-thin-0813_heart_vitals_pulse_rate_health"></i></div> <span>Servicios</span>
                    </a>
                </li>
                <li class="nav-item text-center">
                    <a class="nav-link" href="<?php echo base_url();?>staff/specialties/">
                        <div class="status-especialidades"><i class="picons-thin-icon-thin-0825_stetoscope_doctor_hospital_ill"></i></div><span>Especialidades</span>
                    </a>
                </li>
                <li class="nav-item text-center">
                    <a class="nav-link" href="<?php echo base_url();?>staff/laboratories/">
                        <div class="status-labs"><i class="picons-thin-icon-thin-0817_tube_laboratory_chemistry"></i></div><span>Laboratorios</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
<link rel="stylesheet" href="http://miaula.com.gt/demo/assets/css/image-select.css" type="text/css" />
<div class="app-email-w" style="background-color:#f6f7f8;">
    <div class="app-email-i">
        <div class="ae-side-menu">
            <div class="aem-head">
                <a class="ae-side-menu-toggler" href="javascript:void(0);" style="color:#000;"><i class="os-icon picons-thin-icon-thin-0069a_menu_hambuger" style="font-size:20px;"></i></a>
            </div>
            <ul class="ae-main-menu">
                <li>
                    <a href="<?php echo base_url();?>staff/settings/"><span>Ajustes</span></a>
                </li>
                <li>
                    <a href="<?php echo base_url();?>staff/subscription/"><span>Suscripción</span></a>
                </li>
                <li class="active">
                    <a href="<?php echo base_url();?>staff/prescriptions/"><span>Recetas</span></a>
                </li>
                <li>
                    <a href="<?php echo base_url();?>staff/forms/"><span>Formularios</span></a>
                </li>
            </ul>
        </div><br>
        <div class="ae-content-w">
            <div class="row">
                <div class="col-md-12">
                    <div class="card-box">
                        <div class="card-h">
                            <h5 class="card-caption">Elige una plantilla</h5>
                        </div>
                        <hr>
                        <div class="card-b">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="inputGroup">
                                                <input id="basic" value="1" name="practice_id" type="radio" checked class="service_check">
                                                <label for="basic">Básica</label>
                                                <small><a href="javascript:void(0);">Ver ejemplo</a></small>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="inputGroup">
                                                <input id="clasic" value="1" name="practice_id" type="radio" class="service_check">
                                                <label for="clasic">Clásica</label>
                                                <small><a href="javascript:void(0);">Ver ejemplo</a></small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="card-h">
                            <h5 class="card-caption">Información Profesional</h5>
                        </div>
                        <hr>
                        <div class="card-b">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group m-b-15">
                                        <label for="simpleinput">Nombres</label>
                                        <input type="text" name="first_name" required="" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group m-b-15">
                                        <label for="simpleinput">Apellidos</label>
                                        <input type="text" name="last_name" required="" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group m-b-15">
                                        <label for="simpleinput">Celular</label>
                                        <input type="text" name="phone" required="" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group m-b-15">
                                        <label for="simpleinput">Correo</label>
                                        <input type="email" name="email" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group m-b-15">
                                        <label for="simpleinput">Tipo de sangre</label>
                                        <input type="text" name="blood" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group date-time-picker m-b-15">
                                        <label for="simpleinvput">Nacimiento</label>
                                        <div class="input-group date datepicker" id="datePickerExample">
                                            <input type="text" name="date_of_birth" class="form-control"><span class="input-group-addon"><i data-feather="calendar"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group m-b-15">
                                        <label for="simpleinput">Profesión/Ocupación</label>
                                        <input type="text" name="profession" required="" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Sexo</label>
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="male" name="gender" value="M" class="custom-control-input">
                                            <label class="custom-control-label" for="male">Masculino</label>
                                        </div>
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="female" name="gender" value="F" class="custom-control-input">
                                            <label class="custom-control-label" for="female">Femenino</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Estado civil</label>
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="single" name="status" value="0" class="custom-control-input">
                                            <label class="custom-control-label" for="single">Soltero</label>
                                        </div>
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="married" name="status" value="1" class="custom-control-input">
                                            <label class="custom-control-label" for="married">Casado</label>
                                        </div>
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
            </div>
        </div>
    </div>
</div>
<script>
$('.ae-side-menu-toggler').on('click', function() {
    $('.app-email-w').toggleClass('compact-side-menu');
});
if ($('.app-email-w').length) {
    if (is_display_type('phone') || is_display_type('tablet')) {
        $('.app-email-w').addClass('compact-side-menu');
    }
}
</script>
<script>
$('aside').toggleClass('side-nav-small');
$('.contentWrapper').toggleClass('side-nav-small');
</script>