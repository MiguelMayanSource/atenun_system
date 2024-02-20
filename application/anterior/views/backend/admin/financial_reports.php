<div class="white-box">
    <div class="os-tabs-w">
        <div class="os-tabs-controls">
            <ul class="navx nav-tabs">
                <li class="nav-item text-center">
                    <a class="nav-link current" href="<?php echo base_url();?>admin/financial_reports/">
                        <div class="navWidget"><i class="picons-thin-icon-thin-0425_money_payment_dollar_cash"></i>
                        </div> <span>Financiero</span>
                    </a>
                </li>
                <li class="nav-item text-center">
                    <a class="nav-link" href="<?php echo base_url();?>admin/appointment_reports/">
                        <div class="navWidget"><i class="picons-thin-icon-thin-0021_calendar_month_day_planner"></i>
                        </div> <span>Cirugías</span>
                    </a>
                </li>
                <?php 
                    $inventory = $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->product_module;
                    if($inventory == 1):
                    ?>
                <li class="nav-item text-center">
                    <a class="nav-link" href="<?php echo base_url();?>admin/inventory_reports/">
                        <div class="navWidget"><i class="picons-thin-icon-thin-0820_medicine_drugs_ill_pill"></i></div>
                        <span>Inventario</span>
                    </a>
                </li>
                <?php endif;?>
                <li class="nav-item text-center">
                    <a class="nav-link" href="<?php echo base_url();?>admin/reports/">
                        <div class="navWidget"><i class="picons-thin-icon-thin-0386_graph_line_chart_statistics"></i>
                        </div><span>Actividad</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
<div id="main-content">
    <div class="row">
        <div class="col-sm-12">
            <form action="<?php echo base_url();?>admin/financial_reports/" method="POST">
                <div class="card-h" style="background-color:#fff; padding:15px;border-radius:5px;">
                    <label><b>Aplicar filtros:</b></label>
                    <div class="row">
                        <div class="col-sm-5">
                            <div class="form-group date-time-picker m-b-15">
                                <label for="simpleinvput">Desde:</label>
                                <div class="input-group date datepicker" id="datePickerExample">
                                    <input type="text" autocomplete="off" name="fecha1" value="<?php if($fecha1 != '') echo $fecha1; ?>" class="form-control"><span style="display:none;" class="input-group-addon"><i data-feather="calendar"></i></span>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-5">
                            <div class="form-group date-time-picker m-b-15">
                                <label for="simpleinvput">Hasta:</label>
                                <div class="input-group date datepicker" id="datePickerExample2">
                                    <input type="text" autocomplete="off" name="fecha2" value="<?php if($fecha2 != '') echo $fecha2; ?>" class="form-control"><span style="display:none;" class="input-group-addon"><i data-feather="calendar"></i></span>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-2">
                            <div class="form-group"><br>
                                <button class="btn btn-info" type="submit">Aplicar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-sm-12">
            <div class="row">
                <div class="col-sm-8">
                    <div class="title-header">
                        <div class="card-widget">
                            <h4 class="panel-content-title">Estadísticas</h4>
                            <span class="app-divider2"></span>
                            <canvas id="myChart" height="290" style="width:100%"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="title-header">
                        <div class="card-widget">
                            <h4 class="panel-content-title">Balances</h4>
                            <span class="app-divider2"></span>
                            <div class="balance-widget">
                                <h4 class="balance-title">Ingresos</h4>
                                <span class="app-divider2"></span>
                                <h1 style="font-family: 'CircularStd', sans-serif; font-weight: 800; color: #ffca07;">
                                    <?php echo $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->currency;?>.
                                    <?php echo $this->crud_model->get_income_report($fecha1,$fecha2);?></h1>
                            </div>
                            <div class="balance-widget">
                                <h4 class="balance-title">Egresos</h4>
                                <span class="app-divider2"></span>
                                <h1 style="font-family: 'CircularStd', sans-serif; font-weight: 800; color: #ffca07;">
                                    <?php echo $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->currency;?>.
                                    <?php echo $this->crud_model->get_expense_report($fecha1,$fecha2);?></h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-12">
            <div class="card-widget">
                <h4 class="panel-content-title">Transacciones recientes</h4>
                <a target="_blank" class="add-buton pull-right" style="margin-right:1px;" href="<?php echo base_url();?>admin/print_financial_report/<?php echo base64_encode($fecha1);?>/<?php echo base64_encode($fecha2);?>">IMPRIMIR</a>
                <a class="add-buton pull-right" style="margin-right:1px;" href="<?php echo base_url();?>admin/excel/<?php echo base64_encode($fecha1);?>/<?php echo base64_encode($fecha2);?>">EXCEL</a>
                <span class="app-divider2"></span>
                <div class="table-responsive">
                    <table class="table table-padded" id="user_data">
                        <thead>
                            <tr>
                                <th class="text-right" style="width:50px">Código</th>
                                <th>Fecha</th>
                                <th>Descripcion</th>
                                <th>Paciente</th>
                                <th>de</th>
                                <th>Tipo</th>
                                <th class="text-right" style="width:200px">Monto
                                    (<?php echo $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->currency;?>)
                                </th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.0.0-beta.11/chart.js"></script>
