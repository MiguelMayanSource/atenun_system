
<!DOCTYPE html>
<html>
<head>
    <title>Oops! | Error 404</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body style="background-color:#fff;">
    <style>
        .img_container{
            margin-top:15%;
            float:center;
        }
        .btn-return{
            background-color:#0061da;
            color:#fff!important;
            border-radius:10px;
            padding:10px 15px 10px 15px;
            margin-top:10px;
            -webkit-box-shadow: 0px 2px 14px rgba(0, 68, 233, 0.40);
            box-shadow: 0px 2px 14px rgba(0, 68, 233, 0.40);
        }
    </style>
    <div class="container">
        <div class="img_container">
            <h1 style="color:#43485c; text-align:Center;font-size:65px;font-weight:bold;">Error 404</h1>
            <p style="color:#43485c; font-size:16px;">Parece que la página a la cual estás intentando acceder no existe o se ha actualizado, intenta refrescar el navegador y si el problema continúa contacta a soporte proporcionando la siguiente dirección: <b><?php echo base_url();?></b>
            <br><a class="btn btn-return" href="<?php echo base_url();?>doctor/panel/">Regresar a tu tablero</a></p>
            <center><img src="<?php echo base_url();?>uploads/404_image.png" style="max-width:80%;"></center></div>
    </div>
</body>
</html>