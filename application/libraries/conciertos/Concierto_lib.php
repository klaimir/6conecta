<?php

if (!defined('APPPATH'))
    exit('No direct script access allowed');

/**
 * Librería de concierto
 *
 * El objetivo de esta clase es servir de fachada entre el controlador y los modelos de forma que aglutinen toda la lógica
 * determinadas acciones. Su principal utilidad es por reutilización entre diferentes controladores. Es totalmente opcional.
 * Si no la tuviéramos tendríamos que repetir código en cada controlador para esta misma lógica o bien incluir dentro del
 * modelo el envío del email cuando lo que queremos es que la capa de modelo tenga sólo la lógica para interactuar con la bd
 * así como la lógica de negocio.
 * 
 */
class Concierto_lib
{

    protected $CI;
	private $message;

    function __construct()
    {
        $this->CI = & get_instance();
		$this->CI->load->model('Concierto_model');
    }

	function get_message() {
		return $this->message;
	}

	function set_message($message) {
		$this->message = $message;
	}

    function create_user($data)
    {
		// Podríamos incluir aquí una validación personalizada siguiendo las mismas directrices que se han hecho para
		// personalizar el envío de emails si se cree útil

		// Insertar los datos en bd
		$id = $this->CI->Concierto_model->registrar_concierto($data);
		// Envío de email
		if ($id) {
			$this->CI->load->library('conciertos/concierto_mail');
			if($this->CI->concierto_mail->send_comunicacion_rentabilidad($this->CI->Concierto_model->get_datos_comunicacion_rentabilidad($id))) {
				$this->set_message('Se ha registrado el concierto y enviado el email');
			} else {
				$this->set_message('Se ha registrado el concierto y pero ha habido un error al enviar el email');
			}				
		} else {
			$this->set_message($this->Concierto_model->get_error());
		}
		return $id;
    }

}
