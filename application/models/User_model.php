<?php
   class User_model extends CI_model
   {
       private $name;
       private $email;

       public function __construct()
       {
            $this->load->database();
       }

       public function get_all()
       {
           $query = $this->db->get('user');
   
               if(!$query){
                   $error = $this->db->error();
                   $errorMessage = $error['message'];
                   $errorStatus = 500;
                   throw new Exception($errorMessage, $errorStatus);
               }
   
           return $query->result_array();
       }

       public function get_by_id($id)
       {
           $query = $this->db->get_where('user', array('id' => $id));
   
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

       public function delete($id)
       {
        $query = $this->db->where('id', $id);
        $query = $this->db->delete('product');
        return array("status"=> 201, "message"=> "User account deleted");
      }
   }