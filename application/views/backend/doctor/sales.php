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

<div id="main-content">
    <div class="row">
        <div class="col-sm-12">
            <div class="title-header">
                <h3 class="module-title"><a class="" href="<?php echo base_url().$this->session->userdata('login_type');?>/sales_management"><i class="picons-thin-icon-thin-0132_arrow_back_left"></i></a> Control de ventas</h3>
                <br>
            </div>
        </div>

        <div class="col-md-12">
            <div class="card-b">
                <form class="mb-15" id="search-form" action="<?php echo base_url();?>doctor/sales/Mw==" method='POST'>
                    <div class="row mb-6">

                        <div class="col-lg-3">
                            <div class="form-group date-time-picker m-b-15">
                                <div class="input-group date datepicker" id="DoctorPicker1" style="border:0px;">
                                    <input type="text" id="date_start" name="date_start" autocomplete="off" style="font-weight: 500;padding: 20px;background: #dcdcdc;border-radius: 9px;" value="<?php  echo $date_start;?>" class="form-control">
                                    <span style="display:none;" class="input-group-addon"><i data-feather="calendar"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group date-time-picker m-b-15">
                                <div class="input-group date datepicker" id="DoctorPicker1" style="border:0px;">
                                    <input type="text" id="date_end" name="date_end" autocomplete="off" style="font-weight: 500;padding: 20px;background: #dcdcdc;border-radius: 9px;" value="<?php  echo $date_end;?>" class="form-control">
                                    <span style="display:none;" class="input-group-addon"><i data-feather="calendar"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <button type="submit" class="btn btn-primary btn-primary--icon">
                                <span>
                                    <i class="la la-search"></i>
                                    <span>Buscar</span>
                                </span>
                            </button>
                        </div>
                    </div>
                </form>
             
                <div class="row">
                    <div class="col-sm-12">
                        <div class="table-responsive">
                            <table class="table table-padded" id="user_data">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Fecha</th>
                                        <th>Paciente</th>
                                        <th>Responsable</th>
                                        <th>Método de pago</th>
                                        <th>Total&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" language="javascript">
$(document).ready(function() {
    console.log(<?php echo $sales_status;?>);
    var dataTable = $('#user_data').DataTable({
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            url: "<?php echo base_url() . 'staff/getTable/sales/'.$sales_status; ?>",
            type: "POST",
            data: function(d) {
                d.date_start = $('#date_start').val();
                d.date_end = $('#date_end').val();
                d.statuss = $('#statuss').val();
            }
        },

        "columnDefs": [{
            "targets": 0,
            "orderable": false,
        }, ],
    });

    if ($('.datepicker').length) {
        var date = new Date();
        var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
        $('.datepicker').datepicker({
            format: "dd/mm/yyyy",
            todayHighlight: true,
            autoclose: true
        });
    }
});
</script>
<script type="text/javascript">
function delete_sale(sale_id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "Se anulara la factura de esta venta.",
        type: 'info',
        showCancelButton: true,
        confirmButtonColor: '#9fd13b',
        cancelButtonColor: '#fd4f57',
        confirmButtonText: 'Sí, anular!',
        cancelButtonText: 'Cancelar'

    }).then((result) => {
        if (result.value) {
            location.href = "<?php echo base_url();?>doctor/sales/anulation/" + sale_id;
        }
    })
}
</script>
<?php endif;?>