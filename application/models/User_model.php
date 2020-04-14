<?php
   class User_model extends CI_model
   {
       private $name;
       private $email;

       public function __construct()
       {
            $this->load->database();
       }

       public function get_all($adminId)
       {
           $query = $this->db->get_where('user', array('admin_id' => $adminId));
   
               if(!$query){
                   $error = $this->db->error();
                   $errorMessage = $error['message'];
                   $errorStatus = 500;
                   throw new Exception($errorMessage, $errorStatus);
               }
   
           return $query->result_array();
       }

       public function get_by_id($id,$adminId)
       {
           $query = $this->db->get_where('user', array('id' => $id, 'admin_id' => $adminId));
   
               if(!$query){
                   $error = $this->db->error();
                   $errorMessage = $error['message'];
                   $errorStatus = 500;
                   throw new Exception($errorMessage, $errorStatus);
               }
               
           return $query->row_array();
       }

       public function create($data)
       {
            $query = $this->db->insert("user",$data);
            db_error_response($query);
            return "User Created";
       }

       public function delete($id,$adminId)
       {
        $query = $this->db->where(array('id' => $id, 'admin_id' => $adminId));
        $query = $this->db->delete('product');
        return array("status"=> 201, "message"=> "User account deleted");
      }
   }