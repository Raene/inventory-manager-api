<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends CI_Controller {

	public function __construct()
	{
    		// header('Access-Control-Allow-Origin: *');
			// header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
			if(isset($_SERVER['HTTP_ORIGIN'])) {
				header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
				header("Access-Control-Allow-Credentials: true");
				header("Access-Control-Max-Age: 86400");
			}

			if($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
				if(isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'])) {
					header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
				}
				if(isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'])) {
					header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
				}
					exit(0);
			}
    		parent::__construct();
	}
	
	public function index()
	{
		try 
		{
			$resp = $this->product->get_all();

			return response(200, $resp);
		}
		catch (EXCEPTION $e)
		{
			return response(500,$e->getMessage());
		}
	}

	public function get($id)
	{
		try 
		{
			$resp = $this->product->get_by_id($id);

				if($resp === null){
					$resp = "No record exists matching specified parameters";
			   		return response(500, $resp);
				}

			return response(200, $resp);
		} 
		catch (EXCEPTION $e)
		{
			return response(500,$e->getMessage());
		}
	}

	public function create()
	{
		try 
		{
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

			
			$resp = $this->product->create($data);
	
			return response($resp["status"], $resp["message"]);
		} 
		catch (\Throwable $th) 
		{
			return response($th->getCode(),$th->getMessage());
		}
	}

	public function update()
	{
		try 
		{
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

			$resp = $this->product->update($data);
			return response($resp["status"], $resp["message"]);

		} 
		catch (\Throwable $th) 
		{
			return response($th->getCode(),$th->getMessage());
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

			if(!$this->product->quantity_isNot_zero($quantity))
			{
				return false;
			}else{

				return true;
			}

	}
}
