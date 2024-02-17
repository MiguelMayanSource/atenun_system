<meta http-equiv="Expires" content="0">
<meta http-equiv="Last-Modified" content="0">
<meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
<meta http-equiv="Pragma" content="no-cache">
<link rel="shortcut icon" href="<?php echo base_url();?>public/assets/theme/img/favicon/favicon.png" type="image/x-icon" />
<link href="https://fonts.googleapis.com/css?family=Quicksand&display=swap" rel="stylesheet">
<?php 
        $theme = strtolower($this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->theme);
        if($theme != ''):
    ?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>public/assets/theme/css/themes/<?php echo str_replace('#','',$theme);?>.css?ver=1.1.1.107">
<?php else:?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>public/assets/theme/css/style.css">
<?php endif;?>
<?php if($page_name != 'messages'):?>
<script src="<?php echo base_url();?>public/assets/theme/js/jquery-3.4.1.min.js"></script>
<?php endif;?>
<?php if($page_name == 'settings' || $page_name == 'clinics'):?>
<script>
var baseURL = '<?php echo base_url();?>';
var stats =
    '<?php echo $this->db->get_where('clinic', array( 'clinic_id' =>  $this->session->userdata('current_clinic')))->row()->down_info; ?>';
var initialColor = '<?php echo $this->crud_model->theme();?>';
</script>
<link rel="stylesheet" href="<?php echo base_url();?>public/assets/back/css/colorPick.css">
<link rel="stylesheet" href="<?php echo base_url();?>public/assets/back/css/tempusdominus-bootstrap-4.min.css">
<?php endif;?>
<link rel="stylesheet" href="<?php echo base_url();?>public/assets/theme/fonts/typography-font/typo.css">
<link rel="stylesheet" href="<?php echo base_url();?>public/assets/theme/css/jquery.dataTables.min.css">
<script src="<?php echo base_url();?>public/assets/theme/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>public/uploads/sweetalert2.all.min.js"></script>

<link href="<?php echo base_url();?>public/assets/theme/css/bootstrap.min.css?ver=1" rel="stylesheet">

<link href="<?php echo base_url();?>public/assets/theme/css/colorpicker.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Mukta&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Montserrat&family=Pacifico&display=swap" rel="stylesheet">
<link rel="stylesheet" href="//stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="<?php echo base_url();?>public/assets/theme/css/dripicons.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>public/assets/theme/css/chat.css?ver=1.1">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>public/assets/theme/css/fullcalendar.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>public/assets/theme/css/perfect-scrollbar.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>public/assets/theme/css/bootstrap-datepicker.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>public/assets/theme/css/bootstrap-select.min.css">
<link href="<?php echo base_url();?>public/assets/theme/icon_fonts_assets/batch-icons/style.css" rel="stylesheet">
<link href="<?php echo base_url();?>public/assets/theme/icon_fonts_assets/picons-thin/style.css" rel="stylesheet">
<link href="<?php echo base_url();?>public/assets/appointments/css/select2.css" rel="stylesheet" />
<link href="<?php echo base_url();?>public/assets/theme/icon_fonts_assets/picons-social/style.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Poppins&display=swap" rel="stylesheet">
<link href="<?php echo base_url();?>public/assets/theme/css/bootstrap-clockpicker.min.css" rel="stylesheet">
<?php if($page_name == 'appointment' || $page_name == 'quote'):?>
<link href="https://fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i" rel="stylesheet">
<link href="<?php echo base_url();?>public/assets/appointments/css/style.css?ver=1.4" rel="stylesheet">
<link href="<?php echo base_url();?>public/assets/appointments/css/responsive.css?ver=1.0.1" rel="stylesheet">
<link href="<?php echo base_url();?>public/assets/appointments/css/icon_fonts/css/all_icons_min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>public/assets/theme/css/vanillaCalendar.css">
<?php endif;?>
<?php if($page_name == 'appointment_details' || $page_name == 'stabilitation_details' || $page_name == 'whatsapp' ):?>
<script src="<?php echo base_url();?>public/assets/back/ckeditor/ckeditor.js"></script>
<?php endif;?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/7.1.96/css/materialdesignicons.min.css" integrity="sha512-NaaXI5f4rdmlThv3ZAVS44U9yNWJaUYWzPhvlg5SC7nMRvQYV9suauRK3gVbxh7qjE33ApTPD+hkOW78VSHyeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link href="<?php echo base_url();?>public/assets/theme/input/jquery.fileuploader.min.css" media="all" rel="stylesheet">
<style>
.option {
    margin-bottom: 0;
    border: 1px solid #dee2e6;
    background: white;

}

.option:hover td {
    background: #dee2e6;
    border: 1px solid white !important;
}
</style>