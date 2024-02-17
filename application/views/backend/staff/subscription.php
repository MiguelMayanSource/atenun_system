    <?php $current = $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->package_id;?>
    <div class="white-box">
        <div class="os-tabs-w">
            <div class="os-tabs-controls">
                <ul class="navx nav-tabs">
                    <li class="nav-item text-center">
                        <a class="nav-link current" href="<?php echo base_url();?>staff/settings/">
                            <div class="navWidget"><i class="picons-thin-icon-thin-0049_settings_panel_equalizer_preferences"></i></div> <span>Configuración</span>
                        </a>
                    </li>
                    <li class="nav-item text-center">
                        <a class="nav-link" href="<?php echo base_url();?>staff/services/">
                            <div class="navWidget"><i class="picons-thin-icon-thin-0813_heart_vitals_pulse_rate_health"></i></div> <span>Servicios</span>
                        </a>
                    </li>
                    <li class="nav-item text-center">
                        <a class="nav-link" href="<?php echo base_url();?>staff/specialties/">
                            <div class="navWidget"><i class="picons-thin-icon-thin-0825_stetoscope_doctor_hospital_ill"></i></div><span>Especialidades</span>
                        </a>
                    </li>
                    <li class="nav-item text-center">
                        <a class="nav-link" href="<?php echo base_url();?>staff/laboratories/">
                            <div class="navWidget"><i class="picons-thin-icon-thin-0817_tube_laboratory_chemistry"></i></div><span>Laboratorios</span>
                        </a>
                    </li>
                    <li class="nav-item text-center">
                        <a class="nav-link" href="<?php echo base_url();?>staff/third/">
                            <div class="navWidget"><i class="picons-thin-icon-thin-0726_doctor_surgery_hospital"></i></div><span>Terceros</span>
                        </a>
                    </li>
                    <li class="nav-item text-center">
                        <a class="nav-link" href="<?php echo base_url();?>staff/surveys/">
                            <div class="navWidget"><i class="picons-thin-icon-thin-0065_bullet_list_view"></i></div><span>Encuestas</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="app-email-w" style="background-color:#f6f7f8;">
        <div class="app-email-i">
            <div class="ae-side-menu">
                <div class="aem-head">
                    <a class="ae-side-menu-toggler" href="javascript:void(0);" style="color:#000;"><i class="os-icon picons-thin-icon-thin-0069a_menu_hambuger" style="font-size:20px;"></i></a>
                </div>
                <ul class="ae-main-menu">
                    <li data-toggle="tooltip" data-placement="right" title="Configuración"><a href="<?php echo base_url();?>staff/settings/"><i class="app-icons picons-thin-icon-thin-0031_pin_bookmark"></i><span>Configuración</span></a></li>
                    <li class="active" data-toggle="tooltip" data-placement="right" title="Suscripción"><a href="<?php echo base_url();?>staff/subscription/"><i class="app-icons picons-thin-icon-thin-0031_pin_bookmark"></i><span>Suscripción</span></a></li>
                    <li data-toggle="tooltip" data-placement="right" title="Formularios"><a href="<?php echo base_url();?>staff/forms/"><i class="app-icons picons-thin-icon-thin-0031_pin_bookmark"></i><span>Formularios</span></a></li>
                    <li data-toggle="tooltip" data-placement="right" title="Sucursales"><a href="<?php echo base_url();?>staff/clinics/"><i class="app-icons picons-thin-icon-thin-0031_pin_bookmark"></i><span>Sucursales</span></a></li>
                </ul>
            </div>
            <div class="pageContent2">
                <form action="<?php echo base_url();?>staff/subscription/create" method="POST">
                    <div class="row">
                        <div class="col-sm-12">
                            <?php if($this->crud_model->checkSubscription()->num_rows() > 0):?>
                            <div class="alert alert-danger">
                                Tienes una factura pendiente de pago, haz click <a href="<?php echo base_url();?>staff/confirmed/<?php echo $this->crud_model->checkSubscription()->row()->code;?>/pg/">aquí</a> para más información.
                            </div>
                            <?php endif;?>
                        </div>
                        <div class="col-md-8">
                            <div class="order-box">
                                <div class="order-details-box">
                                    <div class="order-main-info">
                                        <b>Tu suscripción a Medicaby</b>
                                    </div>
                                    <div class="order-sub-info">
                                        <span>Tu plan actual expira</span>
                                        <strong style="text-align:right">el <?php echo $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->expiration;?>.</strong>
                                    </div>
                                </div>
                                <div class="order-items-table">
                                    <div class="middless">
                                        <?php 
                                $plans = $this->db->get('package')->result_array();
                                foreach($plans as $pl):
                            ?>
                                        <label>
                                            <input type="radio" onclick="calculate('<?php echo $pl['package_id'];?>')" name="radio" <?php if($pl['package_id'] == $current && $current > 0) echo 'checked'; else if($current == 0 && $pl['price'] == 0) echo 'checked';?> value="<?php echo $pl['package_id'];?>" />
                                            <div class="pland box">
                                                <span><?php echo $pl['name'];?> <p style="margin-top:-4px;font-size: 15px;font-weight:700;color:#707d94;">$<?php echo $pl['price'];?> USD</p></span>
                                            </div>
                                        </label>
                                        <input type="hidden" id="package-<?php echo $pl['package_id'];?>" value="<?php echo $pl['price'];?>">
                                        <?php endforeach;?>
                                    </div><br>
                                    <div class="row" id="Tarjeta" style="display:none">
                                        <hr>
                                        <div class="col-sm-12">
                                            <label><b>Tarjeta de crédito/débito:</b></label><br>
                                            <img src="<?php echo base_url();?>style/back/images/credit-cards.svg" width="135px;">
                                            <hr>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Nombre del titular:</label>
                                                <input type="text" class="form-control" name="titular" />
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Número de tarjeta:</label>
                                                <input type="number" class="form-control" name="no_tarjeta">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Fecha de expiración:</label>
                                                <input type="text" class="form-control" name="expiration" />
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Código CVC:</label>
                                                <input type="text" class="form-control" name="codigo_cvc" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="order-box">
                                <div class="order-details-box">
                                    <div class="order-main-info">
                                        <strong>Resumen de la orden</strong>
                                    </div>
                                </div>
                                <hr>
                                <div class="order-foot">
                                    <?php if($this->crud_model->checkSubscription()->num_rows() > 0):?>
                                    <p class="text-center">Actualmente tienes una factura pendiente de pago, por favor completala o cancela para poder continuar.</p>
                                    <center><img src="<?php echo base_url();?>style/back/images/error.png" width="80px"></center><br>
                                    <?php else:?>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h5>¿Comentarios?</h5>
                                            <div class="form-group">
                                                <textarea class="form-control" placeholder="Aquí puedes agregar comentarios al equipo de Medicaby..." rows="5" name="comment"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" id="recurrent" onclick="calAnual()" name="isAnual" value="1" class="custom-control-input rm">
                                                <label class="custom-control-label" for="recurrent" style="font-weight:bold;color:#59636d;">Realizar este pago por 1 año.</label>
                                            </div><br>
                                        </div>
                                        <div class="col-sm-12">
                                            <label>¿Cómo deseas pagar?</label>
                                            <div class="form-group">
                                                <select class="vodiapicker" name="method">
                                                    <option value="">Selecciona un método</option>
                                                    <option value="bi" data-thumbnail="<?php echo base_url();?>style/back/images/bi.png">Banco Industrial</option>
                                                    <option value="ban" data-thumbnail="<?php echo base_url();?>style/back/images/banru.png">Banrural</option>
                                                    <option value="pp" data-thumbnail="<?php echo base_url();?>style/back/images/paypal.png">PayPal</option>
                                                    <option value="visa" data-thumbnail="<?php echo base_url();?>style/back/images/visa.png">Tarjeta de crédito/débito</option>
                                                </select>
                                                <input type="hidden" id="response" value="" name="response">
                                                <div class="lang-select">
                                                    <button class="btn-select" type="button" value="" onchange="changeMethod()"></button>
                                                    <div class="b">
                                                        <ul id="a"></ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="order-summary-row">
                                                <div class="order-summary-label">
                                                    <span>Subtotal</span>
                                                </div>
                                                <div class="order-summary-value">
                                                    $<span id="subtotal"></span>
                                                </div>
                                            </div>
                                            <div class="order-summary-row as-total">
                                                <div class="order-summary-label">
                                                    <span>Total</span>
                                                </div>
                                                <div class="order-summary-value">$<span id="total"></span></div>
                                            </div>
                                            <input type="hidden" id="totalPrice" name="totalPrice" value="0">
                                        </div>
                                        <div class="col-sm-12">
                                            <hr>
                                            <button class="btn btn-success" type="submit" id="Submit" style="width:100%; color:#fff;display:none">Confirmar y continuar <i class="picons-thin-icon-thin-0160_arrow_next_right"></i> </button><br><br>
                                            <a class="btn btn-primary" id="PayPal" style="background:#fff;width:100%; color:#000!important;display:none">Pagar con <img src="https://i.ya-webdesign.com/images/paypal-icon-png-5.png" width="80px"></a>
                                        </div>
                                    </div>
                                    <?php endif;?>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
