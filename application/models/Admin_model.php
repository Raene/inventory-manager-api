<?php
    class Admin_model extends CI_Model{
        private $name;
        private $email;
        private $password;

        public function __construct(){
            $this->load->database();
        }

        public function create($data,$enc_password)
        {
            $query = $this->db->insert('admins', $data);

            if(!$query){
                $error = $this->db->error();
                $errorMessage = $error['message'];
                $errorStatus = 400;
                throw new Exception($errorMessage, $errorStatus);
            }
            $id = $this->db->insert_id();
            return array('id'=>$id, 'name'=>$data['name'], 'role'=>'admin');
        }
    }