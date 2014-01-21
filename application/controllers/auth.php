<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends CI_Controller
{
    private $message = null;
    private $data = null;
    private $status = null;

    public function __construct()
    {
        parent::__construct();
        $this->login();
    }

    public function login()
    {
        if ($this->input->is_ajax_request()) {
            $this->load->model('users');
            $username = $this->input->post('email');
            $password = $this->input->post('password');
            $userExist = $this->users->findUserByEmailAndPassword($username, $password);
            if ($userExist) {
                $this->status = 'success';
                $this->message = 'User exists';
                $this->data = $userExist;
            } else {
                $this->status = 'error';
                $this->message = 'User not exists';
                $this->data = $userExist;
            }
        } else {
            $this->status = 'error';
            $this->message = 'Request type not supported';
            $this->data = '';
        }
        echo $this->prepareResponse();
        exit;
    }

    public function logout()
    {

    }

    public function checkSession()
    {

    }

    public function prepareResponse()
    {
        $arr = array(
            'status' => $this->status,
            'statusCode' => '',
            'message' => $this->message,
            'data' => $this->data
        );
        return json_encode($arr);
    }
}
