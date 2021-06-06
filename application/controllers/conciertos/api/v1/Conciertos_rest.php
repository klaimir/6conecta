<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'core/MY_Controller.php';

// Heredaría realmente de MY_REST_Controller pero CI 3 no contiene nativamente una librería para servicios REST y la que
// usaba para este propósito está obsoleta en PHP 7.4. Pero vamos que creo que se entiende como funcionaría :)
class Conciertos_rest extends MY_Controller
{

    function __construct()
    {
        parent::__construct();

        // Secure the access
        $this->_security();		
    }

	Usando librería de concierto
    public function create()
    {
		$this->load->library('conciertos/concierto_lib');
		$this->concierto_lib->create_user($this->input->post());		
		$this->data['message'] = $this->concierto_lib->get_message();
		echo json_encode($this->data);
    }

   
}
