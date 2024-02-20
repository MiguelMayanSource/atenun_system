
    <div id="main-content">
        <div class="row">
            <div class="col-sm-12"><br>
                <div class="title-header">
                    <h3 class="module-title"> <a href="javascript:void(0);" onclick="history.back()" ><i class="picons-thin-icon-thin-0131_arrow_back_undo"></i></a> Categorías de inventario</h3>
                    <a class="add-buton pull-right" href="javascript:void(0);" data-toggle="modal" data-target="#2new_category">+ Nueva Categoría</a>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card-b">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="table-responsive">
                                <table class="table table-padded" id="user_data">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nombre</th>
                                            <th>Descripción</th>
                                            <th>Cantidad de productos</th>
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


    <div class="modal" id="2new_category">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content animated fadeInDown">
                <form action="<?php echo base_url();?>admin/categories/create" method="POST">
                    <div class="modal-header" style="background-color:#fff; box-shadow: 0 4px 2px -2px 000;">
                        <h4 style="font-size:21px; color:#565b6b; font-family:'Poppins';"><span style="vertical-align:-3px"> <i class="picons-thin-icon-thin-0001_compose_write_pencil_new"></i> Agregar nueva
                                categoría.</span></h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body" style="background-color:#f1f3f7;">
                        <div class="form-group">
                            <div class="container">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group m-b-15">
                                            <label for="simpleinput">Nombre</label>
                                            <input type="text" name="name" required="" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group m-b-15">
                                            <label for="simpleinput">Descripción</label>
                                            <textarea type="text" name="description" rows="5" class="form-control"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="button-confirm">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <script type="text/javascript" language="javascript">
$(document).ready(function() {
    var dataTable = $('#user_data').DataTable({
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            url: "<?php echo base_url() . 'admin/getTable/categories'; ?>",
            type: "POST"
        },

        "columnDefs": [{
            "targets": 0,
            "orderable": false,
        }, ],
    });
});
    </script>


    <script type="text/javascript">
function delete_category(category_id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "También se eliminará toda la información asociada al producto.",
        type: 'info',
        showCancelButton: true,
        confirmButtonColor: '#9fd13b',
        cancelButtonColor: '#fd4f57',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.value) {
            location.href = "<?php echo base_url();?>admin/categories/delete/" + category_id;
        }
    })
}
    </script>