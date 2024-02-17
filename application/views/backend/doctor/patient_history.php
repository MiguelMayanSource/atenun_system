<style type="text/css">
@media only screen and (max-width: 700px) {
    .tasks-section {

        width: 100%;
    }
}

@media only screen and (min-width : 700px) and (max-width : 1500px) {

    .tasks-section {

        width: 90%;
    }
}
</style>
<?php 
    $patient_id = base64_decode($id_);
    $this->db->where('patient_id', $patient_id);
    $info = $this->db->get('patient')->result_array();    
    foreach($info as $details):
?>
<div class="todo-app-w">
    <div class="todo-sidebar">
        <div id="sticky">
            <div class="todo-sidebar-section" style="border-bottom:0px">
                <div class="todo-sidebar-section-contents">
                    <ul class="tasks-list">
                        <li class="side-li">
                            <a class="side-items " href="<?php echo base_url();?>doctor/patient_profile/<?php echo base64_encode($details['patient_id']);?>/">
                                <i class="side-icon picons-thin-icon-thin-0002_write_pencil_new_edit"></i>
                                Editar perfil
                            </a>
                        </li>
                        <li class="side-li">
                            <a class="side-items active" href="<?php echo base_url();?>doctor/medical_history/<?php echo base64_encode($details['patient_id']);?>/">
                                <i class="side-icon picons-thin-icon-thin-0299_address_book_contacts"></i> Historial médico
                                <span class="side-active"></span>
                            </a>

                        </li>
                    </ul>
                    <div class="text-center account-container"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="todo-content conts">
        <div class="row">
            <div class="col-sm-12">
                <div class="tasks-section">
                    <form action="<?php echo base_url();?>doctor/patients/update" method="POST" enctype="multipart/form-data" id="doc_form">
                        <div class="col-xl-12 col-lg-12 col-sm-12" style="float: none; margin: 0 auto;">
                            <div class="tasks-section" style="background: #fff; padding: 24px; border-radius: 25px; border: 1px solid #ccc;">
                                <h4 class="todo-content-header">
                                    <i class="batch-icon-arrow-right"></i>
                                    <span> Historial de
                                        <?php echo $this->accounts_model->get_name('patient',$details['patient_id']);?>
                                    </span>
                                </h4>
                                <div class="table-responsive">
                                    <table class="table table-padded" id="user_data">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Fecha de ingreso</th>
                                                <th>Tipo de ingreso</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <br>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url();?>public/assets/back/js/jquery-3.1.1.min.js"></script>
<script src="<?php echo base_url();?>public/assets/theme/js/sticky-sidebar.js"></script>
<script src="<?php echo base_url();?>public/assets/theme/js/jquery.sticky.js"></script>
<script src="<?php echo base_url();?>public/assets/theme/js/PositionSticky/dist/PositionSticky.js"></script>
<script>
var sidebar = new StickySidebar('#sticky', {
    topSpacing: 10
});


$('.ae-side-menu-toggler').on('click', function() {
    $('.app-side').toggleClass('compact-side-menu');
});
if ($('.app-side').length) {
    if (is_display_type('phone') || is_display_type('tablet')) {
        $('.app-side').addClass('compact-side-menu');
    }
}
</script>
<script type="text/javascript" language="javascript">
$(document).ready(function() {
    var dataTable = $('#user_data').DataTable({
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            url: "<?php echo base_url() . 'doctor/getTable/patient_history/'.$patient_id?>",
            type: "POST"
        },

        "columnDefs": [{
            "targets": 0,
            "orderable": false,
        }, ],
    });
});
</script>
<?php  endforeach; ?>