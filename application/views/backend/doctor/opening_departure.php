<?php $rubros = $this->crud_model->getNomenclature();?>
<script src="<?php echo base_url();?>public/uploads/sweetalert2.all.min.js"></script>
<style type="text/css">
    .btn-toolbar {
        display: none !important;
    }
</style>
<div id="main-content">
    <div class="row">
        <div class="col-12">
            <div class="card-box">
                <div class="card-b">
                    <div class="row">
                        <div class="col-lg-6">
                            <h4 class="card-title mb-4">Inicio de partida</h4>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3" style="float: right;">
                                <div class="btn-group focus-btn-group">
                                    <a class="btn btn-info" href="<?php echo base_url();?>doctor/opening/">
                                        <i class="bx bx-arrow-back"></i> Ir a reaperturas
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12"></div>
                        <div class="col-lg-12">
                            <form class="repeater" action="<?php echo base_url();?>doctor/opening_departure/create/" method="POST" enctype="multipart/form-data" id="frmR">
                                <div class="row">
                                    <div class="col-lg-12 mb-3">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="">Periodo</label>
                                                    <input type="text" class="form-control" name="period" id="period" minlength="4" maxlength="4" value="<?php echo date('Y')+1;?>" pattern="[0-9]+" onchange="verifyPeriod()" required />
                                                    <small class="text-danger" id="msgPeriod"></small>
                                                </div>
                                            </div>
                                            <div class="col-lg-2">
                                                <div class="form-group">
                                                    <input type="button" class="btn btn-info btn-rounded mt-2" value="Cargar" onclick="chargeDeparture()" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12" id="divDeparture"></div>
                                    <div class="col-lg-12">
                                        <small class="text-danger" id="msgForm"></small>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    var chD = false;
    var ldD = false;
    var valForm = true;
    var valMonth = true;

    $(document).ready(function () {
        verifyForm();
    });

    function verifyPeriod() {
        var period = $("#period").val();
        if ($.isNumeric(period) && period.length == 4) {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url();?>doctor/verifyPeriodOpen/",
                data: {
                    period: period,
                },
                dataType: "json",
                beforeSend: function () {
                    valForm = false;
                },
                success: function (data) {
                    if (data.exist > 0) valForm = false;
                    else valForm = true;
                    verifyForm();
                },
                error: function (e) {
                    console.log("Error:", e);
                    valForm = false;
                    verifyForm();
                }
            });
        }
    }

    function checkPeriod() {
        var type = $("#type").val();
        if (type == 'month') $("#divMonth").show(300);
        else $("#divMonth").hide(300);
        verifyPeriod();
    }

    function chargeDeparture() {
        var period = $("#period").val();
        if ($.isNumeric(period) && period.length == 4) {
            if (!ldD) {
                $.ajax({
                    method: "POST",
                    url: "<?php echo base_url();?>doctor/chargeOpenDeparture/",
                    data: {
                        year: period,
                    },
                    beforeSend: function () {
                        chD = false;
                        ldD = true;
                        $("#msgCategory").text("Cargando...");
                        $("#msgPeriod").text('');
                        Swal.fire({
                            title: "Cargando",
                            text: "Espera a que se cargue.",
                            padding: '2em',
                            allowOutsideClick: false,
                            didOpen: function () {
                                swal.showLoading()
                            }
                        });
                    },
                    success: function (response) {
                        //console.log(response);
                        $("#msgCategory").text('');
                        $("#msgPeriod").text('');
                        chD = true;
                        ldD = false;
                        $("#divDeparture").html(response);
                        verifyPeriod();
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer)
                                toast.addEventListener('mouseleave', Swal.resumeTimer)
                            }
                        });
                        Toast.fire({
                            type: 'success',
                            title: 'Pártida generada'
                        });
                    },
                    error: function (e) {
                        console.log("Error:", e.responseText);
                        $("#msgCategory").text("Error al cargar la partida, intente mas tarde");
                        $("#divDeparture").html('');
                        chD = false;
                        ldD = false;
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer)
                                toast.addEventListener('mouseleave', Swal.resumeTimer)
                            }
                        });
                        Toast.fire({
                            type: 'error',
                            title: 'Error al generar la pártida'
                        });
                    }
                });
            } else {
                $("#msgCategory").text("Se esta cargando la información");
            }
        } else {
            $("#msgPeriod").text("Ingresa un año válido");
        }
        
    }

    function verifyForm() {
        var mensaje = '';
        console.log("Formulario:", valForm, "Partida:", chD);
        if (valForm && chD) $("#frmR").attr("action", "<?php echo base_url();?>doctor/opening_departure/create/");
        else $("#frmR").attr("action", "javascript:void(0);");

        if (!valForm) mensaje += 'Ya se ha registrado una partida de cierre con los datos seleccionados.<br>';
        if (!chD) mensaje += 'No se ha generado la partida correspondiente.<br>';

        if (mensaje.length > 0) $("#msgForm").html(mensaje);
        else $("#msgForm").html('');
    }
</script>