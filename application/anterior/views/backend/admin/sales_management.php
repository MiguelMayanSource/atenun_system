<?php
$box = $this->db->get_where('box',array('user_id'=>$this->session->userdata('login_user_id'),'user_type'=>$this->session->userdata('login_type'),'status'=>1))->num_rows();
if($box == 0):
?>

<div id="main-content">
    <div class="card-box">
        <center><br><br><br>
            <a class="add-buton pull-right" href="javascript:void(0)" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_new_box');">+ Apertura de caja</a>
            <h4 style="text-align:center;color:#4d4a81;margin-top:2%;">Debes aperturar caja para realizar ventas</h4>
            <br>
            <img src="<?php echo base_url() ?>public/uploads/financial.png" style="width:25%;margin-bottom:10%" />
        </center>
    </div>
</div>
<?php else:?>


<?php 
    $week_days  = $this->crud_model->date_week(date('Y-m-d'));
    $week_name_days  = $this->crud_model->panelDate();
?>

<div id="main-content">
    <?php $insurance = $this->db->get_where('insurance',array('status'=>1,'clinic_id'=>$this->session->userdata('current_clinic')))->result_array();?>

    <div class="row">
        <div class="col-sm-12">
            <div class="title-header">
                <h3 class="module-title">CONTROL DE VENTAS </h3>
                <a class="add-buton pull-right" href="<?php echo base_url().$this->session->userdata('login_type').'/box/';?>">CAJA</a>
            </div>
        </div>
         <?php  if($permission_to_check['view_all_sales'] == 1):?>
        <div class="col-sm-3">
            <div class="profile-tile profile-tile-inlined">
                <div class="profile-tile-box">
                    <div class="tile-controls">
                        <div class="tile-settings os-dropdown-trigger">
                            <i class="batch-icon-ellipsis"></i>
                            <div class="os-dropdown">
                                <div class="icon-w">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 24 24">
                                        <path fill="currentColor" d="M18 10H6a2 2 0 0 0-2 2v7h16v-7a2 2 0 0 0-2-2m0 4h-4v-2h4m-1-3H7V4h10Z" />
                                    </svg>
                                </div>
                                <ul>
                                    <?php  if($permission_to_check['view_all_sales'] == 1):?>
                                    <li><a href="<?php echo base_url().$this->session->userdata('login_type'); ?>/new_sale">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                                <path fill="currentColor" d="M17 9H7V4h10v5m2 4c-3.31 0-6 2.69-6 6H4v-7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v1.09c-.33-.05-.66-.09-1-.09m-9-1H6v2h4v-2m10 6v-3h-2v3h-3v2h3v3h2v-3h3v-2h-3Z" />
                                            </svg>
                                            <span>Nueva venta</span></a>
                                    </li>
                                    <?php endif;?>
                                    <?php  if($permission_to_check['view_cotizations'] == 1):?>
                                    <li><a href="<?php echo base_url().$this->session->userdata('login_type'); ?>/new_cotitation">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                                <path fill="currentColor" d="M17 9H7V4h10v5m2 4c-3.31 0-6 2.69-6 6H4v-7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v1.09c-.33-.05-.66-.09-1-.09m-9-1H6v2h4v-2m10 6v-3h-2v3h-3v2h3v3h2v-3h3v-2h-3Z" />
                                            </svg>
                                            <span>Nueva cotización</span></a>
                                    </li>
                                    <?php endif;?>
                                    <?php  if($permission_to_check['views_insurances'] == 1):?>
                                    <li><a href="<?php echo base_url().$this->session->userdata('login_type'); ?>/new_sale_insurance">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 15 15">
                                                <path fill="currentColor" d="M4.5 6.995H4v1h.5v-1Zm6 1h.5v-1h-.5v1ZM4.5 9.5H4v.5h.5v-.5Zm6 0v.5h.5v-.5h-.5Zm-6-4V5H4v.5h.5Zm6 0h.5V5h-.5v.5Zm3-2h.5v-.207l-.146-.147l-.354.354Zm-3-3l.354-.354L10.707 0H10.5v.5Zm-6 7.495h6v-1h-6v1ZM4.5 10h6V9h-6v1Zm0-4h6V5h-6v1Zm8 8h-10v1h10v-1ZM2 13.5v-12H1v12h1Zm11-10v10h1v-10h-1ZM2.5 1h8V0h-8v1Zm7.646-.146l3 3l.708-.708l-3-3l-.708.708ZM2.5 14a.5.5 0 0 1-.5-.5H1A1.5 1.5 0 0 0 2.5 15v-1Zm10 1a1.5 1.5 0 0 0 1.5-1.5h-1a.5.5 0 0 1-.5.5v1ZM2 1.5a.5.5 0 0 1 .5-.5V0A1.5 1.5 0 0 0 1 1.5h1Zm2 4v4h1v-4H4Zm3 0v4h1v-4H7Zm3 0v4h1v-4h-1ZM4 4h3V3H4v1Zm4 8h3v-1H8v1Z" />
                                            </svg>
                                            <span>Facturación seguros</span></a>
                                    </li>
                                    <?php endif;?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="" style="    display: inline-block;width: 113px;height: auto;font-size: 60px;background: #042d50;color: white;padding: 10px;border-radius: 50%;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24">
                            <path fill="currentColor" d="M7 8q-.825 0-1.413-.588T5 6V4q0-.825.588-1.413T7 2h10q.825 0 1.413.588T19 4v2q0 .825-.588 1.413T17 8H7Zm0-2h10V4H7v2ZM4 22q-.825 0-1.413-.588T2 20v-1h20v1q0 .825-.588 1.413T20 22H4Zm-2-4l3.475-7.825q.25-.55.75-.863T7.3 9h9.4q.575 0 1.075.313t.75.862L22 18H2Zm6.5-2h1q.2 0 .35-.15t.15-.35q0-.2-.15-.35T9.5 15h-1q-.2 0-.35.15T8 15.5q0 .2.15.35t.35.15Zm0-2h1q.2 0 .35-.15t.15-.35q0-.2-.15-.35T9.5 13h-1q-.2 0-.35.15T8 13.5q0 .2.15.35t.35.15Zm0-2h1q.2 0 .35-.15t.15-.35q0-.2-.15-.35T9.5 11h-1q-.2 0-.35.15T8 11.5q0 .2.15.35t.35.15Zm3 4h1q.2 0 .35-.15t.15-.35q0-.2-.15-.35T12.5 15h-1q-.2 0-.35.15t-.15.35q0 .2.15.35t.35.15Zm0-2h1q.2 0 .35-.15t.15-.35q0-.2-.15-.35T12.5 13h-1q-.2 0-.35.15t-.15.35q0 .2.15.35t.35.15Zm0-2h1q.2 0 .35-.15t.15-.35q0-.2-.15-.35T12.5 11h-1q-.2 0-.35.15t-.15.35q0 .2.15.35t.35.15Zm3 4h1q.2 0 .35-.15t.15-.35q0-.2-.15-.35T15.5 15h-1q-.2 0-.35.15t-.15.35q0 .2.15.35t.35.15Zm0-2h1q.2 0 .35-.15t.15-.35q0-.2-.15-.35T15.5 13h-1q-.2 0-.35.15t-.15.35q0 .2.15.35t.35.15Zm0-2h1q.2 0 .35-.15t.15-.35q0-.2-.15-.35T15.5 11h-1q-.2 0-.35.15t-.15.35q0 .2.15.35t.35.15Z" />
                        </svg>
                    </div>
                    <div class="pt-user-last">VENTAS</div>
                    <div class="pt-user-name" onclick="window.location.href='<?php echo base_url().$this->session->userdata('login_type');?>/sales/<?php echo base64_encode(0);?>';">
                        ir</div>
                </div>
            </div>
        </div>
         <?php endif;?>
         <?php  if($permission_to_check['view_cotizations'] == 1):?>
        <div class="col-sm-3">
            <div class="profile-tile profile-tile-inlined">
                <div class="profile-tile-box">
                    <div class="tile-controls">

                    </div>
                    <div class="" style="    display: inline-block;width: 113px;height: auto;font-size: 60px;background: #f8bc34;color: white;padding: 10px;border-radius: 50%;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24">
                            <path fill="currentColor" d="M16 10H4c-1.1 0-2 .9-2 2v7h16v-7a2 2 0 0 0-2-2m0 4h-4v-2h4v2m-1-5H5V4h10v5m7-2v6h-2V7h2m-2 8h2v2h-2v-2Z" />
                        </svg>
                    </div>
                    <div class="pt-user-last">COTIZACIONES</div>
                    <div class="pt-user-name" onclick="window.location.href='<?php echo base_url().$this->session->userdata('login_type');?>/cotizaciones';">
                        ir</div>
                </div>
            </div>
        </div>
         <?php endif;?>
          <?php  if($permission_to_check['view_payments_appointments'] == 1):?>
        <div class="col-sm-3">
            <div class="profile-tile profile-tile-inlined"> 
                <div class="profile-tile-box">
                    <div class="tile-controls">

                    </div>
                    <div class="" style="    display: inline-block;width: 113px;height: auto;font-size: 60px;background: #f8bc34;color: white;padding: 10px;border-radius: 50%;">
                       <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" viewBox="0 0 24 24"><g fill="none"><path d="M24 0v24H0V0zM12.593 23.258l-.011.002l-.071.035l-.02.004l-.014-.004l-.071-.035c-.01-.004-.019-.001-.024.005l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427c-.002-.01-.009-.017-.017-.018m.265-.113l-.013.002l-.185.093l-.01.01l-.003.011l.018.43l.005.012l.008.007l.201.093c.012.004.023 0 .029-.008l.004-.014l-.034-.614c-.003-.012-.01-.02-.02-.022m-.715.002a.023.023 0 0 0-.027.006l-.006.014l-.034.614c0 .012.007.02.017.024l.015-.002l.201-.093l.01-.008l.004-.011l.017-.43l-.003-.012l-.01-.01z"/><path fill="currentColor" d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-7zm-5-9a1 1 0 0 1 1 1v1h2a2 2 0 0 1 2 2v3H3V7a2 2 0 0 1 2-2h2V4a1 1 0 0 1 2 0v1h6V4a1 1 0 0 1 1-1"/></g></svg>
                    </div>
                    <div class="pt-user-last">CITAS</div>
                    <div class="pt-user-name" onclick="window.location.href='<?php echo base_url().$this->session->userdata('login_type');?>/appointments_box';">
                        ir</div>
                </div>
            </div>
        </div>
         <?php endif;?>
         <?php  if($permission_to_check['view_clients'] == 1):?>
        <div class="col-sm-3">
            <div class="profile-tile profile-tile-inlined">
                <div class="profile-tile-box">
                    <div class="tile-controls">

                    </div>
                    <div class="" style="    display: inline-block;width: 113px;height: auto;font-size: 60px;background: #82b440;color: white;padding: 10px;border-radius: 50%;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" viewBox="0 0 24 24"><path fill="currentColor" d="M7.5 6.5C7.5 8.981 9.519 11 12 11s4.5-2.019 4.5-4.5S14.481 2 12 2S7.5 4.019 7.5 6.5M20 21h1v-1c0-3.859-3.141-7-7-7h-4c-3.86 0-7 3.141-7 7v1z"/></svg>
                    </div>
                    <div class="pt-user-last">CLIENTES</div>
                    <div class="pt-user-name" onclick="window.location.href='<?php echo base_url().$this->session->userdata('login_type');?>/clients';">
                        ir</div>
                </div>
            </div>
        </div>
         <?php endif;?>
         <?php  if($permission_to_check['views_insurances'] == 1):?>
        <div class="col-sm-3">
            <div class="profile-tile profile-tile-inlined">
                <div class="profile-tile-box">
                    <div class="tile-controls">

                    </div>
                    <div class="" style="    display: inline-block;width: 113px;height: auto;font-size: 60px;background: #0089FF;color: white;padding: 10px;border-radius: 50%;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" viewBox="0 0 24 24">
                            <g fill="none" fill-rule="evenodd">
                                <path d="M24 0v24H0V0h24ZM12.593 23.258l-.011.002l-.071.035l-.02.004l-.014-.004l-.071-.035c-.01-.004-.019-.001-.024.005l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427c-.002-.01-.009-.017-.017-.018Zm.265-.113l-.013.002l-.185.093l-.01.01l-.003.011l.018.43l.005.012l.008.007l.201.093c.012.004.023 0 .029-.008l.004-.014l-.034-.614c-.003-.012-.01-.02-.02-.022Zm-.715.002a.023.023 0 0 0-.027.006l-.006.014l-.034.614c0 .012.007.02.017.024l.015-.002l.201-.093l.01-.008l.004-.011l.017-.43l-.003-.012l-.01-.01l-.184-.092Z" />
                                <path fill="currentColor" d="M5 2a2 2 0 0 0-2 2v16.9A1.1 1.1 0 0 0 4.1 22h15.8a1.1 1.1 0 0 0 1.1-1.1V11a2 2 0 0 0-2-2h-.5a.5.5 0 0 0-.5.5V20h-1V4a2 2 0 0 0-2-2H5Zm5 3a1 1 0 0 0-1 1v1H8a1 1 0 0 0 0 2h1v1a1 1 0 1 0 2 0V9h1a1 1 0 1 0 0-2h-1V6a1 1 0 0 0-1-1Zm0 9a2 2 0 0 0-2 2v4h4v-4a2 2 0 0 0-2-2Z" />
                            </g>
                        </svg>
                    </div>
                    <div class="pt-user-last">SEGUROS</div>
                    <div class="pt-user-name" onclick="window.location.href='<?php echo base_url().$this->session->userdata('login_type');?>/sales_insurance/<?php echo base64_encode(4);?>';">
                        ir</div>
                </div>
            </div>
        </div>
         <?php endif;?>
    </div>
</div>
<div class="modal" id="1specialtiesModal">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content animated fadeInDown">
            <form action="<?php echo base_url().$this->session->userdata('login_type');?>/insurance/create" method="POST">
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
            location.href = "<?php echo base_url().$this->session->userdata('login_type');?>/insurance/delete/" + insurance_id;
        }
    })
}
</script>
<?php endif; ?>