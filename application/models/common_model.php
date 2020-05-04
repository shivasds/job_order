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
    
}

?>