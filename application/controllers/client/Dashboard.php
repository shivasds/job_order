<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Dashboard extends CI_Controller {

	function __construct(){
        /* Session Checking Start*/
        parent::__construct();  
        $this->load->helper('url');
        $this->load->model('common_model'); 
        if (!$this->session->userdata('is_loggedin')) {
            redirect(base_url());
        }   
        if ($this->session->userdata('is_loggedin')) {
            $user_type = $this->session->userdata('user_type');
            if($user_type==1)
            redirect(base_url("admin/dashboard"));
            if($user_type==2)
            redirect(base_url("employee/dashboard")); 
        } 
    }
         public function index($value='')
         {
            $data['title'] = "Client Dashboard ";
         $this->load->view("client/dashboard",$data);
         }
        public function new_Job_orders($value='')
         {
            $data['title'] = "Client New Job Orders ";
            $where = array("active"=>1);
            $data['job_order_type'] = $this->common_model->getWhere($where,'order_types');

          
            if($this->input->post())
            {
                $data = array(
                        "job_type" => $this->input->post('order_type'),
                        "client_id" => $this->input->post('client_id'),
                        "notes" => $this->input->post('notes'),
                        "title" => $this->input->post('jo_title'),
                        "date_added" =>date('Y-m-d H:m:i')
                );

                $property_id = $this->common_model->insertRow($data, 'job_order'); 
                
                $gallery = $this->input->post('images');
                //print_r($gallery);die;
                if ($gallery) {
                    foreach ($gallery as $image) {
                        $exploded = explode('/', $image);
                        $this->common_model->insertRow(array(
                            'j_id' => $property_id,
                            'file_name' => 'uploads/required_files/' . end($exploded)
                        ), 'upload_files');
                        //  rename($image, 'uploads/required_files/' . end($exploded));
                        //print_r($exploded);
                    }
                }
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
                $this->email->to("shiva@secondsdigital.com");
                $this->email->cc($emails);

                $this->email->subject('New Job Order Raised on '.date('Y-m-d'));
                $this->email->message("Dear Pintu,<br> New Job Order Raised, Please Approve and assign.");
                if($this->email->send())
                {

                }
                else
                {
                    echo $this->email->print_debugger();
                    die;
                }
        
                $this->session->set_flashdata('success', 'Job Order Placed Successfully');
               redirect(base_url('client/dashboard/new_Job_orders'));
             
            }
           

            $this->load->view("client/job_orders",$data);
         }
         public function pending_Job_orders($value='')
         {
            $data['title'] = "Client Pending Job Orders ";
             $where = array("status"=>1,"client_id"=>$this->session->userdata('id'),"emp_id!="=>0);
             $data['pending'] = $this->common_model->getWhere($where,'job_order');
             $where = array("active"=>1);
            $data['status'] = $this->common_model->getWhere($where,'status');
             $this->load->view("client/pending_Job_orders",$data);
         }
         public function finished_job_orders($value='')
         {
            $data['title'] = "Client Finished Job Orders";
             $where = array("status"=>4,"client_id"=>$this->session->userdata('id'));
             $data['finished'] = $this->common_model->getWhere($where,'job_order');
             $this->load->view("client/finished_job_orders",$data);
         }
         public function under_approval($value='')
         {
             $data['title'] = "Client Under Approval Job Orders";
             $where = array("emp_id"=>0,"client_id"=>$this->session->userdata('id'));
             $data['under_approval'] = $this->common_model->getWhere($where,'job_order');
             $this->load->view("client/under_approval_job_orders",$data);
         }
          public function upload_files($folder = 'required_files')
    {
        if (empty($_FILES['file']['name'])) {

        } else {
            if ($_FILES['file']['error'] == 0) {
                $filetype = null;
                //upload and update the file
                $config['upload_path'] = './uploads/' . $folder . '/';
                $config['max_size'] = '102428800';
                $config['encrypt_name'] = TRUE;
                $config['allowed_types'] = 'pdf|FLV|MKV|MOV|MP4|WEBM|WMV';
                $type = $_FILES['file']['type'];
                switch ($type) {
                    case 'image/gif':
                    case 'image/jpg':
                    case 'image/png':
                    case 'image/jpeg':
                    {
                        $filetype = 0;
                        $config['allowed_types'] = 'gif|jpg|png|jpeg|pdf';
                        break;
                    }
                }
                $config['overwrite'] = false;
                $config['remove_spaces'] = true;
                if (!file_exists('./uploads/' . $folder)) {
                    if (!mkdir('./uploads/' . $folder . '/', 0755, true)) {

                    }
                }
                $microtime = microtime(true) * 10000;
                $this->load->library('upload');
                $this->upload->initialize($config);
                if ($this->upload->do_upload('file', $microtime)) {
                    echo json_encode(array(
                        'type' => $filetype,
                        'path' => 'uploads/' . $folder . '/' . $this->upload->file_name
                    ));
                }
            }
        }
        exit;
    }

    public function delete_files($table_of_image = 'upload_files')
    {
        $path = $this->input->post('path');
        echo unlink('./' . $path);
        $this->common_model->deleteWhere(array('image' => $path), $table_of_image);
        //echo unlink('./' . $path);
    }
    public function edit_job_order_deatails($value='')
             {
                 $j_id = $this->input->get_post('id');
                 $emp_id = $this->input->post('emp_id');
                 $notes = $this->input->post('notes');
                 $status = $this->input->post('status');

                 $emp_email = $this->common_model->getWhere(array('id'=>$j_id),'job_order');
                 $receive_email = $this->common_model->getWhere(array('id'=>$emp_email[0]->emp_id),'user');
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
                if($status==2)
                {
                $this->email->subject('Job Order Pending '.date('Y-m-d'));
                $this->email->message("Dear ".$receive_email[0]->name.", <br> Job Order is Still Pending, Please Follow Below Notes. <br>".$notes);
                }
                elseif ($status==5) {
                   $this->email->subject('Job Order Modification is required'.date('Y-m-d'));
                $this->email->message("Dear ".$receive_email[0]->name.", <br> Job Order needs Modification, Please Follow Below Notes. <br>".$notes);
                }
                else
                {
                    $this->email->subject('Job Order Closed Successfully on '.date('Y-m-d'));
                    $jo_close = $this->common_model->jo_closed($j_id);
                   $txt = '';
                    $txt.= "<style>
table {
  border-collapse: collapse;
}

table, td, th {
  border: 1px solid black;
}
</style><table><tr><th>Title</th><th>EMployee Name</th><th>Client Name</th><th>Job Type</th><th>Date Added</th><th>Completed Date</th>";
                    $txt .= "<tr><td>".$jo_close[0]->title."</td><td>".$jo_close[0]->emp_name."</td><td>".$jo_close[0]->client_name."</td><td>".$jo_close[0]->jo_type."</td><td>".$jo_close[0]->date_added."</td><td>".$jo_close[0]->last_updated."</td></tr></table>";
                $this->email->message("Dear ".$receive_email[0]->name.", <br> Job Order Successfully closed! <br>".$txt);
                }
                if($this->email->send())
                {

                }
                else
                {
                    echo $this->email->print_debugger();
                    die;
                }
                 $where = array("id"=>$j_id);
                 $data = array("client_id"=>$emp_id,"notes"=>$notes,"status"=>$status,"is_new"=>0);
                 $this->common_model->updateWhere($where,$data,'job_order');
                 $data1 = array("j_id"=>$j_id,"emp_id"=>$emp_id,"notes"=>$notes,"status"=>$status,"date_added"=>date("Y-m-d H:m:i"));
                 $this->common_model->insertRow($data1,'extra_job_order');
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
