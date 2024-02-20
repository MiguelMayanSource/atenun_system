<link rel="stylesheet" href="<?php echo base_url();?>public/assets/search/estilo.css">
<link href="<?php echo base_url();?>public/assets/appointments/css/select2.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<style>
#formValidate .wizard>.content {
    min-height: 25em;
}

#example-vertical.wizard>.content {
    min-height: 24.5em;
}

#mydiv {
 
    z-index: 99;
    background-color: #f1f1f1;
    border: 1px solid #d3d3d3;
    text-align: center;
    width: 650px;
    padding-top: 10px;
    font-size: 16px;
    border-radius: 10px;
}

#mydivheader {
    padding: 10px;
    cursor: move;
    z-index: 10;
    background-color: #2196F3;
    color: #fff;
}

@media print {

    body,
    page[size="A4"] {
        margin: 0;
        box-shadow: 0;
    }
}

.image_galery {
    position: relative;
    box-sizing: border-box;
    transition: all 0.2s ease;
    border-radius: 6px;
    background-size: cover;
    background-position: center center;
    background-repeat: no-repeat;
    float: left;
    margin: 1.858736%;
    width: 20%;
    height: 150px;
    box-shadow: 0 4px 10px 0 rgb(51 51 51 / 25%);
}


.file_control_custom {
    position: absolute;
    top: 120px;
    right: 0;
    left: 0;
    z-index: 5;
    height: auto;
    font-size: 15px;
    cursor: pointer;
    margin: 30px;
    color: black;
}

.intLink {
    cursor: pointer;
}

img.intLink {
    border: 0;
    width: 30px;
}




