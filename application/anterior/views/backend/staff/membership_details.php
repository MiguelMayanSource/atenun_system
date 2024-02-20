<?php $benefits = $this->db->get_where('membership_benefit',array('status'=>1,'membership_id'=>$membership_id))->result_array(); ?>
<div id="main-content">
    <?php ?>
    <div class="col-sm-12">
        <div class="card-widget">
            <h4 class="panel-content-title">Beneficios</h4>
            <a class="add-buton pull-right" href="javascript:void(0)" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_new_benefit/<?php echo $membership_id;?>');" >+ Agregar beneficio</a>
            <span class="app-divider2"></span>
            <?php if(count($benefits) > 0):?>
            <div class="table-responsive">
                <table class="table table-padded" id="user_data">
                    <thead>
                        <tr>
                            <th>Descripcion</th>
                            <th>Cantidad</th>
                            <th>Tipo</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            foreach ($benefit as $row):
                            ?>
                        <tr>
                            <td><?php echo $row['date'];?></td>
                            <td><?php echo $row['description'];?></td>
                            <td>

                                <?php echo '<div class="user-with-avatar">
                                                <img alt="" src="'.$this->accounts_model->get_photo('patient',$row['patient_id']).'"><span class="smaller lighter">'.$this->accounts_model->short_name('patient',$row['patient_id']).'</span>
                                            </div>';?></td>
                            <td><?php echo $row['type']== 0 ? '<div class="patient-gender-female">Egreso</div>':'<div class="patient-gender-male">Ingreso</div>';?></td>
                            <td><?php echo $row['points']?></td>
                            <td><?php echo $row['value'];?></td>
                            <td class="text-right" style="width:200px">
                                <?php echo number_format($row['points']*$row['value'],2,'.',',');?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php else: ?>
            <div>
                <center>
                    <h5 class="poppins">Aún no hay beneficios registrados! </h5><br><img src="<?php echo base_url() ?>public/uploads/medicamentos.svg" style="max-width:20%;">
                </center>
            </div>
            <?php endif;?>
        </div>
    </div>
</div>

<script type="text/javascript">
$('.os-dropdown-trigger').on('mouseenter', function() {
    $(this).addClass('over');
});
$('.os-dropdown-trigger').on('mouseleave', function() {
    $(this).removeClass('over');
});

function delete_insurance(insurance_id) {
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
            location.href = "<?php echo base_url();?>staff/insurance/delete/" + insurance_id;
        }
    })
}
</script>