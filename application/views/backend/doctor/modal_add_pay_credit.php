        <link href="<?php echo base_url();?>public/assets/theme/css/select2.min.css" rel="stylesheet" />

        <div class="modal-content animated fadeInDown" style="border-radius:20px;">
            <div class="modal-header" style="background-color:#fff;border-radius:20px;">
                <h4 style="font-size:21px; color:#565b6b; font-family:'Poppins';">
                    <span style="vertical-align:-3px">Abono de tratamiento</span>
                </h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>


            <form action="<?php echo base_url();?>doctor/update_treatment/add_pay_credit" method="POST">
                <div class="modal-content animated fadeInDown" style="border-radius:5px; ">
                    <div class="modal-body" style="background-color:#f1f3f7;">
                        <div class="form-group">
                            <div class="container">
                                <div class="row">

                                    <input name="treatment_id" id="treatment_id" type="hidden" value="<?php echo $param2;?>">
                                    <input name="patient_id" id="patient_id" type="hidden" value="<?php echo $param3;?>">
                                    <input name="previous_total" id="previous_total" type="hidden" value="<?php echo $param4;?>">

                                    <div class="col-sm-6">
                                        <div class="form-group m-b-15">
                                            <label for="simpleinput">Forma de pago</label>
                                            <select class="form-control js-example-basic-single" name="method" id="method" required="" onchange="check_prov(this.value)">
                                                <option value="">Seleccionar</option>
                                                <option value="1">Efectivo</option>
                                                <option value="2">Tarjeta</option>
                                                <option value="3">Cheque</option>
                                                <option value="4">Depósito</option>
                                                <option value="5">Transferencia</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="simpleinput">Monto </label><br>
                                            <input class="form-control" type="number" name="amount" id="amount" max="<?php echo $param4;?>" min="1" required="">
                                        </div>
                                    </div>

                                    <div class="col-sm-12" id="tarjeta">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="simpleinput">Titular tarjeta </label><br>
                                                    <input class="form-control" type="text" name="cardholder" id="cardholder">
                                                </div>
                                            </div>

                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="simpleinput"> Váucher </label><br>
                                                    <input class="form-control" type="text" name="vaucher" id="vaucher">
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="col-sm-12" id="cheque">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="simpleinput"> Nombre de la cuenta </label><br>
                                                    <input class="form-control" type="text" name="titular_checkk" id="titular_checkk">
                                                </div>
                                            </div>

                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="simpleinput"> No. Cheque </label><br>
                                                    <input class="form-control" type="text" name="checkk" id="checkk">
                                                </div>
                                            </div>

                                        </div>
                                    </div>


                                    <div class="col-sm-12" id="deposito">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="simpleinput"> No. Depósito</label><br>
                                                    <input class="form-control" type="text" name="no_dep" id="no_dep">
                                                </div>
                                            </div>

                                        </div>
                                    </div>


                                    <div class="col-sm-12" id="transf">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="simpleinput"> No. de Transferencia </label><br>
                                                    <input class="form-control" type="text" name="transf" id="transf">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer" style="text-align:center;">
                        <center>
                            <button type="submit" class="button-confirm">Ingresar</button>
                        </center>
                    </div>
                </div>
            </form>

        </div>

        <script src="<?php echo base_url();?>public/assets/theme/js/select2.min.js"></script>

        <script>
$(function() {
    'use strict'

    if ($(".js-example-basic-single").length) {
        $(".js-example-basic-single").select2();
    }
    if ($(".js-example-basic-multiple").length) {
        $(".js-example-basic-multiple").select2();
    }
});
        </script>


        <script type="text/javascript">
$('#tarjeta').hide();
$('#cheque').hide();
$('#deposito').hide();
$('#transf').hide();


function check_prov(value) {
    if (value == '1') {
        $('#tarjeta').hide(500);
        $('#cheque').hide(500);
        $('#deposito').hide(500);
        $('#transf').hide(500);
    } else if (value == '2') {
        $('#tarjeta').show(500);
        $('#cheque').hide(500);
        $('#deposito').hide(500);
        $('#transf').hide(500);
    } else if (value == '3') {
        $('#cheque').show(500);
        $('#tarjeta').hide(500);
        $('#deposito').hide(500);
        $('#transf').hide(500);
    } else if (value == '4') {
        $('#deposito').show(500);
        $('#tarjeta').hide(500);
        $('#cheque').hide(500);
        $('#transf').hide(500);
    } else if (value == '5') {
        $('#transf').show(500);
        $('#tarjeta').hide(500);
        $('#cheque').hide(500);
        $('#deposito').hide(500);

    } else {
        $('#tarjeta').hide(500);
        $('#cheque').hide(500);
        $('#deposito').hide(500);
        $('#transf').hide(500);
    }

}
        </script>