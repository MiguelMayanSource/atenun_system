<div class="white-box">
    <div class="os-tabs-w">
        <div class="os-tabs-controls">
            <ul class="navx nav-tabs">
                <li class="nav-item text-center">
                    <a class="nav-link <?php  if($page_name == "admins") echo 'current'; ?>" href="<?php echo base_url();?>doctor/admins/">
                        <div class="navWidget"><i class="picons-thin-icon-thin-0710_business_tie_user_profile_avatar_man_male"></i></div> <span>Administradores</span>
                    </a>
                </li>
                <li class="nav-item text-center">
                    <a class="nav-link <?php  if($page_name == "doctors") echo 'current'; ?>" href="<?php echo base_url();?>doctor/doctors/">
                        <div class="navWidget"><i class="picons-thin-icon-thin-0726_doctor_surgery_hospital"></i></div> <span>Doctores</span>
                    </a>
                </li>
                <li class="nav-item text-center">
                    <a class="nav-link <?php  if($page_name == "staff") echo 'current'; ?>" href="<?php echo base_url();?>doctor/staff/">
                        <div class="navWidget"><i class="picons-thin-icon-thin-0723_nurse_medicine_hospital_doctor"></i></div> <span>Enfermeros</span>
                    </a>
                </li>
                <li class="nav-item text-center">
                    <a class="nav-link <?php  if($page_name == "receptionist") echo 'current'; ?>" href="<?php echo base_url();?>doctor/receptionist/">
                        <div class="navWidget"><i class="picons-thin-icon-thin-0731_support_female_phone"></i></div><span>Recepcionistas</span>
                    </a>
                </li>
                <li class="nav-item text-center">
                    <a class="nav-link <?php  if($page_name == "providers") echo 'current'; ?>" href="<?php echo base_url();?>doctor/providers/">
                        <div class="navWidget"><i class="picons-thin-icon-thin-0711_young_boy_user_profile_avatar_man_male"></i></div><span>Proveedores</span>
                    </a>
                </li>
                <li class="nav-item text-center">
                    <a class="nav-link <?php  if($page_name == "sellers") echo 'current'; ?>" href="<?php echo base_url();?>doctor/sellers/">
                        <div class="navWidget"><i class="picons-thin-icon-thin-0711_young_boy_user_profile_avatar_man_male"></i></div> <span>Vendedores</span>
                    </a>
                </li>
                <li class="nav-item text-center">
                    <a class="nav-link <?php  if($page_name == "accountants") echo 'current'; ?>" href="<?php echo base_url();?>doctor/accountants/">
                        <div class="navWidget"><i class="picons-thin-icon-thin-0711_young_boy_user_profile_avatar_man_male"></i></div> <span>Contadores</span>
                    </a>
                </li>
                <li class="nav-item text-center">
                    <a class="nav-link <?php  if($page_name == "permission_request") echo 'current'; ?>" href="<?php echo base_url();?>doctor/permission_request/">
                        <div class="navWidget"><i class="picons-thin-icon-thin-0092_file_profile_user_personal"></i></div> <span>Permisos</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>

