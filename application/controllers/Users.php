<?php 
    
class Users extends CI_Controller
{

	private $key;
	public $creds;
	public $authHeader;

    public function __construct()
	{
		parent::__construct();
		headersUp();
		$this->load->library('myauthorization');
		$this->authHeader = $_SERVER['HTTP_AUTHORIZATION'];
		$this->key   =  $this->config->item('jwt-key');    		
	}
	
	//fetches all users belonging to an admin
	public function index()
	{
		try 
		{
			$this->creds = $this->myauthorization->isLoggedIn($this->authHeader, $this->key);

			if (!$this->myauthorization->isAdmin($this->creds['role'])) 
			{
				return response(401, "Only admins may fetch users");
			}

            $resp["payload"] = $this->user->get_all($this->creds['admin_id']);
            $resp["status"]  = 200;

			return response($resp["status"], $resp["payload"]);
		}
        catch (Exception $e) 
		{ 
			return response($e->getCode(),$e->getMessage());
		}
	}

	public function get($id)
	{
		try 
		{
			$this->creds = $this->myauthorization->isLoggedIn($this->authHeader, $this->key);
				
			if (!$this->myauthorization->isAdmin($this->creds['role'])) 
			{
				return response(401, "Only admins may create users");
			}

			$resp["payload"] = $this->user->get_by_id($id,$this->creds['admin_id']);
			$resp["status"]  = 200;

				if($resp["payload"] === null){
					$resp["payload"] = "No record exists matching specified parameters";
					$resp["status"]  = 200;
			   		return response($resp["status"], $resp["payload"]);
				}

			return response($resp["status"], $resp["payload"]);
		} 
		catch (EXCEPTION $e)
		{
			return response($e->getCode(),$e->getMessage());
		}
	}

		//fetches all users belonging to an admin
		public function create()
		{
			try 
			{
				$this->creds = $this->myauthorization->isLoggedIn($this->authHeader, $this->key);
				
					if (!$this->myauthorization->isAdmin($this->creds['role'])) 
					{
						return response(401, "Only admins may create users");
					}

				$data = $this->input->raw_input_stream;
			    $data = utf8_encode($data);
                $data = json_decode($data, true);
            
                $this->form_validation->set_data($data);
				$this->form_validation->set_rules('name', 'Name', 'required');
				$this->form_validation->set_rules('admin_id', 'Admin_Id', 'required');
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
				$resp["payload"] = $this->user->create($data);
				$resp["status"]  = 200;
	
				return response($resp["status"], "User Created");
			}
			catch (Exception $e) 
			{ 
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