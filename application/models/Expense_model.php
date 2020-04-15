<?php
class Expense_model extends CI_model{
    private $name;
    private $price;
    private $quantity;
    private $user_id;

    public function __construct(){
        $this->load->database();
    }

    public function get_all($adminId)
    {
        $query = $this->db->get_where('expenses', array('admin_id' => $adminId));

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
        
        if(!$query){
            $error = $this->db->error();
            $errorMessage = $error['message'];
            $errorStatus = 400;
            throw new Exception($errorMessage, $errorStatus);
        }
        
        return "Expense added";
    }

    public function get_expenses_by_day($adminId)
    {
        $sql   = "SELECT * FROM `expenses` WHERE DAY(created_at) = DAY(NOW()) AND admin_id = {$adminId}";
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

    public function get_expenses_by_week($adminId)
    {
        $sql   = "SELECT * FROM `expenses` WHERE WEEK(created_at) = WEEK(NOW()) AND admin_id = {$adminId}";
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

    public function get_expenses_by_month($adminId) 
    {
        $sql   = "SELECT * FROM `expenses` WHERE MONTH(created_at) = Month(NOW()) AND admin_id = {$adminId}";
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
        $this->db->where('id', $id);
        $query = $this->db->delete('expenses');
            
            if(!$query)
            {
                $error = $this->db->error();
                $errorMessage = $error['message'];
                $errorStatus = 500;
                throw new Exception($errorMessage, $errorStatus);
            }

        return array("status"=> 201, "message"=> "Expense Deleted from Inventory");
    }
}