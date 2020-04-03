<?php  
defined('BASEPATH') OR exit('No direct script access allowed'); 
use \Firebase\JWT\JWT;

class Auth extends CI_Controller { 
    
    private $authHeader;
    private $authArr;

    public function __construct()
    {
            // Assign the CodeIgniter super-object
            $this->CI =& get_instance();
            $this->authHeader = $_SERVER['HTTP_AUTHORIZATION'];
            $this->authArr = explode(" ", $this->authHeader);
    }

    public function isloggedin(){  
        echo "gee";
        echo $this->authArr;
        
    }  

    // public function userIsOwner(){  
    //     if($this->CI->router->method != 'edit'){
    //         return;
    //     }

    //     //check if user is logged in first
    //     if($this->CI->session->userdata('user_id') != $this->CI->post->get_posts($id)['user_id']){
    //         redirect('posts');
    //     }
        
    // }  
}  
?>  