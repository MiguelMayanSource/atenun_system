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
    $origin_id = base64_decode($id_);
    $origin_type = 'stabilitation';
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
                                                <a class="btn btn-lg btn-primary" href="<?php echo base_url().$this->session->userdata('login_type')?>/stabilitation_financial/<?php echo $id_; ?>"> Resumen</a>
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
                <h2>Hospitalización</h2>
            </div>
            <div>
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#c-evolucion" id="d-evolucion">
                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 48 48">
                                <g fill="currentColor">
                                    <path d="M11 30a1 1 0 0 1 1-1h14a1 1 0 1 1 0 2H12a1 1 0 0 1-1-1Zm1 4a1 1 0 1 0 0 2h14a1 1 0 1 0 0-2H12Zm2-13v-3h2v3h3v2h-3v3h-2v-3h-3v-2h3Z" />
                                    <path fill-rule="evenodd" d="M15 6a3 3 0 0 0-3 3H9a3 3 0 0 0-3 3v27a3 3 0 0 0 3 3h20a3 3 0 0 0 3-3V12a3 3 0 0 0-3-3h-3a3 3 0 0 0-3-3h-8Zm8 6a1 1 0 0 0 1-1V9a1 1 0 0 0-1-1h-8a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1h8Zm-11-1a3 3 0 0 0 3 3h8a3 3 0 0 0 3-3h3a1 1 0 0 1 1 1v27a1 1 0 0 1-1 1H9a1 1 0 0 1-1-1V12a1 1 0 0 1 1-1h3Zm24 6a3 3 0 1 1 6 0v20.303l-3 4.5l-3-4.5V17Zm3-1a1 1 0 0 0-1 1v2h2v-2a1 1 0 0 0-1-1Zm0 22.197l1-1.5V21h-2v15.697l1 1.5Z" clip-rule="evenodd" />
                                </g>
                            </svg>
                            Evolución Clínica </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " data-toggle="tab" href="#c-turns" id="d-turns">
                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 18 24">
                                <path fill="currentColor" d="M15.76 2.852h-2.577v1.221h2.584c.655 0 1.186.531 1.186 1.186V21.6c0 .656-.532 1.187-1.187 1.187H2.401A1.187 1.187 0 0 1 1.214 21.6V5.259c0-.656.532-1.187 1.187-1.187h2.584v-1.22H2.408A2.412 2.412 0 0 0-.003 5.263v16.326a2.412 2.412 0 0 0 2.411 2.41h13.351a2.412 2.412 0 0 0 2.411-2.411V5.262a2.412 2.412 0 0 0-2.411-2.411z" />
                                <path fill="currentColor" d="M12.605 2.225h-1.319a2.225 2.225 0 1 0-4.45 0h-1.31v3.057h7.073V2.225zm-2.258 0h-2.57v-.032a1.286 1.286 0 0 1 2.572 0v.034v-.002zm-4.4 6.287h9.458v1.17H5.947zm0 4.898h9.458v1.17H5.947zm0 4.84h9.458v1.176H5.947zM2.628 7.757h2.68v2.68h-2.68zm0 4.898h2.68v2.68h-2.68zm0 4.842h2.68v2.68h-2.68z" />
                            </svg>
                            Encamamiento
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " data-toggle="tab" href="#c-order" id="d-order">
                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 18 24">
                                <path fill="currentColor" d="M15.76 2.852h-2.577v1.221h2.584c.655 0 1.186.531 1.186 1.186V21.6c0 .656-.532 1.187-1.187 1.187H2.401A1.187 1.187 0 0 1 1.214 21.6V5.259c0-.656.532-1.187 1.187-1.187h2.584v-1.22H2.408A2.412 2.412 0 0 0-.003 5.263v16.326a2.412 2.412 0 0 0 2.411 2.41h13.351a2.412 2.412 0 0 0 2.411-2.411V5.262a2.412 2.412 0 0 0-2.411-2.411z" />
                                <path fill="currentColor" d="M12.605 2.225h-1.319a2.225 2.225 0 1 0-4.45 0h-1.31v3.057h7.073V2.225zm-2.258 0h-2.57v-.032a1.286 1.286 0 0 1 2.572 0v.034v-.002zm-4.4 6.287h9.458v1.17H5.947zm0 4.898h9.458v1.17H5.947zm0 4.84h9.458v1.176H5.947zM2.628 7.757h2.68v2.68h-2.68zm0 4.898h2.68v2.68h-2.68zm0 4.842h2.68v2.68h-2.68z" />
                            </svg>
                            Ordenes médicas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " data-toggle="tab" href="#c-vitals" id="d-vitals">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                <path fill="currentColor" d="M19 3h-4.18C14.4 1.84 13.3 1 12 1c-1.3 0-2.4.84-2.82 2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2m-7 0a1 1 0 0 1 1 1a1 1 0 0 1-1 1a1 1 0 0 1-1-1a1 1 0 0 1 1-1M5 15h3.11l1.51-2.85l.76 5.77l3.69-4.71L15.89 15H19v4H5v-4m14-1.54h-2.47l-2.6-2.6l-2.49 3.19l-.94-6.97l-3.33 6.38H5V5h2v1h10V5h2v8.46Z" />
                            </svg>
                            Signos vitales
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " data-toggle="tab" href="#c-nurse_notes" id="d-nurse_notes">
                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 32 32">
                                <path fill="currentColor" d="M16 3c-1.258 0-2.152.89-2.594 2H6v23h20V5h-7.406C18.152 3.89 17.258 3 16 3zm0 2c.555 0 1 .445 1 1v1h3v2h-8V7h3V6c0-.555.445-1 1-1zM8 7h2v4h12V7h2v19H8zm7 7v3h-3v2h3v3h2v-3h3v-2h-3v-3z" />
                            </svg>
                            Notas de enfermeria</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " data-toggle="tab" href="#c-medication_supplied" id="d-medication_supplied">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 48 48">
                                <g fill="none" stroke="currentColor" stroke-width="4">
                                    <path stroke-linejoin="round" d="M34 10H14a2 2 0 0 0-2 2v30a2 2 0 0 0 2 2h20a2 2 0 0 0 2-2V12a2 2 0 0 0-2-2Z" />
                                    <path stroke-linecap="round" d="M12 18h24" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v6m24-6v6" />
                                    <path stroke-linejoin="round" d="M32 4H16v6h16V4Z" />
                                    <path stroke-linecap="round" d="M20 31h8m-4-4v8" />
                                </g>
                            </svg>
                            Control de medicamentos</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link " data-toggle="tab" href="#c-prescription" id="d-prescription">
                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24">
                                <path fill="currentColor" d="m16.95 20.65l1.15-1.15l-1.6-1.6l-1.15 1.15q-.35.35-.35.8t.35.8q.35.35.8.35t.8-.35Zm2.55-2.55l1.15-1.15q.35-.35.35-.8t-.35-.8q-.35-.35-.8-.35t-.8.35L17.9 16.5l1.6 1.6Zm-1.125 3.975Q17.45 23 16.15 23t-2.225-.925Q13 21.15 13 19.85t.925-2.225l3.7-3.7Q18.55 13 19.85 13t2.225.925Q23 14.85 23 16.15t-.925 2.225l-3.7 3.7ZM5 19V5v14Zm0 2q-.825 0-1.413-.588T3 19V5q0-.825.588-1.413T5 3h4.2q.325-.9 1.088-1.45T12 1q.95 0 1.713.55T14.8 3H19q.825 0 1.413.588T21 5v6.125Q20.5 11 20 11t-1 .075V5H5v14h6.075Q11 19.5 11 20t.125 1H5Zm7-16.75q.325 0 .537-.213t.213-.537q0-.325-.213-.537T12 2.75q-.325 0-.537.213t-.213.537q0 .325.213.537T12 4.25ZM7 9V7h10v2H7Zm0 4v-2h10v.85q-.2.125-.388.288t-.387.362l-.5.5H7Zm0 4v-2h6.725L12.5 16.225q-.2.2-.362.388T11.85 17H7Z" />
                            </svg>
                            Recetas médicas</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link " data-toggle="tab" href="#c-labs" id="d-labs">
                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24">
                                <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 21h14M6 18h2m-1 0v3m2-10l3 3l6-6l-3-3zm1.5 1.5L9 14m8-11l3 3m-8 15a6 6 0 0 0 3.715-10.712" />
                            </svg>
                            Laboratorios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " data-toggle="tab" href="#c-rayx" id="d-rayx">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M19 5v14H5V5h14m0-2H5c-1.11 0-2 .89-2 2v14c0 1.11.89 2 2 2h14c1.11 0 2-.89 2-2V5c0-1.11-.89-2-2-2m-7 3c.55 0 1 .45 1 1v1h3.17c.18.31.33.65.49 1H13v1h4c.1.33.17.67.19 1H13v1h4.2c-.04.35-.05.69-.1 1H13v1h4s-.06 3-1.5 3c-1.35 0-1-1.53-2.5-2v2c0 .55-.45 1-1 1s-1-.45-1-1v-2c-1.5.47-1.15 2-2.5 2C7.06 17 7 14 7 14h4v-1H6.9c-.05-.31-.06-.65-.1-1H11v-1H6.81c.02-.33.1-.67.19-1h4V9H7.34c.16-.35.31-.69.49-1H11V7c0-.55.45-1 1-1Z"/></svg>
                            Rayos X</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " data-toggle="tab" href="#c-ultras" id="d-ultras">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 64 64"><path fill="currentColor" d="M55.211 54.93a7.65 7.65 0 0 0 1.276-7.486l-.874-2.416h5.305V.307H3.377v44.721H34.32l3.376 9.259a7.657 7.657 0 0 0 5.792 4.911l1.586 4.801l13.277.002l-3.139-9.07zm-4.827-24.163a5.474 5.474 0 0 0-3.267 7.012l2.046 5.582H5.041V1.972h54.212v41.389h-4.259l-4.611-12.594z"/><path fill="currentColor" d="M54.335 23.224c-12.253 12.25-32.122 12.25-44.375 0L27.965 5.21a5.905 5.905 0 0 0 8.358 0l18.012 18.014zm-12.774-3.659a4.321 4.321 0 0 0 1.126-5.992c-1.349-1.96-4.032-2.465-5.99-1.121a4.31 4.31 0 0 0 4.865 7.114zm-4.648 2.533c-.088-.249-.2-.487-.397-.692c0 0-3.497-3.69-4.361-4.598c.057-1.097.195-3.939.195-3.939a1.864 1.864 0 0 0-1.774-1.941a1.851 1.851 0 0 0-1.941 1.765l-.221 4.73a1.849 1.849 0 0 0 .503 1.366l1.597 1.688l-4.796 3.166l.258-3.622a2.543 2.543 0 0 0-2.748-2.309s-4.56.315-6.214.454a1.906 1.906 0 0 0-1.734 2.064a1.91 1.91 0 0 0 2.06 1.738c1.154-.102 3.853-.194 4.948-.284c0 0-.947 2.758-.751 4.12c.123.892.379 1.791.923 2.589a5.392 5.392 0 0 0 7.497 1.401c.879-.599 5.248-3.587 6.07-4.151a2.766 2.766 0 0 0 .885-3.544z"/></svg>
                            Ultrasonidos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " data-toggle="tab" href="#c-extras" id="d-extras">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 20 20"><path fill="currentColor" d="M6 2a2 2 0 0 0-2 2v7h1V4a1 1 0 0 1 1-1h4v3.5A1.5 1.5 0 0 0 11.5 8H15v8a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1v-2H4v2a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V7.414a1.5 1.5 0 0 0-.44-1.06l-3.914-3.915A1.5 1.5 0 0 0 10.586 2zm8.793 5H11.5a.5.5 0 0 1-.5-.5V3.207zM6.5 10a.5.5 0 0 0 0 1h7a.5.5 0 0 0 0-1zm-4 2a.5.5 0 0 0 0 1h7a.5.5 0 0 0 0-1zm4 2a.5.5 0 0 0 0 1h7a.5.5 0 0 0 0-1z"/></svg>
                            Extras
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " data-toggle="tab" href="#c-consent" id="d-consent">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 20 20"><path fill="currentColor" d="M6 2a2 2 0 0 0-2 2v7h1V4a1 1 0 0 1 1-1h4v3.5A1.5 1.5 0 0 0 11.5 8H15v8a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1v-2H4v2a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V7.414a1.5 1.5 0 0 0-.44-1.06l-3.914-3.915A1.5 1.5 0 0 0 10.586 2zm8.793 5H11.5a.5.5 0 0 1-.5-.5V3.207zM6.5 10a.5.5 0 0 0 0 1h7a.5.5 0 0 0 0-1zm-4 2a.5.5 0 0 0 0 1h7a.5.5 0 0 0 0-1zm4 2a.5.5 0 0 0 0 1h7a.5.5 0 0 0 0-1z"/></svg>
                            Consentimientos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " data-toggle="tab" href="#c-files" id="d-files">
                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 256 256">
                                <path fill="currentColor" d="m212.24 67.76l-40-40A6 6 0 0 0 168 26H88a14 14 0 0 0-14 14v18H56a14 14 0 0 0-14 14v144a14 14 0 0 0 14 14h112a14 14 0 0 0 14-14v-18h18a14 14 0 0 0 14-14V72a6 6 0 0 0-1.76-4.24ZM170 216a2 2 0 0 1-2 2H56a2 2 0 0 1-2-2V72a2 2 0 0 1 2-2h77.51L170 106.49Zm32-32a2 2 0 0 1-2 2h-18v-82a6 6 0 0 0-1.76-4.24l-40-40A6 6 0 0 0 136 58H86V40a2 2 0 0 1 2-2h77.51L202 74.49Zm-60-32a6 6 0 0 1-6 6H88a6 6 0 0 1 0-12h48a6 6 0 0 1 6 6Zm0 32a6 6 0 0 1-6 6H88a6 6 0 0 1 0-12h48a6 6 0 0 1 6 6Z" />
                            </svg>
                            Archivos</a>
                    </li>
                </ul>
            </div>
            <div class="tab-content">
                <!-- Historial Clinico -->
                <div class="tab-pane container fade show active " id="c-evolucion">
                    <div class="layout-px-spacing" style="margin-top:15px; width: 26.5cm;">
                        <div class="row layout-top-spacing">
                            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                                <div class="widget-content widget-content-area br-6">
                                    <div id="sticky1">
                                        <div class="" id="mydiv">
                                            <img class="intLink" title="Save" onclick="save()"
                                                 src="data:image/png;base64,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" />
                                            <select style=" width: 35px;" onchange="formatDoc('fontname',this[this.selectedIndex].value);this.selectedIndex=0;">
                                                <option class="heading" selected>F</option>
                                                <option>Arial</option>
                                                <option>Arial Black</option>
                                                <option>Courier New</option>
                                                <option>Times New Roman</option>
                                            </select>
                                            <select style=" width: 35px;" onchange="formatDoc('fontsize',this[this.selectedIndex].value);this.selectedIndex=0;">
                                                <option class="heading" selected>T</option>
                                                <option value="1">Muy pequeño</option>
                                                <option value="2">Pequeño</option>
                                                <option value="3">Normal</option>
                                                <option value="4">Medio grande</option>
                                                <option value="5">Grande</option>
                                                <option value="6">Muy grande</option>
                                                <option value="7">Maximo</option>
                                            </select>
                                            <select style=" width: 35px;" onchange="formatDoc('forecolor',this[this.selectedIndex].value);this.selectedIndex=0;">
                                                <option class="heading" selected>C</option>
                                                <option value="black">Negro</option>
                                                <option value="red">Rojo</option>
                                                <option value="blue">Azul</option>
                                                <option value="green">Verde</option>
                                            </select>
                                            <img class="intLink" title="Undo" onclick="formatDoc('undo');" src="data:image/gif;base64,R0lGODlhFgAWAOMKADljwliE33mOrpGjuYKl8aezxqPD+7/I19DV3NHa7P///////////////////////yH5BAEKAA8ALAAAAAAWABYAAARR8MlJq7046807TkaYeJJBnES4EeUJvIGapWYAC0CsocQ7SDlWJkAkCA6ToMYWIARGQF3mRQVIEjkkSVLIbSfEwhdRIH4fh/DZMICe3/C4nBQBADs=" />
                                            <img class="intLink" title="Redo" onclick="formatDoc('redo');" src="data:image/gif;base64,R0lGODlhFgAWAMIHAB1ChDljwl9vj1iE34Kl8aPD+7/I1////yH5BAEKAAcALAAAAAAWABYAAANKeLrc/jDKSesyphi7SiEgsVXZEATDICqBVJjpqWZt9NaEDNbQK1wCQsxlYnxMAImhyDoFAElJasRRvAZVRqqQXUy7Cgx4TC6bswkAOw==" />
                                            <img class="intLink" title="Bold" onclick="formatDoc('bold');" src="data:image/gif;base64,R0lGODlhFgAWAID/AMDAwAAAACH5BAEAAAAALAAAAAAWABYAQAInhI+pa+H9mJy0LhdgtrxzDG5WGFVk6aXqyk6Y9kXvKKNuLbb6zgMFADs=" />
                                            <img class="intLink" title="Italic" onclick="formatDoc('italic');" src="data:image/gif;base64,R0lGODlhFgAWAKEDAAAAAF9vj5WIbf///yH5BAEAAAMALAAAAAAWABYAAAIjnI+py+0Po5x0gXvruEKHrF2BB1YiCWgbMFIYpsbyTNd2UwAAOw==" />
                                            <img class="intLink" title="Underline" onclick="formatDoc('underline');" src="data:image/gif;base64,R0lGODlhFgAWAKECAAAAAF9vj////////yH5BAEAAAIALAAAAAAWABYAAAIrlI+py+0Po5zUgAsEzvEeL4Ea15EiJJ5PSqJmuwKBEKgxVuXWtun+DwxCCgA7" />
                                            <img class="intLink" title="Left align" onclick="formatDoc('justifyleft');" src="data:image/gif;base64,R0lGODlhFgAWAID/AMDAwAAAACH5BAEAAAAALAAAAAAWABYAQAIghI+py+0Po5y02ouz3jL4D4JMGELkGYxo+qzl4nKyXAAAOw==" />
                                            <img class="intLink" title="Center align" onclick="formatDoc('justifycenter');" src="data:image/gif;base64,R0lGODlhFgAWAID/AMDAwAAAACH5BAEAAAAALAAAAAAWABYAQAIfhI+py+0Po5y02ouz3jL4D4JOGI7kaZ5Bqn4sycVbAQA7" />
                                            <img class="intLink" title="Right align" onclick="formatDoc('justifyright');" src="data:image/gif;base64,R0lGODlhFgAWAID/AMDAwAAAACH5BAEAAAAALAAAAAAWABYAQAIghI+py+0Po5y02ouz3jL4D4JQGDLkGYxouqzl43JyVgAAOw==" />
                                            <img class="intLink" title="justifyFull align" onclick="formatDoc('justifyFull');" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAMgAAADICAYAAACtWK6eAAAABHNCSVQICAgIfAhkiAAAAAlwSFlzAAALEwAACxMBAJqcGAAAAdJJREFUeJzt3MFJBEEQhtFVTELwaBKCARiKYZiEYCLCxmAGgicxCUFYL+71p8uhemeZ92BufSjQ77ZVux0AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAMxwUXj70jYFzPc48qgSyOGfg8AaDf3vX3ZPAedMIBAIBAKBQCAQCAQCgUAgEAgEAoHgqvD2rm0KAAAAAAAAAFiLyk76vm0KmO9h5JGjDWyVow2wlEAgEAgEAoFAIBAIBAKBQCAQCAQCQeVow3XbFAAAAAAAAACwFpWd9I+2KWC+25FHjjawVY42wFICgUAgEAgEAoFAIBAIBAKBQCCo7KR/t00BAAAAAAAAAMAZqOyk/7RNAfMN/czK0Qa2ytEGWEogEAgEAoFAIBAIBAKBQCAQCASVow3vbVMAAAAAAAAAwFpUVm5v2qaA+b5GHtlJZ6vspMNSAoFAIBAIBAKBQCAQCAQCgUAgEAgElaMNr21TAAAAAAAAAMBaVHbS79um4Ojz7+MMHXzt39PoH4M5/FgRAoFAIBAIBAKBQCAQCAQCgUAgEAgEgsrRhue2KTh6O/UAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAADAKfwC8T5p6z9Pf5gAAAAASUVORK5CYII=" />
                                            <img class="intLink" title="Numbered list" onclick="formatDoc('insertorderedlist');" src="data:image/gif;base64,R0lGODlhFgAWAMIGAAAAADljwliE35GjuaezxtHa7P///////yH5BAEAAAcALAAAAAAWABYAAAM2eLrc/jDKSespwjoRFvggCBUBoTFBeq6QIAysQnRHaEOzyaZ07Lu9lUBnC0UGQU1K52s6n5oEADs=" />
                                            <img class="intLink" title="Dotted list" onclick="formatDoc('insertunorderedlist');" src="data:image/gif;base64,R0lGODlhFgAWAMIGAAAAAB1ChF9vj1iE33mOrqezxv///////yH5BAEAAAcALAAAAAAWABYAAAMyeLrc/jDKSesppNhGRlBAKIZRERBbqm6YtnbfMY7lud64UwiuKnigGQliQuWOyKQykgAAOw==" />
                                            <img class="intLink" title="Add indentation" onclick="formatDoc('outdent');" src="data:image/gif;base64,R0lGODlhFgAWAMIHAAAAADljwliE35GjuaezxtDV3NHa7P///yH5BAEAAAcALAAAAAAWABYAAAM2eLrc/jDKCQG9F2i7u8agQgyK1z2EIBil+TWqEMxhMczsYVJ3e4ahk+sFnAgtxSQDqWw6n5cEADs=" />
                                            <img class="intLink" title="Delete indentation" onclick="formatDoc('indent');" src="data:image/gif;base64,R0lGODlhFgAWAOMIAAAAADljwl9vj1iE35GjuaezxtDV3NHa7P///////////////////////////////yH5BAEAAAgALAAAAAAWABYAAAQ7EMlJq704650B/x8gemMpgugwHJNZXodKsO5oqUOgo5KhBwWESyMQsCRDHu9VOyk5TM9zSpFSr9gsJwIAOw==" />
                                            <img class="intLink" title="Print" onclick="print_diagnostic();" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABYAAAAWCAYAAADEtGw7AAAABGdBTUEAALGPC/xhBQAAAAZiS0dEAP8A/wD/oL2nkwAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oEBxcZFmGboiwAAAAIdEVYdENvbW1lbnQA9syWvwAAAuFJREFUOMvtlUtsjFEUx//n3nn0YdpBh1abRpt4LFqtqkc3jRKkNEIsiIRIBBEhJJpKlIVo4m1RRMKKjQiRMJRUqUdKPT71qpIpiRKPaqdF55tv5vvusZjQTjOlseUkd3Xu/3dPzusC/22wtu2wRn+jG5So/OCDh8ycMJDflehMlkJkVK7KUYN+ufzA/RttH76zaVocDptRxzQtNi3mRWuPc+6cKtlXZ/sddP2uu9uXlmYXZ6Qm8v4Tz8lhF1H+zDQXt7S8oLMXtbF4e8QaFHjj3kbP2MzkktHpiTjp9VH6iHiA+whtAsX5brpwueMGdONdf/2A4M7ukDs1JW662+XkqTkeUoqjKtOjm2h53YFL15pSJ04Zc94wdtibr26fXlC2mzRvBccEbz2kiRFD414tKMlEZbVGT33+qCoHgha81SWYsew0r1uzfNylmtpx80pngQQ91LwVk2JGvGnfvZG6YcYRAT16GFtW5kKKfo1EQLtfh5Q2etT0BIWF+aitq4fDbk+ImYo1OxvGF03waFJQvBCkvDffRyEtxQiFFYgAZTHS0zwAGD7fG5TNnYNTp8/FzvGwJOfmgG7GOx0SAKKgQgDMgKBI0NJGMEImpGDk5+WACEwEd0ywblhGUZ4Hw5OdUekRBLT7DTgdEgxACsIznx8zpmWh7k4rkpJcuHDxCul6MDsmmBXDlWCH2+XozSgBnzsNCEE4euYV4pwCpsWYPW0UHDYBKSWu1NYjENDReqtKjwn2+zvtTc1vMSTB/mvev/WEYSlASsLimcOhOBJxw+N3aP/SjefNL5GePZmpu4kG7OPr1+tOfPyUu3BecWYKcwQcDFmwFKAUo90fhKDInBCAmvqnyMgqUEagQwCoHBDc1rjv9pIlD8IbVkz6qYViIBQGTJPx4k0XpIgEZoRN1Da0cij4VfR0ta3WvBXH/rjdCufv6R2zPgPH/e4pxSBCpeatqPrjNiso203/5s/zA171Mv8+w1LOAAAAAElFTkSuQmCC">
                                        </div>
                                    </div>
                                    <div class="editor">
                                        <?php 
                                            $history = $this->db->get_where('patient',array('patient_id'=>$patient_id))->row()->history; 
                                            if($history != ""):
                                        ?>
                                        <?php echo $history;?>

                                        <?php else: ?>
                                        <div class="page" id="page_1" contenteditable="true" onkeyup="checkPage(this,event)"></div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Notas de enfermeria -->
                <div class="tab-pane container fade" id="c-nurse_notes">
                    <div class="card-widget" id="nurse_notes" style="margin-top:15px;border: 1px solid #c6c6cc;">
                        <?php
                            include_once(dirname(__DIR__, 1).'/includes/nurse_notes.php');
                        ?>
                    </div>
                </div>

                <!-- Ordenes médica -->
                <div class="tab-pane container fade" id="c-turns">
                    <div class="card-widget" id="turns" style="margin-top:15px;border: 1px solid #c6c6cc;">
                        <?php
                            include_once(dirname(__DIR__, 1).'/includes/patient_turns.php');
                        ?>
                    </div>
                </div>

                <!-- medication_supplied -->
                <div class="tab-pane container fade" id="c-medication_supplied">
                    <div class="card-widget" id="medication_supplied" style="margin-top:15px;border: 1px solid #c6c6cc;">
                        <?php
                            include_once(dirname(__DIR__, 1).'/includes/medication_supplied.php');
                        ?>
                    </div>
                </div>
                <!-- Receta médica -->
                <div class="tab-pane container fade" id="c-prescription">
                    <div class="card-widget" id="recetas" style="margin-top:15px;border: 1px solid #c6c6cc;">
                        <?php
                            include_once(dirname(__DIR__, 1).'/includes/patient_prescriptions.php');
                        ?>
                    </div>
                </div>
                <!-- Signos vitales -->
                <div class="tab-pane container fade" id="c-vitals">
                    <div class="card-widget" id="vitals" style="margin-top:15px;border: 1px solid #c6c6cc;">
                        <?php
                            include_once(dirname(__DIR__, 1).'/includes/patient_vital_signs.php');
                        ?>
                    </div>
                </div>
                <!-- Ordenes médica -->
                <div class="tab-pane container fade" id="c-order">
                    <div class="card-widget" id="orders" style="margin-top:15px;border: 1px solid #c6c6cc;">
                        <?php
                            include_once(dirname(__DIR__, 1).'/includes/patient_order.php');
                        ?>
                    </div>
                </div>
                <!-- Laboratorios médica -->
                <div class="tab-pane container fade" id="c-labs">
                    <div class="card-widget" id="labs" style="margin-top:15px;border: 1px solid #c6c6cc;">
                        <?php
                            include_once(dirname(__DIR__, 1).'/includes/patient_labs.php');
                        ?>
                    </div>
                </div>
                <!-- ultrasonidos -->
                <div class="tab-pane container fade" id="c-ultras">
                    <div class="card-widget" id="ultras" style="margin-top:15px;border: 1px solid #c6c6cc;">
                        <?php
                            include_once(dirname(__DIR__, 1).'/includes/patient_ultras.php');
                        ?>
                    </div>
                </div>
                 <!-- Rayos X médica -->
                <div class="tab-pane container fade" id="c-rayx">
                    <div class="card-widget" id="rayx" style="margin-top:15px;border: 1px solid #c6c6cc;">
                        <?php
                            include_once(dirname(__DIR__, 1).'/includes/patient_rayx.php');
                        ?>
                    </div>
                </div>
                 <!-- Extras de hospitalization -->
                <div class="tab-pane container fade" id="c-extras">
                    <div class="card-widget" id="extras" style="margin-top:15px;border: 1px solid #c6c6cc;">
                        <?php
                            include_once(dirname(__DIR__, 1).'/includes/patient_extras.php');
                        ?>
                    </div>
                </div>
                <!-- Consentimientos -->
                <div class="tab-pane container fade" id="c-consent">
                    <div class="card-widget" id="consent" style="margin-top:15px;border: 1px solid #c6c6cc;">
                        <?php
                            include_once(dirname(__DIR__, 1).'/includes/patient_consent.php');
                        ?>
                    </div>
                </div>
                <!-- Archivos -->
                <div class="tab-pane container fade" id="c-files">
                    <div class="card-widget" id="files" style="margin-top:15px;border: 1px solid #c6c6cc;">
                        <?php
                        $parent_id=0;
                            include_once(dirname(__DIR__, 1).'/includes/patient_files.php');
                        ?>
                    </div>
                </div>
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