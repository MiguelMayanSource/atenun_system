    <div class="white-box">
        <div class="os-tabs-w">
            <div class="os-tabs-controls">
                <ul class="navx nav-tabs">
                    <li class="nav-item text-center">
                        <a class="nav-link current" href="<?php echo base_url();?>admin/appointment_reports/">
                            <div class="navWidget"><i class="picons-thin-icon-thin-0021_calendar_month_day_planner"></i></div> <span>Citas</span>
                        </a>
                    </li>
                    <?php 
                      $inventory = $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->product_module;
                      if($inventory == 1):
                    ?>
                    <li class="nav-item text-center">
                        <a class="nav-link" href="<?php echo base_url();?>admin/inventory_reports/">
                            <div class="navWidget"><i class="picons-thin-icon-thin-0820_medicine_drugs_ill_pill"></i></div><span>Inventario</span>
                        </a>
                    </li>
                    <?php endif;?>
                    <li class="nav-item text-center">
                        <a class="nav-link" href="<?php echo base_url();?>admin/reports/">
                            <div class="navWidget"><i class="picons-thin-icon-thin-0386_graph_line_chart_statistics"></i></div><span>Actividad</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div id="main-content">
        <div class="row">
            <div class="col-sm-12">
                <div class="card-widget">
                    <h4 class="panel-content-title"> <?php if($doctor_id != "") echo 'Citas de '.$this->accounts_model->gender($doctor_id).' '.$this->accounts_model->get_name('admin',$doctor_id);?> <?php
                    if($doctor_id != "" && $fecha1 != "" && $fecha2 != "")
                    { ?>
                        <span style="font: 17px 'Proxima Nova',Helvetica,Arial,sans-serif;   font-style: italic;  font-weight: 400;">[<?php echo $this->crud_model->formatear($fecha1)?> - <?php echo $this->crud_model->formatear($fecha2)." del ".date('Y'); ?>]</span>
                        <?php }   
                    else{
                        $anioActual = date("Y");
                        $mesActual = date("m");
                        $cantidadDias = cal_days_in_month(CAL_GREGORIAN, $mesActual, $anioActual);
                        $fecha = $cantidadDias.'/'.$mesActual.'/'.$anioActual;
                        $hoy = '01/'.$mesActual.'/'.$anioActual;
                        $fecha1 = $hoy;
                        $fecha2 = $fecha;
                    ?>
                        <?php echo $this->crud_model->formatear($fecha)?> - <?php echo $this->crud_model->formatear($hoy)." del ".date('Y'); ?>
                        <?php    } ?>
                    </h4>
                    <span class="app-divider2"></span>
                    <form action="<?php echo base_url();?>admin/appointment_reports/" method="POST">
                        <div class="row">
                            <div class="col-sm-4">
                                <label>Especialista</label>
                                <select class="itemName form-control select2" required="" style="width:100%; float:right" name="doctor_id">
                                    <option value="">Seleccionar</option>
                                    <?php 
										    $this->db->where('status','1');
										    $this->db->where('clinic_id',$this->session->userdata('current_clinic'));
    										$this->db->order_by('first_name', 'ASC');
										    $query = $this->db->get('admin')->result_array();
                                            foreach($query as $pat):?>
                                    <option value="<?php echo $pat['admin_id'];?>" <?php if($pat['admin_id'] == $doctor_id) echo "selected";?>><?php echo $this->accounts_model->get_name('admin', $pat['admin_id']);?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group date-time-picker m-b-15">
                                    <label for="simpleinvput">De</label>
                                    <div class="input-group date datepicker" id="DoctorPicker12">
                                        <input type="text" name="fecha1" value="<?php if($fecha1 != '') { echo $fecha1; } else {echo $fecha;};?>" required="" autocomplete="off" class="form-control"><span style="display:none;" class="input-group-addon"><i data-feather="calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group date-time-picker m-b-15">
                                    <label for="simpleinvput">A</label>
                                    <div class="input-group date datepicker" id="DocPicker">
                                        <input type="text" name="fecha2" value="<?php if($fecha2 != '') { echo $fecha2; } else {echo $hoy;};?>" required="" autocomplete="off" class="form-control"><span style="display:none;" class="input-group-addon"><i data-feather="calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <button style="float:left;" type="submit" class="btn btn-info">Aplicar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="row">
                    <div class="col-sm-8">
                        <div class="row">
                            <div class="col-sm-8">
                                <div class="row">
                                    <div class="col-6 col-sm-12 col-lg-4 col-xl-6">
                                        <a class="element-box el-tablo centered trend-in-corner smaller" href="javascript:void(0);" style="cursor:pointer;">
                                            <div class="label">
                                                Total
                                            </div>
                                            <div class="value">
                                                <?php echo $total = $this->crud_model->count_appointments($doctor_id, $fecha1, $fecha2, 'total')->num_rows();?>
                                            </div>
                                            <div class="trending trending-up">
                                                <span><?php echo $this->crud_model->getPercentage($total,$total);?>%</span>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-6 col-sm-12 col-lg-4 col-xl-6">
                                        <a class="element-box el-tablo centered trend-in-corner smaller" href="javascript:void(0);">
                                            <div class="label">
                                                Canceladas
                                            </div>
                                            <div class="value text-danger">
                                                <?php echo $cancelled = $this->crud_model->count_appointments($doctor_id, $fecha1, $fecha2, 2)->num_rows();?>
                                            </div>
                                            <div class="trending trending-up">
                                                <span><?php echo $this->crud_model->getPercentage($total,$cancelled);?>%</span>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-6 col-sm-12 col-lg-4 col-xl-6">
                                        <a class="element-box el-tablo centered trend-in-corner smaller" href="javascript:void(0);">
                                            <div class="label">
                                                Reprogramadas
                                            </div>
                                            <div class="value">
                                                <?php echo $repro = $this->crud_model->count_appointments($doctor_id, $fecha1, $fecha2, 3)->num_rows();?>
                                            </div>
                                            <div class="trending trending-up">
                                                <span><?php echo $this->crud_model->getPercentage($total,$repro);?>%</span>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-6 col-sm-12 col-lg-4 col-xl-6">
                                        <a class="element-box el-tablo centered trend-in-corner smaller" href="javascript:void(0);">
                                            <div class="label">
                                                Finalizadas
                                            </div>
                                            <div class="value">
                                                <?php echo $fin = $this->crud_model->count_appointments($doctor_id, $fecha1, $fecha2, 4)->num_rows();?>
                                            </div>
                                            <div class="trending trending-up">
                                                <span><?php echo $this->crud_model->getPercentage($total,$fin);?>%</span>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-6 col-sm-12 col-lg-4 col-xl-6">
                                        <a class="element-box el-tablo centered trend-in-corner smaller" href="javascript:void(0);">
                                            <div class="label">
                                                Pendientes
                                            </div>
                                            <div class="value">
                                                <?php echo $pending = $this->crud_model->count_appointments($doctor_id, $fecha1, $fecha2, '0')->num_rows();?>
                                            </div>
                                            <div class="trending trending-up">
                                                <span><?php echo $this->crud_model->getPercentage($total,$pending);?>%</span>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-6 col-sm-12 col-lg-4 col-xl-6">
                                        <a class="element-box el-tablo centered trend-in-corner smaller" href="javascript:void(0);">
                                            <div class="label">
                                                Confirmadas
                                            </div>
                                            <div class="value">
                                                <?php echo $confirmed = $this->crud_model->count_appointments($doctor_id, $fecha1, $fecha2, 1)->num_rows();?>
                                            </div>
                                            <div class="trending trending-up">
                                                <span><?php echo $this->crud_model->getPercentage($total,$confirmed);?>%</span>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="card-widget">
                                    <h4 class="panel-content-title">Citas por género</h4>
                                    <svg id="doughnut-chart" viewBox="0 0 600 650" style="width:100%;" preserveAspectRatio="xMidYMid meet"></svg>
                                    <div class="doughnut-tooltip"></div>
                                </div>
                            </div>
                        </div>

                        <div class="card-widget">
                            <h4 class="panel-content-title">Citas este mes</h4>
                            <span class="app-divider2"></span>
                            <canvas id="myChart" height="290" style="width:100%"></canvas>
                        </div>

                    </div>
                    <div class="col-sm-6 col-lg-4 col-xl-4">
                        <div class="card-widget">
                            <h4 class="panel-content-title">Servicios frecuentes</h4>
                            <span class="app-divider2"></span>
                            <ul class="services_more">
                                <?php 
								$query = $this->crud_model->practiceCount(); 
								             foreach($query as $service): 
                                  if($service['practice']== 0 ):
                             ?>
                                <li><i class="picons-thin-icon-thin-0825_stetoscope_doctor_hospital_ill"></i> Otros servicios</li>
                                <?php endif;
                          
                          if($service['practice']!= 0 ):
                            ?>
                                <li><i class="picons-thin-icon-thin-0825_stetoscope_doctor_hospital_ill"></i> <?php echo $this->db->get_where('service',array('service_id'=>$service['practice']))->row()->name;?></li>
                                <?php endif;
                          
                          endforeach;?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script src="<?php echo base_url();?>public/assets/theme/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.0.0-beta.11/chart.js"></script>
    <script>
