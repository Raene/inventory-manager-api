<?php
use \Firebase\JWT\JWT;
    class Auths extends CI_Controller
    {
        public function __construct()
        {
            parent::__construct();
            headersUp();
            
        }
   
        public function admin_register()
        {
            try 
            {
                $data = $this->input->raw_input_stream;
			    $data = utf8_encode($data);
                $data = json_decode($data, true);
            
                $this->form_validation->set_data($data);
                $this->form_validation->set_rules('name', 'Name', 'required');
                $this->form_validation->set_rules('email', 'Email', 'required|callback_email_exists');
                $this->form_validation->set_rules('password', 'Password', 'required');

                if ($this->form_validation->run() == FALSE)
                {
                    $errorMessage = $this->form_validation->error_string();
                    $errorStatus = 400;
                    throw new Exception($errorMessage, $errorStatus);
                }

                $enc_password = password_hash($data['password'], PASSWORD_BCRYPT);
            
                $token = $this->admin->create($data,$enc_password);

                $key   =  $this->config->item('jwt-key');;
                
                $jwt = JWT::encode($token, $key);
                
                $resp["status"]  = 201;
                $resp["payload"] = $jwt;
    
                return response($resp["status"], $resp["payload"]);    
            }   
            catch (Exception $e) 
            {
                return response($e->getCode(),$e->getMessage());
            }
        }

        public function admin_login()
        {
            try {
                $this->form_validation->set_rules('email', 'Email', 'required|callback_email_exists');
                $this->form_validation->set_rules('password', 'Password', 'required');
                echo password_verify('boobs', $enc_password);
            } catch (Exception $e) {
                
            }
        }

        public function email_exists($email){
            $this->form_validation->set_message('email_exists', 'That email is taken. Choose another');

            if (email_exists('admins',$email)) {
                return true;
            } else {
                return false;
            }
            
        }
    }