function changeMethod() {

    var value = $("#response").val();

    if (value == "visa") {
        $("#Tarjeta").show(500);
        $("#PayPal").hide(500);
        $("#Submit").show(500);
    } else if (value == "bi") {
        $("#PayPal").hide(500);
        $("#Submit").show(500);
        $("#Tarjeta").hide(500);
    } else if (value == "ban") {
        $("#Submit").show(500);
        $("#PayPal").hide(500);
        $("#Tarjeta").hide(500);
    } else if (value == "pp") {
        $("#PayPal").show(500);
        $("#Submit").hide(500);
        $("#Tarjeta").hide(500);
    }
}

var langArray = [];
$('.vodiapicker option').each(function() {
    var img = $(this).attr("data-thumbnail");
    var text = this.innerText;
    var value = $(this).val();
    var item = '<li><img src="' + img + '" alt="" value="' + value + '"/><span>' + text + '</span></li>';
    langArray.push(item);
})

$('#a').html(langArray);

//Set the button value to the first el of the array
$('.btn-select').html(langArray[0]);
$('.btn-select').attr('value', 'en');

//change button stuff on click
$('#a li').click(function() {
    var img = $(this).find('img').attr("src");
    var value = $(this).find('img').attr('value');
    var text = this.innerText;
    var item = '<li><img src="' + img + '" alt="" /><span>' + text + '</span></li>';
    $('.btn-select').html(item);
    $('.btn-select').attr('value', value);
    $('#response').attr('value', value);
    changeMethod();
    $(".b").toggle();
    //console.log(value);
});

