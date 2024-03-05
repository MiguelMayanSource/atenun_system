<?php 
    $week_days  = $this->crud_model->date_week(date('Y-m-d'));
    $week_name_days  = $this->crud_model->panelDate();
?>

<link href="<?php echo base_url();?>public/assets/appointments/css/select2.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<?php include "navigation_memberships.php"; ?>
<div id="main-content">
    <div class="row">
        <div class="col-sm-12">
            <div class="title-header">
                <h3 class="module-title">Planes de: <?php echo $this->db->get_where("membership",array("membership_id"=>$membership_id))->row()->name; ?></h3>
                <a class="add-buton pull-right" href="<?php echo base_url(); ?>admin/membership_plans_add/<?php echo base64_encode($membership_id); ?>">+ Agregar Plan</a>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="card-widget">
                <div class="table-responsive">
                    <table class="table table-padded" id="user_data">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th>Días</th>
                                <th>Precio</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $this->db->select("*");
                            $this->db->from("membership_plans mp");
                            $this->db->join("membership m","m.membership_id = mp.membership_id");
                            $this->db->join("plans p","p.membership_plans_id = mp.membership_plans_id");
                            $this->db->where("mp.membership_id", $membership_id);
                            $this->db->where("mp.status",1);
                            $resultado = $this->db->get()->result_array();
                            foreach ($resultado as $row): ?>
                            <tr>
                                <td><?php echo $row['name'];?></td>
                                <td><?php echo $row['description'];?></td>
                                <td><?php echo $row['days'];?></td>
                                <td><?php echo $row['price'];?></td>
                                <td>
                                    <a class="" href="javascript:void(0)" onclick="showAjaxModal('<?php echo base_url().'modal/popup/modal_membership_edit_plan/'.base64_encode($row['membership_plans_id']).'/'.base64_encode($membership_id);?>')">
                                        <i class="iconBox picons-thin-icon-thin-0001_compose_write_pencil_new"></i>
                                    </a>
                                    <a class="" href="javascript:void(0)" onclick="delete_memebership_plan('<?php echo base64_encode($row['membership_plans_id']); ?>')">
                                        <i class="iconBox picons-thin-icon-thin-0056_bin_trash_recycle_delete_garbage_empty"></i>
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

function delete_memebership_plan(id) {
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
            location.href = "<?php echo base_url();?>admin/membership_plans_add/delete/" + id;
        }
    })
}
</script>