<h5 class="panel-content-title">Citas del paciente <?php if($page_name != "patient_profile"):?><a href="javascript:void(0)" onclick="load_view('new_labs','labs')" style="margin-bottom:10px" class="btn btn-info float-right mb-10">Nueva orden de laboratorio</a><?php endif; ?></h5>
<span class="app-divider2"></span>
<div class="row">
    <div class="col-sm-12">
        <div class="row">
            <div class="col-sm-12 col-xl-3">
                <div class="element-box el-tablo centered trend-in-corner smaller" href="javascript:void(0);" style="cursor:pointer;">
                    <div class="label">
                        Citas pendientes
                    </div>
                    <div class="value">
                        <?php echo $this->db->where_in('status',array(0,10))->get_where('appointment',array('clinic_id'=>$this->session->userdata('current_clinic'),'patient_id'=>$patient_id))->num_rows(); ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-xl-3">
                <div class="element-box el-tablo centered trend-in-corner smaller" href="javascript:void(0);" style="cursor:pointer;">
                    <div class="label">
                        Citas confirmadas
                    </div>
                    <div class="value">
                        <?php echo $this->db->get_where('appointment',array('clinic_id'=>$this->session->userdata('current_clinic'),'patient_id'=>$patient_id,'status'=> 1))->num_rows(); ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-xl-3">
                <div class="element-box el-tablo centered trend-in-corner smaller" href="javascript:void(0);" style="cursor:pointer;">
                    <div class="label">
                        Citas finalizadas
                    </div>
                    <div class="value">
                        <?php echo $this->db->get_where('appointment',array('clinic_id'=>$this->session->userdata('current_clinic'),'patient_id'=>$patient_id,'status'=> 4))->num_rows(); ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-xl-3">
                <div class="element-box el-tablo centered trend-in-corner smaller" href="javascript:void(0);" style="cursor:pointer;">
                    <div class="label">
                        Citas canceladas
                    </div>
                    <div class="value">
                        <?php  echo $this->db->get_where('appointment',array('clinic_id'=>$this->session->userdata('current_clinic'),'patient_id'=>$patient_id,'status'=> 2))->num_rows(); ?>
                    </div>
                </div>
            </div>
        </div><br>
    </div>
    <div class="col-sm-12">
        <div class="tasks-section">
            <div class="table-responsive">
                <table class="table table-padded" id="user_data">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Paciente</th>
                            <th>Especialista</th>
                            <th>Fecha & Hora</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
<link rel="stylesheet" href="<?php echo base_url();?>public/assets/theme/css/jquery.dataTables.min.css">
<script src="<?php echo base_url();?>public/assets/theme/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" language="javascript">
$(document).ready(function() {
    var dataTable = $('#user_data').DataTable({
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            url: "<?php echo base_url() . 'admin/getTable/patient_appointments/'.$patient_id; ?>",
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


</script>