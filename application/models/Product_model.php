<?php
class Product_model extends CI_model{
    private $name;
    private $price;
    private $quantity;
    private $user_id;

    public function __construct(){
        $this->load->database();
    }

    public function get_all()
    {
        $query = $this->db->get('product');

            if(!$query){
                $error = $this->db->error();
                $errorMessage = $error['message'];
                $errorStatus = 500;
                throw new Exception($errorMessage, $errorStatus);
            }

        return $query->result_array();
    }

    public function get_by_id($id)
    {
        $query = $this->db->get_where('product', array('id' => $id));

            if(!$query){
                $error = $this->db->error();
                $errorMessage = $error['message'];
                $errorStatus = 500;
                throw new Exception($errorMessage, $errorStatus);
            }
            
        return $query->row_array();
    }

    public function create($data)
    {   
        $query = $this->db->insert('product', $data);

        if(!$query){
            $error = $this->db->error();
            $errorMessage = $error['message'];
            $errorStatus = 400;
            throw new Exception($errorMessage, $errorStatus);
        }
        
        return "Product added to Inventory";
    }

    public function delete($id){
        $query = $this->db->where('id', $id);
        $query = $this->db->delete('product');
        return array("status"=> 201, "message"=> "Product Deleted from Inventory");
    }

    public function update($data){
        $query = $this->db->where('id', $data["id"]);
        $query = $this->db->update('product', $data);

        if(!$query){
            $error = $this->db->error();
            $errorMessage = $error['message'];
            $errorStatus = 400;
            throw new Exception($errorMessage, $errorStatus);
        }
        return "Product updated Successfully";
    }

    public function product_exists($name){
        $query = $this->db->get_where('product', array('name' => $name));
        if (empty($query->row_array())) {
            return true;
        } else {
            return false;
        }
        
    }
}