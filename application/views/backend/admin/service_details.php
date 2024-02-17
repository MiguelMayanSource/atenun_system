<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>public/assets/appointments/js/fileupload/file-upload-with-preview.min.css">
<style>
span.error {
    font-size: 12px;
    position: absolute;
    -webkit-border-radius: 3px;
    -moz-border-radius: 3px;
    border-radius: 3px;
    top: -20px;
    right: -15px;
    z-index: 2;
    height: 25px;
    line-height: 1;
    background-color: #e34f4f;
    color: #fff;
    font-weight: normal;
    display: inline-block;
    padding: 6px 8px; 
}

span.error:after {
    content: '';
    position: absolute;
    border-style: solid;
    border-width: 0 6px 6px 0;
    border-color: transparent #e34f4f;
    display: block;
    width: 0;
    z-index: 1;
    bottom: -6px;
    left: 20%;
}

#formValidate .wizard>.content {
    min-height: 25em;
}

#example-vertical.wizard>.content {
    min-height: 24.5em;
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
    width: 29.615861214%;
    height: 150px;
    box-shadow: 0 4px 10px 0 rgb(51 51 51 / 25%);
}


.file_control_custom {
    box-sizing: border-box;
    position: absolute;
    top: 0;
    right: 0;
    left: 0;
    z-index: 5;
    height: auto;
    overflow: hidden;
    line-height: 1.5;
    user-select: none;
    background-clip: padding-box;
    border-radius: 0.25rem;
    height: auto;
    border: 1px solid #f1f2f3;
    color: #3b3f5c;
    font-size: 15px;
    padding: 8px 10px;
    letter-spacing: 1px;
    background-color: #f1f2f3;
    cursor: pointer;
    margin: 30px;
}


.custom-file-container input[type=file] {
    position: absolute;
    top: 0;
    min-width: 100%;
    min-height: auto;
    filter: alpha(opacity=0);
    opacity: 0;
    outline: none;
    background: white;
    cursor: inherit;
    display: block;
    z-index: 1000;
    cursor: pointer;
}

.circle.wizard>.steps .current:not(.done) a .number,
.circle.wizard>.steps .current:not(.done) a:hover .number,
.circle.wizard>.steps .current:not(.done) a:active .number {
    border-color: #0e1726;
    background-color: #0e1726;
    color: #fff;
}

.circle.wizard>.steps .done a .number {
    border-color: #0e1726;
}

.circle.wizard>.steps ul li.done::after,
.circle.wizard>.steps ul li.done::before {
    background-color: #0e1726;
}

.wizard>.actions a {
    background-color: #0e1726;

}

.input[type="radio"] {
    display: none !important;
}

.custom-file-container__custom-file__custom-file-control {
    background: #fff !important;
}

.close1:before {
    content: '✕';
    top: 0px;
    position: absolute;
    right: 3px;
    font-weight: bold;
    color: white;
}

.close1 {
    position: absolute;
    top: -10px;
    right: -10px;
    background: red;
    padding: 10px;
    box-sizing: border-box;
    border-radius: 50%;
    width: 10px;
    height: 10px;
    cursor: pointer;
}

label {
    color: black !important;
}

