<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends MY_Auth
{
    public function __construct()
    {
        parent::__construct();
    }

    public function login()
    {
        $this->load->view('welcome_message');
    }
}
