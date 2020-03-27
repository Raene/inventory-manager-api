<?php
    class Auth_model extends CI_Model{
        private $name;
        private $email;
        private $password;

        public function __construct(){
            $this->load->database();
        }

        public function create($tablename,$data)
        {
            $query = $this->db->insert($tablename, $data);

            if(!$query){
                $error = $this->db->error();
                $errorMessage = $error['message'];
                $errorStatus = 400;
                throw new Exception($errorMessage, $errorStatus);
            }
            return "User Created";
        }

        public function login($tablename,$password,$email)
        {
            $result = fetch_by_email($tablename,$email);
            if($result == FALSE){
                $errorMessage = 'User Not Found';
                $errorStatus  = 400;
                throw new Exception($errorMessage, $errorStatus);
            }

             if(!password_verify($password, $result["password"]))
             {
                 $errorMessage = 'Invalid Password';
                 $errorStatus = 400;
                 throw new Exception($errorMessage, $errorStatus);
             }

             return array('id'=>$result["id"], 'name'=>$result['name'], 'email'=>$result['email']);
        }
    }
