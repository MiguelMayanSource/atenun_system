<?php 
    $week_days  = $this->crud_model->date_week(date('Y-m-d'));
    $week_name_days  = $this->crud_model->panelDate();
?>

<link href="<?php echo base_url();?>public/assets/appointments/css/select2.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<?php include "navigation_memberships.php"; ?>
<div id="main-content">
    <?php $insurance = $this->db->get_where('insurance',array('status'=>1,'clinic_id'=>$this->session->userdata('current_clinic')))->result_array();?>
    <div class="row">
        <div class="col-sm-12">
            <div class="title-header">
                <h3 class="module-title">Planes</h3>
                <a class="add-buton pull-right" href="<?php echo base_url(); ?>/admin/membership_plans_add">+ Agregar Plan</a>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="card-widget">
                <div class="table-responsive">
                    <table class="table table-padded" id="user_data">
                        <thead>
                            <tr>
                                <th>Nombre de Membrecía</th>
                                <th># de Planes</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $this->db->select('*, COUNT(*) as total');
                            $this->db->from('membership_plans m');
                            $this->db->join('membership mp', 'm.membership_id = mp.membership_id');
                            $this->db->where("m.status = 1");
                            $this->db->group_by('m.membership_id');
                            $resultado =  $this->db->get()->result_array();
                            foreach ($resultado as $row): ?>
                            <tr>
                                <td><?php echo $row['name'];?></td>
                                <td><?php echo $row['total'];?></td>
                                <td>
                                    <a class="" href="<?php echo base_url();?>admin/membership_plans_details/<?php echo base64_encode($row['membership_id']); ?>">
                                        <i class="iconBox picons-thin-icon-thin-0064_bullet_list_view"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
$(function() {
    $('#user_data').dataTable({

    })
});

$('.os-dropdown-trigger').on('mouseenter', function() {
    $(this).addClass('over');
});
$('.os-dropdown-trigger').on('mouseleave', function() {
    $(this).removeClass('over');
});

$(function() {
    'use strict';
    $('.itemName').select2();
    $('.select22').select2();
    $("#applyDate").trigger("change");
    if ($('#DoctorPicker1').length) {
        var date = new Date();
        var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
        $('#DoctorPicker1').datepicker({
            format: "dd/mm/yyyy",
            todayHighlight: true,
            autoclose: true
        });
    }
});

function delete_memebership(id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "Esta acción no puede deshacerse. ¿Aún así, desea continuar?",
        type: 'info',
        showCancelButton: true,
        confirmButtonColor: '#9fd13b',
        cancelButtonColor: '#fd4f57',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.value) {
            location.href = "<?php echo base_url();?>admin/memberships/delete_membership/" + id;
        }
    })
}
</script>