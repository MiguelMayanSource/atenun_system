<?php 

log_message('error',$permission_request_id);

    $permission_request = $this->db->get_where('permission_request', array('permission_request_id' => $permission_request_id))->row_array();
	
	$admin_id = $permission_request['auth_id'];
	$user_id = $permission_request['user_id'];
	$user = $this->db->get_where($permission_request['user_type'], array($permission_request['user_type'].'_id' => $user_id))->row();
   
?>
<!doctype html>
<html>

<head>
    <style>
    @page {
        background-image: url("<?php echo 'public/uploads/referencia.png'?>");
        background-image-resize: 6;
        background-size: contain;
        margin-top: 90px;
        margin-bottom: 90px;
    }

    .page_break {
        page-break-before: always;
    }
    </style>
</head>

<body>
    <!------ Inicio datos del paciente ------>
    <div style="position:absolute;top:280px;left:100px;">
        <b><span><?php echo $this->accounts_model->get_full_name($permission_request['user_type'],$permission_request['user_id']);?></span></b>
    </div>
    <div style="position:absolute;top:280px;left:720px;width:50px">
        <b><span>0<?php echo $permission_request_id;?></span></b>
    </div>
    <div style="position:absolute;top:320px;left:90px;">
        <b><span><?php echo date('Y-m-d');?></span></b>
    </div>
    <div style="position:absolute;top:320px;left:300px;">
        <b><span><?php echo $user->phone;;?></span></b>
    </div>
    <div style="position:absolute;top:320px;left:550px;">
        <b><span><?php echo $user->code;;?></span></b>
    </div>
    <?php if($user->gender == 'M' ): ?>
    <div style="position:absolute;top:320px;left:705px;">
        <b><span style="font-size:28px">x</span></b>
    </div>
    <?php else: ?>
    <div style="position:absolute;top:320px;left:678px;">
        <b><span>X</b>
    </div>
    <?php endif; ?>
    <div style="position:absolute;top:330px;left:730px;">
        <b><span>
                <?php $originalDate = $user->date_of_birth; $newDate = date("d-m-Y", strtotime($originalDate)); ?>
                <?php echo $this->accounts_model->get_age($originalDate);?>
            </span></b>
    </div>
    <!------ Final datos del paciente ------>
    <!------ Inicio datos de la orden ------>

    <div style="position:absolute;top:460px;right:100px;">
        <b><span>
            <?php    setlocale(LC_ALL,"es_ES.UTF-8"); echo strftime("%A, %d de %B del %Y",strtotime($permission_request['date']));
            ?>
            </span>
    </b>
    </div>
    <div style="position:absolute;top:510px; text-align:justify; width:87%">
        <b><span><?php echo $permission_request['details'];?></span></b>
    </div>
    <!------ Final datos de la orden ------->
    <!------ Inicio datos de la firma ------>


    <!------ Final datos de la firma ------->
</body>

</html>