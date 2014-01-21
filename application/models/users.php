<?php

/**
 * Created by PhpStorm.
 * User: yedukondalu.v
 * Date: 1/21/14
 * Time: 12:41 PM
 */
class Users extends CI_Model
{
    public function __construct()
    {

    }

    public function findUserByEmailAndPassword($email, $password)
    {
        $query = "select * from users where email=? and password=?";
        $arr = array($email, md5($password));
        $result = $this->db->query($query, $arr);
        return $result->result_array();
    }
}