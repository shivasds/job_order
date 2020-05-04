<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Dashboard extends CI_Controller {

	function __construct(){
        /* Session Checking Start*/
        parent::__construct();  
        $this->load->model('login_model'); 
        if (!$this->session->userdata('is_loggedin')) {
            redirect(base_url());
        }   
        if ($this->session->userdata('is_loggedin')) {
            $user_type = $this->session->userdata('user_type');
            if($user_type==1)
            redirect(base_url("admin/dashboard"));
            if($user_type==3)
            redirect(base_url("client/dashboard"));
        } 
    }
 public function index($value='')
 {
    $data["title"] = "Employee";
   $this->load->view('employee/dashboard',$data);
 }
 public function new_Job_orders($value='')
 {
    $data['title'] = "Employee New job Orders";
     $this->load->view("employee/new_job_orders",$data);
 }
 public function pending_Job_orders($value='')
 {
    $data['title'] = "Employee Pending job Orders";
     $this->load->view("employee/pending_Job_orders",$data);
 }
 public function finished_job_orders($value='')
 {
    $data['title'] = "Employee Finished job Orders";
     $this->load->view("employee/finished_job_orders",$data);
 }

	 
 
 
  }
