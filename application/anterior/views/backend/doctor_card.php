<?php $system_title = $this->db->get_where('settings' , array('type'=>'system_title'))->row()->description; ?>
<?php $system_name = $this->db->get_where('settings' , array('type'=>'system_name'))->row()->description; ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <script src="https://apis.google.com/js/platform.js" async defer></script>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Medicaby">
    <meta name="description" content="Medicaby - El software más completo para el control clínico en la nube">
    <title><?php echo $system_name;?> | <?php echo $system_title;?></title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css">
    <link href="<?php echo base_url();?>public/assets/theme/css/dripicons.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>public/assets/theme/css/style.css?ver=1.1.2">
    <link href="<?php echo base_url();?>public/assets/theme/icon_fonts_assets/batch-icons/style.css" rel="stylesheet">
    <link href="<?php echo base_url();?>public/assets/theme/icon_fonts_assets/picons-thin/style.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&family=Pacifico&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="<?php echo base_url();?>public/assets/theme/img/favicon/favicon.png" type="image/x-icon" />
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">

</head>

<style>
.center-col {
    float: none;
    margin: 0 auto;
}

.carnet {
    border: 2px solid #152e4d;
    text-align: center !important;
    border-radius: 5px;
    background: white;
    width: 300px;
}

.image {
    border-radius: 50%;
    height: 100px;
    width: 100px;
    z-index: 9999;
    position: relative;
    object-fit: cover;
}

.celeste {
    color: white;
    margin-top: 25px;
    z-index: 9999999;
    font-weight: bold;
    width: 70%;
    border-bottom-right-radius: 25px;
    border-top-left-radius: 25px;
    padding: 9px;
    font-size: 15px;
    position: relative;
    background: #0da6df;
}

.azul {
    position: relative;
    background-position: center;
    background-size: cover;
    background-repeat: no-repeat;
}

.cel {
    background: #0da6df;
    height: 4px;
    border-bottom-right-radius: 100px;
}

.cls {
    background: #0da6df;
    height: 107px;
    width: 100px;
    border-radius: 50%;

    margin-top: -90px;
    text-align: center;
}

.spe {
    background: #152e4d;
    color: white;
    margin-top: -15px;
    font-size: 25px;
    padding: 10px;
    border-radius: 18px;
    font-weight: bold;
}

.contacts {
    margin-top: 30px;
    padding-bottom: 50px;
}

.contact-img {
    padding: 10px;
    display: inline-block;
    border: 2px solid #152e4d;
    border-radius: 50%;
}

.imga {
    width: 25px;
    height: 25px;
}

.inside {
    padding: 20px;
}
.cards{
	
    position: absolute;
    left: 50%;
    top: 50%;
    transform: translate(-50%, 20%);
}
</style>

<body>
    <div class="wrapper">
        <main class="container-fluid">
            <div class="login-wrapper row">
                <div class="login-l col-lg-4 col-sm-12 col-md-12 center_div">
				<?php 
				$doctors = $this->db->get_where('admin',array('admin_id'=>$doctor_id))->result_array();
				foreach($doctors as $row):?>
                    <div class="carnet cards">
                        <div class="azul" style="cursor:pointer" onclick="window.location='<?php echo base_url();?>admin/doctor_profile/<?php echo base64_encode($row['admin_id']);?>';">
                            <img src="<?php echo base_url(); ?>public/assets/images/back.png" style="width:100%;height:120px">
                        </div>
                        <center>
                            <div class="cls" style="cursor:pointer" onclick="window.location='<?php echo base_url();?>admin/doctor_profile/<?php echo base64_encode($row['admin_id']);?>';">
                                <img src="<?php echo $this->accounts_model->get_photo('admin', $row['admin_id']);?>" class="image">
                            </div>
                        </center>
                        <div class="inside" style="cursor:pointer" onclick="window.location='<?php echo base_url();?>admin/doctor_profile/<?php echo base64_encode($row['admin_id']);?>';">
                            <center>
                                <div class="celeste">
                                    Dr<?php if($row['gender'] == 'F') echo 'a';?>. <?php echo $this->accounts_model->short_name('admin', $row['admin_id']);?>
                                </div>
                            </center>
                            <div class="spe">
                                <?php echo  $this->crud_model->getSpecialty($row['specialty_1']);  ?>
                            </div>
                        </div>
                        <div class="contacts">
                            <input type="hidden" value="<?php echo base_url().'doctor/doctor_card/'.base64_encode($row['admin_id']);?>" id="myInput">
                            <a class="contact-img" style="cursor:pointer" onclick="myFunction()">
                                <img src="<?php echo base_url(); ?>public/assets/images/share.png" class="imga">
                            </a>
                            <div class="contact-img" style="cursor:pointer" onclick="window.open('https://www.atenun.com.gt', '_blank')">
                                <img src="<?php echo base_url(); ?>public/assets/images/globe.png" class="imga">
                            </div>
                            <div class="contact-img" style="cursor:pointer" onclick="window.open('https://goo.gl/maps/AF1KnugRfvpnJ6SLA', '_blank')">
                                <img src="<?php echo base_url(); ?>public/assets/images/location.png" class="imga">
                            </div>
                            <a class="contact-img" style="cursor:pointer" href="<?php if($this->crud_model->getInfo('phone') != ""):?> tel:<?php echo $this->crud_model->getInfo('phone');?> <?php else: ?># <?php endif; ?>">
                                <img src="<?php echo base_url(); ?>public/assets/images/call.png" class="imga">
                            </a>
                            <a class="contact-img" style="cursor:pointer" href="<?php if($this->crud_model->getInfo('whatsapp') != ""):?> https://wa.me/502<?php echo $this->crud_model->getInfo('whatsapp');?> <?php else: ?># <?php endif; ?>">
                                <img src="<?php echo base_url(); ?>public/assets/images/whatsapp.png" class="imga">
                            </a>
                        </div>
                    </div>
				<?php endforeach;?>
                </div>
            </div>
        </main>
    </div>
    <script src="<?php echo base_url();?>public/assets/theme/js/jquery-3.4.1.min.js"></script>
    <script src="<?php echo base_url();?>public/assets/theme/js/popper.js"></script>
    <script src="<?php echo base_url();?>public/assets/theme/js/moment.min.js"></script>
    <script src="<?php echo base_url();?>public/assets/theme/js/bootstrap.min.js?ver=1"></script>
    <script src="<?php echo base_url();?>public/assets/theme/js/script.js"></script>

</body>

</html>