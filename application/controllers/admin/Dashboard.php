<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Dashboard extends CI_Controller {

	function __construct(){
        /* Session Checking Start*/
        parent::__construct();  
        $this->load->model('login_model'); 
        $this->load->model('common_model'); 
        if (!$this->session->userdata('is_loggedin')) {
            redirect(base_url());
        }   
        if ($this->session->userdata('is_loggedin')) {
            $user_type = $this->session->userdata('user_type');
             if($user_type==2)
            redirect(base_url("employee/dashboard"));
            if($user_type==3)
            redirect(base_url("client/dashboard"));
        } 
    }
 public function index($value='')
 {
    $data['title'] = "Dashboard";
   $this->load->view("admin/dashboard",$data);
 }
 public function employees($value='')
 {
    $data['title'] = "Employees";
    $where = array("active"=>1);
    $data['cities'] = $this->common_model->getWhere($where,'city');
    $where = array("active"=>1,"type"=>'2');
    $data['all_user'] = $this->common_model->getWhere($where,'user');
    if($this->input->post())
    {
        $data = $this->input->post();
        $data1 = array(
            "password" =>md5($data['username']),
            "type"=>2,
            "date_created"=>date('Y-m-d H:s:i'),
        );
        $data = array_merge($data,$data1);
        $bool = $this->common_model->insertRow($data,'user');
        if($bool)
        {
            $this->session->set_flashdata('success', 'Employee Added Successfully');
            redirect(base_url('admin/dashboard/employees'));
        }
        else
        {
            $this->session->set_flashdata('error', 'Employee Adding Failed');
            redirect(base_url('admin/dashboard/employees'));
        }

    }
   $this->load->view("admin/employees",$data);
 }
 public function check_user(){
        $code=$this->input->post('code');
        $query=$this->common_model->duplicate_check('user',$code);
        $data = array(
          'count' =>$query
        );
        header('Content-Type: application/json');
        echo json_encode($data);
    }
    function change_status_user(){
        $id=$this->input->post('id');
        $newStatus = $this->common_model->toggle_status('user',$id);
        $data = array(
            'id' => $id,
            'active' => $newStatus
        );
        header('Content-Type: application/json');
        echo json_encode($data);
    }
    public function reset_password($id) {
        $this->common_model->reset_password($id);
        $data = array(
          'status' => true
        );
        header('Content-Type: application/json');
        echo json_encode($data);
    }
     public function clients($value='')
     {
        $data['title'] = "Clients";
        $where = array("active"=>1);
        $data['cities'] = $this->common_model->getWhere($where,'city');
        $where = array("active"=>1,"type"=>'3');
        $data['all_user'] = $this->common_model->getWhere($where,'user');
        // echo $this->db->last_query();
        //  print_r($data);die  ;
        if($this->input->post())
        {
            $data = $this->input->post();
            $data1 = array(
                "password" =>md5($data['username']),
                "type"=>3,
                "date_created"=>date('Y-m-d H:s:i'),
            );
            $data = array_merge($data,$data1);
         
            $bool = $this->common_model->insertRow($data,'user');
            if($bool)
            {
                $this->session->set_flashdata('success', 'Client Added Successfully');
                redirect(base_url('admin/dashboard/clients'));
            }
            else
            {
                $this->session->set_flashdata('error', 'Client Adding Failed');
                redirect(base_url('admin/dashboard/clients'));
            }

        }
       $this->load->view("admin/clients",$data);
     }
                public function new_Job_orders($value='')
             {
                $data['title'] = "Admin New job Orders";
                 $this->load->view("admin/new_job_orders",$data);
             }
             public function pending_Job_orders($value='')
             {
                $data['title'] = "Admin Pending job Orders";
                 $this->load->view("admin/pending_Job_orders",$data);
             }
             public function finished_job_orders($value='')
             {
                $data['title'] = "Admin Finished job Orders";
                 $this->load->view("admin/finished_job_orders",$data);
             }
 
  }
