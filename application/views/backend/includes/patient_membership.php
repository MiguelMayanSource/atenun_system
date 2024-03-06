<h5 class="panel-content-title">Membrecías <a class="btn btn-info pull-right" href="javascript:void(0)" onclick="modal_lg('<?php echo base_url();?>Modal/popup/modal_patient_membership/<?php echo $patient_id ?>');" style="margin-right:45px">Nuevo</a></h5>
<span class="app-divider2"></span>
<div class="row">
    <div class="col-sm-12">

        <?php 
            $this->db->select('*');
            $this->db->from('membership_patients mpa');
            $this->db->join('membership_plans mp', 'mpa.membership_plans_id = mp.membership_plans_id');
            $this->db->join('membership m', 'm.membership_id = mp.membership_id');
            $this->db->where('mpa.status', 1);
            $this->db->where('mpa.patient_id', $patient_id);
            $refresh_query = $this->db->get();
            if($refresh_query->num_rows() > 0):
                $cont= 1;
            ?>
        <table class="table">
            <tr style="background-color:#f9fbfc; color:#59636d">
                <th>#</th>
                <th>Membrecía</th>
                <th>Fecha de Registro</th>
                <th>Fecha de Inicio</th>
                <th>Fecha de Finalización</th>
                <th>Precio</th>
                <th>Acciones</th>
            </tr>
            <?php foreach($refresh_query->result_array() as $row): ?>
            <tr>
                <td>
                    <?php echo $cont++;?>
                </td>
                <td>
                    <?php echo $row['name']?>
                </td>
                <td>
                    <?php echo $row['date_register']?>
                </td>
                <td>
                    <?php echo $row['start_date'];?>
                </td>
                <td>
                    <?php echo $row['finish_date'];?>
                </td>
                
                <td>
                    <?php echo $row['price'];?>
                </td>
                <td>
                    <a class="" href="javascript:void(0)" onclick="delete_patient_membership('<?php echo base64_encode($row['patient_membership_id']); ?>')">
                        <i class="iconBox picons-thin-icon-thin-0056_bin_trash_recycle_delete_garbage_empty"></i>
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php else: ?>
        <div class="col-sm-12"><br>
            <center>
                <h5 class="poppins">Aún no hay membrecías</h5><br><img src="<?php echo base_url() ?>public/uploads/medicamentos.svg" style="max-width:20%;">
            </center>
        </div>
        <?php endif; ?>
    </div>
</div>

<script>
function delete_patient_membership(id) {
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
            location.href = "<?php echo base_url();?>admin/patient_membership/delete/" + id;
        }
    })
}
</script>