div.editor {
    width: 249mm;
    padding: 10mm;
    background-color: #fff;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

div.page {
    width: 210mm;
    height: 297mm;
    margin: 0 0 10mm 0;
    padding: 10mm;
    border: 1px solid #ccc;
    overflow-y: auto;
    box-sizing: border-box;
}


.nav-tabs .nav-item {

    background: #ff001878;
    border-top-left-radius: 15px;
    border-top-right-radius: 15px;
    color: white !important;
    white-space: nowrap;
    margin: 0 0 3px 0;
    padding: 0;
    border: 1px solid white;
}

.nav {}

.nav-link {

    color: white !important;
}

.nav-link.active {
    border-top-left-radius: 15px;
    border-top-right-radius: 15px;
    color: #002a4d !important;
}

.alert-danger {
    background: #ff001878;
    color: white !important;
}

.nav-tabs .nav-item.show .nav-link,
.nav-tabs .nav-link.active {
    border-bottom: 5px solid #ff001878;
}

.patient-details {
    background: #f9fafc;
    width: 100%;
    padding: 10px;
    border-radius: 10px;
    border: 2px dotted #c6c6cc;
    margin-bottom: 10px !important;
    padding-left: 20px;
    text-align: left;
    margin: 0 auto;
    font-size: 13px;
    display: flex;

}
</style>

<script type="text/javascript">
function formatDoc(sCmd, sValue) {
    document.execCommand(sCmd, false, sValue);
    oDoc.focus();
}
</script>

<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.9.1/themes/smoothness/jquery-ui.css" />

<?php   
    $stabilitation_id = base64_decode($id_);
    $this->db->where('stabilitation_ref_id', $stabilitation_id);
    $info = $this->db->get('stabilitation_ref')->result_array();
    foreach ($info as $det):
    $patient_id = $det['patient_id'];
    $status = $det['status'];
    $vs = $this->db->limit(1)->get_where('vital_sign',array('patient_id'=> $patient_id))->row_array();
    $appointment_id = $stabilitation_id;
?>
<script>
var url = '<?php echo base_url().$this->session->userdata('login_type').'/';?>';
var base_url = '<?php echo base_url().$this->session->userdata('login_type').'/';?>';
var app = '<?php echo base64_decode($id_);?>';
var patient_id = '<?php echo $det['patient_id'];?>';

</script>
<div id="main-content">

    <div class="row">
        <div class="col-sm-4">
            <div class="" id="sticky">
                <div class="card-widget" style="border: 1px solid #c6c6cc;">
                    <h4 class="panel-content-title">Paciente</h4>
                    <span class="app-divider2"></span>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="patient-info">
                                <div class="profile-tile-box">
                                    <div class="pt-avatar-w"><img alt="" src="<?php echo $this->accounts_model->get_photo('patient', $det['patient_id']);?>">
                                    </div>
                                    <div class="pt-user-last">
                                        <a href="<?php echo base_url(); ?>admin/patient_profile/<?php echo base64_encode($det['patient_id']); ?>" style="color:black;text-decoration:none;"><?php echo $this->accounts_model->get_name('patient',$det['patient_id']);?></a>.
                                    </div>
                                    <br>
                                    <div class="pt-user-med">
                                        <div class="row">
                                            <div class="col-sm-6 col-md-12 col-lg-6">
                                                <div class="patient-details">
                                                    <span style="display: block;">Edad:</span> <span style="font-weight: bold;">
                                                        <?php $originalDate = $this->db->get_where('patient', array('patient_id' => $det['patient_id']))->row()->date_of_birth; $newDate = date("d-m-Y", strtotime($originalDate)); ?>
                                                        <?php echo $this->accounts_model->get_age($originalDate);?>.
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-12 col-lg-6">
                                                <div class="patient-details">
                                                    <span style="display: block;">Género:</span> <span style="font-weight: bold;">
                                                        <?php $gen = $this->db->get_where('patient', array('patient_id' => $det['patient_id']))->row()->gender; echo $gen =='M' ?  'Masculino' : 'Femenino'; ?></span>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-12 col-lg-12">
                                                <div class="patient-details">
                                                    <span style="display: block;">Tipo sanguíneo:</span> <span style="font-weight: bold;">
                                                        <?php $blood = $this->db->get_where('patient', array('patient_id' => $det['patient_id']))->row()->blood; if($blood != '') echo $blood; else echo 'No especificado'; ?></span>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-12 col-lg-6">
                                                <div class="patient-details">
                                                    <span style="display: block;">Estado cívil:</span> <span style="font-weight: bold;"><?php $ms = $this->db->get_where('patient', array('patient_id' => $det['patient_id']))->row()->marital_status; echo $ms =='0' ?  'Soltero' : 'Casado';?></span>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-12 col-lg-12">
                                                <div class="patient-details">
                                                    <span style="display: block;">Dieta:</span> <input type="text" class="form-control" style="font-weight: bold;" onkeyup="saveDieta(this.value)" value="<?php echo $this->db->get_where('patient', array('patient_id' => $det['patient_id']))->row()->dieta;;?>"></input>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-12 col-lg-12 text-left ">
                                                <center><span class="app-divider"></span></center>
                                                <span style="margin-bottom:10px; display:block;font-weight:bold;font-size:16px;font-family:'Poppins', sans-serif">Signos Vitales</span>
                                                <div class="col-sm-12 row">
                                                    <div class="col-sm-12">
                                                        <b>Peso:</b> <?php echo  $vs['w'] ?> (lbs)
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <b>Altura:</b> <?php echo  $vs['t'] ?> (cm)
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <b>IMC:</b> <?php echo  $vs['imc'] ?>
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <b>Temp:</b> <?php echo  $vs['temp'] ?> °C
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <b>FR:</b> <?php echo  $vs['fr'] ?>
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <b>FC:</b> <?php echo  $vs['fc'] ?> latidos por minuto
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <b>PA:</b> <?php echo  $vs['pa'] ?> mmHg
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <b>SO2:</b> <?php echo  $vs['so2'] ?>
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <b>Glucómetria:</b> <?php echo  $vs['gl'] ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-12 col-lg-12 text-center mt-10">
                                                <center><span class="app-divider"></span></center>
                                                <a class="btn btn-lg btn-primary" href="<?php echo base_url().$this->session->userdata('login_type')?>/stabilitation_financial/<?php echo $id_; ?>"> Dar de alta</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-8">
            <!-- Nav tabs -->
            <div class="alert alert-danger">
                <h2>Resumen de Hospitalización</h2>
            </div>
             <!-- Ordenes médica -->
            <div class="card-widget" id="turns" style="margin-top:15px;border: 1px solid #c6c6cc;">
                    <?php
                        include_once(dirname(__DIR__, 1).'/includes/stabilitation_resumen.php');
                    ?>
                </div>
        </div>
    </div>
</div>


<script src="<?php echo base_url();?>public/assets/search/bootstrap3-typeahead.js"></script>
<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
<script>
$(document).ready(function() {

    if ($("#sticky1").length) {
        new StickySidebar('#sticky1', {
            topSpacing: 0
        });
    }

    putVitalSings();

    $('.page').on('paste', function(event) {
        var items = (event.clipboardData || event.originalEvent.clipboardData).items;
        for (var i = 0; i < items.length; i++) {
            if (items[i].type.indexOf("image") !== -1) {
                var blob = items[i].getAsFile();
                var url = URL.createObjectURL(blob);
                var img = new Image();
                img.src = url;
                img.classList.add('resizable'); // Agregar clase para que sea resizable

                const div = document.createElement('div');
                div.classList.add('resizeMe');
                div.appendChild(img);

                $('.page').append(div);
            }
        }
    });

});

function putVitalSings() {

    $page1 = $('.page').last();
    $page = $('.page').last();

    $page.append(`<br><span style="margin-bottom:10px; display:block;font-weight:bold;font-size:16px;font-family:'Poppins', sans-serif">Últimos signos vitales registrados</span>
            <div >
                <b>Peso:</b> <?php echo  $vs['w'] ?> (lbs)
            </div>
            <div >
                <b>Altura:</b> <?php echo  $vs['t'] ?> (cm)
            </div>
            <div >
                <b>IMC:</b> <?php echo  $vs['imc'] ?>
            </div>
            <div >
                <b>Temp:</b> <?php echo  $vs['temp'] ?> °C
            </div>
            <div >
                <b>FR:</b> <?php echo  $vs['fr'] ?>
            </div>
            <div >
                <b>FC:</b> <?php echo  $vs['fc'] ?> latidos por minuto
            </div>
            <div >
                <b>PA:</b> <?php echo  $vs['pa'] ?> mmHg
            </div>
            <div >
                <b>SO2:</b> <?php echo  $vs['so2'] ?>
            </div>
            <div >
                <b>Glucometría:</b> <?php echo  $vs['gl'] ?>
            </div>`);

    var lastChildPos = 0;
    var extraContent = '';

    $page.children().each(function() {
        lastChildPos += $(this).outerHeight();

        if (lastChildPos >= 963) {
            extraContent += $(this)[0].outerHTML;
            $(this).remove();
        }
        console.log('lastChildPos ' + lastChildPos);
    });

    if ($page.next(".page").length == 0 && lastChildPos >= 963) {
        var $newPage = $('<div class="page" contenteditable="true"  onkeydown="checkPage(this,event)"></div>');

        $page1.after($newPage);
        $page = $newPage;
        $page.focus();
        $page.append(extraContent);
        $page1.html($page1.html().replace(extraContent, ''));
    }


}

function checkPage($page, e) {
    var $editor = $('.editor');
    $page1 = $($page);
    $page = $($page);
    var pageHeight = $page.outerHeight() - 100; // altura de una página

    var lastChildPos = 0;
    var extraContent = '';

    $page.children().each(function() {
        lastChildPos += $(this).outerHeight();

        if (lastChildPos >= 963) {
            extraContent += $(this)[0].outerHTML;
            $(this).remove();
        }

    });


    if ($page.next(".page").length == 0 && lastChildPos >= 963) {
        var $newPage = $('<div class="page" contenteditable="true"  onkeydown="checkPage(this,event)"></div>');

        $page1.after($newPage);
        $page = $newPage;
        $page.focus();
        $page.append(extraContent);

    } else if ($page.next(".page").length > 0 && lastChildPos >= 963) {
        $page.next(".page").prepend(extraContent);
    }


    var page_length = $('.page').length;
    if (e.key == 'Backspace' && ($page.html() == '' || $page.html() == '<br>') && page_length > 1) { // fixed syntax error and added missing && character
        e.preventDefault();
        console.log(page_length);

        var el = $page.prev('.page'); // selector para obtener el elemento anterior a $page con clase .page
        var range = document.createRange(); // createRange es una función JavaScript nativa
        var sel = window.getSelection(); // getSelection es una función JavaScript nativa

        range.selectNodeContents(el.get(0)); // establece el rango para seleccionar todo el contenido del elemento HTML
        range.collapse(false); // colapsa el rango en el extremo final del contenido
        sel.removeAllRanges(); // elimina cualquier selección previa
        sel.addRange(range); // establece el nuevo rango de selección

        el.focus();
        $page.remove();

    }

}

function load_view(a, b, c = "") {
    console.log(c);
    $.post(url + "includes/" + a, c, function(data) {
        $('#' + b).hide();
        $('#' + b).html(data);
        $('#' + b).fadeIn(500);
    }, "html");
}

function delete_function(a, b, c = "", d) {

    Swal.fire({
        title: '¿Estás seguro?',
        text: "Se eliminará la información a relacionada.",
        type: 'info',
        showCancelButton: true,
        confirmButtonColor: '#9fd13b',
        cancelButtonColor: '#fd4f57',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.value) {
            $.post(url + a, c, function(data) {}).done(function(data) {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-right',
                    showConfirmButton: false,
                    timer: 5000
                });
                Toast.fire({
                    type: 'error',
                    title: 'Eliminado'
                })

                load_view(d, b, c)
            });;
        }
    })

}

