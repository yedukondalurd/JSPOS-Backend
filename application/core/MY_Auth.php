<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class MY_Auth extends CI_Controller
{

    protected $current_user;
    protected $pageTitle;

    public function __construct()
    {
        parent::__construct();
        $this->checkLogin();
    }

    public function index()
    {
        echo 'Hello Madam';
        exit;
    }

    public function checkLogin()
    {
        $this->current_user = $this->session->userdata('user'); //Assigning session value to user property
        if (empty($this->current_user)) {
            $this->setLogin();
        } else {
            $this->moduleAccess($this->current_user);
            //checking wether the controller is login or others.
            //if it is login then it will automatically redirect to dashboard.
            if ($this->uri->segment(1) == 'login') {
                redirect('dashboard', 'refresh');
            }
        }
    }
}

?>