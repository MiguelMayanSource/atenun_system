<?php 
    $week_days  = $this->crud_model->date_week(date('Y-m-d'));
    $week_name_days  = $this->crud_model->panelDate();
?>

<div id="main-content">
    <?php $insurance = $this->db->get_where('insurance',array('status'=>1,'clinic_id'=>$this->session->userdata('current_clinic')))->result_array();?>

    <div class="row">
        <div class="col-sm-12">
            <div class="title-header">
                <h3 class="module-title">Puntos y membresias</h3>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="profile-tile profile-tile-inlined">
                <div class="profile-tile-box">
                    <div class="tile-controls">

                    </div>
                    <div class="" style="    display: inline-block;width: 113px;height: auto;font-size: 60px;background: #042d50;color: white;padding: 10px;border-radius: 50%;"><i class="picons-thin-icon-thin-0066_grid_view"></i></div>
                    <div class="pt-user-last">Puntos</div>
                    <div class="pt-user-name" onclick="window.location.href='<?php echo base_url();?>admin/points';">
                        Ver</div>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="profile-tile profile-tile-inlined">
                <div class="profile-tile-box">
                    <div class="tile-controls">

                    </div>
                    <div class="" style="    display: inline-block;width: 113px;height: auto;font-size: 60px;background: #042d50;color: white;padding: 10px;border-radius: 50%;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 24 24"><path fill="currentColor" d="M8 17h2v-1h1c.55 0 1-.45 1-1v-3c0-.55-.45-1-1-1H8v-1h4V8h-2V7H8v1H7c-.55 0-1 .45-1 1v3c0 .55.45 1 1 1h3v1H6v2h2v1zM20 4H4c-1.11 0-1.99.89-1.99 2L2 18c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V6c0-1.11-.89-2-2-2zm0 14H4V6h16v12zm-6-8l2-2l2 2m0 4.25l-2 2l-2-2"/></svg>
                </div>
                    <div class="pt-user-last">Membresias</div>
                    <div class="pt-user-name" onclick="window.location.href='<?php echo base_url();?>admin/memberships';">
                        Ver</div>
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
            location.href = "<?php echo base_url();?>admin/insurance/delete/" + insurance_id;
        }
    })
}
</script>