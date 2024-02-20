<div class="white-box">
    <div class="os-tabs-w">
        <div class="os-tabs-controls">
            <ul class="navx nav-tabs">
                <li class="nav-item text-center">
                    <a class="nav-link current " href="<?php echo base_url();?>doctor/inventory/">
                        <div class="navWidget"><i class="picons-thin-icon-thin-0820_medicine_drugs_ill_pill"></i></div>
                        <span>Inventarios</span>
                    </a>
                </li>
                <li class="nav-item text-center">
                    <a class="nav-link" href="<?php echo base_url();?>doctor/purchases/">
                        <div class="navWidget"><i class="picons-thin-icon-thin-0101_notes_text_notebook"></i></div>
                        <span>Ordenes de compra</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
<div id="main-content">
    <?php $inventorys = $this->db->get_where('inventory',array('status'=>1,'clinic_id'=>$this->session->userdata('current_clinic')))->result_array();?>
    <?php if(count($inventorys) > 0):?>
    <div class="row">
        <div class="col-sm-12">
            <div class="title-header">
                <h3 class="module-title">Inventarios habilitados</h3>
                <a class="add-buton pull-right" href="javascript:void(0)" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_new_inventory');">+ Agregar inventario</a>
            </div>
        </div>
        <?php foreach($inventorys as $row):?>
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
                                    <li><a href="javascript:void(0);" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_update_inventory/<?php echo base64_encode($row['inventory_id']) ?>');"><i class="picons-thin-icon-thin-0001_compose_write_pencil_new"></i><span>Actualizar</span></a>
                                    </li>
                                    <li><a href="javascript:void(0);" onclick="delete_inventory('<?php echo base64_encode($row['inventory_id']);?>');"><i class="picons-thin-icon-thin-0056_bin_trash_recycle_delete_garbage_empty"></i><span>Eliminar</span></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="" style="    display: inline-block;width: 113px;height: auto;font-size: 60px;background: #042d50;color: white;padding: 10px;border-radius: 50%;"><i class="<?php echo $row['icon'];?>"></i></div>
                    <div class="pt-user-last"><?php echo $row['name'];?></div>
                    <span class="badge badge-warning"><?php echo $row['type']==1?'Interno':'Externo';?></span>
                    <div class="pt-user-name" onclick="window.location.href='<?php echo base_url();?>doctor/inventory_products/<?php echo base64_encode($row['inventory_id']);?>';">
                        Productos/Servicios</div>
                </div>
            </div>
        </div>
        <?php endforeach;?>
    </div>
    <?php else:?>
    <div class="card-box">
        <center><br><br><br>
            <a class="add-buton pull-right" href="javascript:void(0)" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_new_inventory');">+ Agregar inventario</a>
            <h4 style="text-align:center;color:#4d4a81;margin-top:2%;">Aún no se tienes inventarios registrados</h4>
            <img src="<?php echo base_url() ?>public/uploads/medicamentos.svg" style="width:25%" />
        </center>
    </div>

    <?php endif;?>

</div>



<link href="<?php echo base_url();?>public/assets/appointments/css/select2.css" rel="stylesheet" />

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>


<script type="text/javascript">
$('.os-dropdown-trigger').on('mouseenter', function() {
    $(this).addClass('over');
});
$('.os-dropdown-trigger').on('mouseleave', function() {
    $(this).removeClass('over');
});

function delete_inventory(inventory_id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "También se eliminará toda la información asociada al inventario.",
        type: 'info',
        showCancelButton: true,
        confirmButtonColor: '#9fd13b',
        cancelButtonColor: '#fd4f57',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.value) {
            location.href = "<?php echo base_url();?>doctor/inventory/delete_inventory/" + inventory_id;
        }
    })
}
</script>