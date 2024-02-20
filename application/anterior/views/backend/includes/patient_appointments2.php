<h5 class="panel-content-title">Citas del paciente <?php if($page_name != "patient_profile"):?><a href="javascript:void(0)" onclick="load_view('complete_evol','evol',{'patient_id':<?php echo $patient_id; ?>})" style="margin-bottom:10px" class="btn btn-info float-right mb-10">Evolucion clínica completa</a><?php endif; ?></h5>
<span class="app-divider2"></span>
<div class="row"> 
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