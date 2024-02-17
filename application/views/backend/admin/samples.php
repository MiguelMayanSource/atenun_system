<?php 
    $week_days  = $this->crud_model->date_week(date('Y-m-d'));
    $week_name_days  = $this->crud_model->panelDate();
    $insurance_id = base64_decode($insurance_id);
?>

<div id="main-content">
    <div class="row">
        <div class="col-sm-12">
            <div class="title-header">
                <h3 class="module-title">Ordenes de laboratorio</h3>
                <a class="add-buton pull-right" href="<?php echo base_url().'admin/inventory_products/MTA='?>">Laboratorios</a>
                <a class="add-buton pull-right" href="<?php echo base_url().'admin/samples_new/0'?>">+ Nueva orden</a>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="table-responsive">
                <table class="table table-padded" id="user_data">
                    <thead>
                        <tr>
                            <th>Estado</th>
                            <th>Fecha</th>
                            <th>Código</th>
                            <th>Paciente</th>
                            <th>Estudio</th>
                            <th>Médico</th>
                            <th>Precio</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
$('.os-dropdown-trigger').on('mouseenter', function() {
    $(this).addClass('over');
});
$('.os-dropdown-trigger').on('mouseleave', function() {
    $(this).removeClass('over');
});
</script>

<script type="text/javascript" language="javascript">
$(document).ready(function() {
    var dataTable = $('#user_data').DataTable({
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            url: "<?php echo base_url() . 'admin/getTable/samples/'; ?>",
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
let timerInterval

function executeExample(chat_id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "Toma en cuenta que solo se eliminará la copia de tu mensaje.",
        type: 'info',
        showCancelButton: true,
        confirmButtonColor: '#9fd13b',
        cancelButtonColor: '#fd4f57',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.value) {
            Swal.fire({
                title: 'Eliminando mensaje',
                titleTextColor: '#000',
                html: 'Esta ventana se cerrará en <strong></strong>.',
                timer: 2000,
                onBeforeOpen: () => {
                    Swal.showLoading()
                    timerInterval = setInterval(() => {
                        Swal.getContent().querySelector('strong').textContent = Swal
                            .getTimerLeft()
                    }, 100)
                },
                onClose: () => {
                    clearInterval(timerInterval)
                }
            })
            location.href = "<?php echo base_url();?>admin/chat/delete/" + chat_id;
        }
    })
}
</script>
<script type="text/javascript">
function delete_patient(patient_id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "También se eliminará toda la información asociada a este paciente.",
        type: 'info',
        showCancelButton: true,
        confirmButtonColor: '#9fd13b',
        cancelButtonColor: '#fd4f57',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.value) 
        {
            location.href = "<?php echo base_url();?>admin/patients/delete/"+patient_id;
        }
    })
}

function loadPatients(idd) {
    $('input#contact').addClass('loading');
    consulta = $("#contact").val();
    $("#results").queue(function(n) {
        if ($("#contact").length == 0) {
            $("#results").removeData()
        }
        $.ajax({
            type: "POST",
            url: '<?php echo base_url();?>admin/get_patients_list',
            dataType: "html",
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status);


                alert("Ups! Algo salio mal.");
                $("input#contact").removeClass("loading");
            },
            success: function(data) {


                $("#results").html(data);
                n();
                $("input#contact").removeClass("loading");
            }
        });
    });
}

function delete_user(user, user_id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "También se eliminará toda la información asociada.",
        type: 'info',
        showCancelButton: true,
        confirmButtonColor: '#9fd13b',
        cancelButtonColor: '#fd4f57',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.value) {
            $.ajax({
                type: "GET",
                url: "<?php echo base_url();?><?php echo $this->session->userdata('login_type');?>/" + user + "/delete/" + user_id,
                success: function(data) {
                    console.log(data);
                    // show response from the php script.
                    if (data != 'Error') {
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 8000
                        });
                        Toast.fire({
                            type: 'success',
                            title: 'Eliminado Correctamente'
                        })

                        location.reload();

                    }
                },
                error: function(xhr, status, error) {
                    var err = eval("(" + xhr.responseText + ")");
                    alert(err.Message);
                },
            });


        }
    })
}
</script>