<div id="main-content">

    <div class="card-box padding0">

        <div class="card-h customPadding noborder">
            <a class="btn btn-info pull-right" href="javascript:void(0)" data-toggle="modal" data-target="#123" style="margin-right:45px">Solicitar nuevo permiso</a>
            <h5 class="card-caption">Permisos solicitados</h5>
        </div>
        <div class="card-b">
            <div class="table-responsive">
                <table class="table custom-table table-striped">
                    <thead style="color: #a2a5b9;">
                        <th>No.</th>
                        <th>USUARIO</th>
                        <th>ESTADO</th>
                        <th>AUTORIZADO POR</th>
                        <th>ACCIONES</th>
                    </thead>
                    <tbody>
                        <?php $permission_requests = $this->db->order_by('permission_request_id','DESC')->get('permission_request')->result_array();
                        foreach($permission_requests as $row):?>
                        <tr style="font-family:'Poppins';font-size:14px;font-weight:bold;color:#4b4a55" class="">
                            <td><?php echo sprintf('%04d', $row['permission_request_id']);?></td>
                            <td><a href="#">
                                    <img src="<?php echo $this->accounts_model->get_photo($row['user_type'], $row['user_id']); ?>" width="35px" style="padding-right:6px">
                                    <?php echo $this->accounts_model->short_name($row['user_type'], $row['user_id']);?></a></td>
                            <td>
                                <?php if($row['status']== 0):?>
                                    <a class="btn btn-secundary">Pendiente</a>
                                    <?php elseif($row['status']== 1):?>
                                        <a class="btn btn-secundary">Aprovado</a>
                                        <?php elseif($row['status']== 2):?>
                                        <a class="btn btn-secundary">Rechazado</a>
                                <?php endif;?>
                            </td>
                            <td>
                            <?php if($row['status']== 0):?>
                                    <a class="btn btn-primary">Pendiente</a>
                                    <?php elseif($row['status']== 1):?>
                                        <a href="#">
                                    <img src="<?php echo $this->accounts_model->get_photo('admin', $row['admin_id']); ?>" width="35px" style="padding-right:6px">
                                    <?php echo $this->accounts_model->short_name('admin', $row['admin_id']);?></a>
                                        <?php elseif($row['status']== 2):?>
                                            <a href="#">
                                    <img src="<?php echo $this->accounts_model->get_photo('admin', $row['admin_id']); ?>" width="35px" style="padding-right:6px">
                                    <?php echo $this->accounts_model->short_name('admin', $row['admin_id']);?></a>
                                <?php endif;?>    
                            
                                </td>
                           
                            <td>
                                <a target="_blank" href="<?php echo base_url(); ?>doctor/permission_details/<?php echo $row['permission_request_id'];?>" ><i style="vertical-align:-3px;color:#a7aabb;font-size:18px;font-weight:bold;" class="picons-thin-icon-thin-0012_notebook_paper_certificate"></i></a>
                            </td>
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<div class="modal" id="123">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content animated fadeInDown">
            <form action="<?php echo base_url();?>doctor/permission_request/create" method="POST">
                <div class="modal-header" style="background-color:#fff; box-shadow: 0 4px 2px -2px 000;">
                    <h4 style="font-size:21px; color:#565b6b; font-family:'Poppins';">
                        <span style="vertical-align:-3px"> <i class="iconBox batch-icon-home-2"></i>
                            Solicitar nuevo permiso</span>
                    </h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="container">
                            <div class="row">
                            <div class="col-sm-6">
                                    <div class="form-group m-b-15">
                                        <label for="simpleinput">Fecha</label>
                                       <input type="date" name="date" required="" class="form-control"></input>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group m-b-15">
                                        <label for="simpleinput">Motivo</label>
                                       <select name="motive" required="" class="form-control">
                                            <option >Seleccione un motivo</option>
                                            <option value="1">Permiso para faltar</option>
                                            <option value="2">Permiso para capacitación</option>
                                            <option value="3">Permiso por muerte de familiar</option>
                                            <option value="4">Permiso por Consulta médica</option>
                                       </select>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group m-b-15">
                                        <label for="simpleinput">Detalles del permiso</label>
                                        <textarea type="text" name="details" required="" id="ckeditorM" class="form-control"></textarea>
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
<script src="<?php echo base_url();?>public/assets/back/ckeditor/ckeditor.js"></script>
<script type="text/javascript">
$('.app-email-w').toggleClass('compact-side-menu');
$('.ae-side-menu-toggler').on('click', function() {
    $('.app-email-w').toggleClass('compact-side-menu');
});
</script>
<script type="text/javascript">
    CKEDITOR.disableAutoInline = true;
    if ($('#ckeditorM').length) {
        CKEDITOR.config.uiColor = '#ffffff';
        CKEDITOR.config.toolbar = [
            ['Bold', 'Italic', '-', 'NumberedList', 'BulletedList', '-', 'Link', 'Unlink', '-', 'About']
        ];
        CKEDITOR.config.height = 110;
        CKEDITOR.replace('ckeditorM');
    }


</script>