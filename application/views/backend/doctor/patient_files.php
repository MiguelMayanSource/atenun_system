<?php 
    $patient_id = base64_decode($id_);
    $this->db->where('patient_id', $patient_id);
    $info = $this->db->get('patient')->result_array();    
    foreach($info as $details):
?>
<link rel="stylesheet" href="<?php echo base_url();?>public/assets/theme/css/files.css">
<div class="todo-app-w">

    <div class="todo-content" style="margin-bottom:20%">
        <h4 class="todo-content-header">
            <i class="batch-icon-arrow-right"></i><span>Archivos clínicos -
                <?php echo $this->accounts_model->get_name('patient',$details['patient_id']);?></span>
        </h4>
        <div class="row">
            <div class="col-sm-12">
                <a href="<?php echo base_url();?>doctor/patient_profile/<?php echo base64_encode($patient_id);?>" class="btn btn-info"><i class="picons-thin-icon-thin-0132_arrow_back_left"></i>
                    Regresar</a><br><br>
            </div>
            <div class="col-sm-12">
                <div class="alert alert-info">
                    <span class="alert-title"><i class="batch-icon-spam"></i> Archivos clínicos.</span>
                    <span class="alert-content">Accede y gestiona rápidamente los archivos de tu <span class="alert-lined"><a href="javascript:void(0);" style="color:#0044e9">paciente</a>.</span></span>
                </div>
            </div>
            <?php
                
                $have_folder = $this->db->get_where('settings',array('type'=>'folder'))->row()->description;

                if ($have_folder == '') 
                {
            ?>

            <div class="col-sm-12">
                <div class="card-widget">
                    <br>
                    <br>
                    <p class="poppins text-center">Necesitamos realizar unas configuraciones antes de que puedas
                        guardar los archivos de tus pacientes.<br> Esto se realiza la primera vez, presiona en
                        confirmar para continuar.</p><br>
                    <center> <img src="<?php echo base_url();?>public/uploads/archivos_compartidos.svg" style="max-width:20%;"></center>
                    <center> <a class="btn btn-success" href="<?php echo base_url();?>drive/checkFolder">De acuerdo, continuar.</a></center>
                </div>
            </div>
        </div>




        <?php    }else
                {
                    ?>

        <div class="col-sm-12">
            <div class="card-widget">
                <div class=" text-center">
                    <div class="files-container" style="background:#fff;padding:25px;height:100%;border-radius:5px;margin-bottom:10%;">
                        <div class="files-head" style="background: #007bff;margin-top: -25px!important; margin-left: -25px; margin-right: -25px;padding:15px;text-align:left;color:#fff;margin-bottom:30px;border-top-left-radius:5px;border-top-right-radius:5px" id="folders">
                            <a onclick="deleteAll('<?php echo $details['folderId']?>','0')" data-id="<?php echo $details['folderId']?>" style="color:#fff" href="javascript:void(0);"><i class="fas fa-home"></i> Unidad</a>
                            <a onclick="refreshFiles();" style="color:#fff;float:right" href="javascript:void(0);"><i class="fas fa-sync"></i> Refrescar</a>
                        </div>
                        <div class="row" id="response">
                            <div class="col-sm-12" id="loading"><br><br><img src="<?php echo base_url();?>public/uploads/loading.gif" width="50px" /></div>
                        </div>
                        <div class="row" id="response2" style="display:none">
                            <div class="col-sm-12" id="loading"><br><br><img src="<?php echo base_url();?>public/uploads/loading.gif" width="50px" /></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
                } ?>
    </div>
</div>
</div>


<script>
var folder_id = '';

function startUpload() {
    $('#f1_upload_process').show(500);
    $('#target').hide(500);
    $('#frm').submit();

    return true;
}

function stopUpload(success) {
    $('#f1_upload_process').hide(500);
    $('#target').show(500);
    $('#submit_btn').show(500);
    $('#file').val('');
    $('#show_result').show(500);
    $('#show_result').delay(3000).hide(500);

    deleteAll(folder_id);
    return true;
}

var patient_id = '<?php echo $patient_id;?>';

function confirm_delete(file_id) {
    Swal.fire({
        title: 'Confirmar esta acción',
        text: "¿Estás seguro que deseas eliminar el archivo? Esta acción no se puede deshacer.",
        type: 'info',
        showCancelButton: true,
        confirmButtonColor: '#9fd13b',
        cancelButtonColor: '#fd4f57',
        confirmButtonText: 'Continuar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: "<?php echo base_url();?>drive/deleteFile/" + file_id + "/" + folder_id + "/" +
                    patient_id,
                success: function(data) {
                    if (data = 'success') {
                        console.log(folder_id);
                        deleteAll(folder_id);

                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-right',
                            showConfirmButton: false,
                            timer: 5000
                        });
                        Toast.fire({
                            type: 'success',
                            title: 'Eliminado correctamente'
                        })

                    } else {
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-right',
                            showConfirmButton: false,
                            timer: 5000
                        });
                        Toast.fire({
                            type: 'error',
                            title: 'error al eliminar el archivo'
                        })
                    }
                },
                error: function(data) {
                    alert("Problemas al tratar de enviar el formulario");
                }
            });
        }
    })
}