.back12 {
    background: #f1f2f3;
    margin-top: 27px;
    width: auto;
    -webkit-border-radius: 5px;
    -moz-border-radius: 5px;
    border-radius: 5px;
    padding: 20px 20px 0px 20px
}
</style>
<script src="<?php echo base_url() ?>public/assets/appointments/js/fileupload/file-upload-with-preview.min.js"></script>
<div id="main-content">
    <link href="<?php echo base_url();?>public/super/plugins/file-upload/file-upload-with-preview.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
     <div class="col-xl-12  col-lg-12 col-sm-12  layout-spacing card-widget">
        <div class="widget-content widget-content-area br-6">
            <div class="widget-heading">
                <h4> <a href="#" onclick="history.back()">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left-circle" data-darkreader-inline-stroke="" style="--darkreader-inline-stroke:currentColor;">
                            <circle cx="12" cy="12" r="10"></circle>
                            <polyline points="12 8 8 12 12 16"></polyline>
                            <line x1="16" y1="12" x2="8" y2="12"></line>
                        </svg>
                    </a><?php echo 'Ingreso de resultados para  <b>'.$this->db->get_where('patient_service',array('patient_service_id'=>base64_decode($ID)))->row()->code;;  ?></b></h4>
            </div>
        </div>
    </div>
    <div class="col-xl-12  col-lg-12 col-sm-12  layout-spacing card-widget">
        <div class="widget-content widget-content-area br-6">
            <div class="row">
                <?php 
                    $images = $this->db->get_where('patient_service_file',array('patient_service_id'=>base64_decode($ID)))->result_array(); 
                    foreach($images as $img):
                ?>
                <div class="col-lg-4 col-sm-4">
                    <a target="_blank" href="<?php echo base_url(); ?>public/uploads/patient_files/<?php echo $img['file']?>" /> <img src="<?php echo base_url(); ?>public/uploads/patient_files/<?php echo $img['file']?>" alt="<?php echo $img['name']?>"  style="width:250px;height:150px;"/></a>
                 </div> 
                <?php endforeach;?>
                
                 <div class="col-lg-12 col-sm-12 mt-4">
                    <a class="btn btn-primary" target="_blank" href="<?php echo base_url(); ?>public/uploads/patient_files/<?php echo $this->db->get_where('patient_service',array('patient_service_id'=>base64_decode($ID)))->row()->report;?>" style="width:250px;"/>Ver informe</a>
                 </div> 
               
            </div>
        </div>
    </div>
    <div class="col-xl-12  col-lg-12 col-sm-12  layout-spacing card-widget">
        <div class="widget-content widget-content-area br-6">
            <div class="">
                <form action="<?php echo base_url();?>admin/service_details/save" method='POST' enctype="multipart/form-data">
                    <input type="hidden" name="patient_service_id" value="<?php echo base64_decode($ID); ?>" />
                    <div class="widget-heading">
                        <h4> </h4>
                    </div>
                    <div class='col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mt-4 '>
                        <h4>Subir imagenes</h4>
                        <div class="default-according style-1  faq-accordion job-accordion  col-xl-12">
                            <div class="custom-file-container" data-upload-id="myFirstImage">
                                <label><a href="javascript:void(0)" class="custom-file-container__image-clear" title="Clear Image">x</a></label>
                                <label class="custom-file-container__custom-file">
                                    <input type="file" class="custom-file-container__custom-file__custom-file-input" accept="*" id="attachments" name="attachments[]" multiple="multiple">
                                    <input type="hidden" name="MAX_FILE_SIZE" value="10485760" />
                                    <span class="custom-file-container__custom-file__custom-file-control"></span>
                                </label>
                                <div class="custom-file-container__image-preview"></div>
                            </div>
                        </div>
                    </div>
                    <div class='col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12  mb-4 '>
                        <label class="custom-file-container__custom-file" for="inform">
                             <input type="file" accept="*" id="inform" multiple="multiple" name="inform"   >
                            <input type="hidden" name="MAX_FILE_SIZE" value="10485760">
                            <span class="custom-file-container__custom-file__custom-file-control informe">Subir informe archivos...<span class="custom-file-container__custom-file__custom-file-control__button"> Buscar </span></span>
                        </label>
                    </div>
                    <div class='col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mt-4 '>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary ">Guardar</button>
                        </div>
                    </div>
                    <br>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(function(){
        
            //First upload
    var firstUpload = new FileUploadWithPreview('myFirstImage', {
        text: {
            browse: 'Buscar',
            chooseFile: 'Seleccionar archivos...'
        },
        multiple: true,
    })

    $(window).on('fileUploadWithPreview:imagesAdded', function(e) {

        // Get a reference to our file input
        const fileInput = document.querySelector('input[type="file"]');

        //Create a new DataTransfer object
        const dataTransfer = new DataTransfer

        //Add new files from the event's DataTransfer
        for (let i = 0; i < e.detail.cachedFileArray.length; i++)
            dataTransfer.items.add(e.detail.cachedFileArray[i])


        fileInput.files = dataTransfer.files
    });
    });
    
      document.getElementById('inform').onchange = function() {
        var filename = this.value.replace(/C:\\fakepath\\/i, '')
        $(".informe").html(filename+' <span class="custom-file-container__custom-file__custom-file-control__button"> Buscar </span> ');
    };
</script>