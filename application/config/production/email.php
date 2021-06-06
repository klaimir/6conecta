<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config['site_title']                 = "6conecta";           // Site Title, example.com
$config['admin_email']                = "adminemail@gmail.com"; // Admin Email, admin@example.com

$config['email_config'] = Array(
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.googlemail.com',
            'smtp_port' => 465,
            'smtp_user' => 'tuemail@gmail.com',
            'smtp_pass' => 'tuclave',
            'mailtype' => 'html',
            'charset' => 'UTF-8',
            'newline' => "\r\n"
        );
