<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	function __construct(){
        /* Session Checking Start*/
        parent::__construct();  
        $this->load->model("Login_model");
        if ($this->session->userdata('is_loggedin')) {
            $user_type = $this->session->userdata('user_type');
            if($user_type==1)
            redirect(base_url("admin/dashboard"));
            elseif($user_type==2)
            redirect(base_url("employee/dashboard"));
            else
            redirect(base_url("client/dashboard"));
        } 
    }

	public function index() {
    $data['title'] = "Login";
    if($this->input->post())
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $type_array=$this->Login_model->get_user_type($username);
        $user_type=$type_array['type'];
        if($user_type)
        {
        $data = $this->Login_model->user_login($username,$password,$user_type);
        if(!$data)
        {
            $this->session->set_flashdata('error', 'User Id or Password Incorrect');
            redirect(base_url());
        }
        else
        {
            $this->session->set_userdata(json_decode(json_encode($data),true));
            $this->session->set_userdata('is_loggedin',true);
            $this->session->set_userdata('user_type',$user_type);
            if($user_type==1)
            redirect(base_url("admin/dashboard"));
            elseif($user_type==2)
            redirect(base_url("employee/dashboard"));
            else
            redirect(base_url("client/dashboard"));
        }
        }
        else
        {
          $this->session->set_flashdata('error', 'User Does not exist');  
          redirect(base_url());
        }

    }
    $this->load->view('login',$data);
    }

     function logout() {
        $this->session->sess_destroy();
        $this->session->unset_userdata('is_loggedin');
            redirect(base_url().'login');
            
    }
     
}
