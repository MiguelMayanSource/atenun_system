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

    background: #002a4d;
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

.alert-primary {
    background: #002a4d;
    color: white !important;
}

.nav-tabs .nav-item.show .nav-link,
.nav-tabs .nav-link.active {
    border-bottom: 5px solid #002a4d;
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

.el-tablo {
    display: block;
    border-radius: 6px;
    margin: 10px;
    background-color: #002a4d;
    padding: 15px;
    box-shadow: 0px 2px 4px rgb(126 142 177 / 12%);
    color: white !important;

}

.el-tablo .label {
    color: white !important;
    /* color: rgba(0, 0, 0, 0.4); */
}

#user_data {
    width: 100% !important;
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
                    <center>
                        <h5 style="color:#43485c">Detalles del paciente</h5>
                        <hr>
                        <div>
                            <img width="100px" src="<?php echo $this->accounts_model->get_photo('patient', $patient_id);?>" alt="Profile image">

                            <h4><?php echo $this->accounts_model->get_full_name('patient', $patient_id);?></h4>
                            <p><?php $gen = $details['gender']; if($gen =='M' )  echo 'Masculino'; if($gen =='F' )  echo 'Femenino'; if($gen =='O' )  echo 'Otro';?></p>
                        </div>
                        <div>
                            <a href="<?php echo base_url();?>" class="btn btn-primary"><i class="picons-thin-icon-thin-0294_phone_call_ringing"></i></a>
                            <a href="<?php echo base_url();?>" class="btn btn-primary"><i class="picons-thin-icon-thin-0275_chat_message_comment_bubble_typing"></i></a>
                            <a href="<?php echo base_url();?>admin/patients_edit/<?php echo base64_encode($patient_id);?>" class="btn btn-warning"><i class="picons-thin-icon-thin-0001_compose_write_pencil_new"></i></a>
                            <a href="javascript:void(0)" onclick="delete_patient(<?php echo $patient_id;?>)"	 class="btn btn-danger"><i class="picons-thin-icon-thin-0056_bin_trash_recycle_delete_garbage_empty"></i></a>
                        </div>
                        <hr>
                        <div style="text-align: left;">
                            <p><b>Información general</b></p>
                            <table style="font-size: 14px">
                                <tbody>
                                    <tr>

                                        <td style="display: block;"><b>Edad:</b></td>
                                        <td>
                                            <?php
                                                $originalDate = $this->db->get_where('patient', array('patient_id' => $patient_id))->row()->date_of_birth;
                                                $age = $this->accounts_model->get_age_card($originalDate);
                                                echo  $age;
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="display: block;"><b>Género:</b></td>
                                        <td><?php $gen = $this->db->get_where('patient', array('patient_id' => $patient_id))->row()->gender; echo $gen =='M' ?  'Masculino' : 'Femenino'; ?></td>
                                    </tr>
                                    <tr>
                                        <td style="display: block;"><b>Tipo sanguíneo:</b></td>
                                        <td> <?php $blood = $this->db->get_where('patient', array('patient_id' => $patient_id))->row()->blood; if($blood != '') echo $blood; else echo 'No especificado'; ?></td>
                                    </tr>
                                    <tr>
                                        <td style="display: block;"><b>Estado cívil:</b> </td>
                                        <td><?php $ms = $this->db->get_where('patient', array('patient_id' => $patient_id))->row()->marital_status; echo $ms =='0' ?  'Soltero' : 'Casado';?></td>
                                    </tr>
                                    <tr>
                                        <td style="display: block;"><b>Correo:</b></td>
                                        <td> <?php echo $this->db->get_where('patient', array('patient_id' => $patient_id))->row()->email; ?></td>
                                    </tr>
                                    <tr>
                                        <td style="display: block;"><b>Celular:</b></td>
                                        <td> <?php echo $this->db->get_where('patient', array('patient_id' => $patient_id))->row()->phone; ?></td>
                                    </tr>
                                </tbody>
                            </table>
                            <hr>
                            <p>
                                <b>Puntos</b>
                                <br>
                                <?php echo $this->crud_model->getPatientPoints($patient_id);?>
                            </p>

                        </div>
                    </center>
                    <div class="text-center account-container"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="todo-content conts">
        <div style="width:auto">
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
                    <a class="nav-link " data-toggle="tab" href="#c-apps" id="d-apps">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24">
                            <path fill="currentColor" d="m16.95 20.65l1.15-1.15l-1.6-1.6l-1.15 1.15q-.35.35-.35.8t.35.8q.35.35.8.35t.8-.35Zm2.55-2.55l1.15-1.15q.35-.35.35-.8t-.35-.8q-.35-.35-.8-.35t-.8.35L17.9 16.5l1.6 1.6Zm-1.125 3.975Q17.45 23 16.15 23t-2.225-.925Q13 21.15 13 19.85t.925-2.225l3.7-3.7Q18.55 13 19.85 13t2.225.925Q23 14.85 23 16.15t-.925 2.225l-3.7 3.7ZM5 19V5v14Zm0 2q-.825 0-1.413-.588T3 19V5q0-.825.588-1.413T5 3h4.2q.325-.9 1.088-1.45T12 1q.95 0 1.713.55T14.8 3H19q.825 0 1.413.588T21 5v6.125Q20.5 11 20 11t-1 .075V5H5v14h6.075Q11 19.5 11 20t.125 1H5Zm7-16.75q.325 0 .537-.213t.213-.537q0-.325-.213-.537T12 2.75q-.325 0-.537.213t-.213.537q0 .325.213.537T12 4.25ZM7 9V7h10v2H7Zm0 4v-2h10v.85q-.2.125-.388.288t-.387.362l-.5.5H7Zm0 4v-2h6.725L12.5 16.225q-.2.2-.362.388T11.85 17H7Z" />
                        </svg>
                        Citas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " data-toggle="tab" href="#c-prescription" id="d-prescription">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24">
                            <path fill="currentColor" d="m16.95 20.65l1.15-1.15l-1.6-1.6l-1.15 1.15q-.35.35-.35.8t.35.8q.35.35.8.35t.8-.35Zm2.55-2.55l1.15-1.15q.35-.35.35-.8t-.35-.8q-.35-.35-.8-.35t-.8.35L17.9 16.5l1.6 1.6Zm-1.125 3.975Q17.45 23 16.15 23t-2.225-.925Q13 21.15 13 19.85t.925-2.225l3.7-3.7Q18.55 13 19.85 13t2.225.925Q23 14.85 23 16.15t-.925 2.225l-3.7 3.7ZM5 19V5v14Zm0 2q-.825 0-1.413-.588T3 19V5q0-.825.588-1.413T5 3h4.2q.325-.9 1.088-1.45T12 1q.95 0 1.713.55T14.8 3H19q.825 0 1.413.588T21 5v6.125Q20.5 11 20 11t-1 .075V5H5v14h6.075Q11 19.5 11 20t.125 1H5Zm7-16.75q.325 0 .537-.213t.213-.537q0-.325-.213-.537T12 2.75q-.325 0-.537.213t-.213.537q0 .325.213.537T12 4.25ZM7 9V7h10v2H7Zm0 4v-2h10v.85q-.2.125-.388.288t-.387.362l-.5.5H7Zm0 4v-2h6.725L12.5 16.225q-.2.2-.362.388T11.85 17H7Z" />
                        </svg>
                        Recetas médicas</a>
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
                    <a class="nav-link " data-toggle="tab" href="#c-labs" id="d-labs">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24">
                            <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 21h14M6 18h2m-1 0v3m2-10l3 3l6-6l-3-3zm1.5 1.5L9 14m8-11l3 3m-8 15a6 6 0 0 0 3.715-10.712" />
                        </svg>
                        Laboratorios
                    </a>
                </li>
            
                <li class="nav-item">
                    <a class="nav-link " data-toggle="tab" href="#c-rayx" id="d-rayx">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24">
                            <path fill="currentColor" d="M19 5v14H5V5h14m0-2H5c-1.11 0-2 .89-2 2v14c0 1.11.89 2 2 2h14c1.11 0 2-.89 2-2V5c0-1.11-.89-2-2-2m-7 3c.55 0 1 .45 1 1v1h3.17c.18.31.33.65.49 1H13v1h4c.1.33.17.67.19 1H13v1h4.2c-.04.35-.05.69-.1 1H13v1h4s-.06 3-1.5 3c-1.35 0-1-1.53-2.5-2v2c0 .55-.45 1-1 1s-1-.45-1-1v-2c-1.5.47-1.15 2-2.5 2C7.06 17 7 14 7 14h4v-1H6.9c-.05-.31-.06-.65-.1-1H11v-1H6.81c.02-.33.1-.67.19-1h4V9H7.34c.16-.35.31-.69.49-1H11V7c0-.55.45-1 1-1Z" />
                        </svg>
                        Rayos X</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " data-toggle="tab" href="#c-ultras" id="d-ultras">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 64 64">
                            <path fill="currentColor" d="M55.211 54.93a7.65 7.65 0 0 0 1.276-7.486l-.874-2.416h5.305V.307H3.377v44.721H34.32l3.376 9.259a7.657 7.657 0 0 0 5.792 4.911l1.586 4.801l13.277.002l-3.139-9.07zm-4.827-24.163a5.474 5.474 0 0 0-3.267 7.012l2.046 5.582H5.041V1.972h54.212v41.389h-4.259l-4.611-12.594z" />
                            <path fill="currentColor" d="M54.335 23.224c-12.253 12.25-32.122 12.25-44.375 0L27.965 5.21a5.905 5.905 0 0 0 8.358 0l18.012 18.014zm-12.774-3.659a4.321 4.321 0 0 0 1.126-5.992c-1.349-1.96-4.032-2.465-5.99-1.121a4.31 4.31 0 0 0 4.865 7.114zm-4.648 2.533c-.088-.249-.2-.487-.397-.692c0 0-3.497-3.69-4.361-4.598c.057-1.097.195-3.939.195-3.939a1.864 1.864 0 0 0-1.774-1.941a1.851 1.851 0 0 0-1.941 1.765l-.221 4.73a1.849 1.849 0 0 0 .503 1.366l1.597 1.688l-4.796 3.166l.258-3.622a2.543 2.543 0 0 0-2.748-2.309s-4.56.315-6.214.454a1.906 1.906 0 0 0-1.734 2.064a1.91 1.91 0 0 0 2.06 1.738c1.154-.102 3.853-.194 4.948-.284c0 0-.947 2.758-.751 4.12c.123.892.379 1.791.923 2.589a5.392 5.392 0 0 0 7.497 1.401c.879-.599 5.248-3.587 6.07-4.151a2.766 2.766 0 0 0 .885-3.544z" />
                        </svg>

                        Ultrasonidos</a>
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

                                <div class="editor">
                                    <?php 
                                        $history = $this->db->get_where('patient',array('patient_id'=>$patient_id))->row()->history; 
                                        $apps_op = $this->db->order_by('appointment_id','asc')->get_where('appointment',array('observations !='=>'','patient_id'=>$patient_id))->result_array();
                                        foreach($apps_op as $obse)
                                        {
                                            $history .= $obse['observations'];
                                            
                                        }
                                        if($history != ""):
                                    ?>
                                    <?php 
                                        echo $history;
                                     else: ?>
                                    <div class="page" id="page_1" contenteditable="true" onkeydown="checkPage(this,event)"></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Receta meédica -->
            <div class="tab-pane container fade" id="c-prescription">
                <div class="card-widget" id="recetas" style="margin-top:15px;border: 1px solid #c6c6cc;">
                    <?php
                            include_once(dirname(__DIR__, 1).'/includes/patient_prescriptions.php');
                        ?>
                </div>
            </div>
            <!-- Listado de citas -->
            <div class="tab-pane container fade" id="c-apps">
                <div class="card-widget" id="orders" style="margin-top:15px;border: 1px solid #c6c6cc;">
                    <?php
                            include_once(dirname(__DIR__, 1).'/includes/patient_appointments.php');
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
            <!-- Signos vitales -->
            <div class="tab-pane container fade" id="c-vitals">
                <div class="card-widget" id="vitals" style="margin-top:15px;border: 1px solid #c6c6cc;">
                    <?php
                            include_once(dirname(__DIR__, 1).'/includes/patient_vital_signs.php');
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
            <!-- Ultras médica -->
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
<script src="<?php echo base_url();?>public/assets/theme/js/sticky-sidebar.js"></script>
<script src="<?php echo base_url();?>public/assets/theme/js/jquery.sticky.js"></script>
<script src="<?php echo base_url();?>public/assets/theme/js/PositionSticky/dist/PositionSticky.js"></script>
<script>
var sidebar = new StickySidebar('#sticky', {
    topSpacing: 10
});

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#imagePreview').css('background-image', 'url(' + e.target.result + ')');
            $('#imagePreview').hide();
            $('#imagePreview').fadeIn(650);
        }
        reader.readAsDataURL(input.files[0]);
    }
}
$("#imageUpload").change(function() {
    readURL(this);
});
$(function() {
    'use strict';

    $('.page').removeAttr('onkeyup');
    $('.page').removeAttr('contenteditable');
    if ($('#DoctorPicker1').length) {
        var date = new Date();
        var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
        $('#DoctorPicker1').datepicker({
            format: "dd/mm/yyyy",
            todayHighlight: true,
            autoclose: true
        });
    }
});
$('.ae-side-menu-toggler').on('click', function() {
    $('.app-side').toggleClass('compact-side-menu');
});
if ($('.app-side').length) {
    if (is_display_type('phone') || is_display_type('tablet')) {
        $('.app-side').addClass('compact-side-menu');
    }
}
//Validar correo electronico  
function validateEXP(exp) {
    console.log(exp);
    $.ajax({
        type: "POST",
        url: "<?php echo base_url();?>admin/check_patient_exp",
        data: {
            'code': exp
        },
        success: function(data) {
            console.log(data.available);
            if (data.available > 0) {
                $('#errorcode').removeClass('error');
                $('#errorcode').removeClass('error_show');
                $('#errorcode').removeClass('success');
                $('#errorcode').text('El numero de expediente ya esta registrado').addClass('error').animate({}, 300);
                $('input[name ="code"]')[0].setCustomValidity('El numero de expediente ya esta registrado');
            } else {
                $('#errorcode').removeClass('error');
                $('#errorcode').removeClass('error_show');
                $('#errorcode').removeClass('success_show');
                $('#errorcode').text('Numero de expadiente valido.').addClass('success').animate({},
                    300);
                $('input[name ="code"]')[0].setCustomValidity('');
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log('error: ' + errorThrown);
        }
    });

};

function delete_patient(patient_id)
{
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
var url = '<?php echo base_url().$this->session->userdata('login_type').'/';?>';
function load_view(a, b, c = "") {
    $.post(url + "includes/" + a, c, function(data) {
        $('#' + b).hide();
        $('#' + b).html(data);
        $('#' + b).fadeIn(500);
    }, "html");
}
</script>


<?php endforeach; ?>