<?php
    class Auth_model extends CI_Model{
        private $name;
        private $email;
        private $password;

        public function __construct(){
            $this->load->database();
        }

        public function create($data)
        {
                $sql = "INSERT INTO `admins`() VALUES ()";
                $query = $this->db->query($sql);
                $data['admin_id'] = $this->db->insert_id();
                $query = $this->db->insert('user',$data);
                db_error_response($query);
                return "Admin User Created";
        }

        public function login($data)
        {
            $this->email    = $data['email'];
            $this->password = $data['password'];

            $result = fetch_by_email('user',$this->email);
            if($result == FALSE){
                $errorMessage = 'User Not Found';
                $errorStatus  = 400;
                throw new Exception($errorMessage, $errorStatus);
            }

             if(!password_verify($this->password, $result["password"]))
             {
                 $errorMessage = 'Invalid Password';
                 $errorStatus = 400;
                 throw new Exception($errorMessage, $errorStatus);
             }

             return array('id'=>$result["id"], 'name'=>$result['name'], 'email'=>$result['email'], 'role'=>$result['role']);
        }
    }
