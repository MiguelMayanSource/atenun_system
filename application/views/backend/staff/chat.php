<!DOCTYPE html>
<html lang="es">

<head>
    <title>Chat - mensajes</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">

    <link rel="shortcut icon" href="<?php echo base_url();?>public/assets/theme/img/favicon/favicon.png" type="image/x-icon" />
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,600,700,800&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,600&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Rubik:300,300i,400,400i,500,500i,700,700i,900,900i&amp;display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>public/assets/chat_assets/css/date-picker.css">
    <link href="<?php echo base_url();?>public/assets/theme/icon_fonts_assets/picons-thin/style.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>public/assets/chat_assets/css/magnific-popup.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>public/assets/chat_assets/css/style.css" media="screen" id="color">
    <script src="<?php echo base_url();?>public/uploads/sweetalert2.all.min.js"></script>
    <div class="chitchat-container">
        <aside class="chitchat-left-sidebar left-disp">
            <div class="recent-default dynemic-sidebar active">
                <div class="recent">
                    <div class="theme-title">
                        <div class="media">
                            <div>
                                <a href="<?php echo base_url();?>staff/panel/" style="font-size:35px"><i class="picons-thin-icon-thin-0132_arrow_back_left"></i></a>
                                <h2>¡Hola <?php echo $this->accounts_model->getirstname('admin', $this->session->userdata('login_user_id'));?>!</h2>
                                <h4>Binvenido a tu Chat.</h4><br>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="chat custom-scroll">
                    <div class="theme-tab tab-sm chat-tabs" style="    padding-top: 50px;">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" data-to="chat-content"><a class="nav-link button-effect active" id="chat-tab" data-toggle="tab" href="#chat" role="tab" aria-controls="chat" aria-selected="true" data-intro="Start chat"><i data-feather="message-square"> </i>Mis Chats</a></li>
                            <li class="nav-item" data-to="contact-content"><a class="nav-link button-effect" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false"> <i data-feather="users"> </i>Mis contactos</a></li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="chat" role="tabpanel" aria-labelledby="chat-tab">
                                <div class="theme-tab">
                                    <!------------- Comienzan Chats ---------------->
                                    <div class="tab-content" id="myTabContent1">
                                        <div class="tab-pane fade show active" id="direct" role="tabpanel" aria-labelledby="direct-tab">
                                            <ul class="chat-main">
                                                <?php 
                            $cont=0;
                            $current_user = 'admin-' . $this->session->userdata('login_user_id');
                            $this->db->order_by('message_id','desc');
                            $this->db->group_by('token');
                            $this->db->where('(sender = "'.$current_user.'" OR reciever = "'.$current_user.'")');
                            $this->db->where('original', $current_user);
                            $message_threads = $this->db->get('message')->result_array();
                            foreach ($message_threads as $row):
                            if ($row['sender'] == $current_user)
                            {
                                $user_to_show = explode('-', $row['reciever']);
                            }
                            if ($row['reciever'] == $current_user)
                            {
                                $user_to_show = explode('-', $row['sender']);
                            }
                            $user_to_show_type = $user_to_show[0];
                            $user_to_show_id = $user_to_show[1];
                            $rw = $this->db->select('*')->where('token',$row['token'])->where('original',$current_user)->order_by('message_id',"desc")->limit(1)->get('message')->row();
                            $dbinfo = explode('-',$rw->sender);
                        ?>
                                                <a href="<?php echo base_url();?>staff/messages/<?php echo $this->db->get_where($user_to_show_type, array($user_to_show_type . '_id' => $user_to_show_id))->row()->username;?>" style="text-decoration:none;">
                                                    <li data-to="blank">
                                                        <div class="chat-box">
                                                            <div class="profile  <?php if($this->crud_model->check_online_status($user_to_show_type, $user_to_show_id) > 0):?>online<?php else:?>busy<?php endif;?> bg-size" style="background-image: url(<?php echo $this->accounts_model->get_photo($user_to_show_type, $user_to_show_id);?>); background-size: cover; background-position: center center; display: block;">
                                                            </div>
                                                            <div class="details">
                                                                <h5><?php echo $this->accounts_model->short_name($user_to_show_type, $user_to_show_id);?></h5>
                                                                <h6>
                                                                    <?php
                                        if($current_user == $rw->sender) 
                                        {
                                            if($rw->message == ''){
                                                echo "Enviaste un archivo.";
                                            }else{
                                              if($rw->stiker != 1 )
                                              {
                                                echo "<b>Tú:</b> ". substr($rw->message, 0, 40).'...';    
                                              }else
                                              {
                                                echo "<b>Tú:</b> Sticker...";    

                                              }
                                               
                                            }
                                        }
                                        else {
                                            if($rw->message == '' && $rw->file_name != ''){
                                                echo "Te envió un archivo.";
                                            }else{
                                              if($rw->stiker != 1 )
                                              {
                                                echo "<b>Envío:</b> ". substr($rw->message, 0, 40).'...';    
                                              }else
                                              {
                                                echo "<b>Envío:</b> Sticker...";    

                                              }
                                             
                                            }
                                        }
                                    ?>
                                                                </h6>
                                                            </div>
                                                </a>
                                                <div class="date-status"><i onclick="executeExample('<?php echo $row['token'];?>')" class="ti-trash" title="Eliminar mensaje"></i>
                                                    <h6><?php echo  date("d/m/Y", strtotime($rw->date));?></h6>
                                                    <?php 
                              
                              if($current_user == $rw->sender) 
                              {

                                $cont = $this->chat_model->unread($row['token'],  $rw->original); 
                                if($cont == 0): 
                              ?>
                                                    <h6 class="font-success status"> visto</h6>
                                                    <?php else:?>
                                                    <h6 class="font-info status">enviado</h6>

                                                    <?php endif;
                              }else
                              {
                            
                              $cont = $this->chat_model->unread($row['token'],  $current_user); 
                                if($cont > 0): 
                              ?>
                                                    <div class="badge badge-primary sm"><?php echo $cont ?></div>
                                                    <?php else:?>

                                                    <?php endif;

                                }
                              

                          ?>
                                                </div>
                                        </div>
                                        </li>

                                        <?php endforeach;?>
                                        </ul>
                                    </div>
                                </div>
                                <!------------------ Terminan Chats -------------------------->
                            </div>
                        </div>
                        <!--------------------------- Empiezan contactos -------------------------------->
                        <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                            <div class="chat-search">
                                <div class="element-search">
                                    <input class="form-control" placeholder="Busca por nombre o apellido" id="contact_search" type="text">
                                </div>
                            </div>
                            <ul class="contact-log-main">
                                <?php $contact = $this->crud_model->contacts();
                  foreach ($contact as $c):
                    if( $c['type'] ==  'staff' ||   $c['type'] ==  'patient' && $c['id'] !=  $this->session->userdata('login_user_id')):
                  ?>

                                <li>
                                    <div class="contact-box">
                                        <div class="profile <?php 
                        if($c['type'] == 'doctor')
                          $type = 'admin';
                        else
                          $type = $c['type'];

                        if($this->crud_model->check_online_status($type, $c['id']) > 0):?>online<?php else:?>busy<?php endif;?>  bg-size" style="background-image: url(<?php echo $this->accounts_model->get_photo($type, $c['id']);?>); background-size: cover; background-position: center center; display: block;">
                                            <img class="bg-img" src="<?php echo $this->accounts_model->get_photo($type, $c['id']);?>" style="display: none;">

                                        </div>

                                        <div class="details">
                                            <h5><?php echo $this->accounts_model->short_name($type, $c['id']);?></h5>
                                            <h6><?php echo $c['type'];?></h6>
                                        </div>
                                        <div class="contact-action">
                                            <div class="icon-btn btn-outline-primary btn-sm button-effect" onclick="javascript:location.href='<?php echo base_url();?>staff/messages/<?php echo $c['username']?>'"><i data-feather="message-square"></i></div>
                                            <div class="icon-btn btn-outline-success btn-sm button-effect" onclick="javascript:location.href='tel:+<?php echo $c['phone']?>'"><i data-feather="phone"></i></div>
                                        </div>
                                    </div>
                                </li>

                                <?php endif; endforeach;?>
                            </ul>
                        </div>

                    </div>
                </div>

        </aside>
        <div class="chitchat-main" id="content">
            <div class="chat-content tabto active">
                <div class="messages custom-sc roll active" id="chating" style="height:100vh!important;">
                    <div class="contact-chat">
                        <center><img src="<?php echo base_url();?>public/uploads/chats.png" style="max-width:350px"></center>
                        <center>
                            <h2>Selecciona un chat o un contacto</h2>
                        </center>
                    </div>
                </div>
            </div>

            <div class="contact-content tabto">
                <div class="messages custom-sc roll active" id="chating" style="height:100vh!important;">
                    <div class="contact-chat">
                        <center><img src="<?php echo base_url();?>public/uploads/chats.png" style="max-width:350px"></center>
                        <center>
                            <h2>Selecciona un chat o un contacto</h2>
                        </center>
                    </div>
                </div>
            </div>
        </div>
        <!---------------------- Terminan contactos ------------------------------>
    </div>

    <script type="text/javascript">
    let timerInterval

    function executeExample(chat_id) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "Toma en cuenta que solo se eliminará la copia de tu mensaje.",
            type: 'info',
            showCancelButton: true,
            confirmButtonColor: '#9fd13b',
            cancelButtonColor: '#fd4f57',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.value) {
                Swal.fire({
                    title: 'Eliminando mensaje',
                    titleTextColor: '#000',
                    html: 'Esta ventana se cerrará en <strong></strong>.',
                    timer: 2000,
                    onBeforeOpen: () => {
                        Swal.showLoading()
                        timerInterval = setInterval(() => {
                            Swal.getContent().querySelector('strong').textContent = Swal.getTimerLeft()
                        }, 100)
                    },
                    onClose: () => {
                        clearInterval(timerInterval)
                    }
                })
                location.href = "<?php echo base_url();?>staff/chat/delete/" + chat_id;
            }
        })
    }
    </script>

    <script src="<?php echo base_url();?>public/assets/chat_assets/js/jquery-3.3.1.min.js"></script>
    <script src="<?php echo base_url();?>public/assets/chat_assets/js/owl.carousel.js"></script>
    <script src="<?php echo base_url();?>public/assets/chat_assets/js/popper.min.js"></script>
    <script src="<?php echo base_url();?>public/assets/chat_assets/js/tippy-bundle.iife.min.js"></script>
    <script src="<?php echo base_url();?>public/assets/chat_assets/js/bootstrap.js"></script>
    <script src="<?php echo base_url();?>public/assets/chat_assets/js/switchery.js"></script>
    <script src="<?php echo base_url();?>public/assets/chat_assets/js/easytimer.min.js"> </script>
    <script src="<?php echo base_url();?>public/assets/chat_assets/js/index.js"> </script>
    <script src="<?php echo base_url();?>public/assets/chat_assets/js/feather-icon/feather.min.js"></script>
    <script src="<?php echo base_url();?>public/assets/chat_assets/js/feather-icon/feather-icon.js"></script>
    <script src="<?php echo base_url();?>public/assets/chat_assets/js/ckeditor/ckeditor.js"></script>
    <script src="<?php echo base_url();?>public/assets/chat_assets/js/ckeditor/styles.js"></script>
    <script src="<?php echo base_url();?>public/assets/chat_assets/js/ckeditor/adapters/jquery.js"></script>
    <script src="<?php echo base_url();?>public/assets/chat_assets/js/ckeditor/ckeditor.custom.js"></script>
    <script src="<?php echo base_url();?>public/assets/chat_assets/js/date-picker/datepicker.js"></script>
    <script src="<?php echo base_url();?>public/assets/chat_assets/js/date-picker/datepicker.en.js"></script>
    <script src="<?php echo base_url();?>public/assets/chat_assets/js/date-picker/datepicker.custom.js"></script>
    <script src="<?php echo base_url();?>public/assets/chat_assets/js/jquery.magnific-popup.js"></script>
    <script src="<?php echo base_url();?>public/assets/chat_assets/js/zoom-gallery.js"></script>
    <script src="<?php echo base_url();?>public/assets/chat_assets/js/script.js"></script>
    <script type="text/javascript">
    window.onload = function() {
        $("#filter").keyup(function() {
            var filter = $(this).val(),
                count = 0;
            $('#response a').each(function() {
                if ($(this).text().search(new RegExp(filter, "i")) < 0) {
                    $(this).hide();
                } else {
                    $(this).show();
                    count++;
                }
            });
        });
    }
    $(document).ready(function() {
        var consulta;
        $("#contact_search").keyup(function(e) {
            $('input#contact_search').addClass('loading');
            consulta = $("#contact_search").val();
            $(".contact-log-main").queue(function(n) {
                if ($("#contact").length == 0) {
                    $(".contact-log-main").removeData()
                }
                $.ajax({
                    type: "POST",
                    url: '<?php echo base_url();?>staff/get_contacts',
                    data: "b=" + consulta,
                    dataType: "html",
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(xhr.status);


                        alert("Ups! Algo salio mal.");
                        $("input#contact").removeClass("loading");
                    },
                    success: function(data) {
                        $(".contact-log-main").html(data);
                        n();
                        $("input#contact").removeClass("loading");
                    }
                });
            });
        });
    });
    </script>
    </body>

</html>