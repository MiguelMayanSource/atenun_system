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
                <h3 class="module-title"><?php echo $this->db->get_where("category_entity",array("category_entity_id"=>$id_category))->row()->name;  ?></h3>
                <a class="add-buton pull-right btn btn-primary" href="<?php echo base_url()?>admin/entity_new/<?php echo base64_encode($id_category); ?>">+ Agregar Entidad</a>
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
                                    <li><a href="<?php echo base_url()?>admin/entity_edit/<?php echo base64_encode($row['entity_id']);?>"><i class="picons-thin-icon-thin-0001_compose_write_pencil_new"></i><span>Actualizar</span></a>
                                    </li>
                                    <li><a href="javascript:void(0);" onclick="delete_insurance('<?php echo $row['entity_id'];?>')"><i class="picons-thin-icon-thin-0056_bin_trash_recycle_delete_garbage_empty"></i><span>Eliminar</span></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="" style="display: inline-block;width: 113px;height: auto;font-size: 60px;background: #042d50;color: white;padding: 10px;border-radius: 50%;"><i class="picons-thin-icon-thin-0823_hospital_ill_medicine_doctor_ambulance"></i></div>
                    <div class="pt-user-last"><?php echo $row['first_name'  ];?></div>
                    <div class="pt-user-name" onclick="window.location.href='<?php echo base_url();?>admin/patients_list/<?php echo base64_encode($row['insurance_id']);?>';">
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


</script>