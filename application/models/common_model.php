<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Common_model extends MY_Model {

    public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
    }
public function duplicate_check($table,$name){
        $this->db->select();
        $this->db->from($table);
        if($table == "user")
            $this->db->where('username',$name);
        else
            $this->db->where('name',$name);
        $query=$this->db->get();
        $rowcount=$query->num_rows();
        return $rowcount;
    }
    public function duplicate_check_email($table,$name){
        $this->db->select();
        $this->db->from($table);
        if($table == "email")
            $this->db->where('email',$name);
        else
            $this->db->where('email',$name);
        $query=$this->db->get();
        $rowcount=$query->num_rows();
        return $rowcount;
    }
    public function toggle_status($table,$id){
        $this->db->select('active');
        $this->db->from($table);
        $this->db->where('id',$id);
        $result=$this->db->get()->result();
        if(count($result) > 0){
            $active = $result[0]->active;
            $newStatus = $active?0:1;
            $query=$this->db->update(
                $table,
                array(
                    'active'=>$newStatus
                ),
                array(
                    'id'=>$id
                )
            );
            return $newStatus;
        }
        return false;
    }
    public function reset_password($id){
        $this->db->select('username');
        $this->db->from('user');
        $this->db->where('id',$id);
        $query=$this->db->get();
        $user = $query->row();
        $this->db->update(
            'user',
            array(
                'password'=>md5($user->username)
            ),
            array(
                'id'=>$id
            )
        );
    }
    public function getfilenames($id='')
    {
        $query = $this->db->select("file_name")
        ->where("j_id",$id)
        ->from("upload_files");
        return $query->get()->result();

    }
    function get_JO_data($id){
        $this->db->select('jo.*,u.name as user_name,s.name as status');
        $this->db->from('extra_job_order as jo');
        $this->db->where('jo.j_id',$id); 
        $this->db->join('user as u','u.id=jo.emp_id', 'left');
        $this->db->join('status as s','s.id=jo.status', 'left');
        $this->db->order_by('jo.date_added','desc');
        $query=$this->db->get();
        
        return $query?$query->result():false;
    }
    public function jo_closed($id='')
    {
        $this->db->select('jo.*,u.name as emp_name,ua.name as client_name,s.name as status, ot.order_type as jo_type');
        $this->db->from('job_order as jo');
        $this->db->where('jo.id',$id); 
        $this->db->join('user as u','u.id=jo.emp_id', 'left');
        $this->db->join('user as ua','ua.id=jo.client_id', 'left');
        $this->db->join('order_types as ot','ot.id=jo.job_type', 'left');
        $this->db->join('status as s','s.id=jo.status', 'left');
        $this->db->order_by('jo.date_added','desc');
        $query=$this->db->get();
        return $query?$query->result():false;
       // echo $this->db->last_query();
    }
    
}

?>