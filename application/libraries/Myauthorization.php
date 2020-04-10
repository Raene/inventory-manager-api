<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    use \Firebase\JWT\JWT;

    class Myauthorization
    {
        protected $CI;

        public function __construct()
        {
                // Assign the CodeIgniter super-object
                $this->CI =& get_instance();
        }

        public function isLoggedIn($authHeader, $key){
                if(!$authHeader)
                {
                    throw new Exception("Access Denied", 500);
                }
                $tokenArr = explode(" ", $authHeader);
                $jwt = $tokenArr[1];
                $decoded = JWT::decode($jwt, $key, array('HS256'));
            
                return (array) $decoded;
        }

        public function isAdmin($role){
            if($role != 'admin')
            {
                return false;
            }

            return true;
        }
    }