<?php $month = date('m');?>
<script src="<?php echo base_url();?>public/uploads/sweetalert2.all.min.js"></script>
<style type="text/css">
    .btn-toolbar {
        display: none !important;
    }
</style>
<div id="main-content">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <h4 class="card-title mb-4">Inicio de partida</h4>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3" style="float: right;">
                                <div class="btn-group focus-btn-group">
                                    <a class="btn btn-info" href="<?php echo base_url();?>admin/closing/">
                                        <i class="bx bx-arrow-back"></i> Ir a cierres
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12"></div>
                        <div class="col-lg-12">
                            <form class="repeater" action="<?php echo base_url();?>admin/closing_departure/create/" method="POST" enctype="multipart/form-data" id="frmC">
                                <div class="row">
                                    <div class="col-lg-12 mb-3">
                                        <div class="row">
                                            <div class="col-lg-5 mb-3">
                                                <div class="form-group">
                                                    <label for="">Categoria</label>
                                                    <select class="form-control" name="category" id="category" required onchange="verifyPeriod()">
                                                        <option value="">Seleccione una opcion</option>
                                                        <option value="sales_cost">Costo de ventas</option>
                                                        <option value="final_inventory">Inventario final</option>
                                                        <option value="profit_loss">Pérdidas y Ganancias</option>
                                                        <option value="gross_sales">Ventas brutas</option>
                                                        <option value="profit_account">Contabilización de la ganancia</option>
                                                        <option value="equity_accounts">Cuentas patrimoniales</option>
                                                        <option value="other">Nuevo</option>
                                                    </select>
                                                    <small class="text-danger" id="msgCategory"></small>
                                                </div>
                                            </div>
                                            <div class="col-lg-5">
                                                <div class="form-group">
                                                    <label for="">Tipo</label>
                                                    <select class="form-control" name="type" id="type" required onchange="checkPeriod()">
                                                        <option value="year" selected>Anual</option>
                                                        <option value="month">Mensual</option>
                                                    </select>
                                                    <small class="text-danger" id="msgType"></small>
                                                </div>
                                            </div>
                                            <div class="col-lg-2">
                                                <div class="form-group">
                                                    <input type="button" class="btn btn-info btn-rounded mt-2" value="Cargar" onclick="chargeDeparture()" />
                                                </div>
                                            </div>
                                            <div class="col-lg-5">
                                                <div class="form-group">
                                                    <label for="">Periodo</label>
                                                    <input type="text" class="form-control" name="period" id="period" minlength="4" maxlength="4" value="<?php echo date('Y');?>" pattern="[0-9]+" onchange="verifyPeriod()" required />
                                                    <small class="text-danger" id="msgPeriod"></small>
                                                </div>
                                            </div>
                                            <div class="col-lg-5" id="divMonth" style="display:none;">
                                                <div class="form-group">
                                                    <label for="">Mes</label>
                                                    <select class="form-control" name="month" id="month" onchange="verifyPeriod()">
                                                        <option value="1" <?php if($month == 1) echo "selected";?>>Enero</option>
                                                        <option value="2" <?php if($month == 2) echo "selected";?>>Febrero</option>
                                                        <option value="3" <?php if($month == 3) echo "selected";?>>Marzo</option>
                                                        <option value="4" <?php if($month == 4) echo "selected";?>>Abril</option>
                                                        <option value="5" <?php if($month == 5) echo "selected";?>>Mayo</option>
                                                        <option value="6" <?php if($month == 6) echo "selected";?>>Junio</option>
                                                        <option value="7" <?php if($month == 7) echo "selected";?>>Julio</option>
                                                        <option value="8" <?php if($month == 8) echo "selected";?>>Agosto</option>
                                                        <option value="9" <?php if($month == 9) echo "selected";?>>Septiembre</option>
                                                        <option value="10" <?php if($month == 10) echo "selected";?>>Octubre</option>
                                                        <option value="11" <?php if($month == 11) echo "selected";?>>Noviembre</option>
                                                        <option value="12" <?php if($month == 12) echo "selected";?>>Diciembre</option>
                                                    </select>
                                                    <small class="text-danger" id="msgMonth"></small>
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
        var category = $("#category").val();
        var type = $("#type").val();
        var period = $("#period").val();
        var month = $("#month").val();
        if (category != '' && $.isNumeric(period) && period.length == 4 && ((type == 'month' && month != '') || type == 'year')) {
            valMonth = true;
            $.ajax({
                type: "POST",
                url: "<?php echo base_url();?>admin/verifyPeriodClose/",
                data: {
                    category: category,
                    type: type,
                    period: period,
                    month: month,
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

        if (type == 'month' && month == '') valMonth = false;
    }

    function checkPeriod() {
        var type = $("#type").val();
        if (type == 'month') $("#divMonth").show(300);
        else $("#divMonth").hide(300);
        verifyPeriod();
    }

    function chargeDeparture() {
        var category = $("#category").val();
        var type = $("#type").val();
        var period = $("#period").val();
        var month = $("#month").val();
        if (category != '' && $.isNumeric(period) && period.length == 4) {
            if (!ldD) {
                $.ajax({
                    method: "POST",
                    url: "<?php echo base_url();?>admin/chargeCloseDeparture/",
                    data: {
                        category: category,
                        type: type,
                        year: period,
                        month: month,
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
        } 
        
        if (category == '') $("#msgCategory").text("Debes seleccionar una categoria");
        if (!$.isNumeric(period) || period.length != 4) $("#msgPeriod").text("Ingresa un año válido");
    }

    function verifyForm() {
        var mensaje = '';
        if (valForm && chD && valMonth) $("#frmC").attr("action", "<?php echo base_url();?>admin/closing_departure/create/");
        else $("#frmC").attr("action", "javascript:void(0);");

        if (!valForm) mensaje += 'Ya se ha registrado una partida de cierre con los datos seleccionados.<br>';
        if (!chD) mensaje += 'No se ha generado la partida correspondiente.<br>';
        if (!valMonth) mensaje += 'Debe seleccionar un mes.<br>'; 

        if (mensaje.length > 0) $("#msgForm").html(mensaje);
        else $("#msgForm").html('');
    }
</script>