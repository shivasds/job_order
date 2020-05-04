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
             if(!empty($_FILES['images']['name'])){
                
            // Set preference
            $config['upload_path'] = 'uploads/';    
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['max_size']    = '1024'; // max_size in kb
            $config['file_name'] = $_FILES['images']['name'];
                    
            //Load upload library
            $this->load->library('upload',$config);         
                
            // File upload
            if($this->upload->do_upload('file')){
                // Get data about the file
                $uploadData = $this->upload->data();
            }
            else
            {
                echo "empty";
            }
            if($this->input->post())
            {
                echo $this->input->post('order_type');
                $gallery = $this->input->post('images');
                print_r($gallery);
                if ($gallery) {
                    foreach ($gallery as $image) {
                        $exploded = explode('/', $image);
                        // $this->properties_model->insertRow(array(
                        //     'property_id' => $property_id,
                        //     'image' => 'uploads/' . $slug . '/' . end($exploded)
                        // ), 'property_images');
                        rename($image, 'uploads/' . $slug . '/' . end($exploded));
                        print_r($exploded);
                    }
                }
                die;
             
            }
           
        }

            $this->load->view("client/new_job_orders",$data);
         }
         public function pending_Job_orders($value='')
         {
            $data['title'] = "Client Pending Job Orders ";
             $this->load->view("client/pending_Job_orders",$data);
         }
         public function finished_job_orders($value='')
         {
            $data['title'] = "Client Finished Job Orders";
             $this->load->view("client/finished_job_orders",$data);
         }
 
  }
