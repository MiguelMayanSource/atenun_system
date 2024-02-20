<aside class="side-nav side-nav-small scroll" id="nav" style="overflow-y: auto !important;">
    <div class="smartphone-menu-trigger"><i class="dripicons-align-justify"></i></div>
    <div class="closeSideNav"><i class="dripicons-cross"></i></div>
    <ul class="side-nav-wrapper">

        <li class="brand">
            <a href="<?php echo base_url();?>doctor/panel/">
                <img src="<?php echo base_url();?>public/uploads/<?php echo $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->logo;?>" style="width:90px; margin:0px;" alt="<?php echo $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->name;?>">
            </a>
        </li>

        <li class="movil_brand">
            <a style="text-align:center;" href="<?php echo base_url();?>doctor/panel/">
                <center><img src="<?php echo base_url();?>public/uploads/<?php echo $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->logo;?>" style="object-fit: scale-down; width: 90px; height: 50px;" alt="<?php echo $this->db->get_where('clinic', array('clinic_id' => $this->session->userdata('current_clinic')))->row()->name;?>">
                </center>
            </a>
        </li>

        <?php
            $admin_id = $this->session->userdata('login_user_id');
            $this->db->where('admin_id', $admin_id);
            $info = $this->db->get('admin')->result_array();
                foreach ($info as $details):
                    $perm = $this->accounts_model->getPermissionsRole($details['role_id']);
                    $check = unserialize($perm);
            ?>
        <?php if ($details['panel'] == 1):?>

        <li class="sideBox-item" data-toggle="tooltip" data-placement="right" title="Tablero">
            <a href="<?php echo base_url();?>doctor/panel/" <?php if ($page_name == 'panel'):?>class="currentPage" <?php endif;?>>
                <i class="iconBox picons-thin-icon-thin-0482_gauge_dashboard_empty"></i>
                <span class="sideBox-item-name">Tablero</span>
            </a>
        </li>

        <?php endif; if ($check['view_chat'] == 1):?>
        <li class="sideBox-item" data-toggle="tooltip" data-placement="right" title="Chat">
            <a href="<?php echo base_url();?>doctor/chat/" <?php if ($page_name == 'chat' || $page_name == 'messages'):?>class="currentPage" <?php endif;?>>
                <i class="iconBox picons-thin-icon-thin-0277_chat_message_comment_bubble_like_favorite"></i>
                <span class="sideBox-item-name">Chat</span>
            </a>
        </li>
        <?php endif; if ($check['view_admins'] == 1):?>
        <li class="sideBox-item" data-toggle="tooltip" data-placement="right" title="Usuarios">
            <a href="<?php echo base_url();?>doctor/admins/" <?php if ($page_name == 'admins' || $page_name == 'new_admin' || $page_name == 'new_doctor' ||$page_name == 'doctors' || $page_name == 'staff' || $page_name == 'receptionist' || $page_name == 'providers' || $page_name == 'staff_profile' || $page_name == 'admin_profile'  || $page_name == 'doctor_profile'|| $page_name == 'permission_details'):?>class="currentPage" <?php endif;?>>
                <i class="iconBox picons-thin-icon-thin-0710_business_tie_user_profile_avatar_man_male"></i>
                <span class="sideBox-item-name">Pacientes</span>
            </a>
        </li>
        <?php endif; if ($check['view_appointments'] == 1):?>
        <li class="sideBox-item" data-toggle="tooltip" data-placement="right" title="Citas">
            <a href="<?php echo base_url();?>doctor/appointments/" <?php if($page_name == 'calendar' ||$page_name == 'appointment_details' || $page_name == 'appointments' || $page_name == 'pending_payment' || $page_name == 'soon' || $page_name == 'rescheduled' || $page_name == 'cancelled' || $page_name == 'archived'):?> class="currentPage" <?php endif;?>>
                <i class="iconBox picons-thin-icon-thin-0021_calendar_month_day_planner"></i>
                <span class="sideBox-item-name">Citas</span>
            </a>
        </li>
        <?php endif;
        if ($check['view_patients'] == 1):?>
        <li class="sideBox-item" data-toggle="tooltip" data-placement="right" title="Pacientes">
            <a href="<?php echo base_url();?>doctor/patients/" <?php if ($page_name == 'prescription_details' || $page_name == 'patients' || $page_name == 'patients_list' || $page_name == 'patient_profile' || $page_name == 'medical_history' || $page_name == 'medical_prescriptions' || $page_name == 'patient_files' || $page_name == 'patient_appointments' || $page_name == 'patient_financial' || $page_name == 'patient_security' || $page_name == 'treatment' || $page_name == 'treatment_details' || $page_name == 'patients_add'|| $page_name == 'patients_edit'):?>class="currentPage" <?php endif;?>>
                <i class="iconBox picons-thin-icon-thin-0092_file_profile_user_personal"></i>
                <span class="sideBox-item-name">Pacientes</span>
            </a>
        </li>
        <?php endif;
        if ($check['view_stabilitation'] == 1): ?>
        <li class="sideBox-item" data-toggle="tooltip" data-placement="right" title="Hospitalizacion">
            <a href="<?php echo base_url();?>doctor/stabilitation/" <?php if ($page_name == 'stabilitation' || $page_name == 'stabilitation_details'):?> class="currentPage" <?php endif;?>>
                <i class="iconBox picons-thin-icon-thin-0723_nurse_medicine_hospital_doctor"></i>
                <span class="sideBox-item-name">Hospitalización</span>
            </a>
        </li>
        
        <?php 
        endif;
            if ($check['view_inventory'] == 1):?>
        <li class="sideBox-item" data-toggle="tooltip" data-placement="right" title="Inventario">
            <a href="<?php echo base_url();?>doctor/inventory/" <?php if ($page_name == 'inventory' || $page_name == 'categories' || $page_name == 'equipment' || $page_name == 'supplies' || $page_name == 'history') :?>class="currentPage" <?php endif;?>>
                <i class="iconBox picons-thin-icon-thin-0820_medicine_drugs_ill_pill"></i>
                <span class="sideBox-item-name">Inventario</span>
            </a>
        </li>
        <?php 
    endif;?>
        <?php if ($check['view_plans'] == 1):?>
        <li class="sideBox-item" data-toggle="tooltip" data-placement="right" title="planes">
            <a href="<?php echo base_url();?>doctor/plans/" <?php if ($page_name == 'Puntos y Memebresias' ) :?>class="currentPage" <?php endif;?>>
                <i class="iconBox picons-thin-icon-thin-0066_grid_view"></i>
                <span class="sideBox-item-name">Puntos y Memebresias</span>
            </a>
        </li>
        <?php endif;?>
         <?php if ($check['view_sales'] == 1):?>
        <li class="sideBox-item" data-toggle="tooltip" data-placement="right" title="Ventas">
            <a href="<?php echo base_url();?>doctor/sales_management/" <?php if ($page_name == 'sales_management' || $page_name == 'sales_insurance' || $page_name == 'new_sale' || $page_name == 'sales' || $page_name == 'sale_details'):?>class="currentPage" <?php endif;?>>
                <i class="iconBox picons-thin-icon-thin-0466_shopping_cart_basket_store_successful"></i>
                <span class="sideBox-item-name">Ventas</span>
            </a>
        </li>
         <?php endif;?>
        <?php  if ($details['financial'] == 1):?>
        <!-- <li class="sideBox-item" data-toggle="tooltip" data-placement="right" title="Finanzas">
            <a href="<?php echo base_url();?>doctor/financial/" <?php if ($page_name == 'financial'):?>class="currentPage" <?php endif;?>>
                <i class="iconBox picons-thin-icon-thin-0406_money_dollar_euro_currency_exchange_cash"></i>
                <span class="sideBox-item-name">Finanzas</span>
            </a>
        </li> -->
        <?php endif; if ($details['reports'] == 1):?>
        <!--<li class="sideBox-item" data-toggle="tooltip" data-placement="right" title="Reportes">
            <a href="<?php echo base_url();?>doctor/financial_reports/" <?php if ($page_name == 'reports' || $page_name == 'financial_reports' || $page_name == 'appointment_reports' || $page_name == 'inventory_reports'):?>class="currentPage" <?php endif;?>>
                <i class="iconBox picons-thin-icon-thin-0397_analytics_graph_line_statistics_presentation_keynote"></i>
                <span class="sideBox-item-name">Reportes</span>
            </a>
        </li>-->
        <?php endif; if ($details['accounting'] == 1):?>
        <li class="sideBox-item" data-toggle="tooltip" data-placement="right" title="Contabilidad">
            <a href="<?php echo base_url();?>doctor/accounting/" <?php if ($page_name == 'accounting' || $page_name == 'nomenclature' || $page_name == 'departures' || $page_name == 'departure' || $page_name == 'departure_edit' || $page_name == 'journal' || $page_name == 'ledger' || $page_name == 'balances' || $page_name == 'statement' || $page_name == 'general' || $page_name == 'sales_book' || $page_name == 'purchasing' || $page_name == 'bank_book' || $page_name == 'bank_conciliations' || $page_name == 'bank_conciliation' || $page_name == 'bank_conciliation_detail' || $page_name == 'cash_flows' || $page_name == 'cash_flow' || $page_name == 'cash_flow_detail' || $page_name == 'clients_book' || $page_name == 'adjust' || $page_name == 'adjust_departure' || $page_name == 'adjust_detail' || $page_name == 'closing' || $page_name == 'closing_departure' || $page_name == 'closing_detail' || $page_name == 'opening' || $page_name == 'opening_departure' || $page_name == 'opening_detail'):?>class="currentPage" <?php endif;?>>
                <i class="iconBox picons-thin-icon-thin-0016_bookmarks_reading_book"></i>
                <span class="sideBox-item-name">Contabilidad</span>
            </a>
        </li>
        <?php endif; if ($details['banks'] == 1):?>
        <li class="sideBox-item" data-toggle="tooltip" data-placement="right" title="Bancos">
            <a href="<?php echo base_url();?>doctor/bank_accounts/" <?php if ($page_name == 'bank_accounts' || $page_name == 'bank_checks' || $page_name == 'bank_transfers' || $page_name == 'account_types' || $page_name == 'currencies' || $page_name == 'banks'):?>class="currentPage" <?php endif;?>>
                <i class="iconBox picons-thin-icon-thin-0418_bank_pantheon"></i>
                <span class="sideBox-item-name">Bancos</span>
            </a>
        </li>
        <?php endif;  
        ?>
        <?php if ($check['view_laboratories'] == 1):?>
        <li class="sideBox-item" data-toggle="tooltip" data-placement="right" title="Laboratorios">
            <a href="<?php echo base_url();?>doctor/samples/" <?php if ($page_name == 'samples'|| $page_name == 'samples_new'  || $page_name == 'laboratory' || $page_name == 'laboratory'  ):?>class="currentPage" <?php endif;?>>
                <i class="iconBox picons-thin-icon-thin-0816_microscope_laboratory"></i>
                <span class="sideBox-item-name">Laboratorios</span>
            </a>
        </li>
        <?php endif;      
                if ($details['view_marketing'] == 1):?>
            <li class="sideBox-item" data-toggle="tooltip" data-placement="right" title="Marketing">
                <a href="<?php echo base_url();?>doctor/whatsapp/" <?php if ($page_name == 'whatsapp' ):?>class="currentPage" <?php endif;?>>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 1536 1600"><path fill="currentColor" d="M985 878q13 0 97.5 44t89.5 53q2 5 2 15q0 33-17 76q-16 39-71 65.5T984 1158q-57 0-190-62q-98-45-170-118T476 793q-72-107-71-194v-8q3-91 74-158q24-22 52-22q6 0 18 1.5t19 1.5q19 0 26.5 6.5T610 448q8 20 33 88t25 75q0 21-34.5 57.5T599 715q0 7 5 15q34 73 102 137q56 53 151 101q12 7 22 7q15 0 54-48.5t52-48.5zm-203 530q127 0 243.5-50t200.5-134t134-200.5t50-243.5t-50-243.5T1226 336t-200.5-134T782 152t-243.5 50T338 336T204 536.5T154 780q0 203 120 368l-79 233l242-77q158 104 345 104zm0-1382q153 0 292.5 60T1315 247t161 240.5t60 292.5t-60 292.5t-161 240.5t-240.5 161t-292.5 60q-195 0-365-94L0 1574l136-405Q28 991 28 780q0-153 60-292.5T249 247T489.5 86T782 26z"/></svg>
                    <span class="sideBox-item-name">Whatsapp</span>
                </a>
            </li>
            <?php endif;
              if ($details['settings'] == 1):?>
            <li class="sideBox-item" data-toggle="tooltip" data-placement="right" title="Configuración">
                <a href="<?php echo base_url();?>doctor/settings/" <?php if ($page_name == 'survey_results' || $page_name == 'question_board' || $page_name == 'questions' || $page_name == 'forms' || $page_name == 'confirmed' || $page_name == 'subscription' || $page_name == 'settings' || $page_name == 'specialties' || $page_name == 'laboratories' || $page_name == 'clinics' || $page_name == 'services' || $page_name == 'specialties' || $page_name == 'laboratories' || $page_name == 'surveys' || $page_name == 'thooth_procedures'):?>class="currentPage" <?php endif;?>>
                    <i class="iconBox picons-thin-icon-thin-0049_settings_panel_equalizer_preferences"></i>
                    <span class="sideBox-item-name">Configuración</span>
                </a>
            </li>
            <?php endif;?>
              <?php if ($check['shedule_appointments'] == 1):?>
        <li class="sideBox-item" data-toggle="tooltip" data-placement="right" title="Nueva cita">
            <a style="font-size:15px; padding-left: 20px; text-align:center;" href="<?php echo base_url();?>doctor/quote/">
                <div class="third-floated-btn new_app">
                    <i class="iconBox picons-thin-icon-thin-0825_stetoscope_doctor_hospital_ill" style="color:#fff"></i>
                </div>
            </a>
        </li>
          <?php endif; ?>
        <li class="sideBox-item"></li>
        <?php endforeach;?>
    </ul>
</aside>