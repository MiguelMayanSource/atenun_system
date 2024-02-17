<?php 
     if($username != ""){
        $info = $this->chat_model->getInfo($username);
        $user_type = $info['type'];
        $user_id = $info['user_id'];
    } 
    $current_message_thread_code = '';
    
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <title>Chat - <?php echo $username?></title>
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
    <link href="<?php echo base_url();?>public/assets/input/script.css" media="all" rel="stylesheet">
    <link href="<?php echo base_url();?>public/assets/input/jquery.fileuploader-theme-dragdrop.css" rel="stylesheet">
    <script src="<?php echo base_url();?>public/uploads/sweetalert2.all.min.js"></script>


    <div class="chitchat-container">

        <aside class="chitchat-left-sidebar left-disp" style=" <?php if($this->crud_model->checkMobile()) echo 'display:none'; ?>">
            <div class="recent-default dynemic-sidebar active">
                <div class="recent">
                    <div class="theme-title">
                        <div class="media">
                            <div>
                                <a href="<?php echo base_url();?>doctor/chat/" style="font-size:35px"><i class="picons-thin-icon-thin-0132_arrow_back_left"></i></a>
                                <h2>¡Hola <?php echo $this->accounts_model->getirstname('admin', $this->session->userdata('login_user_id'));?>!</h2>
                                <h4>Binvenido a tu Chat.</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="chat custom-scroll">
                    <div class="theme-tab tab-sm chat-tabs" style="padding-top: 50px;">
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
                            $cont=1;
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
                                  $usrname = $this->db->get_where($user_to_show[0], array($user_to_show[0].'_id' => $user_to_show[1]))->row()->username;
                              }
                              if ($row['reciever'] == $current_user)
                              {
                                  $user_to_show = explode('-', $row['sender']);
                                  $usrname = $this->db->get_where($user_to_show[0], array($user_to_show[0].'_id' => $user_to_show[1]))->row()->username;
                              }
                              $user_to_show_type = $user_to_show[0];
                              $user_to_show_id = $user_to_show[1];
                                    
                              $rw = $this->db->select('*')->where('token',$row['token'])->where('original',$current_user)->order_by('message_id',"desc")->limit(1)->get('message')->row();
                              $dbinfo = explode('-',$rw->sender);

                            if ($username == $usrname) $current_message_thread_code = $row['token']; 
                        ?>
                                                <a href="<?php echo base_url();?>doctor/messages/<?php echo $this->db->get_where($user_to_show_type, array($user_to_show_type . '_id' => $user_to_show_id))->row()->username;?>" style="text-decoration:none;">
                                                    <li data-to="blank" <?php if ($username == $usrname) echo 'class="active"'; ?>>
                                                        <div class="chat-box">
                                                            <div class="profile <?php if($this->crud_model->check_online_status($user_to_show_type, $user_to_show_id) > 0):?>online<?php else:?>busy<?php endif;?> bg-size" style="background-image: url(<?php echo $this->accounts_model->get_photo($user_to_show_type, $user_to_show_id);?>); background-size: cover; background-position: center center; display: block;">
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
                                                echo  "<b>Envío:</b> ".substr($rw->message, 0, 40).'...';    
                                              }else
                                              {
                                                echo "Envío Sticker...";    

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
                                  $token="";                                
                              if ($username != $usrname){
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
                                      }else
                                      {

                                        $token = $rw->token;
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
                  if($c['id'] != $this->session->userdata('login_user_id')):
                  
                  ?>

                                <li>
                                    <div class="contact-box">
                                        <div class="profile  
                      <?php 
                        if($c['type'] == 'doctor')
                          $type = 'admin';
                        else
                          $type = $c['type'];

                        if($this->crud_model->check_online_status($type, $c['id']) > 0):?>online<?php else:?>busy<?php endif;?> bg-size" style="background-image: url(<?php echo $this->accounts_model->get_photo($type, $c['id']);?>); background-size: cover; background-position: center center; display: block;">
                                        </div>

                                        <div class="details">
                                            <h5><?php echo $this->accounts_model->short_name($type, $c['id']);?></h5>
                                            <h6><?php echo $c['phone'];?></h6>
                                        </div>
                                        <div class="contact-action">
                                            <div class="icon-btn btn-outline-primary btn-sm button-effect" onclick="javascript:location.href='<?php echo base_url();?>doctor/messages/<?php echo $c['username']?>'"><i data-feather="message-square"></i></div>
                                            <div class="icon-btn btn-outline-success btn-sm button-effect" onclick="javascript:location.href='tel:+<?php echo $c['phone']?>'"><i data-feather="phone"></i></div>
                                        </div>
                                    </div>
                                </li>

                                <?php endif; endforeach;?>

                            </ul>
                        </div>
                        <!---------------------- Terminan contactos ------------------------------>
                    </div>
                </div>
            </div>
    </div>
    </aside>

    <div class="chitchat-main" id="content">
        <div class="chat-content tabto active">
            <div class="messages custom-scroll active" id="chating">
                <div class="contact-details">
                    <div class="row">
                        <div class="col-7">
                            <div class="media left">
                                <div class="media-left mr-3">
                                    <div class="menu-trigger profile <?php if($this->crud_model->check_online_status($user_type, $user_id) > 0):?>online<?php else:?>busy<?php endif;?> bg-size" style="background-image: url(<?php echo $this->accounts_model->get_photo($user_type, $user_id);?>); background-size: cover; background-position: center center; display: block;">
                                    </div>

                                </div>
                                <div class="media-body">
                                    <h5><?php echo $this->accounts_model->get_name($user_type, $user_id);?></h5>
                                    <?php if($this->crud_model->check_online_status($user_type, $user_id) > 0):?>
                                    <div class="badge badge-success">En línea</div>
                                    <?php else:?>
                                    <div class="badge badge-danger">Inactivo</div>
                                    <?php endif;?>
                                </div>
                                <div class="media-right">
                                    <ul>
                                        <li><a class="icon-btn btn-light button-effect menu-trigger" href="javascript:void(0);"><i class="fa fa-bars"></i></a></li>
                                        <li><a class="icon-btn btn-light button-effect mobile-sidebar" href="javascript:void(0);"><i data-feather="chevron-left"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <ul class="calls text-right">
                                <li><a class="icon-btn btn-light button-effect" onclick="javascript:location.href='tel:+<?php echo $this->db->get_where($user_type,array('username'=>$username))->row()->phone;?>'" data-tippy-content="Llamada" data-toggle="modal" data-target="#audiocall"><i data-feather="phone"></i></a></li>
                                <li class="chat-friend-toggle"><a class="icon-btn btn-light bg-transparent button-effect outside" href="#" data-tippy-content="Acciones del chat"><i data-feather="more-vertical"></i></a>
                                    <div class="chat-frind-content">
                                        <ul>
                                            <li>
                                                <a class="icon-btn btn-outline-primary button-effect btn-sm" href="#" onclick="javascript:location.href='<?php echo base_url();?>/doctor/<?php echo $user_type == 'admin'? 'doctor':$user_type;?>_profile/<?php echo base64_encode($user_id);?>'"><i data-feather="user"></i></a>
                                                <h5 style="cursor:pointer" onclick="javascript:location.href='<?php echo base_url();?>/doctor/<?php echo $user_type == 'admin'? 'doctor':$user_type;?>_profile/<?php echo base64_encode($user_id);?>'">Perfil</h5>

                                            </li>
                                            <li>
                                                <a class="icon-btn btn-outline-danger button-effect btn-sm" href="#" onclick="executeExample('<?php echo $token;?>')"><i data-feather="trash-2"></i></a>
                                                <h5 onclick="executeExample('<?php echo $token;?>')" style="cursor:pointer">Eliminar</h5>
                                            </li>

                                        </ul>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!--------------------------- Contenido del chat ----------------------------->
                <div class="contact-chat" id="contact-chat">
                    <ul class="chatappend">
                        <?php
                    
                    $recievers = "";
                    $this->db->order_by('message_id', 'asc');
                    $messages = $this->db->get_where('message', array('token' => $current_message_thread_code,'original' => $current_user))->result_array();
                    foreach ($messages as $row):
                    $sender = explode('-', $row['sender']);
                    $sender_account_type = $sender[0];
                    $sender_id = $sender[1];
                    
                    $this->chat_model->read_chat($row['token'], $current_user);
                    
                ?>
                        <?php if($row['sender'] != $current_user):?>
                        <?php $recievers = $row['sender'];?>
                        <?php if($row['file_name'] == ''):?>
                        <?php if($row['stiker'] == ''):?>
                        <li class="sent">
                            <div class="media">
                                <div class="profile mr-4 bg-size" style="background-image: url(<?php echo $this->accounts_model->get_photo($sender_account_type, $sender_id);?>); background-size: cover; background-position: center center; display: block;">
                                    <img class="bg-img" src="<?php echo $this->accounts_model->get_photo($sender_account_type, $sender_id);?>" style="display: none;" />
                                </div>
                                <div class="media-body">
                                    <div class="contact-name">
                                        <h5><?php echo $this->accounts_model->get_name($sender_account_type, $sender_id);?></h5>
                                        <h6><?php echo $row['timestamp'];?></h6>
                                        <ul class="msg-box">
                                            <li class="msg-setting-main">
                                                <h5><?php echo $this->chat_model->check_text($row['message']); ?></h5>
                                                <div class="msg-dropdown-main">
                                                    <div class="msg-setting"><i class="ti-more-alt"></i></div>
                                                    <div class="msg-dropdown">
                                                        <ul>
                                                            <li><a href="#" onclick="deleteChat(<?php echo $row['message_id'];?>)"><i class="ti-trash"></i>eliminar</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <?php endif; ?>
                        <?php if($row['stiker'] == '1'):?>
                        <li class="sent">
                            <div class="media">
                                <div class="profile mr-4 bg-size" style="background-image: url(<?php echo $this->accounts_model->get_photo($sender_account_type, $sender_id);?>); background-size: cover; background-position: center center; display: block;">
                                    <img class="bg-img" src="<?php echo $this->accounts_model->get_photo($sender_account_type, $sender_id);?>" style="display: none;" />
                                </div>
                                <div class="media-body">
                                    <div class="contact-name">
                                        <h5><?php echo $this->accounts_model->get_name($sender_account_type, $sender_id);?></h5>
                                        <h6><?php echo $row['timestamp'];?></h6>
                                        <ul class="msg-box">
                                            <li class="msg-setting-main">
                                                <h5><?php echo $row['message']; ?></h5>
                                                <div class="msg-dropdown-main">
                                                    <div class="msg-setting"><i class="ti-more-alt"></i></div>
                                                    <div class="msg-dropdown">
                                                        <ul>
                                                            <li><a href="#" onclick="deleteChat(<?php echo $row['message_id'];?>)"><i class="ti-trash"></i>eliminar</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </li>

                        <?php endif; ?>
                        <?php else:?>
                        <li class="sent">
                            <div class="media">
                                <div class="profile mr-4 bg-size" style="background-image: url(<?php echo $this->accounts_model->get_photo($sender_account_type, $sender_id);?>); background-size: cover; background-position: center center; display: block;">
                                    <img class="bg-img" src="<?php echo $this->accounts_model->get_photo($sender_account_type, $sender_id);?>" style="display: none;" />
                                </div>
                                <div class="media-body">
                                    <div class="contact-name">
                                        <h5><?php echo $this->accounts_model->get_name($sender_account_type, $sender_id);?></h5>
                                        <h6><?php echo $row['timestamp'];?></h6>
                                        <ul class="msg-box">
                                            <?php if($row['message'] != ''):?>
                                            <li class="msg-setting-main">
                                                <h5><?php echo $this->chat_model->check_text($row['message']); ?></h5>
                                                <div class="msg-dropdown-main">
                                                    <div class="msg-setting"><i class="ti-more-alt"></i></div>
                                                    <div class="msg-dropdown">
                                                        <ul>
                                                            <li><a href="#" onclick="deleteChat(<?php echo $row['message_id'];?>)"><i class="ti-trash"></i>eliminar</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </li>
                                            <?php endif;?>
                                            <?php if($row['file_name'] != ""):?>
                                            <?php if($row['file_type'] != "png" && $row['file_type'] != "jpg" && $row['file_type'] != "JPEG" && $row['file_type'] != "jpeg" && $row['file_type'] != "gif"):?>
                                            <li class="msg-setting-main">
                                                <div class="document"><i class="fa fa-files-o font-primary"></i>
                                                    <div class="details">
                                                        <h5><?php echo $row['original_file_name'];?></h5>
                                                        <h6><?php echo $row['file_size'];?></h6>
                                                    </div>
                                                    <div class="icon-btns"><a class="icon-btn btn-outline-light" href="<?php echo base_url();?>doctor/force_download_messages/<?php echo $row['file_name'];?>" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-download">
                                                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                                                <polyline points="7 10 12 15 17 10"></polyline>
                                                                <line x1="12" y1="15" x2="12" y2="3"></line>
                                                            </svg></a></div>
                                                </div>
                                                <?php if($row['message'] == ''):?>
                                                <div class="msg-dropdown-main">
                                                    <div class="msg-setting"><i class="ti-more-alt"></i></div>
                                                    <div class="msg-dropdown">
                                                        <ul>
                                                            <li><a href="#" onclick="deleteChat(<?php echo $row['message_id'];?>)"><i class="ti-trash"></i>eliminar</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <?php endif;?>
                                            </li>
                                            <?php else:?>
                                            <li class="msg-setting-main">
                                                <ul class="auto-gallery share-media zoom-img">
                                                    <a href="<?php echo base_url().'public/uploads/messages_files/'.$row['file_name'];?>">
                                                        <li class="bg-size" style="background-image: url(<?php echo base_url().'public/uploads/messages_files/'.$row['file_name'];?>); background-size: cover; background-position: center center; display: block;">
                                                            <img class="bg-img" src="<?php echo base_url().'public/uploads/messages_files/'.$row['file_name'];?>" style="display: none;">
                                                        </li>
                                                    </a>

                                                </ul>
                                                <?php if($row['message'] == ''):?>
                                                <div class="msg-dropdown-main">
                                                    <div class="msg-setting"><i class="ti-more-alt"></i></div>
                                                    <div class="msg-dropdown">
                                                        <ul>
                                                            <li><a href="#"><i class="ti-trash"></i>eliminar</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <?php endif;?>
                                            </li>
                                            <?php endif;?>
                                            <?php endif;?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <?php endif;?>
                        <?php endif;?>
                        <?php if($row['sender'] == $current_user):?>
                        <?php $recievers = $user_type."-".$user_id;?>
                        <?php if($row['file_name'] == ''):?>
                        <?php if($row['stiker'] == 1) :?>
                        <li class="replies">
                            <div class="media">
                                <div class="profile mr-4 bg-size" style="background-image: url(<?php echo $this->accounts_model->get_photo($sender_account_type, $sender_id);?>); background-size: cover; background-position: center center; display: block;">
                                    <img class="bg-img" src="<?php echo $this->accounts_model->get_photo($sender_account_type, $sender_id);?>" style="display: none;" />
                                </div>
                                <div class="media-body">
                                    <div class="contact-name">
                                        <h5><?php echo $this->accounts_model->get_name($sender_account_type, $sender_id);?></h5>
                                        <h6><?php echo $row['timestamp'];?></h6>
                                        <ul class="msg-box">
                                            <li class="msg-setting-main">
                                                <h5><?php echo $row['message']; ?></h5>
                                                <?php if($row['file_name'] == ""):?>
                                                <?php if($row['read_status'] == 1):?>
                                                <div class="badge badge-success sm ml-2"> R</div>
                                                <?php else:?>
                                                <div class="badge badge-dark sm ml-2"> D</div>
                                                <?php endif;?>
                                                <?php endif;?>
                                                <div class="msg-dropdown-main">
                                                    <div class="msg-setting"><i class="ti-more-alt"></i></div>
                                                    <div class="msg-dropdown">
                                                        <ul>
                                                            <li><a href="#" onclick="deleteChat(<?php echo $row['message_id'];?>)"><i class="ti-trash"></i>eliminar</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <?php else: ?>
                        <li class="replies">
                            <div class="media">
                                <div class="profile mr-4 bg-size" style="background-image: url(<?php echo $this->accounts_model->get_photo($sender_account_type, $sender_id);?>); background-size: cover; background-position: center center; display: block;">
                                    <img class="bg-img" src="<?php echo $this->accounts_model->get_photo($sender_account_type, $sender_id);?>" style="display: none;" />
                                </div>
                                <div class="media-body">
                                    <div class="contact-name">
                                        <h5><?php echo $this->accounts_model->get_name($sender_account_type, $sender_id);?></h5>
                                        <h6><?php echo $row['timestamp'];?></h6>
                                        <ul class="msg-box">
                                            <li class="msg-setting-main">
                                                <h5><?php echo $this->chat_model->check_text($row['message']); ?></h5>
                                                <?php if($row['file_name'] == ""):?>
                                                <?php if($row['read_status'] == 1):?>
                                                <div class="badge badge-success sm ml-2"> R</div>
                                                <?php else:?>
                                                <div class="badge badge-dark sm ml-2"> D</div>
                                                <?php endif;?>
                                                <?php endif;?>
                                                <div class="msg-dropdown-main">
                                                    <div class="msg-setting"><i class="ti-more-alt"></i></div>
                                                    <div class="msg-dropdown">
                                                        <ul>
                                                            <li><a href="#" onclick="deleteChat(<?php echo $row['message_id'];?>)"> <i class="ti-trash"></i>eliminar</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <?php endif; ?>

                        <?php else:?>
                        <li class="replies">
                            <div class="media">
                                <div class="profile mr-4 bg-size" style="background-image: url(<?php echo $this->accounts_model->get_photo($sender_account_type, $sender_id);?>); background-size: cover; background-position: center center; display: block;">
                                    <img class="bg-img" src="<?php echo $this->accounts_model->get_photo($sender_account_type, $sender_id);?>" style="display: none;" />
                                </div>
                                <div class="media-body">
                                    <div class="contact-name">
                                        <h5><?php echo $this->accounts_model->get_name($sender_account_type, $sender_id);?></h5>
                                        <h6><?php echo $row['timestamp'];?></h6>
                                        <ul class="msg-box">
                                            <?php if($row['message'] != ''):?>
                                            <li class="msg-setting-main">
                                                <div class="msg-dropdown-main">
                                                    <div class="msg-setting"><i class="ti-more-alt"></i></div>
                                                    <div class="msg-dropdown">
                                                        <ul>
                                                            <li><a href="#" onclick="deleteChat(<?php echo $row['message_id'];?>)"><i class="ti-trash"></i>eliminar</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <h5><?php echo $this->chat_model->check_text($row['message']); ?></h5>
                                                <?php if($row['file_name'] == ""):?>
                                                <?php if($row['read_status'] == 1):?>
                                                <div class="badge badge-success sm ml-2"> R</div>
                                                <?php else:?>
                                                <div class="badge badge-dark sm ml-2"> D</div>
                                                <?php endif;?>
                                                <?php endif;?>
                                            </li>
                                            <?php endif;?>
                                            <?php if($row['file_name'] != ""):?>
                                            <?php if($row['file_type'] != "png" && $row['file_type'] != "jpg" && $row['file_type'] != "JPEG" && $row['file_type'] != "gif" && $row['file_type'] != "jpeg"):?>
                                            <li class="msg-setting-main">
                                                <div class="document"><i class="fa fa-files-o font-primary"></i>
                                                    <div class="details">
                                                        <h5><?php echo $row['original_file_name'];?></h5>
                                                        <h6><?php echo $row['file_size'];?></h6>
                                                    </div>
                                                    <div class="icon-btns"><a class="icon-btn btn-outline-light" href="<?php echo base_url();?>doctor/force_download_messages/<?php echo $row['file_name'];?>" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-download">
                                                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                                                <polyline points="7 10 12 15 17 10"></polyline>
                                                                <line x1="12" y1="15" x2="12" y2="3"></line>
                                                            </svg></a></div>
                                                </div>
                                                <?php if($row['read_status'] == 1):?>
                                                <div class="badge badge-success sm ml-2"> R</div>
                                                <?php else:?>
                                                <div class="badge badge-dark sm ml-2"> D</div>
                                                <?php endif;?>
                                                <?php if($row['message'] == ''):?>
                                                <div class="msg-dropdown-main">
                                                    <div class="msg-setting"><i class="ti-more-alt"></i></div>
                                                    <div class="msg-dropdown">
                                                        <ul>
                                                            <li><a href="#" onclick="deleteChat(<?php echo $row['message_id'];?>)"><i class="ti-trash"></i>eliminar</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <?php endif;?>
                                            </li>
                                            <?php else:?>
                                            <li class="msg-setting-main">
                                                <ul class="auto-gallery share-media zoom-img">
                                                    <a href="<?php echo base_url().'public/uploads/messages_files/'.$row['file_name'];?>">
                                                        <li class="bg-size " style="background-image: url(<?php echo base_url().'public/uploads/messages_files/'.$row['file_name'];?>); background-size: cover; background-position: center center; display: block;">
                                                        </li>
                                                    </a>

                                                </ul>
                                                <?php if($row['read_status'] == 1):?>
                                                <div class="badge badge-success sm ml-2"> R</div>
                                                <?php else:?>
                                                <div class="badge badge-dark sm ml-2"> D</div>
                                                <?php endif;?>
                                                <?php if($row['message'] == ''):?>
                                                <div class="msg-dropdown-main">
                                                    <div class="msg-setting"><i class="ti-more-alt"></i></div>
                                                    <div class="msg-dropdown">
                                                        <ul>
                                                            <li><a href="#" onclick="deleteChat(<?php echo $row['message_id'];?>)"><i class="ti-trash"></i>eliminar</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <?php endif;?>
                                            </li>
                                            <?php endif;?>
                                            <?php endif;?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <?php endif;?>
                        <?php endif;?>
                        <?php endforeach;?>
                    </ul>
                </div>
                <!------------------------- Finaliza el contenido --------------------------------->
            </div>
            <?php echo form_open(base_url() . 'doctor/chat/send_message', array('enctype' => 'multipart/form-data', 'id'=>'formMessage')); ?>
            <div class="message-input">
                <div class="wrap emojis-main">
                    <a class="icon-btn btn-outline-primary button-effect mr-3 toggle-sticker outside" href="#">
                        <svg id="Layer_1" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="2158px" height="2148px" viewbox="0 0 2158 2148" enable-background="new 0 0 2158 2148" xml:space="preserve">
                            <path fill-rule="evenodd" clip-rule="evenodd" fill="none" stroke="#000000" stroke-width="60" stroke-miterlimit="10" d="M699,693                        c0,175.649,0,351.351,0,527c36.996,0,74.004,0,111,0c18.058,0,40.812-2.485,57,1c11.332,0.333,22.668,0.667,34,1                        c7.664,2.148,20.769,14.091,25,20c8.857,12.368,6,41.794,6,62c0,49.329,0,98.672,0,148c175.649,0,351.351,0,527,0                        c0-252.975,0-506.025,0-759C1205.692,693,952.308,693,699,693z"></path>
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M886,799c59.172-0.765,93.431,25.289,111,66c6.416,14.867,14.612,39.858,9,63                        c-2.391,9.857-5.076,20.138-9,29c-15.794,35.671-47.129,53.674-90,63c-20.979,4.563-42.463-4.543-55-10                        c-42.773-18.617-85.652-77.246-59-141c10.637-25.445,31.024-49,56-60c7.999-2.667,16.001-5.333,24-8                        C877.255,799.833,882.716,801.036,886,799z"></path>
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M1258,799c59.172-0.765,93.431,25.289,111,66c6.416,14.867,14.612,39.858,9,63                        c-2.391,9.857-5.076,20.138-9,29c-15.794,35.671-47.129,53.674-90,63c-20.979,4.563-42.463-4.543-55-10                        c-42.773-18.617-85.652-77.246-59-141c10.637-25.445,31.024-49,56-60c7.999-2.667,16.001-5.333,24-8                        C1249.255,799.833,1254.716,801.036,1258,799z"></path>
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M1345,1184c-0.723,18.71-11.658,29.82-20,41c-18.271,24.489-50.129,37.183-83,47                        c-7.333,1-14.667,2-22,3c-12.013,2.798-33.636,5.15-44,3c-11.332-0.333-22.668-0.667-34-1c-15.332-3-30.668-6-46-9                        c-44.066-14.426-80.944-31.937-110-61c-22.348-22.353-38.992-45.628-37-90c0.667,0,1.333,0,2,0c9.163,5.585,24.723,3.168,36,6                        c26.211,6.583,54.736,7.174,82,14c34.068,8.53,71.961,10.531,106,19c9.999,1.333,20.001,2.667,30,4c26.193,6.703,54.673,7.211,82,14                        C1304.894,1178.445,1325.573,1182.959,1345,1184z"></path>
                            <polygon fill-rule="evenodd" clip-rule="evenodd" points="668.333,1248.667 901.667,1482 941.667,1432 922.498,1237.846                         687,1210.667 "></polygon>
                        </svg></a>
                    <div class="dot-btn dot-primary mr-3"><a class="icon-btn btn-outline-primary button-effect toggle-emoji" href="#"><i data-feather="smile"></i></a></div>
                    <div class="contact-poll"><a class="icon-btn btn-outline-primary mr-4 outside" href="#"><i class="fa fa-plus"></i></a>
                        <div class="contact-poll-content">
                            <ul>
                                <li><a href="javascript:void(0)" onclick="img()"><i data-feather="image"></i>Imágen & Video</a></li>
                                <input id="img" name="img" type="file" accept="image/*" />
                                <li><a href="javascript:void(0)" onclick="docs()"><i data-feather="paperclip"></i>Documento</a></li>
                                <input id="docs" name="docs" type="file" accept=".doc,.docx,.pdf,.xlsx" />
                            </ul>
                        </div>
                    </div>

                    <input class="setemoj" id="setemoj" type="text" name="message" placeholder="Escribe tu mensaje..." />
                    <input type="hidden" name="thread_code" value="<?php echo $current_message_thread_code;?>" id="thread_code">
                    <input type="hidden" name="redirect" value="<?php echo $username;?>" id="redirect">
                    <?php $para = ""; if($recievers == ""){$para = $user_type."-".$user_id;}else {$para = $recievers;}?>
                    <input type="hidden" name="reciever" value="<?php echo $para;?>" id="reciever">
                    <button type="submit" class="submit icon-btn btn-primary disabled" id="send-msg" disabled="disabled"><i data-feather="send"> </i></button>
                    <div class="emojis-contain">
                        <div class="emojis-sub-contain custom-scroll">
                            <ul>
                                <li>&#128512;</li>
                                <li>&#128513;</li>
                                <li>&#128514;</li>
                                <li>&#128515;</li>
                                <li>&#128516;</li>
                                <li>&#128517;</li>
                                <li>&#128518;</li>
                                <li>&#128519;</li>
                                <li>&#128520;</li>
                                <li>&#128521;</li>
                                <li>&#128522;</li>
                                <li>&#128523;</li>
                                <li>&#128524;</li>
                                <li>&#128525;</li>
                                <li>&#128526;</li>
                                <li>&#128527;</li>
                                <li>&#128528;</li>
                                <li>&#128529;</li>
                                <li>&#128530;</li>
                                <li>&#128531;</li>
                                <li>&#128532;</li>
                                <li>&#128533;</li>
                                <li>&#128534;</li>
                                <li>&#128535;</li>
                                <li>&#128536;</li>
                                <li>&#128537;</li>
                                <li>&#128538;</li>
                                <li>&#128539;</li>
                                <li>&#128540;</li>
                                <li>&#128541;</li>
                                <li>&#128542;</li>
                                <li>&#128543;</li>
                                <li>&#128544;</li>
                                <li>&#128545;</li>
                                <li>&#128546;</li>
                                <li>&#128547;</li>
                                <li>&#128549;</li>
                                <li>&#128550;</li>
                                <li>&#128551;</li>
                                <li>&#128552;</li>
                                <li>&#128553;</li>
                                <li>&#128554;</li>
                                <li>&#128555;</li>
                                <li>&#128557;</li>
                                <li>&#128558;</li>
                                <li>&#128559;</li>
                                <li>&#128560;</li>
                                <li>&#128561;</li>
                                <li>&#128562;</li>
                                <li>&#128563;</li>
                                <li>&#128564;</li>
                                <li>&#128565;</li>
                                <li>&#128566;</li>
                                <li>&#128567;</li>
                                <li>&#128568;</li>
                                <li>&#128569;</li>
                                <li>&#128570;</li>
                                <li>&#128571;</li>
                                <li>&#128572;</li>
                                <li>&#128573;</li>
                                <li>&#128574;</li>
                                <li>&#128576;</li>
                                <li>&#128579;</li>
                            </ul>
                        </div>
                    </div>
                    <div class="sticker-contain">
                        <div class="sticker-sub-contain custom-scroll">
                            <ul>
                                <li><a href="#"><img class="img-fluid" src="<?php echo base_url();?>public/assets/chat_assets/images/sticker/1.gif" alt="sticker" /></a></li>
                                <li><a href="#"><img class="img-fluid" src="<?php echo base_url();?>public/assets/chat_assets//images/sticker/2.gif" alt="sticker" /></a></li>
                                <li><a href="#"><img class="img-fluid" src="<?php echo base_url();?>public/assets/chat_assets/images/sticker/3.gif" alt="sticker" /></a></li>
                                <li><a href="#"><img class="img-fluid" src="<?php echo base_url();?>public/assets/chat_assets/images/sticker/3.gif" alt="sticker" /></a></li>
                                <li><a href="#"><img class="img-fluid" src="<?php echo base_url();?>public/assets/chat_assets/images/sticker/4.gif" alt="sticker" /></a></li>
                                <li><a href="#"><img class="img-fluid" src="<?php echo base_url();?>public/assets/chat_assets/images/sticker/5.gif" alt="sticker" /></a></li>
                                <li><a href="#"><img class="img-fluid" src="<?php echo base_url();?>public/assets/chat_assets/images/sticker/6.gif" alt="sticker" /></a></li>
                                <li><a href="#"><img class="img-fluid" src="<?php echo base_url();?>public/assets/chat_assets/images/sticker/7.gif" alt="sticker" /></a></li>
                                <li><a href="#"><img class="img-fluid" src="<?php echo base_url();?>public/assets/chat_assets/images/sticker/8.gif" alt="sticker" /></a></li>
                                <li><a href="#"><img class="img-fluid" src="<?php echo base_url();?>public/assets/chat_assets/images/sticker/9.gif" alt="sticker" /></a></li>
                                <li><a href="#"><img class="img-fluid" src="<?php echo base_url();?>public/assets/chat_assets/images/sticker/10.gif" alt="sticker" /></a></li>
                                <li><a href="#"><img class="img-fluid" src="<?php echo base_url();?>public/assets/chat_assets/images/sticker/11.gif" alt="sticker" /></a></li>
                                <li><a href="#"><img class="img-fluid" src="<?php echo base_url();?>public/assets/chat_assets/images/sticker/12.gif" alt="sticker" /></a></li>
                                <li><a href="#"><img class="img-fluid" src="<?php echo base_url();?>public/assets/chat_assets/images/sticker/13.gif" alt="sticker" /></a></li>
                                <li><a href="#"><img class="img-fluid" src="<?php echo base_url();?>public/assets/chat_assets/images/sticker/14.gif" alt="sticker" /></a></li>
                                <li><a href="#"><img class="img-fluid" src="<?php echo base_url();?>public/assets/chat_assets/images/sticker/15.gif" alt="sticker" /></a></li>
                                <li><a href="#"><img class="img-fluid" src="<?php echo base_url();?>public/assets/chat_assets/images/sticker/16.gif" alt="sticker" /></a></li>
                                <li><a href="#"><img class="img-fluid" src="<?php echo base_url();?>public/assets/chat_assets/images/sticker/17.gif" alt="sticker" /></a></li>
                                <li><a href="#"><img class="img-fluid" src="<?php echo base_url();?>public/assets/chat_assets/images/sticker/18.gif" alt="sticker" /></a></li>
                                <li><a href="#"><img class="img-fluid" src="<?php echo base_url();?>public/assets/chat_assets/images/sticker/19.gif" alt="sticker" /></a></li>
                                <li><a href="#"><img class="img-fluid" src="<?php echo base_url();?>public/assets/chat_assets/images/sticker/20.gif" alt="sticker" /></a></li>
                                <li><a href="#"><img class="img-fluid" src="<?php echo base_url();?>public/assets/chat_assets/images/sticker/21.gif" alt="sticker" /></a></li>
                                <li><a href="#"><img class="img-fluid" src="<?php echo base_url();?>public/assets/chat_assets/images/sticker/22.gif" alt="sticker" /></a></li>
                                <li><a href="#"><img class="img-fluid" src="<?php echo base_url();?>public/assets/chat_assets/images/sticker/23.gif" alt="sticker" /></a></li>
                                <li><a href="#"><img class="img-fluid" src="<?php echo base_url();?>public/assets/chat_assets/images/sticker/24.gif" alt="sticker" /></a></li>
                                <li><a href="#"><img class="img-fluid" src="<?php echo base_url();?>public/assets/chat_assets/images/sticker/25.gif" alt="sticker" /></a></li>
                                <li><a href="#"><img class="img-fluid" src="<?php echo base_url();?>public/assets/chat_assets/images/sticker/26.gif" alt="sticker" /></a></li>
                                <li><a href="#"><img class="img-fluid" src="<?php echo base_url();?>public/assets/chat_assets/images/sticker/27.gif" alt="sticker" /></a></li>
                                <li><a href="#"><img class="img-fluid" src="<?php echo base_url();?>public/assets/chat_assets/images/sticker/28.gif" alt="sticker" /></a></li>
                                <li><a href="#"><img class="img-fluid" src="<?php echo base_url();?>public/assets/chat_assets/images/sticker/29.gif" alt="sticker" /></a></li>
                                <li><a href="#"><img class="img-fluid" src="<?php echo base_url();?>public/assets/chat_assets/images/sticker/30.gif" alt="sticker" /></a></li>
                                <li><a href="#"><img class="img-fluid" src="<?php echo base_url();?>public/assets/chat_assets/images/sticker/31.gif" alt="sticker" /></a></li>
                                <li><a href="#"><img class="img-fluid" src="<?php echo base_url();?>public/assets/chat_assets/images/sticker/32.gif" alt="sticker" /></a></li>
                                <li><a href="#"><img class="img-fluid" src="<?php echo base_url();?>public/assets/chat_assets/images/sticker/33.gif" alt="sticker" /></a></li>
                                <li><a href="#"><img class="img-fluid" src="<?php echo base_url();?>public/assets/chat_assets/images/sticker/34.gif" alt="sticker" /></a></li>
                                <li><a href="#"><img class="img-fluid" src="<?php echo base_url();?>public/assets/chat_assets/images/sticker/35.gif" alt="sticker" /></a></li>
                                <li><a href="#"><img class="img-fluid" src="<?php echo base_url();?>public/assets/chat_assets/images/sticker/36.gif" alt="sticker" /></a></li>
                                <li><a href="#"><img class="img-fluid" src="<?php echo base_url();?>public/assets/chat_assets/images/sticker/37.gif" alt="sticker" /></a></li>
                                <li><a href="#"><img class="img-fluid" src="<?php echo base_url();?>public/assets/chat_assets/images/sticker/38.gif" alt="sticker" /></a></li>
                                <li><a href="#"><img class="img-fluid" src="<?php echo base_url();?>public/assets/chat_assets/images/sticker/39.gif" alt="sticker" /></a></li>
                                <li><a href="#"><img class="img-fluid" src="<?php echo base_url();?>public/assets/chat_assets/images/sticker/40.gif" alt="sticker" /></a></li>
                                <li><a href="#"><img class="img-fluid" src="<?php echo base_url();?>public/assets/chat_assets/images/sticker/41.gif" alt="sticker" /></a></li>
                                <li><a href="#"><img class="img-fluid" src="<?php echo base_url();?>public/assets/chat_assets/images/sticker/42.gif" alt="sticker" /></a></li>
                                <li><a href="#"><img class="img-fluid" src="<?php echo base_url();?>public/assets/chat_assets/images/sticker/43.gif" alt="sticker" /></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php echo form_close();?>
    <aside class="chitchat-right-sidebar" id="slide-menu">
        <div class="custom-scroll right-sidebar">
            <div class="contact-profile">
                <div class="theme-title">
                    <div class="media">
                        <div>
                            <h2>Información</h2>
                            <h4>Acerca del contacto</h4>
                        </div>
                        <div class="media-body text-right"> <a class="icon-btn btn-outline-light btn-sm close-profile ml-3" href="#"> <i data-feather="x"> </i></a></div>
                    </div>
                </div>
                <div class="details">
                    <div class="contact-top"><img class="bg-img" src="<?php echo $this->accounts_model->get_photo($user_type, $user_id);?>" alt="" /></div>
                    <div class="name">
                        <h3><?php echo $this->accounts_model->get_name($user_type, $user_id);?></h3>
                        <h6>@<?php echo $username;?></h6>
                    </div>
                </div>
            </div>
            <div class="status other">
                <h5 class="block-title p-b-25">Información de contacto</h5>
                <ul>
                    <li>
                        <h5> <a href="#"> <i data-feather="smartphone"></i>+<?php echo $this->db->get_where($user_type,array('username'=>$username))->row()->phone;?></a></h5>
                    </li>
                    <li>
                        <h5><a href="<?php echo base_url() . 'doctor/'.$user_type.'_profile/'.base64_encode($user_id); ?>"> <i data-feather="crosshair"></i>Ir al perfil</a></h5>
                    </li>
                    <li>
                        <h5><a href="#"> <i data-feather="map-pin"></i><?php echo $this->db->get_where($user_type,array('username'=>$username))->row()->address;?></a></h5>
                    </li>
                </ul>
            </div>
            <div class="document">
                <div class="filter-block">
                    <div class="collapse-block open">
                        <h5 class="block-title">Documentos compartidos</h5>
                        <div class="block-content">
                            <?php
                        $this->db->where('file_name !=', "");
                        $this->db->where('original', $current_user);
                        $this->db->where('token',$current_message_thread_code);
                        $files = $this->db->get('message');
                        if($files->num_rows() > 0):
                    ?>
                            <ul class="document-list">
                                <?php foreach($files->result_array() as $file):?>

                                <?php if($file['file_type'] != "png" && $file['file_type'] != "jpg" && $file['file_type'] != "JPEG" && $file['file_type'] != "gif" && $row['file_type'] != "jpeg"):?>
                                <li><i class="ti-folder font-primary"></i>
                                    <h5><a href="<?php echo base_url();?>doctor/force_download_messages/<?php echo $file['file_name'];?>"><?php echo $file['original_file_name'];?></a></h5>
                                </li>
                                <?php endif;?>

                                <?php endforeach;?>
                            </ul>
                            <?php else:?>
                            <center><img src="<?php echo base_url();?>public/uploads/file.png" style="width:90px;" /><br>Sin archivos</center>
                            <?php endif;?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="media-gallery portfolio-section grid-portfolio">
                <div class="collapse-block open">
                    <h5 class="block-title">Multimedia compartida</h5>
                    <div class="block-content">
                        <div class="row share-media zoom-gallery">
                            <?php
                    $this->db->where('file_name !=', "");
                    $this->db->where('original', $current_user);
                    $this->db->where('token',$current_message_thread_code);
                    $imgs = $this->db->get('message');
                    if($imgs->num_rows() > 0):
                ?>
                            <?php foreach($imgs->result_array() as $img):?>
                            <?php if($img['file_type'] == "png" || $img['file_type'] == "jpg" || $img['file_type'] == "JPEG" || $img['file_type'] == "gif" || $img['file_type'] == "jpeg"):?>
                            <div class="col-4">
                                <div class="media-small isotopeSelector filter">
                                    <div class="overlay">
                                        <div class="border-portfolio"><a href="<?php echo base_url().'public/uploads/messages_files/'.$img['file_name'];?>">
                                                <div class="overlay-background"><i class="ti-plus" aria-hidden="true"></i></div><img class="img-fluid bg-img" src="<?php echo base_url().'public/uploads/messages_files/'.$img['file_name'];?>" />
                                            </a></div>
                                    </div>
                                </div>
                            </div>
                            <?php endif;?>
                            <?php endforeach;?>
                            <?php else:?>
                            <div class="col-12">
                                <center> <img src="<?php echo base_url();?>public/uploads/nofile.svg" style="width:90px;" /><br>No se encontraron imágenes.</center>
                            </div>
                            <?php endif;?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </aside>
    </div>
    <style>
    .fileuploader-input {
        display: none;
    }

    .fileuploader {
        background: transparent;
    }

    .image-upload i {
        cursor: pointer;
    }

    .user-w.active {
        background: #007fff;
        color: #fff !important;
    }

    .user-w.active .last-message {
        color: #fff !important;
    }
    </style>
    <script src="//code.jquery.com/jquery-3.2.1.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>public/assets/input/jquery.fileuploader.min.js" type="text/javascript"></script>
    <script type="text/javascript">
    var AjaxURL = '<?php echo base_url();?>' + '/doctor/chat/send_message';

    var aaa = $('input[name="img"]').fileuploader({
        // Options will go here
        extensions: ['jpg', 'pdf', 'text/plain', 'docx', 'png', 'jpeg', 'xlsx'],

    });

    $('input[name="docs"]').fileuploader({
        // Options will go here
        extensions: ['jpg', 'pdf', 'text/plain', 'docx', 'png', 'jpeg', 'xlsx'],

    });


    function img() {
        $(".fileuploader-items-list").empty();
        $("input[id='docs']").val('');
        $("input[id='img']").click();
        $('#send-msg').removeClass('disabled').removeAttr("disabled")
    }

    function docs() {
        $(".fileuploader-items-list").empty();
        $("input[id='img']").val('');
        $("input[id='docs']").click();
        $('#send-msg').removeClass('disabled').removeAttr("disabled")
    }



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
                location.href = "<?php echo base_url();?>doctor/chat/delete/" + chat_id;
            }
        })
    }

    function deleteChat(chat_id) {
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
                location.href = "<?php echo base_url();?>doctor/chat/delete/" + chat_id;
            }
        })
    }
    </script>

    <script src="<?php echo base_url();?>public/assets/chat_assets/js/jquery-3.3.1.min.js"></script>
    <script src="<?php echo base_url();?>public/assets/chat_assets/js/owl.carousel.js"></script>
    <script src="<?php echo base_url();?>public/assets/chat_assets/js/popper.min.js"></script>
    <script src="<?php echo base_url();?>public/assets/chat_assets/js/tippy-bundle.iife.min.js"></script>
    <script src="<?php echo base_url();?>public/assets/chat_assets/js/bootstrap.js"></script>
    <script src="<?php echo base_url();?>public/assets/chat_assets/js/feather-icon/feather.min.js"></script>
    <script src="<?php echo base_url();?>public/assets/chat_assets/js/feather-icon/feather-icon.js"></script>
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
                    url: '<?php echo base_url();?>doctor/get_contacts',
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