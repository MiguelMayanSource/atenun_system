<?php 
    $week_days  = $this->crud_model->date_week(date('Y-m-d'));
    $week_name_days  = $this->crud_model->panelDate();
?>
<div id="main-content">
    <div class="row">
        <div class="col-sm-12">
            <div class="title-header">
                <h3 class="module-title">Hospitalización</h3>
                <a class="add-buton pull-right" href="javascript:void(0);" onclick="modal_lg('<?php echo base_url();?>modal/popup/modal_new_stabilitation');">+ Agregar
                    hospitalización</a>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="table-responsive">
                <table class="table table-padded" id="user_data">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Paciente</th>
                            <th>Ingreso</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
$('.os-dropdown-trigger').on('mouseenter', function() {
    $(this).addClass('over');
});
$('.os-dropdown-trigger').on('mouseleave', function() {
    $(this).removeClass('over');
});
</script>

<script type="text/javascript" language="javascript">
$(document).ready(function() {
    var dataTable = $('#user_data').DataTable({
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            url: "<?php echo base_url() . 'admin/getTable/financial_stabilitation'; ?>",
            type: "POST"
        },

        "columnDefs": [{
            "targets": 0,
            "orderable": false,
        }, ],
    });
});
</script>

<script type="text/javascript">
function delete_patient(patient_id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "También se eliminará toda la información asociada a este paciente.",
        type: 'info',
        showCancelButton: true,
        confirmButtonColor: '#9fd13b',
        cancelButtonColor: '#fd4f57',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.value) {
            location.href = "<?php echo base_url();?>admin/stabilitation/delete/" + patient_id;
        }
    })
}
</script>