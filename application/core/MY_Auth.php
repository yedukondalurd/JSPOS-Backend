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
        //$this->checkLogin();
    }

    public function index()
    {
        echo 'Hello Madam';
        exit;
    }

    public function login()
    {
        $username = $this->input->post('retail_store_username');
        $password = $this->input->post('retail_store_password');
        $arr = array('username' => $username, 'password' => $password);
        echo json_encode($arr);
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

    public function setLogin()
    {
        //Assign values to short variable.
        $username = $this->input->post('retail_store_username');
        $password = $this->input->post('retail_store_password');

        if ($username && $password) {

            //Loding user model..
            $this->load->model('User_model');
            //returning user
            $userExists = $this->User_model->checkUserForLogin($username, $password);
            //If user not exists return to login..
            if (!$userExists) {
                //assigning post values to data to reproduce the form field values....
                $data['return_username'] = $username;
                $data['return_password'] = $password;
                $data['login_error'] = lang('login_incorrect');
                $this->load->view('modules/login/login', $data);
                die($this->output->get_output());
            } else {
                $this->session->set_userdata('user', $userExists);
                if ($this->uri->segment(1) == 'login') {
                    redirect('dashboard', 'refresh');
                } else {
                    redirect($this->uri->uri_string(), 'refresh');
                }
            }
        } else {
            $this->load->view('modules/login/login');
            die($this->output->get_output());
        }
    }

    public function logout()
    {
        //Checking session exist or not and redirecting to login page....
        if ($this->session->userdata('user')) {
            $this->session->unset_userdata('user');
        }
    }
}

?>