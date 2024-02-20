<?php $mon = $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->currency; ?>
<link href="<?php echo base_url();?>public/assets/input/script.css" media="all" rel="stylesheet">
<link href="<?php echo base_url();?>public/assets/input/jquery.fileuploader-theme-dragdrop.css" rel="stylesheet">
<link href="<?php echo base_url();?>public/assets/input/font-fileuploader.css" rel="stylesheet">
<div class="white-box">
    <div class="os-tabs-w">
        <div class="os-tabs-controls">
            <ul class="navx nav-tabs">
                <li class="nav-item text-center">
                    <a class="nav-link current" href="<?php echo base_url();?>admin/financial/">
                        <div class="navWidget"><i class="picons-thin-icon-thin-0425_money_payment_dollar_cash"></i>
                        </div> <span>Finanzas</span>
                    </a>
                </li>
                <li class="nav-item text-center">
                    <a class="nav-link" href="<?php echo base_url();?>admin/financial_stabilitation/">
                        <div class="navWidget"><i class="picons-thin-icon-thin-0414_money_cash_coins_payment"></i>
                        </div> <span>Balance de hospitalizaciones</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
<div id="main-content">
    <div class="row">
        <div class="col-sm-8">
            <div class="card-widget">
                <h4 class="panel-content-title">Estadísticas</h4>
                <span class="app-divider2"></span>
                <canvas id="myChart" height="290" style="width:100%"></canvas>
            </div>
            <div class="card-widget">
                <h4 class="panel-content-title">Transacciones recientes</h4>
                <span class="app-divider2"></span>

                <div class="table-responsive">
                    <table class="table table-padded" id="user_data">
                        <thead>
                            <tr>
                                <th class="text-right">Código</th>
                                <th>Fecha</th>
                                <th>Descripción</th>
                                <th>Paciente</th>
                                <th>Tipo</th>
                                <th>de</th>
                                <th>Comprobantes</th>
                                <th class="text-right">Monto (<?php echo $mon;?>)</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-sm-4">
            <div class="balance-widget">
                <h4 class="balance-title">Balance actual al
                    <?php setlocale(LC_TIME, "spanish");
                            $mi_fecha = date('Y/m/d');
                            $mi_fecha = str_replace("/", "-", $mi_fecha);			
                            $Nueva_Fecha = date("d-m-Y", strtotime($mi_fecha));				
                            $Mes_Anyo = strftime("%d de %B", strtotime($Nueva_Fecha));
                            echo $Mes_Anyo;?>
                </h4>
                <span class="app-divider2"></span>
                <h1 style="    font-family: 'CircularStd', sans-serif; font-weight: 800; color: #ffca07;"><?php echo $mon;?> <?php echo $this->crud_model->get_balance();?></h1>
            </div>
            <form action="<?php echo base_url();?>admin/financial/create" method="POST" enctype="multipart/form-data">
                <div class="card-widget">
                    <h4 class="panel-content-title">Registrar transacción</h4>
                    <span class="app-divider2"></span>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group m-b-15">
                                <label for="simpleinput">Descripción:</label>
                                <textarea type="text" name="description" class="form-control" required=""></textarea>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group m-b-15">
                                <label for="simpleinput">Método:</label>
                                <select class="itemName form-control" style="width:100%" name="method" required="">
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
                            <div class="form-group m-b-15">
                                <label for="simpleinput">Monto:</label>
                                <input type="number" name="amount" required="" class="form-control">
                            </div>
                        </div>

                        <div class="col-sm-8">
                            <div class="form-group">
                                <label>Tipo de transacción:</label>
                                <div class="input-group">
                                    <div class="form-check" style="padding-left: 0px;padding-right: 8px;">
                                        <input checked="" class="radiobutton" type="radio" name="type" id="customRadio2" value="1"><label class="radiobutton-label" for="customRadio2">Ingreso</label>
                                    </div>
                                    <div class="form-check" style="padding-left: 0px;">
                                        <input class="radiobutton" type="radio" name="type" id="customRadio" value="0" checked><label class="radiobutton-label" for="customRadio">Egreso</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="custom-control custom-checkbox mr-sm-2" style="    position: relative;top: 32px;">
                                <input type="checkbox" id="invc" name="invoice" value="1" class="custom-control-input check">
                                <label class="custom-control-label" for="invc">Factura</label>
                            </div>
                        </div>
                        <div class="col-sm-12" id="fact">
                            <div class="form-group m-b-15">
                                <label for="simpleinput">No. factura/Recibo</label></label>
                                <div class="form-group">
                                    <input type="text" name="invoice_code" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12" id="fact2">
                            <div class="form-group m-b-15">
                                <label for="simpleinput">Subir factura</label>
                                <label class="labelx" for="apply"><input type="file" name="invoice_file" class="inputx" id="apply" accept="image/*,.pdf">Seleccionar</label>
                                <small id="fileResponse"></small>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <button type="submit" class="btn btn-primary">Guardar transacción</button>
                        </div>
                    </div>
                </div>

        </div>
        </form>

        <div class="col-sm-8">
        </div>
    </div>
</div>

