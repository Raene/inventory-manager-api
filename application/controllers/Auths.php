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

                $enc_password     = password_hash($data['password'], PASSWORD_BCRYPT);
                $data["password"] = $enc_password;
            
                $resp["payload"] = $this->auth->create('admins',$data);
                $resp["status"]  = 201;
    
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
                $data = $this->input->raw_input_stream;
			    $data = utf8_encode($data);
                $data = json_decode($data, true);
                
                $this->form_validation->set_data($data);
                $this->form_validation->set_rules('email', 'Email', 'required');
                $this->form_validation->set_rules('password', 'Password', 'required');
                
                if ($this->form_validation->run() == FALSE)
                {
                    $errorMessage = $this->form_validation->error_string();
                    $errorStatus = 400;
                    throw new Exception($errorMessage, $errorStatus);
                }

                $token = $this->auth->login('admins',$data["password"],$data["email"]);
                
                $token["role"] = 'admin';
                $key   =  $this->config->item('jwt-key');;
                
                $jwt = JWT::encode($token, $key);

                $resp["payload"] = $jwt;
                $resp["status"]  = 200;

                return response($resp["status"], $resp["payload"]);    


            } catch (Exception $e) {
                return response($e->getCode(),$e->getMessage());
            }
        }

        public function user_register()
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

                $enc_password     = password_hash($data['password'], PASSWORD_BCRYPT);
                $data["password"] = $enc_password;
            
                $resp["payload"] = $this->auth->create('user',$data);
                $resp["status"]  = 201;
    
                return response($resp["status"], $resp["payload"]);    
            }   
            catch (Exception $e) 
            {
                return response($e->getCode(),$e->getMessage());
            }
        }

        public function user_login()
        {
            try {
                $data = $this->input->raw_input_stream;
			    $data = utf8_encode($data);
                $data = json_decode($data, true);
                
                $this->form_validation->set_data($data);
                $this->form_validation->set_rules('email', 'Email', 'required');
                $this->form_validation->set_rules('password', 'Password', 'required');
                
                if ($this->form_validation->run() == FALSE)
                {
                    $errorMessage = $this->form_validation->error_string();
                    $errorStatus = 400;
                    throw new Exception($errorMessage, $errorStatus);
                }

                $token = $this->auth->login('user',$data["password"],$data["email"]);
                
                $token["role"] = 'user';
                $key   =  $this->config->item('jwt-key');;
                
                $jwt = JWT::encode($token, $key);

                $resp["payload"] = $jwt;
                $resp["status"]  = 200;

                return response($resp["status"], $resp["payload"]);    


            } catch (Exception $e) {
                return response($e->getCode(),$e->getMessage());
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