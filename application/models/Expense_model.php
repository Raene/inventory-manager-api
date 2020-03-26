<?php
class Expense_model extends CI_model{
    private $name;
    private $price;
    private $quantity;
    private $user_id;

    public function __construct(){
        $this->load->database();
    }

    public function get_all()
    {
        $query = $this->db->get('expenses');

            if(!$query){
                $error = $this->db->error();
                $errorMessage = $error['message'];
                $errorStatus = 500;
                throw new Exception($errorMessage, $errorStatus);
            }

        return $query->result_array();
    }

    public function create($data)
    {
        $query = $this->db->insert_batch('expenses', $data);
        //return $data;
        if(!$query){
            $error = $this->db->error();
            $errorMessage = $error['message'];
            $errorStatus = 400;
            throw new Exception($errorMessage, $errorStatus);
        }
        
        return "Expense added";
    }

    public function get_expenses_by_day()
    {
        $sql   = "SELECT * FROM `expenses` WHERE DAY(created_at) = DAY(NOW())";
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

    public function get_expenses_by_week()
    {
        $sql   = "SELECT * FROM `expenses` WHERE WEEK(created_at) = WEEK(NOW())";
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

    public function get_expenses_by_month() 
    {
        $sql   = "SELECT * FROM `expenses` WHERE MONTH(created_at) = Month(NOW())";
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

    public function delete($id)
    {
        $query = $this->db->where('id', $id);
        $query = $this->db->delete('expenses');
        return array("status"=> 201, "message"=> "Expense Deleted from Inventory");
    }
}