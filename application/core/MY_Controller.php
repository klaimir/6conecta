<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_controller
{
    
    public function __construct()
    {
        parent::__construct();
        
        // Mantenimiento        
        if ($this->config->item('mantenimiento'))
        {
            redirect(site_url('auth/mantenimiento'), 'refresh');
            return;
        }
        // Enable profiler if ENVIRONMENT is development or staging
        if(ENVIRONMENT=='development' || ENVIRONMENT=='staging')
        {
            $this->output->enable_profiler(TRUE);
        }
    }

    protected function _security()
    {
        return TRUE;
        // logged
        /*
        if (!$this->ion_auth->logged_in())
        {
            redirect(site_url('auth/logout'), 'refresh');
        }
        */
    }

    protected function is_post()
    {
        return $_SERVER['REQUEST_METHOD'] == 'POST' ? TRUE : FALSE;
    }

}
