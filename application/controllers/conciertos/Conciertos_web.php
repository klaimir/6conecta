<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'core/MY_Controller.php';

class Conciertos_web extends MY_Controller
{

    function __construct()
    {
        parent::__construct();

        // Secure the access
        $this->_security();		
    }

	public function index() {
		$this->data['message'] = 'Welcome conciertos web';
		$this->load->view('conciertos/welcome', $this->data);
	}
	/**
     * Crea un concierto
     *
     * @param [POST]						Array con los datos de la interfaz por POST compuesto de:
	 * @param 	['nombre']					Nombre del concierto.
	 * @param 	['fecha']					Fecha del concierto.
	 * @param 	['id_recinto']				Id del recinto en el que ha tenido lugar el concierto.
	 * @param 	['numero_espectadores']		Número de espectadores que asistieron al concierto.
	 * @param 	['id_promotor']				Id del promotor de la empresa encargado del concierto.
	 * @param 	['medios_publicitarios']	Array con ids de los medios publicitarios que cubrieron el concierto.
	 * @param 	['grupos']					Array con ids de los grupos que actuaron en el concierto.
     *
     * @return Devuelve un texto de errores formateado
     */
	// Sin usar librería de concierto
    public function create()
    {
		// Aquí habría una lógica para validar los datos y adaptarlos a la bd, como el cambio del formato de la fecha, 
		// pero suponemos la información correcta y ya adaptada

		// Registramos los datos
		$this->load->model('Concierto_model');		
		$id = $this->Concierto_model->registrar_concierto($this->input->post());
		// Envío de email
		if ($id) {
			$this->load->library('conciertos/concierto_mail');
			if($this->concierto_mail->send_comunicacion_rentabilidad($this->Concierto_model->get_datos_comunicacion_rentabilidad($id))) {
				$this->data['message'] = 'Se ha registrado el concierto y enviado el email';
			} else {
				$this->data['message'] = 'Se ha registrado el concierto y pero ha habido un error al enviar el email';
			}				
		} else {
			$this->data['message'] = $this->Concierto_model->get_error();
		}	
		// Salida
		$this->load->view('conciertos/welcome', $this->data);
    }

   
}
