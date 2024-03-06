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
                <a class="add-buton pull-right" href="javascript:void(0)" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_new_plan');">+ Agregar Plan</a>
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
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $this->db->where("status",1);
                            $resultado =  $this->db->get("plans")->result_array();
                            foreach ($resultado as $row): ?>
                            <tr>
                                <td><?php echo $row['name'];?></td>
                                <td><?php echo $row['description'];?></td>
                                <td><?php echo $row['days'];?></td>
                                <td>
                                    <a class="" href="javascript:void(0)" onclick="showAjaxModal('<?php echo base_url().'modal/popup/modal_new_plan_edit/'.base64_encode($row['plans_id']);?>')">
                                        <i class="iconBox picons-thin-icon-thin-0001_compose_write_pencil_new"></i>
                                    </a>
                                    <a class="" href="javascript:void(0)" onclick="delete_memebership('<?php echo base64_encode($row['plans_id']); ?>')">
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
            location.href = "<?php echo base_url();?>admin/membership_plans/delete/" + id;
        }
    })
}
</script>