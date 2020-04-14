<?php
use \Firebase\JWT\JWT;
    class Auths extends CI_Controller
    {

        private $key;

        public function __construct()
        {
            parent::__construct();
            headersUp();
            $this->key   =  $this->config->item('jwt-key');
            
        }
   
        public function register()
        {
            try 
            {
                $data = $this->input->raw_input_stream;
			    $data = utf8_encode($data);
                $data = json_decode($data, true);
            
                if($data === null)
                {
                    $errorStatus = 400;
                    throw new Exception('No data given', $errorStatus);
                }

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
            
                $resp["payload"] = $this->auth->create($data);
                $resp["status"]  = 201;
    
                return response($resp["status"], $resp["payload"]);    
            }   
            catch (Exception $e) 
            {
                return response($e->getCode(),$e->getMessage());
            }
        }

        public function login()
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

                $dBpayload = $this->auth->login($data);
                
                $token = JWT::encode($dBpayload, $this->key);

                $resp["payload"] = array('token'=> $token, "dBpayload"=>$dBpayload);
                $resp["status"]  = 200;

                return response($resp["status"], $resp["payload"]);    


            } catch (Exception $e) {
                return response($e->getCode(),$e->getMessage());
            }
        }

        public function email_exists($email){
            $this->form_validation->set_message('email_exists', 'That email is taken. Choose another');

            if (email_exists('user',$email)) {
                return true;
            } else {
                return false;
            }            
        }
    }