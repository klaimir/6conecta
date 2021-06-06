<?php

if (!defined('APPPATH'))
    exit('No direct script access allowed');

/**
 * Clase mailing concierto
 *
 * 
 */
class Concierto_mail
{

    protected $CI;

    function __construct()
    {
        $this->CI = & get_instance();
		$this->CI->load->library('email');

		// Esto código debería ejecutar dentro MY_Mail.php pero no lo está haciendo y lo dejo de manera provisional para que funcione
		$this->CI->load->config('email', TRUE);
		$email_config = $this->CI->config->item('email_config', 'email');
		$this->CI->email->initialize($email_config);
    }

	/**
     * Envía el email de comunicación de la rentabilidad
     *
     * @param [info]						Array con los datos para registrar un concierto:
	 * 		['nombre_promotor']
	 *  	['email_promotor']
	 *  	['nombre_recinto']
	 *  	['fecha_concierto']
	 *  	['nombre_concierto']
	 *  	['rentabilidad']
     *
     * @return Devuelve TRUE si ha enviado bien y FALSE en caso contrario
     */

    function send_comunicacion_rentabilidad($info)
    {
		$this->CI->email->clear();
		$this->CI->email->from($this->CI->config->item('admin_email', 'email'), $this->CI->config->item('site_title', 'email'));
		$this->CI->email->to($info['email_promotor']);
		$this->CI->email->subject($this->CI->config->item('site_title', 'email') . ' - Rentabilidad de concierto ' . $info['nombre_concierto']);
		$this->CI->email->message("Estimado " . $info['nombre_promotor'] . ", la rentabilidad del concierto del día " . $info['fecha_concierto'] . " en " . $info['nombre_recinto'] . " es de " . $info['rentabilidad']);
		return $this->CI->email->send();
    }

}