function confirm_delete_folder(file_id) {

    console.log(folder_id, patient_id);
    Swal.fire({
        title: 'Confirmar esta acción',
        text: "¿Estás seguro que deseas continuar? Se eliminara la carpeta y los archivos en ella, esta acción no se puede deshacer.",
        type: 'info',
        showCancelButton: true,
        confirmButtonColor: '#9fd13b',
        cancelButtonColor: '#fd4f57',
        confirmButtonText: 'Continuar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: "<?php echo base_url();?>drive/deleteFile/" + file_id + "/" + folder_id + '/' +
                    patient_id,
                success: function(data) {
                    if (data = 'success') {
                        console.log(folder_id);
                        deleteAll(folder_id);

                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-right',
                            showConfirmButton: false,
                            timer: 5000
                        });
                        Toast.fire({
                            type: 'success',
                            title: 'Eliminado correctamente'
                        })

                    } else {
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-right',
                            showConfirmButton: false,
                            timer: 5000
                        });
                        Toast.fire({
                            type: 'error',
                            title: 'error al eliminar el archivo'
                        })
                    }
                },
                error: function(data) {
                    alert("Problemas al tratar de enviar el formulario");
                }
            });
        }
    })
}
</script>
<?php  endforeach; ?>
<script src="<?php echo base_url();?>public/assets/chat_assets/js/jquery.magnific-popup.js"></script>
<script src="<?php echo base_url();?>public/assets/chat_assets/js/zoom-gallery.js"></script>
<script src="<?php echo base_url();?>public/assets/chat_assets/js/script.js"></script>
<script src="<?php echo base_url();?>public/assets//back/js/jquery-3.1.1.min.js"></script>
<link href="<?php echo base_url();?>public/assets/input/script.css" media="all" rel="stylesheet">
<link href="<?php echo base_url();?>public/assets/input/jquery.fileuploader-theme-dragdrop.css" rel="stylesheet">

<script src="<?php echo base_url();?>public/assets/input/jquery.fileuploader.min.js" type="text/javascript"></script>
<script type="text/javascript">
$('.ae-side-menu-toggler').on('click', function() {
    $('.app-side').toggleClass('compact-side-menu');
});
if ($('.app-side').length) {
    if (is_display_type('phone') || is_display_type('tablet')) {
        $('.app-side').addClass('compact-side-menu');
    }
}
</script>

<script>
$(document).ready(function() {
    showFiles(0, 0, patient_id);
});



function refreshFiles() {
    $("#response").empty();
    $.ajax({
        url: '<?php echo base_url();?>drive/refreshFiles/',
        type: "POST",
        beforeSend: function() {
            $("#response2").show();
        },
        success: function(respuesta) {
            reload();
        },
        error: function() {
            alert(request_error);
        }
    });
}

$('.os-dropdown-trigger').on('mouseenter', function() {
    $(this).addClass('over');
});
$('.os-dropdown-trigger').on('mouseleave', function() {
    $(this).removeClass('over');
});


function reload() {
    location.reload();
}

function deleteAll(folderId, type) {

    $('[data-id="' + folderId + '"]').nextAll().remove();
    if (folderId == 'shared') {
        showSharedFiles(0);
    } else if (folderId == 'root') {
        showFiles(folderId, 0, type);
    } else {
        showFiles(folderId, 0, type);
    }
}

function showFiles(folderId, folderName, patientId) {
    $('#folderId').val(folderId);
    folder_id = folderId;
    $(".location").removeClass('current');
    if (folderName != 0) {
        $("#folders").append('<a href="javascript:void(0);" class="location current" data-id="' + folderId +
            '" onClick="deleteAll(' + "'" + folderId + "'," + "'" + patientId + "'" +
            ')" style="color:#fff">&nbsp;<i class="fas fa-angle-right"></i> ' + folderName + '</a>');
    }
    $("#response").empty();
    $("#response2").show();
    $.ajax({
        url: '<?php echo base_url();?>drive/getPatientFile/' + patient_id,
        data: {
            folderId: folderId,
            folderName: folderName
        },
        type: "POST",
        beforeSend: function() {
            $("#response2").show();
        },
        success: function(respuesta) {
            $("#response2").hide();
            $("#response").append(respuesta);
        },
        error: function() {
            alert(request_error);
        }
    });
}

function showSharedFiles(idVar) {
    if (idVar != 0) {
        $("#folders").append(
            '<a href="javascript:void(0);" class="location current" data-id="shared" onClick="deleteAll(' +
            "'shared'" + ')" style="color:#fff">&nbsp;<i class="fas fa-angle-right"></i> ' + shared_with_me + '</a>'
        );
    }
    $(".location").removeClass('current');
    $("#response").empty();
    $("#response2").show();
    $.ajax({
        url: baseUrl + 'home/showSharedFiles',
        type: "POST",
        beforeSend: function() {
            $("#response2").show();
        },
        success: function(respuesta) {
            $("#response2").hide();
            $("#response").append(respuesta);
        },
        error: function() {
            alert(request_error);
        }
    });
}

function getUrl(mime, id) {
    $.ajax({
        url: baseUrl + 'drive/download',
        type: "POST",
        data: {
            mime: mime,
            id: id
        },
        success: function(respuesta) {},
        error: function() {
            alert(request_error);
        }
    });
}
</script>