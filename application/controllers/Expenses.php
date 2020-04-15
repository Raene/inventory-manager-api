<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Expenses extends CI_Controller
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

    public function index()
    {
        try 
		{
			$this->creds = $this->myauthorization->isLoggedIn($this->authHeader, $this->key);
			if (!$this->myauthorization->isAdmin($this->creds['role'])) 
			{
				return response(401, "Only admins may see all expenses");
			}

            $resp["payload"] = $this->expense->get_all($this->creds['admin_id']);
            $resp["status"]  = 200;

			return response($resp["status"], $resp["payload"]);
		}
        catch (Exception $e) 
		{ 
			return response($e->getCode(),$e->getMessage());
		}
    }

    public function create()
	{
		try 
		{
			$this->creds = $this->myauthorization->isLoggedIn($this->authHeader, $this->key);
			$data = $this->input->raw_input_stream;
			$data = utf8_encode($data);
            $data = json_decode($data, true);
            
			//flatten the array, because CI form validation library has issues reading multidimensional array
			//with array flattened we can apply form_validation to all properties
            $out   = [];
            $iterator = new RecursiveIteratorIterator(new RecursiveArrayIterator($data));
            foreach($iterator as $key => $val)
            {
                $out[$key] = $val;
            }
            $this->form_validation->set_data($out);
			$this->form_validation->set_rules('product_name', 'Product Name', 'required');
			$this->form_validation->set_rules('user_id', 'User id', 'required');
			$this->form_validation->set_rules('admin_id', 'Admin id', 'required');
            $this->form_validation->set_rules('quantity', 'Quantity', 'required|callback_quantity_isNot_zero');
            $this->form_validation->set_rules('product_price', 'Product Price', 'required|callback_price_isNot_zero');

			if ($this->form_validation->run() == FALSE)
			{
						$errorMessage = $this->form_validation->error_string();
						$errorStatus = 400;
						throw new Exception($errorMessage, $errorStatus);
			}

			
			$resp["payload"] = $this->expense->create($data);
			$resp["status"]  = 201;
	
			return response($resp["status"], $resp["payload"]);
		} 
        catch (Exception $e) 
		{ 
			return response($e->getCode(),$e->getMessage());
		}
    }

    public function get_expenses_today(){
        try 
		{
			$this->creds = $this->myauthorization->isLoggedIn($this->authHeader, $this->key);
            $resp["payload"] = $this->expense->get_expenses_by_day($this->creds['admin_id']);
            $resp["status"]  = 200;

			return response($resp["status"], $resp["payload"]);
		}
        catch (Exception $e) 
		{ 
			return response($e->getCode(),$e->getMessage());
		}
    }

    public function get_expenses_week(){
        try 
		{
			$this->creds = $this->myauthorization->isLoggedIn($this->authHeader, $this->key);
            $resp["payload"] = $this->expense->get_expenses_by_week($this->creds['admin_id']);
            $resp["status"]  = 200;

			return response($resp["status"], $resp["payload"]);
		}
        catch (Exception $e) 
		{ 
			return response($e->getCode(),$e->getMessage());
		}
    }

    public function get_expenses_month(){
        try 
		{
			$this->creds = $this->myauthorization->isLoggedIn($this->authHeader, $this->key);
            $resp["payload"] = $this->expense->get_expenses_by_month($this->creds['admin_id']);
            $resp["status"]  = 200;
			return response($resp["status"], $resp["payload"]);
		}
        catch (Exception $e) 
		{ 
			return response($e->getCode(),$e->getMessage());
		}
    }

    public function delete($id){
		$this->creds = $this->myauthorization->isLoggedIn($this->authHeader, $this->key);
		$resp = $this->expense->delete($id);
		return response($resp["status"], $resp["message"]); 
	}
    
	public function quantity_isNot_zero($quantity)
	{
			$this->form_validation->set_message('quantity_isNot_zero', 'Product quantity can\'t be zero ');

			if(!isNot_zero($quantity))
			{
				return false;
			}else{

				return true;
			}

	}

	public function price_isNot_zero($price)
	{
			$this->form_validation->set_message('price_isNot_zero', 'Product must have a set price');

			if(!isNot_zero($price))
			{
				return false;
			}else{

				return true;
			}

	}
}
