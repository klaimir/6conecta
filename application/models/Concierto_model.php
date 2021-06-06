<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'core/MY_Model.php';

class Concierto_model extends MY_Model
{

    public function __construct()
    {
        parent::__construct();

        $this->table = 'conciertos';
        $this->primary_key = 'id';

        $this->has_many['grupos'] = array('local_key' => 'id_concierto', 'foreign_key' => 'id', 'foreign_model' => 'Grupo_model');
        $this->has_one['promotor'] = array('local_key' => 'id_promotor', 'foreign_key' => 'id', 'foreign_model' => 'Promotor_model');
		$this->has_one['recinto'] = array('local_key' => 'id_recinto', 'foreign_key' => 'id', 'foreign_model' => 'Recinto_model');
    }

    /**
     * Crea un concierto
     *
     * @param [datosEntrada]				Array con los datos para registrar un concierto:
	 * @param 	['nombre']					Nombre del concierto.
	 * @param 	['fecha']					Fecha del concierto.
	 * @param 	['id_recinto']				Id del recinto en el que ha tenido lugar el concierto.
	 * @param 	['numero_espectadores']		Número de espectadores que asistieron al concierto.
	 * @param 	['id_promotor']				Id del promotor de la empresa encargado del concierto.
	 * @param 	['medios_publicitarios']	Array con ids de los medios publicitarios que cubrieron el concierto.
	 * @param 	['grupos']					Array con ids de los grupos que actuaron en el concierto.
     *
     * @return Devuelve el identificador del nuevo concierto
     */
	// Sé que esta no es la mejor estrategia para resolverlo pero tb quiero dejar plasmado cual era mi forma de trabajar
	// hasta la fecha. Un posible buena solución sería:
	// 1) Creando entidades agnósticas en una carpeta entity que modelaran todo el dominio de la app.
	// 2) Usar el framework sólo para crear los objetos cuando hiciera falta de forma que les asignemos responsabilidades
	// que contengan la lógica de negocio.
	// 3) Usar estos objetos por ejemplo para realizar acciones, por ejemplo registrar concierto o el envío del email
	// Así no tendríamos que recoger todos los datos varias veces y sería más fácil de testear, estaría totalmente desacoplado
	// del framework (algo muy importante) más comprensible, etc.
    function registrar_concierto($datos_entrada)
    {
		// Datos de concierto
		$datos_concierto['nombre'] = $datos_entrada['nombre'];
		$datos_concierto['fecha'] = $datos_entrada['fecha'];
		$datos_concierto['id_recinto'] = $datos_entrada['id_recinto'];
		$datos_concierto['numero_espectadores'] = $datos_entrada['numero_espectadores'];
		$datos_concierto['id_promotor'] = $datos_entrada['id_promotor'];
		// Calculamos rentabilidad con el resto de datos
		$datos_concierto['rentabilidad'] = $this->calcular_rentabilidad($datos_concierto['numero_espectadores'], $datos_concierto['id_recinto'], $datos_entrada['grupos']);
        // Insertamos info del concierto en bd
        $id = $this->insert($datos_concierto);
        if ($id)
        {
            $this->asignar_grupos($id, $datos_entrada['grupos']);
			$this->asignar_medios_publicitarios($id, $datos_entrada['medios_publicitarios']);
            return $id;
        }
        else
        {
            $this->set_error('Ha ocurrido un error al registrar el inmueble');
            return FALSE;
        }
    }

	/**
     * Crea un concierto
     *	 
	 * @param 	['numero_espectadores']		Número de espectadores que asistieron al concierto.
	 * @param 	['id_recinto']				Id del recinto en el que ha tenido lugar el concierto.
	 * @param 	['grupos']					Array con ids de los grupos que actuaron en el concierto.
     *
     * @return Devuelve la rentabilidad
     */
	// Al menos así se puede reutilizar sin tener registrado el concierto
    function calcular_rentabilidad($numero_espectadores, $id_recinto, $grupos)
    {
		$this->load->model('recinto_model');
		// Ingresos
		$datos_recinto = $this->recinto_model->get_by_id($id_recinto);
		$ingresos = $numero_espectadores * $datos_recinto->precio_entrada;
		// Costes
		$costes_grupos = $this->calcular_costes_grupos($grupos, $ingresos);
		$costes = $datos_recinto->coste_alquiler + $costes_grupos;
		// Rentabilidad
		return $ingresos - $costes;
    }

	/**
     * Calcula el coste como de los diferentes grupos de un concierto
     *
	 * @param 	['ingresos_concierto']		ingresos del concierto.
	 * @param 	['grupos']					Array con ids de los grupos que actuaron en el concierto.
     *
     * @return Devuelve el coste de los grupos
     */
    private function calcular_costes_grupos($grupos, $ingresos_concierto)
    {
		$total_costes = 0;
		$this->load->model('grupo_model');
		foreach ($grupos as $id_grupo) {
			$datos_grupo = $this->grupo_model->get_by_id($id_grupo);
			$total_costes += $datos_grupo->cache + (0.1 * $ingresos_concierto);
		}
		return $total_costes;
    }

	// Podríamos usar insert_batch para optimizar tb
    function asignar_grupos($id_concierto, $grupos)
    {
		foreach ($grupos as $id_grupo) {
			$data = array(
				'id_grupo' => $id_grupo,
				'id_concierto' => $id_concierto
			);
			$this->db->insert('grupos_conciertos', $data);
		}		
    }

	function asignar_medios_publicitarios($id_concierto, $medios_publicitarios)
    {
		foreach ($medios_publicitarios as $id_medio) {
			$data = array(
				'id_medio' => $id_medio,
				'id_concierto' => $id_concierto
			);
			$this->db->insert('medios_conciertos', $data);
		}		
    }

	/**
     * Calcula los datos necesarios para para la comunicación del email de rentabilidad
     *
     * @param [id]					Id. del concierto
     *
     * @return [info]						Array con los datos
	 *  	['nombre_promotor']
	 *  	['email_promotor']
	 *  	['nombre_recinto']
	 *  	['fecha_concierto']
	 *  	['nombre_concierto']
	 *  	['rentabilidad']
     */
	function get_datos_comunicacion_rentabilidad($id) {
		$datos_concierto = $this->get_by_id($id);
		$this->load->model('recinto_model');
		$datos_recinto = $this->recinto_model->get_by_id($datos_concierto->id_recinto);
		$this->load->model('promotor_model');
		$datos_promotor = $this->promotor_model->get_by_id($datos_concierto->id_promotor);
		return array(
			'nombre_promotor' => $datos_promotor->nombre,
			'email_promotor' => $datos_promotor->email,
			'nombre_recinto' => $datos_recinto->nombre,
			'fecha_concierto' => $datos_concierto->fecha,
			'nombre_concierto' => $datos_concierto->nombre,
			'rentabilidad' => $datos_concierto->rentabilidad
		);
	}

}
