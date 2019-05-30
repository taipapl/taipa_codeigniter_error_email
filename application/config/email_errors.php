<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *  When first error is log class send email to admin.
 *
 * @author Michał Myśliński
 *
 * @file email_errors.php
 */

// to enable, set this to true
$config['email_errors_active'] = true;

$config['email_errors_from'] = 'noreply_mail@mail.com';
$config['email_errors_name'] = 'Admin';
$config['email_errors_to'] = 'you_mail@mail.com';
$config['email_errors_subject'] = 'This is admin error email from system';

//smtp config
$config['mailtype'] = 'html';
$config['protocol'] = 'smtp';
$config['charset'] = 'utf-8';
$config['wordwrap'] = TRUE;
$config['smtp_host'] = 'you_host.host.com';
$config['smtp_user'] =	'noreply_mail@mail.com';
$config['smtp_pass'] =	'you_password';
$config['smtp_port'] = 'you_port_number';
$config['smtp_crypto'] = 'ssl'; // tls or ssl
$config['smtp_keepalive'] = true;
$config['smtp_timeout'] = '5';
$config['priority'] = 2;
