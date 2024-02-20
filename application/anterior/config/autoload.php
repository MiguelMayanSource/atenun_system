<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    $autoload['packages'] = array();
    $autoload['libraries'] = array('pagination', 'xmlrpc' , 'form_validation', 'email','upload');
    $autoload['drivers'] = array();
    $autoload['helper'] = array('url','file','form','security','string','inflector','directory','download','multi_language');
    $autoload['config'] = array();
    $autoload['language'] = array();
    $autoload['model'] = array('crud_model', 'accounts_model', 'appointment_model', 'chat_model', 'notify_model', 'log_model', 'whatsapp', 'security_model', 'tables_model','pdf_model','print_model','inventory_model','fel','crud_samples','crud_services','email_model');