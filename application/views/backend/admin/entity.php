<?php 
    $week_days  = $this->crud_model->date_week(date('Y-m-d'));
    $week_name_days  = $this->crud_model->panelDate();
?>

<?php include "navigation_entity.php"; ?>

<div id="main-content">
    <?php 
    $this->db->where("category_entity_id", $id_category);
    $entitys = $this->db->get_where('entity',array('status'=>1))->result_array();?>

    <div class="row">
    <div class="col-sm-12">
            <div class="title-header">
            </div>
        </div>
        <div class="col-sm-12">
            <div class="title-header">
                <h3 class="module-title"><?php echo $this->db->get_where("category_entity",array("category_entity_id"=>$id_category))->row()->name;  ?></h3>
                <a class="add-buton pull-right btn btn-primary" href="<?php echo base_url()?>admin/entity_new/<?php echo base64_encode($id_category); ?>">+ Agregar Entidad</a>
                <a class="add-buton pull-right btn btn-success" href="<?php echo base_url();?>admin/contact_file/all_contact_export/<?php echo $id_category;?>"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><path fill="currentColor" d="M13 9V5h-2v6H9.83L12 13.17L14.17 11H13z" opacity="0.3"/><path fill="currentColor" d="M15 9V3H9v6H5l7 7l7-7zm-3 4.17L9.83 11H11V5h2v6h1.17zM5 18h14v2H5z"/></svg></a>
                <a class="add-buton pull-right btn btn-warning" href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/modal_contact_import');"> <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><path fill="currentColor" d="M9 16h6v-6h4l-7-7l-7 7h4zm-4 2h14v2H5z"/></svg></a>
            </div>
        </div>

        <?php foreach($entitys as $row):?>
        <div class="col-sm-3">
            <div class="profile-tile profile-tile-inlined">
                <div class="profile-tile-box">
                    <div class="tile-controls">
                        <div class="tile-settings os-dropdown-trigger">
                            <i class="batch-icon-ellipsis"></i>
                            <div class="os-dropdown">
                                <div class="icon-w">
                                    <i class="picons-thin-icon-thin-0699_user_profile_avatar_man_male"></i>
                                </div>
                                <ul>
                                    <li><a href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url(); ?>modal/popup/modal_contact_import');"><i class="picons-thin-icon-thin-0124_upload_cloud_file_sync_backup"></i><span>Importar Contactos</span></a>
                                    </li>
                                    <li><a href="<?php echo base_url();?>admin/contact_file/all_contact_export/<?php echo $id_category;?>/<?php echo $row['entity_id'];?>"><i class="picons-thin-icon-thin-0121_download_file"></i><span>Exportar Contactos</span></a>
                                    </li>
                                    <li><a href="<?php echo base_url()?>admin/entity_edit/<?php echo base64_encode($row['entity_id'])."/".base64_encode($id_category);?>"><i class="picons-thin-icon-thin-0001_compose_write_pencil_new"></i><span>Actualizar</span></a>
                                    <li><a href="javascript:void(0);" onclick="delete_entity('<?php echo $row['entity_id']?>','<?php echo $id_category; ?>')"><i class="picons-thin-icon-thin-0056_bin_trash_recycle_delete_garbage_empty"></i><span>Eliminar</span></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="" style="display: inline-block;width: 113px;height: auto;font-size: 60px;background: #042d50;color: white;padding: 10px;border-radius: 50%;"><i class="picons-thin-icon-thin-0823_hospital_ill_medicine_doctor_ambulance"></i></div>
                    <div class="pt-user-last"><?php echo $row['first_name'  ];?></div>
                    <div class="pt-user-name" onclick="window.location.href='<?php echo base_url();?>admin/entity_list/<?php echo base64_encode($row['entity_id']);?>';">
                        Ver</div>
                </div>
            </div>
        </div>
        <?php endforeach;?>
    </div>
</div>

<script type="text/javascript">
$('.os-dropdown-trigger').on('mouseenter', function() {
    $(this).addClass('over');
});
$('.os-dropdown-trigger').on('mouseleave', function() {
    $(this).removeClass('over');
});

function delete_entity(entity_id,id_category) {
    Swal.fire({
        title: "¡Advertencia!",
        text: "Esta acción no puede deshacerse, perderá información de sus pacientes, citas. ¿Aún así, desea continuar?",
        type: 'info',
        showCancelButton: true,
        confirmButtonColor: '#9fd13b',
        cancelButtonColor: '#fd4f57',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.value) {
            location.href = "<?php echo base_url();?>admin/entity/delete/" + entity_id +"/"+ id_category;
        }
    })
}

</script>