const chart = new Chart('myChart', {
    type: 'line',
    data: {
        labels: [<?php $this->crud_model->get_month_report($fecha1,$fecha2); ?>],
        datasets: [{
            label: 'Tus citas',
            data: [<?php $this->crud_model->get_month_appoitments_report($doctor_id, $fecha1,$fecha2); ?>],
            backgroundColor: ['#604dcb'],
            borderWidth: 4,
            borderColor: '#604dcb',
        }]
    },
    options: {
        elements: {
            point: {
                radius: 1
            }
        },
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
$(document).ready(function() {
    all_appointments();
});
$(function() {
    'use strict';
    if ($('#DoctorPicker12').length) {
        var date = new Date();
        var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
        $('#DoctorPicker12').datepicker({
            format: "dd/mm/yyyy",
            todayHighlight: true,
            autoclose: true
        });
    }
});
$(function() {
    'use strict';
    if ($('#DocPicker').length) {
        var date = new Date();
        var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
        $('#DocPicker').datepicker({
            format: "dd/mm/yyyy",
            todayHighlight: true,
            autoclose: true
        });
    }
});
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/d3/5.9.2/d3.min.js"></script>
    <script>
var data = [{
    accountType: "Femenino",
    availableBalance: <?php $this->crud_model->get_month_appoitments_genderFamale_report($doctor_id,$fecha1,$fecha2);?>
}, {
    accountType: "Masculino",
    availableBalance: <?php $this->crud_model->get_month_appoitments_genderMale_report($doctor_id,$fecha1,$fecha2);?>
}];
const locale = "es-GT"
const currency = 'GTQ'
const chartTitle = 'Total citas por género'
var width = 600,
    height = 650,
    outerRadius = width / 2 - 50,
    innerRadius = outerRadius - 25,
    cornerRadius = 40,
    padAngle = 0.05,
    padding = 10;
let cols = []
var colors = d3
    .scaleQuantize()
    .domain([0, data.length])
    .range(["#fa896b", "#52459d"]);
var selectedTitle = undefined;
var eventObj = {
    click: function(d, i) {
        d3.event.stopPropagation();
        let dataObj = (d.data) ? d.data : d
        if (selectedTitle !== dataObj.accountType) {
            selectedTitle = dataObj.accountType;
            d3.select(".fat-path")
                .transition()
                .attr("class", "")
                .attr("stroke-width", 0);
            d3.select(this)
                .transition()
                .attr("class", "fat-path")
                .attr("stroke-width", 18);
            var d3Width = 0;
            tooltipDiv
                .html(
                    "<h5>" +
                    selectedTitle +
                    "</h5>" +
                    dataObj.availableBalance.toLocaleString({
                        style: "currency",
                        currency: false
                    })
                )
                .style("opacity", 1);

        } else {
            selectedTitle = undefined;
            d3.select(".fat-path")
                .transition()
                .attr("class", "")
                .attr("stroke-width", 0);
            tooltipDiv
                .transition()
                .duration(200)
                .style("opacity", 0);
        }
    }
};
let legendContainer = d3
    .select("svg")
    .append("g")
    .attr("class", "legend-container");
var legendItems = legendContainer
    .selectAll(".legend-item")
    .data(data)
    .enter()
    .append("g")
    .attr("class", "lengend-item")
    .attr("transform", (d, i) => `translate(${i * 100},0)`);
legendItems
    .append("circle")
    .attr("r", 14)
    .attr("fill", (d, i) => colors(i))
    .attr("x", 6)
    .attr("y", 0);
legendItems
    .append("text")
    .style("font-family", "'Work Sans', sans-serif")
    .style("font-size", "1.4em")
    .attr("x", 22)
    .attr("y", 8)
    .attr("fill", "#6A6E70")
    .text(d => d.accountType)
    .on('click', eventObj.click)
let offset = 0;
var nodeWidth = d => d.getBBox().width;
var ypos = 0,
    newxpos = 0,
    rowOffsets = [];
var legendItemsCount = data.length;
legendItems.attr("transform", function(d, index) {
    var length = nodeWidth(this) + 20;

    if (width < newxpos + length) {
        rowOffsets.push((width - newxpos) / 2);
        newxpos = 0;
        ypos += 35;
    }
    d.x = newxpos;
    d.y = ypos;
    d.rowNo = rowOffsets.length;
    newxpos += length;
    if (index === legendItemsCount - 1) rowOffsets.push((width - newxpos) / 2);
});
legendItems.attr("transform", function(d, i) {
    let x = offset;
    offset += nodeWidth(this) + 10;
    return `translate(${d.x},${d.y})`;
});
legendContainer.attr("transform", function() {
    return `translate(${(width - nodeWidth(this)) /
        2},${height - this.getBBox().height})`;
});
var textContainer = d3
    .select("svg")
    .append("g")
    .attr("class", "center-text")
    .attr(
        "transform",
        "translate(" + width / 2 + "," + (outerRadius + padding) + ")"
    );
var total = data.reduce((d, i) => (d += i.availableBalance), 0);
data = data.map(dataItem => {
    return {
        ...dataItem,
        percent: ((dataItem.availableBalance * 100) / total).toFixed(1)
    };
});
textContainer
    .append("text")
    .attr("fill", "#414243")
    .style("font-family", "'CircularStd', sans-serif")
    .attr("text-anchor", "middle")
    .attr("font-size", "7em")
    .style("font-weight", 'bold')
    .attr("y", -30)
    .attr("dominant-baseline", "hanging")
    .text(
        total.toLocaleString({
            style: "currency",
            currency: currency
        })
    );
textContainer
    .append("text")
    .attr("fill", "#6a6e70")
    .style("font-family", "Open Sans, sans-serif")
    .attr("text-anchor", "middle")
    .attr("y", 95)
    .style("font-size", "1.5em")
    .text(chartTitle);
var tooltipDiv = d3.select(".doughnut-tooltip");
var pie = d3
    .pie()
    .value(function(d) {
        return d.availableBalance;
    })
    .padAngle(padAngle);
var arcs = pie(data);
var arc = d3
    .arc()
    .innerRadius(innerRadius)
    .outerRadius(outerRadius)
    .cornerRadius(cornerRadius);
var svg = d3
    .select("svg")
    .append("g")
    .attr(
        "transform",
        "translate(" + width / 2 + "," + (outerRadius + padding) + ")"
    );
d3.select("svg").on("click", function() {
    d3.select(".fat-path")
        .transition()
        .duration(500)
        .attr("class", "")
        .attr("stroke-width", 0);
    tooltipDiv
        .transition()
        .duration(200)
        .style("opacity", 0);
});
svg
    .append("g")
    .selectAll("path")
    .data(arcs)
    .enter()
    .append("path")
    .style("fill", function(d, i) {
        return colors(i);
    })
    .style("stroke", function(d, i) {
        return colors(i);
    })
    .attr("stroke-width", 10)
    .attr("d", arc)
    .on("click", eventObj.click);
$('.itemName').select2();
    </script>