function saveDieta(val) {
  console.log(val);
    $.ajax({
        type: 'POST',
        url: url + 'patients/save_dieta/' + patient_id,
        data: {
            dieta: val,
        },
        success: function(response) {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-right',
                showConfirmButton: false,
                timer: 5000
            });
            Toast.fire({
                type: 'success',
                title: 'Guardado'
            })
        },
        error: function() {
            console.log("error");
        }
        //dataType: "html" // test
    });
};


function save() {
    var content = $('.editor').html(); // orig
    $.ajax({
        type: 'POST',
        url: url + 'patients/save_history/' + patient_id,
        data: {
            history: content,
        },
        success: function(response) {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-right',
                showConfirmButton: false,
                timer: 5000
            });
            Toast.fire({
                type: 'success',
                title: 'Guardado'
            })
        },
        error: function() {
            console.log("error");
        }
        //dataType: "html" // test
    });
};

function save_content(data) {
    $.ajax({
        type: 'POST',
        url: url + 'save_content/' + patient_id,
        data: data,
        success: function(response) {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-right',
                showConfirmButton: false,
                timer: 5000
            });
            Toast.fire({
                type: 'success',
                title: 'Guardado'
            })
        },
        error: function() {
            console.log("error");
        }
        //dataType: "html" // test
    });
};


