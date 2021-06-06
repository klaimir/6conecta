<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * MY_Email Class
 *
 * Clase donde se ubican todas la inicialización del envío de email
 * 
 */
class MY_Email extends CI_Email
{
    function __construct()
    {
        parent::__construct();
    }

}
