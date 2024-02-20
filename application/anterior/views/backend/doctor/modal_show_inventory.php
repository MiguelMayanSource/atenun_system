<div class="modal-content animated fadeInDown">
    <form action="<?php echo base_url();?>doctor/services/create" method="POST">
        <div class="modal-header" style="background-color:#fff; box-shadow: 0 4px 2px -2px 000;">
            <h4 style="font-size:21px; color:#565b6b; font-family:'Poppins';"><span style="vertical-align:-3px"> Productos.</span></h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            <div class="widget widget-activity-one">
                <div class="widget-heading">
                    <h5 class=""> <?php echo $row['code'];?></h5>
                </div>
                <div class="widget-content">
                    <div class="mt-container mx-auto ps ps--active-y">
                        <div class='container row'>
                            <div class='col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 '>
                                <div class="table-responsive">
                                    <table class="table table-padded" id="user_data">
                                        <thead>
                                            <tr>
                                                <th>CÓDIGO</th>
                                                <th>NOMBRE DE MEDICAMENTO</th>
                                                <th>PRESENTACIÓN</th>
                                                <th>EXISTENCIA</th>
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
        <div class="modal-footer">
            <button class="btn clouse" data-dismiss="modal"><i class="flaticon-cancel-12"></i>Cerrar</button>
        </div>
    </form>
</div>
<script>
    $(document).ready(function() {
        if ($.fn.DataTable.isDataTable('#user_data')) {
    // Si existe, destruye el DataTable
    $('#user_data').DataTable().destroy();
  }
    var dataTable = $('#user_data').DataTable({
        "lengthMenu": [
            [10, 25, 50, 100, 250, 500, -1],
            [10, 25, 50, 100, 250, 500, "Todos"]
        ],
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            url: "<?php echo base_url() . 'doctor/getTable/inventory_products/'; ?>",
            type: "POST"
        },

        "columnDefs": [{
            "targets": 0,
            "orderable": false,
        }, ],
        fixedColumns: true,
    });
});
</script>