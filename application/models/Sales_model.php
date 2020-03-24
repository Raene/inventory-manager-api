<?php
class Sales_model extends CI_model
{
    private $prod_id;
    private $quantity;
    private $user_id;
    private $prod_name;
    private $prod_price;

    public function __construct()
    {
        $this->load->database();
    }

    public function get_all()
    {
        $query = $this->db->get('sales');

            if(!$query)
            {
                $error = $this->db->error();
                $errorMessage = $error['message'];
                $errorStatus = 500;
                throw new Exception($errorMessage, $errorStatus);
            }

        return $query->result_array();
    }

    public function get_sales_by_day()
    {
        $sql   = "SELECT * FROM `sales` WHERE DAY(created_at) = DAY(NOW())";
        $query = $this->db->query($sql);

            if(!$query)
            {
                $error = $this->db->error();
                $errorMessage = $error['message'];
                $errorStatus = 500;
                throw new Exception($errorMessage, $errorStatus);
            }

        return $query->result_array();
    }

    public function get_sales_by_week()
    {
        $sql   = "SELECT * FROM `sales` WHERE WEEK(created_at) = WEEK(NOW())";
        $query = $this->db->query($sql);

            if(!$query)
            {
                $error = $this->db->error();
                $errorMessage = $error['message'];
                $errorStatus = 500;
                throw new Exception($errorMessage, $errorStatus);
            }

        return $query->result_array();
    }
}