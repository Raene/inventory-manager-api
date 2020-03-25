<?php
class Sales_model extends CI_model
{
    private $prod_id;
    private $quantity;
    private $user_id;
    private $prod_name;
    private $sales_price;

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

    public function get_sales_by_month()
    {
        $sql   = "SELECT * FROM `sales` WHERE MONTH(created_at) = Month(NOW())";
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

    public function monthly_sum()
    {
        $sql = "SELECT SUM(sales_price) FROM sales WHERE MONTH(created_at) = MONTH(NOW())";
        $query = $this->db->query($sql);

            if(!$query)
            {
                $error = $this->db->error();
                $errorMessage = $error['message'];
                $errorStatus = 500;
                throw new Exception($errorMessage, $errorStatus);
            }

        return $query->row_array();
    }

    public function daily_sum()
    {
        $sql = "SELECT SUM(sales_price) FROM sales WHERE DAY(created_at) = DAY(NOW())";
        $query = $this->db->query($sql);

            if(!$query)
            {
                $error = $this->db->error();
                $errorMessage = $error['message'];
                $errorStatus = 500;
                throw new Exception($errorMessage, $errorStatus);
            }

        return $query->row_array();
    }

    public function weekly_sum()
    {
        $sql = "SELECT SUM(sales_price) FROM sales WHERE WEEK(created_at) = WEEK(NOW())";
        $query = $this->db->query($sql);

            if(!$query)
            {
                $error = $this->db->error();
                $errorMessage = $error['message'];
                $errorStatus = 500;
                throw new Exception($errorMessage, $errorStatus);
            }

        return $query->row_array();
    }
}