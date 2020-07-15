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
    
    if($this->session->userdata('username')=='admin')
    { 
      $data['title'] = "Dashboard";
   $this->load->view("admin/dashboard",$data);
 }
 else
 {
  //$this->new_Job_orders();
  redirect('admin/dashboard/new_Job_orders');
 }
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
        $query=$this->common_model->duplicate_check('emails',$code);
        $data = array(
          'count' =>$query
        );
        header('Content-Type: application/json');
        echo json_encode($data);
    }
     public function check_email(){
        $code=$this->input->post('code');
        $query=$this->common_model->duplicate_check_email('emails',$code);
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
    function change_status_mail(){
        $id=$this->input->post('id');
        $newStatus = $this->common_model->toggle_status('emails',$id);
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
               // $where = array("is_new"=>1,"emp_id" => 0);
               // $data['new'] = $this->common_model->getWhere($where,'job_order');
                 $data['new'] = $this->common_model->new_Job_orders('job_order');
                $where1= array("type"=>2);
                $data['emp'] = $this->common_model->getWhere($where1,'user');
                 $this->load->view("admin/job_orders",$data);
             }
             public function pending_Job_orders($value='')
             {
                $data['title'] = "Admin Pending job Orders";
                $where = array("status= 1 or status = 2 or status = "=>5);
                // $data['pending'] = $this->common_model->getWhere($where,'job_order');
                $data['pending'] = $this->common_model->pending_Job_orders_admin($where,'job_order');
             
                 $this->load->view("admin/pending_Job_orders",$data);
             }
             public function finished_job_orders($value='')
             {
                $data['title'] = "Admin Finished job Orders";
                // $where = array("status"=>4);
                // $data['finished'] = $this->common_model->getWhere($where,'job_order');
                 $where = array("status"=>4);
                $data['finished'] = $this->common_model->finished_Job_orders_admin($where,'job_order');
                 $this->load->view("admin/finished_job_orders",$data);
             }


             public function edit_job_order_deatails($value='')
             {
                 $j_id = $this->input->get_post('id');
                 $emp_id = $this->input->get_post('emp_id');
                 $notes = $this->input->get_post('notes');
                 $emp_details = $this->common_model->getWhere(array('id'=>$emp_id),'user');
                 $client_id = $this->common_model->getWhere(array('id'=>$j_id),'job_order');
                $client_details = $this->common_model->getWhere(array('id'=>$client_id[0]->client_id),'user');
                 //print_r($client_details[0]->name);die;
                 $this->load->library('email');
            
                $this->email->initialize(email_config());

                $where = array("active"=>1); 

                $to_emails = $this->common_model->getWhere($where,'emails');
                $emails ='';
                foreach ($to_emails as $email) {
                   $emails .= $email->email.",";
                }
                $emails = rtrim($emails, ','); 
                 
                $this->email->from($this->session->userdata('email'),$this->session->userdata('name'));
                $this->email->to($client_details[0]->email.",shiva@secondsdigital.com");
                $this->email->cc($emails);

                $this->email->subject('Job Order Approved ans Assigned on '.date('Y-m-d'));
                $this->email->message("Dear ".$client_details[0]->name.",<br> Your New Job Order Approved and assigned to ".$emp_details[0]->name." Mobile : ".$emp_details[0]->mobile);
                if($this->email->send())
                {
                  $this->email->from($this->session->userdata('email'),$this->session->userdata('name'));
                $this->email->to($emp_details[0]->email);
                $this->email->cc($emails);

                $this->email->subject('New Job Order Assigned on '.date('Y-m-d'));
                $this->email->message("Dear ".$emp_details[0]->name.",<br> Your New Job Order is assigned! Please Follow with below notes! <br> ".$notes);
                $this->email->send();
                }
                else
                {
                    echo $this->email->print_debugger();
                    //die;
                } 
                 $where = array("id"=>$j_id);
                 //$data = array("emp_id"=>$emp_id,"notes"=>$notes);
                 $data = array("emp_id"=>$emp_id);
                 $this->common_model->updateWhere($where,$data,'job_order');
                 $data1 = array("j_id"=>$j_id,"emp_id"=>$this->session->userdata('id'),"notes"=>$notes,"status"=>2,"date_added"=>date("Y-m-d H:m:i"));
                 $this->common_model->insertRow($data1,'extra_job_order');
             }
               public function emails($value='')
                {
                $data['title'] = "Mails"; 
                $data['emails'] = $this->common_model->getAll('emails');
                if($this->input->post())
                {
                    $data = array("email"=>$this->input->post('email'));
                    $bool = $this->common_model->insertRow($data,'emails');
                    if($bool)
                    {
                        $this->session->set_flashdata('success', 'Email Added Successfully');
                        redirect(base_url('admin/dashboard/emails'));
                    }
                    else
                    {
                        $this->session->set_flashdata('error', 'Email Adding Failed');
                        redirect(base_url('admin/dashboard/emails'));
                    }
                }
                $this->load->view("admin/emails",$data);
                }
                public function get_job_order_details($value='')
    {
      $id = $this->input->get_post("id");
      $indiv_callback_data = $this->common_model->get_JO_data($id); 
        $previous_callback = "";
        foreach ($indiv_callback_data as $callback_data) {
            $previous_callback .= $callback_data->status."****".$callback_data->date_added."****".$callback_data->user_name;
            $previous_callback .= "\n---------------------------------\n";
           $previous_callback .= $callback_data->notes."\n\n";
        }
        $data['previous_callback'] = $previous_callback;
        print_r($data['previous_callback']);

    }
 
  }