<script type="text/javascript" language="javascript">
$(document).ready(function() {
    var dataTable = $('#user_data').DataTable({
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            url: "<?php echo base_url() . 'admin/getTable/financial_reports/'.base64_encode($fecha1).'/'.base64_encode($fecha2); ?>",
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
$(function() {
    'use strict';
    if ($('#datePickerExample').length) {
        var date = new Date();
        var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
        $('#datePickerExample').datepicker({
            format: "dd/mm/yyyy",
            todayHighlight: true,
            autoclose: true
        });
    }
    if ($('#datePickerExample2').length) {
        var date = new Date();
        var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
        $('#datePickerExample2').datepicker({
            format: "dd/mm/yyyy",
            todayHighlight: true,
            autoclose: true
        });
    }
});

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
        labels: [<?php $this->crud_model->get_month_report($fecha1,$fecha2);?>],
        datasets: [{
            label: 'Ingresos',
            data: [<?php $this->crud_model->get_month_income_report($fecha1,$fecha2);?>],
            backgroundColor: [
                '#3e58e3'
            ],
            borderWidth: 0,
            borderRadius: determineBorderRadius,
        }, {
            label: 'Egresos',
            data: [<?php echo $this->crud_model->get_month_expense_report($fecha1,$fecha2);?>],
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
                        Chart.helpers.drawRoundedRectangle(self.chart.ctx, bar.x - bar.width / 2, bar.y - barRadius + 1, bar.width, bar.height, barRadius);
                        ctx.fill();
                        bar.y = y;
                    }
                })
            })
        }
    },
});
var lineChartData = {
    labels: ["1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23", "24", "25", "26", "27", "28", "29", "30", "31"],
    datasets: [{
            fillColor: "#3e58e3",
            strokeColor: "#3e58e3",
            data: [20, 80, 61, 45, 99, 40, 60, 24, 81, 56, 55, 40, 60, 65, 81, 12, 90, 55, 64, 55, 75, 83, 12, 24, 74, 83, 19, 26, 87, 86, 12]
        },
        {
            fillColor: "#1ad0fc",
            strokeColor: "#1ad0fc",
            data: [-20, -80, -61, -45, -99, -40, -60, -24, -81, -56, -55, -40, -60, -65, -81, -12, -90, -55, -64, -55, -75, -83, -12, -24, -74, -83, -19, -26, -87, -86, -12]
        }
    ]
};
var ctx = document.getElementById("myChart").getContext("2d");
var myLine = new Chart(ctx).BarAlt(lineChartData, {
    curvature: 1,

});
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/d3/5.9.2/d3.min.js"></script>