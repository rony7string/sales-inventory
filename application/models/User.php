<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');


/*
 *	@author : Ifty Ron
*	http://iftyron.com
 *  version: 1.0
 */

class User extends CI_Model
{

    function index()
    {

    }

    // auth login
    public function AuthLogin($email, $password)
    {
        $pass = sha1(md5($password));
        // echo $pass;

        //$pass = sha1($password);
        $this->db->select("*");
        $this->db->from('usr_user');
        $this->db->where('USER_NAME', $email);
        $this->db->where('U_PASSWORD', $pass);
        $this->db->where('IS_ACTIVE', '1');
        $query = $this->db->get();
        // echo $this->db->last_query();
        return $query->first_row('array');
    }

    //logout
    public function logout()
    {

        $this->session->sess_destroy();

        redirect(base_url());
    }

    //users list
    public function usersList()
    {
        $this->db->select("*");
        $this->db->from("usr_user as u, usr_group as g");
        $this->db->where("u.GROUP_ID = g.GROUP_ID");
        $query = $this->db->get();
        return $query->result();
    }

}

?>
