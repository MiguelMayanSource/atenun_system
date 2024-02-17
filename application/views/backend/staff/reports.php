<link href="<?php echo base_url();?>public/assets/appointments/css/select2.css" rel="stylesheet" />
<div class="white-box">
    <div class="os-tabs-w">
        <div class="os-tabs-controls">
            <ul class="navx nav-tabs">
                <li class="nav-item text-center">
                    <a class="nav-link" href="<?php echo base_url();?>staff/financial_reports/">
                        <div class="navWidget"><i class="picons-thin-icon-thin-0425_money_payment_dollar_cash"></i>
                        </div> <span>Financiero</span>
                    </a>
                </li>
                <li class="nav-item text-center">
                    <a class="nav-link" href="<?php echo base_url();?>staff/appointment_reports/">
                        <div class="navWidget"><i class="picons-thin-icon-thin-0021_calendar_month_day_planner"></i>
                        </div> <span>Cirugías</span>
                    </a>
                </li>
                <?php 
                      $inventory = $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->product_module;
                      if($inventory == 1):
                    ?>
                <li class="nav-item text-center">
                    <a class="nav-link" href="<?php echo base_url();?>staff/inventory_reports/">
                        <div class="navWidget"><i class="picons-thin-icon-thin-0820_medicine_drugs_ill_pill"></i></div>
                        <span>Inventario</span>
                    </a>
                </li>
                <?php endif;?>
                <li class="nav-item text-center">
                    <a class="nav-link current" href="<?php echo base_url();?>staff/reports/">
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
            <div class="title-header">
                <div class="card-widget">
                    <h4 class="panel-content-title">Seleccionar usuario</h4>
                    <span class="app-divider2"></span>
                    <form action="<?php echo base_url();?>staff/reports" method="POST" id="filter_form">
                        <select class="itemName form-control select2" style="width:100%" onChange="submitForm();" name="user_type">
                            <option value="">Seleccionar usuario</option>
                            <?php 
										$query = $this->crud_model->users_activity($this->session->userdata('current_clinic'));
									    foreach($query as $row): ?>
                            <?php if($row['type'] == 'doctor'){$user ='admin';} else {$user = $row['type'];} ?>
                            <option value="<?php echo $row['_id'].",".$row['type']?>" <?php if($_id == $row['_id'] && $type == $row['type']) echo "selected"?>>
                                <?php echo $this->accounts_model->get_name($user, $row['_id']);?></option>
                            <?php endforeach;?>
                        </select>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-sm-12">
            <?php 
				    if($_id != '' && $type != ''):
                        if($type == 'doctor')
                        {
                            $type = 'admin';
                        }
                ?>

            <div class="table-responsive">
                <table class="table table-padded" id="user_data">
                    <thead style="color: #a2a5b9;">
                        <th>Acción</th>
                        <th class="text-right">Fecha y hora</th>
                    </thead>
                </table>
            </div>

            <?php else:?>
            <div class="container" style="margin-top:5%;">
                <center>
                    <h4 class="panel-content-title">Primero elige a un usuario</h4><span class="app-divider2"></span>
                </center>
                <center><img src="<?php echo base_url();?>public/assets/theme/images/dr.png" width="30%"></center>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<script src="<?php echo base_url();?>public/assets/theme/js/select2.min.js"></script>
<?php if($_id != '' && $type != ''):?>
<script type="text/javascript" language="javascript">
$(document).ready(function() {
    var dataTable = $('#user_data').DataTable({
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            url: "<?php echo base_url() . 'staff/getTable/activities/'.$_id.'/'.$type; ?>",
            type: "POST"
        },

        "columnDefs": [{
            "targets": 0,
            "orderable": false,
        }, ],
    });
});
</script>
<?php endif;?>
<script>
function submitForm() {
    var formObject = document.forms['filter_form'];
    formObject.submit();
}
</script>
<script type="text/javascript">
$('.itemName').select2();
</script>