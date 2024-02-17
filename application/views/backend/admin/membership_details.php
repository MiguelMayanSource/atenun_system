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
                            <th>Tipo</th>
                            <th>Nombre</th>
                            <th>Cantidad</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            foreach ($benefits as $row):
                        ?>
                        <tr>
                            <td><?php echo $row['benefit_type'] != 1? 'Producto/Servicio':'Categoría';?></td>
                            <td><?php echo $row['benefit_type'] != 1? $this->db->get_where('product',array('product_id'=>$row['product_id']))->row()->name: $this->db->get_where('category',array('id'=>$row['category_id']))->row()->name;?></td>
                            <td> <?php echo $row['type_amount'] != 2 ?  number_format($row['amount'],0,'.',',').$this->db->get_where('unity',array('code'=>$row['unity']))->row()->name:number_format($row['porcent'],0,'.',',').'%';?></td>
                            <td>
                                <a class="" href="javascript:void(0)" onclick="showAjaxModal('<?php echo base_url().'modal/popup/modal_edit_benefit/'.base64_encode($row['membership_benefit_id']);?>')">
                                    <i class="iconBox picons-thin-icon-thin-0001_compose_write_pencil_new"></i>
                                </a>
                                <a class="" href="javascript:void(0)" onclick="delete_benefit('<?php echo base64_encode($row['membership_benefit_id']); ?>')">
                                    <i class="iconBox picons-thin-icon-thin-0056_bin_trash_recycle_delete_garbage_empty"></i>
                                </a>
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

function delete_benefit(membership_benefit_id) {
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
            location.href = "<?php echo base_url();?>admin/membership_details/delete/" + membership_benefit_id;
        }
    })
}
</script>