<script src="<?php echo base_url();?>public/assets//back/js/jquery-3.1.1.min.js"></script>
<script src="//code.jquery.com/jquery-3.2.1.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>public/assets/input/jquery.fileuploader.min.js" type="text/javascript">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.0.0-beta.11/chart.js"></script>
<script type="text/javascript" language="javascript">
$(document).ready(function() {
    document.getElementById('apply').onchange = function() {
        var filename = this.value.replace(/C:\\fakepath\\/i, '')
        $("#fileResponse").html('<b>Archivo seleccionado:</b> ' + filename);
    };

    var dataTable = $('#user_data').DataTable({
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            url: "<?php echo base_url() . 'admin/getTable/financial'; ?>",
            type: "POST"
        },

        "columnDefs": [{
            "targets": 0,
            "orderable": false,
        }, ],
    });
});
</script>
<script>
const determineBorderRadius = (context) => {
    const numDatasets = context.chart.data.datasets.length;
    let showBorder = false;
    if (context.datasetIndex === numDatasets - 1) {
        showBorder = true;
    } else if (context.parsed.y !== 0) {
        const sign = Math.sign(context.parsed.y);
        let matches = false;

        for (let i = context.datasetIndex + 1; i < numDatasets; i++) {
            const val = context.parsed._stacks.y[i];
            if (val && Math.sign(val) == sign) {
                matches = true;
                break;
            }
        }
        showBorder = !matches;
    }
    if (!showBorder) {
        return 0;
    }
    let radius = 0;
    if (context.parsed.y > 0) {
        return {
            topLeft: 10,
            topRight: 10,
        };
    } else if (context.parsed.y < 0) {
        return {
            bottomLeft: 10,
            bottomRight: 10,
        };
    }
    return radius;
};

const chart = new Chart('myChart', {
    type: 'bar',
    data: {
        labels: [<?php $this->crud_model->get_month();?>],
        datasets: [{
            label: 'Ingresos',
            data: [<?php $this->crud_model->get_month_income();?>],
            backgroundColor: [
                '#3e58e3'
            ],
            borderWidth: 0,
            borderRadius: determineBorderRadius,
        }, {
            label: 'Egresos',
            data: [<?php $this->crud_model->get_month_expense(); ?>],
            backgroundColor: [
                '#1ad0fc'
            ],
            borderWidth: 0,
            borderRadius: determineBorderRadius,
        }]
    },
    options: {
        scales: {
            y: {
                stacked: true,
            },
            x: {
                stacked: true,
            }
        }
    }
})

Chart.types.Bar.extend({
    name: "BarAlt",
    initialize: function(data) {
        Chart.types.Bar.prototype.initialize.apply(this, arguments);
        if (this.options.curvature !== undefined && this.options.curvature <= 1) {
            var rectangleDraw = this.datasets[0].bars[0].draw;
            var self = this;
            var radius = this.datasets[0].bars[0].width * this.options.curvature * 0.5;
            this.datasets.forEach(function(dataset) {
                dataset.bars.forEach(function(bar) {
                    bar.draw = function() {
                        var y = bar.y;
                        bar.y = Math.min(bar.y + radius, self.scale.endPoint - 1);
                        var barRadius = (bar.y - y);
                        rectangleDraw.apply(bar, arguments);
                        Chart.helpers.drawRoundedRectangle(self.chart.ctx, bar.x - bar
                            .width / 2, bar.y - barRadius + 1, bar.width, bar
                            .height, barRadius);
                        ctx.fill();
                        bar.y = y;
                    }
                })
            })
        }
    },
});
var lineChartData = {
    labels: ["1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12", "13", "14", "15", "16", "17", "18",
        "19", "20", "21", "22", "23", "24", "25", "26", "27", "28", "29", "30", "31"
    ],
    datasets: [{
            fillColor: "#3e58e3",
            strokeColor: "#3e58e3",
            data: [20, 80, 61, 45, 99, 40, 60, 24, 81, 56, 55, 40, 60, 65, 81, 12, 90, 55, 64, 55, 75, 83, 12,
                24, 74, 83, 19, 26, 87, 86, 12
            ]
        },
        {
            fillColor: "#1ad0fc",
            strokeColor: "#1ad0fc",
            data: [-20, -80, -61, -45, -99, -40, -60, -24, -81, -56, -55, -40, -60, -65, -81, -12, -90, -55, -
                64, -55, -75, -83, -12, -24, -74, -83, -19, -26, -87, -86, -12
            ]
        }
    ]
};
var ctx = document.getElementById("myChart").getContext("2d");
var myLine = new Chart(ctx).BarAlt(lineChartData, {
    curvature: 1,

});
</script>

<script>
function submitForm() {
    var formObject = document.forms['filter_form'];
    formObject.submit();
}
</script>

<script type="text/javascript">
$('#fact').hide();
$('#fact2').hide();

$(function() {
    $('[name="invoice"]').change(function() {
        if ($(this).is(':checked')) {
            $('#fact').show(500);
            $('#fact2').show(500);
        } else {
            $('#fact').hide(500);
            $('#fact2').hide(500);
        };
    });
});
</script>

<script>
$('.ae-side-menu-toggler').on('click', function() {
    $('.app-email-w').toggleClass('compact-side-menu');
});
</script>

<script type="text/javascript">
function delete_income(income_id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "También se eliminará toda la información asociada al producto.",
        type: 'info',
        showCancelButton: true,
        confirmButtonColor: '#9fd13b',
        cancelButtonColor: '#fd4f57',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.value) {
            location.href = "<?php echo base_url();?>admin/financial/delete/" + income_id;
        }
    })
}
</script>