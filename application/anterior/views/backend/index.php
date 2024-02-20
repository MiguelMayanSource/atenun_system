<?php
    $system_name        =   $this->db->get_where('settings' , array('type'=>'system_name'))->row()->description;
    $system_title       =   $this->db->get_where('settings' , array('type'=>'system_title'))->row()->description;
    $account_type       =   $this->session->userdata('login_type');
    $currency = $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->currency;

    $log_type = '';
    if($this->session->userdata('login_type') == 'doctor'){
        $log_type = 'admin';
    }else{
        $log_type = $this->session->userdata('login_type');
    }
?>
<!DOCTYPE html>
<html>

<head>
    <title><?php echo $page_title;?> | <?php echo $system_title;?></title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Mayan Source">
    <meta name="description" content="Medicaby - Soluciones médicas">
    <?php include 'topcss.php';?>
</head>

<body id="day-mode">
    <div class="wrapper">
        <?php $this->crud_model->set_online_status($log_type,$this->session->userdata('login_user_id'));
            if($this->session->userdata('login_type') != 'patient'){
                include $account_type.'/navigation.php';    
            }else{
                echo '<style>
                    @media (max-width: 767px)
                    {
                        .todo-app-w {
                            display: block;
                            margin-top: 32%;
                            padding-bottom: 30%;
                            margin-left: 25px;
                        }
                    }
                </style>';
            }
        ?>
        <main class="contentWrapper side-nav-small container-fluid" <?php if($log_type == 'patient'):?>style=" margin-left: 0px;  padding-left: inherit;" <?php endif;?>>
            <?php include 'top.php';
             include $account_type.'/'.$page_name.'.php';
             include 'footer.php'; ?>
        </main>
    </div>
    <?php 
        include 'modal.php';
        include 'scripts.php';
    ?>
</body>

</html>