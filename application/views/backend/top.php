    <?php if($this->session->userdata('login_type') == 'doctor' || $this->session->userdata('login_type') == 'admin'):?>
    <div class="menu-sticky-sidebar" style="z-index:22">
        <nav id="top-nav">
            <div class="nav-search-input">
                <form action="<?php echo base_url().$this->session->userdata('login_type');?>/search/find" method="POST">
                    <input type="text" name="search_key" value="<?php if(isset($like)) {echo $like;}  else { $like = '';}?>" class="form-control" required="" placeholder="Buscar en Medicaby">
                    <i id="search" class="dripicons-search"></i>
                </form>
            </div>
            <div class="mobile-search-active animated fadeInRight">
                <form action="<?php echo base_url().$this->session->userdata('login_type');?>/search/find" method="POST" class="mobile-search-box">
                    <i class="dripicons-search"></i>
                    <input class="mobile-search-input" autofocus type="text" value="<?php if(isset($like)) {echo $like;}  else { $like = '';}?>" required="" name="search_key" placeholder="Buscar en Medicaby...">
                    <button type="button" class="exit-search">
                        <span>×</span>
                    </button>
                </form>
            </div>
            <?php
                    $this->db->where('status','1');
					$clinics = $this->db->get('clinic');
				?>
            <a class="logo-mobile" href="<?php echo base_url().$this->session->userdata('login_type');?>/panel/"><img src="<?php echo base_url();?>public/uploads/<?php echo $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->logo; ?>" alt="Medicaby"></a>
            <div class="user-profile dropdown show">
                <a class="dropdown-toggle" href="#" data-display="static" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                    <img style=" object-fit: contain; border-radius:10px;height:50px; max-width:50x;max-height:50px;border:4px solid #fff;background:#fff; padding=1px" src="<?php echo $this->accounts_model->get_photo('admin',$this->session->userdata('login_user_id'));?>" alt="<?php echo $this->accounts_model->short_name('admin', $this->session->userdata('login_user_id'));?>">
                    <i class="user-icon-m dripicons-user"></i>
                    <span class="dropdown-arrow dripicons-chevron-down"></span>
                </a>
                <div class="dropdown-menu animated zoomIn">
                    <div class="dropdown-menu-wrapper">
                        <?php if($this->crud_model->checkMobile()):?>
                        <div id="dark-toggle" class="dropdown-item">Cambiar sucursal:</div>
                        <?php 
    					            foreach($clinics->result_array() as $top_cli):
    				            ?>
                        <a class="dropdown-item" style="<?php if($this->session->userdata('current_clinic') == $top_cli['clinic_id']):?> color:#27a0ff; font-weight:500;<?php endif;?>" href="<?php echo base_url().$this->session->userdata('login_type');?>/change/<?php echo base64_encode($top_cli['clinic_id']);?>">
                            <i class="picons-thin-icon-thin-0133_arrow_right_next"></i> <?php echo $top_cli['name'];?>
                            <?php if($this->session->userdata('current_clinic') == $top_cli['clinic_id']):?>
                            [Actual]<?php endif;?>.
                        </a>
                        <?php endforeach;?>
                        <?php endif;?>
                        <a class="dropdown-item" href="<?php echo base_url().$this->session->userdata('login_type');?>/my_profile/"><i class="dripicons-user"></i> Mi perfil</a>
                        <?php if($this->crud_model->checkMobile()):?>
                        <a class="dropdown-item" href="#"><i class="picons-thin-icon-thin-0543_world_earth_worldwide_location_travel"></i>
                            Notificaciones</a>
                        <a class="dropdown-item" href="<?php echo base_url().$this->session->userdata('login_type');?>/chat/"><i class="picons-thin-icon-thin-0277_chat_message_comment_bubble_like_favorite"></i>
                            Mensajes</a>
                        <?php endif;?>
                        <a class="dropdown-item" id="logOut" style="cursor:pointer" href="<?php echo base_url();?>logout/"><i class="dripicons-exit"></i>
                            Salir</a>
                    </div>
                </div>
            </div>
            <p class="user-name">
                <?php echo $this->accounts_model->short_name('admin', $this->session->userdata('login_user_id'));?>
                <span class="user-position"><?php echo $this->accounts_model->get_profession($this->session->userdata('login_user_id'));?></span>
            </p>
            <ul class="nav-icons" style="margin: auto;">
                <?php 
					if($clinics->num_rows() > 1 ):
				?>
                <li class="nav-calendar dropdown">
                    <a class="dropdown-toggle" data-display="static" href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        <i class="picons-thin-icon-thin-0823_hospital_ill_medicine_doctor_ambulance"></i>
                    </a>
                    <ul class="user-calendar dropdown-menu animated zoomIn">
                        <li>
                            <?php 
    					        
					            foreach($clinics->result_array() as $top_cli):
				            ?>
                            <a class="dropdown-item" style="font-size:18px; <?php if($this->session->userdata('current_clinic') == $top_cli['clinic_id']):?> color:#27a0ff; font-weight:500;<?php else:?>color:#636363;<?php endif;?>" href="<?php echo base_url().$this->session->userdata('login_type');?>/change/<?php echo base64_encode($top_cli['clinic_id']);?>">
                                <i class="picons-thin-icon-thin-0133_arrow_right_next" style="font-size:13.2px; margin-right:3px; vertical-align:-0.85px;"></i>
                                <?php echo $top_cli['name'];?>.
                            </a>
                            <?php endforeach;?>
                        </li>
                    </ul>
                </li>
                <?php endif;?>
                <li class="nav-messages dropdown">
                    <a class="dropdown-toggle" data-display="static" href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true">
                        <i class="picons-thin-icon-thin-0277_chat_message_comment_bubble_like_favorite"></i>
                    </a>
                    <ul class="user-messages timeline dropdown-menu-wrapper dropdown-menu animated zoomIn">
                        <div class="title-notification">Mensajes <a class="pull-right read-all" href="<?php echo base_url();?><?php echo $this->session->userdata('login_type');?>/chat/">Ver
                                todos</a></div>
                        <?php 
                            $current_user_top = 'admin-' . $this->session->userdata('login_user_id');
                            $this->db->order_by('message_id','desc');
                            $this->db->group_by('token');
                            $this->db->limit(3);
                            $this->db->where('read_status', 0);
                            $this->db->where('(sender = "'.$current_user_top.'" OR reciever = "'.$current_user_top.'")');
                            $this->db->where('original', $current_user_top);
                            $message_threads_top = $this->db->get('message');
                            if($message_threads_top->num_rows() > 0):
                                foreach ($message_threads_top->result_array() as $row_top):
                                if ($row_top['sender'] == $current_user_top)
                                {
                                    $user_to_show_top = explode('-', $row_top['reciever']);
                                }
                                if ($row_top['reciever'] == $current_user_top)
                                {
                                    $user_to_show_top = explode('-', $row_top['sender']);
                                }
                                $user_to_show_type_top = $user_to_show_top[0];
                                $user_to_show_id_top = $user_to_show_top[1];
                                $rw_top = $this->db->select('*')->where('token',$row_top['token'])->order_by('message_id',"desc")->limit(1)->get('message')->row();
                                $dbinfo = explode('-',$rw_top->sender);
                        ?>
                        <li>
                            <a class="contenedor_mensajes" href="<?php echo base_url().$this->session->userdata('login_type');?>/messages/<?php echo $this->db->get_where($user_to_show_type_top, array($user_to_show_type_top . '_id' => $user_to_show_id_top))->row()->username;?>?notify=<?php echo $row_top['message_id'];?>">
                                <div class="contenedor_avatar">
                                    <img src="<?php echo $this->accounts_model->get_photo($user_to_show_type_top, $user_to_show_id_top);?>" alt="User profile">
                                </div>
                                <div class="contenedor_lista">
                                    <p class="contenedor_de">
                                        <?php echo $this->accounts_model->short_name($user_to_show_type_top, $user_to_show_id_top);?>
                                    </p>
                                    <p class="contenedor_mensaje">
                                        <?php
    					                if($current_user_top == $rw_top->sender) 
                                        {
                                            if($rw_top->message == ''){
                                                echo "Enviaste un archivo.";
                                            }else{

												if($rw_top->stiker != 1 )
												{
												  echo "<b>Tú:</b> ". substr($rw_top->message, 0, 80).'...';    
												}else
												{
												  echo "<b>Tú:</b> Sticker...";    
  
												}

                                               
                                            }
                                        }
                                        else {
                                            if($rw_top->message == '' && $rw_top->file_name != ''){
                                                echo "Te envió un archivo.";
                                            }else{
												if($rw_top->stiker != 1 )
												{
												  echo "<b>Envío:</b> ". substr($rw_top->message, 0, 80).'...';    
												}else
												{
												  echo "<b>Envío:</b> Sticker...";    
  
												}

                                            }
                                        }
    					            ?>
                                    </p>
                                </div>
                            </a>
                        </li>
                        <?php endforeach;?>
                        <?php else:?><br>
                        <div>
                            <center><small style="color:#fff;font-family:'CircularStd';">No tienes nuevos
                                    chats</small><br><img src="<?php echo base_url();?>public/uploads/chats.png" style="width:50%;" /></center>
                        </div><br>
                        <?php endif;?>
                    </ul>
                </li>

                <li class="nav-messages dropdown show">
                    <a class="dropdown-toggle" data-display="static" href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true" onclick="notificatiostoread('my_notifications');">
                        <i class="picons-thin-icon-thin-0543_world_earth_worldwide_location_travel"></i>
                    </a>
                    <ul class="user-messages timeline dropdown-menu-wrapper dropdown-menu animated zoomIn">
                        <div class="title-notification">Notificaciones <a class="pull-right read-all" href="<?php echo base_url();?><?php echo $this->session->userdata('login_type');?>/my_notifications/">Ver
                                todas</a></div>
                        <?php 
				            $this->db->limit(5);
							$this->db->order_by('notification_id','DESC');
					        $notifications = $this->db->get_where('notification', array('to_user' => $this->session->userdata('login_user_id'), 'to_type' => $this->session->userdata('login_type')));
					        if($notifications->num_rows() > 0):
    					    foreach($notifications->result_array() as $noti):
					    ?>
                        <li>
                            <a class="contenedor_mensajes" href="<?php echo $noti['url'];?>">

                                <div class="contenedor_lista">
                                    <p class="contenedor_de">
                                        <span class="status-pill" style="width: 8px;height: 8px; background: <?php echo $noti['read_status'] != 1 ? '#e6b517':'#24b314;'; ?>  "></span>
                                        <?php echo $noti['date'];?>
                                    </p>
                                    <p class="contenedor_mensaje">
                                        <?php echo $noti['message'];?>
                                    </p>
                                </div>
                            </a>
                        </li>
                        <?php endforeach;?>
                        <?php else:?>
                        <br>
                        <div>
                            <center><small style="color:#fff;font-family:'CircularStd';">No tienes nuevas
                                    notificaciones</small><br><img src="<?php echo base_url();?>public/uploads/chats.png" style="width:60%;" />
                            </center>
                        </div><br>
                        <?php endif;?>
                    </ul>
                </li>


            </ul>
        </nav>
    </div>
    <?php elseif($this->session->userdata('login_type') == 'staff'):?>
    <div class="menu-sticky-sidebar" style="z-index:22">
        <nav id="top-nav">
            <div class="nav-search-input">
                <form action="<?php echo base_url();?>staff/search/find" method="POST">
                    <input type="text" name="search_key" value="<?php if(isset($like)) echo $like;?>" class="form-control" required="" placeholder="Buscar en Medicaby...">
                    <i id="search" class="dripicons-search"></i>
                </form>
            </div>
            <div class="mobile-search-active animated fadeInRight">
                <form class="mobile-search-box">
                    <i class="dripicons-search"></i>
                    <input class="mobile-search-input" autofocus type="text" spellcheck="false" placeholder="Search...">
                    <button type="button" class="exit-search">
                        <span>×</span>
                    </button>
                </form>
            </div>
            <a class="logo-mobile" href="<?php echo base_url();?>staff/appointments/"><img src="<?php echo base_url();?>public/uploads/<?php echo $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->logo; ?>" alt="Medicaby"></a>
            <div class="user-profile dropdown show">
                <a class="dropdown-toggle" href="#" data-display="static" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                    <img style="border-radius:10px;max-width:50x;max-height:50px;border:4px solid #fff;object-fit:cover;background:#fff;" src="<?php echo $this->accounts_model->get_photo('staff',$this->session->userdata('login_user_id'));?>" alt="<?php echo $this->accounts_model->short_name('staff', $this->session->userdata('login_user_id'));?>">
                    <i class="user-icon-m dripicons-user"></i>
                    <span class="dropdown-arrow dripicons-chevron-down"></span>
                </a>
                <div class="dropdown-menu animated zoomIn">
                    <div class="dropdown-menu-wrapper">
                        <a class="dropdown-item" href="<?php echo base_url();?>staff/staff_profile/<?php echo base64_encode($this->session->userdata('login_user_id'));?>/"><i class="dripicons-user"></i> Mi perfil</a>
                        <?php if($this->crud_model->checkMobile()):?>
                        <a class="dropdown-item" href="<?php echo base_url();?><?php echo $this->session->userdata('login_type');?>/staff_notifications/<?php echo base64_encode($this->session->userdata('login_user_id'));?>"><i class="picons-thin-icon-thin-0543_world_earth_worldwide_location_travel"></i>
                            Notificaciones</a>
                        <a class="dropdown-item" href="<?php echo base_url();?>staff/chat/"><i class="picons-thin-icon-thin-0277_chat_message_comment_bubble_like_favorite"></i>
                            Mensajes</a>
                        <?php endif;?>
                        <a class="dropdown-item" id="logOut" style="cursor:pointer" href="<?php echo base_url();?>logout/"><i class="dripicons-exit"></i>
                            Salir</a>
                    </div>
                </div>
            </div>
            <p class="user-name">
                <?php echo $this->accounts_model->short_name('staff', $this->session->userdata('login_user_id'));?>
                <span class="user-position"><?php echo $this->accounts_model->get_profession($this->session->userdata('login_user_id'));?></span>
            </p>

            <ul class="nav-icons" style="margin: auto;">

                <?php $this->db->where('status','1');
					$clinics = $this->db->get('clinic');
					if($clinics->num_rows() > 1 ):
				?>

                <li class="nav-calendar dropdown">
                    <a class="dropdown-toggle" data-display="static" href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        <i class="picons-thin-icon-thin-0823_hospital_ill_medicine_doctor_ambulance"></i>
                    </a>
                    <ul class="user-calendar dropdown-menu animated zoomIn">
                        <li>
                            <?php 
					                foreach($clinics->result_array() as $top_cli):
				                ?>
                            <a class="dropdown-item" style="font-size:18px; <?php if($this->session->userdata('current_clinic') == $top_cli['clinic_id']):?> color:#27a0ff; font-weight:500;<?php else:?>color:#636363;<?php endif;?>" href="<?php echo base_url();?>staff/change/<?php echo base64_encode($top_cli['clinic_id']);?>">
                                <i class="picons-thin-icon-thin-0133_arrow_right_next" style="font-size:13.2px; margin-right:3px; vertical-align:-0.85px;"></i>
                                <?php echo $top_cli['name'];?>.
                            </a>
                            <?php endforeach;?>
                        </li>
                    </ul>
                </li>
                <?php endif;?>
                <li class="nav-messages dropdown">
                    <a class="dropdown-toggle" data-display="static" href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true">
                        <i class="picons-thin-icon-thin-0277_chat_message_comment_bubble_like_favorite"></i>
                    </a>

                    <ul class="user-messages timeline dropdown-menu-wrapper dropdown-menu animated zoomIn">
                        <div class="title-notification">Mensajes <a class="pull-right read-all" href="<?php echo base_url();?><?php echo $this->session->userdata('login_type');?>/chat/">Ver
                                todos</a></div>
                        <?php 
                            $current_user_top = 'staff-' . $this->session->userdata('login_user_id');
                            $this->db->order_by('message_id','desc');
                            $this->db->group_by('token');
                            $this->db->limit(3);
                            $this->db->where('read_status', 0);
                            $this->db->where('(sender = "'.$current_user_top.'" OR reciever = "'.$current_user_top.'")');
                            $this->db->where('original', $current_user_top);
                            $message_threads_top = $this->db->get('message');
                            if($message_threads_top->num_rows() > 0):
                                foreach ($message_threads_top->result_array() as $row_top):
                                if ($row_top['sender'] == $current_user_top)
                                {
                                    $user_to_show_top = explode('-', $row_top['reciever']);
                                }
                                if ($row_top['reciever'] == $current_user_top)
                                {
                                    $user_to_show_top = explode('-', $row_top['sender']);
                                }
                                $user_to_show_type_top = $user_to_show_top[0];
                                $user_to_show_id_top = $user_to_show_top[1];
                                $rw_top = $this->db->select('*')->where('token',$row_top['token'])->order_by('message_id',"desc")->limit(1)->get('message')->row();
                                $dbinfo = explode('-',$rw_top->sender);
                        ?>
                        <li>
                            <a class="contenedor_mensajes" href="<?php echo base_url().$this->session->userdata('login_type');?>/messages/<?php echo $this->db->get_where($user_to_show_type_top, array($user_to_show_type_top . '_id' => $user_to_show_id_top))->row()->username;?>?notify=<?php echo $row_top['message_id'];?>">
                                <div class="contenedor_avatar">
                                    <img src="<?php echo $this->accounts_model->get_photo($user_to_show_type_top, $user_to_show_id_top);?>" alt="User profile">
                                </div>
                                <div class="contenedor_lista">
                                    <p class="contenedor_de">
                                        <?php echo $this->accounts_model->short_name($user_to_show_type_top, $user_to_show_id_top);?>
                                    </p>
                                    <p class="contenedor_mensaje">
                                        <?php
    					                if($current_user_top == $rw_top->sender) 
                                        {
                                            if($rw_top->message == ''){
                                                echo "Enviaste un archivo.";
                                            }else{

												if($rw_top->stiker != 1 )
												{
												  echo "<b>Tú:</b> ". substr($rw_top->message, 0, 80).'...';    
												}else
												{
												  echo "<b>Tú:</b> Sticker...";    
  
												}

                                               
                                            }
                                        }
                                        else {
                                            if($rw_top->message == '' && $rw_top->file_name != ''){
                                                echo "Te envió un archivo.";
                                            }else{
												if($rw_top->stiker != 1 )
												{
												  echo "<b>Envío:</b> ". substr($rw_top->message, 0, 80).'...';    
												}else
												{
												  echo "<b>Envío:</b> Sticker...";    
  
												}

                                            }
                                        }
    					            ?>
                                    </p>
                                </div>
                            </a>
                        </li>
                        <?php endforeach;?>
                        <?php else:?><br>
                        <div>
                            <center><small style="color:#fff;font-family:'CircularStd';">No tienes nuevos
                                    chats</small><br><img src="<?php echo base_url();?>public/uploads/chats.png" style="width:60%;" /></center>
                        </div><br>
                        <?php endif;?>
                    </ul>
                </li>

                <li class="nav-messages dropdown">
                    <a class="dropdown-toggle" data-display="static" href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true" onclick="notificatiostoread('staff_notifications');">
                        <i class="picons-thin-icon-thin-0543_world_earth_worldwide_location_travel"></i>
                    </a>
                    <ul class="user-messages timeline dropdown-menu-wrapper dropdown-menu animated zoomIn">
                        <div class="title-notification">Notificaciones <a class="pull-right read-all" href="<?php echo base_url();?><?php echo $this->session->userdata('login_type');?>/staff_notifications/<?php echo base64_encode($this->session->userdata('login_user_id'));?>">Ver
                                todas</a></div>
                        <?php 
				            $this->db->limit(5);
							$this->db->order_by('notification_id','DESC');
					        $notifications = $this->db->get_where('notification', array('to_user' => $this->session->userdata('login_user_id'), 'to_type' => $this->session->userdata('login_type')));
					        if($notifications->num_rows() > 0):
    					    foreach($notifications->result_array() as $noti):
					    ?>
                        <li>
                            <a class="contenedor_mensajes" href="<?php echo $noti['url'];?>">

                                <div class="contenedor_lista">
                                    <p class="contenedor_de">
                                        <span class="status-pill" style="width: 8px;height: 8px; background: <?php echo $noti['read_status'] != 1 ? '#e6b517':'#24b314;'; ?>  "></span>
                                        <?php echo $noti['date'];?>
                                    </p>
                                    <p class="contenedor_mensaje">
                                        <?php echo $noti['message'];?>
                                    </p>
                                </div>
                            </a>
                        </li>
                        <?php endforeach;?>
                        <?php else:?>
                        <br>
                        <div>
                            <center><small style="color:#fff;font-family:'CircularStd';">No tienes nuevas
                                    notificaciones</small><br><img src="<?php echo base_url();?>public/uploads/chats.png" style="width:60%;" />
                            </center>
                        </div><br>
                        <?php endif;?>
                    </ul>
                </li>


            </ul>
        </nav>
    </div>
    <?php elseif($this->session->userdata('login_type') == 'patient'):?>
    <div class="menu-sticky-sidebar" style="z-index:22">
        <nav id="top-nav">
            <a class="logo-mobile" href="<?php echo base_url();?>patient/dashboard/<?php echo base64_encode($this->session->userdata('login_user_id'));?>/"><img src="<?php echo base_url();?>public/uploads/<?php echo $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->logo;?>" alt="Medicaby"></a>
            <div class="user-profile dropdown show">
                <a class="dropdown-toggle" href="#" data-display="static" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                    <img style="border-radius:10px;max-width:50x;max-height:50px;border:4px solid #fff;object-fit:cover;background:#fff;" src="<?php echo $this->accounts_model->get_photo('patient',$this->session->userdata('login_user_id'));?>" alt="<?php echo $this->accounts_model->short_name('patient', $this->session->userdata('login_user_id'));?>">
                    <i class="user-icon-m dripicons-user"></i>
                    <span class="dropdown-arrow dripicons-chevron-down"></span>
                </a>

                <div class="dropdown-menu animated zoomIn">
                    <div class="dropdown-menu-wrapper">
                        <?php if($this->crud_model->checkMobile()):?>
                        <a class="dropdown-item" href="<?php echo base_url();?>patient/notifications/<?php echo base64_encode($this->session->userdata('login_user_id'));?>"><i class="picons-thin-icon-thin-0543_world_earth_worldwide_location_travel"></i>
                            Notificaciones</a>
                        <a class="dropdown-item" href="<?php echo base_url();?>patient/chat/"><i class="picons-thin-icon-thin-0277_chat_message_comment_bubble_like_favorite"></i>
                            Mensajes</a>
                        <?php endif;?>
                        <a class="dropdown-item" id="logOut" style="cursor:pointer" href="<?php echo base_url();?>logout/"><i class="dripicons-exit"></i>
                            Salir</a>
                    </div>
                </div>
            </div>
            <p class="user-name">
                <?php echo $this->accounts_model->short_name('patient', $this->session->userdata('login_user_id'));?>
                <span class="user-position">Paciente</span>
            </p>
            <ul class="nav-icons" style="margin: auto;">


                <li class="nav-messages dropdown">
                    <a class="dropdown-toggle" data-display="static" href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true">
                        <i class="picons-thin-icon-thin-0277_chat_message_comment_bubble_like_favorite"></i>
                    </a>

                    <ul class="user-messages timeline dropdown-menu-wrapper dropdown-menu animated zoomIn">
                        <div class="title-notification">Mensajes <a class="pull-right read-all" href="<?php echo base_url();?><?php echo $this->session->userdata('login_type');?>/chat/">Ver
                                todos</a></div>
                        <?php 
								$current_user_top = 'patient-' . $this->session->userdata('login_user_id');
								$this->db->order_by('message_id','desc');
								$this->db->group_by('token');
								$this->db->limit(3);
								$this->db->where('read_status', 0);
								$this->db->where('(sender = "'.$current_user_top.'" OR reciever = "'.$current_user_top.'")');
								$this->db->where('original', $current_user_top);
								$message_threads_top = $this->db->get('message');
								if($message_threads_top->num_rows() > 0):
									foreach ($message_threads_top->result_array() as $row_top):
									if ($row_top['sender'] == $current_user_top)
									{
										$user_to_show_top = explode('-', $row_top['reciever']);
									}
									if ($row_top['reciever'] == $current_user_top)
									{
										$user_to_show_top = explode('-', $row_top['sender']);
									}
									$user_to_show_type_top = $user_to_show_top[0];
									$user_to_show_id_top = $user_to_show_top[1];
									$rw_top = $this->db->select('*')->where('token',$row_top['token'])->order_by('message_id',"desc")->limit(1)->get('message')->row();
									$dbinfo = explode('-',$rw_top->sender);
							?>
                        <li>
                            <a class="contenedor_mensajes" href="<?php echo base_url().$this->session->userdata('login_type');?>/messages/<?php echo $this->db->get_where($user_to_show_type_top, array($user_to_show_type_top . '_id' => $user_to_show_id_top))->row()->username;?>?notify=<?php echo $row_top['message_id'];?>">
                                <div class="contenedor_avatar">
                                    <img src="<?php echo $this->accounts_model->get_photo($user_to_show_type_top, $user_to_show_id_top);?>" alt="User profile">
                                </div>
                                <div class="contenedor_lista">
                                    <p class="contenedor_de">
                                        <?php echo $this->accounts_model->short_name($user_to_show_type_top, $user_to_show_id_top);?>
                                    </p>
                                    <p class="contenedor_mensaje">
                                        <?php
											if($current_user_top == $rw_top->sender) 
											{
												if($rw_top->message == ''){
													echo "Enviaste un archivo.";
												}else{

													if($rw_top->stiker != 1 )
													{
													echo "<b>Tú:</b> ". substr($rw_top->message, 0, 80).'...';    
													}else
													{
													echo "<b>Tú:</b> Sticker...";    

													}

												
												}
											}
											else {
												if($rw_top->message == '' && $rw_top->file_name != ''){
													echo "Te envió un archivo.";
												}else{
													if($rw_top->stiker != 1 )
													{
													echo "<b>Envío:</b> ". substr($rw_top->message, 0, 80).'...';    
													}else
													{
													echo "<b>Envío:</b> Sticker...";    

													}

												}
											}
										?>
                                    </p>
                                </div>
                            </a>
                        </li>
                        <?php endforeach;?>
                        <?php else:?><br>
                        <div>
                            <center><small style="color:#fff;font-family:'CircularStd';">No tienes nuevos
                                    chats</small><br><img src="<?php echo base_url();?>public/uploads/chats.png" style="width:60%;" /></center>
                        </div><br>
                        <?php endif;?>
                    </ul>
                </li>

                <li class="nav-messages dropdown">
                    <a class="dropdown-toggle" data-display="static" href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true" onclick="notificatiostoread('notifications');">
                        <i class="picons-thin-icon-thin-0543_world_earth_worldwide_location_travel"></i>
                    </a>
                    <ul class="user-messages timeline dropdown-menu-wrapper dropdown-menu animated zoomIn">
                        <div class="title-notification">Notificaciones <a class="pull-right read-all" href="<?php echo base_url();?><?php echo $this->session->userdata('login_type');?>/notifications/<?php echo base64_encode($this->session->userdata('login_user_id'));?>">Ver
                                todas</a></div>
                        <?php 
								$this->db->limit(5);
								$this->db->order_by('notification_id','DESC');
								$notifications = $this->db->get_where('notification', array('to_user' => $this->session->userdata('login_user_id'), 'to_type' => $this->session->userdata('login_type')));
								if($notifications->num_rows() > 0):
								foreach($notifications->result_array() as $noti):
							?>
                        <li>
                            <a class="contenedor_mensajes" href="<?php echo $noti['url'];?>">

                                <div class="contenedor_lista">
                                    <p class="contenedor_de">
                                        <span class="status-pill" style="width: 8px;height: 8px; background: <?php echo $noti['read_status'] != 1 ? '#e6b517':'#24b314;'; ?>  "></span>
                                        <?php echo $noti['date'];?>
                                    </p>
                                    <p class="contenedor_mensaje">
                                        <?php echo $noti['message'];?>
                                    </p>
                                </div>
                            </a>
                        </li>
                        <?php endforeach;?>
                        <?php else:?>
                        <br>
                        <div>
                            <center><small style="color:#fff;font-family:'CircularStd';">No tienes nuevas
                                    notificaciones</small><br><img src="<?php echo base_url();?>public/uploads/chats.png" style="width:60%;" />
                            </center>
                        </div><br>
                        <?php endif;?>
                    </ul>
                </li>


            </ul>

        </nav>
    </div>
    <?php endif;?>
    <script>
var see = 0;

function notificatiostoread(link) {
    if (see == 0) {

        $.ajax({
            url: '<?php echo base_url().$this->session->userdata('login_type'); ?>/' + link +
                '/read/<?php echo $this->session->userdata('login_user_id'); ?>',
            success: function(response) {

            }
        });
        see++;
    }
}
    </script>
   