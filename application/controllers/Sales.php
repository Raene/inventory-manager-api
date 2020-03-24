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
        catch (\Throwable $th) 
		{
			return response($th->getCode(),$th->getMessage());
		}
    }
    
    public function get_sales_today(){
        try 
		{
            $resp["payload"] = $this->sales->get_sales_by_day();
            $resp["status"]  = 200;

			return response($resp["status"], $resp["payload"]);
		}
		catch (\Throwable $th) 
		{
			return response($th->getCode(),$th->getMessage());
		}
    }

    public function get_sales_week(){
        try 
		{
            $resp["payload"] = $this->sales->get_sales_by_week();
            $resp["status"]  = 200;

			return response($resp["status"], $resp["payload"]);
		}
        catch (\Throwable $th) 
		{
			return response($th->getCode(),$th->getMessage());
		}
    }
}