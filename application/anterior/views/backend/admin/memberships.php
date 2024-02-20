<?php 
    $week_days  = $this->crud_model->date_week(date('Y-m-d'));
    $week_name_days  = $this->crud_model->panelDate();
?>

<div id="main-content">
    <?php $insurance = $this->db->get_where('insurance',array('status'=>1,'clinic_id'=>$this->session->userdata('current_clinic')))->result_array();?>

    <div class="row">
        <div class="col-sm-12">
            <div class="title-header">
                <h3 class="module-title">Membresias</h3>
                <a class="add-buton pull-right" href="javascript:void(0)" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_new_membership');">+ Agregar membresia</a>
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
                                <th>Pacientes</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $memebership = $this->db->get_where('membership',array('status'=>1))->result_array(); 
                            foreach ($memebership as $row):
                            ?>
                            <tr>
                                <td><?php echo $row['name'];?></td>
                                <td><?php echo $row['description'];?></td>
                                <td><?php echo $this->crud_model->count_patient_membership($row['membership_id']);?></td>
                                <td>
                                    <a class="" href="javascript:void(0)" onclick="showAjaxModal('<?php echo base_url().'modal/popup/modal_edit_membership/'.base64_encode($row['membership_id']);?>')">
                                        <i class="iconBox picons-thin-icon-thin-0001_compose_write_pencil_new"></i>
                                    </a>
                                    <a class="" href="<?php echo base_url();?>admin/membership_details/<?php echo base64_encode($row['membership_id']); ?>">
                                        <i class="iconBox picons-thin-icon-thin-0064_bullet_list_view"></i>
                                    </a>
                                    <a class="" href="javascript:void(0)" onclick="delete_memebership('<?php echo base64_encode($row['membership_id']); ?>')">
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
<div class="modal" id="1specialtiesModal">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content animated fadeInDown">
            <form action="<?php echo base_url();?>admin/insurance/create" method="POST">
                <div class="modal-header" style="background-color:#fff; box-shadow: 0 4px 2px -2px 000;">
                    <h4 style="font-size:21px; color:#565b6b; font-family:'Poppins';"><span style="vertical-align:-3px"> Agregar nueva aseguradora.</span></h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="container">
                            <div class="row">
                                <div class="col-sm-8">
                                    <div class="form-group m-b-15">
                                        <label for="simpleinput">Nombre</label>
                                        <input type="text" name="name" required="" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group m-b-15">
                                        <label for="simpleinput">NIT</label>
                                        <input type="text" name="nit" required="" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group m-b-15">
                                        <label for="simpleinput">Direccíon de facturación</label>
                                        <textarea type="text" name="address" required="" class="form-control"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="button-confirm">Enviar</button>
                </div>
            </form>
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