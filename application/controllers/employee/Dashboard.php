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
    $where = array("is_new"=>1,"emp_id" => $this->session->userdata('id'));
    $data['new'] = $this->common_model->getWhere($where,'job_order');
    if($this->input->post())
    {
        $id = $this->input->get_post("id");
      $this->load->library("zip");
        $files =  json_decode(json_encode($this->common_model->getfilenames($id)),true);
      foreach ($files as $file) {
   
          $this->zip->read_file($file['file_name']);
      }
      $this->zip->download(time().".zip");
      redirect(base_url("employee/dashboard/new_job_orders"));
    }
     $this->load->view("employee/job_orders",$data);
 }
 public function pending_Job_orders($value='')
 {
    $data['title'] = "Employee Pending job Orders";
    $where = array("status"=>2,"emp_id"=>$this->session->userdata('id'),"is_new"=>0);
    $data['pending'] = $this->common_model->getWhere($where,'job_order');
    $where = array("active"=>1);
    $data['status'] = $this->common_model->getWhere($where,'status');

     $this->load->view("employee/pending_Job_orders",$data);
 }
 public function finished_job_orders($value='')
 {
    $data['title'] = "Employee Finished job Orders";
    $where = array("status"=>4,"emp_id"=>$this->session->userdata('id'));
    $data['finished'] = $this->common_model->getWhere($where,'job_order');
     $this->load->view("employee/finished_job_orders",$data);
 }
public function edit_job_order_deatails($value='')
             {
                 $j_id = $this->input->post('id');
                 $emp_id = $this->input->post('emp_id');
                 $notes = $this->input->post('notes');
                 $status = $this->input->post('status');
                 $where = array("id"=>$j_id);
                 $data = array("emp_id"=>$emp_id,"notes"=>$notes,"status"=>$status,"is_new"=>0,"last_updated"=>date('Y-m-d H:m:i'));
                 $this->common_model->updateWhere($where,$data,'job_order');
                 $data1 = array("j_id"=>$j_id,"emp_id"=>$emp_id,"notes"=>$notes,"status"=>$status,"date_added"=>date("Y-m-d H:m:i"));
                 $this->common_model->insertRow($data1,'extra_job_order');

                 $client_email = $this->common_model->getWhere(array('id'=>$j_id),'job_order');
                 $receive_email = $this->common_model->getWhere(array('id'=>$client_email[0]->client_id),'user');
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
                $this->email->to($receive_email[0]->email);
                $this->email->cc($emails);
                if($status==1)
                {
                $this->email->subject('Job Order Review '.date('Y-m-d'));
                $this->email->message("Dear ".$receive_email[0]->name.", <br> Job Order is Under Review, Please Follow Below Notes and Please confirm the job order is close <br>".$notes);
                } 
                if($this->email->send())
                {

                }
                else
                {
                    echo $this->email->print_debugger();
                    die;
                }
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
    public function download_files($value='')
    {
      $id = $this->input->get_post("id");
      
      $this->load->library("zip");
        $files =  json_decode(json_encode($this->common_model->getfilenames($id)),true);
      foreach ($files as $file) {
      //  echo $file['file_name'];
          $this->zip->read_file($file['file_name']);
      }
      //$this->zip->archive("/uploads/",time().".zip");
      $this->zip->download(time().".zip");

    }
  

 
 
  }
