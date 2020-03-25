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
}