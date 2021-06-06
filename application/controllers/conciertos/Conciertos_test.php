<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'core/MY_Controller.php';

class Conciertos_test extends MY_Controller
{

    function __construct()
    {
        parent::__construct();

        // Secure the access
        $this->_security();

        $this->load->library('unit_test');
        
        $str = '
        <table border="0" cellpadding="4" cellspacing="1">
        {rows}
        <tr>
        <td>{item}</td>
        <td>{result}</td>
        </tr>
        {/rows}
        </table>';

        $this->unit->set_template($str);
        
        $this->load->model('Concierto_model');
    }

    function index()
    {
        // Realizamos test para insertar      
		$datos_concierto['nombre'] = 'Concierto prueba';
		$datos_concierto['fecha'] = '2021-01-01';
		$datos_concierto['id_recinto'] = 2;
		$datos_concierto['numero_espectadores'] = 1000;
		$datos_concierto['id_promotor'] = 2;
		$datos_concierto['grupos'] = array(1,2);
		$datos_concierto['medios_publicitarios'] = array(2,3);
        $id=$this->Concierto_model->registrar_concierto($datos_concierto);
        $datos_bd_insert=$this->Concierto_model->get_by_id($id);        
        $this->unit->run($datos_bd_insert->nombre, $datos_concierto['nombre'], 'Test de nombre al insertar');
        $this->unit->run($datos_bd_insert->numero_espectadores, $datos_concierto['numero_espectadores'], 'Test de numero_espectadores al insertar');
		$this->unit->run($datos_bd_insert->rentabilidad, 13700, 'Test de rentabilidad al insertar');

		// Prueba de info del email
		$info_email = $this->Concierto_model->get_datos_comunicacion_rentabilidad($id);
		var_dump($info_email);

		// Prueba de envío de email
		$this->load->library('conciertos/concierto_mail');
		$this->concierto_mail->send_comunicacion_rentabilidad($info_email);

        // The report will be formatted in an HTML table for viewing. If you prefer the raw data you can retrieve an array using:
        var_dump($this->unit->result());
    }

}
