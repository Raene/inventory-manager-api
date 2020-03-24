<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
    		// header('Access-Control-Allow-Origin: *');
			// header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
			
			headersUp();
    		
	}
	
	public function index()
	{
		try 
		{
            $resp["payload"] = $this->sales->get_all();
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

			if(!$this->product->quantity_isNot_zero($quantity))
			{
				return false;
			}else{

				return true;
			}

	}
}
