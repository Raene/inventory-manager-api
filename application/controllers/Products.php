<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends CI_Controller {

	private $key;
	public $creds;
	public $authHeader;

	public function __construct()
	{
    		// header('Access-Control-Allow-Origin: *');
			// header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
			parent::__construct();
			headersUp();
			$this->load->library('myauthorization');
			$this->authHeader = $_SERVER['HTTP_AUTHORIZATION'];
			$this->key   =  $this->config->item('jwt-key');   
    		
	}
	
	//returns a payload containing all products belonging to an admin
	public function index()
	{
		try 
		{
			
			$this->creds = $this->myauthorization->isLoggedIn($this->authHeader, $this->key);
				
            $resp["payload"] = $this->sales->get_all($this->creds['admin_id']);
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

			$resp["payload"] = $this->product->get_by_id($id);
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

	public function create()
	{
		try 
		{
			$this->creds = $this->myauthorization->isLoggedIn($this->authHeader, $this->key);

			$data = $this->input->raw_input_stream;
			$data = utf8_encode($data);
			$data = json_decode($data, true);

			$this->form_validation->set_data($data);

			$this->form_validation->set_rules('name', 'Product Name', 'required|callback_productName_check');
			$this->form_validation->set_rules('price', 'Product Price', 'required');
			$this->form_validation->set_rules('quantity', 'Quantity', 'required|callback_quantity_isNot_zero');

			if ($this->form_validation->run() == FALSE)
			{
						$errorMessage = $this->form_validation->error_string();
						$errorStatus = 400;
						throw new Exception($errorMessage, $errorStatus);
			}

			$data['user_id'] = $this->creds['id'];
			$data['admin_id'] = $this->creds['admin_id'];
			$resp["payload"] = $this->product->create($data);
			$resp["status"]  = 200;
	
			return response($resp["status"], $resp["payload"]);
		} 
        catch (Exception $e) 
		{ 
			return response($e->getCode(),$e->getMessage());
		}
	}

	public function update()
	{
		try 
		{
			$this->creds = $this->myauthorization->isLoggedIn($this->authHeader, $this->key);

			$data = $this->input->raw_input_stream;
			$data = utf8_encode($data);
			$data = json_decode($data, true);

			$this->form_validation->set_data($data);

			$this->form_validation->set_rules('id', 'Product ID', 'required');

			if ($this->form_validation->run() == FALSE)
			{
					$errorMessage = $this->form_validation->error_string();
					$errorStatus = 400;
					throw new Exception($errorMessage, $errorStatus);
			}

			$resp["payload"] = $this->product->update($data);
			$resp["status"]  = 200;
			return response($resp["status"], $resp["payload"]);

		} 
        catch (Exception $e) 
		{ 
			return response($e->getCode(),$e->getMessage());
		}
	}

	public function delete($id){
		$resp = $this->product->delete($id);
		return response($resp["status"], $resp["message"]); 
	}

	public function productName_check($name)
	{
			$this->form_validation->set_message('productName_check', 'That Product Name is taken. Choose another');
		
			if($this->product->product_exists($name))
			{
				return true;
			} 
			else
			{
				return false;
			}
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
}
