<?php

/**
 * When first error is log class send email to admin.
 * 
 * @author	Michał Myśliński
 * 
 * @file MY_Exceptions.php
 */

 /**
 * MY_Log class.
 *
 * @extends MY_Exceptions
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Exceptions extends CI_Exceptions {

	function log_exception($severity, $message, $filepath, $line)
	{

		$ci =& get_instance();

		
		$ci->config->load('email_errors');

		$_email_errors_active = $ci->config->item('email_errors_active');

		if ($_email_errors_active===true) {

			$ci->load->library('email');

			$_conf_log_path = $ci->config->item('log_path');
			$_conf_log_file_extension = $ci->config->item('log_file_extension');


			$_log_path = ($_conf_log_path !== '') ? $_conf_log_path : APPPATH.'logs/';
			$_file_ext = (isset($_conf_log_file_extension) && $_conf_log_file_extension !== '') ? ltrim(_conf_log_file_extension, '.') : 'php';

			$_filepath = $_log_path.'log-'.date('Y-m-d').'.'.$_file_ext;
			

			if ( ! file_exists($_filepath)) {

				$_config['protocol'] = 'smtp';
				$_config['smtp_host'] = $ci->config->item('smtp_host');
				$_config['smtp_user'] = $ci->config->item('smtp_user');
				$_config['smtp_pass'] = $ci->config->item('smtp_pass');
				$_config['smtp_port'] = $ci->config->item('smtp_port');
				$_config['smtp_crypto'] = $ci->config->item('smtp_crypto');
				$_config['smtp_keepalive'] = $ci->config->item('smtp_keepalive');
				$_config['smtp_timeout'] = $ci->config->item('smtp_timeout');
				$_config['priority'] = $ci->config->item('priority');

				$ci->email->initialize($_config);

				$ci->email->from($ci->config->item('email_errors_from'), $ci->config->item('email_errors_name'));
				$ci->email->to($ci->config->item('email_errors_to'));
				$ci->email->subject($ci->config->item('email_errors_subject'));

			}

			$ci->email->message($severity.' '.$message.' '.$filepath.' '.$line);

			if ( ! $ci->email->send()) {
				$_err_mess =  strip_tags($ci->email->print_debugger(array('headers')));
				parent::log_exception($severity, $_err_mess, $filepath, $line);
			} else {
				parent::log_exception($severity, 'Admin error email was send.', $filepath, $line);
			}

			
		}


		parent::log_exception($severity, $message, $filepath, $line);

	}

}
