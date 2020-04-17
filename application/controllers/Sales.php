<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sales extends CI_Controller 
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

    public function index(){
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
    
    public function get_sales_today(){
        try 
		{
            $this->creds = $this->myauthorization->isLoggedIn($this->authHeader, $this->key);

            $resp["payload"] = $this->sales->get_sales_by_day($this->creds['admin_id']);
            $resp["status"]  = 200;

			return response($resp["status"], $resp["payload"]);
		}
        catch (Exception $e) 
		{ 
			return response($e->getCode(),$e->getMessage());
		}
    }

    public function get_sales_week(){
        try 
		{
            $this->creds = $this->myauthorization->isLoggedIn($this->authHeader, $this->key);

            $resp["payload"] = $this->sales->get_sales_by_week($this->creds['admin_id']);
            $resp["status"]  = 200;

			return response($resp["status"], $resp["payload"]);
		}
        catch (Exception $e) 
		{ 
			return response($e->getCode(),$e->getMessage());
		}
    }

    public function get_sales_month(){
        try 
		{
            $this->creds = $this->myauthorization->isLoggedIn($this->authHeader, $this->key);

            $resp["payload"] = $this->sales->get_sales_by_month($this->creds['admin_id']);
            $resp["status"]  = 200;
			return response($resp["status"], $resp["payload"]);
		}
        catch (Exception $e) 
		{ 
			return response($e->getCode(),$e->getMessage());
		}
    }

    public function get_sum(){
        try 
		{
            $this->creds = $this->myauthorization->isLoggedIn($this->authHeader, $this->key);

            $monthly_sum = $this->sales->monthly_sum($this->creds['admin_id'])["SUM(sales_price)"];

            $daily_sum   = $this->sales->daily_sum($this->creds['admin_id'])["SUM(sales_price)"];
            
            $weekly_sum  = $this->sales->weekly_sum($this->creds['admin_id'])["SUM(sales_price)"];

            $resp["payload"] = ["monthly sum"=>$monthly_sum, "daily_sum"=> $daily_sum, "weekly_sum"=>$weekly_sum];

            $resp["status"]  = 200;
			return response($resp["status"], $resp["payload"]);
		}
        catch (Exception $e) 
		{ 
			return response($e->getCode(),$e->getMessage());
		}
    }
}