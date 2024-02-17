<style>
.file-content .folder-box {
    box-sizing: border-box;
    /* Considera padding y border dentro del tamaño total */
    border: 1px solid #ecf3fa;
    border-radius: 5px;
    padding: 15px;
    background-color: rgba(44, 95, 45, 0.05);
    width: calc(25% - 15px);
    height: auto;
    /* Se adapta al tamaño del contenido */
    display: inline-block;
    margin-bottom: 2px;
    margin-left: 3px;
}

.file-content .file-box {
    border: 1px solid #ecf3fa;
    border-radius: 5px;
    padding: 15px;
    background-color: rgba(44, 95, 45, 0.05);
    width: calc(25% - 15px);
    display: inline-block;
    position: relative;
    margin-bottom: 2px;
    height: auto;
    margin-left: 3px;
}

.folder-top {
    border-radius: 5px;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -ms-flex-align: center;
    align-items: center;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: end;

}


.file-content .file-box .file-top {
    height: 100px;
    background-color: #fff;
    border: 1px solid #ececec;
    border-radius: 5px;
    font-size: 36px;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;

}

.file-content .ellips {
    position: absolute;
    top: 30px;
    right: 30px;
    opacity: 0.7;
}

.txt-secondary {
    color: #90b757 !important;
}

.file-manager .files .file-box:nth-child(2) {
    -webkit-animation-fill-mode: both;
    animation-fill-mode: both;
    -webkit-animation: fadeIncustom 0.5s linear 20ms;
    animation: fadeIncustom 0.5s linear 20ms;
}

.txt-warning {
    color: #ff8819 !important;
}

.f-36 {
    font-size: 36px !important;
}

.fa {
    display: inline-block;
    font: normal normal normal 14px/1 FontAwesome;
    font-size: inherit;
    text-rendering: auto;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
}

.media .media-body {
    -webkit-box-flex: 1;
    -ms-flex: 1;
    flex: 1;
}

.media .media-body {
    -webkit-box-flex: 1;
    -ms-flex: 1;
    flex: 1;
}

.ms-3 {
    margin-left: 1rem !important;
}

@media screen and (max-width: 420px) {

    .file-content .folder-box,
    .file-content .file-box {
        width: calc(100%);
        margin-right: unset;
        margin-bottom: 2px;
        margin-left: 3px;
    }
}

#imageOverlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    display: none;
    z-index: 9999;
    /* Para asegurarse de que está encima de todos los elementos */
}

#imageContainer {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    text-align: center;
    /* Centrar la imagen horizontalmente */
}

#imageContainer img {
    max-width: 100%;
    /* Ancho máximo igual al del contenedor */
    height: auto;
    /* Altura se ajusta automáticamente para mantener la proporción */
    object-fit: contain;
    /* Asegura que la imagen no se salga de los bordes del contenedor */
    cursor: pointer;
    /* Cambiar el cursor cuando se hace clic en la imagen */
}

.imageButton {
    cursor: pointer;
    border: none;
    outline: none;
    background-color: transparent;
    color: #fff;
    font-size: 24px;
    margin: 10px 0px;
}
</style>

<h5 class="panel-content-title">Archivos del paciente <div style="    
        top: 100px;
    left: 952px;
    opacity: 1;
    font-size: 36px;
    float:right;
   ">
        <div class="pi-settings os-dropdown-trigger" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-ellipsis-v f-14 ellips"></i>
        </div>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" x-placement="bottom-start" style="width:100px;position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 15px, 0px);">
            <a class="dropdown-item" style="cursor:pointer" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_new_folder/<?php echo $patient_id; ?>/<?php echo $parent_id; ?>');">Nueva carpeta</a>
            <a class="dropdown-item" style="cursor:pointer" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_upload_files/<?php echo $patient_id; ?>/<?php echo $parent_id; ?>');">Subir archivo</a>
        </div>
    </div>
</h5>

