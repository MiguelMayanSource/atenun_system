<style>
.selected_property {
    transform: translateY(-5px) scale(1.02);
    box-shadow: 0px 5px 12px rgb(126 142 177 / 20%);
}

.selected_property .value {
    -webkit-transform: scale(1.1) translateY(-3px);
    transform: scale(1.1) translateY(-3px);
    color: #0056b3 !important;
}

.selected_property .label {
    -webkit-transform: translateY(-2px);
    transform: translateY(-2px);
    color: #0056b3 !important;
}
</style>
<div class="white-box">
    <div class="os-tabs-w">
        <div class="os-tabs-controls">
            <ul class="navx nav-tabs">
                <li class="nav-item text-center">
                    <a class="nav-link" href="<?php echo base_url();?>admin/financial_reports/">
                        <div class="navWidget"><i class="picons-thin-icon-thin-0425_money_payment_dollar_cash"></i>
                        </div> <span>Financiero</span>
                    </a>
                </li>
                <li class="nav-item text-center">
                    <a class="nav-link " href="<?php echo base_url();?>admin/appointment_reports/">
                        <div class="navWidget"><i class="picons-thin-icon-thin-0021_calendar_month_day_planner"></i>
                        </div> <span>Cirugías</span>
                    </a>
                </li>
                <li class="nav-item text-center">
                    <a class="nav-link current" href="<?php echo base_url();?>admin/inventory_reports/">
                        <div class="navWidget"><i class="picons-thin-icon-thin-0820_medicine_drugs_ill_pill"></i></div>
                        <span>Inventario</span>
                    </a>
                </li>
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
            <div class="row">
                <div class="col-sm-8">
                    <div class="row">
                        <div class="col-md-4 col-lg-12 col-xl-4">
                            <a id="start" class="element-box el-tablo centered trend-in-corner smaller selected_property" onclick="total_table(this)" href="javascript:void(0);" style="cursor:pointer;">
                                <div class="label">
                                    Total de productos

                                </div>
                                <br>
                                <div class="value">
                                    <?php echo $this->crud_model->count_cost()->num_rows(); ?>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-2 col-lg-12 col-xl-2">
                            <a class="element-box el-tablo centered trend-in-corner smaller " onclick="alert_table(this)" href="javascript:void(0);" style="cursor:pointer;">
                                <div class="label">
                                    Productos en alerta
                                </div>
                                <div class="value">
                                    <?php echo count($this->crud_model->count_alert()); ?>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-2 col-lg-12 col-xl-2">
                            <a class="element-box el-tablo centered trend-in-corner smaller " onclick="vencer_table(this)" href="javascript:void(0);" style="cursor:pointer;">
                                <div class="label">
                                    Productos por vencer
                                </div>
                                <div class="value">
                                    <?php  echo count($this->crud_model->product_per_expiration());?>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-2 col-lg-12 col-xl-2">
                            <a class="element-box el-tablo centered trend-in-corner smaller" onclick="vencido_table(this)" href="javascript:void(0);" style="cursor:pointer;">
                                <div class="label">
                                    Productos vencidos
                                </div>
                                <div class="value">
                                    <?php echo $this->crud_model->product_expiration()->num_rows();?>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-2 col-lg-12 col-xl-2">
                            <a class="element-box el-tablo centered trend-in-corner smaller" onclick="agotado_table(this)" href="javascript:void(0);" style="cursor:pointer;">
                                <div class="label">
                                    Productos agotados
                                </div>
                                <div class="value">
                                    <?php echo count($this->crud_model->product_outstock());?>
                                </div>
                            </a>
                        </div>

                    </div>
                    <br>
                    <div class="card-widget">
                        <div id="title">

                        </div>
                        <span class="app-divider2"></span>
                        <div id="table_ajax" class="table-responsive">
                            <hr>
                        </div>
                    </div>

                </div>
                <div class="col-sm-4">
                    <div class="card-widget">
                        <h4 class="panel-content-title">Productos Frecuentes</h4>
                        <span class="app-divider2"></span>
                        <ul class="services_more">
                            <?php $prod = $this->db->limit(8)->order_by('product_id','DESC')->get('product')->result_array();
                                    foreach($prod as $res):?>
                            <a href="<?php echo base_url(); ?>admin/history/<?php  echo $res['product_id'];?>">
                                <li><i class="picons-thin-icon-thin-0825_stetoscope_doctor_hospital_ill"></i>
                                    <?php echo $res['name'] ;?>
                                </li>
                            </a>
                            <?php endforeach;?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<script>
