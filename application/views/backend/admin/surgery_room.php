<div class="white-box">
    <div class="os-tabs-w">
        <div class="os-tabs-controls">
            <ul class="navx nav-tabs">
                <li class="nav-item text-center">
                    <a class="nav-link " href="<?php echo base_url();?>admin/rooms/">
                        <div class="navWidget"><i class="picons-thin-icon-thin-0094_file_table"></i>
                        </div>
                        <span>Habitaciones</span>
                    </a>
                </li>
                <li class="nav-item text-center">
                    <a class="nav-link current" href="<?php echo base_url();?>admin/surgery_room/">
                        <div class="navWidget"><i class="picons-thin-icon-thin-0064_bullet_list_view"></i></div>
                        <span>Salas de cirugía</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
<div id="main-content">
    <div class="card-box padding0">
        <div class="card-h customPadding noborder">
            <h5 class="card-caption">Gestionar salas de cirugías</h5><a class="btn btn-info pull-right" href="javascript:void(0)" onclick="modal_lg('<?php echo base_url();?>modal/popup/surgery_room_add/');" style="margin-right:45px">Nueva sala de cirugía</a>
        </div>
        <div class="card-b">
            <div class="container-fluid">
                <div class="alert alert-info">
                    <span class="alert-title"><i class="batch-icon-spam"></i> Agrega, actualiza y elimina tus
                        salas de cirugías.</span>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 col-lg-12 col-xl-12 m-b-30">
                    <div class="support-tablist-content tab-content">
                        <div class="main-table-card">
                            <div class="table-responsive">
                                <table class="table custom-table table-striped">
                                    <thead style="color: #a2a5b9;">
                                        <tr>
                                            <th>ID</th>
                                            <th>Nombre</th>
                                            <th>Descripción</th>
                                            <th>Estado</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $n = 1;$this->db->order_by('name', 'ASC');$this->db->where('clinic_id',$this->session->userdata('current_clinic'));
                                        $rooms = $this->db->get('surgery_room')->result_array();foreach($rooms as $row):?>
                                        <tr style="font-family:'Poppins';font-size:14px;font-weight:bold;color:#4b4a55" class="">
                                            <td><?php echo sprintf('%04d', $row['surgery_room_id']);?></td>
                                            <td><span style="font-weight:normal"><?php echo $row['name'];?></span>
                                            </td>
                                            <td><span style="font-weight:normal"><?php echo $row['description'];?></span>
                                            </td>
                                            <td>
                                                <?php if($row['status'] == 1):?>
                                            <td><span class="badge badge-archived">&bull;
                                                    Libre </span>
                                            </td>
                                            <?php elseif($row['status']==2):?>
                                            <td><span class="badge badge-warning">&bull;
                                                    En limpieza </span>
                                            </td>
                                            <?php else:?>
                                            <td><span class="badge badge-danger">&bull;
                                                    Ocupada </span>
                                            </td>
                                            <?php endif;?>
                                            </td>
                                            <td>
                                                <a href="javascript:void(0);" style="text-decoration:none;" onclick="modal_lg('<?php echo base_url();?>modal/popup/surgery_room_update/<?php echo $row['surgery_room_id'];?>');"><i style="vertical-align:-3px;color:#a7aabb;font-size:18px;font-weight:bold;" class="picons-thin-icon-thin-0002_write_pencil_new_edit"></i></a>

                                                <a href="javascript:void(0);" style="text-decoration:none;" onclick="delete_service('<?php echo $row['surgery_room_id'];?>')"><i style="vertical-align:-3px;color:#a7aabb;font-size:18px;font-weight:bold;" class="picons-thin-icon-thin-0056_bin_trash_recycle_delete_garbage_empty"></i></a>
                                            </td>

                                        </tr>
                                        <?php endforeach;?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
function delete_service(service_id) {
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
            location.href = "<?php echo base_url();?>admin/surgery_room/delete/" + service_id;
        }
    })
}
</script>