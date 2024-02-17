<?php 
    $week_days  = $this->crud_model->date_week(date('Y-m-d'));
    $week_name_days  = $this->crud_model->panelDate();
?>

<div id="main-content">
    <?php $insurance = $this->db->get_where('insurance',array('status'=>1,'clinic_id'=>$this->session->userdata('current_clinic')))->result_array();?>

    <div class="row">
        <div class="col-sm-12">
            <div class="title-header">
                <h3 class="module-title">PACIENTES</h3>
                <a class="add-buton pull-right" href="javascript:void(0)" data-toggle="modal" data-target="#1specialtiesModal">+ Agregar seguro</a>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="profile-tile profile-tile-inlined">
                <div class="profile-tile-box">
                    <div class="tile-controls">

                    </div>
                    <div class="" style="    display: inline-block;width: 113px;height: auto;font-size: 60px;background: #042d50;color: white;padding: 10px;border-radius: 50%;"><i class="picons-thin-icon-thin-0703_users_profile_group_two"></i></div>
                    <div class="pt-user-last">Todos</div>
                    <div class="pt-user-name" onclick="window.location.href='<?php echo base_url();?>doctor/patients_list/<?php echo base64_encode(0);?>';">
                        Ver</div>
                </div>
            </div>
        </div>
        <?php foreach($insurance as $row):?>
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
                                    <li><a href="javascript:void(0);" onclick="modal_lg('<?php echo base_url();?>modal/popup/modal_edit_insurance/<?php echo $row['insurance_id'];?>');"><i class="picons-thin-icon-thin-0001_compose_write_pencil_new"></i><span>Actualizar</span></a>
                                    </li>
                                    <li><a href="javascript:void(0);" onclick="delete_insurance('<?php echo $row['insurance_id'];?>')"><i class="picons-thin-icon-thin-0056_bin_trash_recycle_delete_garbage_empty"></i><span>Eliminar</span></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="" style="display: inline-block;width: 113px;height: auto;font-size: 60px;background: #042d50;color: white;padding: 10px;border-radius: 50%;"><i class="picons-thin-icon-thin-0823_hospital_ill_medicine_doctor_ambulance"></i></div>
                    <div class="pt-user-last">Seguro <?php echo $row['name'];?></div>
                    <div class="pt-user-name" onclick="window.location.href='<?php echo base_url();?>doctor/patients_list/<?php echo base64_encode($row['insurance_id']);?>';">
                        Ver</div>
                </div>
            </div>
        </div>
        <?php endforeach;?>
    </div>
</div>
<div class="modal" id="1specialtiesModal">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content animated fadeInDown">
            <form action="<?php echo base_url();?>doctor/insurance/create" method="POST">
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
                                        <label for="simpleinput">Fecha de facturación</label>
                                        <input type="number" name="date" required="" min="1"  max="31" class="form-control" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxLength="2">
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
            location.href = "<?php echo base_url();?>doctor/insurance/delete/" + insurance_id;
        }
    })
}
</script>