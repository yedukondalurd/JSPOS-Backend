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
                $this->session->set_userdata('user', $userExist);
                $this->status = 'success';
                $this->message = 'User logged in successfully ';
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
        return $this->sendResponse();
    }

    public function logout()
    {
        if ($this->session->userdata('user')) {
            $this->session->unset_userdata('user');
        }
        $this->status = 'success';
        $this->message = 'user logged out successfully';
        $this->data = '';
        return $this->sendResponse();
    }

    public function checkSession()
    {
        if ($this->session->userdata('user')) {
            $this->status = 'success';
            $this->message = 'user session exists';
            $this->data = '';
        } else {
            $this->status = 'error';
            $this->message = 'user session expired';
            $this->data = '';
        }
        return $this->sendResponse();
    }

    private function sendResponse()
    {
        $arr = array(
            'status' => $this->status,
            'statusCode' => '',
            'message' => $this->message,
            'data' => $this->data
        );
        echo json_encode($arr);
        exit;
    }
}