<span class="app-divider2"></span>
<h5 class="mt-4"><?php echo $this->db->get_where('patient_file',array('patient_file_id'=>$parent_id))->row()->name;?></h5>
<div class="file-content">
    <?php 
        $refresh_query  = $this->db->order_by('patient_file_id','desc')->get_where('patient_file',array('patient_id' => $patient_id,'parent_id'=>$parent_id,'status'=>1));
        if($refresh_query->num_rows() > 0):
        $cont= 1;
    ?>
    <ul class="folder" style="display: flex;align-items: start;">
        <?php if($parent_id != 0):?>
        <li class="folder-box">
            <div class="folder-top" style="height: 16px;">

            </div>
            <div class="media" style="cursor:pointer" onclick="load_view('patient_files', 'files', {'patient_id': <?php echo $patient_id;?>,'parent_id':  <?php echo $this->db->get_where('patient_file',array('patient_file_id'=>$parent_id))->row()->parent_id;?>});">
                <i class="fa fa-folder f-36 txt-warning"></i>
                <div class="media-body ms-3">
                    <h6 class="mb-0">......</h6>
                </div>
            </div>
        </li>
        <?php endif;?>
        <?php 
            foreach($refresh_query->result_array() as $row): ?>
        <li class="<?php echo $row['type'] == 0 ? 'folder-box' : 'file-box'; ?>">
            <div class="<?php echo $row['type'] == 0 ? 'folder-top' : 'file-top'; ?>">
                <?php if($row['type'] == 0): ?>
                <i class="fa fa-ellipsis-v f-14 os-dropdown-trigger" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></i>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" x-placement="bottom-start" style="width:100px;position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 15px, 0px);">
                    <a class="dropdown-item" href="javascript:void(0)" onclick="showAjaxModal('<?php echo base_url();?>modal/popup/modal_edit_folder/<?php echo base64_encode($row['patient_file_id']); ?>');">Cambiar nombre</a>
                    <a class="dropdown-item" href="javascript:void(0)" onclick="delete_function('patient_files/delete_files/<?php echo base64_encode($row['patient_file_id']); ?>','files',{'patient_id':<?php echo $patient_id; ?>, 'parent_id': <?php echo $parent_id;?>},'patient_files')">Eliminar</a>
                </div>
                <?php else: ?>
                <i class="<?php echo $this->crud_model->get_extension($row['format'])?> txt-primary"></i>
                <i class="fa fa-ellipsis-v f-14 ellips os-dropdown-trigger" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></i>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" x-placement="bottom-start" style="width:100px;position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 15px, 0px);">
                    <?php if($row['format'] == "png" || $row['format'] == "jpg" ||$row['format'] == "jpeg" ||$row['format'] == "gif"):?>
                    <a class="dropdown-item" href="#" onclick="showImage('<?php echo $row['name']?>')">Ver</a>
                    <?php else:?>
                    <a class="dropdown-item" href="<?php echo base_url() ?>public/uploads/patient_files/<?php echo $row['name']?>">Ver</a>
                    <?php endif;?>
                    <a class="dropdown-item" href="javascript:void(0)" onclick="window.location.href='<?php echo base_url().$this->session->userdata('login_type');?>/patient_files/download/<?php echo $row['patient_file_id'];?>'">Descargar</a>
                    <a class="dropdown-item" href="javascript:void(0)" onclick="delete_function('patient_files/delete_files/<?php echo base64_encode($row['patient_file_id']); ?>','files',{'patient_id':<?php echo $patient_id; ?>, 'parent_id': <?php echo $parent_id;?>},'patient_files')">Eliminar</a>
                </div>
                <?php endif; ?>
            </div>
            <?php if($row['type'] == 0): ?>
            <div class="media" style="cursor:pointer" onclick="load_view('patient_files', 'files', {'patient_id': <?php echo $patient_id;?>,'parent_id':  <?php echo $row['patient_file_id'];?>});">
                <i class="fa fa-folder f-36 txt-warning"></i>
                <div class="media-body ms-3">
                    <h6 class="mb-0"><?php echo $row['name']; ?></h6>
                </div>
            </div>
            <?php else: ?>
            <div class="file-bottom">
                <h6><?php echo $row['old_name']; ?> </h6>
                <p class="mb-1"><?php echo $this->crud_model->file_size($row['size']); ?></p>
            </div>
            <?php endif; ?>
        </li>

        <?php endforeach; ?>
    </ul>
    <?php else: ?>
    <div class="col-sm-12"><br>
        <?php if($parent_id != 0):?>
        <li class="folder-box">
            <div class="folder-top" style="height: 16px;">

            </div>
            <div class="media" style="cursor:pointer" onclick="load_view('patient_files', 'files', {'patient_id': <?php echo $patient_id;?>,'parent_id':  <?php echo $this->db->get_where('patient_file',array('patient_file_id'=>$parent_id))->row()->parent_id;?>});">
                <i class="fa fa-folder f-36 txt-warning"></i>
                <div class="media-body ms-3">
                    <h6 class="mb-0">......</h6>
                </div>
            </div>
        </li>
        <?php endif;?>
        <center>
            <h5 class="poppins">Aún no archivos registrados</h5><br><img src="<?php echo base_url() ?>public/uploads/medicamentos.svg" style="max-width:20%;">
        </center>
    </div>
    <?php endif; ?>
</div>
<!-- HTML del overlay o backdrop -->
<div id="imageOverlay">
    <div id="imageContainer">
        <img src="path-to-image.jpg">
        <button class="imageButton" id="increaseBtn">+</button>
        <button class="imageButton" id="decreaseBtn">-</button>
        <button class="imageButton" id="closeBtn">&#10005;</button>
    </div>
</div>
<script>
function showImage(name) {
    // Se muestra el overlay oscuro
    $('#imageOverlay').fadeIn('500');

    var image = document.querySelector('#imageContainer img');
    image.src = '<?php echo base_url(); ?>public/uploads/patient_files/' + name;
    increaseBtn.addEventListener('click', function() {
        var currentWidth = image.offsetWidth;
        var newWidth = currentWidth + 50; // Incrementar el ancho actual en 50px

        image.style.width = newWidth + 'px';
    });

    decreaseBtn.addEventListener('click', function() {
        var currentWidth = image.offsetWidth;
        var newWidth = currentWidth - 50; // Decrementar el ancho actual en 50px

        if (newWidth < 100) { // Asegurar que la imagen no se haga demasiado pequeña
            newWidth = 100;
        }

        image.style.width = newWidth + 'px';
    });

    closeBtn.addEventListener('click', function() {
        document.querySelector('#imageOverlay').style.display = 'none';
    });

};
</script>