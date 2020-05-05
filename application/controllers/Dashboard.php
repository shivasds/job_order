<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Dashboard extends CI_Controller {

	function __construct(){
        /* Session Checking Start*/
        parent::__construct();  
        $this->load->model('Login_model'); 
        $this->load->model('common_model'); 
        
     }
  function logout() {
        $this->session->sess_destroy();
        $this->session->unset_userdata('is_loggedin');
            redirect(base_url());       
    }
    
 
 
  }