$(".btn-select").click(function() {
    $(".b").toggle();
});

//check local storage for the lang
var sessionLang = localStorage.getItem('lang');
if (sessionLang) {
    //find an item with value of sessionLang
    var langIndex = langArray.indexOf(sessionLang);
    $('.btn-select').html(langArray[langIndex]);
    $('.btn-select').attr('value', sessionLang);
} else {
    var langIndex = langArray.indexOf('ch');
    console.log(langIndex);
    $('.btn-select').html(langArray[langIndex]);
    //$('.btn-select').attr('value', 'en');
}



$("#total").html('0');
$("#subtotal").html('0');

var check;
$("#recurrent").on("click", function() {
    check = $("#recurrent").is(":checked");
    if (check) {
        calAnual();
    } else {
        recalculate();
    }
});

function recalculate() {
    var amount = $("#totalPrice").val();
    $("#subtotal").html(amount);
    $("#total").html(amount);
}

function calculate(package) {
    $("#recurrent").prop('checked', false);
    var amount = $("#package-" + package).val();
    var totalAmount = $("#totalPrice").val(amount);
    $("#subtotal").html(amount);
    $("#total").html(amount);
}

function calAnual() {
    var amount = $("#totalPrice").val();
    totalAmount = amount * 12;
    $("#subtotal").html(totalAmount);
    $("#total").html(totalAmount);
}

$('.app-email-w').toggleClass('compact-side-menu');
$('.ae-side-menu-toggler').on('click', function() {
    $('.app-email-w').toggleClass('compact-side-menu');
});
    </script>