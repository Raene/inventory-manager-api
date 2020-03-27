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
            return "Admin Created";
        }

        public function login($password,$email)
        {
            $admin = fetch_by_email('admins',$email);
            if($admin == FALSE){
                $errorMessage = 'User Not Found';
                $errorStatus  = 400;
                throw new Exception($errorMessage, $errorStatus);
            }

             if(!password_verify($password, $admin["password"]))
             {
                 $errorMessage = 'Invalid Password';
                 $errorStatus = 400;
                 throw new Exception($errorMessage, $errorStatus);
             }

             return array('id'=>$admin["id"], 'name'=>$admin['name'], 'email'=>$admin['email'], 'role'=>'admin');
        }
    }