$(document).ready(function() {
    total_table(document.getElementById("start"));
});
</script>

<script>
var previus = document.getElementById("start");

function total_table(card) {
    $.ajax({
        url: '<?php echo base_url();?>admin/total_inventario/',
        success: function(response) {
            jQuery('#table_ajax').html(response);
            $('#mainTable').DataTable();
            previus.classList.remove("selected_property");
            card.classList.add("selected_property");

            previus = card;
            $('#title').html(`<h4 class="panel-content-title" >Todos los productos</h4>
                        <a target="_blank" class="add-buton pull-right" style="margin-right:1px;" href="<?php echo base_url();?>admin/print_inventory_report/all">IMPRIMIR</a>
                        <a class="add-buton pull-right" style="margin-right:1px;" href="<?php echo base_url();?>admin/excel_inventory_report/all">EXCEL</a>
                        `);
        }
    });
}

function alert_table(card) {

    $.ajax({
        url: '<?php echo base_url();?>admin/alert_table/',
        success: function(response) {
            console.log(response);
            jQuery('#table_ajax').html(response);
            $('#mainTable').DataTable();
            previus.classList.remove("selected_property");
            card.classList.add("selected_property");

            previus = card;
            $('#title').html(`<h4 class="panel-content-title" >Productos en alerta</h4>
                        <a target="_blank" class="add-buton pull-right" style="margin-right:1px;" href="<?php echo base_url();?>admin/print_inventory_report/alert">IMPRIMIR</a>
                        <a class="add-buton pull-right" style="margin-right:1px;" href="<?php echo base_url();?>admin/excel_inventory_report/alert">EXCEL</a>
                        `);
        }
    });
}

function vencido_table(card) {

    $.ajax({
        url: '<?php echo base_url();?>admin/vencido_inventario/',
        success: function(response) {
            console.log(response);
            jQuery('#table_ajax').html(response);
            $('#mainTable').DataTable();
            previus.classList.remove("selected_property");
            card.classList.add("selected_property");

            previus = card;
            $('#title').html(`<h4 class="panel-content-title" >Productos vencidos</h4>
                        <a target="_blank" class="add-buton pull-right" style="margin-right:1px;" href="<?php echo base_url();?>admin/print_inventory_report/expirate">IMPRIMIR</a>
                        <a class="add-buton pull-right" style="margin-right:1px;" href="<?php echo base_url();?>admin/excel_inventory_report/expirate">EXCEL</a>
                        `);
        }
    });
}

function vencer_table(card) {
    $.ajax({
        url: '<?php echo base_url();?>admin/vencer_inventario/',
        success: function(response) {
            jQuery('#table_ajax').html(response);
            $('#mainTable').DataTable();

            previus.classList.remove("selected_property");
            card.classList.add("selected_property");

            previus = card;
            $('#title').html(`<h4 class="panel-content-title" >Productos por vencer</h4>
                        <a target="_blank" class="add-buton pull-right" style="margin-right:1px;" href="<?php echo base_url();?>admin/print_inventory_report/per_expirate">IMPRIMIR</a>
                        <a class="add-buton pull-right" style="margin-right:1px;" href="<?php echo base_url();?>admin/excel_inventory_report/per_expirate">EXCEL</a>
                        `);
        }
    });
}

function agotado_table(card) {
    $.ajax({
        url: '<?php echo base_url();?>admin/agotado_inventario/',
        success: function(response) {
            jQuery('#table_ajax').html(response);
            $('#mainTable').DataTable();
            previus.classList.remove("selected_property");
            card.classList.add("selected_property");

            previus = card;

            $('#title').html(`<h4 class="panel-content-title" >Productos agotados</h4>
                        <a target="_blank" class="add-buton pull-right" style="margin-right:1px;" href="<?php echo base_url();?>admin/print_inventory_report/out">IMPRIMIR</a>
                        <a class="add-buton pull-right" style="margin-right:1px;" href="<?php echo base_url();?>admin/excel_inventory_report/out">EXCEL</a>
                        `);
        }
    });
}
</script>