function getSugest(value, app) {

    $('#med_sugest').val(0);
    $.ajax({
        url: url + "getSugest",
        type: "POST",
        data: {
            app: app,
            name: value,
        },
        success: function(response) {
            $('#results_med').html(response);
            //console.log(response);
        },
        error: function() {
            console.log("error");
        }
    });

}

function addPrescriptionObservations(value, app) {

    $('#med_sugest').val(0);
    $.ajax({
        url: url + "prescriptions/addObservations",
        type: "POST",
        data: {
            code: app,
            value: value,
            patient_id: patient_id,
        },
        success: function(data) {
            console.log(data);
        },
        error: function() {
            alert("Error al agregar la observación");
        }
    });

}

function selectMedicine(idd, text) {
    console.log(decodeURIComponent(escape(atob(text))));
    $('#results_med').html('');
    $('#med').val(decodeURIComponent(escape(atob(text))));
    $('#med_sugest').val(idd);

}


function deleteSugest(element_id, app_id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "Se eliminará esta sugerencia.",
        type: 'info',
        showCancelButton: true,
        confirmButtonColor: '#9fd13b',
        cancelButtonColor: '#fd4f57',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: url + 'prescriptions/deleteSugest/' + element_id,
                success: function(response) {
                    $('#med_' + app_id).click()
                }
            });
        }
    })
}
</script>
<?php if($det['practice']==21):?>
<script src="https://meet.jit.si/external_api.js"></script>
<script>
var domain = "meet.jit.si";
var options = {
    disableDeepLinking: true,
    userInfo: {
        email: '<?php echo $this->db->get_where('admin',array('admin_id'=>$det['doctor_id']))->row()->email;?>',
        displayName: ' <?php echo $this->accounts_model->get_name('admin', $det['doctor_id']);?>',
        moderator: true,
    },
    roomName: "<?php echo base64_encode("Consulta_".$det['date'].$appointment_id);?>",
    width: "100%",
    height: "100%",
    parentNode: document.querySelector('#teleconsulta'),
    interfaceConfigOverwrite: {
        DISABLE_DOMINANT_SPEAKER_INDICATOR: true,
        SHOW_BRAND_WATERMARK: false,
        SHOW_JITSI_WATERMARK: false,
        SHOW_WATERMARK_FOR_GUESTS: false,
        DEFAULT_BACKGROUND: '<?php echo $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->theme?>',
        DEFAULT_LOGO_URL: 'https://medicaby.com/resources/app-logo/logo.svg',
    },
}
var api = new JitsiMeetExternalAPI(domain, options);
api.executeCommand('subject', 'test');
</script>
<?php endif;?>
<script src="<?php echo base_url();?>public/assets/appointments/js/appointments_details.js"></script>
<?php endforeach; ?>