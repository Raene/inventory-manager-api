<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sales extends CI_Controller 
{
    public function __construct()
    {
        parent::__construct();
        headersUp();
    }

    public function index(){
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
    
    public function get_sales_today(){
        try 
		{
            $resp["payload"] = $this->sales->get_sales_by_day();
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
            $resp["payload"] = $this->sales->get_sales_by_week();
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
            $resp["payload"] = $this->sales->get_sales_by_month();
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
            $monthly_sum = $this->sales->monthly_sum()["SUM(sales_price)"];
            $daily_sum   = $this->sales->daily_sum()["SUM(sales_price)"];
            $weekly_sum  = $this->sales->weekly_sum()["SUM(sales_price)"];

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